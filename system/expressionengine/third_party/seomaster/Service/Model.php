<?php

/**
 * SEO Master Model base service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service;

use BuzzingPixel\SeoMaster\Helper\Table;

class Model implements \Iterator
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
		if (property_exists($this, $name) && strpos($this->{$name}, '_') !== 0) {
			return $this->{$name};
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
		if ($name === 'id' && $this->id !== null && ! property_exists($this, 'deleted')) {
			return;
		}

		if (property_exists($this, $name) && strpos($value, '_') !== 0) {
			$type = $this::$_typed_columns[$name];

			if ($type === 'int') {
				$value = (int) $value;
			} elseif ($type === 'bool') {
				$value = $value === 'y';
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
	 * Install model
	 */
	public function install()
	{
		if (ee()->db->table_exists(static::$_table_name)) {
			return;
		}

		$fields = array();

		foreach (static::$_typed_columns as $key => $val) {
			if ($key === 'id') {
				continue;
			}

			if ($val === 'int') {
				$fields[$key] = array(
					'type' => 'INT',
					'unsigned' => true
				);
			} elseif ($val === 'string') {
				$fields[$key] = array(
					'type' => 'TEXT'
				);
			} elseif ($val === 'bool') {
				$fields[$key] = array(
					'type' => 'CHAR',
					'length' => 1,
					'default' => 'n'
				);
			}
		}

		Table::insert($fields, static::$_table_name);
	}

	/**
	 * Uninstall model
	 */
	public function uninstall()
	{
		if (! ee()->db->table_exists(static::$_table_name)) {
			return;
		}

		Table::remove(static::$_table_name);
	}

	/**
	 * Required Iterator methods
	 */
	public function current() {
		return $this->{$this->itteratorKeys[$this->position]};
	}

	function key() {
		return $this->itteratorKeys[$this->position];
	}

	function next() {
		++$this->position;
	}

	function rewind() {
		$this->position = 0;
	}

	function valid() {
		return isset($this->itteratorKeys[$this->position]);
	}
}
