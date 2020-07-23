<?php
class Model_Empresa extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_empresas($paramPaginate=FALSE){
		$this->db->select("
			idempresa,
			razon_social,
			nombre_negocio,
			idusuario,
			telefono,
			contacto,
			email,
			createdat,
			updatedat,
			idtipopago,
			estado_emp,
			codigo_postal,
			dni_cif,
			direccion
		", FALSE);

		$this->db->from('empresa emp');
		$this->db->where('emp.estado_emp', 1);
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
	public function m_count_empresas($paramPaginate=FALSE){
		$this->db->select('count(*) AS contador');
		$this->db->from('empresa emp');
		$this->db->where('emp.estado_emp', 1);
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
	public function m_cargar_empresa_cbo(){
		$this->db->select('emp.idempresa, emp.nombre_comercial');
		$this->db->from('empresa emp');
		$this->db->where('emp.estado_emp', 1);
		$this->db->where('emp.idconfiguracion', $this->sessionVP['idconfiguracion']);
		return $this->db->get()->result_array();
	}
	public function m_registrar($datos)
	{
		$data = array(
			'nombre_negocio' => strtolower_total($datos['nombre_negocio']),
			'razon_social' => strtoupper_total($datos['razon_social']),
			'telefono' => empty($datos['telefono'])? NULL : $datos['telefono'],
			'contacto' => empty($datos['contacto'])? NULL : $datos['contacto'],
			'codigo_postal' => $datos['codigo_postal'],
			'dni_cif' => $datos['dni_cif'],
			'direccion' => $datos['direccion'],
			'createdAt' => date('Y-m-d H:i:s'),
			'updatedAt' => date('Y-m-d H:i:s')
		);
		return $this->db->insert('empresa', $data);
	}
	public function m_editar($datos){
		$data = array(
			'nombre_negocio' => strtolower_total($datos['nombre_negocio']),
			'razon_social' => strtoupper_total($datos['razon_social']),
			'telefono' => empty($datos['telefono'])? NULL : $datos['telefono'],
			'contacto' => empty($datos['contacto'])? NULL : $datos['contacto'],
			'codigo_postal' => $datos['codigo_postal'],
			'dni_cif' => $datos['dni_cif'],
			'direccion' => $datos['direccion'],
			'updatedAt' => date('Y-m-d H:i:s')
		);
		$this->db->where('idempresa',$datos['idempresa']);
		return $this->db->update('empresa', $data);
	}

	public function m_anular($datos)
	{
		$data = array(
			'estado_emp' => 0,
			'updatedAt' => date('Y-m-d H:i:s')
		);
		$this->db->where('idempresa',$datos['idempresa']);
		return $this->db->update('empresa', $data);
	}
}
?>