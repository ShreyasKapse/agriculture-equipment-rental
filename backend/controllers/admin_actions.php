<?php
// backend/controllers/admin_actions.php
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security Check: Only Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    die("Access Denied");
}

$action = $_POST['action'] ?? '';

if ($action === 'delete_user') {
    $user_id = $_POST['user_id'];

    // Prevent self-deletion
    if ($user_id == $_SESSION['user_id']) {
        die("Cannot delete your own admin account.");
    }

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$user_id])) {
        // Deleting user cascades to equipment/bookings via DB constraints usually
        // But our schema declared FOREIGN KEY ... ON DELETE CASCADE, so safe.
        header("Location: ../../frontend/pages/admin/manage_users.php?msg=deleted");
    } else {
        echo "Error deleting user.";
    }
}
?>