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
		$fieldData = array();

		return ee()->load->view(
			'field',
			compact('fieldSettings', 'fieldData'),
			true
		);
	}
}
