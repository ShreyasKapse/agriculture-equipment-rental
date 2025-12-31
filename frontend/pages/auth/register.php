<?php
// frontend/pages/auth/register.php
require_once '../../../backend/config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = trim($_POST['phone']);
    $role = $_POST['role'];
    $address = trim($_POST['address'] ?? '');

    if (empty($full_name) || empty($email) || empty($password) || empty($phone) || empty($role)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, phone, role, address) VALUES (?, ?, ?, ?, ?, ?)");
            try {
                $stmt->execute([$full_name, $email, $password_hash, $phone, $role, $address]);
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } catch (PDOException $e) {
                $error = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
require_once '../../includes/header.php';
?>

<style>
    .register-container {
        min-height: 100vh;
        display: flex;
        background: white;
    }

    .register-sidebar {
        flex: 0 0 40%;
        background: linear-gradient(135deg, #2E7D32 0%, #1B5E20 100%);
        color: white;
        padding: 4rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .register-sidebar::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    }

    .sidebar-content {
        position: relative;
        z-index: 1;
    }

    .sidebar-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .sidebar-icon svg {
        width: 32px;
        height: 32px;
        fill: white;
    }

    .sidebar-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
    }

    .sidebar-description {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 3rem;
        line-height: 1.6;
    }

    .sidebar-features {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar-feature {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .feature-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-icon svg {
        width: 24px;
        height: 24px;
        fill: white;
    }

    .register-form-section {
        flex: 1;
        padding: 4rem 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow-y: auto;
    }

    .register-form-container {
        max-width: 500px;
        width: 100%;
        margin: 0 auto;
    }

    .role-selection {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .role-card {
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .role-card:hover {
        border-color: #2E7D32;
        background: #F1F8E9;
    }

    .role-card.selected {
        border-color: #2E7D32;
        background: #E8F5E9;
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
    }

    .role-card-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .role-card.selected .role-card-icon {
        transform: scale(1.1);
    }

    .role-card-icon svg {
        width: 28px;
        height: 28px;
        fill: white;
    }

    .role-card-title {
        font-weight: 700;
        color: #212121;
        margin: 0;
    }

    .input-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .register-btn {
        background: linear-gradient(135deg, #2E7D32, #66BB6A);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .register-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(46, 125, 50, 0.3);
    }

    @media (max-width: 992px) {
        .register-container {
            flex-direction: column;
        }

        .register-sidebar {
            flex: 0 0 auto;
            padding: 3rem 2rem;
        }

        .sidebar-title {
            font-size: 2rem;
        }

        .input-row {
            grid-template-columns: 1fr;
        }

        .role-selection {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="register-container">
    <!-- Left Sidebar -->
    <div class="register-sidebar">
        <div class="sidebar-content">
            <div class="sidebar-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V9.99h7V2.95c3.81 1.13 6.88 4.08 7.45 7.04H12v3z" />
                </svg>
            </div>

            <h1 class="sidebar-title">Grow with AERS</h1>
            <p class="sidebar-description">
                Join the largest community of farmers and equipment owners. Rent machinery or list your own assets
                efficiently.
            </p>

            <div class="sidebar-features">
                <div class="sidebar-feature">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V9.99h7V2.95c3.81 1.13 6.88 4.08 7.45 7.04H12v3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">Secure Transactions</h4>
                        <p style="margin: 0; opacity: 0.8; font-size: 0.95rem;">Safe payments with verified equipment
                            owners</p>
                    </div>
                </div>

                <div class="sidebar-feature">
                    <div class="feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">Community Driven</h4>
                        <p style="margin: 0; opacity: 0.8; font-size: 0.95rem;">Connect with thousands of farmers
                            nationwide</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Form Section -->
    <div class="register-form-section">
        <div class="register-form-container">
            <h2 class="mb-2">Create your Account</h2>
            <p class="text-muted mb-4">Join the AERS community today. It takes less than a minute.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="" id="registerForm">
                <!-- Role Selection -->
                <div class="role-selection">
                    <div class="role-card selected" onclick="selectRole('farmer')" data-role="farmer">
                        <div class="role-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                        <h5 class="role-card-title">Farmer</h5>
                    </div>
                    <div class="role-card" onclick="selectRole('owner')" data-role="owner">
                        <div class="role-card-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </div>
                        <h5 class="role-card-title">Owner</h5>
                    </div>
                </div>
                <input type="hidden" name="role" id="selectedRole" value="farmer">

                <!-- Form Fields -->
                <div class="input-row mb-3">
                    <div>
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div>
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="(555) 000-0000" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                </div>

                <div class="input-row mb-3">
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div>
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="••••••••"
                            required>
                    </div>
                </div>

                <button type="submit" class="register-btn mb-3">
                    Register Account
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                    </svg>
                </button>
            </form>

            <div class="text-center">
                <p class="mb-0">Already have an account? <a href="login.php" class="text-primary-green fw-bold"
                        style="text-decoration: none;">Log In</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    function selectRole(role) {
        // Update hidden input
        document.getElementById('selectedRole').value = role;

        // Update selected card
        document.querySelectorAll('.role-card').forEach(card => {
            card.classList.remove('selected');
        });
        document.querySelector(`[data-role="${role}"]`).classList.add('selected');
    }
</script>

<style>
    /* Hide default header/footer for full-screen experience */
    body {
        margin: 0;
        padding: 0;
    }

    .navbar,
    footer {
        display: none;
    }
</style>

<?php require_once '../../includes/footer.php'; ?>