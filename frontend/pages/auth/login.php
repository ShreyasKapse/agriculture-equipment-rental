<?php
// frontend/pages/auth/login.php
require_once '../../../backend/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'] ?? 'farmer'; // Default to farmer if not specified

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Verify role matches
            if ($user['role'] !== $role) {
                $error = "Invalid credentials for selected role.";
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_role'] = $user['role'];
                header("Location: ../../../index.php");
                exit;
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}

require_once '../../includes/header.php';
?>

<style>
    .login-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #E8F5E9 0%, #F1F8E9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .login-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        max-width: 480px;
        width: 100%;
    }

    .login-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
    }

    .login-icon svg {
        width: 32px;
        height: 32px;
        fill: white;
    }

    .role-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        background: #F5F5F5;
        padding: 0.5rem;
        border-radius: 12px;
    }

    .role-tab {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        background: transparent;
        border-radius: 8px;
        font-weight: 600;
        color: #757575;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .role-tab.active {
        background: white;
        color: #2E7D32;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .role-tab:hover:not(.active) {
        color: #2E7D32;
    }

    .input-group-icon {
        position: relative;
    }

    .input-group-icon .form-control {
        padding-left: 3rem;
    }

    .input-group-icon .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #757575;
        z-index: 10;
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .social-login {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        border: 2px solid #E0E0E0;
        background: white;
        border-radius: 8px;
        font-weight: 600;
        color: #212121;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .social-btn:hover {
        border-color: #2E7D32;
        background: #F1F8E9;
    }

    .divider {
        text-align: center;
        margin: 1.5rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #E0E0E0;
    }

    .divider span {
        background: white;
        padding: 0 1rem;
        position: relative;
        color: #757575;
        font-size: 0.9rem;
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="login-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
            </svg>
        </div>

        <h3 class="text-center mb-2">Log in to your account</h3>
        <p class="text-center text-muted mb-4">Welcome back to AERS. Please enter your details.</p>

        <!-- Role Selection Tabs -->
        <div class="role-tabs">
            <button type="button" class="role-tab active" data-role="farmer"
                onclick="selectRole('farmer')">Farmer</button>
            <button type="button" class="role-tab" data-role="owner" onclick="selectRole('owner')">Owner</button>
            <button type="button" class="role-tab" data-role="admin" onclick="selectRole('admin')">Admin</button>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" id="loginForm">
            <input type="hidden" name="role" id="selectedRole" value="farmer">

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group-icon">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                        </svg>
                    </span>
                    <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group-icon">
                    <span class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                        </svg>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <div class="remember-forgot">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                    <label class="form-check-label" for="rememberMe">
                        Remember me
                    </label>
                </div>
                <a href="forgot_password.php" class="text-primary-green"
                    style="text-decoration: none; font-weight: 600;">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">Login Securely</button>
        </form>

        <div class="divider">
            <span>Or continue with</span>
        </div>

        <div class="social-login">
            <button type="button" class="social-btn" onclick="alert('Google login coming soon!')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#4285F4"
                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                    <path fill="#34A853"
                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                    <path fill="#FBBC05"
                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                    <path fill="#EA4335"
                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                </svg>
                Google
            </button>
            <button type="button" class="social-btn" onclick="alert('Phone login coming soon!')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#2E7D32">
                    <path
                        d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                </svg>
                Phone
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="mb-0">New to AgriRent? <a href="register.php" class="text-primary-green fw-bold"
                    style="text-decoration: none;">Create an account</a></p>
        </div>
    </div>
</div>

<script>
    function selectRole(role) {
        // Update hidden input
        document.getElementById('selectedRole').value = role;

        // Update active tab
        document.querySelectorAll('.role-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector(`[data-role="${role}"]`).classList.add('active');
    }
</script>

<?php require_once '../../includes/footer.php'; ?>