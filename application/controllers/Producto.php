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
		$this->load->library('excel');
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

	public function upload_excel()
	{
		$arrData['message'] = 'Error al subir archivo';
    	$arrData['flag'] = 0;
    	$errors = array(
		    '0' => 'There is no error, the file uploaded with success',
		    '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		    '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		    '3' => 'The uploaded file was only partially uploaded',
		    '4' => 'No file was uploaded',
		    '6' => 'Missing a temporary folder',
		    '7' => 'Failed to write file to disk.',
		    '8' => 'A PHP extension stopped the file upload.',
		);
    	// var_dump($_FILES['file']); exit();
		if(!empty( $_FILES )  && isset($_FILES['file'])){
			$file_name = $_FILES['file']['name'];
		    $file_size =$_FILES['file']['size'];
		    $file_tmp =$_FILES['file']['tmp_name'];
		    $file_type=$_FILES['file']['type'];
		    $file_error=$_FILES['file']['error'];
		    if(!$file_tmp){
		    	$arrData['message'] = 'Temporal no existe';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		    if($file_error > 0){
		    	$arrData['message'] = $errors[$file_error];
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		 //    $inputFile = $_FILES['spreadsheet']['tmp_name'];
			// $extension = strtoupper(pathinfo($inputFile, PATHINFO_EXTENSION));
		    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		    $extensions_archivo = array("xls","xlsx");
		    $carpeta = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'temp';
		    $file_name = 'productos.'. $file_ext;
		    if(in_array($file_ext,$extensions_archivo)){
		    	move_uploaded_file($file_tmp, $carpeta . DIRECTORY_SEPARATOR . $file_name);
		    	$arrData = $this->registrar_productos_excel($carpeta . DIRECTORY_SEPARATOR . $file_name );
		    }else{
		    	$arrData['message'] = 'No es el formato correcto';
	    		$this->output
				    ->set_content_type('application/json')
				    ->set_output(json_encode($arrData));
				return;
		    }
		}
		// $arrData['message'] = 'Seleccione un archivo';
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	private function registrar_productos_excel($inputFile)
	{
		ini_set('xdebug.var_display_max_depth', 10);
	    ini_set('xdebug.var_display_max_children', 1024);
	    ini_set('xdebug.var_display_max_data', 1024);
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);

		$objPHPExcel = $objReader->load($inputFile);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$arrListado = array();
		foreach ($objWorksheet->getRowIterator() as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);

			$arrAux = array();
			$arrAdicional = array();
			foreach ($cellIterator as $cell) {
				$arrAux[] = $cell->getValue();
			}


			if( !empty($arrAux[0]) && !empty($arrAux[1]) ){
				array_push($arrListado, array(
					'descripcion_pr' => $arrAux[0],
					'idcategoria' => $arrAux[1],
					'alergenos' => empty($arrAux[2])? null: $arrAux[2],
					'precio' => empty($arrAux[3])? 0 : $arrAux[3],
					)
				);
			}
		}
		unset($arrListado[0]);



		$registro_exitoso = TRUE;

		$this->db->trans_begin();
		foreach ($arrListado as $row) {
			$data = array(
				'descripcion_pr' => strtoupper_total($row['descripcion_pr']),
				'idcategoria' => $row['idcategoria'],
				'alergenos' => $row['alergenos'],
				'precio' => $row['precio'],
				'createdat' => date('Y-m-d H:i:s'),
				'updatedat' => date('Y-m-d H:i:s')
			);

			if($idproducto = $this->model_producto->m_registrar($data)){

			}

			else{
	  			$registro_exitoso = FALSE;
	  		}
		}
		if ($this->db->trans_status() == FALSE || $registro_exitoso == FALSE){
			$this->db->trans_rollback();
			$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
	    	$arrData['flag'] = 0;
		}else{
			$this->db->trans_commit();
			$arrData['message'] = 'Se registraron los datos correctamente';
			$arrData['flag'] = 1;
		}

		// return $registro_exitoso;
		return $arrData;
	}

	public function listar_productos_demo()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		// $paramPaginate = $allInputs['paginate'];
		// $paramDatos = $allInputs['data'];

		$lista = $this->model_producto->m_cargar_productos_demo($allInputs);
		$arrListado = array();

		if(empty($lista)){
			$arrData['flag'] = 0;
			$arrData['datos'] = $arrListado;
    		// $arrData['paginate']['totalRows'] = 0;
			$arrData['message'] = 'No hay ningún producto registrado';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($arrData));
			return;
		}

		// $totalRows = $this->model_producto->m_count_productos($paramPaginate,$paramDatos);

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
    	// $arrData['paginate']['totalRows'] = $totalRows;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
}