<?php
// backend/controllers/equipment_actions.php
require_once '../config/db.php';
require_once 'EquipmentController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is logged in and is an owner
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
    die("Access Denied");
}

$controller = new EquipmentController($pdo);
$action = $_POST['action'] ?? '';
$owner_id = $_SESSION['user_id'];

if ($action === 'add') {
    $controller->add($_POST, $_FILES, $owner_id);
} elseif ($action === 'edit') {
    $controller->edit($_POST, $_FILES, $owner_id);
} elseif ($action === 'delete') {
    $controller->delete($_POST, $owner_id);
} else {
    echo "Invalid action.";
}
?>