<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';


$UserClass = new UsersClass($conn);
$response = array(); // Initialize response array

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email'])&& isset($_POST['password'])&& isset($_POST['userType'])) {
        // Retrieve form data
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $userType = $_POST['userType'];

        // Check if email already exists
        if ($UserClass->checkDuplicateEmail($email)) {
            // Email already exists, send error response
            http_response_code(400);
            echo json_encode(array("error" => "Email already exists"));
            exit; // Terminate script execution
        }
        // Insert data into the database
        if ($UserClass->addUser($firstName, $lastName, $email,$password,$userType)) {
            // Success message
            $response['status'] = 'success';
            $response['message'] = 'User added successfully';
            
            http_response_code(200);
            echo json_encode(array("message" => "User added successfully"));

        } else {
            // Error message if user insertion fails
            http_response_code(500);
            echo json_encode(array("error" => "Failed to added user"));
        }
    } 
}
?>
