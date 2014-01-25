<?php

Class Session extends Type {

	protected $fingerprint;
	protected $created;
	protected $updated;

	public function __construct($fingerprint=null, $created=null, $updated=null) {
		$this->fingerprint = $fingerprint;
		$this->created = $created;
		$this->updated = $updated;
	}

}