<?php
class Model_Empresa extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function m_cargar_empresas($paramPaginate=FALSE){
		$this->db->select("
			emp.idempresa,
			emp.razon_social,
			emp.nombre_negocio,
			emp.idusuario,
			emp.telefono,
			emp.contacto,
			emp.email,
			emp.createdat,
			emp.updatedat,
			emp.idtipopago,
			emp.idplan,
			emp.estado_emp,
			emp.codigo_postal,
			emp.dni_cif,
			emp.direccion,
			emp.idusuario,
			pl.descripcion_pl,
			tp.descripcion_tp
		", FALSE);

		$this->db->from('empresa emp');
		$this->db->join('plan pl', 'emp.idplan = pl.idplan','left');
		$this->db->join('tipo_pago tp', 'emp.idtipopago = tp.idtipopago','left');
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
	public function m_registrar($data)
	{
		return $this->db->insert('empresa', $data);
	}
	public function m_editar($data,$id){
		$this->db->where('idempresa',$id);
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