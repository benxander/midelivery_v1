<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Avisos_legales extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'file', 'email', 'date'));
        $this->load->model(array('banners_model','pagina_dinamica_model', 'categorias_model', 'provincias_model','anuncios_model'));
      
    }

	public function index()
	{
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona(1, 'rand()', 0);
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona(2, 'rand()', 0);
		$datos['operaciones'] = $this->categorias_model->get_operacion();
        $datos['categorias'] = $this->categorias_model->get_categorias();
		$datos['areas'] = $this->categorias_model->get_areas();
		$datos['monedas'] = $this->categorias_model->get_monedas();
        $datos['departamentos'] = $this->provincias_model->get_departamentos();
		// DATOS DEL TOP Y DESTACADOS
		// $datos['total_top'] = $this->anuncios_model->get_count_anuncios_top_todos();
        $datos['anuncios_top'] = $this->anuncios_model->get_anuncios_top_todos();
		
		$data['q'] = $this->pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable('terminos-de-uso');
		$datos['pagina']=$data['q']['contenido'];
		
		$this->load->view('header',$datos);
		$this->load->view('paginas_view');
		$this->load->view('footer');
	}
}
//===============================================