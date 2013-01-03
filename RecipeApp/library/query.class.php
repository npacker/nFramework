<?php

class Query {

	protected $connection;
	protected $statement;
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
	protected $whereCalled = false;
	protected $fromCalled = false;

	public function __construct(PDO $connection) {
		$this->connection = $connection;
	}

	public function __destruct() {
		unset($this->connection);
	}

	protected function invalidArgumentExceptionMessage($method, &$argument, $argNum, $expected) {
		$template = "Argument %s passed to %s must be a %s, %s given.";
		$given = gettype($argument);
		$message = sprintf($template, $argNum, $method, $expected, $given);

		return $message;
	}

	public function from($table, Array $columns=array('*')) {
		if (empty($table)) throw new InvalidArgumentException('Table name must be set.');
		if (!is_string($table)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $table, 1, 'string'));

		$this->table = $table;
		$this->columns = $columns;
		$this->fromCalled = true;

		return $this;
	}

	public function where($column, $value, $operator='=') {
		if (empty($column)) throw new InvalidArgumentException('WHERE column must be set.');
		if (!is_string($column)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $column, 1, 'string'));
		if (!is_string($operator)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $operator, 3, 'string'));

		switch ($operator) {
			case '=':
			case '>':
			case '<':
			case '>=':
			case '<=':
			case '!=':
				break;
			default:
				throw new InvalidArgumentException('Invalid WHERE comparison operator.');
		}

		$this->where[] = "{$column} {$operator} :where_{$column}";

		try {
			$this->addValue("where_{$column}", $value);
		} catch (Exception $e) {
			throw $e;
		}

		$this->whereCalled = true;

		return $this;
	}

	public function order($column, $direction='ASC') {
		if (empty($column)) throw new InvalidArgumentException('ORDER BY column must be set.');
		if (!is_string($column)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $column, 1, 'string'));

		$this->order = $column;

		switch (strtoupper($direction)) {
			case 'ASC':
				$this->orderDirection = 'ASC';
				break;
			case 'DESC':
				$this->orderDirection = 'DESC';
				break;
			default:
				throw new InvalidArgumentException('Invalid ORDER BY direction.');
		}

		return $this;
	}

	public function group($column, $direction='ASC') {
		if (empty($column)) throw new InvalidArgumentException('GROUP BY column must be set.');
		if (!is_string($column)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $column, 1, 'string'));

		$this->group = $column;

		switch (strtoupper($direction)) {
			case 'ASC':
				$this->groupDirection = 'ASC';
				break;
			case 'DESC':
				$this->groupDirection = 'DESC';
				break;
			default:
				throw new InvalidArgumentException('Invalid GROUP BY direction.');
		}

		return $this;
	}

	public function limit($limit, $offset=null) {
		if (empty($limit)) throw new InvalidArgumentException('LIMIT value must be set.');
		if (!is_int($limit)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $limit, 1, 'integer'));

		$this->limit = $limit;

		if (isset($offset)) {
			if (!is_int($offset)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $offset, 2, 'integer'));
			$this->offset = $offset;
		}

		return $this;
	}

	protected function whereClause() {
		$where = '';

		if (!empty($this->where)) $where = "WHERE " . implode(' AND ', $this->where);

		return $where;
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

	protected function limitClause() {
		$limit = '';

		if (isset($this->limit)) $limit = "LIMIT {$this->limit}";
		if (isset($this->offset)) $limit .= ",{$this->offset}";

		return $limit;
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

	protected function buildInsert(Array $data) {
		$template = "INSERT INTO %s (%s) VALUES (%s)";
		$columns = array();
		$values = array();

		foreach ($data as $column => $value) {
			try {
				$this->addValue($column, $value);
			} catch (Exception $e) {
				throw $e;
			}

			$columns[] = (string) $column;
			$values[] = ":{$column}";
		}

		$table = $this->table;
		$columns = implode(', ', $columns);
		$values = implode(', ', $values);
		$query = trim(sprintf($template, $table, $columns, $values));

		return $query;
	}

	protected function buildUpdate(Array $data) {
		$template = "UPDATE %s SET %s %s %s";
		$columns = array();

		foreach ($data as $column => $value) {
			try {
				$this->addValue($column, $value);
			} catch (Exception $e) {
				throw $e;
			}

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
		$template = "DELETE FROM %s %s %s";
		$table = $this->table;
		$where = $this->whereClause();
		$limit = $this->limitClause();
		$query = trim(sprintf($template, $table, $where, $limit));

		return $query;
	}

	protected function addValue($column, $value) {
		if (empty($column)) throw new InvalidArgumentException('Column name must be specified for value.');

		$this->values[":{$column}"] = $value;
	}

	protected function setFetchMode($fetchMode, $options=null) {
		try {
			($options) ? $this->statement->setFetchMode($fetchMode, $options) : $this->statement->setFetchMode($fetchMode);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	protected function prepare($query) {
		echo "<p>{$query}</p>";

		try {
			$this->statement = $this->connection->prepare($query);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	protected function execute() {
		try {
			$this->statement->execute($this->values);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function classtype($class) {
		if (!class_exists($class)) throw new Exception("Class {$class} is undefined.");

		$query = $this->buildSelect();
		$this->prepare($query);
		$this->setFetchMode(PDO::FETCH_CLASS, $class);
		$this->execute();
		$result = $this->statement;

		return $result;
	}

	public function both() {
		$query = $this->buildSelect();
		$this->prepare($query);
		$this->setFetchMode(PDO::FETCH_BOTH);
		$this->execute();
		$result = $this->statement;

		return $result;
	}

	public function save(Array $data) {
		$query = ($this->whereCalled) ? $this->buildUpdate($data) : $this->buildInsert($data);
		$this->prepare($query);
		$this->execute();
	}

	public function delete() {
		$query = $this->buildDelete();
		$this->prepare($query);
		$this->execute();
	}

}