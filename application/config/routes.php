<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] 	= "music";
$route['404_override'] 			= '';
$route['artist/music/(:any)'] 	= "music/$1";
$route['tag/music/(:any)'] 		= "music/$1";
$route['search/music/(:any)']	= "music/$1";
$route['admin/music/(:any)']	= "music/$1";


$route['timeline/(:any)'] 		= "music/index/$0/$1/$2";
$route['timeline'] 		= "music/index/$0/$1/$2";
$route['albums/(:any)'] 		= "music/index/$0/$1/$2";
$route['artist/(:any)'] 		= "music/index/$0/$1/$2";
$route['playlist/(:any)'] 		= "music/index/$0/$1/$2";
$route['top/(:any)'] 			= "music/index/$0/$1/$2";
$route['lyric/(:any)'] 			= "music/index/$0/$1/$2";
$route['music_folder'] 			= "music/index/music_folder";
$route['track/(:any)'] 			= "music/index/songInfo/$1/$2/$2";
$route['tag/(:any)'] 			= "music/index/$0/$1/$2";
$route['search/(:any)']			= "music/index/$0/$1/$2";
$route['station/(:any)']		= "music/index/$0/$1/$2";
$route['user/(:any)']			= "music/index/$0/$1/$2";
$route['page/(:any)']			= "music/index/$0/$1/$2";
$route['sitemap.xml']			= "sitemap";
$route['embed/(:any)'] 			= "embed/index/$1";

/* Admin */
$route['admin']					= "dashboard/admin";

/* End of file routes.php */
/* Location: ./application/config/routes.php */