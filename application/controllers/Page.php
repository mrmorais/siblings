﻿<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//Abrir página inicial
		$this->load->view('home');
	}
	
	public function cadastro($tipo="default") {
		switch($tipo) {
			case "academia":
				$this->load->library('form_validation');
				//regras de validação dos dados do gerente
				$this->form_validation->set_rules('gerente_nome', 'Nome do gerente', 'required|max_length[45]');
				$this->form_validation->set_rules('gerente_sobrenome', 'Sobrenome do gerente', 'required|max_length[45]');
				$this->form_validation->set_rules('gerente_email', 'Email', 'required|trim|valid_email|max_length[255]');
				$this->form_validation->set_rules('gerente_senha', 'Senha', 'required|max_length[32]');
				$this->form_validation->set_rules('gerente_r_senha', 'Repetir senha', 'required|matches[gerente_senha]|max_length[32]');
				//regras de validação dos dados da academia
				$this->form_validation->set_rules('academia_nome', 'Nome da academia', 'required|max_length[45]');
				$this->form_validation->set_rules('academia_cidade', 'Cidade', 'required|max_length[45]');
				$this->form_validation->set_rules('academia_estado', 'Estado', 'required|max_length[2]');
				$this->form_validation->set_rules('academia_endereco', 'Endereço', 'max_length[45]');
				$this->form_validation->set_rules('academia_telefone', 'Telefone', 'max_length[45]');
				
				if ($this->form_validation->run()==FALSE) {
					//Se o formulario não foi preenchido corretamente ou se não foi preenchido ainda
					//Carrega a página de cadastro
					$this->load->view('cad_academia');
				} else {
					//Se o formulário foi enviado e preenchido corretamente
					$this->load->model('gerente_md', 'gerente');
					$this->load->model('academia_md', 'academia');
					if ($this->gerente->emailExiste($this->input->post('gerente_email'))) {
						$this->message("email_already_exists", "?/Page/cadastro/academia");
					} else {
						//Cadastrar gerente e academia no banco de dados
						$gerente_nome = $this->input->post('gerente_nome');
						$gerente_sobrenome = $this->input->post('gerente_sobrenome');
						$gerente_email = $this->input->post('gerente_email');
						$gerente_senha = $this->input->post('gerente_senha');
						
						//O cadastro retorna o ID gerado para o gerente
						$idGerente = $this->gerente->cadastrarGerente($gerente_nome, $gerente_sobrenome, $gerente_email, $gerente_senha);

						$academia_nome = $this->input->post('academia_nome');
						$academia_cidade = $this->input->post('academia_cidade');
						$academia_estado = $this->input->post('academia_estado');
						$academia_endereco = $this->input->post('academia_endereco');
						$academia_telefone = $this->input->post('academia_telefone');
						$idAcademia = $this->academia->cadastrarAcademia($academia_nome, $academia_cidade, $academia_estado, $academia_endereco, $academia_telefone);
						
						//Inserindo a relação entre academia e gerente
						$this->load->database();
						$dados = array("gerente_id"=>$idGerente, "academia_id"=>$idAcademia);
						$this->db->insert('gerente_has_academia', $dados);
						
						if ($idGerente == 0) {
							$this->message("error_cadastro", "?/Page");
						} else {
							$this->message("success_cadastro", "?/Page/login/academia");
						}
					}
					
				}
			
				
				break;
			case "aluno":
				//Carrega a página de cadastro de usuário
				$this->load->library('form_validation');
				//regras de validação dos dados do aluno
				$this->form_validation->set_rules('aluno_codigo', 'Código de Acesso', 'required|max_length[6]');
				$this->form_validation->set_rules('aluno_nome', 'Nome do aluno', 'required|max_length[45]');
				$this->form_validation->set_rules('aluno_sobrenome', 'Sobrenome do aluno', 'required|max_length[45]');
				$this->form_validation->set_rules('aluno_nascimento', 'Data de nascimento', 'required|max_length[45]');
				$this->form_validation->set_rules('aluno_email', 'Email', 'required|trim|valid_email|max_length[255]');
				$this->form_validation->set_rules('aluno_senha', 'Senha', 'required|max_length[32]');
				$this->form_validation->set_rules('aluno_r_senha', 'Repetir senha', 'required|matches[aluno_senha]|max_length[32]');
				$this->form_validation->set_rules('aluno_sexo', 'Sexo', 'required|max_length[1]');
				$this->form_validation->set_rules('aluno_endereco', 'Endereço', 'max_length[45]');
				$this->form_validation->set_rules('aluno_telefone', 'Telefone', 'max_length[45]');
				
				if ($this->form_validation->run()==FALSE) {
					//Se o formulario não foi preenchido corretamente ou se não foi preenchido ainda: Carrega a página de cadastro
					$this->load->view('cad_aluno');
					
				} else {
					$this->load->model('aluno_md', 'aluno');
					if ($this->aluno->emailExiste($this->input->post('aluno_email'))) {
						$this->message("email_already_exists", "?/Page/cadastro/aluno");
					} else {
						$idAcademia = $this->aluno->validarCodigoDeAcesso($this->input->post('aluno_codigo'));
						if (!$idAcademia) {
							$this->message("access_code_inexist", "?/Page");
						} else {
							$aluno_nome = $this->input->post('aluno_nome');
							$aluno_sobrenome = $this->input->post('aluno_sobrenome');
							$aluno_nascimento = $this->input->post('aluno_nascimento');
							$aluno_email = $this->input->post('aluno_email');
							$aluno_senha = $this->input->post('aluno_senha');
							$aluno_sexo = $this->input->post('aluno_sexo');
							$aluno_endereco = $this->input->post('aluno_endereco');
							$aluno_telefone = $this->input->post('aluno_telefone');

							$idAluno = $this->aluno->cadastrarAluno($aluno_nome, $aluno_sobrenome, $aluno_email, $aluno_senha, $aluno_nascimento, $aluno_sexo, $aluno_telefone, $aluno_endereco, $idAcademia);
							if ($idAluno == 0) {
								$this->message("error_cadastro", "?/Page");
							} else {
								$this->message("success_cadastro", "?/Page/login/aluno");
							}
						}
					}
				}

				break;
				
			case "personal":
				//Carrega a página de cadastro de usuário
				$this->load->library('form_validation');
				//regras de validação dos dados do aluno
				$this->form_validation->set_rules('personal_nome', 'Nome do personal', 'required|max_length[45]');
				$this->form_validation->set_rules('personal_sobrenome', 'Sobrenome do personal', 'required|max_length[45]');
				$this->form_validation->set_rules('personal_email', 'Email', 'required|trim|valid_email|max_length[255]');
				$this->form_validation->set_rules('personal_senha', 'Senha', 'required|max_length[32]');
				$this->form_validation->set_rules('personal_r_senha', 'Repetir senha', 'required|matches[personal_senha]|max_length[32]');
				
				if ($this->form_validation->run()==FALSE) {
					//Se o formulario não foi preenchido corretamente ou se não foi preenchido ainda: Carrega a página de cadastro
					$this->load->view('cad_personal');
					
				} else {
					$this->load->model('personal_md', 'personal');
					if ($this->personal->emailExiste($this->input->post('personal_email'))) {
						$this->message("email_already_exists", "?/Page/cadastro/personal");
					} else {
							$personal_nome = $this->input->post('personal_nome');
							$personal_sobrenome = $this->input->post('personal_sobrenome');
							$personal_email = $this->input->post('personal_email');
							$personal_senha = $this->input->post('personal_senha');

							$idPersonal = $this->personal->cadastrarPersonal($personal_nome, $personal_sobrenome, $personal_email, $personal_senha);
							
							if ($idPersonal == 0) {
								$this->message("error_cadastro", "?/Page");
							} else {
								$this->message("success_cadastro", "?/Page/login/personal");
							}
						}
					}

				break;
			default:
				$this->load->view("cadastro");
		}
	}
	
	public function login($tipo = null, $acao = "show") {
		switch ($acao) {
			case "show":
				switch ($tipo) {
					case null:
						$this->load->view("login", array("area"=>"picker"));
					break;
					case "aluno":
						$this->load->view("login", array("area"=>"aluno"));
					break;
					case "academia":
						$this->load->view("login", array("area"=>"academia"));
					break;
					case "personal":
						$this->load->view("login", array("area"=>"personal"));
					break;
				}
				break;
			case "go":
				$email = $this->input->post('email');
				$senha = $this->input->post('senha');
				
				$this->load->library('session');
				if ($this->session->has_userdata('tipo')) {
					if ($this->session->userdata('tipo')=="gerente") {
						header("Location: ?/Gerente");
					}
				}
				switch ($tipo) {
					case null:
						$this->load->view("login", array("area"=>"picker"));
					break;
					case "aluno":
						$this->load->model('aluno_md');
						$id = $this->aluno_md->validate($email, $senha);
						if($id != false) {
							$this->session->set_userdata(array("id"=>$id, "tipo"=>"aluno"));
							header("Location: ?/Aluno/");
						} else {
							$this->message("erro_login", "?/Page/login/aluno");
						}
					break;
					case "academia":
						$this->load->model('gerente_md');
						$id = $this->gerente_md->validate($email, $senha);
						if($id != false) {
							$this->session->set_userdata(array("id"=>$id, "tipo"=>"gerente"));
							header("Location: ?/Gerente/");
						} else {
							$this->message("erro_login", "?/Page/login/academia");
						}
					break;
					case "personal":
						$this->load->model('personal_md');
						$id = $this->personal_md->validate($email, $senha);
						if($id != false) {
							$this->session->set_userdata(array("id"=>$id, "tipo"=>"personal"));
							header("Location: ?/Personal/");
						} else {
							$this->message("erro_login", "?/Page/login/personal");
						}
					break;
				}
			break;
		}
	}
	
	public function message($tipo, $link) {
		switch($tipo) {
			case "email_already_exists":
				$data = array("tipo"=>"erro", 
							  "msg"=>"Já existe um usário cadastrado com este e-mail", 
							  "bt_text"=>"Tentar novamente",
							  "bt_href"=>$link);
				$this->load->view('message', $data);
				break;
			case "access_code_inexist":
				$data = array("tipo"=>"erro", 
							  "msg"=>"O código de acesso informado não existe", 
							  "bt_text"=>"Voltar para o início",
							  "bt_href"=>$link);
				$this->load->view('message', $data);
				break;
			case "error_cadastro":
				$data = array("tipo"=>"erro", 
							  "msg"=>"Houve algum problema no seu cadastro!", 
							  "bt_text"=>"Voltar para o início",
							  "bt_href"=>$link);
				$this->load->view('message', $data);
				break;
			case "success_cadastro":
				$data = array("tipo"=>"success", 
							  "msg"=>"Cadastro realizado com sucesso!", 
							  "bt_text"=>"Fazer login",
							  "bt_href"=>$link);
				$this->load->view('message', $data);
				break;
			case "erro_login":
				$data = array("tipo"=>"erro", 
							  "msg"=>"Acesso negado!", 
							  "bt_text"=>"Tentar novamente",
							  "bt_href"=>$link);
				$this->load->view('message', $data);
				break;
		}
	}
	
	//Função provisória para geração de codigo aleatório
	public function gerarcodigo($id) {
		//id é da academia
		$this->load->model("academia_md");
		$this->academia_md->set($id);
		
		echo $this->academia_md->emitirCodigo("aluno");
	}
}
