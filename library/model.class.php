<?php

class Model extends SQLDB {
	protected $_model;

	function __construct() {	
		$this->connect();
	}


    function __destruct() {
	}
}

?>