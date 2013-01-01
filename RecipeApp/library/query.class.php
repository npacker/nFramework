<?php

class Query {

	protected $connection;
	protected $statement;
	protected $insert = true;
	protected $table;
	protected $columns;
	protected $limit;
	protected $order;
	protected $orderDirection;
	protected $group;
	protected $groupDirection;
	protected $where = array();
	protected $values = array();

	public function __construct(MySqlDatabase $connection) {
		$this->connection = $connection;
	}

	public function table($table) {
		$this->table = $table;

		return $this;
	}

	public function columns($columns=array('*')) {
		$this->columns = $columns;

		return $this;
	}

	public function limit($limit) {
		$this->limit = $limit;

		return $this;
	}

	public function order($column, $direction='ASC') {
		$this->order = $column;
		$this->orderDirection = strtoupper($direction);

		return $this;
	}

	public function group($column, $direction='ASC') {
		$this->group = $column;
		$this->groupDirection = strtoupper($drection);

		return $this;
	}

	public function where($column, $operator, $value) {
		$this->where[] = "{$column} {$operator} :{$column}";
		$this->addValue($column, $value);

		if ($insert) $insert = false;

		return $this;
	}

	protected function limitClause() {
		$limit = '';

		if (isset($this->limit)) $limit = "LIMIT {$this->limit}";

		return $limit;
	}

	protected function groupClause() {
		$group = '';

		if (isset($this->group)) $group = "GROUP BY {$this->group} {$this->direction}";

		return $group;
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
		$template = "SELECT %s FROM %s %s %s %s %s";
		$columns = implode(', ', $this->columns);
		$table = $this->table;
		$where = $this->whereClause();
		$group = $this->groupClause();
		$order = $this->orderClause();
		$limit = $this->limitClause();
		$query = trim(sprintf($template, $columns, $table, $where, $group, $order, $limit));

		return $query;
	}

	protected function buildInsert($data) {
		$template = "INSERT INTO %s (%s) VALUES (%s)";

		foreach ($data as $column => $value) {
			$this->addValue($column, $value);
		}

		$table = $this->table;
		$columns = implode(', ', array_keys($this->values));
		$values = implode(', ', $this->values);
		$query = trim(sprintf($template, $table, $columns, $values));

		return $query;
	}

	protected function buildUpdate($data) {
		$template = "UPDATE %s SET %s %s %s";
		$columns = array();

		foreach ($data as $column => $value) {
			$this->addValue($column, $value);
			$columns[] = "{$column}=:{$column}";
		}

		$columns = implode(', ', $columns);
		$where = $this->whereClause();
		$limit = $this->limitClause();
		$query = trim(sprintf($template, $table, $columns, $where, $limit));

		return $query;
	}

	protected function buildDelete() {
		$template = "DELETE FROM %s %s %s";
		$table = $this->table;
		$where = $this->whereClause();
		$limit = $this->limitClause();
		$query = trim(sprintf($template, $table, $where, $limit));

		return $query;
	}

	protected function addValue($column, $value) {
		$this->values[":{$column}"] = $value;
	}

	protected function prepare($query) {
		$this->statement = $this->connection->prepare($query);
	}

	protected function execute() {
		$this->statement->execute($this->values);
	}

	protected function fetch() {
		$this->statement->fetch();
	}

	public function fetchClass($class) {
		$query = $this->buildSelect();
		$this->prepare($query);
		$this->statement->setFetchMode(PDO::FETCH_CLASS, $class);
		$this->execute();
		$result = $this->fetch();

		return $result;
	}

	public function fetchBoth() {
		$query = $this->buildSelect();
		$this->prepare($query);
		$this->statement->setFetchMode(PDO::FETCH_BOTH);
		$this->execute();
		$result = $this->fetch();

		return $result;
	}

	public function save($data) {
		($insert) ? $query = $this->buildInsert($data) : $query = $this->buildUpdate($data);
		$this->prepare($query);
		$this->execute();
	}

	public function delete() {
		$query = $this->buildDelete();
		$this->prepare($query);
		$this->execute();
	}

}