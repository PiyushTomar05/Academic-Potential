<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlatformPhaseFourTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Setup public storage fake
        Storage::fake('public');

        // Clear persistent MongoDB collections to prevent E11000 duplicate key errors
        User::query()->delete();
        Evaluation::query()->delete();
    }


    /**
     * Test uploading PDF resume and compiling ATS score metrics.
     */
    public function test_user_can_upload_resume_and_receive_ats_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $pdfResume = UploadedFile::fake()->create('engineering_cv.pdf', 800, 'application/pdf');

        $response = $this->postJson(route('career.resume.analyze'), [
            'resume_file' => $pdfResume
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertNotNull($user->resume_analysis);
        $this->assertGreaterThan(70, $user->resume_analysis['ats_score']);
        $this->assertEquals('engineering_cv.pdf', $user->resume_analysis['filename']);
    }



    /**
     * Test logging custom achievements to portfolio databases.
     */
    public function test_user_can_submit_achievements_and_view_portfolio(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('career.portfolio.add'), [
            'type' => 'hackathon',
            'title' => 'Global AI Hackathon 2026',
            'role' => 'First Place Winner',
            'year' => 2026,
            'description' => 'Developed local sandbox AI heuristic classifiers inside a Laravel web dashboard.'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['success' => true]);

        $user = $user->fresh();
        $this->assertIsArray($user->achievements);
        $this->assertCount(1, $user->achievements);
        $this->assertEquals('hackathon', $user->achievements[0]['type']);
        $this->assertEquals('Global AI Hackathon 2026', $user->achievements[0]['title']);
    }

    /**
     * Test rendering visual growth timelines.
     */
    public function test_user_can_view_growth_timeline(): void
    {
        $user = User::factory()->create([
            'academic_history' => [
                [
                    'year' => '9th Class',
                    'level' => 'school',
                    'subjects' => [
                        ['subject' => 'Math', 'marks' => 90],
                        ['subject' => 'Science', 'marks' => 88],
                        ['subject' => 'Humanities', 'marks' => 85]
                    ]
                ]
            ],
            'coding_test_score' => ['total' => 85, 'completed_at' => now()->toIso8601String()],
            'speaking_test_score' => ['total' => 82, 'completed_at' => now()->toIso8601String()]
        ]);
        $this->actingAs($user);

        // Timeline check on consolidated index
        $response = $this->get(route('career.index'));
        $response->assertStatus(200);
        $response->assertViewHas('timelineEvents');

        // Verify backward-compatibility redirect
        $redirectResponse = $this->get(route('career.timeline'));
        $redirectResponse->assertRedirect(route('career.index'));
    }

    /**
     * Test placement readiness index and PDF reports layout compilation.
     */
    public function test_user_can_view_placement_readiness_kpi_reports(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Readiness check on consolidated index
        $response = $this->get(route('career.index'));
        $response->assertStatus(200);
        $response->assertViewHas('readinessIndex');
        $response->assertViewHas('level');
        $response->assertViewHas('predictionHistory');

        // Verify backward-compatibility redirect
        $redirectResponse = $this->get(route('career.readiness'));
        $redirectResponse->assertRedirect(route('career.index'));
    }
}
