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
use BuzzingPixel\SeoMaster\Model\Model;

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
		$fieldData = new Model('SeoMasterData');
		$fieldData = $fieldData
			->filter('site_id', $fieldSettings->site_id)
			->filter('entry_id', $fieldSettings->content_id)
			->first();

		return ee()->load->view(
			'field',
			compact('fieldSettings', 'fieldData'),
			true
		);
	}
}
