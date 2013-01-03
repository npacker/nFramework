<?php

class UnitTest {

	protected static $tests;

	protected function setAssertOptions() {
		function assertHandler($file, $line, $code) {

		}

		assert_options(ASSERT_ACTIVE, 1);
		assert_options(ASSERT_WARNING, 0);
		assert_options(ASSERT_BAIL, 0);
		assert_options(ASSERT_QUIET_EVAL, 1);
		assert_options(ASSERT_CALLBACK, 'assertHandler');
	}

	public static function run() {
		$this->setAssertOptions();
		$passed = array();
		$failed = array();
		$exceptions = array();

	}

}