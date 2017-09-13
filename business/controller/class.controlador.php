<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_TemasFundamentales.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Cjm.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Oraciones.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_CantosEudistas.php';
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
                case 5: // consultar familia eudista
                    $return = $obj->_guardarFormarAJesus();
                    break;
                case 6: // guardar familia eudista
                    $return = $obj->_consultarFormarAJesus($_POST['lang'], isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null);
                    break;
                case 7:
                    $return = $obj->_guardarOraciones();
                    break;
                case 8:
                    $return = $obj->_consultarOraciones($_POST['lang'], isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null);
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
    private function _guardarFormarAJesus() {
        $_obj = new DAO_FormarAJesus();
        //print_r($_POST);
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_obj->set_fj_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_obj->set_id_usuario($this->_id_usuario);
            $_obj->set_fj_estado(1);
            //$_obj->set_fj_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_obj->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_obj->get_sql_error(), 0);
            }
        } else {
            $_obj->set_fj_id($_POST['id_articulo']);
            $_obj->consultar();
        }
        $R['id_articulo'] = $_obj->get_fj_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar TITULO
        $_objTextos = $this->_setTextos($_obj, "tematica", $codLang, $_POST['fj_tematica']);
        $R['lang_id_tematica'] = $_objTextos->get_lang_id();
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_obj, "ref_biblia", $codLang, $_POST['fj_ref_biblia']);
        $R['lang_id_ref_biblia'] = $_objTextosDesc->get_lang_id();
        // guardar LECTURA EUDISTA
        $_objTextosDesc = $this->_setTextos($_obj, "lec_eudista", $codLang, $_POST['fj_lec_eudista']);
        $R['lang_id_lec_eudista'] = $_objTextosDesc->get_lang_id();
        return $R;
    }
    /**
     * 
     * @param type $lenguaje
     * @param type $fj_id
     * @return type
     * @throws ControladorEudistaException
     */
    private function _consultarFormarAJesus($lenguaje, $fj_id = null) {
        $_obj = new DAO_FormarAJesus();
        $_obj->habilita1ResultadoEnArray();
        if (!empty($fj_id)) {
            $_obj->set_fj_id($fj_id);
        }
        if (!$arrFj = $_obj->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        }
        $R = array();
        foreach ($arrFj as $_objTemFj) {
            // obtener titulo
            if($_objTemFj instanceof DAO_FormarAJesus){}
            $_objTitulo = $this->_getTextos($_objTemFj, "tematica", $lenguaje);
            $langId = $_objTitulo->get_lang_id();
            if(empty($langId)){
                continue;
            }
            // obtener referencia biblica
            $_objTextoDesc = $this->_getTextos($_objTemFj, "ref_biblia", $lenguaje);
            // obtener lectura eudista
            $_objLecturaEudista = $this->_getTextos($_objTemFj, "lec_eudista", $lenguaje);
            $aux = array(
                'id_articulo' =>    $_objTemFj->get_fj_id(),
                'id_usuario' =>     $this->_id_usuario,
                //'fj_orden' =>       $_objTemFj->get_cj_orden(),
                'lang' =>           $_objTitulo->get_langLengua(),
                'fj_tematica' =>    $_objTitulo->get_lang_texto(),
                'fj_ref_biblia' =>  $_objTextoDesc->get_lang_texto(),
                'fj_lec_eudista' => $_objLecturaEudista->get_lang_texto(),
                'fecha_publica' =>  $_objTemFj->get_fj_fecha_publicacion()
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
     * 
     * @return type
     * @throws ControladorEudistaException
     */
    private function _guardarOraciones() {
        $_objOracion = new DAO_Oraciones();
        //print_r($_POST);
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_objOracion->set_ora_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_objOracion->set_id_usuario($this->_id_usuario);
            $_objOracion->set_ora_estado(1);
            $_objOracion->set_ora_categoria($_POST['ora_categoria']);
//            $_objOracion->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objOracion->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_objOracion->get_sql_error(), 0);
            }
        } else {
            $_objOracion->set_ora_id($_POST['id_articulo']);
            $_objOracion->consultar();
        }
        $R['id_articulo'] = $_objOracion->get_ora_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar TITULO
        $_objTextos = $this->_setTextos($_objOracion, "titulo", $codLang, $_POST['ora_titulo']);
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_objOracion, "oracion", $codLang, $_POST['ora_oracion']);
        return $R;
    }
    /**
     * 
     * @param type $lenguaje
     * @param type $ora_id
     * @return type
     * @throws ControladorEudistaException
     */
    private function _consultarOraciones($lenguaje, $ora_id = null) {
        $_objOracion = new DAO_Oraciones();
        $_objOracion->habilita1ResultadoEnArray();
        if (!empty($ora_id)) {
            $_objOracion->set_ora_id($ora_id);
        }
        if (!$arrOra = $_objOracion->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        }
        $R = array();
        foreach ($arrOra as $_objTemOra) {
            // obtener titulo
            if($_objTemOra instanceof DAO_Oraciones){}
            $_objOracionTitulo = $this->_getTextos($_objTemOra, "titulo", $lenguaje);
            $langId = $_objOracionTitulo->get_lang_id();
            if(empty($langId)){
                continue;
            }
            // obtener descripcion
            $_objTextoDesc = $this->_getTextos($_objTemOra, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemOra->get_ora_id(),
                'id_usuario' => $this->_id_usuario,
                //'cjm_orden' => $_objTemOra->get_cjm_orden(),
                'lang' => $_objOracionTitulo->get_langLengua(),
                'ora_titulo' => $_objOracionTitulo->get_lang_texto(),
                'ora_oracion' => $_objTextoDesc->get_lang_texto()
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
    private function _guardarCantosEudistas() {
        $_objCeu = new DAO_CantosEudistas();
        //print_r($_POST);
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_objCeu->set_ceu_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_objCeu->set_id_usuario($this->_id_usuario);
            $_objCeu->set_ceu_estado(1);
            $_objCeu->set_ceu_url_multimedia($_POST['ceu_url_multimedia']);
            //$_objCeu->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objCeu->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_objCeu->get_sql_error(), 0);
            }
        } else {
            $_objCeu->set_ceu_id($_POST['id_articulo']);
            $_objCeu->consultar();
        }
        $R['id_articulo'] = $_objCeu->get_ceu_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar TITULO
        $_objTextos = $this->_setTextos($_objCeu, "titulo", $codLang, $_POST['ceu_titulo']);
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_objCeu, "desc", $codLang, $_POST['ceu_desc']);
        return $R;
    }
    /**
     * 
     * @param type $lenguaje
     * @param type $ceu_id
     * @return type
     * @throws ControladorEudistaException
     */
    private function _consultarCantosEudistas($lenguaje, $ceu_id = null) {
        $_objCeu = new DAO_CantosEudistas();
        $_objCeu->habilita1ResultadoEnArray();
        if (!empty($ceu_id)) {
            $_objCeu->set_cjm_id($ceu_id);
        }
        if (!$arrCeu = $_objCeu->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        }
        $R = array();
        foreach ($arrCeu as $_objTemCjm) {
            // obtener titulo
            if($_objTemCjm instanceof DAO_CantosEudistas){}
            $_objCeuTitulo = $this->_getTextos($_objTemCjm, "titulo", $lenguaje);
            $langId = $_objCeuTitulo->get_lang_id();
            if(empty($langId)){
                continue;
            }
            // obtener descripcion
            $_objTextoDesc = $this->_getTextos($_objTemCjm, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemCjm->get_cjm_id(),
                'id_usuario' => $this->_id_usuario,
                'cjm_orden' => $_objTemCjm->get_cjm_orden(),
                'lang' => $_objCeuTitulo->get_langLengua(),
                'cjm_titulo' => $_objCeuTitulo->get_lang_texto(),
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
    private function _guardarFamiliaEudista() {
        $_objFam = new DAO_FamiliaEudista();
        //print_r($_POST);
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_objFam->set_fame_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_objFam->set_id_usuario($this->_id_usuario);
            $_objFam->set_fame_estado(1);
            $_objFam->set_fame_id_hija($_POST['fame_id_hija']);
            //$_objFam->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objFam->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_objFam->get_sql_error(), 0);
            }
        } else {
            $_objFam->set_fame_id($_POST['id_articulo']);
            $_objFam->consultar();
        }
        $R['id_articulo'] = $_objFam->get_fame_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar TITULO
        $_objTextos = $this->_setTextos($_objFam, "titulo", $codLang, $_POST['fame_titulo']);
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_objFam, "desc", $codLang, $_POST['fame_desc']);
        return $R;
    }
    /**
     * 
     * @param type $lenguaje
     * @param type $fame_id
     * @return type
     * @throws ControladorEudistaException
     */
    private function _consultarFamiliaEudista($lenguaje, $fame_id = null) {
        $_objFam = new DAO_FamiliaEudista();
        $_objFam->habilita1ResultadoEnArray();
        if (!empty($fame_id)) {
            $_objFam->set_fame_id($fame_id);
        }
        if (!$arrFam = $_objFam->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        } 
       $R = array();
        foreach ($arrFam as $_objTemFa) {
            // obtener titulo
            if($_objTemFa instanceof DAO_FamiliaEudista){}
            $_objCeuTitulo = $this->_getTextos($_objTemFa, "titulo", $lenguaje);
            $langId = $_objCeuTitulo->get_lang_id();
            if(empty($langId)){
                continue;
            }
            // obtener descripcion
            $_objTextoDesc = $this->_getTextos($_objTemFa, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemFa->get_fame_id(),
                'id_usuario' => $this->_id_usuario,
                //'cjm_orden' => $_objTemFa->get_cjm_orden(),
                'lang' => $_objCeuTitulo->get_langLengua(),
                'fame_titulo' => $_objCeuTitulo->get_lang_texto(),
                'fame_desc' => $_objTextoDesc->get_lang_texto()
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
    private function _guardarNoticias() {
        $_objFam = new DAO_Noticias();
        //print_r($_POST);
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_objFam->set_novt_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_objFam->set_fame_estado(1);
            //$_objFam->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objFam->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Noticia " . $_objFam->get_sql_error(), 0);
            }
        } else {
            $_objFam->set_novt_id($_POST['id_articulo']);
            $_objFam->consultar();
        }
        $R['id_articulo'] = $_objFam->get_novt_id();
        // consultar el codigo del lenguaje
        $codLang = $this->_getCodigoLenguaje($_POST['lang']);
        // guardar TITULO
        $_objTextos = $this->_setTextos($_objFam, "titulo", $codLang, $_POST['novt_titulo']);
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_objFam, "desc", $codLang, $_POST['novt_desc']);
        return $R;
    }
    /**
     * 
     * @param type $lenguaje
     * @param type $novt_id
     * @return type
     * @throws ControladorEudistaException
     */
    private function _consultarNoticias($lenguaje, $novt_id = null) {
        $_objFam = new DAO_Noticias();
        $_objFam->habilita1ResultadoEnArray();
        if (!empty($novt_id)) {
            $_objFam->set_fame_id($novt_id);
        }
        if (!$arrFam = $_objFam->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        } 
       $R = array();
        foreach ($arrFam as $_objTemFa) {
            // obtener titulo
            if($_objTemFa instanceof DAO_Noticias){}
            $_objCeuTitulo = $this->_getTextos($_objTemFa, "titulo", $lenguaje);
            $langId = $_objCeuTitulo->get_lang_id();
            if(empty($langId)){
                continue;
            }
            // obtener descripcion
            $_objTextoDesc = $this->_getTextos($_objTemFa, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemFa->get_novt_id(),
                'lang' => $_objCeuTitulo->get_langLengua(),
                'fame_titulo' => $_objCeuTitulo->get_lang_texto(),
                'fame_desc' => $_objTextoDesc->get_lang_texto()
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

}

class ControladorEudistaException extends Exception {
    
}

ControladorEudista::run();
