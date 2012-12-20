<?php

abstract class Type {

	public function getProperites() {
		return get_object_vars($this);
	}

}