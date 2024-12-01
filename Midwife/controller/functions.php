<?php
   error_reporting(0);
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
   

   class SettingsClass {
    private $conn;
    protected $encryptionKey = DEFAULT_ENCRYPTION_KEY;

    public function __construct($conn) {
        $this->conn = $conn;
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

     public function decryptPassword($encryptPassword, $salt) {
         return decryptText($encryptPassword, $this->encryptionKey, $salt);
     }

     

    public function fetchAllUsers() {
     $query = "SELECT * FROM `admin`";
     $result = mysqli_query($this->conn, $query);
     if (!$result) {
         die('Error fetching users: ' . mysqli_error($this->conn));
     }
     $users = [];
     while ($row = $result->fetch_assoc()) {
         $row['admin_id'] = $row['admin_id'];
         $row['email'] = $this->decryptEmail($row['email'], $this->generateSalt());
         $row['created_at'] = isset($row['created_at']) ? date('F j, Y g:i A', strtotime($row['created_at'])) : '';
         $row['name'] = $row['firstName'] . ' ' . $row['lastName'];
         
         $users[] = $row;
     }

     return $users;
 }

 public function getUserById($userId) {
    $sql = "SELECT * FROM `admin` WHERE `admin_id` = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($result) {
        $result['email'] = $this->decryptEmail($result['email'], $this->generateSalt());
    }
    return $result;
}

 public function editUser($firstName, $lastName, $email, $password, $userType, $userId) {
    $salt = $this->generateSalt();
      $sql = "UPDATE `admin` 
              SET `firstName` = ?, 
                  `lastName` = ?, 
                  `email` = ?, 
                  `user_type` = ?";
      if (!empty($password)) {
          $sql .= ", `password` = ?";
      }
      $sql .= " WHERE `admin_id` = ?";
      $stmt = $this->conn->prepare($sql);
      if (!empty($password)) {
          $stmt->bind_param("sssssi", $firstName, $lastName, $this->encryptPassword($email, $salt), $userType, $this->encryptEmail($password, $salt), $userId);
      } else {
          $stmt->bind_param("ssssi", $firstName, $lastName, $this->encryptPassword($email, $salt), $userType, $userId);
      }
      if ($stmt->execute()) {
          $stmt->close();
          return true; // Success
      } else {
          $stmt->close();
          return false; // Failed to update
      }
  }

  public function addUser($firstName, $lastName, $email, $password, $userType) {
    $salt = $this->generateSalt();
    $encryptedEmail = $this->encryptEmail($email,$salt);
    $encryptedPassword = $this->encryptPassword($password,$salt);
    $sql = "INSERT INTO `admin` (`firstName`, `lastName`, `email`, `password`, `user_type`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("sssss", $firstName, $lastName, $encryptedEmail, $encryptedPassword, $userType);
    if ($stmt->execute()) {
        $stmt->close();
        return true; // Success
    } else {
        $stmt->close();
        return false; // Failed to insert
    }
}
}

class MedicineClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addMedicine($medicineBrand, $generic, $medicineName, $lotNumber, $expiryDate, $quantity, $category) {
        if ($this->checkDuplicateMedicine($medicineName, $lotNumber)) {
            return false; // Duplicate medicine found
        }

        $sql = "INSERT INTO `medicines` (`medicine_brand`, `generic`, `medicine_name`, `lot_number`, `expiry_date`, `quantity`, `category`) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssis", $medicineBrand, $generic, $medicineName, $lotNumber, $expiryDate, $quantity, $category);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Success
        } else {
            $stmt->close();
            return false; // Failed to insert
        }
    }

    public function checkDuplicateMedicine($medicineName, $lotNumber) {
        $sql = "SELECT `medicine_name`, `lot_number` FROM `medicines` WHERE `medicine_name` = ? AND `lot_number` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $medicineName, $lotNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    public function fetchMedicines() {
        $sql = "SELECT * FROM `medicines`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    public function fetchAllMedicines() {
        $sql = "SELECT * FROM `medicines` ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $candidates = [];

        while ($row = $result->fetch_assoc()) {
            $candidates[] = $row;
        }

        $stmt->close();
        return $candidates;
    }

    public function deleteMedicine($medicineId) {
        $sql = "DELETE FROM `medicines` WHERE `medicine_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $medicineId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getMedicine($medicineId) {
        $sql = "SELECT * FROM `medicines` WHERE `medicine_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $medicineId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public function editMedicine($medicineId, $medicineBrand, $generic, $medicineName, $lotNumber, $expiryDate, $quantity, $category) {
        $sql = "UPDATE `medicines` 
                SET `medicine_brand` = ?, `generic` = ?, `medicine_name` = ?, `lot_number` = ?, `expiry_date` = ?, `quantity` = ?, `category` = ? 
                WHERE `medicine_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssi", $medicineBrand, $generic, $medicineName, $lotNumber, $expiryDate, $quantity, $category, $medicineId);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Success
        } else {
            $stmt->close();
            return false; // Failed to update
        }
    }
}

class PatientClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Add a new patient
    public function addPatient($patient_no, $first_name, $middle_name, $last_name, $age, $sex, $address, $medicine_id, $quantity, $date, $prescribing_doctor, $dispensing_officer) {
        if ($this->checkDuplicatePatient($patient_no)) {
            return false; // Duplicate patient found
        }

        // Subtract medicine quantity from the medicines table
        if (!$this->updateMedicineQuantity($medicine_id, -$quantity)) {
            return false; // Failed to update medicine quantity
        }

        $sql = "INSERT INTO `patients` (`patient_no`, `first_name`, `middle_name`, `last_name`, `age`, `sex`, `address`, `medicine_id`, `quantity`, `date`, `prescribing_doctor`, `dispensing_officer`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->conn->error); // Log SQL error
            return false; 
        }
        $stmt->bind_param("ssssississss", 
            $patient_no, 
            $first_name, 
            $middle_name, 
            $last_name, 
            $age, 
            $sex, 
            $address, 
            $medicine_id, 
            $quantity, 
            $date, 
            $prescribing_doctor, 
            $dispensing_officer
        );
        if (!$stmt->execute()) {
            error_log("Execute Error: " . $stmt->error); // Log execution error
            $stmt->close(); // Close statement
            return false; 
        }
        $stmt->close();
        return true; // Success
    }
    
    // Check for duplicate patient by patient number
    public function checkDuplicatePatient($patient_no) {
        $sql = "SELECT `patient_no` FROM `patients` WHERE `patient_no` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $patient_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows > 0;
    }

    // Fetch all patients
    public function fetchPatients() {
        $sql = "SELECT * FROM `patients`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result; // Return the result set
    }

    // Fetch all patients with detailed result
    public function fetchAllPatients() {
        $sql = "SELECT patients.*, concat(patients.first_name,' ', patients.middle_name,' ',patients.last_name) as fullname,medicines.medicine_name
        FROM patients
        INNER JOIN medicines ON patients.medicine_id = medicines.medicine_id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $patients = [];

        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }

        $stmt->close();
        return $patients;
    }

    // Delete a patient by id
    public function deletePatient($id) {
        // First, get the medicine ID and quantity to restore the medicine stock
        $patient = $this->getPatient($id);
        $medicineId = $patient['medicine_id'];
        $quantity = $patient['quantity'];

        // Restore medicine quantity before deletion
        $this->updateMedicineQuantity($medicineId, $quantity);

        $sql = "DELETE FROM `patients` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Get a single patient's details by id
    public function getPatient($id) {
        $sql = "SELECT * FROM `patients` WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    // Edit patient details
    public function editPatient($id, $patient_no, $first_name, $middle_name, $last_name, $age, $sex, $address, $medicine_id, $quantity, $date, $prescribing_doctor, $dispensing_officer) {
        // First, get the old patient information
        $oldPatient = $this->getPatient($id);
        $oldMedicineId = $oldPatient['medicine_id'];
        $oldQuantity = $oldPatient['quantity'];

        // Update medicine quantities: 
        // Add back the old quantity
        if (!$this->updateMedicineQuantity($oldMedicineId, $oldQuantity)) {
            return false; // Failed to update old medicine quantity
        }

        // If medicine_id or quantity has changed, we need to subtract the new quantity
        if ($medicine_id != $oldMedicineId || $quantity != $oldQuantity) {
            // Subtract the new quantity
            if (!$this->updateMedicineQuantity($medicine_id, -$quantity)) {
                return false; // Failed to update new medicine quantity
            }
        }

        $sql = "UPDATE `patients` 
                SET `patient_no` = ?, `first_name` = ?, `middle_name` = ?, `last_name` = ?, `age` = ?, `sex` = ?, `address` = ?, `medicine_id` = ?, `quantity` = ?, `date` = ?, `prescribing_doctor` = ?, `dispensing_officer` = ?
                WHERE `id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssississsi", 
            $patient_no, 
            $first_name, 
            $middle_name, 
            $last_name, 
            $age, 
            $sex, 
            $address, 
            $medicine_id, 
            $quantity, 
            $date, 
            $prescribing_doctor, 
            $dispensing_officer, 
            $id
        );

        if (!$stmt->execute()) {
            error_log("Execute Error: " . $stmt->error); // Log execution error
            $stmt->close(); // Close statement
            return false; 
        }
        $stmt->close();
        return true; // Success
    }

    // Function to update medicine quantity
    private function updateMedicineQuantity($medicineId, $quantityChange) {
        $sql = "UPDATE `medicines` SET `quantity` = `quantity` + ? WHERE `medicine_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantityChange, $medicineId);
        if (!$stmt->execute()) {
            return false; // Failed to update medicine quantity
        }
        $stmt->close();
        return true; // Success
    }
}

class DispensedMedicineClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Fetch all dispensed medicines along with patient details
    public function fetchDispensedMedicines() {
        $sql = "SELECT 
                    p.id AS patient_id,
                    p.patient_no,
                    CONCAT(p.first_name, ' ', p.middle_name, ' ', p.last_name) AS patient_name,
                    m.medicine_brand,
                    m.generic,
                    m.medicine_name,
                    IFNULL(p.quantity, 0) AS quantity_dispensed,  -- Use IFNULL to handle medicines with no dispensed quantity
                    m.lot_number,
                    m.expiry_date,
                    m.category,
                    p.date AS dispensed_date,
                    p.prescribing_doctor,
                    p.dispensing_officer,
                    m.quantity AS available_quantity  -- Assuming you have a quantity field for available medicines
                FROM 
                    medicines m
                LEFT JOIN 
                    patients p ON p.medicine_id = m.medicine_id AND p.quantity > 0  -- Include only dispensed medicines where quantity > 0
                WHERE 
                    m.quantity > 0  -- Display only available medicines
                ORDER BY 
                    m.medicine_name;
"; // Ensure only dispensed medicines with quantity are fetched

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->conn->error); // Log SQL error
            return []; // Return an empty array if there's an error
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $dispensedMedicines = [];

        while ($row = $result->fetch_assoc()) {
            $dispensedMedicines[] = $row;
        }

        $stmt->close();
        return $dispensedMedicines; // Return the list of dispensed medicines
    }
}


class ReportMedicineClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchLowStockMedicines() {
        $sql = "SELECT 
                    p.id AS patient_id,
                    p.patient_no,
                    CONCAT(p.first_name, ' ', p.middle_name, ' ', p.last_name) AS patient_name,
                    m.medicine_brand,
                    m.generic,
                    m.medicine_name,
                    IFNULL(p.quantity, 0) AS quantity_dispensed,
                    m.lot_number,
                    m.expiry_date,
                    m.category,
                    p.date AS dispensed_date,
                    p.prescribing_doctor,
                    p.dispensing_officer,
                    m.quantity AS available_quantity
                FROM 
                    medicines m
                LEFT JOIN 
                    patients p ON p.medicine_id = m.medicine_id AND p.quantity > 0
                WHERE 
                    m.quantity > 0
                ORDER BY 
                    m.medicine_name";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->conn->error);
            return [];
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $Medicines = [];

        while ($row = $result->fetch_assoc()) {
            $Medicines[] = $row;
        }

        $stmt->close();
        return $Medicines;
    }

    public function fetchExpiredSixMonthsMedicines() {
        $sql = "SELECT
            p.id AS patient_id,
            p.patient_no,
            CONCAT(p.first_name, ' ', p.middle_name, ' ', p.last_name) AS patient_name,
            m.medicine_brand,
            m.generic,
            m.medicine_name,
            IFNULL(p.quantity, 0) AS quantity_dispensed,
            m.lot_number,
            m.expiry_date,
            m.category,
            p.date AS dispensed_date,
            p.prescribing_doctor,
            p.dispensing_officer,
            m.quantity AS available_quantity
        FROM
            medicines m
        LEFT JOIN
            patients p ON p.medicine_id = m.medicine_id AND p.quantity > 0
        WHERE
            m.quantity > 0
            AND m.expiry_date = CURDATE()
        ORDER BY
            m.medicine_name";
    
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("SQL Prepare Error: " . $this->conn->error);
            return [];
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $Medicines = [];
    
        while ($row = $result->fetch_assoc()) {
            $Medicines[] = $row;
        }
    
        $stmt->close();
        return $Medicines;
    }
}


class ReportClass {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAllPatients($filters = []) {
        $sql = "SELECT patients.*, 
                       CONCAT(patients.first_name, ' ', patients.middle_name, ' ', patients.last_name) AS fullname, 
                       medicines.medicine_name 
                FROM patients 
                INNER JOIN medicines ON patients.medicine_id = medicines.medicine_id 
                WHERE 1=1";

        $params = [];

        // Applying filters
        if (!empty($filters['dispensing_officer'])) {
            $sql .= " AND patients.dispensing_officer = ?";
            $params[] = $filters['dispensing_officer'];
        }
        
        if (!empty($filters['start_date'])) {
            $sql .= " AND patients.date >= ?";
            $params[] = $filters['start_date'];
        }
        
        if (!empty($filters['end_date'])) {
            $sql .= " AND patients.date <= ?";
            $params[] = $filters['end_date'];
        }

        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Database prepare error: " . $this->conn->error);
        }

        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $patients = [];
        
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
        
        $stmt->close();
        return $patients;
    }
}



class DashboardClass {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Count total medicines
    public function countTotalMedicine() {
        $query = "SELECT COUNT(*) AS total FROM medicines";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // Count total patients
    public function countTotalPatient() {
        $query = "SELECT COUNT(*) AS total FROM patients";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // Count total dispensed medicine
    public function countTotalDispensed() {
        $query = "SELECT SUM(quantity) AS total_dispensed FROM patients WHERE quantity > 0";
        $result = $this->conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total_dispensed'] ?? 0; // Return 0 if no records found
        }
        return 0; // In case of query failure
    }

    // Count low-stock medicine (threshold set to 10)
    public function countLowStockMedicine() {
        $query = "SELECT COUNT(*) AS low_stock_count FROM medicines WHERE quantity <= 5"; // Change the threshold as needed
        $result = $this->conn->query($query);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['low_stock_count'] ?? 0; // Return 0 if no records found
        }
        return 0; // In case of query failure
    }
    

    // Count soon-to-expire medicine (expiry within 30 days)
    public function countSoonToExpireMedicine() {
        $query = "SELECT COUNT(*) AS total FROM medicines WHERE expiry_date < NOW() + INTERVAL 30 DAY";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // Count total pharmacists
    public function countPharmacists() {
        $query = "SELECT COUNT(*) AS total FROM pharmacists";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
}




   class UserClass {
       private $conn;
       protected $encryptionKey = DEFAULT_ENCRYPTION_KEY;
   
       public function __construct($conn) {
           $this->conn = $conn;
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

        public function decryptPassword($encryptPassword, $salt) {
            return decryptText($encryptPassword, $this->encryptionKey, $salt);
        }

        
       public function addUser($firstName, $lastName, $province,  $municipality,$barangay,  $email, $password, $userType) {
          $salt = $this->generateSalt();
           if ($this->checkDuplicateEmail($email)) {
               return false; // Email already exists
           }
           $sql = "INSERT INTO `barangay` (`firstName`, `lastName`, `province`, `municipality`, `barangay`,`email`, `password`, `user_type`) VALUES (?, ?,?,?,?, ?, ?, ?)";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("ssssssss", $firstName, $lastName, $province, $municipality, $barangay, $this->encryptEmail($email, $salt),   $this->encryptPassword($password, $salt), $userType);
       
           if ($stmt->execute()) {
               $stmt->close();
               return true; // Success
           } else {
               $stmt->close();
               return false; // Failed to insert
           }
       }
   
       public function checkDuplicateEmail($email) {
        $sql = "SELECT `email` FROM `barangay`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $emailExists = false;
        while ($row = $result->fetch_assoc()) {
            $decryptedEmail = $this->decryptEmail($row['email'], $this->generateSalt());
            if ($decryptedEmail === $email) {
                $emailExists = true;
                break;
            }
        }
        return $emailExists;
    }
        
       public function fetchUsers() {
           $sql = "SELECT * FROM `barangay` WHERE 1";
           $stmt = $this->conn->prepare($sql);
           $stmt->execute();
           $result = $stmt->get_result();
           $stmt->close();
           return $result;
       }
    
   
       public function deleteUser($userId) {
           $sql = "DELETE FROM `barangay` WHERE `barangay_id` = ?";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("i", $userId);
           $stmt->execute();
           return $stmt->affected_rows > 0;
       }
   
       public function getUserById($userId) {
        $sql = "SELECT * FROM `barangay` WHERE `barangay_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if ($result) {
            $result['email'] = $this->decryptEmail($result['email'], $this->generateSalt());
        }
        return $result;
    }
   
       public function fetchAllUsers() {
        $query = "SELECT * FROM `barangay`";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            // Log the error or handle it according to your application's needs
            die('Error fetching users: ' . mysqli_error($this->conn));
        }

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $row['user_id'] = $row['barangay_id'];
            $row['email'] = $this->decryptEmail($row['email'], $this->generateSalt());
            $row['created_at'] = isset($row['created_at']) ? date('F j, Y g:i A', strtotime($row['created_at'])) : '';
            $row['name'] = $row['firstName'] . ' ' . $row['lastName'];
            
            $row['province'] = $row['province'];
            $row['municipality'] = $row['municipality'];
            $row['barangay'] = $row['barangay'];
            $users[] = $row;
        }

        return $users;
    }
       public function editUser($firstName, $lastName, $province, $municipality,  $barangay,$email, $password, $userType, $userId) {
         $salt = $this->generateSalt();
           $sql = "UPDATE `barangay` 
                   SET `firstName` = ?, 
                       `lastName` = ?, 
                       `province` = ?, 
                       `municipality` = ?, 
                       `barangay` = ?, 
                       `email` = ?, 
                       `user_type` = ?";
           if (!empty($password)) {
               $sql .= ", `password` = ?";
           }
           $sql .= " WHERE `barangay_id` = ?";
           $stmt = $this->conn->prepare($sql);
           if (!empty($password)) {
               $stmt->bind_param("ssssssssi", $firstName, $lastName,$province, $municipality,  $barangay, $this->encryptPassword($email, $salt), $userType, $this->encryptEmail($password, $salt), $userId);
           } else {
               $stmt->bind_param("sssssssi", $firstName, $lastName,$province, $municipality,  $barangay,  $this->encryptPassword($email, $salt), $userType, $userId);
           }
           if ($stmt->execute()) {
               $stmt->close();
               return true; // Success
           } else {
               $stmt->close();
               return false; // Failed to update
           }
       }
   }
   


   
   class ManagerClass {
    private $conn;
    protected $encryptionKey = DEFAULT_ENCRYPTION_KEY;

    public function __construct($conn) {
        $this->conn = $conn;
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

     public function decryptPassword($encryptPassword, $salt) {
         return decryptText($encryptPassword, $this->encryptionKey, $salt);
     }

     
    public function addUser($firstName, $lastName,  $email, $password, $userType) {
       $salt = $this->generateSalt();
        if ($this->checkDuplicateEmail($email)) {
            return false; // Email already exists
        }
        $sql = "INSERT INTO `manager` (`firstName`, `lastName`,`email`, `password`, `user_type`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName, $this->encryptEmail($email, $salt),   $this->encryptPassword($password, $salt), $userType);
    
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Success
        } else {
            $stmt->close();
            return false; // Failed to insert
        }
    }

    public function checkDuplicateEmail($email) {
     $sql = "SELECT `email` FROM `manager`";
     $stmt = $this->conn->prepare($sql);
     $stmt->execute();
     $result = $stmt->get_result();
     $stmt->close();
     $emailExists = false;
     while ($row = $result->fetch_assoc()) {
         $decryptedEmail = $this->decryptEmail($row['email'], $this->generateSalt());
         if ($decryptedEmail === $email) {
             $emailExists = true;
             break;
         }
     }
     return $emailExists;
 }
     
    public function fetchUsers() {
        $sql = "SELECT * FROM `manager` WHERE 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
 

    public function deleteUser($userId) {
        $sql = "DELETE FROM `manager` WHERE `manager_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getUserById($userId) {
     $sql = "SELECT * FROM `manager` WHERE `manager_id` = ?";
     $stmt = $this->conn->prepare($sql);
     $stmt->bind_param("i", $userId);
     $stmt->execute();
     $result = $stmt->get_result()->fetch_assoc();
     $stmt->close();
     if ($result) {
         $result['email'] = $this->decryptEmail($result['email'], $this->generateSalt());
     }
     return $result;
 }

    public function fetchAllUsers() {
     $query = "SELECT * FROM `manager`";
     $result = mysqli_query($this->conn, $query);

     if (!$result) {
         // Log the error or handle it according to your application's needs
         die('Error fetching users: ' . mysqli_error($this->conn));
     }

     $users = [];
     while ($row = $result->fetch_assoc()) {
         $row['user_id'] = $row['manager_id'];
         $row['email'] = $this->decryptEmail($row['email'], $this->generateSalt());
         $row['created_at'] = isset($row['created_at']) ? date('F j, Y g:i A', strtotime($row['created_at'])) : '';
         $row['name'] = $row['firstName'] . ' ' . $row['lastName'];
         $users[] = $row;
     }

     return $users;
 }
    public function editUser($firstName, $lastName, $email, $password, $userType, $userId) {
      $salt = $this->generateSalt();
        $sql = "UPDATE `manager` 
                SET `firstName` = ?, 
                    `lastName` = ?, 
                    `email` = ?, 
                    `user_type` = ?";
        if (!empty($password)) {
            $sql .= ", `password` = ?";
        }
        $sql .= " WHERE `manager_id` = ?";
        $stmt = $this->conn->prepare($sql);
        if (!empty($password)) {
            $stmt->bind_param("sssssi", $firstName, $lastName,$this->encryptPassword($email, $salt), $userType, $this->encryptEmail($password, $salt), $userId);
        } else {
            $stmt->bind_param("ssssi", $firstName, $lastName,  $this->encryptPassword($email, $salt), $userType, $userId);
        }
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Success
        } else {
            $stmt->close();
            return false; // Failed to update
        }
    }
}


class StaffClass {
    private $conn;
    protected $encryptionKey = DEFAULT_ENCRYPTION_KEY;

    public function __construct($conn) {
        $this->conn = $conn;
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

     public function decryptPassword($encryptPassword, $salt) {
         return decryptText($encryptPassword, $this->encryptionKey, $salt);
     }

     
    public function addUser($firstName, $lastName, $email, $password, $userType) {
       $salt = $this->generateSalt();
        if ($this->checkDuplicateEmail($email)) {
            return false; // Email already exists
        }
        $sql = "INSERT INTO `staff` (`firstName`, `lastName`,`email`, `password`, `user_type`) VALUES (?, ?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName,  $this->encryptEmail($email, $salt),   $this->encryptPassword($password, $salt), $userType);
    
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Success
        } else {
            $stmt->close();
            return false; // Failed to insert
        }
    }

    public function checkDuplicateEmail($email) {
     $sql = "SELECT `email` FROM `staff`";
     $stmt = $this->conn->prepare($sql);
     $stmt->execute();
     $result = $stmt->get_result();
     $stmt->close();
     $emailExists = false;
     while ($row = $result->fetch_assoc()) {
         $decryptedEmail = $this->decryptEmail($row['email'], $this->generateSalt());
         if ($decryptedEmail === $email) {
             $emailExists = true;
             break;
         }
     }
     return $emailExists;
 }
     
    public function fetchUsers() {
        $sql = "SELECT * FROM `staff` WHERE 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
 

    public function deleteUser($userId) {
        $sql = "DELETE FROM `staff` WHERE `staff_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getUserById($userId) {
     $sql = "SELECT * FROM `staff` WHERE `staff_id` = ?";
     $stmt = $this->conn->prepare($sql);
     $stmt->bind_param("i", $userId);
     $stmt->execute();
     $result = $stmt->get_result()->fetch_assoc();
     $stmt->close();
     if ($result) {
         $result['email'] = $this->decryptEmail($result['email'], $this->generateSalt());
     }
     return $result;
 }

    public function fetchAllUsers() {
     $query = "SELECT * FROM `staff`";
     $result = mysqli_query($this->conn, $query);
     $users = [];
     while ($row = $result->fetch_assoc()) {
         $row['user_id'] = $row['staff_id'];
         $row['email'] = $this->decryptEmail($row['email'], $this->generateSalt());
         $row['created_at'] = isset($row['created_at']) ? date('F j, Y g:i A', strtotime($row['created_at'])) : '';
         $row['name'] = $row['firstName'] . ' ' . $row['lastName'];
         $row['firstName'] = $row['firstName'];
         $row['lastName'] = $row['lastName'];
         
         $users[] = $row;
     }

     return $users;
 }
    public function editUser($firstName, $lastName, $email, $password, $userType, $userId) {
      $salt = $this->generateSalt();
        $sql = "UPDATE `staff` 
                SET `firstName` = ?, 
                    `lastName` = ?, 
                    `email` = ?, 
                    `user_type` = ?";
        if (!empty($password)) {
            $sql .= ", `password` = ?";
        }
        $sql .= " WHERE `staff_id` = ?";
        $stmt = $this->conn->prepare($sql);
        if (!empty($password)) {
            $stmt->bind_param("sssssi", $firstName, $lastName, $this->encryptPassword($email, $salt), $userType, $this->encryptEmail($password, $salt), $userId);
        } else {
            $stmt->bind_param("ssssi", $firstName, $lastName, $this->encryptPassword($email, $salt), $userType, $userId);
        }
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Success
        } else {
            $stmt->close();
            return false; // Failed to update
        }
    }
}

   ?>