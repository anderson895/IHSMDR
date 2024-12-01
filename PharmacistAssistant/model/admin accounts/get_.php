<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

if(isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $SettingsClass = new SettingsClass($conn);
    $userData = $SettingsClass->getUserById($userId);
    if($userData) {
        // Return user data as JSON response
        header('Content-Type: application/json');
        echo json_encode($userData);
    } else {
        // Handle if user with provided ID not found
        echo "User not found";
    }
} else {
    // Handle if user ID is not provided
    echo "User ID not provided";
}
?>
