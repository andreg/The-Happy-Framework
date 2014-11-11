<?php

/**
 * Generic field class. A field is an object that that stores, sets and
 * retrieves data to and from the database and that has a specific visual
 * representation.
 *
 * @package   TheHappyFramework
 * @since 	  1.0.0
 * @version   1.0.0
 * @author 	  The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright (c) 2014 - 2015, Andrea Gandino, Simone Maranzana
 * @link 	  http://thbthemes.com/framework
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

abstract class THB_Field {

	/**
	 * A slug-like definition of the field type.
	 *
	 * @var string
	 */
	protected $_type = '';

	/**
	 * A slug-like definition of the field handle.
	 *
	 * @var string
	 */
	private $_handle = '';

	/**
	 * The field data value.
	 *
	 * @var mixed
	 */
	private $_value = false;

	/**
	 * The field default data value.
	 *
	 * @var mixed
	 */
	private $_default = false;

	/**
	 * A brief definition of the field control function.
	 *
	 * @var string
	 */
	private $_label = '';

	/**
	 * An help text of the field control function.
	 *
	 * @var mixed
	 */
	private $_help = false;

	/**
	 * The handle of the bundle the field belongs to, if any.
	 *
	 * @var string
	 */
	private $_bundle = false;

	/**
	 * Constructor for the field class.
	 *
	 * @param string $handle A slug-like definition of the field handle.
	 * @param string $type A slug-like definition of the field type.
	 * @since 1.0.0
	 */
	function __construct( $data = array() )
	{
		$this->_type = $data['type'];
		$this->_handle = $data['handle'];

		if ( isset( $data['bundle'] ) ) {
			$this->_bundle = $data['bundle'];
		}

		if ( isset( $data['default'] ) ) {
			$this->default_value( $data['default'] );
		}

		if ( isset( $data['value'] ) ) {
			$this->value( $data['value'] );
		}

		if ( isset( $data['label'] ) ) {
			$this->label( $data['label'] );
		}

		if ( isset( $data['help'] ) ) {
			$this->help( $data['help'] );
		}
	}

	/**
	 * Set the field default data value.
	 *
	 * @since 1.0.0
	 * @param mixed $default The field default data value.
	 */
	private function set_default( $default )
	{
		$this->_default = $default;
	}

	/**
	 * Get the field default data value.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	private function get_default()
	{
		return $this->_default;
	}

	/**
	 * Set the field label.
	 *
	 * @since 1.0.0
	 * @param string $label The field label.
	 */
	private function set_label( $label )
	{
		$this->_label = $label;
	}

	/**
	 * Get the field label.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	private function get_label()
	{
		return $this->_label;
	}

	/**
	 * Set the field help text.
	 *
	 * @since 1.0.0
	 * @param array|string $help The field help text.
	 */
	private function set_help( $help )
	{
		$help_types = array(
			'inline',
			'expand',
			'popup'
		);

		$field_help = array(
			'type' => 'inline',
			'text' => ''
		);

		if ( is_string( $help ) ) {
			$field_help['text'] = $help;
		}
		elseif ( is_array( $help ) ) {
			if ( isset( $help['type'] ) && in_array( $help['type'], $help_types ) ) {
				$field_help['type'] = $help['type'];
			}

			if ( isset( $help['text'] ) ) {
				$field_help['text'] = $help['text'];
			}
		}
		else {
			$field_help = false;
		}

		$this->_help = $field_help;
	}

	/**
	 * Get the field help text.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	private function get_help()
	{
		return $this->_help;
	}

	/**
	 * Set or retrieve the field label.
	 *
	 * @since 1.0.0
	 * @param boolean|string $label A brief definition of the field control function.
	 * @return string
	 */
	public function label( $label = false )
	{
		if ( $label === false ) {
			return $this->get_label();
		}
		else {
			$this->set_label( $label );
		}
	}

	/**
	 * Set or retrieve the field help text.
	 *
	 * @since 1.0.0
	 * @param boolean|array $help An help text of the field control function.
	 * @return array
	 */
	public function help( $help = false )
	{
		if ( $help === false ) {
				return $this->get_help();
			}
			else {
				$this->set_help( $help );
			}
	}

	/**
	 * Set or retrieve the field default data value.
	 *
	 * @since 1.0.0
	 * @param mixed|boolean $default The field default data value.
	 * @return mixed|void
	 */
	public function default_value( $default = false )
	{
		if ( $default === false ) {
			return $this->get_default();
		}
		else {
			$this->set_default( $default );
		}
	}

	/**
	 * Set the field data value.
	 *
	 * @since 1.0.0
	 * @param mixed $value The field data value.
	 */
	private function set_value( $value )
	{
		$this->_value = $value;
	}

	/**
	 * Get the field data value.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	private function get_value()
	{
		if ( $this->_value === false ) {
			if ( $this->default_value() !== false ) {
				return $this->default_value();
			}
		}

		return $this->_value;
	}

	/**
	 * Set or retrieve the field data value.
	 *
	 * @since 1.0.0
	 * @param mixed|boolean $value The field data value.
	 * @return mixed|void
	 */
	public function value( $value = false )
	{
		if ( $value === false ) {
			return $this->get_value();
		}
		else {
			$this->set_value( $value );
		}
	}

	/**
	 * Return a set of CSS classes to be applied when the field is rendered to
	 * screen.
	 *
	 * @since 1.0.0
	 * @return array An array of CSS classes.
	 */
	private function classes()
	{
		return array(
			'thb-field',
			'thb-field-' . $this->_type
		);
	}

	/**
	 * Return the field handle.
	 *
	 * @since 1.0.0
	 * @return string The field handle.
	 */
	public function handle()
	{
		$handle = $this->_handle;

		if ( $this->_bundle !== false ) {
			$handle = sprintf( '%s[%s]', $this->_bundle, $this->_handle );
		}

		return $handle;
	}

	/**
	 * Render the field label.
	 *
	 * @since 1.0.0
	 */
	private function _render_label()
	{
		if ( $this->label() != '' ) {
			printf( '<h4 class="thb-label">%s</h4>', esc_html( $this->label() ) );
		}
	}

	/**
	 * Render the field help text.
	 *
	 * @since 1.0.0
	 */
	private function _render_help()
	{
		$help = $this->help();

		if ( $help !== false && $help['text'] != '' ) {
			$help_text = esc_html( $help['text'] );

			printf( '<div class="thb-help thb-help-%s">', esc_attr( $help['type'] ) );
				switch( $help['type'] ) {
					case 'expand':
					case 'popup':
						printf( '<a href="#" class="thb-help-handle">%s</a>', __( 'Need help?', 'thb-framework' ) );
						echo $help_text;
						break;
					case 'inline':
					default:
						echo $help_text;
						break;
				}
			echo '</div>';
		}
	}

	/**
	 * Render the field inner content.
	 *
	 * @since 1.0.0
	 */
	public function render_inner()
	{
		thb_template( THB_FRAMEWORK_TEMPLATES_FOLDER . "fields/{$this->_type}", array(
			'field' => $this
		) );
	}

	/**
	 * Render the field interface.
	 *
	 * @since 1.0.0
	 */
	public function render()
	{
		printf( '<div class="%s">', esc_attr( implode( ' ', $this->classes() ) ) );
			$this->_render_label();
			$this->_render_help();
			$this->render_inner();
		echo '</div>';
	}

	/**
	 * Validate the field declaration structure.
	 *
	 * @static
	 * @since 1.0.0
	 * @param array $field The field declaration structure.
	 * @return boolean
	 */
	public static function validate_structure( $field )
	{
		$field_types = array_keys( thb_field_types() );

		if ( ! is_array( $field ) || empty( $field ) ) {
			return false;
		}
		elseif ( ! array_key_exists( 'type', $field ) || empty( $field['type'] ) ) {
			return false;
		}
		elseif ( array_search( $field['type'], $field_types, true ) === false ) {
			return false;
		}
		elseif ( ! array_key_exists( 'handle', $field ) || empty( $field['handle'] ) ) {
			return false;
		}
		elseif ( ! array_key_exists( 'label', $field ) || empty( $field['label'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Sanitize the field value upon form submission.
	 *
	 * @since 1.0.0
	 * @param array $field The field data structure.
	 * @param mixed $value The field submitted value.
	 * @return mixed The sanitized field value.
	 */
	public static function sanitize( $field, $value )
	{
		switch ( $field['type'] ) {
			case 'bundle':
				foreach ( $field['fields'] as $subfield ) {
					$value[$subfield['handle']] = self::sanitize( $subfield, $value[$subfield['handle']] );
				}
				break;
			default:
				if ( ! array_key_exists( 'sanitize', $field ) ) {
					return $value;
				}

				$sanitize_function = 'thb_sanitize_' . $field['sanitize'];

				if ( function_exists( $sanitize_function ) ) {
					$value = $sanitize_function( $value );
				}
				break;
		}

		return $value;
	}

}