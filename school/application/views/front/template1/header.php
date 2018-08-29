<!doctype html>
<html class="boxed" data-style-switcher-options="{'layoutStyle': 'boxed'}">
   <head>
      <!-- Basic -->
      <meta charset="UTF-8">
      <title>SSP - Students</title>
      <meta name="keywords" content="" />
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- <meta http-equiv="X-Frame-Options" content="deny">-->
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <!-- Web Fonts  -->
      <!-- Vendor CSS -->
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/bootstrap/css/bootstrap.css" />
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/font-awesome/css/font-awesome.css" />
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/magnific-popup/magnific-popup.css" />
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
      <!-- Specific Page Vendor CSS -->		
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/jquery-ui/jquery-ui.css" />
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/jquery-ui/jquery-ui.theme.css" />
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/morris.js/morris.css" />
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
      <!-- Theme CSS -->
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/stylesheets/theme.css" />
      <!-- Theme Custom CSS -->
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/stylesheets/theme-custom.css">
      <!-- Head Libs -->
      <script src="<?php echo BASEURL."assets/ssp";?>assets/vendor/modernizr/modernizr.js"></script>		
      <script src="<?php echo BASEURL."assets/ssp";?>assets/vendor/style-switcher/style.switcher.localstorage.js"></script>
      <?php if(!empty($event_calender_flag)){ ?>
      <link rel="stylesheet" href="<?php echo BASEURL."assets/ssp";?>assets/eventc/css/calendar.css">
      <?php } ?>
      <style type="text/css">
         .dataTables_wrapper .DTTT.btn-group{
         display: none !important;
         }
      </style>
   </head>
   <body>
      <section class="body">
      <!-- start: header -->
      <header class="header">
         <div class="logo-container">
            <a href="3" class="logo">
            <img src="<?php echo BASEURL."assets/ssp";?>assets/images/logo5.png" height="50" alt="NISM_logo" />
            </a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
               <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
         </div>
         <!-- start: search & user box -->
         <div class="header-right hidden-xs">
            <div id="userbox" class="userbox">
               <a href="#" data-toggle="dropdown">
                  <figure class="profile-picture">
                     <img src="<?php echo BASEURL."assets/ssp";?>assets/images/%21logged-user.jpg" alt="Joseph Doe" class="img-circle" data-lock-picture="<?php echo BASEURL."assets/ssp";?>assets/images/%21logged-user.jpg" />
                  </figure>
                  <div class="profile-info" data-lock-name="" data-lock-email="">
                     <span class="name" title="<?php echo $this->session->userdata('studentName');?>"><?php echo $this->session->userdata('studentInitialName');?></span>
                     <span class="role">Student</span>
                  </div>
                  <i class="fa custom-caret"></i>
               </a>
               <div class="dropdown-menu">
                  <ul class="list-unstyled">
                     <li class="divider"></li>
                     <li>
                        <a role="menuitem" tabindex="-1" href="<?php echo BASEURL.'student/profile'?>"><i class="fa fa-user"></i> My Profile</a>
                     </li>
                     <li>
                        <a role="menuitem" tabindex="-1" href="<?php echo BASEURL.'home/passwordreset'?>"><i class="fa fa-key"></i> Change Password</a>
                     </li>
                     <li>
                        <a role="menuitem" tabindex="-1" href="<?php echo BASEURL.'logout';?>"><i class="fa fa-power-off"></i> Logout</a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
         <!-- end: search & user box -->
      </header>
      <!-- end: header -->
      <div class="inner-wrapper">
      <!-- start: sidebar -->
      <aside id="sidebar-left" class="sidebar-left">
         <div class="sidebar-header">
            <div class="sidebar-title" style="font-size: 1.8rem;">
              <b> Navigation</b>
            </div>
            <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
               <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
         </div>
         <div class="nano">
            <div class="nano-content">
               <nav id="menu" class="nav-main" role="navigation">
                  <ul class="nav nav-main">
                     <li>
                        <a href="<?php echo BASEURL.'school/cegweb/dashboard'?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>Dashboard</span>
                        </a>
                     </li>
                     <?php 
                     $accademicList = $this->session->userdata('ay_session_data');
                     if(!empty($accademicList))
                     {
                        foreach ($accademicList as $accademicDetails) {

                     ?>
                     <li class="nav-parent <?php echo (!empty($menu_details) && $menu_details == 'student' && !empty($front_menu_ay) && $front_menu_ay == $accademicDetails['slug'] )?"nav-expanded":""?>">
                        <a>
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        <span>Academic year – <?php echo $accademicDetails['session'];?></span>
                        </a>
                        <ul class="nav nav-children ">
<!--                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'general')?"nav-active":""?>" >
                              <a href="<?php echo BASEURL.'student/general'?>">
                              General Details
                              </a>
                           </li>-->
                            <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'notes')?"nav-active":""?>" >
                                <a href="<?php echo BASEURL.'student/notes/'.$accademicDetails['slug'];?>">
                              Notes
                              </a>
                           </li>
                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'event')?"nav-active":""?>" >
                                <a href="<?php echo BASEURL.'student/events/'.$accademicDetails['slug'];?>">
                              Events
                              </a>
                           </li>
                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'achievements')?"nav-active":""?>" >
                                <a href="<?php echo BASEURL.'student/achievements/'.$accademicDetails['slug'];?>">
                              Achievements
                              </a>
                           </li>
                           
<!--                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'fees')?"nav-active":""?>" >
                              <a href="<?php echo BASEURL.'student/fees'?>">
                              Session Fees
                              </a>
                           </li>-->
                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'attendance')?"nav-active":""?>" >
                              <a href="<?php echo BASEURL.'student/attendance/'.$accademicDetails['slug'];?>">
                              Attendance
                              </a>
                           </li>
                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'leave')?"nav-active":""?>" >
                              <a href="<?php echo BASEURL.'student/leave/'.$accademicDetails['slug'];?>">
                              Leave Details
                              </a>
                           </li>
                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'disciplinary')?"nav-active":""?>" >
                                <a href="<?php echo BASEURL.'student/action/'.$accademicDetails['slug'];?>">
                              Disciplinary Action
                              </a>
                           </li>
<!--                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'routine')?"nav-active":""?>" >
                            <a href="<?php echo BASEURL.'student/routine'?>">
                              Exam Routine
                              </a>
                           </li>
                           <li class="<?php echo (!empty($front_menu_details) && $front_menu_details == 'marks')?"nav-active":""?>" >
                              <a href="<?php echo BASEURL.'student/marks'?>">
                              Exam Marks
                              </a>
                           </li>-->
<!--                           <li>
                              <a href="<?php echo BASEURL.'promotion'?>">
                              Promotion
                              </a>
                           </li>-->
                        </ul>
                     </li>
                    <?php  
                        }
                    }
                    ?>
                     <li class="hidden-sm visible-xs">
                        <a href="<?php echo BASEURL.'student/profile'?>">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>Profile</span>
                        </a>
                     </li>
                     <li class="hidden-sm visible-xs">
                        <a href="<?php echo BASEURL.'logout'?>">
                        <i class="fa fa-power-off" aria-hidden="true"></i>
                        <span>Logout</span>
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>
      </aside>
      <!-- end: sidebar -->