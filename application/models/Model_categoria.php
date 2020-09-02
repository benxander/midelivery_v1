<?php
class Model_categoria extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_categorias($paramPaginate=FALSE){
		$this->db->select("
			cat.idcategoria,
			cat.descripcion_cat,
			cat.imagen_cat
		", FALSE);

		$this->db->from('categoria cat');
		$this->db->where('cat.estado_cat', 1);
		$this->db->where('cat.idempresa', $this->sessionVP['idempresa']);

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
	public function m_count_categorias($paramPaginate=FALSE){
		$this->db->select('count(*) AS contador');
		$this->db->from('categoria cat');
		$this->db->where('cat.estado_cat', 1);
		$this->db->where('cat.idempresa', $this->sessionVP['idempresa']);
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
		$this->db->insert('categoria', $data);
		return $this->db->insert_id();
	}
	public function m_editar($data,$id){
		$this->db->where('idcategoria',$id);
		return $this->db->update('categoria', $data);
	}

	public function m_anular($datos)
	{
		$data = array(
			'estado_cat' => 0,
		);
		$this->db->where('idcategoria',$datos['idcategoria']);
		return $this->db->update('categoria', $data);
	}
}