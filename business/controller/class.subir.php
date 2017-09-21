<?php

//print_r($_SERVER);

include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/controller/class.cabeceras.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SubirMultimedia extends Cabeceras {
    
    private $_imagen_folder = 'uploads/';
    private $_formatos_autorizados = array('audio/mp3');
   

    public static function run() {
        try{
            $funcion = isset($_POST['funcion']) ? $_POST['funcion'] : NULL;
            switch ($funcion){
                case 1:$_obj = new self();
                    $_obj->_subirArchivo(isset($_FILES[$_POST['archivo_multi']]) ? $_FILES[$_POST['archivo_multi']] : NULL );
                break;
                default :
                    throw new SubirMultimediaException(-3);
            }
            
        } catch(SubirMultimediaException $e) {
            $_obj->cabeceras();
            echo json_encode(array(
                'cod_respuesta' => 0,
                'mensaje' => $e->getMessage(),
                'data' => NULL
            ));
            return ;
        }
        $_obj->cabeceras();
        echo json_encode(array(
            'cod_respuesta' => 1,
            'mensaje' => 'archivo subido correctamente',
            'data' => NULL
        ));
        return ;
    }
    
   
    /**
     * 
     * @param type $_file
     * @return boolean|string donde queda guardado
     * @throws SubirMultimediaException
     */
    protected function _subirArchivo($_file) {
        if(empty($_file)){
            throw new SubirMultimediaException(UPLOAD_ERR_NO_FILE);
        }
        $uiq = uniqid();
        $uploaded = false;
        if ($_file['error'] == 0) {
            if(!in_array($_file['type'], $this->_formatos_autorizados)) {
                throw new SubirMultimediaException(-2);
            }
            if(!move_uploaded_file($_file['tmp_name'], $this->_imagen_folder . $_file['name'])){
                throw new SubirMultimediaException(-1);
            }
            return $this->_imagen_folder . $_file['name'];
        }
        throw new SubirMultimediaException($_file['error']);
    }

}
class SubirMultimediaException extends Exception{
    public function __construct($codError) {
        parent::__construct($this->_mensajeError($codError),0);
    }
    /**
     * Mensajes de error para exception
     * @param type $codError
     * @return string
     */
    private function _mensajeError($codError) {
        switch ($codError) { 
            case -3:
                $mensaje = 'Parámetros incorrectos';
                break;
            case -2:
                $mensaje = "Archivo no autorizado";
                break;
            case -1:
                $mensaje = "No se pudo almacenar archivo multimedia";
                break;
            case UPLOAD_ERR_INI_SIZE: 
                $mensaje = "Tamaño del archivo exede la directiva upload_max_filesize en php.ini"; 
                break; 
            case UPLOAD_ERR_FORM_SIZE: 
                $mensaje = "Tamaño del archivo excede la directiva MAX_FILE_SIZE especificada en el formulario";
                break; 
            case UPLOAD_ERR_PARTIAL: 
                $mensaje = "El archivo fue parcialmente cargado"; 
                break; 
            case UPLOAD_ERR_NO_FILE: 
                $mensaje = "ningún archivo ha sido cargado"; 
                break; 
            case UPLOAD_ERR_NO_TMP_DIR: 
                $mensaje = "No se encuentra carpeta temporal"; 
                break; 
            case UPLOAD_ERR_CANT_WRITE: 
                $mensaje = "Error al escribir el archivo en el disco"; 
                break; 
            case UPLOAD_ERR_EXTENSION: 
                $mensaje = "Carga parada por extención"; 
                break; 

            default: 
                $mensaje = "Error desconocido"; 
                break; 
        } 
        return $mensaje;
    }
}

