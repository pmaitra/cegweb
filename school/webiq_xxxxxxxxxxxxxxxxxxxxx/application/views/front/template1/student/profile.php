<?php
$imageCreation1 = genarateImageFromByteArr($basic_details['profileImage1']);
$imageCreation2 = genarateImageFromByteArr($basic_details['profileImage2']);
?>
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
            </ul>
            <div class="tab-content">
               <div id="overview" class="tab-pane active">
                   <h4 class="mb-xlg">Profile Images</h4>
                 <div class="row">
                     
                    <div class="col-md-3 col-lg-3 col-xl-3">
                         
                  <img class=" img-thumbnail img-responsive" src="<?php echo $imageCreation1;?>" onerror="this.src ='<?php echo BASEURL."assets/ssp";?>assets/images/noimg.png'"> 
                    </div>
                     <div class="col-md-3 col-lg-3 col-xl-3">
                          
                  <img class="img-thumbnail  img-responsive" src="<?php echo $imageCreation2;?>" onerror="this.src ='<?php echo BASEURL."assets/ssp";?>assets/images/noimg.png'"> 
                  </div>
                 </div>
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
                           <b>Admission Date</b>
                        </td>
                        <td>
                           <b>Blood Group</b>
                        </td>
                        <td>
                           <b>Category</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['gender']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['admissisonDate'],'date'); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['bloodGroup']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['category']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>Religion</b>
                        </td>
                        <td>
                           <b>Mothers Tongue</b>
                        </td>
                        <td>
                           <b>Aadhaar No</b>
                        </td>
                        <td>
                           <b>Nationality</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['religion']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['motherTongue']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['aadharNumber']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['nationality']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>Child ID</b>
                        </td>
                        <td>
                           <b>House</b>
                        </td>
                        <td>
                           <b>State Of Domicile</b>
                        </td>
                        <td>
                           <b>Scholarship</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['childId']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['house']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['stateOfDomicile']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['scholarship']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>Bank Name</b>
                        </td>
                        <td>
                           <b>Branch</b>
                        </td>
                        <td>
                           <b>A/C No.</b>
                        </td>
                        <td>
                           <b>Medical Status</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['bankName']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['branch']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['accountNumber']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['medicalStatus']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>E-Mail</b>
                        </td>
                        <td>
                            <b>Contact Number</b>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['email']); ?>
                        </td>
                        <td>
                             <?php echo displayCheck($basic_details['contactNumber']); ?>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <h4 class="mb-xlg">Father's Details</h4>
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
                           <b>In Defence</b>
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
                           <?php echo displayCheck($basic_details['fatherDefenceCategory']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>Service Status</b>
                        </td>
                        <td>
                           <b>Defence Category</b>
                        </td>
                        <td>
                           <b>Rank</b>
                        </td>
                        <td>
                           <b>Mobile</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['fatherServiceStatus']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['fatherDefenceCategory']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['fatherRank']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['fatherMobile']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>E-Mail</b>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['fatherEmail']); ?>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <h4 class="mb-xlg">Mother's Details</h4>
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
                           <b>Mobile</b>
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
                     </tr>
                     <tr>
                        <td>
                           <b>E-Mail</b>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['motherEmail']); ?>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <h4 class="mb-xlg">Guardian's Details</h4>
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
                           <b>Mobile</b>
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
                     </tr>
                     <tr>
                        <td>
                           <b>E-Mail</b>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                     <tr>
                        
                        <td>
                           <?php echo displayCheck($basic_details['guardianEmail']); ?>
                        </td>
                        
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <h4 class="mb-xlg">Income Details</h4>
                  <table class="table table-striped">
                     <tr>
                        <td>
                           <b>Father's Income</b>
                        </td>
                        <td>
                           <b>Mother's Income</b>
                        </td>
                        <td>
                           <b>Student's Income</b>
                        </td>
                        <td>
                           <b>Family Income</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['fatherIncome']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['motherIncome']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['studentIncome']); ?>
                        </td>
                        <td>
                            <?php echo displayCheck($basic_details['familyIncome']); ?>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <?php  
                         if(!empty($basic_details['address']))
                         {
                             
                             $addressArr = json_decode($basic_details['address'],true);
                             $address=$addressArr[0];
                             //pr($address);
                         ?>
                  <h4 class="mb-xlg">Present Address</h4>
                  <table class="table table-striped">
                     <tr>
                        <td colspan="2">
                           <b>Address</b>
                        </td>
                        <td colspan="2">
                           <b>Landmark</b>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2">
                           <?php echo displayCheck($address['presentAddressLine']); ?>
                        </td>
                        <td colspan="2">
                           <?php echo displayCheck($address['presentAddressLandmark']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>City/Village</b>
                        </td>
                        <td>
                           <b>Pin Code</b>
                        </td>
                        <td>
                           <b>District</b>
                        </td>
                        <td>
                           <b>Post Office</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($address['presentAddressCityVillage']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['presentAddressPinCode']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['presentAddressDistrict']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['presentAddressState']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>Police Station</b>
                        </td>
                        <td>
                           <b>State</b>
                        </td>
                        <td>
                           <b>Country</b>
                        </td>
                        <td>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($address['presentAddressPoliceStation']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['presentAddressState']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['presentAddressCountry']); ?>
                        </td>
                        <td>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <h4 class="mb-xlg">Permanent Address</h4>
                  <table class="table table-striped">
                     <tr>
                        <td colspan="2">
                           <b>Address</b>
                        </td>
                        <td colspan="2">
                           <b>Landmark</b>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2">
                           <?php echo displayCheck($address['permanentAddressLine']); ?>
                        </td>
                        <td colspan="2">
                           <?php echo displayCheck($address['permanentAddressLandmark']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>City/Village</b>
                        </td>
                        <td>
                           <b>Pin Code</b>
                        </td>
                        <td>
                           <b>District</b>
                        </td>
                        <td>
                           <b>Post Office</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($address['permanentAddressCityVillage']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['permanentAddressPinCode']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['permanentAddressDistrict']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['permanentAddressPostOffice']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>Police Station</b>
                        </td>
                        <td>
                           <b>State</b>
                        </td>
                        <td>
                           <b>Country</b>
                        </td>
                        <td>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($address['permanentAddressPoliceStation']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['permanentAddressState']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['permanentAddressCountry']); ?>
                        </td>
                        <td>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <h4 class="mb-xlg">Local Guardian's Address</h4>
                  <table class="table table-striped">
                     <tr>
                        <td colspan="2">
                           <b>Address</b>
                        </td>
                        <td colspan="2">
                           <b>Landmark</b>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2">
                           <?php echo displayCheck($address['guardianAddressLine']); ?>
                        </td>
                        <td colspan="2">
                           <?php echo displayCheck($address['guardianAddressLandmark']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>City/Village</b>
                        </td>
                        <td>
                           <b>Pin Code</b>
                        </td>
                        <td>
                           <b>District</b>
                        </td>
                        <td>
                           <b>Post Office</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($address['guardianAddressCityVillage']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['guardianAddressPinCode']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['guardianAddressDistrict']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['guardianAddressPostOffice']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <b>Police Station</b>
                        </td>
                        <td>
                           <b>State</b>
                        </td>
                        <td>
                           <b>Country</b>
                        </td>
                        <td>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($address['guardianAddressPoliceStation']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['guardianAddressState']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($address['guardianAddressCountry']); ?>
                        </td>
                        <td>
                        </td>
                     </tr>
                  </table>
                  <?php } ?>
                  <hr>
                  <h4 class="mb-xlg">Other Details</h4>
                  <table class="table table-striped">
                     <tr>
                        <td>
                           <b>Food Preference</b>
                        </td>
                        <td>
                           <b>Pickup Place</b>
                        </td>
                        <td>
                           <b>Hobbies</b>
                        </td>
                        <td>
                           <b>Personal Identification</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['foodPreference']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['firstPickUpPlace']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['hobbies']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['personalIdentificationMark']); ?>
                        </td>
                     </tr>
                  </table>
                  <hr>
                  <h4 class="mb-xlg">Previous Education Details</h4>
                  <table class="table table-striped">
                     <tr>
                        <td>
                           <b>School Name</b>
                        </td>
                        <td>
                           <b>Website</b>
                        </td>
                        <td>
                           <b>E-Mail</b>
                        </td>
                        <td>
                           <b>Phone</b>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <?php echo displayCheck($basic_details['previousSchoolName']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['previousSchoolWebsite']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['previousSchoolEmail']); ?>
                        </td>
                        <td>
                           <?php echo displayCheck($basic_details['previousSchoolPhone']); ?>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2">
                           <b>Address</b>
                        </td>
                        <td colspan="2">
                           <b>Previous Achivement</b>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2">
                           <?php echo displayCheck($basic_details['previousSchoolAddress']); ?>
                        </td>
                        <td colspan="2">
                           <?php echo displayCheck($basic_details['previousAchivement']); ?>
                        </td>
                     </tr>
                  </table>
               </div>
               
            </div>
         </div>
      </div>
   </div>
   <!-- end: page -->
</section>