<?php

Class User extends Type {

	protected $name;
	protected $email;
	protected $password;

	public function __construct($name=null, $email=null, $password=null) {
		echo 'Called ' . __METHOD__ . "<br />";
		$this->name = $name;
		$this->email = $email;
		$this->password = $password;
	}

}