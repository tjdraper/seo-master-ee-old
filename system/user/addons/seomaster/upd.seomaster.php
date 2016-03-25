<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include_once(PATH_THIRD . 'seomaster/addon.setup.php');

/**
 * SEO Master installer/updater
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

use BuzzingPixel\SeoMaster\Controller\Installer;

class Seomaster_upd
{
	public $name = SEOMASTER_NAME;
	public $version = SEOMASTER_VER;

	private $installer;

	/**
	 * Ansel_upd constructor
	 */
	public function __construct()
	{
		$this->installer = new Installer();
	}

	/**
	 * Install
	 *
	 * @return bool
	 */
	public function install()
	{
		$this->installer->install();
		return true;
	}

	/**
	 * Uninstall
	 *
	 * @return bool
	 */
	public function uninstall()
	{
		$this->installer->uninstall();
		return true;
	}

	/**
	 * Update
	 *
	 * @param string $current The current version before update
	 * @return bool
	 */
	public function update($current = '')
	{
		if ($current === $this->version) {
			return false;
		}

		$this->installer->generalUpdate();
		return true;
	}
}
