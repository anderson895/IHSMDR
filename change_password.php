<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Change Password</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/png" href="https://via.placeholder.com/32x32" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.1/iconfont/material-icons.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-7 col-lg-6">
                <!-- Change Password Form -->
                <div class="card shadow-lg mt-4" id="changePasswordCard">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-center mb-4">Change Password</h3>
                        <p class="text-center mb-4">Enter a new password and confirm it to reset your password. Make sure it matches and meets the requirements.</p>
                        <form id="formChangePassword" class="mb-3">
                            <!-- Hidden Token Field -->
                            <input type="hidden" id="resetToken" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required>
                                <label for="newPassword">New Password</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                                <label for="confirmPassword">Confirm Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Change Password</button>
                        </form>
                        <a href="index.php" class="btn btn-light w-100">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX for Change Password -->
    <script>
     $(document).ready(function() {
    $('#formChangePassword').on('submit', function(e) {
        e.preventDefault();

        // Show SweetAlert2 loading spinner
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Validate passwords match
        const newPassword = $('#newPassword').val();
        const confirmPassword = $('#confirmPassword').val();

        if (newPassword !== confirmPassword) {
            Swal.close(); // Close the loading spinner
            Swal.fire('Error', 'Passwords do not match.', 'error');
            return;
        }

        $.ajax({
            url: 'model/change_password.php',
            type: 'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                Swal.close(); // Close the loading spinner

                if (response.success) {
                    Swal.fire('Success', response.message, 'success').then(() => {
                        window.location.href = 'index.php';
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.close(); // Close the loading spinner
                Swal.fire('Error', 'There was an error processing your request.', 'error');
            }
        });
    });
});

    </script>
</body>
</html>
