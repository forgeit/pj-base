<?php

class CrediarioModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'crediario';
	}

	function buscarPorVenda($venda) {
		$sql = "SELECT
				id_crediario,
				DATE_FORMAT(c.data_vencimento, '%d/%m/%y %h:%i:%s') AS data_vencimento,
				CASE WHEN c.data_pagamento IS NULL THEN '-' ELSE DATE_FORMAT(c.data_pagamento, '%d/%m/%y %h:%i:%s') END AS data_pagamento,
				Concat('R$ ', Replace (Replace (Replace  (Format(c.valor_parcela, 2), '.', '|'), ',', '.'), '|', ',')) as valor_parcela,
				CASE WHEN c.data_pagamento IS NOT NULL THEN 'Paga'
					 WHEN c.data_vencimento < CURRENT_DATE AND c.data_pagamento IS NULL THEN 'Vencida'
					 ELSE 'Aguardando Pagamento' 
				END AS situacao
				FROM crediario c 
				JOIN venda v ON c.id_venda = v.id_venda
				WHERE v.id_venda = ?";

        $query = $this->db->query($sql, array($venda));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function remover($id) {
		$sql = "DELETE FROM crediario WHERE id_venda = ?";
		return $this->db->query($sql, array($id));
	}
}