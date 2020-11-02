<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionVP = @$this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
        $this->load->helper(array('otros'));
        $this->load->model(array('model_producto'));
    }

	/**
	 * Método para listar todos los productos de una carta digital.
	 * Se usa en la vista principal de Mantenimiento de Productos.
	 *
	 * @since 1.0.0 1-09-2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	public function listar_productos()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];
		$paramDatos = $allInputs['data'];

		$lista = $this->model_producto->m_cargar_productos($paramPaginate,$paramDatos);
		$arrListado = array();

		if(empty($lista)){
			$arrData['flag'] = 0;
			$arrData['datos'] = $arrListado;
    		$arrData['paginate']['totalRows'] = 0;
			$arrData['message'] = 'No hay ningún producto registrado';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($arrData));
			return;
		}

		$totalRows = $this->model_producto->m_count_productos($paramPaginate,$paramDatos);

		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idproducto' 		=> $row['idproducto'],
					'descripcion_pr' 	=> $row['descripcion_pr'],
					'idcategoria' 		=> $row['idcategoria'],
					'descripcion_cat' 	=> $row['descripcion_cat'],
					'alergenos'			=> explode(",", $row['alergenos']),
					'precio' 			=> $row['precio'],
					'categoria' 	=> array(
						'idcategoria' => $row['idcategoria'],
						'descripcion' => $row['descripcion_cat'],
					),
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
	public function registrar_producto()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;


    	// INICIA EL REGISTRO
		$data = array(
			'descripcion_pr' => strtoupper_total($allInputs['descripcion_pr']),
			'idcategoria' => $allInputs['categoria']['id'],
			'alergenos' => implode(",",$allInputs['alergenos']),
			'precio' => $allInputs['precio'],
			'createdat' => date('Y-m-d H:i:s'),
			'updatedat' => date('Y-m-d H:i:s')
		);

		if($idproducto = $this->model_producto->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
			$arrData['datos'] = $idproducto;
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
	public function editar_producto(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		$data = array(
			'descripcion_pr' => strtoupper_total($allInputs['descripcion_pr']),
			'idcategoria' => $allInputs['categoria']['id'],
			'precio' => $allInputs['precio'],
			'alergenos' => implode(",",$allInputs['alergenos']),
			'updatedat' => date('Y-m-d H:i:s')
		);

		if($this->model_producto->m_editar($data,$allInputs['idproducto'])){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_producto(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		if($this->model_producto->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}