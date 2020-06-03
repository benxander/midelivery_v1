<?php
class Usuario_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_usuarios() {
        //Funcion que recoge todos los labels (excepto los que tengan usuario Administrador

        $data = array();

        //$res = mysql_query("SELECT L.*,P.nombre as plan_name,P.image as plan_image FROM label AS L INNER JOIN plan as P ON L.plan = P.id WHERE L.administrador = 0 ORDER BY L.activo DESC, L.record_label ASC ");
        $res = mysql_query("SELECT * FROM usuarios");

        while ($row = mysql_fetch_array($res)) {
            $data[] = $row;
        }

        return $data;

        //Devuelve un array con todos los usuarios y dentro de ese array todos los valores de los campos de la base de datos
    }

    function get_usuario($id) {
        //Funcion que recoge todos los usuarios del un cliente
        $sql = "SELECT * FROM usuarios where id = " . $id;
        //$sql = "SELECT L.*,P.nombre as plan_name,P.image as plan_image FROM label AS L INNER JOIN plan as P ON L.plan = P.id WHERE L.id = ?";
        $res = $this->db->query($sql, $id);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0];
        } else {
            return 0;
        }

        //Devuelve un array con todos los usuarios y dentro de ese array todos los valores de los campos de la base de datos
    }

    function get_nombre($id_usuario) {
        $sql = "SELECT usuario FROM usuarios WHERE id = " . $id_usuario;
        $res = $this->db->query($sql);

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            return $rows[0]['usuario'];
        } else {
            return 0;
        }
    }

    function login($usuario, $password) {
        //Funcion donde comprueba que el usuario existe.

        $sql = "SELECT * FROM usuarios WHERE (usuario = ? OR email = ? ) AND activo = 1";
        // El password ya se envía encriptado
        $res = $this->db->query($sql, array($usuario, $usuario));

        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            // Ahora es la clave que puede poder desencriptarse, pero no es inyectiva, cada vez varía
            if ($this->encrypt->decode($rows[0]['password']) == $this->encrypt->decode($password)) {
                $sql = "INSERT INTO sesion(usuario) VALUES('" . $usuario . "')";
                $res = $this->db->query($sql);
                return $rows[0];
            }
            else
                return 0;
        } else {
            return 0;
        }
        //Devuelve el array con los datos del usuario si el login fue bien, si no devuelve un 0
    }
	//=================================================================================================
	// CREA UN NUEVO USUARIO
	//=================================================================================================	
    function insertar($datos) {
        //Funcion que crea un nuevo usuario con los campos pasados
        extract($datos);

        //Funcion que inserta un nuevo anuncio en la base de datos

        $ip = $this->input->ip_address();

        $lista_campos = '(';
        $lista_valores = 'VALUES(';

        foreach ($datos as $nombre => $valor) {
            if ($nombre != 'repassword' && $nombre != 'terminos_y_condiciones') {

                $lista_campos .= $nombre . ",";

                if ($nombre == 'password'){
                    $password_encriptado = $this->encrypt->encode($valor);
                    $lista_valores .= "'" . $password_encriptado . "',";
                }
                else
                    $lista_valores .= "'" . $this->db->escape_str($valor) . "',";
            }
        }

        $lista_campos .= "ip)";
        $lista_valores .= "'" . $ip . "')";

        $sql = "INSERT INTO usuarios" . $lista_campos . " " . $lista_valores;

        $resConsulta = $this->db->query($sql);

        if ($resConsulta)
            return $password_encriptado;
        else
            return 0;
        //Devuelve 0 si hubo un error y 1 si fue existosa
    }
	//=================================================================================================
	// ACTIVA EL REGISTRO DE USUARIO
	//=================================================================================================	

    function confirmacion_registro_usuario($usuario, $password) {
        //Funcion donde comprueba que el usuario existe.

        $sql = "SELECT * FROM usuarios WHERE MD5(usuario) = ? AND MD5(password) = ?";
        // El password ya se envía encriptado
        $res = $this->db->query($sql, array($usuario, $password));
        
        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            // Ahora es la clave que puede poder desencriptarse, pero no es inyectiva, cada vez varía

            $sql = "UPDATE usuarios SET activo = 1 WHERE id = '" . $rows[0]['id'] . "'";
            $res = $this->db->query($sql);
            return $rows[0];
        } else {
            return 0;
        }
    }
    
    function recuperar_password($usuario) {
        //Funcion donde comprueba que el usuario existe.

        $sql = "SELECT password FROM usuarios WHERE usuario = ? AND activo = 1";
        // El password ya se envía encriptado
        $res = $this->db->query($sql, array($usuario));
        
        if ($res->num_rows() > 0) {
            $rows = $res->result_array();
            // Ahora es la clave que puede poder desencriptarse, pero no es inyectiva, cada vez varía
            return $rows[0]['password'];
        } else {
            return 0;
        }
    }
	// ============================================================================================
	// INSERTAR SUSCRIPTORES
	// ============================================================================================			
	function insertar_suscriptor($email){
		$this->db->where('email',$email);
		$res = $this->db->get('suscriptores');
		if ($res->num_rows() > 0) {
          
           return 0; // ya existe
        } else {
            $data = array(
				   'email' => $email ,
				   'categoria' => '0'
				);
			if($this->db->insert('suscriptores', $data) )
				return true;
        }
	}
	// ============================================================================================
	// OBTENER SUSCRIPTORES
	// ============================================================================================		
	function get_suscriptores($email){
		$data = array();
		$this->db->where('email !=', $email);
        $res = $this->db->get('suscriptores');

        // while ($row = mysql_fetch_array($res)) {
		foreach($res->result_array() as $row){
			$data[] = $row;
        }

        return $data;
    }
	// ============================================================================================
	// Verificar si existe el usuario con el email $email y enviar el id
	// ============================================================================================	
	function verificar_usuario($email){
		$this->db->where('email',$email);
		$res = $this->db->get('usuarios');
		if ($res->num_rows() > 0) {
           $rows = $res->result_array();
           return $rows[0]['id'];
        } else {
            return 0;
        }
	}
	// ============================================================================================
	// Verificar si existe el usuario con el usuario $usuario y enviar el id
	// ============================================================================================	
	function verificar_usuario_duplicado($usuario,$id){
		$this->db->where('id <>',$id);
		$this->db->where('usuario',$usuario);
		$res = $this->db->get('usuarios');
		if ($res->num_rows() > 0) {
           $rows = $res->result_array();
           return $rows[0]['id'];
        } else {
            return 0;
        }
	}
	function insertar_usuario($email,$password_code){
		$data = array(
		   'usuario' => $email ,
		   'email' => $email ,
		   'password' => $password_code,
		   'activo' => '1'
        );

		$this->db->insert('usuarios', $data); 
		return $this->db->insert_id();
	}
	
}

/***********************fin*************************************/