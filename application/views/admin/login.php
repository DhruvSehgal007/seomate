<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login Page</title>
  <link rel="stylesheet" href="<?php base_url('assets/template/vendors/mdi/css/materialdesignicons.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/vendors/mdi/css/materialdesignicons.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/template/vendors/css/vendor.bundle.base.css');?>">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url('assets/template/css/style.css');?>">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url('assets/template/images/favicon.png'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('assets/template/css/login.css'); ?>">
</head>

<body>
  <div class="container-scroller d-flex">
    <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
          <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="auth-form-transparent text-left p-3">
              <div class="brand-logo">
              <img src="<?php echo base_url('images/newlogo_one.png'); ?>" alt="logo"/>
              </div>
              <h4>Welcome back!</h4>
              <h6 class="font-weight-light">Happy to see you again!</h6>
              <form class="pt-3" method="post" action="<?php echo base_url('login/authenticate'); ?>">
                <div class="form-group">
                  <label for="username">Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="text" name="username" class="form-control form-control-lg border-left-0" id="username" placeholder="Username" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="password" name="password" class="form-control form-control-lg border-left-0" id="password" placeholder="Password" required>
                    <!--  -->
                    <div class="input-group-append eye_div">
                      <button type="button" class="btn btn-outline-secondary eye_div_btn" onclick="togglePasswordVisibility()">
                        <i id="toggleIcon" class="mdi mdi-eye-off-outline eye_div_btn_i"></i>
                      </button>
                    </div>
                    <!--  -->
                  </div>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check form-check-primary">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" name="remember">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="my-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">LOGIN</button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register-2.html" class="text-primary create_link">Create</a>
                </div>
              </form>
              <?php if (isset($error)) : ?>
                <script>
                  alert('<?php echo $error; ?>');
                </script>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-lg-6 login-half-bg d-none d-lg-flex flex-row">
            <p class="text-white font-weight-medium text-center flex-grow align-self-end">© 2024 E-karigar Technologies. All rights reserved</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function togglePasswordVisibility() {
      var passwordInput = document.getElementById('password');
      var toggleIcon = document.getElementById('toggleIcon');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('mdi-eye-off-outline');
        toggleIcon.classList.add('mdi-eye-outline');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('mdi-eye-outline');
        toggleIcon.classList.add('mdi-eye-off-outline');
      }
    } 
  </script>

  <script src="<?php echo base_url('assets/template/vendors/js/vendor.bundle.base.js'); ?>"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="<?php echo base_url('assets/template/vendors/chart.js/Chart.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/template/js/jquery.cookie.js'); ?>" type="text/javascript"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url('assets/template/js/off-canvas.js'); ?>"></script>
  <script src="<?php echo base_url('assets/template/js/hoverable-collapse.js'); ?>"></script>
  <script src="<?php echo base_url('assets/template/js/template.js'); ?>"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url('assets/template/js/dashboard.js'); ?>"></script>
  <!-- End custom js for this page-->
</body>

</html>
