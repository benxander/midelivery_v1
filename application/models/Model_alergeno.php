<?php
class Model_alergeno extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_alergenos($paramPaginate=FALSE){
		$this->db->select("
			idalergeno,
			nombre,
			descripcion,
			icono
		", FALSE);

		$this->db->from('alergeno');

		if($paramPaginate){
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
		}else{
			$this->db->order_by('nombre', 'ASC');
		}
		return $this->db->get()->result_array();
	}
	public function m_count_alergenos($paramPaginate=FALSE){
		$this->db->select('count(*) AS contador');
		$this->db->from('alergeno');
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