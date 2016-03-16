<?php

/**
 * SEO Master FieldSettingsSave controller
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Controller;

class FieldSettingsSave
{
	/**
	 * Process FieldSettings
	 *
	 * @param array $data
	 * @return array
	 */
	public function process($data)
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
