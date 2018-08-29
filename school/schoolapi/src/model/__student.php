<?php
//namespace App\Models; 
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table= 'users'; 
    protected $fillable = ['first_name','last_name','middle_name','email_id','dateOfBirth','username','status'];
}

class UserGroup extends Model
{
    protected $table= 'user_groups_map'; 
    protected $fillable = ['user_id','group_id'];
}
class StudentSection extends Model
{
    protected $table= 'student_section_map'; 
    protected $fillable = ['rollNumber','standard','section'];
}

class StudentAttendance extends Model
{
    protected $table= 'student_attendance'; 
    protected $fillable = ['rollNumber','standard','section','attendanceDate','type','accademicSession'];
}
class Student extends Model
{ 
    protected $table= 'student_details'; 
    protected $fillable = ['userId','firstName','middleName','lastName','standard','admissionDrive',
        'formId','rollNumber','dateOfBirth','admissisonDate','gender','bloodGroup','category','religion',
        'motherTongue','aadharNumber','nationality','childId','house','stateOfDomicile','scholarship','bankName',
        'branch','accountNumber','medicalStatus','email','fatherFirstName','fatherMiddleName',
        'fatherLastName','fatherServiceStatus','fatherDefenceCategory','fatherRank','fatherMobile',
        'fatherEmail','motherFirstName','motherMiddleName','motherLastName','motherMobile','motherEmail',
        'guardianFirstName','guardianMiddleName','guardianLastName','guardianMobile','guardianEmail',
        'fatherIncome','motherIncome','studentIncome','familyIncome','address',
        'foodPreference','firstPickUpPlace','hobbies','personalIdentificationMark','previousSchoolName',
        'previousSchoolWebsite','previousSchoolAddress','previousSchoolPhone','previousSchoolEmail',
        'previousAchivement','courseCode','contactNumber'
        ];
}

class StudentSessionFees extends Model
{ 
    protected $table= 'student_session_fees'; 
    protected $fillable = ['academicSession','standardName','sectionName','rollNumber','fees'];
}

class StudentMarks extends Model
{ 
    protected $table= 'student_marks'; 
    protected $fillable = ['standard','section','subject','exam','academicYear','rollNumber','name',
        'theoryTotal','practicalTotal','theoryObtained','practicalObtained','status'];
}

class StudentLeave extends Model
{ 
    protected $table= 'student_leave'; 
    protected $fillable = ['rollNumber','reason','leaveDate','approver','accademicSession'];
}

class StudentHostel extends Model
{ 
    protected $table= 'student_hostel'; 
    protected $fillable = ['rollNumber','house'];
}

class StudentComment extends Model
{ 
    protected $table= 'student_comment'; 
    protected $fillable = ['rollNumber','standard','section','comment','codeOfConduct','description',
        'logTime','accademicSession'];
}

class StudentSession extends Model
{ 
    protected $table= 'student_session'; 
    protected $fillable = ['session','slug'];
}
class SchoolNote extends Model
{ 
    protected $table= 'student_notes'; 
    protected $fillable = ['accademicSession','title','description','sender','logTime','rollNumber'];
}
class SchoolEvents extends Model
{ 
    protected $table= 'school_events'; 
    protected $fillable = ['accademicSession','title','category','description','incharge','startDate','endDate'];
}

class SchoolAchievements extends Model
{ 
    protected $table= 'school_achievements'; 
    protected $fillable = ['accademicSession','title','rollNumber','eventPosition','eventPhoto','eventId','endDate'];
}