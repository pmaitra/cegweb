<section role="main" class="content-body">
   <header class="page-header">
      <h2>User Profile</h2>
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
         <div class="tabs">
            <ul class="nav nav-tabs tabs-primary">
               <li class="active">
                  <a href="#overview" data-toggle="tab">Personal Information</a>
               </li>
               
               <li>
                  <a href="#change-password" data-toggle="tab">Change Password</a>
               </li>
            </ul>
            <div class="tab-content">
               <div id="overview" class="tab-pane active">
                  
                     <header class="page-header">
                        <h2>Personal Information</h2>
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
                        
                                 
                        
                            <!--
                            <div class="form-group">
                               <label class="col-md-4 control-label" for="userfirstname">First Name:</label>
                               <div class="col-md-8">
                                  <input type="text" class="form-control" id="user_first_name" name="user_first_name" value="<?php echo (!empty($user_list['first_name']))?$user_list['first_name']:'';?>">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-md-4 control-label" for="usermiddlename">Middle Name:</label>
                               <div class="col-md-8">
                                  <input type="text" class="form-control" id="user_middle_name" name="user_middle_name" value="<?php echo (!empty($user_list['middle_name']))?$user_list['middle_name']:'';?>">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-md-4 control-label" for="userlastname">Last Name:</label>
                               <div class="col-md-8">
                                  <input type="text" class="form-control" id="user_last_name" name="user_last_name" value="<?php echo (!empty($user_list['last_name']))?$user_list['last_name']:'';?>">
                               </div>
                            </div>
                            -->
                            <div class="form-group">
                               <label class="col-md-2 control-label " for="user_profile_picture">Profile Picture:</label>
                               <div class="col-md-4">
                                  <input type="file" class="form-control file_upload_input" id="profile_picture" name="profile_picture" value="<?php //echo set_value('zip_code'); ?>" placeholder="">
                                  <input type="hidden" class="" id="profile_picture_input" value="" >
                               </div>
                               <div class="col-md-2">
                                   <button  id="update_profile_information" class="btn btn-primary">Update</button>
                               </div>
                            </div>
                        
                        
                        
                        
                        
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
                                          <?php echo ucfirst($candidate_details['first_name']);?>
                                       </td>
                                       <td>
                                          <?php echo ucfirst($candidate_details['middle_name']);?>
                                       </td>
                                       <td>
                                          <?php echo ucfirst($candidate_details['last_name']);?>
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
                                          <?php echo getCountryById($single_address['country_id']);?>
                                       </td>
                                    </tr>
                                    <?php
                                       }}
                                       ?>
                                 </table>
                                 <hr>
                                 <h4>Add New Address</h4>
                                 <div class="well">
                                    <!--<form id="add-user-frm" class="form-horizontal" >-->
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
                                    <!--</form>-->
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
                                    <!--      <form id="add-qualification-frm" class="form-horizontal" >-->
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
                                    <!--</form>-->
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
                                    <!--     <form id="add-professional-exp-frm" class="form-horizontal" >-->
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
                                    <!--   </form>-->
                                 </div>
                                 <hr>
                                 <?php if(!empty($candidate_payment_details)){ ?>
                                 <h4>Payment Details</h4>
                                 <table class="table table-striped">
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
                                 </table>
                                 <?php } ?> 
                              </div>
                           </section>
                        </div>
                     </div>
                     <!-- end: page -->
                 
               </div>
               <div id="change-password" class="tab-pane">
                  <form action="<?php echo BASEURL;?>changepasswordsubmit" class="form-horizontal" method="post">
                     <h4 class="mb-xlg">Change Password</h4>
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
               <?php //if(!empty($user_list)){
                  ?>
               <div id="profile_pic_verify1" class="tab-pane">
                  <form action="<?php echo BASEURL;?>updateProfilePicturesubmit" class="form-horizontal" method="post">
                     <h4 class="mb-xlg">Profile Picture Verification</h4>
                     <fieldset class="mb-xl">
                        <div class="form-group">
                           <label class="col-md-4 control-label" for="userfirstname">First Name:</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" id="user_first_name" name="user_first_name" value="<?php echo (!empty($user_list['first_name']))?$user_list['first_name']:'';?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-md-4 control-label" for="usermiddlename">Middle Name:</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" id="user_middle_name" name="user_middle_name" value="<?php echo (!empty($user_list['middle_name']))?$user_list['middle_name']:'';?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-md-4 control-label" for="userlastname">Last Name:</label>
                           <div class="col-md-8">
                              <input type="text" class="form-control" id="user_last_name" name="user_last_name" value="<?php echo (!empty($user_list['last_name']))?$user_list['last_name']:'';?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-md-4 control-label " for="user_profile_picture">Profile Picture:</label>
                           <div class="col-md-8">
                              <input type="file" class="form-control file_upload_input" id="profile_pic" name="profile_pic" value="<?php //echo set_value('zip_code'); ?>" placeholder="">
                              <input type="hidden" class="" id="user_profile_picture" name="user_profile_picture">
                           </div>
                        </div>
                     </fieldset>
                     <div class="panel-footer">
                        <div class="row">
                           <div class="col-md-9 col-md-offset-4">
                              <button  id="update_profile_picture" class="btn btn-primary">Submit</button>
                              <button type="reset" class="btn btn-default">Edit</button>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <?php // } ?>
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