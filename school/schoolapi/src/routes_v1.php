<?php

// Routes

/*$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
 * */

// Get ALL routes
// --------------
$allRoutes = [];
$routes = $app->getContainer()->router->getRoutes();

foreach ($routes as $route) {
  array_push($allRoutes, $route->getPattern());
}

$container['allRoutes'] = $allRoutes;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get('/[check]', function ($request, $response, $args) {
    $name =array('status'=>200);
if($name) {
    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($name));

} else { throw new PDOException('No records found');}
    
});

//$app -> get('/rss/', function() use ($app) {
$app->get('/v1/getPublishedCourse.xml', function ($request, $response, $args) use($app) {
    
    //pr('hi');
    //$articles = Model::factory('Article') -> order_by_desc('timestamp') -> find_many();
    $db = getConnection();
    $query = $db->prepare("SELECT course_link,program_name,details FROM courses "
            . "WHERE form_issuance_date <= CURDATE() and form_submission_last_date >= CURDATE() "
            . "ORDER BY form_submission_last_date");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
    $display_xml = '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL.
                    '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">'.PHP_EOL;

    if(!empty($result))
    {
        $display_xml.= '<channel>'.PHP_EOL.
                '<title>2017 Apllications  </title>'.PHP_EOL.
                '<link>http://'.$_SERVER['HTTP_HOST'].'/icamapi/icamapi/public/v1/getPublishedCourse</link>'.PHP_EOL.
                '<description>Course Description</description>'.PHP_EOL.
                '<atom:link href="http://'.$_SERVER['HTTP_HOST'].'/icamapi/icamapi/public/v1/getPublishedCourse" rel="self" type="application/rss+xml"  />  '.PHP_EOL.
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

$app->get('/v1/getPublishedNotice.xml', function ($request, $response, $args) use($app) {

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
                '<atom:link href="http://'.$_SERVER['HTTP_HOST'].'/icamapi/icamapi/public/v1/getPublishedNotice.xml" rel="self" type="application/rss+xml"  />  '.PHP_EOL.
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

$app->post('/v1/insertNotice', function ($request, $response, $args) {
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

$app->post('/v1/insertCourseData', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $params = json_decode($jsonData, true);
        // pr($params['semesterAndFees']);
        $username = trim($params['username']);
        $password = trim($params['password']);
        if(empty($params['programId']))
        { 
            return createResponse($response,400,0,'Please enter Program Id');
        }
        $program_id = trim($params['programId']);
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
                $query = $db->prepare("INSERT courses SET program_id = :programId,program_name = :programName, program_type = :programType, "
                        . "form_fees=:form_fees ,total_seat = :totalSeat, form_issuance_date = :formIssuanceDate, form_submission_last_date = :formSubmissionLastDate, "
                        . "candidate_scrutiny_date = :candidateScrutinyDate, interview_date = :interviewDate, "
                        . "marks_submission_date = :marksSubmissionDate, fees_payment_start_date = :feesPaymentStartDate, "
                        . "fees_payment_end_date = :feesPaymentEndDate ,course_link = :course_link , name = :name,created_date=:created_date");

                        try { 
                                $db->beginTransaction(); 
                                $query->execute(
                                    array(
                                        ':programId' => $program_id,
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
                                        ':course_link'=>  strtolower(preg_replace("/[^a-zA-Z]/", "", $program_name)),
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
                                    
                                    $query = $db->prepare("INSERT INTO courses_fee_structure(course_id,program_id ,
                                    term_name,fee_type,term_id,general_fee,st_fee,sc_fee,obc_fee,created_date,modified_date)
                                    VALUES(:course_id,:program_id ,
                                    :term_name,:feeType,:term_id,:general_fee,:st_fee,:sc_fee,:obc_fee,
                                    :created_date,:modified_date)");

                                        try { 
                                            $db->beginTransaction(); 
                                            $query->execute(
                                                array(
                                                    ':course_id' => $course_id,
                                                    ':program_id' => $program_id,
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
                                
                                return createResponse($response,200,1,array('program_id'=>$program_id));
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
        //pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('insertCourseData');

$app->get('/v1/getNewCandidates', function ($request, $response, $args) {
     try 
    {
        $params = $request->getParams();
        $username = trim($params['username']);
        $password = trim($params['password']);
        if(!empty($username) && !empty($password))
        {   
           $db = getConnection();
           $login_result = login_check($db,$username,$password);

            if ( !empty($login_result) ) 
            {
                $query = $db->prepare("SELECT * FROM candidate_details 
                                        WHERE payment_flag = 1 AND new_registration_flag = 1
                                      ");
                    
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details($db,$result,1);
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

$app->get('/v1/getScrutinizedCandidates', function ($request, $response, $args) {
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
                $query = $db->prepare("SELECT * FROM candidate_details 
                                        WHERE dirty_flag = 1 AND scrutiny_flag = 1 AND 	interview_ready_flag = 0
                                      ");
                    
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details($db,$result);
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

$app->get('/v1/getSelectedCandidates', function ($request, $response, $args) {
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
                $query = $db->prepare(" SELECT * FROM candidate_details WHERE selected_flag > 0 ");
                    
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details($db,$result,'',1);
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

$app->get('/v1/getCandidatesMarksObtained', function ($request, $response, $args) {
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

$app->post('/v1/interviewDetailsEntry', function ($request, $response, $args) {
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
       
        if(empty($params['locations']))
        { 
            return createResponse($response,400,0,'Please enter interview locations');
        }

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
                                        (city,address,state,interview_panel,interview_date,capacity,created_time)
                                        VALUES(:interview_city,:interview_address,
                                        :interview_state,:interview_panel,:interview_date,:capacity,:created_time)");

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
                                        ':created_time' => date('Y-m-d H:i:s')
                                    )
                                ); 
                                $location_id = $db->lastInsertId();
                                $db->commit(); 
                                multipleTeacherEntry($db,$single_locations['interviewPanel'],$location_id);
                                $insertCount++; 
                                

                                
                            } catch(PDOExecption $e) { 
                                pr($e);
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

$app->post('/v1/singleInterviewDetailsEntry', function ($request, $response, $args) {
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
                    //$final_candidate_arr = get_canditate_details($db,$result);
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

$app->post('/v1/readApplicationData', function ($request, $response, $args) {
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

$app->post('/v1/updateCourse', function ($request, $response, $args) {
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

        if(empty($params['programId']))
        { 
            return createResponse($response,400,0,'Please enter program id');
        }
        $program_id = trim($params['programId']);
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
                //Checking Program id
                    $query = $db->prepare("SELECT id FROM courses WHERE program_id = :programId;");
                    $query->execute(
                        array(
                            ':programId' => $program_id
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
                            
                                $final_candidate_arr = array('programId'=>$program_id);
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
    
})->setName('updateCourse');

$app->get('/v1/getAdmittedCandidates', function ($request, $response, $args) {
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
                $query = $db->prepare("SELECT * FROM candidate_details where selected_flag =1 and admission_flag = 1 and admission_payment_flag = 1");
                $query->execute();
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                if(!empty($result))
                {
                    $final_candidate_arr = get_canditate_details($db,$result,'','',1);
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
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('getAdmittedCandidates');

function login_check($db,$username,$password)
{
   /* $query = $db->prepare("SELECT username FROM users
                                  WHERE username = :user AND password = :pass
                                  LIMIT 1");
                                  */
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

$app->post('/v1/postAlumniCandidates', function ($request, $response, $args) {
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

        if(empty($params['emailId']))
        { 
            return createResponse($response,400,0,'Please enter email id');
        }
        $email_id = trim($params['emailId']);

        $passoutDate = convertDateTimeInput($params['passoutDate'],'passout date','date');
        if($passoutDate['responseCode'] != 200)
        { 
            return createResponse($response,400,0,$passoutDate['data']);
        }
        $passout_date = $passoutDate['data'];
        
        if(empty($params['programId']))
        { 
            return createResponse($response,400,0,'Please enter program id');
        }
        
        //alumni flag handling
        $alumni_flag = 1;
        if(!empty($params['alumniFlag']) && $params['alumniFlag'] == 2)
        { 
            $alumni_flag = 2;
        }

            if(!empty($username) && !empty($password))
            {   
               $db = getConnection();
               $login_result = login_check($db,$username,$password);
                if ( !empty($login_result) ) 
                {
                
                //Checking Candidate id
                    $query = $db->prepare("SELECT user_id FROM candidate_details 
                                            WHERE email_id = :emailId;
                                          ");
                     $query->execute(
                        array(
                            ':emailId' => $email_id
                        )
                    );
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    if(empty($result['user_id']))
                    { 
                        return createResponse($response,400,0,'Please enter a valid email id');
                    }
                    $user_id = $result['user_id'];
                    unset($result);
                        //print_r($candidate_id); die();
                    if($alumni_flag == 1)
                    {
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

                                

                            } catch(PDOExecption $e) { 
                                $db->rollback(); 
                                return createResponse($response,500,0,'Please try again');

                            } 
                            
                                $final_candidate_arr = array('emailId'=>$email_id);
                                return createResponse($response,200,1,$final_candidate_arr);
                    }
                    
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
    
})->setName('postAlumniCandidates');

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
        $query = $db->prepare("SELECT candidate_courses_map.id as application_id , courses.program_id,users.icam_user_id FROM candidate_courses_map "
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
        $domain = strtolower($_SERVER['HTTP_HOST']);

	switch($domain) {
	case 'qtsin.com' :
        case 'qtsin.net' :
		$_SERVER['CI_ENV'] = 'production';
	break;
	case 'nism.dev' :
		$_SERVER['CI_ENV'] = 'testing';
	break;
        case 'demo1.qtsin.net' :
		$_SERVER['CI_ENV'] = 'demo1';
	break;
        case 'demo2.qtsin.net' :
		$_SERVER['CI_ENV'] = 'demo2';
	break;
        case 'demo3.qtsin.net' :
		$_SERVER['CI_ENV'] = 'demo3';
	break;
        case 'demo4.qtsin.net' :
		$_SERVER['CI_ENV'] = 'demo4';
	break;
        case 'dev.qtsin.net' :
		$_SERVER['CI_ENV'] = 'devdemo';
        case 'dev1.qtsin.net' :
		$_SERVER['CI_ENV'] = 'devdemo1';
	break;
        case 'dev2.qtsin.net' :
		$_SERVER['CI_ENV'] = 'devdemo2';
	break;
        case 'dev3.qtsin.net' :
		$_SERVER['CI_ENV'] = 'devdemo3';
	break;
        case 'test.qtsin.net' :
		$_SERVER['CI_ENV'] = 'testdemo';
	break;
        case 'test1.qtsin.net' :
		$_SERVER['CI_ENV'] = 'testdemo1';
	break;
        case 'test2.qtsin.net' :
		$_SERVER['CI_ENV'] = 'testdemo2';
	break;
        case 'test3.qtsin.net' :
		$_SERVER['CI_ENV'] = 'testdemo3';
	break;
        case '11.0.2.158' :
        case 'icamdemo.com' :
        case 'http://icamdemo.com' :  
        case 'www.icamdemo.com' : 
		$_SERVER['CI_ENV'] = 'awsdemo';
        break;
	default :
		$_SERVER['CI_ENV'] = 'development';
	break;
	}

	define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
        
        switch (ENVIRONMENT)
        {
            case 'development':
                    error_reporting(-1);
                    ini_set('display_errors', 1);
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'root');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', '');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal');
            break;

            case 'testing':
                    ini_set('display_errors', 0);
                    if (version_compare(PHP_VERSION, '5.3', '>='))
                    {
                            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
                    }
                    else
                    {
                            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
                    }
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'root');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', '');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal');
            case 'production':
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal');
            break;
            case 'demo1': 
                    # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_demo1');

                    break; 

            case 'demo2': 
            # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_demo2');

            break; 

            case 'demo3': 
            # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_demo3');

            break; 

            case 'demo4': 
            # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_demo4');

            case 'devdemo': 
                    # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_dev');

            break;
            case 'devdemo1': 
                    # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_dev1');

            break;
            case 'devdemo2': 
                    # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_dev2');

            break;
            case 'devdemo3': 
                    # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_dev3');

            break;
            case 'testdemo': 
                # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_test');

            break;
            case 'testdemo1': 
                # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_test1');

            break;
            case 'testdemo2': 
                # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_test2');

            break;
            case 'testdemo3': 
                # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
                    defined('DB_USER')      ? null : define('DB_USER', 'icam_portal_db');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'h79Ox7S$zTTl');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icam_portal_test3');

            break;
        
            case 'awsdemo': 
        
                    # DB 
                    defined('DB_HOST')      ? null : define('DB_HOST', 'icam-web-iq-db.ch6tvtyjtsqa.ap-south-1.rds.amazonaws.com');
                    defined('DB_USER')      ? null : define('DB_USER', 'icamwebiqdb');
                    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'Jg68qa71');
                    defined('DB_NAME')      ? null : define('DB_NAME', 'icamwebiqdb');
                    break;
            default:
                    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                    echo 'The application environment is not found.';
                    exit(1); // EXIT_ERROR
    }
    
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
    if(empty($status))
    {
        $status = 400;
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

//Display data null checking
function convertDate($param)
{
    //echo $param;die;
    if(!empty($param) && !empty(strtotime($param)))
    {
        return date('Y-m-d H:i:s',$param);
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


