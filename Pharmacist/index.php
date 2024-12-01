<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Include Chart.js library -->
<?php
   // Instantiate DashboardClass and retrieve counts from DB
   $DashboardClass = new DashboardClass($conn);
   $countTotalMedicine = $DashboardClass->countTotalMedicine();
   $countTotalPatient = $DashboardClass->countTotalPatient();
   $countTotalDispensed = $DashboardClass->countTotalDispensed();
   $countLowStockMedicine = $DashboardClass->countLowStockMedicine();
   $countSoonToExpireMedicine = $DashboardClass->countSoonToExpireMedicine();
   $countPharmacists = $DashboardClass->countPharmacists();

   $sql = "SELECT medicine_name, quantity FROM medicines";
   $result = $conn->query($sql);

   // Initialize arrays to hold data for Chart.js
   $brands = [];
   $quantities = [];

   // Fetch data and store in arrays
   if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
         $brands[] = $row['medicine_name'];
         $quantities[] = $row['quantity'];
      }
   } else {
      echo "No records found.";
   }



   $query = "SELECT medicine_name, quantity FROM medicines WHERE quantity < 100";
   $result = $conn->query($query);

   // Function to get medicine data by expiry date
function getMedicineDataByExpiryDate($conn, $startDate, $endDate) {
   $sql = "SELECT medicine_name, quantity FROM medicines WHERE expiry_date BETWEEN ? AND ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("ss", $startDate, $endDate);
   $stmt->execute();
   $result = $stmt->get_result();

   $data = ['brands' => [], 'quantities' => []];
   while ($row = $result->fetch_assoc()) {
       $data['brands'][] = $row['medicine_name'];
       $data['quantities'][] = $row['quantity'];
   }
   return $data;
}

// Handle AJAX request for date-filtered data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['startDate']) && isset($_POST['endDate'])) {
   $startDate = $_POST['startDate'];
   $endDate = $_POST['endDate'];
   $filteredData = getMedicineDataByExpiryDate($conn, $startDate, $endDate);
   echo json_encode($filteredData);
   exit; // End script execution after returning JSON response
}
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
         <!-- <div class="content">
            <div class="card">
               <div class="chart-container">
                     <canvas id="medicineChart"></canvas>
               </div>
            </div>
         </div> -->
         <div class="content">
            <div class="row">
               <!-- Chart Column -->
               <div class="col-md-8">
                  <div class="card">
                     <div class="chart-container">
                        <canvas id="medicineChart"></canvas>
                     </div>
                  </div>
               </div>
               
               <!-- Notification Column -->
               <div class="col-md-4">
                  <div class="card">
                     <div class="card-header">
                        <h4 class="card-title">Low Stock Medicines</h4>
                     </div>
                     <div class="card-body">
                        <div class="list-group">
                           <?php
                           // Fetch low stock medicines from the database
                           $query = "SELECT medicine_name, quantity FROM medicines WHERE quantity < 100";
                           $result = $conn->query($query);

                           // Display notifications if there are any low stock medicines
                           if ($result && $result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                                 $medicineName = htmlspecialchars($row['medicine_name'], ENT_QUOTES, 'UTF-8');
                                 $quantity = (int) $row['quantity'];
                                 echo "<a href='#' class='list-group-item list-group-item-action'>
                                          <div class='d-flex justify-content-between'>
                                             <span><strong>{$medicineName}</strong></span>
                                             <span class='badge bg-warning'>{$quantity}</span>
                                          </div>
                                       </a>";
                              }
                           } else {
                              echo "<p class='text-muted'>No low stock medicines.</p>";
                           }
                           ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <style>
        .chart-container {
            width: 80%;
            margin: 0 auto;
        }
        .date-filter {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
         }
   </style>
   <script>
   // Prepare data for Chart.js from PHP variables
   const labels = <?php echo json_encode($brands); ?>;
   const data = {
      labels: labels,
      datasets: [{
         label: 'Quantity',
         data: <?php echo json_encode($quantities); ?>,
         backgroundColor: 'rgba(54, 162, 235, 0.5)',
         borderColor: 'rgba(54, 162, 235, 1)',
         borderWidth: 1
      }]
   };

   // Configure the chart
   const config = {
      type: 'bar',
      data: data,
      options: {
         scales: {
               y: { beginAtZero: true, title: { display: true, text: 'Quantity' } },
               x: { title: { display: true, text: 'Medicine Brand' } }
         },
         plugins: {
               legend: { display: true, position: 'top' },
               title: { display: true, text: 'Medicine Quantity by Brand' }
         }
      }
   };

   // Render the chart
   const myChart = new Chart(document.getElementById('medicineChart'), config);

   function filterData() {
      const startDate = document.getElementById('start_date').value;
      const endDate = document.getElementById('end_date').value;

      if (!startDate || !endDate) {
         alert("Please select both start and end dates.");
         return;
      }

      // Send AJAX request to PHP to fetch filtered data
      fetch('index.php', {
         method: 'POST',
         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
         body: `startDate=${startDate}&endDate=${endDate}`
      })
      .then(response => response.json())
      .then(data => {
         // Update chart with new data
         updateChart(data.brands, data.quantities);
      })
      .catch(error => console.error('Error fetching data:', error));
   }

   function updateChart(brands, quantities) {
      // Update the chart's labels and data
      myChart.data.labels = brands;
      myChart.data.datasets[0].data = quantities;
      myChart.update();
   }
   </script>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
