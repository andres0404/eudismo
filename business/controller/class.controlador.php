<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_TemasFundamentales.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Cjm.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Textos.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/controller/class.cabeceras.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/class.mtablas.php';

class ControladorEudista extends Cabeceras {

    private $_solicitud;
    private $_id_usuario = 1;

    public function __construct() {
        ;
    }

    /**
     * Arranca el servicio
     */
    public static function run() {
        try {
            $obj = new self();
            $obj->_solicitud = json_encode($_POST);
            $return = NULL;
            //print_r($obj->_solicitud);
            $con = ConexionSQL::getInstance();
            $con->begin();
            switch (isset($_REQUEST['funcion']) ? $_REQUEST['funcion'] : null) {
                case 1: // guardar CJM
                    $return = $obj->_guardarCjm();
                    break;
                case 2:// consultar CJM
                    $return = $obj->_consultarCjm($_POST['lang'], isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null);
                    break;
                case 3: // consultar temas fundamentales
                    $return = $obj->_guardarTemasFundamentales();
                    break;
                case 4: // guardar temas fundamentales
                    $return = $obj->_consultarTemasFundamentales($_POST['lang'], isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null);
                    break;
                case 6: // consultar familia eudista
                    $return = $obj->_listaProductos((isset($_REQUEST['id_sucursal']) ? $_REQUEST['id_sucursal'] : 0), (isset($_REQUEST['prod_clasificacion']) ? $_REQUEST['prod_clasificacion'] : 5));
                    break;
                case 7: // guardar familia eudista
                    //$return = $obj->
                    break;
            }
            $respuesta = array(
                'cod_respuesta' => 1,
                'mensaje' => "Elementos almacenados con exito",
                'data' => $return // // establece datos entregados por web service y busca codigo
            );
            $con->commit();
        } catch (ControladorEudistaException $ex) {
            $con->rollback();
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
     * @return type
     * @throws ControladorEudistaException
     */
    private function _guardarCjm() {
        $_objCjm = new DAO_Cjm();
        //print_r($_POST);
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_objCjm->set_cjm_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_objCjm->set_id_usuario($this->_id_usuario);
            $_objCjm->set_cjm_estado(1);
            $_objCjm->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objCjm->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_objCjm->get_sql_error(), 0);
            }
        } else {
            $_objCjm->set_cjm_id($_POST['id_articulo']);
            $_objCjm->consultar();
        }
        $R['id_articulo'] = $_objCjm->get_cjm_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar TITULO
        $_objTextos = $this->_setTextos($_objCjm, "titulo", $codLang, $_POST['cjm_titulo']);
        $R['lang_id_titulo'] = $_objTextos->get_lang_id();
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_objCjm, "desc", $codLang, $_POST['cjm_desc']);
        $R['lang_id_desc'] = $_objTextosDesc->get_lang_id();
        return $R;
    }
    /**
     * 
     * @param type $lenguaje
     * @param type $cjm_id
     * @return type
     * @throws ControladorEudistaException
     */
    private function _consultarCjm($lenguaje, $cjm_id = null) {
        $_objCjm = new DAO_Cjm();
        $_objCjm->habilita1ResultadoEnArray();
        if (!empty($cjm_id)) {
            $_objCjm->set_cjm_id($cjm_id);
        }
        if (!$arrCjm = $_objCjm->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        }
        $R = array();
        foreach ($arrCjm as $_objTemCjm) {
            // obtener titulo
            if($_objTemCjm instanceof DAO_Cjm){}
            $_objCjmTitulo = $this->_getTextos($_objTemCjm, "titulo", $lenguaje);
            $langId = $_objCjmTitulo->get_lang_id();
            if(empty($langId)){
                continue;
            }
            // obtener descripcion
            $_objTextoDesc = $this->_getTextos($_objTemCjm, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemCjm->get_cjm_id(),
                'id_usuario' => $this->_id_usuario,
                'cjm_orden' => $_objTemCjm->get_cjm_orden(),
                'lang' => $_objCjmTitulo->get_langLengua(),
                'cjm_titulo' => $_objCjmTitulo->get_lang_texto(),
                'cjm_desc' => $_objTextoDesc->get_lang_texto()
            );
            $R[] = $aux;
        }

        return $R;
    }

    /**
     * 
     * @return type
     * @throws ControladorEudistaException
     */
    private function _guardarTemasFundamentales() {
        $_objTemas = new DAO_TemasFundamentales();
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_objTemas->set_temf_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_objTemas->set_id_usuario($this->_id_usuario);
            $_objTemas->set_temf_estado(1);
            $_objTemas->set_temf_orden(isset($_POST['temf_orden']) ? $_POST['temf_orden'] : "");
            if (!$_objTemas->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_objTemas->get_sql_error(), 0);
            }
        } else {
            $_objTemas->set_temf_id($_POST['id_articulo']);
            $_objTemas->consultar();
        }
        $R['id_articulo'] = $_objTemas->get_temf_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar TITULO
        $_objTextos = $this->_setTextos($_objTemas, "titulo", $codLang, $_POST['funda_titulo']);
        $R['lang_id_titulo'] = $_objTextos->get_lang_id();
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_objTemas, "desc", $codLang, $_POST['funda_desc']);
        $R['lang_id_desc'] = $_objTextosDesc->get_lang_id();
        return $R;
    }
    

    /**
     * 
     * @param type $temf_id
     * @param type $lenguaje
     * @throws ControladorEudistaException
     */
    private function _consultarTemasFundamentales($lenguaje, $temf_id = null) {
        $_objTemFunda = new DAO_TemasFundamentales();
        $_objTemFunda->habilita1ResultadoEnArray();
        if (!empty($temf_id)) {
            $_objTemFunda->set_temf_id($temf_id);
        }
        if (!$arrTemasFundamen = $_objTemFunda->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        }
        $R = array();
        foreach ($arrTemasFundamen as $_objTemFun) {
            // obtener titulo
            if($_objTemFun instanceof DAO_TemasFundamentales){}
            $_objTextoTitulo = $this->_getTextos($_objTemFun, "titulo", $lenguaje);
            $langId = $_objTextoTitulo->get_lang_id();
            if(empty($langId)){
                continue;
            }
            // obtener descripcion
            $_objTextoDesc = $this->_getTextos($_objTemFun, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemFun->get_temf_id(),
                'id_usuario' => $this->_id_usuario,
                'temf_orden' => $_objTemFun->get_temf_orden(),
                'lang' => $_objTextoTitulo->get_langLengua(),
                'funda_titulo' => $_objTextoTitulo->get_lang_texto(),
                'funda_desc' => $_objTextoDesc->get_lang_texto()
            );
            $R[] = $aux;
        }

        return $R;
    }
    /**
     * Consultar texto
     * @param type $tabla
     * @param type $id_tabla
     * @param type $seccion
     * @param type $lengua
     * @return \DAO_Textos
     */
    private function _getTextos(DAOGeneral $_objDAO,$seccion,$lengua) {
        $_objTexto = new DAO_Textos();
        $_objTexto->set_lang_tbl($_objDAO->getTabla());
        $_objTexto->set_lang_id_tbl($_objDAO->getValorPrimario());
        $_objTexto->set_lang_seccion($seccion);
        $_objTexto->set_lang_lengua($this->_getCodigoLenguaje($lengua));
        $_objTexto->consultar();
        return $_objTexto;
    }
    /**
     * Almacenar texto
     * @param DAOGeneral $_objDAO
     * @param type $seccion
     * @param type $codLang
     * @param type $texto
     * @return \DAO_Textos
     * @throws ControladorEudistaException
     */
    private function _setTextos(DAOGeneral $_objDAO,$seccion,$codLang,$texto) {
        $_objTexto = new DAO_Textos();
        $_objTexto->set_lang_tbl($_objDAO->getTabla());
        $_objTexto->set_lang_id_tbl($_objDAO->getValorPrimario());
        $_objTexto->set_lang_seccion($seccion);
        $_objTexto->set_lang_lengua($codLang);
        $_objTexto->consultar(); // se consulta para obtener llave primaria y modificar si es necesario
        $_objTexto->set_lang_texto($texto);
        if (!$_objTexto->guardar()) {
            throw new ControladorEudistaException("No se pudo almacenar $seccion  ".$_objDAO->getTabla() ." " . $_objTexto->get_sql_error(), 0);
        }
        return $_objTexto;
    }
    
    

    /**
     * Obtener el codigo del lenguaje a partir del codigo ISO
     * @param type $codISO
     * @return boolean
     */
    private function _getCodigoLenguaje($codISO) {
        $_objMTablas = new MTablas();
        $lenguajes = $_objMTablas->getTablaCheckBox(4);
        $codLang = null;
        foreach ($lenguajes as $id => $langISO) {
            if ($langISO == $codISO) {
                return $id;
            }
        }
        return false;
    }

    private function _guardarFamiliaEudista() {
        $_objFamilia = new DAO_FamiliaEudista();
        $_objFamilia->set_id_usuario(1);
    }

}

class ControladorEudistaException extends Exception {
    
}

ControladorEudista::run();
