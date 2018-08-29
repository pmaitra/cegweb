<?php
date_default_timezone_set("Asia/Calcutta");
function getSession($session)
{
            $sessionCheck = StudentSession::firstOrNew(['session' => $session]);

            if(empty($sessionCheck->id))
            {
                $studentSession = StudentSession::create(
                [ 'session' => $session,
                   'slug'=>'ay'.seoFriendlyUrl($session)
                ]);
                
                $sessionId = $studentSession->id;
            }
            else
            {
                $sessionId = $sessionCheck->id;
            }
        
        if(!empty($sessionId))
        {
            return $sessionId;
        }
        return null;
}

function createSchoolNotes($type,$requestParams)
{
    $sqlParam = 'where';
    switch ($type)
    {
        case 'rollwise':
                    $successArr = insertNotes($requestParams['rollwise'],$requestParams);
        break;
        case 'standardwise':
            $query = Illuminate\Database\Capsule\Manager::table('student_section_map');
            $j = 0;
            for ($i = 0; $i < count($requestParams['standardwise']); $i++) {
                
                foreach ($requestParams['standardwise'][$i]['section'] as $sections)
                {
                    $standard = $requestParams['standardwise'][$i]['standard'];
                    if($j == 0 )
                    {
                        $query->where(function ($qry) use($sections,$standard){
                                    $qry->where('standard', '=', $standard)
                                          ->where('section', '=', $sections);
                                });
                                $j++;
                    }
                    else{
                        $query->orWhere(function ($qry) use($sections,$standard){
                                    $qry->where('standard', '=', $standard)
                                          ->where('section', '=', $sections);
                                });
                    }
                }
            }
            
           $records = $query->get();
            foreach ($records as $singleRoll) {
                $rollArr[] = $singleRoll->rollNumber;
            }

            if(!empty($rollArr))
            {
                $successArr = insertNotes($rollArr,$requestParams);
            }
            break;
            case 'general':
                $query = Illuminate\Database\Capsule\Manager::table('student_details');
                $records = $query->get();
            foreach ($records as $singleRoll) {
                $rollArr[] = $singleRoll->rollNumber;
            }

            if(!empty($rollArr))
            {
                $successArr = insertNotes($rollArr,$requestParams);
            }
            break;
                
    }

    if(!empty($successArr))
    {
        return $successArr;
    }
    return null;
}

function insertNotes($studentArr,$requestParams) {
    $successNumber = 0;
    $sessionId = getSession($requestParams['academicsSession']);
    
    for ($i = 0; $i < count($studentArr); $i++) {
        $rollNumberCheck = Student::firstOrNew(['rollNumber' => $studentArr[$i]]);

        if (!empty($studentArr[$i]) && !empty($rollNumberCheck->id)) {
            $studentNotes = SchoolNote::create(
                            ['accademicSession' => $sessionId,
                                'title' => $requestParams['note'],
                                'description' => $requestParams['descr'],
                                'sender' => $requestParams['sender'],
                                'logTime' => date('Y-m-d H:i:s', $requestParams['logTime']),
                                'rollNumber' => $studentArr[$i]
            ]);

            if (!empty($studentNotes->id)) {
                $successNumber = $successNumber + 1;
                $successArr[] = $studentArr[$i];
            } else {
                $failedArr[] = $studentArr[$i];
            }
        }
    }

    if(!empty($successNumber))
    {
        return $successArr;
    }
    return null;
}

function processAttendanse($attendanceDate,$students,$requestParams,$type)
{
    $sessionId = getSession($requestParams['academicsSession']);
    if(!empty($students))
    {
        for($i=0;$i<count($students);$i++)
        {
            $rollNumberCheck = Student::firstOrNew(['rollNumber' => $students[$i]]);
            $attendanceCheck = StudentAttendance::firstOrNew(['rollNumber' => $students[$i],
                        'attendanceDate' => date('Y-m-d', $requestParams['attendanceDate']),
                        'accademicSession'=>$sessionId]);
            if(!empty($students[$i]) && !empty($rollNumberCheck->id) && empty($attendanceCheck->attendanceId))
            {
                $studentAttendanceDetails = StudentAttendance::create(
                [   'standard' => $requestParams['standard'],
                    'section' => $requestParams['section'],
                    'rollNumber' =>$students[$i],
                    'type' => $type,
                    'attendanceDate' => date('Y-m-d H:i:s', $requestParams['attendanceDate']),
                    'accademicSession' => $sessionId
                ]);
                
                if(!empty($studentAttendanceDetails->id))
                {
                    $successNumber = $successNumber+1;
                    $successArr[]= $students[$i];
                }
                else 
                {
                    $failedArr[]= $students[$i];
                }
            }
        }
        
        if(!empty($successNumber))
        {
            return $successArr;
        }
        return null;
    }
}

function login_check($db,$username,$password)
{
    $query = $db->prepare("SELECT users.id FROM users JOIN user_groups_map ON (users.id=user_groups_map.user_id) WHERE  users.username=:username AND users.password=:password AND user_groups_map.group_id=3");                            

    $query->execute(
                array(
                    ':username' => $username,
                    ':password' => md5($password)
                )
            );

    $result = $query->fetch();
    
    if(!empty($result))
    {
        return $result;
    }
    else
    {
        return FALSE;
    }        
}

function get_canditate_details($db,$result,$fulldata='',$marksFlag='',$paymentFlag='')
{
    //pr($paymentFlag);
    foreach ($result as $singleCandidate)
    { 
        $candidate_details_arr = getApplicationId($db,$singleCandidate['id']);
        
        $candidate_details['admissionFormId'] = intval($candidate_details_arr['application_id']);
        $candidate_details['programId'] = intval($candidate_details_arr['program_id']);

        if($marksFlag == 1)
        {
            $candidate_details['marks'] = $singleCandidate['interview_score'];
            if($singleCandidate['selected_flag'] == 1)
            {
                $candidate_details['marks'] = floatval($singleCandidate['interview_score']);
                $candidate_details['selectionStatus'] = 'Selected';
            }
            else 
            {
                $candidate_details['marks'] = $singleCandidate['interview_score'];
                $candidate_details['selectionStatus'] = 'Rejected';
            }
        }
        
        if($paymentFlag == 1)
        {
           // pr('hi');
            $query = $db->prepare("SELECT * FROM candidate_payment where candidate_id =:candidate_id and application_id=:application_id");
            $query->execute(array(':candidate_id' => $singleCandidate['id'],':application_id'=>$candidate_details['admissionFormId']));
            $payment_details = $query->fetch(PDO::FETCH_ASSOC);

            $candidate_details['paymentDetails'] = format_payment_details($payment_details);
        }
        
        if($fulldata == 1)
        {
            
            $candidate_details['portalCandidateDetails'] = format_candidate_details($singleCandidate);
            $candidate_details['portalCandidateDetails']['userId'] = nullCheck(intval($candidate_details_arr['icam_user_id']));
            
            $query = $db->prepare("SELECT * FROM qualification_details where candidate_id =:candidate_id");
            $query->execute(array(':candidate_id' => $singleCandidate['id']));
            $qualification_details = $query->fetchAll(PDO::FETCH_ASSOC);
            $candidate_details['qualificationDetails'] = format_acamdemic_qualification($qualification_details);

            $query = $db->prepare("SELECT * FROM professional_details where candidate_id =:candidate_id");
            $query->execute(array(':candidate_id' => $singleCandidate['id']));
            $professional_details = $query->fetchAll(PDO::FETCH_ASSOC);
            $candidate_details['professionalDetails'] = format_professional_qualification($professional_details);
            
            $query = $db->prepare("SELECT * FROM candidate_payment where candidate_id =:candidate_id and application_id=:application_id");
            $query->execute(array(':candidate_id' => $singleCandidate['id'],':application_id'=>$candidate_details['admissionFormId']));
            $payment_details = $query->fetch(PDO::FETCH_ASSOC);
            
            $candidate_details['paymentDetails'] = format_payment_details($payment_details);
        }
        $final_candidate_arr[] = $candidate_details;            
    }
    
    if(!empty($final_candidate_arr))
    {
        return $final_candidate_arr;
    }
    else
    {
        return FALSE;
    }
}



function multipleTeacherEntry($db,$param,$location_id)
{
    $panelEntry = '';
    if(!empty($param))
    { 
        for($i= 0 ; $i<count($param) ; $i++) 
        {
            $panel_details = singleTeacherEntry($db,$param[$i],$location_id);
            //echo $panel_details;
            if(!empty($panel_details))
            {
                if($i > 1)
                {
                    $panelEntry.=' , ';
                }
                $panelEntry.= $param[$i]['firstName'].' '.$param[$i]['middleName'].' '.$param[$i]['lastName'];
            }
            
        }
    }
    return $panelEntry;
        
}

function singleTeacherEntry($db,$param,$location_id)
{
    
    $query = $db->prepare("SELECT  id as user_id FROM users WHERE email_id = :email");

    $query->execute(array(':email'=> $param['email']));
    
    $result = $query->fetch(PDO::FETCH_ASSOC);
        if(empty($result['user_id']))
        {
            if(!empty($param['email']) && !empty($param['firstName']) && !empty($param['lastName']))
            {
                $query = $db->prepare("INSERT INTO users(username,email_id,password,first_name,middle_name,last_name,status,created_date)
                                VALUES(:username,:email_id,:password,:first_name,:middle_name,:last_name,1,:created_date)");
                try { 
                    $db->beginTransaction(); 
                   
                    $query->execute(array(  ':username' => $param['email'],
                                            ':email_id' => $param['email'],
                                            ':password' => md5('password'),
                                            ':first_name' => $param['firstName'],
                                            ':middle_name' => $param['middleName'],
                                            ':last_name' => $param['lastName'],
                                            ':created_date' => date('Y-m-d H:i:s')
                                            )
                                   ); 
                    $teacher_id = $db->lastInsertId();
                    $db->commit(); 
                    insertUserGroup($db,$teacher_id);
                    insertLocationToTeacher($db,$location_id,$teacher_id);
                    
                    return $last_insert_id;
                    } catch(PDOExecption $e) 
                    { 
                        //pr($e);
                        $db->rollback(); 
                        return FALSE;
                    } 
                    return FALSE;
                }
                else
                {
                    return FALSE;
                }
        }
        else
        {
            insertLocationToTeacher($db,$location_id,$result['user_id']);
           return $result['user_id'];
        }
    }
    
    function insertUserGroup($db,$userid)
    {
        if(!empty($userid))
        {
            $query = $db->prepare("INSERT INTO user_groups_map(user_id,group_id,created_date,modified_date)
                                VALUES(:user_id,:group_id,:created_date,:modified_date)");
                try { 
                    $db->beginTransaction(); 
                    $query->execute(array(  ':user_id' => $userid,
                                            ':group_id' => 4,//Later make it dynamic
                                            ':created_date' => date('Y-m-d H:i:s'),
                                            ':modified_date' => date('Y-m-d H:i:s')
                                            )
                                   ); 
                    $db->commit(); 

                    $last_insert_id = $db->lastInsertId();
                    
                    return $last_insert_id;
                    } catch(PDOExecption $e) 
                    { 
                        
                        $db->rollback(); 
                        return FALSE;
                    } 
        }
        return FALSE;            
    }
    
    function insertLocationToTeacher($db,$location_id,$teacher_id)
    {
        
        if(!empty($location_id) && !empty($teacher_id))
        {
            $query = $db->prepare("INSERT INTO location_panel_map(teacher_id,location_id,created_date)
                                VALUES(:teacher_id,:location_id,:created_date)");
                try { 
                    $db->beginTransaction(); 
                    $query->execute(array(  ':teacher_id' => $teacher_id,
                                            ':location_id' => $location_id,
                                            ':created_date' => date('Y-m-d H:i:s'),
                                            
                                            )
                                   ); 
                    $last_insert_id = $db->lastInsertId();
                    $db->commit(); 

                    return $last_insert_id;
                    } catch(PDOExecption $e) 
                    { 
                        
                        $db->rollback(); 
                        return FALSE;
                    } 
        }
        return FALSE;            
    }

function format_candidate_details($param) 
{
    if(!empty($param))
    {
        $result_param['portalCandidateId'] = intval($param['id']);
        $result_param['firstName'] = nullCheck($param['first_name']);
        $result_param['middleName'] = nullCheck($param['middle_name']);
        $result_param['lastName'] = $param['last_name'];
        $result_param['profilePicture'] = $param['profile_picture'];
        $result_param['dateOfBirth'] = convertDate($param['date_of_birth']);
        $result_param['sex'] = nullCheck($param['sex']);
        $result_param['maritalStatus'] = $param['marrital_status'];
        $result_param['contactNo'] = nullCheck($param['contact_number']);
        $result_param['panCardNo'] = nullCheck($param['pan_card_no']);
        $result_param['adharCardNo'] = nullCheck($param['adhar_card_no']);
        $result_param['voterCardNo'] = nullCheck($param['voter_card_no']);
        $result_param['passportNo'] = nullCheck($param['passport_no']);
        $result_param['email'] = $param['email_id'];
        $result_param['professionalQualification'] = nullCheck($param['professional_qualification']);
        $result_param['competitiveExams'] = nullCheck($param['competitive_exams']);
        $result_param['academicCocurricularAchievements'] = $param['academic_or_cocurricular_achievements'];
        $result_param['professionalExperience'] = $param['professional_experience'];
        $result_param['professionalAchivements'] = floatval($param['professional_achievements']);
        $result_param['interviewMarks'] = floatval($param['interview_score']);
        
        //todo add all needed fields
        return $result_param;
    }
    else 
    {
        return FALSE;
    }
}

function format_acamdemic_qualification($param) 
{
    if(!empty($param))
    {
        foreach ($param as $single_param)
        {
            $result_param['academicId'] = intval($single_param['id']);
            $result_param['degree'] = $single_param['degree'];
            $result_param['specialization'] = $single_param['specialization'];
            $result_param['instituteName'] = $single_param['institute_name'];
            $result_param['affiliation'] = $single_param['affiliation'];
            $result_param['statusOfCompletion'] = $single_param['status_of_completion'];
            $result_param['previousCourseStartDate'] = convertDate($single_param['start_date']);
            $result_param['previousCourseEndDate'] = convertDate($single_param['end_date']);
            $result_param['percentage'] = intval($single_param['percentage']);
            $result_param['cgpa'] = $single_param['cgpa'];
            
            //todo add all needed fields
            $result_param_list[] = $result_param;
        }
        return $result_param_list;
    }
    else 
    {
        return NULL;
    }
}

function format_professional_qualification($param) 
{
    if(!empty($param))
    {
        foreach ($param as $single_param)
        {
            $result_param['professionalId'] = intval($single_param['id']);
            $result_param['organization'] = $single_param['organization'];
            $result_param['designation'] = $single_param['designation'];
            $result_param['jobRole'] = $single_param['roles'];
            $result_param['jobStartDate'] = convertDateTime($single_param['start_from']);
            $result_param['jobEndDate'] = convertDateTime($single_param['start_to']);
            
            //todo add all needed fields
            $result_param_list[] = $result_param;
        }
        return $result_param_list;
    }
    else 
    {
        return NULL;
    }
}

function format_payment_details($param) 
{
    if(!empty($param))
    {
        $result_param['invoiceId'] = intval($param['id']);
        $result_param['paymentMethod'] = $param['payment_type'];
        $result_param['paymentAmount'] = floatval($param['amount']);
        $result_param['paymentDate'] = convertDateTime($param['created_date']);
        
        return $result_param;
    }
    else 
    {
        return NULL;
    }
}

function getApplicationId($db,$candidate_id = '') {
        
        //$query = $db->prepare("SELECT id FROM candidate_courses_map where candidate_id =:candidate_id");
        $query = $db->prepare("SELECT candidate_courses_map.id as application_id ,courses.drive_name , courses.program_id,users.icam_user_id FROM candidate_courses_map "
                . "left join courses on courses.id = candidate_courses_map.course_id left join candidate_details on "
                . "candidate_courses_map.candidate_id = candidate_details.id left "
                . "join users on candidate_details.user_id = users.id where candidate_courses_map.candidate_id = :candidate_id");
        
        $query->execute(array(':candidate_id' => $candidate_id));
        $application_arr = $query->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($application_arr['application_id']))
        {
            return $application_arr;
        }
        else 
        {
            return FALSE;
        }
}

function getConnection() {
    try{
        
    
    $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
    } catch(PDOExecption $e) 
    { 
        
        $db->rollback(); 
    return createResponse($response,500,0,'Please try again');

    }
}

function createResponse($response,$status='',$success='',$result) {
    $message ='Fail';
    if($success == 1)
    {
        $message ='Success';
    }
    if(empty($status) || $status == 400)
    {
        $status = 201;
    }
    $responseArr = array('status'=>  intval($status),"message"=>$message,"data"=>$result);
            
    return $response->withStatus($status)
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($responseArr));
}

//Print and Die
function pr($param)
{
    print_r($param);die;
}

//Display data null checking
function nullCheck($param)
{
    if(!empty($param))
    {
        return $param;
    }
    return NULL;
    
}

//Display data null checking
function convertDateTime($param)
{
    if(!empty($param) && !empty(strtotime($param)))
    {
        return abs(strtotime($param));
    }
    return 0;
    
}
function intCheck($param)
{
    if(!empty($param))
    {
        return intval($param);
    }
    return 0;
    
}
function floatCheck($param)
{
    if(!empty($param))
    {
        return floatval($param);
    }
    return 0;
    
}        
//Display data null checking
function convertDate($param)
{
    echo $param;die;
    if(!empty($param) && !empty(strtotime($param)))
    {
        
        return abs(strtotime($param));
        return 1321743601;
    }
    return 0;
    
}

//Display data null checking
function convertDateTimeInput($param,$param_text,$covert_type='datetime')
{

    if(empty($param))
    { 
        return array('responseCode'=>400,"data"=>"Please enter $param_text");
    }
    if(strlen($param) != 10)
    {
        return array("responseCode"=>400,"data"=>"Please enter $param_text on 10 digit EPOCH format");
    }
    
    switch ($covert_type)
    {
        case 'date':
            $coverted_time = date('Y-m-d',trim($param));
            break;
        case 'time':
            $coverted_time = date('H:i:s',trim($param));;
            break;
        case 'datetime':
            $coverted_time = date('Y-m-d H:i:s',trim($param));
            break;
        default :
            $coverted_time = date('Y-m-d H:i:s',trim($param));
            break;
    }
//pr($coverted_time);
    return array("responseCode"=>200,"data"=>$coverted_time);
}

//Display data null checking
function convertDateTimeSting($param,$covert_type='datetime')
{

    if(empty($param))
    { 
        return FALSE;
    }
    /*if(strlen($param) != 10)
    {
        return FALSE;
    }
    */
    $param = str_replace("/","-",$param);
    switch ($covert_type)
    {
        
        case 'date':
            //$coverted_time = date('Y-m-d',trim($param));
            $coverted_time = date('Y-m-d', strtotime(trim($param)));
            break;
        case 'time':
            $coverted_time = date('H:i:s',trim($param));;
            break;
        case 'datetime':
            $coverted_time = date('Y-m-d H:i:s',strtotime(trim($param)));
            break;
        default :
            $coverted_time = date('Y-m-d H:i:s',trim($param));
            break;
    }
//pr($coverted_time);
    return $coverted_time;
}

//Display data null checking
function jsonChecking($db,$reruestArray,$requiredFileds)
{

    foreach ($requiredFileds as $singleRequiredField)
    {
        if(!array_key_exists($singleRequiredField, $reruestArray))
        {
            return "Please enter :$singleRequiredField";
        }
    }
    
    $validUser = login_check($db,$reruestArray['username'],$reruestArray['password']);
    
    if(empty($validUser))
    {
        return "Invalid User Credential";
    }
    return "Success";

}

function insertIntoDb($db,$requestArray)
{
    try
    {
        if(!empty($requestArray))
        {
            foreach ($array as $key => $value) {
                
            }
            $sqlStr = "INSERT $tableName SET ";
            foreach ($requestArray as $insertKey => $insertValue) {
                $sqlStr.= "$insertKey =:$insertKey, ";
                $exequteArr["$insertKey"] = $insertValue;
            }
            $sqlStr.= " createdDate =:createdDate , modifiedDate = :modifiedDate ";
            $exequteArr["createdDate"] = date('Y-m-d H:i:s');
            $exequteArr["modifiedDate"] = date('Y-m-d H:i:s');
            $lastInsertId = insert($db,$sqlStr,$exequteArr);
            return $lastInsertId;
        }
    } catch (Exception $ex) {
        echo $ex;die;
    }


}

function insert($db,$sql,$dataArr)
{
    echo $sql."\n";
    $query = $db->prepare($sql);
    $db->beginTransaction();
    $query->execute($dataArr);
    $query->debugDumpParams();
    $last_insert_id = $db->lastInsertId();
    $db->commit();
    return $last_insert_id;
}

function insertEvents($eventArr,$requestParams) {
    $successNumber = 0;
    $sessionId = getSession($requestParams['academicsSession']);
    
    for ($i = 0; $i < count($eventArr); $i++) {
        //$rollNumberCheck = Student::firstOrNew(['rollNumber' => $studentArr[$i]]);

        if (!empty($eventArr[$i]['eventName'])
                && !empty($eventArr[$i]['eventDescription']) 
                && !empty($eventArr[$i]['eventIncharge']) 
                && !empty($eventArr[$i]['startDate']) 
                && !empty($eventArr[$i]['endDate']) ) {
            $eventsEntry = SchoolEvents::create(
                            ['accademicSession' => $sessionId,
                                'slug' => 'sspevent'.uniqid(),
                                'category' => 'General',
                                'title' => $eventArr[$i]['eventName'],
                                'description' => $eventArr[$i]['eventDescription'],
                                'incharge' => $eventArr[$i]['eventIncharge'],
                                'startDate' => date('Y-m-d H:i:s', $eventArr[$i]['startDate']),
                                'endDate' => date('Y-m-d H:i:s', $eventArr[$i]['endDate'])
            ]);

            if (!empty($eventsEntry->id)) {
                $successNumber = $successNumber + 1;
                $successArr[] = $eventArr[$i]['eventName'];
            } else {
                $failedArr[] = $eventArr[$i]['eventName'];
            }
        }
    }

    if(!empty($successNumber))
    {
        return $successArr;
    }
    return null;
}
function insertAchievments($eventArr,$requestParams,$sessionId,$eventId) {
    $successNumber = 0;

    for ($i = 0; $i < count($eventArr); $i++) {
        $rollNumberCheck = Student::firstOrNew(['rollNumber' => $eventArr[$i]]);

        if (!empty($rollNumberCheck->id)
                && !empty($eventArr[$i]['eventPosition']) 
                && !empty($eventArr[$i]['eventPhoto']) 
                && !empty($eventArr[$i]['rollNumber'])  ) {
            $eventsEntry = SchoolAchievements::create(
                            ['accademicSession' => $sessionId,
                                'eventPosition' => $eventArr[$i]['eventPosition'],
                                'eventPhoto' => json_encode($eventArr[$i]['eventPhoto']),
                                'rollNumber' => $eventArr[$i]['rollNumber'],
                                'eventId' => $eventId,
            ]);

            if (!empty($eventsEntry->id)) {
                $successNumber = $successNumber + 1;
                $successArr[] = $eventArr[$i]['rollNumber'];
            } else {
                $failedArr[] = $eventArr[$i]['rollNumber'];
            }
        }
    }

    if(!empty($successNumber))
    {
        return $successArr;
    }
    return null;
}

function seoFriendlyUrl($string){
    $string = str_replace(array('[\', \']','-'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
}
