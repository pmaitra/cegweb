
				<section role="main" class="content-body">
					<header class="page-header">
						<h2>User Profile</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.html">
										<i class="fa fa-home"></i>
									</a>
								</li>
							</ol>
					
							
						</div>
					</header>

					<!-- start: page -->
					<div class="row">
                                            <div class="col-md-12 col-lg-12 col-xl-12">
						<div class="tabs">
                                                    <ul class="nav nav-tabs tabs-primary">
									<li class="active">
										<a href="#overview" data-toggle="tab">Personal Information</a>
									</li>
									<li>
										<a href="#edit" data-toggle="tab">Change Password</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="overview" class="tab-pane active">
										<form class="form-horizontal" method="post">
											<h4 class="mb-xlg">Personal Information</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileFirstName">First Name</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileFirstName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileLastName">Last Name</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileLastName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileAddress">Address</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileAddress">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileCompany">Company</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileCompany">
													</div>
												</div>
											</fieldset>
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<button type="submit" class="btn btn-primary">Submit</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
											</div>

										</form>
									</div>
									<div id="edit" class="tab-pane">

										<form action="<?php echo BASEURL;?>changepasswordsubmit" class="form-horizontal" method="post">	
											<h4 class="mb-xlg">Change Password</h4>
                                                                                                   

							<div id="modalSuccess" class="modal-block modal-header-color modal-block-success mfp-hide">
								<section class="panel">
									<header class="panel-heading">
										<h2 class="panel-title">Success!</h2>
									</header>
									<div class="panel-body">
										<div class="modal-wrapper">
											<div class="modal-icon">
												<i class="fa fa-check"></i>
											</div>
											<div class="modal-text">
												<h4>Success</h4>
												<p>This is a successfull message.</p>
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-md-12 text-right">
												<button class="btn btn-success modal-dismiss">OK</button>
											</div>
										</div>
									</footer>
								</section>
							</div>
                                                        
                                                        
											<fieldset class="mb-xl">
                                                                                            <div class="form-group">
													<label class="col-md-3 control-label" for="profileOldPassword">Old Password</label>
													<div class="col-md-8">
														<input type="password" class="form-control" id="old_password" name="old_password">
													</div>
												</div>
                                                                                            
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileNewPassword">New Password</label>
													<div class="col-md-8">
														<input type="password" class="form-control" id="new_password" name="new_password">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileNewPasswordRepeat">Confirm Password</label>
													<div class="col-md-8">
														<input type="password" class="form-control" id="confirm_password" name="confirm_password">
													</div>
												</div>
											</fieldset>
											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-3">
														<button type="submit" class="btn btn-primary">Submit</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
											</div>

										</form>

									</div>
								</div>
							</div>
						</div>
						
					</div>
					
					
					<!-- end: page -->
				</section>
			