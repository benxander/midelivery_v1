<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->load->library(
			array(
				'pagination',
				'encrypt',
				'form_validation',
				'curl'
			)
		);
		$this->load->helper(
			array(
				'string_helper',
				'text',
				'date_helper',
				'metadata_helper',
				'email',
				'config_helper',
				'form'
			)
		);
        $this->load->model(
        	array(
	        	'Ficha_model',
	        	'Banners_model',
	        	'Pagina_dinamica_model',
	        	'Categorias_model'
        	)
    	);
	}
	public function index()
	{
		ini_set('xdebug.var_display_max_depth', 10);
	    ini_set('xdebug.var_display_max_children', 1024);
		ini_set('xdebug.var_display_max_data', 1024);
		$lista_imagenes = obtener_imagenes();
		foreach ($lista_imagenes as $key => $value) {
			$imagen[$value['nombre']] = $value['imagen'];
		}

		$arrFooter = get_piepagina();
		foreach ($arrFooter as $key => $value) {
			$footer[$value['nombre']] = $value['valor'];
		}
		$datos['banners_cabecera'] = $this->Banners_model->get_banners_zona('cabecera');
		$datos['promociones'] = $this->Banners_model->get_promociones();
		// $datos['banners_laterales'] = $this->Banners_model->get_banners_zona('lateral');

		$lista = $this->Ficha_model->m_listar_modulos_menu();
		$arrListado = array();
		foreach ($lista as $row) {
			$arrListado[$row['idmodulo']] = array(
				'idmodulo' 			=> $row['idmodulo'],
				'modulo' 			=> $row['modulo'],
				'segmento_modulo' 	=> $row['segmento_modulo'],
				'contenido' 		=> $row['contenido'],
				'titulo_principal' 	=> $row['titulo_principal'],
				'titulo_secundario' => $row['titulo_secundario'],
				'imagenes' 			=> array(),
			);
		}

		foreach ($arrListado as $key => $value) {
			$arrAux = array();
			foreach ($lista as $row) {
				if( $key == $row['idmodulo'] &&
					!empty($row['nombre']) &&
					file_exists("./uploads/paginas/" . $row['nombre'])
				){

					array_push($arrAux,
						array(
							'nombre'	=> base_url() . "uploads/paginas/" . $row['nombre'],
							'orden'		=> $row['orden']
						)
					);
				}
			}
			$arrListado[$key]['imagenes'] = $arrAux;
		}

		$arrListado = array_values($arrListado);


		$arrCarta = $this->Ficha_model->m_listar_detalle_carta();
		$arrSeccion = array();
		foreach ($arrCarta as $row) {
			$arrSeccion[$row['idseccion']] = array(
				'idseccion'	=> $row['idseccion'],
				'seccion'	=> $row['seccion'],
				'imagen_sec'	=> $row['imagen_sec'],
				'lista_carta'	=> array()
			);
		}

		foreach ($arrSeccion as $key => $value) {
			$arrAux = array();
			foreach ($arrCarta as $row) {
				if( $key == $row['idseccion'] ){
					array_push($arrAux,
						array(
							'carta'		=> $row['carta']
						)
					);
				}
			}
			$arrSeccion[$key]['lista_carta'] = $arrAux;
		}
		$arrSeccion = array_values($arrSeccion);

		$arrMenu = $this->Ficha_model->m_listar_menu_sidreria();

		$datos['modulos'] = $arrListado;
		$datos['secciones_carta'] = $arrSeccion;
		$datos['menu_sid'] = $arrMenu;
		$datos['imagen'] = $imagen;
		$datos['footer'] = $footer;
		$this->load->view('home',$datos);
	}
	public function reserva()
	{


		$this->form_validation->set_rules('nombre', '<i>&quot;Nombre&quot;</i>', 'required|min_length[3]|max_length[50]|trim');
        $this->form_validation->set_rules('telefono', '<i>&quot;Teléfono&quot;</i>', 'required|trim');
        $this->form_validation->set_rules('email', '<i>&quot;Email&quot;</i>', 'required|min_length[7]|max_length[100]|valid_email|trim');
        $this->form_validation->set_rules('fecha', '<i>&quot;Fecha&quot;</i>', 'required|trim');
        $this->form_validation->set_rules('comentario', '<i>&quot;Comentario&quot;</i>', 'min_length[7]|max_length[600]|trim');
        //Mensajes
        // %s es el nombre del campo que ha fallado
        $this->form_validation->set_message('required','El campo %s es obligatorio');
        $this->form_validation->set_message('min_length','El campo %s debe tener mas de %s caracteres');
		$this->form_validation->set_message('valid_email','El campo %s debe ser un email correcto');

		if(!$this->form_validation->run()){
			//error en la validacion. volvemos a mostrar el formulario
			// var_dump(validation_errors());
			// exit();
			// $mensaje = validation_errors();
			$msg = 'Algunos datos no son válidos';

			echo "<script>

				alert('". $msg ."');
				window.location.replace('".base_url()."#reservas');
				</script>";
        }else{
			extract($this->input->post());

			$comentario = strip_tags($comentario);

			// echo "Asunto: " . $asunto . "<br>Nombre: ".$nombre ."<br>Email: " . $email . "<br>Mensaje: " . $mensaje;
			$asunto = 'Reserva';
			$mensaje = "Se ha recibido una solicitud de reserva de:
			<br>
			<br>
			<b>Nombre: </b>" . $nombre . "<br>
			<b>Teléfono: </b>" . $telefono . "<br>
			<b>Email: </b>" . $email . "<br>
			<b>Fecha de reserva: </b> " . $fecha . "<br>
			<b>Hora de reserva: </b>" . $hora . "<br>
			<b>Nº de comensales: </b>" . $comensal . "<br><br>
			<b>Comentario: </br>" . nl2br($comentario);

			if ( envio_email(EMAIL, "rguevarac@hotmail.es",$asunto,$mensaje) ) {
                // echo $this->email->print_debugger();
                echo "<script>alert('Enviado. Gracias por contactarnos...');window.location.replace('".base_url()."');</script>";

            } else {
                envio_email("rguevarac@hotmail.es", "","Error al enviar el formulario de contacto", "Se ha recibido un mensaje de contacto: <br><br>Nombre:<b> " . $nombre . "</b><br>Email:<b> " . $email . "</b><br>Mensaje:<br><br>" . nl2br($comentario),$email);
                // echo $this->email->print_debugger();
                echo "<script>alert('Oops... Ocurrió un error . Vuelva a intentarlo pasado unos minutos. Gracias.');window.location.replace('".base_url()."');</script></script>";

            }
			// exit();
		}
	}

	public function contacto()
	{


		$this->form_validation->set_rules('nombre', '<i>&quot;Nombre&quot;</i>', 'required|min_length[3]|max_length[50]|trim');

        $this->form_validation->set_rules('email', '<i>&quot;Email&quot;</i>', 'required|min_length[7]|max_length[100]|valid_email|trim');

        //Mensajes
        // %s es el nombre del campo que ha fallado
        $this->form_validation->set_message('required','El campo %s es obligatorio');
        $this->form_validation->set_message('min_length','El campo %s debe tener mas de %s caracteres');
		$this->form_validation->set_message('valid_email','El campo %s debe ser un email correcto');

		if(!$this->form_validation->run()){
			//error en la validacion. volvemos a mostrar el formulario
			// var_dump(validation_errors());
			// exit();
			// $mensaje = validation_errors();
			$msg = 'Algunos datos no son válidos';

			echo "<script>

				alert('". $msg ."');
				window.location.replace('".base_url()."#reservas');
				</script>";
        }else{
			extract($this->input->post());

			$comentario = strip_tags($comentario);

			// echo "Asunto: " . $asunto . "<br>Nombre: ".$nombre ."<br>Email: " . $email . "<br>Mensaje: " . $mensaje;
			// $asunto = 'Reserva';
			$mensaje = "Se ha recibido un email de contacto:
			<br>
			<br>
			<b>Nombre: </b>" . $nombre . "<br>
			<b>Email: </b>" . $email . "<br>
			<b>Comentario: </br>" . nl2br($comentario);

			if ( envio_email(EMAIL, "rguevarac@hotmail.es",$asunto,$mensaje) ) {
                // echo $this->email->print_debugger();
                echo "<script>alert('Enviado. Gracias por contactarnos...');window.location.replace('".base_url()."');</script>";

            } else {
                envio_email("rguevarac@hotmail.es", "","Error al enviar el formulario de contacto", "Se ha recibido un mensaje de contacto: <br><br>Nombre:<b> " . $nombre . "</b><br>Email:<b> " . $email . "</b><br>Mensaje:<br><br>" . nl2br($comentario),$email);
                // echo $this->email->print_debugger();
                echo "<script>alert('Oops... Ocurrió un error . Vuelva a intentarlo pasado unos minutos. Gracias.');window.location.replace('".base_url()."');</script></script>";

            }
			// exit();
		}
	}


	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function listado()
	{
		ini_set('xdebug.var_display_max_depth', 10);
	    ini_set('xdebug.var_display_max_children', 1024);
		ini_set('xdebug.var_display_max_data', 1024);
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->Banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->Banners_model->get_banners_zona('lateral');
		$lista = $this->Ficha_model->m_listar_modulo_categorias();

		$arrModulos = array();
		foreach ($lista as $row) {
			$arrModulos[$row['idmodulo']] =
				array(
					'idmodulo' 		=> $row['idmodulo'],
					'modulo' 		=> $row['modulo'],
					'segmento_modulo'=> $row['segmento_modulo'],
					'contenido'		=> $row['contenido'],
					'categorias' 	=> array()
				);
		}
		foreach ($arrModulos as $key => $value) {
			$arrAux = array();
			foreach ($lista as $row) {
				if( $value['idmodulo'] == $row['idmodulo'] ){
					if ( $row['imagen_ca'] == '' ||
		        		!file_exists("./uploads/categorias/" . $row['imagen_ca'])
		        		){
		        		$imagen_ca = base_url() . "images/sin_foto.jpg";
		        	}else{
		        		$imagen_ca = base_url() . "uploads/categorias/" . $row['imagen_ca'];
		        	}
					$descripcion_ca = rip_tags($row['descripcion_ca']);
					$descripcion = substr($descripcion_ca,0,80);
					if (strlen($descripcion_ca) > 80)
						$descripcion .= "...";
					array_push($arrAux,
						array(
							'idcategoria'		=> $row['idcategoria'],
							'categoria'			=> $row['categoria'],
							'segmento_categoria'=> $row['segmento_categoria'],
							'imagen_ca'			=> $imagen_ca,
							'descripcion_ca'	=> $descripcion,
							'color_fondo'		=> $row['color_fondo'],
						)
					);
				}
			}
			$arrModulos[$key]['categorias'] = $arrAux;
		}
		$arrModulos = array_values($arrModulos);
		// var_dump($arrModulos); exit();

        $datos['modulos'] = $arrModulos;

        $datos['videos'] = $this->Banners_model->m_listar_videos();
		$datos['mensaje_inicio'] = $this->Pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable('mensaje');
		if( empty($datos['mensaje_inicio']['imagen']) ){
			$datos['mensaje_inicio']['tiene_imagen'] = FALSE;
		}else{
			$datos['mensaje_inicio']['tiene_imagen'] = TRUE;

			if( $datos['mensaje_inicio']['posicion_imagen'] === 'LEFT' ) {
				$datos['mensaje_inicio']['class'] = 'pull-left mr-md';
			}elseif( $datos['mensaje_inicio']['posicion_imagen'] === 'RIGHT' ) {
				$datos['mensaje_inicio']['class'] = 'pull-right ml-md';
			}else{
				$datos['mensaje_inicio']['class'] = '';
			}
		}
		// var_dump('<pre>',$datos);
		// exit();
		$datos['scripts'] = '';
		$this->load->view('header',$datos);
		$this->load->view('inicio_view');
		$this->load->view('footer');
	}
	/**
	 * Para ver el contenido de una Categoria perteneciente a un modulo
	 * @param  string $segmento_amigable
	 * @param  string $segmento_amigable
	 * @return [Mixed]
	 */
	public function modulo($modulo='', $categoria='')
	{
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->Banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->Banners_model->get_banners_zona('lateral');

		$rowCat = $this->Categorias_model->cargar_categoria_por_seg_amigable($modulo,$categoria);
        $lista = $this->Ficha_model->m_listar_fichas_por_categoria($rowCat['idcategoria']);
        $arrFichas = array();
        foreach ($lista as $row) {
        	if ( $row['foto_principal'] == '' ||
        		!file_exists("./uploads/thumbs/" . $row['foto_principal'])
        		){
        		$foto_principal = base_url() . "images/sin_foto.jpg";
        	}else{
        		$foto_principal = base_url() . "uploads/thumbs/" . $row['foto_principal'];
        	}
        	$descripcion_ficha = rip_tags($row['descripcion_ficha']);
			$descripcion = substr($descripcion_ficha,0,80);
			if (strlen($descripcion_ficha) > 80)
				$descripcion .= "...";
        	array_push($arrFichas,
        		array(
        			'idficha'		=> $row['idficha'],
        			'titulo'		=> $row['titulo'],
        			'descripcion'	=> $descripcion,
        			'idtipoficha'	=> $row['idtipoficha'],
        			'tipo_ficha'	=> $row['tipo_ficha'],
        			'enlace'		=> $row['enlace'],
        			'foto_principal'=> $foto_principal,
        		)
        	);
        }

        $datos['rowCat'] = $rowCat;
        $datos['arrFichas'] = $arrFichas;

        $datos['videos'] = $this->Banners_model->m_listar_videos();
		$datos['mensaje_inicio'] = $this->Pagina_dinamica_model->get_pagina_dinamica_by_segmento_amigable('mensaje');

		$datos['scripts'] = '
			<script src="' . base_url() . 'js/modernizr.custom.js"></script>
			<script src="' . base_url() . 'js/toucheffects.js"></script>
		';
		// var_dump($datos);
		// exit();
		$this->load->view('header',$datos);
		$this->load->view('modulos/categoria_view');
		$this->load->view('footer');
	}
	/**
	 * Muestra el contenido de una Ficha
	 * @param  string
	 * @return [type]
	 */
	public function ver_promocion($url) {
        $partes = explode("-", $url);
        $id = $partes[count($partes) - 1];

		// DATOS DE CABECERA
		$lista_imagenes = obtener_imagenes();
		foreach ($lista_imagenes as $key => $value) {
			$imagen[$value['nombre']] = $value['imagen'];
		}

		$arrFooter = get_piepagina();
		foreach ($arrFooter as $key => $value) {
			$footer[$value['nombre']] = $value['valor'];
		}
		$datos['imagen'] = $imagen;
		$datos['footer'] = $footer;
		// $datos['banners_cabecera'] = $this->Banners_model->get_banners_zona('cabecera');
		// $datos['banners_laterales'] = $this->Banners_model->get_banners_zona('lateral');

		// DATOS DEL BODY
		/* OBTENEMOS LOS DATOS DEL ANUNCIO DESDE SU ID*/

		$datos['promocion'] = $this->Banners_model->get_promocion($id);
		// var_dump($datos['promocion']);
		// exit();

		$this->load->view('promocion_view',$datos);

	}

	/**
	 * Muestra el contenido de una Ficha
	 * @param  string
	 * @return [type]
	 */
	public function ver_anuncio($url) {
        $partes = explode("-", $url);
        $id = $partes[count($partes) - 1];

		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->Banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->Banners_model->get_banners_zona('lateral');

		// DATOS DEL BODY
		/* OBTENEMOS LOS DATOS DEL ANUNCIO DESDE SU ID*/
		$datos['scripts'] = '
			<script src="' . base_url() . 'js/fancybox/jquery.fancybox.pack.js"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					$(".fancybox").fancybox({

			    	openEffect	: \'elastic\',
			    	closeEffect	: \'elastic\',
					nextEffect	: \'fade\',
			    	prevEffect	: \'fade\',
					openSpeed : \'slow\',
					closeSpeed : \'slow\',
					padding: 5
					});
				});
			</script>
		';
		if($datos['anuncio'] = $this->Ficha_model->m_cargar_ficha($id)){
			$datos['fotos'] = $this->Ficha_model->m_cargar_fotos_ficha($id);
		}


		$this->load->view('header',$datos);
		$this->load->view('ver_anuncio_view');
		$this->load->view('footer');
    }



	public function qr($data="httpS://www.hementxe.com"){
		$this->load->library('ciqrcode');
		header("Content-Type: image/png");
		$params['data'] = $data;
		$params['level'] = 'H';
		$params['size'] = 7;
		$this->ciqrcode->generate($params);
	}
	/**
	 * Carga las categorias de un módulo seleccionado
	 * @param  string $idmodulo
	 * @return [mixed]
	 */
	public function listar_categorias_modulo($idmodulo = '') {
        if ($idmodulo != 0) {
            $categorias = $this->Categorias_model->m_cargar_categoria_por_modulo($idmodulo);

            foreach ($categorias as $row) {
                echo "<option value='" . $row['idcategoria'] . "'>" . $row['categoria'] . "</option>";
            }
        } else {
            echo "<option value='' selected='selected'>Selecciona primero un módulo</option>";
        }
    }

	public function iconos()
	{
		$this->load->view('modulos/iconos');
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */