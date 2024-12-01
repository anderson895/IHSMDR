<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

try {
    $dispensedMedicineClass = new DispensedMedicineClass($conn);
    $dispensedMedicines = $dispensedMedicineClass->fetchDispensedMedicines();

    http_response_code(200);
    echo json_encode($dispensedMedicines);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("error" => "Exception: " . $e->getMessage()));
}
?>
