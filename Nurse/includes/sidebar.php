<div class="sidebar" id="sidebar">
   <div class="sidebar-inner slimscroll">
      <div id="sidebar-menu" class="sidebar-menu">
         <ul>
            <li <?php echo ($currentFileName == 'index.php') ? 'class="active"' : ''; ?>>
               <a href="index.php"><i class="fa fa-home"></i><span> Dashboard</span></a>
            </li>
            <hr>

            <li <?php echo ($currentFileName == 'users.php') ? 'class="active"' : ''; ?>>
            <a href="patient.php"><i class="fas fa-print"></i><span>Patients</span></a>
            </li>

            <li <?php echo ($currentFileName == 'users.php') ? 'class="active"' : ''; ?>>
            <a href="medicine_dispense.php"><i class="fas fa-print"></i><span>Medicine Dispense</span></a>
            </li>
        
            <li class="submenu">
               <a href="#"><i class="fas fa-print"></i><span>Reports </span><span class="menu-arrow"></span></a>
               <ul>
                  <li><a href="fhsis.php" <?php echo ($currentFileName == 'fhsis.php') ? 'class="active"' : ''; ?>>FHSIS</a></li>
                  <li><a href="m1Form.php"  <?php echo ($currentFileName == 'm1Form.php') ? 'class="active"' : ''; ?>>M1 Form</a></li>
                  <li><a href="tcl.php"  <?php echo ($currentFileName == 'tcl.php') ? 'class="active"' : ''; ?>>Target Client List</a></li>
                  <li><a href="patientReports.php"  <?php echo ($currentFileName == 'patientReports.php') ? 'class="active"' : ''; ?>>Patient Record Reports</a></li>
               </ul>
            </li>
            
         </ul>
      </div>
   </div>
</div>