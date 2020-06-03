<?php

if (!function_exists('get_metadata')) {

    function get_metadata($variable) {
        // Cached response
        $CI = & get_instance();
        $CI->load->model('portal_model');

        $seo_data = $CI->portal_model->get_configuraciones($variable);

        //$seo_data = unserialize($this->curl->simple_get("http://www.portaleseroticos.com/metadata/get/" . NOMBRE_PORTAL_NOTACION_MINUSCULA));
        return $seo_data['valor'];
    }

}

if (!function_exists('get_imagen')) {

    function get_imagen($variable) {
        // Cached response
        $CI = & get_instance();
        $CI->load->model('portal_model');
        $imagen_data = $CI->portal_model->get_imagen($variable);
        return $imagen_data['imagen'];
    }

}

if (!function_exists('get_piepagina')) {

    function get_piepagina() {
        $CI = & get_instance();
        $CI->load->model('portal_model');
        $arrFooter = $CI->portal_model->get_footer();
        return $arrFooter;
    }

}

if (!function_exists('get_redes')) {

    function get_redes($variable) {
        // Cached response
        $CI = & get_instance();
        $CI->load->model('portal_model');

        $imagen_data = $CI->portal_model->get_redes($variable);

        //$seo_data = unserialize($this->curl->simple_get("http://www.portaleseroticos.com/metadata/get/" . NOMBRE_PORTAL_NOTACION_MINUSCULA));
        return $imagen_data;
    }

}
function obtener_imagenes() {
    // Cached response
    $CI = & get_instance();
    $CI->load->model('portal_model');
    $arrImagen = $CI->portal_model->m_obtener_imagenes();
    return $arrImagen;
}
/*=============================================================================================*/