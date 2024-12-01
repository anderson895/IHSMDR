<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

try {
    $patientClass = new PatientClass($conn);
    $patients = $patientClass->fetchAllPatients();

    http_response_code(200);
    echo json_encode($patients);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("error" => "Exception: " . $e->getMessage()));
}
