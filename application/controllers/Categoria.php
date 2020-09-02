<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionVP = @$this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
        $this->load->helper(array('otros'));
        $this->load->model(array('model_categoria'));
    }

	/**
	 * Método para listar todas las categorias de una carta digital.
	 * Se usa en la vista principal de Mantenimiento de Categorias.
	 *
	 * @since 1.0.0 22-07-2020
	 * @pdated 01-09-2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	public function listar_categorias()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];

		$lista = $this->model_categoria->m_cargar_categorias($paramPaginate);
		$arrListado = array();

		if(empty($lista)){
			$arrData['flag'] = 0;
			$arrData['datos'] = $arrListado;
    		$arrData['paginate']['totalRows'] = 0;
			$arrData['message'] = 'No hay ninguna categoria registrada';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($arrData));
			return;
		}

		$totalRows = $this->model_categoria->m_count_categorias($paramPaginate);

		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idcategoria' 		=> $row['idcategoria'],
					'descripcion_cat' 	=> $row['descripcion_cat'],
					'imagen_cat' 		=> $row['imagen_cat'],
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
	public function registrar_categoria()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;


    	// INICIA EL REGISTRO
		$data = array(
			'idempresa' => $this->sessionVP['idempresa'],
			'descripcion_cat' => strtoupper_total($allInputs['descripcion_cat']),
			'imagen_cat' => null,
			'createdat' => date('Y-m-d H:i:s'),
			'updatedat' => date('Y-m-d H:i:s')
		);

		if($idcategoria = $this->model_categoria->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
			$arrData['datos'] = $idcategoria;
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
	public function editar_categoria(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		$data = array(
			'descripcion_cat' => strtoupper_total($allInputs['descripcion_cat']),
			'imagen_cat' => null,
			'updatedat' => date('Y-m-d H:i:s')
		);

		if($this->model_categoria->m_editar($data,$allInputs['idcategoria'])){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_categoria(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if($this->model_categoria->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}