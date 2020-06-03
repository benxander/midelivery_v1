<?php
class Anuncios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
	//======================================================================================================
	// OBTENER ANUNCIOS SIN TOPS
	//======================================================================================================
	public function get_anuncios($offset, $por_pagina) {
		// $this->load->model('categorias_model');
		$data = array();
		$res = $this->db->query("SELECT * FROM anuncios WHERE activo = 1 AND NOT ".$this->get_top_condition()." ORDER BY timestamp DESC LIMIT " . $offset . ", " . $por_pagina);

		foreach($res->result_array() as $row){
           //  $conversor = new html2text($row['descripcion']);
			$row['foto_principal']	 = $this->get_foto_1_anuncio($row['id']);
		  
            $row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
			
			
			
            $data[] = $row;
        }
		return $data;
	}
	// ============================================================================================
	// OBTIENE TODOS LOS ANUNCIOS QUE SON DESTACADOS
	// ============================================================================================
    public function get_anuncios_destacados() {
        $data = array();
		
		$query = $this->db->query("SELECT * FROM anuncios WHERE activo = 1 AND destacado = 1 ORDER BY id DESC");

		foreach ($query->result_array() as $row)
		{

			$data[] = $row;
		}
        return $data;
    }
	//======================================================================================================
	// OBTENER DATOS DE UN ANUNCIO
	//======================================================================================================
	public function get_anuncio($id) {
        $sql = "SELECT * FROM anuncios WHERE id = " . $id;
        
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
			$rows[0]['foto_principal']	 = $this->get_foto_1_anuncio($rows[0]['id']);
            return $rows[0];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// OBTENER FOTOS DE UN ANUNCIO
	//======================================================================================================
	public function get_fotos_anuncio($id_anuncio) {
        $data = array();
		$query = $this->db->query("SELECT * FROM anuncios_fotos WHERE id_anuncio = " . $id_anuncio ." ORDER BY orden ASC");
		foreach ($query->result_array() as $row){
			$data[] = $row;
		}
		return $data;
    }
	//======================================================================================================
	// OBTENER FOTOS DE UN PROFESIONAL
	//======================================================================================================
	public function get_fotos_profesional($id_profesional) {
        $data = array();
		$query = $this->db->query("SELECT * FROM profesionales_fotos WHERE id_profesional = " . $id_profesional);
		foreach ($query->result_array() as $row){
			$data[] = $row;
		}
		return $data;
    }
	//======================================================================================================
	// OBTENER FICHAS POR CATEGORIA
	//======================================================================================================
	public function get_fichas_categoria($categoria) {
		$data = array();
		$sql = "SELECT * FROM fichas WHERE activo = 1 AND categoria = ? ORDER BY id ASC";
        $res = $this->db->query($sql,$categoria);
		
		foreach($res->result_array() as $row){
			$data[] = $row;
        }
		return $data;
	}
	//======================================================================================================
	// OBTENER DATOS DE UNA FICHA
	//======================================================================================================
	public function get_ficha($id) {
        $sql = "SELECT * FROM fichas WHERE id = " . $id;
        
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// OBTENER DESCRIPCION DE UNA FICHA
	//======================================================================================================
	public function get_desc_ficha($titulo) {
        $sql = "SELECT * FROM fichas WHERE titulo LIKE '%" . $titulo."%'";
        
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }
    }

	//======================================================================================================
	// OBTENER TOTALIDAD DE ANUNCIOS ACTIVOS
	//======================================================================================================
	public function get_anuncios_todos() {
		$data = array();
		$res = $this->db->query("SELECT * FROM anuncios WHERE activo = 1 ORDER BY timestamp DESC");
		foreach($res->result_array() as $row){
			$data[] = $row;
        }
		return $data;
	}
	//======================================================================================================
	// OBTENER CANTIDAD DE ANUNCIOS TOTALES
	//======================================================================================================
	public function contar_anuncios_totales() {
		$this->db->where('activo', '1');
		$this->db->order_by("timestamp", "DESC");
		$res = $this->db->get('anuncios');
		return $res->num_rows();
	}
	//======================================================================================================
	// OBTENER CANTIDAD ANUNCIOS SIN TOPS
	//======================================================================================================
	public function get_anuncios_total() {
		$res = $this->db->query("SELECT * FROM anuncios WHERE activo = 1 AND NOT ".$this->get_top_condition()." ORDER BY timestamp DESC");
		return $res->num_rows();
	}
	//======================================================================================================
	// OBTENER ANUNCIOS TOTALES POR PAGINA
	//======================================================================================================
	public function get_anuncios_totales($offset, $por_pagina) {
		$data = array();
		$res = $this->db->query("SELECT * FROM anuncios WHERE activo = 1 ORDER BY timestamp DESC LIMIT " . $offset . ", " . $por_pagina);

		foreach($res->result_array() as $row){
           //  $conversor = new html2text($row['descripcion']);
		   $row['foto_principal']	 = $this->get_foto_1_anuncio($row['id']);
		  
            $row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
			
			
            $data[] = $row;
        }
		return $data;
	}	
	
	//======================================================================================================
	// CANTIDAD TOTAL DE TODOS LOS TOPS
	//======================================================================================================
    public function get_count_anuncios_top_todos() {
        $this->db->where($this->get_top_condition());
        $this->db->where('activo', 1);
        return $this->db->count_all_results('anuncios');
    }
	
	// ============================================================================================
	// OBTIENE TODOS LOS ANUNCIOS QUE SON TOPS O DESTACADOS
	// ============================================================================================
    public function get_anuncios_top_todos() {
        $data = array();
		
		$query = $this->db->query("SELECT * FROM anuncios WHERE activo = 1 AND " . $this->get_top_condition() . " ORDER BY fecha_alta DESC");

		foreach ($query->result_array() as $row)
		{
			$row['foto_principal']	 = $this->get_foto_1_anuncio($row['id']);
			$row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
			$data[] = $row;
		}
        return $data;
    }

	
	// ===================================================================================
	// ELIMINAR SOLO IMAGENES DE UN ANUNCIO Q SE VA A BORRAR POR ADMIN
	// ===================================================================================
    public function eliminar_imagenes($id) {
        $sql = "SELECT foto FROM anuncios_fotos WHERE id_anuncio = " . $id;

        $query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
		   foreach ($query->result() as $row)
		   {
			   unlink("uploads/anuncios/" . $row->foto);
                unlink("uploads/thumbs/" . $row->foto);
				log_message('error','Borrando foto: '.$row->foto.' del anuncio '.$id.': ');
		   }
		}
		return true;

    }

	//======================================================================================================
	// OBTENER UNA CIERTA CANTIDAD DE ANUNCIOS CON CRITERIOS DE BUSQUEDA
	//======================================================================================================
	public function obtener_anuncios_criterios($offset, $por_pagina,$provincia,$anunciante,$categoria,$subcategoria1,$subcategoria2,$precio_max) {
		$data = array();
		$where_precio="precio <= ".$precio_max;
		if($provincia!=0) $this->db->where('provincia', $provincia);
		if($anunciante!=0) $this->db->where('tipo', $anunciante);
		if($categoria!=0) $this->db->where('categoria', $categoria);
		if($subcategoria1!=0) $this->db->where('subcategoria1', $subcategoria1);
		if($subcategoria2!=0) $this->db->where('subcategoria2', $subcategoria2);
		if($precio_max!=0) $this->db->where($where_precio);
		$this->db->where('activo', '1');
		// if($municipio!=0) $this->db->where('municipio', $municipio);
		$this->db->order_by("timestamp", "DESC");
		$res = $this->db->get('anuncios',$por_pagina,$offset);

		foreach($res->result_array() as $row){
			$row['foto_principal']	 = $this->get_foto_1_anuncio($row['id']);
			$row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
            $data[] = $row;
        }
		return $data;
	}
	//======================================================================================================
	// OBTENER TODOS LOS ANUNCIOS CON CRITERIOS DE BUSQUEDA
	//======================================================================================================	
	public function contar_anuncios_criterios($provincia,$anunciante,$categoria,$subcategoria1,$subcategoria2,$precio_max) {
		$where_precio="precio <= ".$precio_max;
		if($provincia!=0) $this->db->where('provincia', $provincia);
		if($anunciante!=0) $this->db->where('tipo', $anunciante);
		if($categoria!=0) $this->db->where('categoria', $categoria);
		if($subcategoria1!=0) $this->db->where('subcategoria1', $subcategoria1);
		if($subcategoria2!=0) $this->db->where('subcategoria2', $subcategoria2);
		if($precio_max!=0) $this->db->where($where_precio);
		$this->db->where('activo', '1');
		// if($municipio!=0) $this->db->where('municipio', $municipio);
		$this->db->order_by("timestamp", "DESC");
		$res = $this->db->get('anuncios');
		return $res->num_rows();
	}
    
	//======================================================================================================
	// OBTENER UNA CIERTA CANTIDAD DE ANUNCIOS CON VIDEOS
	//======================================================================================================
	public function get_videos_totales($offset, $por_pagina) {
		$data = array();
		// $res = mysql_query("SELECT * FROM anuncio WHERE activo = 1 ORDER BY timestamp DESC LIMIT " . $offset . ", " . $por_pagina);
		$this->db->where('video !=', '');
		$this->db->where('activo', '1');
		$this->db->order_by("timestamp", "DESC");
		$res = $this->db->get('anuncios',$por_pagina,$offset);

		foreach($res->result_array() as $row){
			$row['foto_principal']	 = $this->get_foto_1_anuncio($row['id']);
			$row['cant_fotos'] = $this->contar_fotos_escort($row['id']);
            $row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
			$id_idiomas = $row['idiomas'];
			if($id_idiomas!=''){
				// $row['nombre_idiomas'] = explode(",",$this->categorias_model->get_idioma($id_idiomas));
				$row['nombre_idiomas'] = $this->get_idiomas_escort($id_idiomas);
			}else
				$row['nombre_idiomas']='';
			
            $data[] = $row;
        }
		return $data;
	}
	
	//======================================================================================================
	// OBTENER TODOS LOS ANUNCIOS CON VIDEOS
	//======================================================================================================	
	public function contar_videos_totales() {
		
		$this->db->where('video !=', '');
		$this->db->where('activo', '1');
		$this->db->order_by("timestamp", "DESC");
		$res = $this->db->get('anuncios');
		return $res->num_rows();
	}
	
	//======================================================================================================
	// OBTENER TODOS LOS ANUNCIOS POR PROVINCIAS
	//======================================================================================================
	public function get_anuncios_provincia($offset, $por_pagina, $provincia) {
		$data = array();
        $consulta = "
			SELECT *, CASE WHEN " . $this->get_destacado_condition() . " THEN 1 ELSE 0 END as destacado FROM anuncios WHERE activo = 1 AND provincia = 0 
			UNION
			SELECT *, CASE WHEN " . $this->get_destacado_condition() . " THEN 1 ELSE 0 END AS destacado FROM anuncios WHERE activo = 1 AND (provincia = " . $provincia . " OR " . $this->get_todas_las_provincias_condition() . ") ORDER BY timestamp DESC LIMIT " . $offset . ", " . $por_pagina;
        $res = mysql_query($consulta);

        while ($row = mysql_fetch_array($res)) {
			$row['foto_principal'] = $this->get_foto_1_anuncio($row['id']);
			$row['cant_fotos'] = $this->contar_fotos_escort($row['id']);
            $row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
			$id_idiomas = $row['idiomas'];
			if($id_idiomas!=''){
				// $row['nombre_idiomas'] = explode(",",$this->categorias_model->get_idioma($id_idiomas));
				$row['nombre_idiomas'] = $this->get_idiomas_escort($id_idiomas);
			}else
				$row['nombre_idiomas']='';
			
            $data[] = $row;
        }

        return $data;
    }

	//======================================================================================================
	// OBTENER CANTIDAD DE ANUNCIOS POR PROVINCIAS
	//======================================================================================================
    public function get_anuncios_provincia_total($provincia) {
        $data = array();
		$res_1 = mysql_query("SELECT COUNT(*) FROM anuncios WHERE activo = 1 AND (provincia = " . $provincia . " OR " . $this->get_todas_las_provincias_condition() . ") order by timestamp DESC");

        $row_1 = mysql_fetch_array($res_1);

         $res_2 = mysql_query("SELECT COUNT(*) FROM anuncios WHERE activo = 1 AND provincia = 0 order by timestamp DESC");

        $row_2 = mysql_fetch_array($res_2);

        return $row_1[0] + $row_2[0];
    }
	//======================================================================================================
	// OBTENER TODOS LOS ANUNCIOS PARA OTRAS CIUDADES
	//======================================================================================================
	public function get_anuncios_provincia_excepto($offset, $por_pagina) {
		$barcelona = 8;
		$madrid = 28;
		$vizcaya = 48;
		$data = array();
        $consulta = "
			SELECT *, CASE WHEN " . $this->get_destacado_condition() . " THEN 1 ELSE 0 END as destacado FROM anuncios WHERE activo = 1 AND provincia = 0 
			UNION
			SELECT *, CASE WHEN " . $this->get_destacado_condition() . " THEN 1 ELSE 0 END AS destacado FROM anuncios WHERE activo = 1 AND ((provincia <> " . $barcelona . " AND provincia <> " . $madrid . " AND provincia <> " . $vizcaya . ") OR " . $this->get_todas_las_provincias_condition() . ") ORDER BY timestamp DESC LIMIT " . $offset . ", " . $por_pagina;
        $res = mysql_query($consulta);

        while ($row = mysql_fetch_array($res)) {
			$row['foto_principal'] = $this->get_foto_1_anuncio($row['id']);
			$row['cant_fotos'] = $this->contar_fotos_escort($row['id']);
            $row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
			$id_idiomas = $row['idiomas'];
			if($id_idiomas!=''){
				// $row['nombre_idiomas'] = explode(",",$this->categorias_model->get_idioma($id_idiomas));
				$row['nombre_idiomas'] = $this->get_idiomas_escort($id_idiomas);
			}else
				$row['nombre_idiomas']='';
			
            $data[] = $row;
        }

        return $data;
    }

	//======================================================================================================
	// OBTENER CANTIDAD DE ANUNCIOS PARA OTRAS CIUDADES
	//======================================================================================================
    public function contar_anuncios_provincia_excepto() {
		$barcelona = 8;
		$madrid = 28;
		$vizcaya = 48;
        $data = array();
		$res_1 = mysql_query("SELECT COUNT(*) FROM anuncios WHERE activo = 1 AND ((provincia <> " . $barcelona . " AND provincia <> " . $madrid . " AND provincia <> " . $vizcaya . ") OR " . $this->get_todas_las_provincias_condition() . ") order by timestamp DESC");

        $row_1 = mysql_fetch_array($res_1);

         $res_2 = mysql_query("SELECT COUNT(*) FROM anuncios WHERE activo = 1 AND provincia = 0 order by timestamp DESC");

        $row_2 = mysql_fetch_array($res_2);

        return $row_1[0] + $row_2[0];
    }

	//======================================================================================================
	// OBTENER profesionales TOTALES UTILIZADO EN LOS BANNERS
	//======================================================================================================	
	
	public function get_profesionales(){
		$data = array();
		$this->db->where('activo', '1');
		$this->db->order_by("rand()");
		// $this->db->order_by("id");
		$res = $this->db->get('profesionales');
		
		foreach($res->result_array() as $row){
            $data[] = $row;
        }
		return $data;
	}

	//======================================================================================================
	// OBTENER NUMERO DE PROFESIONALES POR PROVINCIA
	//======================================================================================================	
	
	public function get_num_profesionales(){
		
		$this->db->where('activo', '1');
		$this->db->order_by("fecha_alta", "DESC");
		$res = $this->db->get('profesionales');

		return $res->num_rows();
	}
	//======================================================================================================
	// OBTENER profesionales POR PAGINA
	//======================================================================================================	
	
	public function get_profesionales_pag($offset, $por_pagina){
		$data = array();
		
		$this->db->where('activo', '1');
		$this->db->order_by("fecha_alta", "DESC");

		$res = $this->db->get('profesionales',$por_pagina,$offset);
		
		foreach($res->result_array() as $row){
			$row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
            $data[] = $row;
        }
		return $data;
	}
	//======================================================================================================
	// OBTENER NUMERO DE profesionales PARA OTRAS CIUDADES
	//======================================================================================================	
	
	public function get_num_profesionales_otras(){
		$barcelona = 8;
		$madrid = 28;
		$vizcaya = 48;
		$this->db->where('provincia <>', $barcelona);
		$this->db->where('provincia <>', $madrid);
		$this->db->where('provincia <>', $vizcaya);
		$this->db->where('activo', '1');
		$this->db->order_by("fecha_alta", "DESC");
		$res = $this->db->get('profesionales');

		return $res->num_rows();
	}
	//======================================================================================================
	// OBTENER profesionales PARA OTRAS CIUDADES
	//======================================================================================================	
	
	public function get_profesionales_otras_pag($offset, $por_pagina){
		$data = array();
		$barcelona = 8;
		$madrid = 28;
		$vizcaya = 48;
		$this->db->where('provincia <>', $barcelona);
		$this->db->where('provincia <>', $madrid);
		$this->db->where('provincia <>', $vizcaya);
		$this->db->where('activo', '1');
		$this->db->order_by("fecha_alta", "DESC");

		$res = $this->db->get('profesionales',$por_pagina,$offset);
		
		foreach($res->result_array() as $row){
			$row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
            $data[] = $row;
        }
		return $data;
	}
	//======================================================================================================
	// OBTENER DATOS DE UN PROFESIONAL POR SU ID
	//======================================================================================================
	public function get_profesional($id) {
		$this->db->where('id',$id);
		$res = $this->db->get('profesionales');
        
        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
           
            $rows[0]['nombre_provincia'] = $this->get_provincia_nombre($rows[0]['provincia']);
			$rows[0]['nombre_municipio'] = $this->get_municipio_nombre($rows[0]['municipio']);
            return $rows[0];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// OBTENER DATOS DE UN PROFESIONAL POR SU USUARIO
	//======================================================================================================
	public function get_profesional_by_usuario($usuario) {
        $this->db->where('usuario',$usuario);
		$res = $this->db->get('profesionales');

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
           
            $rows[0]['nombre_provincia'] = $this->get_provincia_nombre($rows[0]['provincia']);
			$rows[0]['nombre_municipio'] = $this->get_municipio_nombre($rows[0]['municipio']);
            return $rows[0];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// OBTENER EL ID USUARIO DE UNA profesional (CADUCADO)?
	//======================================================================================================
	public function get_usuario_profesional($id_profesional) {
        $this->db->where('id',$id_profesional);
		$res = $this->db->get('profesionales');
		
		// $sql = "SELECT usuario FROM profesionales WHERE id = " . $id_profesional;
        
        // $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();

            return $rows[0]['usuario'];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// OBTENER EL ID PROFESIONAL DE UN USUARIO
	//======================================================================================================
	public function get_id_profesional($id_usuario) {
        $sql = "SELECT id FROM profesionales WHERE usuario = " . $id_usuario;
        
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();

            return $rows[0]['id'];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// OBTENER DATOS DE USUARIO DE UNA profesional
	//======================================================================================================
	public function get_datos_usuario_profesional($id_profesional) {
        $sql = "SELECT usuario FROM profesionales WHERE id = " . $id_profesional;
        
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
			// $rows[0]['usuario'];
			$sql2 = "SELECT * FROM usuarios WHERE id = " . $rows[0]['usuario'];
			$res2 = $this->db->query($sql2);
			if ($res2->num_rows() > 0) {
				$rows2 = $res2->result_array();
				return $rows2[0];
			}else return 0;
			
        } else return 0; 
    }
	//======================================================================================================
	// OBTENER DATOS DE USUARIO DE ESCORT INDEPENDIENTE
	//======================================================================================================
	public function get_usuario_escort($id_anuncio) {
        $sql = "SELECT usuario FROM anuncios WHERE id = " . $id_anuncio;
        
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
			// $rows[0]['usuario'];
			$sql2 = "SELECT * FROM usuarios WHERE id = " . $rows[0]['usuario'];
			$res2 = $this->db->query($sql2);
			if ($res2->num_rows() > 0) {
				$rows2 = $res2->result_array();
				return $rows2[0];
			}else return 0;
			
        } else return 0; 
    }
	//======================================================================================================
	// OBTENER CANTIDAD DE ANUNCIOS DE UN PROFESIONAL
	//======================================================================================================
	public function cant_profesionales_anuncios($id_profesional) {
		$this->db->where('profesional',$id_profesional);
		$res = $this->db->get('anuncios');
		return $res->num_rows();
    }
	//======================================================================================================
	// OBTENER PROFESIONALES CON EL USUARIO DADO
	//======================================================================================================
	public function profesionales_usuario($id_usuario) {
		$this->db->where('usuario',$id_usuario);
		$res = $this->db->get('profesionales');
		return $res->num_rows();
    }
	//======================================================================================================
	// OBTENER anuncios DE UNA profesional
	//======================================================================================================
	public function get_anuncios_profesional($id_profesional) {
		$data = array();
		$res = $this->db->query("SELECT * FROM anuncios WHERE activo = 1 AND profesional = ". $id_profesional ." ORDER BY timestamp DESC");

		foreach($res->result_array() as $row){
		   $row['fotos'] = $this->get_fotos_anuncio($row['id']);
		   
            $row['nombre_provincia'] = $this->get_provincia_nombre($row['provincia']);
			$row['nombre_municipio'] = $this->get_municipio_nombre($row['municipio']);
			
            $data[] = $row;
        }
		return $data;
	}
	//======================================================================================================
	// DESACTIVAR UNA profesional
	//======================================================================================================
	 public function desactivar_profesional($id_profesional) {
        $sql = "UPDATE profesionales SET activo = 0 WHERE id = " . $id_profesional;

        return $this->db->query($sql);
    }
	//======================================================================================================
	// ACTIVAR anuncios DE UNA profesional
	//======================================================================================================
	 public function activar_anuncio_profesional($id_profesional) {
        $sql = "UPDATE anuncios SET activo = 1 WHERE profesional = " . $id_profesional;

        return $this->db->query($sql);
    }
	//======================================================================================================
	// DESACTIVAR anuncios DE UNA profesional
	//======================================================================================================
	 public function desactivar_anuncio_profesional($id_profesional) {
        $sql = "UPDATE anuncios SET activo = 0 WHERE profesional = " . $id_profesional;

        return $this->db->query($sql);
    }
	//======================================================================================================
	// DESACTIVAR anuncios INDEPENDIENTE
	//======================================================================================================
	 public function desactivar_anuncio($id_anuncio) {
        $sql = "UPDATE anuncios SET activo = 0 WHERE id = " . $id_anuncio;

        return $this->db->query($sql);
    }
	
	
	
	
	function ultimos_anuncios() {
        //Consultamos solo los ultimos 10 articulos
        //Esto generara una consulta de esta manera
        //SELECT * FROM (`articulos`) ORDER BY `id_articulo` desc LIMIT 10
        $this->db->order_by('timestamp', 'desc');
        $consulta = $this->db->get('anuncios', 10);
        return $consulta->result(); //Retornamos los datos
    }
	
	//======================================================================================================
	// OBTENER LA CONDICION DE TOP
	//======================================================================================================
    private function get_top_condition() {
        return "EXISTS(SELECT * from servicio_anuncio as SA where SA.id_anuncio = anuncios.id AND SA.id_servicio = " . ID_SERVICIO_TOP . " AND datediff(now(),SA.fecha_alta) <= SA.numero_dias)";
    }
	private function get_top_NOT_condition() {
        return "EXISTS (SELECT * FROM servicio_anuncio as SA WHERE SA.id_anuncio = anuncios.id AND SA.id_servicio = " . ID_SERVICIO_TOP . " AND datediff(now(),SA.fecha_alta) <= SA.numero_dias)";
    }
    private function get_destacado_condition() {
        return "EXISTS(SELECT * from servicio_anuncio as SA where SA.id_anuncio = anuncios.id AND SA.id_servicio = " . ID_SERVICIO_DESTACADO . " AND datediff(now(),SA.fecha_alta) <= SA.numero_dias)";
    }

    private function get_todas_las_provincias_condition() {
        return "EXISTS(SELECT * from servicio_anuncio as SA where SA.id_anuncio = anuncios.id AND SA.id_servicio = " . ID_SERVICIO_TODAS_LAS_PROVINCIAS . " AND datediff(now(),SA.fecha_alta) <= SA.numero_dias)";
    }
	
	//======================================================================================================
	// OBTENER FOTO PRINCIPAL DE UNA ESCORT
	//======================================================================================================
	public function get_foto_1_anuncio($id_anuncio) {
		$res = $this->db->query("SELECT * FROM anuncios_fotos WHERE id_anuncio = " . $id_anuncio ." ORDER BY orden ASC");

		if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }

    }
	//======================================================================================================
	// NOMBRE DE UNA PROVINCIA DADA
	//======================================================================================================
    private function get_provincia_nombre($id_provincia) {

        $sql = "SELECT nombre FROM provincia WHERE id = ?";
        $res = $this->db->query($sql, $id_provincia);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0]['nombre'];
        } else {
            return 0;
        }
    }
	//======================================================================================================
	// NOMBRE DE UN MUNICIPIO DADO
	//======================================================================================================
    private function get_municipio_nombre($id_municipio) {

        $sql = "SELECT nombre FROM municipio WHERE id = ?";
        $res = $this->db->query($sql, $id_municipio);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0]['nombre'];
        } else {
            return 0;
        }
    }	   
}
/* =======================================================================*/