<?php
// Database migration script to create user_layouts table
require_once '../config/db.php';

$sql = "CREATE TABLE IF NOT EXISTS user_layouts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    layout_data JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($conn->query($sql) === TRUE) {
    echo "✓ user_layouts table created successfully";
} else {
    echo "✗ Error creating table: " . $conn->error;
}

$conn->close();
?>
