<?php

class Dashboard extends CI_Controller {

    function index()
    {
        uservalidate();
        $studentRoll = $this->session->userdata('rollNumber');
        $response['front_menu_details']="dashboard";
       
        $display_page='dashboard';   
        $this->load->model('modelstudent');
        
        $response['basic_details'] = fetch_single_row('student_section_map', array('section','standard'),array('rollNumber'=>$studentRoll));
        $response['student_details'] = fetch_single_row('student_details', array('standard','house'),array('rollNumber'=>$studentRoll));
        $response['student_hostel'] = $this->modelstudent->getLatestHotel($studentRoll);

        if(!empty($response['student_hostel']))
        {
            $response['student_details']['house'] = $response['student_hostel'];
        }
        if(!empty($response['basic_details']['standard']))
        {
            $response['student_details']['standard'] = $response['basic_details']['standard'];
        }
        $response['page_title']="";
        //pr($response);
       renderViews(array('front/template1/header'=>$response,'front/template1/'.$display_page=>'','front/template1/footer'=>''));
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
        
        public function downloads()
        {
            $response['page_title']="";
            renderViews(array('front/template1/header'=>$response,'front/template1/user/downloads'=>'','front/template1/footer'=>''));

        }
}
