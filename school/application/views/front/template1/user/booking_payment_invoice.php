			

				<section role="main" class="content-body">
					<header class="page-header">
						<h2><?php echo !empty($course_details_display['program_name'])?$course_details_display['program_name']:'';?> Invoice</h2>						
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
												102/34 Rabindra Sarani <br> Kolkata, West Bengal, India
												<br/>
                                                                                                Email : info@qtsin.net
                                                                                                <br/>
												Phone: 9830098300
											</address>
										</td>
										<td style="text-align: right;">
											<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">INVOICE</h2>
											<h4 class="h4 m-none text-dark text-weight-bold">
                                                                                            #<?php echo !empty($invoice_id)?$invoice_id:'';?>
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
												<?php echo (!empty($candidate_address['street_address'])?$candidate_address['street_address'].', ':'').(!empty($candidate_address['address_line_2'])?$candidate_address['address_line_2'].' , ':'').$candidate_address['city'].'-'.$candidate_address['postal_code'];?>
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
												<th id="cell-id"     class="text-weight-semibold" align="left">Sr#</th>
												<th id="cell-desc"   class="text-weight-semibold" align="left">Description</th>
												<th id="cell-total"  class="text-weight-semibold text-right" align="right">Amount</th>
											</tr>
										</thead>
										<tbody>
                                                                                    <?php
                                                                                        //pr($candidate_payment_details);
                                                                                        $total_amount= 0;
                                                                                        for($i=0;$i<count($candidate_payment_details);$i++) {
                                                                                            $total_amount = $total_amount+$candidate_payment_details[$i]['amount'];
                                                                                            ?>
											<tr>
											
												<td align="left"><?php echo $i+1;?></td>
											
                                                                                                <td class="text-weight-semibold text-dark" align="left"><?php echo ucfirst($candidate_payment_details[$i]['payment_fee_type']);?></td>
												<td align="right"><i class="fa fa-rupee" aria-hidden="true"></i>
                                                                                                    <?php echo !empty($candidate_payment_details[$i]['amount'])?number_format($candidate_payment_details[$i]['amount'],2):'';?>
                                                                                                </td>
												
											</tr>
                                                                                        <?php } ?>
										</tbody>
									</table>
								</div>
							
								<div class="invoice-summary">
									<div class="row">
										<div class="col-sm-6 pull-right">
											<table class="table h5 text-dark">
												<tbody>
													<tr class="h4">
														<td colspan="2">Grand Total</td>
														<td class="text-right" align="right"><i class="fa fa-rupee" aria-hidden="true"></i> 
                                                                                                                    <?php echo !empty($total_amount)?number_format($total_amount,2):'';?></td>
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
			