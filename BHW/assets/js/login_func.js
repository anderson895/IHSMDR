
   document.getElementById("formAdminAuthentication").addEventListener("submit", function(event) {
      event.preventDefault();
      handleLogin('admin');
   });

   function handleLogin(userType) {
      let emailInput, passwordInput;
      emailInput = document.getElementById("adminUsername");
      passwordInput = document.getElementById("adminPassword");

      const email = emailInput.value;
      const password = passwordInput.value;
      removeError(emailInput);
      removeError(passwordInput);

      const loadingIndicator = showLoading();

      setTimeout(function() {
         fetch("model/login.php", { // Adjust the path to your login.php file
               method: "POST",
               headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
               },
               body: new URLSearchParams({
                  username: email,
                  password: password,
               }),
            })
            
            .then(response => response.json())
            .then(data => {
               console.log("Fetch Success:", data);

               if (data.success === true) {
                  const userType = data.user;
                  switch (userType) {
                     case "admin":
                        sessionStorage.setItem("userType", "admin");
                        window.location.href = "pages/admin/";
                        break;
                     case "branch":
                        sessionStorage.setItem("userType", "branch");
                        window.location.href = "pages/branch/";
                        break;
                     default:
                        console.error("Unknown userType:", userType);
                  }
               } else {
                  showError(emailInput, 'Login Failed', data.message || 'An error occurred during login.');
                  showError(passwordInput);
               }
            })
            .catch(error => {
               showError(emailInput, 'Error', 'Invalid credentials. Please try again.');
            })
            .finally(() => {
               loadingIndicator.close();
            });
      }, 500);
   }

   function showError(input, title, message) {
      input.classList.add("border", "alert-danger");
      Swal.fire({
         icon: 'error',
         title: title,
         text:'Invalid credentials. Please try again.',
      });
   }
   

   function removeError(input) {
      input.classList.remove("border", "border-danger");
   }

   function showLoading() {
      return Swal.fire({
         title: 'Logging in...',
         allowOutsideClick: false,
         showConfirmButton: false,
         onBeforeOpen: () => {
            Swal.showLoading();
         }
      });
   }