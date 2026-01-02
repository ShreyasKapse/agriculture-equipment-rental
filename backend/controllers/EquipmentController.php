<?php
// backend/controllers/EquipmentController.php
require_once __DIR__ . '/../models/Equipment.php';

class EquipmentController
{
    private $equipmentModel;

    public function __construct($pdo)
    {
        $this->equipmentModel = new Equipment($pdo);
    }

    public function add($postData, $fileData, $ownerId)
    {
        $name = trim($postData['name']);
        $category = $postData['category'] ?? 'other';
        $description = trim($postData['description']);
        $price = $postData['price'];

        $debugMsg = '';
        $imageUrl = $this->handleImageUpload($fileData['image'], $debugMsg);

        if ($imageUrl === false)
            $imageUrl = null;

        if ($this->equipmentModel->create($ownerId, $name, $category, $description, $price, $imageUrl)) {
            header("Location: ../../frontend/pages/owner/my_equipment.php?msg=added");
            exit;
        } else {
            echo "Error adding equipment.";
        }
    }

    public function edit($postData, $fileData, $ownerId)
    {
        $id = $postData['equipment_id'];
        $name = trim($postData['name']);
        $category = $postData['category'] ?? 'other';
        $description = trim($postData['description']);
        $price = $postData['price'];

        // Verify ownership first
        $item = $this->equipmentModel->findById($id);
        if (!$item || $item['owner_id'] != $ownerId) {
            die("Access Denied");
        }

        $debugMsg = '';
        $imageUrl = $this->handleImageUpload($fileData['image'], $debugMsg);

        if ($this->equipmentModel->update($id, $ownerId, $name, $category, $description, $price, $imageUrl)) {
            header("Location: ../../frontend/pages/owner/my_equipment.php?msg=updated");
            exit;
        } else {
            echo "Error updating equipment.";
        }
    }

    public function delete($postData, $ownerId)
    {
        $id = $postData['equipment_id'];
        if ($this->equipmentModel->delete($id, $ownerId)) {
            header("Location: ../../frontend/pages/owner/my_equipment.php?msg=deleted");
            exit;
        } else {
            echo "Error deleting equipment.";
        }
    }

    private function handleImageUpload($file, &$errorLog)
    {
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . basename($file['name']);
            $targetPath = $uploadDir . $fileName;

            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    return 'uploads/' . $fileName;
                }
            }
        }
        return false;
    }
}
?>