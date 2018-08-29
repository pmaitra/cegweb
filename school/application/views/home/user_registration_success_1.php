<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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

<!-- Web Fonts  
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">-->


</head>
<body>
<section class="body"> 
  
  <!-- start: header -->
  <header class="header">
    <div class="logo-container"> <a href="3" class="logo"> <img src="assets/images/logo.png" height="50" alt="NISM_logo" /> </a>
      <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened"> <i class="fa fa-bars" aria-label="Toggle sidebar"></i> </div>
    </div>
  </header>
  <!-- end: header -->
  <hr>
  <div class="inner-wrapper">
    <section role="main" class="content-body">
      <header class="page-header">
        <h2>PGPSM Application Form - Admissions 2016-17</h2>
      </header>
      <div class="row">
        <div class="col-md-8 col-md-offset-2 panel-body">
          <h3><?php //echo $application_data;?></h3>
        </div>
      </div>
       <div class="row">
	                                                
	            <div class="col-md-12">
	                <h3>Personal Details</h3>
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
                                      <div id="first_name_data">
                                        <?php echo $candidate_details['first_name'];?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="middle_name_data">
                                        <?php echo $candidate_details['middle_name'];?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="last_name_data" >
                                        <?php echo $candidate_details['last_name'];?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="date_of_birth_data" >
                                        <?php echo $candidate_details['date_of_birth'];?>
                                      </div>
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
                                      <div id="gender_data">
                                        <?php echo $candidate_details['sex'];?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="marital_status_data">
                                        <?php echo $candidate_details['marrital_status'];?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="phone_data" >
                                        <?php echo $candidate_details['contact_number'];?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="email_data" >
                                        <?php echo $candidate_details['email_id'];?>
                                      </div>
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
                                                                    <div id="street_address_data" >
                                    <?php echo $single_address['street_address'];?>
                                                                    </div>
                                  </td>
                                  <td colspan="2">
                                                                    <div id="address_line_2_data" >
                                    <?php echo $single_address['address_line_2'];?>
                                                                    </div>
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
                                                                    <div id="city_data" >
                                    <?php echo $single_address['city'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="state_data" >
                                    <?php echo $single_address['state'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="zip_code_data" >
                                    <?php echo $single_address['postal_code'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="country_data" >
                                    <?php echo $single_address['country_id'];?>
                                                                        </div>
                                  </td>
                                </tr>
                                      <?php
                                          }}
                                      ?>

                        </table>
	                <hr>
	                <h3>Academic Qualification </h3>

	                                                	
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
                                                                    <div id="name_of_the_school_ssc_data" >
                                    <?php echo $single_qualification['institute_name'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="name_of_the_board_ssc_data" >
                                    <?php echo $single_qualification['affiliation'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="year_of_passing_ssc_data" >
                                    <?php echo $single_qualification['end_date'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="percentage_ssc_data" >
                                    <?php echo $single_qualification['percentage'];?>
                                                                    </div>
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
                                       <div id="group_major_hsc_data" >
                                    <?php echo $single_qualification['degree'];?>
                                       </div>
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
                                                                    <div id="name_of_the_school_hsc_data" >
                                    <?php echo $single_qualification['institute_name'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="name_of_the_board_hsc_data" >
                                    <?php echo $single_qualification['affiliation'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="year_of_passing_hsc_data" >
                                    <?php echo $single_qualification['end_date'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="percentage_hsc_data" >
                                    <?php echo $single_qualification['percentage'];?>
                                                                    </div>
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
                                                                    <div id="degree_diploma_ug_data" >
                                    <?php echo $single_qualification['degree'];?>
                                                                        </div>
                                  </td>
                                  <td colspan="2">
                                                                    <div id="specialization_ug_data" >
                                    <?php echo $single_qualification['specialization'];?>
                                                                        </div>
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
                                                                    <div id="name_of_the_college_ug_data" >
                                    <?php echo $single_qualification['institute_name'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="name_of_the_university_ug_data" >
                                    <?php echo $single_qualification['affiliation'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="year_of_passing_ug_data" >
                                    <?php echo $single_qualification['end_date'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="percentage_ug_data" >
                                    <?php echo $single_qualification['percentage'];?>
                                                                        </div>
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
	                <h3>Professional Experience </h3>

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
                                                                    <div id="organization_1_data" >
                                    <?php echo $single_professional_experience['organization'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="designation_1_data" >
                                    <?php echo $single_professional_experience['designation'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="roles_1_data" >
                                    <?php echo $single_professional_experience['roles'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="start_from_1_data" >
                                    <?php echo $single_professional_experience['start_from'];?>
                                                                        </div>
                                  </td>
                                  <td>
                                                                    <div id="start_to_1_data" >
                                    <?php echo $single_professional_experience['start_to'];?>
                                                                        </div>
                                  </td>
                                </tr>
	                                <?php
								    }}
								    ?>
                                
                        </table>


	            </div>
	        </div>                                           
	                                            
    </section>
  </div>    

</section>


</body>
</html>