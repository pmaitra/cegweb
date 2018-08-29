<?php

    class User extends CI_Controller {

        function __construct() 
        {
            parent::__construct();
            uservalidate();
        }

	function index()
	{
	    
            
	    $response['page_title']="";
            $response['country_list'] = fetch_all_data('countries', array('id', 'name'));

            $username = $this->session->userdata('loggedinusername');
            $user_id = fetch_single_value('users', 'id',array('username'=>$username));          
            $candidate_id = fetch_single_value('candidate_details', 'id',array('user_id'=>$user_id));

            $response['address_list'] = fetch_all_data('address','', array('candidate_id'=>$candidate_id));

            renderViews(array('front/template1/header'=>$response,'front/template1/user/changepassword'=>'','front/template1/footer'=>''));

            
	   
           
	}

	public function changePasswordSubmit()
        {
			
            $response['page_title']="";             
            $this->load->library('form_validation');             
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

            if ($this->form_validation->run() == FALSE)
            {
                renderViews(array('front/template1/header'=>$response,'front/template1/user/changepassword'=>'','front/template1/footer'=>''));
            }
            else
            {
                $old_password = md5($this->input->post('old_password'));
				//pr($old_password);
                $postdata['new_password'] = md5($this->input->post('new_password'));
				//pr($postdata);
		$confirm_password = md5($this->input->post('confirm_password'));
				//pr($confirm_password);
				
		$this->load->model('modeluser');
		if($this->modeluser->checkOldPass($old_password) == "TRUE")
		{
                    $result = $this->modeluser->passwordChange($postdata);
                    if(!empty($result))
                    {
                        redirect(BASEURL.'dashboard');
                    }
                    else 
                    {
                        $response['error_message'] = 'Please give the valid credential !!';
                        renderViews(array('changePass/index'=>$response));
                    }
                }
                else
                {
                    $response['error_message'] = 'Please give the valid credential !!';
                    return FALSE;
                }
            }

        }
        
        public function submitaddress()
        {
                
                $this->load->helper('security');


                $user['contact_no_1'] = trim($this->input->post('contact_no_1', true));
                $user['street_address_1'] = trim($this->input->post('street_address_1', true));
                $user['address_line2_1'] = trim($this->input->post('address_line2_1', true));
                $user['city_1'] = trim($this->input->post('city_1', true));
                $user['state_1'] = trim($this->input->post('state_1', true));
                $user['postal_code_1'] = trim($this->input->post('postal_code_1', true));
                $user['country_1'] = trim($this->input->post('country_1', true));

                $this->load->model('modeluser');
                $result = $this->modeluser->addAddress($user);
                if($result)
                {
                        $success_msg['responseCode']=200;
                        $success_msg['message']='success';
                        $success_msg['restult']=  $result;
                        print_r(json_encode($success_msg));
                        exit();

                }
                else
                {
                        $error_msg['responseCode']=406;
                        $error_msg['message']='error';
                        $error_msg['restult']='';
                        print_r(json_encode($error_msg));
                        exit();

                }

        }

	}