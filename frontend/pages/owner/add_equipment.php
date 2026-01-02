<?php
// frontend/pages/owner/add_equipment.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
    header("Location: ../../../index.php");
    exit;
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">Add New Equipment</div>
            <div class="card-body">
                <form action="../../../backend/controllers/equipment_actions.php" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-select" required>
                            <option value="tractors">Tractors</option>
                            <option value="harvesters">Harvesters</option>
                            <option value="seeders">Seeders</option>
                            <option value="irrigation">Irrigation</option>
                            <option value="trailers">Trailers</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Equipment Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Price Per Day (₹)</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label>Equipment Image</label>
                        <input type="file" name="image" class="form-control" appcept="image/*">
                        <small class="text-muted">Allowed: JPG, PNG. Max size 2MB.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Equipment</button>
                    <a href="my_equipment.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>