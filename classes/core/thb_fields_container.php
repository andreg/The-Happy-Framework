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

	/**
	 * Render a field in the fields container.
	 *
	 * @since 1.0.0
	 * @param array $element The field data.
	 */
	private function render_field( $element )
	{
		$field_types = apply_filters( 'thb_field_types', array() );
		$field_class = $field_types[$element['type']];
		$thb_field = new $field_class( $element['handle'] );

		if ( isset( $element['default'] ) ) {
			$thb_field->default_value( $element['default'] );
		}

		if ( isset( $element['value'] ) ) {
			$thb_field->value( $element['value'] );
		}

		$thb_field->render();
	}

	/**
	 * Render a group of fields in the fields container.
	 *
	 * @since 1.0.0
	 * @param array $element The group data.
	 */
	private function render_group( $group )
	{
		foreach ( $group['fields'] as $index => $field ) {
			$this->render_field( $field );
		}
	}

	/**
	 * Render the fields container fields.
	 *
	 * @since 1.0.0
	 */
	protected function render_elements()
	{
		$elements = $this->elements();

		if ( ! empty( $elements ) ) {
			foreach ( $elements as $index => $element ) {
				if ( $element['type'] === 'group' ) {
					$this->render_group( $element );
				}
				else {
					$this->render_field( $element );
				}
			}
		}
	}

	/**
	 * Validate a fields container fields structure. This method ensures that
	 * the provided structure for the fields container doesn't lead to
	 * inconsistencies.
	 * If the validator fails, the fields container will display no fields at
	 * all.
	 *
	 * @since 1.0.0
	 * @param array $elements The fields container fields structure.
	 * @return boolean
	 */
	protected static function _validate_fields_structure( $elements )
	{
		$groups = 0;

		foreach ( $elements as $index => $element ) {
			if ( $element['type'] === 'group' && array_key_exists( 'fields', $element ) && is_array( $element['fields'] ) ) {
				$groups++;

				if ( ! self::_validate_fields_structure( $element['fields'] ) ) {
					return false;
				}
			}
			else {
				if ( ! THB_Field::validate_structure( $element ) ) {
					return false;
				}
			}
		}

		if ( $groups > 0 && $groups !== count( $elements ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Return the list of the elements that belong to the fields container.
	 *
	 * @since 1.0.0
	 * @return array An array of elements data.
	 */
	abstract public function elements();

	/**
	 * Display the fields container.
	 *
	 * @since 1.0.0
	 */
	abstract public function render();

}