<?php
class Model_seccion extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_secciones($paramPaginate=FALSE){
		$this->db->select("
			sec.idseccion,
			sec.descripcion_sec,
			sec.imagen_sec
		", FALSE);

		$this->db->from('seccion sec');

		if( isset($paramPaginate['search'] ) && $paramPaginate['search'] ){
			foreach ($paramPaginate['searchColumn'] as $key => $value) {
				if(! empty($value)){
					$this->db->like($key ,strtoupper_total($value) ,FALSE);
				}
			}
		}

		if( $paramPaginate['sortName'] ){
			$this->db->order_by($paramPaginate['sortName'], $paramPaginate['sort']);
		}
		if( $paramPaginate['firstRow'] || $paramPaginate['pageSize'] ){
			$this->db->limit($paramPaginate['pageSize'],$paramPaginate['firstRow'] );
		}
		return $this->db->get()->result_array();
	}
	public function m_count_secciones($paramPaginate=FALSE){
		$this->db->select('count(*) AS contador');
		$this->db->from('seccion sec');
		if( isset($paramPaginate['search'] ) && $paramPaginate['search'] ){
			foreach ($paramPaginate['searchColumn'] as $key => $value) {
				if(! empty($value)){
					$this->db->like($key ,strtoupper_total($value) ,FALSE);
				}
			}
		}
		$fData = $this->db->get()->row_array();
		return $fData['contador'];
	}
}