<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configuracion extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!($this->session->userdata('logged')))
            redirect('/admin');

        $this->load->database();
        $this->load->library(array('grocery_CRUD', 'session'));
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
        $this->load->view('admin/menu2');
        $this->load->view('admin/gestor', $output);
        $this->load->view('admin/footer');
    }

    function index() {
        $this->_gestor_output((object) array('output' => '', 'js_files' => array(), 'css_files' => array()));
    }
	// ===================================================================================
	// GESTION DE CONFIGURACION
	// ===================================================================================
    function datos_web() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_subject('Configuracion');
            $crud->set_table('configuracion');


			// $crud->columns('imagen','usuario', 'email', 'password','telefono');
			// $crud->callback_column('imagen', array($this, '_callback_avatar_renderizado'));
			// $crud->callback_column('password', array($this, 'decrypt_password_list_mode_callback'));

			$crud->field_type('elemento','readonly');
			$crud->field_type('descripcion','readonly');
            $crud->unset_add();
			$crud->unset_delete();


            $output = $crud->render();
            $output->seccion = "Datos de la Web";


            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
	// ===================================================================================
	// GESTION DE IMAGENES DE LA WEB
	// ===================================================================================
    function gestion_imagenes() {
		$crud = new grocery_CRUD();

		$crud->set_subject('Imagenes');
		$crud->set_table('imagenes');
		$crud->order_by('id','asc');

		// $crud->unset_add();
		$crud->set_field_upload('imagen', 'uploads');
		$crud->callback_after_upload(array($this,'_callback_after_upload'));
		$crud->unset_delete();
		$crud->unset_texteditor('ubicacion');
		$output = $crud->render();
		$output->seccion = "Imagenes";
		$this->_gestor_output($output);
    }
	// ===================================================================================
	// GESTION DE CONFIGURACION
	// ===================================================================================
    function gestion_footer() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_subject('Pie de Página');
            $crud->set_table('piepagina');


			// $crud->columns('imagen','usuario', 'email', 'password','telefono');
			$crud->callback_column('activo', array($this, '_renderizar_columna_activo'));
			// $crud->callback_column('password', array($this, 'decrypt_password_list_mode_callback'));

			$crud->field_type('nombre','readonly');
			$crud->field_type('activo','hidden');
            $crud->unset_add();
			$crud->unset_delete();


            $output = $crud->render();
            $output->seccion = "Datos del Pie de Página";


            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
	// ===================================================================================
	// ANTES DE SUBIR IMAGEN
	// ===================================================================================
	function _callback_after_upload($uploader_response,$field_info, $files_to_upload){
	$new_name = substr_replace($uploader_response[0]->name, '', 0,6) ;
	$config['source_image']	= './images/'.$uploader_response[0]->name;
	$config['new_image'] = $new_name;
	$this->load->library('image_lib', $config);
	$this->image_lib->resize();
	return true;

/*$this->load->library('image_moo');

    //Is only one file uploaded so it ok to use it with $uploader_response[0].
    $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name;
	$new_name = substr_replace($uploader_response[0]->name, '', 0,6) ;
	$new_file = $field_info->upload_path.'/'.$new_name;
    $this->image_moo->load($file_uploaded)->save($new_file,true);

    return true;*/

	}

	// ===================================================================================
	// ANTES DE ACTUALIZAR E INSERTAR HAY QUE RENOMBRAR EL ARCHIVO DE LA IMAGEN
	// ===================================================================================
	function renombrar_archivo($post_array, $primary_key = null){
		$post_array['imagen'] = $post_array['nombre_archivo'];
		return $post_array;
	}
	// ===================================================================================
	// GESTION DE FICHAS
	// ===================================================================================
    function gestion_fichas() {
		$crud = new grocery_CRUD();

		$crud->set_subject('Fichas');
		$crud->set_table('fichas');
		$crud->order_by('id','desc');

		$crud->columns('foto_1','categoria','titulo','descripcion','activo');
		$crud->callback_column('activo', array($this, '_renderizar_columna_activo'));

		$crud->field_type('categoria','enum',array('tarot','tarot-gratis','significados','horoscopo','videncia'));

		// $crud->unset_add();
		$crud->set_field_upload('foto_1', 'uploads/fichas');
		// $crud->unset_delete();
		$output = $crud->render();
		$output->seccion = "Fichas";
		$this->_gestor_output($output);
    }

	// ===================================================================================
	// GESTION DE PAGINAS DINAMICAS
	// ===================================================================================
    function gestion_paginas_dinamicas() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_table('pagina_dinamica');
            $crud->set_subject('Página dinámica');
            $crud->columns('imagen','nombre','titulo','contenido','url_imagen');
            $crud->display_as('nombre', 'Página')
                ->display_as('contenido', 'Descripción');

            $crud->set_field_upload('imagen', 'uploads/paginas');
            $crud->field_type('posicion_imagen','enum',array('TOP','LEFT','RIGHT','BOTTOM'));
            $crud->field_type('destino_url_imagen','enum',array('_blank','_self','_parent','_top','modal'));
            $output = $crud->render();

            $output->seccion = "Páginas dinámicas";

            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
	// ===================================================================================
	// GESTION DE USUARIOS
	// ===================================================================================
    function gestion_usuarios() {
        try {
            $crud = new grocery_CRUD();

            $crud->set_subject('Usuario');
            $crud->set_table('usuarios');
			$crud->columns('id','usuario', 'password','email','tipo_usuario','ip','activo');
			$crud->callback_column('password', array($this, 'decrypt_password_list_mode_callback'));
			// $crud->columns('imagen', 'usuario', 'email','telefono','tipo_usuario','ip','activo');
			// $crud->callback_column('imagen', array($this, '_callback_avatar_renderizado'));
			$crud->callback_add_field('usuario', array($this, '_callback_add_usuario'));
			$crud->callback_edit_field('usuario', array($this, '_callback_edit_usuario'));

            $crud->callback_before_insert(array($this, 'encrypt_password_callback'));
            $crud->callback_before_update(array($this, 'encrypt_password_callback'));
            $crud->callback_edit_field('password', array($this, 'decrypt_password_callback'));

			$crud->required_fields('usuario','email','password','tipo_usuario');

			$crud->fields('usuario','password','email','telefono','tipo_usuario','ip','activo');
			$crud->unique_fields('usuario','email');
			$crud->field_type('ip', 'hidden', $this->input->ip_address());
			// $crud->set_field_upload('avatar', 'uploads/avatar');
			// $crud->display_as('avatar', 'Imagen<br>Si desea subir una imagen para su perfil.<br><span style="color:red">Tamaño recomendado: 150 x 150 pixeles</span>');

			$crud->set_rules('email','Email','valid_email');
			$crud->set_rules('usuario','Usuario','alpha_numeric');
            $output = $crud->render();

            $output->seccion = "Usuarios";


            $this->_gestor_output($output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
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
	// ===================================================================================
	// FUNCION QUE MUESTRA EL AVATAR EN LA COLUMNA
	// ===================================================================================
	public function _callback_avatar_renderizado($value, $row) {
        if($row->avatar != '')
            return "<center><a class='image-thumbnail' style='cursor:-webkit-zoom-in;' href='" . base_url() . 'uploads/avatar/' . $row->avatar . "'><img  style='max-width: 50px; max-height: 50px' src='" . base_url() . 'uploads/avatar/' . $row->avatar . "'/></a></center>";
        else
			return "";
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



}
// ===================================================================================
// FIN DE ARCHIVO
// ===================================================================================