<!doctype html>
<html class="fixed">
<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>iCAM Home</title>
		<meta name="keywords" content="" />
		<meta name="description" content="">
		<meta name="author" content="">
                <!-- Fav Icons  --> 
                 <link rel="icon" href="<?php echo BASEURL.'assets/images/favicons/'.FAVICONLINK;?>" type="image/gif" sizes="16x16">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<!-- Specific Page Vendor CSS -->		
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/jquery-ui/jquery-ui.css" />		
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/jquery-ui/jquery-ui.theme.css" />		
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />		
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/morris.js/morris.css" />
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/pnotify/pnotify.custom.css" />
		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme.css" />
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="<?php echo BASEURL;?>assets/vendor/modernizr/modernizr.js"></script>		
<!--                <script src="<?php echo BASEURL;?>assets/vendor/style-switcher/style.switcher.localstorage.js"></script>-->
                
		<style type="text/css">
			.dataTables_wrapper .DTTT.btn-group{
				display: none !important;
			}
			.pager li a {
			    background: #0088cc;
			    color: #fff;
			}
		</style>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="" class="logo">
						<img src="<?php echo BASEURL.'assets/images/'.LOGOLINK;?>" height="50" alt="ICAM_logo" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>			
				<!-- start: search & user box -->
				<div class="header-right">
			
					
			
					<span class="separator"></span>
			
					
			
					<div id="userbox" class="userbox">
						<a href="<?php echo BASEURL.'dashboard'?>" data-toggle="dropdown">
							<figure class="profile-picture">
                                    <?php 
                                   $candidate_personal_details = $this->session->userdata('candidate_details')	;
                                   //echo ROOTURL.'/uploads/profileimages/'.$candidate_personal_details['profile_picture'];
                                   //pr($candidate_personal_details['profile_picture']);
                                    if(!empty($candidate_personal_details['profile_picture']) && file_exists(ROOTURL.'/uploads/profileimages/'.$candidate_personal_details['profile_picture']))
                                    {
                                        $profile_pic = BASEURL.'uploads/profileimages/'.$candidate_personal_details['profile_picture'];
                                    }
                                    else 
                                    {                 
                                        $profile_pic = BASEURL.'assets/images/sample_pic.jpg';
                                    }
                                    ?>
                                    
								<img src="<?php echo $profile_pic;?>" alt="<?php echo $this->session->userdata('loggedinusername');?>"  class="img-circle"  data-lock-picture="<?php echo $profile_pic;?>" />
							</figure>
							<div class="profile-info" data-lock-name="<?php echo $this->session->userdata('loggedinusername');?>" data-lock-email="">
								<span class="name"><?php echo $this->session->userdata('loggedinusername');?></span>
								<span class="role"></span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo BASEURL."profile";?>"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo BASEURL."logout";?>"><i class="fa fa-power-off"></i> Logout</a>
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
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="<?php echo (!empty($front_menu_details)) && ($front_menu_details=='dashboard')?"nav-active":"";?> ">
										<a href="<?php echo BASEURL.'dashboard'?>">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
                                    <?php if(!empty($alumni_flag)){ ?>
                                    <li>
										<a href="<?php echo HOMEURL.'/alumni'?>">
											<i class="glyphicon glyphicon-leaf" aria-hidden="true"></i>
											<span>Alumni</span>
										</a>
									</li>
                                    <?php } ?>
                                    <?php if(!empty($course_list)){ 
                                        foreach ($course_list as $single_course) {
                                    ?>
                                    <li>
										<a href="<?php echo BASEURL.'dashboard'?>">
											<i class="fa fa-columns" aria-hidden="true"></i>
                                            <span title="<?php echo $single_course['name'];?>">
                                    <?php echo strlen($single_course['name']) > 20 ? substr($single_course['name'],0,20)."..." : $single_course['name'];?> </span>
										</a>
									</li>
                                    <?php }} ?>
                                    <li class="<?php echo (!empty($front_menu_details)) && ($front_menu_details=='feedback')?"nav-active":"";?> ">
										<a href="<?php echo BASEURL.'userfeedback'?>">
											<i class="fa fa-list-alt" aria-hidden="true"></i>
											<span>Feedback</span>
										</a>
									</li>
									<li class="nav-parent <?php echo (!empty($front_menu_details)) && ($front_menu_details=='request')?"nav-expanded":"";?>">
								        <a>
									        <i class="fa fa-certificate" aria-hidden="true"></i>
									        <span>Request</span>
								        </a>
								        <ul class="nav nav-children">
								            <li>
								            	<a href="<?php echo BASEURL.'user/request'?>">
													<span>Certificate Request</span>
												</a>
								           </li>
								           <li>
								            	<a href="<?php echo BASEURL.'user/refund'?>">
													<span>Refund Request</span>
												</a>
								           </li>
								        </ul>
								    </li>  
                                        <li class="<?php echo (!empty($front_menu_details)) && ($front_menu_details=='myprofile')?"nav-active":"";?> ">
										<a href="<?php echo BASEURL.'profile'?>">
											<i class="fa fa-user" aria-hidden="true"></i>
											<span>My Profile</span>
										</a>
									</li>
								</ul>
							</nav>
				
							
				
							
						</div>
				
					</div>
				
				</aside>
				<!-- end: sidebar -->
				
