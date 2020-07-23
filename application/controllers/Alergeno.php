<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alergeno extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionVP = @$this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
        $this->load->helper(array('otros'));
        $this->load->model(array('model_alergeno'));
    }

	/**
	 * Método para listar todas los alergenos de ley que deben estar en los platos.
	 * Se usa en la vista principal de Mantenimiento de Alergenos.
	 *
	 * @since 1.0.0 22-07-2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	public function listar_alergenos()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];

		$lista = $this->model_alergeno->m_cargar_alergenos($paramPaginate);
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

		$totalRows = $this->model_alergeno->m_count_alergenos($paramPaginate);

		foreach ($lista as $row) {
			if(empty($row['icono'])){
				$icono = '../images/sin_foto.jpg';
			}else{
				$icono = '../images/alergenos/' . $row['icono'];
			}
			array_push($arrListado,
				array(
					'idalergeno' 	=> $row['idalergeno'],
					'nombre' 		=> $row['nombre'],
					'descripcion' 	=> $row['descripcion'],
					'icono' 		=> $icono,
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
}