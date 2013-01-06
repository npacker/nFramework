<?php

class UnitTest {

	protected $tests;
	protected $failedAssertions;
	protected $passed;
	protected $failed;
	protected $exceptions;

	protected function setAssertOptions() {
		function assertHandler($file, $line, $code) {

		}

		assert_options(ASSERT_ACTIVE, 1);
		assert_options(ASSERT_WARNING, 0);
		assert_options(ASSERT_BAIL, 0);
		assert_options(ASSERT_QUIET_EVAL, 1);
		assert_options(ASSERT_CALLBACK, 'assertHandler');
	}

	public function run() {
		$this->setAssertOptions();
	}

}