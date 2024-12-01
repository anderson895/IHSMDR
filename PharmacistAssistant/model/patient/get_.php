<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get patient ID from request
    $id = $_GET['patientId'] ?? ''; // Changed to match the JavaScript AJAX call

    // Validate the input
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(array("error" => "Patient ID is required"));
        exit();
    }

    try {
        // Create an instance of the PatientClass
        $patientClass = new PatientClass($conn);
        // Attempt to retrieve the patient
        $patient = $patientClass->getPatient($id);

        // Check if the patient was found
        if ($patient) {
            http_response_code(200);
            echo json_encode($patient);
        } else {
            http_response_code(404);
            echo json_encode(array("error" => "Patient not found"));
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
