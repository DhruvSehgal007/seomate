<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SEO Mate</title>
  <!-- base:css -->
  <link rel="stylesheet" href="<?php echo base_url('vendors/mdi/css/materialdesignicons.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('vendors/css/vendor.bundle.base.css '); ?>">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('css/offpage.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('css/onpage.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('css/offpage.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('css/offpage.css'); ?>">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url('images/favicon.png'); ?>">
</head>
<body>
  <div class="container-scroller d-flex">
   
    <!-- partial:./partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">


      <li class="nav-item sidebar-category">
      <a class="navbar-brand brand-logo" href="<?php echo base_url('admin/dashboard'); ?>"><img src="<?php echo base_url('images/new_logo_two.png'); ?>" alt="logo"/></a>
        </li>



        <li class="nav-item sidebar-category">
          <p>Navigation</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">
            <i class="mdi mdi-view-quilt menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            <!-- <div class="badge badge-info badge-pill">2</div> -->
          </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>Components</p>
          <span></span>
        </li>



        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('admin/industry_category'); ?>" >
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Add Industry</span>
          </a>
        </li>


        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('admin/clients'); ?>" >
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Add Clients</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('admin/project'); ?>" >
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Add projects</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('admin/onpage'); ?>" >
            <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Add Data</span>
          </a>
        </li>


        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="<?php echo base_url('#offpage_cat'); ?>" aria-expanded="false" aria-controls="offpage_cat">
            <i class="mdi mdi-palette menu-icon"></i>
            <span class="menu-title">Off Page Category</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="offpage_cat">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('admin/off_page_category'); ?>">Add category</a></li>
              
            </ul>
          </div>
        </li>




     
      

        


        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="<?php echo base_url('#onpage_cat'); ?>" aria-expanded="false" aria-controls="onpage_cat">
            <i class="mdi mdi-palette menu-icon"></i>
            <span class="menu-title">On Page Category</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="onpage_cat">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('admin/on_page_category'); ?>">Add main category</a></li>
              <li class="nav-item"> <a class="nav-link" href="<?php echo base_url('admin/on_page_sub_category'); ?>">Add sub category</a></li>
              
            </ul>
          </div>
        </li>



        
        <li class="nav-item sidebar-category">
          <p>Configuration</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('admin/manage_users'); ?>">
            <i class="mdi mdi-emoticon menu-icon"></i>
            <span class="menu-title">manage Users</span>
          </a>
        </li>



        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('admin/assigned_user'); ?>">
            <i class="mdi mdi-emoticon menu-icon"></i>
            <span class="menu-title">Assigned User</span>
          </a>
        </li>

       
        
      </ul>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
       

<!-- Toggle Button -->
<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize" id="menu-toggle">
    <span class="mdi mdi-menu"></span>
</button>


          

          
          <?php if (isset($username) && $username): ?>
                    <span class="welcome_name">Welcome back, <?php echo htmlspecialchars($username); ?></span>
                <?php else: ?>
                    <span class="welcome_name">Welcome back, Guest</span>
                <?php endif; ?>
          <ul class="navbar-nav navbar-nav-right">
          <div class="navbar-menu-wrapper navbar-search-wrapper d-none d-lg-flex align-items-center">
          
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" href="<?php echo base_url('#'); ?>" data-bs-toggle="dropdown" id="profileDropdown">
                <img src="<?php echo base_url('images/faces/face5.jpg'); ?>" alt="profile"/>
               
                <!--  -->
                <?php if (isset($username) && $username): ?>
                    <span class="nav-profile-name"><?php echo htmlspecialchars($username); ?></span>
                <?php else: ?>
                    <span class="nav-profile-name">Guest</span>
                <?php endif; ?>
                <!--  -->
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item">
                  <i class="mdi mdi-settings text-primary"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="<?php echo base_url('admin/login'); ?>">
                  <i class="mdi mdi-logout text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
           
          </ul>
        </div>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
        
      </nav>