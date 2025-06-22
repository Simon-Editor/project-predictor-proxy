<?php
require_once 'includes/header.php';
require_once 'includes/auth.php'; // Protect this page

$userName = $_SESSION['user_name'];
?>

<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <div class="card p-4">
            <h2 class="mb-3">Welcome, <?= htmlspecialchars($userName) ?> 👋</h2>
            <p class="lead">
                Ready to predict your software project outcome?
            </p>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                <a href="predict.php" class="btn btn-primary btn-lg me-md-2">Start Prediction</a>
                <a href="history.php" class="btn btn-outline-primary btn-lg">View Prediction History</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
