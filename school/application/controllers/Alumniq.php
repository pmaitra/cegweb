<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni extends CI_Controller {

      public function index()
      {
          $response['alumni_flag'] ='';
          $user_id = $this->session->userdata('loggedinuserid');
          $this->load->model('modelalumni');

          $response['event_list'] = $this->modelalumni->display_event_list();
          
          //$response['drive_details'] = fetch_all_data('courses', array('course_link','drive_name','details','program_name') ,
                  //array('status'=>1,'form_submission_last_date >= ' => date('Y-m-d'),'form_issuance_date <= ' => date('Y-m-d')));
          
          
          if(!empty($user_id))
          {
              $response['existing_courses'] = fetch_single_column('candidate_details', 'course_id',array('user_id'=>$user_id));
              //pr($response['existing_courses']);
              $response['drive_details'] = $this->modelalumni->display_alumni_course($user_id,$response['existing_courses']);
              $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                    'id'=>$user_id));
          }
          else 
          {
              $response['drive_details'] = $this->modelalumni->display_alumni_course();
          }
            renderViews(array('alumni/header'=>$response,'alumni/content'=>'','alumni/footer'=>''));
      }
      
      public function home()
      {
            alumnivalidate();
            $response ='';
            renderViews(array('alumni/header'=>$response,'alumni/content'=>'','alumni/footer'=>''));
      }
      
      /* login*/
        public function ajaxLogin()
        {
                // Update user
                $user['username'] = $this->input->post('username', true);
                $user['password'] = $this->input->post('password', true);
                $this->load->model('modeluser');
                // Validate the user can login
                $result = $this->modeluser->validate($user);
                $get_amumni_flag = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                    'email_id'=>$user['username']));
               // $result = 1;
                if(!empty($result) && $get_amumni_flag == 1)
                {
                    $scucces_msg['responseCode']=200;
                    $scucces_msg['message']='success';
                    $scucces_msg['restult']=$result;
                    print_r(json_encode($scucces_msg));
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
        
      
    function alumnilogout()
    {
        $this->session->unset_userdata('loggedinusername');
        $this->session->sess_destroy();
        redirect(BASEURL.'alumni');
    }
    
    public function contactus()
    {
            $response['page_title'] ='';
            $user_id = $this->session->userdata('loggedinuserid');
            $this->load->model('modelalumni');
            if(!empty($user_id))
            {
                $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                      'id'=>$user_id));
            }
            
            renderViews(array('alumni/header'=>$response,'alumni/contact_us'=>'','alumni/footer'=>''));
    }
    
    public function aboutus()
    {
            $response['page_title'] ='';
            $user_id = $this->session->userdata('loggedinuserid');
            $this->load->model('modelalumni');
            if(!empty($user_id))
            {
                $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                      'id'=>$user_id));
            }
            
            renderViews(array('alumni/header'=>$response,'alumni/about_us'=>'','alumni/footer'=>''));
    }
    
    public function donateUs()
    {
            //alumnivalidate();
            $response['page_title'] ='';
            $user_id = $this->session->userdata('loggedinuserid');
            $this->load->model('modelalumni');
            if(!empty($user_id))
            {
                $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                      'id'=>$user_id));
            }
            $response['donation_list'] = fetch_all_data('alumni_donation');
            renderViews(array('alumni/header'=>$response,'alumni/donation_home'=>'','alumni/footer'=>''));
    }

    public function alumniDonation1()
    {
        $postdata['donor_amount'] = $this->input->post('donor_amount');
        $postdata['donor_first_name'] = $this->input->post('donor_first_name');
        $postdata['donor_email'] = $this->input->post('donor_email');
        $postdata['donor_address'] = $this->input->post('donor_address');
        $postdata['donor_last_name'] = $this->input->post('donor_last_name');
        $postdata['donor_phone'] = $this->input->post('donor_phone');
        $postdata['donor_notes'] = $this->input->post('donor_notes');
        //pr($postdata);

        $this->load->model('modelalumni');
        $resposeData = $this->modelalumni->addDonation($postdata);

            if(!empty($resposeData))
            {   
                $message = 'Thanks for Supporting us.We have received your donation succesfully.';
                $footer = 'iCAM Bhavan, Plot No. 12, Sector - 117, Salt Lake,Kolkata, West Bengal, 700002, India<br />
                <a href="'.BASEURL.'" target="_blank" class="link-1" style="color:#666666; text-decoration:none"><span class="link-1" style="color:#666666; text-decoration:none">www.nism.ac.in</span></a>
                <span class="mobile-block"><span class="hide-for-mobile">|</span></span>
                Phone: <a href="tel:+1655606605" target="_blank" class="link-1" style="color:#666666; text-decoration:none"><span class="link-1" style="color:#666666; text-decoration:none">022 66735100 - 05</span></a>' ;               

                $html_message = general_email_template($postdata['donor_first_name'],$message,'Thank You !',$footer);
                $subject = 'Donation has recieved succesfully';
                send_customer_mail('iCAM Admission',$response['candidate_details']['email_id'],$subject,$message,$html_message);
                
                $this->session->set_flashdata('success_message',  'Donation has received successfully !!');
                $success_msg['responseCode']=200;
                $success_msg['message']='success';
                $success_msg['result']=  $resposeData;
                print_r(json_encode($success_msg));
                exit();
            }
            else
            {
                $this->session->set_flashdata('error_msg',  'Please try again !!');
                $error_msg['responseCode']=406;
                $error_msg['message']='error';
                $error_msg['result']='';
                print_r(json_encode($error_msg));
                exit();
            }
    }
    
    public function alumniDonation()
    {
        $postdata['donor_amount'] = $this->input->post('donor_amount');
        $postdata['donor_first_name'] = $this->input->post('donor_first_name');
        $postdata['donor_email'] = $this->input->post('donor_email');
        $postdata['donor_address'] = $this->input->post('donor_address');
        $postdata['donor_last_name'] = $this->input->post('donor_last_name');
        $postdata['donor_phone'] = $this->input->post('donor_phone');
        $postdata['donor_notes'] = $this->input->post('donor_notes');
        //pr($postdata);

        $this->load->model('modelalumni');
        $responseData = $this->modelalumni->addDonation($postdata);
        //pr($responseData);
            if(!empty($responseData))
            {
                $message = 'Thanks for Supporting us.We have received your donation succesfully.';
                $footer = 'iCAM Bhavan, Plot No. 12, Sector - 117, Salt Lake,Kolkata, West Bengal, 700002, India<br />
                <a href="'.BASEURL.'" target="_blank" class="link-1" style="color:#666666; text-decoration:none">
                    <span class="link-1" style="color:#666666; text-decoration:none">www.nism.ac.in</span></a>
                <span class="mobile-block"><span class="hide-for-mobile">|</span></span>
                Phone: <a href="tel:+1655606605" target="_blank" class="link-1" style="color:#666666; text-decoration:none">
                <span class="link-1" style="color:#666666; text-decoration:none">022 66735100 - 05</span></a>' ;               

                $html_message = general_email_template($postdata['donor_first_name'],$message,'Thank You !',$footer);
                $subject = 'Donation has recieved succesfully';
                 
                //From email templates
                $get_amumni_email = get_email_template_details('Donation');
                
                //pr($get_amumni_email);
                if(!empty($get_amumni_email))
                {
                    $source_var = array("@FirstName","@MiddleName","@LastName","@CourseName","@ApplicationId","@InterviewDate","@LoginLink");
                    $replaced_var = array($postdata['donor_first_name'],"",$postdata['donor_last_name'],"","","",'<a href="'.BASEURL.'"></a>');
                    if(!empty($get_amumni_email['body']))
                    {
                        $message = $get_amumni_email['body'];
                        $message = str_replace($source_var,$replaced_var,$message);
                        if(!empty($get_amumni_email['email_footer']))
                        {
                            $footer = $get_amumni_email['email_footer'];
                            $footer = str_replace($source_var,$replaced_var,$footer);
                        }
                        $html_message = general_email_template($postdata['donor_first_name'],$message,'Thank You !',$footer);
                    }

                    if(!empty($get_amumni_email['subject']))
                    {
                        $subject = $get_amumni_email['subject'];
                        $subject = str_replace($source_var,$replaced_var,$subject);
                    }
                } 
                
                //pr($html_message);
                send_customer_mail('iCAM Admission',$postdata['donor_email'],$subject,$message,$html_message);
                
                $this->session->set_flashdata('success_message',  'Donation has received successfully !!');
                
                $success_msg['responseCode']=200;
                $success_msg['message']='success';
                $success_msg['result']=  $responseData;
                print_r(json_encode($success_msg));
                exit();
            }
            else
            {
                $this->session->set_flashdata('error_msg',  'Please try again !!');
                $error_msg['responseCode']=406;
                $error_msg['message']='error';
                $error_msg['result']='';
                print_r(json_encode($error_msg));
                exit();
            }
    }
    
        public function donationPayments()
    {

        $response['page_title']="";
        $response['donationid']=$donationid=$this->uri->segment(3);
            
            if(!empty($response['donationid']))
            {
                $response['donation_details'] = fetch_single_row('alumni_donation', '' , array('id'=>$response['donationid']));
                //pr($response);
                $amount = $response['amount'] = $response['donation_details']['amount'];
                //pr($amount);
                if(ENVIRONMENT == 'production')
                {
                    $response['return_url'] = BASEURL.'alumni/donationinvoice/'.trim($donationid);
                    $this->load->library('ccavenue/ccavenue');

                    $this->ccavenue->donationSubmission($response);
                }
                else 
                {
                    renderViews(array('alumni/donation_pay'=>$response));
                    //$this->output->set_header('refresh:10; url='.BASEURL.'alumni/donationinvoice/'.trim($donationid));
                    
                }
                
                
                //redirect(BASEURL.'paymentreciept/'.trim($response['donationid']));
            }
    }
    
    public function donationPaymentsInvoice()
    {

        $response['page_title']="";
        $response['donationid']=$donationid=$this->uri->segment(3);
            
            if(!empty($response['donationid']))
            {
                $response['donation_details'] = fetch_single_row('alumni_donation', '' , array('id'=>$response['donationid']));
                //pr($response);
                renderViews(array('alumni/donation_pay'=>$response));
                //redirect(BASEURL.'paymentreciept/'.trim($response['donationid']));
            }
    }
    
    public function events()
    {
            $response['page_title'] ='';
            $user_id = $this->session->userdata('loggedinuserid');
            $this->load->model('modelalumni');
            if(!empty($user_id))
            {
                $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                      'id'=>$user_id));
            }

            $response['event_list'] = $this->modelalumni->display_event_list();
            renderViews(array('alumni/header'=>$response,'alumni/events'=>'','alumni/footer'=>''));
    }
    
    public function singleEvent1()
    {
            //alumnivalidate();
            $response ='';
            $response['event_link'] = trim($this->uri->segment(3));
            $response['event_details'] = fetch_single_row('alumni_events', '', array('status'=>1,"event_link"=>$response['event_link']));
            //$this->load->model('modelalumni');

            //$response['event_list'] = $this->modelalumni->display_event_list();
            if(!empty($response['event_details']))
            {
                renderViews(array('alumni/header'=>$response,'alumni/single_event'=>'','alumni/footer'=>''));
            }
            else 
            {
                 renderViews(array('home/course_not_found'=>$response));
            }
    }
   
    
    public function singleEvent()
    {
            //alumnivalidate();
            $response ='';

            $response['user_id'] = $this->session->userdata('loggedinuserid');
            $response['user_email'] = $this->session->userdata('loggedinusername');
            

            $response['event_link'] = trim($this->uri->segment(3));
            $response['event_details'] = fetch_single_row('alumni_events', '', array('status'=>1,"event_link"=>$response['event_link']));
            //$this->load->model('modelalumni');
            $response['page_title'] ='';
            $user_id = $this->session->userdata('loggedinuserid');
            $this->load->model('modelalumni');
            if(!empty($user_id))
            {
                $response['alumni_flag'] = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                      'id'=>$user_id));
            }
            //$response['event_list'] = $this->modelalumni->display_event_list();
            if(!empty($response['event_details']))
            {
                renderViews(array('alumni/header'=>$response,'alumni/single_event'=>'','alumni/footer'=>''));
            }
            else 
            {
                 renderViews(array('home/course_not_found'=>$response));
            }
    }

    public function joinMe()
    {
        $postdata['event_id'] = $this->input->post('event_id');
        $postdata['user_id'] = $this->input->post('user_id');
        $postdata['user_email'] = $this->input->post('user_email');
        
        $this->load->model('modelalumni');
        $resposeData = $this->modelalumni->alumniEventMap($postdata);
        //pr($resposeData);
            if(!empty($resposeData))
            {
                $this->session->set_flashdata('success_message',  'Event has added successfully !!');
                $success_msg['responseCode']=200;
                $success_msg['message']='success';
                $success_msg['result']=  $resposeData;
                print_r(json_encode($success_msg));
                exit();
            }
            else
            {
                $this->session->set_flashdata('error_msg',  'Please try again !!');
                $error_msg['responseCode']=406;
                $error_msg['message']='error';
                $error_msg['result']='';
                print_r(json_encode($error_msg));
                exit();
            }
    }
    
    public function alumniBirthday()
    {
        $today = date ('y-m-d');
        //echo($today);
        $this->load->model('modelalumni');
        $response['alumni_candidate_list'] = $this->modelalumni->display_alumni_birthday();

        foreach($response['alumni_candidate_list'] as $single_alumni_candidate)
        {

            $message = 'Celebrate being Happy every day. May your birthday and every day be filled with the warmth of sunshine, the happiness of smiles, the sounds of laughter, the feeling of love and the sharing of good cheer.';
            $user_name_display = ucfirst($single_alumni_candidate['first_name']).' '.ucfirst($single_alumni_candidate['middle_name']).' '.ucfirst($single_alumni_candidate['last_name']);
            $html_message = birthday_email_template($user_name_display,$message);
            $subject = 'Happy Birth Day To You.';
                                
            send_customer_mail('iCAM Alumni',$single_alumni_candidate['email_id'],$subject,$message,$html_message);
        }
        //pr($response);
    }
    
}
