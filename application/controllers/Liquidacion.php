<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Liquidacion extends CI_Controller {

	public function __construct(){
			parent::__construct();
			$this->load->model(array('banners_model','calendario_model'));
			$this->load->helper('date');
	}

	public function index(){
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');

		// DATOS DEL BODY
		//$datos['pagina'] = $this->pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable('calendario');
		$datos['arrCalendario'] = $this->calendario_model->m_obtener_calendario();

		// var_dump($datos['arrCalendario']); exit();
		// $data['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera', 'blog');
		// $data['titulo']='INMOPER - Blog';
		$datos['scripts'] = '';
		$this->load->view('header',$datos);
		$this->load->view('calendario_view');
		$this->load->view('footer');
	}
	public function articulo($url){
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');

		$datos['scripts'] = '';

		$partes = explode("-", $url);
        $id = $partes[count($partes) - 1]; /*Se obtiene el id de la ultima parte de la url*/

		$datos['id_articulo'] = $id;
		$datos['articulo'] = $this->calendario_model->m_obtener_evento($id);

		$this->load->view('header',$datos);
		$this->load->view('articulo_view');
		$this->load->view('footer');
	}
}