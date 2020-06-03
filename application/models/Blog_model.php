<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blog_model extends CI_Model {

	// ===================================================================================
	// OBTENER TODOS LOS ARTICULOS
	// ===================================================================================
	public function getArticles(){
		$this->db->where('activo', '1');
		$this->db->order_by('fecha DESC');
		return $this->db->get('articulos')->result();
	}

	// ===================================================================================
	// INSERTAR DATOS $data EN LA TABLA $table
	// ===================================================================================
	public function insert($table, $data){
		$this->db->insert($table, $data);
		// Retornamos el id del comentario recien ingresado
		return $this->db->insert_id();
	}

	// ===================================================================================
	// OBTENER DATOS DE UN ARTICULO $ID
	// ===================================================================================
	public function getArticle($id){

	 $res = $this->db->get_where('articulos', array('id' => $id));

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();

            return $rows[0];
        } else {
            return 0;
        }


		// return $this->db->get_where('articulos', array('id' => $id))->result_array();

	}
	// ===================================================================================
	// OBTENER titulo DE UN ARTICULO $ID
	// ===================================================================================
	public function getTitleArticle($id){

	 $res = $this->db->get_where('articulos', array('id' => $id));

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();

            return $rows[0]['titulo'];
        } else {
            return 0;
        }


		// return $this->db->get_where('articulos', array('id' => $id))->result_array();

	}
	// ===================================================================================
	// OBTENER TODOS LOS COMENTARIOS DE UN ARTICULO $ID
	// ===================================================================================
	public function getComentarios($id){
		$this->db->order_by('fecha DESC');
		return $this->db->get_where('comentarios', array('id_articulo' => $id))->result();
	}

	// ===================================================================================
	// OBTENER SOLO LOS COMENTARIOS ACTIVOS DE UN ARTICULO $ID
	// ===================================================================================
	public function getComentarios_activos($id){
		$this->db->order_by('fecha DESC');
		return $this->db->get_where('comentarios', array('id_articulo' => $id,'activo' => '1'))->result();
	}

	// ===================================================================================
	// OBTENER DATOS DE UN COMENTARIO $ID
	// ===================================================================================
	public function getComentario($id){
		$res = $this->db->get_where('comentarios', array('id' => $id,'activo' => '1'));
		if ($res->num_rows() > 0) {
            $rows = $res->result_array();

            return $rows[0];
        } else {
            return 0;
        }
	}

	// ===================================================================================
	// ACTIVAR UN COMENTARIO VIA URL
	// ===================================================================================
	public function activar_comentario($email,$id){
		$sql = "SELECT * FROM comentarios WHERE MD5(email) = ? AND MD5(id) = ?";

        $res = $this->db->query($sql, array($email, $id));
        // $res = $this->db->get_where('comentarios', array(md5('email') => $email, md5('id') => $id));

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            $sql = "UPDATE comentarios SET activo = 1 WHERE id = '" . $rows[0]['id'] . "'";
			$res = $this->db->query($sql);
            $rows[0]['titulo'] = $this->getTitleArticle($rows[0]['id_articulo']);
			return $rows[0];
        } else {
            return 0;
        }

	}

	// ===================================================================================
	// VERIFICAR Y SUBSCRIBIR UN USUARIO A UNA NOTICIA
	// ===================================================================================
	function subscribe($nombre,$email,$id_articulo){
		$this->db->where('email', $email);
		$this->db->where('id_articulo', $id_articulo);
		$res = $this->db->get('subscriptor');

		if ($res->num_rows() > 0) {
            return 0;
        } else {
			$datos = array(
				'nombre' 		=> $nombre,
				'email' 		=> $email,
				'id_articulo'	=> $id_articulo
			);
            $this->db->insert('subscriptor',$datos);
			return $this->db->insert_id();
        }
	}

	function getEmailSubscriptor($email,$id_articulo){
		$this->db->select('email');
		$this->db->where('email !=', $email);
		$this->db->where('id_articulo', $id_articulo);
		$res = $this->db->get('subscriptor');
		if ($res->num_rows() > 0) {
			return $res->result_array();
		}
		else return 0;
	}
	function m_obtener_ultimas_noticias(){
		$this->db->select('*');
		$this->db->from('articulos');
		$this->db->order_by('fecha', 'DESC');
		$this->db->limit(10);
		return $this->db->get()->result_array();
	}
}
/*===================================*/