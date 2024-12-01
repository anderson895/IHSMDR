<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_no = $_POST['patient_no'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $middle_name = $_POST['middle_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $age = $_POST['age'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $address = $_POST['address'] ?? '';
    $medicine_id = $_POST['medicine_id'] ?? '';
    $quantity = $_POST['quantity'] ?? '';
    $date = $_POST['date'] ?? '';
    $prescribing_doctor = $_POST['prescribing_doctor'] ?? '';
    $dispensing_officer = $_POST['dispensing_officer'] ?? '';

    if (empty($patient_no) || empty($first_name) || empty($last_name)) {
        http_response_code(400);
        echo json_encode(array("error" => "Patient number, first name, and last name are required"));
        exit();
    }

    try {
        $patientClass = new PatientClass($conn);
        $result = $patientClass->addPatient($patient_no, $first_name, $middle_name, $last_name, $age, $sex, $address, $medicine_id, $quantity, $date, $prescribing_doctor, $dispensing_officer);

        if ($result) {
            http_response_code(200);
            echo json_encode(array("message" => "Patient added successfully"));
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to add patient or patient already exists"));
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("error" => "Exception: " . $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
}
