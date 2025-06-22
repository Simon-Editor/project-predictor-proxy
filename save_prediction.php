<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $team_size = $_POST['team_size'];
    $planning_hours = $_POST['planning_hours'];
    $coding_hours = $_POST['coding_hours'];
    $gpa_average = $_POST['gpa_average'];
    $tech_stack = $_POST['tech_stack'];
    $supervisor_experience = $_POST['supervisor_experience'];

    // Validate fields
    if (
        empty($team_size) || empty($planning_hours) || empty($coding_hours) ||
        empty($gpa_average) || empty($tech_stack) || empty($supervisor_experience)
    ) {
        header("Location: predict.php?error=empty");
        exit;
    }

    // Prepare data for API
    $inputData = [
        "team_size" => (int)$team_size,
        "planning_hours" => (float)$planning_hours,
        "coding_hours" => (float)$coding_hours,
        "gpa_average" => (float)$gpa_average,
        "tech_stack" => $tech_stack,
        "supervisor_experience" => (int)$supervisor_experience
    ];

    // Call Hugging Face Space API
    $api_url = "https://simon-editor-jnr-project-success-predictor.hf.space/run/predict"; // Make sure this matches your Space
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["data" => array_values($inputData)]));
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);

    if (isset($json['data'][0])) {
        // Extract and sanitize
        $prediction_text = $json['data'][0]; // e.g. "Success with 78.5% confidence"
        $predicted_result = stripos($prediction_text, 'Success') !== false ? 'Success' : 'Failure';
        preg_match('/(\d+(\.\d+)?)%/', $prediction_text, $matches);
        $predicted_score = isset($matches[1]) ? floatval($matches[1]) / 100 : null;

        // Save to DB
        $stmt = $pdo->prepare("INSERT INTO predictions (user_id, team_size, planning_hours, coding_hours, gpa_average, tech_stack, supervisor_experience, predicted_result, predicted_score)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $user_id,
            $team_size,
            $planning_hours,
            $coding_hours,
            $gpa_average,
            $tech_stack,
            $supervisor_experience,
            $predicted_result,
            $predicted_score
        ]);

        // Redirect to results page
        header("Location: prediction-result.php?result=" . urlencode($predicted_result) . "&score=" . urlencode($predicted_score));
        exit;
    } else {
        // API didn't return usable data
        header("Location: predict.php?error=model");
        exit;
    }
} else {
    header("Location: predict.php");
    exit;
}
