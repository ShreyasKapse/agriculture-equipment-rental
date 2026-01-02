<?php
// backend/controllers/BookingController.php
require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    private $bookingModel;
    private $pdo; // Need pdo for extra queries like fetch price

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->bookingModel = new Booking($pdo);
    }

    public function create($postData, $farmerId)
    {
        $equipmentId = $postData['equipment_id'];
        $startDate = $postData['start_date'];
        $endDate = $postData['end_date'];

        if ($startDate > $endDate) {
            die("Invalid date range.");
        }

        // Calculate Price
        // Ideally this should be in a Service or Model, but doing here for now
        $stmt = $this->pdo->prepare("SELECT price_per_day, owner_id FROM equipment WHERE id = ?");
        $stmt->execute([$equipmentId]);
        $equipment = $stmt->fetch();

        if (!$equipment)
            die("Equipment not found.");
        if ($equipment['owner_id'] == $farmerId)
            die("Cannot book your own equipment.");

        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $days = $end->diff($start)->days + 1;
        $totalPrice = $days * $equipment['price_per_day'];

        if ($this->bookingModel->create($equipmentId, $farmerId, $startDate, $endDate, $totalPrice)) {
            header("Location: ../../frontend/pages/farmer/my_bookings.php?msg=booked");
            exit;
        } else {
            echo "Error creating booking.";
        }
    }

    public function updateStatus($postData, $ownerId)
    {
        $bookingId = $postData['booking_id'];
        $status = $postData['status'];

        if (!in_array($status, ['approved', 'rejected', 'completed'])) {
            die("Invalid status.");
        }

        // Verify ownership via Booking Model or direct query?
        // Detailed verification logic in Model is cleaner, but let's check basic ownership
        // Reuse logic: fetch booking, check equipment owner
        $stmt = $this->pdo->prepare("
            SELECT b.id 
            FROM bookings b 
            JOIN equipment e ON b.equipment_id = e.id 
            WHERE b.id = ? AND e.owner_id = ?
        ");
        $stmt->execute([$bookingId, $ownerId]);
        if (!$stmt->fetch()) {
            die("Access Denied or Booking not found.");
        }

        if ($this->bookingModel->updateStatus($bookingId, $status)) {
            header("Location: ../../frontend/pages/owner/manage_bookings.php?msg=updated");
            exit;
        } else {
            die("Error updating status.");
        }
    }

    public function cancel($postData, $farmerId)
    {
        $bookingId = $postData['booking_id'];
        // Check if pending status is handled in Model (it is)
        // But we should verify it returns row count > 0 ideally, or just try.
        // The model method adds "AND status='pending'"

        // We do a check first to give feedback? 
        // Or blindly call model:
        if ($this->bookingModel->cancel($bookingId, $farmerId)) {
            // We can't easily know if it failed because it wasn't pending or DB error without rowCount
            // But for now redirect
            header("Location: ../../frontend/pages/farmer/my_bookings.php?msg=cancelled");
            exit;
        } else {
            echo "Error cancelling booking.";
        }
    }
}
?>