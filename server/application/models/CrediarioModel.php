<?php

class CrediarioModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'crediario';
	}

	function remover($id) {
		$sql = "DELETE FROM crediario WHERE id_venda = ?";
		return $this->db->query($sql, array($id));
	}
}