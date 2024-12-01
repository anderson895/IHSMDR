
$(document).ready(function() {
    function fetchSocialServicesList() {
        if ($.fn.DataTable.isDataTable('#socialServicesTable')) {
            $('#socialServicesTable').DataTable().destroy();
        }
        var dataTable = $('#socialServicesTable').DataTable({
            columns: [
                { 
                    data: 'fullname', 
                    title: 'Name', 
                    orderable: true,
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);" class="view-social-service btn btn-link" data-id="' + row.socialService_id + '">' + data + '</a>';
                    }
                },
                { data: 'socialService', title: 'Type of Assistance', orderable: true },  
                { data: 'municipality', title: 'Municipality', orderable: true },
                { data: 'barangay', title: 'Barangay', orderable: true },
                { data: 'endorsedBy', title: 'Endorsed By', orderable: true },
                {
                    data: 'status',
                    title: 'Status',
                    orderable: true,
                    render: function(data) {
                        var badgeClass = '';
                        var badgeText = '';

                        switch (data) {
                            case 'Pending':
                                badgeClass = 'badges bg-lightyellow'; // Red for requested
                                badgeText = 'Pending';
                                break;

                            case 'Approved':
                                badgeClass = 'badges bg-lightgreen'; // Yellow for pending
                                badgeText = 'Approved';
                                break;

                            case 'Rejected':
                                badgeClass = 'badges bg-lightred'; // Green for endorsed
                                badgeText = 'Rejected';
                                break;

                            case 'Claimed':
                                badgeClass = 'badges bg-lightgreen'; // Red for rejected
                                badgeText = 'Claimed';
                                break;

                            default:
                                badgeClass = 'badge bg-secondary'; // Gray for unknown status
                                badgeText = 'Unknown';
                        }

                        return `<span class="${badgeClass}">${badgeText}</span>`;
                    }
                },
                { data: 'amountRedeem', title: 'Approved Amount', orderable: true },
                {
                    data: null,
                    title: 'Action',
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="table-actions">' +
                            '<a class="me-3 edit-social-service" href="javascript:void(0);" data-id="' + row.socialService_id + '"><img src="assets/img/icons/edit.svg" alt="img"></a>' +
                            '<a class="me-3 delete-social-service" href="javascript:void(0);" data-service-id="' + row.socialService_id + '"><img src="assets/img/icons/delete.svg" alt="img"></a>' +
                            '</div>';
                    }
                }
            ]
        });

        $.ajax({
            url: 'model/social_services/fetch_.php',
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
    fetchSocialServicesList();

    // Handle click event on the name link
    $('#socialServicesTable').on('click', '.view-social-service', function(e) {
        e.preventDefault();
        var socialServiceId = $(this).data('id');
        $.ajax({
            url: 'model/social_services/get_.php',
            type: 'GET',
            data: { socialServiceId: socialServiceId },
            dataType: 'json',
            success: function(data) {
                console.log(data);
    
                // Set citizen details
                $('#citizenId').val(data.citizen_id);
                $('#firstName').val(data.first_name);
                $('#lastName').val(data.last_name);
                $('#middleName').val(data.middle_name);
                $('#suffix').val(data.suffix);
                $('#birthdate').val(data.birthdate);
                $('#gender').val(data.gender);
                $('#mobileNo').val(data.mobile_no);
                $('#email').val(data.email);
                $('#address').val(data.address);
                $('#sector').val(data.sector);
                $('#registeredVoter').val(data.registered_voter);
                $('#religion').val(data.religion);
                $('#affiliation').val(data.affiliation);
    
                // Display current file names for IDs and images if they exist
                if (data.front_valid_id) {
                    $('#frontValidIdLabel').text(`Current: ${data.front_valid_id}`);
                    $('#frontValidIdImage').attr('src', `../uploads/${data.front_valid_id}`).show();
                } else {
                    $('#frontValidIdImage').hide();
                }
    
                if (data.back_valid_id) {
                    $('#backValidIdLabel').text(`Current: ${data.back_valid_id}`);
                    $('#backValidIdImage').attr('src', `../uploads/${data.back_valid_id}`).show();
                } else {
                    $('#backValidIdImage').hide();
                }
    
                // Show the modal with citizen details
                $('#citizenModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching social service details:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch social service details.'
                });
            }
        });
    });
    
    // Image modal preview
    $('#citizenModal').on('click', 'img', function() {
        const imgSrc = $(this).attr('src');
        const imgAlt = $(this).attr('alt');
    
        $('#modalImage').attr('src', imgSrc);
        $('#imageModalLabel').text(imgAlt || 'Preview');
        $('#imageModal').modal('show');
    });
    
    // Initialize modals
    $('#imageModal').on('hidden.bs.modal', function() {
        $('#modalImage').attr('src', '');
    });
    

    $('#socialServicesTable').on('click', '.edit-social-service', function(e) {
        e.preventDefault();
        var socialServiceId = $(this).data('id');
        $.ajax({
            url: 'model/social_services/get_.php',
            type: 'GET',
            data: { socialServiceId: socialServiceId },
            dataType: 'json',
            success: function(data) {
                $('#editsocialServiceId').val(data.socialService_id);
                $('#editServiceName').val(data.socialService);
                $('#editFullName').val(data.fullname);
                $('#editEndorsedBy').val(data.endorsedBy);
                $('#amountRedeem').val(data.amountRedeem);
                var fileContainer = $('#editFileContainer');
                if (data.uploadFilePath) {
                    var files = JSON.parse(data.uploadFilePath); // Parse JSON string
                    
                    var fileLinks = '';
                    for (var type in files) {
                        if (files.hasOwnProperty(type)) {
                            var fileName = files[type];
                            fileLinks += `<a href="../files/${fileName}" download class="btn btn-link me-1 ">
                                            <i class="fa fa-download"></i> ${type.replace(/([A-Z])/g, ' $1').trim()}
                                          </a>`;
                        }
                    }
            
                    fileContainer.html(fileLinks || '<span>No files available</span>');
                } else {
                    fileContainer.html('<span>No file available</span>');
                }
    
                $('#editStatus').val(data.status);
                $('#editSocialServiceModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching social service details:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch social service details.'
                });
            }
        });
    });

    $('#submitEdit').on('click', function() {
        var formData = $('#editSocialServiceForm').serialize();
        $.ajax({
            url: 'model/social_services/edit_.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Social service updated successfully.'
                    });
                    $('#editSocialServiceModal').modal('hide');
                    fetchSocialServicesList();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'An error occurred while updating the social service.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating social service:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the social service.'
                });
            }
        });
    });

    $('#socialServicesTable').on('click', '.delete-social-service', function(e) {
        e.preventDefault();
        var serviceId = $(this).data('service-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'model/social_services/del_.php',
                    type: 'POST',
                    data: { serviceId: serviceId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Social service has been deleted.'
                            }).then(function() {
                                fetchSocialServicesList();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting social service:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete social service.'
                        });
                    }
                });
            }
        });
    });
});