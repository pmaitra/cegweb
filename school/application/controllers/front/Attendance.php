<?php
class Attendance extends CI_Controller {
        private $studentRoll;
            function __construct() 
        {
            parent::__construct();
            uservalidate();
            $this->studentRoll = $this->session->userdata('rollNumber');
        }
    function index()
   {   
        $response['page_title']="";
        $response['menu_details']="student";
        $response['front_menu_details']="attendance";
        $response['front_menu_ay'] = trim($this->uri->segment(3));
        $response['accademicSessionId'] = getAccademicSessionId( $response['front_menu_ay']);
        
       $data['year'] = $response['current_year'] = intval(trim($this->uri->segment(4)));
       $data['month'] =$response['current_month'] = intval(trim($this->uri->segment(5)));
        if(empty($response['current_year']) || empty($response['current_year']))
        {
            $response['current_year'] = date('Y');
            $response['current_month'] = date('m');
        }
        $start_date = $response['current_year'].'/'.$response['current_month'].'/01';
        $end_date = $response['current_year'].'/'.$response['current_month'].'/31';
        
        $this->load->model('modelstudent');
        
        $db_current_month_events_data = $this->modelstudent->get_event_calendar(
                $response['current_year'],$response['current_month'],$this->studentRoll,$response['accademicSessionId']);

        $data['calendar_display_data']= $this->create_calendar_arr(
                $db_current_month_events_data,$response['current_year'],$response['current_month']);
        //pr($data['calendar_display_data']);
         $prefs = array (
                       'show_next_prev'  => TRUE,
                       'next_prev_url'   => BASEURL.'student/attendance/'.$response['front_menu_ay'].'/',
                        'day_type'       => 'long',
                        'start_day'     => 'monday'
                     );
         $prefs['template'] = $this->create_calendar_template($data['year'],$data['month']);
         $this->load->library('calendar', $prefs);
         $response['calender_data'] = $this->calendar->generate($data['year'],$data['month'],$data['calendar_display_data']);
         renderViews(array('front/template1/header'=>$response,'front/template1/student/leave_calender'=>'','front/template1/footer'=>''));
    }
    
    public function create_calendar_arr($db_events_data,$year,$month) 
    {
        $calander_arr=array();
        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0,$month, $d, $year);
            if (date('m', $time)==$month)
            {
                //echo $d;
                if(date('d', $time) <10)
                    $calander_arr[str_replace('0','',date('d', $time))]="";
                else
                    $calander_arr[date('d', $time)]="";
            }
        }
      
        //   Current month Data handleing
        if(!empty($db_events_data))
        {
            foreach ($db_events_data as $db_events_single) 
            {
                switch ($db_events_single['type']) {
                            case "1":
                                $display_details = '<button type="button" class="btn btn-success">Present</button>';
                                break;
                            case "3":
                                $display_details =  '<button type="button" class="btn btn-danger">Absent</button>';
                                break;
                            case "2":
                                $display_details =  '<button type="button" class="btn btn-info">On Leave</button>';
                                break;
                            default:
                                $display_details =  "N/A";
                        }
                        
                  if(!empty($calander_arr) && array_key_exists($db_events_single['date_start_day'],$calander_arr))
                  {
                      //echo $calander_arr[$db_events_single['date_start_day']];
                      $calander_arr[$db_events_single['date_start_day']] =  $calander_arr[$db_events_single['date_start_day']].'<span class="event_listing">'.$display_details.'</span>';
                  }   
                  else
                  {
                      $calander_arr[$db_events_single['date_start_day']] = '<span class="event_listing">'.$display_details.'</span>';
                  }
                  
                }
        }
              if(!empty($calander_arr))
                  return $calander_arr;
              else
                  return FALSE;
        
    }
    
    public function create_calendar_template($year,$month) {
        $data_str ='{table_open}<table class="calendar">{/table_open}

            {heading_row_start}<tr>{/heading_row_start}

            {heading_previous_cell}<th class=""><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
            {heading_title_cell}<th class="" colspan="{colspan}">{heading}</th>{/heading_title_cell}
            {heading_next_cell}<th class=""><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

            {heading_row_end}</tr>{/heading_row_end}

            {week_row_start}<tr>{/week_row_start}
            {week_day_cell}<th class="day_header">{week_day}</th>{/week_day_cell}
            {week_row_end}</tr>{/week_row_end}

            {cal_row_start}<tr>{/cal_row_start}
            {cal_cell_start}<td class="">{/cal_cell_start}

            {cal_cell_content}<span class="day_listing">{day}
            
            </span>{content}{/cal_cell_content}
            {cal_cell_content_today}<div class="highlight"><div class="">{day}
            
            </div>{content}</div>{/cal_cell_content_today}

            {cal_cell_no_content}<div class="">{day}
            

            </div>{/cal_cell_no_content}
            {cal_cell_no_content_today}<span class="day_listing">{day}
            
            
            </span>{/cal_cell_no_content_today}

            {cal_cell_blank}&nbsp;{/cal_cell_blank}

            {cal_cell_end}</td>{/cal_cell_end}
            {cal_row_end}</tr>{/cal_row_end}

            {table_close}</table>{/table_close}';
        return $data_str;
        
    }
}