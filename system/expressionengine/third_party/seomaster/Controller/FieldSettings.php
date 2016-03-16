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
	public function __construct($data)
	{
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

		// Add Display Title Suffix row
		$this->display_title = $this->display_title ?: 'y';

		ee()->table->add_row(
			lang('field_setting_display_title', 'seomaster_display_title'),
			form_radio(array(
				'name' => 'seomaster_display_title',
				'id' => 'seomaster_display_title_yes',
				'value' => 'y',
				'checked' => $this->display_title === 'y'
			)) .
			"<label for=\"seomaster_display_title_yes\" class=\"seomaster-radio-label\">{$yes}</label>" .
			form_radio(array(
				'name' => 'seomaster_display_title',
				'id' => 'seomaster_display_title_no',
				'value' => 'n',
				'checked' => $this->display_title !== 'y'
			)) .
			"<label for=\"seomaster_display_title_no\" class=\"seomaster-radio-label\">{$no}</label>"
		);

		// Add Title Max Length row
		ee()->table->add_row(
			lang('field_setting_title_max_length', 'seomaster_title_max_length'),
			form_input(array(
				'name' => 'seomaster_title_max_length',
				'type' => 'number',
				'min' => 1,
				'placeholder' => lang('field_setting_title_max_length'),
				'id' => 'seomaster_title_max_length',
				'value' => $this->title_max_length
			))
		);

		// Add Display Title Suffix row
		$this->display_title_suffix = $this->display_title_suffix ?: 'y';

		ee()->table->add_row(
			lang('field_setting_display_title_suffix', 'seomaster_display_title_suffix'),
			form_radio(array(
				'name' => 'seomaster_display_title_suffix',
				'id' => 'seomaster_display_title_suffix_yes',
				'value' => 'y',
				'checked' => $this->display_title_suffix === 'y'
			)) .
			"<label for=\"seomaster_display_title_suffix_yes\" class=\"seomaster-radio-label\">{$yes}</label>" .
			form_radio(array(
				'name' => 'seomaster_display_title_suffix',
				'id' => 'seomaster_display_title_suffix_no',
				'value' => 'n',
				'checked' => $this->display_title_suffix !== 'y'
			)) .
			"<label for=\"seomaster_display_title_suffix_no\" class=\"seomaster-radio-label\">{$no}</label>"
		);

		// Add Description Max Length row
		ee()->table->add_row(
			lang('field_setting_description_max_length', 'seomaster_description_max_length'),
			form_input(array(
				'name' => 'seomaster_description_max_length',
				'type' => 'number',
				'min' => 1,
				'placeholder' => lang('field_setting_description_max_length'),
				'id' => 'seomaster_description_max_length',
				'value' => $this->description_max_length
			))
		);

		// Add Display Share Image row
		$this->display_share_image = $this->display_share_image ?: 'y';

		ee()->table->add_row(
			lang('field_setting_display_share_image', 'seomaster_display_share_image'),
			form_radio(array(
				'name' => 'seomaster_display_share_image',
				'id' => 'seomaster_display_share_image_yes',
				'value' => 'y',
				'checked' => $this->display_share_image === 'y'
			)) .
			"<label for=\"seomaster_display_title_suffix_yes\" class=\"seomaster-radio-label\">{$yes}</label>" .
			form_radio(array(
				'name' => 'seomaster_display_share_image',
				'id' => 'seomaster_display_share_image_no',
				'value' => 'n',
				'checked' => $this->display_share_image !== 'y'
			)) .
			"<label for=\"seomaster_display_share_image_no\" class=\"seomaster-radio-label\">{$no}</label>"
		);

		// Set Share Image upload directory
		ee()->table->add_row(
			lang('field_setting_share_image_upload_dir', 'seomaster_share_image_upload_dir'),
			form_dropdown(
				'seomaster_share_image_upload_dir',
				$uploadDropdown,
				$this->share_image_upload_dir,
				"class=\"js-seomaster-chosen\" id=\"seomaster_share_image_upload_dir\""
			)
		);
	}
}
