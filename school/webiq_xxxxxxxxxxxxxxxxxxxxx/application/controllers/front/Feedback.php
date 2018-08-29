<?php

    class Feedback extends CI_Controller 
    {
        public function index()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');
            
            $this->load->model('modelfeedback');
            $response['feedback_course_list'] = $this->modelfeedback->display_course_list_for_user($user_id);
            
            //Course Display
            $this->load->model('modeluser');
            $response['course_list'] = $this->modeluser->checkPassoutdate();
            //alumni display 
            $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                    'id'=>$user_id));
            $response['front_menu_details']="feedback";
            renderViews(array('front/template1/header'=>$response,'front/template1/user/feedback'=>'','front/template1/footer'=>''));
        }
        
        public function userFeedbackAdd()
        {
            uservalidate();
            $this->load->helper('security');
            $postdate['course_id'] = trim($this->input->post('course_id', true));
            $postdate['feedback'] = trim($this->input->post('data', true));
                //pr($survey_questions);
            $this->load->model('modelfeedback');
            $resposeData = $this->modelfeedback->addFeedback($postdate);
                //pr($resposeData);
                if(!empty($resposeData))
                {
                    $this->session->set_flashdata('success_message',  'You have  submited feedback successfully!!');
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
        }

        public function teacherIndex()
        {
            teachervalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');
            $response['course_list'] = getCourseList();
            $this->load->model('modelfeedback');
            $response['course_details'] = $this->modelfeedback->display_course_list_for_teacher($user_id);
            renderViews(array('operations/template1/header'=>$response,'operations/template1/feedback/index'=>'','operations/template1/footer'=>''));
        }

        public function teacherFeedbackAdd()
        {
            teachervalidate();
		$response['course_list'] = getCourseList();
            $this->load->helper('security');
            $postdate['course_id'] = trim($this->input->post('course_id', true));
            $postdate['feedback'] = trim($this->input->post('data', true));
            $this->load->model('modelfeedback');
            $resposeData = $this->modelfeedback->addTeacherFeedback($postdate);
                
                if(!empty($resposeData))
                {
                    $this->session->set_flashdata('success_message',  'You have  submited feedback successfully!!');
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
        }
    }
?>