<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modeluser extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    public function validate($user){
        // grab user input
        $username = $user['username'];
        $password = $user['password'];

        $this->db->SELECT(array('id as userid'));
        //$this->db->where('username', $username);
        $this->db->where('email_id', $username);
        $this->db->where('password', md5($password));
        $this->db->where('status', '1');

        // Run the query
        $query = $this->db->get('users');
        
        //echo $this->db->last_query();die;
        // Let's check if there are any results
        if($query->num_rows() == 1)
        {
            // If there is a user, then create session data
            $row = $query->row(); 
            //Role validation
            //if($row->user_type =='customer' )
            //{               
               $login_data = array('loggedinusername'=>$username,
                   'loggedinuserid'=>$row->userid);                                    
            //}
            //else 
            //{
                
            //}
            
            $this->session->set_userdata($login_data);

            $param = array(               
               'login_time'=>date("Y-m-d H:i:s"),
               'user_id'=>$row->userid
            );
            $this->db->insert('user_login_history', $param);
            return true;
        }
        // If the previous process did not validate
        // then return false.
        return false;
    }
    
    public function passwordChange($user) 
    {

        $param['password'] = $user['new_password'];
        $param['modified_date'] = date ('c');
	$username = $this->session->userdata('loggedinusername');
	$this->db->where('email_id', $username);
               $this->db->update('users', $param);
               $userid = $this->db->affected_rows();

       if(!empty($userid))
        {
           //$this->service_company_id_update($service_company_id);
           return $userid;
        }
       return FALSE;
   }
   
	   public function checkOldPass($old_password)
	   {
		   $param['password'] = $old_password;
		   $username = $this->session->userdata('loggedinusername');
		   
			$this->db->SELECT(array('id as userid'));
			$this->db->where('password', $param['password']);
		   $this->db->where('email_id', $username);
		   $this->db->where('status', '1');
		   
		   $query = $this->db->get('users');
		   //echo $this->db->last_query();die;
		   if($query->num_rows() == 1)
			{
				return TRUE;
				
			}
                        
		   return FALSE;
	 
            }
            
            public function addAddress($user)
            {
                $username = $this->session->userdata('loggedinusername');
                $user_id = fetch_single_value('users', 'id',array('username'=>$username));          
                $candidate_id = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));

                $param['candidate_id'] = $candidate_id;
                $param['mobile_no'] = $user['contact_no_1'];
                $param['street_address'] = $user['street_address_1'];
                $param['address_line_2'] = $user['address_line2_1'];
                $param['city'] = $user['city_1'];
                $param['state'] = $user['state_1'];
                $param['postal_code'] = $user['postal_code_1'];
                $param['country_id'] = $user['country_1'];
                $param['created_by'] = $user_id;
                $param['created_date'] = date ('c');

                $this->db->insert('address', $param);
                $address_id = $this->db->insert_id();

                if($address_id)
                {
                    return $address_id;
                }
                return FALSE;      

            }
		
}
       

?>