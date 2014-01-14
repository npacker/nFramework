<?php

class Clause extends Base {

	protected $query;
	protected $values = array();

	public function __construct(Query $query) {
		$this->query = $query;
	}

	abstract public function andClause() {}

	abstract public function orClause() {}

	abstract public function andGroup() {}

	abstract public function orGroup() {}

	public function getValues() {
		return $this->values;
	}

}