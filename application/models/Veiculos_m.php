<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#=====================================================================================================================
# LocalizaÃ§Ã£o deste arquivo : application/models
# @copyright (c). Base Administrativa do Quartel-General do ExÃ©rcito - FORTE CAXIAS
# @author Sd Figueira - STI B Adm QGEx
#
# =====================================================================================================================

class Veiculos_m extends CI_Model {

	public function __construct(){
				parent::__construct();
				$this->load->helper('est');
        $this->dgp = $this->load->database('dgp',TRUE);
        $this->load->model('Log_m');
    }

	public function add_v($data){
		$dt = new DateTime('NOW');
		$data["ult_ren"] = $dt->format("y-m-d");
		$this->db->insert('est_veiculos', $data);
		return $this->db->insert_id();
	}
	public function edit_v($info){
		switch ($info['modo']) {
			case 'add':
				$dt = new DateTime('NOW');
				$data = array(
					'codom' => $info['codom'],
					'id_resp' => $info['id_resp'],
					'espec' => $info['espec'],
					'placa' => $info['placa'],
					'placa_vinculada' => $info['placa_vinculada'],
					'marca' => $info['marca'],
					'modelo' => $info['modelo'],
					'cor' => $info['cor'],
					'ano_fab' => $info['ano_fab'],
					'ano_mod' => $info['ano_mod'],
					'uf' => $info['uf'],
					'renavam' => $info['renavam'],
					'tipo' => $info['tipo'],
					'ult_ren' => $dt->format("y-m-d")
				);
				$this->db->insert('est_veiculos', $data);
				return $this->db->insert_id();
				case 'edit':
				$data = array(
					'codom' => $info['codom'],
					'id_resp' => $info['id_resp'],
					'espec' => $info['espec'],
					'placa' => $info['placa'],
					'placa_vinculada' => $info['placa_vinculada'],
					'marca' => $info['marca'],
					'modelo' => $info['modelo'],
					'cor' => $info['cor'],
					'ano_fab' => $info['ano_fab'],
					'ano_mod' => $info['ano_mod'],
					'uf' => $info['uf'],
					'renavam' => $info['renavam'],
					'ult_ren' => $info['ult_ren'],
				);
				$this->db->set($data);
				$this->db->where('id', $info['id']);
				$this->db->update('est_veiculos', $data);
				return $info['id'];
			case 'del':
				$this->db->delete('est_veiculos', array('id_resp' => $info['id']));
				$this->db->delete('est_users', array('id' => $info['id']));
			break;
		}
	}

	public function get_v($id_v = null, $full_info = null){
		$r = $this->db->where('id', $id_v)->get('est_veiculos')->row();
		if($r->tipo == "V"){
			$r->om = $this->Common_m->get_om($r->codom);
		}else{
			$r->resp = $this->Users_m->get_user($r->id_resp);
		}
		if($full_info){
			$r->cartoes = $this->get_cartao('id_veiculo',$r->id);
		}
		return $r;
	}

	public function get_total(){
		return $this->db->count_all("est_veiculos");
	}

	public function get_current_page_records($limit = 0, $start = 0) {
		$this->db->limit($limit, $start);
		if($limit != 0){
		}
		$query = $this->db->get("est_veiculos");
		
		if ($query->num_rows() > 0) 
		{
			$out = array();
			foreach ($query->result() as $d) 
			{
						$resp = "";
						if($d->tipo == "V")
								$resp = $this->Common_m->get_om($d->codom)->om_nome;
						else
								$resp = $this->Users_m->get_user($d->id_resp)->nome_completo;
						$v = new StdClass();
						$v->id = $d->id;
						$v->tipo = $d->tipo == "V" ? "Viatura" : "Particular";
						$v->placa = $d->placa;
						$v->marca_modelo = $d->marca." - ".$d->modelo;
						$v->resp = $resp;
						$v->ult_ren = data_br($d->ult_ren);
						$out[] = $v;
				}
				return $out;
		}
		return false;
  }
	
	public function mudar_cartao($id_cartao){
		$cartao = $this->db->where('id',$id_cartao)->get('est_cartoes')->row();
		$data = array(
			'status' => $cartao->status == "ATIVO" ? "CANCELADO" : "ATIVO"
		);
		$this->db->set($data);
		$this->db->where('id', $id_cartao);
		$this->db->update('est_cartoes', $data);
		$v = $this->db->where('id',$cartao->id_veiculo)->get('est_veiculos')->row();
		$placa = $v->placa_vinculada != null || $v->placa_vinculada != "" ? $v->placa_vinculada : $v->placa;
		$this->Log_m->gravar_log('Modificou o cartão da placa: '.$placa.' para: '.$data['status']);
		return $cartao->id_veiculo;
	}
	
	public function add_cartao($id_veiculo, $id_est, $ano, $vaga){
		$v = $this->db->where('id',$id_veiculo)->get('est_veiculos')->row();
		$placa = $v->placa_vinculada != null || $v->placa_vinculada != "" ? $v->placa_vinculada : $v->placa;
		$dt = new DateTime('NOW');
		$data = array(
			'id_veiculo' => $id_veiculo,
			'id_est' => $id_est,
			'ano' => $ano,
			'vaga' => $vaga,
			'status' => "ATIVO",
			'dt_criacao' => $dt->format("y-m-d")
		);
		$this->db->insert('est_cartoes', $data);
		$placa = $v->placa_vinculada != null || $v->placa_vinculada != "" ? $v->placa_vinculada : $v->placa;
		$this->Log_m->gravar_log('Gerou um cartão para a placa: '.$placa);
		return $v->id;//volta a id do veículo para voltar para a página de detalhes
	}

	public function get_cartao($key, $cod, $full = null){
		if($full){
			$c = $this->db->where('id',$cod)->get('est_cartoes')->row();
			$v = $this->db->where('id',$c->id_veiculo)->get('est_veiculos')->row();
			$dados = new StdClass();
			if($v->tipo == "V"){
				$om = $this->Common_m->get_om($v->codom);
				$dados->ramal = "";
				$dados->local_trabalho = $om->om_sigla;
				$dados->resp = "Viatura";
			}else{
				$u = $this->db->where('id',$v->id_resp)->get('est_users')->row();
				$dados->ramal = $u->ramal;
				$dados->local_trabalho = $u->local_trabalho;
				$dados->resp = $u->titulo." ".$u->nome_guerra;
			}
			$dados->placa = $v->placa_vinculada != null || $v->placa_vinculada != "" ? $v->placa_vinculada : $v->placa;
			$dados->placa = str_replace("-","",$dados->placa);
			$dados->vaga = $c->vaga == 0 ? "" : $c->vaga;
			return $dados;
		}else{
			$cartoes_raw = $this->db->where($key,$cod)->get('est_cartoes')->result();
			foreach ($cartoes_raw as $c)
			$c->nome_est = $this->db->where('id',$c->id_est)->get('est_estacionamentos')->row()->nome;
			return $cartoes_raw;
		}
		
	}
}
?>