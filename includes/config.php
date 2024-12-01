<?php  
$host ="localhost";
$user ="root";
$pass="";
$db ="ishmdr_db";

// $host ="localhost";
// $user ="u380084282_panalo_user";
// $pass=">cyj!Lp3";
// $db ="u380084282_panalo_db";


$conn = mysqli_connect($host,$user,$pass,$db);
mysqli_set_charset($conn,"utf8");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
?>
