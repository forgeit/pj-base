<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends MY_Controller {

	public function atualizar() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$produto = json_decode($data);
		$produtoModel = array();
		$produtoModel['id_produto'] = $this->uri->segment(3);

		if (isset($produto->descricao)) {
			if (!trim($produto->descricao)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
				die();
			} else {
				$produtoModel['descricao'] = mb_strtoupper($produto->descricao);
				if ($this->ProdutoModel->buscarPorDescricaoId($produtoModel['descricao'], $produtoModel['id_produto'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "o produto informado já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
			die();
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

		if (isset($produto->descricao)) {
			if (!trim($produto->descricao)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
				die();
			} else {
				$produtoModel['descricao'] = mb_strtoupper($produto->descricao);

				if ($this->ProdutoModel->buscarPorDescricao($produtoModel['descricao'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O produto informado já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
			die();
		}
		
		$response = array('exec' => $this->ProdutoModel->inserir($produtoModel));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao salvar o registro." : "Erro ao salvar o registro.");
		print_r(json_encode($array));
	}

}