<?php
$app->get('/v1/check', function ($request, $response, $args) use($app) {
    return createResponse($response,200,1,"Welcome to Demo School API verson 1.0");
})->setName('check');


$app->post('/v1/sendBasicDetailsOfCadet', function ($request, $response, $args) {
    try 
    {
         /* @var $reques Psr\Http\Message\ServerRequestInterface */
         //$users = Student::all()->toArray();
         
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password',
                    'firstName','lastName','standard','admissionDrive',
        'formId','rollNumber','dateOfBirth','admissisonDate','gender','bloodGroup','category',
          'nationality','fatherFirstName','guardianFirstName','guardianLastName',
                    'address'));
        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }
        //Student::find()
        $rollNumberCheck = Student::firstOrNew(['rollNumber' => $requestParams['rollNumber']]);

        if(!empty($rollNumberCheck->id))
        {
            return createResponse($response,400,0,"Student already exist.");
        }
        
        $user = Users::create(
                [   'first_name' => $requestParams['firstName'],
                    'middle_name' => $requestParams['middle_name'],
                    'last_name' => $requestParams['lastName'],
                    'email_id' =>$requestParams['email'],
                    'username' =>$requestParams['rollNumber'],
                    'password' =>md5('welcome'),
                    'status' => 1
                ])
                ;
        if(empty($user->id))
        {
            return createResponse($response,400,0,"Student already exist.");
        }
        UserGroup::create(
                [  
                    'user_id' => $user->id,
                    'group_id' => 2
                ]);
        
        $studentDetails = Student::create(
                [   'userId' => $user->id,
                    'firstName' => $requestParams['firstName'],
                    'middleName' => $requestParams['middleName'],
                    'lastName' => $requestParams['lastName'],
                    'standard' =>$requestParams['standard'],
                    'admissionDrive' =>$requestParams['admissionDrive'],
                    'formId' =>$requestParams['formId'],
                    'rollNumber' =>$requestParams['rollNumber'],
                    'dateOfBirth' => convertDateTimeSting($requestParams['dateOfBirth']),
                    'admissisonDate' =>convertDateTimeSting($requestParams['admissisonDate']),
                    'gender' =>$requestParams['gender'],
                    'bloodGroup' =>$requestParams['bloodGroup'],
                    'category' =>$requestParams['category'],
                    'religion' =>$requestParams['religion'],
                    'motherTongue' =>$requestParams['motherTongue'],
                    'aadharNumber' =>$requestParams['aadharNumber'],
                    'nationality' =>$requestParams['nationality'],
                    'childId' =>$requestParams['childId'],
                    'house' =>$requestParams['house'],
                    'stateOfDomicile' =>$requestParams['stateOfDomicile'],
                    'scholarship' =>$requestParams['scholarship'],
                    'bankName' =>$requestParams['bankName'],
                    'branch' =>$requestParams['branch'],
                    'accountNumber' =>$requestParams['accountNumber'],
                    'medicalStatus' =>$requestParams['medicalStatus'],
                    'email' =>$requestParams['email'],
                    'fatherFirstName' =>$requestParams['fatherFirstName'],
                    'fatherMiddleName' =>$requestParams['fatherMiddleName'],
                    'fatherLastName' =>$requestParams['fatherLastName'],
                    'fatherServiceStatus' =>$requestParams['fatherServiceStatus'],
                    'fatherDefenceCategory' =>$requestParams['fatherDefenceCategory'],
                    'fatherRank' =>$requestParams['fatherRank'],
                    'fatherMobile' =>$requestParams['fatherMobile'],
                    'fatherEmail' =>$requestParams['fatherEmail'],
                    'motherFirstName' =>$requestParams['motherFirstName'],
                    'motherMiddleName' =>$requestParams['motherMiddleName'],
                    'motherLastName' =>$requestParams['motherLastName'],
                    'motherMobile' =>$requestParams['motherMobile'],
                    'motherEmail' =>$requestParams['motherEmail'],
                    'guardianFirstName' =>$requestParams['guardianFirstName'],
                    'guardianMiddleName' =>$requestParams['guardianMiddleName'],
                    'guardianLastName' =>$requestParams['guardianLastName'],
                    'guardianMobile' =>$requestParams['guardianMobile'],
                    'guardianEmail' =>$requestParams['guardianEmail'],
                    'fatherIncome' =>$requestParams['fatherIncome'],
                    'motherIncome' =>$requestParams['motherIncome'],
                    'studentIncome' =>$requestParams['studentIncome'],
                    'familyIncome' =>$requestParams['familyIncome'],
                    'address' => json_encode($requestParams['address']),
                    'foodPreference' =>$requestParams['foodPreference'],
                    'firstPickUpPlace' =>$requestParams['firstPickUpPlace'],
                    'hobbies' =>$requestParams['hobbies'],
                    'personalIdentificationMark' =>$requestParams['personalIdentificationMark'],
                    'previousSchoolName' =>$requestParams['previousSchoolName'],
                    'previousSchoolWebsite' =>$requestParams['previousSchoolWebsite'],
                    'previousSchoolAddress' =>$requestParams['previousSchoolAddress'],
                    'previousSchoolPhone' =>$requestParams['previousSchoolPhone'],
                    'previousSchoolEmail' =>$requestParams['previousSchoolEmail'],
                    'previousAchivement' =>$requestParams['previousAchivement'],
                    
                ]);
        if(empty($studentDetails->id))
        {
            return createResponse($response,400,0,"Some error occured.Please try again !!");
        }
        else
        {
            return createResponse($response,200,1,array('standard'=>$requestParams['standard']
                                        ,'rollNumber'=>$requestParams['rollNumber']));
        }
         

    }
    catch (PDOException $e) {
        error_log(var_export($e,1));
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendBasicDetailsOfCadet');

$app->post('/v1/sendFeesPaymentDetailsForCadet', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','academicSession','rollNumber','standardName'
                    ));
        //echo convertDateTimeSting($requestParams['dateOfBirth']);die;
        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }
        //Student::find()
        $rollNumberCheck = Student::firstOrNew(['rollNumber' => $requestParams['rollNumber']]);

        if(empty($rollNumberCheck->id))
        {
            return createResponse($response,400,0,"Student does not exist.");
        }
        
        $studentFeeDetails = StudentSessionFees::create(
                [   'academicSession' => $requestParams['academicSession'],
                    'standardName' => $requestParams['standardName'],
                    'sectionName' => $requestParams['sectionName'],
                    'rollNumber' =>$requestParams['rollNumber'],
                    'fees' => json_encode($requestParams['fees']),
                ]);
        if(empty($studentFeeDetails->id))
        {
            return createResponse($response,400,0,"Some error occured.Please try again !!");
        }
        else
        {
            return createResponse($response,200,1,array('standard'=>$requestParams['standardName']
                                        ,'section'=>$requestParams['sectionName'],
                                        'rollNumber'=>$requestParams['rollNumber']
                    ));
        }
         

    }
    catch (PDOException $e) {
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendFeesPaymentDetailsForCadet');

$app->post('/v1/sendExamMarksOfCadet', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','standard','section','subject','academicYear'
                    ));

        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }
       
        $students = $requestParams['students'];
        $successNumber = 0;
        for($i=0;$i<count($students);$i++)
        {
            $rollNumberCheck = Student::firstOrNew(['rollNumber' => $students[$i]['rollNumber']]);

            if(!empty($students[$i]['rollNumber']) && !empty($rollNumberCheck->id) &&
                    !empty($students[$i]['status']) && !empty($students[$i]['name']))
            {
                $studentMarksDetails = StudentMarks::create(
                [   'standard' => $requestParams['standard'],
                    'section' => $requestParams['section'],
                    'subject' => $requestParams['subject'],
                    'exam' =>trim($requestParams['exam']),
                    'academicYear' => $requestParams['academicYear'],
                    'rollNumber' =>$students[$i]['rollNumber'],
                    'name' =>$students[$i]['name'],
                    'theoryTotal' => intCheck($students[$i]['theoryTotal']),
                    'practicalTotal' =>intCheck($students[$i]['practicalTotal']),
                    'theoryObtained' =>intCheck($students[$i]['theoryObtained']),
                    'practicalObtained' =>intCheck($students[$i]['practicalObtained']),
                    'theoryObtained' =>intCheck($students[$i]['theoryObtained']),
                    'status' =>$students[$i]['status']
                ]);
                
                if(!empty($studentMarksDetails->id))
                {
                    $successNumber = $successNumber+1;
                    $successArr[]= $students[$i]['rollNumber'];
                }
                else 
                {
                    $failedArr[]= $students[$i]['rollNumber'];
                }
            }
        
        }
        
        if($successNumber == 0)
        {
            return createResponse($response,400,0,"Invalid request.Unable to parse.Please verify the roll number and other parameters !!");
        }
        else
        {
            return createResponse($response,200,1,array('standard'=>$requestParams['standard']
                                        ,'section'=>$requestParams['section'],
                                        'exam'=>$requestParams['exam'],
                                        'successRollNumbers'=> $successArr
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendExamMarksOfCadet');

$app->post('/v1/appliedLeaveOfCadet', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','rollNumber','days','reason'
                    ));

        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }

        $rollNumberCheck = Student::firstOrNew(['rollNumber' => $requestParams['rollNumber']]);

        if(empty($rollNumberCheck->id))
        {
            return createResponse($response,400,0,"Student does not exist.");
        }
        
        $leaveDates= $requestParams['days'];
        $successNumber = 0;
        for($i=0;$i<count($leaveDates);$i++)
        {
            $leaveDate = convertDateTimeSting($leaveDates[$i], 'date');
            if(!empty($leaveDates[$i]) && !empty($leaveDate))
            {
                $studentMarksDetails = StudentLeave::create(
                [   'rollNumber' => $requestParams['rollNumber'],
                    'reason' => $requestParams['reason'],
                    'leaveDate' =>$leaveDate
                ]);
                
                if(!empty($studentMarksDetails->id))
                {
                    $successNumber = $successNumber+1;
                    $successArr[]= $students[$i]['rollNumber'];
                }
                else 
                {
                    $failedArr[]= $students[$i]['rollNumber'];
                }
            }
        
        }
        
        if($successNumber == 0)
        {
            return createResponse($response,400,0,"Invalid request.Unable to parse.Please verify :days  !!");
        }
        else
        {
            return createResponse($response,200,1,array('rollNumber'=>$requestParams['rollNumber']
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('appliedLeaveOfCadet');

$app->post('/v1/updateHostelOfCadet', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','rollNumber','house'
                    ));

        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }

        $rollNumberCheck = Student::firstOrNew(['rollNumber' => $requestParams['rollNumber']]);

        if(empty($rollNumberCheck->id))
        {
            return createResponse($response,400,0,"Student does not exist.");
        }
        
        
        $studentHostelDetails = StudentHostel::create(
        [   'rollNumber' => $requestParams['rollNumber'],
            'house' => $requestParams['house']
        ]);
                
                
        
        if(empty($studentHostelDetails->id))
        {
            return createResponse($response,400,0,"Invalid request.Unable to parse.");
        }
        else
        {
            return createResponse($response,200,1,array('rollNumber'=>$requestParams['rollNumber'],
                'house' => $requestParams['house']
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('updateHostelOfCadet');


$app->post('/v1/sendCommentOnStudent', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','standard','section','rollNumber','comment'
                    ));

        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }

        $rollNumberCheck = Student::firstOrNew(['rollNumber' => $requestParams['rollNumber']]);

        if(empty($rollNumberCheck->id))
        {
            return createResponse($response,400,0,"Student does not exist.");
        }
        
        
        $studentHostelDetails = StudentComment::create(
        [   'rollNumber' => $requestParams['rollNumber'],
            'standard' => $requestParams['standard'],
            'section' => $requestParams['section'],
            'comment' => $requestParams['comment']
        ]);
                
                
        
        if(empty($studentHostelDetails->id))
        {
            return createResponse($response,400,0,"Invalid request.Unable to parse.");
        }
        else
        {
            return createResponse($response,200,1,array('rollNumber'=>$requestParams['rollNumber']
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendCommentOnStudent');

$app->post('/v1/updateStandardSectionForCadet', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','standard','section','rollNumbers'
                    ));

        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }
       
        $students = $requestParams['rollNumbers'];
        $successNumber = 0;
        for($i=0;$i<count($students);$i++)
        {
            $rollNumberCheck = Student::firstOrNew(['rollNumber' => $students[$i]]);

            if(!empty($students[$i]) && !empty($rollNumberCheck->id))
            {
                $studentSectionDetails = StudentSection::create(
                [   'standard' => $requestParams['standard'],
                    'section' => $requestParams['section'],
                    'rollNumber' =>$students[$i]
                ]);
                
                if(!empty($studentSectionDetails->id))
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
        
        if($successNumber == 0)
        {
            return createResponse($response,400,0,"Invalid request.Unable to parse.Please verify the roll number and other parameters !!");
        }
        else
        {
            return createResponse($response,200,1,array('standard'=>$requestParams['standard']
                                        ,'section'=>$requestParams['section'],
                                        'successRollNumbers'=> $successArr
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('updateStandardSectionForCadet');

$app->post('/v1/sendDailyAttendanceOfCadet', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','standard','section','attendanceDate'
                    ));

        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }
        $attendanceDate =   convertDateTimeSting($requestParams['attendanceDate'],'date');  
        
        if(empty($attendanceDate))
        {
            return createResponse($response,400,0,"Please Enter a valide date in EPOCH format");
        }
        $successNumber = 0;
        $successArr=array();
        $successArr['rollNumbersPresent'] = processAttendanse($attendanceDate,$requestParams['rollNumbersPresent'],$requestParams,1);
        $successArr['rollNumbersOnLeave'] = processAttendanse($attendanceDate,$requestParams['rollNumbersOnLeave'],$requestParams,2);
        $successArr['rollNumbersAbsent'] = processAttendanse($attendanceDate,$requestParams['rollNumbersAbsent'],$requestParams,3);
        
        if(empty($successArr['rollNumbersPresent']) && empty($successArr['rollNumbersOnLeave'])
                && empty($successArr['rollNumbersAbsent']))
        {
            return createResponse($response,400,0,"Invalid request.Unable to parse.Please verify the roll number and other parameters !!");
        }
        else
        {
            return createResponse($response,200,1,array('standard'=>$requestParams['standard']
                                        ,'section'=>$requestParams['section'],
                                        'successRollNumbers'=> $successArr
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendDailyAttendanceOfCadet');


?>
