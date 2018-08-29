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
<!-- Vendor CSS -->

		<!--<link type="text/css" rel="stylesheet" href="http://localhost/icamportal/assets/stylesheets/theme.css" />-->
                <style>
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 20px;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  padding: 8px;
  line-height: 1.42857143;
  vertical-align: top;
  border-top: 1px solid #ddd;
}
.table > thead > tr > th {
  vertical-align: bottom;
  border-bottom: 2px solid #ddd;
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
  border-top: 0;
}
.table > tbody + tbody {
  border-top: 2px solid #ddd;
}
.table .table {
  background-color: #fff;
}
.table-condensed > thead > tr > th,
.table-condensed > tbody > tr > th,
.table-condensed > tfoot > tr > th,
.table-condensed > thead > tr > td,
.table-condensed > tbody > tr > td,
.table-condensed > tfoot > tr > td {
  padding: 5px;
}
.table-bordered {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
  border: 1px solid #ddd;
}
.table-bordered > thead > tr > th,
.table-bordered > thead > tr > td {
  border-bottom-width: 2px;
}
.table-striped > tbody > tr:nth-of-type(odd) {
  background-color: #f9f9f9;
}
.table-hover > tbody > tr:hover {
  background-color: #f5f5f5;
}
table col[class*="col-"] {
  position: static;
  display: table-column;
  float: none;
}
table td[class*="col-"],
table th[class*="col-"] {
  position: static;
  display: table-cell;
  float: none;
}
.table > thead > tr > td.active,
.table > tbody > tr > td.active,
.table > tfoot > tr > td.active,
.table > thead > tr > th.active,
.table > tbody > tr > th.active,
.table > tfoot > tr > th.active,
.table > thead > tr.active > td,
.table > tbody > tr.active > td,
.table > tfoot > tr.active > td,
.table > thead > tr.active > th,
.table > tbody > tr.active > th,
.table > tfoot > tr.active > th {
  background-color: #f5f5f5;
}
.table-hover > tbody > tr > td.active:hover,
.table-hover > tbody > tr > th.active:hover,
.table-hover > tbody > tr.active:hover > td,
.table-hover > tbody > tr:hover > .active,
.table-hover > tbody > tr.active:hover > th {
  background-color: #e8e8e8;
}
.table > thead > tr > td.success,
.table > tbody > tr > td.success,
.table > tfoot > tr > td.success,
.table > thead > tr > th.success,
.table > tbody > tr > th.success,
.table > tfoot > tr > th.success,
.table > thead > tr.success > td,
.table > tbody > tr.success > td,
.table > tfoot > tr.success > td,
.table > thead > tr.success > th,
.table > tbody > tr.success > th,
.table > tfoot > tr.success > th {
  background-color: #dff0d8;
}
.table-hover > tbody > tr > td.success:hover,
.table-hover > tbody > tr > th.success:hover,
.table-hover > tbody > tr.success:hover > td,
.table-hover > tbody > tr:hover > .success,
.table-hover > tbody > tr.success:hover > th {
  background-color: #d0e9c6;
}
.table > thead > tr > td.info,
.table > tbody > tr > td.info,
.table > tfoot > tr > td.info,
.table > thead > tr > th.info,
.table > tbody > tr > th.info,
.table > tfoot > tr > th.info,
.table > thead > tr.info > td,
.table > tbody > tr.info > td,
.table > tfoot > tr.info > td,
.table > thead > tr.info > th,
.table > tbody > tr.info > th,
.table > tfoot > tr.info > th {
  background-color: #d9edf7;
}
.table-hover > tbody > tr > td.info:hover,
.table-hover > tbody > tr > th.info:hover,
.table-hover > tbody > tr.info:hover > td,
.table-hover > tbody > tr:hover > .info,
.table-hover > tbody > tr.info:hover > th {
  background-color: #c4e3f3;
}
.table > thead > tr > td.warning,
.table > tbody > tr > td.warning,
.table > tfoot > tr > td.warning,
.table > thead > tr > th.warning,
.table > tbody > tr > th.warning,
.table > tfoot > tr > th.warning,
.table > thead > tr.warning > td,
.table > tbody > tr.warning > td,
.table > tfoot > tr.warning > td,
.table > thead > tr.warning > th,
.table > tbody > tr.warning > th,
.table > tfoot > tr.warning > th {
  background-color: #fcf8e3;
}
.table-hover > tbody > tr > td.warning:hover,
.table-hover > tbody > tr > th.warning:hover,
.table-hover > tbody > tr.warning:hover > td,
.table-hover > tbody > tr:hover > .warning,
.table-hover > tbody > tr.warning:hover > th {
  background-color: #faf2cc;
}
.table > thead > tr > td.danger,
.table > tbody > tr > td.danger,
.table > tfoot > tr > td.danger,
.table > thead > tr > th.danger,
.table > tbody > tr > th.danger,
.table > tfoot > tr > th.danger,
.table > thead > tr.danger > td,
.table > tbody > tr.danger > td,
.table > tfoot > tr.danger > td,
.table > thead > tr.danger > th,
.table > tbody > tr.danger > th,
.table > tfoot > tr.danger > th {
  background-color: #f2dede;
}
.table-hover > tbody > tr > td.danger:hover,
.table-hover > tbody > tr > th.danger:hover,
.table-hover > tbody > tr.danger:hover > td,
.table-hover > tbody > tr:hover > .danger,
.table-hover > tbody > tr.danger:hover > th {
  background-color: #ebcccc;
}
.table-responsive {
  min-height: .01%;
  overflow-x: auto;
}
blockquote.primary {
	border-color: #0088cc;
}
.b-thin {
	border-width: 3px;
}
.rounded {
	border-radius: 5px;
}
blockquote {
    padding: 10px 20px;
    margin: 0 0 20px;
    font-size: 17.5px;
    border-left: 5px solid #eee;
}
                </style>
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
                                <tbody>
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
                                        <?php echo ucfirst($candidate_details['first_name']);?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="middle_name_data">
                                        <?php echo ucfirst($candidate_details['middle_name']);?>
                                      </div>
                                  </td>
                                  <td>
                                      <div id="last_name_data" >
                                        <?php echo ucfirst($candidate_details['last_name']);?>
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
                                    <?php echo getCountryById($single_address['country_id']);?>
                                                                        </div>
                                  </td>
                                </tr>
                                      <?php
                                          }}
                                      ?>
                                <tr>                                                        
                                  <td>
                                    <b>Pan Card No</b>
                                  </td>
                                  <td>
                                    <b>Adhar Card No</b>
                                  </td>
                                  <td>
                                    <b>Voter Card No</b>
                                  </td>
                                  <td>
                                    <b>Passport No</b>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                                                    <div id="pan_card_no_data">
                                    <?php echo $candidate_details['pan_card_no'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="adhar_card_no_data">
                                    <?php echo $candidate_details['adhar_card_no'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="voter_card_no_data" >
                                    <?php echo $candidate_details['voter_card_no'];?>
                                                                    </div>
                                  </td>
                                  <td>
                                                                    <div id="passport_no_data" >
                                    <?php echo $candidate_details['passport_no'];?>
                                                                    </div>
                                  </td>
                                </tr>
                                </tbody>
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
                            <tbody>
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
                            </tbody>
                        </table>

                            <?php    
                              break;
                              case 'HSC':
                            ?>
                            <blockquote class="primary rounded b-thin">
                                <h5>HSC or Equivalent</h5>
                        	</blockquote>
                        <table class="table table-striped">
                            <tbody>
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
                                </tbody>
                              </table>
                                        <?php    
						                  break;
						                  case 'UG':
						                ?>
                            <blockquote class="primary rounded b-thin">
                    			<h5>Graduation / Equivalent Diploma</h5>
                  			</blockquote>
                        <table class="table table-striped">
                            <tbody>
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
                                </tbody>
                        </table> 
					                  <?php
					                      
					                      break;
					                      default:
					                     ?>
			                <blockquote class="primary rounded b-thin">
			                    <h5>Post Graduation / Equivalent Diploma</h5>
			                </blockquote>
                        <table class="table table-striped">
                            <tbody>
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
                                </tbody>
                        </table>
				                    <?php 
				                      
				                      break;
				                  
				                      }
				                    ?>
				                      
				                              <?php
				                            }}
				                            ?>
                        <blockquote class="primary rounded b-thin">
			    <h5>Academic / Co-curricular Achievements</h5>
			 </blockquote>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                  <td colspan="4">
                                    <?php echo (!empty($candidate_details['academic_or_cocurricular_achievements']))?$candidate_details['academic_or_cocurricular_achievements']:'';
                                        ?>
                                    
                                  </td>
                                  
                                </tr>
                            </tbody>
                        </table>
                        <blockquote class="primary rounded b-thin">
			    <h5>Professional Qualification</h5>
			 </blockquote>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                  <td colspan="4">
                                    <?php echo (!empty($candidate_details['professional_qualification']))?implode(' , ', json_decode($candidate_details['professional_qualification'])):'';
                                        ?>
                                    
                                  </td>
                                  
                                </tr>
                            </tbody>
                        </table>
                        
                        <blockquote class="primary rounded b-thin">
			    <h5>Competitive Exams</h5>
			 </blockquote>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                  <td colspan="4">
                                    <?php echo (!empty($candidate_details['competitive_exams']))?implode(' , ', json_decode($candidate_details['competitive_exams'])):'';?>
                                    
                                  </td>
                                  
                                </tr>
                            </tbody>
                        </table>
	                <hr>
	                <h3>Professional Experience </h3>
                            <blockquote class="primary rounded b-thin">
			    <h5>Total Professional Experience</h5>
                            </blockquote>
                            <table class="table table-striped">
                               <tbody>
                                   <tr>
                                     <td colspan="4">
                                       <?php echo (!empty($candidate_details['professional_experience']))?$candidate_details['professional_experience']:0;?> year's
                                     </td>

                                   </tr>
                               </tbody>
                            </table>
                               <table class="table table-striped">
                                <tbody>
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
                                </tbody>
                        </table>
                        <blockquote class="primary rounded b-thin">
			    <h5>Professional Achievements</h5>
                            </blockquote>
                            <table class="table table-striped">
                               <tbody>
                                   <tr>
                                     <td colspan="4">
                                       <?php echo (!empty($candidate_details['professional_achievements']))?$candidate_details['professional_achievements']:'';?>
                                     </td>

                                   </tr>
                               </tbody>
                            </table>
                        <hr>
	                <h3>Payment Details</h3>
                       
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                  <td>
                                    <b>Invoice Date:</b>
                                  </td>
                                  <td>
                                       <?php echo !empty($candidate_payment_details['created_date'])?date('d/m/Y',  strtotime($candidate_payment_details['created_date'])):'';?>
                                  </td>
                            </tr> 
                            <tr>
                                  <td>
                                    <b>Payment Method:</b>
                                  </td>
                                  <td>
                                       Net Banking
                                  </td>
                            </tr>
                            <tr>
                                  <td>
                                    <b>Registration Fees :</b>
                                  </td>
                                  <td>
                                    <i class="fa fa-inr" aria-hidden="true"></i> <?php echo !empty($candidate_payment_details['amount'])?number_format($candidate_payment_details['amount'],2):'';?>
                                  </td>
                            </tr>
                            <tr>
                                  <td>
                                    <b>Payment Status:</b>
                                  </td>
                                  <td>
                                       Paid
                                  </td>
                            </tr>
                            </tbody>
                        </table>
                          

	            </div>
	        </div>                                           
	                                            
    </section>
  </div>    

</section>


</body>
</html>