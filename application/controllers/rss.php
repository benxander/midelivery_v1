<?
class RSS extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //Cargamos los helpers necesarios
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('xml');
        //Cargamos el modelo
        $this->load->model('blog_model');
    }

    function index() {
        $datos['encoding'] = 'utf-8';
        $datos['nombre_feed'] = 'Novedades de '.NOMBRE_PORTAL_NOTACION_URL;
        $datos['url_feed'] = site_url('rss');
        $datos['descripcion'] = 'Anuncios RSS';
        $datos['lenguaje'] = 'es-es';
        $datos['autor'] = NOMBRE_PORTAL_NOTACION_URL;
        $datos['articulos'] = $this->blog_model->m_obtener_ultimas_noticias();
        //var_dump($datos['articulos']); exit();
        header("Content-Type: application/rss+xml");
        $this->load->view('feed', $datos);
    }
}
//=========================================