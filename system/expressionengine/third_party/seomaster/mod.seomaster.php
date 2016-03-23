<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include_once(PATH_THIRD . 'seomaster/addon.setup.php');

/**
 * SEO Master module
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

use BuzzingPixel\SeoMaster\Controller;

class Seomaster
{
	/**
	 * Data tag
	 *
	 * @return string
	 */
	public function header_tags()
	{
		$tagParams = ee()->TMPL->tagparams ?: array();
		$tagData = ee()->TMPL->tagdata ?: '';

		if (! isset($tagParams['side_id'])) {
			$tagParams['site_id'] = ee()->config->item('site_id');
		}

		$field = new Controller\Tag();
		return $field->header_tags($tagParams, $tagData);
	}
}
