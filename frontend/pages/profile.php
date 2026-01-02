<?php
// frontend/pages/profile.php
require_once '../../backend/config/db.php';
require_once '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT full_name, email, phone, address, role FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">My Profile</h4>
            </div>
            <div class="card-body">
                <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
                    <div class="alert alert-success">Profile updated successfully!</div>
                <?php endif; ?>

                <form action="../../backend/controllers/user_actions.php" method="POST">
                    <input type="hidden" name="action" value="update_profile">

                    <div class="mb-3">
                        <label class="form-label text-muted">Full Name (Read Only)</label>
                        <input type="text" class="form-control bg-light"
                            value="<?php echo htmlspecialchars($user['full_name']); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Email (Read Only)</label>
                        <input type="email" class="form-control bg-light"
                            value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Role</label>
                        <input type="text" class="form-control bg-light" value="<?php echo ucfirst($user['role']); ?>"
                            readonly>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control"
                            value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control"
                            rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password (Optional)</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Leave blank to keep current password">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>