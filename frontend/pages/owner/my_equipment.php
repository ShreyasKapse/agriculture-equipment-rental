<?php
// frontend/pages/owner/my_equipment.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
    header("Location: ../../../index.php");
    exit;
}

$owner_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM equipment WHERE owner_id = ? ORDER BY created_at DESC");
$stmt->execute([$owner_id]);
$equipment_list = $stmt->fetchAll();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Equipment</h2>
    <a href="add_equipment.php" class="btn btn-primary">+ Add New</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        <?php
        if ($_GET['msg'] == 'added')
            echo "Equipment added successfully!";
        if ($_GET['msg'] == 'deleted')
            echo "Equipment deleted successfully!";
        ?>
    </div>
<?php endif; ?>

<div class="row">
    <?php if (count($equipment_list) > 0): ?>
        <?php foreach ($equipment_list as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($item['image_url']): ?>
                        <img src="/agriculture-equipment-rental/<?php echo htmlspecialchars($item['image_url']); ?>"
                            class="card-img-top" alt="Equipment Image" style="height: 200px; object-fit: cover;">
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
                        <span class="badge <?php echo $item['is_available'] ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo $item['is_available'] ? 'Available' : 'Rented'; ?>
                        </span>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="edit_equipment.php?id=<?php echo $item['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="../../../backend/controllers/equipment_actions.php" method="POST"
                            onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="equipment_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">You haven't listed any equipment yet.</h4>
            <a href="add_equipment.php" class="btn btn-outline-primary mt-3">Add Your First Machine</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../../includes/footer.php'; ?>