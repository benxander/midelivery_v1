<?php

class Pagina_dinamica_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_pagina_dinamica_by_segmento_amigable($segmento_amigable) {
        $this->db->select("
            id,
            nombre,
            segmento_amigable,
            titulo,
            contenido,
            imagen,
            posicion_imagen,
            url_imagen,
            destino_url_imagen
        ", FALSE);
        $this->db->from('pagina_dinamica pd');
        $this->db->where('segmento_amigable', $segmento_amigable);
        $this->db->limit('1');
        return $this->db->get()->row_array();
    }



}

/* =============================================================================== */