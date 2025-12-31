<?php
// backend/controllers/equipment_actions.php
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure user is logged in and is an owner
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
    die("Access Denied");
}

$action = $_POST['action'] ?? '';

// Helper to handle uploads
function handleImageUpload($file, &$errorLog)
{
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                $errorLog = "Failed to create directory: $uploadDir";
                return false;
            }
        }
        $fileName = time() . '_' . basename($file['name']);
        $targetPath = $uploadDir . $fileName;

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                return 'uploads/' . $fileName; // Relative path for DB
            } else {
                $errorLog = "Move failed: " . $file['tmp_name'] . " to " . $targetPath;
                return false;
            }
        } else {
            $errorLog = "Invalid extension: " . $ext;
            return false;
        }
    } else {
        if (isset($file)) {
            $errorLog = "Upload error code: " . $file['error'];
        }
        return false;
    }
}

if ($action === 'add') {
    $owner_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];

    $debugMsg = '';
    $image_url = handleImageUpload($_FILES['image'], $debugMsg);

    if ($debugMsg) {
        file_put_contents(__DIR__ . '/debug_log.txt', date('Y-m-d H:i:s') . " - Add: " . $debugMsg . "\n", FILE_APPEND);
    }

    // If upload failed or no image, ensure it is empty string or NULL? DB allow NULL? 
    // Schema says VARCHAR(255), defaults to NULL usually if not set "NOT NULL". 
    // "image_url VARCHAR(255)" implies nullable.
    if ($image_url === false)
        $image_url = null;

    $stmt = $pdo->prepare("INSERT INTO equipment (owner_id, name, description, image_url, price_per_day) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$owner_id, $name, $description, $image_url, $price])) {
        header("Location: ../../frontend/pages/owner/my_equipment.php?msg=added");
    } else {
        echo "Error adding equipment.";
    }

} elseif ($action === 'delete') {
    $equipment_id = $_POST['equipment_id'];
    $owner_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM equipment WHERE id = ? AND owner_id = ?");
    if ($stmt->execute([$equipment_id, $owner_id])) {
        header("Location: ../../frontend/pages/owner/my_equipment.php?msg=deleted");
    } else {
        echo "Error deleting equipment.";
    }

} elseif ($action === 'edit') {
    $equipment_id = $_POST['equipment_id'];
    $owner_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];

    // Verify ownership
    $stmt = $pdo->prepare("SELECT id FROM equipment WHERE id = ? AND owner_id = ?");
    $stmt->execute([$equipment_id, $owner_id]);
    if (!$stmt->fetch()) {
        die("Access Denied");
    }

    $sql = "UPDATE equipment SET name = ?, description = ?, price_per_day = ?";
    $params = [$name, $description, $price];

    $debugMsg = '';
    $new_image_url = handleImageUpload($_FILES['image'], $debugMsg);

    if ($debugMsg && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        file_put_contents(__DIR__ . '/debug_log.txt', date('Y-m-d H:i:s') . " - Edit: " . $debugMsg . "\n", FILE_APPEND);
    }

    if ($new_image_url) {
        $sql .= ", image_url = ?";
        $params[] = $new_image_url;
    }

    $sql .= " WHERE id = ?";
    $params[] = $equipment_id;

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
        header("Location: ../../frontend/pages/owner/my_equipment.php?msg=updated");
    } else {
        echo "Error updating equipment.";
    }
}
?>