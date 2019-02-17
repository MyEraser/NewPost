<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pontos extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model('Model_CRUD','crud');

	}

	public function index(){

		$this->load->view('layouts/header');
		$this->load->view('pontos/pontos');
		$this->load->view('layouts/mainLayout');
	}

}