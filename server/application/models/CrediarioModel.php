<?php

class CrediarioModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'crediario';
	}
}