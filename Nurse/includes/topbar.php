<body >
  <!-- <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div> -->
    <div class="main-wrapper" >
        <div class="header" >
            <div class="header-left active bg-white" >
                <a href="index.php" class="logo h4 pt-3 text-dark text-bold">NURSE
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
                  
                    <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">
                                            <span class="avatar flex-shrink-0">
                                            <img alt="" src="assets/img/profiles/avatar-02.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                            <span class="noti-title">Store 1:</span>
                                            <span class="noti-text">"We regret to inform you that your quotation request for <span class="noti-title">Quotation request</span> has been denied."</span>
                                            <p class="noti-time">
                                                <span class="notification-time">4 mins ago</span>
                                            </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="#">
                                        <div class="media d-flex">

                                        <span class="avatar flex-shrink-0">
                                            <img alt="" src="assets/img/profiles/avatar-13.jpg">
                                            </span>
                                            <div class="media-body flex-grow-1">
                                            <span class="noti-title">Store 2:</span>
                                            <span class="noti-text">"Your quotation request for <span class="noti-title">Product X</span> has been approved. The price is <span class="noti-title">$199.99</span>"</span>
                                            <p class="noti-time">
                                                <span class="notification-time">4 mins ago</span>
                                            </p>
                                            </div>
                                        </div>
                                    
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="#">View all Notifications</a>
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