<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_c extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('funcoes');
    }

    public function index() {
       $this->load->view('shared/main', [
		 	'content' => $this->load->view('index', TRUE, TRUE)
	 	]);
    }

    public function sobre(){
    	$this->load->view('shared/main', [
		 	'content' => $this->load->view('sobre', TRUE, TRUE)
	 	]);
    }

}
