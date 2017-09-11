<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/DAO/DAO_TemasFundamentales.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/DAO/DAO_Textos.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/controller/class.cabeceras.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/class.mtablas.php';


class ControladorEudista extends Cabeceras {
    
    
    private $_solicitud;
    private $_id_usuario = 1;

    public function __construct() {
        ;
    }
    /**
     * Arranca el servicio
     */
    public static function run(){
        try{
            $obj = new self();
            $obj->_solicitud = json_encode($_POST);
            $return = NULL;
            //print_r($obj->_solicitud);
            switch(isset($_REQUEST['funcion']) ? $_REQUEST['funcion'] : null){
                case 1: // consultar temas fundamentales
                    
                    break;
                case 2: // guardar temas fundamentales
                    
                    break;
                case 6: // consultar familia eudista
                    $return = $obj->_listaProductos((isset($_REQUEST['id_sucursal']) ? $_REQUEST['id_sucursal'] : 0 ), (isset($_REQUEST['prod_clasificacion']) ? $_REQUEST['prod_clasificacion'] : 5 ));
                break;
                case 7: // guardar familia eudista
                    //$return = $obj->
                     break;

            }
            $respuesta = array(
		'cod_respuesta' => 1,
		'mensaje'  => "OK",
		'data' => $return // // establece datos entregados por web service y busca codigo
	    );
        } catch (ControladorEudistaException $ex) {
            $respuesta = array(
		'cod_respuesta' => $ex->getCode(),
		'mensaje' => $ex->getMessage(),
		'data' => ''
	    );
        }
        $response = json_encode($respuesta);
        //$obj->_registrarSoicitud($response);
        $obj->cabeceras();
        echo $response;
    }
    /**
     * 
     */
    private function _guardarTemasFundamentales() {
        $_objTemas = new DAO_TemasFundamentales();
        $con = ConexionSQL::getInstance();
        $con->begin();  
        if(isset($_REQUEST['temf_id']) && empty($_REQUEST['temf_id'])) {
            $_objTemas->set_temf_id($_REQUEST['temf_id']);
            $_objTemas->set_id_usuario($this->_id_usuario);
            $_objTemas->set_temf_estado(1);
            $_objTemas->set_temf_orden($_REQUEST['temf_orden']);
            if(!$_objTemas->guardar()){
                $con->rollback();
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales",0);
            }
        } else {
            $_objTemas->set_temf_id($_REQUEST['temf_id']);
            $_objTemas->consultar();
        }
        // consultar el codigo del lenguaje
        $_objMTablas = new MTablas();   
        $lenguajes = $_objMTablas->getTablaCheckBox(4);
        $codLang = null;
        foreach($lenguajes as $id => $langISO){
            if($langISO == $_POST['lang']){
                $codLang = $id;
                break;
            }
        }
        // guardar datos en textos (Titulo)
        $_objTextos = new DAO_Textos();
        if(isset($_POST['lang_id_titulo']) && !empty($_POST['lang_id_titulo'])){
            $_objTextos->set_lang_id($_POST['lang_id']);
        }
        $_objTextos->set_lang_id_tbl($_objTemas->get_temf_id());
        $_objTextos->set_lang_tbl($_objTemas->getTabla());
        $_objTextos->set_lang_lengua($codLang);
        $_objTextos->set_lang_seccion("titulo");
        $_objTextos->set_lang_texto($_POST['funda_titulo']);
        if(!$_objTextos->guardar()){
            $con->rollback();
            throw new ControladorEudistaException("No se pudo almacenar Titulo Temas Fundamentales ",0);
        }
        $_objTextosDesc = new DAO_Textos();
        if(isset($_POST['lang_id_desc']) && !empty($_POST['lang_id_desc'])){
            $_objTextosDesc->set_lang_id($_POST['lang_id']);
        }
        $_objTextosDesc->set_lang_id_tbl($_objTemas->get_temf_id());
        $_objTextosDesc->set_lang_tbl($_objTemas->getTabla());
        $_objTextosDesc->set_lang_lengua($codLang);
        $_objTextosDesc->set_lang_seccion("titulo");
        $_objTextosDesc->set_lang_texto($_POST['funda_desc']);
        if(!$_objTextosDesc->guardar()){
            $con->rollback();
            throw new ControladorEudistaException("No se pudo almacenar Desc Temas Fundamentales ",0);
        }
    }
    
    private function _guardarFamiliaEudista() {
        $_objFamilia = new DAO_FamiliaEudista();
        $_objFamilia->set_id_usuario(1);
        
    }
    
    
    
}
class ControladorEudistaException extends Exception{}
ControladorEudista::run();
