<?php

    class Request extends CI_Controller 
    {
        public function requestIndex()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');

            $response['candidate_id'] = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));
            //$response['application_id'] = fetch_single_value('candidate_courses_map', 'id',array('candidate_id'=>$candidate_id));
            

            $this->load->model('modeluser');
            $response['feedback_course_list'] = $this->modeluser->display_course_list_for_user_request($user_id);
            $response['certificate_list'] = fetch_all_data('certificates_details');
            $response['display_service_request_list'] = $this->modeluser->display_service_request_list('service_requests','',array('request_type'=>'Certificates','user_id'=>$user_id));

            $response['service_request'] = 1;
            //Course Display
            $this->load->model('modeluser');
            $response['course_list'] = $this->modeluser->checkPassoutdate();
            //alumni display 
            $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                    'id'=>$user_id));
            $response['front_menu_details']="request";
            renderViews(array('front/template1/header'=>$response,'front/template1/user/requests'=>'','front/template1/footer'=>''));
        }
        
        public function userRequestAdd()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');
            $this->load->helper('security');
            //$postdate['candidate_id'] = trim($this->input->post('candidate_id', true));
           
            $postdate['certificate_id'] = trim($this->input->post('certificate_id', true));
            $postdate['comments'] = trim($this->input->post('comments', true));
            $postdate['certificate_path'] = '';
            $postdate['course_id'] = trim($this->input->post('course_id', true));
            $postdate['candidate_id'] = fetch_single_value('candidate_details','id',array('course_id'=>$postdate['course_id'],'user_id'=>$user_id));
            if(!empty($postdate['candidate_id']))
            {
                $postdate['application_id'] = fetch_single_value('candidate_courses_map','id',array('candidate_id'=>$postdate['candidate_id'] ,
                    'course_id'=>$postdate['course_id']));
            }
            
            //pr($postdate);
            if(!empty($postdate['candidate_id']) && !empty($postdate['application_id']) && !empty($postdate['course_id']))
            {
                $this->load->model('modeluser');
                $postdate['request_type'] = 'Certificates';
                $resposeData = $this->modeluser->addUserRequest($postdate);
            }
            
                //pr($resposeData);
                if(!empty($resposeData))
                {
                    $this->session->set_flashdata('success_message',  'You have submited Request successfully!!');
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

        public function refundIndex()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');

            $response['candidate_id'] = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));
            $response['application_id'] = fetch_single_value('candidate_courses_map', 'id',array('candidate_id'=>$response['candidate_id']));
            

            $this->load->model('modeluser');
            $response['refund_course_list'] = $this->modeluser->display_course_list_for_user_refund($user_id);

            $response['display_refund_list'] = $this->modeluser->display_refund_list($response['candidate_id']);
                //'service_requests','',array('request_type'=>'Certificates','user_id'=>$user_id));

            $response['service_request'] = 1;
            //Course Display
            $this->load->model('modeluser');
            $response['course_list'] = $this->modeluser->checkPassoutdate();
            //alumni display 
            $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                    'id'=>$user_id));
            $response['front_menu_details']="request";
            renderViews(array('front/template1/header'=>$response,'front/template1/user/refund'=>'','front/template1/footer'=>''));
        }

        public function userRefundRequestAdd()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');
            $this->load->helper('security');
            //$postdate['candidate_id'] = trim($this->input->post('candidate_id', true));
           
            $postdate['course_id'] = trim($this->input->post('course_id', true));
            $first_fee = trim($this->input->post('first_fee', true));
            $first_fee_refund_percentage = trim($this->input->post('first_fee_refund_percentage', true));
            $postdate['refund_amount'] = ($first_fee_refund_percentage / $first_fee ) * 100;
            //pr($postdate['refund_amount']);

            $postdate['candidate_id'] = fetch_single_value('candidate_details','id',array('course_id'=>$postdate['course_id'],'user_id'=>$user_id));
            if(!empty($postdate['candidate_id']))
            {
                $postdate['application_id'] = fetch_single_value('candidate_courses_map','id',array('candidate_id'=>$postdate['candidate_id'] ,
                    'course_id'=>$postdate['course_id']));
            }
            
            //pr($postdate);
            if(!empty($postdate['candidate_id']) && !empty($postdate['application_id']) && !empty($postdate['course_id']))
            {
                $this->load->model('modeluser');
                //$postdate['request_type'] = 'Certificates';
                $resposeData = $this->modeluser->addUserRefundRequest($postdate);
            }
            
                //pr($resposeData);
                if(!empty($resposeData))
                {
                    $this->session->set_flashdata('success_message',  'You have submited Request successfully!!');
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