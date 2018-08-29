 <?php 
    $candidate_application_id = set_value('application_id');
    if(!empty($candidate_application_id))
    {
        $application_id = $candidate_application_id;
    }
?>
<!doctype html>
<html class="boxed" data-style-switcher-options="{'layoutStyle': 'boxed'}">
<head>

<!-- Basic -->
<meta charset="UTF-8">
<title>iCAM - Admission</title>
<meta name="keywords" content="" />
<meta name="description" content="">
<meta name="author" content="">

<!-- Mobile Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

<!-- Vendor CSS -->
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/font-awesome/css/font-awesome.css" />

<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/jquery-ui/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/jquery-ui/jquery-ui.theme.css" />
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/pnotify/pnotify.custom.css" />
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />
<!-- Theme CSS -->
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme.css" />

<!-- Theme Custom CSS -->
<link rel="stylesheet" href="<?php echo BASEURL;?>assets/stylesheets/theme-custom.css">
<style type="text/css">
.dataTables_wrapper .DTTT.btn-group {
  display: none !important;
}
.pager li a {
  background: #0088cc;
  color: #fff;
}
</style>
</head>
<body>
<section class="body"> 
  
  <!-- start: header -->
  <header class="header">
    <div class="logo-container"> <a href="#" class="logo"> <img src="<?php echo BASEURL;?>assets/images/logo.png" height="50" alt="NISM_logo" /> </a>
      <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened"> <i class="fa fa-bars" aria-label="Toggle sidebar"></i> </div>
    </div>
    <!-- start: search & user box -->
    <div class="header-right"> <span class="separator"></span>
      <div id="userbox" class="userbox"> <a href="<?php echo BASEURL;?>login" class="btn btn-primary" data-toggle="">Login</a> </div>
    </div>
    <!-- end: search & user box --> 
    
  </header>
  <!-- end: header -->
  
  <div class="inner-wrapper">
    <section role="main" class="content-body">
      <header class="page-header">
        <h2><?php echo (!empty($course_details_display['program_name']))?$course_details_display['program_name']:$course_name; ?></h2>
      </header>
      
      <!-- start: page -->
      <div class="row form-body">
        <div class="col-md-12 col-lg-12 col-xl-12">
          <section class="panel  panel-primary">
            <div class="panel-body">
              <div class="wizard">
                <div class="wizard-inner">
                  <div class="connecting-line"></div>
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active" id="tab_instructions"> <a data-toggle="tab" aria-controls="step1" role="tab" title="Instructions"> <span class="round-tab">1</span>
                      <p>Instructions</p>
                      </a> </li>
                    <li role="presentation" class="disabled" id="tab_personal_details"> <a data-toggle="tab" aria-controls="step2" role="tab" title="Personal Details"> <span class="round-tab">2</span>
                      <p>Personal Details</p>
                      </a> </li>
                    <li role="presentation" class="disabled" id="tab_academic_qualification"> <a data-toggle="tab" aria-controls="step3" role="tab" title="Academic Qualification"> <span class="round-tab">3</span>
                      <p>Academic Qualification</p>
                      </a> </li>
                    <li role="presentation" class="disabled" id="tab_professional_experience"> <a data-toggle="tab" aria-controls="complete" role="tab" title="Professional Experience"> <span class="round-tab">4</span>
                      <p>Professional Experience</p>
                      </a> </li>
                    <li role="presentation" class="disabled" id="tab_verify_statement"> <a data-toggle="tab" aria-controls="complete" role="tab" title="Verify Statement"> <span class="round-tab">5</span>
                      <p>Verify Statement</p>
                      </a> </li>
                    <li role="survey" class="disabled" id="tab_entry_survey"> <a data-toggle="tab" aria-controls="complete" role="tab" title="Survey"> <span class="round-tab">6</span>
                      <p>Survey</p>
                      </a> </li> 
                    <li role="presentation" class="disabled" id="tab_payment_declaration"> <a data-toggle="tab" aria-controls="complete" role="tab" title="Payment & Declaration"> <span class="round-tab">7</span>
                      <p>Payment & Declaration</p>
                      </a> </li>
                  </ul>
                </div>
                <div class="tab-content">
                  <div class="tab-pane active" role="tabpanel" id="instructions">
                    <div class="row">
                      <div class="col-md-12">
                        <ul>
                          <li> The application form contains five sections (including 'Instructions').</li>
                          <li> The mandatory fields are marked with an asterisk (*).</li>
                          <li> Instructions are provided across various fields throughout the application form.</li>
                          <li> Only completely filled application forms will be considered for admission.</li>
                          <li> A copy of your application form would be sent to your email on submission.</li>
                          <li> In case of multiple submissions, only your last submission will be considered.</li>
                          <li> The application form do not have a provision to save and resume later. Keep all information handy before starting to fill the form.</li>
                          <li> Critical shortlist happens at the application phase, so you may fill the application form with care.</li>
                          <li> The application fee is 
                              Rs. <?php echo (!empty($course_details_display['form_fees']))?$course_details_display['form_fees']:0; ?>/- and is non-refundable.</li>
                          <li> Applicants would be provided a link to the Application Fee Payment Page on submission. The link will also be sent by email.</li>
                          <li> You are advised to check your email inbox frequently for updates on your application.</li>
                          <li> The form will stop accepting submissions by 11:59 p.m. on 
                          <?php echo date('d M Y',strtotime($course_details_display['form_submission_last_date']));?>.</li>
                        </ul>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <ul class="pager">
                        <li class="previous disabled"> <a class="btn btn-xs"><i class="fa fa-angle-left"></i> Previous</a> </li>
                        <li class="next"> <a class="btn btn-xs" id="next_instructions">Next <i class="fa fa-angle-right"></i></a> </li>
                      </ul>
                    </div>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="personal_details">
                    <form class="" id="user-registraiton-frm"  enctype="multipart/form-data" action="<?php //echo BASEURL;?>usersubmission" method="post" role="form">
                      <div  class="">
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Identification</h3>
                            </blockquote>
                          </div>
                        </div>
                        <input type="hidden" class="" id="course_id" 
                        value="<?php echo (!empty($course_details_display['id']))?$course_details_display['id']:''; ?>" name="course_id">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">First Name <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" value="<?php echo set_value('first_name'); ?>" id="first_name" name="first_name" placeholder="First Name">
                              <input type="hidden" name="course_name" value="<?php echo $course_name; ?>"/>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Middle Name </label>
                              <input type="text" class="form-control preview_input" id="middle_name" name="middle_name" value="<?php echo set_value('middle_name'); ?>" placeholder="Middle Name">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Last Name <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="last_name" name="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Last Name">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Date Of Birth <span class="required" aria-required="true">*</span></label>
                              <input name="date_of_birth" id="date_of_birth" type="text" data-plugin-datepicker=""  readonly="readonly" placeholder="Select date" class="form-control readonly datepicker">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Sex <span class="required" aria-required="true">*</span></label>
                              <div style="" class="form-group">
                                <label class="radio-inline radio-primary preview_input">
                                  <input type="radio" class="preview_radio" data-previewid="gender_data" required="required" value="Male" id="male"
                                    name="sex_is"  >
                                  Male </label>
                                <label class="radio-inline radio-primary preview_input padding-right-30">
                                  <input type="radio" class="preview_radio" required="required" data-previewid="gender_data" value="Female" id="female" name="sex_is" >
                                  Female </label>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Marital Status <span class="required" aria-required="true">*</span></label>
                              <div style="margin-top: 5px;" class="form-group">
                                <label class="radio-inline radio-primary preview_input">
                                  <input type="radio" value="Single" required="required" class="preview_radio" data-previewid="marital_status_data" id="single" name="marital_status_is" >
                                  Single </label>
                                <label class="radio-inline radio-primary preview_input padding-right-30">
                                  <input type="radio" required="required" value="Married" class="preview_radio" data-previewid="marital_status_data" id="married" name="marital_status_is" >
                                  Married </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Contact Details</h3>
                            </blockquote>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Contact Number (Mobile) <span class="required" aria-required="true">*</span></label>
                              <input class="form-control preview_input" name="contact_no" value="<?php echo set_value('contact_no'); ?>" placeholder="(00) 00000-00000" data-input-mask="(99) 99999-99999"  id="phone">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">E-Mail <span class="required" aria-required="true">*</span></label>
                              <input type="email" placeholder="eg.: examples@email.com" class="form-control preview_input" id="email" name="email" value="<?php echo set_value('email'); ?>" >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Street Address <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="street_address" name="street_address" value="<?php echo set_value('street_address'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Address Line 2 </label>
                              <input type="text" class="form-control preview_input" id="address_line_2" name="address_line_2" value="<?php echo set_value('address_line_2'); ?>" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> City <span class="required" aria-required="true">*</span></label>
                              <input type="text"  class="form-control preview_input" id="city" name="city" value="<?php echo set_value('city'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> State / Province / Region <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="state" name="state" value="<?php echo set_value('state'); ?>" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Postal / Zip Code <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="zip_code" name="zip_code" value="<?php echo set_value('zip_code'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Country <span class="required" aria-required="true">*</span></label>
                              <select id="country" name="country" class="form-control preview_select" data-previewid="country_data">
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
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Upload Photograph (Max size 200 KB)</label>
                              <input type="file" class="form-control" id="profile_picture" name="profile_picture" value="<?php //echo set_value('zip_code'); ?>" placeholder="">
                            </div>
                            <hr>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Documents Upload</h3>
                            </blockquote>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Pan Card No </label>
                              <input type="text"  class="form-control preview_input" id="pan_card_no" name="pan_card_no" value="<?php echo set_value('pan_card_no'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Upload Pan Card (Max size 2 MB)</label>
                              <input type="file" class="form-control" id="pan_card" name="pan_card" value="<?php //echo set_value('zip_code'); ?>" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Adhar Card No </label>
                              <input type="text"  class="form-control preview_input" id="adhar_card_no" name="adhar_card_no" value="<?php echo set_value('adhar_card_no'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Upload Adhar Card (Max size 2 MB)</label>
                              <input type="file" class="form-control" id="adhar_card" name="adhar_card" value="<?php //echo set_value('zip_code'); ?>" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Voter Card No </label>
                              <input type="text"  class="form-control preview_input" id="voter_card_no" name="voter_card_no" value="<?php echo set_value('voter_card_no'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Upload Voter Card (Max size 2 MB)</label>
                              <input type="file" class="form-control" id="voter_card" name="voter_card" value="<?php //echo set_value('zip_code'); ?>" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Passport No </label>
                              <input type="text"  class="form-control preview_input" id="passport_no" name="passport_no" value="<?php echo set_value('passport_no'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label"> Upload Passport (Max size 2 MB)</label>
                              <input type="file" class="form-control" id="passport" name="passport" value="<?php //echo set_value('zip_code'); ?>" placeholder="">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <div class="row">
                          <div class="col-md-12">
                            <?php $validation_error = validation_errors(); 
                                if(!empty($validation_error))
                                {
                                    echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">Ãƒâ€”</button>'. '<div class="alert alert-danger">'.$validation_error.'</div>';
                                }
                            ?>
                          </div>
                        </div>
                        <?php if($this->session->flashdata('err_registration')){ ?>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <div class="alert alert-danger"> <?php echo $this->session->flashdata('err_registration');?> </div>
                          </div>
                        </div>
                        <?php } ?>

                        <?php if($this->session->flashdata('err_profile_picture')){ ?>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <div class="alert alert-danger"> Upload Photograph : <?php echo $this->session->flashdata('err_profile_picture');?> </div>
                          </div>
                        </div>
                        <?php } ?>

                        <?php if($this->session->flashdata('err_pan_card')){ ?>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <div class="alert alert-danger"> Upload Pan Card : <?php echo $this->session->flashdata('err_pan_card');?> </div>
                          </div>
                        </div>
                        <?php } ?>

                        <?php if($this->session->flashdata('err_adhar_card')){ ?>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <div class="alert alert-danger"> Upload Adhar Card : <?php echo $this->session->flashdata('err_adhar_card');?> </div>
                          </div>
                        </div>
                        <?php } ?>

                        <?php if($this->session->flashdata('err_voter_card')){ ?>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <div class="alert alert-danger"> Upload Voter Card : <?php echo $this->session->flashdata('err_voter_card');?> </div>
                          </div>
                        </div>
                        <?php } ?>

                        <?php if($this->session->flashdata('err_passport')){ ?>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <div class="alert alert-danger"> Upload Passport : <?php echo $this->session->flashdata('err_passport');?> </div>
                          </div>
                        </div>
                        <?php } ?>


                        <!--                                                                                            <div class="row">
                                                                                            <div class="col-md-6">
                                                                                                  <div class="form-group">
                                                                                                        <input class="btn btn-sm btn-primary" type="submit" value="Submit">
                                                                                                  </div>
                                                                                                </div>
                                                                                            </div>-->
                        
                        <div class="col-md-12">&nbsp;</div>
                      </div>
                      <div class="panel-footer">
                        <ul class="pager">
                          <li class="previous"> <a class="btn btn-xs" id="prev_personal_details"><i class="fa fa-angle-left"></i> Previous</a> </li>
                          <li class="next">
                            <button class="btn btn-primary round-button pull-right" id="btn_submit_personal_details" type="">
                            Next <i class="fa fa-angle-right"></i>
                            </button>
                            <a class="btn btn-xs hide" id="next_personal_details">Next <i class="fa fa-angle-right"></i></a> </li>
                        </ul>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="academic_qualification">
                    <form id="accademics-update-frm"   action="<?php echo BASEURL;?>accademicssubmission" method="post" role="form">
                      <div id="" class="">
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>SSC or Equivalent </h3>
                            </blockquote>
                          </div>
                        </div>
                        <input type="hidden" class="" id="application_id" 
                        value="" name="application_id">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the School <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="name_of_the_school_ssc" name="name_of_the_school_ssc" value="<?php echo set_value('name_of_the_school_ssc'); ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the Board <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="name_of_the_board_ssc" name="name_of_the_board_ssc" value="<?php echo set_value('name_of_the_board_ssc'); ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          
              
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Year of Passing <span class="required" aria-required="true">*</span></label>
                              <input  id="year_of_passing_ssc" name="year_of_passing_ssc" value="<?php echo set_value('year_of_passing_ssc'); ?>" placeholder="____" class="form-control valid preview_input">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Percentage <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="percentage_ssc" name="percentage_ssc" value="<?php echo set_value('percentage_ssc'); ?>">
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>HSC or Equivalent </h3>
                            </blockquote>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="control-label">Group / Major <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="group_major_hsc" name="group_major_hsc" value="<?php echo set_value('group_major_hsc'); ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the School <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="name_of_the_school_hsc" name="name_of_the_school_hsc" value="<?php echo set_value('name_of_the_school_hsc'); ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the Board <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="name_of_the_board_hsc" name="name_of_the_board_hsc" value="<?php echo set_value('name_of_the_school_hsc'); ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Year of Passing <span class="required" aria-required="true">*</span></label>
                              <input data-input-mask="9999" id="year_of_passing_hsc" name="year_of_passing_hsc" value="<?php echo set_value('year_of_passing_hsc'); ?>" placeholder="____" class="form-control valid preview_input" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Percentage <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="percentage_hsc" name="percentage_hsc" value="<?php echo set_value('percentage_hsc'); ?>">
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Graduation / Equivalent Diploma</h3>
                            </blockquote>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Degree / Diploma <span class="required" aria-required="true">*</span></label>
                              <select class="form-control preview_input" data-previewid="degree_diploma_ug_data" id="degree_diploma_ug" name="degree_diploma_ug" >
                                <option>Select</option>
                                <option value="BA" >B.A</option>
                                <option value="BBA">B.B.A</option>
                                <option value="BCOM">B.Com</option>
                                <option value="BED">B.Ed</option>
                                <option value="BE">B.E/B.Tech</option>
                                <option value="BSC">B.Sc</option>
                                <option value="LLB">L.L.B</option>
                                <option value="Others">Others</option>
                              </select>
                            </div>
                          </div>
                          <div class="hide" id="degree_diploma_ug_others_div">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label">Specify </label>
                                <input type="text" class="form-control preview_input" id="degree_diploma_ug_others" name="degree_diploma_ug_others" value="<?php echo set_value('degree_diploma_ug_others'); ?>" >
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Specialization <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="specialization_ug" name="specialization_ug" value="<?php echo set_value('specialization_ug'); ?>">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the College <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="name_of_the_college_ug" name="name_of_the_college_ug" value="<?php echo set_value('name_of_the_college_ug'); ?>">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the University <span class="required" aria-required="true">*</span></label>
                              <input type="text" class="form-control preview_input" id="name_of_the_university_ug" name="name_of_the_university_ug" value="<?php echo set_value('name_of_the_university_ug'); ?>">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label class="control-label">Status of Completion <span class="required" aria-required="true">*</span></label>
                              <select class="form-control preview_select"  data-previewid="status_of_completion_ug_data" id="status_of_completion_ug"  name="status_of_completion_ug" >
                                <option>Select</option>
                                <option value="Complete" >Complete</option>
                                <option value="Pursuing">Pursuing</option>
                              </select>
                            </div>
                          </div>
                          <div id="passed_data_ug" class="hide">
                            <div id="passed_data_pg_year" class="">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="control-label">Year of Passing <span class="required" aria-required="true">*</span></label>
                                  <input id="year_of_passing_ug"  data-input-mask="9999" name="year_of_passing_ug" value="<?php echo set_value('year_of_passing_ug'); ?>" placeholder="____" class="form-control valid preview_input ">
                                </div>
                              </div>
                            </div>
                            <div id="passed_data_ug_percentage" class="">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="control-label">Percentage <span class="required" aria-required="true">*</span></label>
                                  <input type="text" class="form-control preview_input" id="percentage_ug" name="percentage_ug" value="<?php echo set_value('percentage_ug'); ?>" >
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Post Graduation / Equivalent Diploma</h3>
                            </blockquote>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Degree / Diploma</label>
                              <select class="form-control preview_select" data-previewid="degree_diploma_pg_data" id="degree_diploma_pg" name="degree_diploma_pg" >
                                <option>Select</option>
                                <option value="MA" >M.A</option>
                                <option value="MBA">M.B.A</option>
                                <option value="MCOM">M.Com</option>
                                <option value="MED">M.Ed</option>
                                <option value="ME">M.E/M.Tech</option>
                                <option value="MSC">M.Sc</option>
                                <option value="PGDM">PGDM and equivalent</option>
                                <option value="Others">Others</option>
                              </select>
                            </div>
                          </div>
                          <div class="hide" id="degree_diploma_pg_others_div">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label class="control-label">Specify</label>
                                <input type="text" class="form-control preview_input" id="degree_diploma_pg_others" name="degree_diploma_pg_others" value="<?php echo set_value('degree_diploma_pg_others'); ?>" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Specialization</label>
                              <input type="text" class="form-control preview_input" id="specialization_pg" name="specialization_pg" value="<?php echo set_value('specialization_pg'); ?>" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the College</label>
                              <input type="text" class="form-control preview_input" id="name_of_the_college_pg" name="name_of_the_college_pg" value="<?php echo set_value('name_of_the_college_pg'); ?>" >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label class="control-label">Name of the University </label>
                              <input type="text" class="form-control preview_input" id="name_of_the_university_pg" name="name_of_the_university_pg" value="<?php echo set_value('name_of_the_university_pg'); ?>" >
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label class="control-label">Status of Completion </label>
                              <select class="form-control preview_select"  data-previewid="status_of_completion_pg_data" id="status_of_completion_pg"  name="status_of_completion_pg" >
                                <option>Select</option>
                                <option value="Complete" >Complete</option>
                                <option value="Pursuing">Pursuing</option>
                              </select>
                            </div>
                          </div>
                          <div id="passed_data_pg" class="hide">
                            <div id="passed_data_pg_year" class="">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="control-label">Year of Passing</label>
                                  <input id="year_of_passing_pg"  data-input-mask="9999" name="year_of_passing_pg" value="<?php echo set_value('year_of_passing_pg'); ?>" placeholder="____" class="form-control valid preview_input" >
                                </div>
                              </div>
                            </div>
                            <div id="passed_data_pg_percentage" class="">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label class="control-label">Percentage</label>
                                  <input type="text" class="form-control preview_input" id="percentage_pg" name="percentage_pg" value="<?php echo set_value('percentage_pg'); ?>" >
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Professional Qualification</h3>
                            </blockquote>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <div class="checkbox-custom checkbox-default">
                                <input type="checkbox"  class="professional_qualification_cls" name="professional_qualification_check[]" id="qualification1"
                                value="CA"  <?php echo set_checkbox('professional_qualification_check[]', 'CA'); ?>>
                                <label for="qualification1">CA</label>
                              </div>
                              <div class="checkbox-custom checkbox-default">
                                <input type="checkbox"  class="professional_qualification_cls" name="professional_qualification_check[]" id="qualification2"
                                value="CFA"  <?php echo set_checkbox('professional_qualification_check[]', 'CFA'); ?>>
                                <label for="qualification2">CFA</label>
                              </div>
                              <div class="checkbox-custom checkbox-default">
                                <input type="checkbox"  class="professional_qualification_cls" name="professional_qualification_check[]" id="qualification3"
                                value="CS"  <?php echo set_checkbox('professional_qualification_check[]', 'CS'); ?>>
                                <label for="qualification3">CS</label>
                              </div>
                              <div class="checkbox-custom checkbox-default">
                                <input type="checkbox"  class="professional_qualification_cls" name="professional_qualification_check[]" id="qualification4"
                                value="CWA"  <?php echo set_checkbox('professional_qualification_check[]', 'CWA'); ?>>
                                <label for="qualification4">CWA</label>
                              </div>
                              <div class="checkbox-custom checkbox-default">
                                <input type="checkbox"  class="professional_qualification_cls" name="professional_qualification_check[]" id="qualification5"
                                value="Law"  <?php echo set_checkbox('professional_qualification_check[]', 'Law'); ?>>
                                <label for="qualification5">Law</label>
                              </div>
                              <div class="checkbox-custom checkbox-default">
                                <input type="checkbox" class="professional_qualification_cls" name="professional_qualification_check[]" id="qualification6"
                                value="Others"  <?php echo set_checkbox('professional_qualification_check[]', 'Others'); ?>>
                                <label for="qualification6">Others</label>
                              </div>
                              <div id="professional_qualification_others_div" class="hide">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="control-label">Specify</label>
                                    <input type="text" class="form-control preview_input" id="professional_qualification_others" name="professional_qualification_others" value="<?php echo set_value('professional_qualification_others'); ?>" >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Competitive Exams</h3>
                            </blockquote>
                          </div>
                        </div>
                        
                          <div class="col-md-12">
                            <div class="form-group">
                              <p>Choose the Competitive Exam(s) you have appeared for</p>
                              <div class="row">
                                <div class="checkbox-custom checkbox-default col-md-1">
                                  <input type="checkbox" class="competitive_exams_cls" name="competitive_exams_check[]" id="exam1" value="GMAT" <?php echo set_checkbox('competitive_exams_check[]', 'GMAT'); ?>>
                                  <label for="exam1">GMAT</label>
                                </div>
                                <div id="competitive_exams_gmat_div" class="hide col-md-2">
                                  <div class="form-group">
                                    <input type="text" class="form-control preview_input" id="professional_qualification_gmat" placeholder="Score obtained" name="professional_qualification_gmat" value="<?php echo set_value('professional_qualification_gmat'); ?>" >
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="checkbox-custom checkbox-default col-md-1">
                                  <input type="checkbox" class="competitive_exams_cls" name="competitive_exams_check[]" id="exam2" value="CAT" <?php echo set_checkbox('competitive_exams_check[]', 'CAT'); ?>>
                                  <label for="exam2">CAT</label>
                                </div>
                                <div id="competitive_exams_cat_div" class="hide col-md-2">
                                  <div class="form-group">
                                    <input type="text" class="form-control preview_input" id="professional_qualification_cat" name="professional_qualification_cat" placeholder="Percentile obtained" value="<?php echo set_value('professional_qualification_cat'); ?>" >
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="checkbox-custom checkbox-default col-md-1">
                                  <input type="checkbox" class="competitive_exams_cls" name="competitive_exams_check[]" id="exam3" value="XAT" <?php echo set_checkbox('competitive_exams_check[]', 'XAT'); ?>>
                                  <label for="exam3">XAT</label>
                                </div>
                                <div id="competitive_exams_xat_div" class="hide col-md-2">
                                  <div class="form-group">
                                    <input type="text" class="form-control preview_input" id="professional_qualification_xat" placeholder="Score obtained" name="professional_qualification_xat" value="<?php echo set_value('professional_qualification_xat'); ?>" >
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="checkbox-custom checkbox-default col-md-1">
                                  <input type="checkbox" class="competitive_exams_cls" name="competitive_exams_check[]" id="exam4" value="CMAT" <?php echo set_checkbox('competitive_exams_check[]', 'CMAT'); ?>>
                                  <label for="exam4">CMAT</label>
                                </div>
                                <div id="competitive_exams_cmat_div" class="hide col-md-2">
                                  <div class="form-group">
                                    <input type="text" class="form-control preview_input" id="professional_qualification_cmat" placeholder="Score obtained" name="professional_qualification_cmat" value="<?php echo set_value('professional_qualification_cmat'); ?>" >
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="checkbox-custom checkbox-default col-md-1">
                                  <input type="checkbox" class="competitive_exams_cls" name="competitive_exams_check[]" id="exam5" value="MAT" <?php echo set_checkbox('competitive_exams_check[]', 'MAT'); ?>>
                                  <label for="exam5">MAT</label>
                                </div>
                                <div id="competitive_exams_mat_div" class="hide col-md-2">
                                  <div class="form-group">
                                    <input type="text" class="form-control preview_input" id="professional_qualification_mat" placeholder="Score obtained" name="professional_qualification_mat" value="<?php echo set_value('professional_qualification_mat'); ?>" >
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="checkbox-custom checkbox-default col-md-1">
                                  <input type="checkbox" class="competitive_exams_cls" name="competitive_exams_check[]" id="exam6" value="Others" <?php echo set_checkbox('competitive_exams_check[]', 'Others'); ?>>
                                  <label for="exam6">Others</label>
                                </div>
                                <div id="competitive_exams_others_div1" class="hide col-md-2 ">
                                  <div class="form-group">
                                    <input type="text" class="form-control preview_input" id="competitive_exams_others_specify" placeholder="Specify" name="competitive_exams_others_specify" value="<?php echo set_value('professional_qualification_others_specify'); ?>" >
                                  </div>
                                </div>
                                <div id="competitive_exams_others_div2" class="hide col-md-3">
                                  <div class="form-group">
                                    <input type="text" class="form-control preview_input" id="competitive_exams_others_score" placeholder="Score obtained" name="competitive_exams_others_score" value="<?php echo set_value('professional_qualification_others_score'); ?>" >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        
                        <hr>
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Academic / Co-curricular Achievements </h3>
                            </blockquote>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <ol>
                              <li>Enter your academic / co-curricular achievements, if any, in brief (not more than 50 words)</li>
                              <li>Enter your achievements in points.</li>
                              <li>Enter only information that holds significant value</li>
                            </ol>
                            <textarea class="form-control preview_input" rows="3" id="academic_achievement" name="academic_achievement" value="<?php echo set_value('academic_achievement'); ?>" ></textarea>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <?php $validation_error = validation_errors(); 
                              if(!empty($validation_error))
                                {
                                  echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'. '<div class="alert alert-danger">'.$validation_error.'</div>';
                                }
                            ?>
                          </div>
                        </div>
                        <?php if($this->session->flashdata('err_accademics')){ ?>
                        <div class="row">
                          <div class="col-md-12">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <div class="alert alert-danger"> <?php echo $this->session->flashdata('err_accademics');?> </div>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="panel-footer">
                        <ul class="pager">
                          <li class="previous"> <a class="btn btn-xs" id="prev_academic_qualification"><i class="fa fa-angle-left"></i> Previous</a> </li>
                          <li class="next">
                            <button class="btn  btn-primary pull-right round-button" id="btn_submit_accademic_details" type="" id="">
                            Next <i class="fa fa-angle-right"></i>
                            </button>
                            <a class="btn btn-xs hide" id="next_academic_qualification">Next <i class="fa fa-angle-right"></i></a> </li>
                        </ul>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="professional_experience">
                    <form id="prof-experience-update-frm" action="#" method="post" role="form">
                      <div id="professional-experience" class="tab-pane">
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Total Professional Experience</h3>
                            </blockquote>
                          </div>
                          <input type="hidden" class="" id="application_id_qualification" value="" name="application_id_qualification">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Years</label>
                              <input type="text" class="form-control preview_input" id="total_exp_years" name="total_exp_years" value="<?php echo set_value('total_exp_years'); ?>" placeholder="">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label class="control-label">Months</label>
                              <input type="text" class="form-control preview_input" id="total_exp_months" name="total_exp_months" value="<?php echo set_value('total_exp_months'); ?>" placeholder="">
                              <br>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Professional Details </h3>
                            </blockquote>
                          </div>
                          <div class="col-md-12">
                            <ol>
                              <li> Start with your most recent Organization</li>
                              <li> Enter the highest designation held in the Organization</li>
                              <li> Enter your role(s) in brief. For example, Software Development, Maintenance of Accounts, etc.</li>
                              <li> Enter the month and year of joining in 'From'</li>
                              <li> Enter the month and year of leaving in 'To'</li>
                              <li> Leave 'To' blank if you are currently working in the Organization,</li>
                            </ol>
                            <br>
                          </div>
                        </div>
                        <br/>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="control-label">Organization</label>
                              <input type="text" class="form-control preview_input" id="organization_1" name="organization_1" value="<?php echo set_value('organization_1'); ?>" placeholder="Organization Name">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label class="control-label"> Designation </label>
                              <input type="text" class="form-control preview_input" id="designation_1" name="designation_1" value="<?php echo set_value('designation_1'); ?>" placeholder="Designation">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label class="control-label">Roles</label>
                              <input type="text" class="form-control preview_input" id="roles_1" name="roles_1" value="<?php echo set_value('roles_1'); ?>" placeholder="Roles">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label class="control-label">From </label>
                              <input type="text"  class="form-control preview_input datepicker" id="start_from_1" name="start_from_1" 
                                     data-plugin-datepicker="" value="<?php echo set_value('start_from_1'); ?>" data-input-mask="99/99/9999" 
                                     placeholder="__/__/____" >
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label class="control-label">To</label>
                              <input type="text"  class="form-control preview_input datepicker" id="start_to_1" name="start_to_1" 
                                     data-plugin-datepicker="" value="<?php echo set_value('start_to_1'); ?>" 
                                      placeholder="__/__/____">
                            </div>
                          </div>
                        </div>
                        <br/>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="text" class="form-control preview_input" id="organization_2" 
                                     name="organization_2" value="<?php echo set_value('organization_2'); ?>" placeholder="Organization Name">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="text" class="form-control preview_input" id="designation_2" name="designation_2" value="<?php echo set_value('designation_2'); ?>" placeholder="Designation">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text" class="form-control preview_input" id="roles_2" name="roles_2" 
                                     value="<?php echo set_value('roles_2'); ?>" placeholder="Roles">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text"  class="form-control preview_input datepicker" id="start_from_2" name="start_from_2" value="<?php echo set_value('start_from_2'); ?>"
                                placeholder="__/__/____" data-plugin-datepicker="" >
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text"  class="form-control preview_input datepicker" id="start_to_2" name="start_to_2" value="<?php echo set_value('start_to_2'); ?>" 
                               placeholder="__/__/____" data-plugin-datepicker="" >
                            </div>
                          </div>
                        </div>
                        <br/>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="text" class="form-control preview_input" id="organization_3" name="organization_3" value="<?php echo set_value('organization_3'); ?>" placeholder="Organization Name">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="text" class="form-control preview_input" id="designation_3" name="designation_3" value="<?php echo set_value('designation_3'); ?>" placeholder="Designation">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text" class="form-control preview_input" id="roles_3" name="roles_3" value="<?php echo set_value('roles_3'); ?>" placeholder="Roles">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text"  class="form-control preview_input datepicker" id="start_from_3" name="start_from_3" value="<?php echo set_value('start_from_3'); ?>"
                                placeholder="__/__/____" data-plugin-datepicker="" >
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <input type="text"  class="form-control preview_input datepicker" id="start_to_3" name="start_to_3" value="<?php echo set_value('start_to_3'); ?>" 
                               placeholder="__/__/____" data-plugin-datepicker="" >
                            </div>
                          </div>
                        </div>
                        <br/>
                        
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Professional Achievements</h3>
                            </blockquote>
                          </div>
                          <div class="col-md-12">
                            <ol>
                              <li>Enter your professional achievements, if any, in brief (not more than 50 words)</li>
                              <li>Enter your professional achievements in points.</li>
                              <li>Enter only information that holds significant value.</li>
                            </ol>
                            <textarea class="form-control preview_input" rows="3"  id="professional_achievements" name="professional_achievements" value="<?php echo set_value('professional_achievement'); ?>" ></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="panel-footer">
                        <ul class="pager">
                          <li class="previous"> <a class="btn btn-xs" id="prev_professional_experience"><i class="fa fa-angle-left"></i> Previous</a> </li>
                          <li class="next">
                            <button class="btn  btn-primary pull-right round-button" id="btn_submit_professional_experience">
                            Next <i class="fa fa-angle-right"></i>
                            </button>
                            <a class="btn btn-xs hide" id="next_professional_experience">Next <i class="fa fa-angle-right"></i></a> </li>
                        </ul>
                      </div>
                    </form>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="verify_statement">
                    <form role="form">
                      <div id="preview" class="tab-pane">
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Verify Statement</h3>
                            </blockquote>
                          </div>
                          <section class="panel panel-primary">
                            <div class="panel-body">
                              <h3>Personal Details</h3>
                              <table class="table table-striped">
                                <tr>
                                  <td><b>First Name</b></td>
                                  <td><b>Middle Name</b></td>
                                  <td><b>Last Name</b></td>
                                  <td><b>Date Of Birth</b></td>
                                </tr>
                                <tr>
                                  <td><div id="first_name_data">  </div></td>
                                  <td><div id="middle_name_data"> <?php //echo ucfirst($candidate_details['middle_name']);?> </div></td>
                                  <td><div id="last_name_data" > <?php //echo ucfirst($candidate_details['last_name']);?> </div></td>
                                  <td><div id="date_of_birth_data" > <?php //echo $candidate_details['date_of_birth'];?> </div></td>
                                </tr>
                                <tr>
                                  <td><b>Sex</b></td>
                                  <td><b>Marital Status</b></td>
                                  <td><b>Contact Number (Mobile)</b></td>
                                  <td><b>E-Mail</b></td>
                                </tr>
                                <tr>
                                  <td><div id="gender_data"> <?php //echo $candidate_details['sex'];?> </div></td>
                                  <td><div id="marital_status_data"> <?php //echo $candidate_details['marrital_status'];?> </div></td>
                                  <td><div id="phone_data" > <?php //echo $candidate_details['contact_number'];?> </div></td>
                                  <td><div id="email_data" > <?php //echo $candidate_details['email_id'];?> </div></td>
                                </tr>
                                <?php if(!empty($address_list)){
                    foreach ($address_list as $single_address) {
                ?>
                                <tr>
                                  <td colspan="2"><b>Street Address</b></td>
                                  <td colspan="2"><b>Address Line 2</b></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><div id="street_address_data" > <?php //echo $single_address['street_address'];?> </div></td>
                                  <td colspan="2"><div id="address_line_2_data" > <?php //echo $single_address['address_line_2'];?> </div></td>
                                </tr>
                                <tr>
                                  <td><b>City</b></td>
                                  <td><b>State / Province / Region</b></td>
                                  <td><b>Postal / Zip Code</b></td>
                                  <td><b>Country</b></td>
                                </tr>
                                <tr>
                                  <td><div id="city_data" > <?php //echo $single_address['city'];?> </div></td>
                                  <td><div id="state_data" > <?php //echo $single_address['state'];?> </div></td>
                                  <td><div id="zip_code_data" > <?php //echo $single_address['postal_code'];?> </div></td>
                                  <td><div id="country_data" > <?php //echo getCountryById($single_address['country_id']);?> </div></td>
                                </tr>
                                <?php
                    }}
                ?>
                                <tr>
                                  <td><b>Pan Card No</b></td>
                                  <td><b>Adhar Card No</b></td>
                                  <td><b>Voter Card No</b></td>
                                  <td><b>Passport No</b></td>
                                </tr>
                                <tr>
                                  <td><div id="pan_card_no_data"> <?php //echo $candidate_details['pan_card_no'];?> </div></td>
                                  <td><div id="adhar_card_no_data"> <?php //echo $candidate_details['adhar_card_no'];?> </div></td>
                                  <td><div id="voter_card_no_data" > <?php //echo $candidate_details['voter_card_no'];?> </div></td>
                                  <td><div id="passport_no_data" > <?php //echo $candidate_details['passport_no'];?> </div></td>
                                </tr>
                              </table>
                              <hr>
                              <h3>Academic Qualification</h3>
                              <div id="accademic_details_display"></div>
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
                                  <td><b>Name of the School</b></td>
                                  <td><b>Name of the Board</b></td>
                                  <td><b>Year of Passing</b></td>
                                  <td><b>Percentage</b></td>
                                </tr>
                                <tr>
                                  <td><div id="name_of_the_school_ssc_data" > <?php //echo $single_qualification['institute_name'];?> </div></td>
                                  <td><div id="name_of_the_board_ssc_data" > <?php //echo $single_qualification['affiliation'];?> </div></td>
                                  <td><div id="year_of_passing_ssc_data" > <?php //echo $single_qualification['end_date'];?> </div></td>
                                  <td><div id="percentage_ssc_data" > <?php //echo $single_qualification['percentage'];?> </div></td>
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
                                  <td colspan="4"><b>Group / Major</b></td>
                                </tr>
                                <tr>
                                  <td colspan="4"><div id="group_major_hsc_data" > <?php echo $single_qualification['specialization'];?> </div></td>
                                </tr>
                                <tr>
                                  <td><b>Name of the School</b></td>
                                  <td><b>Name of the Board</b></td>
                                  <td><b>Year of Passing</b></td>
                                  <td><b>Percentage</b></td>
                                </tr>
                                <tr>
                                  <td><div id="name_of_the_school_hsc_data" > <?php //echo $single_qualification['institute_name'];?> </div></td>
                                  <td><div id="name_of_the_board_hsc_data" > <?php //echo $single_qualification['affiliation'];?> </div></td>
                                  <td><div id="year_of_passing_hsc_data" > <?php //echo $single_qualification['end_date'];?> </div></td>
                                  <td><div id="percentage_hsc_data" > <?php echo $single_qualification['percentage'];?> </div></td>
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
                                  <td colspan="2"><b>Degree / Diploma</b></td>
                                  <td colspan="2"><b>Specialization</b></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><?php //echo $single_qualification['degree'];?></td>
                                  <td colspan="2"><?php //echo $single_qualification['specialization'];?></td>
                                </tr>
                                <tr>
                                  <td><b>Name of the College</b></td>
                                  <td><b>Name of the University</b></td>
                                  <td><b>Year of Passing</b></td>
                                  <td><b>Percentage</b></td>
                                </tr>
                                <tr>
                                  <td><?php //echo $single_qualification['institute_name'];?></td>
                                  <td><?php //echo $single_qualification['affiliation'];?></td>
                                  <td><?php //echo $single_qualification['end_date'];?></td>
                                  <td><?php //echo $single_qualification['percentage'];?></td>
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
                                  <td colspan="2"><b>Degree / Diploma</b></td>
                                  <td colspan="2"><b>Specialization</b></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><div id="degree_diploma_ug_data" > <?php //echo $single_qualification['degree'];?> </div></td>
                                  <td colspan="2"><div id="specialization_ug_data" > <?php //echo $single_qualification['specialization'];?> </div></td>
                                </tr>
                                <tr>
                                  <td><b>Name of the College</b></td>
                                  <td><b>Name of the University</b></td>
                                  <td><b>Year of Passing</b></td>
                                  <td><b>Percentage</b></td>
                                </tr>
                                <tr>
                                  <td><div id="name_of_the_college_ug_data" > <?php //echo $single_qualification['institute_name'];?> </div></td>
                                  <td><div id="name_of_the_university_ug_data" > <?php //echo $single_qualification['affiliation'];?> </div></td>
                                  <td><div id="year_of_passing_ug_data" > <?php //echo $single_qualification['end_date'];?> </div></td>
                                  <td><div id="percentage_ug_data" > <?php //echo $single_qualification['percentage'];?> </div></td>
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
                              <h3>Professional Experience</h3>
                              <table class="table table-striped" id="prof_experience_tbl">
                                <tr>
                                  <th> <b>Organization</b> </th>
                                  <th> <b>Designation</b> </th>
                                  <th> <b>Roles</b> </th>
                                  <th> <b>From</b> </th>
                                  <th> <b>To</b> </th>
                                </tr>
                               
                                <?php //if(!empty($professional_experience_list)){
      //foreach ($professional_experience_list as $single_professional_experience) {
    ?>
                               <tbody>
                               
                                </tbody>
                                <?php
    ?>
                              </table>
                            </div>
                          </section>
                        </div>
                      </div>
                      <div class="panel-footer">
                        <ul class="pager">
                          <li class="previous"> <a class="btn btn-xs" id="prev_verify_statement"><i class="fa fa-angle-left"></i> Previous</a> </li>
                          <li class="next"> <a class="btn btn-xs" id="next_verify_statement">Next <i class="fa fa-angle-right"></i></a> </li>
                        </ul>
                      </div>
                    </form>
                  </div>
                     <div class="tab-pane" role="tabpanel" id="survey-tab">
                        <div id="survey-tab-inside" class="tab-pane">                            
                            <div class="row">
                                <div class="col-md-12">
                                    <blockquote class="b-thin rounded primary">
                                       <h3>Survey</h3>
                                    </blockquote>
                                </div>
                                <div class="col-md-12">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                   <h3>How did you come to know about this course?</h3>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                       <input type="radio" id="radio1" required name="radioExample1">
                                      <label for="radio1">Newspaper</label>
                                   </div>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio2" name="radioExample1">
                                      <label for="radio2">Digital Media</label>
                                   </div>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio3" name="radioExample1">
                                      <label for="radio3">Friend/Colleague</label>
                                   </div>
                                </div>
                             </div>
                             <hr>
                             <div class="row">
                                <div class="col-md-12">
                                   <h3>What do you expect from this course?</h3>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio4" name="radioExample2">
                                      <label for="radio4">Skill enhancement</label>
                                   </div>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio5" name="radioExample2">
                                      <label for="radio5">Beat Recession</label>
                                   </div>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio6" name="radioExample3">
                                      <label for="radio6">Better Job Opportunity</label>
                                   </div>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio7" name="radioExample4">
                                      <label for="radio7">Understand the subject to the core</label>
                                   </div>
                                </div>
                             </div>
                             <hr>
                             <div class="row">
                                <div class="col-md-12">
                                   <h3>Do you expect the course would enhance your chance of getting a specialized job?</h3>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio8" name="radioExample5">
                                      <label for="radio8">Yes</label>
                                   </div>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio9" name="radioExample5">
                                      <label for="radio9">No</label>
                                   </div>
                                </div>
                             </div>
                             <hr>
                             <div class="row">
                                <div class="col-md-12">
                                   <h3>Do you expect the course would ensure quicker promotion in your current job?</h3>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio10" name="radioExample6">
                                      <label for="radio10">Yes</label>
                                   </div>
                                </div>
                                <div class="col-sm-12">
                                   <div class="radio-custom radio-primary">
                                      <input type="radio" id="radio11" name="radioExample6">
                                      <label for="radio11">No</label>
                                   </div>
                                </div>
                             </div>
                        </div>
                        <div class="panel-footer">
                        <ul class="pager">
                          <li class="previous"> <a class="btn btn-xs" id="prev_survey_tab"><i class="fa fa-angle-left"></i> Previous</a> </li>
                          <li class="next"> <a class="btn btn-xs" id="next_survey_tab">Next <i class="fa fa-angle-right"></i></a> </li>
                        </ul>
                      </div>
                    </div>  
                  <div class="tab-pane" role="tabpanel" id="payment_declaration">
                    <form role="form">
                      <div id="payment-declaration" class="tab-pane">
                        <div class="row">
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Instructions for Payment</h3>
                            </blockquote>
                            <p>Read the following information carefully before submitting the form</p>
                            <ol>
                              <li>The application fee is Rs. <?php echo (!empty($course_details_display['form_fees']))?$course_details_display['form_fees']:0; ?>/- and is non-refundable.</li>
                              <li>The link to pay application fee would be sent to your email on submitting this form.</li>
                              <li>The application form is complete only after paying the application fee.</li>
                            </ol>
                            <br>
                            <p>To resolve any queries, please contact, <br>
                              Admission Helpdesk: +91-82680 02412 </p>
                          </div>
                          <hr>
                          <div class="tab-content">
                      <div id="w4-Submission" class="tab-pane active">
                        <div class="row">
                                                                         
                          <div class="col-md-8">
                            <table class="table table-striped">
                              <thead>
                                <tr class="h4 text-dark">
                                  <th>Description</th>
                                  <th class="text-right">Amount</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>Registration Fees</td>
                                  <td align="right"><i class="fa fa-rupee" aria-hidden="true"></i> <span id="registration_amount" >
                                      <?php echo (!empty($course_details_display['form_fees']))?$course_details_display['form_fees']:0; ?></span></td>
                                </tr>
                                <tr>
                                  <td><a href="#" data-toggle="modal" data-target="#at-coupon">Apply Coupon</a> 
                                  Coupon applied  : <span id="coupon_code_applied">N/A</span>
                                  <span id="discount_percentage"></span>
                                  
                                  </td>

                                  <td align="right"> <i class="fa fa-rupee" aria-hidden="true"></i> <span id="coupon_discount_amount">0.00</span></td>
                                </tr>
                              </tbody>
                              <tfoot>
                                <tr class="h4 text-dark">
                                  <td align="right">Grand Total :</td>
                                  <td align="right"><i class="fa fa-rupee" aria-hidden="true"></i> <span id ="grand_total_registration"> 
                                      <?php echo (!empty($course_details_display['form_fees']))?$course_details_display['form_fees']:0; ?></span></td>
                                </tr>                                                       
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  <section class="at-login-form">
                <!-- MODAL LOGIN -->
                    <div class="modal fade" id="at-coupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h2>Coupon <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></h2>
                                    
                          </div>
                        <div class="modal-body">
                          <form>
                            <p> Please Enter Your Coupon Code </p>
                            <div class="form-group">

                              <input id="coupon_code" type="text" class="form-control" placeholder="Coupon Code">
                            </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button id="add_coupon_apply" class="btn-gst" data-toggle="modal" data-dismiss="modal">Apply </button>
                        </div>
                        </div>
                      </div>
                    </div>
                  </section>
                  
                          <div class="col-md-12">
                            <blockquote class="b-thin rounded primary">
                              <h3>Declaration</h3>
                            </blockquote>
                            <p>I agree to abide by NISM's rules, code of conduct and students' guidelines framed/to be framed from time to time. I hereby certify that the above information given is true and correct to the best of my knowledge. I understand that any false declaration shall result in disqualification of my admission to PGPSM.</p>
                          </div>
                          <div class="col-md-12">
                            <div class="checkbox-custom checkbox-default">
                              <input type="checkbox" id="agree" value="Iagree">
                              <label for="agree">I agree</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel-footer">
                        <ul class="pager">
                          <li class="previous"> <a class="btn btn-xs" id="prev_payment_declaration"><i class="fa fa-angle-left"></i> Previous</a> </li>
                          <li class="next">
                            <button class="btn  btn-primary pull-right round-button" id="next_payment_declaration">Next <i class="fa fa-angle-right"></i></button>
                          </li>
                        </ul>
                      </div>
                    </form>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      
      <!-- end: page --> 
    </section>
  </div>
</section>

<!-- Vendor --> 
<script src='<?php echo BASEURL;?>assets/javascripts/jquery.min.js'></script> 
<script src='<?php echo BASEURL;?>assets/javascripts/bootstrap.min.js'></script> 
<script src='<?php echo BASEURL;?>assets/javascripts/bootstrapvalidator.min.js'></script> 

<!-- Specific Page Vendor --> 
<script src="<?php echo BASEURL;?>assets/vendor/jquery-ui/jquery-ui.js"></script> 
<script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.init.js"></script> 
<script src="<?php echo BASEURL;?>assets/vendor/pnotify/pnotify.custom.js"></script>
<script src="<?php echo BASEURL;?>assets/javascripts/forms/user_registration.js"></script>
<script src="<?php echo BASEURL;?>assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<?php if(!empty($default_tab_selection))
       {
?>
<script><?php echo $default_tab_selection;?>()</script>
<?php
       }
?>

<!-- Validation --> 

<script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.form.validation.js"></script> 
<!-- Preview --> 
<script src="<?php echo BASEURL;?>assets/javascripts/forms/custom.preview.js"></script>
</body>
</html>