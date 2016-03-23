<?php

/**
 * SEOMaster EEFile service
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Service\Data;

use BuzzingPixel\SeoMaster\Service;

class EEFile extends Base
{
	/**
	 * EEFile Constructor
	 *
	 * @param int $fileId Optional-if no ID, empty instance returned to populate
	 */
	public function __construct($fileId = false)
	{
		// Make sure the EE file model is loaded
		ee()->load->model('file_model');

		// Get the file
		if ($fileId) {
			$file = ee()->session->cache('ansel', "eefile-{$fileId}");

			if ($file) {
				$this->setup($file);
				return;
			}

			$file = ee()->file_model->get_files_by_id($fileId)->row();
		} else {
			$file = new Service\BlankSlate();
		}

		// Check if this file still exists
		if (! $file) {
			$this->setup(array());

			return;
		}

		// Cast properties appropriately
		$file->file_id = (int) $file->file_id;
		$file->site_id = (int) $file->site_id;
		$file->title = (string) $file->title;
		$file->upload_location_id = (int) $file->upload_location_id;
		$file->mime_type = (string) $file->mime_type;
		$file->file_name = (string) $file->file_name;
		$file->file_size = (int) $file->file_size;
		$file->description = (string) $file->description;
		$file->credit = (string) $file->credit;
		$file->location = (string) $file->location;
		$file->uploaded_by_member_id = (int) $file->uploaded_by_member_id;
		$file->upload_date = (int) $file->upload_date;
		$file->modified_by_member_id = (int) $file->modified_by_member_id;
		$file->modified_date = (int) $file->modified_date;

		// Explode the height and width appropriately
		if ($file->file_hw_original) {
			$fileHW = explode(' ', $file->file_hw_original);
			$file->width = (int) $fileHW[1];
			$file->height = (int) $fileHW[0];
			unset($file->file_hw_original);
		} else {
			$file->width = 0;
			$file->height = 0;
		}

		/**
		 * Get the real file path (EE does not update path from the config file)
		 */

		// Get directories
		$directories = new UploadDirectories(true);

		// Get this file's directory
		$uploadDir = $directories->{$file->upload_location_id};

		// Set the URL
		$file->url = $uploadDir['url'] . $file->file_name;

		// Set path variables
		$file->upload_location_name = $uploadDir['name'];
		$file->upload_location_path = $uploadDir['server_path'];
		$file->upload_location_url = $uploadDir['url'];
		$file->rel_path = $uploadDir['server_path'] . $file->file_name;

		// Set file info
		if ($file->file_name) {
			$pathinfo = pathinfo($file->file_name);
			$file->filename = $pathinfo['filename'];
			$file->basename = $pathinfo['basename'];
			$file->extension = $pathinfo['extension'];
		} else {
			$file->filename = '';
			$file->basename = '';
			$file->extension = '';
		}

		// Get the image type
		if ($file->rel_path && file_exists($file->rel_path)) {
			$fileSize = getimagesize($file->rel_path);
			$file->phpImageType = $fileSize[2];
		} else {
			$file->phpImageType = 0;
		}

		ee()->session->set_cache('ansel', "eefile-{$fileId}", $file);

		$this->setup($file);
	}

	/**
	 * Save the file
	 */
	public function save()
	{
		if ($this->file_id) {
			$this->saveFile();
		} else {
			$this->insertNewFile();
		}
	}

	/**
	 * Save file
	 */
	private function saveFile()
	{
		// Get directories
		$directories = new UploadDirectories(true);

		// Get this file's directory
		$uploadDir = $directories->{$this->upload_location_id};

		// Set the path
		$path = $uploadDir['server_path'] . $this->file_name;

		// Get the image size
		$imageSize = getimagesize($path);

		// Set up the insert data
		$insertData = array(
			'site_id' => $this->site_id,
			'title' => $this->title,
			'upload_location_id' => $this->upload_location_id,
			'rel_path' => $path,
			'mime_type' => mime_content_type($path),
			'file_name' => $this->file_name,
			'file_size' => fileSize($path),
			'description' => $this->description ?: null,
			'credit' => $this->credit ?: null,
			'location' => $this->location ?: null,
			'modified_by_member_id' => ee()->session->userdata('member_id'),
			'modified_date' => time(),
			'file_hw_original' => $imageSize[1] . ' ' . $imageSize[0]
		);

		// Update the record
		ee()->db->where('file_id', $this->file_id);
		ee()->db->update('files', $insertData);

		// Reconstruct the class
		$this->__construct($this->file_id);

		// Update thumbnails and manipulations
		$this->updateThumbsAndManipulations();
	}

	/**
	 * Insert new file
	 */
	private function insertNewFile()
	{
		// Make sure required items are set
		if (! $this->upload_location_id || ! $this->file_name) {
			return;
		}

		// Set the time
		$time = time();

		// Get directories
		$directories = new UploadDirectories(true);

		// Get this file's directory
		$uploadDir = $directories->{$this->upload_location_id};

		// Set the path
		$path = $uploadDir['server_path'] . $this->file_name;

		// Get the image size
		$imageSize = getimagesize($path);

		// Set the title
		$title = $this->title ?: $this->file_name;

		// Set up the insert data
		$insertData = array(
			'site_id' => ee()->config->item('site_id'),
			'title' => $title,
			'upload_location_id' => $this->upload_location_id,
			'rel_path' => $path,
			'mime_type' => mime_content_type($path),
			'file_name' => $this->file_name,
			'file_size' => fileSize($path),
			'description' => $this->description ?: null,
			'credit' => $this->credit ?: null,
			'location' => $this->location ?: null,
			'uploaded_by_member_id' => ee()->session->userdata('member_id'),
			'upload_date' => $time,
			'modified_by_member_id' => ee()->session->userdata('member_id'),
			'modified_date' => $time,
			'file_hw_original' => $imageSize[1] . ' ' . $imageSize[0]
		);

		// Add the record
		ee()->db->insert('files', $insertData);

		// Reconstruct the class
		$this->__construct(ee()->db->insert_id());

		// Update thumbnails and manipulations
		$this->updateThumbsAndManipulations();
	}

	/**
	 * Update thumbnails and manipulations
	 */
	private function updateThumbsAndManipulations() {
		ee()->load->library('filemanager');

		// Get dimensions for manipulations
		$dimensions = ee()->file_model
			->get_dimensions_by_dir_id($this->upload_location_id)
			->result_array();

		ee()->filemanager->create_thumb(
			$this->rel_path,
			array(
				'server_path' => $this->upload_location_path,
				'file_name' => $this->file_name,
				'dimensions' => $dimensions,
				'mime_type' => $this->mime_type
			),
			true,
			false
		);
	}
}
