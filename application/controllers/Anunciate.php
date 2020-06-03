<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anunciate extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'email', 'date','form'));
        $this->load->model(array('provincias_model','categorias_model','banners_model','pagina_dinamica_model', 'anuncios_model'));

    }

	public function index()
	{
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');
		$datos['banners_profesionales'] = $this->anuncios_model->get_profesionales();
		$datos['provincias'] = $this->provincias_model->get_provincias();
		$datos['categorias'] = $this->categorias_model->get_categorias();
		$datos['bikes'] = $this->categorias_model->get_subcategorias(1);
		$datos['componentes'] = $this->categorias_model->get_subcategorias(2);
		$datos['accesorios'] = $this->categorias_model->get_subcategorias(3);
		
		// DATOS DEL TOP Y DESTACADOS
		$datos['total_top'] = $this->anuncios_model->get_count_anuncios_top_todos();
        $datos['anuncios_top'] = $this->anuncios_model->get_anuncios_top_todos();
		$datos['scripts'] = '';	
		
		// DATOS DEL BODY
        $datos['pagina_dinamica'] = $this->pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable('anunciate');

		
		$this->load->view('header',$datos);
		$this->load->view('anunciate_view');
		$this->load->view('footer');
	}
	
	public function enviar() {
        // Para que el F5 no vuelva a enviar
		$asunto="SOLICITUD DE PUBLICACION EN ".NOMBRE_PORTAL;
        extract($this->input->post());
		// echo "Asunto: ".$asunto." .Nombre: ".$nombre;
        if (envio_email(EMAIL, "",$asunto, "Mensaje de un contacto interesado en publicar en la web. <br><br>Nombre:<b> " . $nombre . "</b><br>Teléfono:<b> " . $telefono . "</b><br>Email:<b> " . $email . "</b><br>Mensaje:<br><br>" . nl2br($mensaje))) {        
            // echo $this->email->print_debugger();
			redirect('contactar/ok');
        } else {
            envio_email("rguevarac@hotmail.es", "","Error al enviar el formulario de contacto", "Se ha recibido un mensaje de contacto: <br><br>Nombre:<b> " . $nombre . "</b><br>Teléfono:<b> " . $telefono . "</b><br>Email:<b> " . $email . "</b><br>Mensaje:<br><br>" . nl2br($mensaje),$email);
			// echo $this->email->print_debugger();
            redirect('contactar/nok');
        }
    }
}
//===============================================