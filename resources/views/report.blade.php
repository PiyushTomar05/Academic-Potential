<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Potential Report - {{ $evaluation->student_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Geist', sans-serif;
            background: #ffffff;
            color: #0f172a;
            margin: 0;
            padding: 40px;
            font-size: 14px;
        }
        .header {
            display: flex;
            justify-between: space-between;
            align-items: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
            color: #2563eb;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .meta-card {
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 12px;
        }
        .meta-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-line {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .meta-line:last-child {
            border: none;
        }
        .label {
            color: #64748b;
            font-weight: 600;
        }
        .value {
            font-weight: 700;
            color: #0f172a;
        }
        .gauge-section {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .gauge-card {
            flex: 1;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .radial-gauge {
            width: 120px;
            height: 120px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 15px 0;
        }
        .radar-chart {
            width: 160px;
            height: 160px;
        }
        .radar-area {
            fill: rgba(37, 99, 235, 0.15);
            stroke: #2563eb;
            stroke-width: 2;
        }
        .swot-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .swot-card {
            padding: 20px;
            border-radius: 12px;
        }
        .strengths-card {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }
        .weaknesses-card {
            background: #faf5ff;
            border: 1px solid #e9d5ff;
        }
        .swot-card h3 {
            margin: 0 0 15px 0;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .strengths-card h3 { color: #1e3a8a; }
        .weaknesses-card h3 { color: #581c87; }
        .swot-list {
            padding-left: 20px;
            margin: 0;
        }
        .swot-list li {
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .roadmap-section {
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .roadmap-section h3 {
            margin: 0 0 15px 0;
            font-size: 14px;
            color: #0f172a;
        }
        .roadmap-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }
        .roadmap-step {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 15px;
            border-radius: 8px;
        }
        .roadmap-step h4 {
            margin: 0 0 5px 0;
            font-size: 11px;
            text-transform: uppercase;
            color: #64748b;
        }
        .roadmap-step p {
            margin: 0;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h1>Evaluating Academic Potential</h1>
            <p>ANN-Based Placement Fit Report</p>
        </div>
        <div style="text-align: right;">
            <div style="font-weight: 700; color: #0f172a;">REPORT ID: {{ substr($evaluation->id, -8) }}</div>
            <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">TIMESTAMP: {{ date('M d, Y H:i:s') }}</div>
        </div>
    </div>

    <div class="meta-grid">
        <div class="meta-card">
            <h3>Candidate Profile</h3>
            <div class="meta-line">
                <span class="label">Name:</span>
                <span class="value">{{ $evaluation->student_name }}</span>
            </div>
            <div class="meta-line">
                <span class="label">Email:</span>
                <span class="value">{{ $evaluation->email }}</span>
            </div>
            <div class="meta-line">
                <span class="label">Track Recommended:</span>
                <span class="value" style="color: #2563eb;">{{ $evaluation->recommended_track }}</span>
            </div>
        </div>
        <div class="meta-card">
            <h3>Scholastic Indexes</h3>
            <div class="meta-line">
                <span class="label">CGPA Metric:</span>
                <span class="value">{{ number_format($evaluation->cgpa, 2) }} / 10.0</span>
            </div>
            <div class="meta-line">
                <span class="label">Aptitude Score:</span>
                <span class="value">{{ $evaluation->aptitude_score }}%</span>
            </div>
            <div class="meta-line">
                <span class="label">Classification Class:</span>
                <span class="value">{{ $evaluation->potential_class }}</span>
            </div>
        </div>
    </div>

    <div class="gauge-section">
        <!-- Radial fit gauge -->
        <div class="gauge-card">
            <h4 style="margin: 0; font-size: 12px; color: #475569; uppercase">Placement Fit Index</h4>
            <div class="radial-gauge">
                <svg width="100" height="100" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#e2e8f0" stroke-width="8"></circle>
                    @php
                        $dash = 2 * pi() * 40;
                        $offset = $dash - ($dash * ($evaluation->probability_score / 100));
                    @endphp
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#2563eb" stroke-width="8" stroke-dasharray="{{ $dash }}" stroke-dashoffset="{{ $offset }}" stroke-linecap="round"></circle>
                </svg>
                <div style="position: absolute; font-size: 20px; font-weight: 900; color: #0f172a;">{{ $evaluation->probability_score }}%</div>
            </div>
            <span style="font-size: 11px; font-weight: bold; color: #64748b;">Sigmoid Activation Fit</span>
        </div>

        <!-- Skills map radar -->
        <div class="gauge-card">
            <h4 style="margin: 0; font-size: 12px; color: #475569; uppercase">Cognitive Skill Map</h4>
            @php
                $s1 = $evaluation->data_synthesis;
                $s2 = $evaluation->cognitive_agility;
                $s3 = $evaluation->problem_decomposition;
                $s4 = $evaluation->academic_influence;
                $s5 = $evaluation->communication_rating;

                $v1_x = 100;
                $v1_y = 100 - (80 * ($s1 / 10));

                $v2_x = 100 - (80 * ($s2 / 10));
                $v2_y = 100 - (20 * ($s2 / 10));

                $v3_x = 100 - (50 * ($s4 / 10));
                $v3_y = 100 + (70 * ($s4 / 10));

                $v4_x = 100 + (50 * ($s3 / 10));
                $v4_y = 100 + (70 * ($s3 / 10));

                $v5_x = 100 + (80 * ($s5 / 10));
                $v5_y = 100 - (20 * ($s5 / 10));

                $points = "{$v1_x},{$v1_y} {$v2_x},{$v2_y} {$v3_x},{$v3_y} {$v4_x},{$v4_y} {$v5_x},{$v5_y}";
            @endphp
            <div class="radial-gauge">
                <svg class="radar-chart" viewBox="0 0 200 200">
                    <polygon class="radar-area" points="{{ $points }}"></polygon>
                    <polygon points="100,20 180,80 150,170 50,170 20,80" fill="none" stroke="#cbd5e1" stroke-width="1"></polygon>
                    <polygon points="100,50 150,85 130,140 70,140 50,85" fill="none" stroke="#e2e8f0" stroke-width="1"></polygon>
                    <line x1="100" y1="100" x2="100" y2="20" stroke="#cbd5e1" stroke-width="1"></line>
                    <line x1="100" y1="100" x2="20" y2="80" stroke="#cbd5e1" stroke-width="1"></line>
                    <line x1="100" y1="100" x2="50" y2="170" stroke="#cbd5e1" stroke-width="1"></line>
                    <line x1="100" y1="100" x2="150" y2="170" stroke="#cbd5e1" stroke-width="1"></line>
                    <line x1="100" y1="100" x2="180" y2="80" stroke="#cbd5e1" stroke-width="1"></line>
                </svg>
            </div>
            <span style="font-size: 11px; font-weight: bold; color: #64748b;">5-Axis Vector Mapping</span>
        </div>
    </div>

    @php
        $aiData = $evaluation->ai ?? [];
        $strengths = $aiData['strengths'] ?? ['Grade stability', 'Logic competency'];
        $weaknesses = $aiData['weaknesses'] ?? ['Lacks active capstone projects', 'Fewer verified tech skills'];
        $recommendations = $aiData['recommendations'] ?? ['Deploy an open-source tool on GitHub', 'Engage in corporate internships'];
    @endphp

    <div class="swot-section">
        <div class="swot-card strengths-card">
            <h3>STRENGTH ARCHRENGTHS</h3>
            <ul class="swot-list">
                @foreach ($strengths as $strength)
                    <li>{{ $strength }}</li>
                @endforeach
            </ul>
        </div>
        <div class="swot-card weaknesses-card">
            <h3>GROWTH AREAS</h3>
            <ul class="swot-list">
                @foreach ($weaknesses as $weakness)
                    <li>{{ $weakness }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="roadmap-section">
        <h3>Actionable Roadmap & Skill Improvement Recommendations</h3>
        <div class="roadmap-grid">
            @foreach ($recommendations as $index => $rec)
                <div class="roadmap-step">
                    <h4>Milestone 0{{ $index + 1 }}</h4>
                    <p>{{ $rec }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <span>Evaluating Academic Potential Platform</span>
        <span>Secure Report Verification MD5: {{ md5($evaluation->id . $evaluation->student_name) }}</span>
        <span>CONFIDENTIAL REPORT</span>
    </div>

    <script>
        // Trigger print immediately on document ready to export as PDF
        window.addEventListener('load', () => {
            window.print();
        });
    </script>
</body>
</html>
