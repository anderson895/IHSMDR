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
                                <a href="#" class="edit-btn" data-id="${data.admin_id}">
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
});