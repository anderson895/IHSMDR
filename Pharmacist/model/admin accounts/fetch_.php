<?php
session_start();
include '../../../includes/config.php';
include '../../controller/functions.php';

$SettingsClass = new SettingsClass($conn);
$user = $SettingsClass->fetchAllUsers();
echo json_encode($user);
?>
