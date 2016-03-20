<?php

/**
 * DataTagParams service
 *
 * @package Stripe
 * @author TJ Draper <tj@buzzingpixel.com>
 */

namespace BuzzingPixel\SeoMaster\Service\Params;

class DataTagParams extends BaseParams
{
	protected $id = 'intArray';
	protected $site_id = 'intArray';
	protected $entry_id = 'intArray';
	protected $no_index = 'string';
	protected $use_title_suffix = 'string';
	protected $title = 'string';
	protected $description = 'string';
	protected $no_index_override = 'truthy';
	protected $no_index_fallback = 'truthy';
	protected $use_title_suffix_override = 'truthy';
	protected $use_title_suffix_fallback = 'truthy';
	protected $title_override = 'string';
	protected $title_fallback = 'string';
	protected $description_override = 'string';
	protected $description_fallback = 'string';
	protected $seo_title_suffix_override = 'string';
	protected $twitter_card = 'string';
	protected $twitter_site = 'string';
}
