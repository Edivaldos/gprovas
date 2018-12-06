<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#=====================================================================================================================
# Localização deste arquivo : application/models
# @copyright (c). Base Administrativa do Quartel-General do Exército - FORTE CAXIAS
# @author Sd Figueira - STI B Adm QGEx
#
# =====================================================================================================================

class Common_m extends CI_Model {

public function __construct(){
    parent::__construct();
    $this->dgp = $this->load->database('dgp',TRUE);
    $this->load->helper('funcoes');
    $this->load->helper('est');
}

    public function lista_om() {
            $this->dgp->order_by('tb_om.sigla', 'asc');
            return $this->dgp->get('tb_om')->result();
    }


    public function get_militar($id_militar){
        $out = api("getMilitar&idt=$id_militar");
        $out["sexo"] = $out["sexo"] = "1" ? "Masculino" : "Feminino";
        return $out;
    }

    public function get_om($codom) {
        return $this->dgp->where('codom',$codom)->get('tb_om')->row();
    }

    public function get_ufs(){
        return array( "AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA",
         "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RO", "RS", "RR", "SC", "SE", "SP", "TO", "Outro");
    }

    public function get_titulos(){
		$r = array();
		$r[] = "Sr";
		$r[] = "Sra";
		$pts = $this->dgp->get('global_postograd')->result();
		foreach ($pts as $pt) {
			$r[] = $pt->sigla_pg;
		}
		$r[] = "SC";
		$r[] = "FC";
		return $r;
	}

    
}?>