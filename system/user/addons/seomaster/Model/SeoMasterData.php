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

use BuzzingPixel\SeoMaster\Service\Data\EEFile;

class SeoMasterData extends Base
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
	public static $_typed_columns = array(
		'id' => 'int',
		'site_id' => 'int',
		'entry_id' => 'int',
		'no_index' => 'bool',
		'use_title_suffix' => 'bool',
		'title' => 'string',
		'description' => 'string',
		'image' => 'string'
	);

	/**
	 * Get the EEFile model on image set
	 *
	 * @param int $id
	 * @return object EEFile class
	 */
	protected function image__onSet($id)
	{
		return new EEFile($id);
	}

	/**
	 * Make sure the image is EEFile model
	 *
	 * @param int $image
	 * @return object EEFile class
	 */
	protected function image__onGet($image)
	{
		if (! $image instanceof EEFile) {
			$image = new EEFile(null);
		}

		return $image;
	}

	/**
	 * Format the image for saving to the database
	 */
	protected function image__onSave()
	{
		return $this->image->file_id;
	}
}
