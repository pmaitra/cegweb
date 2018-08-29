	<section role="main" class="content-body">
					<header class="page-header">
						<h2>Student Profile</h2>
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
										<h4 class="mb-xlg">Personal Details</h4>
										<table class="table table-striped">
			                        		<tr>
			                        			<td>
			                        				<b>First Name</b>
			                        			</td>
			                        			<td>
			                        				<b>Middle Name</b>
			                        			</td>
			                        			<td>
			                        				<b>Last Name</b>
			                        			</td>
			                        			<td>
			                        				<b>Date Of Birth</b>
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['firstName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['middleName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['lastName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['dateOfBirth'],'date'); ?>
			                        			</td>
			                        		</tr>
			                        		<tr>	                                                			
			                        			<td>
			                        				<b>Sex</b>
			                        			</td>
			                        			<td>
			                        				<b>Blood Group</b>
			                        			</td>
			                        			<td>
			                        				<b>Contact Number (Mobile)</b>
			                        			</td>
			                        			<td>
			                        				<b>E-Mail</b>
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['gender']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['bloodGroup']); ?>
			                        			</td>
			                        			<td>
			                        				N/A
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['email']); ?>
			                        			</td>
			                        		</tr>
			                        	</table>
			                        	<hr>
                                                        <h4 class="mb-xlg">Parent & Gurdian Details</h4>
			                        	<table class="table table-striped">
			                        		<tr>
			                        			<td>
			                        				<b>First Name</b>
			                        			</td>
			                        			<td>
			                        				<b>Middle Name</b>
			                        			</td>
			                        			<td>
			                        				<b>Last Name</b>
			                        			</td>
			                        			<td>
			                        				<b>Contact</b>
			                        			</td>
                                                                        <td>
			                        				<b>Email</b>
			                        			</td>
			                        		</tr>
                                                                <tr>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['fatherFirstName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['fatherMiddleName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['fatherLastName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['fatherMobile']); ?>
			                        			</td>
                                                                        <td>
			                        				<?php echo displayCheck($basic_details['fatherEmail']); ?>
			                        			</td>
			                        		</tr>
                                                                <tr>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['motherFirstName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['motherMiddleName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['motherLastName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['motherMobile']); ?>
			                        			</td>
                                                                        <td>
			                        				<?php echo displayCheck($basic_details['motherEmail']); ?>
			                        			</td>
			                        		</tr>
                                                                <tr>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['guardianFirstName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['guardianMiddleName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['guardianLastName']); ?>
			                        			</td>
			                        			<td>
			                        				<?php echo displayCheck($basic_details['guardianMobile']); ?>
			                        			</td>
                                                                        <td>
			                        				<?php echo displayCheck($basic_details['guardianEmail']); ?>
			                        			</td>
			                        		</tr>
                                                        </table>
			                        	<hr>
			                        	<h4 class="mb-xlg">Address Details</h4>	
                                                        <table class="table table-striped">
                                                        <?php if(!empty($basic_details['address']))
                                                            {
                                                                $address = json_decode($basic_details['address'],TRUE);
                                                                
                                                                //pr($address);
                                                                foreach ($address[0] as $key => $value) {
                                                                echo "<tr>
			                        			<td colspan='2'>
			                        				<b>".ucfirst($key)."</b> : 
			                        			</td>
			                        			<td colspan='2'>
			                        				".ucfirst($value)."
			                        			</td>
			                        		</tr>";
                                                            }
                                                        }; 
                                                        ?>
			                        	</table>
			                        		
			                        		
									</div>
									<div id="edit" class="tab-pane">

										<form class="form-horizontal" method="get">	
											<h4 class="mb-xlg">Change Password</h4>
											<fieldset class="mb-xl">
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileNewPassword">New Password</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileNewPassword">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-3 control-label" for="profileNewPasswordRepeat">Repeat New Password</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileNewPasswordRepeat">
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
			