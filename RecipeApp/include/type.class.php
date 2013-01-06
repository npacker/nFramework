<?php

abstract class Type extends Base {

	public function getProperites() {
		echo 'Called ' . __METHOD__ . "<br />";
		return get_object_vars($this);
	}

}