<?php

   error_reporting(0);

   define('DEFAULT_ENCRYPTION_KEY', 'P@_#1234');

   function generateSalt() {
       return random_bytes(16);
   }

   function encryptText($text, $key) {
       $salt = generateSalt();
       $saltedText = $salt . $text;
       return base64_encode(openssl_encrypt($saltedText, 'aes-256-cbc', $key, 0, $salt));
   }

   function decryptText($encryptedText, $key, $salt) {
       $saltedText = openssl_decrypt(base64_decode($encryptedText), 'aes-256-cbc', $key, 0, $salt);
       return substr($saltedText, 16); // Removing the salt
   }



   class ChangePassClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Reset password based on the token and user type
    public function resetPassword($token, $newPassword) {
        $tables = ['citizen', 'manager', 'staff'];

        foreach ($tables as $table) {
            $stmt = $this->conn->prepare("SELECT email, reset_expires_at FROM $table WHERE reset_token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($email, $expires_at);
                $stmt->fetch();

                if (new DateTime() < new DateTime($expires_at)) {
                    // Update password
                    $hashedPassword = encryptText($newPassword, DEFAULT_ENCRYPTION_KEY);
                    $stmt = $this->conn->prepare("UPDATE $table SET password = ?, reset_token = NULL, reset_expires_at = NULL WHERE email = ?");
                    $stmt->bind_param("ss", $hashedPassword, $email);
                    $stmt->execute();
                    return true;
                }
            }
        }
        return false;
    }
}

?>
