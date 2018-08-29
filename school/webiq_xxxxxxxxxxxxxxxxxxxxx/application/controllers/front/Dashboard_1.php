<?php

class Dashboard extends CI_Controller {

    function index()
    {
        uservalidate();
        $user_id = $this->session->userdata('loggedinuserid');
        $candidate_details = fetch_single_row('candidate_details', '',array('user_id'=>$user_id));
       
        $course_details = fetch_single_row('courses', array('name','id'), array('name'=>'PGPSM Application Form - Admissions 2016-17'));
        $response['course_name'] = $course_details['name'];
        $response['course_id'] = $course_details['id'];
        $response['application_id'] = fetch_single_value('candidate_courses_map', 'id',array('candidate_id'=>$candidate_details['id'],'course_id'=>$response['course_id']));
        
        //Checking the form status
        switch ($candidate_details['form_flag']) {
            case 0:
                $display_page = 'dashboard';
                break;
            case 1:
                $response['user_registration_flag']=1;
                $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                $response['default_tab_selection'] = 'accademic_details_tab_display';
                $display_page = 'registration/user_registration';
                break;
            case 2:
                $response['user_registration_flag']=1;
                $display_page = 'registration/user_registration';
                break;
            default:
                $display_page = 'dashboard';
                break;
        }

        $response['page_title']="";
        
        renderViews(array('front/template1/header'=>$response,'front/template1/'.$display_page=>'','front/template1/footer'=>''));
    }
    
    public function accademicQualificationSubmit()
      {
            $response['page_title']="";
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['default_tab_selection'] = 'accademic_details_tab_display';
            
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
                //pr($resposeData);
                if($resposeData['responseCode'] == 200)
                {
                    $response['page_title']="";
                    $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                    $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    $response['application_id'] = $resposeData['result'];
                    $response['default_tab_selection'] = 'professional_details_tab_display';
                    renderViews(array('front/template1/header'=>$response,'front/template1/'.$display_page=>'','front/template1/footer'=>''));
                }
                else 
                {
                    $this->session->set_flashdata('err_registration',  $resposeData['message']);
                    renderViews(array('front/template1/header'=>$response,'front/template1/'.$display_page=>'','front/template1/footer'=>''));
                }

            }
      }
      
      public function professionalQualificationSubmit()
      {
            $response['page_title']="";
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
            $response['default_tab_selection'] = 'professional_details_tab_display';
            
            
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
                    $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
                    $response['course_name'] = fetch_single_value('courses', 'name', array('name'=>'PGPSM Application Form - Admissions 2016-17'));
                    $response['application_id'] = $resposeData['result'];
                    $response['default_tab_selection'] = 'preview_details_tab_display';
                    renderViews(array('front/template1/header'=>$response,'front/template1/'.$display_page=>'','front/template1/footer'=>''));
                }
                else 
                {
                    $this->session->set_flashdata('err_experience',  $resposeData['message']);
                    renderViews(array('front/template1/header'=>$response,'front/template1/'.$display_page=>'','front/template1/footer'=>''));
                }
      } 
      
        public function registrationSuccess()
        {
            $response['page_title']="";
            $this->output->set_header('refresh:10; url='.BASEURL.'printinvoice');
            renderViews(array('home/user_registration_success'=>$response));
        }
        
        public function printInvoice()
        {
            $response['page_title']="";
            renderViews(array('home/print_invoice'=>$response));
        }
}
