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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'inicio';
$route['404_override'] = '';

$route['profesionales'] = "inicio/profesionales";
$route['admin/login'] = "admin/acceso/login";
$route['admin/logout'] = "admin/acceso/logout";
$route['admin'] = "admin/acceso";
$route['busqueda/(:any)'] = "inicio/busqueda/$1";
$route['buscar/(:any)'] = "inicio/buscar/$1";
$route['modulo/(:any)/(:any)'] = 'inicio/modulo/$1/$2';
$route['ficha/(:any)'] = "inicio/ver_anuncio/$1";
$route['promocion/(:any)'] = "inicio/ver_promocion/$1";
$route['aviso-legal'] = "paginas_dinamicas/desarrollar/aviso-legal";
$route['politica-de-privacidad'] = "paginas_dinamicas/desarrollar/politica-de-privacidad";
$route['politica-de-cookies'] = "paginas_dinamicas/desarrollar/politica-de-cookies";

$route['c/(:any)'] = "empresa/carta_digital/$1";


$route['translate_uri_dashes'] = FALSE;
