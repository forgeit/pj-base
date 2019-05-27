<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends MY_Controller {

	public function atualizar() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$produto = json_decode($data);
		$produtoModel = array();
		$produtoModel['id_produto'] = $this->uri->segment(3);

		if (isset($produto->codigo)) {
			if (!trim($produto->codigo)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo código é obrigatório.")));
				die();
			} else {
				$produtoModel['codigo'] = $produto->codigo;

				if ($this->ProdutoModel->buscarPorCodigoId($produtoModel['codigo'], $produtoModel['id_produto'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O código informado para o produto já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo código é obrigatório.")));
			die();
		}

		if (isset($produto->nome)) {
			if (!trim($produto->nome)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
				die();
			} else {
				$produtoModel['nome'] = $produto->nome;

				if ($this->ProdutoModel->buscarPorNomeId($produtoModel['nome'], $produtoModel['id_produto'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O nome informado para o produto já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
			die();
		}

		if (isset($produto->custo)) {		
			if ($produto->custo) {
				$produtoModel['custo'] = $produto->custo;
			}
		}

		if (isset($produto->valor)) {
			if (!trim($produto->valor)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo valor é obrigatório.")));
				die();
			} else {
				$produtoModel['valor'] = $produto->valor;
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo valor é obrigatório.")));
			die();
		}

		if (isset($produto->quantidade)) {		
			if ($produto->quantidade) {
				$produtoModel['quantidade'] = $produto->quantidade;
			}
		}

		if (isset($produto->id_grupo)) {		
			if ($produto->id_grupo) {
				$produtoModel['id_grupo'] = $produto->id_grupo;
			}
		}

		if (isset($produto->observacao)) {		
			if ($produto->observacao) {
				$produtoModel['observacao'] = $produto->observacao;
			}
		}

		$response = array('exec' => $this->ProdutoModel->atualizar($produtoModel['id_produto'], $produtoModel, 'id_produto'));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao atualizar o registro." : "Erro ao atualizar o registro.");
		print_r(json_encode($array));
	}

	public function excluir() {
		$response = $this->ProdutoModel->excluir($this->uri->segment(3), 'id_produto');
		$message = array();

		$message[] = $response == TRUE ? 
			array('tipo' => 'success', 'mensagem' => 'Sucesso ao remover o registro.') : 
			array('tipo' => 'error', 'mensagem' => 'Erro ao remover o registro.');
			
		$array = array(
			'message' => $message,
			'status' => $response == TRUE ? 'true' : 'false'
		);
		print_r(json_encode($array));
	}

	public function buscar() {
		$array = array('data' => 
			array('ProdutoDTO' => $this->ProdutoModel->buscarPorId($this->uri->segment(2), 'id_produto')));
		print_r(json_encode($array));
	}

	public function buscarTodos() {
		$lista = $this->ProdutoModel->buscarTodosNativo();
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function buscarTodosProdutos() {
		$lista = $this->ProdutoModel->buscarTodosProdutos();
		print_r(json_encode(array('data' => array ('produtos' => $lista ? $lista : array()))));
	}

	public function buscarCodigo() {
		$lista = $this->ProdutoModel->buscarCodigo();

		$objeto = $lista[0];

		$objeto['id']  = ($objeto['id'] == null) ? 1 : $objeto['id'] + 1;
		$objeto['id'] = str_pad($objeto['id'], 5, "0", STR_PAD_LEFT);

		print_r(json_encode(array('data' => $objeto ? $objeto : array())));
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
		$produto = json_decode($data);
		$produtoModel = array();

		if (isset($produto->codigo)) {
			if (!trim($produto->codigo)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo código é obrigatório.")));
				die();
			} else {
				$produtoModel['codigo'] = $produto->codigo;

				if ($this->ProdutoModel->buscarPorCodigo($produtoModel['codigo'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O código informado para o produto já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo código é obrigatório.")));
			die();
		}

		if (isset($produto->nome)) {
			if (!trim($produto->nome)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
				die();
			} else {
				$produtoModel['nome'] = $produto->nome;

				if ($this->ProdutoModel->buscarPorNome($produtoModel['nome'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O nome informado para o produto já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
			die();
		}

		if (isset($produto->custo)) {		
			if ($produto->custo) {
				$produtoModel['custo'] = $produto->custo;
			}
		}

		if (isset($produto->valor)) {
			if (!trim($produto->valor)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo valor é obrigatório.")));
				die();
			} else {
				$produtoModel['valor'] = $produto->valor;
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo valor é obrigatório.")));
			die();
		}

		if (isset($produto->quantidade)) {		
			if ($produto->quantidade) {
				$produtoModel['quantidade'] = $produto->quantidade;
			}
		}

		if (isset($produto->id_grupo)) {		
			if ($produto->id_grupo) {
				$produtoModel['id_grupo'] = $produto->id_grupo;
			}
		}

		if (isset($produto->observacao)) {		
			if ($produto->observacao) {
				$produtoModel['observacao'] = $produto->observacao;
			}
		}
		
		$response = array('exec' => $this->ProdutoModel->inserir($produtoModel));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao salvar o registro." : "Erro ao salvar o registro.");
		print_r(json_encode($array));
	}

}