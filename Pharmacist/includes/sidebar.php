<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
         <ul>
            <li <?php echo ($currentFileName == 'index.php') ? 'class="active"' : ''; ?>>
               <a href="index.php"><i class="fa fa-home"></i><span> Dashboard</span></a>
            </li>
            <hr>

            <li <?php echo ($currentFileName == 'medicine.php') ? 'class="active"' : ''; ?>>
               <a href="medicine.php"><i class="fa fa-list"></i><span> Medicine Management </span></a>
            </li>   
            <li <?php echo ($currentFileName == 'patients.php') ? 'class="active"' : ''; ?>>
               <a href="patients.php"><i class="fa fa-users"></i><span> Patient </span></a>
            </li>

            <!-- <li <?php echo ($currentFileName == 'dispend medicines.php') ? 'class="active"' : ''; ?>>
               <a href="dispend medicines.php"><i class="fa fa-medkit"></i><span> Dispensed Medicines </span></a>
            </li> -->

            <li class="submenu">
               <a href="#"><i class="fas fa-print"></i><span>Reports </span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="inventory.php"  <?php echo ($currentFileName == 'inventory.php') ? 'class="active"' : ''; ?>>Inventory</a></li>
                  <!-- <li><a href="medicine low stock.php" <?php //echo ($currentFileName == 'medicine low stock.php') ? 'class="active"' : ''; ?>>Medicine-Low Stock</a></li>
                  <li><a href="medicine soon to expired.php"  <?php //echo ($currentFileName == 'medicine soon to expired.php') ? 'class="active"' : ''; ?>>Medicine Soon to Expired</a></li> -->
                  <li><a href="report.php"  <?php echo ($currentFileName == 'report.php') ? 'class="active"' : ''; ?>>Patient Record Reports</a></li>
               </ul>
            </li>

            <li <?php echo ($currentFileName == '#') ? 'class="active"' : ''; ?>>
               <a href="#"><i class="fas fa-cog"></i><span>Activity Logs</span></a>
            </li>
            <!-- <li>
            <li <?php //echo ($currentFileName == 'manager.php') ? 'class="active"' : ''; ?>>
               <a href="manager.php"><i class="fas fa-users"></i><span>Manager</span></a>
            </li>
            <li <?php //echo ($currentFileName == 'staff.php') ? 'class="active"' : ''; ?>>
               <a href="staff.php"><i class="fas fa-users"></i><span>Staff Account </span></a>
            </li>
             -->
       
         </ul>
      </div>
   </div>
</div>