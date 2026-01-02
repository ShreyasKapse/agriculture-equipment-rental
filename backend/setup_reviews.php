<?php
// backend/setup_reviews.php
require_once 'config/db.php';

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        booking_id INT NOT NULL,
        rating INT CHECK (rating >= 1 AND rating <= 5),
        comment TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
        UNIQUE KEY unique_booking_review (booking_id)
    );
    ";

    $pdo->exec($sql);
    echo "Reviews table created successfully or already exists.";

} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>
