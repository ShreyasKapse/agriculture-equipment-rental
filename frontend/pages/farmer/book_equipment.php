<?php
// frontend/pages/farmer/book_equipment.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'farmer') {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Access Denied. Farmers only.</div></div>";
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid Request";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM equipment WHERE id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();

if (!$item) {
    echo "Equipment not found.";
    exit;
}

// Fetch Reviews
$reviewStmt = $pdo->prepare("
    SELECT r.rating, r.comment, r.created_at, u.full_name 
    FROM reviews r 
    JOIN bookings b ON r.booking_id = b.id 
    JOIN users u ON b.farmer_id = u.id 
    WHERE b.equipment_id = ? 
    ORDER BY r.created_at DESC
");
$reviewStmt->execute([$id]);
$reviews = $reviewStmt->fetchAll();

$avgRating = 0;
if (count($reviews) > 0) {
    $total = 0;
    foreach ($reviews as $rev) {
        $total += $rev['rating'];
    }
    $avgRating = round($total / count($reviews), 1);
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">Book Equipment</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <?php if ($item['image_url']): ?>
                            <img src="<?php echo BASE_URL; ?>/<?php echo htmlspecialchars($item['image_url']); ?>"
                                class="img-fluid rounded mb-3">
                        <?php else: ?>
                            <div class="bg-light text-center py-5 mb-3">No Image</div>
                        <?php endif; ?>
                        <h5>
                            <?php echo htmlspecialchars($item['name']); ?>
                        </h5>
                        <p class="text-muted">
                            <?php echo htmlspecialchars($item['description']); ?>
                        </p>
                        <h4 class="text-primary">₹<span id="pricePerDay">
                                <?php echo $item['price_per_day']; ?>
                            </span> / day</h4>

                        <?php if ($avgRating > 0): ?>
                            <div class="mt-2">
                                <span class="text-warning fs-5">
                                    <?php echo str_repeat('★', floor($avgRating)); ?>
                                    <?php echo ($avgRating - floor($avgRating) >= 0.5) ? '½' : ''; ?>
                                </span>
                                <span class="text-muted small">(<?php echo count($reviews); ?> reviews)</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-7">
                        <form action="../../../backend/controllers/booking_actions.php" method="POST">
                            <input type="hidden" name="action" value="create">
                            <input type="hidden" name="equipment_id" value="<?php echo $item['id']; ?>">

                            <div class="mb-3">
                                <label>Start Date</label>
                                <input type="date" name="start_date" id="startDate" class="form-control" required
                                    min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-3">
                                <label>End Date</label>
                                <input type="date" name="end_date" id="endDate" class="form-control" required
                                    min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <div class="alert alert-info">
                                Total Days: <span id="totalDays">0</span><br>
                                <strong>Total Cost: ₹<span id="totalCost">0</span></strong>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Confirm Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-light">
                <h4 class="mb-0">Reviews (<?php echo count($reviews); ?>)
                    <?php if ($avgRating > 0): ?>
                        <span class="text-warning float-end">
                            <?php echo $avgRating; ?> ★
                        </span>
                    <?php endif; ?>
                </h4>
            </div>
            <div class="card-body">
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $rev): ?>
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($rev['full_name']); ?></h6>
                                <span class="badge bg-light text-dark border">
                                    <?php echo $rev['rating']; ?> <span class="text-warning">★</span>
                                </span>
                            </div>
                            <small class="text-muted d-block mb-2">
                                <?php echo date('d M Y', strtotime($rev['created_at'])); ?>
                            </small>
                            <p class="mb-0"><?php echo htmlspecialchars($rev['comment']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center py-3">No reviews yet. Be the first to rent and review!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    const pricePerDay = <?php echo $item['price_per_day']; ?>;
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const totalDaysSpan = document.getElementById('totalDays');
    const totalCostSpan = document.getElementById('totalCost');

    function calculateCost() {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);

        if (start && end && end >= start) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            totalDaysSpan.textContent = diffDays;
            totalCostSpan.textContent = (diffDays * pricePerDay).toFixed(2);
        } else {
            totalDaysSpan.textContent = 0;
            totalCostSpan.textContent = 0;
        }
    }

    startDateInput.addEventListener('change', calculateCost);
    endDateInput.addEventListener('change', calculateCost);
</script>

<?php require_once '../../includes/footer.php'; ?>