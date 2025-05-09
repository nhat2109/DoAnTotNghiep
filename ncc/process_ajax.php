<?php
session_start();
include '../includes/tlca_world.php';
//nhathem104
// Load necessary classes
$class_index = $tlca_do->load('class_ncc');

// Verify user is logged in
if (!isset($_COOKIE['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

// Get action from request
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle different actions
switch ($action) {
    case 'get_huyen':
        $tinh = isset($_GET['tinh']) ? intval($_GET['tinh']) : 0;
        if ($tinh > 0) {
            echo $class_index->list_option_huyen($conn, $tinh, 0);
        } else {
            echo '';
        }
        break;
        
    case 'get_xa':
        $huyen = isset($_GET['huyen']) ? intval($_GET['huyen']) : 0;
        if ($huyen > 0) {
            echo $class_index->list_option_xa($conn, $huyen, 0);
        } else {
            echo '';
        }
        break;
        
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
} 