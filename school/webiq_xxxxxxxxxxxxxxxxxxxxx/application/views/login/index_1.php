<!doctype html>
<html >

    
<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>iCAM Login </title>
		<meta name="keywords" content="" />
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
                <!-- Fav Icons  -->
                <link rel="icon" href="<?php echo BASEURL.'assets/images/favicons/'.FAVICONLINK;?>" type="image/gif" sizes="16x16">
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/magnific-popup/magnific-popup.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme.css" />
        
        <style type="text/css">
            .scrollable .scrollable-content{
                padding: 0 17px 0 0;
            }
        </style>
		
       <script src="<?php echo BASEURL;?>assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body class="login-body">
		<!-- start: page -->
		<section class="body-sign">           
                               
            <div class="center-sign">
                <a href="#" class="logo pull-left">
                    <img src="<?php echo BASEURL.'assets/images/'.LOGOTRANSPARENTLINK;?>" height="65" alt="" />
                </a>

                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign &nbsp; In</h2>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo BASEURL;?>loginsubmit" method="post">
                            <div class="form-group mb-lg">
                                <label>Username</label>
                                <div class="input-group input-group-icon">
                                    <input name="username" type="text" <?php echo set_value('username'); ?> required="" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <label class="pull-left">Password</label>
                                    
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="password" type="password" required="" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <?php if($this->session->flashdata('login_error')){ ?>
                                    <div class="row">
                                                    <div class="col-md-12">
                                                    <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
                                                    <div class="alert alert-danger">    <?php echo $this->session->flashdata('login_error');?>
                                        </div>
                                        </div>
                                    </div>
                            <?php } ?> 
                            
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="checkbox-custom checkbox-default">
                                        <input id="RememberMe" name="rememberme" type="checkbox"/>
                                        <label for="RememberMe">Remember Me</label>
                                        <a href="<?php echo BASEURL;?>resetpassword">Forgot Password</a>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2017. All Rights Reserved.</p>
                </div>                    
            </div>
            
           
		</section>
        
		<!-- end: page -->

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>		
        <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>		
        <script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
        <script src="assets/javascripts/theme.js"></script>
        <script src="assets/javascripts/theme.init.js"></script>
	</body>


</html>