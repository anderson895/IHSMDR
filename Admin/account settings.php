<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
    <div class="page-header p-4"  style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>Account Settings</h4>
                <h6>View/Search Account Settings</h6>
            </div>
       <div class="page-btn">
                <button class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Add Admin User
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
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be appended here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add Admin User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="addFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="addFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="addLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="addEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="addEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="addPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="addPassword" required>
                            <button type="button" class="btn btn-outline-secondary" id="generateAddPassword">
                                <i class="fa fa-key"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="toggleAddPassword">
                                <i class="fa fa-eye" id="add-eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3" hidden>
                        <label for="addUserType" class="form-label">User Type</label>
                        <select class="form-select" id="addUserType" required>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="editUserId">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="editPassword" required>
                            <button type="button" class="btn btn-outline-secondary" id="generateEditPassword">
                                <i class="fa fa-key"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="toggleEditPassword">
                                <i class="fa fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-3" hidden>
                        <label for="editUserType" class="form-label">User Type</label>
                        <select class="form-select" id="editUserType" required>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- js -->
<?php include 'includes/footer.php'; ?>
<script>

$(document).ready(function() {
    // Password Generation and Validation
    function generateStrongPassword() {
        const length = 12; // Increased length for stronger password
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        let password = "";

        do {
            password = "";
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
        } while (!validatePassword(password));

        return password;
    }

    function validatePassword(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{12,}$/;
        return regex.test(password);
    }

    function togglePasswordVisibility(inputSelector, iconSelector) {
        const passwordInput = $(inputSelector);
        const icon = $(iconSelector);

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }

    // Fetch and populate users in DataTable
    function fetchUsers() {
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        $('#dataTable').DataTable({
            ajax: {
                url: 'model/admin accounts/fetch_.php',
                dataSrc: ''
            },
            columns: [
                { data: 'firstName' },
                { data: 'lastName' },
                { data: 'email' },
                { data: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    render: function(data) {
                        return `
                            <div class="table-actions">
                                <a href="#" class="edit-btn" data-id="${data.user_id}">
                                    <img src="assets/img/icons/edit.svg" alt="Edit">
                                </a>
                              
                            </div>`;
                    }
                }
            ],
            select: {
                style: 'multi',
                selector: 'td:first-child',
            }
        });
    }

    // Edit User Modal
    $('#dataTable').on('click', '.edit-btn', function(e) {
        e.preventDefault();
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: 'model/admin accounts/get_.php',
            type: 'GET',
            data: { userId: userId },
            success: function(response) {
                $('#editUserId').val(response.admin_id);
                $('#editFirstName').val(response.firstName);
                $('#editLastName').val(response.lastName);
                $('#editEmail').val(response.email);
                $('#editUserType').val(response.user_type);
                $('#editPassword').val('');
                $('#editUserModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching user data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to fetch user data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Toggle and Generate Password
    $('#toggleEditPassword').click(function() {
        togglePasswordVisibility('#editPassword', '#eye-icon');
    });

    $('#generateEditPassword').click(function() {
        const suggestedPassword = generateStrongPassword();
        $('#editPassword').val(suggestedPassword);
        togglePasswordVisibility('#editPassword', '#eye-icon');
    });

      // Add User Form Submission
      $('#addUserForm').submit(function(e) {
        e.preventDefault();
        const userData = {
            firstName: $('#addFirstName').val(),
            lastName: $('#addLastName').val(),
            email: $('#addEmail').val(),
            password: $('#addPassword').val(),
            user_type: $('#addUserType').val()
        };

        $.ajax({
            url: 'model/admin accounts/add_.php',
            type: 'POST',
            data: userData,
            dataType: 'json',
            success: function(response) {
                if (response.message) {
                    $('#addUserModal').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(fetchUsers);
                } else if (response.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Unknown response format',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error adding user: ' + error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error adding user:', error);
            }
        });
    });

    // Save Changes
    $('#editUserForm').submit(function(e) {
        e.preventDefault();
        const userData = {
            userId: $('#editUserId').val(),
            firstName: $('#editFirstName').val(),
            lastName: $('#editLastName').val(),
            email: $('#editEmail').val(),
            password: $('#editPassword').val(),
            user_type: $('#editUserType').val()
        };

        $.ajax({
            url: 'model/admin accounts/edit_.php',
            type: 'POST',
            data: userData,
            dataType: 'json',
            success: function(response) {
                if (response.message) {
                    $('#editUserModal').modal('hide');
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(fetchUsers);
                } else if (response.error) {
                    Swal.fire({
                        title: 'Error!',
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Unknown response format',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Error editing user: ' + error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                console.error('Error editing user:', error);
            }
        });
    });

    // Toggle and Generate Password for Add User
    $('#toggleAddPassword').click(function() {
        togglePasswordVisibility('#addPassword', '#add-eye-icon');
    });

    $('#generateAddPassword').click(function() {
        const suggestedPassword = generateStrongPassword();
        $('#addPassword').val(suggestedPassword);
        togglePasswordVisibility('#addPassword', '#add-eye-icon');
    });

    // Initial fetch
    fetchUsers();
}); </script>