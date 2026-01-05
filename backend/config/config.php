<?php
// backend/config/config.php

// Define the Base URL
// If APP_URL is set in environment (e.g., Render/Railway), use it.
// Otherwise, fallback to the local XAMPP path.
// Note: In production (cloud), this should likely be empty string '' or just '/' if at root.
// But valid URL prefixes are also fine.

$baseUrl = getenv('APP_URL');

if ($baseUrl === false) {
    // Auto-detect environment
    if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
        // Localhost: keeps the subfolder path
        $baseUrl = '/agriculture-equipment-rental';
    } else {
        // Production (InfinityFree/Shared Hosting): assumes site is at root
        $baseUrl = '';
    }
}

define('BASE_URL', $baseUrl);
?>