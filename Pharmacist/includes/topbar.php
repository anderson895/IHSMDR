<?php 

session_start();
$servername = "localhost";  // Your database server, usually 'localhost'
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "ishmdr_db";   // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query = "SELECT medicine_name, quantity FROM medicines WHERE quantity < 100";
$result = $conn->query($query);


?> 
<body >
   <!-- <div id="global-loader">
      <div class="whirly-loader"> </div>
      </div> -->
   <div class="main-wrapper" >
   <div class="header" >
      <div class="header-left active bg-white" >
         <a href="index.php" class="logo h4 pt-3 text-dark text-bold">PHARMACIST
         </a>
         <a href="index.html" class="logo-small">
         <img src="assets/img/Sidebar Logo.jpg" alt="">
         </a>
         <a id="toggle_btn" href="javascript:void(0);">
         </a>
      </div>
      <a id="mobile_btn" class="mobile_btn" href="#sidebar">
      <span class="bar-icon">
      <span></span>
      <span></span>
      <span></span>
      </span>
      </a>
      <ul class="nav user-menu">
         <li class="nav-item">
            <div class="top-nav-search">
               <a href="javascript:void(0);" class="responsive-search">
               <i class="fa fa-search"></i>
               </a>
            </div>
         </li>
         <!-- <li class="nav-item dropdown has-arrow flag-nav">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
            <img src="../assets/img/flags/us1.png" alt="" height="20">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            <a href="javascript:void(0);" class="dropdown-item">
            <img src="assets/img/flags/us.png" alt="" height="16"> English
            </a>
            <a href="javascript:void(0);" class="dropdown-item">
            <img src="assets/img/flags/fr.png" alt="" height="16"> French
            </a>
            <a href="javascript:void(0);" class="dropdown-item">
            <img src="assets/img/flags/es.png" alt="" height="16"> Spanish
            </a>
            <a href="javascript:void(0);" class="dropdown-item">
            <img src="assets/img/flags/de.png" alt="" height="16"> German
            </a>
            </div>
            </li> -->
        
        
         <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
            <img src="assets/img/icons/notification-bing.svg" alt="img"> <span class="badge rounded-pill">4</span>
            </a>
            <div class="dropdown-menu notifications">
               <div class="topnav-dropdown-header">
                  <span class="notification-title">Notifications</span>
                  <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
               </div>
               <div class="noti-content">
                  <ul class="notification-list">
                  <?php
                 
                     if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                           echo "<li class='notification-message'>
                                    <a href='#'>
                                       <div class='media d-flex'>
                                          <div class='media-body'>
                                             <p>Low stock alert: <strong>{$row['medicine_name']}</strong> (Quantity: {$row['quantity']})</p>
                                          </div>
                                       </div>
                                    </a>
                                 </li>";
                        }
                  } else {
                        echo "<li class='notification-message'>
                                 <p>No low stock alerts.</p>
                              </li>";
                  }
                 ?>

                  </ul>
               </div>
               <div class="topnav-dropdown-footer">
                  <a href="medicine soon to expired.php">View all Notifications</a>
               </div>
            </div>
         </li>

         
         <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
            <span class="user-img"><img src="assets/img/profiles/default-avatar.jpg" alt="">
            <span class="status online"></span></span>
            </a>
            <div class="dropdown-menu menu-drop-user">
               <div class="profilename">
                  <div class="profileset">
                     <span class="user-img"><img src="assets/img/profiles/default-avatar.jpg" alt="">
                     <span class="status online"></span></span>
                     <div class="profilesets">
                        <h6><?php echo $_SESSION['role']; ?></h6>
                     </div>
                  </div>
                  <hr class="m-0">
                  <a class="dropdown-item logout pb-0"  href="session/logout.php"><img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout</a>
               </div>
            </div>
         </li>
      </ul>
      <div class="dropdown mobile-user-menu">
         <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
         <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="session/logout.php">Logout</a>
         </div>
      </div>
   </div>