<section role="main" class="content-body">
					<header class="page-header">
						<h2> Application Invoice - Admissions 2017-18</h2>						
					</header>

					<!-- start: page -->
					<section class="panel">
                                            

							
                                                   
						<div class="panel-body">
                                                    
						
                                                    
							<div class="invoice" id='invoice-printarea'>
								
								<table width="100%" style="border-bottom: 1px solid #DADADA; margin-bottom: 20px;">
									<tr>
										<td>
											<img src="<?php echo BASEURL;?>assets/sspassets/images/logo.png" width="250" />
											<address>
												<br/>
												SSP Bhavan, Plot No. 82, Purulia, <br> West Bengal, 722005, India
												<br/>
												Phone: 033 66735100 -05
											</address>
										</td>
										<td style="text-align: right;">
											<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">INVOICE</h2>
											<h4 class="h4 m-none text-dark text-weight-bold">
                                                                                            #23256666666666666
                                                                                        </h4>
										</td>
									</tr>
								</table>
								<table width="100%" style="margin-bottom: 20px;">
									<tr>
										<td>
											<p class="h5 mb-xs text-dark text-weight-semibold">Applicant Details:</p>
											<address>
												Anup Roy
												<br/>
												100 Rabindra Sarani, Block 2/1
												<br/>
												Kolkata
												<br/>
												Phone: 9090909090
												<br/>
												anup@gmail.com
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
											
												<td align="left">4987979</td>
											
												<td class="text-weight-semibold text-dark" align="left">2017-18 Application Form Registration Fees</td>
												<td align="right"><i class="fa fa-rupee" aria-hidden="true"></i>
                                                                                                    <?php echo number_format(2000,2);?>
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
                                                                                                                    <?php echo number_format(2000,2);?></td>
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
						
						</div>

					</section>

					
					
					<!-- end: page -->
				</section>
		
	</body>

</html>