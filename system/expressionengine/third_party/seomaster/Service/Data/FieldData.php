<?php

/**
 * SEO Master FieldData Data service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Data;

class FieldData extends Base
{
	/**
	 * FieldData Constructor
	 *
	 * @param array $rawSettings
	 */
	public function __construct($rawSettings = array())
	{
		if (! $rawSettings) {
			$this->setup(array());
			return;
		}

		$settings = array(
			'required' => $rawSettings['field_required'] === 'y',
			'field_id' => (int) $rawSettings['field_id'],
			'site_id' => (int) $rawSettings['site_id'],
			'group_id' => (int) $rawSettings['group_id'],
			'field_name' => $rawSettings['field_name'],
			'field_label' => $rawSettings['field_label'],
			'content_id' => (int) $rawSettings['content_id'] ?: false,
			'display_title' => $rawSettings['display_title'] === 'y',
			'title_max_length' => (int) $rawSettings['title_max_length'],
			'display_title_suffix' => $rawSettings['display_title_suffix'] === 'y',
			'description_max_length' => (int) $rawSettings['description_max_length'],
			'display_share_image' => $rawSettings['display_share_image'] === 'y',
			'share_image_upload_dir' => (int) $rawSettings['share_image_upload_dir']
		);

		$this->setup($settings);
	}
}
