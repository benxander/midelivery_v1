<?php

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        $input = fopen("php://input", "r");
        $temp = tmpfile();
        $realSize = stream_copy_to_stream($input, $temp);
        fclose($input);

        if ($realSize != $this->getSize()) {
            return false;
        }

        $target = fopen($path, "w");
        fseek($temp, 0, SEEK_SET);
        stream_copy_to_stream($temp, $target);
        fclose($target);

        return true;
    }

    function getName() {
        return $_GET['qqfile'];
    }

    function getSize() {
        if (isset($_SERVER["CONTENT_LENGTH"])) {
            return (int) $_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('No es posible determinar el tamaño del archivo.');
        }
    }

}

/**
 * Handle file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {

    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
    function save($path) {
        if (!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)) {
            return false;
        }
        return true;
    }

    function getName() {
        return $_FILES['qqfile']['name'];
    }

    function getSize() {
        return $_FILES['qqfile']['size'];
    }

}

class qqFileUploader {

    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {

        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        $this->checkServerSettings();

        if (isset($_GET['qqfile'])) {
            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new qqUploadedFileForm();
        } else {
            $this->file = false;
        }
    }

    private function checkServerSettings() {
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));

        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
            die("{'error':'incremente los valores post_max_size y upload_max_filesize a $size'}");
        }
    }

    private function toBytes($str) {
        $val = trim($str);
        $last = strtolower($str[strlen($str) - 1]);
        switch ($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE) {
        if (!is_writable($uploadDirectory)) {
			
            return array('error' => "Error del servidor. La carpeta de subida no tiene permisos de escritura.");
        }

        if (!$this->file) {
            return array('error' => 'No se subió ningún archivo.');
        }

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => 'El archivo está vacío.');
        }

        if ($size > $this->sizeLimit) {
            return array('error' => 'El archivo es demasiado pesado.');
        }

        $pathinfo = pathinfo($this->file->getName());

        // Fix para definir $pathinfo['filename'], disponible a partir de PHP 5.2.0
        if (!isset($pathinfo['filename'])) {
            $pathinfo['filename'] = substr($pathinfo['basename'], 0, strpos($pathinfo['basename'], '.'));
        }
        //$filename = $pathinfo['filename'];

        $filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'El archivo no tiene una extensión válida. Debería ser una de las siguientes: ' . $these . '.');
        }

        if (!$replaceOldFile) {
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)) {

            $CI = & get_instance();
            $CI->load->library('image_lib');

            //Create 100px unwatermarked thumbnail
            $config = array();
            $config['source_image'] = $uploadDirectory . $filename . '.' . $ext;
            $config['new_image'] = $uploadDirectory . 'thumbs/' . $filename . '.' . $ext;
            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = TRUE;
            $config['create_thumb'] = FALSE;   // Tells it to make a copy called *_thumb.*
            $config['width'] = 100;
            $config['height'] = 100;
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
            unset($config);

            //Create 600px unwatermarked 
            $config = array();
            $config['source_image'] = $uploadDirectory . $filename . '.' . $ext;
            $config['new_image'] = $uploadDirectory . 'anuncios/' . $filename . '.' . $ext;
            $config['image_library'] = 'gd2';
            $config['maintain_ratio'] = TRUE;
            $config['create_thumb'] = FALSE;   // Tells it to make a copy called *_thumb.*
            $config['width'] = 600;
            $config['height'] = 1000;
            $config['master_dim'] = "auto";
            $CI->image_lib->initialize($config);
            $CI->image_lib->resize();
            $CI->image_lib->clear();
            unset($config);

            // Metemos la marca de agua izquierda superior

            $size = GetImageSize($uploadDirectory . 'anuncios/' . $filename . '.' . $ext);

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $uploadDirectory . 'anuncios/' . $filename . '.' . $ext;
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = './images/watermark.png';
            $config['wm_opacity'] = 100;
            $config['wm_vrt_alignment'] = 'top';
            $config['wm_hor_alignment'] = 'left';
            $CI->image_lib->initialize($config);
            $CI->image_lib->watermark();
            $CI->image_lib->clear();
            unset($config);

            // Metemos la marca de agua derecha inferior

            $size = GetImageSize($uploadDirectory . 'anuncios/' . $filename . '.' . $ext);

            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $uploadDirectory . 'anuncios/' . $filename . '.' . $ext;
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = './images/watermark.png';
            $config['wm_opacity'] = 100;
            $config['wm_vrt_alignment'] = 'bottom';
            $config['wm_hor_alignment'] = 'right';
            $CI->image_lib->initialize($config);
            $CI->image_lib->watermark();
            $CI->image_lib->clear();
            unset($config);

            // Eliminamos la original 
            unlink($uploadDirectory . $filename . '.' . $ext);

            return array('success' => true, 'filename' => $filename . '.' . $ext);
        } else {
            return array('error' => 'No se pudo guardar el archivo subido.' .
                'La subida se canceló u ocurrió un error en el servidor.');
        }
    }
}