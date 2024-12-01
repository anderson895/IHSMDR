<?php include 'includes/header.php';?>
<body class="bg" >
   <div class="container">
      <div class="row justify-content-center align-items-center min-vh-100">
         <div class="col-md-6 col-lg-6">
            <!-- Login Card -->
            <div class="card shadow-lg mt-4" id="loginCard">
               <div class="card-body p-5">
                  <div class="text-center mb-4">
                     <img src="assets/img/logo/image-logo.png" alt="Company Logo" width="200" class="mb-3">
                     <h3 class="text-responsive">LIBERTAD POLYCLINIC</h3>
                  </div>
                  <form id="formLogin" class="mb-3">
                  <h5 class="alert alert-light">Personal Details</h5>
                     
                     <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="loginEmail" name="loginEmail" placeholder="Enter your email" required>
                        <label for="loginEmail">Email</label>
                     </div>
                     <div class="form-floating mb-3 input-group">
                        <input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="Enter your password" required>
                        <label for="loginPassword">Password</label>
                        <span class="input-group-text" onclick="togglePasswordVisibility('loginPassword', this)">
                        <i class="material-icons">visibility</i>
                        </span>
                     </div>
                     <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" id="remember-me">
                           <label class="form-check-label" for="remember-me">Remember me</label>
                        </div>
                       <!-- <a href="forgot_password.php" class="text-primary">Forgot Password?</a>-->
                     </div>
                     <button type="submit" class="btn btn-primary w-100">Sign In</button>
                  </form>
                
               </div>
            </div>
         </div>
        
</body>
</html> 
<?php include'includes/footer.php';?>