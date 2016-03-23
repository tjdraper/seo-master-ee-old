<?php

/**
 * BlankSlate service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service;

class BlankSlate
{
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
}
