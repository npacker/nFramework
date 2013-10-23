<?php

class Clause extends Base {

	protected $query;
	protected $values = array();

	public function __construct(Query &$query) {
		$this->query = $query;
	}

}