<?php
require_once 'backend/config/db.php';
require_once 'frontend/includes/header.php';
?>

<div class="hero">
    <h1>Welcome to Agriculture Equipment Rental System</h1>
    <p class="lead">Rent modern agricultural equipment at affordable prices.</p>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="/agriculture-equipment-rental/frontend/pages/auth/register.php" class="btn btn-primary btn-lg">Get
            Started</a>
        <a href="/agriculture-equipment-rental/frontend/pages/auth/login.php"
            class="btn btn-outline-secondary btn-lg">Login</a>
    <?php else: ?>
        <p class="text-success">You are logged in!</p>
    <?php endif; ?>
</div>

<div class="row text-center">
    <div class="col-md-4">
        <h3>For Farmers</h3>
        <p>Find the best equipment for your farm needs.</p>
    </div>
    <div class="col-md-4">
        <h3>For Owners</h3>
        <p>List your idle equipment and earn income.</p>
    </div>
    <div class="col-md-4">
        <h3>Easy Process</h3>
        <p>Book, Pay, and Use. Simple and transparent.</p>
    </div>
</div>

<?php require_once 'frontend/includes/footer.php'; ?>