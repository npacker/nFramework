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

	public function add(callable $test, $name='Untitled') {
		if (!is_string($name)) throw new InvalidArgumentException($this->invalidArgumentExceptionMessage(__METHOD__, $name, 2, 'string'));
		$this->tests[$name] = $test;
	}

	public function run() {
		$this->setAssertOptions();

		foreach ($this->tests as $name => $test) {
			try {
				$success = call_user_func($test);
				($success) ? array_push($this->passed, $name) : array_push($this->failed, $name);
			} catch (Exception $e) {
				array_push($this->exceptions, $e);
			}
		}
	}

}