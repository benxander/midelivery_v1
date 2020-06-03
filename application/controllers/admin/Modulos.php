<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Modulos extends CI_Controller {
    function __construct()
    {
        parent::__construct();
		if (!($this->session->userdata('logged')))
            redirect('/admin');
        $this->load->library(array('grocery_CRUD','image_lib'));
        $this->load->helper(
			array(
				'metadata_helper',
                'config_helper',
                'string'
			)
		);
        // $this->load->model(
        // 	array(
        // 		'modulo_model',
        // 		'categorias_model'
        // 	)
        // );
        $this->config->load('grocery_crud');
	}

    private $files = array();
	protected $path_to_uploade_function = 'admin/Modulos/multi_uploade';
    // protected $default_css_path = 'assets/css';
    // protected $default_javascript_path = 'assets/js';
    protected $ruta_principal = 'uploads/paginas/';
    protected $ruta_miniaturas = 'uploads/thumbs/';

    protected $file_table = 'modulo_imagen';
    protected $idmodulo_field = 'idmodulo';
    protected $file_name_field = 'nombre';
    protected $orden_field = 'orden';
	protected $primary_key = 'idmoduloimagen';

	/**
	 * Funcion Principal para gestionar los modulos y la subida de imagenes
	 *
	 * @create_at : 11-06-2019
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	function gestion_modulo(){
        $crud = new grocery_CRUD();
        $crud->set_table('modulo');
        $crud->set_subject('Modulo');

        $crud->callback_add_field('fotos', array($this, 'add_upload_fied'));
        $crud->callback_edit_field('fotos', array($this, 'edit_upload_fied'));

        $crud->callback_before_insert(array($this, '_set_files'));
        $crud->callback_after_insert(array($this, '_save_files_into_db'));
        $crud->callback_before_update(array($this, '_set_files'));
        $crud->callback_after_update(array($this, '_save_files_into_db'));
        // if you have no any upload fields on the page you should to set list of the JS files

		// $crud->set_relation("idmodulo", "modulo", "descripcion_modulo",
		// 	array(
		// 		'estado_modulo' => 1,
		// 		'idtipomodulo'	=> 1 //solo fichas
		// 	),
		// 	"idmodulo ASC"
		// );
		// $crud->set_relation("idcategoria", "categoria", "categoria", NULL, "idcategoria ASC");
		$crud->set_relation("idtipomodulo", "tipo_modulo", "descripcion_tm", null, "descripcion_tm ASC");
		// $crud->callback_edit_field('idcategoria', array($this, '_callback_categorias_edit'));
        // $crud->callback_add_field('idcategoria', array($this, '_callback_categorias_add'));

		$crud->columns(
			'descripcion_modulo',
			'titulo_principal'
		);
		$crud->callback_column('estado_modulo', array($this, 'renderizar_columna_estado_modulo'));

		$crud->fields(
			'descripcion_modulo',
			'titulo_principal',
			'contenido',
			'fotos'
		);
		// $crud->field_type('fecha_creacion', 'invisible');
			// $crud->field_type('fecha_alta', 'date');
			// $crud->field_type('fecha_fin', 'date');


			// $crud->field_type('email', 'invisible');

        $crud->required_fields('titulo_principal','descripcion_modulo','segmento_amigable');
            // revisar callback_before_delete
		$crud->callback_before_delete(array($this, 'borrar_imagenes_anuncio'));

		$crud->display_as('idmodulo', 'Módulo')
			->display_as('idtipomodulo', 'Tipo de Modulo')
			->display_as('enlace', 'Enlace o Código Youtube')
			// ->display_as('precio', 'Precio (€)')
			->display_as('idmodulo', 'Cód. Módulo')
			// ->display_as('orden_fi', 'Orden')

			->display_as('fotos', '<p>En esta sección puede ingresar sus fotos seleccionándolas todas o individualmente.<span style="color:red">Despues de subir sus fotos puede ordenarlas con tan solo arrastrarlas</span> </p>Subir Fotos<br><span style="color:red">(Formatos válidos: jpg, png, gif)</span>');

        $crud->order_by('idmodulo', 'desc');


			$crud->unset_add();
			$crud->unset_delete();
            // $crud->unset_texteditor('descripcion');
		$this->_set_js($crud);
        $output = $crud->render();

        $output->seccion = "Modulos";
        $this->_plantillas_output($output);
    }

	function renderizar_columna_estado_modulo($primary_key, $row) {
        if ($row->estado_modulo) {
            return '<div style="text-align:center;"><span style="color: #03BA03"><strong>ACTIVO</strong></span></div>';
        } else {
            return '<div style="text-align:center;"><span style="color: #FF0000"><strong>INACTIVO</strong></span></div>';
        }
	}

	/**
	 * Funcion que determina si se sube o se borra un archivo
	 *
	 * @param [type] $action
	 * @return void
	 */
	function multi_uploade($action = NULL)
    {
        switch ($action)
        {
            case 'uploade':
                $this->uploade_file();

                break;
            case 'delete_file':
                $this->delete_file();

                break;

            default:

                break;
        }
    }
	/**
	 * Metodo para subir imagenes
	 *
	 * @return void
	 */
	function uploade_file(){
	    $watermark = get_imagen("marca_agua");
	    if(!empty($watermark)){
	    	$watermark = './uploads/' . $watermark;
	    }

        $json = NULL;
        $config['upload_path'] = $this->ruta_principal;
        $config['allowed_types'] = $this->config->item('grocery_crud_file_upload_allow_file_types');
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
		$config['max_filename'] = 0;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('multi_aploade'))
        {
            $json['error'] = $this->upload->display_errors();
            $json['success'] = 'false';
        }
        else
        {
			$uploade_data = $this->upload->data();
            $json['success'] = 'true';
            $json['file_name'] = $uploade_data['file_name'];
			// ======================Primero estandarizamos la imagen a un tamaño max de 660x660
			$config['source_image']	= $this->ruta_principal . $uploade_data['file_name'];
			$config['width']	= 660;
			$config['height']	= 660;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();

			$this->image_lib->clear();
			// =======================creamos el thumb
			$config['source_image']	= $this->ruta_principal . $uploade_data['file_name'];
			$config['new_image'] = $this->ruta_miniaturas;
			$config['width']	= 300;
			$config['height']	= 300;
			$this->image_lib->initialize($config);
			$this->image_lib->resize();

			$this->image_lib->clear();

			if(!empty($watermark)){
				// =====================Aplicamos la 1ª marca de agua
				$config['source_image']	= $this->ruta_principal.$uploade_data['file_name'];
				$config['new_image'] = '';
				$config['wm_type']	= 'overlay';
				$config['wm_overlay_path'] = $watermark;
				// $config['wm_padding'] = '20';
				$config['wm_vrt_alignment']	= 'top';
				$config['wm_hor_alignment']	= 'left';
				$this->image_lib->initialize($config);
				$this->image_lib->watermark();

				$this->image_lib->clear();
				// =====================Aplicamos la 2ª marca de agua
				$config['source_image']	= $this->ruta_principal.$uploade_data['file_name'];
				$config['wm_type']	= 'overlay';
				$config['wm_overlay_path'] = $watermark;
				// $config['wm_padding'] = '20';
				$config['wm_vrt_alignment']	= 'bottom';
				$config['wm_hor_alignment']	= 'right';
				$this->image_lib->initialize($config);
				$this->image_lib->watermark();
			}


        }
        echo json_encode($json);
        exit;
	}
	/**
	 * Metodo para eliminar imagenes
	 *
	 * @param [type] $file_name
	 * @return void
	 */
	function delete_file($file_name = NULL)
    {
        $arrData['message'] = 'Ocurrió un error intentelo nuevamente.';
    	$arrData['success'] = false;
        $file_name = $this->input->post('foto') ? $this->input->post('foto') : $_POST['file_name'];
        $this->db->delete($this->file_table, array($this->file_name_field => $file_name));
        if (file_exists($this->ruta_principal . $file_name))
        {
            if(unlink($this->ruta_principal . $file_name)){
            	$arrData['message'] = 'Imagen eliminada correctamente';
    			$arrData['success'] = true;
            }

        }
        if (file_exists($this->ruta_miniaturas . $file_name))
        {
            if(unlink($this->ruta_miniaturas . $file_name)){
            	$arrData['message'] = 'Imagen eliminada correctamente';
    			$arrData['success'] = true;
            }
        }


        //$json = array('success' => true);
        echo json_encode($arrData);
		exit;
	}

	/**
	 * Funcion que agrega una nueva imagen
	 *
	 * @create_at : 11-06-2019
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	function add_upload_fied()
    {
        $html = '<div>
					<span class="fileinput-button qq-upload-button" id="upload-button-svc">
						<span>Subir Foto</span>
						<input type="file" multiple name="multi_aploade" id="multi_aploade_field" accept="image/*" >
					</span>
					<span class="qq-upload-spinner" id="ajax-loader-file" style="display:none;"></span>
					<span id="progress-multiple" style="display:none;"></span>
				</div>
				<select name="files[]" multiple="multiple" size="8" class="multiselect" id="file_multiple_select" style="display:none;">
				</select>
				<div id="file_list_svc" style="margin-top: 40px;"></div>';

        $html .= $this->JS();
        return $html;
	}
	/**
	 * Funcion que edita una imagen
	 *
	 * @create_at : 11-06-2019
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	function edit_upload_fied($value, $primary_key)
    {
       $this->db->order_by("orden", "asc");
		$files = $this->db->get_where($this->file_table, array($this->idmodulo_field => $primary_key))->result_array();
        $html = '
		<div>
			<span class="fileinput-button qq-upload-button" id="upload-button-svc">
			<span>Subir Foto</span>
			<input type="file" multiple name="multi_aploade" id="multi_aploade_field" accept="image/*">
			</span> <span class="qq-upload-spinner" id="ajax-loader-file" style="display:none;"></span>
			<span id="progress-multiple" style="display:none;"></span>
		</div>';

        $html.= '<select name="files[]" multiple="multiple" size="8" class="multiselect" id="file_multiple_select" style="display:none;">';
        if (!empty($files))
        { $i =1;
            foreach ($files as $items)
            {
                // $html.="<option value=" . $i++ . " selected='selected'>" . $items[$this->file_name_field] . "</option>";
				$html.="<option value=" . $items[$this->file_name_field] . " selected='selected'>" . $items[$this->file_name_field] . "</option>";
            }
        }
        $html.='</select>';
        $html.='<div id="file_list_svc" style="margin-top: 40px;">';
        if (!empty($files))
        {$i =1;
            foreach ($files as $items)
            {
                if ($this->_is_image($items[$this->file_name_field]) === true)
                {
                    // $html.= '<div id="' . $i++ . '">';
					$html.= '<div id="' . $items[$this->file_name_field] . '">';
                    $html.= '<a href="' . base_url() . $this->ruta_principal . $items[$this->file_name_field] . '" class="image-thumbnail" id="fancy_' . $items[$this->file_name_field] . '">';
                    $html.='<img src="' . base_url() . $this->ruta_miniaturas . $items[$this->file_name_field] . '" height="100"/>';
                    $html.='</a>';
                    $html.='<a href="javascript:" onclick="delete_file_svc(this,\'' . $items[$this->file_name_field] . '\')" style="color:red;" >Eliminar</a>';
                    $html.='</div>';
                }
                else
                {
                    $html.='<div id="' . $items[$this->file_name_field] . '" >
                          <span>' . $items[$this->file_name_field] . '</span>
                          <a href="javascript:" onclick="delete_file_svc(this,\'' . $items[$this->file_name_field] . '\')" style="color:red;" >Eliminar</a>
                          </div>';
                }
            }
        }
        $html.='</div>';
        $html.=$this->JS();
        return $html;
	}

	function _is_image($name)
    {
        return ((substr($name, -4) == '.jpg')
				|| (substr($name, -4) == '.JPG')
				|| (substr($name, -4) == '.JPEG')
                || (substr($name, -4) == '.png')
                || (substr($name, -5) == '.jpeg')
                || (substr($name, -4) == '.gif' )
                || (substr($name, -5) == '.tiff')) ? true : false;
	}

	function _set_files($post_array)
    {
        $this->files = $post_array['files'];
        unset($post_array['files']);
		$this->orden = $post_array['orden'];
        unset($post_array['orden']);
        return $post_array;
	}

	function _save_files_into_db($post_array, $primary_key)
    {
        $this->db->delete($this->file_table, array($this->idmodulo_field => $primary_key));

		$files = array();
        if (!empty($this->files))
        {
			$lista = explode(",", $this->orden);
			$longitud = count($lista);
			$orden = 0;
            foreach ($this->files as $file)
            {
				if (!empty($this->orden)){
					 for($i=0;$i<$longitud;$i++){
						if($file == $lista[$i]){

							$orden = $i+1;
						}
					}
				}else{
					$orden++;
				}

				$files[] = array(
					$this->idmodulo_field => $primary_key,
					$this->file_name_field => $file,
					$this->orden_field => $orden
				);
            }
        }
        if (!empty($files))
        {
            $this->db->insert_batch($this->file_table, $files);
        }
        return true;
	}

	function _set_js($crud){
        $crud->set_css('assets/grocery_crud/css/ui/simple/' . grocery_CRUD::JQUERY_UI_CSS);
        $crud->set_css('assets/grocery_crud/css/jquery_plugins/file_upload/file-uploader.css');
        $crud->set_css('assets/grocery_crud/css/jquery_plugins/file_upload/jquery.fileupload-ui.css');
        $crud->set_js('assets/grocery_crud/js/' . grocery_CRUD::JQUERY);
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/ui/' . grocery_CRUD::JQUERY_UI_JS);
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/tmpl.min.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/load-image.min.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.iframe-transport.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.fileupload.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/config/jquery.fileupload.config.js');
        $crud->set_css('assets/grocery_crud/css/jquery_plugins/fancybox/jquery.fancybox.css');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.fancybox.pack.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.easing-1.3.pack.js');
        // $crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.mousewheel-3.0.4.pack.js');
        $crud->set_js('assets/grocery_crud/js/jquery_plugins/config/jquery.fancybox.config.js');
	}

	function JS()
    {
        $js = "<script>
			function delete_file_svc(link,filename)
			{
				if (confirm('¿Seguro que deseas eliminarla?')) {

					$('#file_multiple_select option[value=\"'+filename+'\"]').remove();
					/*$(link).parent().remove();*/
					$.post('" . base_url() . $this->path_to_uploade_function . "/delete_file', 'file_name='+filename, function(json){
						console.log('json data', json);
						if(json.success)
						{
							$(link).parent().remove();
						}else{
							console.log('Error');
						}
					}, 'json');
				}
			}
			$(document).ready(function() {
				$('#file_list_svc').sortable({

				   update: function(){
						var ordenElementos = $(this).sortable('toArray').toString();
						$('#file_list_svc').append('<input type=\"hidden\" name=\"orden\" value=\"'+ ordenElementos +'\"/>');
						//alert(ordenElementos);
				   }

				});
				$('#multi_aploade_field').fileupload({
					 url: '" . base_url() . $this->path_to_uploade_function . "/uploade',
					 sequentialUploads: true,
					 cache: false,
					  autoUpload: true,
					  dataType: 'json',
					  acceptFileTypes: /(\.|\/)(" . $this->config->item('grocery_crud_file_upload_allow_file_types') . ")$/i,
					  limitMultiFileUploads: 1,
					  beforeSend: function()
					  {
					  $('#upload-button-svc').slideUp('fast');
					  $('#ajax-loader-file').css('display','block');
					  $('#progress-multiple').css('display','block');
					  },
					  progress: function (e, data) {
						$('#progress-multiple').html(parseInt(data.loaded / data.total * 100, 10) + '%');
					  },
					  done: function (e, data)
					  {
					   console.log(data.result);
					   $('#file_multiple_select').append('<option value=\"'+data.result.file_name+'\" selected=\"selected\">'+data.result.file_name+'</select>');
					   var is_image = (data.result.file_name.substr(-4) == '.jpg'
													|| data.result.file_name.substr(-4) == '.JPG'
													|| data.result.file_name.substr(-4) == '.JPEG'
													|| data.result.file_name.substr(-4) == '.png'
													|| data.result.file_name.substr(-5) == '.jpeg'
													|| data.result.file_name.substr(-4) == '.gif'
													|| data.result.file_name.substr(-5) == '.tiff')
															? true : false;
					 var html;
					 if(is_image==true){
						html='<div id=\"'+data.result.file_name+'\" ><a href=\"" . base_url() . $this->ruta_principal . "'+data.result.file_name+'\" class=\"image-thumbnail\" id=\"fancy_'+data.result.file_name+'\">';
						html+='<img src=\"" . base_url() . $this->ruta_miniaturas . "'+data.result.file_name+'\" height=\"100\"/>';
						html+='</a> <a href=\"javascript:\" onclick=\"delete_file_svc(this,\''+data.result.file_name+'\')\" style=\"color:red;\" >Eliminar</a><div>';
						$('#file_list_svc').append(html);
						$('.image-thumbnail').fancybox({
								'transitionIn'	:	'elastic',
								'transitionOut'	:	'elastic',
								'speedIn'		:	600,
								'speedOut'		:	200,
								'overlayShow'	:	true
						});
					 }
					 else{
						 html = '<div id=\"'+data.result.file_name+'\" ><span>'+data.result.file_name+'</span> <a href=\"javascript:\" onclick=\"delete_file_svc(this,\''+data.result.file_name+'\')\" style=\"color:red;\" >Eliminar</a><div>';
						 $('#file_list_svc').append(html);
					}
					$('#upload-button-svc').show('fast');
					$('#ajax-loader-file').css('display','none');
					$('#progress-multiple').css('display','none');
					$('#progress-multiple').html('');
					}
				 });

			});
			</script>";
        return $js;
	}

	function _plantillas_output($output = null)
    {
		$this->load->view('admin/header');
        $this->load->view('admin/menu');
        $this->load->view('admin/gestor', $output);
        $this->load->view('admin/footer');

    }


}