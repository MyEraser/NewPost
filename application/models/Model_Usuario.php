<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* métodos genéricos para atualizar */

class Model_Usuario extends CI_Model{
	//nome da tabela que deve ser ser realizada a pesquisa, utilizando o mesmo nome do controller como entidade
	private $table_name;

	//id que deve ser informada deve conferir com a id que existe na tabela informada
	private $table_id;

	public function __construct(){

		$this->load->database();
	}

    public function credenciais($login,$senha){
        $this->load->database();
        
        return $this->db
        ->select('id_usuario')
        ->from('usuarios')
        ->where('login', $login)
        ->where('senha',$senha)
        ->get()
        ->result_array();

	}

}
