<!doctype html>
<html class="boxed" data-style-switcher-options="{'layoutStyle': 'boxed'}">
<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Icam Invoice</title>
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
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />		<link rel="stylesheet" href="assets/vendor/morris.js/morris.css" />
                <link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="<?php echo BASEURL;?>assets/vendor/modernizr/modernizr.js"></script>		
                <script src="<?php echo BASEURL;?>assets/vendor/style-switcher/style.switcher.localstorage.js"></script>
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
					<a href="3" class="logo">
						<img src="<?php echo BASEURL.'assets/images/'.LOGOLINK;?>" height="50" alt="NISM_logo" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>	
                            <!-- start: search & user box -->
		        <div class="header-right">
		            <span class="separator"></span>
		            <div id="userbox" class="userbox">
		            <a href="<?php echo BASEURL;?>login" class="btn btn-primary" data-toggle="">Login</a>
		            </div>
		        </div>
		        <!-- end: search & user box -->
				
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">				

				<section role="main" class="content-body">
	<header class="page-header">
		<h2><?php echo !empty($course_details_display['program_name'])?$course_details_display['program_name']:'';?> Application Invoice</h2>						
	</header>

	<!-- start: page -->
	<section class="panel">
		<div class="panel-body">
		
				<div class="invoice" id='invoice-printarea'>
				
				<table width="100%" style="border-bottom: 1px solid #DADADA; margin-bottom: 20px;">
					<tr>
						<td>
							<img src="assets/images/logo.png" />
							<address>
								<br/>
								Rabindra Sarani, Kolkata, West Bengal, India,
								<br/>
								Phone: 022 66735100 -05
							</address>
						</td>
						<td style="text-align: right;">
							<span class="mt-none mb-sm text-dark text-weight-semibold">Registration Date: </span>
							<span class="m-none text-dark"><?php echo date('d/m/y')?></span>
						</td>
					</tr>
				</table>
				
				<table width="100%" style="margin-bottom: 20px;">
					<tr>
						<td>
							<p class="h5 mb-xs text-dark text-weight-semibold">Applicant Details:</p>
							<address>
								<?php echo ucfirst($candidate_details['first_name']).' '.$candidate_details['middle_name'].' '.$candidate_details['last_name'];?>
								<br/>
								<?php echo $candidate_address['street_address'].','.$candidate_address['address_line_2'].','.$candidate_address['city'].'-'.$candidate_address['postal_code'];?>
								<br/>
								<?php echo $candidate_address['state'].','.getCountryById($candidate_address['country_id']);?>
								<br/>
								Phone: <?php echo $candidate_details['contact_number'];?>
								<br/>
								Email: <?php echo $candidate_details['email_id'];?>
							</address>											
						</td>
						<td valign="top" style="text-align: right;">											
							<p class="mb-none">
								<span class="text-dark text-weight-semibold">Course Name:</span>
								<span class="value"><?php echo !empty($course_details_display['program_name'])?$course_details_display['program_name']:'';?></span>
							</p>
							<p class="mb-none">
								<span class="text-dark text-weight-semibold">Application ID:</span>
								<span class="value"><?php echo !empty($application_id)?$application_id:'';?></span>
							</p>
							<p class="mb-none">
								<span class="text-dark text-weight-semibold">Amount:</span>
								<span class="value"><?php echo !empty($payment_ammount)?$payment_ammount:'';?></span>
							</p>
							<p class="mb-none">
								<span class="text-dark text-weight-semibold">Payment Method:</span>
								<span class="value">Offilne</span>
							</p>
						</td>
					</tr>
				</table>
				<div class="text-xs-center" align="center">
				  <h1 class="display-3"><b> Thank You! </b></h1>
				  <p class="lead">Please check your email for further instructions on how to complete your payment.</p>
				  <hr>
				</div>
				
			</div>

			<div class="text-right mr-lg">
				<a href="" id="printinvoice" class="btn btn-primary ml-sm"><i class="fa fa-print"></i> Print</a>
			</div>

		</div>
	</section>
	<!-- end: page -->
</section>
			</div>

			

		</section>

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
		
		<!-- Examples -->
		<script src="<?php echo BASEURL;?>assets/javascripts/forms/examples.wizard.js"></script>
		<script type="text/javascript">

			$("#printinvoice").live("click", function () {
	            var divContents = $("#invoice-printarea").html();
	            var printWindow = window.open('', '', 'height=500,width=900');
	            printWindow.document.write('<html><head><title>Registration Invoice</title>');
	            printWindow.document.write('<link rel="stylesheet" href="assets/stylesheets/custom-print.css" type="text/css" />');
                    printWindow.document.write('<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css" type="text/css" />');
	            printWindow.document.write('</head><body onload="window.print()">');
	            printWindow.document.write(divContents);
	            printWindow.document.write('</body></html>');
	            printWindow.document.close();	            
	        });
 
 		</script>
	</body>

</html>