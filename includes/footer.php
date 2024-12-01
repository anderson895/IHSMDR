     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        $(document).ready(function () {
            // Handle login form submission
            $('#formLogin').on('submit', function (event) {
                event.preventDefault();
                handleLogin();
            });
        });

        function handleLogin() {
            const formData = $('#formLogin').serialize(); // Serialize form data
            const loadingIndicator = showLoading('Logging in...');
            
            $.ajax({
                url: 'model/login.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        //console.log('Login successful'); // Log success message
                         window.location.href = data.user; // Redirect on success
                         console.log(data.user);
                    } else {
                        showError('Error', data.message || 'Invalid credentials. Please try again.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error during login:', textStatus, errorThrown); // Log error to console
                 
                },
                complete: function() {
                    loadingIndicator.close(); // Close loading indicator
                }
            });
        }

        function showLoading(message) {
            return Swal.fire({
                title: message,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function showError(title, message) {
            Swal.fire({
                icon: 'error',
                title: title,
                text: message,
            });
        }

        function togglePasswordVisibility(fieldId, icon) {
            const inputField = $(`#${fieldId}`);
            const iconElement = $(icon).find('i');
            if (inputField.attr('type') === 'password') {
                inputField.attr('type', 'text');
                iconElement.text('visibility_off');
            } else {
                inputField.attr('type', 'password');
                iconElement.text('visibility');
            }
        }
        </script>
