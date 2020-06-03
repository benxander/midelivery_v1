<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paginas_dinamicas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('Pagina_dinamica_model'));
    }

    /* Hasta que se diga lo contrario, las páginas dinámicas serán todas Shadowboxes */
    public function desarrollar($segmento_amigable) {
        $data = $this->Pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable($segmento_amigable);
        if($data === 0)
			$datos['contenido'] = '<h1>ESTA PAGINA ESTA EN CONSTRUCCION</h1>Disculpe la molestia<br>Cualquier consulta haganos saber a nuestro correo de contacto, '.EMAIL.'<br>Gracias';
		else $datos = $data;
        $this->load->view('pagina_dinamica',$datos);

    }
    /* Hasta que se diga lo contrario, las páginas dinámicas serán todas Shadowboxes, esta sustituira las ### */
    public function desarrollar_con_sustitucion($segmento_amigable, $sustitucion) {
        $datos = str_replace("###", $sustitucion, $this->Pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable($segmento_amigable));

        $this->load->view('pagina_dinamica',$datos);

    }

    /* Hasta que se diga lo contrario, las páginas dinámicas serán todas Shadowboxes */
    public function desarrollar_servicio($nombre_vista,$id) {

        $datos['id'] = $id;

        $this->load->view('servicios/'.$nombre_vista, $datos);

    }

}

/* ============================*/