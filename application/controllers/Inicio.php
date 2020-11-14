<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {
	public function __construct() {
        parent::__construct();
		$this->sessionVP = @$this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
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
				'Categorias_model',
				'Model_empresa'
        	)
    	);
	}
	public function index()
	{
		// ini_set('xdebug.var_display_max_depth', 10);
	    // ini_set('xdebug.var_display_max_children', 1024);
		// ini_set('xdebug.var_display_max_data', 1024);
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


		// $arrCarta = $this->Ficha_model->m_listar_detalle_carta();
		// $arrSeccion = array();
		// foreach ($arrCarta as $row) {
		// 	$arrSeccion[$row['idseccion']] = array(
		// 		'idseccion'	=> $row['idseccion'],
		// 		'seccion'	=> $row['seccion'],
		// 		'imagen_sec'	=> $row['imagen_sec'],
		// 		'lista_carta'	=> array()
		// 	);
		// }

		// foreach ($arrSeccion as $key => $value) {
		// 	$arrAux = array();
		// 	foreach ($arrCarta as $row) {
		// 		if( $key == $row['idseccion'] ){
		// 			array_push($arrAux,
		// 				array(
		// 					'carta'		=> $row['carta']
		// 				)
		// 			);
		// 		}
		// 	}
		// 	$arrSeccion[$key]['lista_carta'] = $arrAux;
		// }
		// $arrSeccion = array_values($arrSeccion);
		$params = array(
			'idempresa' => 1
		);
		$arrEmpresa = $this->Model_empresa->m_cargar_empresa_demo($params);
		$arrCartaDigital = $this->Model_empresa->m_cargar_carta_digital($arrEmpresa);

		$arrCategoria = array();
		foreach ($arrCartaDigital as $row) {
			$arrCategoria[$row['idcategoria']] = array(
				'idcategoria'	=> $row['idcategoria'],
				'categoria'	=> $row['categoria'],
				'imagen_cat'	=> $row['imagen_cat'],
				'color'			=> $arrEmpresa['clase'],
				'productos'	=> array()
			);
		}

		foreach ($arrCategoria as $key => $value) {
			$arrAux = array();
			foreach ($arrCartaDigital as $row) {
				if( $key == $row['idcategoria'] ){
					array_push($arrAux,
						array(
							'idproducto'	=> $row['idproducto'],
							'producto'		=> $row['producto'],
							'precio'		=> $row['precio'],
							'alergenos'		=> $row['alergenos'],
						)
					);
				}
			}
			$arrCategoria[$key]['productos'] = $arrAux;
		}
		$arrCategoria = array_values($arrCategoria);

		$arrMenu = $this->Ficha_model->m_listar_menu_sidreria();

		if($arrEmpresa['modelo_carta'] === '1' ){
			$datos['estilo'] = base_url() . 'css/style_carta1.css';
		}else{
			$datos['estilo'] = base_url() . 'css/style_carta2.css';
		}

		$datos['modulos'] = $arrListado;
		$datos['modelo_carta'] = $arrEmpresa['modelo_carta'];
		$datos['categoria_carta'] = $arrCategoria;
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


	public function qr($data="https://www.hementxe.com"){
		$this->load->library('ciqrcode');
		header("Content-Type: image/png");
		$params['data'] = $data;
		$params['level'] = 'H';
		$params['size'] = 7;
		$this->ciqrcode->generate($params);
	}
	public function qr_code($nombre_negocio = null){
		$this->load->library('ciqrcode');
		$sesion = $this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
		
		if(!empty($this->sessionVP['nombre_negocio'])){
			$nombre_negocio = $this->sessionVP['nombre_negocio'];
		}

		$data = base_url() . 'c/' . $nombre_negocio;
		header("Content-Type: image/png");
		$params['data'] = $data;
		$params['level'] = 'H';
		$params['size'] = 7;
		$this->ciqrcode->generate($params);
	}


	public function iconos()
	{
		$this->load->view('modulos/iconos');
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */