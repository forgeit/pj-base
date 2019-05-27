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

	function buscarPorNomeId($nome, $id) {
		$sql = "SELECT 
				id_produto
				FROM produto
				WHERE nome = ? AND id_produto <> ?";
        $query = $this->db->query($sql, array($nome, $id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarPorCodigoId($codigo, $id) {
		$sql = "SELECT 
				id_produto
				FROM produto
				WHERE codigo = ? AND id_produto <> ?";
        $query = $this->db->query($sql, array($codigo, $id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarPorNome($nome) {
		$sql = "SELECT 
				id_produto
				FROM produto
				WHERE nome = ?";
        $query = $this->db->query($sql, array($nome));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarPorCodigo($codigo) {
		$sql = "SELECT 
				id_produto
				FROM produto
				WHERE codigo = ?";
        $query = $this->db->query($sql, array($codigo));
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

	function buscarTodosProdutos() {
		$sql = "select
				p.id_produto,
				p.codigo,
				p.nome,
				p.valor
				from produto p
				order by p.codigo";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarCodigo() {
		$sql = "SELECT 
				max(id_produto) as id
				FROM produto";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}
	

}
