<?php
// backend/config/db.php

// 1. Try to load production config (manual file on server)
// Create 'prod_config.php' in this same folder on your server with your real credentials
$prodConfigFile = __DIR__ . '/prod_config.php';
if (file_exists($prodConfigFile)) {
    require_once $prodConfigFile;
}

// 2. Fallback: If variables aren't set by prod_config, use Environment or Local defaults
if (!isset($host))
    $host = getenv('DB_HOST') ?: 'localhost';
if (!isset($db_name))
    $db_name = getenv('DB_NAME') ?: 'agriculture_rental_db';
if (!isset($username))
    $username = getenv('DB_USER') ?: 'root';
if (!isset($password))
    $password = getenv('DB_PASS') !== false ? getenv('DB_PASS') : '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>