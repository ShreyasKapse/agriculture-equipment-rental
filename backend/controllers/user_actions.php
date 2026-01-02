<?php
// backend/controllers/user_actions.php
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("Access Denied");
}

$action = $_POST['action'] ?? '';

if ($action === 'update_profile') {
    $user_id = $_SESSION['user_id'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password']; // Optional

    try {
        if (!empty($password)) {
            // Update with password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET phone = ?, address = ?, password_hash = ? WHERE id = ?");
            $params = [$phone, $address, $hashed_password, $user_id];
        } else {
            // Update without password
            $stmt = $pdo->prepare("UPDATE users SET phone = ?, address = ? WHERE id = ?");
            $params = [$phone, $address, $user_id];
        }

        if ($stmt->execute($params)) {
            header("Location: ../../frontend/pages/profile.php?msg=updated");
        } else {
            die("Error updating profile.");
        }

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>