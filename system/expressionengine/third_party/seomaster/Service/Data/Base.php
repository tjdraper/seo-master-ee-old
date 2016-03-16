<?php

/**
 * Base Data service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Data;

class Base
{
	protected $properties;

	/**
	 * Set magic method
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		if (isset($this->properties[$name])) {
			$this->{$name} = $value;
		}
	}

	/**
	 * Setup properties
	 *
	 * @param array $items
	 */
	protected function setup($items)
	{
		foreach ($items as $key => $val) {
			$this->properties[$key] = gettype($val);
			$this->{$key} = $val;
		}
	}

	/**
	 * Get magic method
	 *
	 * @param string $name Class variable name
	 * @return mixed
	 */
	public function __get($name) {
		if (
			! isset($this->{$name}) ||
			! isset($this->properties[$name])
		) {
			return null;
		}

		return $this->{$name};
	}

	/**
	 * Get variable type
	 *
	 * @param string $name Variable name
	 * @return null|string
	 */
	public function getType($name)
	{
		if (! isset($this->properties[$name])) {
			return null;
		}

		return $this->properties[$name];
	}

	/**
	 * Get all properties as an array
	 *
	 * @return array
	 */
	public function asArray()
	{
		$array = array();

		foreach ($this->properties as $key => $val) {
			$array[$key] = $this->{$key};
		}

		return $array;
	}
}
