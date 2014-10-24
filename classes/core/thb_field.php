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
	public $handle = '';

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
	 * Constructor for the field class.
	 *
	 * @param string $handle A slug-like definition of the field handle.
	 * @since 1.0.0
	 */
	function __construct( $handle )
	{
		$this->handle = $handle;
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
	protected function handle()
	{
		return $this->handle;
	}

}