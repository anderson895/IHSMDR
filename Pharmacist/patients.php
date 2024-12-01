<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        

        <div class="card">
        <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>Patient Records</h4>
                <h6>View/Search Patients</h6>
            </div>
            <div class="page-btn">
                <button class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Add Patient
                </button>
            </div>
        </div> 
            <div class="card-body">
                <div class="table-top">
                    <!-- Filter options can be added here -->
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
</div>


<?php include 'modal/patients/modal.php'; ?>
<?php include 'includes/footer.php'; ?>
<script>
$(document).ready(function() {
    $('#qty').prop('disabled', true);

    $('#medicineId').on('change', function() {
        let medicineId = $(this).val();
        $.post('model/patient/fetch_medicine_quantity.php', { medicineId: medicineId }, function(response) {
            if (response.success) {
                let maxQty = response.quantity;
                $('#qty').val(maxQty).attr('max', maxQty).prop('disabled', maxQty <= 0);
                $('#qty').off('input').on('input', function() {
                    let enteredQty = $(this).val();
                    if (enteredQty > maxQty) {
                        Swal.fire('Exceeds Stock', 'Only ' + maxQty + ' available.', 'error');
                        $('#qty').val(maxQty); // Reset to maxQty but keep it enabled
                    } else if (enteredQty <= 0) {
                        Swal.fire('Out of Stock', 'Only ' + maxQty + ' available.', 'error');
                        $('#qty').val(1); // Minimum value should be 1
                    } else {
                        $('#qty').prop('disabled', false); // Re-enable on valid input
                    }
                });
            } else {
                $('#qty').val(0).prop('disabled', true);
                Swal.fire('Error', 'Error fetching stock information.', 'error');
            }
        }, 'json');
    });
});


$(document).ready(function() {
    // Function to fetch patients and populate the DataTable
    function fetchPatients() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        var dataTable = $('#dataTable').DataTable({
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
                { data: 'dispensing_officer' },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        return `
                        <div class="table-actions">
                            <a href="#" class="edit-btn" data-id="${data.id}">
                                <img src="assets/img/icons/edit.svg" alt="Edit">
                            </a>
                            <a href="#" class="delete-btn" data-id="${data.id}">
                                <img src="assets/img/icons/delete.svg" alt="Delete">
                            </a>
                        </div>`;
                    }
                }
            ]
        });

        $.ajax({
            url: 'model/patient/fetch_.php',
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

    // Add patient form submission
    $('#addPatientForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "model/patient/add_.php",
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                $('#addPatientModal').modal('hide');
                $('#addPatientForm')[0].reset();
                Swal.fire({
                    title: 'Success!',
                    text: 'Patient added successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    fetchPatients();
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr); // Log the xhr object
                Swal.fire({
                    title: 'Warning!',
                    text: 'Error adding patient: ' + error,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }

        });
    });

        
    // Edit patient button click event
    $('#dataTable').on('click', '.edit-btn', function(e) {
        e.preventDefault();
        var patientId = $(this).data('id');

        $.ajax({
            url: 'model/patient/get_.php', // URL to fetch patient details
            type: 'GET',
            dataType: 'json',
            data: { patientId: patientId }, // Send patientId
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    // Populate the edit form fields with patient data
                    
                    $('#editPatientId').val(response.id);
                    $('#editPatientNo').val(response.patient_no);
                    $('#editFirstName').val(response.first_name);
                    $('#editMiddleName').val(response.middle_name);
                    $('#editLastName').val(response.last_name);
                    $('#editAge').val(response.age);
                    $('#editSex').val(response.sex);
                    $('#editAddress').val(response.address);
                    $('#editMedicineId').val(response.medicine_id);
                    $('#editQuantity').val(response.quantity);
                    $('#editDate').val(response.date);
                    $('#editPrescribingDoctor').val(response.prescribing_doctor);
                    $('#editDispensingOfficer').val(response.dispensing_officer);
                    // Show the modal for editing patient details
                    $('#editPatientModal').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching patient data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Error fetching patient data: ' + error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });


    // Edit patient form submission
    $('#editPatientForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "model/patient/edit_.php",
            data: $(this).serialize(),
            success: function(response) {
                $('#editPatientModal').modal('hide');
                Swal.fire({
                    title: 'Success!',
                    text: 'Patient updated successfully',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    fetchPatients();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Error updating patient: ' + error,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Delete patient button click event
    $('#dataTable').on('click', '.delete-btn', function(e) {
    e.preventDefault();
    var patientId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this patient. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            deletePatient(patientId);
        }
    });
});

// Function to delete a patient using AJAX
function deletePatient(patientId) {
    $.ajax({
        url: 'model/patient/del_.php',
        type: 'GET',
        data: { patientId: patientId },
        success: function(response) {
            // Parse the JSON response
            var res = JSON.parse(response);
            if (res.message) {
                Swal.fire({
                    title: 'Success!',
                    text: res.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(function() {
                    fetchPatients(); // Refresh the patient list
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: res.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Error!',
                text: 'Error deleting patient: ' + error,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

    fetchPatients();
});

</script>