<?php
// frontend/includes/header.php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../backend/config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Equipment Rental</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Material-Inspired Styles -->
    <link href="<?php echo BASE_URL; ?>/frontend/assets/css/style.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>/index.php">🌾 AgriRental</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo BASE_URL; ?>/index.php">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo BASE_URL; ?>/frontend/pages/farmer/browse_equipment.php">Browse
                            Equipment</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="<?php echo BASE_URL; ?>/frontend/pages/about.php">About Us</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <li class="nav-item"><a class="nav-link"
                                    href="<?php echo BASE_URL; ?>/frontend/pages/admin/dashboard.php">Admin Panel</a></li>
                        <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'owner'): ?>
                            <li class="nav-item"><a class="nav-link"
                                    href="<?php echo BASE_URL; ?>/frontend/pages/owner/dashboard.php">Dashboard</a>
                            </li>
                            <li class="nav-item"><a class="nav-link"
                                    href="<?php echo BASE_URL; ?>/frontend/pages/owner/my_equipment.php">My Equipment</a>
                            </li>
                            <li class="nav-item"><a class="nav-link"
                                    href="<?php echo BASE_URL; ?>/frontend/pages/owner/manage_bookings.php">Requests</a>
                            </li>
                        <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'farmer'): ?>
                            <li class="nav-item"><a class="nav-link"
                                    href="<?php echo BASE_URL; ?>/frontend/pages/farmer/my_bookings.php">My Bookings</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link"
                                href="<?php echo BASE_URL; ?>/frontend/pages/profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link"
                                href="<?php echo BASE_URL; ?>/frontend/pages/auth/logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link"
                                href="<?php echo BASE_URL; ?>/frontend/pages/auth/login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2"
                                href="<?php echo BASE_URL; ?>/frontend/pages/auth/register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">