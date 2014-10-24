<?php

/**
 * Login controller class. This controller is entitled to handle the loading
 * of login and registration external resources as well as routing operations.
 *
 * @package   TheHappyFramework
 * @since 	  1.0.0
 * @version   1.0.0
 * @author 	  The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright (c) 2014 - 2015, Andrea Gandino, Simone Maranzana
 * @link 	  http://thbthemes.com/framework
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class THB_LoginController extends THB_Controller {

	/**
	 * Contructor for the login controller class. This method binds
	 * operations to specific hooks in the request cycle, such as the ones
	 * entitled to load external resources (scripts and styles).
	 *
	 * @since 1.0.0
	 */
	function __construct()
	{
		/* Bind the enqueue of scripts and stylesheets. */
		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_scripts' ), apply_filters( 'thb_login_enqueue_scripts_priority', 20 ) );
	}

}