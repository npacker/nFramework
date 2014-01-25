<?php

Class User extends Type {

	protected $name;
	protected $password;

	public function __construct($name=null, $password=null) {
		$this->name = $name;
		$this->password = $password;
	}

}