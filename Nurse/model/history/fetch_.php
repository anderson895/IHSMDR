<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

// Initialize the HistoryClass
$HistoryClass = new HistoryClass($conn);

// Set the content type to JSON
header('Content-Type: application/json');

try {
    // Retrieve date parameters from GET request
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

    // Fetch all financial histories with optional date filtering
    $financialBudgets = $HistoryClass->getAllHistory($startDate, $endDate);

    // Return the data as JSON
    echo json_encode($financialBudgets);
} catch (Exception $e) {
    // Return an error response if something goes wrong
    echo json_encode([
        'status' => 'error',
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}
?>
