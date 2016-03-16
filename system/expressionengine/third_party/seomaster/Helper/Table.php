<?php

/**
 * SEO Master Table helper
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Helper;

class Table
{
	/**
	 * Insert table
	 *
	 * @param array $fields
	 * @param string $tableName
	 */
	public static function insert($fields, $tableName)
	{
		ee()->load->dbforge();

		// Set auto inc id field
		$defaultFields = array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			)
		);

		// Merge to form final field set
		$fields = array_merge($defaultFields, $fields);

		// Add fields to forge
		ee()->dbforge->add_field($fields);

		// Set the 'id' field as the primary key
		ee()->dbforge->add_key('id', true);

		// Create the table
		ee()->dbforge->create_table($tableName, true);
	}

	/**
	 * Remove table
	 *
	 * @param string $tableName
	 */
	public static function remove($tableName)
	{
		ee()->load->dbforge();

		ee()->dbforge->drop_table($tableName);
	}
}
