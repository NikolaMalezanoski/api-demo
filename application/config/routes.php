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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['test'] = "welcome/rewrite";

/*
 * API PATTERN
 *
 * GET  	/orders?tag=<<string>> 	<---> return orders
 * POST  	/orders          		<---> new order
 * GET  	/orders/<<ID>>        	<---> return specific order
 * PUT  	/orders/<<ID>>        	<---> edit order
 * DELETE	/delete/<<ID>>        	<---> delete order
 *
 */




/*
 * AUTHENTICATION
 */

// oAuth Registration
$route['api/latest/oauth/register'] = "oAuth/register/register";

// oAuth Login
$route['api/latest/oauth/login'] = "oAuth/login/login";

// oAuth RefreshToken Exchange
$route['api/latest/oauth/refresh-token'] = "oAuth/refreshTokenExchange/refreshTokenExchange";

// reset Password Request
$route['api/latest/oauth/reset-password/request'] = "oAuth/resetPassword/request";

// reset Password New PAssword
$route['api/latest/oauth/reset-password/new-rassword'] = "oAuth/resetPassword/newPasswordWithToken";


/*
 * API PATTERN CATEGORIES
 *
 * GET  	/categories?tag=<<string>> 	<---> return categories (public)
 * GET  	/categories/<<ID>>        	<---> return specific categories (public)
 * POST  	/categories          		<---> new Category   (oAuth Protected)
 * PUT  	/categories/<<ID>>        	<---> update category (oAuth Protected)
 * DELETE	/categories/<<ID>>        	<---> delete categories (oAuth Protected)
 *
 */
$route['api/latest/categories'] = "categories/index";
$route['api/latest/categories/(:num)'] = "categories/index/$1";


/*
 * API PATTERN CITIES
 *
 * GET  	/cities					 	<---> return cities    (public)
 *
 */
$route['api/latest/cities'] = "cities/index";



// Get Client Details
$route['api/latest/client/personal-details'] = "personalDetails/getPersonalDetails";
