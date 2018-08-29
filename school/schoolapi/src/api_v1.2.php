<?php
$app->get('/v1.2/check', function ($request, $response, $args) use($app) {
    pr('hi1.2');
})->setName('check');

$app->get('/v1.2/getPublishedCourse.xml', function ($request, $response, $args) use($app) {
    
    //pr('hi');
    //$articles = Model::factory('Article') -> order_by_desc('timestamp') -> find_many();
    $db = getConnection();
    $query = $db->prepare("SELECT course_link,program_name,details FROM courses "
            . "WHERE form_issuance_date <= '".date('Y-m-d')."' and form_submission_last_date >= '".date('Y-m-d')."' AND status = 1 "
            . "ORDER BY form_submission_last_date");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $display_xml = '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL.
                    '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'.PHP_EOL;

    if(!empty($result))
    {
        $display_xml.= '<channel>'.PHP_EOL.
                '<title>2017 Apllications  </title>'.PHP_EOL.
                '<link>http://'.$_SERVER['HTTP_HOST'].'/icamapi/icamapi/public/v1.2/getPublishedCourse</link>'.PHP_EOL.
                '<description>Course Description</description>'.PHP_EOL.
                '<atom:link href="http://'.$_SERVER['HTTP_HOST'].'/icamapi/icamapi/public/v1.2/getPublishedCourse" rel="self" type="application/rss+xml"  />  '.PHP_EOL.
                '<language>en-us</language>'.PHP_EOL ;
                
        for($i=0;$i<count($result);$i++)
        {
            $display_xml.=''
                    . '<item>'
                    . '<title>'.$result[$i]['program_name'].'</title>'.PHP_EOL.
                            '<link>http://'.$_SERVER['HTTP_HOST'].'/webiq/admission/'.$result[$i]['course_link'].'</link>'.PHP_EOL.
                        '<description> '.$result[$i]['details'].'</description>'.PHP_EOL.
                                 '<source url="http://'.$_SERVER['HTTP_HOST'].'/webiq/admission/'.$result[$i]['course_link'].'">http://'.$_SERVER['HTTP_HOST'].'/webiq/admission/'.$result[$i]['course_link'].'</source>'.PHP_EOL.
                                    '<guid isPermaLink="false">'.
                                   'http://'.$_SERVER['HTTP_HOST'].'/webiq/admission/'.$result[$i]['course_link'].
                                    '</guid>'.PHP_EOL.
                                    '</item>'.PHP_EOL ;
        }
        $display_xml.='</channel>'.PHP_EOL;
    }
    else
    {
        $display_xml.='<channel>
               </channel>';
    }
    
    $display_xml.='</rss>'.PHP_EOL;
    
    
        return $response->withStatus(200)
                        ->withHeader('Content-Type', 'text/xml')
                        ->write($display_xml);
  
})->setName('getPublishedCourse.xml');

$app->get('/v1.2/getPublishedNotice.xml', function ($request, $response, $args) use($app) {

    $db = getConnection();
    // Uncoment if needed real time
    $query = $db->prepare(" SELECT * FROM `institution_notice` WHERE display_start_date <= CURDATE() and display_end_date >= CURDATE() ");
    //$query = $db->prepare(" SELECT * FROM `institution_notice` ");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $display_xml = '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL.
                    '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'.PHP_EOL;

    if(!empty($result))
    {
        $display_xml.= '<channel>'.PHP_EOL.
                '<title>Notice Board </title>'.PHP_EOL.
                '<link>Notice Board'.PHP_EOL.'</link>'.
                '<description>Notice Board</description>'.PHP_EOL.
                '<atom:link href="http://'.$_SERVER['HTTP_HOST'].'/icamapi/icamapi/public/v1.2/getPublishedNotice.xml" rel="self" type="application/rss+xml"  />  '.PHP_EOL.
                '<language>en-us</language>'.PHP_EOL ;
                
        for($i=0;$i<count($result);$i++)
        {
            $display_xml.=''
                    . '<item>'
                    . '<title>'.$result[$i]['title'].'</title>'.PHP_EOL.
                            '<link>'.$result[$i]['title'].'</link>'.PHP_EOL.
                        '<description> '.$result[$i]['title'].'</description>'.PHP_EOL.
                                 '</item>'.PHP_EOL ;
        }
        $display_xml.='</channel>'.PHP_EOL;
    }
    else
    {
        $display_xml.='<channel>
               </channel>';
    }
    
    $display_xml.='</rss>'.PHP_EOL;
    
    
        return $response->withStatus(200)
                        ->withHeader('Content-Type', 'text/xml')
                        ->write($display_xml);
  
})->setName('getPublishedNotice.xml');

$app->post('/v1.2/insertNotice', function ($request, $response, $args) {
     try 
    {

        $jsonData = $request->getBody();
        

        $params = json_decode($jsonData, true);

        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }

        if(empty($params['title']))
        { 
            return createResponse($response,400,0,'Please enter a title');
        }
        $title = trim($params['title']);
        
        $description =  '';
        if(!empty($params['description']))
        { 
            $description = trim($params['description']);
        }
        
        
        $start_date_arr = convertDateTimeInput($params['displayStartDate'],'start date','date');
        if($start_date_arr['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$start_date_arr['data']);
        }
        $start_date = $start_date_arr['data'];
        
        $end_date_arr = convertDateTimeInput($params['displayEndDate'],'end date','date');
        if($end_date_arr['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$end_date_arr['data']);
        }
        $end_date = $end_date_arr['data'];

        if(!empty($username) && !empty($password))
        {   
            $db = getConnection();
            $login_result = login_check($db,$username,$password);
            if ( !empty($login_result) ) 
            {
                $query = $db->prepare("INSERT institution_notice SET title = :title,description = :description, display_start_date = :display_start_date, "
                        . "display_end_date=:display_end_date ,created_date = now(), modified_date =  now()");

                        try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                    array(
                                        ':title' => $title,
                                        ':description' => $description,
                                        ':display_start_date' => $start_date,
                                        ':display_end_date' =>$end_date
                                    )
                                );
                                $notice_id = $db->lastInsertId(); 
                               // $result = $db->fetch(PDO::FETCH_ASSOC);
                                //pr($result);
                                $db->commit(); 
                                
                                
                                if(!empty($notice_id))
                                {
                                    return createResponse($response,200,1,array('notice_id'=>$notice_id));
                                }
                                else
                                {
                                    return createResponse($response,400,0,'Please try again');
                                }
                        } 
                        catch(PDOExecption $e) { 
                            //pr($e);
                            $db->rollback(); 
                            return createResponse($response,500,0,'Please try again');
                        } 
            }
            else
                {
                    return createResponse($response,400,0,'Please enter valid credetial');
                }
        }   
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }  
    }
    catch (PDOException $e) {
        //pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('insertNotice');

$app->post('/v1.2/insertDrive', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $params = json_decode($jsonData, true);
        // pr($params['semesterAndFees']);
        $username = trim($params['username']);
        $password = trim($params['password']);
        if(empty($params['programCode']))
        { 
            return createResponse($response,400,0,'Please enter Program Code');
        }
        $program_code = trim($params['programCode']);
        
        if(empty($params['driveName']))
        { 
            return createResponse($response,400,0,'Please enter drive name');
        }
        $drive_name = trim($params['driveName']);
        //print_r($program_id);die;

        if(empty($params['programName']))
        { 
            return createResponse($response,400,0,'Please enter Program name');
        }
        $program_name = trim($params['programName']);
        
        if(empty($params['programType']))
        { 
            return createResponse($response,400,0,'Please enter Program Type');
        }
        $program_type = trim($params['programType']);
        
        if(empty($params['formFees']))
        { 
            return createResponse($response,400,0,'Please enter form fees');
        }
        $form_fees = floatval(trim($params['formFees']));
        
        if(empty($params['totalSeat']))
        { 
            return createResponse($response,400,0,'Please enter Total Seat');
        }
        $total_seat = trim($params['totalSeat']);
        
        $formIssuanceDate = convertDateTimeInput($params['formIssuanceDate'],'form issueance date','date');
        if($formIssuanceDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$formIssuanceDate['data']);
        }
        $form_issuance_date = $formIssuanceDate['data'];
        
        $formSubmissionLastDate = convertDateTimeInput($params['formSubmissionLastDate'],'form submission last date','date');
        if($formSubmissionLastDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$form_submission_last_date['data']);
        }
        $form_submission_last_date = $formSubmissionLastDate['data'];
        
        $candidateScrutinyDate = convertDateTimeInput($params['candidateScrutinyDate'],'candidate scrutiny date','date');
        if($candidateScrutinyDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$candidateScrutinyDate['data']);
        }
        $candidate_scrutiny_date = $candidateScrutinyDate['data'];

        $interviewDate = convertDateTimeInput($params['interviewDate'],'interview date','datetime');
        if($interviewDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$interviewDate['data']);
        }
        $interview_date = $interviewDate['data'];
        
        $marksSubmissionDate = convertDateTimeInput($params['marksSubmissionDate'],'marks submission date','date');
        if($marksSubmissionDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$marksSubmissionDate['data']);
        }
        $marks_submission_date = $marksSubmissionDate['data'];

        $feesPaymentStartDate = convertDateTimeInput($params['feesPaymentStartDate'],'fee payment start date','date');
        if($feesPaymentStartDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$feesPaymentStartDate['data']);
        }
        $fees_payment_start_date = $feesPaymentStartDate['data'];
        
        $feesPaymentEndDate = convertDateTimeInput($params['feesPaymentEndDate'],'fee payment start date','date');
        if($feesPaymentEndDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$feesPaymentEndDate['data']);
        }
        $fees_payment_end_date = $feesPaymentEndDate['data'];
        
        if(empty($params['semesterAndFees']))
        { 
            return createResponse($response,400,0,'Please enter Fees details');
        }
        $semesterAndFees = $params['semesterAndFees'];
        
        if(!empty($username) && !empty($password))
        {   
            $db = getConnection();
            $login_result = login_check($db,$username,$password);
            if ( !empty($login_result) ) 
            {
                $drive_exist = check_existing_drive_v1_2($db, $drive_name);
                if(!empty($drive_exist))
                { 
                    return createResponse($response,400,0,'Drive name already exist.Please enter another drive name');
                }
                
                $active_drive_exist = check_existing_program_v1_2($db, $drive_name, $program_code);
                if(!empty($active_drive_exist))
                { 
                    return createResponse($response,400,0,'Another drive is active on same program.');
                }
                
                $query = $db->prepare("INSERT courses SET program_code = :program_code,drive_name = :drive_name,program_name = :programName, program_type = :programType, "
                        . "form_fees=:form_fees ,total_seat = :totalSeat, form_issuance_date = :formIssuanceDate, form_submission_last_date = :formSubmissionLastDate, "
                        . "candidate_scrutiny_date = :candidateScrutinyDate, interview_date = :interviewDate, "
                        . "marks_submission_date = :marksSubmissionDate, fees_payment_start_date = :feesPaymentStartDate, "
                        . "fees_payment_end_date = :feesPaymentEndDate ,course_link = :course_link , name = :name,created_date=:created_date");

                        try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                    array(
                                        ':program_code' => $program_code,
                                        ':drive_name' => $drive_name,
                                        ':programName' => $program_name,
                                        ':programType' => $program_type,
                                        ':form_fees' =>$form_fees,
                                        ':totalSeat' => $total_seat,
                                        ':formIssuanceDate' => $form_issuance_date,
                                        ':formSubmissionLastDate' => $form_submission_last_date,
                                        ':candidateScrutinyDate' => $candidate_scrutiny_date,
                                        ':interviewDate' => $interview_date,
                                        ':marksSubmissionDate' => $marks_submission_date,
                                        ':feesPaymentStartDate' => $fees_payment_start_date,
                                        ':feesPaymentEndDate' => $fees_payment_end_date,
                                        ':course_link'=>  strtolower(preg_replace("/[^a-zA-Z]/", "", $drive_name)),
                                        ':name'=>$program_name,
                                        ':created_date' => date('Y-m-d H:i:s')
                                    )
                                );
                                $course_id = $db->lastInsertId(); 
                               // $result = $db->fetch(PDO::FETCH_ASSOC);
                                //pr($result);
                                $db->commit(); 
                                
                                foreach ($semesterAndFees as $single_semister_fees) {
                                     foreach ($single_semister_fees['fees'] as $semister_fee) {
                                    
                                    $query = $db->prepare("INSERT INTO courses_fee_structure(course_id,program_id,
                                    term_name,fee_type,term_id,general_fee,st_fee,sc_fee,obc_fee,created_date,modified_date)
                                    VALUES(:course_id,:program_id ,
                                    :term_name,:feeType,:term_id,:general_fee,:st_fee,:sc_fee,:obc_fee,
                                    :created_date,:modified_date)");

                                        try { 
                                            $db->beginTransaction(); 
                                            $query->execute(
                                                array(
                                                    ':course_id' => $course_id,
                                                    ':program_id' => 0,
                                                    ':term_name' => $single_semister_fees['termName'],
                                                    ':feeType' => $semister_fee['feeType'],
                                                    ':term_id' => $single_semister_fees['termId'],
                                                    ':general_fee' => $semister_fee['GENERAL'],
                                                    ':st_fee' => $semister_fee['ST'],
                                                    ':sc_fee' => $semister_fee['SC'],
                                                    ':obc_fee' => $semister_fee['OBC'],
                                                    ':created_date' => date('Y-m-d H:i:s'),
                                                    ':modified_date' => date('Y-m-d H:i:s')
                                                )
                                            ); 
                                            $db->commit(); 

                                            $last_insert_id = $db->lastInsertId();
                                        } catch(PDOExecption $e) { 
                                            //pr($e);
                                            $db->rollback(); 
                                            return createResponse($response,500,0,'Please try again');

                                        }
                                     }
                                     
                                    
                                }
                                
                                return createResponse($response,200,1,array('program_code'=>$program_code,'drive_name'=>$drive_name));
                            } 
                            catch(PDOExecption $e) { 
                               // pr($e);
                                $db->rollback(); 
                                return createResponse($response,500,0,'Please try again');
                            } 
            }
            else
                {
                    return createResponse($response,400,0,'Please enter valid credetial');
                }
        }   
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }  
    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('insertDrive');

$app->get('/v1.2/getNewCandidates', function ($request, $response, $args) {
     try 
    {
        $params = $request->getParams();
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        if(empty($params['driveName']))
        { 
            return createResponse($response,400,0,'Please enter drive name');
        }
        $drive_name = trim($params['driveName']);
        
        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);

            if ( !empty($login_result) ) 
            {
                
                
                //Checking drive name 
                $drive_id = get_course_v1_2($db,$drive_name) ;
                
                if(empty($drive_id))
                {
                    return createResponse($response,400,0,'Please enter a valid driveName');
                }
                $query = $db->prepare("SELECT * FROM candidate_details 
                                        WHERE payment_flag = 1 AND new_registration_flag = 1 AND course_id =:course_id
                                      ");
                $query->execute(array(':course_id' => $drive_id));    
                
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details_v1_2($db,$result,1);
                    return createResponse($response,200,1,$final_candidate_arr);
                        
                }
                else
                {
                    return createResponse($response,400,0,'No data found');
                }
            }
            else
            {
                return createResponse($response,400,0,'Please enter valid credetial');
            }
        }
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('getNewCandidates');

$app->get('/v1.2/getScrutinizedCandidates', function ($request, $response, $args) {
     try 
    {
        $params = $request->getParams();
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);

            if ( !empty($login_result) ) 
            {
                
                if(empty($params['driveName']))
                { 
                    return createResponse($response,400,0,'Please enter drive name');
                }
                $drive_name = trim($params['driveName']);
                
                //Checking drive name 
                $drive_id = get_course_v1_2($db,$drive_name) ;
                
                if(empty($drive_id))
                {
                    return createResponse($response,400,0,'Please enter a valid driveName');
                }
                
                $query = $db->prepare("SELECT * FROM candidate_details 
                                        WHERE dirty_flag = 1 AND scrutiny_flag = 1 AND 	interview_ready_flag = 0 
                                        AND course_id = :course_id
                                      ");
                    
                $query->execute(array(':course_id' => $drive_id)); 
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details_v1_2($db,$result);
                    return createResponse($response,200,1,$final_candidate_arr);
                        
                }
                else
                {
                    return createResponse($response,400,0,'No data found');
                }
            }
            else
            {
                return createResponse($response,400,0,'Please enter valid credetial');
            }
        }
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('getScrutinizedCandidates');

$app->get('/v1.2/getSelectedCandidates', function ($request, $response, $args) {
     try 
    {
        $params = $request->getParams();
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        if(empty($params['driveName']))
        { 
            return createResponse($response,400,0,'Please enter drive name');
        }
        $drive_name = trim($params['driveName']);
        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);

            if ( !empty($login_result) ) 
            {
                
                
                //Checking drive name 
                $drive_id = get_course_v1_2($db,$drive_name) ;
                
                if(empty($drive_id))
                {
                    return createResponse($response,400,0,'Please enter a valid driveName');
                }
                $query = $db->prepare(" SELECT * FROM candidate_details WHERE selected_flag > 0 AND course_id = :course_id");
                    
                $query->execute(array(':course_id' => $drive_id)); 
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details_v1_2($db,$result,'',1);
                    return createResponse($response,200,1,$final_candidate_arr);
                        
                }
                else
                {
                    return createResponse($response,400,0,'No data found');
                }
            }
            else
            {
                return createResponse($response,400,0,'Please enter valid credetial');
            }
        }
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('getSelectedCandidates');

$app->get('/v1.2/getCandidatesMarksObtained', function ($request, $response, $args) {
     try 
    {
        $params = $request->getParams();
        
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        
        if(empty($params['admissionFormId']))
        { 
            return createResponse($response,400,0,'Please enter application id');
        }
        $application_id = trim($params['admissionFormId']);
        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);

            if ( !empty($login_result) ) 
            {
                
                //Checking Candidate id
                $query = $db->prepare("SELECT candidate_id FROM candidate_courses_map 
                                        WHERE id = :applicationid;
                                      ");
                    
                 $query->execute(
                    array(
                        ':applicationid' => $application_id
                    )
                );
                $result = $query->fetch(PDO::FETCH_ASSOC);
                
                if(empty($result['candidate_id']))
                { 
                    return createResponse($response,400,0,'Please enter a valid application id');
                }
                $candidate_id = $result['candidate_id'];
                $query = $db->prepare("SELECT interview_score,interview_done_flag FROM candidate_details 
                                        WHERE id = :candidateid;
                                      ");
                    
               $query->execute(
                    array(
                        ':candidateid' => $candidate_id
                    )
                );
                $result = $query->fetch(PDO::FETCH_ASSOC);
                    
               // print_r($result);die;
                if(!empty($result))
                {   
                    if($result['interview_done_flag'] == 1)
                    {
                        $final_candidate_arr = array('marks'=>$result['interview_score']);
                        return createResponse($response,200,1,$final_candidate_arr);
                    }
                    else 
                    {
                        return createResponse($response,400,0,'Interview yet to be done.');
                    }
                    
                        
                }
                else
                {
                    return createResponse($response,400,0,'No data found');
                }
            }
            else
            {
                return createResponse($response,400,0,'Please enter valid credetial');
            }
        }
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('getCandidatesMarksObtained');

$app->post('/v1.2/interviewDetailsEntry', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $params = json_decode($jsonData, true);
        
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
       
        if(empty($params['locations']))
        { 
            return createResponse($response,400,0,'Please enter interview locations');
        }
        
        if(empty($params['driveName']))
        { 
            return createResponse($response,400,0,'Please enter drive name');
        }
                $drive_name = trim($params['driveName']);
        /*
        if(empty($params['interviewCity']))
        { 
            return createResponse($response,400,0,'Please enter interview city');
        }
        $interview_city = trim($params['interviewCity']);
        
        if(empty($params['interviewPanel']))
        { 
            return createResponse($response,400,0,'Please enter interview panel details');
        }
        $interview_panel = trim($params['interviewPanel']);
        */
        

        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);
           
            if ( !empty($login_result) ) 
            {
                //Checking drive name 
                $drive_id = get_course_v1_2($db,$drive_name) ;
                
                if(empty($drive_id))
                {
                    return createResponse($response,400,0,'Please enter a valid driveName');
                }
                $locations = $params['locations'];
                $insertCount = 0;
                foreach ($locations as $single_locations) {
                    // json verification
                    if(!empty($single_locations['interviewAddress']) && !empty($single_locations['interviewCity'])
                        && !empty($single_locations['interviewState']) && !empty($single_locations['interviewPanel']))
                    {
                        //duplicate data verification
                        //Checking existing address data
                        $query = $db->prepare("SELECT  id as venue_id FROM candidate_venue_list 
                                                WHERE city = :city AND state = :state AND address=:address;
                                              ");

                        $query->execute(
                            array(
                                ':city'=> $single_locations['interviewCity'],
                                ':state'=> $single_locations['interviewState'],
                                ':address'=> $single_locations['interviewAddress'],
                            )
                        );
                        $result = $query->fetch(PDO::FETCH_ASSOC);

                        	
                        //pr($query->debugDumpParams());
                        if(empty($result['venue_id']))
                        {
                            unset($result);
                            
                            
                            //Panel Entry 
                            $panelEntry = 'Panel';
                            //Entering locations
                            $query = $db->prepare("INSERT INTO candidate_venue_list
                                        (city,address,state,interview_panel,interview_date,capacity,drive_id,created_time)
                                        VALUES(:interview_city,:interview_address,
                                        :interview_state,:interview_panel,:interview_date,:capacity,:drive_id,:created_time)");

                            try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                    array(
                                        ':interview_city' => $single_locations['interviewCity'],
                                        ':interview_state' => $single_locations['interviewState'],
                                        ':interview_address' => $single_locations['interviewAddress'],
                                        ':interview_date' => date('Y-m-d',$single_locations['interviewDate']),
                                        ':interview_panel' => $panelEntry,
                                        ':capacity'=> $single_locations['capacity'],
                                        ':drive_id' => $drive_id,
                                        ':created_time' => date('Y-m-d H:i:s')
                                    )
                                ); 
                                $location_id = $db->lastInsertId();
                                $db->commit(); 
                                multipleTeacherEntry($db,$single_locations['interviewPanel'],$location_id);
                                $insertCount++; 
                                

                                
                            } catch(PDOExecption $e) { 
                                //pr($e);
                                $db->rollback(); 
                                return createResponse($response,500,0,'Please try again');

                            } 
                            
                        }
                        
                    }
                }  
                if($insertCount > 0)
                {
                    $final_candidate_arr = array('insertCount'=>$insertCount);
                    return createResponse($response,200,1,$final_candidate_arr);
                }
                else
                {
                    return createResponse($response,400,0,'No data inserted,Please verify your json.');
                }
            }
            else
            {
                return createResponse($response,400,0,'Please enter valid credetial');
            }
        }
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('interviewDetailsEntry');

$app->post('/v1.2/singleInterviewDetailsEntry', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $params = json_decode($jsonData, true);
        
         if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        if(empty($params['interviewAddress']))
        { 

            return createResponse($response,400,0,'Please enter interview address');
        }
        $interview_address = trim($params['interviewAddress']);
        //pr($interview_address);die();
        
        if(empty($params['interviewCity']))
        { 
            return createResponse($response,400,0,'Please enter interview city');
        }
        $interview_city = trim($params['interviewCity']);
        
        if(empty($params['interviewPanel']))
        { 
            return createResponse($response,400,0,'Please enter interview panel details');
        }
        $interview_panel = trim($params['interviewPanel']);
        //pr($interview_panel);
        if(empty($params['interviewDate']))
        { 
            return createResponse($response,400,0,'Please enter interview date on YYYY/MM/DD format');
        }
        $interview_date = trim($params['interviewDate']);
        //pr($params);
        //print_r($application_id);die;
        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);

            if ( !empty($login_result) ) 
            {
                
                //Checking existing address data
                $query = $db->prepare("SELECT  id as venue_id FROM candidate_venue_map 
                                        WHERE city = :city;
                                      ");

                $query->execute(
                    array(
                        ':city'=> $interview_city
                    )
                );
                $result = $query->fetch(PDO::FETCH_ASSOC);
                
                
                if(!empty($result['venue_id']))
                { 
                    return createResponse($response,400,0,'Interview panel already exist for this application id.');
                }
                unset($result);
                $query = $db->prepare("INSERT INTO candidate_venue_list(city,address ,interview_panel,interview_date)
                    VALUES(:interview_city,:interview_address,:interview_panel,:interview_date)");
                
                    try { 
                        $db->beginTransaction(); 
                        $query->execute(
                            array(
                                ':interview_city' => $interview_city,
                                ':interview_address' => $interview_address,
                                ':interview_panel' => $interview_panel,
                                ':interview_date' => $interview_date
                            )
                        ); 
                        $db->commit(); 
                        
                        $last_insert_id = $db->lastInsertId();

                       
                    } catch(PDOExecption $e) { 
                        $db->rollback(); 
                        return createResponse($response,500,0,'Please try again');
                        
                    } 
                    
                      //pr($last_insert_id);

                            
               // if($last_insert_id))
                //{
                    //todo fix last insert id 
                    $final_candidate_arr = array('Success');
                    //$final_candidate_arr = get_canditate_details_v1($db,$result);
                    return createResponse($response,200,1,$final_candidate_arr);
                        
               // }
               // else
               // {
                    //return createResponse($response,400,0,'No data found');
               // }
            }
            else
            {
                return createResponse($response,400,0,'Please enter valid credetial');
            }
        }
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }   
})->setName('singleInterviewDetailsEntry');

$app->post('/v1.2/readApplicationData', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $params = json_decode($jsonData, true);
        
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        if(empty($params['admissionFormId']))
        { 
            return createResponse($response,400,0,'Please enter application id');
        }
        $application_id = trim($params['admissionFormId']);
            //print_r($application_id); die();

            if(!empty($username) && !empty($password))
            {   
               $db = getConnection();
               $login_result = login_check($db,$username,$password);
                if ( !empty($login_result) ) 
                {
                
                //Checking Candidate id
                    $query = $db->prepare("SELECT candidate_id FROM candidate_courses_map 
                                            WHERE id = :applicationid;
                                          ");
                        
                     $query->execute(
                        array(
                            ':applicationid' => $application_id
                        )
                    );
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    if(empty($result['candidate_id']))
                    { 
                        return createResponse($response,400,0,'Please enter a valid application id');
                    }
                    $candidate_id = $result['candidate_id'];
                    unset($result);
                        //print_r($candidate_id); die();

                        $query = $db->prepare("SELECT  dirty_flag as dirtyflag FROM candidate_details 
                                        WHERE id = :candidateid
                                      ");                       
                        $query->execute(
                            array(
                                ':candidateid' => $candidate_id
                            )
                        );
                        $result = $query->fetch(PDO::FETCH_ASSOC);

                        //print_r($result['dirtyflag']); die();

                            if($result['dirtyflag'] == 0)
                            { 
                                return createResponse($response,400,0,'The application already read.');
                            }
                            unset($result);
                            
                            
                            $query = $db->prepare("UPDATE candidate_details SET dirty_flag = :dirty WHERE id = :candidateid");
                            
                            try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                array(
                                    ':dirty' => 0,
                                    ':candidateid' => $candidate_id
                                    )
                                );
                                $db->commit(); 

                                $last_insert_id = $db->lastInsertId();

                            } catch(PDOExecption $e) { 
                                $db->rollback(); 
                                return createResponse($response,500,0,'Please try again');

                            } 
                            
                                $final_candidate_arr = array('application_id'=>$application_id);
                                return createResponse($response,200,1,$final_candidate_arr);
                }
                else
                {
                    return createResponse($response,400,0,'Please enter valid credetial');
                }

            }   
            else 
            {
                return createResponse($response,400,0,'Please enter username and password');
            }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('readApplicationData');

$app->post('/v1.2/updateDrive', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $params = json_decode($jsonData, true);
        
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }

        if(empty($params['driveName']))
        { 
            return createResponse($response,400,0,'Please enter driveName');
        }
        $drive_name = trim($params['driveName']);
//pr($program_id);
        $courseEndDate = convertDateTimeInput($params['formSubmissionLastDate'],'form submission last date ','date');
        if($courseEndDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$courseEndDate['data']);
        }
        $course_end_date = $courseEndDate['data'];
        
        //pr($course_end_date);
        if(!empty($username) && !empty($password))
        {   
               $db = getConnection();
               $login_result = login_check($db,$username,$password);
                if (!empty($login_result)) 
                {  
                    //Checking drive name 
                    $query = $db->prepare("SELECT id FROM courses WHERE drive_name = :drive_name;");
                    $query->execute(
                        array(
                            ':drive_name' => $drive_name
                        )
                    );
                    $result = $query->fetch(PDO::FETCH_ASSOC);

                    if(empty($result['id']))
                    { 
                        return createResponse($response,400,0,'Please enter a valid program id');
                    }
                    $course_id = $result['id'];
                    unset($result);
                        //print_r($candidate_id); die();
                    //if($alumni_flag == 1)
                    //{
                            $query = $db->prepare("UPDATE courses SET form_submission_last_date = :courseEndDate WHERE id = :courseid");
                            
                            try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                array(
                                    ':courseEndDate' => $course_end_date,
                                    ':courseid' => $course_id
                                    )
                                );
                                $last_insert_id = $db->lastInsertId();
                                $db->commit(); 

                                

                            } catch(PDOExecption $e) { 
                                $db->rollback(); 
                                return createResponse($response,500,0,'Please try again');

                            } 
                            
                                $final_candidate_arr = array('drive_name'=>$drive_name);
                                return createResponse($response,200,1,$final_candidate_arr);
                    //}
                    
                    return createResponse($response,400,0,'Please try again');
                }
                else
                {
                    return createResponse($response,400,0,'Please enter valid credetial');
                }
        }   
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('updateDrive');

$app->get('/v1.2/getAdmittedCandidates', function ($request, $response, $args) {
     try 
    {
        $params = $request->getParams();
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        if(empty($params['driveName']))
        { 
            return createResponse($response,400,0,'Please enter driveName');
        }
        $drive_name = trim($params['driveName']);
        
        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);

            if ( !empty($login_result) ) 
            {
                //Checking drive name 
                $course_id = get_course_v1_2($db,$drive_name) ;
                
                if(empty($course_id))
                {
                    return createResponse($response,400,0,'Please enter a valid driveName');
                }
                $query = $db->prepare("SELECT * FROM candidate_details where selected_flag = 1 and admission_flag = 1 and admission_payment_flag = 1"
                        . " and course_id = :course_id");
                $query->execute(array(
                            ':course_id' => $course_id
                        ));
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details_v1_2($db,$result,'','',1,1);
                    return createResponse($response,200,1,$final_candidate_arr);
                }
                else
                {
                    return createResponse($response,400,0,'No data found');
                }
            }
            else
            {
                return createResponse($response,400,0,'Please enter valid credetial');
            }
        }
        else 
        {
            return createResponse($response,400,0,'Please enter username and password');
        }
    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('getAdmittedCandidates');

$app->post('/v1.2/passoutCandidates', function ($request, $response, $args) {
     try 
    {
        
       //echo strtotime(date('Y-m-d')); die();
        $jsonData = $request->getBody();
        $params = json_decode($jsonData, true);
        
        if(!empty($params['username']))
        {
            $username = trim($params['username']);
        }
        if(!empty($params['password']))
        {
            $password = trim($params['password']);
        }
        //pr ($password); 
         if(empty($params['driveName']))
        { 
            return createResponse($response,400,0,'Please enter driveName');
        }
        $drive_name = trim($params['driveName']);

        if(empty($params['candidateList']))
        { 
            return createResponse($response,400,0,'Please enter candidate list');
        }

        //echo $drive_name ; die();
       
       

            if(!empty($username) && !empty($password))
            {   
               $db = getConnection();
               $login_result = login_check($db,$username,$password);
              // pr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
               if ( !empty($login_result) ) 
                { 
                    $request->getUri()->getPath();
                   // api_log_entry($db ,$request->getUri()->getPath(),'passoutCandidates','1.2',$params);
                    //echo $drive_name ;

                    //Checking drive name 
                    $drive_id = get_course_v1_2($db,$drive_name);
                    //echo $drive_id ; 
                   // echo $drive_name ; die();
                    if(empty($drive_id))
                    {
                        //pr ("1") ;
                        return createResponse($response,400,0,'Please enter a valid driveName');
                    }
                    //pr ("hi") ;
                    $candidate_list = $params['candidateList'];
                    $insertCount = 0;
                    //pr ($candidate_list) ;
                    foreach ($candidate_list as $single_candidate) 
                    {
                        $passoutDate = convertDateTimeInput($single_candidate['passoutDate'],'passout date','date');
                        if($passoutDate['responseCode'] != 200)
                        { 
                            return createResponse($response,400,0,$passout_date['data']);
                        }
                        $passout_date = $passoutDate['data'];
                        //pr($passout_date);
                        if(!empty($single_candidate['emailId']) && !empty($passout_date))
                        {
                            $query = $db->prepare("SELECT id, user_id FROM candidate_details WHERE email_id = :emailId AND course_id = :courseId ");
                             $query->execute(
                                array(
                                    ':emailId' => $single_candidate['emailId'],
                                    ':courseId' => $drive_id
                                )
                            );
                            $result = $query->fetch(PDO::FETCH_ASSOC);
                            //print_r($result); die();
                    
                            
                            if(empty($result['user_id']))
                            { 
                                return createResponse($response,400,0,'Please enter a valid email id');
                            }
                            $user_id = $result['user_id'];
                            //pr ($user_id) ;
                            //unset($result);
                                
                            // update icam_alumni_flag in users table
                            $query = $db->prepare("UPDATE users SET icam_alumni_flag = :icamalumniflag WHERE id = :userid");
                            
                            try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                array(
                                    ':icamalumniflag' => 1,
                                    ':userid' => $user_id
                                    )
                                );
                                $last_insert_id = $db->lastInsertId();
                                $db->commit(); 
                                $insertCount++;


                            } catch(PDOExecption $e) { 
                                $db->rollback(); 
                                return createResponse($response,500,0,'Please try again');

                            } 


                            if(empty($result['id']))
                            { 
                                return createResponse($response,400,0,'Please enter a valid email id');
                            }
                            $candidate_id = $result['id'];
                            //pr ($candidate_id) ;
                             unset($result);
                        // update passout date in candidate_details table
                            $query = $db->prepare("UPDATE candidate_details SET passout_date = :passoutDate WHERE  id = :candidateId");
                            
                            try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                array(
                                    ':passoutDate' => $passout_date,
                                    ':candidateId' => $candidate_id
                                    )
                                );
                                $last_insert_id = $db->lastInsertId();
                                $db->commit(); 
                                $insertCount++; 
                                //pr ($last_insert_id) ;

                            } catch(PDOExecption $e) { 
                                $db->rollback(); 
                                return createResponse($response,500,0,'Please try again');

                            } 
                        }
                    }
                       
                    if($insertCount > 0)
                    {

                         $final_candidate_arr = array('emailId'=>$single_candidate['emailId']);
                                return createResponse($response,200,1,$final_candidate_arr);

                                //pr($final_candidate_arr);
                    }
                    else
                    {
                        return createResponse($response,400,0,'Please try again');
                    }
                    
                }
                else
                {
                    return createResponse($response,400,0,'Please enter valid credetial');
                }
            }   
            else 
            {
                return createResponse($response,400,0,'Please enter username and password');
            }
    }
    catch (PDOException $e) {
       // pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('passoutCandidates');


function get_canditate_details_v1_2($db,$result,$fulldata='',$marksFlag='',$paymentFlag='',$admissionFlag='')
{
    foreach ($result as $singleCandidate)
    {
        $candidate_details_arr = getApplicationIdv1_2($db,$singleCandidate['id']);
        
        $candidate_details['admissionFormId'] = intval($candidate_details_arr['application_id']);
        $candidate_details['driveName'] = $candidate_details_arr['drive_name'];
        if(!empty($admissionFlag))
        {
            $candidate_details['registrationId'] = nullCheck($singleCandidate['registration_id']);
        }
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
            if(!empty($admissionFlag))
            {
                $course_fee_structure = getFeeStructurev1_2($db,$singleCandidate['course_id']);
                $query = $db->prepare("SELECT * FROM candidate_payment where candidate_id =:candidate_id and application_id=:application_id and term_id > 0");
                $query->execute(array(':candidate_id' => $singleCandidate['id'],':application_id'=>$candidate_details['admissionFormId']));
                $payment_details = $query->fetchAll(PDO::FETCH_ASSOC);
                $candidate_details['paymentForAdmittedCandidates'] = format_payment_details_v1_2($payment_details,$course_fee_structure);
            }
            else 
            {
                $query = $db->prepare("SELECT * FROM candidate_payment where candidate_id =:candidate_id and application_id=:application_id");
                $query->execute(array(':candidate_id' => $singleCandidate['id'],':application_id'=>$candidate_details['admissionFormId']));
                $payment_details = $query->fetch(PDO::FETCH_ASSOC);
                $candidate_details['paymentDetails'] = format_payment_details_v1_2($payment_details);
            }
                
        }
        
        if($fulldata == 1)
        {
            $candidate_details['portalCandidateDetails'] = format_candidate_details_v1_2($singleCandidate);
            $candidate_details['portalCandidateDetails']['userId'] = nullCheck(intval($candidate_details_arr['icam_user_id']));
            
            $query = $db->prepare("SELECT * FROM qualification_details where candidate_id =:candidate_id");
            $query->execute(array(':candidate_id' => $singleCandidate['id']));
            $qualification_details = $query->fetchAll(PDO::FETCH_ASSOC);
            $candidate_details['qualificationDetails'] = format_acamdemic_qualification($qualification_details);

            $query = $db->prepare("SELECT * FROM professional_details where candidate_id =:candidate_id");
            $query->execute(array(':candidate_id' => $singleCandidate['id']));
            $professional_details = $query->fetchAll(PDO::FETCH_ASSOC);
            $candidate_details['professionalDetails'] = format_professional_qualification($professional_details);
            
            if(!empty($admissionFlag))
            {
                //pr($singleCandidate['course_id']);
                $course_fee_structure = getFeeStructurev1_2($db,$singleCandidate['course_id']);
                $query = $db->prepare("SELECT * FROM candidate_payment where candidate_id =:candidate_id and application_id=:application_id and term_id > 0");
                $query->execute(array(':candidate_id' => $singleCandidate['id'],':application_id'=>$candidate_details['admissionFormId']));
                $payment_details = $query->fetchAll(PDO::FETCH_ASSOC);
                $candidate_details['paymentForAdmittedCandidates'] = format_payment_details_v1_2($payment_details,$course_fee_structure);
            }
            else 
            {
                $query = $db->prepare("SELECT * FROM candidate_payment where candidate_id =:candidate_id and application_id=:application_id");
                $query->execute(array(':candidate_id' => $singleCandidate['id'],':application_id'=>$candidate_details['admissionFormId']));
                $payment_details = $query->fetch(PDO::FETCH_ASSOC);
                $candidate_details['paymentDetails'] = format_payment_details_v1_2($payment_details);
            }
            
            //$candidate_details['paymentDetails'] = format_payment_details_v1_2($payment_details);
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

function getApplicationIdv1_2($db,$candidate_id = '') {
        
        //$query = $db->prepare("SELECT id FROM candidate_courses_map where candidate_id =:candidate_id");
        $query = $db->prepare("SELECT candidate_courses_map.id as application_id ,courses.drive_name , courses.program_id,courses.program_code,users.icam_user_id FROM candidate_courses_map "
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

function getFeeStructurev1_2($db,$course_id) {
        
        //$query = $db->prepare("SELECT id FROM candidate_courses_map where candidate_id =:candidate_id");
        $query = $db->prepare("SELECT * from courses_fee_structure where course_id = :course_id");
        
        $query->execute(array(':course_id' => $course_id));
        $fee_arr = $query->fetchAll(PDO::FETCH_ASSOC);
        
        if(!empty($fee_arr))
        {
            return $fee_arr;
        }
        else 
        {
            return FALSE;
        }
}

function format_payment_details_v1_2($param,$fee_structure='') 
{
    if(!empty($param))
    {
        if(!empty($fee_structure))
        {
            for($j=0;$j<count($param);$j++)
            {
                $payment_arr[$param[$j]['term_id']][$param[$j]['payment_fee_type']] = $param[$j];
            }
            for($i=0;$i<count($fee_structure);$i++)
            {
                if(!empty($payment_arr[$fee_structure[$i]['term_id']][$fee_structure[$i]['fee_type']]))
                {
                    $result_param[$i]['termId'] = $fee_structure[$i]['term_id'];
                    $result_param[$i]['termName'] = $fee_structure[$i]['term_name'];
                    $result_param[$i]['feesCategory'] = $fee_structure[$i]['fee_type'];
                    $result_param[$i]['totalAmountToPay'] = $fee_structure[$i]['general_fee'];
                    $result_param[$i]['invoiceId'] = $payment_arr[$fee_structure[$i]['term_id']][$fee_structure[$i]['fee_type']]['invoice_id'];
                    $result_param[$i]['paymentAmount'] = floatval($payment_arr[$fee_structure[$i]['term_id']][$fee_structure[$i]['fee_type']]['amount']);
                    $result_param[$i]['paymentDate'] = convertDateTime($payment_arr[$fee_structure[$i]['term_id']][$fee_structure[$i]['fee_type']]['created_date']);
                }
                
                
            }
        }
        else 
        {
            $result_param['invoiceId'] = intval($param['invoice_id']);
            $result_param['paymentMethod'] = $param['payment_type'];
            $result_param['paymentAmount'] = floatval($param['amount']);
            $result_param['paymentDate'] = convertDateTime($param['created_date']);
        }
        
        return $result_param;
    }
    else 
    {
        return NULL;
    }
}

function format_candidate_details_v1_2($param) 
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

function get_course_v1_2($db,$param) 
{
    if(!empty($param))
    {
        //pr($param);
        $query = $db->prepare("SELECT id FROM courses WHERE drive_name = :drive_name;");
                $query->execute(
                            array(
                                ':drive_name' => $param
                            )
                        );
                $result_course = $query->fetch(PDO::FETCH_ASSOC);
                $course_id = $result_course['id'];
                //pr($result_course['drive_name']);
    }
    if(!empty($course_id))
    {
        return $course_id;
    }
    return FALSE;
}

function check_existing_drive_v1_2($db,$drive_name) 
{
    if(!empty($drive_name))
    {
        $query = $db->prepare("SELECT id FROM courses WHERE drive_name = :drive_name ");
        $query->execute(
                        array(
                            ':drive_name' => $drive_name
                            
                        )
                    );
        $result_course= $query->fetch(PDO::FETCH_ASSOC);
        $course_id = $result_course['id'];
    }
    
        
    if(!empty($course_id))
    {
        return $course_id;
    }
    
    return FALSE;
}
function check_existing_program_v1_2($db,$drive_name,$program_code) 
{
    if(!empty($drive_name) && !empty($program_code))
    {
        if(!empty($course_id))
        {
            $query = $db->prepare("SELECT id FROM courses WHERE program_code = :program_code AND form_submission_last_date > now()");
            $query->execute(
                            array(
                                ':program_code' => $program_code,
                            )
                        );
            $result_course= $query->fetch(PDO::FETCH_ASSOC);
            $course_id = $result_course['id'];
        }
    }
    return FALSE;
}

function api_log_entry($db,$url,$api_name,$version,$jsonData) 
{
    //pr($jsonData);
    if ( !empty($url) && !empty($api_name) && !empty($version) && !empty($jsonData)) 
        {
            pr($_SERVER['HTTP_HOST']);
            try {
                //pr("hi");
                $query = $db->prepare("INSERT api_request_log SET url = :url, api_name = :api_name, version = :version, request_json=:jsonData, domain = :domain, , created_date = now(), modified_date =  now()");
                
                    $db->beginTransaction(); 
                    $query->execute(
                        array(
                            ':url' => $url,
                            ':api_name' => $api_name,
                            ':version' => $version,
                            ':jsonData' =>json_encode($jsonData),
                            ':domain' => $_SERVER['HTTP_HOST']
                        )
                    );
                    $logid = $db->lastInsertId(); 
                    $db->commit(); 
                    pr($logid);
                } 
                catch(PDOExecption $e) { 
                    //pr($e);
                    $db->rollback(); 
                    //return createResponse($response,500,0,'Please try again');
                }
        }
        if(!empty($logid))
        {
            pr("hi");
            return $logid;
        }
        return FALSE;                   
}

?>
