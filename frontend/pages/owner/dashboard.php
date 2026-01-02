<?php
// frontend/pages/owner/dashboard.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
    header("Location: ../../../index.php");
    exit;
}

$owner_id = $_SESSION['user_id'];

// Fetch Stats
// 1. Total Equipment
$stmt = $pdo->prepare("SELECT COUNT(*) FROM equipment WHERE owner_id = ?");
$stmt->execute([$owner_id]);
$totalEquipment = $stmt->fetchColumn();

// 2. Active Bookings (Approved or Pending)
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM bookings b 
    JOIN equipment e ON b.equipment_id = e.id 
    WHERE e.owner_id = ? AND b.status IN ('amount', 'approved')
");
// Wait, status 'pending' is active? Yes. 'approved' is active. 'completed' is done.
// Let's count 'ongoing' rentals separately maybe?
// 'Pending' = Requests. 'Approved' = Rented/Reserved.
// Let's just count 'Active Rentals' (Approved) and 'Pending Requests' (Pending) separately.

// Pending Requests
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM bookings b 
    JOIN equipment e ON b.equipment_id = e.id 
    WHERE e.owner_id = ? AND b.status = 'pending'
");
$stmt->execute([$owner_id]);
$pendingRequests = $stmt->fetchColumn();

// Active/Approved Rentals
$stmt = $pdo->prepare("
    SELECT COUNT(*) FROM bookings b 
    JOIN equipment e ON b.equipment_id = e.id 
    WHERE e.owner_id = ? AND b.status = 'approved'
");
$stmt->execute([$owner_id]);
$activeRentals = $stmt->fetchColumn();

// 3. Total Earnings (Completed bookings)
$stmt = $pdo->prepare("
    SELECT SUM(b.total_price) FROM bookings b 
    JOIN equipment e ON b.equipment_id = e.id 
    WHERE e.owner_id = ? AND b.status IN ('completed', 'approved')
");
$stmt->execute([$owner_id]);
$totalEarnings = $stmt->fetchColumn() ?: 0;

// Fetch Recent Requests
$stmt = $pdo->prepare("
    SELECT b.*, e.name as equipment_name, u.full_name as farmer_name
    FROM bookings b
    JOIN equipment e ON b.equipment_id = e.id
    JOIN users u ON b.farmer_id = u.id
    WHERE e.owner_id = ?
    ORDER BY b.created_at DESC LIMIT 5
");
$stmt->execute([$owner_id]);
$recentActivity = $stmt->fetchAll();
?>

<div class="row mb-4">
    <div class="col-12">
        <h2>Owner Dashboard</h2>
        <p class="text-muted">Overview of your rental business</p>
    </div>
</div>

<!-- Stats Row -->
<div class="row text-center mb-5">
    <div class="col-md-3">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h6 class="card-title">Total Earnings</h6>
                <h3 class="display-6">₹<?php echo number_format($totalEarnings); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
         <div class="card bg-warning text-dark mb-3">
            <div class="card-body">
                <h6 class="card-title">Pending Requests</h6>
                <h3 class="display-6"><?php echo $pendingRequests; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h6 class="card-title">Active Rentals</h6>
                <h3 class="display-6"><?php echo $activeRentals; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white mb-3">
            <div class="card-body">
                <h6 class="card-title">My Equipment</h6>
                <h3 class="display-6"><?php echo $totalEquipment; ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light fw-bold">Quick Actions</div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="add_equipment.php" class="btn btn-outline-primary btn-lg">
                        + Add New Equipment
                    </a>
                    <a href="manage_bookings.php" class="btn btn-outline-dark">
                        Manage Booking Requests
                        <?php if ($pendingRequests > 0): ?>
                            <span class="badge bg-danger ms-2"><?php echo $pendingRequests; ?> New</span>
                        <?php endif; ?>
                    </a>
                    <a href="my_equipment.php" class="btn btn-outline-secondary">
                        View My Listings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header bg-light fw-bold">Recent Activity</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Equipment</th>
                            <th>Farmer</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($recentActivity) > 0): ?>
                            <?php foreach ($recentActivity as $act): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($act['equipment_name']); ?></td>
                                    <td><?php echo htmlspecialchars($act['farmer_name']); ?></td>
                                    <td>
                                        <span class="badge <?php 
                                            echo match($act['status']) {
                                                'pending' => 'bg-warning text-dark',
                                                'approved' => 'bg-success',
                                                'rejected' => 'bg-danger',
                                                'completed' => 'bg-info text-dark',
                                                'cancelled' => 'bg-secondary',
                                                default => 'bg-light'
                                            };
                                        ?>"><?php echo ucfirst($act['status']); ?></span>
                                    </td>
                                    <td><?php echo date('M d', strtotime($act['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted">No recent activity.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
