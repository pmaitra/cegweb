<!doctype html>
<html class="fixed dark">


    <head>
        <!-- Basic -->
        <meta charset="UTF-8">

        <title>SSP Login</title>
        <meta name="keywords" content="" />
        <meta name="description" content="">
        <meta name="author" content="">
<!--        <meta http-equiv="X-Frame-Options" content="deny">-->
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Vendor CSS -->
        <link rel="stylesheet" href="assets/sspassets/vendor/bootstrap/css/bootstrap.css" />

        <link rel="stylesheet" href="assets/sspassets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="assets/sspassets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="assets/sspassets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

        <!-- Specific Page Vendor CSS -->		
        <link rel="stylesheet" href="assets/sspassets/vendor/jquery-ui/jquery-ui.css" />		
        <link rel="stylesheet" href="assets/sspassets/vendor/jquery-ui/jquery-ui.theme.css" />		
        <link rel="stylesheet" href="assets/sspassets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />		
        <link rel="stylesheet" href="assets/sspassets/vendor/morris.js/morris.css" />
        <link rel="stylesheet" href="assets/sspassets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="assets/sspassets/stylesheets/main.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="assets/sspassets/stylesheets/theme-custom.css">

        <!-- Head Libs -->
        <script src="assets/sspassets/vendor/modernizr/modernizr.js"></script>		
        <script src="assets/sspassets/vendor/style-switcher/style.switcher.localstorage.js"></script>
        <style type="text/css">
            .dataTables_wrapper .DTTT.btn-group{
                display: none !important;
            }
        </style>


    </head>
    <body>
    
    <!--==========Header 220818===========-->

<header class='main-wrapper header'>
	<div class="container apex">
		<div class="row">

			<nav class="navbar header-navbar" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<div class="logo navbar-brand">
						<a href="#" title="CEG WEB"></a>
					</div>
		     
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<div class="navbar-right">
						
							<div class="wr-soc">
								<div class="header-social">
									<ul class='social-transform unstyled'>
									<li>
										<a href='#' target='blank' class='front'><div class="fa fa-facebook"></div></a>
									</li>
									<li>
										<a href='#' target='blank' class='front'><i class="fa fa-twitter"></i></a>
									</li>
									<li>
										<a href='#' target='blank' class='front'><i class="fa fa-google-plus"></i></a>
									</li>
									<li>
										<a href='#' target='blank' class='front'><i class='fa fa-vimeo-square'></i></a>
									</li>
									</ul>
								</div>
							</div>
						</div>
		    </div><!-- /.navbar-collapse -->
			</nav>
		</div>
	</div>
</header>
 <!--==========content===========-->
 <section class="relative big-slider">
		<div id="form_slider" class='big-bxslider row' data-anchor="form_slider">
			<ul class="form-bxslider xSlider list-unstyled">
				<li class='firstslide'>
					<div class="container relative body-slide">
						<div class="list-forstart fin_1">
							<form action="loginsubmit" method="post">
                             <div class="form-group mb-lg">
                                <div class="input-group input-group-icon">
                                    <input name="username" type="text" placeholder="Roll Number" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <a href="pages-recover-password.html"  class="pull-right">Lost Password?</a>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="password" type="password" placeholder="Password" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="dob" readonly="" placeholder="Date Of Birth" type="text" class="datepicker datepicker-dark form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-calendar "></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group mb-lg">
                                <div class="">
                                    <p><div class="captcha-img"><?php echo $captcha; ?><img id="Imageid" /> </div>
                                     <i class="fa fa-refresh btn-refresh" aria-hidden="true"></i></p>
                                   
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="captcha" type="text" placeholder="Please enter the captcha" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-snowflake-o" aria-hidden="true"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="checkbox-custom checkbox-default">
                                        <input id="RememberMe" name="rememberme" type="checkbox"/>
                                        <label for="RememberMe">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
                                </div>
                            </div>



                        </form>
					</div>
					<div class="img-slider slide-man1 fin_2"></div>
				</li>
			</ul>
		</div>
	</section>   
    
    <div class="container bottom">

		<span class="copyright">
			&copy; Copyright @ 2018 CloudHead Tech. All Rights Reserved.
		</span>
	
	</div>
    
     

        <!-- Vendor -->
        <script src="assets/sspassets/vendor/jquery/jquery.js"></script>		
        <script src="assets/sspassets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>		
        <script src="assets/sspassets/vendor/jquery-cookie/jquery-cookie.js"></script>		
        <script src="assets/sspassets/vendor/style-switcher/style.switcher.js"></script>		
        <script src="assets/sspassets/vendor/bootstrap/js/bootstrap.js"></script>		
        <script src="assets/sspassets/vendor/nanoscroller/nanoscroller.js"></script>		
        <script src="assets/sspassets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>		
        <script src="assets/sspassets/vendor/magnific-popup/jquery.magnific-popup.js"></script>		
        <script src="assets/sspassets/vendor/jquery-placeholder/jquery-placeholder.js"></script>

        <!-- Specific Page Vendor -->		
        <script src="assets/sspassets/vendor/select2/js/select2.js"></script>		
        <script src="assets/sspassets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>		
        <script src="assets/sspassets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>		
        <script src="assets/sspassets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="assets/sspassets/javascripts/theme.js"></script>

        <!-- Theme Custom -->
        <script src="assets/sspassets/javascripts/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="assets/sspassets/javascripts/theme.init.js"></script>

        <!-- Examples -->
        <script src="assets/sspassets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="assets/sspassets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="assets/sspassets/javascripts/tables/examples.datatables.tabletools.js"></script>
        <script>
            var baseUrl = '<?php echo BASEURL;?>';
            $('.datepicker').datepicker({
                    format: 'mm/dd/yyyy',
                 autoclose: true});
           
           $(document).on('click', '.btn-refresh', function(){
                $.ajax({
                    url:baseUrl+'home/refreshCaptcha',
                    dataType: "text",  
                    cache:false,
                    success:function(data){
                       $('.captcha-img').html(data);
                    }
                }); 
           });
           
          </script>
    </body>


</html>