<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

$StaffClass = new StaffClass($conn);
$Users = $StaffClass->fetchAllUsers();
// Return the data as JSON
echo json_encode($Users);
?>
