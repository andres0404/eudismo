<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_TemasFundamentales.php';
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
            switch (isset($_REQUEST['funcion']) ? $_REQUEST['funcion'] : null) {
                case 1: // consultar temas fundamentales
                    $return = $obj->_guardarTemasFundamentales();
                    break;
                case 2: // guardar temas fundamentales
                    $return = $obj->_consultarTemasFundamentales($_POST['lang'], isset($_POST['temf_id']) ? $_POST['temf_id'] : null);
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
                'mensaje' => "OK",
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
     * @return type
     * @throws ControladorEudistaException
     */
    private function _guardarTemasFundamentales() {
        $_objTemas = new DAO_TemasFundamentales();
        $con = ConexionSQL::getInstance();
        $con->begin();
        if (isset($_POST['temf_id']) && empty($_POST['temf_id'])) {
            $_objTemas->set_temf_id($_POST['temf_id']);
            $_objTemas->set_id_usuario($this->_id_usuario);
            $_objTemas->set_temf_estado(1);
            $_objTemas->set_temf_orden($_POST['temf_orden']);
            if (!$_objTemas->guardar()) {
                $con->rollback();
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_objTemas->get_sql_error(), 0);
            }
        } else {
            $_objTemas->set_temf_id($_POST['temf_id']);
            $_objTemas->consultar();
        }
        $R['temf_id'] = $_objTemas->get_temf_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar datos en textos (Titulo)
        $_objTextos = new DAO_Textos();
        if (isset($_POST['lang_id_titulo']) && !empty($_POST['lang_id_titulo'])) {
            $_objTextos->set_lang_id($_POST['lang_id']);
        }
        $_objTextos->set_lang_id_tbl($_objTemas->get_temf_id());
        $_objTextos->set_lang_tbl($_objTemas->getTabla());
        $_objTextos->set_lang_lengua($codLang);
        $_objTextos->set_lang_seccion("titulo");
        $_objTextos->set_lang_texto($_POST['funda_titulo']);
        if (!$_objTextos->guardar()) {
            $con->rollback();
            throw new ControladorEudistaException("No se pudo almacenar Titulo Temas Fundamentales " . $_objTextos->get_sql_error(), 0);
        }
        $R['lang_id_titulo'] = $_objTextos->get_lang_id();
        $_objTextosDesc = new DAO_Textos();
        if (isset($_POST['lang_id_desc']) && !empty($_POST['lang_id_desc'])) {
            $_objTextosDesc->set_lang_id($_POST['lang_id']);
        }
        $_objTextosDesc->set_lang_id_tbl($_objTemas->get_temf_id());
        $_objTextosDesc->set_lang_tbl($_objTemas->getTabla());
        $_objTextosDesc->set_lang_lengua($codLang);
        $_objTextosDesc->set_lang_seccion("desc");
        $_objTextosDesc->set_lang_texto($_POST['funda_desc']);
        if (!$_objTextosDesc->guardar()) {
            $con->rollback();
            throw new ControladorEudistaException("No se pudo almacenar Descripcion Temas Fundamentales " . $_objTextosDesc->get_sql_error(), 0);
        }
        $con->commit();
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
                'temf_id' => $_objTemFun->get_temf_id(),
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
