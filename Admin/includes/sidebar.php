<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
         <ul>
            <li <?php echo ($currentFileName == 'index.php') ? 'class="active"' : ''; ?>>
               <a href="index.php"><i class="fa fa-home"></i><span> Dashboard</span></a>
            </li>
            <hr>

            <li <?php echo ($currentFileName == 'users.php') ? 'class="active"' : ''; ?>>
            <a href="users.php"><i class="fas fa-print"></i><span>Users</span></a>
            </li>

            <!-- <li class="submenu">
               <a href="#"><i class="fas fa-print"></i><span>Medicine Dispensing/reporting </span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="medicine.php" <?php echo ($currentFileName == 'medicine.php') ? 'class="active"' : ''; ?>>Inventory</a></li>
                  <li><a href="patients.php"  <?php echo ($currentFileName == 'patients.php') ? 'class="active"' : ''; ?>>Patients</a></li>
                  <li><a href="dispend medicines.php"  <?php echo ($currentFileName == 'dispend medicines.php') ? 'class="active"' : ''; ?>>Dispense Meds Details</a></li>
               </ul>
            </li> -->
        
            <li class="submenu">
               <a href="#"><i class="fas fa-print"></i><span>Reports </span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="summarytable.php" <?php echo ($currentFileName == 'summarytable.php') ? 'class="active"' : ''; ?>>FHSIS</a></li>
                  <li><a href="datatable.php"  <?php echo ($currentFileName == 'datatable.php') ? 'class="active"' : ''; ?>>M1 Form</a></li>
                  <li><a href="patientlist.php"  <?php echo ($currentFileName == 'patientlist.php') ? 'class="active"' : ''; ?>>Target Client List</a></li>
                  <li><a href="medicine low stock.php" <?php echo ($currentFileName == 'medicine low stock.php') ? 'class="active"' : ''; ?>>Medicine-Low Stock</a></li>
                  <li><a href="medicine soon to expired.php"  <?php echo ($currentFileName == 'medicine soon to expired.php') ? 'class="active"' : ''; ?>>Medicine Soon to Expired</a></li>
                  <li><a href="report.php"  <?php echo ($currentFileName == 'report.php') ? 'class="active"' : ''; ?>>Patient Record Reports</a></li>
                  <!-- <li><a href="maternal.php"  <?php echo ($currentFileName == 'maternal.php') ? 'class="active"' : ''; ?>>Maternal Record Reports</a></li> -->
               </ul>
            </li>
            

            <li <?php //echo ($currentFileName == '#') ? 'class="active"' : ''; ?>>
               <a href="#"><i class="fas fa-cog"></i><span>Activity Logs</span></a>
            </li>
          <li>
             
            <li <?php echo ($currentFileName == 'account settings.php') ? 'class="active"' : ''; ?>>
               <a href="account settings.php"><i class="fas fa-user-cog"></i><span>Account Settings</span></a>
            </li>
         </ul>
      </div>
   
   </div>
</div>