<?php

class UnitTest extends Base {

	protected $tests  = array();
	protected $failedAssertions = array();
	protected $passed = array();
	protected $failed  = array();
	protected $exceptions  = array();

	protected function setAssertOptions() {
		function assertHandler($file, $line, $code) {
			array_push($this->failedAssertions, array('file' => $file, 'line' => $line, 'code' => $code));
		}

		assert_options(ASSERT_ACTIVE, 1);
		assert_options(ASSERT_WARNING, 0);
		assert_options(ASSERT_BAIL, 0);
		assert_options(ASSERT_QUIET_EVAL, 1);
		assert_options(ASSERT_CALLBACK, 'assertHandler');
	}

	public function add(callable $test, $name) {
		if (!is_string($name)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $name, 2, 'string'));
		$this->tests[$name] = $test;
	}

	public function run() {
		$this->setAssertOptions();

		foreach ($this->tests as $name => $test) {
			try {
				call_user_func($test);
			} catch (Exception $e) {
				array_push($this->exceptions, $e);
				array_push($this->failed, $name);
			}
		}
	}

}