<?php

abstract class Type extends Base {

	public function getProperites() {
		return get_object_vars($this);
	}

}