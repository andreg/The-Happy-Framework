<?php

/**
 * Generic fields container class.
 *
 * A field container is an object entitled to be a container for form fields in
 * meta boxes, other meta forms, or option pages.
 *
 * @package   TheHappyFramework
 * @since 	  1.0.0
 * @version   1.0.0
 * @author 	  The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright (c) 2014 - 2015, Andrea Gandino, Simone Maranzana
 * @link 	  http://thbthemes.com/framework
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

abstract class THB_FieldsContainer {

	/**
	 * A slug-like definition of the fields container.
	 *
	 * @var string
	 */
	private $_handle = '';

	/**
	 * A human-readable definition of the fields container. This string should
	 * usually be localized.
	 *
	 * @var string
	 */
	private $_title = '';

	/**
	 * An array containing a default set of fields that belong to the container.
	 *
	 * @var array
	 */
	protected $_fields = array();

	/**
	 * Constructor for the fields container class.
	 *
	 * @param string $handle A slug-like definition of the fields container.
	 * @param string $title A human-readable definition of the fields container.
	 * @param array $fields An array containing a default set of fields that belong to the container.
	 * @since 1.0.0
	 */
	function __construct( $handle, $title, $fields = array() )
	{
		$this->_handle = $handle;
		$this->_title = $title;
		$this->fields = $this->_add_fields( $fields );
	}

	/**
	 * Return the fields container handle.
	 *
	 * @since 1.0.0
	 * @return string A slug-like definition of the fields container.
	 */
	public function handle()
	{
		return $this->_handle;
	}

	/**
	 * Return the fields container title.
	 *
	 * @since 1.0.0
	 * @return string A human-readable definition of the fields container.
	 */
	public function title()
	{
		return $this->_title;
	}

	/**
	 * Add a series of fields to the fields container.
	 *
	 * @since 1.0.0
	 * @param array $fields An array of fields data.
	 */
	private function _add_fields( $fields = array() )
	{
		foreach ( $fields as $field ) {
			$this->add_field( $field );
		}
	}

	/**
	 * Add a field to the fields container.
	 *
	 * @since 1.0.0
	 * @param array $field The field data.
	 */
	public function add_field( $field = array() )
	{
		$this->_fields[] = $field;
	}

	protected function render_fields()
	{
		$fields = $this->fields();

		if ( ! empty( $fields ) ) {
			$field_types = apply_filters( 'thb_field_types', array() );

			foreach ( $fields as $field_structure ) {
				$field_class = $field_types[$field_structure['type']];
				$thb_field = new $field_class( $field_structure['handle'] );

				if ( isset( $field_structure['default'] ) ) {
					$thb_field->default_value( $field_structure['default'] );
				}

				if ( isset( $field_structure['value'] ) ) {
					$thb_field->value( $field_structure['value'] );
				}

				$thb_field->render();
			}
		}
	}

	/**
	 * Return the list of the fields that belong to the fields container.
	 *
	 * @since 1.0.0
	 * @return array An array of field data.
	 */
	abstract public function fields();

	/**
	 * Display the fields container.
	 *
	 * @since 1.0.0
	 */
	abstract public function render();

}