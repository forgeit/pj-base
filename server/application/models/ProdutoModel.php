<?php

class ProdutoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'produto';
	}

	function buscarPorDescricaoId($descricao, $id) {
		$sql = "SELECT 
				descricao
				FROM produto p
				WHERE descricao = ? AND id_produto <> ?";
        $query = $this->db->query($sql, array($descricao, $id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarPorDescricao($descricao) {
		$sql = "SELECT 
				descricao
				FROM produto
				WHERE descricao = ?";
        $query = $this->db->query($sql, array($descricao));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}
	
	function buscarTodosNativo() {
		$sql = "select
				p.id_produto,
				p.codigo,
				p.nome,
				g.descricao as grupo,
				p.valor,
				p.quantidade
				from produto p 
				join grupo g on g.id_grupo = p.id_grupo";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

}