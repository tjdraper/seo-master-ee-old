<?php

/**
 * SEO Master FieldTypeInstaller service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Install;

class FieldTypeInstaller
{
	/**
	 * Update fieldtype record
	 */
	public function update()
	{
		ee()->db->where('name', 'seomaster');
		ee()->db->update('fieldtypes', array(
			'version' => SIMPLETAG_VER
		));
	}
}
