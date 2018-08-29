<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class Alumniregistration extends CI_Controller {

    public function index()
    {
        uservalidate();
        $response['page_title']="";
        $response['course_link'] = trim($this->uri->segment(3));
        $response['course_id'] = fetch_single_value('courses', 'id', array('course_link'=>$response['course_link']));
        if(!empty($response['course_id']))
        {
            $already_on_course = fetch_single_row('candidate_details', '', array('course_id'=>$response['course_id']));
            if(!empty($already_on_course))
            {
                redirect(BASEURL.'dashboard');
            }
            $user_id = $this->session->userdata('loggedinuserid');
            $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,'id'=>$user_id));

            $alumni_candidate_details = fetch_single_row('candidate_details', array('candidate_details.id','candidate_details.course_id','candidate_details.first_name','candidate_details.middle_name',
                'candidate_details.last_name','candidate_details.profile_picture','candidate_details.date_of_birth','candidate_details.sex','candidate_details.marrital_status',
                'candidate_details.contact_number','candidate_details.email_id','candidate_details.form_flag',
                'candidate_details.interview_ready_flag','candidate_details.interview_schedule_flag','candidate_details.scrutiny_flag',
                'candidate_details.selected_flag','candidate_details.pan_card_no','candidate_details.adhar_card_no','candidate_details.voter_card_no','candidate_details.passport_no'
                ,'candidate_details.professional_qualification','candidate_details.competitive_exams','candidate_details.competative_exam_score','candidate_details.academic_or_cocurricular_achievements',
                'candidate_details.professional_experience','candidate_details.professional_achievements'
                ,'candidate_details.interview_preferred_location'),array('user_id'=>$user_id));
            $response['alumni_candidate_details'] = $alumni_candidate_details ;
            //pr($response['candidate_details']);
            $course_details = fetch_all_data('courses', array('name','id'));
            $this->load->model('modeluser');

            //$response['course_list'] = $this->modeluser->get_all_course_for_candidate();
            $response['course_list'] = $this->modeluser->checkPassoutdate();
            //pr($response['course_list']);
            if(!empty($response['course_list']))
            {
                foreach ($response['course_list'] as $single_course_display) {
                    $single_course_display_arr['all_details'] = $single_course_display;
                    $single_course_display_arr['status'] = user_display_status($single_course_display);
                    $display_user_data[] = $single_course_display_arr;
                    unset($single_course_display_arr);
                }
                $response['user_course_list'] = $display_user_data;
            }


            //$response['course_id'] = $candidate_details['course_id'];
            $course_details = fetch_single_row('courses','', array('id'=>$response['course_id']));
            $response['course_name'] = $course_details['drive_name'];
            $response['course_details_display'] = $course_details;
            $response['application_id'] = fetch_single_value('candidate_courses_map', 'id',array('candidate_id'=>$response['alumni_candidate_details']['id']));
            //pr( $response['application_id'] );
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));
            $response['address_list'] = fetch_single_row('address','', array('candidate_id'=>$response['alumni_candidate_details']['id']));
            //$response['address_list'] = fetch_all_data('address','', array('candidate_id'=>$response['alumni_candidate_details']['id']));
            $response['qualification_details'] = fetch_all_data('qualification_details', '' ,array('candidate_id'=>$response['alumni_candidate_details']['id']));
            $response['professional_experience_list'] = fetch_all_data('professional_details','', array('candidate_id'=>$response['alumni_candidate_details']['id']));
            $response['venue_list'] = fetch_all_data('candidate_venue_list','',array('drive_id'=> $response['course_id']));

            $response['user_registration_flag']=1;
            //$response['course_name']= trim($this->uri->segment(3));
            renderViews(array('front/template1/header'=>$response,'front/template1/registration/alumni_registration'=>'','front/template1/footer'=>''));
        }
        else 
        {
            redirect(BASEURL.'alumni');
        }
    }
  }
?>