<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PredictionService
{
    /**
     * Predict academic potential and cognitive metrics based on candidate input using a local weighted scoring matrix.
     *
     * @param array $data
     * @return array
     */
    public function predict(array $data): array
    {
        $cgpa = (float)($data['cgpa'] ?? 0.0);
        $aptitude = (int)($data['aptitude_score'] ?? 0);
        $skills = (int)($data['skills_count'] ?? 0);
        $certs = (int)($data['certifications_count'] ?? 0);
        $projects = (int)($data['projects_done'] ?? 0);
        $internships = (int)($data['internships_count'] ?? 0);
        $communication = (int)($data['communication_rating'] ?? 5);
        $leadership = (bool)($data['leadership_role'] ?? false);

        // Extract verified profile test scores if injected
        $verifiedAptitude = $data['verified_aptitude'] ?? null;
        $verifiedReading = $data['verified_reading'] ?? null;
        $verifiedStress = $data['verified_stress'] ?? null;
        $verifiedCoding = $data['verified_coding'] ?? null;

        // If verified test scores are available, fine-tune the parameters
        if ($verifiedAptitude) {
            $aptitude = round(($aptitude + $verifiedAptitude['total']) / 2);
        }
        if ($verifiedReading) {
            $communication = round(($communication + ($verifiedReading['accuracy'] / 10)) / 2);
        }
        if ($verifiedCoding) {
            $skills = max($skills, (int)round($verifiedCoding['total'] / 10));
        }

        // Normalize features to a 0-100 scale
        $cgpaNorm = ($cgpa / 10.0) * 100.0;
        $aptitudeNorm = ($aptitude / 100.0) * 100.0;
        $skillsNorm = min(100.0, ($skills / 10.0) * 100.0);       // 10 skills is 100%
        $projectsNorm = min(100.0, ($projects / 5.0) * 100.0);     // 5 projects is 100%
        $internshipsNorm = min(100.0, ($internships / 3.0) * 100.0); // 3 internships is 100%
        $certsNorm = min(100.0, ($certs / 5.0) * 100.0);           // 5 certifications is 100%
        $communicationNorm = ($communication / 10.0) * 100.0;
        $leadershipNorm = $leadership ? 100.0 : 0.0;

        // Apply weighted scoring matrix (total weights = 100%)
        $finalScore = ($cgpaNorm * 0.20) +
                       ($aptitudeNorm * 0.15) +
                       ($skillsNorm * 0.15) +
                       ($projectsNorm * 0.10) +
                       ($internshipsNorm * 0.10) +
                       ($communicationNorm * 0.10) +
                       ($leadershipNorm * 0.10) +
                       ($certsNorm * 0.10);

        $probability = (int)round($finalScore);
        $probability = max(30, min(100, $probability));

        // Group potential classifications
        if ($probability >= 90) {
            $potential = 'Elite Potential';
            $confidence = 'Elite';
        } elseif ($probability >= 80) {
            $potential = 'High Potential';
            $confidence = 'High';
        } elseif ($probability >= 60) {
            $potential = 'Moderate Potential';
            $confidence = 'Moderate';
        } else {
            $potential = 'Developing Potential';
            $confidence = 'Low';
        }

        // Dynamic SWOT Rule Heuristic Engine
        $strengths = [];
        $weaknesses = [];
        $recommendations = [];

        // Strength rules
        if ($cgpa >= 8.5) {
            $strengths[] = "Exceptional academic GPA standing representing deep conceptual understanding.";
        }
        if ($skills >= 8) {
            $strengths[] = "Strong technical profile with broad verified technology and programming competencies.";
        }
        if ($leadership) {
            $strengths[] = "Active leadership background representing proactive peer collaboration and drive.";
        }
        if ($communication >= 8) {
            $strengths[] = "Excellent communication ratings representing clear and articulate expression.";
        }
        if ($internships >= 1) {
            $strengths[] = "Valuable commercial project exposure and corporate training through professional internships.";
        }

        // Weakness rules
        if ($projects < 3) {
            $weaknesses[] = "Underrepresented capstone project count limits practical index validation.";
            $recommendations[] = "Engage in capstone development to build and host at least 2 more comprehensive project platforms.";
        }
        if ($certs < 2) {
            $weaknesses[] = "Low industry-accredited certifications portfolio.";
            $recommendations[] = "Target industry-accredited professional certifications (e.g. AWS, Azure, Google Cloud, Salesforce) to validate expertise.";
        }
        if ($communication < 6) {
            $weaknesses[] = "Soft skill communication rating can be polished for placement interviews.";
            $recommendations[] = "Enroll in presentation workshops or engage in student club discussions to polish professional expression.";
        }
        if ($aptitude < 60) {
            $weaknesses[] = "Aptitude and problem-solving index shows room for conceptual polish.";
            $recommendations[] = "Engage in weekly standardized problem-solving drills, algorithm practices, and logical puzzles.";
        }

        // Fallback recommendations if everything is perfect
        if (empty($recommendations)) {
            if ($potential === 'Elite Potential') {
                $recommendations[] = "Apply for advanced research fellowships, PG honors, or Ph.D. tracks.";
                $recommendations[] = "Target tier-1 global deep engineering and research labs.";
            } else {
                $recommendations[] = "Obtain advanced architecture or cloud infrastructure certifications.";
                $recommendations[] = "Engage with industry mentors to review profile portfolio mappings.";
            }
        }

        // Career Recommendation Heuristics Engine
        $careerRecommendations = [];
        if ($cgpa >= 8.5 && $projects >= 4 && $skills >= 7) {
            $careerRecommendations[] = "Machine Learning Engineer / Research Scientist";
            $careerRecommendations[] = "Software Systems Architect";
        } elseif ($aptitude >= 85 && $skills >= 6) {
            $careerRecommendations[] = "Data Scientist / Quantitative Analyst";
            $careerRecommendations[] = "Algorithm Engineer";
        } elseif ($communication >= 8 && $leadership) {
            $careerRecommendations[] = "Technical Product Manager";
            $careerRecommendations[] = "Management Consultant";
        } elseif ($certs >= 3 && $skills >= 5) {
            $careerRecommendations[] = "Cloud Infrastructure Engineer";
            $careerRecommendations[] = "DevOps Specialist";
        } else {
            $careerRecommendations[] = "Full Stack Software Developer";
            $careerRecommendations[] = "Business Intelligence Analyst";
        }

        return [
            'potential' => $potential,
            'probability' => $probability,
            'confidence' => $confidence,
            'strengths' => $strengths,
            'weaknesses' => $weaknesses,
            'recommendations' => $recommendations,
            'career_recommendations' => $careerRecommendations,
            'source' => 'Laravel Weighted Scoring Engine'
        ];
    }

    /**
     * Performs a health check against the local scoring engine.
     *
     * @return bool
     */
    public function healthCheck(): bool
    {
        // Local PHP engine is always online and ready
        return true;
    }
}
