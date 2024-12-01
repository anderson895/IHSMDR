<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<?php
   // Instantiate DashboardClass and retrieve counts from DB
   $DashboardClass = new DashboardClass($conn);
   $countTotalMedicine = $DashboardClass->countTotalMedicine();
   $countTotalPatient = $DashboardClass->countTotalPatient();
   $countTotalDispensed = $DashboardClass->countTotalDispensed();
   $countLowStockMedicine = $DashboardClass->countLowStockMedicine();
   $countSoonToExpireMedicine = $DashboardClass->countSoonToExpireMedicine();
   //$countPharmacists = $DashboardClass->countPharmacists();
?>

<div class="page-wrapper">
   <div class="content">
      <div class="row">
    
         <!-- New Medicine and Patient Statistics -->
         <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count das4 bg-info">
               <div class="dash-counts">
                  <h4><?php echo $countTotalMedicine ?></h4>
                  <h5>Total Medicine</h5>
               </div>
               <div class="dash-imgs">
                  <i class="fas fa-prescription-bottle-alt"></i>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count das5 bg-success">
               <div class="dash-counts">
                  <h4><?php echo $countTotalPatient ?></h4>
                  <h5>Total Patients</h5>
               </div>
               <div class="dash-imgs">
                  <i class="fas fa-user-injured"></i>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count das6 bg-warning">
               <div class="dash-counts">
                  <h4><?php echo $countTotalDispensed ?></h4>
                  <h5>Total Dispensed Medicine</h5>
               </div>
               <div class="dash-imgs">
                  <i class="fas fa-pills"></i>
               </div>
            </div>
         </div>
         
         <!-- Pharmacist, Low Stock, and Expiring Medicines -->
         <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count das7 bg-danger">
               <div class="dash-counts">
                  <h4><?php echo $countPharmacists ?></h4>
                  <h5>Total Pharmacists</h5>
               </div>
               <div class="dash-imgs">
                  <i class="fas fa-user-md"></i>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count das8 bg-secondary">
               <div class="dash-counts">
                  <h4><?php echo $countLowStockMedicine ?></h4>
                  <h5>Total Low Stock Medicine</h5>
               </div>
               <div class="dash-imgs">
                  <i class="fas fa-exclamation-triangle"></i>
               </div>
            </div>
         </div>
         <div class="col-lg-4 col-sm-6 col-12 d-flex">
            <div class="dash-count das9 bg-light">
               <div class="dash-counts">
                  <h4><?php echo $countSoonToExpireMedicine ?></h4>
                  <h5>Total Soon to Expire Medicine</h5>
               </div>
               <div class="dash-imgs">
                  <i class="fas fa-hourglass-end"></i>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
