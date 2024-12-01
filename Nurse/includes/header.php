<?php 

include '../includes/config.php';
include 'controller/functions.php';

session_start();
$currentFileName = basename($_SERVER['PHP_SELF']);
if (!isset($_SESSION['role'])) {
    header('Location:../index.php');
    exit();
}
if ($_SESSION['role'] !== 'Nurse') {
    unset($_SESSION['role']);
    session_destroy();
    header('Location:../index.php'); 
    exit();
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="POS - Bootstrap Admin Template">
<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
<meta name="author" content="Dreamguys - Bootstrap Admin Template">
<meta name="robots" content="noindex, nofollow">
<title>Dashboard</title>
<link rel="icon" type="image/png" href="../assets/img/favicon/favicon-32x32.png" />
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/animate.css">
<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background:linear-gradient(to bottom, rgb(192 192 192 / 29%), rgb(231 232 233));
       
    }
    .header {
    border-bottom: 1px solid transparent;
    height: 60px;
    z-index: 999;
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    -webkit-box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.05);
    -moz-box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.05);
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.05);
    }
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #ffffff80;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }
    .table tbody tr td {
    padding: 10px;
    color: #333333;
    font-weight: 500;
    border-bottom: 1px solid #afafaf;
    vertical-align: middle;
    white-space: nowrap;
}
    .page-header .btn-added {
    background: #4464e8;
    padding: 7px 15px;
    color: #fff;
    font-weight: 700;
    font-size: 14px;
    }
    .sidebar .slimScrollDiv {
    width: 260px !important;
    overflow: visible !important;
    background: #ffffff;
   }

  .sidebar .sidebar-menu > ul > li > a span {
    margin-left: 10px;
    font-size: 15px;
    font-weight: 500;
    color: #313131;
}

.header .header-left {
    float: left;
    height: 60px;
    position: relative;
    text-align: center;
    width: 260px;
    z-index: 1;
    padding: 0 40px;
    -webkit-transition: all 0.2s ease;
    -ms-transition: all 0.2s ease;
    transition: all 0.2s ease;
    border-right: 1px solid #e8ebed;
}
.sidebar .sidebar-menu > ul > li > a:hover span {
    color: #313131;
}
.sidebar .sidebar-menu > ul > li > a.active {
    background: #4464e8;
    color: #fff;
    border-radius: 5px;
}

.sidebar .sidebar-menu > ul > li.active a {

    background: #4464e8;
    border-radius: 5px;
}.sidebar .sidebar-menu > ul > li:hover a {
    background: #ebecfb;
    color: #44525d;
    border-radius: 5px;
}
.sidebar .sidebar-menu > ul > li a {
    background: #e9ecfc;
    border-radius: 5px;
}
.dash-count.das1 {
    background: #ff4500;
}
.dash-count.das2 {
    background: #fdd600;
}
.dash-count.das3 {
    background: #7761f8;
}
</style>

<style>.image-container {
  position: relative;
  width: 100%;
  padding-top: 56.25%; /* 16:9 aspect ratio */
  background-color: #f0f0f0;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.image-container:hover {
  transform: scale(1.05);
}

.id-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  cursor: pointer;
}

.image-label {
  position: absolute;
  bottom: 10px;
  left: 10px;
  background-color: rgba(0, 0, 0, 0.6);
  color: white;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 14px;
}</style>

<style>/* Sidebar Footer Basic Styling */
.sidebar-footer {
    width: 100%;
    height: 450px;
    background-image: url('assets/img/Sidebar Footer (700x800).jpg');
    background-size: cover;
    background-position: center;
    position: relative;
    bottom: 0;
}

/* Responsive Design for Sidebar Footer */
@media (max-width: 768px) {
    .sidebar-footer {
        height: 400px; /* Adjust height for medium screens */
        background-size: contain; /* Adjust background size to contain */
    }
}

@media (max-width: 480px) {
    .sidebar-footer {
        height: 100px; /* Adjust height for small screens */
        background-size: contain; /* Ensure the image scales down appropriately */
        background-position: center center; /* Center the image */
    }
}
</style>
<style>
.dash-count {
    padding: 20px;
    border-radius: 10px;
    color: white; /* Adjust text color based on background color */
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dash-counts h4 {
    margin: 0;
    font-size: 24px;
}

.dash-counts h5 {
    margin: 5px 0 0;
    font-size: 14px;
}

.bg-info {
    background-color: #17a2b8;
}

.bg-success {
    background-color: #28a745;
}

.bg-warning {
    background-color: #ffc107;
}

.bg-danger {
    background-color: #dc3545;
}

.bg-secondary {
    background-color: #6c757d;
}

.bg-light {
    background-color: #f8f9fa;
    color: #212529; /* Adjust text color for light background */
}
</style>