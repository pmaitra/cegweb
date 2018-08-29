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
                    'address','courseCode'));
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
                    'dateOfBirth' =>convertDateTimeSting($requestParams['dateOfBirth']),
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
                    'courseCode'=>$requestParams['courseCode'],
                    'contactNumber'=>$requestParams['contactNumber']
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
        return createResponse($response,201,0,'Please try again');
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
                array('username','password','rollNumber','days','reason','approver','academicsSession'
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
        $sessionId = getSession($requestParams['academicsSession']);
        for($i=0;$i<count($leaveDates);$i++)
        {
            $leaveDate = convertDateTimeSting($leaveDates[$i], 'date');
            if(!empty($leaveDates[$i]) && !empty($leaveDate))
            {
                $studentMarksDetails = StudentLeave::create(
                [   'rollNumber' => $requestParams['rollNumber'],
                    'reason' => $requestParams['reason'],
                    'approver' => $requestParams['approver'],
                    'leaveDate' =>$leaveDate,
                    'accademicSession'=>$sessionId
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
                array('username','password','standard','section','rollNumber','comment',
                    'codeOfConduct','codeDescription','logTime','dateString','academicsSession'
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
        $sessionId = getSession($requestParams['academicsSession']);
                
        $studentHostelDetails = StudentComment::create(
        [   'rollNumber' => $requestParams['rollNumber'],
            'standard' => $requestParams['standard'],
            'section' => $requestParams['section'],
            'comment' => $requestParams['comment'],
            'codeOfConduct' => $requestParams['codeOfConduct'],
            'description' => $requestParams['codeDescription'],
            'logTime'   => date('Y-m-d H:i:s',$requestParams['logTime']),
            'accademicSession'=>$sessionId
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
        //pr($e);
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
                    ,'academicsSession'));

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
        $successArr['rollNumberPresent'] = processAttendanse($attendanceDate,$requestParams['rollNumberPresent'],$requestParams,1);
        $successArr['rollNumberOnLeave'] = processAttendanse($attendanceDate,$requestParams['rollNumberOnLeave'],$requestParams,2);
        $successArr['rollNumberAbsent'] = processAttendanse($attendanceDate,$requestParams['rollNumberAbsent'],$requestParams,3);
        
        if(empty($successArr['rollNumberPresent']) && empty($successArr['rollNumberOnLeave'])
                && empty($successArr['rollNumberAbsent']))
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

$app->post('/v1/sendSchoolNote', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','note','descr','sender',
                    'logTime','dateString','academicsSession'
                    ));
        
        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }
        if(!empty($requestParams['rollwise']))
        {
            $responseArr = createSchoolNotes('rollwise',$requestParams);
        }
        else if(!empty($requestParams['standardwise']))
        {
             $responseArr = createSchoolNotes('standardwise',$requestParams);
        }
        else if(!empty($requestParams['general']))
        {
             $responseArr = createSchoolNotes('general',$requestParams);
        }
        if(empty($responseArr))
        {
            return createResponse($response,201,0,"Invalid request.Unable to parse.");
        }
        else
        {
            return createResponse($response,200,1,array('successRollNumbers'=>$responseArr
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendSchoolNote');

$app->post('/v1/eventsEntry', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password',
                    'events','academicsSession'
                    ));
        
        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }

            $responseArr = insertEvents($requestParams['events'],$requestParams);

        if(empty($responseArr))
        {
            return createResponse($response,201,0,"Invalid request.Unable to parse.");
        }
        else
        {
            return createResponse($response,200,1,array('successEvents'=>$responseArr
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendSchoolNote');

$app->post('/v1/sendStudentAchievement', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password',
                    'eventName','academicsSession','achievements'
                    ));
        
        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }
        $sessionId = getSession($requestParams['academicsSession']);
        $eventCheck = SchoolEvents::firstOrNew(['title' => trim($requestParams['eventName']),
            'accademicSession'=>$sessionId]);
        if(empty($eventCheck->id))
        {
            return createResponse($response,400,0,"Event does not exist.");
        }
        $responseArr = insertAchievments($requestParams['achievements'],$requestParams,$sessionId,$eventCheck->id);

        if(empty($responseArr))
        {
            return createResponse($response,201,0,"Invalid request.Unable to parse.");
        }
        else
        {
            return createResponse($response,200,1,array('successRollNumbers'=>$responseArr
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('sendStudentAchievement');

$app->post('/v1/updateBasicDetailsOfCadet', function ($request, $response, $args) {
     try 
    {
        $jsonData = $request->getBody();
        $requestParams = json_decode($jsonData, true);
        
        $db = getConnection();
        $responseCheck = jsonChecking($db,$requestParams,
                array('username','password','rollNumber','academicsSession'
                    ));
        $sessionId = getSession($requestParams['academicsSession']);
        if($responseCheck != 'Success')
        {
            return createResponse($response,400,0,"$responseCheck");
        }

        $studentDetails = Student::firstOrNew(['rollNumber' => $requestParams['rollNumber']]);

        if(!empty($studentDetails->id))
        {
            $studentDetails->accademicSession = $sessionId;
            if(!empty($requestParams['profileImage1']))
            {
                $studentDetails->profileImage1 = json_encode($requestParams['profileImage1']);
            }
            if(!empty($requestParams['profileImage2']))
            {
                $studentDetails->profileImage2 = json_encode($requestParams['profileImage2']);
            }
            if(!empty($requestParams['firstName']))
            {
                $studentDetails->firstName = $requestParams['firstName'];
            }
            if(!empty($requestParams['middleName']))
            {
                $studentDetails->middleName = $requestParams['middleName'];
            }
            if(!empty($requestParams['lastName']))
            {
                $studentDetails->lastName = $requestParams['lastName'];
            }
            if(!empty($requestParams['dateOfBirth']))
            {
                $studentDetails->dateOfBirth = convertDateTimeSting($requestParams['dateOfBirth']);
                //@todo update in user
            }
            if(!empty($requestParams['admissisonDate']))
            {
                $studentDetails->admissisonDate = convertDateTimeSting($requestParams['admissisonDate']);
            }
            if(!empty($requestParams['gender']))
            {
                $studentDetails->gender = trim($requestParams['gender']);
            }
            if(!empty($requestParams['bloodGroup']))
            {
                $studentDetails->bloodGroup = trim($requestParams['bloodGroup']);
            }
            if(!empty($requestParams['category']))
            {
                $studentDetails->category = trim($requestParams['category']);
            }
            if(!empty($requestParams['religion']))
            {
                $studentDetails->religion = trim($requestParams['religion']);
            }
            if(!empty($requestParams['motherTongue']))
            {
                $studentDetails->motherTongue = trim($requestParams['motherTongue']);
            }
            if(!empty($requestParams['aadharNumber']))
            {
                $studentDetails->aadharNumber = trim($requestParams['aadharNumber']);
            }
            if(!empty($requestParams['nationality']))
            {
                $studentDetails->nationality = trim($requestParams['nationality']);
            }
            if(!empty($requestParams['childId']))
            {
                $studentDetails->childId = trim($requestParams['childId']);
            }
            if(!empty($requestParams['stateOfDomicile']))
            {
                $studentDetails->stateOfDomicile = trim($requestParams['stateOfDomicile']);
            }
            if(!empty($requestParams['scholarship']))
            {
                $studentDetails->scholarship = trim($requestParams['scholarship']);
            }
            if(!empty($requestParams['bankName']))
            {
                $studentDetails->bankName = trim($requestParams['bankName']);
            }
            if(!empty($requestParams['branch']))
            {
                $studentDetails->branch = trim($requestParams['branch']);
            }
            if(!empty($requestParams['accountNumber']))
            {
                $studentDetails->accountNumber = trim($requestParams['accountNumber']);
            }
            if(!empty($requestParams['medicalStatus']))
            {
                $studentDetails->medicalStatus = trim($requestParams['medicalStatus']);
            }
            if(!empty($requestParams['fatherFirstName']))
            {
                $studentDetails->fatherFirstName = trim($requestParams['fatherFirstName']);
            }
            if(!empty($requestParams['fatherMiddleName']))
            {
                $studentDetails->fatherMiddleName = trim($requestParams['fatherMiddleName']);
            }
            if(!empty($requestParams['fatherMiddleName']))
            {
                $studentDetails->fatherMiddleName = trim($requestParams['fatherMiddleName']);
            }
            if(!empty($requestParams['fatherMiddleName']))
            {
                $studentDetails->fatherMiddleName = trim($requestParams['fatherMiddleName']);
            }
            if(!empty($requestParams['fatherLastName']))
            {
                $studentDetails->fatherLastName = trim($requestParams['fatherLastName']);
            }
            if(!empty($requestParams['fatherServiceStatus']))
            {
                $studentDetails->fatherServiceStatus = trim($requestParams['fatherServiceStatus']);
            }
            
            //Todo entry a lot
            if(!empty($requestParams['address']))
            {
                $studentDetails->address = json_encode($requestParams['address']);
            }
            if(!empty($requestParams['courseCode']))
            {
                $studentDetails->courseCode = trim($requestParams['courseCode']);
            }
            if(!empty($requestParams['contactNumber']))
            {
                $studentDetails->address = trim($requestParams['contactNumber']);
            }
      
            $studentDetails->save();
            $succesFlag = 1;
        }
        
        if(empty($succesFlag))
        {
            return createResponse($response,400,0,"Invalid request.Unable to parse.Please verify the roll number and other parameters !!");
        }
        else
        {
            return createResponse($response,200,1,array(
                                        'rollNumber'=> $requestParams['rollNumber']
                    ));
        }
         

    }
    catch (PDOException $e) {
        pr($e);
        return createResponse($response,500,0,'Please try again');
    }
    
})->setName('updateStandardSectionForCadet');
?>
