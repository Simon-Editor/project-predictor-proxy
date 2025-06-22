
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Software Project Predictor</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">Project Predictor</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <div class="d-flex">
        <a href="dashboard.php" class="btn btn-outline-light me-2">Dashboard</a>
        <a href="logout.php" class="btn btn-outline-light">Logout</a>
      </div>
    <?php endif; ?>
  </div>
</nav>

<div class="container my-4 flex-grow-1">
