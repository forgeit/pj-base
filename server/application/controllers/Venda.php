<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Venda extends MY_Controller {

	public function atualizar() {
		// $data = $this->security->xss_clean($this->input->raw_input_stream);
		// $grupo = json_decode($data);
		// $grupoModel = array();
		// $grupoModel['id_grupo'] = $this->uri->segment(3);

		// if (isset($grupo->descricao)) {
		// 	if (!trim($grupo->descricao)) {
		// 		print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
		// 		die();
		// 	} else {
		// 		$grupoModel['descricao'] = mb_strtoupper($grupo->descricao);
		// 		if ($this->GrupoModel->buscarPorDescricaoId($grupoModel['descricao'], $grupoModel['id_grupo'])) {
		// 			print_r(json_encode($this->gerarRetorno(FALSE, "o grupo informado já está registrado.")));
		// 			die();
		// 		}
		// 	}
		// } else {
		// 	print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
		// 	die();
		// }

		// $response = array('exec' => $this->GrupoModel->atualizar($grupoModel['id_grupo'], $grupoModel, 'id_grupo'));
		// $array = $this->gerarRetorno($response, $response ? "Sucesso ao atualizar o registro." : "Erro ao atualizar o registro.");
		// print_r(json_encode($array));
	}

	public function excluir() {
		// $response = $this->GrupoModel->excluir($this->uri->segment(3), 'id_grupo');
		// $message = array();

		// $message[] = $response == TRUE ? 
		// 	array('tipo' => 'success', 'mensagem' => 'Sucesso ao remover o registro.') : 
		// 	array('tipo' => 'error', 'mensagem' => 'Erro ao remover o registro.');
			
		// $array = array(
		// 	'message' => $message,
		// 	'status' => $response == TRUE ? 'true' : 'false'
		// );
		// print_r(json_encode($array));
	}

	public function buscar() {
		// $array = array('data' => 
		// 	array('GrupoDTO' => $this->GrupoModel->buscarPorId($this->uri->segment(2), 'id_grupo')));
		// print_r(json_encode($array));
	}

	public function buscarContasPendentesCliente() {
		$lista = $this->VendaModel->buscarContasPendentesCliente($this->uri->segment(3));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function compra() {
		$lista = $this->VendaModel->compra($this->uri->segment(3));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function buscarContasPagasCliente() {
		$lista = $this->VendaModel->buscarContasPagasCliente($this->uri->segment(3));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function buscarTodos() {
		// $lista = $this->GrupoModel->buscarTodosNativo();
		// print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function buscarCombo() {
		// $lista = $this->GrupoModel->buscarCombo();
		// print_r(json_encode(array('data' => $lista ? $lista : array())));
	}
	
	private function gerarRetorno($response, $mensagem) {
		$message = array();
		$message[] = $response == TRUE ? 
		array('tipo' => 'success', 'mensagem' => $mensagem) : 
		array('tipo' => 'error', 'mensagem' => $mensagem);
		$array = array(
			'message' => $message,
			'status' => $response == TRUE ? 'true' : 'false'
		);
		return $array;
	}

	public function salvar() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$objetoEntrada = json_decode($data);
		$vendaModel = array();

		$objetoEntradaVenda = $objetoEntrada->venda;

		if (isset($objetoEntradaVenda->parcelamento)) {
			if (!trim($objetoEntradaVenda->parcelamento)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo número de parcelas é obrigatório.")));
				die();
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo número de parcelas é obrigatório.")));
			die();
		}

		if (isset($objetoEntrada->valor_total)) {
			if (!trim($objetoEntrada->valor_total)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O valor total é obrigatório.")));
				die();
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O valor total é obrigatório.")));
			die();
		}


		$compraParcelada = $objetoEntradaVenda->parcelamento > 1;

		if ($compraParcelada) {
			if (!isset($objetoEntradaVenda->cliente)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo cliente é obrigatório.")));
				die();
			}

			if (isset($objetoEntradaVenda->cliente->id_cliente)) {
				if (!trim($objetoEntradaVenda->cliente->id_cliente)) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O campo cliente é obrigatório.")));
					die();
				}
			} else {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo cliente é obrigatório.")));
				die();
			}

			if (!isset($objetoEntradaVenda->valorEntrada)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo valor entrada é obrigatório.")));
				die();
			}

			if (!isset($objetoEntradaVenda->dataPagamento)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo data de pagamento é obrigatório.")));
				die();
			}
		}

		$vendaModel['data_hora'] = date('Y-m-d H:i:s');
		$vendaModel['forma_pagamento'] = $objetoEntradaVenda->parcelamento;
		$vendaModel['valor_total'] = $objetoEntrada->valor_total;

		if ($compraParcelada) {
			$vendaModel['id_cliente'] = $objetoEntradaVenda->cliente->id_cliente;
			$vendaModel['valor_entrada'] = $objetoEntradaVenda->valorEntrada;
		}

		if (isset($objetoEntrada->carrinho)) {
			$carrinho = $objetoEntrada->carrinho;

			if (count($carrinho) <= 0) {
				print_r(json_encode($this->gerarRetorno(FALSE, "Erro ao detectar os produtos.")));
				die();
			}

		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "Erro ao detectar os produtos.")));
			die();
		}

		$produtoLista = array();

		foreach ($carrinho as $value) {
			$produto = array();

			if (isset($value->id_produto)) {
				if (!trim($value->id_produto)) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O código do produto não foi detectado.")));
					die();
				} else {
					$produto['id_produto'] = $value->id_produto;
				}
			} else {
				print_r(json_encode($this->gerarRetorno(FALSE, "O código do produto não foi detectado.")));
				die();
			}

			if (isset($value->valor)) {
				if (!trim($value->valor)) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O valor do produto não foi detectado.")));
					die();
				} else {
					$produto['valor'] = $value->valor;
				}
			} else {
				print_r(json_encode($this->gerarRetorno(FALSE, "O valor do produto não foi detectado.")));
				die();
			}

			if (isset($value->quantidade)) {
				if (!trim($value->quantidade)) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O quantidade do produto não foi detectado.")));
					die();
				} else {
					$produto['quantidade'] = $value->quantidade;
				}
			} else {
				print_r(json_encode($this->gerarRetorno(FALSE, "O valor do produto não foi detectado.")));
				die();
			}

			$produtoLista[] = $produto;
		}

		$this->db->trans_begin();

		$idVenda = $this->VendaModel->inserirRetornaId($vendaModel);

		foreach ($produtoLista as $key => $value) {
			$produtoLista[$key]['id_venda'] = $idVenda;
			$this->VendaProdutoModel->inserir($produtoLista[$key]);
		}

		if ($compraParcelada) {
			$valorParcela = ($vendaModel['valor_total'] - $vendaModel['valor_entrada']) / $vendaModel['forma_pagamento'];

			for ($i = 0; $i < $vendaModel['forma_pagamento']; $i++) {
				$crediario = array();
				$crediario['id_venda'] = $idVenda;

				$time = strtotime($objetoEntradaVenda->dataPagamento);
				$crediario['data_vencimento'] = date("Y-m-d", strtotime("+" . $i . " month", $time));
				$crediario['data_pagamento'] = NULL;
				$crediario['valor_parcela'] = $valorParcela;
				
				$this->CrediarioModel->inserir($crediario);
			}
		}

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			print_r(json_encode($this->gerarRetorno(FALSE, "Ocorreu um erro ao registrar a venda.")));
		} else {
			$this->db->trans_commit();
			print_r(json_encode($this->gerarRetorno(TRUE, "A venda foi registrada com sucesso.")));
		}
	}

}