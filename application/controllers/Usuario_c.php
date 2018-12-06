<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_c extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('funcoes');
    }

    public function login() {
       $this->load->view('shared/main', [
		 	'content' => $this->load->view('usuario/login', TRUE, TRUE)
	 	]);
    }

    public function login_post(){
        mydump($_POST);
    }

    public function registrar(){
    	$this->load->view('shared/main', [
		 	'content' => $this->load->view('usuario/registrar', TRUE, TRUE)
	 	]);
    }

    public function registrar_post(){
        mydump($_POST);
    }

}
