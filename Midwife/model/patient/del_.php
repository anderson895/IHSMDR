<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get patient ID from request
    $id = $_GET['patientId'] ?? '';
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(array("error" => "Patient ID is required"));
        exit();
    }

    try {
        $patientClass = new PatientClass($conn);
        $result = $patientClass->deletePatient($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(array("message" => "Patient deleted successfully"));
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to delete patient"));
        }
    } catch (Exception $e) {
        // Log the exception
        error_log("Exception occurred: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(array("error" => "Exception: " . $e->getMessage()));
    }
} else {
    // Handle invalid request method
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}
