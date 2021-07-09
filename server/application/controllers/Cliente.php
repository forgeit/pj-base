<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends MY_Controller {

	public function atualizar() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$cliente = json_decode($data);
		$clienteModel = array();
		$clienteModel['id_cliente'] = $this->uri->segment(3);

		if (isset($cliente->nome)) {		
			if (!trim($cliente->nome)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
				die();
			} else {
				$clienteModel['nome'] = $cliente->nome;
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
			die();
		}

		$clienteModel['email'] = null;

		if (isset($cliente->email)) {		
			if ($cliente->email) {
				$clienteModel['email'] = $cliente->email;
			}
		}

		$clienteModel['cpf_cnpj'] = null;
		
		if (isset($cliente->cpf_cnpj)) {
			if ($cliente->cpf_cnpj) {
				$clienteModel['cpf_cnpj'] = $cliente->cpf_cnpj;
			}
		}
		
		if (isset($cliente->telefone)) {
			if (!trim($cliente->telefone)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
				die();
			} else {
				$clienteModel['telefone'] = $cliente->telefone;
				if ($this->ClienteModel->buscarPorTelefoneId($clienteModel['telefone'], $clienteModel['id_cliente'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O telefone informado já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
			die();
		}

		$response = array('exec' => $this->ClienteModel->atualizar($clienteModel['id_cliente'], $clienteModel, 'id_cliente'));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao atualizar o registro." : "Erro ao atualizar o registro.");
		print_r(json_encode($array));
	}

	public function excluir() {
		$response = $this->ClienteModel->excluir($this->uri->segment(3), 'id_cliente');
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
			array('ClienteDTO' => $this->ClienteModel->buscarPorId($this->uri->segment(2), 'id_cliente')));
		print_r(json_encode($array));
	}

	public function buscarTodos() {
		$lista = $this->ClienteModel->buscarTodosNativo();
		print_r(json_encode(array('data' => array ('datatables' => $lista ? $lista : array()))));
	}

	public function buscarTodosClientes() {
		$lista = $this->ClienteModel->buscarTodosClientes();
		print_r(json_encode(array('data' => array ('clientes' => $lista ? $lista : array()))));
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
		$cliente = json_decode($data);
		$clienteModel = array();

		if (isset($cliente->nome)) {		
			if (!trim($cliente->nome)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
				die();
			} else {
				$clienteModel['nome'] = $cliente->nome;
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
			die();
		}

		$clienteModel['email'] = null;

		if (isset($cliente->email)) {		
			if ($cliente->email) {
				$clienteModel['email'] = $cliente->email;
			}
		}

		if (isset($cliente->cpf_cnpj)) {
			if ($cliente->cpf_cnpj) {
				$clienteModel['cpf_cnpj'] = $cliente->cpf_cnpj;
			}
		}
		
		if (isset($cliente->telefone)) {
			if (!trim($cliente->telefone)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
				die();
			} else {
				$clienteModel['telefone'] = $cliente->telefone;


				if ($this->ClienteModel->buscarPorTelefone($clienteModel['telefone'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O telefone informado já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo nome é obrigatório.")));
			die();
		}
		
		$response = array('exec' => $this->ClienteModel->inserir($clienteModel));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao salvar o registro." : "Erro ao salvar o registro.");
		print_r(json_encode($array));
	}

}