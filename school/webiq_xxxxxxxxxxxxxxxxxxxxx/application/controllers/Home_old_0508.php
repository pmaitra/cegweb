<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

      public function index()
      {
          redirect(BASEURL.'login');    
      }
      
      public function admission()
      {
            //logintempcheck();
            loginredirection();
            $this->load->library('form_validation');
            $response['page_title']="";
            
            $response['course_link'] = trim($this->uri->segment(2));
            $response['course_details_display'] = fetch_single_row('courses', '', array('course_link'=>$response['course_link']));
            
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
          send_custom_sendmail('sayak.mukherjee@qtsin.net','sayak2011@gmail.com','Weil.comlcome to new course ','Please login using  your registered email.');
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
            $data['application_id']=$this->uri->segment(2);
            $data['payment_ammount']=$this->uri->segment(3);
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            if(!empty($data['application_id']))
            {
                $candidate_id = fetch_single_value('candidate_courses_map', 'candidate_id', array('id'=>$data['application_id']));
                single_column_update('candidate_details', array('payment_flag'=>1), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('form_flag'=>4), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('dirty_flag'=>1), array('id'=>$candidate_id));
                single_column_update('candidate_details', array('new_registration_flag'=>1), array('id'=>$candidate_id));
                $response['page_title']="";
                $this->output->set_header('refresh:10; url='.BASEURL.'printinvoice/'.$data['application_id'].'/'.$data['payment_ammount']);
                renderViews(array('home/user_registration_success'=>$response));
            }
            else
            {
                PR("Please Try Again");
            }
        }
        
        public function printInvoice()
        {
            $response['page_title']="";
            $response['application_id']=$applicant_id=$this->uri->segment(2);
            $response['payment_ammount']=$this->uri->segment(3);
            $response['course_details_display'] = fetch_single_row('courses', '', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            
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
                    $payment_data['amount'] = $response['payment_ammount'];
                    $payment_data['status'] = 1;

                    $result = $this->modeluser->addPayment($payment_data);
                
                    $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));

                    $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
                    $response['candidate_payment_details'] = fetch_single_row('candidate_payment' , array('amount','id as payment_id','created_date') , array('candidate_id'=>$candidate_id,'application_id'=>$applicant_id));
                
                }
                $user_id = $this->session->userdata('loggedinuserid');
                if(!empty($user_id))
                {
                    redirect(BASEURL.'paymentreciept/'.$response['application_id'].'/'.$response['payment_ammount']);
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
        
        
      
      
      public function login()
      {
            loginredirection();
            $response='';
            renderViews(array('login/index'=>$response));
      }
      
      public function templogin()
      {
          //pr('jo');
            //loginredirection();
            $response='';
            renderViews(array('login/tempindex'=>$response));
      }
      
      public function logintempsubmit()
      {
            //loginredirection();
            $response['page_title']="";
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('login_error', 'Please enter username and password for login.');
                renderViews(array('login/tempindex'=>$response));
            }
            else
            {
                $postdata['username'] = $this->input->post('username');
                $postdata['password'] = $this->input->post('password');
                
                
                
                if(!empty($postdata['username'] == 'adminportal@qtsin.net' && $postdata['password'] == '!Q2w3e4r')){
                    $login_data = array('logintemp'=>$postdata['username']);  
                    $this->session->set_userdata($login_data);
                    redirect(BASEURL);
                }
                else 
                {
                    $this->session->set_flashdata('login_error',  'Please enter valid username and password for login.');
                    renderViews(array('login/index'=>$response));
                }
            }
      }
      
      public function loginSubmit()
      {
            loginredirection();
            $response['page_title']="";
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE)
            {
                $this->session->set_flashdata('login_error', 'Please enter username and password for login.');
                renderViews(array('login/index'=>$response));
            }
            else
            {
                $postdata['username'] = $this->input->post('username');
                $postdata['password'] = $this->input->post('password');
                
                $this->load->model('modeluser');

                $result = $this->modeluser->validate($postdata);
                
                if(!empty($result)){
                    $user_id = $this->session->userdata('loggedinuserid');
                    $admin_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_NISM_ADMIN));
                    $user_map_admin = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$admin_group_id,'user_id'=>$user_id));
                    
                    $teacher_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_ICAM_TEACHER));
                    $user_map_teacher = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$teacher_group_id,'user_id'=>$user_id));
                    
                    if(!empty($user_map_admin))
                    {  
                        redirect(BASEURL.'admin/dashboard');
                    }
                    else if(!empty($user_map_teacher))
                    {   
                        
                        redirect(BASEURL.'operation/dashboard');
                    }
                    redirect(BASEURL.'dashboard');
                }
                else 
                {
                    $this->session->set_flashdata('login_error',  'Please enter valid username and password for login.');
                    renderViews(array('login/index'=>$response));
                }
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

       public function ajaxAccademicSubmission()
      {

                $this->load->helper('security');

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

                $response['address_list'] = fetch_single_row('address','', array('candidate_id'=>$response['candidate_id']));

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
}
