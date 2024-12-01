<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4"  style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
            <h4>Employee Account List</h4>
            <h6>View/Search Employee Accounts</h6>
            </div>  <div class="page-btn">
                <!-- Button to trigger modal -->
                <button class="btn btn-added" data-bs-toggle="modal" data-bs-target="#adduserModal">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Add User
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
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                        <!-- Add more columns as needed -->
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

    <!-- js -->
    <?php include 'includes/footer.php'; ?>
    <?php include 'modal/users/add_.php'; ?>
    <?php include 'modal/users/edit_.php'; ?>
    <script>$(document).ready(function() {
          
          $('#generatePassword').click(function() {
              const suggestedPassword = generateStrongPassword();
              $('#password').val(suggestedPassword);
          });
      
          // Toggle password visibility
          $('#togglePassword').click(function() {
              var passwordInput = $('#password');
              var icon = $(this).find('i');
              
              if (passwordInput.attr('type') === 'password') {
                  passwordInput.attr('type', 'text');
                  icon.removeClass('fa-eye').addClass('fa-eye-slash');
              } else {
                  passwordInput.attr('type', 'password');
                  icon.removeClass('fa-eye-slash').addClass('fa-eye');
              }
          });
      
      
          
          // Validate password strength
          function validatePassword(password) {
                      var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/;
                      return regex.test(password);
                  }
      
                  function generateStrongPassword() {
                  const length = 8; // Length of the generated password
                  const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*"; // Characters to include in the password
                  let password = "";
      
                  // Loop until a valid password is generated
                  do {
                      password = "";
                      for (let i = 0; i < length; i++) {
                          const randomIndex = Math.floor(Math.random() * charset.length);
                          password += charset[randomIndex];
                      }
                  } while (!validatePassword(password));
      
                  return password;
              }
      
          
          // Function to fetch users and populate the DataTable
          function fetchUsers() {
              if ($.fn.DataTable.isDataTable('#dataTable')) {
                  $('#dataTable').DataTable().destroy();
              }
              // Initialize DataTable with column definitions
              var dataTable = $('#dataTable').DataTable({
              columns: [
                  { data: 'name', orderable: true },
                  { data: 'email' },
                  { data: 'user_type' },
                  { data: 'created_at' },
                  {
                      data: null,
                      orderable: false,
                      render: function(data, type, row) {
                          return `
                          <div class="table-actions">
                              <a href="#" class="edit-btn" data-id="${data.user_id}">
                                  <img src="assets/img/icons/edit.svg" alt="Edit">
                              </a>
                              <a href="#" class="delete-btn" data-id="${data.user_id}">
                              <img src="assets/img/icons/delete.svg" alt="Delete">
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
      
      
              // Edit button click event
              $('#dataTable').on('click', '.edit-btn', function(e) {
                  e.preventDefault();
                  var userId = $(this).data('id');
                  $.ajax({
                      url: 'model/users/get_.php', // Adjust the URL to your endpoint
                      type: 'GET',
                      data: { userId: userId },
                      success: function(response) {
                          // Populate the edit modal with user data
                          $('#editUserId').val(response.user_id); // Assuming you have an input field with id "editUserId" for storing user ID
                          $('#editFirstName').val(response.firstName);
                          $('#editLastName').val(response.lastName);
                          $('#editPassword').val('');
                          $('#editEmail').val(response.email);// Assuming response.user_type contains the user type value received from the server
                          var userType = response.user_type;
                          // Select the <select> element
                          var editUserTypeSelect = document.getElementById("editUserType");
      
                          // Loop through the options to find the one with the matching value
                          for (var i = 0; i < editUserTypeSelect.options.length; i++) {
                              if (editUserTypeSelect.options[i].value === userType) {
                                  // Set the selected attribute of the matching option
                                  editUserTypeSelect.options[i].selected = true;
                                  break; // Exit the loop once a match is found
                              }
                          }
      
                          //$('#editPassword').val(response.password);
      
                          // Show the edit modal
                          $('#editUserModal').modal('show');
                      },
                      error: function(xhr, status, error) {
                          console.error('Error fetching user data:', error);
                          // Handle error if needed
                      }
                  });
              });
      
          // Toggle password visibility in Edit User modal
          $('#toggleEditPassword').click(function() {
              var passwordInput = $('#editPassword');
              var eyeIcon = $('#eye-icon');
              
              if (passwordInput.attr('type') === 'password') {
                  passwordInput.attr('type', 'text');
                  eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
              } else {
                  passwordInput.attr('type', 'password');
                  eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
              }
          });
      
                  // Generate and fill password field in Edit User modal
          $('#generateEditPassword').click(function() {
              const suggestedPassword = generateStrongPassword();
              $('#editPassword').val(suggestedPassword);
          });
      
          // Handle form submission to edit a user
          $('#editUserForm').submit(function(e) {
              e.preventDefault();
              var userId = $('#editUserId').val();
              var firstName = $('#editFirstName').val();
              var lastName = $('#editLastName').val();
              var email = $('#editEmail').val();
              var password = $('#editPassword').val();
              var user_type = $('#editUserType').val();
              // Perform AJAX request to edit the user
          
              $.ajax({
                  url: 'model/users/edit_.php',
                  type: 'POST',
                  data: {
                      userId: userId,
                      firstName: firstName,
                      lastName: lastName,
                      email: email,
                      password: password,
                      user_type: user_type
                  },
                  dataType: 'json',
                  success: function(response) {
                    console.log(user_type);
                      // Display the message with SweetAlert
                      if (response.hasOwnProperty('message')) {
                          $('#editUserModal').modal('hide'); // Hide the edit modal
                          Swal.fire({
                              title: 'Success!',
                              text: response.message,
                              icon: 'success',
                              confirmButtonText: 'OK'
                          }).then(function() {
                              fetchUsers(); // Refresh user list
                          });
                      } else if (response.hasOwnProperty('error')) {
                          // Show error message with SweetAlert
                          Swal.fire({
                              title: 'Error!',
                              text: response.error,
                              icon: 'error',
                              confirmButtonText: 'OK'
                          });
                      } else {
                          // Handle unexpected response
                          Swal.fire({
                              title: 'Error!',
                              text: 'Unknown response format',
                              icon: 'error',
                              confirmButtonText: 'OK'
                          });
                      }
                  },
                  error: function(xhr, status, error) {
                      // Show error message with SweetAlert
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
      
      
      // Delete button click event
          $('#dataTable').on('click', '.delete-btn', function(e) {
              e.preventDefault();
              var userId = $(this).data('id');
              
              // Show SweetAlert confirmation dialog
              Swal.fire({
                  title: 'Are you sure?',
                  text: 'You are about to delete this user. This action cannot be undone.',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!',
                  cancelButtonText: 'Cancel'
              }).then((result) => {
                  if (result.isConfirmed) {
                      // Proceed with delete operation
                      deleteUser(userId);
                  }
              });
          });
      
          // Function to delete the user via AJAX
          function deleteUser(userId) {
              // Perform AJAX request to delete the user
              $.ajax({
                  url: 'model/users/del_.php',
                  type: 'GET',
                  data: { userId: userId },
                  success: function(response) {
                      Swal.fire({
                          title: 'Success!',
                          text: JSON.parse(response).message,
                          icon: 'success',
                          confirmButtonText: 'OK'
                      }).then(function() {
                          fetchUsers(); // Refresh user list
                      });
                  },
                  error: function(xhr, status, error) {
                      // Show error message with SweetAlert
                      Swal.fire({
                          title: 'Error!',
                          text: 'Error deleting user: ' + error,
                          icon: 'error',
                          confirmButtonText: 'OK'
                      });
                  }
              });
          }
      
      
              // Fetch data using Ajax and populate the table
              $.ajax({
                  url: 'model/users/fetch_.php',
                  type: 'GET',
                  dataType: 'json',
                  success: function (data) {
                      dataTable.clear().rows.add(data).draw();
                  },
                  error: function (xhr, status, error) {
                      console.error('Ajax request failed: ' + status + ', ' + error);
                      $('#errorContainer').text('Error loading data: ' + error).show();
                  }
              });
          }
      
          // Call fetchUsers function when the page loads
          fetchUsers();
          // Handle form submission to add a new user
          $('#addUserForm').submit(function(e) {
              e.preventDefault();
              var password = $('#password').val();
      
              if (!validatePassword(password)) {
                  // Show error message if password doesn't meet criteria
                  Swal.fire({
                      title: 'Error!',
                      text: 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.',
                      icon: 'error',
                      confirmButtonText: 'OK'
                  });
                  return;
              }
      
              $.ajax({
                  type: "POST",
                  url: "model/users/add_.php",
                  data: $(this).serialize(),
                  success: function(response) {
                      $('#adduserModal').modal('hide');
                      // Clear form fields
                      $('#firstName').val('');
                      $('#lastName').val('');
                      $('#email').val('');
                      // Show success message with SweetAlert
                      Swal.fire({
                          title: 'Success!',
                          text: 'User added successfully',
                          icon: 'success',
                          confirmButtonText: 'OK'
                      }).then(function() {
                          // Refresh user list or append the new user dynamically
                          fetchUsers(); // Call fetchUsers to update the DataTable
                      });
                  },
                  error: function(xhr, status, error) {
                      // Show error message with SweetAlert
                      Swal.fire({
                          title: 'Warning!',
                          text: 'Email is already taken. Please try again: ',
                          icon: 'warning',
                          confirmButtonText: 'OK'
                      });
                  }
              });
          });
      
      });</script>