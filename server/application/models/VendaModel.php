<?php

class VendaModel extends MY_Model {
	function __construct() {
		parent::__construct();
		$this->table = 'venda';
	}

	function compra($id) {
		$sql = "SELECT
				c.id_crediario,
				date_format(c.data_vencimento, '%d/%m/%y') as data_vencimento,
				case when c.data_pagamento is null then '-' else date_format(c.data_pagamento, '%d/%m/%y') end as data_pagamento,
				c.valor_parcela,
				case when c.data_pagamento is not null then true else false end as paga
				FROM venda v 
				JOIN crediario c ON c.id_venda = v.id_venda
				WHERE
				v.id_venda = ?
				ORDER BY c.id_crediario";

        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarContasPendentesCliente($id) {
		$sql = "select 
				v.id_venda,
				date_format(data_hora, '%d/%m/%y') as data_hora,
				forma_pagamento,
				Concat('R$ ', Replace (Replace (Replace  (Format(v.valor_total, 2), '.', '|'), ',', '.'), '|', ',')) as valor_total,
				count(case when c.data_pagamento is null then 1 else null end) as total_pendente
				from venda v
				join crediario c on c.id_venda = v.id_venda
				where v.id_cliente = ?
				and v.forma_pagamento > 1
				group by 1, 2, 3, 4
				having count(case when c.data_pagamento is null then 1 else null end) > 0 
				order by v.id_venda ";

        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}

	function buscarContasPagasCliente($id) {
		$sql = "select 
				v.id_venda,
				date_format(data_hora, '%d/%m/%y') as data_hora,
				forma_pagamento,
				Concat('R$ ', Replace (Replace (Replace  (Format(v.valor_total, 2), '.', '|'), ',', '.'), '|', ',')) as valor_total,
				count(case when c.data_pagamento is null then 1 else null end) as total_pendente
				from venda v
				join crediario c on c.id_venda = v.id_venda
				where v.id_cliente = 2
				and v.forma_pagamento > 1
				group by 1, 2, 3, 4
				having count(case when c.data_pagamento is null then 1 else null end) = 0 
				order by v.id_venda ";

        $query = $this->db->query($sql, array($id));
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
	}
}