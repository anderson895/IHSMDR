<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>Maternal Record Reports</h4>
            </div>
        </div> 

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="row">
                        <div class="col-md-3">
                            <select id="dispensingOfficerFilter" class="form-control">
                                <option value="">All Dispensing Officers</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" id="startDate" class="form-control" placeholder="Start Date">
                        </div>
                        <div class="col-md-3">
                            <input type="date" id="endDate" class="form-control" placeholder="End Date">
                        </div>
                        <div class="col-md-6 mt-3">
                            <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
                            <button id="exportReport" class="btn btn-success">Export Report</button>
                            <button id="printReport" class="btn btn-info">Print Report</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table hover nowrap">
                        <thead>
                            <tr>
                                <th>Patient No</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Address</th>
                                <th>Medicine</th>
                                <th>Quantity</th>
                                <th>Date</th>
                                <th>Prescribing Doctor</th>
                                <th>Dispensing Officer</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    let dataTable;

    function initializeDataTable() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        dataTable = $('#dataTable').DataTable({
            columns: [
                { data: 'patient_no', orderable: true },
                { data: 'first_name' },
                { data: 'middle_name' },
                { data: 'last_name' },
                { data: 'age' },
                { data: 'sex' },
                { data: 'address' },
                { data: 'medicine_name' },
                { data: 'quantity' },
                { data: 'date' },
                { data: 'prescribing_doctor' },
                { data: 'dispensing_officer' }
            ]
        });
    }

    function fetchPatients(filters = {}) {
        $.ajax({
            url: 'model/reports/fetch_.php',
            type: 'GET',
            data: filters,
            dataType: 'json',
            success: function(data) {
                dataTable.clear().rows.add(data).draw();
                updateDispensingOfficerFilter(data);
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed: ' + status + ', ' + error);
                alert('Error loading data: ' + error);
            }
        });
    }

    function updateDispensingOfficerFilter(data) {
        let officers = [...new Set(data.map(item => item.dispensing_officer))];
        let filterSelect = $('#dispensingOfficerFilter');
        filterSelect.empty().append('<option value="">All Dispensing Officers</option>');
        officers.forEach(officer => {
            filterSelect.append(`<option value="${officer}">${officer}</option>`);
        });
    }

    $('#applyFilters').on('click', function() {
        let filters = {
            dispensing_officer: $('#dispensingOfficerFilter').val(),
            start_date: $('#startDate').val(),
            end_date: $('#endDate').val()
        };
        fetchPatients(filters);
    });

    $('#exportReport').on('click', function() {
        let data = dataTable.data().toArray();
        let ws = XLSX.utils.json_to_sheet(data);
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Patients");
        XLSX.writeFile(wb, "patient_report.xlsx");
    });

    $('#printReport').on('click', function() {
        let data = dataTable.data().toArray();
        let printContent = `
            <div class="receipt-container">
                <div class="receipt-header">
                    <h2>Report</h2>
                </div>
                <div class="receipt-info">
                    <div class="receipt-row">
                        <span>Date: ${new Date().toLocaleDateString()}</span>
                        <span>Time: ${new Date().toLocaleTimeString()}</span>
                    </div>
                </div>
                <div class="receipt-details">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Patient No</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Medicine</th>
                                <th>Quantity</th>
                                <th>Date</th>
                                <th>Prescribing Doctor</th>
                                <th>Dispensing Officer</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.map(row => `
                                <tr>
                                    <td>${row.patient_no}</td>
                                    <td>${row.first_name} ${row.middle_name} ${row.last_name}</td>
                                    <td>${row.age}</td>
                                    <td>${row.sex}</td>
                                    <td>${row.medicine_name}</td>
                                    <td>${row.quantity}</td>
                                    <td>${row.date}</td>
                                    <td>${row.prescribing_doctor}</td>
                                    <td>${row.dispensing_officer}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                <div class="receipt-footer">
                </div>
            </div>
        `;

        let printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Patient Management Report</title>
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                    <style>
                        body { font-family: Arial, sans-serif; }
                        .receipt-container { max-width: 100%; margin: 0 auto; padding: 20px; }
                        .receipt-header { text-align: center; margin-bottom: 20px; }
                        .receipt-logo { max-width: 150px; margin-bottom: 10px; }
                        .receipt-info { margin-bottom: 20px; }
                        .receipt-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
                        .receipt-details { margin-bottom: 20px; }
                        .receipt-total { text-align: right; margin-top: 20px; }
                        .receipt-footer { text-align: center; margin-top: 30px; font-style: italic; }
                        @media print {
                            body { -webkit-print-color-adjust: exact; }
                            .table { width: 100%; }
                        }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
            </html>
        `);
        printWindow.document.close();
        
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
    });

    initializeDataTable();
    fetchPatients(); // Initial fetch
});
</script>