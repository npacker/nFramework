<?php

class Query {

	protected $from;
	protected $fields;
	protected $limit;
	protected $offset;
	protected $order;
	protected $direction;
	protected $where = array();

	public function from($table, $fields=array('*')) {
		$this->from = $table;
		$this->fields[$table] = $fields;

		return $this;
	}

	public function limit($limit) {
		$this->limit = $limit;

		return $this;
	}

	public function order($order, $direction='ASC') {
		$this->order = $order;
		$this->direction = strtoupper($direction);

		return $this;
	}

	public function where($column, $value) {
	  $this->where[] = sprintf("$column = %s", $value);

		return $this;
	}

	protected function buildSelect() {
		$template = "SELECT %S FROM %s %s %s %s";
		$fields = array();
		$from = $where = $order = $limit = $query = '';

		foreach ($this->fields as $field => $alias) {
			(is_string($field)) ? $fields[] = "$field as $alias" : $fields[] = $alias;
		}

		$fields = implode(', ', $fields);
		$from = $this->from;
		$where = $this->whereClause();
		$order = $this->orderClause();
		$limit = $this->limitClause();
		$query = trim(sprintf($template, $fields, $from, $where, $order, $limit));

		return $query;
	}

	protected function buildInsert() {}

	protected function buildUpdate() {}

	protected function buildDelete() {}

	protected function whereClause() {
		if (isset($this->where)) {
			$where = "WHERE " . implode(' AND ', $this->where);
		}

		return $where;
	}

	protected function orderClause() {
		if (isset($this->order)) {
			$order = "ORDER BY {$this->order} {$this->direction}";
		}

		return $order;
	}

	protected function limitClause() {
		if (isset($this->limit)) {
			$limit = "LIMIT {$this->limit}";
		}

		return $limit;
	}

}