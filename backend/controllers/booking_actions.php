<?php
// backend/controllers/booking_actions.php
require_once '../config/db.php';
require_once 'BookingController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = new BookingController($pdo);
$action = $_POST['action'] ?? '';

if ($action === 'create') {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'farmer') {
        die("Access Denied. Only farmers can book.");
    }
    $controller->create($_POST, $_SESSION['user_id']);

} elseif ($action === 'update_status') {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
        die("Access Denied.");
    }
    $controller->updateStatus($_POST, $_SESSION['user_id']);

} elseif ($action === 'cancel') {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'farmer') {
        die("Access Denied.");
    }
    $controller->cancel($_POST, $_SESSION['user_id']);

} else {
    echo "Invalid action.";
}
?>