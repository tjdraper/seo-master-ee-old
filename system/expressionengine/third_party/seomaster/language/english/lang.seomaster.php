<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include_once(PATH_THIRD . 'seomaster/addon.setup.php');

$lang = array(
	// Module required lang
	'seomaster_module_name' => SEOMASTER_NAME,
	'seomaster_module_description' => SEOMASTER_DESCRIPTION,

	// Field settings
	'field_settings_choose_dir' => 'Choose a directory&hellip;',
	'field_setting_display_indexing' => 'Display indexing options?',
	'field_setting_display_title' => 'Display SEO Title field?',
	'field_setting_display_title_suffix' => 'Display the "Use SEO Title Suffix" options?',
	'field_setting_title_max_length' => 'SEO Title Max Length',
	'field_setting_display_description' => 'Display Description field?',
	'field_setting_description_max_length' => 'SEO Description Max Length',
	'field_setting_display_share_image' => 'Display Share Image field?',
	'field_setting_share_image_upload_dir' => 'Share Image Upload Directory',

	// Field
	'field_seo_title_label' => 'SEO Title',
	'field_seo_title_placeholder' => 'Type an SEO Title',
	'field_seo_title_explain' => 'Set an SEO title. If this field is not filled in, the Title field will be used.',
	'field_seo_title_suffix' => 'Use SEO Title Suffix?',
	'field_seo_no_index' => 'Search Engine Indexing',
	'field_seo_no_index_index' => 'Index',
	'field_seo_no_index_no_index' => 'No Index',
	'field_seo_description_label' => 'SEO Description',
	'field_seo_description_placeholder' => 'Type an SEO Description',
	'field_add_share_image_label' => 'Share Image',
	'field_add_share_image' => 'Add a Share Image',
	'field_remove_share_image' => 'Remove Share Image'
);
