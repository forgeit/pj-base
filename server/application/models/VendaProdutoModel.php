<?php

class VendaProdutoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'venda_produto';
	}

	function remover($id) {
		$sql = "DELETE FROM venda_produto WHERE id_venda = ?";
        return $this->db->query($sql, array($id));
	}
}