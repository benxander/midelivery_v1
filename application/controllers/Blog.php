<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function __construct(){
			parent::__construct();
			$this->load->library(array('form_validation','email','session'));
			$this->load->model(array('anuncios_model','banners_model','blog_model','provincias_model','categorias_model'));
			$this->load->helper(array('text','date'));
	}

	public function index(){
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');

		// DATOS DEL BODY
		$datos['articulos'] = $this->blog_model->getArticles();
		// $data['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera', 'blog');
		// $data['titulo']='INMOPER - Blog';
		$datos['scripts'] = '';
		$this->load->view('header',$datos);
		$this->load->view('blog_view');
		$this->load->view('footer');
	}

	public function ver_articulo($url){
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');

		$datos['scripts'] = '';
		// DATOS DEL BODY
		// venimos de un envio del formulario con errores
		if($this->input->post()){
		   // los recuperamos para mostrarlos en el formulario
			$array_datos_contacto = array(
				'nombre'=>$this->input->post('nombre'),
				'email'=>$this->input->post('email'),
				'comentario'=>$this->input->post('comentario')
			);
		}
		else{
		   //inicializamos los campos vacios
			$array_datos_contacto = array(
				'nombre'=>'',
				'email'=>'',
				'comentario'=>''
			);
		}


		$partes = explode("-", $url);
        $id = $partes[count($partes) - 1]; /*Se obtiene el id de la ultima parte de la url*/

		$datos['id_articulo'] = $id;
		$datos['articulo'] = $this->blog_model->getArticle($id);
        $datos['comentarios'] = $this->blog_model->getComentarios_activos($id);
		// $data['total'] = $this->blog_model->getNumComentarios($id);

		// $data['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera', 'blog');
		// $data['titulo']='INMOPER - Blog';
		$datos['top_destacado'] ='';
		$this->load->view('header',$datos);
		$this->load->view('blog_comentario_view',$array_datos_contacto);
		$this->load->view('footer');
	}


	public function insertar_comentario(){
		//validamos los parametros con la libreria de codeigniter
		$this->form_validation->set_rules('nombre', '<i>&quot;Nombre&quot;</i>', 'min_length[3]|max_length[50]|trim|xss_clean');
		$this->form_validation->set_rules('email', '<i>&quot;Email&quot;</i>', 'required|min_length[7]|max_length[100]|valid_email|trim|xss_clean');

		//Mensajes
		// %s es el nombre del campo que ha fallado
		$this->form_validation->set_message('required','El campo %s es obligatorio');
		$this->form_validation->set_message('min_length','El campo %s debe tener mas de %s caracteres');
		$this->form_validation->set_message('valid_email','El campo %s debe ser un email correcto');

		if(!$this->form_validation->run()){
			//error en la validacion. volvemos a mostrar el formulario
			$this->ver_articulo($this->input->post('id_articulo'));
		}
		else{
			$id_articulo = $this->input->post('id_articulo');
			$nombre = $this->input->post('nombre');
			$email = $this->input->post('email');

			$entry = array(
				'id_articulo'	=> $id_articulo,
				'nombre' 		=> $nombre,
				'email' 		=> $email,
				'comentario'	=> $this->input->post('comentario'),
				// 'subscribe'	=> $this->input->post('subscribe'),
				'fecha' 		=> date('Y-m-d H:i:s'),
				// 'activo' => '1'
				);
			if ($id_comentario = $this->blog_model->insert('comentarios', $entry)){
				// Verificamos si el usuario desea subscribirse
				if($this->input->post('subscribe')){
					$datos_subscripcion = $this->blog_model->subscribe($nombre,$email,$id_articulo);
				}

			   // parametros correctos. enviamos el mail
				$this->email->clear();

				//remitente
				$this->email->from(EMAIL, NOMBRE_PORTAL);

				//destinatarios
				$array_emails = array(
					EMAIL,
					'rguevarac@hotmail.es'

				);
				$this->email->to($array_emails);

				//datos del formulario
				$array_datos_contacto = array(
					'url'				=>	$this->input->post('url'),
					'titulo'			=>	$this->input->post('titulo'),
					'nombre' 			=>	$this->input->post('nombre'),
					'email'				=>	$this->input->post('email'),
					'email_encriptado'	=>	md5($this->input->post('email')),
					'id_encriptado'		=>	md5($id_comentario),
					'comentario'		=>	$this->input->post('comentario')
				);

				//parseamos los datos del formulario con la vista del email
				$mail_body = $this->load->view('notificaciones/activar_comentario', $array_datos_contacto, true);

			   //resto de datos para el envio
				$this->email->subject('Activar Comentario');
				$this->email->message($mail_body);

				if ($this->email->send()) {
					//correcto. saltamos a otra url para evitar envios múltiples
					redirect('blog/mensaje/'.$this->input->post('id_articulo').'#gracias', 'refresh');
				} else {
					//error
					redirect(base_url().'blog/confirmacion_publicacion_nok','refresh');

				}

			  // echo 'OK.';
			}

		}
	}
	function mensaje($id_articulo) {
		$datos['articulo'] = $this->blog_model->getArticle($id_articulo);

		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');
		$datos['provincias'] = $this->provincias_model->get_provincias();
		$datos['categorias'] = $this->categorias_model->get_categorias();
		$datos['dormitorios'] = $this->categorias_model->get_subcategorias(1);
		$datos['salones'] = $this->categorias_model->get_subcategorias(2);
		$datos['cocinas'] = $this->categorias_model->get_subcategorias(3);
		$datos['varios'] = $this->categorias_model->get_subcategorias(4);

		// DATOS DEL TOP Y DESTACADOS
		$datos['total_top'] = $this->anuncios_model->get_count_anuncios_top_todos();
        $datos['anuncios_top'] = $this->anuncios_model->get_anuncios_top_todos();
		$datos['scripts'] = '';

		// DATOS DEL BODY
		$this->load->view('header',$datos);
		$this->load->view('notificaciones/mensaje');
		$this->load->view('footer');

	}

	function confirmar_comentario($url){
		$partes = explode("-", $url);
            if (count($partes) == 2) {
                $email_codificado = $partes[0];
                $id_comentario_codificado = $partes[1];

                if ($datos_articulo = $this->blog_model->activar_comentario($email_codificado,$id_comentario_codificado)) {
                    // Enviamos el comentario a los subscriptores
					$id_articulo = $datos_articulo['id_articulo'];
					$id_comentario = $datos_articulo['id'];
					// $email = $datos_articulo['email'];
					$this->enviar_subscriptores($id_comentario);

					// Mostramos la banda ver del success
					$this->session->set_flashdata('publicado_con_exito', '1');

					redirect('blog/ver_articulo/'.strtolower(url_title($datos_articulo['titulo']."-".$id_articulo)));

                }
                else
                    redirect('blog/confirmacion_publicacion_nok');
            }
            else
                redirect('blog/confirmacion_publicacion_nok');
	}

	function confirmacion_publicacion_nok(){
		// DATOS DE CABECERA
		$datos['banners_cabecera'] = $this->banners_model->get_banners_zona('cabecera');
		$datos['banners_laterales'] = $this->banners_model->get_banners_zona('lateral');
		$datos['provincias'] = $this->provincias_model->get_provincias();
		$datos['categorias'] = $this->categorias_model->get_categorias();
		$datos['dormitorios'] = $this->categorias_model->get_subcategorias(1);
		$datos['salones'] = $this->categorias_model->get_subcategorias(2);
		$datos['cocinas'] = $this->categorias_model->get_subcategorias(3);
		$datos['varios'] = $this->categorias_model->get_subcategorias(4);
		// DATOS DEL TOP Y DESTACADOS
		$datos['total_top'] = $this->anuncios_model->get_count_anuncios_top_todos();
        $datos['anuncios_top'] = $this->anuncios_model->get_anuncios_top_todos();
		$datos['scripts'] = '';

		// DATOS DEL BODY
		$this->session->set_flashdata('publicado_con_exito', '0');
		$datos['top_destacado'] ='';

		$this->load->view('header',$datos);
		$this->load->view('nok_view');
		$this->load->view('footer');
	}

	function enviar_subscriptores($id_comentario){
		// obtenemos los datos del comentario a enviar
		$datos_comentario = $this->blog_model->getComentario($id_comentario);
		$email = $datos_comentario['email'];
		$id_articulo = $datos_comentario['id_articulo'];

		// obtenemos los emails de los subscriptores
		$emails = $this->blog_model->getEmailSubscriptor($email,$id_articulo);

		// obtenemos el titulo del Articulo
		$titulo = $this->blog_model->getTitleArticle($id_articulo);

		$array_datos_comentario['nombre'] = $datos_comentario['nombre'];
		$array_datos_comentario['comentario'] = $datos_comentario['comentario'];
		$array_datos_comentario['id_articulo'] = $id_articulo;
		$array_datos_comentario['titulo'] = $titulo;
		foreach ($emails as $email){
			// parametros correctos. enviamos el mail
			$this->email->clear();
			//remitente
			$this->email->from(EMAIL, NOMBRE_PORTAL);
		 	//destinatarios
			$this->email->to($email);
			// cargamos las vistas necesarias para enviar el mensaje eb html
			$plantilla = $this->load->view('notificaciones/plantilla',array(),TRUE);
			$mensaje = $this->load->view('notificaciones/enviar_comentario', $array_datos_comentario, true);
			//parseamos los datos del formulario con la vista del email
			$mail_body = str_replace("{contenido}", $mensaje, $plantilla);

			//resto de datos para el envio
			$this->email->subject('Comentario Nuevo');
			$this->email->message($mail_body);
			$this->email->send();


		}


		// $this->load->view('prueba_view',$data);

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */