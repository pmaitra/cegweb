<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modelsurvey extends CI_Model{
    function __construct(){
        parent::__construct();
    }

            public function addSurveyQuestion($user)
            {
                
                $param['questions'] = $user['survey_questions'];
                $param['status'] = $user['survey_questions_status'];
                
                $param['created_date'] = date ('c');

                $this->db->insert('survey_questions', $param);
                $survey_id = $this->db->insert_id();

                if($survey_id)
                {
                    return $survey_id;
                }
                return FALSE;      

            }

            public function editSurveyQuestion($user)
            {
                $survey_id = $user['survey_id'];
                $param['questions'] = $user['survey_questions'];
                $param['status'] = $user['survey_questions_status'];
                
                $param['modified_date'] = date ('c');

                $this->db->where('id', $survey_id);
                $this->db->update('survey_questions', $param);
                $survey_id = $this->db->affected_rows();

                if($survey_id)
                {
                    return $survey_id;
                }
                return FALSE;        
            }

            public function addSurveyAnswer($user)
            {
                
                $param['answers'] = $user['survey_answers'];
                $param['weight'] = $user['survey_answer_weights'];
                $param['status'] = $user['survey_answers_status'];
                
                $param['created_date'] = date ('c');

                $this->db->insert('survey_answers', $param);
                $survey_id = $this->db->insert_id();

                if($survey_id)
                {
                    return $survey_id;
                }
                return FALSE;      

            }

            public function editSurveyAnswer($user)
            {
                $survey_id = $user['survey_id'];
                $param['answers'] = $user['survey_answers'];
                $param['weight'] = $user['survey_answer_weights'];
                $param['status'] = $user['survey_answers_status'];
                
                $param['modified_date'] = date ('c');

                $this->db->where('id', $survey_id);
                $this->db->update('survey_answers', $param);
                $survey_id = $this->db->affected_rows();

                if($survey_id)
                {
                    return $survey_id;
                }
                return FALSE;        
            }

            public function addSurvey($user)
            {
                
                $param['survey_name'] = $user['survey_name'];
                $param['survey_description'] = $user['survey_description'];
                $param['status'] = $user['survey_status'];
                
                $param['created_date'] = date ('c');

                $this->db->insert('survey_head', $param);
                $survey_id = $this->db->insert_id();

                if($survey_id)
                {
                    return $survey_id;
                }
                return FALSE;      

            }

            public function editSurvey($user)
            {
                $surveyid = $user['survey_id'];
                $param['survey_name'] = $user['survey_name'];
                $param['survey_description'] = $user['survey_description'];
                $param['status'] = $user['survey_status'];
                
                $param['modified_date'] = date ('c');

                $this->db->where('id', $surveyid);
                $this->db->update('survey_head', $param);
                $survey_id = $this->db->affected_rows();

                if($survey_id)
                {
                    return $survey_id;
                }
                return FALSE;        
            }

            public function addSurveySet($user)
            {
                $param['survey_id'] = $user['survey'];
                $param['combination_id'] = $user['combination_id'];
                $param['question_id'] = $user['survey_question'];
                $param['type_id'] = $user['survey_answer_type'];
                if(!empty($user['survey_answer']) && !empty($user['survey_answer_weight']))
                {
                    $param['answer_id'] = $user['survey_answer'];
                    $param['answer_weight_id'] = $user['survey_answer_weight'];
                }
                else
                {
                    $param['answer_id'] = 0;
                    $param['answer_weight_id'] = 0;
                }
                
                $param['required'] = $user['survey_required'];
                $param['created_date'] = date ('c');

                $this->db->insert('survey_combination', $param);
                $survey_id = $this->db->insert_id();

                if($survey_id)
                {
                    return $survey_id;
                }
                return FALSE;      

            }

             public function addSurveyCombinationMap($user)
            {
                $param['survey_id'] = $user['survey'];
                $param['combination_name'] = $user['combination_name'];
                $param['combination_link'] = strtolower(preg_replace("/[^a-zA-Z]/", "", $param['combination_name']));
                
                $param['status'] = 1;

                $param['created_date'] = date ('c');

                $this->db->insert('survey_combination_map', $param);
                $combination_id = $this->db->insert_id();

                if($combination_id)
                {
                    return $combination_id;
                }
                return FALSE;      

            }
            

             public function addCourseSurvey($user)
            {
                
                $param['course_id'] = $user['course_id'];
                $param['survey_id'] = $user['survey_id'];
                $param['combination_id'] = $user['combination_name'];
                $param['step'] = $user['step'];
                $param['mandatory'] = $user['required'];
                
                $param['created_date'] = date ('c');

                $this->db->insert('course_survey_map', $param);
                $course_survey_map_id = $this->db->insert_id();

                if($course_survey_map_id)
                {
                    return $course_survey_map_id;
                }
                return FALSE;      

            }

            public function display_survey_course_list()
            {
                $select_arr = array('courses.program_name',
                    'survey_head.survey_name','survey_combination_map.combination_name','survey_combination_map.combination_link'
                    );
                $this->db->select($select_arr);
                $this->db->from('course_survey_map'); 
                $this->db->join('courses', 'courses.id = course_survey_map.course_id');

                $this->db->join('survey_combination_map', 'survey_combination_map.id = course_survey_map.combination_id');
                
                $this->db->join('survey_head', 'survey_head.id = course_survey_map.survey_id');
                $this->db->order_by('course_survey_map.id');
                
                $query = $this->db->get();
                
                $result_arr = $query->result_array();
                 
                //pr($result_arr);
                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }

            public function display_survey_combination_list($users)
            {
                $select_arr = array('answer_type.type_name','survey_answers.answers',
                    'survey_answers.weight','survey_questions.questions');
                $this->db->select($select_arr);
                $this->db->from('survey_combination');

                $this->db->join('survey_answers', 'survey_answers.id = survey_combination.answer_id', 'left');
                $this->db->join('answer_type', 'answer_type.type_id = survey_combination.type_id' );
                $this->db->join('survey_questions', 'survey_questions.id = survey_combination.question_id');

                $this->db->where('combination_id', $users); 
                $query = $this->db->get();
                //pr($this->db->last_query());
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
     
            }

            public function display_user_survey_list()
            {
                $select_arr = array('courses.drive_name',
                    'candidate_details.first_name','candidate_details.middle_name','candidate_details.last_name','user_survey.email_id','user_survey.id','survey_combination_map.combination_name');
                $this->db->select($select_arr);
                $this->db->from('user_survey');
                $this->db->join('candidate_details', 'candidate_details.email_id = user_survey.email_id' );
                $this->db->join('candidate_courses_map', 'candidate_courses_map.candidate_id = candidate_details.id');
                $this->db->join('courses', 'courses.id = candidate_courses_map.course_id');
                $this->db->join('survey_combination_map', 'survey_combination_map.id = user_survey.combination_id');
                
                $query = $this->db->get();
                //pr($this->db->last_query());
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
            }

            public function user_survey_details_list($user_survey_id)
            {
                $select_arr = array('survey_answers.id','answer_type.type_name','survey_answers.answers',
                    'survey_answers.weight','survey_questions.questions');
                $this->db->select($select_arr);
                $this->db->from('survey_combination');

                $this->db->join('survey_answers', 'survey_answers.id = survey_combination.answer_id', 'left');
                $this->db->join('answer_type', 'answer_type.type_id = survey_combination.type_id' );
                $this->db->join('survey_questions', 'survey_questions.id = survey_combination.question_id');

                $this->db->where('combination_id', $user_survey_id); 
                $query = $this->db->get();
                //pr($this->db->last_query());
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
            }

            

}
       

?>
