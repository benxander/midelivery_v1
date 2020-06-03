<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Extension of email helper
 *
 * Send an SMTP email
 *
 * @access	public
 * @return	bool
 */
if (!function_exists('envio_email')) {

    function envio_email($to,$cc='', $subject = 'Email de prueba', $message = 'Esto es una prueba',$from=EMAIL) {

        $CI = & get_instance();

        $CI->load->library('email');
        $CI->load->helper('metadata_helper');

        $salida = $CI->load->view('notificaciones/plantilla',array(),TRUE);

        $CI->email->from($from, NOMBRE_PORTAL);
        $CI->email->to($to);
		$CI->email->cc($cc);
        $CI->email->subject($subject);
        $CI->email->message(str_replace("{contenido}", $message, $salida));

        return $CI->email->send();
    }

}

/* End of file MY_email_helper.php */
/* Location: ./application/helpers/MY_email_helper.php */
?>
