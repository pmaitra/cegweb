public function printInvoice()
        {
            $response['page_title']="";
            $applicant_id = 33;
            $response['applicant_id'] = $applicant_id;
            $candidate_id = fetch_single_value('candidate_courses_map', 'candidate_id', array('id'=>$applicant_id));

            $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('id'=>$candidate_id));

            $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');
            
            renderViews(array('home/print_invoice'=>$response));

        }

        public function loginprintInvoice()
        {
            uservalidate();
            $response['page_title']="";
            $user_id = $this->session->userdata('loggedinuserid');

            $response['candidate_details'] = fetch_single_row('candidate_details', array('id','first_name' , 'middle_name' , 'last_name' , 'contact_number' , 'email_id' , 'payment_flag') , array('user_id'=>$user_id));
            //$candidate_id = fetch_single_value('candidate_details', 'id', array('user_id'=>$user_id));
            $candidate_id = $response['candidate_details']['id'];
            $applicant_id = fetch_single_value('candidate_courses_map', 'id', array('candidate_id'=>$candidate_id));
            
            $response['candidate_address'] = fetch_single_row('address' , array('street_address','address_line_2','city','state','postal_code','country_id') , array('candidate_id'=>$candidate_id),'','created_by asc');

            //pr($response['candidate_address']);
            //pr($response);
            

            if($response['candidate_details']['payment_flag'] == 1)
            {
                $response['applicant_id'] = $applicant_id;
                renderViews(array('home/print_invoice'=>$response));
            }
            else
            {
                pr("hi");

                renderViews(array('home/print_invoice'=>$response));
            }

        }

