<?php
require_once '../includes/config.php'; // Your database configuration
require_once '../controller/change pass.php'; // Your custom functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token']);
    $newPassword = trim($_POST['newPassword']);

    // Check if the token and new password are provided
    if (empty($token) || empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Token and password are required.']);
        exit;
    }

    $changePass = new ChangePassClass($conn);
    $success = $changePass->resetPassword($token, $newPassword);

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Your password has been reset successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid or expired token.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

