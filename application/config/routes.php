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
$route['default_controller'] = 'home';
$route['404_override'] = 'home/not_found';
$route['translate_uri_dashes'] = FALSE;

$route['admin/category'] = 'admin/category/index';
$route['admin/ajax/category'] = 'admin/category/index/indexAjax';
$route["admin/category/delete/:num"] = 'admin/category/index/delete/:num';

$route['admin/communication'] = 'admin/communication/index';
$route['admin/ajax/communication'] = 'admin/communication/index/indexAjax';
$route["admin/communication/delete/:num"] = 'admin/communication/index/delete/:num';
$route['admin/communication/edit/:num'] = 'admin/communication/index/edit';

$route['admin/vocabulary'] = 'admin/vocabulary/index';
$route['admin/ajax/vocabulary'] = 'admin/vocabulary/index/indexAjax';

$route['admin/result'] = 'admin/result/index';
$route['admin/result/edit/:num'] = 'admin/result/index/edit';
$route["admin/result/delete/:num"] = 'admin/result/index/delete/:num';
$route['admin/ajax/result'] = 'admin/result/index/indexAjax';

$route['admin/lession'] = 'admin/lession/index';
$route['admin/lession/createExercise'] = 'admin/lession/index/createExercise';
$route["admin/lession/delete/:num"] = 'admin/lession/index/delete/:num';
$route['admin/ajax/lession'] = 'admin/lession/index/indexAjax';
$route['admin/ajax/lession/loadtable'] = 'admin/lession/index/loadTableVocabulary';

$route['admin/read'] = 'admin/read/index';
$route['read-detail/:num'] = 'home/exercise_detail/:num';
$route["admin/read/delete/:num"] = 'admin/read/index/delete/:num';
$route['admin/ajax/read'] = 'admin/read/index/indexAjax';

$route['admin/pharse'] = 'admin/pharse/index';
$route['admin/ajax/pharse'] = 'admin/pharse/index/indexAjax';

$route['admin/exercise'] = 'admin/lession/index';
$route['admin/ajax/exercise'] = 'admin/lession/index/indexAjax';
$route["admin/exercise/delete/:num"] = 'admin/lession/index/delete/:num';

$route['admin/category/table'] = 'admin/category/index/table';
$route['admin'] = 'admin/admin';

$route['exercise'] = 'home/exercise';
$route['exercise-detail/:num'] = 'home/exercise_detail/:num';

$route['lession'] = 'home/lession';
$route['lession-detail/:num'] = 'home/lession_detail/:num';

