<?php
// frontend/pages/admin/dashboard.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

// Access Control
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit;
}

// Fetch Stats
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalEquipment = $pdo->query("SELECT COUNT(*) FROM equipment")->fetchColumn();
$totalBookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Admin Dashboard</h2>
        <p class="text-muted">System Overview & Management</p>
    </div>
</div>

<div class="row text-center mb-5">
    <div class="col-md-4">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <h2 class="display-4">
                    <?php echo $totalUsers; ?>
                </h2>
                <a href="manage_users.php" class="text-white">Manage Users &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Equipment</h5>
                <h2 class="display-4">
                    <?php echo $totalEquipment; ?>
                </h2>
                <span class="text-white-50">Listed across platform</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Bookings</h5>
                <h2 class="display-4">
                    <?php echo $totalBookings; ?>
                </h2>
                <a href="all_bookings.php" class="text-dark">View Bookings &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Quick Actions</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="manage_users.php" class="btn btn-outline-primary">View Registered Users</a>
                    <a href="all_bookings.php" class="btn btn-outline-dark">Monitor All Rentals</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>