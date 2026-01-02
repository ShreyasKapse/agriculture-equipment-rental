<?php
// backend/models/Booking.php

class Booking
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($equipmentId, $farmerId, $startDate, $endDate, $totalPrice)
    {
        $stmt = $this->pdo->prepare("INSERT INTO bookings (equipment_id, farmer_id, start_date, end_date, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        return $stmt->execute([$equipmentId, $farmerId, $startDate, $endDate, $totalPrice]);
    }

    public function updateStatus($bookingId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $bookingId]);
    }

    public function cancel($bookingId, $farmerId)
    {
        $stmt = $this->pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ? AND farmer_id = ? AND status = 'pending'");
        return $stmt->execute([$bookingId, $farmerId]);
    }

    public function getByFarmer($farmerId)
    {
        $stmt = $this->pdo->prepare("
            SELECT b.*, e.name as equipment_name, e.image_url, r.rating, r.id as review_id
            FROM bookings b 
            JOIN equipment e ON b.equipment_id = e.id 
            LEFT JOIN reviews r ON b.id = r.booking_id
            WHERE b.farmer_id = ? 
            ORDER BY b.created_at DESC
        ");
        $stmt->execute([$farmerId]);
        return $stmt->fetchAll();
    }

    public function getByOwner($ownerId)
    {
        $stmt = $this->pdo->prepare("
            SELECT b.*, e.name as equipment_name, u.full_name as farmer_name, u.phone as farmer_phone
            FROM bookings b
            JOIN equipment e ON b.equipment_id = e.id
            JOIN users u ON b.farmer_id = u.id
            WHERE e.owner_id = ?
            ORDER BY b.created_at DESC
        ");
        $stmt->execute([$ownerId]);
        return $stmt->fetchAll();
    }

    public function getById($bookingId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$bookingId]);
        return $stmt->fetch();
    }
}
?>