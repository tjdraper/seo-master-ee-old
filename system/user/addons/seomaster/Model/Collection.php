<?php

/**
 * SEO Master ModelCollection service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Model;

use BuzzingPixel\SeoMaster\Helper\Table;

class Collection implements \ArrayAccess, \Iterator, \Countable
{
	private $position = 0;
	protected $items = array();

	/**
	 * ModelCollection constructor
	 *
	 * @param array $array Array of models
	 */
	public function __construct($array)
	{
		$this->items = $array;
	}

	/**
	 * Set magic method
	 */
	public function __set($name, $value)
	{
		// Check if there are any items in this collection
		if (isset($this->items[0])) {
			$firstItem = $this->items[0];

			// Check if the property exists on the model
			if (property_exists($firstItem, $name) && strpos($firstItem->{$name}, '_') !== 0) {
				// Loop through the models and set the property
				foreach ($this->items as $model) {
					$model->{$name} = $value;
				}
			}
		}

		return;
	}

	/**
	 * Get magic method
	 *
	 * @param string $name Class variable name
	 * @return mixed
	 */
	public function __get($name)
	{
		if (! isset($this->{$name})) {
			return null;
		}

		return $this->{$name};
	}

	/**
	 * Get all models as arrays
	 *
	 * @param bool $untypedProperties
	 */
	public function asArray($untypedProperties)
	{
		$array = array();

		foreach ($this->items as $model) {
			$array[] = $model->asArray($untypedProperties);
		}

		return $array;
	}

	/**
	 * Save all model data
	 */
	public function save()
	{
		// Check if there are any items in this collection
		if (isset($this->items[0])) {
			$firstItem = $this->items[0];

			ee()->db->update_batch(
				$firstItem::$_table_name,
				$this->asArray(true),
				'id'
			);
		}
	}

	/**
	 * Delete all model data
	 */
	public function delete()
	{
		// Check if there are any items in this collection
		if (isset($this->items[0])) {
			$firstItem = $this->items[0];

			$ids = array();

			foreach ($this->items as $key => $model) {
				$ids[] = $model->id;

				unset($this->items[$key]);
			}

			ee()->db->where_in('id', $ids);
			ee()->db->delete($firstItem::$_table_name);
		}
	}

	/**
	 * Required ArrayAccess Methods
	 */
	public function offsetSet($offset, $value)
	{
		if (is_null($offset)) {
			$this->items[] = $value;
		} else {
			$this->items[$offset] = $value;
		}
	}

	public function offsetExists($offset)
	{
		return isset($this->items[$offset]);
	 }

	public function offsetUnset($offset)
	{
		unset($this->items[$offset]);
	}

	public function offsetGet($offset)
	{
		return isset($this->items[$offset]) ? $this->items[$offset] : null;
	}

	/**
	 * Required Iterator methods
	 */
	public function current()
	{
		return $this->items[$this->position];
	}

	function key()
	{
		return $this->position;
	}

	function next()
	{
		++$this->position;
	}

	function rewind()
	{
		$this->position = 0;
	}

	function valid()
	{
		return isset($this->items[$this->position]);
	}

	/**
	 * Countable required method
	 */
	public function count()
	{
		return count($this->items);
	}
}
