<?php
// frontend/pages/owner/edit_equipment.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
    header("Location: ../../../index.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid Request";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM equipment WHERE id = ? AND owner_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$item = $stmt->fetch();

if (!$item) {
    echo "Equipment not found or access denied.";
    exit;
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">Edit Equipment</div>
            <div class="card-body">
                <form action="../../../backend/controllers/equipment_actions.php" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="equipment_id" value="<?php echo $item['id']; ?>">

                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-select" required>
                            <option value="tractors" <?php echo ($item['category'] ?? '') === 'tractors' ? 'selected' : ''; ?>>Tractors</option>
                            <option value="harvesters" <?php echo ($item['category'] ?? '') === 'harvesters' ? 'selected' : ''; ?>>Harvesters</option>
                            <option value="seeders" <?php echo ($item['category'] ?? '') === 'seeders' ? 'selected' : ''; ?>>Seeders</option>
                            <option value="irrigation" <?php echo ($item['category'] ?? '') === 'irrigation' ? 'selected' : ''; ?>>Irrigation</option>
                            <option value="trailers" <?php echo ($item['category'] ?? '') === 'trailers' ? 'selected' : ''; ?>>Trailers</option>
                            <option value="other" <?php echo ($item['category'] ?? '') === 'other' ? 'selected' : ''; ?>>
                                Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Equipment Name</label>
                        <input type="text" name="name" class="form-control"
                            value="<?php echo htmlspecialchars($item['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control"
                            rows="3"><?php echo htmlspecialchars($item['description']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Price Per Day (₹)</label>
                        <input type="number" name="price" class="form-control" step="0.01"
                            value="<?php echo $item['price_per_day']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Current Image</label><br>
                        <?php if ($item['image_url']): ?>
                            <img src="/agriculture-equipment-rental/<?php echo htmlspecialchars($item['image_url']); ?>"
                                width="100" class="mb-2">
                        <?php else: ?>
                            <p>No image uploaded.</p>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Upload to replace existing image.</small>
                    </div>
                    <button type="submit" class="btn btn-warning">Update Equipment</button>
                    <a href="my_equipment.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>