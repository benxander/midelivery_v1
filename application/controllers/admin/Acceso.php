<?php
class Acceso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->library(
            array(
                'form_validation',
                'encrypt'
            )
        );
        $this->load->helper(
			array(
				'string_helper',
				'text',
				'date_helper',
				'metadata_helper',
				'email',
				'config_helper'
			)
		);
    }

    function index() {
        if ($this->session->userdata('logged')) {
                redirect('/admin/menu');
                // redirect('/inicio');
        } else {
            $this->mostrar_formulario();
        }
    }

    function login() {

        //redirect('/admin/menu');
        // Lanzadera
        $datos = array();
        // Aplicamos reglas
        $this->form_validation->set_rules('usuario', 'Usuario', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $datos['mensaje_error'] = "Debe introducir todos los campos";
            // Si hay errores de validación o se han enviado los parámetros por defecto
            $this->mostrar_formulario($datos);
        } else {
            // Recepcion correcta de los datos, los recojo
            //recojo datos
            extract($this->input->post());

            $datos_usuario = $this->usuario_model->login($usuario, $this->encrypt->encode($password));

            if ($datos_usuario) {
                if($datos_usuario['tipo_usuario'] === 'administrador')
                    $administrador = true;
                else $administrador = false;
                if($datos_usuario['tipo_usuario'] === 'profesional')
                    $profesional = true;
                else $profesional = false;
                $datos_sesion = array(
                    'logged' => TRUE,
                    'id_usuario' => $datos_usuario['id'],
                    'administrador' => $administrador,
                    'profesional' => $profesional,
                    'email' => $datos_usuario['email'],
                    'usuario' => $datos_usuario['usuario']
                );

                $this->session->set_userdata($datos_sesion);
                // if($proveniencia == 'home')
                    // redirect('');
                // else
                    redirect('/admin/menu');
                // redirect('/inicio');
            } else {
                $datos['mensaje_error'] = 'No se han encontrado los datos de acceso';
                $this->mostrar_formulario($datos);
            }
        }
    }

     function mostrar_formulario($datos = '') {
        if($datos === '')$datos['mensaje_error']='';
         // $this->load->view('admin/header');
        $this->load->view('admin/login_reg_view', $datos);
        // $this->load->view('footer');
    }

    function logout() {
        $this->session->sess_destroy();
        // redirect('/inicio');
        redirect('/admin');
    }
}
/* End of file admin/acceso.php */
/* Location: ./application/controller/admin/acceso.php */