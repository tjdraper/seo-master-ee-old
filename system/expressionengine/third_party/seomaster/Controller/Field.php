<?php

/**
 * SEO Master Field controller
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

class Field
{
	private $fieldSettings;
	private $fieldData;

	/**
	 * Field constructor
	 *
	 * @param array $fieldSettings
	 */
	public function __construct($fieldSettings)
	{
		// Set JS variables
		ee()->javascript->output(
			"window.SEOMASTER = window.SEOMASTER || {};" .
			"window.SEOMASTER.vars = window.SEOMASTER.vars || {};" .
			"window.SEOMASTER.vars.pageType = 'fieldType';"
		);

		// Get settings object
		$this->fieldSettings = new FieldSettings($fieldSettings);

		// Get existing field data
		$fieldData = new Model('SeoMasterData');
		$this->fieldData = $fieldData
			->filter('site_id', $this->fieldSettings->site_id)
			->filter('entry_id', $this->fieldSettings->content_id)
			->first();

		// Start styles
		$css = '<style type="text/css">';
		$closeBtn = URL_THIRD_THEMES . 'seomaster/img/close-button.png';
		$closeBtn2x = URL_THIRD_THEMES . 'seomaster/img/close-button-2x.png';

		// Add close button
		$css .= ".seomaster-close-btn {background-image: url({$closeBtn});}";
		$css .= "@media only screen and (-webkit-min-device-pixel-ratio: 1.3), (min--moz-device-pixel-ratio: 1.3), (min-resolution: 1.3dppx) {";
		$css .= ".seomaster-close-btn {background-image: url({$closeBtn2x});}";
		$css .= "}";

		// End styles
		$css .= '</style>';

		// Send the CSS output to the browser
		ee()->cp->add_to_head($css);
	}

	/**
	 * Render the field
	 *
	 * @param array $fieldSettings
	 */
	public function render()
	{
		return ee()->load->view(
			'field',
			array(
				'fieldSettings' => $this->fieldSettings,
				'fieldData' => $this->fieldData
			),
			true
		);
	}

	/**
	 * Save the field
	 *
	 * @param array $data
	 */
	public function save($data)
	{
		// Set model data
		foreach ($data as $key => $val) {
			$this->fieldData->{$key} = $val;
		}

		// Set model entry ID
		$this->fieldData->entry_id = $this->fieldSettings->content_id;

		// Set model site ID
		$this->fieldData->site_id = $this->fieldSettings->site_id;

		// Save the model
		$this->fieldData->save();
	}
}
