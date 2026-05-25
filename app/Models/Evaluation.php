<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'predictions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'student_name',
        'email',
        'academic',
        'portfolio',
        'softskills',
        'ai',
        'academic_history',
        'aptitude',
        'english',
        'speaking',
        'reading',
        'writing',
        'core_subjects',
        'career_recommendations',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'academic' => 'array',
        'portfolio' => 'array',
        'softskills' => 'array',
        'ai' => 'array',
        'academic_history' => 'array',
        'aptitude' => 'array',
        'english' => 'array',
        'speaking' => 'array',
        'reading' => 'array',
        'writing' => 'array',
        'core_subjects' => 'array',
        'career_recommendations' => 'array',
    ];

    // Accessors for candidate general info
    public function getCandidateNameAttribute()
    {
        return $this->student_name;
    }

    public function getCandidateEmailAttribute()
    {
        return $this->email;
    }

    // Accessors for academic nested object
    public function getCgpaAttribute()
    {
        return (float)($this->academic['cgpa'] ?? 0.0);
    }

    public function getAptitudeScoreAttribute()
    {
        return (int)($this->academic['aptitude'] ?? 0);
    }

    public function getCertificationsCountAttribute()
    {
        return (int)($this->academic['certifications'] ?? 0);
    }

    // Accessors for portfolio nested object
    public function getProjectsDoneAttribute()
    {
        return (int)($this->portfolio['projects'] ?? 0);
    }

    public function getInternshipsCountAttribute()
    {
        return (int)($this->portfolio['internships'] ?? 0);
    }

    public function getLeadershipRoleAttribute()
    {
        return (bool)($this->portfolio['leadership'] ?? false);
    }

    // Accessors for softskills nested object
    public function getCommunicationRatingAttribute()
    {
        return (int)($this->softskills['communication'] ?? 0);
    }

    public function getSkillsCountAttribute()
    {
        return (int)($this->softskills['skills'] ?? 0);
    }

    // Accessors for AI nested object
    public function getPotentialClassAttribute()
    {
        return $this->ai['potential'] ?? 'Developing Potential';
    }

    public function getProbabilityScoreAttribute()
    {
        return (int)($this->ai['probability'] ?? 0);
    }

    public function getRecommendedTrackAttribute()
    {
        $recs = $this->ai['recommendations'] ?? [];
        return $recs[0] ?? 'Specialized Technical Track';
    }

    // Dynamic calculations for backward-compatible radar chart rendering
    public function getCognitiveAgilityAttribute()
    {
        $aptitude = $this->aptitude_score;
        $cgpa = $this->cgpa;
        $leadership = $this->leadership_role;
        $val = (($aptitude / 100) * 6.0) + (($cgpa / 10) * 3.0) + ($leadership ? 1.0 : 0);
        return round(max(2.0, min(10.0, $val)), 1);
    }

    public function getDataSynthesisAttribute()
    {
        $skills = $this->skills_count;
        $certs = $this->certifications_count;
        $projects = $this->projects_done;
        $aptitude = $this->aptitude_score;
        $val = (($skills / 10) * 3.0) + (($certs / 5) * 3.0) + (($projects / 5) * 3.0) + (($aptitude / 100) * 1.0);
        return round(max(2.0, min(10.0, $val)), 1);
    }

    public function getProblemDecompositionAttribute()
    {
        $cgpa = $this->cgpa;
        $projects = $this->projects_done;
        $internships = $this->internships_count;
        $val = (($cgpa / 10) * 4.0) + (($projects / 5) * 4.0) + (($internships / 3) * 2.0);
        return round(max(2.0, min(10.0, $val)), 1);
    }

    public function getAcademicInfluenceAttribute()
    {
        $cgpa = $this->cgpa;
        $certs = $this->certifications_count;
        $comm = $this->communication_rating;
        $leadership = $this->leadership_role;
        $val = (($cgpa / 10) * 3.5) + (($certs / 5) * 2.5) + (($comm / 10) * 2.5) + ($leadership ? 1.5 : 0);
        return round(max(2.0, min(10.0, $val)), 1);
    }

    /**
     * Get the user that owns this evaluation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
