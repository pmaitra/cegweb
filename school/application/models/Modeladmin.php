<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modeladmin extends CI_Model{
    function __construct(){
        parent::__construct();
    }

            public function get_all_user()
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->where('payment_flag', '1'); 
                $this->db->where('form_flag >', '3'); 
                $this->db->where('scrutiny_flag <', '2'); 
                $this->db->where('interview_ready_flag', '0');

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            public function get_all_candidate_with_venue()
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id', 'candidate_venue_map.city', 'candidate_venue_map.address');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('candidate_venue_map', 'candidate_venue_map.candidate_id = candidate_details.id');
                //$this->db->where('status', $status); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_user_before_interview_schedule()
            {
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->where('payment_flag', '1'); 
                $this->db->where('form_flag >', '3'); 
                $this->db->where('scrutiny_flag', '1');
                $this->db->where('interview_ready_flag', '1');
                $this->db->where('interview_schedule_flag', '0');
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_user_after_interview_schedule()
            {
               
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_courses_map.id as application_id'
                    ,'candidate_details.scrutiny_flag','candidate_venue_map.city','candidate_venue_map.address','candidate_venue_map.interview_panel',
                    'candidate_venue_map.interview_time');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('candidate_venue_map', 'candidate_venue_map.candidate_id = candidate_details.id');
                $this->db->where('candidate_venue_map.status', '1');
                $this->db->where('payment_flag', '1'); 
                $this->db->where('form_flag >', '3'); 
                $this->db->where('scrutiny_flag', '1');
                $this->db->where('interview_ready_flag', '1');
                $this->db->where('interview_schedule_flag', '1');
                $this->db->where('interview_done_flag <', '1');
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            

            public function addCoupon($user)
            {
                
                $param['course_id'] = $user['route_id'];
                $param['coupon_benifit'] = $user['coupon_benifit'];
                $param['coupon_user_type'] = $user['coupon_user_type'];
                if(!empty($user['user_email']))
                {
                    $param['individual_email'] = $user['user_email'];
                }
                $param['coupon_uses_type'] = $user['coupon_uses_type'];
                $param['no_of_multiple_uses'] = $user['no_of_multiple_uses'];
                $param['coupon_code'] = strtoupper($user['coupon_code']);
                $param['discount_type'] = $user['discount_type'];
                $param['discount_amount'] = $user['discount_amount'];
                $param['minimum_order_value'] = $user['minimum_order_value'];
                $param['valid_from'] = $user['valid_from'];
                $param['valid_till'] = $user['valid_till'];
                $param['created_by'] = 1;
                $param['created_date'] = date ('c');

                $this->db->insert('course_coupons', $param);
                $coupon_id = $this->db->insert_id();

                if($coupon_id)
                {
                    return $coupon_id;
                }
                return FALSE;      

            }

            public function showCouponList()
            {
                $select_arr = array('course_coupons.coupon_code','course_coupons.discount_amount','course_coupons.valid_from','course_coupons.valid_till',
                    'courses.id as applicable_for_route','courses.program_name');
                $this->db->select($select_arr);
                $this->db->from('course_coupons');
                $this->db->join('courses', 'courses.id = course_coupons.course_id');
                
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
            }
            
            public function showPaymentList()
            {
                $select_arr = array('candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','candidate_payment.amount','candidate_payment.application_id','candidate_payment.payment_type',
                    'candidate_payment.payment_fee_type','candidate_payment.created_date','candidate_payment.status',
                    'candidate_payment.coupon_id','courses.program_name');
                $this->db->select($select_arr);
                $this->db->from('candidate_payment');
                $this->db->join('candidate_details', 'candidate_payment.candidate_id = candidate_details.id');
                $this->db->join('courses', 'courses.id = candidate_details.course_id');
                $this->db->order_by('candidate_payment.id', 'desc');
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
            }
            
           
            public function get_event_calendar($start_date,$end_date)
            {
                $select_arr = array('alumni_events.id as event_id','alumni_events.event_name','alumni_events.event_description',
                    'alumni_events.event_start_date','alumni_events.event_end_date');
                $this->db->select($select_arr);
                $this->db->from('alumni_events'); 
                //$this->db->where('alumni_events.event_start_date >= ', $start_date);
                //$this->db->where('alumni_events.event_start_date <= ', $end_date);  
               // $this->db->where('alumni_events.event_start_date >= ', $start_date);
                //$this->db->or_where('alumni_events.event_start_date <= ', $end_date);  
                $this->db->where("alumni_events.event_start_date BETWEEN '$start_date' AND '$end_date'");
                $this->db->or_where("alumni_events.event_end_date BETWEEN '$start_date' AND '$end_date'");
                $this->db->order_by('alumni_events.event_start_date asc ');
                
                $query = $this->db->get();
                
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_state()
            {
                //pr($course_id);
                $select_arr = array('candidate_venue_list.state');
                $this->db->select($select_arr);
                $this->db->from('candidate_venue_list');

                $this->db->group_by('candidate_venue_list.state'); 
                $this->db->order_by('candidate_venue_list.state', 'asc' ); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();
               
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }

             public function get_all_city($state_id='',$user_id ='')
            {
                //pr($course_id);
                $select_arr = array('candidate_venue_list.id as location_id','candidate_venue_list.city','candidate_venue_list.capacity','candidate_venue_list.filled_up_seat','candidate_venue_list.address');
                $this->db->select($select_arr);
                $this->db->from('candidate_venue_list');
                //$this->db->join('teacher_candidate_map', 'teacher_candidate_map.location_id = candidate_venue_list.id');
                
                if(!empty($user_id))
                {
                    $this->db->join('location_panel_map', 'location_panel_map.location_id = candidate_venue_list.id');
                    $this->db->where('location_panel_map.teacher_id',$user_id);
                }
                if(!empty($state_id))
                {
                    $this->db->where('candidate_venue_list.state',$state_id);
                }
                $this->db->group_by('candidate_venue_list.city'); 
                $this->db->order_by('candidate_venue_list.city', 'asc' ); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();
               //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_total_selected_candidate_count($location_id,$user_id ='')
            {
                //pr($course_id);
                $select_arr = array('count(candidate_details.id) as candidate_selected_count');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                //$this->db->join('candidate_venue_map', 'candidate_venue_list.candidate_id = candidate_details.id');
                $this->db->join('teacher_candidate_map', 'candidate_details.id = teacher_candidate_map.candidate_id');
                
                if(!empty($user_id))
                {
                    $this->db->join('location_panel_map', 'location_panel_map.location_id = candidate_venue_list.id');
                    $this->db->where('location_panel_map.teacher_id',$user_id);
                }
                $this->db->where('candidate_details.selected_flag',1);
                $this->db->where('teacher_candidate_map.location_id',$location_id);
                //$this->db->group_by('candidate_venue_list.city'); 
                //$this->db->order_by('candidate_venue_list.city', 'asc' ); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();
               
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            public function get_total_mapped_candidate_count($location_id,$user_id ='')
            {
                //pr($course_id);
                $select_arr = array('count(candidate_id) as candidate_mapped_count');
                $this->db->select($select_arr);
                
                $this->db->from('teacher_candidate_map');
                
                if(!empty($user_id))
                {
                    //$this->db->join('location_panel_map', 'location_panel_map.location_id = candidate_venue_list.id');
                    //$this->db->where('location_panel_map.teacher_id',$user_id);
                }
                //$this->db->where('candidate_details.selected_flag',1);
                $this->db->where('teacher_candidate_map.location_id',$location_id);
                $this->db->group_by('teacher_candidate_map.teacher_id'); 
                //$this->db->order_by('candidate_venue_list.city', 'asc' ); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();
               
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            
            public function get_all_course_list()
            {
               
                $select_arr = array('program_name','program_id','program_type','total_seat','course_link',
                    'form_issuance_date','form_submission_last_date','form_fees','status','drive_name','program_code','first_fee');
                $this->db->select($select_arr);
                $this->db->from('courses');
                $this->db->order_by('created_date', 'desc' ); 
            
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_emaillog_list()
            {
               
                $select_arr = array('send_from','send_to','subject','message',
                    'created_date','status');
                $this->db->select($select_arr);
                $this->db->from('email_log');
                $this->db->order_by('created_date', 'desc' ); 
            
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_donation_list()
            {
               
                $select_arr = array('first_name','last_name','email_id','phone_no','amount',
                    'created_date');
                $this->db->select($select_arr);
                $this->db->from('alumni_donation');
                $this->db->order_by('created_date', 'asc' ); 
            
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_event_name_with_userid()
            {
               
                $select_arr = array('alumni_event_map.event_id','alumni_event_map.user_id','alumni_event_map.user_email','alumni_event_map.created_date','alumni_events.event_name','users.first_name','users.middle_name','users.last_name');
                $this->db->select($select_arr);
                $this->db->from('alumni_event_map');
                $this->db->join('alumni_events', 'alumni_events.id = alumni_event_map.event_id');
                $this->db->join('users', 'users.id = alumni_event_map.user_id');

                //$this->db->where('alumni_event_map.event_id', $event_id); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                    //pr($result_arr);
                     return $result_arr;
                }
                return FALSE;
     
            }

            public function get_all_event_name_without_userid()
            {
               
                $select_arr = array('alumni_event_map.event_id','alumni_event_map.user_id','alumni_event_map.user_email','alumni_event_map.created_date','alumni_events.event_name');
                $this->db->select($select_arr);
                $this->db->from('alumni_event_map');
                $this->db->join('alumni_events', 'alumni_events.id = alumni_event_map.event_id');
                //$this->db->join('users', 'users.id = alumni_event_map.user_id');

                //$this->db->where('alumni_event_map.event_id', $event_id); 

                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                    //pr($result_arr);
                     return $result_arr;
                }
                return FALSE;
     
            }
            
        public function get_current_month_events($month,$year){

        $first_date =$year.'-'.$month.'-01';
        
        if($month == 12)
        {
            $month = 0;
            $year=$year+1;
        }
        $last_date =$year.'-'.($month+1).'-01';
        
                $select_arr = array('alumni_events.id as event_id','alumni_events.event_name','alumni_events.event_description',
                    'alumni_events.event_start_date','alumni_events.event_end_date','Extract(day from alumni_events.event_start_date) as date_start_day',
                'Extract(day from alumni_events.event_end_date) as date_end_day');
                $this->db->select($select_arr);
                $this->db->from('alumni_events'); 
                $this->db->where('alumni_events.event_start_date >= ', $first_date);
                $this->db->where('alumni_events.event_start_date < ', $last_date);  
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
//        $query = $this->db->query("Select alumni_events.id,alumni_events.event_name as name,alumni_events.event_link,Extract(day from alumni_events.event_start_date) as date_start_day,
//            Extract(day from alumni_events.event_end_date) as date_end_day FROM alumni_events
//            where event_start_date >= '".$first_date."' AND event_start_date <  '".$last_date."' order by event_start_date");
//
//       $query = $this->db->get();
//        if($query->num_rows > 0)
//        {   foreach ($query->result_array() as $row)
//            {
//                $resultset[]=$row;
//            }
//        }
//        var_dump($resultset);die;
//        if(!empty ($resultset))
//            return $resultset;
//        else
//            return false;

    }
    
    public function get_last_month_continue_events($month,$year){
        //return;
        $first_date =$year.'-'.$month.'-01';
        
        if($month == 12)
        {
            $month = 0;
            $year=$year+1;
        }
        $last_date = date("Y-m-t", strtotime($year.'/'.$month.'/01'));
        
        $select_arr = array('alumni_events.id as event_id','alumni_events.event_name','alumni_events.event_description',
                    'alumni_events.event_start_date','alumni_events.event_end_date','Extract(day from alumni_events.event_start_date) as date_start_day',
                'Extract(day from alumni_events.event_end_date) as date_end_day');
                $this->db->select($select_arr);
                $this->db->from('alumni_events'); 
                $this->db->where('alumni_events.event_start_date < ', $first_date);
                $this->db->where('alumni_events.event_end_date >= ', $first_date);
               // $this->db->where('alumni_events.event_start_date < ', $last_date);  
               // $this->db->where('alumni_events.event_start_date >= ', $start_date);
                //$this->db->or_where('alumni_events.event_start_date <= ', $end_date);  
                //$this->db->where('alumni_events.event_start_date NOT BETWEEN CAST("'.$first_date.'" AS DATE)  AND CAST("'.$last_date.'" AS DATE) ', NULL, FALSE);
                //$this->db->where('alumni_events.event_end_date NOT BETWEEN CAST("'.$first_date.'" AS DATE)  AND CAST("'.$last_date.'" AS DATE) ', NULL, FALSE);
                //$this->db->where("alumni_events.event_end_date BETWEEN "'.$first_date.'" AND $last_date");
                $this->db->order_by('alumni_events.event_start_date asc ');
                
                $query = $this->db->get();
                
                $result_arr = $query->result_array();
                //echo $this->db->last_query();die;
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
                
//        $query = $this->db->query("Select alumni_events.id,alumni_events.event_name as name,alumni_events.event_link,Extract(day from alumni_events.event_start_date) as date_start_day,
//            Extract(day from alumni_events.event_end_date) as date_end_day FROM alumni_events
//             WHERE event_start_date not between '".$first_date."' and '".$last_date."'
//            AND
//            event_end_date between '".$first_date."' and '".$last_date."'
//            order by event_start_date
//        ");
//        //$query = $this->db->get('');
//        if($query->num_rows > 0)
//        {   foreach ($query->result_array() as $row)
//            {
//                $resultset[]=$row;
//            }
//        }
//        //var_dump($resultset);die;
//        if(!empty ($resultset))
//            return $resultset;
//        else
//            return false;

    }
    
    public function get_all_alumni_event_list()
    {
               
                $select_arr = array('id as event_id','event_name','event_link','location',
                    'event_start_date','event_end_date','status');
                $this->db->select($select_arr);
                $this->db->from('alumni_events');
                $this->db->order_by('created_date', 'asc' ); 
            
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
        }
    
        public function get_yearly_payment()
        {
               
                $select_arr = array('month(created_date) as month','sum(amount) as totalAmount');
                $this->db->select($select_arr);
                $this->db->from('candidate_payment');
                $this->db->where('year(created_date)',date('Y')); 
                $this->db->group_by('month(created_date)'); 
            
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
        }
        
        public function get_yearly_donation()
        {
               
                $select_arr = array('month(created_date) as month','sum(amount) as totalAmount');
                $this->db->select($select_arr);
                $this->db->from('alumni_donation');
                $this->db->where('year(created_date)',date('Y')); 
                $this->db->group_by('month(created_date)'); 
            
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
        }
        
            public function updateCourseStatus($user)
            {
                //pr($user);
               $param = array('status'=>$user['course_status']);
                $this->db->where('id', $user['course_id']);
                $this->db->update('courses',$param );
                $course_id = $this->db->affected_rows();
                 //pr($this->db->last_query());
                if($course_id)
                {
                    return $course_id;
                }
                return FALSE;
            } 
            
            //select month(created_date) as "month", sum(amount) as TotalAmount from candidate_payment where year(created_date) = 2017 group by month(created_date)

            public function get_all_booking_details($course_id)
            {
               
                $select_arr = array('candidate_details.first_name',
                    'candidate_details.middle_name',
                    'candidate_details.last_name','candidate_details.email_id','candidate_details.contact_number',
                    'candidate_courses_map.id as application_id','candidate_payment.amount','courses.first_fee_refund_percentage');
                $this->db->select($select_arr);
                $this->db->from('candidate_details');
                $this->db->join('candidate_payment', 'candidate_payment.candidate_id = candidate_details.id');
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('courses', 'candidate_details.course_id = courses.id');
                $this->db->where('candidate_payment.payment_fee_type', 'Booking Fee');
                $this->db->where('candidate_details.course_id', $course_id);
                $query = $this->db->get();
               
                $result_arr = $query->result_array();
                //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function get_all_apilog_list()
            {
               
                $select_arr = array('url','	api_name','version','user_agent',
                    'user_accept','domain','request_json','response_json',
                    'created_date','status');
                $this->db->select($select_arr);
                $this->db->from('api_request_log');
                $this->db->order_by('created_date', 'desc' ); 
            
                $query = $this->db->get();
               
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
}
       

?>