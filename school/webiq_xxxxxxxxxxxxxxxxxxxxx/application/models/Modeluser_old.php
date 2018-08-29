<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modeluser extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function validate($user){
        // grab user input
        $username = $user['username'];
        $password = $user['password'];

        $this->db->SELECT(array('id as userid','first_name','middle_name','last_name','profile_picture'));
        //$this->db->where('username', $username);
        $this->db->where('email_id', $username);
        $this->db->where('password', md5($password));
        $this->db->where('status', '1');

        // Run the query
        $query = $this->db->get('users');
        
        //echo $this->db->last_query();die;
        // Let's check if there are any results
        if($query->num_rows() == 1)
        {
            // If there is a user, then create session data
            $row = $query->row(); 
            //Role validation
            //if($row->user_type =='customer' )
            //{               
               $login_data = array('loggedinusername'=>$username,
                   'loggedinuserid'=>$row->userid,'loggedadmin'=>0);  
               if(!empty($row->userid))
               {
                    $admin_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_NISM_ADMIN));
                    $user_map = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$admin_group_id,'user_id'=>$row->userid));
               }

                if(!empty($user_map))
                {
                    $login_data['loggedadmin']  = 1;
                }
                else 
                {
                    $login_data['candidate_details'] = fetch_single_row('candidate_details', array('course_id','first_name','middle_name','last_name','profile_picture'), array('user_id'=>$row->userid));
                    $login_data['candidate_details']['first_name'] = $row->first_name;
                    $login_data['candidate_details']['middle_name'] = $row->middle_name;
                    $login_data['candidate_details']['profile_picture'] = $row->profile_picture;
                    //profile_picture
                    if(!empty($login_data['candidate_details']['course_id']))
                    {
                        $course_details = fetch_single_row('courses', array('name','id'), array('id'=> $login_data['candidate_details']['course_id']));
                        $response['course_name'] = $course_details['name'];
                        $response['course_id'] = $course_details['id'];
                    }
                    
                }
            
            $this->session->set_userdata($login_data);

            $param = array(               
               'login_time'=>date("Y-m-d H:i:s"),
               'user_id'=>$row->userid
            );
            $this->db->insert('user_login_history', $param);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
    
    public function passwordChange($user) 
    {

        $param['password'] = $user['new_password'];
        $param['modified_date'] = date ('c');
	$username = $this->session->userdata('loggedinusername');
	$this->db->where('email_id', $username);
               $this->db->update('users', $param);
               $userid = $this->db->affected_rows();

       if(!empty($userid))
        {
           //$this->service_company_id_update($service_company_id);
           return $userid;
        }
       return FALSE;
   }
   
	   public function checkOldPass($old_password)
	   {
		   $param['password'] = $old_password;
		   $username = $this->session->userdata('loggedinusername');
		   
			$this->db->SELECT(array('id as userid'));
			$this->db->where('password', $param['password']);
		   $this->db->where('email_id', $username);
		   $this->db->where('status', '1');
		   
		   $query = $this->db->get('users');
		   //echo $this->db->last_query();die;
		   if($query->num_rows() == 1)
			{
				return TRUE;
				
			}
                        
		   return FALSE;
	 
            }
            
            public function forgetPassword($user)
            {
                $username = $user['username'];
                $param['password'] = $user['new_password'];
                $param['modified_date'] = date ('c');

                $this->db->where('username', $username);
                       $this->db->update('users', $param);
                       $userid = $this->db->affected_rows();
                if($userid)
                        {
                            //pr($userid);
                            return $userid;
                        }
                        return FALSE; 
            }
            
            public function addAddress($user)
            {
                $username = $this->session->userdata('loggedinusername');
                $user_id = fetch_single_value('users', 'id',array('username'=>$username));          
                $candidate_id = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));

                $param['candidate_id'] = $candidate_id;
                $param['mobile_no'] = $user['contact_no_1'];
                $param['street_address'] = $user['street_address_1'];
                $param['address_line_2'] = $user['address_line2_1'];
                $param['city'] = $user['city_1'];
                $param['state'] = $user['state_1'];
                $param['postal_code'] = $user['postal_code_1'];
                $param['country_id'] = $user['country_1'];
                $param['created_by'] = $user_id;
                $param['created_date'] = date ('c');

                $this->db->insert('address', $param);
                $address_id = $this->db->insert_id();

                if($address_id)
                {
                    return $address_id;
                }
                return FALSE;      

            }

            public function addQualificationDetails($user)
            {
                $username = $this->session->userdata('loggedinusername');
                $user_id = fetch_single_value('users', 'id',array('username'=>$username));          
                $candidate_id = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));

                $param['candidate_id'] = $candidate_id;
                $param['degree'] = $user['degree_1'];
                $param['degree'] = 'PG';
                $param['specialization'] = $user['specialization_1'];
                $param['institute_name'] = $user['name_of_college_1'];
                $param['affiliation'] = $user['name_of_university_1'];
                $param['status_of_completion'] = "";
                $param['start_date'] = "";
                $param['end_date'] = $user['year_of_passing_1'];
                $param['percentage'] = $user['percentage_1'];
                $param['cgpa'] = "";             
                $param['created_by'] = $user_id;
                $param['created_date'] = date ('Y-m-d H:i:s');

                $this->db->insert('qualification_details', $param);
                
                $professional_id = $this->db->insert_id();

                if($professional_id)
                {
                    return $professional_id;
                }
                return FALSE;      

            }

             public function addProfessionalExperience($user)
            {
                $username = $this->session->userdata('loggedinusername');
                $user_id = fetch_single_value('users', 'id',array('username'=>$username));          
                $candidate_id = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));

                $param['candidate_id'] = $candidate_id;
                $param['organization'] = $user['organization_1'];
                $param['designation'] = $user['designation_1'];
                $param['roles'] = $user['roles_1'];
                $param['start_from'] = $user['from_1'];
                $param['start_to'] = $user['to_1'];
                $param['created_by'] = $user_id;
                $param['created_date'] = date ('c');

                $this->db->insert('professional_details', $param);
                $professional_id = $this->db->insert_id();

                if($professional_id)
                {
                    return $professional_id;
                }
                return FALSE;      

            }
            
            public function get_all_user($course_id)
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                $this->db->where('payment_flag', '1'); 
                $this->db->where('form_flag >', '3'); 
                $this->db->where('scrutiny_flag <', '2'); 
                $this->db->where('interview_ready_flag', '0');

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            public function get_all_candidate_with_venue($course_id)
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id', 'candidate_venue_map.city', 'candidate_venue_map.address');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('candidate_venue_map', 'candidate_venue_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                
                //$this->db->where('status', $status); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_user_before_interview_schedule($course_id)
            {
                //pr($course_id);
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                $this->db->where('payment_flag', '1'); 
                $this->db->where('form_flag >', '3'); 
                $this->db->where('scrutiny_flag', '1');
                //$this->db->where('interview_ready_flag', '1');
                $this->db->where('interview_schedule_flag', '0');
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();
               // pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_user_after_interview_schedule($course_id)
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag','candidate_venue_map.city','candidate_venue_map.address','candidate_venue_map.interview_panel',
                    'candidate_venue_map.interview_date','candidate_venue_map.interview_time_slot');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('candidate_venue_map', 'candidate_venue_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                $this->db->where('candidate_venue_map.status', '1');
                $this->db->where('payment_flag', '1'); 
                $this->db->where('form_flag >', '3'); 
                $this->db->where('scrutiny_flag', '1');
                //$this->db->where('interview_ready_flag', '1');
                $this->db->where('interview_schedule_flag', '1');
                $this->db->where('interview_done_flag <', '1');
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function addPayment($user)
            {
                $param['invoice_id'] =  $user['invoice_id'];
                $param['candidate_id'] = $user['candidate_id'];
                $param['application_id'] = $user['application_id'];
                $param['amount'] = $user['amount'];
                $param['term_id'] = $user['term_id'];
                $param['payment_fee_type']   = $user['payment_fee_type'];
                $param['status'] = $user['status'];
                $param['created_date'] = date ('Y-m-d h:i:s');

                $this->db->insert('candidate_payment', $param);
                $payment_id = $this->db->insert_id();

                if($payment_id)
                {
                    return $payment_id;
                }
                return FALSE;      

            }

            public function addInterviewSlot($user)
            {
                $param['application_id'] = $user['application_id'];
               
                $param['candidate_id'] = $user['candidate_id'];
                $param['interview_panel'] = $user['interview_panel'];
                $param['interview_time_slot'] = $user['interview_slot'];
                $param['interview_date'] = $user['interview_date'];
                $param['city'] = $user['interview_city'];
                $param['address'] = $user['interview_address'];
                $param['location_id'] = $user['location_id'];
                $param['status'] = 1;
                $param['created_date'] = date ('c');

                $this->db->insert('candidate_venue_map', $param);
                $payment_id = $this->db->insert_id();

                if($payment_id)
                {
                    return $payment_id;
                }
                return FALSE;      

            }
            
             public function addTeacherCandidate($user)
            {
                $param['teacher_id'] = $user['teacher_id'];
               
                $param['location_id'] = $user['location_id'];
                $param['candidate_id'] = $user['candidate_id'];
                $param['course_id'] = $user['course_id'];
                $param['application_id'] = $user['application_id'];
                $param['interview_date'] = $user['interview_date'];
                $param['interview_date'] = $user['interview_date'];
                $param['interview_slot_id'] = $user['interview_slot_id'];

                $param['created_date'] = date ('c');

                $this->db->insert('teacher_candidate_map', $param);
                $payment_id = $this->db->insert_id();

                if($payment_id)
                {
                    //pr("hi");
                    return $payment_id;
                }
                return FALSE;      

            }

            public function get_venue_map_count($course_id)
            {
               
                $select_arr = array('COUNT(candidate_venue_map.id) as application_count','city');
                $this->db->select($select_arr);
                $this->db->from('candidate_venue_map');
                $this->db->join('candidate_details', 'candidate_venue_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_details.course_id', $course_id); 
                $this->db->group_by('city'); 
                $this->db->order_by('city', 'desc');
                //$this->db->where('status', $status); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_user_for_selection($course_id)
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
               // $this->db->join('candidate_marks_log', 'candidate_marks_log.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                $this->db->where('interview_schedule_flag', '1');
                //$this->db->where('candidate_marks_log.id',);
                $this->db->where('selected_flag', '0');
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_user_selected($course_id)
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name',
                    'candidate_courses_map.id as application_id','candidate_details.interview_score');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                $this->db->where('interview_done_flag', '1');
                $this->db->where('selected_flag', '1');
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_user_rejected($course_id)
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name',
                    'candidate_courses_map.id as application_id','candidate_details.interview_score');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                //$this->db->where('interview_done_flag', '1');
                $this->db->where('selected_flag', '2');
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }

            public function add_interview_marks()
            {
                
                $param['interview_score'] = $user['interview_marks'];
                $param['interview_score'] = $user['interview_marks'];
                $param['modified_date'] = date ('Y-m-d H:i:s');

                //$candidate_id = $this->session->userdata('loggedinusername');

                $this->db->where('id', $candidate_id);
                $this->db->update('candidate_details', $param);
                $candidate_id = $this->db->affected_rows();

                   if(!empty($candidate_id))
                    {
                       //$this->service_company_id_update($service_company_id);
                       return $candidate_id;
                    }
                   return FALSE;
            }
            
             public function get_all_course_for_candidate()
            {
               
                $select_arr = array('candidate_details.id as candidate_id','candidate_details.first_name','candidate_details.middle_name',
                    'candidate_details.last_name','candidate_details.profile_picture','candidate_details.date_of_birth',
                    'candidate_details.sex','candidate_details.marrital_status',
                    'candidate_details.contact_number','candidate_details.email_id','candidate_details.form_flag',
                    'candidate_details.interview_ready_flag','candidate_details.interview_schedule_flag','candidate_details.scrutiny_flag',
                    'candidate_details.selected_flag','candidate_details.pan_card_no','candidate_details.adhar_card_no',
                    'candidate_details.voter_card_no','candidate_details.passport_no'
                    ,'candidate_details.professional_qualification','candidate_details.competitive_exams',
                    'candidate_details.competative_exam_score','candidate_details.academic_or_cocurricular_achievements',
                    'candidate_details.professional_experience','candidate_details.professional_achievements',
                    'candidate_courses_map.id as application_id','candidate_details.interview_score',
                    'courses.name','courses.program_name','courses.id as course_id');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('courses', 'courses.id = candidate_details.course_id');
                $this->db->where('candidate_details.user_id', $this->session->userdata('loggedinuserid'));
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();
                //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_interview_for_teacher($teacher_id='',$course_id='',$limit='')
            {
               try{
                  
                $select_arr = array('teacher_candidate_map.id as schedule_id','courses.program_name',
                    'interview_time_slot.slot as interview_time_slot_display','candidate_details.first_name','candidate_details.middle_name',
                    'candidate_details.last_name','candidate_courses_map.id as application_id',
                    'candidate_venue_list.city','candidate_venue_list.city','candidate_venue_list.address',
                    'teacher_candidate_map.interview_date');
                //$select_arr = array('teacher_candidate_map.id as schedule_id');
                $this->db->select($select_arr);
                $this->db->from('teacher_candidate_map');
                $this->db->join('candidate_details', 'teacher_candidate_map.candidate_id = candidate_details.id');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('courses', 'candidate_courses_map.course_id = courses.id');
                $this->db->join('interview_time_slot', 'teacher_candidate_map.interview_slot_id = interview_time_slot.id');
                $this->db->join('candidate_venue_list', 'teacher_candidate_map.location_id = candidate_venue_list.id');
                
                if(!empty($teacher_id))
                {
                    $this->db->where('teacher_candidate_map.teacher_id', $teacher_id);
                }
                if(!empty($course_id))
                {
                    $this->db->where('candidate_courses_map.course_id', $course_id);
                }
                $this->db->where('candidate_details.interview_schedule_flag', '1');
                $this->db->where('candidate_details.selected_flag', '0');
                $this->db->where('teacher_candidate_map.interview_date >= ', date('Y-m-d'));
                $this->db->order_by('teacher_candidate_map.interview_date asc');
                if(!empty($limit))
                {
                    $this->db->limit($limit);
                }
                $query = $this->db->get();
                //echo $this->db->last_query();die;
                $result_arr = $query->result_array();
                
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
               }
               catch (Exception $e) {
                    //alert the user then kill the process
                    return FALSE;
                }
     
            }
            
            public function addMarksLog1($table_name,$user)
            {
                $user_id = $this->session->userdata('loggedinuserid');
                $param['application_id'] = $user['application_id'];
                $param['candidate_id'] = $user['candidate_id'];
                $param['teacher_id'] = $user_id;
                $param['status_flag'] = $user['interview_status'];
                $param['marks'] = $user['interview_marks'];
               
                $param['created_date'] = date ('Y-m-d H:i:s');
                $param['modified_date'] = date ('Y-m-d H:i:s');

                $this->db->insert($table_name, $param);
                $marks_id = $this->db->insert_id();

                if($marks_id)
                {
                    return $marks_id;
                }
                return FALSE;      

            }
            
            public function candidateUpdate($param,$candidate_id) {
                    $this->db->where('id' , $candidate_id);
                    $this->db->update('candidate_details',$param);   
                return FALSE;
            }
            
            public function get_all_user_before_interview_schedule_display($course_id,$state_name='')
            {
                //pr($course_id);
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag','address.street_address','address.address_line_2','address.city','address.state','address.postal_code');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('address', 'address.candidate_id = candidate_details.id');

                $this->db->where('candidate_courses_map.course_id', $course_id);
                $this->db->where('candidate_details.payment_flag', '1'); 
                $this->db->where('candidate_details.form_flag >', '3'); 
                $this->db->where('candidate_details.scrutiny_flag', '1');
                //$this->db->where('interview_ready_flag', '1');
                $this->db->where('candidate_details.interview_schedule_flag', '0');
                $this->db->group_by('candidate_details.id'); 
                $this->db->order_by('candidate_details.first_name'); 

                if(!empty($state_name))
                {
                    $this->db->where('address.state', $state_name);
                }
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();
               // echo $this->db->last_query();die;
                //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }

            public function get_all_center_before_interview_schedule_display($state_name='')
            {
                //pr($course_id);
                $select_arr = array('candidate_venue_list.id','candidate_venue_list.capacity','candidate_venue_list.filled_up_seat','candidate_venue_list.city','candidate_venue_list.address','candidate_venue_list.interview_date','candidate_venue_list.state');
                $this->db->select($select_arr);
                $this->db->from('candidate_venue_list');
                //$this->db->join('address', 'address.candidate_id = candidate_details.id');
                //$this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                
                //$this->db->where('interview_ready_flag', '1');
                //$this->db->where('candidate_details.interview_schedule_flag', '0');

                if(!empty($state_name))
                {
                    $this->db->where('state', $state_name);
                    //$this->db->where('address.state', $state_name);
                }
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();
                //echo $this->db->last_query();
                //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_alumni_user()
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name',
                    'users.icam_portal_alumni_flag',
                    'candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('users', 'users.id = candidate_details.user_id');
                //$this->db->where('candidate_coursses_map.course_id', $course_id); 
                $this->db->where('users.icam_alumni_flag', '1');

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function addMarksLog_old($table_name,$user)
            {
                $user_id = $this->session->userdata('loggedinuserid');
                $param['application_id'] = $user['application_id'];
                $param['candidate_id'] = $user['candidate_id'];
                $param['teacher_id'] = $user_id;
                $param['status_flag'] = $user['interview_status'];
                $param['marks'] = $user['interview_marks'];
               
                $param['created_date'] = date ('Y-m-d H:i:s');
                $param['modified_date'] = date ('Y-m-d H:i:s');

                $this->db->insert($table_name, $param);
                $marks_id = $this->db->insert_id();

                if($marks_id)
                {
                    return $marks_id;
                }
                return FALSE;      

            }

            public function editMarksLog_old($table_name,$user)
            {
                $user_id = $this->session->userdata('loggedinuserid');
                $param['status_flag'] = $user['interview_status'];
                $param['marks'] = $user['interview_marks'];
                $param['modified_date'] = date ('Y-m-d H:i:s');
               
                $this->db->where('teacher_id', $user_id);
                $this->db->where('application_id', $user['application_id']);
                $this->db->where('candidate_id', $user['candidate_id']);
                $this->db->update($table_name, $param);
                $marks_id = $this->db->affected_rows();

                if($marks_id)
                {
                    return $marks_id;
                }
                return FALSE;      

            }
            
            public function addMarksLog($table_name,$user)
    {
        $user_id = $this->session->userdata('loggedinuserid');
        $param['application_id'] = $user['application_id'];
        $param['candidate_id'] = $user['candidate_id'];
        $param['teacher_id'] = $user_id;
        $param['status_flag'] = $user['interview_status'];
        $param['marks'] = $user['interview_marks'];
        $param['marks_details'] = $user['interview_marks_details'];
        
        $param['created_date'] = date ('Y-m-d H:i:s');
        $param['modified_date'] = date ('Y-m-d H:i:s');

        $this->db->insert($table_name, $param);
        $marks_id = $this->db->insert_id();

        if($marks_id)
        {
            return $marks_id;
        }
        return FALSE;      

    }

    public function editMarksLog($table_name,$user)
    {
        $user_id = $this->session->userdata('loggedinuserid');
        $param['status_flag'] = $user['interview_status'];
        $param['marks'] = $user['interview_marks'];
        $param['marks_details'] = $user['interview_marks_details'];
        $param['modified_date'] = date ('Y-m-d H:i:s');
        
        $this->db->where('teacher_id', $user_id);
        $this->db->where('application_id', $user['application_id']);
        $this->db->where('candidate_id', $user['candidate_id']);
        $this->db->update($table_name, $param);
        $marks_id = $this->db->affected_rows();

        if($marks_id)
        {
            return $marks_id;
        }
        return FALSE;      

    }
    
    public function get_candidate_marks_log($application_id)
    {
      
       $select_arr = array('candidate_marks_log.teacher_id','candidate_marks_log.marks','candidate_marks_log.marks_details','candidate_marks_log.created_date','candidate_marks_log.status_flag','candidate_marks_log.application_id','candidate_marks_log.application_id as user_id','users.first_name','users.middle_name','users.last_name');
       
       
       $this->db->select($select_arr);
       $this->db->from('candidate_marks_log');
       $this->db->join('users', 'candidate_marks_log.teacher_id = users.id');
       //$this->db->join('users', 'candidate_marks_log.teacher_id = users.id');
       
       $this->db->where('candidate_marks_log.application_id', $application_id);

       $query = $this->db->get();
      
       $result_arr = $query->result_array();

       if(!empty($result_arr))
       {
           return $result_arr;
       }
       return FALSE;
    }
           public function get_candidate_marks_log_old($application_id)
           {
              
               $select_arr = array('candidate_marks_log.teacher_id','candidate_marks_log.marks','candidate_marks_log.created_date','candidate_marks_log.status_flag','candidate_marks_log.application_id','candidate_marks_log.application_id as user_id','users.first_name','users.middle_name','users.last_name');
               
               
               $this->db->select($select_arr);
               $this->db->from('candidate_marks_log');
               $this->db->join('users', 'candidate_marks_log.teacher_id = users.id');
               
               $this->db->where('candidate_marks_log.application_id', $application_id);

               $query = $this->db->get();
              
               $result_arr = $query->result_array();

               if(!empty($result_arr))
               {
                   return $result_arr;
               }
               return FALSE;
           }
           
        public function updateProPicture($user)
        {
            $username = $this->session->userdata('loggedinusername');
            //$param['first_name'] = $user['user_first_name'];
            //$param['middle_name'] = $user['user_middle_name'];
            //$param['last_name'] = $user['user_last_name'];
            $param['profile_picture'] = $user['profile_picture'];
            //pr($username);
            $this->db->where('email_id', $username);
            $this->db->update('users', $param);
            $userid = $this->db->affected_rows();
            //pr($userid);

            if($userid)
            {
                    //$candidate_personal_details = $this->session->userdata('candidate_details')
                    
                    $user_data = fetch_single_row('users',array('first_name','middle_name','last_name'),array('username'=>$username));
                    
                    $login_data['first_name'] = $user_data['first_name'];
                    $login_data['middle_name'] = $user_data['middle_name'];
                    $login_data['last_name'] =  $user_data['last_name'];
                    $login_data['profile_picture'] = $user['profile_picture'];
                
                $this->session->set_userdata('candidate_details',$login_data);
                return $userid;
            }
                return FALSE; 
        }
        
            public function checkPassoutdate()
            {
                
               $select_arr = array('candidate_details.passout_date','candidate_details.id as candidate_id','candidate_details.first_name','candidate_details.middle_name',
                    'candidate_details.last_name','candidate_details.profile_picture','candidate_details.date_of_birth',
                    'candidate_details.sex','candidate_details.marrital_status',
                    'candidate_details.contact_number','candidate_details.email_id','candidate_details.form_flag',
                    'candidate_details.interview_ready_flag','candidate_details.interview_schedule_flag','candidate_details.scrutiny_flag',
                    'candidate_details.selected_flag','candidate_details.pan_card_no','candidate_details.adhar_card_no',
                    'candidate_details.voter_card_no','candidate_details.passport_no'
                    ,'candidate_details.professional_qualification','candidate_details.competitive_exams',
                    'candidate_details.competative_exam_score','candidate_details.academic_or_cocurricular_achievements',
                    'candidate_details.professional_experience','candidate_details.professional_achievements','candidate_courses_map.id as application_id','candidate_details.interview_score',
                    'courses.name','courses.program_name','courses.id as course_id');
               $this->db->select($select_arr);
               $this->db->from('courses');
               $this->db->join('candidate_details', 'candidate_details.course_id = courses.id');
               $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
               $this->db->where('candidate_details.user_id', $this->session->userdata('loggedinuserid'));
               //$where = " YEAR(candidate_details.passout_date) +5 >= YEAR(NOW())";
               //$this->db->where($where);

               $query = $this->db->get();
              
               $result_arr = $query->result_array();

               if(!empty($result_arr))
               {
                   return $result_arr;
               }
               return FALSE;
            }
            
            public function get_all_survey_details()
            {
                $select_arr = array('course_survey_map.combination_id',
                    'course_survey_map.survey_id',
                    'course_survey_map.course_id',
                    'course_survey_map.step',
                    'survey_questions.questions',
                    'survey_answers.answers',
                    'survey_answers.weight',
                    'answer_type.type_id',
                    'survey_combination_map.combination_link'
                    );
                $this->db->select($select_arr);
                $this->db->from('course_survey_map');
                $this->db->join('survey_combination', 'survey_combination.combination_id = course_survey_map.combination_id');
                $this->db->join('survey_combination_map', 'survey_combination_map.id = course_survey_map.combination_id');
                $this->db->join('survey_questions', 'survey_questions.id = survey_combination.question_id');
                $this->db->join('survey_answers', 'survey_answers.id = survey_combination.answer_id');
                $this->db->join('answer_type', 'answer_type.type_id = survey_combination.type_id');

                $query = $this->db->get();
              
               $result_arr = $query->result_array();

               if(!empty($result_arr))
               {
                   return $result_arr;
               }
               return FALSE;

            }

            public function display_survey_combination_list($users)
            {
                $select_arr = array('survey_answers.id as answer_id','answer_type.type_name','survey_answers.answers','answer_type.type_id',
                    'survey_answers.weight','survey_questions.questions','survey_questions.id as question_id','survey_combination.combination_id');
                $this->db->select($select_arr);
                $this->db->from('survey_combination');

                $this->db->join('survey_answers', 'survey_answers.id = survey_combination.answer_id');
                $this->db->join('answer_type', 'answer_type.type_id = survey_combination.type_id');
                $this->db->join('survey_questions', 'survey_questions.id = survey_combination.question_id');

                $this->db->where('combination_id', $users); 
                $query = $this->db->get();
                
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }

            public function addUserSurvey($user)
            {
                $param['user_id'] = $user['user_id'];
                $param['application_id'] = $user['application_id'];
                $param['email_id'] = $user['email_id'];
                $param['question_id'] = $user['questions_id'];
                $param['answer_id'] = $user['answers_id'];
                
                $param['created_date'] = date ('c');

                $this->db->insert('user_survey', $param);
                $user_survey_id = $this->db->insert_id();

                if($user_survey_id)
                {
                    return $user_survey_id;
                }
                return FALSE;      

            }
            
            public function get_all_fees_details($course_id)
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_courses_map.course_id', $course_id);
                $this->db->where('payment_flag', '1'); 
                $this->db->where('form_flag >', '3'); 
                $this->db->where('scrutiny_flag <', '2'); 
                $this->db->where('interview_ready_flag', '0');

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
}
       

?>