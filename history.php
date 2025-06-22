<?php
require_once 'includes/header.php';
require_once 'includes/auth.php';
require_once 'includes/db.php'; // ✅ This line is required

$user_id = $_SESSION['user_id'];

// Fetch predictions
$stmt = $pdo->prepare("SELECT * FROM predictions WHERE user_id = ? ORDER BY prediction_date DESC");
$stmt->execute([$user_id]);
$predictions = $stmt->fetchAll();

?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow p-4">
            <h3 class="mb-4 text-center">Your Prediction History</h3>

            <?php if (count($predictions) === 0): ?>
                <p class="text-center">No predictions yet. <a href="predict.php">Make one now</a>.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Team Size</th>
                                <th>Planning (hrs)</th>
                                <th>Coding (hrs)</th>
                                <th>GPA</th>
                                <th>Tech Stack</th>
                                <th>Supervisor Exp.</th>
                                <th>Prediction</th>
                                <th>Score</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($predictions as $index => $row): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $row['team_size'] ?></td>
                                    <td><?= $row['planning_hours'] ?></td>
                                    <td><?= $row['coding_hours'] ?></td>
                                    <td><?= $row['gpa_average'] ?></td>
                                    <td><?= htmlspecialchars($row['tech_stack']) ?></td>
                                    <td><?= $row['supervisor_experience'] ?></td>
                                    <td>
                                        <span class="badge <?= $row['predicted_result'] === 'Success' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $row['predicted_result'] ?>
                                        </span>
                                    </td>
                                    <td><?= round($row['predicted_score'] * 100, 1) ?>%</td>
                                    <td><?= date('d M Y, h:i A', strtotime($row['prediction_date'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
