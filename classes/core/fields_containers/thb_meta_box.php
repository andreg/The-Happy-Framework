<?php

/**
 * Meta box fields container class.
 *
 * A meta box is a field container that is displayed in post types editing
 * screens in the WordPress admininistration.
 *
 * @package   TheHappyFramework
 * @since 	  1.0.0
 * @version   1.0.0
 * @author 	  The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright (c) 2014 - 2015, Andrea Gandino, Simone Maranzana
 * @link 	  http://thbthemes.com/framework
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class THB_MetaBox extends THB_FieldsContainer {

	/**
	 * An array of post types that should display the meta box.
	 *
	 * @var array
	 */
	private $_post_types = array();

	/**
	 * Constructor for the meta box class. Per WordPress Developer documentation
	 * the method also binds the "register" method of the class to the
	 * "add_meta_boxes" action on admin.
	 *
	 * @param string $handle A slug-like definition of the meta box.
	 * @param string $title A human-readable definition of the meta box.
	 * @param array $post_types An array of post types that should display the meta box.
	 * @param array $fields An array containing a default set of fields that belong to the meta box.
	 * @since 1.0.0
	 */
	function __construct( $handle, $title, $post_types = 'post', $fields = array() )
	{
		$this->_post_types = (array) $post_types;
		parent::__construct( $handle, $title, $fields );

		/* Register the meta box in WordPress. */
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
	}

	/**
	 * Register the meta box in WordPress, associating it to the specified
	 * post types.
	 *
	 * @since 1.0.0
	 */
	public function register()
	{
		foreach ( $this->_post_types as $post_type ) {
			add_meta_box( $this->handle(), $this->title(), array( $this, 'render' ), $post_type );
		}
	}

	public function render()
	{
		$this->render_fields();
	}

	/**
	 * Return the list of the fields that belong to the fields container.
	 *
	 * @since 1.0.0
	 * @return array An array of field data.
	 */
	public function fields()
	{
		global $post;
		$current_screen = get_current_screen();
		$post_type = $current_screen->post_type;

		$fields = apply_filters( "thb[post_type:{$post_type}][metabox:{$this->handle()}]", $this->_fields );

		if ( $post_type === 'page' ) {
			$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
			$fields = apply_filters( "thb[post_type:{$post_type}][metabox:{$this->handle()}][template:{$page_template}]", $fields );
		}

		foreach ( $fields as $index => $field ) {
			if ( ! THB_Field::validate_structure( $field ) ) {
				unset( $fields[$index] );
			}
		}

		return $fields;
	}

}