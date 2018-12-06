<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#=====================================================================================================================
# LocalizaУЇУЃo deste arquivo : application/models
# @copyright (c). Base Administrativa do Quartel-General do Exщrcito - FORTE CAXIAS
# @author Sd Figueira - STI B Adm QGEx
#
# =====================================================================================================================

class Requisicoes_m extends CI_Model {

	public function __construct(){
        parent::__construct();
        $this->dgp = $this->load->database('dgp',TRUE);
				$this->load->model('Log_m');
				$this->load->model('Users_m');
				$this->load->helper('est');
    }

	public function get_requisicao($cod , $modo = ""){
		$cod = strtoupper($cod);
		if($modo == "full")
		{
			switch (substr($cod,0,2)){
				case 'CR':
					$r = 
					$this->db->query('select * from est_requisicao_cracha where id = '.substr($cod,2))->row();
					$r->dt = data_br($r->dt);
					$r->tipo = "Crachс";
					return $r;
				case 'CA':
					$r = 
					$this->db->query('select * from est_requisicao_cartao where id = '.substr($cod,2))->row();
					$r->dt = data_br($r->dt);
					$r->tipo = "Cartуo de Estacionamento";
					return $r;
				default:
					$r = new StdClass();
					$r->dt = "-";
					$r->titulo = "-";
					$r->nome_guerra = "-";
					$r->tipo = "-";
					return $r;
			}
		}
		else
		{
			switch (substr($cod,0,2)){
				case 'CR':
				$r = 
				$this->db->query('select dt, titulo, nome_guerra, status, observacao from est_requisicao_cracha where id = '
				.substr($cod,2))->row();
				$r->dt = data_br($r->dt);
				$r->tipo = "Crachс";
				return $r;
				case 'CA':
				$r = 
				$this->db->query('select dt, titulo, nome_guerra, status, observacao from est_requisicao_cartao where id = '.substr($cod,2))->row();
				$r->dt = data_br($r->dt);
				$r->tipo = "Cartуo de Estacionamento";
				return $r;
				default:
				$r = new StdClass();
				$r->dt = "-";
				$r->titulo = "-";
				$r->nome_guerra = "-";
				$r->tipo = "-";
				return $r;
			}
		}
	}

	public function add_req_cracha($data){
		$data['dt'] = date('Y-m-d');
		$data['hms'] = date("H:i:s");
		$data['status'] = "Requisiчуo feita";
		//$data['ip'] = getip();
		$this->db->insert('est_requisicao_cracha', $data);
		return $this->db->insert_id();
	}

	public function editar_req($cod, $data){
		$cod = strtoupper($cod);
		switch (substr($cod,0,2)){
			case 'CR':
				$this->db->set($data);
				$this->db->where('id', substr($cod,2));
				$this->db->update('est_requisicao_cracha', $data);
				return $cod;
			case 'CA':
				$this->db->set($data);
				$this->db->where('id', substr($cod,2));
				$this->db->update('est_requisicao_cartao', $data);
				return $cod;
			return $r;
		}
	}

	public function add_req_cartao($data){
		$data['dt'] = date('Y-m-d');
		$data['hms'] = date("H:i:s");
		$data['status'] = "Requisiчуo feita";
		//$data['ip'] = getip();
		$this->db->insert('est_requisicao_cartao', $data);
		return $this->db->insert_id();
	}

	public function update_status($cod, $status){
		$cod = strtoupper($cod);
		switch (substr($cod,0,2)){
			case 'CR':
				$data = array('status' => $status);
				$this->db->set($data);
				$this->db->where('id', substr($cod,2));
				$this->db->update('est_requisicao_cracha', $data);
				return $cod;
			case 'CA':
				$data = array('status' => $status);
				$this->db->set($data);
				$this->db->where('id', substr($cod,2));
				$this->db->update('est_requisicao_cartao', $data);
				return $cod;
			return $r;
		}
	}

	public function add_user_to_system($cod){
		$new_user = $this->get_requisicao($cod, "full");
		$new_user->cod_requisicao = $cod;
		$columns = $this->db->list_fields("est_users");
		$new_user = (array) $new_user;
		$data = array();
		foreach (array_keys($new_user) as $k) {
			if(in_array($k, $columns)){
				$data[$k] = $new_user[$k];
			}
		}
		$data["id"] = "";//Nуo deixa inserir a id;
		return $this->Users_m->add_user($data);
	}

	public function update_user($cod){
		$new_data = $this->get_requisicao($cod, "full");
		$new_data->cod_requisicao = $cod;
		$columns = $this->db->list_fields("est_users");
		$new_data = (array) $new_data;
		$data = array();
		foreach (array_keys($new_data) as $k) {
			if(in_array($k, $columns)){
				$data[$k] = $new_data[$k];
			}
		}
		$data["id"] = $this->Users_m->get_user($new_data['cpf'],null, "cpf")->id;
		return $this->Users_m->edit_user($data);
	}

	public function add_veiculo_to_system($cod){
		$new_v = $this->get_requisicao($cod, "full");
		$new_v->cod_requisicao = $cod;
		$columns = $this->db->list_fields("est_veiculos");
		$new_v = (array) $new_v;
		$data = array();
		foreach (array_keys($new_v) as $k) {
			if(in_array($k, $columns)){
				$data[$k] = $new_v[$k];
			}
		}
		$data["id"] = "";//Nуo deixa inserir a id;
		$data["tipo"] = "P";
		$data["id_resp"] = $this->Users_m->get_user($new_v['cpf'],null, "cpf")->id;
		return $this->Veiculos_m->add_v($data);
	}

	public function get_total(){
		return ($this->db->count_all("est_requisicao_cracha") + $this->db->count_all("est_requisicao_cartao"));
	}

	public function get_current_page_records($limit = 0, $start = 0){
		$this->db->limit($limit, $start);
		if($limit != 0){
		}
		$out = array();
		$cr = $this->db->get("est_requisicao_cracha");
		$ca = $this->db->get("est_requisicao_cartao");
		if ($cr->num_rows() > 0 || $ca->num_rows() > 0) 
		{
			foreach ($cr->result() as $d) 
			{
				$d->tipo = "Crachс";
				$out[] = $d;
			}
			
			foreach ($ca->result() as $d) 
			{
				$d->tipo = "Cartуo";
				$out[] = $d;
			}

			return $out;
		}
		return false;
	}
}
?>