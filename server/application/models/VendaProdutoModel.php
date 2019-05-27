<?php

class VendaProdutoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'venda_produto';
	}
}