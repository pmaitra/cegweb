<?php

class Student extends CI_Controller {

    private $studentRoll;

    function __construct() {
        parent::__construct();
        uservalidate();
        $this->studentRoll = $this->session->userdata('rollNumber');
    }

    function index() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "general";
        renderViews(array('front/template1/header' => $response, 'front/template1/student/password-reset' => '', 'front/template1/footer' => ''));
    }

    function profile() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "profile";
        $studentRoll = $this->session->userdata('rollNumber');

        $response['basic_details'] = fetch_single_row('student_details', '', array('rollNumber' => $this->studentRoll));
        //$response['hostel_details'] = fetch_single_value('student_hostel', 'house',array('rollNumber'=>$studentRoll));
        //pr($response['basic_details']);
        $response['page_title'] = "";

        renderViews(array('front/template1/header' => $response, 'front/template1/student/profile' => '', 'front/template1/footer' => ''));
    }

    function general() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "general";
        renderViews(array('front/template1/header' => $response, 'front/template1/student/general' => '', 'front/template1/footer' => ''));
    }

    function fees() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "fees";
        $response['front_fee_details'] = fetch_all_data('student_session_fees', '', array('rollNumber' => $this->studentRoll), '', 'created_at desc');
        //pr($response['front_fee_details']);
        renderViews(array('front/template1/header' => $response, 'front/template1/student/session_fees' => '', 'front/template1/footer' => ''));
    }

    function invoice() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "fees";
        $response['front_fee_details'] = fetch_all_data('student_session_fees', '', array('rollNumber' => $this->studentRoll), '', 'created_at desc');
        //pr($response['front_fee_details']);
        renderViews(array('front/template1/header' => $response, 'front/template1/student/print_invoice' => '', 'front/template1/footer' => ''));
    }

    function leave() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "leave";
        $response['front_menu_ay'] = trim($this->uri->segment(3));
        $response['accademicSessionId'] = getAccademicSessionId( $response['front_menu_ay']);
        $response['front_leave_details'] = fetch_all_data('student_leave', '', 
                array('rollNumber' => $this->studentRoll,'accademicSession'=>$response['accademicSessionId']), '', 'leaveDate desc');

        renderViews(array('front/template1/header' => $response, 'front/template1/student/leave' => '', 'front/template1/footer' => ''));
    }

    function events() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "event";
        $response['front_menu_ay'] = trim($this->uri->segment(3));
        $response['accademicSessionId'] = getAccademicSessionId( $response['front_menu_ay']);
        $response['front_attendance_details'] = fetch_all_data('student_attendance', '', array('rollNumber' => $this->studentRoll
                ,'accademicSession'=>$response['accademicSessionId']), '', 'attendanceDate desc');
        $response['event_calender_flag'] = 1;
        renderViews(array('front/template1/header' => $response, 'front/template1/student/event-calender' => '', 'front/template1/footer' => ''));
    }
    
    function achievements() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "achievements";
        $response['front_menu_ay'] = trim($this->uri->segment(3));
        $response['accademicSessionId'] = getAccademicSessionId( $response['front_menu_ay']);
        $this->load->model('modelstudent');
        $response['front_action_details'] = $this->modelstudent->getAchievements($this->studentRoll,$response['accademicSessionId']);

        renderViews(array('front/template1/header' => $response, 'front/template1/student/school_achievements' => '', 'front/template1/footer' => ''));
    }

    function eventjsonold() {
        $out = array();
        $fromDate = $this->input->get('from');
        $toDate = $this->input->get('to');
        if(!empty($fromDate) && !empty($toDate))
        {
            $fromDate = $fromDate/1000;
            $toDate = $toDate/1000;
        }
        
        
        $this->load->model('modelstudent');
        $getEventData = $this->modelstudent->getSchoolEventsData($fromDate,$toDate);
        
        
        for ($i = 1; $i <= 15; $i++) {  //from day 01 to day 15
            $data = date('Y-m-d', strtotime("+" . $i . " days"));
            $out[] = array(
                'id' => $i,
                'title' => 'Event name ' . $i,
                'url' => '#',
                'class' => 'event-important',
                'start' => strtotime($data) . '000',
                'end' => strtotime($data) . '000'
            );
        }

        echo json_encode(array('success' => 1, 'result' => $out));
        exit;
    }
    
    function eventjson() {
    $out = array();
        $fromDate = $this->input->get('from');
        $toDate = $this->input->get('to');
        if(!empty($fromDate) && !empty($toDate))
        {
            $fromDate = $fromDate/1000;
            $toDate = $toDate/1000;
        }
        $response['front_menu_ay'] = trim($this->uri->segment(3));
        $response['accademicSessionId'] = getAccademicSessionId( $response['front_menu_ay']);
        
        $this->load->model('modelstudent');
        $getEventData = $this->modelstudent->getSchoolEventsData($fromDate,$toDate,$response['accademicSessionId']);
        if(!empty($getEventData)){
        for ($i = 0; $i <count($getEventData); $i++) {

            $out[] = array(
                'id' => $getEventData[$i]['id'],
                'title' =>  $getEventData[$i]['title'],
                'url' => BASEURL.'student/event/details/'.$getEventData[$i]['id'],
                'class' => 'event-important',
                'start' => strtotime($getEventData[$i]['startDate']) . '000',
                'end' => strtotime($getEventData[$i]['endDate']) . '000'
            );
        }
        echo json_encode(array('success' => 1, 'result' => $out));
        exit;
        }
        else{
        echo json_encode(array('success' => 1, 'result' => []));
        exit;
        }
    }
    
    function eventDetails() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "event";
        $eventId = trim($this->uri->segment(4));
        $response['event_details'] = fetch_single_row('school_events', '', array('id' => $eventId));
        //pr($response['event_details']);
        //$response['event_calender_flag'] = 1;
        renderViews(array('front/template1/header' => $response, 'front/template1/student/event-details' => '', 'front/template1/footer' => ''));
    }
    
    function action() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "disciplinary";
        $response['front_menu_ay'] = trim($this->uri->segment(3));
        $response['accademicSessionId'] = getAccademicSessionId( $response['front_menu_ay']);
        $response['front_action_details'] = fetch_all_data('student_comment', '', 
                array('rollNumber' => $this->studentRoll,'accademicSession'=>$response['accademicSessionId']), '', 'created_at desc');

        renderViews(array('front/template1/header' => $response, 'front/template1/student/disciplinary_action' => '', 'front/template1/footer' => ''));
    }

    function marks() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "marks";
        $this->load->model('modelstudent');
        error_log("student roll === " . $this->studentRoll);
        $response['front_exam_details'] = $this->modelstudent->getExams($this->studentRoll);

        //= fetch_all_data('student_marks', '',array('rollNumber'=>),'','created_at desc');
        renderViews(array('front/template1/header' => $response, 'front/template1/student/marks' => '', 'front/template1/footer' => ''));
    }

    function markDetails() {
        $response['marksId'] = trim($this->uri->segment(3));
        $response['exam'] = fetch_single_value('student_marks', 'exam', array('marksId' => $response['marksId']));
        $response['front_marks_details'] = fetch_all_data('student_marks', '', array('exam' => $response['exam'], 'rollNumber' => $this->studentRoll), '', 'created_at desc');

        if (!empty($response['front_marks_details'])) {
            $response['page_title'] = "";
            $response['menu_details'] = "student";
            $response['front_menu_details'] = "marks";
            $this->load->model('modelstudent');
            $response['front_exam_details'] = $this->modelstudent->getExams($this->studentRoll);

            //pr($response['front_marks_details']);
            renderViews(array('front/template1/header' => $response, 'front/template1/student/mark_details' => '', 'front/template1/footer' => ''));
        } else {
            redirect(BASEURL . 'student/marks');
        }
    }

    function routine() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "routine";
        renderViews(array('front/template1/header' => $response, 'front/template1/student/routine' => '', 'front/template1/footer' => ''));
    }

    function notes() {
        $response['page_title'] = "";
        $response['menu_details'] = "student";
        $response['front_menu_details'] = "notes";
        $response['front_menu_ay'] = trim($this->uri->segment(3));
        $response['accademicSessionId'] = getAccademicSessionId( $response['front_menu_ay']);
        $response['front_action_details'] = fetch_all_data('student_notes', '', 
                array('rollNumber' => $this->studentRoll,'accademicSession'=>$response['accademicSessionId']), '', 'created_at desc');
        //pr($response['front_fee_details']);
        renderViews(array('front/template1/header' => $response, 'front/template1/student/school_note' => '', 'front/template1/footer' => ''));
    }
}
