<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(DEBUGFLAG == 1)
{  
?>

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: <?php echo $severity; ?></p>
<p>Message:  <?php echo $message; ?></p>
<p>Filename: <?php echo $filepath; ?></p>
<p>Line Number: <?php echo $line; ?></p>

<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

	<p>Backtrace:</p>
	<?php foreach (debug_backtrace() as $error): ?>

		<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

			<p style="margin-left:10px">
			File: <?php echo $error['file'] ?><br />
			Line: <?php echo $error['line'] ?><br />
			Function: <?php echo $error['function'] ?>
			</p>

		<?php endif ?>

	<?php endforeach ?>

<?php endif ?>

</div>
<?php }  else {
 ?>   

<!DOCTYPE html>
<html class="boxed" data-style-switcher-options="{'layoutStyle': 'boxed'}"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>ICAM - 404</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        
        <!-- Vendor CSS -->
        <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/bootstrap/css/bootstrap.css" />

        <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/magnific-popup/magnific-popup.css" />
        <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

        <!-- Specific Page Vendor CSS -->       
		<link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/jquery-ui/jquery-ui.css" />      
		<link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/jquery-ui/jquery-ui.theme.css" />       
		<link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />      
		<link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/morris.js/morris.css" />
		<link rel="stylesheet" href="<?php echo BASEURL; ?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/stylesheets/theme.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="<?php echo BASEURL; ?>assets/stylesheets/theme-custom.css">

        <!-- Head Libs -->
        <script src="<?php echo BASEURL; ?>assets/vendor/modernizr/modernizr.js">
		</script>        
		<script src="<?php echo BASEURL; ?>assets/vendor/style-switcher/style.switcher.localstorage.js"></script>
        <style type="text/css">
            body { background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==) !important;}
                .error-template {padding: 40px 15px;text-align: center;}
                .error-actions {margin-top:15px;margin-bottom:15px;}
                .error-actions .btn { margin-right:10px; }                
        </style>
    </head>
    <body>
    <!--[if lt IE 7]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <section class="body">
        <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="error-template">
                            <h1>
                                <i class="fa fa-warning" aria-hidden=" true"></i> Oops! Page Not Found</h1>
                           
                            <div class="error-details">
                                <div class="error-details-h" style="display:none;">
                                <?php foreach (debug_backtrace() as $error): ?>

                                <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

                                        <p style="margin-left:10px">php
                                        File: <?php echo $error['file'] ?><br />
                                        Line: <?php echo $error['line'] ?><br />
                                        Function: <?php echo $error['function'] ?>
                                        </p>

                                <?php endif ?>

                                <?php endforeach ?>
                                </div>
                                The page you requested could not be found, either contact your webmaster or try again.  Use your browsers Back button to navigate to the page you have prevously come from <br>
                                Or you could just press this neat little button:
                            </div>
                            <div class="error-actions">
                                <a href="<?php echo BASEURL; ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                                    Take Me Home </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>  
        

        
        <!-- Vendor -->
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <!-- Specific Page Vendor -->       
        <script src="<?php echo BASEURL; ?>assets/vendor/jquery-ui/jquery-ui.js"></script>            
        <script src="<?php echo BASEURL; ?>assets/vendor/select2/js/select2.js"></script>             
        <script src="<?php echo BASEURL; ?>assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>   
        <!-- Theme Base, Components and Settings -->
        <script src="<?php echo BASEURL; ?>assets/javascripts/theme.js"></script>
                
        <!-- Theme Initialization Files -->
        <script src="<?php echo BASEURL; ?>assets/javascripts/theme.init.js"></script>        

    </body>
</html>




<?php } ?>
