<?php

class LoginClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticateUser($email, $password, $user_type) {
        return $this->authenticateUserByType($email, $password, $user_type);
    }

    private function authenticateUserByType($email, $password, $user_type) {
        // Prepare statement to check for the specific user_type
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_type = ?");
        $stmt->bind_param("s", $user_type);
        $stmt->execute();
        $result = $stmt->get_result();

        define('DEFAULT_ENCRYPTION_KEY', 'P@_#1234');

        function generateSalt() {
            return random_bytes(16);
        }

        function decryptText($encryptedText, $key, $salt) {
            $saltedText = openssl_decrypt(base64_decode($encryptedText), 'aes-256-cbc', $key, 0, $salt);
            return substr($saltedText, 16);
        }

        $encryptionKey = isset($_POST['key']) ? $_POST['key'] : DEFAULT_ENCRYPTION_KEY;
        $salt = generateSalt();

        // Iterate through the results and check email and password
        while ($row = $result->fetch_assoc()) {
            $encryptedEmail = $row['email'];
            $decryptedEmail = decryptText($encryptedEmail, $encryptionKey, $salt);

            if ($email === $decryptedEmail) {
                $hashedPassword = $row['password'];
                $decryptedPassword = decryptText($hashedPassword, $encryptionKey, $salt);

                if ($password === $decryptedPassword) {
                    // Store the user's session details
                    $_SESSION["role"] = $row["user_type"];
                    $_SESSION['user_id'] = $row['user_id'];  // Assuming user_id as the primary key in the users table
                    $_SESSION['name'] = $row['firstName'].' '.$row['lastName']; // Assuming user_id as the primary key in the users table
                    return $row;
                }
            }
        }

        return false;
    }
}

?>
