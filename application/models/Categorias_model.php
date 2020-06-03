<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Categorias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

 	//======================================================================================================
	// OBTENER TODAS LAS CONFIGURACIONES
	//======================================================================================================
	public function get_configuraciones() {
		$data = array();
		$sql = "SELECT * FROM configuracion";
        $res = $this->db->query($sql);

		foreach($res->result_array() as $row){
			$data[] = $row;
        }
		return $data;
	}

	/**
	 * Carga todas las categorias pertenecientes a un módulo
	 * @param  int $idmodulo
	 * @return array
	 */
	public function m_cargar_categoria_por_modulo($idmodulo)
	{
		$this->db->select('ca.idcategoria, ca.categoria, ca.idmodulo, ca.estado_ca');
		$this->db->from('categoria ca');
		$this->db->where('estado_ca', 1);
		$this->db->where('ca.idmodulo', $idmodulo);
		$this->db->order_by('idmodulo', 'ASC');
		return $this->db->get()->result_array();
    }

    /**
	 * Carga datos de una categoria
	 * @param  int $idcategoria
	 * @return array
	 */
	public function m_cargar_categoria_por_id($idcategoria)
	{
		$this->db->select('ca.idcategoria, ca.categoria, ca.idmodulo, ca.segmento_amigable, ca.estado_ca');
		$this->db->from('categoria ca');
		$this->db->where('estado_ca', 1);
		$this->db->where('ca.idcategoria', $idcategoria);
		$this->db->limit(1);
		return $this->db->get()->row_array();
    }
    /**
	 * Carga datos de una categoria por el segmento amigable
	 * @param  int $idcategoria
	 * @return array
	 */
	public function cargar_categoria_por_seg_amigable($segmento_modulo, $segmento_categoria)
	{
		$this->db->select('
            m.idmodulo,
            m.descripcion_modulo AS modulo,
            ca.idcategoria,
            ca.categoria,
            ca.imagen_ca,
            ca.color_fondo,
            ca.descripcion_ca
        ');
		$this->db->from('categoria ca');
		$this->db->join('modulo m', 'ca.idmodulo = m.idmodulo');
		$this->db->where('m.segmento_amigable', $segmento_modulo);
		$this->db->where('ca.segmento_amigable', $segmento_categoria);
		$this->db->limit(1);
		return $this->db->get()->row_array();
    }

    //======================================================================================================
	// OBTENER NOMBRE DE UNA SUBCATEGORIA
	//======================================================================================================
    public function get_subcategoria_nombre($id_subcategoria) {
        if ($id_subcategoria == 0) {
            return "Todas las Subcategorias";
        } else {
            $sql = "SELECT subcategoria1 FROM subcategorias1 WHERE id = ?";
            $res = $this->db->query($sql, $id_subcategoria);

            if ($res->num_rows() > 0) {
                $rows = $res->result_array();
                return $rows[0]['subcategoria1'];
            } else {
                return 0;
            }
        }
    }
	//======================================================================================================
	// OBTENER TODAS LAS SUBCATEGORIAS DE UNA CATEGORIA
	//======================================================================================================
	public function get_subcategorias($id_categoria) {
        $data = array();
        $res = $this->db->query("SELECT * FROM subcategorias1 WHERE id_categoria = ? ORDER BY id ASC", $id_categoria);
		foreach($res->result_array() as $row){
			$data[] = $row;
        }
		return $data;
    }

// ***************** Funcion que recoge todas las idiomas de un anuncio********************************
	public function get_idiomas_escort($ids) {
		$id = explode(",", $ids);

		$data = array();
		for ($i=0;$i<count($id);$i++){
			$sql = "SELECT * FROM idiomas WHERE id = ? ";
			$res = $this->db->query($sql,$id[$i]);
			$rows = $res->result_array();

			$data[] = $rows;

		}
		return $data;
    }

	// ***************** Funcion que recoge todas las servicios ********************************
	public function get_servicios() {
        $data = array();

		$this->db->order_by("servicio", "ASC");
		$res = $this->db->get('servicios');
		foreach($res->result_array() as $row){
            $data[] = $row;
        }
		return $data;


    }


 // ***************** Funcion que recoge todas las servicios de un anuncio********************************
	public function get_servicio($ids) {
		$id = explode(",", $ids);

		$hasil = '';
		for ($i=0;$i<count($id);$i++){
			$sql = "SELECT * FROM servicios WHERE id = ? ";
			$res = $this->db->query($sql,$id[$i]);
			$rows = $res->result_array();
			if($i<count($id)-1)
				$hasil .= $rows[0]['servicio']. ',';
			else
				$hasil .= $rows[0]['servicio'];

		}
		return $hasil;
    }
}

/*==========================================================================================*/