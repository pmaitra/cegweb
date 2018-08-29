<?php

    class User extends CI_Controller {

        function __construct() 
        {
            parent::__construct();
            uservalidate();
        }

	function index()
	{

	    $response['page_title']="";
            $response['front_menu_details']="myprofile";
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));

            $username = $this->session->userdata('loggedinusername');
            $user_id = fetch_single_value('users', 'id',array('username'=>$username)); 
            
            $candidate_details = fetch_single_row('candidate_details', array('id','first_name','middle_name','last_name','date_of_birth','sex','marrital_status','contact_number','email_id','form_flag'),array('user_id'=>$user_id));
            $response['candidate_details'] = $candidate_details ; 
            
            $candidate_id = $candidate_details['id'];
            $course_details = fetch_single_row('courses', array('name','id'), array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['course_name'] = $course_details['name'];
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));

            //Course Display
            $this->load->model('modeluser');
            $response['course_list'] = $this->modeluser->checkPassoutdate();
            //alumni display 
            $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                    'id'=>$user_id));
            
            $response['course_id'] = $course_details['id'];
            $response['application_id'] = fetch_single_value('candidate_courses_map', 'id',array('candidate_id'=>$candidate_id,'course_id'=>$response['course_id']));
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$candidate_id));
            $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$candidate_id));
            $response['address_list'] = fetch_all_data('address','', array('candidate_id'=>$candidate_id));
            $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','id as payment_id','created_date') ,
                        array('candidate_id'=>$candidate_id,'application_id'=>$response['application_id']));
            $response['user_list'] = fetch_single_row('users','', array('id'=>$user_id));
            $response['venue_details'] = fetch_single_row('candidate_venue_map', '' , array('application_id'=>$response['application_id'],'status'=>1));
            
            renderViews(array('front/template1/header'=>$response,'front/template1/user/changepassword'=>'','front/template1/footer'=>''));

            
	   
           
	}

	public function changePasswordSubmit()
        {	
            $response['page_title']="";             
            $this->load->library('form_validation');             
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

            if ($this->form_validation->run() == FALSE)
            {
                renderViews(array('front/template1/header'=>$response,'front/template1/user/changepassword'=>'','front/template1/footer'=>''));
            }
            else
            {
                $old_password = md5($this->input->post('old_password'));
				//pr($old_password);
                $postdata['new_password'] = md5($this->input->post('new_password'));
				//pr($postdata);
		$confirm_password = md5($this->input->post('confirm_password'));
				//pr($confirm_password);
				
		$this->load->model('modeluser');
		if($this->modeluser->checkOldPass($old_password) == "TRUE")
		{
                    $result = $this->modeluser->passwordChange($postdata);
                    if(!empty($result))
                    {
                        redirect(BASEURL.'dashboard');
                    }
                    else 
                    {
                        $response['error_message'] = 'Please give the valid credential !!';
                        renderViews(array('changePass/index'=>$response));
                    }
                }
                else
                {
                    $response['error_message'] = 'Please give the valid credential !!';
                    return FALSE;
                }
            }

        }
        
        public function updateProfilePicture()
        {
                $this->load->helper('security');

                $postdata['user_first_name'] = $this->input->post('user_first_name');
                $postdata['user_middle_name'] = $this->input->post('user_middle_name');
                $postdata['user_last_name'] = $this->input->post('user_last_name');
                $postdata['profile_picture'] =  $this->input->post('user_profile_picture');
                
               //$username = fetch_all_data('users',array('username'));
                //pr($postdata);

                $this->load->model('modeluser');
                $resposeData = $this->modeluser->updateProPicture($postdata);
                
                    if($resposeData)
                        {
                            $success_msg['responseCode']=200;
                            $success_msg['message']='success';
                            $success_msg['result']=  $resposeData;
                            print_r(json_encode($success_msg));
                            exit();
                        }
                            $error_msg['responseCode']=406;
                            $error_msg['message']=$resposeData['message'];
                            $error_msg['result']='';
                            print_r(json_encode($error_msg));
                            exit();

                
        }
        
         public function submitaddress()
        {
                
                $this->load->helper('security');

                $user['contact_no_1'] = trim($this->input->post('contact_no_1', true));
                $user['street_address_1'] = trim($this->input->post('street_address_1', true));
                $user['address_line2_1'] = trim($this->input->post('address_line2_1', true));
                $user['city_1'] = trim($this->input->post('city_1', true));
                $user['state_1'] = trim($this->input->post('state_1', true));
                $user['postal_code_1'] = trim($this->input->post('postal_code_1', true));
                $user['country_1'] = trim($this->input->post('country_1', true));

                $this->load->model('modeluser');
                $result = $this->modeluser->addAddress($user);
                if($result)
                {
                        $success_msg['responseCode']=200;
                        $success_msg['message']='success';
                        $success_msg['restult']=  $result;
                        print_r(json_encode($success_msg));
                        exit();

                }
                else
                {
                        $error_msg['responseCode']=406;
                        $error_msg['message']='error';
                        $error_msg['restult']='';
                        print_r(json_encode($error_msg));
                        exit();

                }

        }

        public function submitqualificationdetails()
        {
                $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                $this->load->helper('security');

                $user['degree_1'] = trim($this->input->post('degree_1', true));
                $user['specialization_1'] = trim($this->input->post('specialization_1', true));
                $user['name_of_college_1'] = trim($this->input->post('name_of_college_1', true));
                $user['name_of_university_1'] = trim($this->input->post('name_of_university_1', true));
                $user['year_of_passing_1'] = trim($this->input->post('year_of_passing_1', true));
                $user['percentage_1'] = trim($this->input->post('percentage_1', true));
                
                
                $this->load->model('modeluser');
                $result = $this->modeluser->addQualificationDetails($user);
                if($result)
                {
                        $success_msg['responseCode']=200;
                        $success_msg['message']='success';
                        $success_msg['restult']=  $result;
                        print_r(json_encode($success_msg));
                        exit();

                }
                else
                {
                        $error_msg['responseCode']=406;
                        $error_msg['message']='error';
                        $error_msg['restult']='';
                        print_r(json_encode($error_msg));
                        exit();

                }

        }

        public function submitprofessionalexperience()
        {
                
                $this->load->helper('security');

                $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                $user['organization_1'] = trim($this->input->post('organization_1', true));
                $user['designation_1'] = trim($this->input->post('designation_1', true));
                $user['roles_1'] = trim($this->input->post('roles_1', true));
                $user['from_1'] = trim($this->input->post('from_1', true));
                $user['to_1'] = trim($this->input->post('to_1', true));
                

                $this->load->model('modeluser');
                $result = $this->modeluser->addProfessionalExperience($user);
                if($result)
                {
                        $success_msg['responseCode']=200;
                        $success_msg['message']='success';
                        $success_msg['restult']=  $result;
                        print_r(json_encode($success_msg));
                        exit();

                }
                else
                {
                        $error_msg['responseCode']=406;
                        $error_msg['message']='error';
                        $error_msg['restult']='';
                        print_r(json_encode($error_msg));
                        exit();

                }
        }
        
      public function userAccademicQualificationFormSubmit()
      {
            $response['page_title']="";
            
            $user_id = $this->session->userdata('loggedinuserid');
            $candidate_details = fetch_single_row('candidate_details', array('id','first_name','middle_name',
                'last_name','date_of_birth','sex','marrital_status','contact_number','email_id','form_flag',
                'interview_ready_flag','interview_schedule_flag','scrutiny_flag','selected_flag','pan_card_no','adhar_card_no','voter_card_no','passport_no'
                ,'professional_qualification','competitive_exams','competative_exam_score','academic_or_cocurricular_achievements','professional_experience','professional_achievements'),array('user_id'=>$user_id));
            $response['candidate_details'] = $candidate_details ;
            $response['address_list'] = fetch_single_row('address','', array('candidate_id'=>$candidate_details['id']));
            $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$candidate_details['id']));
            $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$candidate_details['id']));
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['default_tab_selection'] = 'accademic_details_tab_display';
            $response['user_registration_flag'] =1;
            $this->load->library('form_validation');
            
            
            $this->form_validation->set_rules('name_of_the_school_ssc', 'Name of the School SSC', 'trim|required');
            
            $this->form_validation->set_rules('name_of_the_board_ssc', 'Name of the Board SSC', 'trim|required');
            $this->form_validation->set_rules('year_of_passing_ssc', 'Year of Passing SSC', 'trim|required');
            $this->form_validation->set_rules('percentage_ssc', 'Percentage SSC', 'trim|required|numeric');


            $this->form_validation->set_rules('group_major_hsc', 'Group / Major HSC', 'trim|required');
            $this->form_validation->set_rules('name_of_the_school_hsc', 'Name of the School HSC', 'trim|required');
            $this->form_validation->set_rules('name_of_the_board_hsc', 'Name of the Board HSC', 'trim|required');
            $this->form_validation->set_rules('year_of_passing_hsc', 'Year of Passing HSC', 'trim|required|numeric');
            $this->form_validation->set_rules('percentage_hsc', 'Percentage HSC', 'trim|required|numeric');


            $this->form_validation->set_rules('degree_diploma_ug', 'Degree / Diploma Graduation', 'trim|required');
            $this->form_validation->set_rules('name_of_the_college_ug', 'Name of the College', 'trim|required');
            $this->form_validation->set_rules('status_of_completion_ug', 'Status of Completion Group', 'trim|required');

            $this->form_validation->set_rules('year_of_passing_ug', 'Year of Passing Graduation', 'trim|numeric');
            $this->form_validation->set_rules('percentage_hsc', 'Percentage Graduation', 'trim|numeric');
            
            if ($this->form_validation->run() == FALSE)
            {
                $response['page_title']="";
                $user_id = $this->session->userdata('loggedinuserid');
                $candidate_details = fetch_single_row('candidate_details', array('id','first_name','middle_name',
                    'last_name','date_of_birth','sex','marrital_status','contact_number','email_id','form_flag',
                    'interview_ready_flag','interview_schedule_flag','scrutiny_flag','selected_flag','pan_card_no','adhar_card_no','voter_card_no','passport_no'
                    ,'professional_qualification','competitive_exams','competative_exam_score','academic_or_cocurricular_achievements','professional_experience','professional_achievements'),array('user_id'=>$user_id));
                $response['candidate_details'] = $candidate_details ;
                $response['address_list'] = fetch_single_row('address','', array('candidate_id'=>$candidate_details['id']));
                $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$candidate_details['id']));
                $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$candidate_details['id']));
            
                $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                $response['default_tab_selection'] = 'accademic_details_tab_display';
                
                
                renderViews(array('front/template1/header'=>$response,'front/template1/registration/user_registration'=>'','front/template1/footer'=>''));
            }
            else
            {
                $postdata['course_name'] = $this->input->post('course_name');
                $postdata['application_id'] = $this->input->post('application_id');

                $postdata['name_of_the_school_ssc'] = $this->input->post('name_of_the_school_ssc');
                $postdata['name_of_the_board_ssc'] = $this->input->post('name_of_the_board_ssc');
                $postdata['year_of_passing_ssc'] = $this->input->post('year_of_passing_ssc');
                $postdata['percentage_ssc'] = $this->input->post('percentage_ssc');

                $postdata['group_major'] = $this->input->post('group_major');
                $postdata['name_of_the_school_hsc'] = $this->input->post('name_of_the_school_hsc');
                $postdata['name_of_the_board_hsc'] = $this->input->post('name_of_the_board_hsc');
                $postdata['year_of_passing_hsc'] = $this->input->post('year_of_passing_hsc');
                $postdata['percentage_hsc'] = $this->input->post('percentage_hsc');

                $postdata['degree_diploma_ug'] = $this->input->post('degree_diploma_ug');
                $postdata['specialization_ug'] = $this->input->post('specialization_ug');
                $postdata['name_of_the_college_ug'] = $this->input->post('name_of_the_college_ug');
                $postdata['name_of_the_university_ug'] = $this->input->post('name_of_the_university_ug');
                $postdata['status_of_completion_ug'] = $this->input->post('status_of_completion_ug');        
                $postdata['year_of_passing_ug'] = $this->input->post('year_of_passing_ug');
                $postdata['percentage_ug'] = $this->input->post('percentage_ug');

                $postdata['degree_diploma_pg'] = $this->input->post('degree_diploma_pg');
                $postdata['specialization_pg'] = $this->input->post('specialization_pg');
                $postdata['name_of_the_college_pg'] = $this->input->post('name_of_the_college_pg');
                $postdata['name_of_the_university_pg'] = $this->input->post('name_of_the_university_pg');
                $postdata['status_of_completion_pg'] = $this->input->post('status_of_completion_pg');        
                $postdata['year_of_passing_pg'] = $this->input->post('year_of_passing_pg');
                $postdata['percentage_pg'] = $this->input->post('percentage_pg');

                // there have no insert command for Professional Qualification & Competitive Exams because these are in checkbox

                $postdata['academic_achievement'] = $this->input->post('academic_achievement');
                $postdata['professional_achievements'] = $this->input->post('professional_achievements');
               //pr($postdata);
                /*$postdata['total_exp_years'] = $this->input->post('total_exp_years');
                $postdata['total_exp_months'] = $this->input->post('months');
                
                $postdata['competitive_exams_check'] = $this->input->post('competitive_exams_check');
                $postdata['professional_qualification_check'] = $this->input->post('professional_qualification_check');
           
                */
                
                $this->load->model('modelregistration');

                $resposeData = $this->modelregistration->candidateAccademicsRegister($postdata);
               // pr($resposeData);
                if($resposeData['responseCode'] == 200)
                {
                    $response['page_title']="";
                    $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                    $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    $response['application_id'] = $resposeData['result'];
                    $response['default_tab_selection'] = 'professional_details_tab_display';
                    $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    renderViews(array('front/template1/header'=>$response,'front/template1/registration/user_registration'=>'','front/template1/footer'=>''));
                }
                else 
                {
                    $this->session->set_flashdata('err_registration',  $resposeData['message']);
                    renderViews(array('front/template1/header'=>$response,'front/template1/registration/user_registration'=>'','front/template1/footer'=>''));
                }

            }
      }
      
      public function userProfessionalQualificationFormSubmit()
      {
            $response['user_registration_flag'] =1;
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');
            $candidate_details = fetch_single_row('candidate_details', array('id','first_name','middle_name',
                'last_name','date_of_birth','sex','marrital_status','contact_number','email_id','form_flag',
                'interview_ready_flag','interview_schedule_flag','scrutiny_flag','selected_flag','pan_card_no','adhar_card_no','voter_card_no','passport_no'
                ,'professional_qualification','competitive_exams','competative_exam_score','academic_or_cocurricular_achievements','professional_experience','professional_achievements'),array('user_id'=>$user_id));
            $response['candidate_details'] = $candidate_details ;
            $response['address_list'] = fetch_single_row('address','', array('candidate_id'=>$candidate_details['id']));
            $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$candidate_details['id']));
            $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$candidate_details['id']));
            
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['default_tab_selection'] = 'professional_details_tab_display';
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            
                $postdata['course_name'] = $this->input->post('course_name');
                $postdata['application_id'] = $this->input->post('application_id');

                $postdata['total_exp_years'] = $this->input->post('total_exp_years');
                $postdata['total_exp_months'] = $this->input->post('months');
                
                $postdata['competitive_exams_check'] = $this->input->post('competitive_exams_check');
                $postdata['professional_qualification_check'] = $this->input->post('professional_qualification_check');
           
                $postdata['organization_1'] = $this->input->post('organization_1'); 
                $postdata['designation_1'] = $this->input->post('designation_1');
                $postdata['roles_1'] = $this->input->post('roles_1');
                $postdata['start_from_1'] = $this->input->post('start_from_1');
                $postdata['start_to_1'] = $this->input->post('start_to_1');

                $postdata['organization_2'] = $this->input->post('organization_2'); 
                $postdata['designation_2'] = $this->input->post('designation_2');
                $postdata['roles_2'] = $this->input->post('roles_2');
                $postdata['start_from_2'] = $this->input->post('start_from_2');
                $postdata['start_to_2'] = $this->input->post('start_to_2');

                $postdata['organization_3'] = $this->input->post('organization_3'); 
                $postdata['designation_3'] = $this->input->post('designation_3');
                $postdata['roles_3'] = $this->input->post('roles_3');
                $postdata['start_from_3'] = $this->input->post('start_from_3');
                $postdata['start_to_3'] = $this->input->post('start_to_3');
                
                //pr($postdata);
                $this->load->model('modelregistration');

                $resposeData = $this->modelregistration->candidateExperienceRegister($postdata);
                
                if($resposeData['responseCode'] == 200)
                {
                    $response['page_title']="";
                    
                    $user_id = $this->session->userdata('loggedinuserid');
                    $candidate_details = fetch_single_row('candidate_details', array('id','first_name','middle_name',
                        'last_name','date_of_birth','sex','marrital_status','contact_number','email_id','form_flag',
                        'interview_ready_flag','interview_schedule_flag','scrutiny_flag','selected_flag','pan_card_no','adhar_card_no','voter_card_no','passport_no'
                        ,'professional_qualification','competitive_exams','competative_exam_score','academic_or_cocurricular_achievements',
                        'professional_experience','professional_achievements'),array('user_id'=>$user_id));
                    $response['candidate_details'] = $candidate_details ;
                    $response['address_list'] = fetch_single_row('address','', array('candidate_id'=>$candidate_details['id']));
                    $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$candidate_details['id']));
                    $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$candidate_details['id']));
                    
                    $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                    $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    $response['application_id'] = $resposeData['result'];
                    $response['default_tab_selection'] = 'preview_details_tab_display';
                    $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    renderViews(array('front/template1/header'=>$response,'front/template1/registration/user_registration'=>'','front/template1/footer'=>''));
                }
                else 
                {
                    $this->session->set_flashdata('err_experience',  $resposeData['message']);
                    renderViews(array('front/template1/header'=>$response,'front/template1/registration/user_registration'=>'','front/template1/footer'=>''));
                }
      } 
      
        public function paymentInvoice()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');
            $candidate_details = fetch_single_row('candidate_details', array('candidate_details.id','candidate_details.first_name','candidate_details.middle_name',
            'candidate_details.last_name','candidate_details.profile_picture','candidate_details.date_of_birth','candidate_details.sex','candidate_details.marrital_status',
            'candidate_details.contact_number','candidate_details.email_id','candidate_details.form_flag',
            'candidate_details.interview_ready_flag','candidate_details.interview_schedule_flag','candidate_details.scrutiny_flag',
            'candidate_details.selected_flag','candidate_details.pan_card_no','candidate_details.adhar_card_no','candidate_details.voter_card_no','candidate_details.passport_no'
            ,'candidate_details.professional_qualification','candidate_details.competitive_exams','candidate_details.competative_exam_score','candidate_details.academic_or_cocurricular_achievements',
            'candidate_details.professional_experience','candidate_details.professional_achievements'),array('user_id'=>$user_id));
            $response['candidate_details'] = $candidate_details ;

            $course_details = fetch_all_data('courses', array('name','id'));
            $this->load->model('modeluser');

            $response['course_list'] = $this->modeluser->get_all_course_for_candidate();
            
            $response['application_id'] = trim($this->uri->segment(2));
            $course_map_details = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
            $course_id = $course_map_details['course_id'];
            $candidate_id = $course_map_details['candidate_id'];
            //pr($course_id);
           // pr($course_map_details);
            $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$course_id));
            $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));
            //$candidate_id = fetch_single_value('candidate_details', 'id', array('user_id'=>$user_id));
            
            //$applicant_id = fetch_single_value('candidate_courses_map', 'id', array('candidate_id'=>$candidate_id));
            $applicant_id = $response['application_id'];
            
            $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
            $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','invoice_id as payment_id','created_date') , array('candidate_id'=>$candidate_id,'application_id'=>$applicant_id));

            if($response['candidate_details']['payment_flag'] == 1 && !empty($response['candidate_payment_details']))
            {
                $response['default_print'] = 1;
                $response['applicant_id'] = $applicant_id;
            }
            
            renderViews(array('front/template1/header'=>$response,'front/template1/user/payment_invoice'=>'','front/template1/footer'=>''));

        }
        
        public function paymentInvoiceWithoutLogin()
        {
            uservalidate();
            $response['page_title']="";
            //$user_id = $this->session->userdata('loggedinuserid');
            $candidate_details = fetch_single_row('candidate_details', array('candidate_details.id','candidate_details.first_name','candidate_details.middle_name',
            'candidate_details.last_name','candidate_details.profile_picture','candidate_details.date_of_birth','candidate_details.sex','candidate_details.marrital_status',
            'candidate_details.contact_number','candidate_details.email_id','candidate_details.form_flag',
            'candidate_details.interview_ready_flag','candidate_details.interview_schedule_flag','candidate_details.scrutiny_flag',
            'candidate_details.selected_flag','candidate_details.pan_card_no','candidate_details.adhar_card_no','candidate_details.voter_card_no','candidate_details.passport_no'
            ,'candidate_details.professional_qualification','candidate_details.competitive_exams','candidate_details.competative_exam_score','candidate_details.academic_or_cocurricular_achievements',
            'candidate_details.professional_experience','candidate_details.professional_achievements'),array('user_id'=>$user_id));
            $response['candidate_details'] = $candidate_details ;

            $course_details = fetch_all_data('courses', array('name','id'));
            $this->load->model('modeluser');

            $response['course_list'] = $this->modeluser->get_all_course_for_candidate();
            
            $response['application_id'] = trim($this->uri->segment(2));
            $course_map_details = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
            $course_id = $course_map_details['course_id'];
            $candidate_id = $course_map_details['candidate_id'];
            //pr($course_id);
           // pr($course_map_details);
            $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$course_id));
            $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));
            //$candidate_id = fetch_single_value('candidate_details', 'id', array('user_id'=>$user_id));
            
            //$applicant_id = fetch_single_value('candidate_courses_map', 'id', array('candidate_id'=>$candidate_id));
            $applicant_id = $response['application_id'];
            
            $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
            $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','invoice_id as payment_id','created_date') , array('candidate_id'=>$candidate_id,'application_id'=>$applicant_id));

            if($response['candidate_details']['payment_flag'] == 1 && !empty($response['candidate_payment_details']))
            {
                $response['default_print'] = 1;
                $response['applicant_id'] = $applicant_id;
            }
            
            renderViews(array('front/template1/header'=>$response,'front/template1/user/payment_invoice'=>'','front/template1/footer'=>''));

        }
        
        
        public function registrationInvoice()
        {
            //pr('hi');
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');
            $candidate_details = fetch_single_row('candidate_details', array('candidate_details.id','candidate_details.first_name','candidate_details.middle_name',
            'candidate_details.last_name','candidate_details.profile_picture','candidate_details.date_of_birth','candidate_details.sex','candidate_details.marrital_status',
            'candidate_details.contact_number','candidate_details.email_id','candidate_details.form_flag',
            'candidate_details.interview_ready_flag','candidate_details.interview_schedule_flag','candidate_details.scrutiny_flag',
            'candidate_details.selected_flag','candidate_details.pan_card_no','candidate_details.adhar_card_no','candidate_details.voter_card_no','candidate_details.passport_no'
            ,'candidate_details.professional_qualification','candidate_details.competitive_exams','candidate_details.competative_exam_score','candidate_details.academic_or_cocurricular_achievements',
            'candidate_details.professional_experience','candidate_details.professional_achievements'),array('user_id'=>$user_id));
            $response['candidate_details'] = $candidate_details ;

            $course_details = fetch_all_data('courses', array('name','id'));
            $this->load->model('modeluser');

            $response['course_list'] = $this->modeluser->get_all_course_for_candidate();
            
            $response['application_id'] = trim($this->uri->segment(2));
            $course_map_details = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
            $course_id = $course_map_details['course_id'];
            $candidate_id = $course_map_details['candidate_id'];
            //pr($course_id);
           // pr($course_map_details);
            $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$course_id));
            $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));
            //$candidate_id = fetch_single_value('candidate_details', 'id', array('user_id'=>$user_id));
            
            //$applicant_id = fetch_single_value('candidate_courses_map', 'id', array('candidate_id'=>$candidate_id));
            $applicant_id = $response['application_id'];
            
            $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
            $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','invoice_id as payment_id','created_date') , array('candidate_id'=>$candidate_id,'application_id'=>$applicant_id));

            if($response['candidate_details']['payment_flag'] == 1 && !empty($response['candidate_payment_details']))
            {
                $response['default_print'] = 1;
                $response['applicant_id'] = $applicant_id;
            }
            
            renderViews(array('front/template1/header'=>$response,'front/template1/user/payment_invoice'=>'','front/template1/footer'=>''));

        }
        
        public function userStatus()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');

            $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 
                'interview_ready_flag','interview_schedule_flag','scrutiny_flag','selected_flag','payment_flag') ,
                    array('user_id'=>$user_id));
           

            //$candidate_id = fetch_single_value('candidate_details', 'id', array('user_id'=>$user_id));
            $candidate_id = $response['candidate_details']['id'];
            $applicant_id = fetch_single_value('candidate_courses_map', 'id', array('candidate_id'=>$candidate_id));

            $response['venue_details'] = fetch_single_row('candidate_venue_map', '' , array('application_id'=>$applicant_id,'status'=>1));

            if($response['candidate_details']['interview_ready_flag'] == 1)
            {
                $response['applicant_id'] = $applicant_id;
                renderViews(array('front/template1/header'=>$response,'front/template1/user/user_status'=>'','front/template1/footer'=>''));
            }
            else
            {
                renderViews(array('front/template1/header'=>$response,'front/template1/user/user_status'=>'','front/template1/footer'=>''));
            }

        }
        
      public function userApplicationFormPdf()
      {
            uservalidate();
            $this->load->library('pdf');
            $user_id = $this->session->userdata('loggedinuserid');

            $response['application_id'] = $response['applicant_id'] = trim($this->uri->segment(2));
            $course_map_details = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
            $course_id = $course_map_details['course_id'];
            $response['candidate_id'] = $course_map_details['candidate_id'];
            
            $response['candidate_details'] = fetch_single_row('candidate_details', '',array('id'=>$response['candidate_id']));
            $response['address_list'] = fetch_all_data('address','', array('candidate_id'=>$response['candidate_id']));
            $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$response['candidate_id']));
            $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$response['candidate_id']));
            
            $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','id as payment_id','created_date') ,
                        array('candidate_id'=>$response['candidate_id'],'application_id'=>$response['applicant_id']));
            //pr( $response);
            $this->pdf->load_view('front/template1/user/user_application_form',$response);
            $this->pdf->render();
            $this->pdf->stream("PGPSM_Application.pdf");
      }
      
        public function submitcoupon()
        {
                $this->load->helper('security');

                $user['coupon_code'] = trim($this->input->post('coupon_code', true));
                $user['registration_amount'] = trim($this->input->post('registration_amount', true));
                
                $coupon_details = fetch_single_row('course_coupons','',array('coupon_code'=>$user['coupon_code']));
                $coupon_code = $coupon_details['coupon_code'];

                $result['discount_percentage'] = $coupon_details['discount_amount'];  
                              
                $result['discount_amount'] = ($user['registration_amount'] * $coupon_details['discount_amount'])/100;
                $result['grand_total'] = ($user['registration_amount'] - $result['discount_amount']);

                $result['coupon_code'] = $coupon_code ;

                if(!empty($coupon_code))
                {
                        $success_msg['responseCode']=200;
                        $success_msg['message']='success';
                        $success_msg['result']=  $result;
                        print_r(json_encode($success_msg));
                        exit();

                }
                else
                {
                        $error_msg['responseCode']=406;
                        $error_msg['message']='error';
                        $error_msg['result']='';
                        print_r(json_encode($error_msg));
                        exit();

                }

        }
        
        public function admissionPaymentIndex1()
        {
            $response['page_title'] = '';
            $data['application_id']=$this->uri->segment(2);
            $data['payment_ammount']=$this->uri->segment(3);
            
            if(!empty($data['application_id']))
            {
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$data['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                
                single_column_update('candidate_details', array('admission_flag'=>1), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('admission_payment_flag'=>1), array('id'=>$candidate_id));
                $response['page_title']="";
                $this->output->set_header('refresh:10; url='.BASEURL.'admissioninvoice/'.trim($data['application_id']).'/'.trim($data['payment_ammount']));
                renderViews(array('home/user_registration_success'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
        }
        
        public function feePaymentIndex()
        {
            try{
                
           
            $response['page_title'] = '';
            $data['payment_details']=$this->uri->segment(2);
            $rejex = '/\d+_\d+_\d+/';
            if(!empty($data['payment_details']))
            {
                preg_match_all($rejex, $data['payment_details'], $matches, PREG_SET_ORDER, 0);
                if(!empty($matches))
                {
                    $payment_arr = explode('_', $data['payment_details']);
                    $data['application_id'] = $payment_arr[0];
                    $data['term_id'] = $payment_arr[1];
                    $data['payment_ammount'] = $payment_arr[2];
                }
               
            }
            //pr($data);
            
            if(!empty($data['application_id']) && !empty($data['term_id']) && !empty($data['payment_ammount']))
            {
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$data['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                
                single_column_update('candidate_details', array('admission_flag'=>1), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('admission_payment_flag'=>1), array('id'=>$candidate_id));
                $response['page_title']="";
                $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));

                $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id));
                $response['application_id'] = $data['application_id'];
                $response['amount'] = $data['payment_ammount'];

                if(ENVIRONMENT == 'production')
                {
                    $response['return_url'] = BASEURL.'admissioninvoice/'.trim($data['application_id']).'/'.trim($data['payment_ammount']);
                    $this->load->library('ccavenue/ccavenue');

                    $this->ccavenue->semesterPaymentSubmission($response);
                }
                else 
                {
                    renderViews(array('home/user_registration_success'=>$response));
                    $this->output->set_header('refresh:5; url='.BASEURL.'feepaymentinvoice/'.trim($data['application_id']).'_'.trim($data['term_id']).'_'.trim($data['payment_ammount']));
                    
                }

                
                renderViews(array('home/user_registration_success'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
            //redirect(BASEURL.'dashboard');
             } catch (Exception $ex) {
                 redirect(BASEURL.'dashboard');
            }
        }
        
        public function feePaymentInvoice()
        {
            try
            {
            $response['page_title']="";
            $data['payment_details']=$this->uri->segment(2);
            $rejex = '/\d+_\d+/';
            if(!empty($data['payment_details']))
            {
                preg_match_all($rejex, $data['payment_details'], $matches, PREG_SET_ORDER, 0);
                if(!empty($matches))
                {
                    $payment_arr = explode('_', $data['payment_details']);
                    $response['application_id'] = $payment_arr[0];
                    $response['term_id'] = $payment_arr[1];
                    $response['payment_ammount'] = $payment_arr[2];
                }
               
            }
            
            if(!empty($response['application_id']) && !empty($response['term_id']) && !empty($response['payment_ammount']))
            {
                //echo $response['application_id'];die;
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
                //pr($candidate_arr);
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                //pr($response['course_details_display']);
                $payment_id = '';//fetch_single_value('candidate_payment', 'id', array('application_id'=>$response['application_id'],'term_id'=>$response['term_id']));
                //pr($payment_id);
                if(empty($payment_id))
                {
                    $payment_structure_data = fetch_all_data('courses_fee_structure', array('term_name','fee_type','general_fee'),
                            array('course_id' => $candidate_arr['course_id'],'term_id'=>$response['term_id']));
                    $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));
                    
                    if(!empty($payment_structure_data))
                    {
                        $invoice_id = $response['application_id'].'_'.$response['term_id'].'_'.strtotime(date('c'));
                        if($response['term_id'] == 1 && empty($response['candidate_details']['registration_id']))
                        {
                            $registraion_id = $response['course_details_display']['program_code'].'_'.date('Y').'_'.$response['application_id'].strtotime(date('c'));
                            single_column_update('candidate_details', array('registration_id'=>$registraion_id), array('id'=>$candidate_id));
                        }
                        for($i=0;$i<count($payment_structure_data);$i++)
                        {
                            $this->load->model('modeluser');
                    
                            //Payment Entry
                            $payment_data['application_id'] = $response['application_id'];
                            $payment_data['candidate_id'] = $candidate_id;
                            $payment_data['amount'] = $payment_structure_data[$i]['general_fee'];
                            $payment_data['payment_fee_type']   = $payment_structure_data[$i]['fee_type'];
                            $payment_data['term_id'] = $response['term_id'];
                            $payment_data['invoice_id'] = $invoice_id;
                            
                            $payment_data['status'] = 1;
                            
                            $payment_id = $this->modeluser->addPayment($payment_data);
                        }
                    }
                    //pr($payment_id);
                    $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
                  
                    
                
                }
                else
                {
                    renderViews(array('home/course_not_found'=>$response));
                }
                $response['candidate_payment_details'] = fetch_all_data('candidate_payment' , array('amount','id as payment_id','created_date') , array('invoice_id'=>$invoice_id
                            ));
               // pr($response['candidate_payment_details']);
                $user_id = $this->session->userdata('loggedinuserid');
                //renderViews(array('home/course_not_found'=>$response));
                 //renderViews(array('front/template1/header'=>$response,'front/template1/user/admission_print_invoice'=>'','front/template1/footer'=>''));
                if(!empty($user_id))
                {
                    redirect(BASEURL.'invoicedisplay/'.$invoice_id);
                }
                else 
                {
                    renderViews(array('home/course_not_found'=>$response));
                }
            
                
            }
            else
            {
                redirect(BASEURL.'dashboard');
            }
            
            } catch (Exception $ex) {
                 redirect(BASEURL.'dashboard');
            }

        }
        
        
        public function userInvoiceDisplay()
        {
            
            $response['page_title']="";
            $response['invoice_id']=$this->uri->segment(2);
            //pr( $response['payment_id']);
            
            if(!empty($response['invoice_id']))
            {
                $response['candidate_payment_details'] = fetch_all_data('candidate_payment', '', array('invoice_id'=>$response['invoice_id']));
            }//pr($payment_details);
            //$response['payment_ammount']=$this->uri->segment(3);
           
            
            if(!empty($response['candidate_payment_details']))
            {
                 $response['application_id'] = $response['candidate_payment_details'][0]['application_id'];
                //echo $response['application_id'];die;
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
                //pr($candidate_arr);
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                //pr($response['course_details_display']);
                
                $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));

                $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');

                renderViews(array('front/template1/header'=>$response,'front/template1/user/fee_payment_invoice'=>'','front/template1/footer'=>'')); 
            }
            else
            {
                PR("Please Try Again");
            }

        }
        
        public function useradmission()
        {
            alumnivalidate();
            //log_message('info', 'Admission page opened.');
            // loginredirection();
            $this->load->library('form_validation');
            $response['page_title']="";
            
            $response['course_link'] = trim($this->uri->segment(2));
            $response['course_details_display'] = fetch_single_row('courses', '', array('course_link'=>$response['course_link']));
            //pr($response['course_details_display']);
            if(!empty($response['course_details_display']))
            {
                $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                $response['course_name'] = $response['course_details_display']['program_name'];
                $response['venue_list'] = fetch_all_data('candidate_venue_list','',array('drive_id'=> $response['course_details_display']['id']));
                
                $survey_arr = array('1'=>'','2'=>'','3'=>'',
                    '4'=>'','5'=>'','6'=>'',);
                
                //pr($survey_arr);
                // 22.06.2017
                $this->load->model('modeluser');
                $course_servey_combination_list = $this->modeluser->get_all_survey_details();
                //$course_servey_combination_list = get_all_survey_details();
                //Survey Display arr
                if(!empty($course_servey_combination_list))
                {
                    for($i=0 ; $i < count($course_servey_combination_list) ; $i++)
                    {
                        $survey_arr[$course_servey_combination_list[$i]['step']][] = $course_servey_combination_list[$i];
                    }
                }
                 $response['survey_display_arr'] =$survey_arr;
                 //for($i=0 ; $i < count($response['survey_display_arr']) 

                 //pr($response['survey_display_arr'][1][2]['combination_id']);

                    //$this->load->model('modeluser');
                    //$response['survey_combination_list'] = $this->modeluser->display_survey_combination_list($combination_id);

                renderViews(array('home/user_registration'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
        }

    public function offlinePaymentInvoice()
    {
        uservalidate();
        $data['payment_details']=$this->uri->segment(2);
        $rejex = '/\d+_\d+/';
        if(!empty($data['payment_details']))
        {
            preg_match_all($rejex, $data['payment_details'], $matches, PREG_SET_ORDER, 0);
            if(!empty($matches))
            {
                $payment_arr = explode('_', $data['payment_details']);
                $response['application_id'] = $payment_arr[0];
                $response['payment_ammount'] = $payment_arr[1];
            }
           
        }
        $response['page_title'] ='';
            if(!empty($response['application_id']) && !empty($response['payment_ammount']))
            {
                $course_details = fetch_all_data('courses', array('name','id'));
                
                $this->load->model('modeluser');
                $response['course_list'] = $this->modeluser->get_all_course_for_candidate();
                //$response['course_list'] = fetch_all_data('courses', array('id','program_id','program_name','course_link','name')); 
                $response['application_id'] =$response['application_id'];
                $response['amount'] = $response['payment_ammount'];
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                
                 $response['candidate_details'] = fetch_single_row('candidate_details', '', array('id'=>$candidate_arr['candidate_id']));
                 $response['candidate_address'] = fetch_single_row('address', '', array('candidate_id'=>$candidate_arr['candidate_id']));
                 //pr($response);
                renderViews(array('front/template1/header'=>$response,'front/template1/user/offline_payment_invoice'=>'','front/template1/footer'=>''));
                //renderViews(array('front/user/offline_payment_invoice'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
    }
    
        public function bookingFeePaymentIndex()
        {
            try{
                
           
            $response['page_title'] = '';
            $data['payment_details']=$this->uri->segment(2);
            $rejex = '/\d+_\d+/';
            if(!empty($data['payment_details']))
            {
                preg_match_all($rejex, $data['payment_details'], $matches, PREG_SET_ORDER, 0);
                if(!empty($matches))
                {
                    $payment_arr = explode('_', $data['payment_details']);
                    $data['application_id'] = $payment_arr[0];
                    $data['booking_amount'] = $payment_arr[1];
                }
               
            }
            //pr($data);
            
            if(!empty($data['application_id']) && !empty($data['booking_amount']))
            {
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$data['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                
                
                $response['page_title']="";
                $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));

                $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id));
                $response['application_id'] = $data['application_id'];
                $response['amount'] = $data['booking_amount'];

                if(ENVIRONMENT == 'production')
                {
                    $response['return_url'] = BASEURL.'bookingfeepaymentinvoice/'.trim($data['application_id']).'_'.trim($data['booking_amount']);
                    $this->load->library('ccavenue/ccavenue');

                    $this->ccavenue->semesterPaymentSubmission($response);
                }
                else 
                {
                    renderViews(array('home/user_registration_success'=>$response));
                    $this->output->set_header('refresh:5; url='.BASEURL.'bookingfeepaysucessinvoice/'.trim($data['application_id']).'_'.trim($data['booking_amount']));
                    
                }

                
                renderViews(array('home/user_registration_success'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
            //redirect(BASEURL.'dashboard');
             } catch (Exception $ex) {
                 redirect(BASEURL.'dashboard');
            }
        }
        
         public function bookingFeePaymentInvoice()
        {
            uservalidate();
            $data['payment_details']=$this->uri->segment(2);
            $rejex = '/\d+_\d+/';
            if(!empty($data['payment_details']))
            {
                preg_match_all($rejex, $data['payment_details'], $matches, PREG_SET_ORDER, 0);
                if(!empty($matches))
                {
                    $payment_arr = explode('_', $data['payment_details']);
                    $response['application_id'] = $payment_arr[0];
                    $response['booking_amount'] = $payment_arr[1];
                }
               
            }
            $response['page_title'] ='';
            if(!empty($response['application_id']) && !empty($response['booking_amount']))
            {
                $course_details = fetch_all_data('courses', array('name','id'));
                
                $this->load->model('modeluser');
                $response['course_list'] = $this->modeluser->get_all_course_for_candidate();
                //$response['course_list'] = fetch_all_data('courses', array('id','program_id','program_name','course_link','name')); 
                $response['application_id'] =$response['application_id'];
                $response['amount'] = $response['booking_amount'];
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                $response['candidate_details'] = fetch_single_row('candidate_details', '', array('id'=>$candidate_arr['candidate_id']));
                $response['candidate_address'] = fetch_single_row('address', '', array('candidate_id'=>$candidate_arr['candidate_id']));
                
                $payment_id = fetch_single_value('candidate_payment', 'id', array('application_id'=>$response['application_id'],
                    'term_id'=>0,'payment_fee_type' => 'Booking Fee'));
                //pr($payment_id);
                if(empty($payment_id))
                {                    
                        $response['invoice_id']  = $response['application_id'].'_00_'.strtotime(date('c'));
                        
                        
                            $this->load->model('modeluser');
                    
                            //Payment Entry
                            $payment_data['application_id'] = $response['application_id'];
                            $payment_data['candidate_id'] = $candidate_id;
                            $payment_data['amount'] = $response['booking_amount'];
                            $payment_data['payment_fee_type']   = 'Booking Fee';
                            $payment_data['payment_method']   = '1';
                            $payment_data['term_id'] = 0;
                            $payment_data['invoice_id'] = $response['invoice_id'];
                            
                            $payment_data['status'] = 1;
                            
                            $payment_id = $this->modeluser->addPayment($payment_data);
                        
                }
                 single_column_update('candidate_details', array('admission_first_fee_flag'=>1), array('id'=>$candidate_id));
                 //pr($response['invoice_id'] );  
                 $response['candidate_payment_details'][0] = fetch_single_row('candidate_payment','',array('id'=>$payment_id));
                 $response['invoice_id'] = $response['candidate_payment_details'][0]['invoice_id'];
                 //pr($response['candidate_payment_details']);
                renderViews(array('front/template1/header'=>$response,'front/template1/user/booking_payment_invoice'=>'','front/template1/footer'=>''));
                //renderViews(array('front/user/offline_payment_invoice'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
        }
}