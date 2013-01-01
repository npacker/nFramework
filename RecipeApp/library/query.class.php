<?php

class Query {

	protected $connection;
	protected $statement;
	protected $insert = true;
	protected $table;
	protected $columns;
	protected $limit;
	protected $offset;
	protected $order;
	protected $orderDirection;
	protected $group;
	protected $groupDirection;
	protected $where = array();
	protected $values = array();

	public function __construct(PDO $connection) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->connection = $connection;
	}

	public function __destruct() {
		echo 'Called ' . __METHOD__ . "<br />";
		unset($this->connection);
	}

	public function from($table, Array $columns=array('*')) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->table = $table;
		$this->columns = $columns;

		return $this;
	}

	public function where($column, $value, $operator='=') {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->where[] = "{$column} {$operator} :where_{$column}";
		$this->addValue("where_{$column}", $value);

		if ($this->insert) $this->insert = false;

		return $this;
	}

	public function order($column, $direction='ASC') {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->order = $column;
		$this->orderDirection = strtoupper($direction);

		return $this;
	}

	public function group($column, $direction='ASC') {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->group = $column;
		$this->groupDirection = strtoupper($drection);

		return $this;
	}

	public function limit($limit, $offset) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->limit = $limit;
		$this->offset = $offset;

		return $this;
	}

	protected function whereClause() {
		echo 'Called ' . __METHOD__ . "<br />";
		$where = '';

		if (!empty($this->where)) $where = "WHERE " . implode(' AND ', $this->where);

		return $where;
	}

	protected function groupClause() {
		echo 'Called ' . __METHOD__ . "<br />";
		$group = '';

		if (isset($this->group)) $group = "GROUP BY {$this->group} {$this->direction}";

		return $group;
	}

	protected function orderClause() {
		echo 'Called ' . __METHOD__ . "<br />";
		$order = '';

		if (isset($this->order)) $order = "ORDER BY {$this->order} {$this->direction}";

		return $order;
	}

	protected function limitClause() {
		echo 'Called ' . __METHOD__ . "<br />";
		$limit = '';

		if (isset($this->limit)) $limit = "LIMIT {$this->limit}";
		if (isset($this->offset)) $limit .= ",{$this->offset}";

		return $limit;
	}

	protected function buildSelect() {
		echo 'Called ' . __METHOD__ . "<br />";
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

	protected function buildInsert(Array $data) {
		echo 'Called ' . __METHOD__ . "<br />";
		$template = "INSERT INTO %s (%s) VALUES (%s)";
		$columns = array();

		foreach ($data as $column => $value) {
			$this->addValue($column, $value);
			$columns[] = $column;
		}

		$table = $this->table;
		$columns = implode(', ', $columns);
		$values = implode(', ', array_keys($this->values));
		$query = trim(sprintf($template, $table, $columns, $values));

		return $query;
	}

	protected function buildUpdate(Array $data) {
		echo 'Called ' . __METHOD__ . "<br />";
		$template = "UPDATE %s SET %s %s %s";
		$columns = array();

		foreach ($data as $column => $value) {
			$this->addValue($column, $value);
			$columns[] = "{$column} = :{$column}";
		}

		$table = $this->table;
		$columns = implode(', ', $columns);
		$where = $this->whereClause();
		$limit = $this->limitClause();
		$query = trim(sprintf($template, $table, $columns, $where, $limit));

		return $query;
	}

	protected function buildDelete() {
		echo 'Called ' . __METHOD__ . "<br />";
		$template = "DELETE FROM %s %s %s";
		$table = $this->table;
		$where = $this->whereClause();
		$limit = $this->limitClause();
		$query = trim(sprintf($template, $table, $where, $limit));

		return $query;
	}

	protected function addValue($column, $value) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->values[":{$column}"] = $value;
	}

	protected function setFetchMode($fetchMode, $option=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		try {
			($option) ? $this->statement->setFetchMode($fetchMode, $option) : $this->statement->setFetchMode($fetchMode);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	protected function prepare($query) {
		echo 'Called ' . __METHOD__ . "<br />";

		echo $query . "<br />";

		try {
			$this->statement = $this->connection->prepare($query);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	protected function execute() {
		echo 'Called ' . __METHOD__ . "<br />";
		try {
			$this->statement->execute($this->values);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function classtype($class) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = $this->buildSelect();
		$this->prepare($query);
		$this->setFetchMode(PDO::FETCH_CLASS, $class);
		$this->execute();
		$result = $this->statement;

		return $result;
	}

	public function both() {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = $this->buildSelect();
		$this->prepare($query);
		$this->setFetchMode(PDO::FETCH_BOTH);
		$this->execute();
		$result = $this->statement;

		return $result;
	}

	public function save(Array $data) {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = ($this->insert) ? $this->buildInsert($data) : $this->buildUpdate($data);
		$this->prepare($query);
		$this->execute();
	}

	public function delete() {
		echo 'Called ' . __METHOD__ . "<br />";
		$query = $this->buildDelete();
		$this->prepare($query);
		$this->execute();
	}

}