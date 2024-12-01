<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

try {
    $ReportMedicineClass = new ReportMedicineClass($conn);
    $lowstock = $ReportMedicineClass->fetchLowStockMedicines();

    http_response_code(200);
    echo json_encode($lowstock);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("error" => "Exception: " . $e->getMessage()));
}
?>
