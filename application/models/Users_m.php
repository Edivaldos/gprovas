<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#=====================================================================================================================
# Localizaзгo deste arquivo : application/models
# @copyright (c). Base Administrativa do Quartel-General do Exйrcito - FORTE CAXIAS
# @author Sd Figueira - STI B Adm QGEx
#
# =====================================================================================================================

class Users_m extends CI_Model {

	public function __construct(){
        parent::__construct();
				$this->dgp = $this->load->database('dgp',TRUE);
				$this->load->helper('est');
    }

	public function get_user($id_user = null, $full_info = null, $key = "id"){
		if($full_info){
			$user = $this->db->query("select * from est_users where $key = '".$id_user."'")->row();
			if($user){
				$user->veiculos = $this->db->query("select * from est_veiculos where id_resp = ".$user->id)->result();
				$user->crachas = $this->db->query("select * from est_crachas where id_user = $user->id")->result();
				foreach ($user->crachas as $cracha) {
					$cracha->vault_ent = api_vault("CardNo", $cracha->nr_cracha);
					
				}
			}
			return $user;
		}
		return $this->db->where($key, $id_user)->get('est_users')->row();
	}

	public function get_militar($id_militar){
		$out = $this->dgp->where('pes_identificador_cod', $id_militar)->get('tb_militar')->row();
		$out->om = $this->db->where('codom',$out->om_codom)->get('tb_om')->row()->om_sigla;
		$out->pt = $this->db->where('id_posto',$out->posto_grad_codigo)->get('tb_postos')->row()->posto;
		return $out;
	}

	public function add_user($data){
		$dt = new DateTime('NOW');
		$data["dt_criacao"] = $dt->format("y-m-d");
		$this->db->insert('est_users', $data);
		return $this->db->insert_id();
	}

	public function edit_user($data){
		$data = fix_data_array($data);//Tira todos os campos vazios para que nгo se perca dos dados antigos sу porque nгo foram informados novamente.
		$this->db->set($data);
		$this->db->where('id', $data['id']);
		$this->db->update('est_users', $data);
		return $data['id'];
	}

	public function delete_user($id){
		$this->db->delete('est_veiculos', array('id_resp' => $id));
		$this->db->delete('est_users', array('id' => $id));
	}
	
	public function get_total(){
		return $this->db->count_all("est_users");
	}

	public function get_current_page_records($limit = 0, $start = 0) 
    {
			$this->db->limit($limit, $start);
			if($limit != 0){
			}
			$query = $this->db->get("est_users");
			
			if ($query->num_rows() > 0) 
			{
				$out = array();
				foreach ($query->result() as $d) 
				{
					$out[] = $d;
				}
					return $out;
			}
			return false;
  }

}?>