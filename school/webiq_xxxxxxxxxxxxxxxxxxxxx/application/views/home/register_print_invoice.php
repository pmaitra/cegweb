<!doctype html>
<html class="boxed" data-style-switcher-options="{'layoutStyle': 'boxed'}">
<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>NISM</title>
		<meta name="keywords" content="" />
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<!-- Specific Page Vendor CSS -->		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css" />		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.theme.css" />		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />		<link rel="stylesheet" href="assets/vendor/morris.js/morris.css" /><link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>		<script src="assets/vendor/style-switcher/style.switcher.localstorage.js"></script>
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
						<img src="assets/images/logo.png" height="50" alt="NISM_logo" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>			
				
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">				

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>PGPSM Application Invoice - Admissions 2016-17</h2>						
					</header>

					<!-- start: page -->
					<section class="panel">
						<div class="panel-body">
						<?php if(!empty($candidate_details)){

							?>
							<div class="invoice" id='invoice-printarea'>
								
								<table width="100%" style="border-bottom: 1px solid #DADADA; margin-bottom: 20px;">
									<tr>
										<td>
											<img src="assets/images/logo.png" width="250" />
											<address>
												<br/>
												NISM Bhavan, Plot No. 82, Sector - 17, Vashi, Navi Mumbai, <br> Maharashtra, 400703, India
												<br/>
												Phone: 022 66735100 -05
											</address>
										</td>
										<td style="text-align: right;">
											<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">INVOICE</h2>
											<h4 class="h4 m-none text-dark text-weight-bold">#76598345</h4>
										</td>
									</tr>
								</table>
								<table width="100%" style="margin-bottom: 20px;">
									<tr>
										<td>
											<p class="h5 mb-xs text-dark text-weight-semibold">Applicant Details:</p>
											<address>
												<?php echo $candidate_details['first_name'].' '.$candidate_details['middle_name'].' '.$candidate_details['last_name'];?>
												<br/>
												<?php echo $candidate_address['street_address'].','.$candidate_address['address_line_2'].','.$candidate_address['city'].'-'.$candidate_address['postal_code'];?>
												<br/>
												<?php echo $candidate_address['state'].','.getCountryById($candidate_address['country_id']);?>
												<br/>
												Phone: <?php echo $candidate_details['contact_number'];?>
												<br/>
												<?php echo $candidate_details['email_id'];?>
											</address>
										</td>
									
										
										<td style="text-align: right;" valign="top">
											<p class="mb-none">
												<span class="text-dark">Invoice Date:</span>
                                                <span class="value"><?php echo date('d/m/Y');?></span>
											</p>
											<p class="mb-none">
												<span class="text-dark">Payment Method:</span>
												<span class="value">Net Banking</span>
											</p>
										</td>
									</tr>
								</table>
								
								<div class="table-responsive">
									<table class="table invoice-items">
										<thead>
											<tr class="h4 text-dark">
												<th id="cell-id"     class="text-weight-semibold" align="left">Applicant ID</th>
												<th id="cell-desc"   class="text-weight-semibold" align="left">Description</th>
												<th id="cell-total"  class="text-weight-semibold text-right" align="right">Amount</th>
											</tr>
										</thead>
										<tbody>
											<tr>
											<?php if(!empty($applicant_id)){
                  							?>
												<td align="left"><?php echo $applicant_id?></td>
											<?php
												}
											?>
												<td class="text-weight-semibold text-dark" align="left">2016-17 Application Form Registration Fees</td>
												<td align="right"><i class="fa fa-inr" aria-hidden="true"></i> 1000.00</td>
												
											</tr>
										</tbody>
									</table>
								</div>
							
								<div class="invoice-summary">
									<div class="row">
										<div class="col-sm-4 col-sm-offset-8">
											<table class="table h5 text-dark">
												<tbody>
													<tr class="h4">
														<td colspan="2">Grand Total</td>
														<td class="text-right" align="right"><i class="fa fa-inr" aria-hidden="true"></i> 1000.00</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>

							</div>

							<div class="text-right mr-lg">
								<a href="" id="printinvoice" class="btn btn-primary ml-sm"><i class="fa fa-print"></i> Print</a>
							</div>
							<?php } ?>
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
        <script src="assets/vendor/jquery-ui/jquery-ui.js"></script>			
        <script src="assets/vendor/select2/js/select2.js"></script>				
        <script src="assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>	
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
				
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>
		
		<!-- Examples -->
		<script src="assets/javascripts/forms/examples.wizard.js"></script>
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