<?php

class Query {

	protected $from;
	protected $fields;
	protected $limit;
	protected $order;
	protected $direction;
	protected $where = array();

	public function from($table, $fields=array('*')) {
		$this->from = $table;
		$this->fields = $fields;

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

	public function where($column, $operator, $value) {
	  $this->where[] = sprintf("$column %s %s", $operator, $value);

		return $this;
	}

	protected function limitClause() {
		$limit = '';

		if (isset($this->limit)) $limit = "LIMIT {$this->limit}";

		return $limit;
	}

	protected function orderClause() {
		$order = '';

		if (isset($this->order)) $order = "ORDER BY {$this->order} {$this->direction}";

		return $order;
	}

	protected function whereClause() {
		$where = '';

		if (isset($this->where)) $where = "WHERE " . implode(' AND ', $this->where);

		return $where;
	}

	protected function buildSelect() {
		$template = "SELECT %S FROM %s %s %s %s";
		$fields = implode(', ', $this->fields);
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

	public function save($data) {}

	public function delete() {}

}