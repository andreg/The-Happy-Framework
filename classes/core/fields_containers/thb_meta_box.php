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

		/* Register the saving action. */
		add_action( 'save_post', array( $this, 'save' ) );
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

	/**
	* Render the metabox content.
	*
	* @since 1.0.0
	*/
	public function render()
	{
		wp_nonce_field( 'thb_meta_box', 'thb' );
		$this->render_elements();
	}

	/**
	 * Return the list of the elements that belong to the fields container.
	 *
	 * @since 1.0.0
	 * @return array An array of field data.
	 */
	public function elements()
	{
		global $post;
		$current_screen = get_current_screen();
		$post_type = $current_screen->post_type;

		$fields = apply_filters( "thb[post_type:{$post_type}][metabox:{$this->handle()}]", $this->_fields );

		if ( $post_type === 'page' ) {
			$page_template = get_post_meta( $post->ID, '_wp_page_template', true );
			$fields = apply_filters( "thb[post_type:{$post_type}][metabox:{$this->handle()}][template:{$page_template}]", $fields );
		}

		if ( ! self::_validate_fields_structure( $fields ) ) {
			return false;
		}

		return $fields;
	}

	/**
	 * When the post is saved, save the custom data contained in the metabox.
	 *
	 * @since 1.0.0
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id )
	{
		if ( ! thb_user_can_save( $post_id, 'thb_meta_box' ) ) {
			return;
		}

		$elements = $this->elements();

		if ( ! empty( $elements ) ) {
			foreach ( $elements as $index => $element ) {
				if ( ! isset( $_POST[$element['handle']] ) ) {
					delete_post_meta( $post_id, $element['handle'] );
				}

				if ( $element['type'] === 'group' ) {
					foreach ( $element['fields'] as $field ) {
						$value = stripslashes_deep( $_POST[$field['handle']] );
						$value = THB_Field::sanitize( $field, $value );

						update_post_meta( $post_id, $field['handle'], $value );
					}
				}
				else {
					$value = stripslashes_deep( $_POST[$element['handle']] );
					$value = THB_Field::sanitize( $field, $_POST[$element['handle']] );

					update_post_meta( $post_id, $element['handle'], $value );
				}
			}
		}
	}

}