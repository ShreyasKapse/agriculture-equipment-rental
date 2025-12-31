<?php
// backend/controllers/booking_actions.php
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$action = $_POST['action'] ?? '';

if ($action === 'create') {
    // Farmer creating a booking
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'farmer') {
        die("Access Denied. Only farmers can book.");
    }

    $farmer_id = $_SESSION['user_id'];
    $equipment_id = $_POST['equipment_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Basic validation
    if ($start_date > $end_date) {
        die("Invalid date range.");
    }

    // Fetch price to calculate total
    $stmt = $pdo->prepare("SELECT price_per_day, owner_id FROM equipment WHERE id = ?");
    $stmt->execute([$equipment_id]);
    $equipment = $stmt->fetch();

    if (!$equipment) {
        die("Equipment not found.");
    }

    // prevent Farmer from booking their own equipment (if they somehow have dual role or logic loop)
    if ($equipment['owner_id'] == $farmer_id) {
        die("You cannot book your own equipment.");
    }

    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $days = $end->diff($start)->days + 1; // Inclusive
    $total_price = $days * $equipment['price_per_day'];

    $stmt = $pdo->prepare("INSERT INTO bookings (equipment_id, farmer_id, start_date, end_date, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')");

    if ($stmt->execute([$equipment_id, $farmer_id, $start_date, $end_date, $total_price])) {
        header("Location: ../../frontend/pages/farmer/my_bookings.php?msg=booked");
    } else {
        echo "Error creating booking.";
    }

} elseif ($action === 'update_status') {
    // Owner approving/rejecting
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'owner') {
        die("Access Denied.");
    }

    $booking_id = $_POST['booking_id'];
    $status = $_POST['status']; // approved or rejected
    $owner_id = $_SESSION['user_id'];

    if (!in_array($status, ['approved', 'rejected'])) {
        die("Invalid status.");
    }

    // Verify that the booking belongs to equipment owned by this user
    $stmt = $pdo->prepare("
        SELECT b.id 
        FROM bookings b 
        JOIN equipment e ON b.equipment_id = e.id 
        WHERE b.id = ? AND e.owner_id = ?
    ");
    $stmt->execute([$booking_id, $owner_id]);

    if ($stmt->fetch()) {
        $updateStmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $updateStmt->execute([$status, $booking_id]);
        header("Location: ../../frontend/pages/owner/manage_bookings.php?msg=updated");
    } else {
        die("Booking not found or access denied.");
    }
}
?>