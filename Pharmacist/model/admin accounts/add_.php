<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

$SettingsClass = new SettingsClass($conn);

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the necessary parameters are set
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user_type'])) {
        // Sanitize input data
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];

        // Call the addUser method to add the new user
        if ($SettingsClass->addUser($firstName, $lastName, $email, $password, $user_type)) {
            // Respond with success message
            http_response_code(200);
            echo json_encode(array("message" => "User added successfully"));
        } else {
            // Respond with error message if the addition failed
            http_response_code(500);
            echo json_encode(array("error" => "Failed to add user"));
        }
    } else {
        // Respond with error message if required parameters are missing
        $response = array("error" => "Missing parameters");
        echo json_encode($response);
    }
} else {
    // Respond with error message if the request method is not POST
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request method"));
}
?>
