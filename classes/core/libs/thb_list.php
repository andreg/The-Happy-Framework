<?php

/**
 * List class.
 *
 * This class manages an ordered list. It is an array wrapper that allows the
 * insertion and removal of items at a specific position.
 *
 * @package   TheHappyFramework
 * @since 	  1.0.0
 * @author 	  The Happy Bit <thehappybit@gmail.com>
 * @copyright Copyright (c) 2014 - 2015, Andrea Gandino, Simone Maranzana
 * @link 	  http://thbthemes.com/framework
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
class THB_List implements Iterator {

	/**
	 * The collection items.
	 *
	 * @var array
	 */
	private $_items = array();

	/**
	 * The iterator position.
	 *
	 * @var int
	 */
	private $_position = 0;

	/**
	 * Constructor for the list class.
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$this->rewind();
	}

	/**
	 * Return the current element.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	public function current()
	{
		return $this->get( $this->_position );
	}

	/**
	 * Return the index of the current element.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function key()
	{
		return $this->_position;
	}

	/**
	 * Move forward by one.
	 *
	 * @since 1.0.0
	 */
	public function next()
	{
		++$this->_position;
	}

	/**
	 * Rewind the list.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	public function rewind()
	{
		$this->_position = 0;
	}

	/**
	 * Check if the current element is valid.
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function valid()
	{
		return isset( $this->_items[$this->_position] );
	}

	/**
	 * Return the number of items in the collection.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function size()
	{
		return count( $this->_items );
	}

	/**
	 * Get an item from the collection.
	 *
	 * @since 1.0.0
	 * @param int $index The item index.
	 * @return mixed|bool
	 */
	public function get( $index=0 )
	{
		if( isset( $this->_items[$index] ) ) {
			return $this->_items[$index];
		}

		return FALSE;
	}

	/**
	 * Get the first item from the collection.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	public function get_first()
	{
		return $this->get( 0 );
	}

	/**
	 * Get the last item from the collection.
	 *
	 * @since 1.0.0
	 * @return mixed
	 */
	public function get_last()
	{
		end( $this->_items );
		return $this->get( key( $this->_items ) );
	}

	/**
	 * Get all the items in the collection.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_all()
	{
		return $this->_items;
	}

	/**
	 * Add a new item at the end of the collection.
	 *
	 * @since 1.0.0
	 * @param mixed $item The item to add to the collection.
	 */
	public function insert( $item )
	{
		$this->_items[] = $item;
	}

	/**
	 * Add a new item at a specific index of the collection.
	 *
	 * @since 1.0.0
	 * @param mixed $item The item to add to the collection.
	 * @param integer $index The item expected index.
	 */
	public function insert_at( $item, $index = 0 )
	{
		if ( $index < 0 ) {
			$size = $this->size();
			$index = $size + $index;
		}

		$start = array_slice( $this->_items, 0, $index );
		$end = array_slice( $this->_items, $index );
		$start[] = $item;
		$this->_items = array_merge( $start, $end );
	}

	/**
	 * Remove an item of the collection at a specific index.
	 *
	 * @since 1.0.0
	 * @param integer $index The item expected index.
	 */
	public function remove_at( $index = 0 )
	{
		if ( $index < 0 ) {
			$size = $this->size();
			$index = $size + $index - 1;
		}

		if ( isset( $this->_items[$index] ) ) {
			array_splice( $this->_items, $index, 1 );
		}
	}

	/**
	 * Remove the first element of the collection.
	 *
	 * @since 1.0.0
	 */
	public function remove_first()
	{
		$this->removeAt( 0 );
	}

	/**
	 * Remove the last element of the collection.
	 *
	 * @since 1.0.0
	 */
	public function remove_last()
	{
		array_pop( $this->_items );
	}

	/**
	 * Remove all the elements from the collection.
	 *
	 * @since 1.0.0
	 */
	public function remove_all()
	{
		$this->_items = array();
	}

}