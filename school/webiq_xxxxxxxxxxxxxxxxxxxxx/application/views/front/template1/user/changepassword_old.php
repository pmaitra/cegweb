
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
										<a href="#overview-address" data-toggle="tab">Address</a>
									</li>
                                                                        <li>
										<a href="#overview-accamecis" data-toggle="tab">Academic Experience</a>
									</li>
                                                                        <li>
										<a href="#overview-experience" data-toggle="tab">Professional Experience</a>
									</li>
									<li>
										<a href="#change-password" data-toggle="tab">Change Password</a>
									</li>
								</ul>
								<div class="tab-content">
									<div id="overview" class="tab-pane active">
										<form class="form-horizontal" method="post">
											 <h4 class="mb-xlg">Personal Information</h4>
											<fieldset>
												<div class="form-group">
													<label class="col-md-4 control-label" for="profileFirstName">First Name</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileFirstName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label" for="profileLastName">Last Name</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileLastName">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label" for="profileAddress">Address</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileAddress">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label" for="profileCompany">Company</label>
													<div class="col-md-8">
														<input type="text" class="form-control" id="profileCompany">
													</div>
												</div>

	




				

							                    						<div class="row">
	
	</div>

	                        
	
	




											</fieldset>


											<div class="panel-footer">
												<div class="row">
													<div class="col-md-9 col-md-offset-4">
														<button type="submit" class="btn btn-primary">Submit</button>
														<button type="reset" class="btn btn-default">Reset</button>
													</div>
												</div>
											</div>

										</form>
									</div>
									
                                                                    
                                                                    <div id="overview-address" class="tab-pane">
                                                                        <table class="table table-striped">
                                                                        <tr>
                                                                                <th>
                                                                                        Contact No
                                                                                </th>
                                                                                <th>
                                                                                        Street Address
                                                                                </th>
                                                                                <th>
                                                                                        Address Line 2
                                                                                </th>
                                                                                <th>
                                                                                        City
                                                                                </th>
                                                                                <th>
                                                                                        State
                                                                                </th>
                                                                                <th>
                                                                                        Postal Code
                                                                                </th>
                                                                                <th>
                                                                                        Country
                                                                                </th>

                                                                        </tr>

                                                                        <div>

                                                                                        <?php if(!empty($address_list)){
                                                                                                foreach ($address_list as $single_address) {
                                                                                        ?>
                                                                                        <tr>
                                                                                                        <td><?php echo $single_address['mobile_no'];?></td>
                                                                                                        <td><?php echo $single_address['street_address'];?></td>
                                                                                                        <td><?php echo $single_address['address_line_2'];?></td>
                                                                                                        <td><?php echo $single_address['city'];?></td>
                                                                                                        <td><?php echo $single_address['state'];?></td>
                                                                                                        <td><?php echo $single_address['postal_code'];?></td>
                                                                                                        <td><?php echo $single_address['country_id'];?></td>
                                                                                        </tr>
                                                                                        <?php
                                                                                        }}
                                                                                        ?>
                                                                        </div>
                                                                        </table>
                                                                        
                                                                        
                                                                            <h4 class="mb-xlg">Add Address</h4>
                                                                                    <div class="row">
                                                                                    <div class="col-md-12">							                    			
                                                                                    <div class="panel panel-default">
                                                                                    <div class="panel-body">																	  
                                                                                            <div id="address_fields">
                                                                                                    <div class="col-sm-12 nopadding">
                                                                                                    <div class="form-group">
                                                                                                            <input type="text" class="form-control" id="contact_no_1" name="contact_no_1" value="" placeholder="Contact Number (Mobile)">
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-4 nopadding">
                                                                                                    <div class="form-group">
                                                                                                            <input type="text" class="form-control" id="street_address_1" name="street_address_1" value="" placeholder="Street Address">
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-4 nopadding">
                                                                                                    <div class="form-group">
                                                                                                            <input type="text" class="form-control" id="address_line2_1" name="address_line2_1" value="" placeholder="Address Line 2">
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-4 nopadding">
                                                                                                    <div class="form-group">
                                                                                                            <input type="text" class="form-control" id="city_1" name="city_1" value="" placeholder="City">
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-4 nopadding">
                                                                                                    <div class="form-group">
                                                                                                            <input type="text" class="form-control" id="state_1" name="state_1" value="" placeholder="State / Province / Region ">
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-4 nopadding">
                                                                                                    <div class="form-group">
                                                                                                            <input type="text" class="form-control" id="postal_code_1" name="postal_code_1" value="" placeholder="Postal / Zip Code ">
                                                                                                    </div>
                                                                                                    </div>
                                                                                                    <div class="col-sm-4 nopadding">
                                                                                                    <div class="form-group">
                                                                                                            <select id="country_1" name="country_1" class="form-control" data-previewid="country_data">
                                                                                                    <?php if(!empty($country_list)){
                                                                                                        foreach ($country_list as $single_country) {
                                                                                                          if($single_country['name'] =='India')
                                                                                                           {
                                                                                                             echo '<option value="'.$single_country['id'].'" '. set_select('country', $single_country['name'],TRUE).' >'.$single_country['name'].'</option>';
                                                                                                            }
                                                                                                           else
                                                                                                           {
                                                                                                             echo '<option value="'.$single_country['id'].'" '. set_select('country', $single_country['name']).' >'.$single_country['name'].'</option>';
                                                                                                           }
                                                                                                        }
                                                                                                       }
                                                                                                    ?>
                                                                                                </select>
                                                                                                    </div>
                                                                                                    </div>


                                                                                                    <div class="col-sm-12 nopadding">
                                                                                                            <div class="form-group">
                                                                                                                    <div class="input-group-btn">
                                                                                                                            <button type="button" class="btn btn-success"  id="add_address_btn">SEND

                                                                                                                            </button>

                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    <!--
                                                                                                    <div class="col-sm-12 nopadding">
                                                                                                            <div class="form-group">
                                                                                                                    <div class="input-group-btn">
                                                                                                                            <button class="btn btn-success" type="button"  onclick="address_fields();">
                                                                                                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
                                                                                                                            </button>
                                                                                                                    </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                    -->

                                                                                            </div>
                                                                                            <div class="clear"></div>

                                                                                    </div>																  
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>	
                                                                    </div>
                                                                    <div id="overview-accamecis" class="tab-pane"></div>
                                                                    <div id="overview-experience" class="tab-pane">
                                                                        <h4 class="mb-xlg">Add Professional Experience</h4>



<div class="row">
<div class="col-md-12">							                    			
<div class="panel panel-default">
<div class="panel-body">																	  
<div id="professional_experience_fields">

<div class="col-sm-4 nopadding">
<div class="form-group">
<input type="text" class="form-control" id="organization_1" name="" value="" placeholder="Organization">
</div>
</div>
<div class="col-sm-4 nopadding">
<div class="form-group">
<input type="text" class="form-control" id="designation_1" name="" value="" placeholder="Designation ">
</div>
</div>
<div class="col-sm-4 nopadding">
<div class="form-group">
<input type="text" class="form-control" id="roles_1" value="" placeholder="Roles">
</div>
</div>
<div class="col-sm-4 nopadding">
<div class="form-group">
<input type="text" class="form-control" id="from_1" name="" value="" placeholder="Start From">
</div>
</div>
<div class="col-sm-4 nopadding">
<div class="form-group">
<input type="text" class="form-control" id="to_1" name="" value="" placeholder=" End To">
</div>
</div>

																	  

																		<div class="col-sm-4 nopadding">
																		  <div class="form-group">
																		    <div class="input-group-btn">
																		        <button class="btn btn-success" type="button"  onclick="professional_experience_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
																		      </div>
																		  </div>
																		</div>
																		</div>
																		<div class="clear"></div>
																	  
																	</div>																  
																</div>
	
							                    		</div>
								                    	</div>
                                                                    </div>
                                                                    <div id="change-password" class="tab-pane">

										<form action="<?php echo BASEURL;?>changepasswordsubmit" class="form-horizontal" method="post">	
											<h4 class="mb-xlg">Change Password</h4>
                                                                                                   

                                                        <!-- 	<div id="modalSuccess" class="modal-block modal-header-color modal-block-success mfp-hide"> -->
                                                                <!--	<section class="panel">
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
                                                                -->


                                                        <fieldset class="mb-xl">
                                                            <div class="form-group">
                                                                                                                <label class="col-md-4 control-label" for="profileOldPassword">Old Password</label>
                                                                                                                <div class="col-md-8">
                                                                                                                        <input type="password" class="form-control" id="old_password" name="old_password">
                                                                                                                </div>
                                                                                                        </div>

                                                            <div class="form-group">
                                                                                                                <label class="col-md-4 control-label" for="profileNewPassword">New Password</label>
                                                                                                                <div class="col-md-8">
                                                                                                                        <input type="password" class="form-control" id="new_password" name="new_password">
                                                                                                                </div>
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                                <label class="col-md-4 control-label" for="profileNewPasswordRepeat">Confirm Password</label>
                                                                                                                <div class="col-md-8">
                                                                                                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </fieldset>
                                                                                                <div class="panel-footer">
                                                                                                        <div class="row">
                                                                                                                <div class="col-md-9 col-md-offset-4">
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
				<script type="text/javascript">
							var room = 1;
							var professional_experience_count = 1;

					function address_fields() {
						alert (room);
						var custom_room = room+1;
					 alert (custom_room);

					    room++;
					    var objTo = document.getElementById('address_fields')
					    objTo.setAttribute('class', 'form-group');
					    var divtest = document.createElement("div");
						divtest.setAttribute("class", "form-group removeclass"+room);
						var rdiv = 'removeclass'+room;
						divtest.innerHTML = '<div class="panel panel-default"><div class="panel-body"><div id="address_fields"><div><div class="col-sm-12 nopadding"><div class="form-group"><input type="text" class="form-control" id="contact_no_'+custom_room+'" name="" value="" placeholder="Contact Number (Mobile)"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="street_address_'+custom_room+'" name="" value="" placeholder="Street Address"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="'+custom_room+'" name="" value="" placeholder="Address Line 2"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="'+custom_room+'" name="" value="" placeholder="City"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="'+custom_room+'" name="" value="" placeholder="State / Province / Region "></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="'+custom_room+'" name="" value="" placeholder="Postal / Zip Code "></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="'+custom_room+'" name="" value="" placeholder="Country "></div></div><div class="col-sm-4 nopadding"><div class="form-group"><div class="input-group-btn"><button class="btn btn-danger" type="button"  onclick="remove_address_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"> </span></button></div></div></div></div></div></div>';
					    //divtest.innerHTML = '<div class="col-sm-4 nopadding"><div class="form-group"> <input type="text" class="form-control" id="" name="" value="" placeholder="Street Address"></div></div><div class="col-sm-4 nopadding"><div class="form-group"> <input type="text" class="form-control" id="" name="" value="" placeholder="City"></div></div><div class="col-sm-4 nopadding"><div class="form-group"> <input type="text" class="form-control" id="" name="" value="" placeholder="Pincode"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><div class="input-group"> <select class="form-control" id="educationDate" name="educationDate[]"><option value="">Date</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option> </select><div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_address_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div>';
					    
					    objTo.appendChild(divtest)
					}
					function remove_address_fields(rid) {
						//$('.removeclass'+rid).remove();
					}



	        






					function professional_experience_fields() {
						alert (professional_experience_count);
						var custom_professional_experience_count = professional_experience_count+1;
					 alert (custom_professional_experience_count);

					    professional_experience_count++;
					    var objTo = document.getElementById('professional_experience_fields')
					    objTo.setAttribute('class', 'form-group');
					    var divtest = document.createElement("div");
						divtest.setAttribute("class", "form-group removeclass"+professional_experience_count);
						var rdiv = 'removeclass'+professional_experience_count;

						divtest.innerHTML = '<div class="panel panel-default"><div class="panel-body"><div id="professional_experience_fields"><div class="col-sm-12 nopadding"><div class="form-group"><input type="text" class="form-control" id="organization'+custom_professional_experience_count+'" name="organization'+custom_professional_experience_count+'" value="" placeholder="Organization"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="designation'+custom_professional_experience_count+'" name="designation'+custom_professional_experience_count+'" value="" placeholder="Designation "></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="roles'+custom_professional_experience_count+'" name="roles'+custom_professional_experience_count+'" value="" placeholder="Roles"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="from'+custom_professional_experience_count+'" name="from'+custom_professional_experience_count+'" value="" placeholder="Start From"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><input type="text" class="form-control" id="to'+custom_professional_experience_count+'" name="to'+custom_professional_experience_count+'" value="" placeholder=" End To"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><div class="input-group-btn"><button class="btn btn-danger" type="button"  onclick="remove_address_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"> </span></button></div></div></div></div>';

					    //divtest.innerHTML = '<div class="col-sm-4 nopadding"><div class="form-group"> <input type="text" class="form-control" id="" name="" value="" placeholder="Street Address"></div></div><div class="col-sm-4 nopadding"><div class="form-group"> <input type="text" class="form-control" id="" name="" value="" placeholder="City"></div></div><div class="col-sm-4 nopadding"><div class="form-group"> <input type="text" class="form-control" id="" name="" value="" placeholder="Pincode"></div></div><div class="col-sm-4 nopadding"><div class="form-group"><div class="input-group"> <select class="form-control" id="educationDate" name="educationDate[]"><option value="">Date</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option> </select><div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_address_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear"></div>';
					    
					    objTo.appendChild(divtest)
					}
					function remove_professional_experience_fields(rid) {
						//$('.removeclass'+rid).remove();
					}

				</script>