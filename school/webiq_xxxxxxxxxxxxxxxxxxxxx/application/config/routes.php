<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['student/attendance/(:any)'] = 'front/attendance/index';
$route['student/attendance/(:any)/(:any)/(:any)'] = 'front/attendance/index';
$route['student/(:any)'] = 'front/student/$1';
$route['student/(:any)/(:any)'] = 'front/student/$1';
$route['student/marks/(:any)'] = 'front/student/markDetails';
$route['student/event/details/(:any)'] = 'front/student/eventDetails';

$route['login'] = 'home/login';
$route['loginprintinvoice'] = 'home/loginprintInvoice';

$route['loginsubmit'] = 'home/loginSubmit';
$route['dashboard'] = 'front/dashboard/index';
$route['profile'] = 'front/user/index';
$route['changepasswordsubmit'] = 'front/user/changePasswordSubmit';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

