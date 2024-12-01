<!DOCTYPE html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Forgot Password</title>
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
                <!-- Forgot Password Form -->
                <div class="card shadow-lg mt-4" id="forgotPasswordCard">
                    <div class="card-body p-5">
                        <h3 class="fw-bold text-center mb-4">Forgot Password</h3>
                        <p class="text-center mb-4">Enter your email address below to receive instructions on how to reset your password. Please ensure the email is correct.</p>
                        <form id="formForgotPassword" class="mb-3">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="forgotPasswordEmail" name="forgotPasswordEmail" placeholder="Enter your email" required>
                                <label for="forgotPasswordEmail">Email Address</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                        <a href="index.php" id="backToLogin" class="btn btn-light w-100">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX for Forgot Password -->
    <script>
        $(document).ready(function() {
            $('#formForgotPassword').on('submit', function(e) {
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

                $.ajax({
                    url: 'model/forgot_password.php',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        Swal.close(); // Close the loading spinner

                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
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
