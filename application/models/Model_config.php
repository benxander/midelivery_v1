<?php
class Model_config extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function m_cargar_empresa_admin()
	{
		$this->db->select("
			idconfiguracion,
			empresa,
			pagina_web,
			logo_imagen
		", FALSE);
		$this->db->from('w_configuracion wc');
		$this->db->limit('1');
		return $this->db->get()->row_array();
	}

	public function m_cargar_configuracion_por_usuario($datos)
	{
		$this->db->select("
			us.idusuario,
			us.estado_us,
			us.username,
			us.idgrupo,
			us.nombre_foto,
			cf.idconfiguracion,
			cf.empresa,
			cf.pagina_web,
			cf.logo_imagen
		", FALSE);
		$this->db->from('usuario us');
		$this->db->join('w_configuracion cf', 'us.idconfiguracion = cf.idconfiguracion');
		$this->db->where('us.idusuario', $datos['idusuario']);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
}