<?php
session_start();
require_once '../includes/config.php';
require_once '../controller/login.php';

const ENCRYPTION_KEY = 'P@_#1234';
const ALLOWED_CHARACTERS_PATTERN = '/^[a-zA-Z0-9@!#$%^&*()_+{}\[\]:;<>,.?~\/\\-]+$/';

$loginObj = new LoginClass($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Set header for JSON response
    header("Content-Type: application/json");

    // Initialize response array
    $response = array();

    // Sanitize and validate inputs
    $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'loginEmail', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'loginPassword', FILTER_SANITIZE_STRING);

    if (empty($email) || empty($password)) {
        $response["success"] = false;
        $response["message"] = "Email and password are required.";
    } elseif (!preg_match(ALLOWED_CHARACTERS_PATTERN, $email)) {
        $response["success"] = false;
        $response["message"] = "Invalid characters in the email.";
    } else {
        // Authenticate user by user type, email, and password
        $user = $loginObj->authenticateUser($email, $password, $userType);

        if ($user !== false) {
            $response["success"] = true;
            $response["message"] = "Login successful.";
            $response["user"] = $user['user_type']; // Consider using a redirect URL instead
        } else {
            $response["success"] = false;
            $response["message"] = "Incorrect email or password. Please try again.";
        }
    }

    // Send JSON response back to the client
    echo json_encode($response);
    exit(); // Exit after sending the response
}

?>
