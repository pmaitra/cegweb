<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelemailtemplate extends CI_Model{
    function __construct(){
        parent::__construct();
    }
        public function addEmailTemplates($user)
        {
            $param['subject'] = $user['email_subject'];
            $param['email_header'] = ' ';
            $param['body'] = $user['email_body'];
            $param['email_footer'] = $user['email_footer'];
            
            $param['created_date'] = date ('c');

            $this->db->insert('email_templates', $param);
            $email_templates_id = $this->db->insert_id();

            if($email_templates_id)
            {
                return $email_templates_id;
            }
            return FALSE;      

        }

        public function editEmailTemplates($user)
        {
            $param['subject'] = $user['email_subject'];
            $param['body'] = $user['email_body'];
            //pr($user['email_body']);
            $param['email_footer'] = $user['email_footer'];
            
            $param['modified_date'] = date ('c');

            $this->db->where('id', $user['email_temp_id']);
            $this->db->update('email_templates', $param);
            $email_id = $this->db->affected_rows();

            if($email_id)
            {
                return $email_id;
            }
            return FALSE;      

        }

        public function addEvent($user)
        {
            $param['event_name'] = $user['event_name'];
            
            $param['created_date'] = date ('c');

            $this->db->insert('email_trigger_events', $param);
            $event_id = $this->db->insert_id();

            if($event_id)
            {
                return $event_id;
            }
            return FALSE;      

        }

        public function editEvent($user)
        {
            $param['event_name'] = $user['event_name'];
            
            $param['modified_date'] = date ('c');

            $this->db->where('id', $user['event_id']);
            $this->db->update('email_trigger_events', $param);
            $event_id = $this->db->affected_rows();

            if($event_id)
            {
                return $event_id;
            }
            return FALSE;      

        }

        public function addEventTemplateMap($user)
        {
            $param['email_template_id'] = $user['template_name'];
            $param['event_id'] = $user['event_name'];
            
            $param['created_date'] = date ('c');

            $this->db->insert('email_template_event_map', $param);
            $event_id = $this->db->insert_id();

            if($event_id)
            {
                return $event_id;
            }
            return FALSE;      

        }

        public function addSenderReceverMap($user)
        {
            $param['template_id'] = $user['template_id'];
            $param['sender_email_id'] = $user['sender_email'];
            $param['sender_name'] = $user['sender_name'];
            $param['receiver_name'] = $user['recipient'];
            $param['receiver_email_id'] = '';
            
            $param['created_date'] = date ('c');

            $this->db->insert('email_template_sender_receiver_map', $param);
            $event_id = $this->db->insert_id();

            if($event_id)
            {
                return $event_id;
            }
            return FALSE;      

        }

        public function updateEvents($event_id)
        {
            $param['status'] = 1;
            
            $param['modified_date'] = date ('c');

            $this->db->where('id', $event_id);
            $this->db->update('email_trigger_events', $param);
            $trigger_id = $this->db->affected_rows();

            if($trigger_id)
            {
                return $trigger_id;
            }
            return FALSE;      

        }

        public function updateTemplates($template_id)
        {
            $param['status'] = 1;
            
            $param['modified_date'] = date ('c');

            $this->db->where('id', $template_id);
            $this->db->update('email_templates', $param);
            $templateId = $this->db->affected_rows();

            if($templateId)
            {
                return $templateId;
            }
            return FALSE;      

        }


        public function display_email_template_mapping_list()
        {
            $select_arr = array('email_trigger_events.event_name ','email_template_event_map.created_date ','email_template_event_map.id','email_templates.subject');
            $this->db->select($select_arr);
            $this->db->from('email_template_event_map');
            $this->db->join('email_trigger_events', 'email_template_event_map.event_id = email_trigger_events.id'); 
            $this->db->join('email_templates', 'email_template_event_map.email_template_id   = email_templates.id'); 
            //$this->db->where('candidate_details.user_id', $user_id);

            $query = $this->db->get();
            $result_arr = $query->result_array();
            //pr($result_arr);
            if(!empty($result_arr))
            {
                 return $result_arr;
            }
            return FALSE;
        }

    }
       

?>
