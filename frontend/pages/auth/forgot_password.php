<?php
// frontend/pages/auth/forgot_password.php
require_once '../../includes/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Reset Password</h3>

                <?php if (isset($_POST['email'])): ?>
                    <div class="alert alert-success">
                        If an account exists with that email, we have sent password reset instructions.
                    </div>
                    <div class="d-grid">
                        <a href="login.php" class="btn btn-outline-primary">Back to Login</a>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center mb-4">Enter your email address and we'll send you a link to reset your
                        password.</p>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Send Reset Link</button>
                            <a href="login.php" class="btn btn-link text-decoration-none text-muted">Back to Login</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>