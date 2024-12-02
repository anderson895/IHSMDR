<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicineId = isset($_POST['medicineId']) ? $_POST['medicineId'] : '';
    $medicineBrand = isset($_POST['medicineBrand']) ? $_POST['medicineBrand'] : '';
    $generic = isset($_POST['generic']) ? $_POST['generic'] : '';
    $medicineName = isset($_POST['medicineName']) ? $_POST['medicineName'] : '';
    $lotNumber = isset($_POST['lotNumber']) ? $_POST['lotNumber'] : '';
    $expiryDate = isset($_POST['expiryDate']) ? $_POST['expiryDate'] : '';
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    // Validation
    if (empty($medicineId) || empty($medicineBrand) || empty($medicineName)) {
        http_response_code(400);
        echo json_encode(array("error" => "Medicine ID, brand, and name are required"));
        exit();
    }

    try {
        $medicineClass = new MedicineClass($conn);
        $result = $medicineClass->editMedicine($medicineId, $medicineBrand, $generic, $medicineName, $lotNumber, $expiryDate, $quantity, $category);

        if ($result) {
            http_response_code(200);
            echo json_encode(array("message" => "Medicine updated successfully"));
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to update medicine"));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("error" => "Exception: " . $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}
?>
