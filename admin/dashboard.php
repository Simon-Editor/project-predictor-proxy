<?php
session_start();
require_once 'includes/auth.php';
include '../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow p-4">
            <h3 class="mb-3 text-center">Welcome, Admin <?= $_SESSION['admin_username'] ?></h3>
            <p class="text-center">Use the links below to manage the system.</p>

            <div class="d-flex justify-content-center gap-3">
                <a href="users.php" class="btn btn-outline-primary">View Students</a>
                <a href="predictions.php" class="btn btn-outline-success">View Predictions</a>
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
