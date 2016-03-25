<?php

/**
 * SEO Master EntryTitle model
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Model;

class EntryTitle extends Base
{
	// Metadata
	public static $_table_name = 'channel_titles';

	// Properties
	protected $title;

	// Typed columns
	public static $_typed_columns = array(
		'title' => 'string'
	);
}
