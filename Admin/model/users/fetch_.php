<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

$UserClass = new UsersClass($conn);
$Users = $UserClass->fetchAllUsers();

// Return the data as JSON
echo json_encode($Users);
?>
