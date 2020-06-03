<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calendario_model extends CI_Model {

	// ===================================================================================
	// OBTENER TODOS LOS ARTICULOS
	// ===================================================================================
	public function m_obtener_calendario(){
		$this->db->select('idcalendario, titulo, contenido, imagen, fecha_creacion, estado_cal');
		$this->db->from('calendario');
		$this->db->where('estado_cal', '1');
		$this->db->order_by('fecha_creacion DESC');
		return $this->db->get()->result_array();
	}
	public function m_obtener_evento($id){
		$this->db->select('idcalendario, titulo, contenido, imagen, fecha_creacion, estado_cal');
		$this->db->from('calendario');
		$this->db->where('idcalendario', $id);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
}