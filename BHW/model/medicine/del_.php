<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

// Check if GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $medicineId = isset($_GET['medicineId']) ? $_GET['medicineId'] : '';

    // Validation
    if (empty($medicineId)) {
        http_response_code(400);
        echo json_encode(array("error" => "Medicine ID is required"));
        exit();
    }

    try {
        $medicineClass = new MedicineClass($conn);
        $result = $medicineClass->deleteMedicine($medicineId);

        if ($result) {
            http_response_code(200);
            echo json_encode(array("message" => "Medicine deleted successfully"));
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to delete medicine"));
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
