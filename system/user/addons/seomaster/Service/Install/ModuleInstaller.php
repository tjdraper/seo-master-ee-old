<?php

/**
 * SEO Master ModuleInstaller service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Install;

class ModuleInstaller
{
	/**
	 * Add module record
	 */
	public function add()
	{
		ee()->db->insert('modules', array(
			'module_name' => 'Seomaster',
			'module_version' => SEOMASTER_VER,
			'has_cp_backend' => 'n',
			'has_publish_fields' => 'n'
		));
	}

	/**
	 * Remove module record
	 */
	public function remove()
	{
		ee()->db->where('module_name', 'Seomaster');
		ee()->db->delete('modules');
	}

	/**
	 * Update module record
	 */
	public function update()
	{
		ee()->db->where('module_name', 'Seomaster');
		ee()->db->update('modules', array(
			'module_version' => SEOMASTER_VER
		));
	}
}
