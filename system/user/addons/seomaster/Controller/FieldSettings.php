<?php

/**
 * SEO Master FieldSettings
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Controller;

use BuzzingPixel\SeoMaster\Service\Data\UploadDirectories;

class FieldSettings
{
	/**
	 * FieldSettings constructor
	 *
	 * @param array $data
	 */
	public function __construct($data = array())
	{
		// Set data
		foreach ($data as $key => $val) {
			$this->{$key} = $val;
		}
	}

	/**
	 * Get magic method
	 */
	public function __get($name)
	{
		if (isset($this->{$name})) {
			return $this->{$name};
		}

		return null;
	}

	/**
	 * Render field settings
	 */
	public function render()
	{
		// Set page type to fieldSettings
		ee()->javascript->output(
			"window.SEOMASTER = window.SEOMASTER || {};" .
			"window.SEOMASTER.vars = window.SEOMASTER.vars || {};" .
			"window.SEOMASTER.vars.pageType = 'fieldSettings';"
		);

		// Add Chosen CSS
		$css = URL_THIRD_THEMES . 'seomaster/css/chosen.min.css';
		ee()->cp->add_to_head("<link rel=\"stylesheet\" href=\"{$css}\">");

		// Add Chosen JS
		$js = URL_THIRD_THEMES . 'seomaster/js/chosen.jquery.min.js';
		ee()->cp->add_to_foot(
			"<script type=\"text/javascript\" src=\"{$js}\"></script>"
		);

		// Get lang
		$yes = lang('yes');
		$no = lang('no');

		// Get Upload directories
		$uploadDirs = new UploadDirectories();

		// Set the form_dropdown array
		$uploadDropdown = array(
			'' => lang('field_settings_choose_dir')
		);

		foreach ($uploadDirs as $dir) {
			$uploadDropdown[$dir['id']] = $dir['name'];
		}

		// Set variables
		$this->display_indexing = $this->display_indexing ?: 'y';
		$this->display_title_suffix = $this->display_title_suffix ?: 'y';
		$this->display_title = $this->display_title ?: 'y';
		$this->display_description = $this->display_description ?: 'y';
		$this->display_share_image = $this->display_share_image ?: 'y';

		return array(
			// Indexing options
			array(
				'title' => 'field_setting_display_indexing',
				'fields' => array(
					'seomaster_display_indexing' => array(
						'type' => 'yes_no',
						'value' => $this->display_indexing
					)
				)
			),

			// Title suffix
			array(
				'title' => 'field_setting_display_title_suffix',
				'fields' => array(
					'seomaster_display_title_suffix' => array(
						'type' => 'yes_no',
						'value' => $this->display_title_suffix
					)
				)
			),

			// Title row
			array(
				'title' => 'field_setting_display_title',
				'fields' => array(
					'seomaster_display_title' => array(
						'type' => 'yes_no',
						'value' => $this->display_title
					)
				)
			),

			// Title max length
			array(
				'title' => 'field_setting_title_max_length',
				'fields' => array(
					'seomaster_title_max_length' => array(
						'type' => 'html',
						'content' => form_input(array(
							'name' => 'seomaster_title_max_length',
							'type' => 'number',
							'min' => 1,
							'placeholder' => lang('field_setting_title_max_length'),
							'value' => $this->title_max_length ?: 60
						))
					)
				)
			),

			// Description row
			array(
				'title' => 'field_setting_display_description',
				'fields' => array(
					'seomaster_display_description' => array(
						'type' => 'yes_no',
						'value' => $this->display_description
					)
				)
			),

			// Description max length
			array(
				'title' => 'field_setting_description_max_length',
				'fields' => array(
					'seomaster_description_max_length' => array(
						'type' => 'html',
						'content' => form_input(array(
							'name' => 'seomaster_description_max_length',
							'type' => 'number',
							'min' => 1,
							'placeholder' => lang('field_setting_description_max_length'),
							'value' => $this->description_max_length ?: 160
						))
					)
				)
			),

			// Share image row
			array(
				'title' => 'field_setting_display_share_image',
				'fields' => array(
					'seomaster_display_share_image' => array(
						'type' => 'yes_no',
						'value' => $this->display_share_image
					)
				)
			),

			// Share image upload directory
			array(
				'title' => 'field_setting_share_image_upload_dir',
				'fields' => array(
					'seomaster_share_image_upload_dir' => array(
						'type' => 'html',
						'content' => form_dropdown(
							'seomaster_share_image_upload_dir',
							$uploadDropdown,
							$this->share_image_upload_dir,
							"class=\"js-seomaster-chosen\" id=\"seomaster_share_image_upload_dir\""
						)
					)
				)
			)
		);
	}

	/**
	 * Save FieldSettings
	 *
	 * @param array $data
	 * @return array
	 */
	public function save($data)
	{
		$saveData = array();

		foreach($data as $saveKey => $save) {
			if (strncmp('seomaster_', $saveKey, 10) === 0) {
				$saveData[substr($saveKey, 10)] = $save;
			}
		}

		return $saveData;
	}
}
