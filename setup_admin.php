<?php
require_once 'backend/config/db.php';

$email = 'admin@aers.com';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

// Check if admin exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    // Update existing
    $stmt = $pdo->prepare("UPDATE users SET password_hash = ?, role = 'admin' WHERE email = ?");
    if ($stmt->execute([$hash, $email])) {
        echo "Admin user updated successfully.<br>";
    } else {
        echo "Error updating admin user.<br>";
    }
} else {
    // Insert new
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute(['System Admin', $email, $hash, '0000000000', 'Admin HQ', 'admin'])) {
        echo "Admin user created successfully.<br>";
    } else {
        echo "Error creating admin user.<br>";
    }
}

echo "Email: $email<br>";
echo "Password: $password<br>";
echo "<a href='frontend/pages/auth/login.php'>Go to Login</a>";
?>