<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* métodos genéricos para atualizar */

class Model_CRUD extends CI_Model{
	//nome da tabela que deve ser ser realizada a pesquisa, utilizando o mesmo nome do controller como entidade
	private $table_name;

	//id que deve ser informada deve conferir com a id que existe na tabela informada
	private $table_id;

	public function __construct(){

		$this->load->database();
	}

	//buscará dados especificos
	public function buscaDados($table_name,$table_id){

			return true;
	}

	
	public function insert($table, $val){

        // $this->load->database();

        if($this->db->insert($table, $val)){
            return intval($this->db->insert_id());
        }else{
            return FALSE;
        }

    }

    //passar somente uma array com o que deve ser atualizado no banco
    public function updateById($table, $val, $id, $id_table_name){

        $this->load->database();

        return $this->db
        ->where($id_table_name, $id)
        ->update($table, $val);

    }

    //deletar o registro por meio de uma array no modelo CI
    public function deleteById($table, $where_table, $where_value){

        $this->load->database();

        $this->db->where($where_table, $where_value);
        return $this->db->delete($table);

    }

}
