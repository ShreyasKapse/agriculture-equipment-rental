<?php
// frontend/pages/admin/all_bookings.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit;
}

// Fetch all bookings with details
$sql = "
    SELECT b.*, e.name as equipment_name, u.full_name as farmer_name, o.full_name as owner_name
    FROM bookings b
    JOIN equipment e ON b.equipment_id = e.id
    JOIN users u ON b.farmer_id = u.id
    JOIN users o ON e.owner_id = o.id
    ORDER BY b.created_at DESC
";
$stmt = $pdo->query($sql);
$bookings = $stmt->fetchAll();
?>

<h2>All System Bookings</h2>

<div class="table-responsive mt-3">
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>Equipment</th>
                <th>Farmer (Borrower)</th>
                <th>Owner (Lender)</th>
                <th>Dates</th>
                <th>Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($b['equipment_name']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($b['farmer_name']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($b['owner_name']); ?>
                    </td>
                    <td>
                        <?php echo $b['start_date']; ?> to
                        <?php echo $b['end_date']; ?>
                    </td>
                    <td>₹
                        <?php echo number_format($b['total_price'], 2); ?>
                    </td>
                    <td>
                        <span
                            class="badge <?php echo $b['status'] == 'approved' ? 'bg-success' : ($b['status'] == 'rejected' ? 'bg-danger' : 'bg-warning text-dark'); ?>">
                            <?php echo ucfirst($b['status']); ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../../includes/footer.php'; ?>