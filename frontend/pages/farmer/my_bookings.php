<?php
// frontend/pages/farmer/my_bookings.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'farmer') {
    header("Location: ../../../index.php");
    exit;
}

$farmer_id = $_SESSION['user_id'];
// Join with equipment to get name
$stmt = $pdo->prepare("
    SELECT b.*, e.name as equipment_name, e.image_url 
    FROM bookings b 
    JOIN equipment e ON b.equipment_id = e.id 
    WHERE b.farmer_id = ? 
    ORDER BY b.created_at DESC
");
$stmt->execute([$farmer_id]);
$bookings = $stmt->fetchAll();
?>

<h2>My Bookings</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'booked'): ?>
    <div class="alert alert-success">Booking request sent successfully! Wait for owner approval.</div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Equipment</th>
                <th>Dates</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Date Booked</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($bookings) > 0): ?>
                <?php foreach ($bookings as $b): ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php if ($b['image_url']): ?>
                                    <img src="/agriculture-equipment-rental/<?php echo htmlspecialchars($b['image_url']); ?>"
                                        width="50" class="me-2 rounded">
                                <?php endif; ?>
                                <?php echo htmlspecialchars($b['equipment_name']); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo $b['start_date']; ?> to
                            <?php echo $b['end_date']; ?>
                        </td>
                        <td>₹
                            <?php echo number_format($b['total_price'], 2); ?>
                        </td>
                        <td>
                            <?php
                            $badgeClass = match ($b['status']) {
                                'approved' => 'bg-success',
                                'rejected' => 'bg-danger',
                                'pending' => 'bg-warning text-dark',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>">
                                <?php echo ucfirst($b['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php echo date('d M Y', strtotime($b['created_at'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No bookings found. <a href="browse_equipment.php">Browse
                            Equipment</a> to book.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once '../../includes/footer.php'; ?>