<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelalumniutility extends CI_Model{
    function __construct(){
        parent::__construct();
    }

        public function addNewUser($user)
        {
            $param['username'] = $user['email_id'];
            $param['email_id'] = $user['email_id'];
            $param['password'] = $user['password'];
            $param['first_name'] = $user['first_name'];
            $param['middle_name'] = $user['middle_name'];
            $param['last_name'] = $user['last_name'];
            $param['status'] = 1;
            $param['alumni_status'] = 1;

            $param['created_date'] = date ('Y-m-d H:i:s');
            //pr('hi');
            $alunmi_db = $this->load->database('alumni_primary', TRUE);
            $alunmi_db->insert('users', $param);
            $user_id = $alunmi_db->insert_id();

            if(!empty($user_id))
            {   
                //Adding user to group
                $group_param['group_id'] = fetch_single_value('groups', 'id', array('group_name'=>ALUMNI_MEMBER),ALUMNI_DB);
                $group_param['user_id'] = $user_id;
                $alunmi_db->insert('user_groups_map', $group_param);
                return $user_id;
            }
            return FALSE;

        } 

        public function updateUser($user_id,$user_details,$status)
        {
            $param['status'] = $status;
            $param['alumni_status'] = $status;
            
            $param['modified_date'] = date ('Y-m-d H:i:s');
            $alunmi_db = $this->load->database(ALUMNI_DB, TRUE);
            $alunmi_db->where('id', $user_id);
            $alunmi_db->update('users', $param);
            $user_id = $alunmi_db->affected_rows();

            if($user_id)
            {
                return $user_id;
            }
            return FALSE;

        } 

        public function alumniStatusSelection($user,$alumniflag)
        {
            //$user_id = $this->session->userdata('loggedinuserid');
            
            $param['alumni_status'] = $alumniflag;
            $param['modified_date'] = date ('Y-m-d H:i:s');

            $this->db->where('id', $user);
            $this->db->update('users', $param);
            $user_id = $this->db->affected_rows();

            if($user_id)
            {
                return $user_id;
            }
            return FALSE;   
        }

    }
       

?>