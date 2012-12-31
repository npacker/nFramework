<?php

Class User extends Type {

	protected $name;
	protected $password;

	public function __construct($name=null, $password=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->name = $name;
		$this->password = $password;
	}

}