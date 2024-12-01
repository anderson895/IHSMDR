<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

try {
    $MedicineClass = new MedicineClass($conn);
    $medicines = $MedicineClass->fetchAllMedicines();

    http_response_code(200);
    echo json_encode($medicines);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("error" => "Exception: " . $e->getMessage()));
}
?>
