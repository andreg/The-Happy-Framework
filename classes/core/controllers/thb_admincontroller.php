<?php

/**
 * Admin controller class. This controller is entitled to handle the loading
 * of admin external resources as well as routing operations.
 *
 * @package   TheHappyFramework
 * @since 	  1.0.0
 * @version   1.0.0
 * @author 	  The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright (c) 2014 - 2015, Andrea Gandino, Simone Maranzana
 * @link 	  http://thbthemes.com/framework
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class THB_AdminController extends THB_Controller {

	/**
	 * The admin pages.
	 *
	 * @var array
	 */
	public $pages = array();

	/**
	 * Contructor for the admin controller class. This method binds
	 * operations to specific hooks in the request cycle, such as the ones
	 * entitled to load external resources (scripts and styles).
	 *
	 * @since 1.0.0
	 */
	function __construct()
	{
		/* Bind the enqueue of scripts and stylesheets. */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), apply_filters( 'thb_admin_enqueue_scripts_priority', 20 ) );
	}

	/**
	 * Register and add a meta box to the admin interface binding it to one or
	 * more specific post types.
	 *
	 * @since 1.0.0
	 * @param string $handle A slug-like definition of the meta box.
	 * @param string $title A human-readable definition of the meta box.
	 * @param string|array $post_types A string or array of post types handles.
	 * @param array $fields An array containing a default set of fields that belong to the meta box.
	 * @return THB_MetaBox
	 */
	public function add_meta_box( $handle, $title, $post_types = 'post', $fields = array() )
	{
		$post_types = apply_filters( "thb_{$handle}_metabox_post_types", $post_types );

		return new THB_MetaBox( $handle, $title, $post_types, $fields );
	}

}