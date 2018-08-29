<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelfeedback extends CI_Model{

	public function addFeedback($user)  
    {
        $username = $this->session->userdata('loggedinusername');
        $user_id = fetch_single_value('users', 'id',array('username'=>$username));          
        $candidate_id = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));

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

} 
?>