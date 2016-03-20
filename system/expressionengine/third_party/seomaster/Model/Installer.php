<?php

/**
 * SEO Master Model Installer
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Model;

use BuzzingPixel\SeoMaster\Utility\Table;

class Installer
{
	/**
	 * Install a model
	 *
	 * @param string $name The name of the model class
	 */
	public static function install($name)
	{
		$modelClass = '\BuzzingPixel\SeoMaster\Model\\' . $name;

		if (ee()->db->table_exists($modelClass::$_table_name)) {
			return;
		}

		$fields = array();

		foreach ($modelClass::$_table_name as $key => $val) {
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

		Table::insert($fields, $modelClass::$_table_name);
	}

	/**
	 * Uninstall a model
	 *
	 * @param string $name The name of the model class
	 */
	public static function uninstall($name)
	{
		$modelClass = '\BuzzingPixel\SeoMaster\Model\\' . $name;

		if (! ee()->db->table_exists($modelClass::$_table_name)) {
			return;
		}

		Table::remove($modelClass::$_table_name);
	}
}
