<?php

class Servicio_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_servicios() {
        $data = array();
        $res = mysql_query("SELECT * FROM servicio order by nombre ASC");

        while ($row = mysql_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
    }

    public function get_servicio_nombre($id_servicio) {

        $sql = "SELECT nombre FROM servicio WHERE id = ?";
        $res = $this->db->query($sql, $id_servicio);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0]['nombre'];
        } else {
            return 0;
        }
    }
    
    public function aplicar_destacar_905($id_anuncio){
        $sql = "INSERT into servicio_anuncio(id_servicio,id_anuncio,numero_dias)
                VALUES(".ID_SERVICIO_DESTACADO.",'".$id_anuncio."',2)";

        $result = $this->db->query($sql);
               
        return $result;
    }
    
    public function get_precio_base($id_servicio){
        $sql = "SELECT precio FROM servicio WHERE id = ?";
        $res = $this->db->query($sql, $id_servicio);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0]['precio'];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// OBTENER SERVICIO POR ANUNCIO
	//======================================================================================================
    public function get_servicio_anuncios($id){
        $sql = "SELECT * FROM anuncios WHERE id = ?";
        $res = $this->db->query($sql, $id);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }
    }
	
    public function get_descuentos($id_servicio){

        $data = array();

        $res = mysql_query("SELECT * FROM servicio_descuento WHERE id_servicio = ".$id_servicio." order by minima ASC");

        while ($row = mysql_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
        
    }
    
    
    public function get_descuento_numero_aplicaciones($id_servicio, $numero_aplicaciones){
        $sql = "SELECT porcentaje_descuento FROM servicio_descuento WHERE id_servicio = ? AND minima <= ".$numero_aplicaciones." AND maxima >= ".$numero_aplicaciones." order by maxima DESC LIMIT 1";
        $res = $this->db->query($sql, $id_servicio);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0]['porcentaje_descuento'];
            
        } else {
            return 0;
        }
    }
    
    public function get_descuento_numero_dias($id_servicio, $numero_dias){
        $sql = "SELECT porcentaje_descuento FROM servicio_descuento WHERE id_servicio = ? AND minima <= ".$numero_dias." AND maxima >= ".$numero_dias." order by maxima DESC LIMIT 1";
        $res = $this->db->query($sql, $id_servicio);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0]['porcentaje_descuento'];
            
        } else {
            return 0;
        }
    }

    public function eliminar_autorenuevas_caducados(){
        $data = array();

        $res = mysql_query("UPDATE anuncio SET fecha_alta = timestamp WHERE id IN (SELECT SA.id_anuncio FROM servicio_anuncio as SA WHERE SA.id_servicio = 7 AND DATE_ADD(SA.fecha_alta, INTERVAL SA.numero_dias DAY) < now())");

        while ($row = mysql_fetch_array($res)) {
            $data[] = $row;
        }
        return $data;
    }
	//======================================================================================================
	// OBTENER PASARELA DESDE PORTALES EROTICOS
	//======================================================================================================
	function get_pasarela($id_pago) {
		$db_portales = $this->load->database('portaleseroticos', TRUE);
		
		if($db_portales){
			$sql = "SELECT * FROM pago WHERE id = ?";
			$res = $db_portales->query($sql, $id_pago);
						
			if ($res->num_rows() > 0) {
				$rows = $res->result_array();
				return $rows[0];
			} else {
				return 0;
			}
		}	
		
    }
    
}
/*==============================================*/