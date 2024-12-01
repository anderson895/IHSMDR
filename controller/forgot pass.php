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


   class ForgotPassClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Check if email exists in any of the three tables
    private function getEmailFromTables($email) {
        $encryptedEmail = encryptText($email, DEFAULT_ENCRYPTION_KEY);
        $tables = ['citizen', 'manager', 'staff'];
        
        foreach ($tables as $table) {
            $stmt = $this->conn->prepare("SELECT email, user_type FROM $table WHERE email = ?");
            $stmt->bind_param("s", $encryptedEmail);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                return ['email' => $encryptedEmail, 'table' => $table];
            }
        }
        return false;
    }

    // Forgot password functionality
    public function forgotPassword($email) {
        $emailData = $this->getEmailFromTables($email);

        if ($emailData) {
            $token = bin2hex(random_bytes(50));
            $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
            $table = $emailData['table'];
            $encryptedEmail = $emailData['email'];

            $stmt = $this->conn->prepare("UPDATE $table SET reset_token = ?, reset_expires_at = ? WHERE email = ?");
            $stmt->bind_param("sss", $token, $expires_at, $encryptedEmail);
            $stmt->execute();

            return $token;
        }
        return false;
    }
}
?>