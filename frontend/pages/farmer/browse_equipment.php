<?php
// frontend/pages/farmer/browse_equipment.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

// Search logic
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM equipment WHERE is_available = 1";
$params = [];

if ($search) {
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$equipment_list = $stmt->fetchAll();
?>

<div class="row mb-4">
    <div class="col-md-6">
        <h2>Available Equipment</h2>
    </div>
    <div class="col-md-6">
        <form action="" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search equipment..."
                value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-outline-success">Search</button>
        </form>
    </div>
</div>

<div class="row">
    <?php if (count($equipment_list) > 0): ?>
        <?php foreach ($equipment_list as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($item['image_url']): ?>
                        <img src="/agriculture-equipment-rental/<?php echo htmlspecialchars($item['image_url']); ?>"
                            class="card-img-top" alt="Equipment" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                            style="height: 200px;">No Image</div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </h5>
                        <p class="card-text text-truncate">
                            <?php echo htmlspecialchars($item['description']); ?>
                        </p>
                        <p class="text-primary fw-bold">₹
                            <?php echo number_format($item['price_per_day'], 2); ?> / day
                        </p>
                    </div>
                    <div class="card-footer">
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'farmer'): ?>
                            <a href="book_equipment.php?id=<?php echo $item['id']; ?>" class="btn btn-success w-100">Book Now</a>
                        <?php elseif (!isset($_SESSION['user_id'])): ?>
                            <a href="../auth/login.php" class="btn btn-outline-primary w-100">Login to Book</a>
                        <?php else: ?>
                            <button class="btn btn-secondary w-100" disabled>Owner View Only</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center">
            <p class="text-muted">No equipment found matching your search.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>