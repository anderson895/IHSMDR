<?php
   include '../../../includes/config.php';
               header('Content-Type: application/json');
   
               $today = date('Y-m-d');
   
               $query = "SELECT `medicine_id`, `medicine_brand`, `generic`, `medicine_name`, `lot_number`, `expiry_date`, `quantity`, `category` 
                       FROM `medicines` 
                       WHERE `expiry_date` = '$today'
                       ORDER BY `medicine_name` ASC";
   
               $result = mysqli_query($conn, $query);
   
               $medicines = [];
               while ($row = mysqli_fetch_assoc($result)) {
                   $medicines[] = $row;
               }
   
               echo json_encode($medicines);
               mysqli_close($conn);
               ?>