<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelstudent extends CI_Model{
    function __construct(){
        parent::__construct();
    }

            public function getExams($user)
            {
               //echo $user;
                error_log("================ getExams ===============");
                
                $param['rollNumber'] = $user;
               

                $select_arr = array('exam','marksId');
                $this->db->select($select_arr);
                error_log("================ getExams 1 ===============");
                $this->db->from('student_marks'); 
                $this->db->where('rollNumber',$user); 
                $this->db->order_by('created_at desc');
               // $this->db->group_by('exam');
                
                $query = $this->db->get();
               // echo $this->db->last_query();
		//die;
		//if(!$query) {
		//	return FALSE;
		//}
                error_log("================ getExams 2 ===============");
		//error_log(var_export($query, 1));
                
                $result_arr = $query->result_array();
                error_log("================ getExams 3 ===============");
                 
                //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;

            }
            
            public function get_event_calendar($year,$month,$rollNumber,$accademicId)
            {
                $start_date =$year.'-'.$month.'-01';
        
                if($month == 12)
                {
                    $month = 0;
                    $year=$year+1;
                }
                $end_date =$year.'-'.($month+1).'-01';
                
                $select_arr = array('student_attendance.attendanceId','student_attendance.type',
                    'student_attendance.description',
                    'student_attendance.attendanceDate','Extract(day from student_attendance.attendanceDate) as date_start_day');
                $this->db->select($select_arr);
                $this->db->from('student_attendance'); 
                $this->db->where("student_attendance.attendanceDate BETWEEN '$start_date' AND '$end_date'");
                $this->db->where('rollNumber',$rollNumber); 
                $this->db->where('student_attendance.accademicSession',$accademicId); 
                
                $this->db->order_by('student_attendance.attendanceDate asc ');
                
                $query = $this->db->get();
                
                $result_arr = $query->result_array();
              //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }

           public function getSchoolEventsData($start,$end,$accademicSessionId)
            {
               //Date correction
                $to  =date('Y-m-d',$start);
                //$to = date('Y-m-d',strtotime($start . "-2 days"));
                $from =date('Y-m-d',$end);
                //$from =date('Y-m-d',strtotime($end . "+1 days"));

                $select_arr = array('id','title','description','startDate','endDate','accademicSession');
                $this->db->select($select_arr);
                $this->db->from('school_events');
                $this->db->where('accademicSession',$accademicSessionId);
                $this->db->group_start(); 
                $this->db->where('startDate >= date("'.$to.'")');
                $this->db->or_where('endDate <= date("'.$from.'")');
                $this->db->or_where('date("'.$from.'") BETWEEN startDate and endDate');
                $this->db->group_end();
                $query = $this->db->get();

                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }
            
            public function getLatestHotel($rollNumber)
            {
                $select_arr = array('house');
                $this->db->select($select_arr);
                $this->db->from('student_hostel'); 
                $this->db->where('rollNumber',$rollNumber);
                $this->db->order_by('hostelMapId desc');
                
                $query = $this->db->get();

                if ($query->num_rows() > 0)
                {
                    $row = $query->row(); 
                    return $row->house;
                }

                return FALSE;
     
            }
            
            public function getAchievements($rollNumber,$accademicId)
            {
                $select_arr = array('school_achievements.id','school_events.title','school_events.description',
                    'school_events.startDate','school_events.endDate',
                    'school_achievements.eventPosition',
                    'school_achievements.eventPhoto');
                $this->db->select($select_arr);
                $this->db->from('school_achievements'); 
                $this->db->join('school_events', 'school_events.id = school_achievements.eventId');
                $this->db->where('school_achievements.rollNumber',$rollNumber);
                $this->db->where('school_achievements.accademicSession',$accademicId);
                
                $this->db->order_by('school_achievements.id desc');
                
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
