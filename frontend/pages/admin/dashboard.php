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

// Calculate Total Revenue (Completed & Approved)
$totalRevenue = $pdo->query("SELECT SUM(total_price) FROM bookings WHERE status IN ('completed', 'approved')")->fetchColumn();
$totalRevenue = $totalRevenue ?: 0;

// Fetch Recent Bookings
$recentBookings = $pdo->query("
    SELECT b.created_at, b.total_price, u.full_name, b.status 
    FROM bookings b 
    JOIN users u ON b.farmer_id = u.id 
    ORDER BY b.created_at DESC LIMIT 5
")->fetchAll();

// Fetch Recent Users
$recentUsers = $pdo->query("SELECT full_name, role, created_at FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll();
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

<div class="row text-center mb-5">
    <div class="col-md-12">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Estimated Total Revenue</h5>
                <h2 class="display-5">₹<?php echo number_format($totalRevenue, 2); ?></h2>
                <span class="text-white-50">From approved & completed bookings</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light fw-bold">Recent Bookings</div>
            <ul class="list-group list-group-flush">
                <?php if (count($recentBookings) > 0): ?>
                    <?php foreach ($recentBookings as $rb): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold"><?php echo htmlspecialchars($rb['full_name']); ?></span>
                                <small
                                    class="text-muted d-block"><?php echo date('M d', strtotime($rb['created_at'])); ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-secondary"><?php echo $rb['status']; ?></span>
                                <small class="d-block">₹<?php echo $rb['total_price']; ?></small>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item text-center text-muted">No recent bookings</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light fw-bold">Newest Users</div>
            <ul class="list-group list-group-flush">
                <?php if (count($recentUsers) > 0): ?>
                    <?php foreach ($recentUsers as $ru): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold"><?php echo htmlspecialchars($ru['full_name']); ?></span>
                                <small
                                    class="text-muted d-block"><?php echo date('M d', strtotime($ru['created_at'])); ?></small>
                            </div>
                            <span class="badge bg-primary rounded-pill"><?php echo ucfirst($ru['role']); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item text-center text-muted">No recent users</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>