<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include_once(PATH_THIRD . 'seomaster/addon.setup.php');

/**
 * SEO Master field type
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

use BuzzingPixel\SeoMaster\Controller;

class Seomaster_ft extends EE_Fieldtype
{
	// Set EE fieldtype info
	public $info = array(
		'name' => SEOMASTER_NAME,
		'version' => SEOMASTER_VER
	);

	// Set field type as tag pair
	public $has_array_data = true;

	/**
	 * FieldType constructor
	 */
	public function __construct()
	{
		// Make sure SeoMaster is really being requested and we're in the CP
		if (
			REQ === 'CP' &&
			ee()->uri->segment(3) !== 'package_settings' &&
			in_array(PATH_THIRD . 'seomaster/', ee()->config->_config_paths)
		) {
			// Make sure the package path is available
			ee()->load->add_package_path(PATH_THIRD . 'seomaster/');

			// Make sure the lang file is available
			ee()->lang->loadfile('seomaster');

			// Add CSS
			$css = URL_THIRD_THEMES . 'seomaster/css/style.min.css';
			ee()->cp->add_to_head("<link rel=\"stylesheet\" href=\"{$css}\">");

			// Add JS
			$js = URL_THIRD_THEMES . 'seomaster/js/script.min.js';
			ee()->cp->add_to_foot(
				"<script type=\"text/javascript\" src=\"{$js}\"></script>"
			);
		}

		// Make sure the parent constructor runs
		parent::__construct();
	}

	/**
	 * Field settings
	 *
	 * @param string $data Existing field setting data
	 */
	public function display_settings($data)
	{
		// Load the controller and render
		$fieldSettings = new Controller\FieldSettings($data);
		$fieldSettings->render();
	}

	/**
	 * Save settings
	 *
	 * @param array $data Field setting data
	 * @return array
	 */
	public function save_settings($data)
	{
		// Load the controller and process the data
		$fieldSettingsSave = new Controller\FieldSettings();
		return $fieldSettingsSave->save($data);
	}

	/**
	 * Display field
	 *
	 * @param mixed $data Existing field data
	 * @return string
	 */
	public function display_field($data)
	{
		$fieldSettings = $this->settings;
		$fieldSettings['content_id'] = $this->content_id;

		// Load the controller and render
		$field = new Controller\Field($fieldSettings);
		return $field->render();
	}

	/**
	 * Save field data
	 *
	 * @param mixed $data
	 * @return string
	 */
	public function save($data)
	{
		// Get a unique ID
		$uniqueId = uniqid();

		// Cache the data for use in post_save
		ee()->session->set_cache('seomaster', 'post_data', $data);

		return $uniqueId;
	}

	/**
	 * Save field data to SeoMaster table
	 *
	 * @param string $data
	 */
	public function post_save($data)
	{
		$data = ee()->session->cache('seomaster', 'post_data', $data);

		$fieldSettings = $this->settings;
		$fieldSettings['content_id'] = $this->content_id;

		// Load the controller and render
		$field = new Controller\Field($fieldSettings);
		return $field->save($data);
	}

	/**
	 * Replace tag
	 *
	 * @param string $fieldData
	 * @param array $tagParams
	 * @return string
	 */
	public function replace_tag(
		$fieldData = false,
		$tagParams = array(),
		$tagData = false
	)
	{
		$tagParams = $tagParams ?: array();
		$tagParams['site_id'] = ee()->config->item('site_id');
		$tagParams['entry_id'] = $this->content_id;

		$field = new Controller\Tag();
		return $field->data($tagParams, $tagData);
	}
}
