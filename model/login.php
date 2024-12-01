<?php
session_start();
require_once '../includes/config.php';
require_once '../controller/login.php';


$loginObj = new LoginClass($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Set header for JSON response
    header("Content-Type: application/json");

    // Initialize response array
    $response = array();

    $email = filter_input(INPUT_POST, 'loginEmail', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'loginPassword', FILTER_SANITIZE_STRING);

    if (empty($email) || empty($password)) {
        $response["success"] = false;
        $response["message"] = "Email and password are required.";
    } 
        // Authenticate user by user type, email, and password
        $user = $loginObj->authenticateUser($email, $password);

        if ($user !== false) {
            $response["success"] = true;
            $response["message"] = "Login successful.";
            $response["user"] = $user['user_type']; // Consider using a redirect URL instead
        } else {
            $response["success"] = false;
            $response["message"] = "Incorrect email or password. Please try again.";
        }
    

    // Send JSON response back to the client
    echo json_encode($response);
    exit(); // Exit after sending the response
}

?>
