<?php
// frontend/pages/owner/manage_bookings.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
    header("Location: ../../../index.php");
    exit;
}

$owner_id = $_SESSION['user_id'];
// Join bookings with equipment and users (farmer)
$sql = "
    SELECT b.*, e.name as equipment_name, u.full_name as farmer_name, u.phone as farmer_phone
    FROM bookings b
    JOIN equipment e ON b.equipment_id = e.id
    JOIN users u ON b.farmer_id = u.id
    WHERE e.owner_id = ?
    ORDER BY b.created_at DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$owner_id]);
$requests = $stmt->fetchAll();
?>

<h2>Manage Booking Requests</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
    <div class="alert alert-success">Booking status updated!</div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>Equipment</th>
                <th>Farmer</th>
                <th>Dates</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($requests) > 0): ?>
                <?php foreach ($requests as $r): ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($r['equipment_name']); ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($r['farmer_name']); ?><br>
                            <small class="text-muted">
                                <?php echo htmlspecialchars($r['farmer_phone']); ?>
                            </small>
                        </td>
                        <td>
                            <?php echo $r['start_date']; ?> to
                            <?php echo $r['end_date']; ?>
                        </td>
                        <td>₹
                            <?php echo number_format($r['total_price'], 2); ?>
                        </td>
                        <td>
                            <span
                                class="badge <?php echo $r['status'] == 'pending' ? 'bg-warning text-dark' : ($r['status'] == 'approved' ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo ucfirst($r['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($r['status'] === 'pending'): ?>
                                <form action="../../../backend/controllers/booking_actions.php" method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="booking_id" value="<?php echo $r['id']; ?>">
                                    <button type="submit" name="status" value="approved"
                                        class="btn btn-sm btn-success">Approve</button>
                                    <button type="submit" name="status" value="rejected"
                                        class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No booking requests received yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../../includes/footer.php'; ?>