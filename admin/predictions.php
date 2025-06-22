<?php
session_start();
require_once 'includes/auth.php';
require_once '../includes/db.php';
include '../includes/header.php';

$stmt = $pdo->query("SELECT p.*, u.full_name FROM predictions p 
                     JOIN users u ON p.user_id = u.user_id 
                     ORDER BY p.prediction_date DESC");
$predictions = $stmt->fetchAll();
?>

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card shadow p-4">
            <h3 class="mb-4 text-center">All Project Predictions</h3>

            <?php if (count($predictions) === 0): ?>
                <p class="text-center">No predictions found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Student</th>
                                <th>Team Size</th>
                                <th>Planning Hrs</th>
                                <th>Coding Hrs</th>
                                <th>GPA</th>
                                <th>Tech Stack</th>
                                <th>Supervisor Exp.</th>
                                <th>Prediction</th>
                                <th>Score</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($predictions as $index => $p): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($p['full_name']) ?></td>
                                    <td><?= $p['team_size'] ?></td>
                                    <td><?= $p['planning_hours'] ?></td>
                                    <td><?= $p['coding_hours'] ?></td>
                                    <td><?= $p['gpa_average'] ?></td>
                                    <td><?= htmlspecialchars($p['tech_stack']) ?></td>
                                    <td><?= $p['supervisor_experience'] ?></td>
                                    <td>
                                        <span class="badge <?= $p['predicted_result'] === 'Success' ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $p['predicted_result'] ?>
                                        </span>
                                    </td>
                                    <td><?= round($p['predicted_score'] * 100, 1) ?>%</td>
                                    <td><?= date('d M Y, h:i A', strtotime($p['prediction_date'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
