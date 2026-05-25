<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlatformPhaseThreeTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup local storage fake for tests
        Storage::fake('public');

        // Clear persistent MongoDB collections to prevent E11000 duplicate key errors
        User::query()->delete();
        Evaluation::query()->delete();
    }

    /**
     * Test guest routing to landing and login pages.
     */
    public function test_guest_routing_is_successful(): void
    {
        $response = $this->get(route('landing'));
        $response->assertStatus(200);

        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /**
     * Test authentication and registration process.
     */
    public function test_user_can_register_and_authenticate(): void
    {
        $email = $this->faker->unique()->safeEmail();
        
        $response = $this->post(route('register.post'), [
            'name' => 'John Doe',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals('John Doe', $user->name);
    }

    /**
     * Test settings update with file uploads and custom user profiles.
     */
    public function test_authenticated_user_can_update_profile_and_files(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $avatar = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');
        $resume = UploadedFile::fake()->create('resume.pdf', 500, 'application/pdf');

        $response = $this->post(route('settings.save'), [
            'name' => 'Jane Smith',
            'email' => $user->email,
            'avatar' => $avatar,
            'resume' => $resume,
            'institution' => 'Stanford University',
            'department' => 'Computer Science',
            'github' => 'https://github.com/janesmith',
            'linkedin' => 'https://linkedin.com/in/janesmith',
            'skills' => 'Laravel, PHP, MongoDB, Python',
            'projects_done' => 5,
            'internships_count' => 2,
            'certifications_count' => 3,
            'leadership_role' => true,
        ]);

        $response->assertRedirect();
        
        // Refresh User model from MongoDB database connection
        $user = $user->fresh();

        $this->assertEquals('Jane Smith', $user->name);
        $this->assertEquals('Stanford University', $user->institution);
        $this->assertEquals('Computer Science', $user->department);
        $this->assertEquals('https://github.com/janesmith', $user->github);
        $this->assertEquals('https://linkedin.com/in/janesmith', $user->linkedin);
        
        // Assert skills parsed as array
        $this->assertIsArray($user->skills);
        $this->assertContains('Laravel', $user->skills);
        $this->assertContains('Python', $user->skills);

        // Assert portfolio stats
        $this->assertEquals(5, $user->projects_done);
        $this->assertEquals(2, $user->internships_count);
        $this->assertEquals(3, $user->certifications_count);
        $this->assertTrue($user->leadership_role);

        // Assert file storage paths are set
        $this->assertNotNull($user->avatar);
        $this->assertNotNull($user->resume);

        // Assert file existences in public storage fake
        Storage::disk('public')->assertExists($user->avatar);
        Storage::disk('public')->assertExists($user->resume);
    }

    /**
     * Test admin role access control policies.
     */
    public function test_admin_middleware_gates_unauthorized_users(): void
    {
        // 1. Unauthenticated guest is redirected to login
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));

        // 2. Authenticated non-admin gets a 403 Forbidden
        $user = User::factory()->create(['is_admin' => false]);
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertStatus(403);

        // 3. Authenticated admin gets 200 OK
        $admin = User::factory()->create(['is_admin' => true]);
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    /**
     * Test saving interactive coding test results.
     */
    public function test_user_can_complete_and_save_coding_test(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('tests.coding.save'), [
            'code1' => 'function isPalindrome(str) { return str.split("").reverse().join("") === str; }',
            'code2' => 'for (let i = 1; i <= 100; i++) { if (i % 3 === 0 && i % 5 === 0) console.log("FizzBuzz"); }',
            'code3' => 'let stack = []; stack.push("("); stack.pop();',
            'time_taken' => 120
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertNotNull($user->coding_test_score);
        $this->assertEquals(100, $user->coding_test_score['total']);
    }

    /**
     * Test claiming digital gold certificate for coding.
     */
    public function test_user_can_view_coding_certificate(): void
    {
        $user = User::factory()->create([
            'coding_test_score' => [
                'total' => 100,
                'completed_at' => now()->toIso8601String()
            ]
        ]);
        $this->actingAs($user);

        $response = $this->get(route('tests.certificate', 'coding'));
        $response->assertStatus(200);
        $response->assertViewHas('hash');
    }

    /**
     * Test secure routing to Test Center and individual assessment forms.
     */
    public function test_authenticated_user_can_access_test_center(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('tests.index'));
        $response->assertStatus(200);

        $response = $this->get(route('tests.aptitude'));
        $response->assertStatus(200);

        $response = $this->get(route('tests.reading'));
        $response->assertStatus(200);

        $response = $this->get(route('tests.psychometric'));
        $response->assertStatus(200);
    }

    /**
     * Test saving cognitive aptitude quiz results in user profiles.
     */
    public function test_user_can_complete_and_save_aptitude_test(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('tests.aptitude.save'), [
            'q1' => '450',
            'q2' => '15/56',
            'q3' => '42',
            'q4' => 'NRETTAP',
            'q5' => 'Wisdom',
            'q6' => 'A',
            'time_taken' => 90
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertNotNull($user->aptitude_test_score);
        $this->assertEquals(100, $user->aptitude_test_score['total']);
    }

    /**
     * Test saving academic history records.
     */
    public function test_user_can_save_academic_history(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('tests.history.save'), [
            'education_level' => 'school',
            'yr1_name' => '9th Class',
            'yr1_math' => 90,
            'yr1_sci' => 88,
            'yr1_hum' => 85,
            'yr2_name' => '10th Class',
            'yr2_math' => 92,
            'yr2_sci' => 90,
            'yr2_hum' => 88,
            'yr3_name' => '11th Class',
            'yr3_math' => 95,
            'yr3_sci' => 92,
            'yr3_hum' => 90,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertIsArray($user->academic_history);
        $this->assertCount(3, $user->academic_history);
        $this->assertEquals('school', $user->academic_history[0]['level']);
        $this->assertEquals(90, $user->academic_history[0]['subjects'][0]['marks']);
    }

    /**
     * Test saving English quiz results.
     */
    public function test_user_can_complete_and_save_english_test(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('tests.english.save'), [
            'q1' => 'A',
            'q2' => 'B',
            'q3' => 'A',
            'q4' => 'C',
            'time_taken' => 45
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertNotNull($user->english_test_score);
        $this->assertEquals(100, $user->english_test_score['total']);
    }

    /**
     * Test speaking voice introduction submission.
     */
    public function test_user_can_complete_speaking_audio_test(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $audio = UploadedFile::fake()->create('intro.wav', 200, 'audio/wav');

        $response = $this->postJson(route('tests.speaking.save'), [
            'audio' => $audio,
            'duration' => 15
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertNotNull($user->speaking_test_score);
        $this->assertNotNull($user->speaking_test_score['audio_path']);
        Storage::disk('public')->assertExists($user->speaking_test_score['audio_path']);
    }

    /**
     * Test written essay composition evaluation.
     */
    public function test_user_can_submit_written_essay(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('tests.written.save'), [
            'essay' => 'My core professional goals are highly ambitious. However, I need to focus on Laravel. Therefore, I will learn databases. Furthermore, MongoDB is perfect.'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertNotNull($user->written_test_score);
        $this->assertGreaterThan(50, $user->written_test_score['total']);
        $this->assertEquals(23, $user->written_test_score['word_count']);
    }

    /**
     * Test core subject quiz submission.
     */
    public function test_user_can_complete_core_subject_quiz(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('tests.core.save'), [
            'stream' => 'cs',
            'q1' => 'A',
            'q2' => 'B',
            'q3' => 'C'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertNotNull($user->core_subject_score);
        $this->assertEquals(100, $user->core_subject_score['total']);
    }

    /**
     * Test claim digital gold certificates.
     */
    public function test_user_can_view_certificate_when_completed(): void
    {
        $user = User::factory()->create([
            'aptitude_test_score' => [
                'total' => 90,
                'completed_at' => now()->toIso8601String()
            ]
        ]);
        $this->actingAs($user);

        $response = $this->get(route('tests.certificate', 'aptitude'));
        $response->assertStatus(200);
        $response->assertViewHas('hash');
    }

    /**
     * Test final prediction score aggregation pipeline.
     */
    public function test_user_can_submit_final_score_aggregation_prediction(): void
    {
        $user = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'student_' . uniqid() . '@test.com',
            'academic_history' => [
                [
                    'year' => '9th Class',
                    'level' => 'school',
                    'subjects' => [
                        ['subject' => 'Math', 'marks' => 90],
                        ['subject' => 'Science', 'marks' => 90],
                        ['subject' => 'Humanities', 'marks' => 90],
                    ]
                ],
                [
                    'year' => '10th Class',
                    'level' => 'school',
                    'subjects' => [
                        ['subject' => 'Math', 'marks' => 90],
                        ['subject' => 'Science', 'marks' => 90],
                        ['subject' => 'Humanities', 'marks' => 90],
                    ]
                ],
                [
                    'year' => '11th Class',
                    'level' => 'school',
                    'subjects' => [
                        ['subject' => 'Math', 'marks' => 90],
                        ['subject' => 'Science', 'marks' => 90],
                        ['subject' => 'Humanities', 'marks' => 90],
                    ]
                ]
            ],
            'aptitude_test_score' => ['total' => 95, 'completed_at' => now()->toIso8601String()],
            'english_test_score' => ['total' => 90, 'completed_at' => now()->toIso8601String()],
            'speaking_test_score' => ['total' => 90, 'completed_at' => now()->toIso8601String()],
            'reading_test_score' => ['wpm' => 250, 'total' => 100, 'completed_at' => now()->toIso8601String()],
            'written_test_score' => ['total' => 88, 'completed_at' => now()->toIso8601String()],
            'core_subject_score' => ['total' => 90, 'completed_at' => now()->toIso8601String()],
            'psychometric_test_score' => ['total' => 85, 'completed_at' => now()->toIso8601String()],
        ]);
        $this->actingAs($user);

        $response = $this->postJson(route('prediction.final.save'), [
            'projects_done' => 4,
            'internships_count' => 2,
            'skills_count' => 8,
            'certifications_count' => 3,
            'leadership_role' => true
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'redirect']);

        $evaluation = Evaluation::where('student_name', $user->name)->latest()->first();
        $this->assertNotNull($evaluation);
        $this->assertEquals('High Potential', $evaluation->potential_class);
        $this->assertEquals(9.0, $evaluation->cgpa);
    }
}

