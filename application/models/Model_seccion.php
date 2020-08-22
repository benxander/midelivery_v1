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
		$this->db->where('sec.estado_sec', 1);

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

	public function m_registrar($data)
	{
		$this->db->insert('seccion', $data);
		return $this->db->insert_id();
	}
	public function m_editar($data,$id){
		$this->db->where('idseccion',$id);
		return $this->db->update('seccion', $data);
	}

	public function m_anular($datos)
	{
		$data = array(
			'estado_sec' => 0,
		);
		$this->db->where('idseccion',$datos['idseccion']);
		return $this->db->update('seccion', $data);
	}
}