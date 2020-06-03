<?php
class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!($this->session->userdata('logged')  && $this->session->userdata('administrador') ))
            redirect ('/admin');
        $this->load->helper(
			array(
				'metadata_helper',
				'config_helper'
			)
		);
    }

    function index() {
        $this->load->view('admin/header');
        $this->load->view('admin/menu');
        $this->load->view('admin/inicio');
        $this->load->view('admin/footer');
    }
	function configuracion() {
        $this->load->view('admin/header');
        $this->load->view('admin/menu2');
        $this->load->view('admin/configuracion_view');
        $this->load->view('admin/footer');
    }

}
// ===========================================================