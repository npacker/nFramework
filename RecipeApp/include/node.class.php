<?php

abstract class Node {

	public function getProperites() {
		return get_object_vars($this);
	}

}