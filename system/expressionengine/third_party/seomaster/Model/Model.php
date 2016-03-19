<?php

/**
 * SEO Master Model base
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Model;

use BuzzingPixel\SeoMaster\Helper\Table;

class Model
{
	// Metadata
	protected static $_primary_key = 'id';
	protected static $_table_name = null;

	// Typed columns
	protected static $_typed_columns = array();

	/**
	 * Install model
	 */
	public function install()
	{
		if (ee()->db->table_exists(static::$_table_name)) {
			return;
		}

		$fields = array();

		foreach (static::$_typed_columns as $key => $val) {
			if ($key === 'id') {
				continue;
			}

			if ($val === 'int') {
				$fields[$key] = array(
					'type' => 'INT',
					'unsigned' => true
				);
			} elseif ($val === 'string') {
				$fields[$key] = array(
					'type' => 'TEXT'
				);
			} elseif ($val === 'bool') {
				$fields[$key] = array(
					'type' => 'CHAR',
					'length' => 1,
					'default' => 'n'
				);
			}
		}

		Table::insert($fields, static::$_table_name);
	}

	/**
	 * Uninstall model
	 */
	public function uninstall()
	{
		if (! ee()->db->table_exists(static::$_table_name)) {
			return;
		}

		Table::remove(static::$_table_name);
	}
}
