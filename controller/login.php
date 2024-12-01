<?php

class LoginClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticateUser($email, $password) {
        // Hash the email and password using SHA-256
        $hashedEmail = hash('sha256', $email);
        $hashedPassword = hash('sha256', $password);

        // Prepare statement to fetch user details
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $hashedEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Check if the hashed password matches the stored password
            if (hash_equals($row['password'], $hashedPassword)) {
                // Store the user's session details
                $_SESSION["role"] = $row["user_type"];
                $_SESSION['user_id'] = $row['user_id'];  // Assuming user_id as the primary key
                $_SESSION['name'] = $row['firstName'] . ' ' . $row['lastName'];

                return $row;
            }
        }

        return false;
    }
}

?>
