<?php

/**
 * SEO Master DisplayField controller
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Controller;

use BuzzingPixel\SeoMaster\Service\Data\FieldSettings;
use BuzzingPixel\SeoMaster\Service\Data\FieldData;

class DisplayField
{
	/**
	 * Render the field
	 *
	 * @param array $fieldSettings
	 */
	public function render($fieldSettings)
	{
		// Format the settings
		$fieldSettings = new FieldSettings($fieldSettings);

		// Get existing field data
		$fieldData = new FieldData();

		// var_dump($fieldSettings);
		// die;

		return ee()->load->view(
			'field',
			compact('fieldSettings', 'fieldData'),
			true
		);
	}
}
