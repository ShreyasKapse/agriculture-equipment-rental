<?php
// frontend/pages/admin/manage_users.php
require_once '../../../backend/config/db.php';
require_once '../../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../../index.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>

<h2>Manage Users</h2>

<?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="alert alert-success">User deleted successfully.</div>
<?php endif; ?>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td>
                        <?php echo $u['id']; ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($u['full_name']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($u['email']); ?>
                    </td>
                    <td>
                        <span
                            class="badge <?php echo $u['role'] == 'admin' ? 'bg-danger' : ($u['role'] == 'owner' ? 'bg-info text-dark' : 'bg-success'); ?>">
                            <?php echo ucfirst($u['role']); ?>
                        </span>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($u['phone']); ?>
                    </td>
                    <td>
                        <?php if ($u['id'] != $_SESSION['user_id']): ?>
                            <form action="../../../backend/controllers/admin_actions.php" method="POST"
                                onsubmit="return confirm('Delete this user? This will also remove their equipment and bookings.');">
                                <input type="hidden" name="action" value="delete_user">
                                <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">(You)</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once '../../includes/footer.php'; ?>