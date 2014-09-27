<?php

abstract class Entity {

	public function getProperites() {
		return get_object_vars($this);
	}

}