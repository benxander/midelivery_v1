<?php
class Banners_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	//====================================================
	// OBTENER BANNERS POR ZONA
	//===================================================
    public function get_banners_zona($zona) {
		$this->db->select("
			id,
			banner,
			CONCAT('uploads/banners/', banner) AS imagen,
			titulo,
			link,
			destino_url,
			zona,
			activo
		",FALSE);
    	$this->db->from('banner');
    	$this->db->where('activo', 1);
    	$this->db->where('zona', $zona);
    	$this->db->order_by('rand()');
    	return $this->db->get()->result_array();
    }
	//======================================================
	// OBTENER DATOS DE UN BANNER
	//======================================================
	public function get_banner($id) {
		$this->db->select('id, banner, titulo, link, destino_url, zona, activo');
		$this->db->from('banner');
		$this->db->where('id', $id);
		return $this->db->get()->row_array();
    }
    public function m_listar_videos(){
    	$this->db->select('*');
		$this->db->from('video_youtube');
		$this->db->order_by('idvideoyoutube');
		return $this->db->get()->result_array();
	}

	public function get_promociones() {
		$this->db->select("
			idpromocion,
			CONCAT('uploads/promocion/', imagen) AS imagen,
			titulo,
			precio,
			precio_anterior,
			fecha_inicio,
			fecha_fin,
			estado_pr
		",FALSE);
    	$this->db->from('promocion');
    	$this->db->where('estado_pr', 1);
    	$this->db->order_by('idpromocion','DESC');
    	return $this->db->get()->result_array();
	}

	public function get_promocion($id) {
		$this->db->select("
			idpromocion,
			CONCAT('uploads/promocion/', imagen) AS imagen,
			titulo,
			contenido,
			precio,
			precio_anterior,
			fecha_inicio,
			fecha_fin,
			estado_pr
		",FALSE);
		$this->db->from('promocion');
		$this->db->where('idpromocion', $id);
    	$this->db->limit('1');
    	return $this->db->get()->row_array();
    }
}
/* ================================== */