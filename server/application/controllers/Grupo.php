<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grupo extends MY_Controller {

	public function atualizar() {
		$data = $this->security->xss_clean($this->input->raw_input_stream);
		$grupo = json_decode($data);
		$grupoModel = array();
		$grupoModel['id_grupo'] = $this->uri->segment(3);

		if (isset($grupo->descricao)) {
			if (!trim($grupo->descricao)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
				die();
			} else {
				$grupoModel['descricao'] = mb_strtoupper($grupo->descricao);
				if ($this->GrupoModel->buscarPorDescricaoId($grupoModel['descricao'], $grupoModel['id_grupo'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "o grupo informado já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
			die();
		}

		$response = array('exec' => $this->GrupoModel->atualizar($grupoModel['id_grupo'], $grupoModel, 'id_grupo'));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao atualizar o registro." : "Erro ao atualizar o registro.");
		print_r(json_encode($array));
	}

	public function excluir() {
		$response = $this->GrupoModel->excluir($this->uri->segment(3), 'id_grupo');
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
			array('GrupoDTO' => $this->GrupoModel->buscarPorId($this->uri->segment(2), 'id_grupo')));
		print_r(json_encode($array));
	}

	public function buscarTodos() {
		$lista = $this->GrupoModel->buscarTodosNativo();
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
		$grupo = json_decode($data);
		$grupoModel = array();

		if (isset($grupo->descricao)) {
			if (!trim($grupo->descricao)) {
				print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
				die();
			} else {
				$grupoModel['descricao'] = mb_strtoupper($grupo->descricao);

				if ($this->GrupoModel->buscarPorDescricao($grupoModel['descricao'])) {
					print_r(json_encode($this->gerarRetorno(FALSE, "O grupo informado já está registrado.")));
					die();
				}
			}
		} else {
			print_r(json_encode($this->gerarRetorno(FALSE, "O campo descrição é obrigatório.")));
			die();
		}
		
		$response = array('exec' => $this->GrupoModel->inserir($grupoModel));
		$array = $this->gerarRetorno($response, $response ? "Sucesso ao salvar o registro." : "Erro ao salvar o registro.");
		print_r(json_encode($array));
	}

}