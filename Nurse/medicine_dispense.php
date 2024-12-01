<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>Dispensed Medicines Management</h4>
                <h6>View/Search Dispensed Medicines</h6>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <!-- Filter options can be added here -->
                </div>
                <div class="table-responsive">
                    <table id="dataTable" class="table hover nowrap">
                        <thead>
                            <tr>
                            <th>Medicine Brand</th>
                            <th>Generic</th>
                            <th>Medicine Name</th>
                            <th>Quantity Available</th>
                            <th>Category</th>
                            <th>Quantity Dispensed</th>
                            <th>Lot Number</th>
                    <!---  <th>Dispensed Date</th>
                            <th>Prescribing Doctor</th>
                            <th>Dispensing Officer</th>
                            <th>Action</th>--->
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
<script>
    //For Dispensed Medicine
$(document).ready(function() {
    // Function to fetch dispensed medicines and populate the DataTable
    function fetchDispensedMedicines() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        var dataTable = $('#dataTable').DataTable({
            columns: [
                //{ data: 'patient_id', orderable: true }, // Dispensed ID
                //{ data: 'patient_no', orderable: true }, // Patient Number
                //{ data: 'patient_name', orderable: true }, // Patient Name
                { data: 'medicine_brand', orderable: true }, // Medicine Brand
                { data: 'generic', orderable: true }, // Generic
                { data: 'medicine_name', orderable: true }, // Medicine Name
                { data: 'available_quantity', orderable: true }, // Quantity Dispensed
                { data: 'category', orderable: true }, // Category
                { data: 'quantity_dispensed', orderable: true }, // Quantity Dispensed
                { data: 'lot_number', orderable: true }, // Lot Number
                // { data: 'expiry_date', orderable: true }, // Expiry Date
                // { data: 'dispensed_date', orderable: true }, // Dispensed Date
                //{ data: 'prescribing_doctor', orderable: true }, // Prescribing Doctor
                //{ data: 'dispensing_officer', orderable: true } // Dispensing Officer
                // Uncomment the action column if you decide to implement it
                // {
                //     data: null,
                //     orderable: false,
                //     render: function(data) {
                //         return `
                //         <div class="table-actions">
                //             <a href="#" class="edit-btn" data-id="${data.dispensed_id}">
                //                 <img src="assets/img/icons/edit.svg" alt="Edit">
                //             </a>
                //             <a href="#" class="delete-btn" data-id="${data.dispensed_id}">
                //                 <img src="assets/img/icons/delete.svg" alt="Delete">
                //             </a>
                //         </div>`;
                //     }
                // }
            ]
        });

        $.ajax({
            url: 'model/dispensed medicine/fetch_.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                dataTable.clear().rows.add(data).draw();
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed: ' + status + ', ' + error);
                $('#errorContainer').text('Error loading data: ' + error).show();
            }
        });
    }

    // // Add dispensed medicine form submission
    // $('#addDispensedMedicineForm').submit(function(e) {
    //     e.preventDefault();

    //     $.ajax({
    //         type: "POST",
    //         url: "model/dispensed_medicine/add_.php",
    //         data: $(this).serialize(),
    //         success: function(response) {
    //             $('#addDispensedMedicineModal').modal('hide');
    //             $('#addDispensedMedicineForm')[0].reset();
    //             Swal.fire({
    //                 title: 'Success!',
    //                 text: 'Dispensed medicine added successfully',
    //                 icon: 'success',
    //                 confirmButtonText: 'OK'
    //             }).then(function() {
    //                 fetchDispensedMedicines();
    //             });
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire({
    //                 title: 'Warning!',
    //                 text: 'Error adding dispensed medicine: ' + error,
    //                 icon: 'warning',
    //                 confirmButtonText: 'OK'
    //             });
    //         }
    //     });
    // });

    // // Edit dispensed medicine button click event
    // $('#dataTable').on('click', '.edit-btn', function(e) {
    //     e.preventDefault();
    //     var dispensedId = $(this).data('id');
    //     $.ajax({
    //         url: 'model/dispensed_medicine/get_.php',
    //         type: 'GET',
    //         dataType: 'json',
    //         data: { dispensedId: dispensedId },
    //         success: function(response) {
    //             $('#editDispensedId').val(response.dispensed_id);
    //             $('#editPatientName').val(response.patient_name);
    //             $('#editMedicineName').val(response.medicine_name);
    //             $('#editQuantityDispensed').val(response.quantity_dispensed);
    //             $('#editDispensedDate').val(response.dispensed_date);
    //             $('#editDispensedMedicineModal').modal('show');
    //         },
    //         error: function(xhr, status, error) {
    //             console.error('Error fetching dispensed medicine data:', error);
    //         }
    //     });
    // });

    // // Edit dispensed medicine form submission
    // $('#editDispensedMedicineForm').submit(function(e) {
    //     e.preventDefault();
        
    //     $.ajax({
    //         type: "POST",
    //         url: "model/dispensed_medicine/edit_.php",
    //         data: $(this).serialize(),
    //         success: function(response) {
    //             $('#editDispensedMedicineModal').modal('hide');
    //             Swal.fire({
    //                 title: 'Success!',
    //                 text: 'Dispensed medicine updated successfully',
    //                 icon: 'success',
    //                 confirmButtonText: 'OK'
    //             }).then(function() {
    //                 fetchDispensedMedicines();
    //             });
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire({
    //                 title: 'Warning!',
    //                 text: 'Error updating dispensed medicine: ' + error,
    //                 icon: 'warning',
    //                 confirmButtonText: 'OK'
    //             });
    //         }
    //     });
    // });

    // // Delete dispensed medicine button click event
    // $('#dataTable').on('click', '.delete-btn', function(e) {
    //     e.preventDefault();
    //     var dispensedId = $(this).data('id');

    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: 'You are about to delete this dispensed medicine. This action cannot be undone.',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!',
    //         cancelButtonText: 'Cancel'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             deleteDispensedMedicine(dispensedId);
    //         }
    //     });
    // });

    // function deleteDispensedMedicine(dispensedId) {
    //     $.ajax({
    //         url: 'model/dispensed_medicine/del_.php',
    //         type: 'GET',
    //         data: { dispensedId: dispensedId },
    //         success: function(response) {
    //             Swal.fire({
    //                 title: 'Success!',
    //                 text: 'Dispensed medicine deleted successfully',
    //                 icon: 'success',
    //                 confirmButtonText: 'OK'
    //             }).then(function() {
    //                 fetchDispensedMedicines();
    //             });
    //         },
    //         error: function(xhr, status, error) {
    //             Swal.fire({
    //                 title: 'Error!',
    //                 text: 'Error deleting dispensed medicine: ' + error,
    //                 icon: 'error',
    //                 confirmButtonText: 'OK'
    //             });
    //         }
    //     });
    // }

    fetchDispensedMedicines();
});
</script>