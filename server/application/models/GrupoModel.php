<?php

class GrupoModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'grupo';
	}

	function buscarPorDescricaoId($descricao, $id) {
		$sql = "SELECT 
				descricao
				FROM grupo p
				WHERE descricao = ? AND id_grupo <> ?";
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
				FROM grupo
				WHERE descricao = ?";
        $query = $this->db->query($sql, array($descricao));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}
	
	function buscarTodosNativo() {
		$sql = "SELECT 
				id_grupo,
                descricao
				FROM grupo";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

}