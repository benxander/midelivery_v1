<?php

if (!function_exists('get_modulo_fichas')) {

    function get_modulo_fichas() {
        // Cached response
        $CI = & get_instance();
        $CI->load->model('ficha_model');

        $lista = $CI->ficha_model->m_listar_modulo_fichas();
        $arrPrincipal = array();
        foreach ($lista as $row) {
            $arrPrincipal[$row['idmodulo']] = array(
                'idmodulo' => $row['idmodulo'],
                'modulo' => $row['modulo'],
                'fichas' => array()
             );


        }
        foreach ($lista as $row) {
            if( $row['idficha'] != NULL ){
                array_push($arrPrincipal[$row['idmodulo']]['fichas'], array(
                    'idficha' => $row['idficha'],
                    'titulo' => $row['titulo'],
                    )
                );
            }

        }

        return $arrPrincipal;
    }
    function get_modulo_categorias() {
        // Cached response
        $CI = & get_instance();
        $CI->load->model('ficha_model');

        $lista = $CI->ficha_model->m_listar_modulos_menu();
        $arrPrincipal = array();
        foreach ($lista as $row) {
            $arrPrincipal[$row['idmodulo']] = array(
                'idmodulo' => $row['idmodulo'],
                'modulo' => $row['modulo'],
                'segmento_modulo'=> $row['segmento_modulo'],
                'categorias' => array()
             );


        }
        foreach ($lista as $row) {
            if( $row['idcategoria'] != NULL ){
                array_push($arrPrincipal[$row['idmodulo']]['categorias'], array(
                    'idcategoria' => $row['idcategoria'],
                    'segmento_categoria'=> $row['segmento_categoria'],
	                'categoria' => $row['categoria'],
	        		)
	        	);
        	}

        }

        return $arrPrincipal;
    }

}