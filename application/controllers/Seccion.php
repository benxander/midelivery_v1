<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seccion extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionVP = @$this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
        $this->load->helper(array('otros'));
        $this->load->model(array('model_seccion'));
    }

	/**
	 * Método para listar todas las secciones de una carta digital.
	 * Se usa en la vista principal de Mantenimiento de Secciones.
	 *
	 * @since 1.0.0 22-07-2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	public function listar_secciones()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];

		$lista = $this->model_seccion->m_cargar_secciones($paramPaginate);
		$arrListado = array();

		if(empty($lista)){
			$arrData['flag'] = 0;
			$arrData['datos'] = $arrListado;
    		$arrData['paginate']['totalRows'] = 0;
			$arrData['message'] = 'No hay ninguna sección registrada';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($arrData));
		}

		$totalRows = $this->model_seccion->m_count_secciones($paramPaginate);

		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idseccion' 		=> $row['idseccion'],
					'descripcion_sec' 	=> $row['descripcion_sec'],
					'imagen_sec' 		=> $row['imagen_sec'],
				)
			);
		}

    	$arrData['datos'] = $arrListado;
    	$arrData['paginate']['totalRows'] = $totalRows;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	// MANTENIMIENTO
	public function registrar_seccion()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;


    	// INICIA EL REGISTRO
		$data = array(
			'descripcion_sec' => strtoupper_total($allInputs['descripcion_sec']),
			'imagen_sec' => null
		);

		if($idseccion = $this->model_seccion->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
			$arrData['datos'] = $idseccion;
    		$arrData['flag'] = 1;
		}else{
			$arrData['message'] = 'Ocurrió un error. Inténtelo nuevamente';
			$arrData['datos'] = null;
    		$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_seccion(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		$data = array(
			'descripcion_sec' => strtoupper_total($allInputs['descripcion_sec']),
			'imagen_sec' => null
		);

		if($this->model_seccion->m_editar($data,$allInputs['idseccion'])){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_seccion(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if($this->model_seccion->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}