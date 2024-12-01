<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';


// Check if the user ID is provided via GET request
if(isset($_GET['userId'])) {
    // Sanitize user ID
    $userId = intval($_GET['userId']);

    try {
        $userClass = new UsersClass($conn);
        $result = $userClass->deleteUser($userId);

        if($result) {
            // User deleted successfully
            http_response_code(200);
            echo json_encode(array("message" => "User deleted successfully"));
        } else {
            // Failed to delete user
            http_response_code(500);
            echo json_encode(array("error" => "Failed to delete user"));
        }
    } catch (Exception $e) {
        // Handle any exceptions
        http_response_code(500);
        echo json_encode(array("error" => "Exception: " . $e->getMessage()));
    }
} else {
    // Handle if user ID is not provided
    http_response_code(400);
    echo json_encode(array("error" => "User ID not provided"));
}
?>
