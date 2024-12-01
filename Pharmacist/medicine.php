<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>Medicine Management</h4>
                <h6>View/Search Medicines</h6>
            </div>
            <div class="page-btn">
                <button class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Add Medicine
                </button>
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
                                <th>Medicine ID</th>
                                <th>Brand</th>
                                <th>Generic</th>
                                <th>Medicine Name</th>
                                <th>Lot Number</th>
                                <th>Expiry Date</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Action</th>
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

<?php include 'modal/medicine/modal.php'; ?>
<!-- js -->
<?php include 'includes/footer.php'; ?>
<script>
$(document).ready(function() {
    // Function to fetch medicines and populate the DataTable
    function fetchMedicines() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        var dataTable = $('#dataTable').DataTable({
            columns: [
                { data: 'medicine_id', orderable: true },
                { data: 'medicine_brand' },
                { data: 'generic' },
                { data: 'medicine_name' },
                { data: 'lot_number' },
                { data: 'expiry_date' },
                { data: 'quantity' },
                { data: 'category' },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        return `
                        <div class="table-actions">
                            <a href="#" class="edit-btn" data-id="${data.medicine_id}">
                                <img src="assets/img/icons/edit.svg" alt="Edit">
                            </a>
                            <a href="#" class="delete-btn" data-id="${data.medicine_id}">
                                <img src="assets/img/icons/delete.svg" alt="Delete">
                            </a>
                        </div>`;
                    }
                }
            ]
        });

        $.ajax({
            url: 'model/medicine/fetch_.php',
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

    // Add medicine form submission
    $('#addMedicineForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "model/medicine/add_.php",
            data: $(this).serialize(),
            success: function(response) {
                $('#addMedicineModal').modal('hide');
                $('#addMedicineForm')[0].reset();
                Swal.fire({
                    title: 'Success!',
                    text: 'Medicine added successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    fetchMedicines();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Error adding medicine: ' + error,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Edit medicine button click event
    $('#dataTable').on('click', '.edit-btn', function(e) {
        e.preventDefault();
        var medicineId = $(this).data('id');
        $.ajax({
            url: 'model/medicine/get_.php',
            type: 'GET',
            dataType: 'json',
            data: { medicineId: medicineId },
            success: function(response) {
                $('#editMedicineId').val(response.medicine_id);
                $('#editMedicineBrand').val(response.medicine_brand);
                $('#editGeneric').val(response.generic);
                $('#editMedicineName').val(response.medicine_name);
                $('#editLotNumber').val(response.lot_number);
                $('#editExpiryDate').val(response.expiry_date);
                $('#editQuantity').val(response.quantity);
                $('#editCategory').val(response.category);
                $('#editMedicineModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching medicine data:', error);
            }
        });
    });

    // Edit medicine form submission
    $('#editMedicineForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "model/medicine/edit_.php",
            data: $(this).serialize(),
            success: function(response) {
                $('#editMedicineModal').modal('hide');
                Swal.fire({
                    title: 'Success!',
                    text: 'Medicine updated successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    fetchMedicines();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Error updating medicine: ' + error,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Delete medicine button click event
    $('#dataTable').on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var medicineId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete this medicine. This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteMedicine(medicineId);
            }
        });
    });

    function deleteMedicine(medicineId) {
        $.ajax({
            url: 'model/medicine/del_.php',
            type: 'GET',
            data: { medicineId: medicineId },
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Medicine deleted successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    fetchMedicines();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error deleting medicine: ' + error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    fetchMedicines();
});
</script>
