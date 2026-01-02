<?php
// backend/models/User.php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function register($fullName, $email, $password, $phone, $address, $role)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (full_name, email, password_hash, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$fullName, $email, $hash, $phone, $address, $role]);
    }

    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return false;
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT full_name, email, phone, address, role FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateProfile($id, $phone, $address, $password = null)
    {
        if ($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE users SET phone = ?, address = ?, password_hash = ? WHERE id = ?");
            return $stmt->execute([$phone, $address, $hash, $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE users SET phone = ?, address = ? WHERE id = ?");
            return $stmt->execute([$phone, $address, $id]);
        }
    }
}
?>