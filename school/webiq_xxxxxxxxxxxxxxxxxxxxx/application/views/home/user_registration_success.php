
<!DOCTYPE html>
<html class="boxed" data-style-switcher-options="{'layoutStyle': 'boxed'}"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Payment Processing</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        
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

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme-custom.css">

        <!-- Head Libs -->
        <script src="<?php echo BASEURL;?>assets/vendor/modernizr/modernizr.js"></script>       
        <script src="<?php echo BASEURL;?>assets/vendor/style-switcher/style.switcher.localstorage.js"></script>
    </head>
    <body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <section class="body">
        <div class="inner-wrapper">
            <div class="row" id="process-content">
                <div class="col-md-6 col-md-offset-3">
                    <section class="panel">
                        <div class="panel-body">
                            <h4><b>Your payment is being processed.</b></h4>
                            <h5>Please do not close this window or click the Back button on your browser.</h5>
                        </div>
                    </section>
                </div>
            </div>
            
        </div>
    </section>
    
        
    <div class="fakeloader"></div>
        

        
        <!-- Vendor -->
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <!-- Specific Page Vendor -->       
        <script src="<?php echo BASEURL;?>assets/vendor/jquery-ui/jquery-ui.js"></script>            
        <script src="<?php echo BASEURL;?>assets/vendor/select2/js/select2.js"></script>             
        <script src="<?php echo BASEURL;?>assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>   
        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo BASEURL;?>assets/javascripts/theme.js"></script>
                
        <!-- Theme Initialization Files -->
        <script src="<?php echo BASEURL;?>assets/javascripts/theme.init.js"></script>

        <!-- fakeLoader -->
        <link rel="stylesheet" href="http://joaopereirawd.github.io/fakeLoader.js/demo/css/fakeLoader.css">
        <script src="http://joaopereirawd.github.io/fakeLoader.js/js/fakeLoader.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".fakeloader").fakeLoader({
                    timeToHide:20000,
                    spinner:"spinner3"
                });
                $('#process-content').css('display','block');
                
            });
            
            /*function pageRedirect() {
                window.location.replace("invoice.html");
            }      
            setTimeout("pageRedirect()", 18000);
            */
        </script>

    </body>
</html>



