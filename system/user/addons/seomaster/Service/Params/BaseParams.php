<?php

/**
 * BaseParams service
 *
 * @package Stripe
 * @author TJ Draper <tj@buzzingpixel.com>
 */

namespace BuzzingPixel\SeoMaster\Service\Params;

abstract class BaseParams
{
	/**
	 * Baseparams constructor
	 *
	 * @param array $params
	 */
	public function __construct($params = array())
	{
		// Loop through the params and set them
		foreach ($this as $key => $val) {
			$param = isset($params[$key]) ? $params[$key] : null;
			$param = preg_replace('/^{.*?}/', '', $param);

			// If the param is not set, check if there is a fallback
			if (
				// Check if param is not set
				! $param &&
				// Check if there is a default value
				$this->{"_{$key}_default"} &&
				// Make sure an alternate is not set
				! isset($params[$this->{"_{$key}_default_when_not"}])
			) {
				// Set the default param
				$param = $this->{"_{$key}_default"};
			}

			// Process custom params
			if (strpos($val, 'custom|') === 0) {
				$ex = explode('|', $val);
				$method = $ex[1];

				$this->{$key} = $this->{$method}($param);

			// Set string value
			} elseif ($val === 'string') {
				$this->{$key} = $param;

			// Set int value
			} elseif ($val === 'int') {
				$this->{$key} = $param !== null ? (int) $param : null;

			// Set float value
			} elseif ($val === 'float') {
				$this->{$key} = $param !== null ? (float) $param : null;

			// Set array value
			} elseif (
				$val === 'array' ||
				$val === 'intArray' ||
				$val === 'floatArray'
			) {
				$param = $param ? explode('|', $param) : array();

				// Set array as ints
				if ($val === 'intArray') {
					foreach ($param as $pKey => $pVal) {
						$param[$pKey] = (int) $pVal;
					}

				// Set array as floats
				} elseif ($val === 'floatArray') {
					foreach ($param as $pKey => $pVal) {
						$param[$pKey] = (float) $pVal;
					}
				}

				$this->{$key} = $param;

			// Set truthy value
			} elseif ($val === 'truthy') {
				$this->{$key} = $this->truthy($param);

			// Set falsy value
			} elseif ($val === 'falsy') {
				$this->{$key} = $this->falsy($param);

			// Otherwise this type isn't account for and should be unset
			} else {
				unset($this->{$key});
			}
		}
	}

	/**
	 * Get truthy value
	 *
	 * @param string|bool $val
	 */
	private function truthy($val)
	{
		$truth = array(
			'y',
			'yes',
			'true',
			true
		);

		return in_array($val, $truth, true);
	}

	/**
	 * Get falsy value
	 *
	 * @Param string|bool $val
	 */
	private function falsy($val)
	{
		$false = array(
			'n',
			'no',
			'false',
			false
		);

		return ! in_array($val, $false, true);
	}

	/**
	 * Get param magic method
	 *
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		if (isset($this->{$name})) {
			return $this->{$name};
		}

		return null;
	}

	/**
	 * Set param magic method
	 *
	 * @param string $name
	 * @param mixed $val
	 * @return null
	 */
	public function __set($name, $val)
	{
		return null;
	}

	/**
	 * Get an md5 hash of all params
	 *
	 * @return string
	 */
	public function getHash()
	{
		return md5(serialize($this));
	}
}
