<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_m extends CI_Model {

	public function __construct(){
    parent::__construct();
    $this->load->library('user_agent');
	}

	function gravar_log($acao) {
    $CI =& get_instance();
    $dadoslog = [
        'dt' => date('Y-m-d'),
				'user' => 'Fulano',
        //'user' => $CI->session->sigla_pg . ' ' . $CI->session->nome_guerra,
        'acao' => $acao,
        'ip' => $CI->input->ip_address(),
        'plataforma' => $CI->agent->platform,
        'navegador' => $CI->agent->browser,
				'id_user' => 'Id do Fulano',
        'hms' => date('H:i:s'),
    ];
    $this->db->insert('est_log', $dadoslog);
	}

	public function get_total(){
		return $this->db->count_all("est_log");
	}

	public function get_current_page_records($limit = 0, $start = 0) 
    {
		$this->db->limit($limit, $start);
		if($limit != 0){
		}
		$query = $this->db->get("est_log");
		
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