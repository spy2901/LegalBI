<?php
require_once __DIR__ . '/../config/db.php';

// Get user's saved layout
function getUserLayout($conn, $username) {
    $sql = "SELECT layout_data FROM user_layouts WHERE username = ? ORDER BY created_at DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return json_decode($row['layout_data'], true);
    }
    return null;
}

// Save user's layout
function saveUserLayout($conn, $username, $layoutData) {
    // Check if layout exists
    $sql = "SELECT id FROM user_layouts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $layoutJson = json_encode($layoutData);
    
    if ($result->num_rows > 0) {
        // Update existing
        $sql = "UPDATE user_layouts SET layout_data = ?, updated_at = NOW() WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $layoutJson, $username);
    } else {
        // Insert new
        $sql = "INSERT INTO user_layouts (username, layout_data, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $layoutJson);
    }
    
    return $stmt->execute();
}

// Reset to default layout
function resetLayout($conn, $username) {
    $sql = "DELETE FROM user_layouts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    return $stmt->execute();
}
