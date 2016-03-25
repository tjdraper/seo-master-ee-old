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

		// Display Indexing Options row
		$this->display_indexing = $this->display_indexing ?: 'y';

		ee()->table->add_row(
			lang('field_setting_display_indexing', 'seomaster_display_indexing'),
			form_radio(array(
				'name' => 'seomaster_display_indexing',
				'id' => 'seomaster_display_indexing_yes',
				'value' => 'y',
				'checked' => $this->display_indexing === 'y'
			)) .
			"<label for=\"seomaster_display_indexing_yes\" class=\"seomaster-radio-label\">{$yes}</label>" .
			form_radio(array(
				'name' => 'seomaster_display_indexing',
				'id' => 'seomaster_display_indexing_no',
				'value' => 'n',
				'checked' => $this->display_indexing !== 'y'
			)) .
			"<label for=\"seomaster_display_indexing_no\" class=\"seomaster-radio-label\">{$no}</label>"
		);

		// Display Title Suffix row
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

		// Display Title row
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

		// Title Max Length row
		ee()->table->add_row(
			lang('field_setting_title_max_length', 'seomaster_title_max_length'),
			form_input(array(
				'name' => 'seomaster_title_max_length',
				'type' => 'number',
				'min' => 1,
				'placeholder' => lang('field_setting_title_max_length'),
				'id' => 'seomaster_title_max_length',
				'value' => $this->title_max_length ?: 60
			))
		);

		// Display Discription row
		$this->display_description = $this->display_description ?: 'y';

		ee()->table->add_row(
			lang('field_setting_display_description', 'seomaster_display_description'),
			form_radio(array(
				'name' => 'seomaster_display_description',
				'id' => 'seomaster_display_description_yes',
				'value' => 'y',
				'checked' => $this->display_description === 'y'
			)) .
			"<label for=\"seomaster_display_description_yes\" class=\"seomaster-radio-label\">{$yes}</label>" .
			form_radio(array(
				'name' => 'seomaster_display_description',
				'id' => 'seomaster_display_description_no',
				'value' => 'n',
				'checked' => $this->display_description !== 'y'
			)) .
			"<label for=\"seomaster_display_description_no\" class=\"seomaster-radio-label\">{$no}</label>"
		);

		// Description Max Length row
		ee()->table->add_row(
			lang('field_setting_description_max_length', 'seomaster_description_max_length'),
			form_input(array(
				'name' => 'seomaster_description_max_length',
				'type' => 'number',
				'min' => 1,
				'placeholder' => lang('field_setting_description_max_length'),
				'id' => 'seomaster_description_max_length',
				'value' => $this->description_max_length ?: 160
			))
		);

		// Display Share Image row
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
