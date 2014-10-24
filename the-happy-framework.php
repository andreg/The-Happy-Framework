<?php

/**
 * Plugin Name: The Happy Framework
 * Plugin URI: http://thbthemes.com/framework
 * Description: A WordPress theme development framework.
 * Version: 1.0.0
 * Author: The Happy Bit
 * Author URI: http://thehappybit.com
 * License: GPL2
 *
 * The Happy Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * The Happy Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @package   TheHappyFramework
 * @since 	  1.0.0
 * @version   1.0.0
 * @author 	  The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright (c) 2014 - 2015, Andrea Gandino, Simone Maranzana
 * @link 	  http://thbthemes.com/framework
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class THB_Framework {

	/**
	 * The framework class instance.
	 *
	 * @static
	 * @var THB_Framework
	 */
	private static $_instance = null;

	/**
	 * The admin controller.
	 *
	 * @var THB_AdminController
	 */
	public $admin = null;

	/**
	 * The frontend controller.
	 *
	 * @var THB_FrontendController
	 */
	public $frontend = null;

	/**
	 * The login controller.
	 *
	 * @var THB_LoginController
	 */
	public $login = null;

	/**
	 * Contructor for the main framework class. This function defines a list of
	 * constants used throughout the framework and bootstraps the framework
	 * and launch the inclusion of files and libraries.
	 *
	 * @since 1.0.0
	 */
	function __construct()
	{
		/* Framework version number. */
		define( 'THB_FRAMEWORK_VERSION', '1.0.0' );

		/* Theme folder. */
		define( 'THB_THEME_FOLDER', trailingslashit( get_template_directory() ) );

		/* Theme URI. */
		define( 'THB_THEME_URI', trailingslashit( get_template_directory_uri() ) );

		/* Child theme folder. */
		define( 'THB_CHILD_THEME_FOLDER', trailingslashit( get_stylesheet_directory() ) );

		/* Child theme URI. */
		define( 'THB_CHILD_THEME_URI', trailingslashit( get_stylesheet_directory_uri() ) );

		/* Framework folder. */
		define( 'THB_FRAMEWORK_FOLDER', trailingslashit( dirname( __FILE__ ) ) );

		/* Framework URI. */
		define( 'THB_FRAMEWORK_URI', plugin_dir_url( __FILE__ ) );

		/* Framework includes folder. */
		define( 'THB_FRAMEWORK_INCLUDES_FOLDER', trailingslashit( THB_FRAMEWORK_FOLDER . 'includes' ) );

		/* Framework classes folder. */
		define( 'THB_FRAMEWORK_CLASSES_FOLDER', trailingslashit( THB_FRAMEWORK_FOLDER . 'classes' ) );

		/* Framework includes. */
		$this->_includes();

		/* Framework bootstrap. */
		$this->_bootstrap();
	}

	/**
	 * Load internationalization functions and the framework text domain.
	 *
	 * @since 1.0.0
	 */
	private function _i18n()
	{
		/* Load the text domain for framework files. */
		load_plugin_textdomain( 'thb-framework', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Bootstrap the framework. This method runs a series of operations that
	 * are needed by the framework to operate correctly, such as loading the
	 * controllers for the admin and frontend of the website; the text domain
	 * for the framework is also loaded by this method.
	 *
	 * @since 1.0.0
	 */
	private function _bootstrap()
	{
		/* Load internationalization functions and the framework text domain. */
		$this->_i18n();

		/* Instantiate the controller of the admin area. */
		$this->admin = new THB_AdminController();

		/* Instantiate the controller of the theme frontend. */
		$this->frontend = new THB_FrontendController();

		/* Instantiate the controller of the theme login and registration screens. */
		$this->login = new THB_LoginController();
	}

	/**
	 * Load the framework functions. These functions can either be utility
	 * helpers as well as functions enabling specific functionalities; as such
	 * their behavior can be altered via filters or overriding them all
	 * together.
	 *
	 * @since 1.0.0
	 */
	private function _includes()
	{
		/* General system utilities. */
		require_once( THB_FRAMEWORK_INCLUDES_FOLDER . 'system.php' );

		/* Core classes. */
		$this->_includes_core();
	}

	/**
	 * Load the framework core classes.
	 *
	 * @since 1.0.0
	 */
	private function _includes_core()
	{
		/* Pages controller. */
		require_once( THB_FRAMEWORK_CLASSES_FOLDER . 'core/thb_controller.php' );

		/* Frontend pages controller. */
		require_once( THB_FRAMEWORK_CLASSES_FOLDER . 'core/controllers/thb_frontendcontroller.php' );

		/* Admin pages controller. */
		require_once( THB_FRAMEWORK_CLASSES_FOLDER . 'core/controllers/thb_admincontroller.php' );

		/* Login and registration pages controller. */
		require_once( THB_FRAMEWORK_CLASSES_FOLDER . 'core/controllers/thb_logincontroller.php' );

		/* Fields. */
		require_once( THB_FRAMEWORK_CLASSES_FOLDER . 'core/thb_field.php' );
	}

	/**
	 * Return the instance of the framework class.
	 *
	 * @static
	 * @since 1.0.0
	 * @return THB_Framework
	 */
	public static function instance()
	{
		if ( self::$_instance === null ) {
			self::$_instance = new THB_Framework();
		}

		return self::$_instance;
	}

}

/* Let the fun begin! */
THB_Framework::instance();