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
							<img src="<?php echo BASEURL;?>assets/images/logo.png" />
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