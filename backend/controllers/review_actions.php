<?php
// backend/controllers/review_actions.php
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Access Control: Only Farmers can review
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'farmer') {
    die("Access Denied.");
}

$action = $_POST['action'] ?? '';

if ($action === 'add_review') {
    $farmer_id = $_SESSION['user_id'];
    $booking_id = $_POST['booking_id'];
    $rating = (int) $_POST['rating'];
    $comment = trim($_POST['comment']);

    if ($rating < 1 || $rating > 5) {
        die("Invalid rating.");
    }

    // 1. Verify that the booking belongs to this farmer and is completed
    $stmt = $pdo->prepare("SELECT id, status FROM bookings WHERE id = ? AND farmer_id = ?");
    $stmt->execute([$booking_id, $farmer_id]);
    $booking = $stmt->fetch();

    if (!$booking) {
        die("Booking not found or access denied.");
    }

    if ($booking['status'] !== 'completed') {
        die("You can only review completed bookings.");
    }

    // 2. Check if a review already exists
    $stmt = $pdo->prepare("SELECT id FROM reviews WHERE booking_id = ?");
    $stmt->execute([$booking_id]);
    if ($stmt->fetch()) {
        die("You have already reviewed this booking.");
    }

    // 3. Insert Review
    $stmt = $pdo->prepare("INSERT INTO reviews (booking_id, rating, comment) VALUES (?, ?, ?)");
    if ($stmt->execute([$booking_id, $rating, $comment])) {
        header("Location: ../../frontend/pages/farmer/my_bookings.php?msg=review_added");
    } else {
        echo "Error adding review.";
    }
}
?>