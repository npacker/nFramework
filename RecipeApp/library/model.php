<?php

interface Model {

	protected $connection;

	abstract public function view();

	abstract public function create();

	abstract public function update();

	abstract public function delete();

}