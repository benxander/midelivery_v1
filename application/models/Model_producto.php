<?php
class Model_producto extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_productos($paramPaginate=FALSE,$paramDatos){
		$this->db->select("
			pr.idproducto,
			pr.descripcion_pr,
			pr.alergenos,
			pr.precio,
			cat.idcategoria,
			cat.descripcion_cat
		", FALSE);

		$this->db->from('producto pr');
		$this->db->join('categoria cat', 'pr.idcategoria = cat.idcategoria');
		$this->db->where('pr.estado_pr', 1);
		$this->db->where('cat.estado_cat', 1);
		$this->db->where('cat.idempresa', $this->sessionVP['idempresa']);
		if($paramDatos['categoria']['id'] != 0){
			$this->db->where('cat.idcategoria', $paramDatos['categoria']['id']);
		}
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
	public function m_count_productos($paramPaginate=FALSE,$paramDatos){
		$this->db->select('count(*) AS contador');
		$this->db->from('producto pr');
		$this->db->join('categoria cat', 'pr.idcategoria = cat.idcategoria');
		$this->db->where('pr.estado_pr', 1);
		$this->db->where('cat.estado_cat', 1);
		$this->db->where('cat.idempresa', $this->sessionVP['idempresa']);
		if($paramDatos['categoria']['id'] != 0){
			$this->db->where('cat.idcategoria', $paramDatos['categoria']['id']);
		}
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

	public function m_cargar_productos_demo($datos){
		$this->db->select("
			pr.idproducto,
			pr.descripcion_pr,
			pr.alergenos,
			pr.precio,
			cat.idcategoria,
			cat.descripcion_cat
		", FALSE);

		$this->db->from('producto pr');
		$this->db->join('categoria cat', 'pr.idcategoria = cat.idcategoria');
		$this->db->where('pr.estado_pr', 1);
		$this->db->where('cat.estado_cat', 1);
		$this->db->where('cat.idempresa', $datos['idempresa']);
		// if($datos['categoria']['id'] != 0){
		// 	$this->db->where('cat.idcategoria', $datos['categoria']['id']);
		// }

		$this->db->order_by('idproducto', 'ASC');
		return $this->db->get()->result_array();
	}
}