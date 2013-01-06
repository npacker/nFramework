<?php

class UnitTest {

	protected $tests  = array();
	protected $failedAssertions = array();
	protected $passed = array();
	protected $failed  = array();
	protected $exceptions  = array();

	protected function setAssertOptions() {
		function assertHandler($file, $line, $code) {
			array_push($this->failedAssertions, array($file, $line, $code));
		}

		assert_options(ASSERT_ACTIVE, 1);
		assert_options(ASSERT_WARNING, 0);
		assert_options(ASSERT_BAIL, 0);
		assert_options(ASSERT_QUIET_EVAL, 1);
		assert_options(ASSERT_CALLBACK, 'assertHandler');
	}

	public function add(callable $test) {
		array_push($this->tests, $test);
	}

	public function run() {
		$this->setAssertOptions();
	}

}