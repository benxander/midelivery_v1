<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gestores extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if (!($this->session->userdata('logged')))
            redirect('/admin');
        $this->load->library('grocery_CRUD');
        $this->load->helper(
			array(
				'metadata_helper',
                'config_helper',
                'string'
			)
		);
    }
    function _gestor_output($output = null) {
        $this->load->view('admin/header');
        $this->load->view('admin/menu');
        $this->load->view('admin/gestor', $output);
        $this->load->view('admin/footer');
    }
    function index() {
        $this->_gestor_output((object) array('output' => '', 'js_files' => array(), 'css_files' => array()));
    }
    // ===================================================================================
    // GESTION DE VIDEOS
    // ===================================================================================
    function gestion_enlace_videos() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('video_youtube');
            $crud->set_subject('Enlace a Video Youtube');

            $crud->columns('titulo', 'codigo_video');


            $output = $crud->render();
            $output->seccion = "Enlaces a Videos YouTube";
            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Mantenedor de SECCIONES DE LA CARTA
     *
     * @return [Mixed]
     */
    function gestion_secciones() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('seccion');
            $crud->set_subject('Sección de Carta');

            $crud->columns(
                'idseccion',
                'descripcion_sec'
            );

            $crud->fields(
                'descripcion_sec',
                'imagen_sec'
            );
            $crud->required_fields(
                'descripcion_sec'
            );
            $crud->set_field_upload('imagen_sec', 'uploads/categorias');

            $crud->display_as('descripcion_sec', 'Descripción');

            $output = $crud->render();
            $output->seccion = "Secciones de Carta";
            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    /**
     * Mantenedor de CARTA
     *
     * @return [Mixed]
     */
    function gestion_carta() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('carta');
            $crud->set_subject('Plato');

            $crud->columns(
                'idcarta',
                'idseccion',
                'descripcion_ca'
            );

            $crud->fields(
                'idseccion',
                'descripcion_ca'
            );
            $crud->set_relation("idseccion", "seccion", "descripcion_sec",
                array( ),
                "idseccion ASC"
            );

            $crud->required_fields(
                'descripcion_sec'
            );
            // $crud->set_field_upload('imagen_sec', 'uploads/categorias');

            $crud->display_as('descripcion_ca', 'Plato');
            $crud->display_as('idseccion', 'Sección');

            $output = $crud->render();
            $output->seccion = "Platos";
            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    /**
     * Mantenedor de MENUS
     *
     * @return [Mixed]
     */
    function gestion_menus() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('menu_sid');
            $crud->set_subject('Menu');

            $crud->columns(
                'imagen_icono',
                'nombre_menu',
                'precio'
            );
            $crud->callback_column('imagen_icono', array($this, '_callback_menu_renderizado'));

            $crud->required_fields(
                'nombre_menu',
                'contenido',
                'precio'
            );
            $crud->set_field_upload('imagen_icono', 'uploads/categorias');

            $crud->display_as('idmenu_sid', 'Código');
            $crud->display_as('contenido', 'Listado de platos');

            $output = $crud->render();
            $output->seccion = "Menus";
            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    /**
     * Mantenedor de Categorias
     *
     * @return [Mixed]
     */
    function gestion_categorias() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('categoria');
            $crud->set_subject('Categoria');

            $crud->columns(
                'imagen_ca',
                'idmodulo',
                'orden_ca',
                'categoria'
            );
            $crud->callback_column('imagen_ca', array($this, '_callback_categoria_renderizado'));
            $crud->set_relation("idmodulo", "modulo", "descripcion_modulo",
                array(
                    'estado_modulo' => 1,
                    'idtipomodulo'  => 1 //solo fichas
                ),
                "idmodulo ASC"
            );
            $crud->fields(
                'idmodulo',
                'categoria',
                'segmento_amigable',
                'descripcion_ca',
                'orden_ca',
                'color_fondo',
                'imagen_ca'
            );
            $crud->required_fields('categoria','idmodulo', 'segmento_amigable');
            $crud->unset_fields('estado_ca');

            $crud->set_field_upload('imagen_ca', 'uploads/categorias');

            $crud->display_as('idmodulo', 'Módulo')
                ->display_as('orden_ca', 'Número de orden')
                ->display_as('imagen_ca', 'Imagen');

            $output = $crud->render();
            $output->seccion = "Categorias";
            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
	// ===================================================================================
	// GESTION DE DATOS DE UN USUARIO REGISTRADO
	// ===================================================================================
    function gestion_usuario() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_subject('Usuario');
			$crud->where('usuarios.id', $this->session->userdata('id_usuario'));
            $crud->set_table('usuarios');


			$crud->columns('id','usuario', 'email', 'password','telefono');

			$crud->callback_column('password', array($this, 'decrypt_password_list_mode_callback'));
			$crud->callback_edit_field('usuario', array($this, '_callback_edit_usuario'));
			$crud->callback_edit_field('password', array($this, 'decrypt_password_callback'));


			$crud->fields('usuario','password','email','telefono');
			$crud->unique_fields('usuario','email');
			$crud->required_fields('usuario','email','password');
			$crud->display_as('id', 'Código');

			$crud->unset_fields('ip', 'tipo_usuario', 'activo');
            $crud->unset_add();
			$crud->unset_delete();

            $crud->callback_before_update(array($this, 'encrypt_password_callback'));
			// $crud->callback_before_insert(array($this, 'encrypt_password_callback'));
			$crud->set_rules('email','Email','valid_email');
			$crud->set_rules('usuario','Usuario','alpha_numeric');
            $output = $crud->render();
            $output->seccion = "Datos de Usuario";


            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

	// ===================================================================================
	// GESTION DE BANNERS
	// ===================================================================================
    function gestion_banners() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('banner');
            $crud->set_subject('Banner');

            $crud->columns('banner_col', 'titulo');
            $crud->callback_column('banner_col', array($this, '_callback_banner_renderizado'));
			// $crud->callback_column('activo', array($this, '_renderizar_columna_activo'));
            // $crud->callback_before_insert(array($this, '_preparar_data_callback'));
		    $crud->callback_before_delete(array($this, 'eliminar_banner'));

            // $crud->callback_edit_field('destino_url', array($this, '_callback_edit_destino'));

			$crud->fields('titulo','banner');
            $crud->set_field_upload('banner', 'uploads/banners');
            $crud	->display_as('titulo', 'Título')
					->display_as('banner_col', 'Banner')
					->display_as('banner', 'Banner:<br><span style="color:red">Banner Cabecera:</span> Tamaño: 1000 x 470 px<br><span style="color:red">');


            // $crud->field_type('zona','enum',array("cabecera","lateral"));
            // $crud->field_type('destino_url','enum',array(
            //     1 => 'Misma Ventana',
            //     2 => 'Otra pestaña',
            //     3 => 'Modal'
            //     )
            // );
            $output = $crud->render();
            $output->seccion = "Banners";
            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    function eliminar_banner($primary_key) {
        $this->load->model(array('banners_model'));

        $row = $this->banners_model->get_banner($primary_key);
        if ( file_exists('uploads/banners/' . $row['banner']) ){
            unlink('uploads/banners/' . $row['banner']);
        }
        return TRUE;
    }
    // ===================================================================================
    // RENDERIZAR BANNER
    // ===================================================================================
    public function _callback_banner_renderizado($value, $row) {

            return "<center><a class='image-thumbnail' style='cursor:-webkit-zoom-in;' href='" . base_url() . 'uploads/banners/' . $row->banner . "'><img style='max-width: 245px; max-height: 80px' src='" . base_url() . 'uploads/banners/' . $row->banner . "'/></a></center>";

    }
    public function _callback_categoria_renderizado($value, $row) {
        if(!empty($row->imagen_ca)){
            return "<center><a class='image-thumbnail' style='cursor:-webkit-zoom-in;' href='" . base_url() . 'uploads/categorias/' . $row->imagen_ca . "'><img style='max-width: 245px; max-height: 80px' src='" . base_url() . 'uploads/categorias/' . $row->imagen_ca . "'/></a></center>";
        }else{
            return;
        }

    }
    public function _callback_menu_renderizado($value, $row) {
        if(!empty($row->imagen_icono)){
            return "<center><a class='image-thumbnail' style='cursor:-webkit-zoom-in;' href='" . base_url() . 'uploads/categorias/' . $row->imagen_icono . "'><img style='max-width: 245px; max-height: 80px' src='" . base_url() . 'uploads/categorias/' . $row->imagen_icono . "'/></a></center>";
        }else{
            return;
        }

    }
	// ===================================================================================
	// RENDERIZAR DESTINO
	// ===================================================================================
	 public function _preparar_data_callback($post_array) {
        switch ($post_array['destino_url']) {
            case 'Misma Ventana':
                $post_array['destino_url'] = 1;
                break;
            case 'Otra pestaña':
                $post_array['destino_url'] = 2;
                break;
            case 'Modal':
                $post_array['destino_url'] = 3;
                break;
            default:
                $post_array['destino_url'] = 1;
                break;
        }
        return $post_array;
    }

    // ===================================================================================
    // RENDERIZAR CAMPO EDITAR DESTINO
    // ===================================================================================
     function _callback_edit_destino($value,$primary_key) {
        $sel1 = '';
        $sel2 = '';
        $sel3 = '';
        switch ($value) {
            case 1:
                $sel1 = 'selected="selected"';
                break;
            case 2:
                $sel2 = 'selected="selected"';
                break;
            case 3:
                $sel3 = 'selected="selected"';
                break;
            default:

                break;
        }
        $result = '<select id="destino_url" name="destino_url">';
        $result .= '<option value="1" '.$sel1.'>Misma Ventana</option>';
        $result .= '<option value="2" '.$sel2.'>Otra Pestaña</option>';
        $result .= '<option value="3" '.$sel3.'>Modal</option>';
        $result .= '</select>';
       return $result;

    }
	// ===================================================================================
	// REDERIZAR COLUMNA ACTIVO PARA ADMINISTRADOR
	// ===================================================================================
	function _renderizar_columna_activo($primary_key, $row) {
        if ($row->activo) {
            return '<div><span style="color: #03BA03"><strong>SÍ</strong></span></div>';
        } else {
            return '<div><span style="color: #FF0000"><strong>NO</strong></span></div>';
        }
    }

    function _renderizar_columna_estado_pr($primary_key, $row) {
        if ( $row->estado_pr == 1) {
            return '<div><span style="color: #03BA03"><strong>ACTIVO</strong></span></div>';
        } else {
            return '<div><span style="color: #FF0000"><strong>INACTIVO</strong></span></div>';
        }
    }
	// ===================================================================================
	// REDERIZAR COLUMNA ACTIVO PARA ADMINISTRADOR
	// ===================================================================================
	function _renderizar_columna_top($primary_key, $row) {
        if ($row->top_rotativo) {
            return '<div><span style="color: #03BA03"><strong>SÍ</strong></span></div>';
        } else {
            return '<div><span style="color: #FF0000"><strong>NO</strong></span></div>';
        }
    }
	// ===================================================================================
	// FUNCION PARA MOSTRAR LA CADUCIDAD
	// ===================================================================================
	function _renderizar_columna_caduca($primary_key, $row) {
		$this->load->model('anuncios_model');
		$book = $this->anuncios_model->get_anuncio($row->id);

		$dt2 = time();
		$dt1 = strtotime($book['fecha_fin']);
			$dt2 = time();

			$res  = $dt1 - $dt2;
			if($res > 0){
				$dias_d   = $res / 86400;
				$div = explode('.', $dias_d);
				$dias = $div[0]; //aqui obtienes los dias
				$horas_d = ($res - (86400 * $dias))/3600;
				$div2 = explode('.', $horas_d);
				$horas = $div2[0];//aca obtienes las horas
				return $dias . ' dias, '. $horas .' horas';
			}else
				return '<div style="text-align:center;"><span style="color: #FF0000"> <strong>CADUCADO</strong></span></div>';
    }
	// ===================================================================================
	// FUNCION PARA MOSTRAR LA CADUCIDAD
	// ===================================================================================
	function _renderizar_columna_caduca_banner($primary_key, $row) {
		$this->load->model('banners_model');
		$banner = $this->banners_model->get_banner($row->id);

		$dt2 = time();
		$dt1 = strtotime($banner['fecha_hasta']);
			$dt2 = time();

			$res  = $dt1 - $dt2;
			if($banner['zona']=='1'){
				return '<div style="text-align:center;"><span style="color: #03BA03"> <strong>NO CADUCA</strong></span></div>';
			}else{
				if($res > 0){
					$dias_d   = $res / 86400;
					$div = explode('.', $dias_d);
					$dias = $div[0]; //aqui obtienes los dias
					$horas_d = ($res - (86400 * $dias))/3600;
					$div2 = explode('.', $horas_d);
					$horas = $div2[0];//aca obtienes las horas
					return $dias . ' dias, '. $horas .' horas';
				}else
					return '<div style="text-align:center;"><span style="color: #FF0000"> <strong>CADUCADO</strong></span></div>';
			}
    }
	// ===================================================================================
	// GESTION DE NOTICIAS
	// ===================================================================================
	 function gestion_noticias() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('articulos');
            $crud->set_subject('Noticia');
			$crud->order_by('fecha', 'desc');
            $crud->columns('imagen','titulo', 'fecha');

            // $crud->callback_column('banner', array($this, '_callback_banner_renderizado'));
            // $crud->set_field_upload('banner', 'uploads/banners');
			$crud->display_as('imagen','Banner');
			$crud->unset_fields('fecha');

			$crud->set_field_upload('imagen', 'uploads/articulos');


			$crud->add_action('Comentarios', base_url() . 'images/iconos/comentarios.png', 'admin/gestores/gestion_comentarios');
			$output = $crud->render();

            $output->seccion = "Noticias";

            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    // ===================================================================================
    // GESTION DE CALENDARIO
    // ===================================================================================
     function gestion_promocion() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('promocion');
            $crud->set_subject('Promocion');
            $crud->order_by('idpromocion', 'DESC');
            $crud->columns('titulo', 'fecha_inicio', 'fecha_fin','estado_pr');

            // $crud->callback_column('banner', array($this, '_callback_banner_renderizado'));
            $crud->callback_column('estado_pr', array($this, '_renderizar_columna_estado_pr'));
            // $crud->set_field_upload('banner', 'uploads/banners');
            $crud->display_as('estado_pr','Estado');

            $crud->set_field_upload('imagen', 'uploads/promocion');

            $crud->unset_fields('estado_pr','precio','precio_anterior');

            $output = $crud->render();

            $output->seccion = "Promociones";

            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
	// ===================================================================================
	// GESTION DE COMENTARIOS
	// ===================================================================================
    function gestion_comentarios($id_articulo) {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('comentarios');
            $crud->where('id_articulo', $id_articulo);
            $crud->set_subject('Comentario');
            // $crud->columns('id_servicio', 'numero_aplicaciones', 'numero_dias', 'fecha_desde', 'fecha_hasta', 'estado');

            // $crud->fields('id_servicio', 'id_anuncio', 'numero_aplicaciones', 'numero_dias');

			$crud->unset_fields('fecha');
            $crud->field_type('id_articulo', 'hidden', $id_articulo);


            // $crud->callback_before_insert(array($this, 'preparar_array_post'));
            // $crud->callback_before_update(array($this, 'preparar_array_post'));
            // $crud->callback_before_delete(array($this, 'tras_borrar_servicio_anuncio'));

            $output = $crud->render();

            $output->seccion = "Comentarios de la Noticia " . $id_articulo;


            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }





    function gestion_configuracion() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_subject('Parámetro de configuración');
            $crud->set_table('configuracion');
            $output = $crud->render();

            $output->seccion = "la Configuración";

            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }




	// ===================================================================================
	// FUNCION QUE CREA LOS THUMBS Y REDIMENCIONA LAS IMAGENES DE LOS ANUNCIOS AGREG. MARCA DE AGUA
	// ===================================================================================
    function crear_versiones_callback($uploader_response, $field_info, $files_to_upload) {
        $this->load->library('image_moo');

        $this->image_moo->set_watermark_transparency(50);
        //$this->image_moo->set_jpg_quality(80);

        $file_uploaded = $field_info->upload_path . '/' . $uploader_response[0]->name;
        $miniatura = str_replace("anuncios", "thumbs", $field_info->upload_path) . '/' . $uploader_response[0]->name;

        $this->image_moo->load($file_uploaded)->resize(100, 100)->save($miniatura, true);
        $this->image_moo->load($file_uploaded)->resize(600, 2000)->save($file_uploaded, true);
        $this->image_moo->load($file_uploaded)->load_watermark('./images/watermark.png')->watermark(7)->save($file_uploaded, true);
        $this->image_moo->load($file_uploaded)->load_watermark('./images/watermark.png')->watermark(3)->save($file_uploaded, true);

        return true;
    }


    function ver_anuncio_callback($primary_key, $row) {
        //return site_url('anuncios/ver_anuncio/' . strtolower(url_title($row['titulo'] . "-" . $row['id'])));
        return site_url('anuncios/ver_anuncio/' . strtolower(url_title($row['titulo'] . "-" . $row['id'])));
    }

    function castellanizar_fecha_desde($value, $row) {
        $this->load->helper('date');
        $dt = new DateTime($row->fecha_alta);
        return date_castellanize($dt->format("jS F Y"));
    }

    function castellanizar_fecha_hasta($value, $row) {
        $this->load->helper('date');
        $dt = new DateTime($row->fecha_alta);
        $intervalo = $row->numero_dias . " days";
        date_add($dt, date_interval_create_from_date_string($intervalo));
        return date_castellanize($dt->format("jS F Y"));
    }

    function calcular_estado($value, $row) {
        $this->load->helper('date');
        $dt = new DateTime($row->fecha_alta);
        $intervalo = $row->numero_dias . " days";
        date_add($dt, date_interval_create_from_date_string($intervalo));
        if (dateDifference($dt->format("jS F Y"), date("jS F Y")) > 0)
            return '<span style="color:#cc0000">Caducado</span>';
        else
            return '<span style="color:#00cc00">Activo</span>';
    }


	// ===================================================================================
	// FUNCION QUE ELIMINA LAS IMAGENES DE UN ANUNCIO A BORRAR
	// ===================================================================================
	function borrar_imagenes_anuncio($primary_key) {
		$this->load->model(array('anuncios_model'));

		$this->anuncios_model->eliminar_imagenes($primary_key);

		return TRUE;
	}
	// ===================================================================================
	// FUNCION QUE COMPLETA LOS DATOS DEL ANUNCIO FREE
	// ===================================================================================
    function completar_datos_anuncio($post_array) {
        $ahora = date("Y-m-d H:i:s", time());

        $post_array['fecha_alta'] = $ahora;
        $post_array['ip'] = $this->input->ip_address();
		$post_array['activo'] = 1;
		$post_array['usuario'] = $this->session->userdata('id_usuario');
        return $post_array;
    }


	// ===================================================================================
	// FUNCION QUE CARGA LA GALERIA DE FOTOS
	// ===================================================================================
	function galeria_add_field_callback() {

        // $this->load->model('anuncios_model');
       	$datos['foto'] = '';
        $return = $this->load->view('admin/galeria_subida', $datos, true);

        return $return;
    }

	function encrypt_password_callback($post_array, $primary_key = null) {
        $this->load->library('encrypt');

        $post_array['password'] = $this->encrypt->encode($post_array['password']);
        return $post_array;
    }

    function decrypt_password_callback($value) {
        $this->load->library('encrypt');

        $decrypted_password = $this->encrypt->decode($value);
        return "<input id='field-password' type='text' name='password' value='$decrypted_password' />";
    }

    function decrypt_password_list_mode_callback($value) {
        $this->load->library('encrypt');

        return $this->encrypt->decode($value);
    }
	// ===================================================================================
	// RENDERIZAR CAMPO AGREGAR USUARIO
	// ===================================================================================
	 function _callback_add_usuario() {
        $label = '<p>Ingrese solo caracteres alfanuméricos, es decir letras y números.<br><span style="color:red">No se permiten espacios en blanco, guiones, vocales acentuadas, ñs...</span></p>';
            return $label.'<input id="field-usuario" name="usuario" type="text" maxlength="60"></input>';

    }
	// ===================================================================================
	// RENDERIZAR CAMPO EDITAR USUARIO
	// ===================================================================================
	 function _callback_edit_usuario($value,$primary_key) {
        $label = '<p>Ingrese solo caracteres alfanuméricos, es decir letras y números.<br><span style="color:red">No se permiten espacios en blanco, guiones, vocales acentuadas, ñs...</span></p>';
            return $label.'<input id="field-usuario" name="usuario" type="text" value="'.$value.'" maxlength="60"></input>';

    }

}
// ===================================================================================
// FIN DE ARCHIVO
// ===================================================================================