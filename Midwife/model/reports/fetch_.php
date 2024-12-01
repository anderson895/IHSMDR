<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

try {
    $ReportClass = new ReportClass($conn);

    // Get filter parameters from GET request
    $filters = [
        'dispensing_officer' => filter_input(INPUT_GET, 'dispensing_officer', FILTER_SANITIZE_STRING),
        'start_date' => filter_input(INPUT_GET, 'start_date', FILTER_SANITIZE_STRING),
        'end_date' => filter_input(INPUT_GET, 'end_date', FILTER_SANITIZE_STRING)
    ];

    // Remove any null or empty values from the filters array
    $filters = array_filter($filters, function($value) {
        return !is_null($value) && $value !== '';
    });

    // Fetch patients with applied filters
    $patients = $ReportClass->fetchAllPatients($filters);

    http_response_code(200);
    echo json_encode($patients);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("error" => "Exception: " . $e->getMessage()));
}
