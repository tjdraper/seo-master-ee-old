<?php

/**
 * SEO Master Tag controller
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Controller;

use BuzzingPixel\SeoMaster\Model\Model;
use BuzzingPixel\SeoMaster\Service\Params\DataTagParams;
use BuzzingPixel\SeoMaster\Service\Data\DataTagData;
use BuzzingPixel\SeoMaster\Service\Vars\VarPrepare;

class Tag
{
	/**
	 * Data tag
	 *
	 * @param array $tagParams
	 * @param array $tagData
	 * @return string
	 */
	public function header_tags($tagParams, $tagData)
	{
		// Get tag params
		$tagParams = new DataTagParams($tagParams);

		return ee()->load->view(
			'data',
			$this->getTagData($tagParams, $tagData),
			true
		);
	}

	/**
	 * Tag pair
	 *
	 * @param array $tagParams
	 * @param array $tagData
	 * @return string
	 */
	public function pair($tagParams, $tagData)
	{
		// Get tag params
		$tagParams = new DataTagParams($tagParams);

		$data = $this->getTagData($tagParams, $tagData);

		return ee()->TMPL->parse_variables(
			$tagData,
			VarPrepare::process($data, $tagParams->namespace ?: 'seo')
		);
	}

	/**
	 * Get data for tag(s)
	 *
	 * @param array $tagParams
	 * @param array $tagData
	 * @return object
	 */
	private function getTagData($tagParams, $tagData)
	{
		// Get model data
		$model = new Model('SeoMasterData');

		/**
		 * Filter as required
		 */
		if ($id = $tagParams->id) {
			$model->filter('id', 'IN', $id);
		}

		if ($site_id = $tagParams->site_id) {
			$model->filter('site_id', 'IN', $site_id);
		}

		if ($entry_id = $tagParams->entry_id) {
			$model->filter('entry_id', 'IN', $entry_id);
		} else {
			$model->filter('entry_id', null);
		}

		if ($no_index = $tagParams->no_index) {
			if (
				$no_index === 'y' ||
				$no_index === 'yes' ||
				$no_index === 'true'
			) {
				$model->filter('no_index', 'y');
			} elseif (
				$no_index === 'n' ||
				$no_index === 'no' ||
				$no_index === 'false'
			) {
				$model->filter('no_index', 'n');
			}
		}

		if ($use_title_suffix = $tagParams->use_title_suffix) {
			if (
				$use_title_suffix === 'y' ||
				$use_title_suffix === 'yes' ||
				$use_title_suffix === 'true'
			) {
				$model->filter('use_title_suffix', 'y');
			} elseif (
				$use_title_suffix === 'n' ||
				$use_title_suffix === 'no' ||
				$use_title_suffix === 'false'
			) {
				$model->filter('use_title_suffix', 'n');
			}
		}

		if ($title = $tagParams->title) {
			$model->filter('title', 'IN', $title);
		}

		if ($description = $tagParams->description) {
			$model->filter('description', 'IN', $description);
		}

		$model = $model->first();

		return new DataTagData($model, $tagParams);
	}
}
