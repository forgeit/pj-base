<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Venda extends MY_Controller {
	
	public function excluir() {
		$this->db->trans_begin();

		$this->VendaProdutoModel->remover($this->uri->segment(3));
		$this->CrediarioModel->remover($this->uri->segment(3));
		$this->VendaModel->excluir($this->uri->segment(3), 'id_venda');

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			print_r(json_encode($this->gerarRetorno(FALSE, "Ocorreu um erro ao remover a venda.")));
		} else {
			$this->db->trans_commit();
			print_r(json_encode($this->gerarRetorno(TRUE, "A venda foi removida com sucesso.")));
		}
	}

	public function buscarDadosHome() {
		$lista = $this->VendaModel->buscarDadosHome();

		print_r(json_encode(array('data' => $lista[0])));
	}

	public function reimprimirVenda() {
		$lista = $this->VendaModel->reimprimirVenda($this->uri->segment(3));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function buscarContasPendentesCliente() {
		$lista = $this->VendaModel->buscarContasPendentesCliente($this->uri->segment(3));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function visualizarVenda() {

		$retorno = array();

		$venda = $this->VendaModel->visualizarVenda($this->uri->segment(3));
		
		$retorno['venda'] = $venda[0];

		$produtos = $this->ProdutoModel->buscarPorVenda($this->uri->segment(3));
		$retorno['produtos'] = $produtos;

		if ($retorno['venda']['consultar_crediario'] == 1) {
			$crediario = $this->CrediarioModel->buscarPorVenda($this->uri->segment(3));
			$retorno['crediario'] = $crediario;
		}

		print_r(json_encode(array('data' => array ('datatables' => $retorno ? $retorno : array()))));
	}

	public function compra() {
		$lista = $this->VendaModel->compra($this->uri->segment(3));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function buscarDadosImpressao() {
		$lista = $this->VendaModel->buscarDadosImpressao($this->uri->segment(3), $this->uri->segment(4));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista[0] : array()))));
	}

	public function pagar() {
		$model = array();
		$model['id_crediario'] = $this->uri->segment(3);
		$model['data_pagamento'] = date('Y-m-d H:i:s');

		$response = array('exec' => $this->CrediarioModel->atualizar($model['id_crediario'], $model, 'id_crediario'));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao efetuar o pagamento." : "Erro ao efetuar o pagamento.");
		print_r(json_encode($array));
	}

	public function removerPagamento() {
		$model = array();
		$model['id_crediario'] = $this->uri->segment(3);
		$model['data_pagamento'] = NULL;

		$response = array('exec' => $this->CrediarioModel->atualizar($model['id_crediario'], $model, 'id_crediario'));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao remover o pagamento." : "Erro ao remover o pagamento.");
		print_r(json_encode($array));
	}

	public function buscarContasPagasCliente() {
		$lista = $this->VendaModel->buscarContasPagasCliente($this->uri->segment(3));
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
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

	public function buscarTodos() {
		$lista = $this->VendaModel->buscarTodosNativo();
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
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