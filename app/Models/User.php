<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'academic_history',
        'aptitude_test_score',
        'english_test_score',
        'speaking_test_score',
        'reading_test_score',
        'written_test_score',
        'core_subject_score',
        'psychometric_test_score',
        'coding_test_score',
        'projects_done',
        'internships_count',
        'certifications_count',
        'leadership_role',
        'achievements',
        'resume_analysis',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'academic_history' => 'array',
            'aptitude_test_score' => 'array',
            'english_test_score' => 'array',
            'speaking_test_score' => 'array',
            'reading_test_score' => 'array',
            'written_test_score' => 'array',
            'core_subject_score' => 'array',
            'psychometric_test_score' => 'array',
            'coding_test_score' => 'array',
            'projects_done' => 'integer',
            'internships_count' => 'integer',
            'certifications_count' => 'integer',
            'leadership_role' => 'boolean',
            'achievements' => 'array',
            'resume_analysis' => 'array',
        ];
    }

    /**
     * Get all evaluations submitted by this user.
     */
    public function evaluations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Evaluation::class);
    }
}
