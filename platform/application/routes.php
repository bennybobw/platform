<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Platform
 * @version    1.0.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/

Route::any(ADMIN.'/(:any?)/(:any?)/(:any?)(/.*)?', function($bundle = 'dashboard', $controller = null, $action = null, $params = null)
{

	if ( ! Bundle::exists($bundle))
	{
		return Response::error('404');
	}

	// Check if the controller exists
	if (Controller::resolve($bundle, 'admin.'.$controller))
	{
		$controller = $bundle.'::admin.'.$controller.'@'.(($action) ?: 'index');
		$params     = explode('/', substr($params, 1));
	}

	// If it doesn't, default to to bundle name as a controller
	else
	{
		$controller = $bundle.'::admin.'.$bundle.'@'.(($controller) ?: 'index');
		$params     = explode('/', $action.$params);
	}

	return Controller::call($controller, $params);
});

/**
 * Route /api/extension/:id
 *
 *	<code>
 *		/api/users/1 => users::api.users@index(1)
 *	</code>
 */
Route::any(API.'/(:any)/(:num)', function($bundle = DEFAULT_BUNDLE, $id = null, $params = null)
{
	return Controller::call($bundle.'::api.'.$bundle.'@index', array($id));
});

/**
 * Route /api/extension/controller/:id
 *
 *	<code>
 *		/api/users/groups/1 => users::api.users.groups@index(1)
 *	</code>
 */
Route::any(API.'/(:any)/(:any)/(:num)', function($bundle = DEFAULT_BUNDLE, $controller = null, $id = null, $params = null)
{
	return Controller::call($bundle.'::api.'.$controller.'@index', array($id));
});

// Re-route api controllers
Route::any(array(API.'/(:any?)/(:any?)/(:any?)(/.*)?', API.'/(:any?)/(:any?)(/.*)?', API.'/(:any?)(/.*)?'), function($bundle = 'dashboard', $controller = null, $action = null, $params = null)
{
	if ( ! Bundle::exists($bundle))
	{
		$bundle = DEFAULT_BUNDLE;
	}

	// Check if the controller exists
	if (Controller::resolve($bundle, $_controller = 'api.'.$controller))
	{
		$controller = $bundle.'::'.$_controller.'@'.(($action) ?: 'index');
		$params     = explode('/', substr($params, 1));
	}

	// If it doesn't, default to to bundle name as a controller
	elseif (Controller::resolve($bundle, $_controller = 'api.'.$bundle))
	{
		$controller = $bundle.'::'.$_controller.'@'.(($controller) ?: 'index');
		$params     = explode('/', $action.$params);
	}

	// Fallback to API controller
	else
	{
		$controller = 'api@no_route';
		$params     = array();
	}

	return Controller::call($controller, $params);
});

// Now detect controllers
Route::controller(Controller::detect());

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	// if (Request::forged())
	// {
	// 	return Response::error('500');
	// }

	// Remove the token from the input now
	Request::foundation()->request->remove(Session::csrf_token);
});

// Filter all auth
Route::filter('auth', function()
{
	if ( ! Sentry::check())
	{
		// store current uri in session
		Session::flash('login_redirect', URI::current());

		return Redirect::to('login');
	}
});

// Filter all admin auth
Route::filter('admin_auth', function()
{
	if ( ! Sentry::check() or ! Sentry::user()->has_access('is_admin') )
	{
		// store current uri in session
		Session::flash('login_redirect', URI::current());

		return Redirect::to('login');
	}
});
