<?php
require_once 'includes/header.php';
require_once 'includes/auth.php';

$result = $_GET['result'] ?? 'Unknown';
$score = $_GET['score'] ?? 'N/A';

$confidence = is_numeric($score) ? round($score * 100, 1) . '%' : 'N/A';
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow p-4">
            <h3 class="mb-4 text-center">Prediction Result</h3>

            <div class="alert alert-info text-center">
                <strong>Prediction:</strong> <?php echo htmlspecialchars($result); ?> <br>
                <strong>Confidence:</strong> <?php echo $confidence; ?>
            </div>

            <div class="text-center">
                <a href="predict.php" class="btn btn-secondary">Make Another Prediction</a>
                <a href="history.php" class="btn btn-primary">View My Prediction History</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
