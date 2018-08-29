<section role="main" class="content-body">
    <header class="page-header">
        <h2>Registration Form Details</h2>				
	<div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
		<li>
                    
		</li>
            </ol>
					
							
	</div>
    </header>

					<!-- start: page -->
					<div class="row">
						<div class="col-md-12 col-lg-12 col-xl-12">	
							<section class="panel panel-primary">
								<div class="panel-body">
                                                                    <h3>Personal Details <!--<span class="pull-right"><a href="<?php echo BASEURL.'applicationdownload';?>" class="btn btn-info">Download  Registration  Form</a></span>--></h3>
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
		                        				<?php echo $candidate_details['first_name'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $candidate_details['middle_name'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $candidate_details['last_name'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $candidate_details['date_of_birth'];?>
		                        			</td>
		                        		</tr>
		                        		<tr>	                                                			
		                        			<td>
		                        				<b>Sex</b>
		                        			</td>
		                        			<td>
		                        				<b>Marital Status</b>
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
		                        				<?php echo $candidate_details['sex'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $candidate_details['marrital_status'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $candidate_details['contact_number'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $candidate_details['email_id'];?>
		                        			</td>
		                        		</tr>

		   


		            <?php if(!empty($address_list)){
                 		foreach ($address_list as $single_address) {
            		?>


		                        		<tr>
		                        			<td colspan="2">
		                        				<b>Street Address</b>
		                        			</td>
		                        			<td colspan="2">
		                        				<b>Address Line 2</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td colspan="2">
		                        				<?php echo $single_address['street_address'];?>
		                        			</td>
		                        			<td colspan="2">
		                        				<?php echo $single_address['address_line_2'];?>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<b>City</b>
		                        			</td>
		                        			<td>
		                        				<b>State / Province / Region</b>
		                        			</td>
		                        			<td>
		                        				<b>Postal / Zip Code</b>
		                        			</td>
		                        			<td>
		                        				<b>Country</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<?php echo $single_address['city'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_address['state'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_address['postal_code'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_address['country_id'];?>
		                        			</td>
		                        		</tr>
		            <?php
                		}}
            		?>



		                        	</table>
		                        	<hr>
		                        	<h4>Add New Address</h4>
		                        	<div class="well">
		                        		<table class="table table-striped">
		                        			<tr>
			                        			<td colspan="2">
			                        				<b>Street Address</b>
			                        			</td>
			                        			<td colspan="2">
			                        				<b>Address Line 2</b>
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td colspan="2">
			                        				<input type="text" class="form-control" id="street_address_1" name="street_address_1" value="" placeholder="Street Address">
			                        			</td>
			                        			<td colspan="2">
			                        				<input type="text" class="form-control" id="address_line2_1" name="address_line2_1" value="" placeholder="Address Line 2">
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td>
			                        				<b>City</b>
			                        			</td>
			                        			<td>
			                        				<b>State / Province / Region</b>
			                        			</td>
			                        			<td>
			                        				<b>Postal / Zip Code</b>
			                        			</td>
			                        			<td>
			                        				<b>Country</b>
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td>
			                        		        <input type="text" class="form-control" id="city_1" name="city_1" value="" placeholder="City">

			                        			</td>
			                        			<td>
			                        				<input type="text" class="form-control" id="state_1" name="state_1" value="" placeholder="State / Province / Region ">
			                        			</td>
			                        			<td>
			                        				<input type="text" class="form-control" id="postal_code_1" name="postal_code_1" value="" placeholder="Postal / Zip Code ">
			                        			</td>
			                        			<td>
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
			                        			</td>
			                        		</tr>
		                        		</table>
		                        		
		                        		<button class="btn btn-primary" id="add_address_btn">Add</button>
		                        	</div>


		                        	<hr>
		                        	<h3>Academic Qualification</h3>
		                        	
		                        	

		            <?php if(!empty($qualification_details)){

                 		foreach ($qualification_details as $single_qualification) {

			            switch ($single_qualification['degree_type']) {
			            case 'SSC':
			                ?>
			                <blockquote class="primary rounded b-thin">
										<h5>SSC or Equivalant</h5>
							</blockquote>
			                <table class="table table-striped">
			                			<tr>
		                        			<td>
		                        				<b>Name of the School</b>
		                        			</td>
		                        			<td>
		                        				<b>Name of the Board</b>
		                        			</td>
		                        			<td>
		                        				<b>Year of Passing</b>
		                        			</td>
		                        			<td>
		                        				<b>Percentage</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<?php echo $single_qualification['institute_name'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['affiliation'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['end_date'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['percentage'];?>
		                        			</td>
		                        		</tr>
		                     </table>

			           <?php    
			           	break;
			            case 'HSC':
			            ?>
			            <blockquote class="primary rounded b-thin">
										<h5>HSC or Equivalent</h5>
						</blockquote>
		                        	<table class="table table-striped">
		                        		<tr>
		                        			<td colspan="4">
		                        				<b>Group / Major</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td colspan="4">
		                        				<?php echo $single_qualification['degree'];?>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<b>Name of the School</b>
		                        			</td>
		                        			<td>
		                        				<b>Name of the Board</b>
		                        			</td>
		                        			<td>
		                        				<b>Year of Passing</b>
		                        			</td>
		                        			<td>
		                        				<b>Percentage</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<?php echo $single_qualification['institute_name'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['affiliation'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['end_date'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['percentage'];?>
		                        			</td>
		                        		</tr>
		                        	</table>
                                                <?php    
			           	break;
			            case 'UG':
			            ?>
                                             <blockquote class="primary rounded b-thin">
										<h5>Graduation / Equivalent Diploma</h5>
									</blockquote>
		                        	<table class="table table-striped">
		                        		<tr>
		                        			<td colspan="2">
		                        				<b>Degree / Diploma</b>
		                        			</td>
		                        			<td colspan="2">
		                        				<b>Specialization</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td colspan="2">
		                        				<?php echo $single_qualification['degree'];?>
		                        			</td>
		                        			<td colspan="2">
		                        				<?php echo $single_qualification['specialization'];?>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<b>Name of the College</b>
		                        			</td>
		                        			<td>
		                        				<b>Name of the University</b>
		                        			</td>
		                        			<td>
		                        				<b>Year of Passing</b>
		                        			</td>
		                        			<td>
		                        				<b>Percentage</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<?php echo $single_qualification['institute_name'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['affiliation'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['end_date'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['percentage'];?>
		                        			</td>
		                        		</tr>
		                        	</table>   
			            <?php
			                
			                break;
			                default:
			               ?>
			            <blockquote class="primary rounded b-thin">
										<h5>Post Graduation / Equivalent Diploma</h5>
									</blockquote>
		                        	<table class="table table-striped">
		                        		<tr>
		                        			<td colspan="2">
		                        				<b>Degree / Diploma</b>
		                        			</td>
		                        			<td colspan="2">
		                        				<b>Specialization</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td colspan="2">
		                        				<?php echo $single_qualification['degree'];?>
		                        			</td>
		                        			<td colspan="2">
		                        				<?php echo $single_qualification['specialization'];?>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<b>Name of the College</b>
		                        			</td>
		                        			<td>
		                        				<b>Name of the University</b>
		                        			</td>
		                        			<td>
		                        				<b>Year of Passing</b>
		                        			</td>
		                        			<td>
		                        				<b>Percentage</b>
		                        			</td>
		                        		</tr>
		                        		<tr>
		                        			<td>
		                        				<?php echo $single_qualification['institute_name'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['affiliation'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['end_date'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_qualification['percentage'];?>
		                        			</td>
		                        		</tr>
		                        	</table>
			               <?php 
			                
			                break;
			            
			        }
            		?>
            		
		                        	<?php
		                        }}
		                        ?>
		                        	
		                        	
		                        	
		                        	<hr>
		                        	<h4>Add More Post Graduation / Equivalent Diploma Details</h4>
		                        	<div class="well">
		                        		<table class="table table-striped">
			                        		<tr>
			                        			<td colspan="2">
			                        				<b>Degree / Diploma</b>
			                        			</td>
			                        			<td colspan="2">
			                        				<b>Specialization</b>
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td colspan="2">
			                        				<input  id="degree_1" name="degree_1" placeholder="" class="form-control"  type="text">
			                        			</td>
			                        			<td colspan="2">
			                        				<input  id="specialization_1" name="specialization_1" placeholder="" class="form-control"  type="text">
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td>
			                        				<b>Name of the College</b>
			                        			</td>
			                        			<td>
			                        				<b>Name of the University</b>
			                        			</td>
			                        			<td>
			                        				<b>Year of Passing</b>
			                        			</td>
			                        			<td>
			                        				<b>Percentage</b>
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td>
			                        				<input  id="name_of_college_1" name="name_of_college_1" placeholder="" class="form-control"  type="text">
			                        			</td>
			                        			<td>
			                        				<input  id="name_of_university_1" name="name_of_university_1" placeholder="" class="form-control"  type="text">
			                        			</td>
			                        			<td>
			                        				<input id="year_of_passing_1" name="year_of_passing_1" placeholder="" class="form-control"  type="text">
			                        			</td>
			                        			<td>
			                        				<input id="percentage_1" name="percentage_1" placeholder="" class="form-control"  type="text">
			                        			</td>
			                        		</tr>
			                        	</table>
		                        		<button class="btn btn-primary" id="add_qualification_btn">Add</button>
		                        	</div>



		                        	<hr>
		                        	<h3>Professional Experience</h3>
		                        	<table class="table table-striped">
		                        	<tr>
		                        			<th>
		                        				<b>Organization</b>
		                        			</th>
		                        			<th>
		                        				<b>Designation</b>
		                        			</th>
		                        			<th>
		                        				<b>Roles</b>
		                        			</th>
		                        			<th>
		                        				<b>From</b>
		                        			</th>
		                        			<th>
		                        				<b>To</b>
		                        			</th>
		                        		</tr>

		<?php if(!empty($professional_experience_list)){
			foreach ($professional_experience_list as $single_professional_experience) {
		?>
		
		                        		
		                        		<tr>
		                        			<td>
		                        				<?php echo $single_professional_experience['organization'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_professional_experience['designation'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_professional_experience['roles'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_professional_experience['start_from'];?>
		                        			</td>
		                        			<td>
		                        				<?php echo $single_professional_experience['start_to'];?>
		                        			</td>
		                        		</tr>
		                        		<?php
		}}
		?>
		                        		
		                        	</table>
		                        	<hr>
		                        	<h4>Add More Professional Experience Details</h4>
		                        	<div class="well">
		                        		<table class="table table-striped">	
		
		
			                        		<tr>
			                        			<td>
			                        				<b>Organization</b>
			                        			</td>
			                        			<td>
			                        				<b>Designation</b>
			                        			</td>
			                        			<td>
			                        				<b>Roles</b>
			                        			</td>
			                        			<td>
			                        				<b>From</b>
			                        			</td>
			                        			<td>
			                        				<b>To</b>
			                        			</td>
			                        		</tr>
			                        		<tr>
			                        			<td>
			                        				<input type="text" class="form-control" id="organization_1" name="organization_1" value="" placeholder="Organization">

			                        			</td>
			                        			<td>
			                        				<input type="text" class="form-control" id="designation_1" name="designation_1" value="" placeholder="Designation ">
			                        			</td>
			                        			<td>
			                        				<input type="text" class="form-control" id="roles_1" name="roles_1" value="" placeholder="Roles">

			                        			</td>
			                        			<td>
			                        				<input type="text" class="form-control" id="from_1" name="from_1" value="" placeholder="YYYY-MM-DD">

			                        			</td>
			                        			<td>
			                        				<input type="text" class="form-control" id="to_1" name="to_1" value="" placeholder=" YYYY-MM-DD">

			                        			</td>
			                        		</tr>

		       		
			                        	</table>
		                        		<button class="btn btn-primary" id="add_professional_experience_btn">Add</button>

		                        	</div>
								</div>
							</section>	
						</div>						
					</div>
					
					
					<!-- end: page -->
</section>