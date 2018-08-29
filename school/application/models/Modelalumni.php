<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelalumni extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function addEvent($user)
    {
                $user_id = $this->session->userdata('loggedinuserid');
                $param['event_name'] = trim($user['event_name']);
                $param['event_description'] = $user['event_description'];
                $param['location'] = $user['event_location'];
                $param['event_start_date'] =  date("Y-m-d", strtotime($user['event_start_date']));
                $param['event_end_date'] = date("Y-m-d", strtotime($user['event_end_date']));
                $param['event_link'] = strtolower(preg_replace("/[^a-zA-Z]/", "", $param['event_name']));
                $param['created_by'] = $user_id;
                $param['modified_by'] = $user_id;               
                $param['created_date'] = date ('Y-m-d H:i:s');
                $param['modified_date'] = date ('Y-m-d H:i:s');

                $this->db->insert('alumni_events', $param);
                $events_id = $this->db->insert_id();

                if($events_id)
                {
                    return $events_id;
                }
                return FALSE;   
    } 

            public function editEvent($user)
            {
                $user_id = $this->session->userdata('loggedinuserid');
                $event_id = $user['event_id'];
                $param['event_name'] = $user['event_name'];
                $param['event_link'] = strtolower(preg_replace("/[^a-zA-Z]/", "", $param['event_name']));
                $param['event_description'] = $user['event_description'];
                $param['location'] = $user['event_location'];
                $param['event_start_date'] =  date("Y-m-d", strtotime($user['event_start_date']));

                $param['event_end_date'] = date("Y-m-d", strtotime($user['event_end_date']));
                //pr($param['event_start_date']);
                $param['modified_by'] = $user_id;               
                $param['modified_date'] = date ('Y-m-d H:i:s');
 

                $this->db->where('id', $event_id);
                $this->db->update('alumni_events', $param);
                $event_id = $this->db->affected_rows();
                if($event_id)
                {
                    return $event_id;
                }
                return FALSE;   
            } 
            
            public function display_event_list()
            {
                $select_arr = array('alumni_events.id as event_id','alumni_events.location','alumni_events.event_name',
                    'alumni_events.event_description','alumni_events.event_start_date','alumni_events.event_link');
                $this->db->select($select_arr);
                $this->db->from('alumni_events'); 
                $this->db->where('alumni_events.event_start_date >= ', date('Y-m-d'));
                //$this->db->where('alumni_events.event_start_date <= ', $end_date);  
               // $this->db->where('alumni_events.event_start_date >= ', $start_date);
                //$this->db->or_where('alumni_events.event_start_date <= ', $end_date);  
                //$this->db->where("alumni_events.event_start_date BETWEEN '$start_date' AND '$end_date'");
                //$this->db->or_where("alumni_events.event_end_date BETWEEN '$start_date' AND '$end_date'");
                $this->db->order_by('alumni_events.event_start_date asc ');
                
                $query = $this->db->get();
                
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function addDonation($user)
            {
                /*$user_id = $this->session->userdata('loggedinuserid');
                if($user_id != '')
                {
                    $param['user_id'] = $user_id;
                }
                else
                {
                    $param['user_id'] = '';*/
                    $param['first_name'] = $user['donor_first_name'];
                    $param['last_name'] = $user['donor_last_name'];
                    $param['email_id'] =  $user['donor_email'];
                    $param['phone_no'] = $user['donor_phone'];
                    $param['address'] = $user['donor_address'];
                    $param['additional_note'] = $user['donor_notes'];
                    $param['amount'] = $user['donor_amount'];

                    $param['created_date'] = date ('Y-m-d H:i:s');
                    $param['modified_date'] = date ('Y-m-d H:i:s');

                    $this->db->insert('alumni_donation', $param);
                    $donation_id = $this->db->insert_id();

                    if($donation_id)
                    {
                        return $donation_id;
                    }
                    return FALSE; 
                 
    } 
    
            public function alumniEventMap($user)
            {
                
                    $param['event_id'] = $user['event_id'];
                    $param['user_id'] = $user['user_id'];
                    $param['user_email'] =  $user['user_email'];
                    
                    $param['created_date'] = date ('Y-m-d H:i:s');
                    $param['modified_date'] = date ('Y-m-d H:i:s');

                    $this->db->insert('alumni_event_map', $param);
                    $alumnieventsmap_id = $this->db->insert_id();

                    if($alumnieventsmap_id)
                    {
                        return $alumnieventsmap_id;
                    }
                    return FALSE; 
                 
            } 
            
    public function display_alumni_course($user_id='',$existing_courses='')
    {
        if(!empty($user_id))
        {
            $select_arr = array('courses.course_link','courses.drive_name','courses.details','courses.program_name');
            $this->db->select($select_arr);
            $this->db->from('courses'); 
            //$this->db->join('candidate_details', 'candidate_details.course_id = courses.id','left');
        
        
            $this->db->where_not_in('courses.id', $existing_courses);
            $this->db->where('courses.status', 1);
            $this->db->where('courses.form_submission_last_date >= ', date('Y-m-d'));
            $this->db->where('courses.form_issuance_date <= ',  date('Y-m-d'));
        }
        else 
        {
            $select_arr = array('courses.course_link','courses.drive_name','courses.details','courses.program_name');
            $this->db->select($select_arr);
            $this->db->from('courses'); 
        
            $this->db->where('courses.status', 1);
            $this->db->where('courses.form_submission_last_date >= ', date('Y-m-d'));
            $this->db->where('courses.form_issuance_date <= ',  date('Y-m-d'));

        }

        $query = $this->db->get();
        
        $result_arr = $query->result_array();
        if(!empty($result_arr))
        {
            //pr($result_arr);
             return $result_arr;
        }
        return FALSE;

    }
    
    public function display_alumni_birthday()
    {
        $select_arr = array('candidate_details.date_of_birth','candidate_details.middle_name','candidate_details.first_name','candidate_details.last_name','candidate_details.email_id');
        $this->db->select($select_arr);
        $this->db->from('users'); 
        $this->db->join('candidate_details', 'candidate_details.email_id = users.email_id');
        $this->db->where('users.icam_portal_alumni_flag', 1);
        
        $where = " MONTH(candidate_details.date_of_birth) = MONTH(NOW()) AND DAY(candidate_details.date_of_birth) = DAY(NOW())";

        $this->db->where($where);
        

        $query = $this->db->get();
        

        $result_arr = $query->result_array();
        //echo ($this->db->last_query());
        if(!empty($result_arr))
        {
             return $result_arr;
        }
        return FALSE;

    }


}
       

?>