<?php

/**
 * SEO Master UploadDirectories service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Data;

class UploadDirectories extends Base
{
	/**
	 * UploadDirectories Constructor
	 *
	 * @param bool $idAsKey Optional
	 */
	public function __construct($idAsKey = false)
	{
		$cacheName = $idAsKey ? 'UploadDirectoriesId' : 'UploadDirectories';

		$dirs = ee()->session->cache('ansel', $cacheName);

		if (! $dirs) {
			$dirs = $this->retrieve($idAsKey);

			ee()->session->set_cache('ansel', $cacheName, $dirs);
		}

		$this->setup($dirs);
	}

	/**
	 * Retrieve upload directories
	 *
	 * @param bool $idAsKey
	 */
	private function retrieve($idAsKey)
	{
		ee()->load->library('filemanager');

		$dirs = ee('Model')->get('UploadDestination')
			->filter('module_id', 0)
			->all();

		$sortedDirs = array();

		foreach ($dirs as $val) {
			$val = $val->toArray();

			if (gettype($val['server_path']) === 'object') {
				$path = $val['server_path'];
				$val['server_path'] = $path->path;
			}

			foreach ($val as $key => $item) {
				if ($key === 'id' || $key === 'site_id') {
					$val[$key] = (int) $item;
				}
			}

			$sortedDirs[$idAsKey ? $val['id'] : $val['name']] = $val;
		}

		asort($sortedDirs);

		return $sortedDirs;
	}
}
