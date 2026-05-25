<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Candidate General Info
            $table->string('candidate_name');
            $table->string('candidate_email');
            
            // Academic Inputs
            $table->decimal('cgpa', 4, 2);
            $table->integer('aptitude_score');
            $table->integer('skills_count');
            $table->integer('certifications_count');
            $table->integer('projects_done'); // Numeric value stored (e.g. 0, 2, 5)
            $table->integer('internships_count');
            $table->boolean('leadership_role');
            $table->integer('communication_rating');
            
            // Simulated AI Prediction Outputs
            $table->string('potential_class'); // Elite, High, Moderate, Developing
            $table->integer('probability_score'); // percentage 0-100
            
            // Multi-variable Cognitive Scales (0-10)
            $table->decimal('cognitive_agility', 3, 1);
            $table->decimal('data_synthesis', 3, 1);
            $table->decimal('problem_decomposition', 3, 1);
            $table->decimal('academic_influence', 3, 1);
            
            $table->string('recommended_track'); // Ph.D. / Research, Corporate Leadership, etc.
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
