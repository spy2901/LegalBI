<?php

session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/layout_manager.php';

header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$username = $_SESSION['username'];
$action = $_GET['action'] ?? '';

if ($action === 'save') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['layout'])) {
        echo json_encode(["error" => "Invalid layout data"]);
        exit;
    }
    
    if (saveUserLayout($conn, $username, $data['layout'])) {
        echo json_encode(["success" => true, "message" => "Layout saved"]);
    } else {
        echo json_encode(["error" => "Failed to save layout"]);
    }
} elseif ($action === 'get') {
    $layout = getUserLayout($conn, $username);
    echo json_encode(["layout" => $layout]);
} elseif ($action === 'reset') {
    if (resetLayout($conn, $username)) {
        echo json_encode(["success" => true, "message" => "Layout reset"]);
    } else {
        echo json_encode(["error" => "Failed to reset layout"]);
    }
} else {
    echo json_encode(["error" => "Invalid action"]);
}
