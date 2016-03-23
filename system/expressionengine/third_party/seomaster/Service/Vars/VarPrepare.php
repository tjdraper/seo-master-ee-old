<?php

/**
 * Var Namespace service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Vars;

class VarPrepare
{
	/**
	 * Get magic method
	 *
	 * @param string $name Class variable name
	 * @return mixed
	 */
	public static function process($vars, $namespace = '')
	{
		$returnVars = array();

		$namespace = $namespace ? $namespace . ':' : '';

		foreach ($vars as $key => $val) {
			$returnVars[$namespace . $key] = $val;
		}

		return array(
			$returnVars
		);
	}
}
