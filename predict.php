<?php
 include 'includes/header.php'; 

$prediction = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teamSize = $_POST["team_size"];
    $planningHours = $_POST["planning_hours"];
    $codingHours = $_POST["coding_hours"];
    $gpaAverage = $_POST["gpa_average"];
    $techStack = $_POST["tech_stack"];
    $supervisorExperience = $_POST["supervisor_experience"];

    $data = [
        "data" => [
            (int)$teamSize,
            (int)$planningHours,
            (int)$codingHours,
            (float)$gpaAverage,
            $techStack,
            (int)$supervisorExperience
        ]
    ];

    $jsonData = json_encode($data);

    $apiUrl = "http://localhost:5001/predict";
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = 'Request Error: ' . curl_error($ch);
    } else {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            $decoded = json_decode($response, true);
            $prediction = is_array($decoded['prediction']) ? $decoded['prediction'][0] : $decoded['prediction'];// returns the prediction string
        } else {
            $error = "HTTP $httpCode Error: $response";
        }
    }

    curl_close($ch);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Success Predictor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Predict Your Project Success</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($prediction): ?>
            <div class="alert alert-success"><strong>Prediction:</strong> <?= htmlspecialchars($prediction) ?></div>
        <?php endif; ?>

        <form method="post" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Team Size</label>
                <input type="number" name="team_size" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Planning Hours</label>
                <input type="number" name="planning_hours" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Coding Hours</label>
                <input type="number" name="coding_hours" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">GPA Average</label>
                <input type="number" step="0.01" name="gpa_average" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tech Stack</label>
                <select name="tech_stack" class="form-select">
                    <option value="PHP">PHP</option>
                    <option value="Python">Python</option>
                    <option value="JavaScript">JavaScript</option>
                    <option value="Java">Java</option>
                    <option value="C#">C#</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Supervisor Experience (years)</label>
                <input type="number" name="supervisor_experience" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit for Prediction</button>
        </form>

    </div>
</body>
</html>

<?php include 'includes/footer.php'; ?>