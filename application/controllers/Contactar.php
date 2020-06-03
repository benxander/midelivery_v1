<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactar extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->helper(
			array(
				'url',
				'file',
				'email',
				'date',
				'form',
				'metadata_helper',
				'config_helper'
			)
		);
        $this->load->model(
			array(
				'banners_model',
				'pagina_dinamica_model'
			)
		);
    }

    public function index() {
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');

		$datos['scripts'] = '';

		// DATOS DEL BODY
		$datos['pagina_dinamica'] = $this->pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable('contactar');
		$this->load->view('header',$datos);
		$this->load->view('formulario_contactar');
		$this->load->view('footer');

    }

    public function enviar() {
        // Para que el F5 no vuelva a enviar
		$asunto="Contacto desde la Web: ".NOMBRE_PORTAL;
        extract($this->input->post());
		// echo "Asunto: ".$asunto." .Nombre: ".$nombre;
        if (envio_email(EMAIL, "",$asunto, "Se ha recibido un mensaje de contacto: <br><br>Nombre:<b> " . $nombre . "</b><br>Teléfono:<b> " . $telefono . "</b><br>Email:<b> " . $email . "</b><br>Mensaje:<br><br>" . nl2br($mensaje),EMAIL)) {
            // echo $this->email->print_debugger();
			redirect('contactar/ok');
        } else {
            envio_email("rguevarac@hotmail.es", "","Error al enviar el formulario de contacto", "Se ha recibido un mensaje de contacto: <br><br>Nombre:<b> " . $nombre . "</b><br>Teléfono:<b> " . $telefono . "</b><br>Email:<b> " . $email . "</b><br>Mensaje:<br><br>" . nl2br($mensaje),$email);
			// echo $this->email->print_debugger();
            redirect('contactar/nok');
        }
    }

    public function ok() {
   		 // DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');

		$datos['scripts'] = '';

		// DATOS DEL BODY

        $this->load->view('header',$datos);
        $this->load->view('contactar_ok');
        $this->load->view('footer');
    }

    public function nok() {
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');

		$datos['scripts'] = '';

		// DATOS DEL BODY

        $this->load->view('header',$datos);
        $this->load->view('contactar_nok');
        $this->load->view('footer');

    }

	public function envio(){
		$this->load->library('email');

		$this->email->from('jm@hementxe.com');
        $this->email->to('comunica@hementxe.com');
        $this->email->subject('asunto');
        $this->email->message('mensaje con prioridad 1');

        if($this->email->send()){
			echo "enviado ";
			echo $this->email->print_debugger();
		}
		else echo "No enviado ";
		echo $this->email->print_debugger();
	}

}
/*=================================================================================*/