<?php

/**
 * SEO Master DataTagData Data service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Data;

use BuzzingPixel\SeoMaster\Model\Model;

class DataTagData extends Base
{
	/**
	 * DataTagData Constructor
	 *
	 * @param object $model
	 */
	public function __construct(
		\BuzzingPixel\SeoMaster\Model\SeoMasterData $model,
		\BuzzingPixel\SeoMaster\Service\Params\DataTagParams $tagParams
	)
	{
		$data = array(
			'no_index' => $tagParams->no_index_override ||
				$model->no_index_override ||
				$tagParams->no_index_fallback,
			'use_title_suffix' => $tagParams->use_title_suffix_override ||
				$model->use_title_suffix ||
				$tagParams->use_title_suffix_fallback,
			'title' => $tagParams->title_override ?:
				($model->title ?: $tagParams->title_fallback),
			'description' => $tagParams->description_override ?:
				($model->description ?: $tagParams->description_fallback),
			'image' => $tagParams->image_override ?:
				($model->image->url ? $model->image->url : $tagParams->image_fallback),
			'seo_title_suffix' => $tagParams->seo_title_suffix_override ?:
				' | ' . ee()->config->item('site_name'),
			'twitter_card' => $tagParams->twitter_card,
			'twitter_site' => $tagParams->twitter_site
		);

		if (! $data['title']) {
			$entryTitle = new Model('EntryTitle');
			$entryTitle = $entryTitle->filter('entry_id', 'IN', $model->id)
				->first();
		}

		$this->setup($data);
	}
}
