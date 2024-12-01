<?php
session_start();
include '../../../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medicineId = $_POST['medicineId'];

    $stmt = $conn->prepare("SELECT quantity FROM medicines WHERE medicine_id = ?");
    $stmt->bind_param("i", $medicineId);
    $stmt->execute();
    $stmt->bind_result($quantity);
    $stmt->fetch();
    
    if ($quantity !== null) {
        echo json_encode(['success' => true, 'quantity' => $quantity]);
    } else {
        echo json_encode(['success' => false, 'quantity' => 0]);
    }
}
?>
