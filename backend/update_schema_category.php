<?php
// backend/update_schema_category.php
require_once 'config/db.php';

try {
    // Check if column exists
    $check = $pdo->query("SHOW COLUMNS FROM equipment LIKE 'category'");

    if ($check->rowCount() == 0) {
        $sql = "ALTER TABLE equipment ADD COLUMN category VARCHAR(50) NOT NULL DEFAULT 'other' AFTER description";
        $pdo->exec($sql);
        echo "Successfully added 'category' column to equipment table.";
    } else {
        echo "'category' column already exists.";
    }

} catch (PDOException $e) {
    echo "Error updating table: " . $e->getMessage();
}
?>