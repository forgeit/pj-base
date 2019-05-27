<?php

class ClienteModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'cliente';
	}

	function buscarPorTelefoneId($telefone, $id) {
		$sql = "SELECT 
				nome
				FROM cliente p
				WHERE telefone = ? AND id_cliente <> ?";
        $query = $this->db->query($sql, array($telefone, $id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarPorTelefone($telefone) {
		$sql = "SELECT 
				nome
				FROM cliente p
				WHERE telefone = ?";
        $query = $this->db->query($sql, array($telefone));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}
	
	function buscarTodosNativo() {
		$sql = "SELECT 
				c.id_cliente,
                c.nome, 
                CASE WHEN c.cpf_cnpj IS NULL THEN '-' ELSE c.cpf_cnpj END AS cpf_cnpj, 
                CASE WHEN c.email IS NULL THEN '-' ELSE c.email END AS email, 
                c.telefone
				FROM cliente c";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarTodosClientes() {
		$sql = "SELECT 
				c.id_cliente,
                c.nome,
                c.telefone
				FROM cliente c 
				ORDER BY c.nome";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

}