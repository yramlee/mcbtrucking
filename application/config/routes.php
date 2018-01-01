<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['login'] = 'delivery/login';
$route['logout'] = 'delivery/logout';
$route['delivery/add/company'] = 'delivery/company';
$route['delivery/edit/company'] = 'delivery/company';
$route['delivery/add/company/(:any)'] = 'delivery/add/$1';
$route['delivery/edit/(:any)'] = 'delivery/edit/$1';
$route['delivery/delete/(:any)'] = 'delivery/delete/$1';
$route['delivery'] = 'delivery/index';

$route['deductions/edit/(:any)'] = 'deductions/edit/$1';
$route['deductions/delete/(:any)'] = 'deductions/delete/$1';
$route['deductions'] = 'deductions/index';
$route['deductions/add'] = 'deductions/add';

$route['company/edit/(:any)'] = 'company/edit/$1';
$route['company/delete/(:any)'] = 'company/delete/$1';
$route['company'] = 'company/index';
$route['company/add'] = 'company/add';

$route['destination/edit/(:any)'] = 'destination/edit/$1';
$route['destination/delete/(:any)'] = 'destination/delete/$1';
$route['destination'] = 'destination/index';
$route['destination/add'] = 'destination/add';

$route['shift/edit/(:any)'] = 'shift/edit/$1';
$route['shift/delete/(:any)'] = 'shift/delete/$1';
$route['shift'] = 'shift/index';
$route['shift/add'] = 'shift/add';

$route['vessel/edit/(:any)'] = 'vessel/edit/$1';
$route['vessel/delete/(:any)'] = 'vessel/delete/$1';
$route['vessel'] = 'vessel/index';
$route['vessel/add'] = 'vessel/add';

$route['material/edit/(:any)'] = 'material/edit/$1';
$route['material/delete/(:any)'] = 'material/delete/$1';
$route['material'] = 'material/index';
$route['material/add'] = 'material/add';

$route['rate/edit/(:any)'] = 'rate/edit/$1';
$route['rate/delete/(:any)'] = 'rate/delete/$1';
$route['rate'] = 'rate/index';
$route['rate/add'] = 'rate/add';


$route['reports/(:any)'] = 'reports/index/$1';
$route['reports'] = 'reports/index';

$route['default_controller'] = 'delivery';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
