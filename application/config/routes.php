<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'auth2';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// admin
$route['admin/siswa/(:num)'] = 'admin/viewEditSiswa/$1';
$route['admin/ortu/(:num)'] = 'admin/viewEditOrtu/$1';
$route['admin/siswa/(:num)/edit'] = 'admin/editSiswa/$1';
$route['admin/ortu/(:num)/edit'] = 'admin/editOrtu/$1';
$route['admin/siswa/cetak/all'] = 'admin/printsiswa';
$route['admin/ortu/cetak/all'] = 'admin/printortu';
$route['admin/pembayaran/acc/(:num)'] = 'payment/acc/$1';
$route['admin/pembayaran/tolak/(:num)'] = 'payment/tolak/$1';
$route['admin/kelas-b1'] = 'admin/kelasb1';
$route['admin/kelas-a1'] = 'admin/kelasa1';
$route['admin/kelas-a2'] = 'admin/kelasa2';
$route['admin/laporan/cetak/siswa/all'] = 'admin/printAllSiswa';

// user
$route['user/data'] = 'user/datadiri';
$route['user/data/form'] = 'user/formdatadiri';
$route['user/data/form/update'] = 'user/simpanDatadiri';
$route['user/ortu'] = 'user/dataortu';
$route['user/ortu/form'] = 'user/formdataortu';
$route['user/ortu/form/update'] = 'user/simpanDataortu';
$route['user/pembayaran/manual'] = 'payment/manual_pay';
$route['user/pembayaran/manual/upload'] = 'payment/upload_bukti';

// $route['admin/siswa/hapus/(:num)'] = 'admin/hapusSiswa/$1';

// kepsek
$route['kepsek'] = 'kepsek/index';
$route['kepsek/laporan/cetak/kepsek/all'] = 'kepsek/printAllSiswa';