			

				<section role="main" class="content-body">
					<header class="page-header">
						<h2><?php echo !empty($course_details_display['program_name'])?$course_details_display['program_name']:'';?> Application Invoice - Admissions 2016-17</h2>						
					</header>

					<!-- start: page -->
					<section class="panel">
                                            <?php if(!empty($candidate_details)){

							?>
                                                   
						<div class="panel-body">
                                                    
						
                                                    
							<div class="invoice" id='invoice-printarea'>
								
								<table width="100%" style="border-bottom: 1px solid #DADADA; margin-bottom: 20px;">
									<tr>
										<td>
											<img src="<?php echo BASEURL;?>assets/images/logo.png" width="250" />
											<address>
												<br/>
												NISM Bhavan, Plot No. 82, Sector - 17, Vashi, Navi Mumbai, <br> Maharashtra, 400703, India
												<br/>
												Phone: 022 66735100 -05
											</address>
										</td>
										<td style="text-align: right;">
											<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">INVOICE</h2>
											<h4 class="h4 m-none text-dark text-weight-bold">
                                                                                            #<?php echo !empty($candidate_payment_details['id'])?$candidate_payment_details['id']:'';?>
                                                                                        </h4>
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
											<?php if(!empty($application_id)){
                                                                                            ?>
												<td align="left"><?php echo $application_id;?></td>
											<?php
												}
											?>
												<td class="text-weight-semibold text-dark" align="left">2016-17 Application Admission Fees</td>
												<td align="right"><i class="fa fa-rupee" aria-hidden="true"></i>
                                                                                                    <?php echo !empty($candidate_payment_details['amount'])?number_format($candidate_payment_details['amount'],2):'';?>
                                                                                                </td>
												
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
														<td class="text-right" align="right"><i class="fa fa-rupee" aria-hidden="true"></i> 
                                                                                                                    <?php echo !empty($candidate_payment_details['amount'])?number_format($candidate_payment_details['amount'],2):'';?></td>
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
							<?php } else { ?>
                                                            <div class="row">
										<div class="col-sm-12 col-sm-12 alert alert-danger">
                                                                                    Payment has already done. Please <a href="<?php echo BASEURL;?>login">Login</a> to see the application status.
                                                                                </div>
                                                            </div>
                                                        <?php } ?>
						</div>

					</section>

					
					
					<!-- end: page -->
				</section>
			