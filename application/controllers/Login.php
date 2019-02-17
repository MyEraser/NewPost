<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	private $login;
	private $senha;
	private $token;

	public function __construct(){
		parent::__construct();
		$this->load->model('Model_CRUD','crud');
		$this->load->model('Model_Usuario','usuario');


		$this->load->library('session');

	}

	public function index(){
		$data['registros'] = 0;
		$this->load->view('layouts/header');
		$this->load->view('usuarios/login');
		// $this->load->view('layouts/mainLayout');

		// $this->load->view('layouts/mainLayout',$data);
	}

	public function entrar(){
		$login = $this->input->post('login');
		$senha = $this->input->post('senha');

		//só devolvo o id_usuario, se as credenciais existirem no banco de dados
		$id_usuario =  $this->searchIdUsuario($login,$senha);
	

		if($id_usuario == FALSE or $id_usuario == NULL){
			
			echo "<script> alert('Login ou senha inválidos') </script>";
			
			header(base_url());
		}else{

			$newdata = array(
        		'login'  => $login,
        		'senha'     => $senha,
        		'id_usuario' => $id_usuario[0]
			);

		}

		$this->session->set_userdata($newdata);

		$this->dashboard();

		// header('location'.base_url('Dashboard'));

		print_r($this->session->userdata());
		
	}

	public function dashboard(){
		$data['registros'] = 0;
		$this->load->view('layouts/header');
		$this->load->view('layouts/mainLayout',$data);
	}

	public function searchIdUsuario($login,$senha){

		return $this->usuario->credenciais($login,$senha);
	}

	//encerra a sessao e encaminha para a tela de login
	public function sair(){
		$array_unset = array(
			'login', 
        	'senha',
        	'id_usuario'
		);
		$this->session->unset_userdata($array_unset);

		header('location:'.base_url('login'));
	}

}