<?php
// backend/models/Equipment.php

class Equipment
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($ownerId, $name, $category, $description, $price, $imageUrl)
    {
        $stmt = $this->pdo->prepare("INSERT INTO equipment (owner_id, name, category, description, price_per_day, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$ownerId, $name, $category, $description, $price, $imageUrl]);
    }

    public function update($id, $ownerId, $name, $category, $description, $price, $imageUrl = null)
    {
        $sql = "UPDATE equipment SET name = ?, category = ?, description = ?, price_per_day = ?";
        $params = [$name, $category, $description, $price];

        if ($imageUrl) {
            $sql .= ", image_url = ?";
            $params[] = $imageUrl;
        }

        $sql .= " WHERE id = ? AND owner_id = ?";
        $params[] = $id;
        $params[] = $ownerId;

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id, $ownerId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM equipment WHERE id = ? AND owner_id = ?");
        return $stmt->execute([$id, $ownerId]);
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM equipment WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function search($searchTerm = '', $category = 'all')
    {
        $sql = "SELECT e.*, AVG(r.rating) as avg_rating, COUNT(r.id) as review_count 
                FROM equipment e
                LEFT JOIN bookings b ON e.id = b.equipment_id
                LEFT JOIN reviews r ON b.id = r.booking_id
                WHERE e.is_available = 1";

        $params = [];

        if ($searchTerm) {
            $sql .= " AND (e.name LIKE ? OR e.description LIKE ?)";
            $params[] = "%$searchTerm%";
            $params[] = "%$searchTerm%";
        }

        if ($category !== 'all') {
            $sql .= " AND e.category = ?";
            $params[] = $category;
        }

        $sql .= " GROUP BY e.id ORDER BY e.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getByOwner($ownerId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM equipment WHERE owner_id = ? ORDER BY created_at DESC");
        $stmt->execute([$ownerId]);
        return $stmt->fetchAll();
    }
}
?>