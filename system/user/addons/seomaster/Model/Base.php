<?php

/**
 * SEO Master Model base service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Model;

abstract class Base implements \Iterator
{
	private $position = 0;
	private $itteratorKeys = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		foreach (static::$_typed_columns as $key => $val) {
			$this->itteratorKeys[] = $key;
		}
	}

	// Metadata
	protected static $_primary_key = 'id';
	protected static $_table_name = null;

	// Typed columns
	protected static $_typed_columns = array();

	/**
	 * Get magic method
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		if (
			property_exists($this, $name) &&
			strpos($name, '_') !== 0
		) {
			$value = $this->{$name};

			// Check for onGet method
			$modelMethods = get_class_methods($this);

			// Loop through the model methods
			foreach ($modelMethods as $methodName) {
				// Explode the name to look for onSet
				$check = explode('__', $methodName);

				// Check if we have a method to run for onSet
				if (count($check) === 2 && $check[0] === $name && $check[1] === 'onGet') {
					$value = $this->{$methodName}($value);

					break;
				}
			}

			return $value;
		}
	}

	/**
	 * Set magic method
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		if (
			$name === 'id' && $this->id !== null &&
			! property_exists($this, 'deleted')
		) {
			return;
		}

		// Make sure property exists and is not private
		if (property_exists($this, $name) && strpos($value, '_') !== 0) {
			$type = $this::$_typed_columns[$name];

			// Cast value properly
			if ($type === 'int') {
				$value = (int) $value;
			} elseif ($type === 'bool') {
				$value = $value === 'y';
			}

			// Check for onSet method
			$modelMethods = get_class_methods($this);

			// Loop through the model methods
			foreach ($modelMethods as $methodName) {
				// Explode the name to look for onSet
				$check = explode('__', $methodName);

				// Check if we have a method to run for onSet
				if (count($check) === 2 && $check[0] === $name && $check[1] === 'onSet') {
					$value = $this->{$methodName}($value);

					break;
				}
			}

			$this->{$name} = $value;
		}
	}

	/**
	 * Save model to database
	 *
	 * @return self
	 */
	public function save()
	{
		// Make sure an entry_id has been defined
		if (! $this->entry_id) {
			return $this;
		}

		// If site_id has not been defined, set it to current site_id
		if (! $this->site_id) {
			$this->site_id = ee()->config->item('site_id');
		}

		// Set data to be updated
		$updateData = $this->asArray(true);
		unset($updateData['id']);

		// Get model methods
		$modelMethods = get_class_methods($this);

		// Check for onSave methods
		foreach ($updateData as $key => $val) {
			// Loop through the model methods
			foreach ($modelMethods as $methodName) {
				// Explode the name to look for onSet
				$check = explode('__', $methodName);

				// Check if we have a method to run for onSet
				if (count($check) === 2 && $check[0] === $key && $check[1] === 'onSave') {
					$updateData[$key] = $this->{$methodName}();

					break;
				}
			}
		}

		// Create new record if there is no id
		if (! $this->id) {
			ee()->db->insert(static::$_table_name, $updateData);
			$this->id = ee()->db->insert_id();
		} else {
			// Update record
			ee()->db->where('id', $this->id);
			ee()->db->update(static::$_table_name, $updateData);
		}

		unset($this->deleted);

		return $this;
	}

	/**
	 * Delete the row from the database
	 */
	public function delete()
	{
		ee()->db->where('id', $this->id);
		ee()->db->delete(static::$_table_name);

		$this->deleted = true;

		foreach ($this as $key => $val) {
			$this->{$key} = null;
		}
	}

	/**
	 * Get the model data as an array
	 *
	 * @param bool $untypedProperties
	 */
	public function asArray($untypedProperties = false)
	{
		$array = array();

		foreach ($this as $key => $val) {
			if ($untypedProperties === true) {
				$type = $this::$_typed_columns[$key];

				if ($type === 'bool') {
					$val = $val ?'y' : 'n';
				}
			}

			$array[$key] = $val;
		}

		return $array;
	}

	/**
	 * Required Iterator methods
	 */
	public function current()
	{
		return $this->{$this->itteratorKeys[$this->position]};
	}

	function key()
	{
		return $this->itteratorKeys[$this->position];
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
		return isset($this->itteratorKeys[$this->position]);
	}
}
