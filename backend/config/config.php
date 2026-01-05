<?php
// backend/config/config.php

// Define the Base URL
// If APP_URL is set in environment (e.g., Render/Railway), use it.
// Otherwise, fallback to the local XAMPP path.
// Note: In production (cloud), this should likely be empty string '' or just '/' if at root.
// But valid URL prefixes are also fine.

$baseUrl = getenv('APP_URL');

if ($baseUrl === false) {
    // Localhost fallback
    $baseUrl = '/agriculture-equipment-rental';
}

define('BASE_URL', $baseUrl);
?>