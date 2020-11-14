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
			pl.descripcion_pl,
			tp.descripcion_tp,
			us.idusuario,
			us.username
		", FALSE);

		$this->db->from('empresa emp');
		$this->db->join('plan pl', 'emp.idplan = pl.idplan','left');
		$this->db->join('tipo_pago tp', 'emp.idtipopago = tp.idtipopago','left');
		$this->db->join('usuario us', 'emp.idusuario = us.idusuario','left');
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

	public function m_cargar_empresa_por_negocio($negocio)
	{
		$this->db->select("
			emp.idempresa,
			emp.razon_social,
			emp.nombre_negocio,
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
			emp.modelo_carta,
			emp.idcolor,
			co.clase
		", FALSE);

		$this->db->from('empresa emp');
		$this->db->join('color co', 'emp.idcolor = co.idcolor');
		$this->db->where('nombre_negocio', $negocio);
		$this->db->limit('1');
		return $this->db->get()->row_array();
	}

	public function m_cargar_carta_digital($datos)
	{
		$this->db->select("
			cat.idcategoria,
			cat.descripcion_cat AS categoria,
			cat.imagen_cat,
			pr.idproducto,
			pr.descripcion_pr AS producto,
			pr.precio,
			pr.alergenos
		", FALSE);
		$this->db->from('categoria cat');
		$this->db->join('producto pr', 'cat.idcategoria = pr.idcategoria');
		$this->db->where('cat.idempresa', $datos['idempresa']);
		$this->db->where('cat.estado_cat', 1);
		$this->db->where('pr.estado_pr', 1);
		$this->db->order_by('cat.idcategoria', 'ASC');
		return $this->db->get()->result_array();
	}

	public function m_cargar_colores()
	{
		$this->db->select("
			idcolor,
			nombre,
			hexa,
			clase
		", FALSE);
		$this->db->from('color co');
		$this->db->order_by('co.idcolor', 'ASC');
		return $this->db->get()->result_array();
	}

	public function m_cargar_cartas_demo()
	{
		$this->db->select("
			emp.idempresa,
			emp.razon_social,
			emp.nombre_negocio,
			modelo_carta AS idmodelo,
			emp.idcolor,
			concat('MODELO ', emp.modelo_carta) AS modelo_carta,
			co.nombre AS color,
			co.hexa
		", FALSE);
		$this->db->from('empresa emp');
		$this->db->join('color co', 'emp.idcolor = co.idcolor');
		$this->db->where('emp.estado_emp', 2);
		return $this->db->get()->result_array();
	}

	public function m_cargar_categorias_demo($datos)
	{
		$this->db->select("
			cat.idcategoria,
			cat.descripcion_cat AS categoria,
			cat.imagen_cat
		", FALSE);
		$this->db->from('categoria cat');
		$this->db->where('cat.idempresa', $datos['idempresa']);
		$this->db->where('cat.estado_cat', 1);
		$this->db->order_by('cat.idcategoria', 'ASC');
		return $this->db->get()->result_array();
	}

	public function m_cargar_empresa_demo($datos)
	{
		$this->db->select("
			emp.idempresa,
			emp.razon_social,
			emp.nombre_negocio,
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
			emp.modelo_carta,
			emp.idcolor,
			co.clase
		", FALSE);

		$this->db->from('empresa emp');
		$this->db->join('color co', 'emp.idcolor = co.idcolor');
		$this->db->where('emp.idempresa', $datos['idempresa']);
		$this->db->limit('1');
		return $this->db->get()->row_array();
	}
}
?>