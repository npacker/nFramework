<?php

Class User extends Type {

	protected $name;
	protected $email;
	protected $password;

	public function __construct($name=null, $email=null, $password=null) {

	}

	public function name() {
		return $this->name;
	}

	public function email() {
		return $this->email;
	}

	public function password() {
		return $this->password;
	}

}