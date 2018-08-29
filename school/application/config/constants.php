<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//Groups
define('GROUP_SSP_ADMIN', 'ssp_admin');

define('GROUP_SSP_STUDENT', 'ssp_student');

define('GROUP_ICAM_TEACHER', 'icam_teacher');

//Groups
define('SUPER_ADMIN', 'super_admin');

define('ALUMNI_ADMIN', 'alumni_admin');

define('ALUMNI_MEMBER', 'alumni_member');

define('GROUP_TEAM_MEMBER', 'sales_team_member');

define('GROUP_TEAM_LEAD', 'sales_lead');
define('ALUMNI_DB', 'alumni_primary');

define('LOGIN_LDAP_LINK', 'http://apps.sainikschoolpurulia.com/api/ldap/rest/validateLogin');
define('CHANGE_PASSWORD_LDAP_LINK', 'http://apps.sainikschoolpurulia.com/api/ldap/rest/changePassword');
//ECHO ENVIRONMENT;DIE;
switch(ENVIRONMENT){

    case 'development':
    # DB
    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
    defined('DB_USER')      ? null : define('DB_USER', 'phptrain_ssp-live');
    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'D6yoIxlu_Fy6');
    defined('DB_NAME')      ? null : define('DB_NAME', 'phptrain_ssp-live');
    defined('ALUMNI_DB_NAME')? null : define('ALUMNI_DB_NAME', 'icam_alumni');
    defined('CRM_DB_NAME')      ? null : define('CRM_DB_NAME', 'icam_crm');

    $folder_name='';
    $folder_base_name='school/webiq';

    define('HOMEURL','http://'.$_SERVER['HTTP_HOST']);
    //define('FILEROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/');
    define('ASSETURL','http://'.$_SERVER['HTTP_HOST'].'/'.$folder_name.'/assets/');
    define('ASSETBASEURL',$_SERVER['DOCUMENT_ROOT'].'/'.$folder_name.'/assets/');

    define('ROOTURL',$_SERVER['DOCUMENT_ROOT'].'/'.$folder_name);
    define('BASEURL','http://'.$_SERVER['HTTP_HOST'].'/'.$folder_name.'');
    define('PUBLICURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/public/');
    define('PUBLICROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/public/');
    define('FILEROOTURL',$_SERVER['DOCUMENT_ROOT'].'/'.$folder_name.'/uploads/');
    define('FILEBASEURL','http://'.$_SERVER['HTTP_HOST'].'/'.$folder_name.'/public/uploads/');
    define('LOGOLINK','logo-university.png');
    define('LOGOTRANSPARENTLINK','logo-university-white.png');
    //define('FAVICONLINK','favicon-school.png');
    define('FAVICONLINK','favicon-university.ico');
    define('SCHOOLFLAG','0');
    define('LOCALLANGUAGEFLAG','0');
    define('DEBUGFLAG','1');
    break;
    
    case 'dev2':
    # DB
    defined('DB_HOST')      ? null : define('DB_HOST', '127.0.0.1');
    defined('DB_USER')      ? null : define('DB_USER', 'root');
    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', '');
    defined('DB_NAME')      ? null : define('DB_NAME', 'ssp-local');
    defined('ALUMNI_DB_NAME')? null : define('ALUMNI_DB_NAME', 'icam_alumni');
    defined('CRM_DB_NAME')      ? null : define('CRM_DB_NAME', 'icam_crm');

    $folder_name='';
    $folder_base_name='ssp';

    define('HOMEURL','http://'.$_SERVER['HTTP_HOST']);
    //define('FILEROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/');
    define('ASSETURL','http://'.$_SERVER['HTTP_HOST'].'/'.$folder_name.'/assets/');
    define('ASSETBASEURL',$_SERVER['DOCUMENT_ROOT'].'/'.$folder_name.'/assets/');

    define('ROOTURL',$_SERVER['DOCUMENT_ROOT'].'/'.$folder_name);
    define('BASEURL','http://'.$_SERVER['HTTP_HOST'].'/'.$folder_name.'');
    define('PUBLICURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/public/');
    define('PUBLICROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/public/');
    define('FILEROOTURL',$_SERVER['DOCUMENT_ROOT'].'/'.$folder_name.'/uploads/');
    define('FILEBASEURL','http://'.$_SERVER['HTTP_HOST'].'/'.$folder_name.'/public/uploads/');
    define('LOGOLINK','logo-university.png');
    define('LOGOTRANSPARENTLINK','logo-university-white.png');
    //define('FAVICONLINK','favicon-school.png');
    define('FAVICONLINK','favicon-university.ico');
    define('SCHOOLFLAG','0');
    define('LOCALLANGUAGEFLAG','0');
    define('DEBUGFLAG','1');
    break;

    case 'production':
    # DB
    defined('DB_HOST')      ? null : define('DB_HOST', 'localhost');
    defined('DB_USER')      ? null : define('DB_USER', 'ssp_user');
    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'ssp@secure');
    defined('DB_NAME')      ? null : define('DB_NAME', 'ssp_live');
    defined('ALUMNI_DB_NAME')      ? null : define('ALUMNI_DB_NAME', 'icam_alumni');
    defined('CRM_DB_NAME')      ? null : define('CRM_DB_NAME', 'icam_crm');
   // 0Q8vVK.6mdEi
    $folder_name='/webiq';

    define('HOMEURL','http://'.$_SERVER['HTTP_HOST']).$folder_name."/";
    define('ASSETURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/assets/');
    define('ASSETBASEURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/assets/');
    define('ROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name);
    define('BASEURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/');
    define('PUBLICURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'public/');
    define('PUBLICROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'public/');
    define('FILEROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/uploads/');
    define('FILEBASEURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/public/uploads/');
    define('LOGOTRANSPARENTLINK','logo-school-white.png');
    define('LOGOLINK','logo-school.png');
    define('FAVICONLINK','favicon-school.png');
    //define('FAVICONLINK','favicon-university.ico');
    define('SCHOOLFLAG','1');
    define('LOCALLANGUAGEFLAG','0');
    break;

    case 'testing':
    error_log(var_export($_SERVER, 1));
    # DB
    defined('DB_HOST')      ? null : define('DB_HOST', '127.0.0.1');
    defined('DB_USER')      ? null : define('DB_USER', 'ssp_user');
    defined('DB_PASSWORD')  ? null : define('DB_PASSWORD', 'ssp@secure');
    defined('DB_NAME')      ? null : define('DB_NAME', 'ssp_live');
    defined('ALUMNI_DB_NAME')      ? null : define('ALUMNI_DB_NAME', 'icam_alumni');
    defined('CRM_DB_NAME')      ? null : define('CRM_DB_NAME', 'icam_crm');
   // 0Q8vVK.6mdEi
    $folder_name='';

    define('HOMEURL','http://'.$_SERVER['HTTP_HOST']);
    define('ASSETURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/assets/');
    define('ASSETBASEURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/assets/');
    define('ROOTURL',$_SERVER['DOCUMENT_ROOT'].'/'.$folder_name);
    define('BASEURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/');
    define('PUBLICURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/public/');
    define('PUBLICROOTURL',$_SERVER['DOCUMENT_ROOT'].$folder_name.'/public/');
    define('FILEROOTURL',$_SERVER['DOCUMENT_ROOT'].''.$folder_name.'/uploads/');
    define('FILEBASEURL','http://'.$_SERVER['HTTP_HOST'].$folder_name.'/public/uploads/');
    define('LOGOTRANSPARENTLINK','logo-school-white.png');
    define('LOGOLINK','logo-school.png');
    define('FAVICONLINK','favicon-school.png');
    //define('FAVICONLINK','favicon-university.ico');
    define('SCHOOLFLAG','1');
    define('LOCALLANGUAGEFLAG','0');
    break;



}
