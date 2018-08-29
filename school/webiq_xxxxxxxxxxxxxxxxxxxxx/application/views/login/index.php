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
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/bootstrap/css/bootstrap.css" />

        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

        <!-- Specific Page Vendor CSS -->		
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-ui/jquery-ui.css" />		
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-ui/jquery-ui.theme.css" />		
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />		
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/morris.js/morris.css" />
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/stylesheets/theme.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo BASEURL . "assets/ssp"; ?>assets/stylesheets/theme-custom.css">

        <!-- Head Libs -->
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/modernizr/modernizr.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/style-switcher/style.switcher.localstorage.js"></script>
        <style type="text/css">
            .dataTables_wrapper .DTTT.btn-group{
                display: none !important;
            }
        </style>


    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign">
            <div class="center-sign">
                <a href="#" class="logo pull-left hidden-xs">
                    <img src="<?php echo BASEURL . "assets/ssp"; ?>assets/images/logo_wht.png" alt="" />
                </a>
                <a href="#" class="logo pull-left hidden-sm visible-xs" style="padding-top: 20px;">
                    <img src="<?php echo BASEURL . "assets/ssp"; ?>assets/images/logo_wht.png" alt="" width="220" />
                </a>
                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo BASEURL; ?>loginsubmit" method="post">
                            <?php if ($this->session->flashdata('login_error')) { ?>
                                <div class="alert alert-danger"> <?= $this->session->flashdata('login_error') ?> </div>
                            <?php } ?>
                            <div class="form-group mb-lg">
                                <label>Roll Number</label>
                                <div class="input-group input-group-icon">
                                    <input name="username" type="text" class="form-control input-lg" />
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
                                    <a href="pages-recover-password.html" class="pull-right">Lost Password?</a>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="password" type="password" class="form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <label class="pull-left">Date of Birth</label>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="dob" readonly="" type="text" class="datepicker datepicker-dark form-control input-lg" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-calendar "></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group mb-lg">
                                <div class="">
                                    <p><div class="captcha-img"><?php echo $captcha; ?> </div>
                                     <i class="fa fa-refresh btn-refresh" aria-hidden="true"></i></p>
                                    <label class="pull-left">Please enter the captcha</label>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="captcha" type="text" class="form-control input-lg" />
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
                </div>

                <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All Rights Reserved.</p>
            </div>
        </section>
        <!-- end: page -->

        <!-- Vendor -->
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery/jquery.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-cookie/jquery-cookie.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/style-switcher/style.switcher.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/bootstrap/js/bootstrap.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/nanoscroller/nanoscroller.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>

        <!-- Specific Page Vendor -->		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/select2/js/select2.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>		
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/theme.js"></script>

        <!-- Theme Custom -->
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/theme.init.js"></script>

        <!-- Examples -->
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/tables/examples.datatables.default.js"></script>
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
        <script src="<?php echo BASEURL . "assets/ssp"; ?>assets/javascripts/tables/examples.datatables.tabletools.js"></script>
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