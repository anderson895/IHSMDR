<?php

define('DEFAULT_ENCRYPTION_KEY', 'P@_#1234');

function generateSalt() {
    return random_bytes(16);
}

function encryptText($text, $key, $salt) {
    $saltedText = $salt . $text;
    return base64_encode(openssl_encrypt($saltedText, 'aes-256-cbc', $key, 0, $salt));
}

function decryptText($encryptedText, $key, $salt) {
    $saltedText = openssl_decrypt(base64_decode($encryptedText), 'aes-256-cbc', $key, 0, $salt);
    return substr($saltedText, 16); // Removing the salt
}

class LoginClass {
    private $conn;
    private $encryptionKey;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->encryptionKey = DEFAULT_ENCRYPTION_KEY;  // Use constant for encryption key
    }

    public function generateSalt() {
        return random_bytes(16);
    }

    public function encryptEmail($email, $salt) {
        return encryptText($email, $this->encryptionKey, $salt);
    }

    public function decryptEmail($encryptedEmail, $salt) {
        return decryptText($encryptedEmail, $this->encryptionKey, $salt);
    }

    public function encryptPassword($password, $salt) {
        return encryptText($password, $this->encryptionKey, $salt);
    }

    public function decryptPassword($encryptedPassword, $salt) {
        return decryptText($encryptedPassword, $this->encryptionKey, $salt);
    }

    public function authenticateUser($email, $password) {
        return $this->authenticateUserByType($email, $password);
    }

    private function authenticateUserByType($email, $password) {
        // Generate a salt for encryption, the same one used during user creation
        $salt = generateSalt();

        // Encrypt the user-provided email using the same method
        $encryptedEmail = $this->encryptEmail($email, $salt);

        // Prepare statement to check for the specific user_type
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $encryptedEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if email exists
        if ($row = $result->fetch_assoc()) {
            $decryptedEmail = $this->decryptEmail($row['email'], $salt);

            if ($email === $decryptedEmail) {
                $hashedPassword = $row['password'];  // Encrypted password stored in DB
                $decryptedPassword = $this->decryptPassword($hashedPassword, $salt);

                if ($password === $decryptedPassword) {
                    // Store the user's session details
                    $_SESSION["role"] = $row["user_type"];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['name'] = $row['firstName'].' '.$row['lastName'];
                    return $row;  // User authenticated successfully
                }
            }
        }

        return false;  // Invalid credentials
    }
}
?>
