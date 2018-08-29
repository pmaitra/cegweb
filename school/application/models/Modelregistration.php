<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ModelRegistration extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function candidateRegister($formData) {
        $error_msg['responseCode']=406;
        $error_msg['message']='error';
        $error_msg['result']='';
        $user_id = fetch_single_value('users', 'id',array('email_id'=>$formData['email']));
        
        if(empty($user_id))
        {
            $user_id = $this->userRegister($formData);
        }
        
        if(!empty($user_id))
        {
            $candidate_id = $this->candidateDetailsEntry($formData,$user_id);
            if(!empty($candidate_id))
            {
                $application_id = $this->addmissionEntry($formData,$candidate_id,$user_id); 
                
                $this->addressEntry($formData,$candidate_id,$user_id); 
                
                $success_msg['responseCode']=200;
                $success_msg['message']='success';
                $success_msg['result']= $application_id;
                return $success_msg;
            }
            else 
            {
                $error_msg['message']='You have already registered for this course.Please login and continue';
            }
            
            
            
        }
        return $error_msg;
    }
  
    public function candidateAccademicsRegister($formData) {
        $error_msg['responseCode']=406;
        $error_msg['message']='error';
        $error_msg['result']='';
        if($this->session->userdata('loggedinuserid') && !empty($formData['application_id']))
        {
           $user_id =  $this->session->userdata('loggedinuserid');
           $candidate_id = fetch_single_value('candidate_courses_map', 'candidate_id',array('id'=>$formData['application_id']));
           $candidate_details = fetch_single_row('candidate_details', '',array('id'=>$candidate_id));
           $candidate_id = $candidate_details['id'];
           //pr($candidate_details);
        }
        else if($this->session->userdata('loggedinuserid'))
        {
           $user_id =  $this->session->userdata('loggedinuserid');
           $candidate_details = fetch_single_row('candidate_details', '',array('user_id'=>$user_id));
           $candidate_id = $candidate_details['id'];
           //pr($candidate_details);
        }
        else 
        {
            $candidate_details = fetch_single_row('candidate_courses_map', '',array('id'=>$formData['application_id']));
            $user_id = fetch_single_value('candidate_details', 'user_id',array('id'=>$candidate_details['candidate_id']));
            $candidate_id = $candidate_details['candidate_id'];
        }
        

        if(!empty($user_id))
        {

            $this->candidateQualificationEntry($formData,$candidate_id,$user_id);
            single_column_update('candidate_details', array('form_flag'=>2), array('id'=>$candidate_id));
            single_column_update('candidate_details', array('dirty_flag'=>1), array('id'=>$candidate_id));
            
            //$this->candidateProfessionEntry($formData,$candidate_id,$user_id);
            $success_msg['responseCode']=200;
            $success_msg['message']='success';
            $success_msg['result']= $formData['application_id'];
            return $success_msg;
        }
        else 
        {
            $error_msg['message']='User not found !! Please start again';
        }
        return $error_msg;
    }
    
    public function candidateExperienceRegister($formData) {
        $error_msg['responseCode']=406;
        $error_msg['message']='error';
        $error_msg['result']='';
        if($this->session->userdata('loggedinuserid') && !empty($formData['application_id']))
        {
           $user_id =  $this->session->userdata('loggedinuserid');
           $candidate_id = fetch_single_value('candidate_courses_map', 'candidate_id',array('id'=>$formData['application_id']));
           $candidate_details = fetch_single_row('candidate_details', '',array('id'=>$candidate_id));
           $candidate_id = $candidate_details['id'];
           //pr($candidate_details);
        }
        else if($this->session->userdata('loggedinuserid'))
        {
           $user_id =  $this->session->userdata('loggedinuserid');
           $candidate_details = fetch_single_row('candidate_details', '',array('user_id'=>$user_id));
           $candidate_id = $candidate_details['id'];
        }
        else 
        {
            $candidate_details = fetch_single_row('candidate_courses_map', '',array('id'=>$formData['application_id']));
            $user_id = fetch_single_value('candidate_details', 'user_id',array('id'=>$candidate_details['candidate_id']));
        
            $candidate_id = $candidate_details['candidate_id'];
        }
        
        
        if(!empty($user_id))
        {
            $this->candidateProfessionEntry($formData,$candidate_id,$user_id);
            
            single_column_update('candidate_details', array('form_flag'=>3), array('id'=>$candidate_id));
            single_column_update('candidate_details', array('dirty_flag'=>1), array('id'=>$candidate_id));
 
            $success_msg['responseCode']=200;
            $success_msg['message']='success';
            $success_msg['result']=$formData['application_id'];
            return $success_msg;
        }
        else 
        {
            $error_msg['message']='User not found !! Please start again';
        }
        return $error_msg;
    }
    
    public function userRegister($formData) {
  
        $param['username'] = $formData['email'];
        $param['email_id'] = $formData['email'];
        $param['first_name'] = $formData['first_name'];
        $param['middle_name'] = $formData['middle_name'];
        $param['last_name'] = $formData['last_name'];
        // Profile picture update
        if(!empty($formData['profile_picture']))
        {
            $param['profile_picture'] = $formData['profile_picture'];
        }
        $param['password'] = md5('password');
        $param['created_date'] = date ('Y-m-d H:i:s');
        
        $param['status'] = '1';
        $this->db->insert('users', $param);
        $user_id = $this->db->insert_id();
        
        if(!empty($user_id))
        {   
            //Adding user to group
            $group_param['group_id'] = fetch_single_value('groups', 'id', array('group_name'=>GROUP_NISM_APPLICANT));
            $group_param['user_id'] = $user_id;
            $this->db->insert('user_groups_map', $group_param);
            return $user_id;
        }
        return FALSE;
     }
     
     public function addmissionEntry($formData,$candidate_id,$user_id) {
  
            $param['course_id'] = $formData['course_id'];
            $param['candidate_id'] = $candidate_id;
            $param['created_by'] = $user_id;
            $param['created_date'] = date ('Y-m-d H:i:s');

            $this->db->insert('candidate_courses_map', $param);
            $application_id = $this->db->insert_id();
            if(!empty($application_id))
            {
                return $application_id;
            }
     }
     
     public function candidateDetailsEntry($formData,$user_id) {
         
            //Course id
            //$param['course_id'] = fetch_single_value('courses', 'id',array('name'=>$formData['course_name']));
            $param['course_id'] = $formData['course_id'];
            $candidate_id = fetch_single_value('candidate_details', 'id',array('course_id'=>$param['course_id'],'user_id'=>$user_id));
            //echo $this->db->last_query();die;
            if(empty($candidate_id))
            {
                $param['email_id'] = $formData['email'];
                $param['user_id'] = $user_id;

                //candidate details
                $param['first_name'] = $formData['first_name'];
                $param['middle_name'] = $formData['middle_name'];
                $param['last_name'] = $formData['last_name'];

                //Date formatting
                $param['date_of_birth'] = input_date_convertion($formData['date_of_birth']);

                $param['sex'] = $formData['sex_is'];
                $param['marrital_status'] = $formData['marital_status_is'];
                $param['parents_name'] = $formData['parents_name'];
                $param['parents_email'] = $formData['parents_email'];
                $param['parents_phone'] = $formData['parents_contact_no'];
                $param['relationship'] = $formData['relationship'];
                $param['contact_number'] = $formData['contact_no'];
                $param['email_id'] = $formData['email'];
                $param['form_flag'] = 1;
                $param['dirty_flag'] = 1;
                $param['pan_card_no'] = $formData['pan_card_no'];
                $param['adhar_card_no'] = $formData['adhar_card_no'];
                $param['voter_card_no'] = $formData['voter_card_no'];
                $param['passport_no'] = $formData['passport_no'];
                $param['interview_preferred_location'] = $formData['interview_preferred_location'];
                
                // Profile picture update
                if(!empty($formData['profile_picture']))
                {
                    $param['profile_picture'] = $formData['profile_picture'];
                }
                // Pan card update
                if(!empty($formData['pan_card']))
                {
                    $param['pan_card_link'] = $formData['pan_card'];
                }
                // Adhar card update
                if(!empty($formData['adhar_card']))
                {
                    $param['adhar_card_link'] = $formData['adhar_card'];
                }
                // Voter card update
                if(!empty($formData['voter_card']))
                {
                    $param['voter_card_link'] = $formData['voter_card'];
                }
                // Passport update
                if(!empty($formData['passport']))
                {
                    $param['passport_link'] = $formData['passport'];
                }
                /*$param['academic_or_cocurricular_achievements'] = $formData['academic_achievement'];
                $param['professional_experience'] = $formData['total_exp_years'].'.'.$formData['total_exp_months'];
                $param['professional_achievements'] = $formData['professional_achievements'];
                if(!empty($formData['competitive_exams_check']))
                {
                    $param['competitive_exams'] = json_encode($formData['competitive_exams_check']);
                }
                if(!empty($formData['professional_qualification_check']))
                {
                    $param['professional_qualification'] = json_encode($formData['professional_qualification_check']);
                }
                */
                $param['created_date'] = date ('Y-m-d H:i:s');


                $this->db->insert('candidate_details', $param);
                $candidate_id = $this->db->insert_id(); 
                if($candidate_id)
                {
                    return $candidate_id;
                }
            }
        return FALSE;
     }
     
     //For Single address entry
    public function candidateUpdate($param,$candidate_id,$user_id) {
            $this->db->where('id' , $candidate_id);
            $this->db->update('candidate_details',$param);   
        return FALSE;
    }
     
    //For Single address entry
    public function addressEntry($formData,$candidate_id,$user_id) {
            $param['candidate_id'] = $candidate_id;
            
            $param['street_address'] = $formData['street_address'];
            $param['address_line_2'] = $formData['address_line_2'];
            $param['city'] = $formData['city'];
            $param['state'] = $formData['state'];
            $param['postal_code'] = $formData['zip_code'];
            $param['country_id'] = $formData['country'];
            $param['mobile_no'] = $formData['contact_no'];
            $param['created_by'] = $user_id;   
            $param['created_date'] = date ('Y-m-d H:i:s');
            
            $this->db->insert('address', $param);
            $address_id = $this->db->insert_id();
            
            if($address_id)
            {
                return $address_id;
            }
        return FALSE;
    }

    
    public function candidateQualificationEntry($formData,$candidate_id,$user_id) {
            
            if(!empty($formData['competitive_exams_check']))
            {
                $candidateParam['competitive_exams'] = json_encode($formData['competitive_exams_check']);
            }
            if(!empty($formData['professional_qualification_check']))
            {
                $candidateParam['professional_qualification'] = json_encode($formData['professional_qualification_check']);
            }
            if(!empty($formData['academic_achievement']))
            {
                $candidateParam['academic_or_cocurricular_achievements'] = $formData['academic_achievement'];
            }
            if(!empty($candidateParam))
            {
                $this->candidateUpdate($candidateParam,$candidate_id,$user_id);
            }
            //SSC Entry
            $paramReset['institute_name'] = $formData['name_of_the_school_ssc'];            
            $paramReset['affiliation'] = $formData['name_of_the_board_ssc'];
            $paramReset['end_date'] = date("Y-m-d", strtotime('01/01/'.$formData['year_of_passing_ssc']));
            $paramReset['percentage'] = $formData['percentage_ssc'];
            $paramReset['status_of_completion'] = '';
            $paramReset['degree_type'] = 'SSC';
            $paramReset['degree'] = 'SSC';
            $paramReset['start_date']='';
            $paramReset['cgpa'] ='';
            $paramReset['specialization'] = '';
            
            $this->qualificationEntry($paramReset,$candidate_id,$user_id);
            
            $paramReset['institute_name'] = $formData['name_of_the_school_hsc'];            
            $paramReset['affiliation'] = $formData['name_of_the_board_hsc'];
            $paramReset['end_date'] =date("Y-m-d", strtotime('01/01/'.$formData['year_of_passing_hsc']));
            $paramReset['percentage'] = $formData['percentage_hsc'];
            $paramReset['status_of_completion'] = '';
            $paramReset['degree'] = 'HSC';
            $paramReset['degree_type'] = 'HSC';
            $paramReset['start_date']='';
            $paramReset['cgpa'] ='';
            $paramReset['specialization'] = $formData['group_major'];
            
            $this->qualificationEntry($paramReset,$candidate_id,$user_id);
            
            $paramReset['degree'] = $formData['degree_diploma_ug'];
            $paramReset['degree_type'] ='UG';
            $paramReset['specialization'] = $formData['specialization_ug'];
            $paramReset['institute_name'] = $formData['name_of_the_college_ug'];            
            $paramReset['affiliation'] = $formData['name_of_the_university_ug'];
            $paramReset['status_of_completion'] = $formData['status_of_completion_ug'];           
            $paramReset['end_date'] = date("Y-m-d", strtotime('01/01/'.$formData['year_of_passing_ug']));
            $paramReset['percentage'] = $formData['percentage_ug'];          
            $paramReset['start_date']='';
            $paramReset['cgpa'] ='';
            
            $this->qualificationEntry($paramReset,$candidate_id,$user_id);
            
            if(!empty($formData['degree_diploma_pg']) && ($formData['degree_diploma_pg'] != 'Select'))
            {
                $paramReset['degree'] = $formData['degree_diploma_pg'];
                $paramReset['degree_type'] ='PG';
                $paramReset['specialization'] = $formData['specialization_pg'];
                $paramReset['institute_name'] = $formData['name_of_the_college_pg'];            
                $paramReset['affiliation'] = $formData['name_of_the_university_pg'];
                $paramReset['status_of_completion'] = $formData['status_of_completion_pg'];           
                $paramReset['end_date'] = date("Y-m-d", strtotime('01/01/'.$formData['year_of_passing_pg']));
                $paramReset['percentage'] = $formData['percentage_pg'];
                $paramReset['status_of_completion'] = '';
                $paramReset['start_date']='';
                $paramReset['cgpa'] ='';
            
                $this->qualificationEntry($paramReset,$candidate_id,$user_id);
            }
            
    }
    
    //For Single qualification entry
    public function qualificationEntry($formData,$candidate_id,$user_id) {
            $param['candidate_id'] = $candidate_id;
            
            $param['degree'] = $formData['degree'];
            $param['specialization'] = $formData['specialization'];
            $param['institute_name'] = $formData['institute_name'];
            $param['affiliation'] = $formData['affiliation'];
            $param['start_date'] = $formData['start_date'];
            $param['end_date'] = $formData['end_date'];
            $param['percentage'] = $formData['percentage'];
            if(!empty( $formData['degree_type']))
            {
                $param['degree_type'] =$formData['degree_type'];
            }
            else
            {
                $param['degree_type'] ='PG';
            }
            
            $param['status_of_completion'] = $formData['status_of_completion'];
            $param['cgpa'] = $formData['cgpa'];
            $param['created_by'] = $user_id;   
            $param['created_date'] = date ('Y-m-d H:i:s');
            
            $this->db->insert('qualification_details', $param);
            $address_id = $this->db->insert_id();
            
            if($address_id)
            {
                return $address_id;
            }
        return FALSE;
    }
    
    public function candidateProfessionEntry($formData,$candidate_id,$user_id) 
    {
            if(empty($formData['total_exp_years']))
            {
                $formData['total_exp_years'] = 0;
            }
            if(empty($formData['total_exp_months']))
            {
                $formData['total_exp_months'] = 0;
            }
            
            $candidateParam['professional_experience'] = $formData['total_exp_years'].'.'.$formData['total_exp_months'];
            if(!empty($formData['professional_achievements']))
            {
                $candidateParam['professional_achievements'] = $formData['professional_achievements'];
            }
            
            $this->candidateUpdate($candidateParam,$candidate_id,$user_id);
            $paramReset['organization'] = $formData['organization_1'];            
            $paramReset['designation'] = $formData['designation_1'];
            $paramReset['roles'] = $formData['roles_1'];
            $paramReset['start_from'] = date("Y-m-d", strtotime($formData['start_from_1']));
            $paramReset['start_to'] = date("Y-m-d", strtotime($formData['start_to_1']));
            //pr($candidate_id);
            $this->professionEntry($paramReset,$candidate_id,$user_id);

            $paramReset['organization'] = $formData['organization_2'];            
            $paramReset['designation'] = $formData['designation_2'];
            $paramReset['roles'] = $formData['roles_2'];
            $paramReset['start_from'] = date("Y-m-d", strtotime($formData['start_from_2']));
            $paramReset['start_to'] = date("Y-m-d", strtotime($formData['start_to_2']));
           
            $this->professionEntry($paramReset,$candidate_id,$user_id);

            $paramReset['organization'] = $formData['organization_3'];            
            $paramReset['designation'] = $formData['designation_3'];
            $paramReset['roles'] = $formData['roles_3'];
            $paramReset['start_from'] = date("Y-m-d", strtotime($formData['start_from_3']));
            $paramReset['start_to'] = date("Y-m-d", strtotime($formData['start_to_3']));
           
            $this->professionEntry($paramReset,$candidate_id,$user_id);

    }

    public function professionEntry($formData,$candidate_id,$user_id) 
    {
            $param['candidate_id'] = $candidate_id;
            $param['organization'] = $formData['organization'];
            
            if(!empty($param['organization']))
            {
                $param['designation'] = $formData['designation'];
                $param['roles'] = $formData['roles'];
                $param['start_from'] = $formData['start_from'];
                $param['start_to'] = $formData['start_to'];
                $param['created_by'] = $user_id;   
                $param['created_date'] = date ('Y-m-d H:i:s');

                $this->db->insert('professional_details', $param);
                $address_id = $this->db->insert_id();
            
                if($address_id)
                {
                    return $address_id;
                }
            }
            else 
            {
                //To protect Blank entry Have to change it later
                return TRUE;   
            }
        return FALSE;
    }

     public function updateCandidateDetails($user,$candidate_id)
    {
        $param['first_name'] = $user['first_name'];
        $param['middle_name'] = $user['middle_name'];
        $param['last_name'] = $user['last_name'];
        $param['date_of_birth'] = input_date_convertion($user['date_of_birth']);

        $param['sex'] = $user['sex_is'];
        $param['marrital_status'] = $user['marital_status_is'];
        $param['parents_name'] = $user['parents_name'];
        $param['parents_email'] = $user['parents_email'];
        $param['parents_phone'] = $user['parents_contact_no'];
        $param['relationship'] = $user['relationship'];
        $param['contact_number'] = $user['contact_no'];
        $param['pan_card_no'] = $user['pan_card_no'];
        $param['adhar_card_no'] = $user['adhar_card_no'];
        $param['voter_card_no'] = $user['voter_card_no'];
        $param['passport_no'] = $user['passport_no'];
        $param['interview_preferred_location'] = $user['interview_preferred_location'];
                
        // Profile picture update
        if(!empty($user['profile_picture']))
        {
            $param['profile_picture'] = $user['profile_picture'];
        }
        // Pan card update
        if(!empty($user['pan_card']))
        {
            $param['pan_card_link'] = $user['pan_card'];
        }
        // Adhar card update
        if(!empty($user['adhar_card']))
        {
            $param['adhar_card_link'] = $user['adhar_card'];
        }
        // Voter card update
        if(!empty($user['voter_card']))
        {
            $param['voter_card_link'] = $user['voter_card'];
        }
        // Passport update
        if(!empty($user['passport']))
        {
            $param['passport_link'] = $user['passport'];
        }
        $param['modified_date'] = date ('c');
        
        $this->db->where('id', $candidate_id);
        $this->db->update('candidate_details', $param);
        $userid = $this->db->affected_rows();

       if(!empty($candidateid))
        {
           //$this->service_company_id_update($service_company_id);
           return $candidateid;
        }
       return FALSE;
    }

    public function updateUser($user,$user_id)
    {
        $param['first_name'] = $user['first_name'];
        $param['middle_name'] = $user['middle_name'];
        $param['last_name'] = $user['last_name'];
        $param['profile_picture'] = $user['profile_picture'];

        $param['modified_date'] = date ('c');
        
        $this->db->where('id', $user_id);
        $this->db->update('users', $param);
        $userid = $this->db->affected_rows();

       if(!empty($userid))
        {
           //$this->service_company_id_update($service_company_id);
           return $userid;
        }
       return FALSE;
    }
            
    public function updateAddress($formData,$candidate_id,$user_id) {
            //$param['candidate_id'] = $candidate_id;
            
            $param['street_address'] = $formData['street_address'];
            $param['address_line_2'] = $formData['address_line_2'];
            $param['city'] = $formData['city'];
            $param['state'] = $formData['state'];
            $param['postal_code'] = $formData['zip_code'];
            $param['country_id'] = $formData['country'];
            $param['mobile_no'] = $formData['contact_no'];
            $param['modified_by'] = $user_id;   
            $param['modified_date'] = date ('Y-m-d H:i:s');
            
            $this->db->where('candidate_id', $candidate_id);
            $this->db->update('address', $param);
            $address_id = $this->db->affected_rows();

            if($address_id)
            {
                return $address_id;
            }
        return FALSE;
    }
            
    
}



?>