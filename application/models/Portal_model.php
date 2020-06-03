<?php
class Portal_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

 	//======================================================================================================
	// OBTENER TODAS LAS CONFIGURACIONES
	//======================================================================================================
	public function get_configuraciones($variable) {
		$data = array();
		$sql = "SELECT * FROM configuracion WHERE elemento = ?";
        $res = $this->db->query($sql,$variable);

		if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }
	}

	//======================================================================================================
	// OBTENER TODAS LAS IMAGENES
	//======================================================================================================
	public function get_imagen($variable) {
		$data = array();
		$sql = "SELECT * FROM imagenes WHERE nombre = ?";
        $res = $this->db->query($sql,$variable);

		if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }
	}
	public function m_obtener_imagenes() {
		$this->db->select('nombre, imagen, titulo');
		$this->db->from('imagenes');
		return $this->db->get()->result_array();
	}
	//======================================================================================================
	// OBTENER DATOS DEL PIE DE PAGINA
	//======================================================================================================
	public function get_footer() {
		$this->db->select('nombre, valor');
		$this->db->from('piepagina');
		$this->db->where('activo', 1);
		return $this->db->get()->result_array();
	}

	//======================================================================================================
	// OBTENER DATOS DEL PIE DE PAGINA
	//======================================================================================================
	public function get_redes($variable) {
		$data = array();
		$sql = "SELECT * FROM redes_sociales WHERE red_social = ?";
        $res = $this->db->query($sql,$variable);

		if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }
	}

}

/*==========================================================================================*/