<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

      public function index()
      {
          redirect(BASEURL.'login');    
      }
        
      public function passwordreset()
      {
          $response['page_title'] = "";
          $response['menu_restriction'] = 1;

          renderViews(array('front/template1/header' => $response, 'front/template1/student/password_reset' => '', 'front/template1/footer' => ''));
      }
      
      public function reset()
      {
          
            //loginredirection();
          //echo "hi";die;
            $response['page_title']="";
            $this->load->library('form_validation');
            $this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required');
            $this->form_validation->set_rules('newpassword', 'Password', 'trim|required|required');
            $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|required|matches[newpassword]');

            if(ENVIRONMENT != 'dev2')
            {
                //$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
                //$this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');
            }
            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('error_message', 'Please enter all the fields.');
                renderViews(array('front/template1/header' => $response, 'front/template1/student/password_reset' => '', 'front/template1/footer' => ''));
            }
            else
            {
                
                $this->load->helper('web_service');
                $send_data['userName'] = $this->session->userdata('rollNumber');
                $send_data['oldPassword'] = trim($this->input->post('oldpassword'));
                $send_data['newPassword'] = trim($this->input->post('newpassword'));
                $send_data['organization'] ='ss-purulia';
                $send_data['serviceUserName'] = 'test';
                $send_data['servicePassword'] = 'test';
                //pr($send_data);
                //Todo LDAP cALL
                
                $responseJson = callApi('POST', CHANGE_PASSWORD_LDAP_LINK, $send_data);
                $response ='';
                //pr($responseJson);
                if(!empty($responseJson))
                {
                    $response = json_decode($responseJson,TRUE);
                }
                if(ENVIRONMENT == 'dev23')
                {
                    
                }
                if(!empty($response) && $response['message'] == 'success')
                {
                    $result_data['passwordReset'] = 1; 
                    $this->db->where('username' , $this->session->userdata('rollNumber'));
                    $this->db->update('users', $result_data); 
                    $this->session->set_userdata('passwordResetFlag', 1);
                    redirect(BASEURL.'dashboard'); 
                }
                else
                    { 
                    $this->session->set_flashdata('error_message', 'The operation is not successfull');
                    renderViews(array('front/template1/header' => $response, 'front/template1/student/password_reset' => '', 'front/template1/footer' => ''));
                    }
                        
                  
            }
      }
      
      public function cer()
      {    
          
          ini_set ( 'max_execution_time', 1200); 
          $response['title'] = '';
            //uservalidate();
            $this->load->library('pdf');
           //pr( $response);
            $this->pdf->load_view('front/template1/user/user_certificate',$response);
            $this->pdf->render();
            $this->pdf->get_canvas()->get_cpdf()->setEncryption("pass", "pass");
            $output =  $this->pdf->output();
            file_put_contents(ROOTURL.'/uploads/certificates/Brochsure.pdf', $output);
            //$this->pdf->stream("PGPSM_Applicxxadtion.pdf");
      }
      
      public function checkPayment()
      {
          //pr('hi');
        $response['page_title']="";
        $this->load->library('ccavenue/ccavenue');
        $this->ccavenue->submission(); 
          //renderViews(array('ccavenue/index'=>$response));
      }
      
      public function paysuccess()
      {
          //pr('hi');
        $response['page_title']="";
        $this->load->library('ccavenue/ccavenue');
        $this->ccavenue->payment_response(); 
          //renderViews(array('ccavenue/index'=>$response));
      }
      
      public function paycancel()
      {
                    //pr('hi');
        $response['page_title']="";
        $this->load->library('ccavenue/ccavenue');
        $this->ccavenue->payment_response(); 
          //renderViews(array('ccavenue/index'=>$response));
      }
    
        public function admission()
        {
            log_message('info', 'Admission page opened.');
            loginredirection();
            $this->load->library('form_validation');
            $response['page_title']="";
            if(LOCALLANGUAGEFLAG == 1)
            {
                $this->lang->load('form_registration_lang','bengali');
                $response['registration_local_language_list'] = $this->lang->line('registration_form');
            }
//pr($registration_local_language_list['first_name']);
          
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
                $course_servey_combination_list = $this->modeluser->get_all_survey_details($response['course_details_display']['id']);
                //$course_servey_combination_list = get_all_survey_details();
                
                //Survey Display arr
                if(!empty($course_servey_combination_list))
                {
                    //pr($course_servey_combination_list);
                    for($i=0 ; $i < count($course_servey_combination_list) ; $i++)
                    {
                        $survey_arr[$course_servey_combination_list[$i]['step']] = $course_servey_combination_list[$i];
                    }
                }
                //pr($survey_arr);
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
        /* 
         * Used for display survey on admission form
         */
        public function userSurvey()
        {
            $combination_id = trim($this->input->post('combination_id', true));
            //$combination_id = 5;
            $resposeData ='';
            $this->load->model('modeluser');
            $survey_details = $this->modeluser->display_survey_combination_list($combination_id);
            for($i=0;$i<count($survey_details);$i++)
            {
                if(empty($survey_rebuild_list[$survey_details[$i]['question_id']]['question_id']))
                {
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['combination_id'] = $survey_details[$i]['combination_id'];
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['question_id'] = $survey_details[$i]['question_id'];
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['question'] = $survey_details[$i]['questions'];
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['type_id'] = $survey_details[$i]['type_id'];
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['type_name'] = $survey_details[$i]['type_name'];
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['answers'][]=
                    array('id' =>$survey_details[$i]['answer_id'],'answer'=>$survey_details[$i]['answers']);
                    
                }
                else
                {
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['answers'][]=
                    array('id' =>$survey_details[$i]['answer_id'],'answer'=>$survey_details[$i]['answers']);
                    /*$survey_rebuild_list[$survey_details[$i]['question_id']]['answers'][$i]['id'] = $survey_details[$i]['answer_id'];
                    $survey_rebuild_list[$survey_details[$i]['question_id']]['answers'][$i]['name'] = $survey_details[$i]['answers'];

                    $survey_rebuild_list[$survey_details[$i]['question_id']]['answers'] =
                    array_values($survey_rebuild_list[$survey_details[$i]['question_id']]['answers']);
                    */
                }
            }
            if(!empty($survey_rebuild_list))
            {
                $survey_rebuild_list = array_values( $survey_rebuild_list);
            }
            $resposeData = $survey_rebuild_list;
            //pr($resposeData);
            if(!empty($resposeData))
                {
                    $success_msg['responseCode']=200;
                    $success_msg['message']='success';
                    $success_msg['result']=  $resposeData;
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

        public function admission3()
        {
            $this->load->helper('security');

            //$new_survey_questions = trim($this->input->post('survey_questions', true));
            //$survey_questions = fetch_single_value('survey_questions','questions',array('questions'=>$new_survey_questions));
            //if (empty($survey_questions))
            //{

                $postdate['combination_id'] = trim($this->input->post('combination_id', true));
                $postdate['application_id'] = trim($this->input->post('application_id', true));
                $postdate['email_id'] = trim($this->input->post('email_id', true));
                $postdate['questions_answer_id'] = trim($this->input->post('questions_answer_id', true));

                //pr($survey_questions);
                $this->load->model('modeluser');
                $resposeData = $this->modeluser->addUserSurvey($postdate);
                //pr($resposeData);
                if(!empty($resposeData))
                {
                    $this->session->set_flashdata('success_message',  'Question has added successfully !!');
                    $success_msg['responseCode']=200;
                    $success_msg['message']='success';
                    $success_msg['result']=  $resposeData;
                    print_r(json_encode($success_msg));
                    exit();
                }
                else
                {
                    $this->session->set_flashdata('error_msg',  'Please try again !!');
                    $error_msg['responseCode']=406;
                    $error_msg['message']='error';
                    $error_msg['result']='';
                    print_r(json_encode($error_msg));
                    exit();
                }
            //}
            //else
            //{
                //$this->session->set_flashdata('err_msg',  'Please enter another survey Question !!');
                   // $error_msg['responseCode']=400;
                   // $error_msg['message']='error';
                  //  $error_msg['result']='';
                   // print_r(json_encode($error_msg));
                   // exit();
           // }
        } 
        
        
      public function admission_working()
      {
            log_message('info', 'Admission page opened.');
            loginredirection();
            $this->load->library('form_validation');
            $response['page_title']="";
            
            $response['course_link'] = trim($this->uri->segment(2));
            $response['course_details_display'] = fetch_single_row('courses', '', array('course_link'=>$response['course_link']));
//            $response['course_details_display'] = fetch_single_row('courses', '', 
//                    array('course_link'=>$response['course_link'],
//                        'form_issuance_date <= ' =>'CURDATE()',' form_submission_last_date >= '=> 'CURDATE()'));
            
            if(!empty($response['course_details_display']))
            {
                $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                       
                $response['course_name'] = $response['course_details_display']['program_name'];
                renderViews(array('home/user_registration'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
      }
        
      public function checkmail()
      {
         // pr('hi');
           $user_name_display = 'Sayak';
                    $couruse_name = 'PGPSM';
                    $message = 'Your payment has been received for '.ucfirst($course_name).'.
                                        You can <a href="'.BASEURL.'login">login</a> and view your application status.
                                Please enter your email as username and  Password: "password".';
                    $html_message = general_email_template($user_name_display,$message,'Thank You !');
                    $subject = 'Payment has been recieved succesfully';
                                
                    send_customer_mail('iCAM Admission','sayak2011@gmail.com',$subject,$message,$html_message);
          //send_customer_mail('iCAM Admission','sayak.mukherjee@qtsin.net',$subject,$message,$html_msg);

      }
      /*public function registrationSubmit()
      {
            loginredirection();
            $response['page_title']="";
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['default_tab_selection'] = 'personal_details_tab_display';
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required|alpha');
            $this->form_validation->set_rules('middle_name', 'Middle name', 'trim|alpha');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|alpha');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('street_address', 'Street Address', 'trim|required');
            $this->form_validation->set_rules('address_line_2', 'Address Line 2', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('date_of_birth', 'Date of Birth', "trim|required|callback_date_format_check");
            $this->form_validation->set_rules('pan_card_no', 'Pan Card No', 'trim');
            $this->form_validation->set_rules('adhar_card_no', 'Adhar Card No', 'trim');
            $this->form_validation->set_rules('voter_card_no', 'Voter Card No', 'trim');
            $this->form_validation->set_rules('passport_no', 'Passport No', 'trim');
            

            if ($this->form_validation->run() == FALSE)
            {
                
                renderViews(array('home/user_registration'=>$response));
            }
            else
            {
                $postdata['course_name'] = $this->input->post('course_name');
                $postdata['first_name'] = $this->input->post('first_name');
                $postdata['middle_name'] = $this->input->post('middle_name');
                $postdata['last_name'] = $this->input->post('last_name');
                $postdata['date_of_birth'] = $this->input->post('date_of_birth');
                $postdata['sex_is'] = $this->input->post('sex_is');
                $postdata['marital_status_is'] = $this->input->post('marital_status_is');
                $postdata['contact_no'] = $this->input->post('contact_no');
                $postdata['email'] = $this->input->post('email');
                $postdata['street_address'] = $this->input->post('street_address');
                $postdata['address_line_2'] = $this->input->post('address_line_2');
                $postdata['city'] = $this->input->post('city');
                $postdata['state'] = $this->input->post('state');
                $postdata['zip_code'] = $this->input->post('zip_code');
                $postdata['country'] = $this->input->post('country');
                $postdata['pan_card_no'] = $this->input->post('pan_card_no');
                $postdata['adhar_card_no'] = $this->input->post('adhar_card_no');
                $postdata['voter_card_no'] = $this->input->post('voter_card_no');
                $postdata['passport_no'] = $this->input->post('passport_no');
               
                $image_upload_result =  $this->upload_image('profile_picture',200);
                if(!empty($image_upload_result) && $image_upload_result['responseCode'] == 400)
                {
                    $postdata['profile_picture'] =  $image_upload_result['result']['file_name'] ;

                }
                else
                {
                    $this->setFlashData('err_profile_picture',  $image_upload_result['result']);
                }

                $pan_no_upload_result =  $this->upload_image('pan_card',2048);
                if(!empty($pan_no_upload_result) && $pan_no_upload_result['responseCode'] == 400)
                {
                    $postdata['pan_card'] =  $pan_no_upload_result['result']['file_name'] ;
                }
                else
                {
                    $this->setFlashData('err_pan_card',  $pan_no_upload_result['result']);
                }

                $adhar_no_upload_result =  $this->upload_image('adhar_card',2048);
                if(!empty($adhar_no_upload_result) && $adhar_no_upload_result['responseCode'] == 400)
                {
                    $postdata['adhar_card'] =  $adhar_no_upload_result['result']['file_name'] ;
                }
                else
                {
                   $this->setFlashData('err_adhar_card',  $adhar_no_upload_result['result']);
                }

                $voter_no_upload_result =  $this->upload_image('voter_card',2048);

                if(!empty($voter_no_upload_result) && $voter_no_upload_result['responseCode'] == 400)
                {
                    $postdata['voter_card'] =  $voter_no_upload_result['result']['file_name'] ;
                }
                else
                {
                    $this->setFlashData('err_voter_card',  $voter_no_upload_result['result']);
                }

                $passport_upload_result =  $this->upload_image('passport',2048);

                if(!empty($passport_upload_result) && $passport_upload_result['responseCode'] == 400)
                {
                    $postdata['passport'] =  $passport_upload_result['result']['file_name'] ;
                }
                else
                {
                    $this->setFlashData('err_passport',  $passport_upload_result['result']);
                }

                $this->load->model('modelregistration');

                $resposeData = $this->modelregistration->candidateRegister($postdata);
                //pr($resposeData);
                if($resposeData['responseCode'] == 200)
                {
                    //send_custom_mail('sayak.mukherjee@qtsin.net',$postdata['email'],'Welcome to new course ','Please login using  your registered email.');
                    $response['page_title']="";
                    $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                    $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    $response['application_id'] = $resposeData['result'];
                    $response['default_tab_selection'] = 'accademic_details_tab_display';
                    renderViews(array('home/user_registration'=>$response));
                }
                else 
                {
                    $this->session->set_flashdata('err_registration',  $resposeData['message']);
                    renderViews(array('home/user_registration'=>$response));
                }

            }
      } 
      
      public function upload_image($fileInputName,$max_size='')
	{
            try
            {

                //echo $service_company_id;die;
                    //$fileInputName='profile_picture';
                 $this->error_msg = '';
                    $fileType ='image';
                    $upload_path=FILEROOTURL.'uploads/profileimages';
                    $config['upload_path']   = $upload_path; 
                    $config['allowed_types'] = 'gif|jpg|png|jpeg'; 

                    if(empty($max_size))
                    {
                        $config['max_size']      = 200;
                    } 
                    //$config['max_width']     = 1024; 
                    //$config['max_height']    = 768;  
                    //$this->load->library('upload', $config);
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload($fileInputName)) {

                        $error_msg['responseCode']=406;
                        $error_msg['message']='error';
                        $error_msg['result']=rebuild_file_errors($this->upload->display_errors());
                        
                        return $error_msg;
                    }
                    else 
                    { 
                        //pr($this->upload->data());
                        $success_msg['responseCode']=400;
                        $success_msg['message']='success';
                        $success_msg['result']=$this->upload->data();

                        return $success_msg;
                           
                    }
            } 
            catch (Exception $e) 
            {
                return FALSE;
                //var_dump($e->getMessage());
            }
	}
        
      public function accademicQualificationSubmit()
      {
            $response['page_title']="";
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['default_tab_selection'] = 'accademic_details_tab_display';
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            
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
                renderViews(array('home/user_registration'=>$response));
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
                if(!empty($postdata['degree_diploma_ug']) && $postdata['degree_diploma_ug'] == 'Others')
                {
                    $postdata['degree_diploma_ug'] = $this->input->post('degree_diploma_ug_others');
                }
                $postdata['specialization_ug'] = $this->input->post('specialization_ug');
                $postdata['name_of_the_college_ug'] = $this->input->post('name_of_the_college_ug');
                $postdata['name_of_the_university_ug'] = $this->input->post('name_of_the_university_ug');
                $postdata['status_of_completion_ug'] = $this->input->post('status_of_completion_ug');        
                $postdata['year_of_passing_ug'] = $this->input->post('year_of_passing_ug');
                $postdata['percentage_ug'] = $this->input->post('percentage_ug');

                $postdata['degree_diploma_pg'] = $this->input->post('degree_diploma_pg');
                if(!empty($postdata['degree_diploma_pg']) && $postdata['degree_diploma_pg'] == 'Others')
                {
                    $postdata['degree_diploma_pg'] = $this->input->post('degree_diploma_pg_others');
                }
                
                $postdata['specialization_pg'] = $this->input->post('specialization_pg');
                $postdata['name_of_the_college_pg'] = $this->input->post('name_of_the_college_pg');
                $postdata['name_of_the_university_pg'] = $this->input->post('name_of_the_university_pg');
                $postdata['status_of_completion_pg'] = $this->input->post('status_of_completion_pg');        
                $postdata['year_of_passing_pg'] = $this->input->post('year_of_passing_pg');
                $postdata['percentage_pg'] = $this->input->post('percentage_pg');

                // there have no insert command for Professional Qualification & Competitive Exams because these are in checkbox

                $postdata['academic_achievement'] = $this->input->post('academic_achievement');
                $postdata['professional_achievements'] = $this->input->post('professional_achievements');

                $postdata['competitive_exams_check'] = $this->input->post('competitive_exams_check');
                
                if(!empty($postdata['competitive_exams_check']))
                {
                    //$postdata['competitive_exams_score'] = $this->input->post('competitive_exams_');
                    if($postdata['competitive_exams_check'] == 'Others')
                    {
                        $postdata['competitive_exams_check'] = $this->input->post('professional_qualification_others_specify');
                
                    }
                }
                $postdata['professional_qualification_check'] = $this->input->post('professional_qualification_check');
                if(!empty($postdata['professional_qualification_check']) && $postdata['professional_qualification_check'] == 'Others')
                {
                    $postdata['professional_qualification_check'] = $this->input->post('professional_qualification_others');
                }
                $this->load->model('modelregistration');

                $resposeData = $this->modelregistration->candidateAccademicsRegister($postdata);

                if($resposeData['responseCode'] == 200)
                {
                    $response['page_title']="";
                    $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                    $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    $response['application_id'] = $resposeData['result'];
                    $response['default_tab_selection'] = 'professional_details_tab_display';
                    renderViews(array('home/user_registration'=>$response));
                }
                else 
                {
                    $this->session->set_flashdata('err_registration',  $resposeData['message']);
                    renderViews(array('home/user_registration'=>$response));
                }
            }
      }
      
      public function professionalQualificationSubmit()
      {
          
            $response['page_title']="";
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['course_details'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['course_name'] = $response['course_details']['name'];
            $response['default_tab_selection'] = 'professional_details_tab_display';
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            
           // pr($response['course_details']);
            $postdata['course_name'] = $this->input->post('course_name');
            $postdata['application_id'] = $this->input->post('application_id');
            //echo $postdata['application_id'];
            //For preview
            $response['course_id'] = $response['course_details']['id'];
            $response['candidate_id'] = fetch_single_value('candidate_courses_map', 'candidate_id',array('id'=>$postdata['application_id'],'course_id'=>$response['course_id']));
            $response['candidate_details'] = fetch_single_row('candidate_details', '',array('id'=>$response['candidate_id']));
            //pr($response['candidate_details']);
            $response['address_list'] = fetch_all_data('address','', array('candidate_id'=>$response['candidate_id']));
            $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$response['candidate_id']));
            $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$response['candidate_id']));
            //echo $response['candidate_id'];
           // pr($response['professional_experience_list']);
            //For preview
            $postdata['total_exp_years'] = $this->input->post('total_exp_years');
            $postdata['total_exp_months'] = $this->input->post('total_exp_months');
                
            $postdata['professional_achievements'] = $this->input->post('professional_achievements');
           
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
                
                $this->load->model('modelregistration');

                $resposeData = $this->modelregistration->candidateExperienceRegister($postdata);

                if($resposeData['responseCode'] == 200)
                {
                    $response['page_title']="";
                    $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                    $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    
                    $response['application_id'] = $resposeData['result'];
                    $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$response['candidate_id']));
                    $response['default_tab_selection'] = 'preview_details_tab_display';
                    renderViews(array('home/user_registration'=>$response));
                }
                else 
                {
                    $this->session->set_flashdata('err_experience',  $resposeData['message']);
                    renderViews(array('home/user_registration'=>$response));
                }
      } 
      
        public function paymentIndexOld()
        {
            $data['application_id']=$this->uri->segment(2);
            if(!empty($data['application_id']))
            {
                $candidate_id = fetch_single_value('candidate_courses_map', 'candidate_id', array('id'=>$data['application_id']));
                single_column_update('candidate_details', array('payment_flag'=>1), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('form_flag'=>4), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('dirty_flag'=>1), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('new_registration_flag'=>1), array('id'=>$candidate_id));
                $response['page_title']="";
                $this->output->set_header('refresh:10; url='.BASEURL.'printinvoice/'.$data['application_id']);
                renderViews(array('home/user_registration_success'=>$response));
            }
            else
            {
                PR("Please Try Again");
            }
        }
        
        public function printInvoiceOld()
        {
            $response['page_title']="";
            $response['application_id']=$applicant_id=$this->uri->segment(2);
            if(!empty($response['application_id']))
            {
                $candidate_id = fetch_single_value('candidate_courses_map', 'candidate_id', array('id'=>$applicant_id));
                
                $payment_id = fetch_single_value('candidate_payment', 'id', array('application_id'=>$applicant_id));
                if(empty($payment_id))
                {
                    $this->load->model('modeluser');
                    //Payment Entry
                    $payment_data['application_id'] = $response['application_id'];
                    $payment_data['candidate_id'] = $candidate_id;
                    $payment_data['amount'] = 1000;
                    $payment_data['status'] = 1;

                    $result = $this->modeluser->addPayment($payment_data);
                
                    $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));

                    $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
                    $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','id as payment_id','created_date') , array('candidate_id'=>$candidate_id,'application_id'=>$applicant_id));
                
                }
                $user_id = $this->session->userdata('loggedinuserid');
                if(!empty($user_id))
                {
                    redirect(BASEURL.'paymentreciept');
                }
                else 
                {
                    renderViews(array('home/print_invoice'=>$response));
                }
                
            }
            else
            {
                PR("Please Try Again");
            }

        }
        */
        public function paymentIndex()
        {
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
            
            //$data['application_id']=$this->uri->segment(2);
            //$data['payment_ammount']=$this->uri->segment(3);
            $response['page_title'] ='';
            if(!empty($response['application_id']) && !empty($response['payment_ammount']))
            {
                $response['application_id'] =$response['application_id'];
                $response['amount'] = $response['payment_ammount'];
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                
                 $response['candidate_details'] = fetch_single_row('candidate_details', '', array('id'=>$candidate_arr['candidate_id']));
                 $response['candidate_address'] = fetch_single_row('address', '', array('candidate_id'=>$candidate_arr['candidate_id']));
                
                
                if(ENVIRONMENT == 'production')
                {
                    $response['return_url'] = BASEURL.'registrationinvoice/'.trim($response['application_id']).'_'.trim($response['amount']);
                    $this->load->library('ccavenue/ccavenue');
                    $this->ccavenue->submission($response);
                }
                else 
                {
                    $this->output->set_header('refresh:10; url='.BASEURL.'responseinvoice/'.trim($response['application_id']).'_'.trim($response['payment_ammount']));
                    
                }
                //
                renderViews(array('home/user_registration_success'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
        }
        
        public function printInvoice()
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
                    $response['payment_ammount'] = $payment_arr[1];
                }
               
            }
            //$response['application_id']=$applicant_id=$this->uri->segment(2);
            //$response['payment_ammount']=$this->uri->segment(3);
            
            //$response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            
            if(!empty($response['application_id']) && !empty($response['payment_ammount']))
            {
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                
                $payment_id = fetch_single_value('candidate_payment', 'id', array('application_id'=>$response['application_id']));
                if(empty($payment_id))
                {
                    $this->load->model('modeluser');
                    //Payment Entry
                    $payment_data['application_id'] = $response['application_id'];
                    $payment_data['candidate_id'] = $candidate_id;
                    $payment_data['amount'] = $response['payment_ammount'];
                    $payment_data['payment_fee_type']   = 'admission_form';
                    $payment_data['term_id'] = 0;
                    $payment_data['invoice_id'] = $response['application_id'].'_'.$candidate_id.'_'.strtotime(date('c'));
                    $payment_data['status'] = 1;
                    
                    $result = $this->modeluser->addPayment($payment_data);
                    single_column_update('candidate_details', array('payment_flag'=>1), array('id'=>$candidate_id));
                    single_column_update('candidate_details', array('form_flag'=>4), array('id'=>$candidate_id));
                    single_column_update('candidate_details', array('dirty_flag'=>1), array('id'=>$candidate_id));
                    single_column_update('candidate_details', array('new_registration_flag'=>1), array('id'=>$candidate_id));
                    $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));

                    $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
                    $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','invoice_id as payment_id','created_date') , array('candidate_id'=>$candidate_id,'application_id'=>$response['application_id']));
                
                    $user_name_display = $response['candidate_details']['first_name'];
                    $course_name = fetch_single_value('courses', 'program_name',array('id'=>$candidate_arr['course_id']));
                    $message = 'Your payment has been received for '.ucfirst($course_name).'.
                                        You can <a href="'.BASEURL.'login">login</a> and view your application status.
                                Please enter your email as username and  Password: "password".';
                    $footer = 'iCAM Bhavan, Plot No. 12, Sector - 117, Salt Lake,Kolkata, West Bengal, 700002, India<br />
                    <a href="'.BASEURL.'" target="_blank" class="link-1" style="color:#666666; text-decoration:none">
                        <span class="link-1" style="color:#666666; text-decoration:none">www.nism.ac.in</span></a>
                    <span class="mobile-block"><span class="hide-for-mobile">|</span></span>
                    Phone: <a href="tel:+1655606605" target="_blank" class="link-1" style="color:#666666; text-decoration:none">
                    <span class="link-1" style="color:#666666; text-decoration:none">022 66735100 - 05</span></a>' ; 
                    $html_message = general_email_template($user_name_display,$message,'Thank You !',$footer);
                    $subject = 'Payment has been received succesfully';
                     
                    //From email templates
                    $get_payment_email = get_email_template_details('Payment');
                    //pr($get_payment_email);
                    if(!empty($get_payment_email))
                    {
                        $source_var = array("@FirstName","@MiddleName","@LastName","@CourseName","@ApplicationId","@InterviewDate","@LoginLink");
                        $replaced_var = array($response['candidate_details']['first_name'],$response['candidate_details']['middle_name'],
                            $response['candidate_details']['last_name'],$course_name,$payment_data['application_id'],"",'<a href="'.BASEURL.'"></a>');

                        if(!empty($get_payment_email['body']))
                        {
                            $message = $get_payment_email['body'];
                            $message = str_replace($source_var,$replaced_var,$message);
                            if(!empty($get_payment_email['email_footer']))
                            {
                                $footer = $get_payment_email['email_footer'];
                                $footer = str_replace($source_var,$replaced_var,$footer);
                            }
                            $html_message = general_email_template($response['candidate_details']['first_name'],$message,' ',$footer);
                        }

                        if(!empty($get_payment_email['subject']))
                        {
                            $subject = $get_payment_email['subject'];
                            $subject = str_replace($source_var,$replaced_var,$subject);
                        }
                    } 

                    send_customer_mail('iCAM Admission',$response['candidate_details']['email_id'],$subject,$message,$html_message);
                }
                
                $user_id = $this->session->userdata('loggedinuserid');
                if(!empty($user_id))
                {
                    redirect(BASEURL.'paymentreciept/'.trim($response['application_id']).'_'.trim($response['payment_ammount']));
                }
                else 
                {
                    renderViews(array('home/print_invoice'=>$response));
                }
                
            }
            else
            {
                 renderViews(array('home/course_not_found'=>$response));
            }

        }
        
        
      
      
      public function login()
      {
           //pr($result);
            loginredirection();
            $response['captcha']= $this->createCaptcha();
            //pr($response['captcha']);
            renderViews(array('login/index'=>$response));
      }
      
      public function createCaptcha()
      {
            loginredirection();
            $this->load->helper('captcha');
            
            $capWord = $this->generateRandomString(6);
                $vals = array(
                    'word'          => strtoupper($capWord),
                    'img_path'      => ROOTURL.'/assets/captcha/',
                    'img_url'       => BASEURL.'/assets/captcha/',
                    'img_width'     => '150',
                    'img_height'    => 30,
                    'expiration'    => 7200,
                    'word_length'   => 5,
                    'font_size'     => 25,
                    'img_id'        => 'Imageid',
                    'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

                    // White background and border, black text and red grid
                    'colors'        => array(
                            'background' => array(255, 255, 255),
                            'border' => array(255, 255, 255),
                            'text' => array(0, 0, 0),
                            'grid' => array(255, 240, 40)
                    )
            );
            $cap = create_captcha($vals);
            $this->session->set_userdata('captcha-str', $cap['word']);
            return $cap['image'];
            
      }
      
      public function refreshCaptcha() {
        $captcha = $this->createCaptcha();
        echo $captcha;
        die;
    }
      
      
      function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
      public function loginSubmit()
      {
            loginredirection();
            $response['page_title']="";
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if(ENVIRONMENT != 'dev2')
            {
                $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required');
            }
            if ($this->form_validation->run() == FALSE)
            {
                $response['captcha']= $this->createCaptcha();
                $this->session->set_flashdata('login_error', 'Please enter all the fields.');
                renderViews(array('login/index'=>$response));
            }
            else
            {
                $postdata['captcha'] = $this->input->post('captcha');
                $valid_captcha=true;
                if(ENVIRONMENT != 'dev2')
                {
                    //Captcha Checking
                    if($postdata['captcha'] != $this->session->userdata['captcha-str'])
                    {
                        $response['captcha']= $this->createCaptcha();
                        $valid_captcha=false;
                        $this->session->set_flashdata('login_error', 'Please enter valid captcha.');
                        renderViews(array('login/index'=>$response));
                    }
                    
                    //
                }
                $postdata['username'] = $this->input->post('username');
                $postdata['password'] = $this->input->post('password');        
                $postdata['dob'] = $this->input->post('dob');
                $postdata['ref_link'] = $this->input->post('ref_link');
                
                $this->load->model('modeluser');
                if($valid_captcha==true)
                {
                    $result = $this->modeluser->validate($postdata);
                    if(ENVIRONMENT != 'dev2')
                    {
                        //LDAP CALL 
                        $this->load->helper('web_service');
                        $send_data['userName'] =$postdata['username'];
                        $send_data['password'] =$postdata['password'];
    
                        $send_data['organization'] ='ss-purulia';
                        $send_data['serviceUserName'] = 'test';
                        $send_data['servicePassword'] = 'test';
                        //echo json_encode($send_data);die;
                        //Todo LDAP cALL
                        $responseJson = callApi('POST', LOGIN_LDAP_LINK, $send_data);
                        $response ='';
                        if(!empty($responseJson))
                        {
                            $response = json_decode($responseJson,TRUE);
                        }
                    }
                    else
                    {
                        $response['message'] = 'success';
                    }
                    
                    if(!empty($result) && !empty($response) && $response['message'] == 'success'){
                        $this->enableLoginSession($result);
                        $user_id = $this->session->userdata('loggedinuserid');
                        $admin_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_SSP_ADMIN));
                        $user_map_admin = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$admin_group_id,'user_id'=>$user_id));
                        
                        //$teacher_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_ICAM_TEACHER));
                        //$user_map_teacher = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$teacher_group_id,'user_id'=>$user_id));
                        
    //                    if(!empty($user_map_admin))
    //                    {  
    //                        redirect(BASEURL.'admin/dashboard');
    //                    }
    //                    else if(!empty($user_map_teacher))
    //                    {   
    //                        
    //                        redirect(BASEURL.'operation/dashboard');
    //                    }
                        $firstLogin = fetch_single_value('user_login_history', 'id', array('user_id'=>$user_id));
                        $param = array(               
                            'login_time'=>date("Y-m-d H:i:s"),
                            'user_id'=>$user_id
                         );
                         $this->db->insert('user_login_history', $param);
                        if(empty($firstLogin))
                        {
                            redirect(BASEURL.'home/passwordreset');
                        }
                        else{
                            redirect(BASEURL.'dashboard');
                        }
                    }
                    else 
                    {
                        $response['captcha']= $this->createCaptcha();
                        $this->session->set_flashdata('login_error',  'Please enter valid username and password for login.');
                        renderViews(array('login/index'=>$response));
                    }
                }
            }
      }
      
      private function enableLoginSession($row)
      {
          $login_data = array('loggedinusername'=>$username,
                   'loggedinuserid'=>$row->userid,'loggedadmin'=>0);  
               if(!empty($row->userid))
               {
                    $admin_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_SSP_ADMIN));
                    $user_map = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$admin_group_id,'user_id'=>$row->userid));
               }

                if(!empty($user_map))
                {
                    $login_data['loggedadmin']  = 1;
                }
                else 
                {
                    $login_data['studentInitialName'] = $row->first_name;
                    $login_data['studentName'] = $row->first_name.(!empty($row->middle_name)?" $row->middle_name":'')." $row->last_name";
                    $login_data['rollNumber'] = fetch_single_value('student_details', 'rollNumber',array('userId'=>$row->userid));
                    $login_data['passwordResetFlag'] = $row->passwordReset;
                }
            $login_data['ay_session_data'] = fetch_all_data('student_session');
            $this->session->set_userdata($login_data);
            
            
           
            
            return true;
      }

      public function resetPassword()
      {
                $response['page_title']="";
                //redirect(BASEURL.'forgetPassword');    
                renderViews(array('login/reset_password'=>$response));
      }
      
       public function resetPasswordSubmit()
        {
            
                $username = $this->input->post('username');
                $username_check = fetch_single_value('users','username',array('username'=>$username));
                //pr($username_check);
                if($username_check == $username )
                {
                    $postdata['username'] = $username;

                    $new_password = trim($this->input->post('new_password'));
                    $confirm_password = trim($this->input->post('confirm_password'));
                    if($new_password == $confirm_password)
                    {
                        $postdata['new_password'] = md5($new_password);

                        $this->load->model('modeluser');
                        $response = $this->modeluser->forgetPassword($postdata);
                        
                        if(!empty($response))
                        {
                           renderViews(array('login/index'=>$response));
                        }
                        else 
                        {
                            $response['error_message'] = 'Please give the valid credential !!';
                            renderViews(array('login/reset_password'=>$response));
                        }
                    }
                    else
                    {
                        $response['error_message'] = 'Please confirm the new password !!';
                        renderViews(array('login/reset_password'=>$response));
                    }
                    
                }
                else
                {
                    $response['error_message'] = 'Please give the valid username !!';
                    renderViews(array('login/reset_password'=>$response));
                }
            
        }
        
      
      public function date_format_check($str)
      {
            if (!DateTime::createFromFormat('d/m/Y', $str)) //yes it's DD/MM/YYYY
            {
                $this->form_validation->set_message('date_format_check', 'The {field} has not a valid date format');
                return FALSE;
            }
            else
            {
                return TRUE;
            }
      }

      function setFlashData($var_name,$err_msg)
      {

            if(!empty($err_msg))
            {
                $err_msg = strip_tags($err_msg);
                if($err_msg != 'You did not select a file to upload.')
                {
                    
                    $this->session->set_flashdata($var_name,  $err_msg);
                }
                
            }
            return TRUE;
      }
    
        public function applycoupon()
        {
                $this->load->helper('security');

                $user['coupon_code'] = trim($this->input->post('coupon_code', true));
                $user['registration_amount'] = trim($this->input->post('registration_amount', true));
                
                $coupon_details = fetch_single_row('course_coupons','',array('coupon_code'=>$user['coupon_code'] ,
                    'valid_till > ' =>  date('Y-m-d') , 'minimum_order_value < '=> $user['registration_amount']));
                
                //echo $this->db->last_query();
                //pr($coupon_details);
                if(!empty($coupon_details) && $coupon_details['coupon_user_type'] == 'common')
                {
                    $coupon_code = $coupon_details['coupon_code'];
                    $result['discount_type'] = $coupon_details['discount_type'];
                    $result['discount_percentage'] = $coupon_details['discount_amount'];  
                    
                    if($coupon_details['discount_type'] == 'percentage')
                    {
                        $result['discount_amount'] = ($user['registration_amount'] * $coupon_details['discount_amount'])/100;
                        $result['grand_total'] = ($user['registration_amount'] - $result['discount_amount']);
                    }
                    else if($coupon_details['discount_type'] == 'flat')
                    {
                        $result['discount_amount'] =  $coupon_details['discount_amount'];
                        $result['grand_total'] = ($user['registration_amount'] - $result['discount_amount']);
                    }
                    $result['coupon_code'] = $coupon_code ;
                    //pr($result);
                }
                
//pr($result);
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
                        $error_msg['result']='Coupon is not valid';
                        print_r(json_encode($error_msg));
                        exit();

                }

        }
      
      public function ajaxRegistrationSubmit()
      {

        $this->load->helper('security');

                $postdata['course_name'] = $this->input->post('course_name');
                $postdata['course_id'] = $this->input->post('course_id');
                $postdata['first_name'] = $this->input->post('first_name');
                $postdata['middle_name'] = $this->input->post('middle_name');
                $postdata['last_name'] = $this->input->post('last_name');
                $postdata['date_of_birth'] = $this->input->post('date_of_birth');
                $postdata['sex_is'] = $this->input->post('sex_is');
                $postdata['marital_status_is'] = $this->input->post('marital_status_is');
                $postdata['parents_name'] = $this->input->post('parents_name');
                $postdata['parents_email'] = $this->input->post('parents_email');
                $postdata['parents_contact_no'] = $this->input->post('parents_contact_no');
                $postdata['relationship'] = $this->input->post('relationship');
                $postdata['contact_no'] = $this->input->post('contact_no');
                $postdata['email'] = $this->input->post('email');
                $postdata['street_address'] = $this->input->post('street_address');
                $postdata['address_line_2'] = $this->input->post('address_line_2');
                $postdata['city'] = $this->input->post('city');
                $postdata['state'] = $this->input->post('state');
                $postdata['zip_code'] = $this->input->post('zip_code');
                $postdata['country'] = $this->input->post('country');
                $postdata['pan_card_no'] = $this->input->post('pan_card_no');
                $postdata['adhar_card_no'] = $this->input->post('adhar_card_no');
                $postdata['voter_card_no'] = $this->input->post('voter_card_no');
                $postdata['passport_no'] = $this->input->post('passport_no');
                $postdata['interview_preferred_location'] =  $this->input->post('interview_preferred_location');
                
                $postdata['profile_picture'] =  $this->input->post('profile_picture_input');
                $postdata['pan_card'] =  $this->input->post('pan_card_input');
                $postdata['adhar_card'] =  $this->input->post('adhar_card_input');
                $postdata['voter_card'] =  $this->input->post('voter_card_input');
                $postdata['passport'] =  $this->input->post('passport_input');

                
                $this->load->model('modelregistration');
                $resposeData = $this->modelregistration->candidateRegister($postdata);
                //pr($resposeData);
                if(empty($resposeData['responseCode']))
                {
                    $error_msg['responseCode']=406;
                    $error_msg['message']='Please try again';
                    $error_msg['result']='';
                    print_r(json_encode($error_msg));
                    exit();        

                }
                else
                {
                        if($resposeData['responseCode'] == 200)
                        {
                           
                                $user_name_display = $postdata['first_name'];
                                $course_name = fetch_single_value('courses', 'program_name',array('id'=>$postdata['course_id']));
                                $message = '
                                    Thank you for registering in course '.ucfirst($course_name).'.
                                        You can <a href="'.BASEURL.'login">login</a>  and continue your registration.
                                Please enter your email as username and  Password: "password".
                               ';
                                $footer = 'iCAM Bhavan, Plot No. 12, Sector - 117, Salt Lake,Kolkata, West Bengal, 700002, India<br />
                                <a href="'.BASEURL.'" target="_blank" class="link-1" style="color:#666666; text-decoration:none">
                                    <span class="link-1" style="color:#666666; text-decoration:none">www.nism.ac.in</span></a>
                                <span class="mobile-block"><span class="hide-for-mobile">|</span></span>
                                Phone: <a href="tel:+1655606605" target="_blank" class="link-1" style="color:#666666; text-decoration:none">
                                <span class="link-1" style="color:#666666; text-decoration:none">022 66735100 - 05</span></a>' ; 
                                
                                $html_message = general_email_template($user_name_display,$message,'A Big Thank You & Welcome!',$footer);
                                $subject = 'Thanks for the registration';

                                //From email templates
                                $get_registration_email = get_email_template_details('Registration');
                                //pr($get_registration_email);
                                if(!empty($get_registration_email))
                                {
                                    $source_var = array("@FirstName","@MiddleName","@LastName","@CourseName","@ApplicationId","@InterviewDate","@LoginLink");
                                    $replaced_var = array($postdata['first_name'],$postdata['middle_name'],$postdata['last_name'],$course_name,"","",'<a href="'.BASEURL.'"></a>');
                                      
                                    if(!empty($get_registration_email['body']))
                                    {
                                        $message = $get_registration_email['body'];
                                        $message = str_replace($source_var,$replaced_var,$message);
                                        if(!empty($get_registration_email['email_footer']))
                                        {
                                            $footer = $get_registration_email['email_footer'];
                                            $footer = str_replace($source_var,$replaced_var,$footer);
                                        }
                                        $html_message = general_email_template($postdata['first_name'],$message,' ',$footer);
                                    }

                                    if(!empty($get_registration_email['subject']))
                                    {
                                        $subject = $get_registration_email['subject'];
                                        $subject = str_replace($source_var,$replaced_var,$subject);
                                    }
                                } 
                                
                                send_customer_mail('iCAM Admission',trim($postdata['email']),$subject,$message,$html_message);
                                
                                $success_msg['responseCode']=200;
                                $success_msg['message']='success';
                                $success_msg['result']=  $resposeData['result'];
                                print_r(json_encode($success_msg));
                                exit();
                        }
                        $error_msg['responseCode']=406;
                        $error_msg['message']=$resposeData['message'];
                        $error_msg['result']='';
                        print_r(json_encode($error_msg));
                        exit();

                }

            }

       public function ajaxFileUpload()
       {
           $postdata['file_size'] = $this->input->post('file_size');
           $image_upload_result =  $this->upload_image('user-file-input',$postdata['file_size']);
           print_r(json_encode($image_upload_result));
                exit();
            //pr($image_upload_result);
                
       }
       
       public function ajaxAccademicSubmission()
      {

                $this->load->helper('security');

                $postdata['course_name'] = $this->input->post('course_name');
                $postdata['application_id'] = $this->input->post('application_id');

                $postdata['name_of_the_school_ssc'] = $this->input->post('name_of_the_school_ssc');
                $postdata['name_of_the_board_ssc'] = $this->input->post('name_of_the_board_ssc');
                $postdata['year_of_passing_ssc'] = $this->input->post('year_of_passing_ssc');
                $postdata['percentage_ssc'] = $this->input->post('percentage_ssc');

                $postdata['group_major'] = $this->input->post('group_major_hsc');
                $postdata['name_of_the_school_hsc'] = $this->input->post('name_of_the_school_hsc');
                $postdata['name_of_the_board_hsc'] = $this->input->post('name_of_the_board_hsc');
                $postdata['year_of_passing_hsc'] = $this->input->post('year_of_passing_hsc');
                $postdata['percentage_hsc'] = $this->input->post('percentage_hsc');

                $postdata['degree_diploma_ug'] = $this->input->post('degree_diploma_ug');
                if(!empty($postdata['degree_diploma_ug']) && $postdata['degree_diploma_ug'] == 'Others')
                {
                    $postdata['degree_diploma_ug'] = $this->input->post('degree_diploma_ug_others');
                }
                $postdata['specialization_ug'] = $this->input->post('specialization_ug');
                $postdata['name_of_the_college_ug'] = $this->input->post('name_of_the_college_ug');
                $postdata['name_of_the_university_ug'] = $this->input->post('name_of_the_university_ug');
                $postdata['status_of_completion_ug'] = $this->input->post('status_of_completion_ug');        
                $postdata['year_of_passing_ug'] = $this->input->post('year_of_passing_ug');
                $postdata['percentage_ug'] = $this->input->post('percentage_ug');

                $postdata['degree_diploma_pg'] = $this->input->post('degree_diploma_pg');
                if(!empty($postdata['degree_diploma_pg']) && $postdata['degree_diploma_pg'] == 'Others')
                {
                    $postdata['degree_diploma_pg'] = $this->input->post('degree_diploma_pg_others');
                }
                
                $postdata['specialization_pg'] = $this->input->post('specialization_pg');
                $postdata['name_of_the_college_pg'] = $this->input->post('name_of_the_college_pg');
                $postdata['name_of_the_university_pg'] = $this->input->post('name_of_the_university_pg');
                $postdata['status_of_completion_pg'] = $this->input->post('status_of_completion_pg');        
                $postdata['year_of_passing_pg'] = $this->input->post('year_of_passing_pg');
                $postdata['percentage_pg'] = $this->input->post('percentage_pg');
                $postdata['professional_qualification_check'] = $this->input->post('professional_qualification_check[]');
                $postdata['competitive_exams_check'] = $this->input->post('competitive_exams_check[]');
                $postdata['academic_achievement'] = $this->input->post('academic_achievement');
                //pr($postdata);
                $this->load->model('modelregistration');

                $resposeData = $this->modelregistration->candidateAccademicsRegister($postdata);
               // pr($resposeData);
                if($resposeData)
                {
                        $success_msg['responseCode']=200;
                        $success_msg['message']='success';
                        $success_msg['result']=  $resposeData;
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

      public function ajaxProfessionalQualificationSubmission()
      {
            $postdata['course_name'] = $this->input->post('course_name');
            $postdata['application_id'] = $this->input->post('application_id');

            $postdata['total_exp_years'] = $this->input->post('total_exp_years');
            $postdata['total_exp_months'] = $this->input->post('total_exp_months');
                
            $postdata['professional_achievements'] = $this->input->post('professional_achievements');
           
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

            $responseData = $this->modelregistration->candidateExperienceRegister($postdata);
                //pr($responseData);
            if($responseData)
            {
                $success_msg['responseCode']=200;
                $success_msg['message']='success';
                $response['application_id'] = $responseData['result'];
                $response['candidate_id'] = fetch_single_value('candidate_courses_map', 'candidate_id', array('id'=>$response['application_id']));
                $response['candidate_details'] = fetch_single_row('candidate_details','', array('id'=>$response['candidate_id']));
                if(!empty($response['candidate_details']['interview_preferred_location']))
                {
                    $response['candidate_details']['preferred_venue_location'] = getVenueById($response['candidate_details']['interview_preferred_location']);
                }
                $address_details = fetch_single_row('address','', array('candidate_id'=>$response['candidate_id']));
                $response['address_details'] = '';
                
                if(!empty($address_details))
                {
                    $address_details['street_address'] = $address_details['street_address'];
                    $address_details['city'] = $address_details['city'];
                    $address_details['state'] = $address_details['state'];
                    $address_details['postal_code'] = $address_details['postal_code'];
                    $address_details['country'] = getCountryById($address_details['country_id']);
                    $response['address_details'] = $address_details;
                }
                
               

                $response['qualification_details_list'] = fetch_all_data('qualification_details','', array('candidate_id'=>$response['candidate_id']));

                $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$response['candidate_id']));

                $success_msg['result']= $response;
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
      
      public function upload_image($fileInputName,$max_size='')
	{
            try
            {

                    $this->error_msg = '';
                    $fileType ='image';
                    $upload_path=FILEROOTURL.'profileimages';
                    $config['upload_path']   = $upload_path; 
                    $config['allowed_types'] = 'gif|jpg|png|jpeg'; 

                    if(empty($max_size))
                    {
                        $config['max_size']      = 200;
                    }
                    else 
                    {
                         $config['max_size']      = intval($max_size);
                    }
                    //$config['max_width']     = 1024; 
                    //$config['max_height']    = 768;  
                    //$this->load->library('upload', $config);
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ( ! $this->upload->do_upload($fileInputName)) {

                        $error_msg['responseCode']=406;
                        $error_msg['message']='error';
                        $error_msg['result']=rebuild_file_errors($this->upload->display_errors());
                        
                        return $error_msg;
                    }
                    else 
                    { 
                        //pr($this->upload->data());
                        $success_msg['responseCode']=200;
                        $success_msg['message']='success';
                        $success_msg['result']=$this->upload->data();

                        return $success_msg;
                           
                    }
            } 
            catch (Exception $e) 
            {
                return FALSE;
                //var_dump($e->getMessage());
            }
	}

	public function ajaxUpdateRegistration()
    {
        $this->load->helper('security');
        $application_id = $this->input->post('application_id');
        if(!empty($application_id))
        {
            $candidate_id = fetch_single_value('candidate_courses_map','candidate_id',array('id'=>$application_id));
            $user_id =  fetch_single_value('candidate_details','user_id',array('id'=>$candidate_id));
        }
        $postdata['first_name'] = $this->input->post('first_name');
        $postdata['middle_name'] = $this->input->post('middle_name');
        $postdata['last_name'] = $this->input->post('last_name');
        $postdata['date_of_birth'] = $this->input->post('date_of_birth');
        $postdata['sex_is'] = $this->input->post('sex_is');
        $postdata['marital_status_is'] = $this->input->post('marital_status_is');
        $postdata['parents_name'] = $this->input->post('parents_name');
        $postdata['parents_email'] = $this->input->post('parents_email');
        $postdata['parents_contact_no'] = $this->input->post('parents_contact_no');
        $postdata['relationship'] = $this->input->post('relationship');
        $postdata['contact_no'] = $this->input->post('contact_no');
        $postdata['street_address'] = $this->input->post('street_address');
        $postdata['address_line_2'] = $this->input->post('address_line_2');
        $postdata['city'] = $this->input->post('city');
        $postdata['state'] = $this->input->post('state');
        $postdata['zip_code'] = $this->input->post('zip_code');
        $postdata['country'] = $this->input->post('country');
        $postdata['pan_card_no'] = $this->input->post('pan_card_no');
        $postdata['adhar_card_no'] = $this->input->post('adhar_card_no');
        $postdata['voter_card_no'] = $this->input->post('voter_card_no');
        $postdata['passport_no'] = $this->input->post('passport_no');
        $postdata['interview_preferred_location'] =  $this->input->post('interview_preferred_location');
        
        $postdata['profile_picture'] =  $this->input->post('profile_picture_input');
        $postdata['pan_card'] =  $this->input->post('pan_card_input');
        $postdata['adhar_card'] =  $this->input->post('adhar_card_input');
        $postdata['voter_card'] =  $this->input->post('voter_card_input');
        $postdata['passport'] =  $this->input->post('passport_input');

        $this->load->model('modelregistration');
        $resposeData = $this->modelregistration->updateCandidateDetails($postdata,$candidate_id);
        $resposeData = $this->modelregistration->updateUser($postdata,$user_id);
        $resposeData = $this->modelregistration->updateAddress($postdata,$candidate_id,$user_id);
        //pr($resposeData);
        if(!empty($resposeData['responseCode']))
        {
            $success_msg['responseCode']=200;
            $success_msg['message']='success';
            $success_msg['result']=  $resposeData['result'];
            print_r(json_encode($success_msg));
            exit();
        }
        else
        {
            $error_msg['responseCode']=406;
            $error_msg['message']='Please try again';
            $error_msg['result']='';
            print_r(json_encode($error_msg));
            exit(); 
        }
    }

    public function offlinePrintInvoice()
    {
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
                //$response['course_list'] = fetch_all_data('courses', array('id','program_id','program_name','course_link','name')); 
                $response['application_id'] =$response['application_id'];
                $response['amount'] = $response['payment_ammount'];
                $candidate_arr = fetch_single_row('candidate_courses_map', '', array('id'=>$response['application_id']));
                $response['course_details_display'] = fetch_single_row('courses', '', array('id'=>$candidate_arr['course_id']));
                $candidate_id = $candidate_arr['candidate_id'];
                
                 $response['candidate_details'] = fetch_single_row('candidate_details', '', array('id'=>$candidate_arr['candidate_id']));
                 $response['candidate_address'] = fetch_single_row('address', '', array('candidate_id'=>$candidate_arr['candidate_id']));
                 //pr($response);
                //renderViews(array('front/template1/header'=>$response,'front/template1/user/offline_payment_invoice'=>'','front/template1/footer'=>''));
                renderViews(array('home/offline_print_invoice'=>$response));
            }
            else
            {
                renderViews(array('home/course_not_found'=>$response));
            }
    }
    

}
