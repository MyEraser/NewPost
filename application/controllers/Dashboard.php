<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model('Model_CRUD','crud');

	}

	public function index(){

		$data['header'] = 'layouts/header';
		$data['pagina'] = 'home/home';

		$this->load->view('layouts/mainLayout',$data);
	}

}