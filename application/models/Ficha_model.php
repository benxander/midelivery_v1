<?php
class Ficha_model extends CI_Model {
	public function __construct() {
        parent::__construct();
    }
    public function m_listar_fichas() {
    	$this->db->select('f.idficha, f.titulo, f.descripcion_ficha, f.fecha_creacion');
        $this->db->select('m.idmodulo, m.descripcion_modulo, fi.foto');
    	$this->db->from('ficha f');
    	$this->db->join('modulo m', 'f.idmodulo = m.idmodulo');
        $this->db->join('ficha_imagen fi', 'f.idficha = fi.idficha AND fi.orden = 1','left');
    	$this->db->where('estado_ficha', 1); // activo
        $this->db->where('m.estado_modulo', 1); // modulo activo
        $this->db->where('m.idtipomodulo', 1); // modulo de fichas
    	$this->db->order_by('idficha', 'ASC');
    	return $this->db->get()->result_array();
    }
    public function m_cargar_ficha($id){
        $this->db->select('
            f.idficha,
            f.idmodulo,
            f.idcategoria,
            f.titulo,
            f.descripcion_ficha as descripcion,
            f.fecha_creacion,
            f.enlace,
            tf.idtipoficha,
            tf.descripcion_tf AS tipo_ficha,
            estado_ficha
        ');
        $this->db->from('ficha f');
        $this->db->join('tipo_ficha tf', 'f.idtipoficha = tf.idtipoficha','left');
        $this->db->where('idficha', $id);
        $this->db->limit(1);
        return $this->db->get()->row_array();
    }
    public function m_cargar_fotos_ficha($id){
        $this->db->select('idfichaimagen, foto, orden');
        $this->db->from('ficha_imagen');
        $this->db->where('idficha', $id);
        $this->db->order_by('orden', 'ASC');
        return $this->db->get()->result_array();
    }
    public function m_listar_modulo_fichas(){
        $this->db->select('f.idficha, f.titulo, m.idmodulo, m.descripcion_modulo AS modulo');
        $this->db->from('modulo m');
        $this->db->join('ficha f', 'm.idmodulo = f.idmodulo AND estado_ficha = 1','left');
        $this->db->where('m.estado_modulo', 1); // modulo activo
        $this->db->where('m.idtipomodulo', 1); // modulo de fichas
        $this->db->order_by('idmodulo', 'ASC');
        $this->db->order_by('idficha', 'ASC');
        return $this->db->get()->result_array();
    }
    public function m_listar_fichas_por_categoria($idcategoria){
        $this->db->select('
            f.idficha,
            f.titulo,
            f.descripcion_ficha,
            tf.idtipoficha,
            tf.descripcion_tf AS tipo_ficha,
            f.enlace,
            f.idmodulo
        ');
        $this->db->select("
            (SELECT foto FROM ficha_imagen WHERE idficha = f.idficha ORDER BY orden DESC LIMIT 1)
            AS foto_principal
        ",FALSE);
        $this->db->from('ficha f');
        $this->db->join('tipo_ficha tf', 'f.idtipoficha = tf.idtipoficha','left');
        $this->db->where('f.estado_ficha', 1); // ficha activa
        $this->db->where('f.idcategoria', $idcategoria);
        $this->db->order_by('orden_fi', 'ASC');
        $this->db->order_by('idficha', 'ASC');
        return $this->db->get()->result_array();
    }
    public function m_listar_modulo_categorias(){
        $this->db->select('
            m.idmodulo,
            m.descripcion_modulo AS modulo,
            m.segmento_amigable AS segmento_modulo,
            m.contenido,
            ca.idcategoria,
            ca.categoria,
            ca.imagen_ca,
            ca.color_fondo,
            ca.segmento_amigable AS segmento_categoria,
            ca.descripcion_ca
        ');
        $this->db->from('modulo m');
        $this->db->join('categoria ca', 'm.idmodulo = ca.idmodulo AND estado_ca = 1','left');
        $this->db->where('m.estado_modulo', 1); // modulo activo
        $this->db->where('m.idtipomodulo', 1); // modulo de fichas
        $this->db->order_by('idmodulo', 'ASC');
        $this->db->order_by('orden_ca', 'ASC');
        return $this->db->get()->result_array();
    }
    public function m_listar_modulos_menu(){
        $this->db->select('
            m.idmodulo,
            m.descripcion_modulo AS modulo,
            m.segmento_amigable AS segmento_modulo,
            m.contenido,
            m.titulo_principal,
            m.titulo_secundario,
            mi.nombre,
            mi.orden
        ');
        $this->db->from('modulo m');
        $this->db->join('modulo_imagen mi', 'm.idmodulo = mi.idmodulo','left');
        $this->db->where('m.estado_modulo', 1); // modulo activo
        // $this->db->where('m.idtipomodulo', 1); // modulo de fichas
        $this->db->order_by('posicion', 'ASC');
        $this->db->order_by('mi.orden', 'ASC');
        return $this->db->get()->result_array();
    }

    public function m_listar_detalle_carta()
    {
        $this->db->select("
            sec.idseccion,
            sec.descripcion_sec AS seccion,
            sec.imagen_sec,
            ca.idcarta,
            ca.descripcion_ca AS carta
        ", FALSE);
        $this->db->from('carta ca');
        $this->db->join('seccion sec', 'ca.idseccion = sec.idseccion');
        $this->db->where('ca.estado', 1);
        $this->db->order_by('sec.idseccion', 'ASC');
        $this->db->order_by('ca.idcarta', 'ASC');
        return $this->db->get()->result_array();
    }

    public function m_listar_menu_sidreria()
    {
        $this->db->select("
            me.idmenu_sid,
            me.nombre_menu,
            me.imagen_icono,
            me.contenido,
            me.precio
        ", FALSE);
        $this->db->from('menu_sid me');
        return $this->db->get()->result_array();
    }

}