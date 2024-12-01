    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="assets/plugins/apexchart/chart-data.js"></script>
        
    <script src="assets/plugins/chartjs/chart.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
      <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
    <script src="assets/js/script.js"></script>

        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <script>
            $(document).ready(function() {
                function fetchExpiringMedicines() {
                    $.ajax({
                        url: 'model/notif/fetch_expiring_medicines.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            updateNotificationDropdown(data);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                        }
                    });
                }

                function updateNotificationDropdown(medicines) {
                    var $notificationList = $('.notification-list');
                    $notificationList.empty();

                    medicines.forEach(function(medicine) {
                        var notificationHtml = `
                            <li class="notification-message">
                                <a href="medicine soon to expired.php?id=${medicine.medicine_id}">
                                    <div class="media d-flex">
                                        <span class="avatar flex-shrink-0">
                                            <img alt="" src="../assets/img/icons/medicine/image.png">
                                        </span>
                                        <div class="media-body flex-grow-1">
                                            <p class="noti-details">
                                                <span class="noti-title">${medicine.medicine_name}</span> is expiring today
                                            </p>
                                            <p class="noti-time">
                                                <span class="notification-time">Lot: ${medicine.lot_number}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        `;
                        $notificationList.append(notificationHtml);
                    });

                    // Update notification count
                    $('.badge.rounded-pill').text(medicines.length);
                }

                // Fetch expiring medicines every 5 minutes
                fetchExpiringMedicines();
                setInterval(fetchExpiringMedicines, 300000);
            });
            </script>