<?php

/**
 * SEO Master Installer controller
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Controller;

use BuzzingPixel\SeoMaster\Service\Install;
use BuzzingPixel\SeoMaster\Model;

class Installer
{
	private $moduleInstaller;
	private $fieldTypeInstaller;
	private $modelInstaller;

	/**
	 * Installer constructor
	 */
	public function __construct()
	{
		// Load services
		$this->moduleInstaller = new Install\ModuleInstaller();
		$this->fieldTypeInstaller = new Install\FieldTypeInstaller();
	}

	/**
	 * Install
	 */
	public function install()
	{
		// Install SeoMasterData model
		Model\Installer::install('SeoMasterData');

		// Add module
		$this->moduleInstaller->add();
	}

	/**
	 * Uninstall
	 */
	public function uninstall()
	{
		// Uninstall SeoMasterData model
		Model\Installer::uninstall('SeoMasterData');

		// Remove Module
		$this->moduleInstaller->remove();
	}

	/**
	 * General update routines
	 */
	public function generalUpdate()
	{
		// Update module
		$this->moduleInstaller->update();

		// Update fieldtype
		$this->fieldTypeInstaller->update();
	}
}
