<?php

/**
 * SEO Master Data model
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Model;

class SeoMasterData extends \BuzzingPixel\SeoMaster\Service\Model
{
	// Metadata
	public static $_table_name = 'seomaster_data';

	// Properties
	protected $id;
	protected $site_id;
	protected $entry_id;
	protected $no_index;
	protected $use_title_suffix;
	protected $title;
	protected $description;
	protected $image;

	// Typed columns
	protected static $_typed_columns = array(
		'id' => 'int',
		'site_id' => 'int',
		'entry_id' => 'int',
		'no_index' => 'bool',
		'use_title_suffix' => 'bool',
		'title' => 'string',
		'description' => 'string',
		'image' => 'string'
	);
}
