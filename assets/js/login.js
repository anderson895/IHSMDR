$(document).ready(function() {
    function showError(title, message, preventClose) {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: message,
            allowOutsideClick: !preventClose,
            showConfirmButton: !preventClose,
            timer: preventClose ? 30000 : undefined,
            timerProgressBar: preventClose
        });
    }

    function handleLogin(userType) {
        let $emailInput = userType === 'user' ? $('#userUsername') : $('#adminUsername');
        let $passwordInput = userType === 'user' ? $('#userPassword') : $('#adminPassword');

        const email = $emailInput.val();
        const password = $passwordInput.val();

        $emailInput.removeClass('is-invalid');
        $passwordInput.removeClass('is-invalid');

        $.ajax({
            url: "model/login.php",
            type: "POST",
            data: {
                username: email,
                password: password
            },
            dataType: "json",
            success: function(data) {
                if (data.success === true) {
                    const userType = data.user.user_type;
                    console.log("User Role: " + userType);

                    sessionStorage.setItem("userType", userType);
                    switch (userType) {
                        case "admin":
                        case "member":
                            window.location.href = `${userType}/views/`;
                            break;
                        default:
                            console.error("Unknown userType:", userType);
                    }
                } else {
                    if (data.message && data.message.includes("You have exceeded the maximum number of login attempts")) {
                        showError('', data.message, true);
                    } else {
                        showError('Error', data.message || 'An error occurred during login.');
                    }
                }
            },
            error: function() {
                showError('Error', 'Invalid credentials. Please try again.');
            }
        });
    }

    $('#formAdminAuthentication').on('submit', function(e) {
        e.preventDefault();
        handleLogin('admin');
    });
});