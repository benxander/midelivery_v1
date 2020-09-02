<?php
class Model_producto extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_productos($paramPaginate=FALSE){
		$this->db->select("
			pr.idproducto,
			pr.descripcion_pr,
			pr.precio,
			cat.idcategoria,
			cat.descripcion_cat
		", FALSE);

		$this->db->from('producto pr');
		$this->db->join('categoria cat', 'pr.idcategoria = cat.idcategoria');
		$this->db->where('pr.estado_pr', 1);
		$this->db->where('cat.estado_cat', 1);
		$this->db->where('cat.idempresa', $this->sessionVP['idempresa']);

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
			$this->db->order_by('idproducto', 'ASC');
		}
		return $this->db->get()->result_array();
	}
	public function m_count_productos($paramPaginate=FALSE){
		$this->db->select('count(*) AS contador');
		$this->db->from('producto pr');
		$this->db->join('categoria cat', 'pr.idcategoria = cat.idcategoria');
		$this->db->where('pr.estado_pr', 1);
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
		$this->db->insert('producto', $data);
		return $this->db->insert_id();
	}
	public function m_editar($data,$id){
		$this->db->where('idproducto',$id);
		return $this->db->update('producto', $data);
	}

	public function m_anular($datos)
	{
		$data = array(
			'estado_pr' => 0,
		);
		$this->db->where('idproducto',$datos['idproducto']);
		return $this->db->update('producto', $data);
	}
}