<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#=====================================================================================================================
# Localização deste arquivo : application/models
# @copyright (c). Base Administrativa do Quartel-General do Exército - FORTE CAXIAS
# @author Sd Figueira - STI B Adm QGEx
#
# Esta classe possui funções relacionadas ao modulo de estacionamento no sistema...
# =====================================================================================================================

class Ests_m extends CI_Model {

	public function lista_ests() {
	        $this->db->order_by('est_estacionamentos.nome', 'asc');
	        return $this->db->get('est_estacionamentos')->result();
	}

	public function edit_est($info){
		switch ($info['modo']) {
			case 'add':
				$data = array(
				        'nome' => $info['nome'],
				        'permissao' => $info['permissao'],
				        'nr_vagas' => $info['cap']
						);
				$data['nr_vagas'] = $data['nr_vagas'] == 0 ? null : $data['nr_vagas'];
				$this->db->insert('est_estacionamentos', $data);
				break;
			case 'edit':
				$data = array(
				        'nome' => $info['nome'],
				        'permissao' => $info['permissao'],
				        'nr_vagas' => $info['cap']
						);
				$data['nr_vagas'] = $data['nr_vagas'] == 0 ? null : $data['nr_vagas'];
				$this->db->set($data);
				$this->db->where('id', $info['id']);
				$this->db->update('est_estacionamentos', $data);
				break;
			case 'del':
				$this->db->delete('est_estacionamentos', array('id' => $info['id']));
			break;
		}
	}

	public function get_estacionamento($key,$cod){
		return $this->db->where($key,$cod)->get("est_estacionamentos")->result();
	}


}?>