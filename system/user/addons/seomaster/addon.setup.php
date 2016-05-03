<?php

defined('SEOMASTER_AUTHOR') || define('SEOMASTER_AUTHOR', 'TJ Draper');
defined('SEOMASTER_AUTHOR_URL') || define('SEOMASTER_AUTHOR_URL', 'https://buzzingpixel.com');
defined('SEOMASTER_DESCRIPTION') || define('SEOMASTER_DESCRIPTION', 'Take charge of ExpressionEngine SEO');
defined('SEOMASTER_DOCS_URL') || define('SEOMASTER_DOCS_URL', 'https://buzzingpixel.com/software/seomaster/documentation');
defined('SEOMASTER_NAME') || define('SEOMASTER_NAME', 'SEO Master');
defined('SEOMASTER_NAMESPACE') || define('SEOMASTER_NAMESPACE', 'BuzzingPixel\SeoMaster');
defined('SEOMASTER_VER') || define('SEOMASTER_VER', '1.0.1');

return array(
	'author' => SEOMASTER_AUTHOR,
	'author_url' => SEOMASTER_AUTHOR_URL,
	'description' => SEOMASTER_DESCRIPTION,
	'docs_url' => SEOMASTER_DOCS_URL,
	'name' => SEOMASTER_NAME,
	'namespace' => SEOMASTER_NAMESPACE,
	'settings_exist' => false,
	'version' => SEOMASTER_VER,
	'fieldtypes' => array(
		'seomaster' => array(
			'name' => 'SEO Master',
			'compatibility' => 'seomaster'
		)
	)
);
