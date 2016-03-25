<?php

/**
 * SEO Master Model
 *
 * @package seomaster
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/software/seomaster
 * @copyright Copyright (c) 2016, BuzzingPixel, LLC
 */

namespace BuzzingPixel\SeoMaster\Model;

class Model
{
	private $modelName;
	private $filters = array();
	private $ordering = array();
	private $limit;

	private $filterMap = array(
		'==' => 'where',
		'!=' => 'where',
		'<' => 'where',
		'>' => 'where',
		'<=' => 'where',
		'>=' => 'where',
		'IN' => 'where_in',
		'NOT IN' => 'where_not_in'
	);

	/**
	 * Model constructor
	 *
	 * $param string $name The name of the model to get
	 */
	public function __construct($name = null)
	{
		$this->modelName = $name;
	}

	/**
	 * Get a model
	 *
	 * @param string $name The name of the model to get
	 * @return self
	 */
	public function get($name)
	{
		$this->modelName = $name;
		return $this;
	}

	/**
	 * Filter the model
	 *
	 * @param string $filterOn
	 * @param mixed $condition
	 * @param mixed $value
	 * @return self
	 */
	public function filter($filterOn, $condition, $value = null)
	{
		// Check if $condition is a condition or a value
		if ($value === null) {
			$value = $condition;
			$condition = '==';
		}

		if (! isset($this->filterMap[$condition])) {
			throw new \Exception('Conditional parameter not allowed');
		}

		$this->filters[] = compact(
			'filterOn', 'condition', 'value'
		);

		return $this;
	}

	/**
	 * Order the model
	 *
	 * @param string $by
	 * @param string $sort
	 * @return self
	 */
	public function order($by, $sort = 'DESC')
	{
		$this->ordering[] = compact(
			'by',
			'sort'
		);

		return $this;
	}

	/**
	 * Set model limit
	 *
	 * @param int $limit
	 * @return self
	 */
	public function limit($limit)
	{
		$this->limit = $limit;

		return $this;
	}

	/**
	 * Get first result
	 *
	 * @return object
	 */
	public function first()
	{
		$this->limit = 1;

		$models = $this->runQuery();

		if (! $models) {
			$modelClass = '\BuzzingPixel\SeoMaster\Model\\' . $this->modelName;

			return new $modelClass();
		}

		return $models[0];
	}

	/**
	 * Get all results
	 *
	 * @return object Collection
	 */
	public function all()
	{
		$models = $this->runQuery();

		return new Collection($models);
	}

	/**
	 * Run the query
	 */
	private function runQuery()
	{
		// Get the table name
		$modelClass = '\BuzzingPixel\SeoMaster\Model\\' . $this->modelName;
		$tableName = $modelClass::$_table_name;

		// Start the query
		ee()->db->select('*')
			->from($tableName);

		// Apply filters
		foreach ($this->filters as $filter) {
			if ($this->filterMap[$filter['condition']] === 'where') {
				if ($filter['condition'] === '==') {
					ee()->db->where($filter['filterOn'], $filter['value']);
				} else {
					ee()->db->where(
						$filter['filterOn'] . ' ' . $filter['condition'],
						$filter['value']
					);
				}
			} else {
				ee()->db->{$this->filterMap[$filter['condition']]}(
					$filter['filterOn'],
					$filter['value']
				);
			}
		}

		// Apply ordering
		foreach ($this->ordering as $ordering) {
			ee()->db->order_by($ordering['by'], $ordering['sort']);
		}

		// Apply limit
		if ($this->limit) {
			ee()->db->limit($this->limit);
		}

		// Get the result
		$result = ee()->db->get()->result();

		$models = array();

		// Get a model of each result
		foreach ($result as $data) {
			$model = new $modelClass();

			foreach ($data as $key => $item) {
				$model->{$key} = $item;
			}

			$models[] = $model;
		}

		return $models;
	}
}
