<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        // Se le asigna a la informacion a la variable $sessionVP.
        $this->sessionVP = @$this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
        $this->load->helper(array('fechas','otros','imagen'));
        $this->load->model(array('model_empresa','model_categoria'));
    }

	/**
	 * Método para listar todas las empresas registradas.
	 * Se usa en la vist principal de Mantenimiento de Empresas.
	 *
	 * @since 1.0.0 18-07-2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 * @return void
	 */
	public function listar_empresas()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$paramPaginate = $allInputs['paginate'];

		$lista = $this->model_empresa->m_cargar_empresas($paramPaginate);
		$arrListado = array();

		if(empty($lista)){
			$arrData['flag'] = 0;
			$arrData['datos'] = $arrListado;
    		$arrData['paginate']['totalRows'] = 0;
			$arrData['message'] = 'No hay ninguna empresa registrada';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($arrData));
		}

		$totalRows = $this->model_empresa->m_count_empresas($paramPaginate);

		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'idempresa' 		=> $row['idempresa'],
					'nombre_negocio' 	=> $row['nombre_negocio'],
					'razon_social' 		=> $row['razon_social'],
					'telefono' 			=> $row['telefono'],
					'contacto' 			=> $row['contacto'],
					'email' 			=> $row['email'],
					'idtipopago' 		=> $row['idtipopago'],
					'idplan' 			=> $row['idplan'],
					'estado_emp' 		=> $row['estado_emp'],
					'codigo_postal' 	=> $row['codigo_postal'],
					'dni_cif' 			=> $row['dni_cif'],
					'direccion' 		=> $row['direccion'],
					'idusuario' 		=> $row['idusuario'],
					'usuario' 			=> $row['username'],
					'descripcion_pl'	=> $row['descripcion_pl'],
					'descripcion_tp'	=> $row['descripcion_tp']
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
	/**
	 * Undocumented function

	 */
	public function listar_empresa_cbo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_empresa->m_cargar_empresa_cbo();
		$arrListado = array();
		foreach ($lista as $row) {
			array_push($arrListado,
				array(
					'id' => $row['idempresa'],
					'descripcion' => $row['nombre_comercial'],
				)
			);
		}

    	$arrData['datos'] = $arrListado;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		if(empty($lista)){
			$arrData['flag'] = 0;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	// MANTENIMIENTO
	public function registrar_empresa()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// AQUI ESTARAN LAS VALIDACIONES

    	// INICIA EL REGISTRO

		$data = array(
			'nombre_negocio' => strtolower_total($allInputs['nombre_negocio']),
			'razon_social' => strtoupper_total($allInputs['razon_social']),
			'telefono' => empty($allInputs['telefono'])? NULL : $allInputs['telefono'],
			'contacto' => empty($allInputs['contacto'])? NULL : $allInputs['contacto'],
			'idusuario' => empty($allInputs['idusuario'])? NULL : $allInputs['idusuario'],
			'codigo_postal' => $allInputs['codigo_postal'],
			'dni_cif' => $allInputs['dni_cif'],
			'direccion' => $allInputs['direccion'],
			'idtipopago' => $allInputs['tipo_pago']['id'],
			'idplan' => $allInputs['plan']['id'],
			'createdAt' => date('Y-m-d H:i:s'),
			'updatedAt' => date('Y-m-d H:i:s')
		);

		if($this->model_empresa->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
    		$arrData['flag'] = 1;
    		// $arrData['idempresa'] = GetLastId('idempresa','empresa');
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function editar_empresa(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		$data = array(
			'nombre_negocio' => strtolower_total($allInputs['nombre_negocio']),
			'razon_social' => strtoupper_total($allInputs['razon_social']),
			'telefono' => empty($allInputs['telefono'])? NULL : $allInputs['telefono'],
			'contacto' => empty($allInputs['contacto'])? NULL : $allInputs['contacto'],
			'idusuario' => empty($allInputs['idusuario'])? NULL : $allInputs['idusuario'],
			'codigo_postal' => $allInputs['codigo_postal'],
			'dni_cif' => $allInputs['dni_cif'],
			'direccion' => $allInputs['direccion'],
			'idtipopago' => $allInputs['tipo_pago']['id'],
			'idplan' => $allInputs['plan']['id'],
			'updatedAt' => date('Y-m-d H:i:s')
		);

		if($this->model_empresa->m_editar($data,$allInputs['idempresa'])){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	public function anular_empresa(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al anular los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// var_dump($allInputs); exit();
		if($this->model_empresa->m_anular($allInputs)){
			$arrData['message'] = 'Se anularon los datos correctamente';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	/** CARTA DIGITAL
	 *
	 * @Creado: 09/09/2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 */

	public function carta_digital($negocio)
	{


		$arrEmpresa = $this->model_empresa->m_cargar_empresa_por_negocio($negocio);

		$arrCartaDigital = $this->model_empresa->m_cargar_carta_digital($arrEmpresa);

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

		$datos = array(
			'nombre_negocio' => $negocio,
			'razon_social'	=> $arrEmpresa['razon_social'],
			'telefono'	=> $arrEmpresa['telefono'],
			'categoria_carta' => $arrCategoria
		);
		if($arrEmpresa['modelo_carta'] == 2){
			$this->load->view('carta_digital2_view',$datos);
		}else{
			$this->load->view('carta_digital_view',$datos);
		}
	}

	public function guardar_apariencia()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$data = array(
			'modelo_carta' => $allInputs['modelo'],
			'idcolor' => $allInputs['idcolor']
		);

		$idempresa = $this->sessionVP['idempresa'];

		if($this->model_empresa->m_editar($data, $idempresa)){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}



		$arrData['message'] = 'Se registraron los datos correctamente';
    	$arrData['flag'] = 1;

		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function cargar_colores()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_empresa->m_cargar_colores();

		$arrData['datos'] = $lista;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	/** CARTAS DEMO
	 *
	 * @Creado: 05/11/2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 */

	public function listar_cartas_demo()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_empresa->m_cargar_cartas_demo();

		$arrData['datos'] = $lista;
		$arrData['paginate']['totalRows'] = count($lista);
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	/** CATEGORIAS DEMO
	 *
	 * @Creado: 07/11/2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 */

	public function listar_categorias_demo()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$lista = $this->model_empresa->m_cargar_categorias_demo($allInputs);

		$arrData['datos'] = $lista;
    	$arrData['message'] = '';
    	$arrData['flag'] = 1;
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}
	/** AGREGAR CATEGORIA DEMO
	 *
	 * @Creado: 07/11/2020
	 * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
	 */

	public function agregar_categoria_demo()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al registrar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;
    	// AQUI ESTARAN LAS VALIDACIONES
		if(empty($allInputs['categoria'])){
			$arrData['message'] = 'Debe ingresar un nombre de categoria';
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($arrData));
			return;
		}
    	// INICIA EL REGISTRO

		$data = array(
			'idempresa' =>$allInputs['idempresa'],
			'descripcion_cat' => strtoupper_total($allInputs['categoria']),
			'imagen_cat' => null,
			'createdat' => date('Y-m-d H:i:s'),
			'updatedat' => date('Y-m-d H:i:s')
		);

		if($idcategoria = $this->model_categoria->m_registrar($data)){
			$arrData['message'] = 'Se registraron los datos correctamente';
			$arrData['datos'] = $idcategoria;
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

	public function editar_carta_demo(){
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);
		$arrData['message'] = 'Error al editar los datos, inténtelo nuevamente';
    	$arrData['flag'] = 0;

		$data = array(
			'nombre_negocio' => strtolower_total($allInputs['nombre_negocio']),
			'razon_social' => strtoupper_total($allInputs['razon_social']),
			'modelo_carta' => $allInputs['modeloObj']['id'],
			'idcolor' => $allInputs['colorObj']['idcolor'],
			'updatedAt' => date('Y-m-d H:i:s')
		);

		if($this->model_empresa->m_editar($data,$allInputs['idempresa'])){
			$arrData['message'] = 'Se editaron los datos correctamente ';
    		$arrData['flag'] = 1;
		}
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($arrData));
	}

}