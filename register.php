<?php
include 'includes/header.php';
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $raw_password = $_POST['password'];

    // Validate password: min 8 characters, at least one letter and one number
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $raw_password)) {
        $error = "Password must be at least 8 characters long and include at least one letter and one number.";
    } else {
        $password = password_hash($raw_password, PASSWORD_BCRYPT);

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = "Email already exists!";
        } else {
            // Insert new user
            $insert = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
            $insert->execute([$full_name, $email, $password]);
            $success = "Registration successful. <a href='login.php'>Login now</a>";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow p-4">
            <h3 class="text-center mb-4">Student Registration</h3>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif (!empty($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name:</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" name="password" class="form-control" required
                        pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
                        title="Must be at least 8 characters, including one letter and one number">
                    <small class="text-muted">Must be at least 8 characters, include a letter and a number.</small>
                </div>

                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>

            <p class="mt-3 text-center">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
