<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelfeedback extends CI_Model{

	public function addFeedback($user)  
    {
        $username = $this->session->userdata('loggedinusername');
        $user_id = fetch_single_value('users', 'id',array('username'=>$username));          
        $candidate_id = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));
        $param['course_id'] = $user['course_id'];
        $param['candidate_id'] = $candidate_id;
        $param['teacher_id'] = 0;
        $param['user_id'] = $user_id;
        $param['feedback'] = $user['feedback'];
        $param['created_date'] = date ('c');
        $param['modified_date'] = date ('c');
        
        $this->db->insert('user_feedback', $param);
        $feedbackid = $this->db->insert_id();

        if($feedbackid)
        {
            return $feedbackid;
        }
        return FALSE;      

    }

    public function addTeacherFeedback($user)  
    {
        $username = $this->session->userdata('loggedinusername');
        $user_id = fetch_single_value('users', 'id',array('username'=>$username));          

        $param['course_id'] = $user['course_id'];
        $param['candidate_id'] = 0;
        $param['teacher_id'] = $user_id;
        $param['user_id'] = $user_id;
        $param['feedback'] = $user['feedback'];
        $param['created_date'] = date ('c');
        $param['modified_date'] = date ('c');
        
        $this->db->insert('user_feedback', $param);
        $feedbackid = $this->db->insert_id();

        if($feedbackid)
        {
            return $feedbackid;
        }
        return FALSE;      

    }

    public function display_course_list_for_user($user_id)
    {
        $select_arr = array('courses.drive_name ','courses.name ','courses.id ');
        $this->db->select($select_arr);
        $this->db->from('candidate_details');
        $this->db->join('courses', 'courses.id = candidate_details.course_id'); 
        $this->db->where('candidate_details.user_id', $user_id);

        $query = $this->db->get();
        $result_arr = $query->result_array();
        //pr($result_arr);
        if(!empty($result_arr))
        {
             return $result_arr;
        }
        return FALSE;
    }

    public function display_course_list_for_teacher($user_id)
    {
        $select_arr = array('courses.drive_name ','courses.name ','courses.id ','courses.course_link ');
        $this->db->select($select_arr);
        $this->db->from(' teacher_candidate_map');
        $this->db->join('courses', 'courses.id =  teacher_candidate_map.course_id'); 
        $this->db->where('teacher_candidate_map.teacher_id', $user_id);
        $this->db->group_by('teacher_candidate_map.teacher_id');

        $query = $this->db->get();
        $result_arr = $query->result_array();
        //pr($result_arr);
        if(!empty($result_arr))
        {
             return $result_arr;
        }
        return FALSE;
    }

    public function display_user_feedback_list()
    {
        $select_arr = array('candidate_details.first_name','candidate_details.middle_name', 'candidate_details.last_name','users.first_name as user_first_name','users.middle_name as user_middle_name', 'users.last_name as user_last_name','courses.drive_name','courses.name','courses.program_name','user_feedback.user_id','user_feedback.created_date','user_feedback.id','user_feedback.candidate_id','user_feedback.teacher_id');
        $this->db->select($select_arr);
        $this->db->from('user_feedback');
        $this->db->join('candidate_details', 'candidate_details.id = user_feedback.candidate_id');
        $this->db->join('courses', 'courses.id = user_feedback.course_id');
        $this->db->join('users', 'users.id = user_feedback.user_id'); 
        $this->db->where('user_feedback.teacher_id', '0');

        $query = $this->db->get();
        
        $result_arr = $query->result_array();

        if(!empty($result_arr))
        {
             return $result_arr;
        }
        return FALSE;

    }

    public function display_teacher_feedback_list()
    {
        $select_arr = array('users.first_name as user_first_name','users.middle_name as user_middle_name', 'users.last_name as user_last_name','courses.drive_name','courses.name','courses.program_name','user_feedback.user_id','user_feedback.created_date','user_feedback.id','user_feedback.candidate_id','user_feedback.teacher_id');

        $this->db->select($select_arr);
        $this->db->from('user_feedback');
        //$this->db->join('candidate_details', 'candidate_details.id = user_feedback.candidate_id');
        $this->db->join('courses', 'courses.id = user_feedback.course_id');
        $this->db->join('users', 'users.id = user_feedback.user_id'); 
        $this->db->where('user_feedback.candidate_id', 0);
        $this->db->where('user_feedback.teacher_id > ', 0);

        $query = $this->db->get();
        //echo $this->db->last_query();
        $result_arr = $query->result_array();

        if(!empty($result_arr))
        {
             return $result_arr;
        }
        return FALSE;

    }

} 
?>