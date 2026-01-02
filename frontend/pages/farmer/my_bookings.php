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
    SELECT b.*, e.name as equipment_name, e.image_url, r.rating, r.id as review_id,
           u.full_name as owner_name, u.phone as owner_phone, u.address as owner_address
    FROM bookings b 
    JOIN equipment e ON b.equipment_id = e.id 
    JOIN users u ON e.owner_id = u.id
    LEFT JOIN reviews r ON b.id = r.booking_id
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
                <th>Owner Details</th>
                <th>Dates</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Review</th>
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
                                    <strong><?php echo htmlspecialchars($b['owner_name']); ?></strong>
                                    <?php if (in_array($b['status'], ['approved', 'completed'])): ?>
                                            <br>
                                            <small class="text-muted">
                                                📞 <?php echo htmlspecialchars($b['owner_phone']); ?><br>
                                                📍 <?php echo htmlspecialchars($b['owner_address']); ?>
                                            </small>
                                    <?php else: ?>
                                            <br><small class="text-muted fst-italic">Contact info hidden</small>
                                    <?php endif; ?>
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
                                'completed' => 'bg-info text-white',
                                'cancelled' => 'bg-dark text-white',
                                default => 'bg-secondary'
                            };
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>">
                                <?php echo ucfirst($b['status']); ?>
                            </span>

                            <?php if ($b['status'] === 'pending'): ?>
                                <form action="../../../backend/controllers/booking_actions.php" method="POST" class="d-inline ms-2"
                                    onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    <input type="hidden" name="action" value="cancel">
                                    <input type="hidden" name="booking_id" value="<?php echo $b['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger py-0">Cancel</button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($b['status'] === 'completed'): ?>
                                <?php if ($b['review_id']): ?>
                                    <span class="text-warning">
                                        <?php echo str_repeat('★', $b['rating']) . str_repeat('☆', 5 - $b['rating']); ?>
                                    </span>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal"
                                        onclick="setBookingId(<?php echo $b['id']; ?>)">
                                        Rate & Review
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <small class="text-muted">-</small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo date('d M Y', strtotime($b['created_at'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No bookings found. <a href="browse_equipment.php">Browse
                            Equipment</a> to book.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../../../backend/controllers/review_actions.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Rate Equipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_review">
                    <input type="hidden" name="booking_id" id="modalBookingId">

                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select" required>
                            <option value="5">★★★★★ (5 Stars)</option>
                            <option value="4">★★★★☆ (4 Stars)</option>
                            <option value="3">★★★☆☆ (3 Stars)</option>
                            <option value="2">★★☆☆☆ (2 Stars)</option>
                            <option value="1">★☆☆☆☆ (1 Star)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Share your experience..."
                            required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setBookingId(id) {
        document.getElementById('modalBookingId').value = id;
    }
</script>

<?php require_once '../../includes/footer.php'; ?>