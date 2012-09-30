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

class Admin_Controller extends Authorized_Controller
{

	/**
	 * Called when the class object is
	 * initialized
	 */
	public function __construct()
	{
		$this->filter('before', 'admin_auth')->except($this->whitelist);
		parent::__construct();
	}

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		if (Config::get('application.ssl') and ! Request::secure())
		{
			return Redirect::to_secure(URI::current())->send();
		}

		// Now check to make sure they have bundle specific permissions
		if ( ! Sentry::user()->has_access())
		{
			return Redirect::to_admin('insufficient_permissions')->send();
			exit;
		}

		// Set the active theme based on the database contents,
		// falling back to the theme config.
		Theme::active('backend'.DS.Platform::get('themes.theme.backend'));
		Theme::fallback('backend'.DS.'default');
	}

}
