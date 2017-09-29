<?php
header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']); //$_SERVER['HTTP_REFERER']);
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_TemasFundamentales.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Cjm.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Oraciones.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_FormarAJesus.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_FamiliaEudista.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Testimonios.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_CantosEudistas.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Noticias.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/DAO/DAO_Textos.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/controller/class.cabeceras.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/controller/class.subir.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/class.sessions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/eudista/business/class.mtablas.php';

class ControladorEudista extends SubirMultimedia {

    private $_solicitud;
    private $_id_usuario = 1;
    private $_correo_sugerencias = 'hernando.silva@uniminuto.edu';
    private $_mensaje = 'Datos almacenados correctamente';

    public function __construct() {
        ;
    }

    /**
     * Arranca el servicio
     */
    public static function run() {
        try {
            if(!SessionPostulantes::verificarSesion(false,isset($_POST['token']) ? $_POST['token']:NULL))
                die("Acceso denegado");
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
                case 5: // consultar formar a jesus
                    $return = $obj->_guardarFormarAJesus();
                    break;
                case 6: // guardar familia eudista
                    $return = $obj->_consultarFormarAJesus($_POST['lang'], isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null);
                    break;
                case 7:
                    $return = $obj->_guardarOraciones();
                    break;
                case 8:
                    $return = $obj->_consultarOraciones($_POST['lang'], (isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null),(isset($_POST['ora_categoria']) ? $_POST['ora_categoria'] : null)) ;
                    break;
                case 9:
                    $return = $obj->_guardarCantosEudistas();
                    break;
                case 10:
                    $return = $obj->_consultarCantosEudistas("es", (isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null), (isset($_POST['ceu_categoria']) ? $_POST['ceu_categoria'] : null) );
                    break;
                case 11:
                    $return = $obj->_guardarFamiliaEudista();
                    break;
                case 12:
                    $return = $obj->_consultarFamiliaEudista($_POST['lang'], (isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null), (isset($_POST['fame_id_padre']) ? $_POST['fame_id_padre'] : '0') );
                    break;
                case 13:
                    $return = $obj->_guardarNoticias();
                    break;
                case 14:
                    $return = $obj->_consultarNoticias($_POST['lang'], isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null);
                    break;
                case 15:
                    $return = $obj->_guardarTestimonios();
                    break;
                case 16:
                    $return = $obj->_consultarTestimonios($_POST['lang'], isset($_POST['id_articulo']) ? $_POST['id_articulo'] : null);
                    break;
                case 17:
                    $return = $obj->_enviarMailSugerencias();
                    break;
                case 18:
                    $return = $obj->_listarCategoriaOraciones($_POST['lang']);
                    break;
                case 19:
                    $return = $obj->_eliminar($_POST['DAO'], $_POST['id_articulo'], $_POST['lang']);
                    break;
            }
            $respuesta = array(
                'cod_respuesta' => 1,
                'mensaje' => $obj->_mensaje,
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
     * @param type $tabla
     * @param type $idArticulo
     * @param type $lengua
     */
    public function _eliminar ($tabla, $idArticulo,$lengua) {
        $objMT = new MTablas();
        $tabla = $objMT->getTablaCheckBox(6,null,array("LIKE" => "%$tabla%"));
        $arrTabla = each($tabla);
        $datos = json_decode($arrTabla['value']);
        $arr_tabla_vs_DAO = each($datos);
        $objDAO = new $arr_tabla_vs_DAO['value']();
        $objDAO->setValorPrimario($idArticulo);
        if($this->_eliminarTexto($objDAO, $lengua)){// aliminar el registro
            if(!$objDAO->eliminar()){
                throw new ControladorEudistaException("Error ".$objDAO->get_sql_error());
            }
        }
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
            $_objCjm->set_cjm_imagen( ( empty($_POST['cjm_imagen']) || $_POST['cjm_imagen'] == 'undefined' ) ? "" : $_POST['cjm_imagen'] );
            //$_objCjm->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objCjm->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar CJM " . $_objCjm->get_sql_error(), 0);
            }
        } else {
            $_objCjm->set_cjm_id($_POST['id_articulo']);
            $_objCjm->consultar();
            $_objCjm->set_cjm_imagen( ( empty($_POST['cjm_imagen']) || $_POST['cjm_imagen'] == 'undefined' ) ? "" : $_POST['cjm_imagen'] );
            // actualiza imagen
            if (!$_objCjm->guardar()) {
                throw new ControladorEudistaException("No se pudo actualizar CJM " . $_objCjm->get_sql_error(), 0);
            }
        }
        $R['id_articulo'] = $_objCjm->get_cjm_id();
        // consultar el codigo del lenguaje
        $codLang = $_POST['lang'];
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
                //'cjm_orden' => $_objTemCjm->get_cjm_orden(),
                'lang' => $_objCjmTitulo->get_langLengua(),
                'cjm_titulo' => $_objCjmTitulo->get_lang_texto(),
                'cjm_desc' => $_objTextoDesc->get_lang_texto(),
                'cjm_imagen' => $_objTemCjm->get_cjm_imagen()
            );
            $R[] = $aux;
        }
        $this->_mensaje = 'Datos encontrados';
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
            $_obj->set_fj_fecha_publicacion($_POST['fecha_publica']);
            //$_obj->set_fj_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_obj->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Formar a Jesus " . $_obj->get_sql_error(), 0);
            }
        } else {
            $_obj->set_fj_id($_POST['id_articulo']);
            $_obj->consultar();
        }
        $R['id_articulo'] = $_obj->get_fj_id();
        // consultar el codigo del lenguaje
        //$codLang = $_POST['lang'];
        $codLang = $_POST['lang'];
        // guardar TITULO
        $_objTextos = $this->_setTextos($_obj, "tematica", $codLang, $_POST['fj_tematica']);
        $R['lang_id_tematica'] = $_objTextos->get_lang_id();
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_obj, "ref_biblia", $codLang, $_POST['fj_ref_biblia']);
        $R['lang_id_ref_biblia'] = $_objTextosDesc->get_lang_id();
        
        // guardar OBJETIVO
        $_objTextosDesc = $this->_setTextos($_obj, "objetivo", $codLang, $_POST['fj_objetivo']);
        $R['lang_id_fj_objetivo'] = $_objTextosDesc->get_lang_id();
        
        // guardar LECTURA EUDISTA
        $_objTextosDesc = $this->_setTextos($_obj, "lec_eudista", $codLang, $_POST['fj_lec_eudista']);
        $R['lang_id_lec_eudista'] = $_objTextosDesc->get_lang_id();
        
        // guardar ORACION FINAL
        $_objTextosDesc = $this->_setTextos($_obj, "oracion_final", $codLang, $_POST['fj_oracion_final']);
        $R['lang_id_oracion_final'] = $_objTextosDesc->get_lang_id();
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
            
            $_objObjetivo = $this->_getTextos($_objTemFj, "objetivo", $lenguaje);
            
            $_objOracionFinal = $this->_getTextos($_objTemFj, "oracion_final", $lenguaje);
            $aux = array(
                'id_articulo' =>    $_objTemFj->get_fj_id(),
                'id_usuario' =>     $this->_id_usuario,
                //'fj_orden' =>       $_objTemFj->get_cj_orden(),
                'lang' =>           $_objTitulo->get_langLengua(),
                'fj_tematica' =>    $_objTitulo->get_lang_texto(),
                'fj_ref_biblia' =>  $_objTextoDesc->get_lang_texto(),
                'fj_objetivo' =>    $_objObjetivo->get_lang_texto(),//
                'fj_lec_eudista' => $_objLecturaEudista->get_lang_texto(),
                'fj_oracion_final'=>$_objOracionFinal->get_lang_texto(),//
                'fecha_publica' =>  $_objTemFj->get_fj_fecha_publicacion()
            );
            $R[] = $aux;
        }
        $this->_mensaje = 'Datos encontrados';
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
            //$_objTemas->set_temf_orden(isset($_POST['temf_orden']) ? $_POST['temf_orden'] : "");
            if (!$_objTemas->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Temas Fundamentales " . $_objTemas->get_sql_error(), 0);
            }
        } else {
            $_objTemas->set_temf_id($_POST['id_articulo']);
            $_objTemas->consultar();
        }
        $R['id_articulo'] = $_objTemas->get_temf_id();
        // consultar el codigo del lenguaje
        $codLang = $_POST['lang'];
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
        $this->_mensaje = 'Datos encontrados';
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
                throw new ControladorEudistaException("No se pudo almacenar Oraciones " . $_objOracion->get_sql_error(), 0);
            }
        } else {
            $_objOracion->set_ora_id($_POST['id_articulo']);
            $_objOracion->consultar();
        }
        $R['id_articulo'] = $_objOracion->get_ora_id();
        // consultar el codigo del lenguaje
        $codLang = $_POST['lang'];
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
    private function _consultarOraciones($lenguaje, $ora_id = null,$ora_categoria = null) {
        $_objOracion = new DAO_Oraciones();
        $_objOracion->habilita1ResultadoEnArray();
        if (!empty($ora_id)) {
            $_objOracion->set_ora_id($ora_id);
        }
        if(!empty($ora_categoria)){
            $_objOracion->set_ora_categoria($ora_categoria);
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
            $_objTextoDesc = $this->_getTextos($_objTemOra, "oracion", $lenguaje);
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
        $this->_mensaje = 'Datos encontrados';
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
            $_objCeu->set_ceu_url($_POST['ceu_url']);
            //$_objCeu->set
            //$_objCeu->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objCeu->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Cantos Eudistas " . $_objCeu->get_sql_error(), 0);
            }
        } else {
            $_objCeu->set_ceu_id($_POST['id_articulo']);
            $_objCeu->consultar();
            $_objCeu->set_ceu_url($_POST['ceu_url']);
            $_objCeu->set_ceu_categoria($_POST['ceu_categoria']);
        }
        $R['id_articulo'] = $_objCeu->get_ceu_id();
        // subir archivo multimedia
        try{
            if( isset( $_FILES['archivo_multi'] ) ){
                $_objCeu->set_ceu_url_multimedia( $this->_subirArchivo( $_FILES['archivo_multi'] ) );
                $_objCeu->guardar();
            }
        } catch (SubirMultimediaException $e){
            throw new ControladorEudistaException($e->getMessage(),0);
        }
        // consultar el codigo del lenguaje
        //$codLang = $_POST['lang'];
        $codLang = "es";//$this->_getCodigoLenguaje("es");
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
            $_objCeu->set_ceu_id($ceu_id);
        }
        if (!$arrCeu = $_objCeu->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        }
        //print_r($arrCeu);
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
            //print_r($_SERVER);
            $origen = !empty($_SERVER['HTTP_ORIGIN']) ? ('http://'.$_SERVER['HTTP_HOST']) :  $_SERVER['HTTP_ORIGIN'] ;
            $ruta = "{$origen}/eudista/business/controller/";
            $_objTextoDesc = $this->_getTextos($_objTemCjm, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemCjm->get_ceu_id(),
                'id_usuario' => $this->_id_usuario,
                'ceu_url_multimedia' => $ruta.$_objTemCjm->get_ceu_url_multimedia(),
                'lang' => $_objCeuTitulo->get_langLengua(),
                'cjm_titulo' => $_objCeuTitulo->get_lang_texto(),
                'cjm_desc' => $_objTextoDesc->get_lang_texto()
            );
            $R[] = $aux;
        }
        $this->_mensaje = 'Datos encontrados';
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
            $_objFam->set_fame_id_padre(empty($_POST['fame_id_padre']) ? "0" : $_POST['fame_id_padre'] );
            //$_objFam->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objFam->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Familia Eudista " . $_objFam->get_sql_error(), 0);
            }
        } else {
            $_objFam->set_fame_id($_POST['id_articulo']);
            $_objFam->consultar();
        }
        $R['id_articulo'] = $_objFam->get_fame_id();
        // consultar el codigo del lenguaje
        $codLang = $_POST['lang'];
        
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
    private function _consultarFamiliaEudista($lenguaje, $fame_id = null,$fame_id_padre = '0') {
        $_objFam = new DAO_FamiliaEudista();
        $_objFam->habilita1ResultadoEnArray();
        if (!empty($fame_id)) {
            $_objFam->set_fame_id($fame_id);
        }
    if(!empty($fame_id_padre) || $fame_id_padre == '0'){
            $_objFam->set_fame_id_padre($fame_id_padre);
        }
        //+print_r($_objFam);
        if (!$arrFam = $_objFam->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        } 
        //print_r($arrFam);
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
                'fame_id_padre' => $_objTemFa->get_fame_id_padre(),
                //'cjm_orden' => $_objTemFa->get_cjm_orden(),
                'lang' => $_objCeuTitulo->get_langLengua(),
                'fame_titulo' => $_objCeuTitulo->get_lang_texto(),
                'fame_desc' => $_objTextoDesc->get_lang_texto()
            );
            $R[] = $aux;
        }
        $this->_mensaje = 'Datos encontrados';
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
            $_objFam->set_novt_imagen((empty($_POST['novt_imagen']) || $_POST['novt_imagen'] == 'undefined') ? "" : $_POST['novt_imagen'] );
            $_objFam->set_novt_estado(1);
            //$_objFam->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objFam->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Noticias " . $_objFam->get_sql_error(), 0);
            }
        } else {
            $_objFam->set_novt_id($_POST['id_articulo']);
            $_objFam->consultar();
            $_objFam->set_novt_imagen((empty($_POST['novt_imagen']) || $_POST['novt_imagen'] == 'undefined') ? "" : $_POST['novt_imagen'] );
            if (!$_objFam->guardar()) {
                throw new ControladorEudistaException("No se pudo actualizar Noticias " . $_objFam->get_sql_error(), 0);
            }
        }
        $R['id_articulo'] = $_objFam->get_novt_id();
        // consultar el codigo del lenguaje
        $codLang = $_POST['lang'];
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
            $_objFam->set_novt_id($novt_id);
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
                'novt_titulo' => $_objCeuTitulo->get_lang_texto(),
                'novt_desc' => $_objTextoDesc->get_lang_texto(),
                'novt_imagen' => $_objTemFa->get_novt_imagen()
            );
            $R[] = $aux;
        }
        $this->_mensaje = 'Datos encontrados';
        return $R;
    }
    /**
     * 
     * @return type
     * @throws ControladorEudistaException
     */
    private function _guardarTestimonios() {
        $_objFam = new DAO_Testimonios();
        //print_r($_POST);
        // consultar el codigo del lenguaje
        $codLang = $_POST['lang'];
        if (isset($_POST['id_articulo']) && ( empty($_POST['id_articulo']) || $_POST['id_articulo'] == 'undefined' ) ) {
            $_objFam->set_test_id($_POST['id_articulo'] == 'undefined' ? "" : $_POST['id_articulo']);
            $_objFam->set_test_lengua_nativa($codLang);
            $_objFam->set_id_usuario($_POST['id_usuario']);
            $_objFam->set_test_estado(1);
            //$_objFam->set_cjm_orden(isset($_POST['cjm_orden']) ? $_POST['cjm_orden'] : "" );
            if (!$_objFam->guardar()) {
                throw new ControladorEudistaException("No se pudo almacenar Testimonios " . $_objFam->get_sql_error(), 0);
            }
        } else {
            $_objFam->set_test_id($_POST['id_articulo']);
            $_objFam->consultar();
        }
        $R['id_articulo'] = $_objFam->get_test_id();
        // guardar TITULO
        //$_objTextos = $this->_setTextos($_objFam, "titulo", $codLang, $_POST['test_titulo']);
        // guardar DESCRIPCION
        $_objTextosDesc = $this->_setTextos($_objFam, "desc", $codLang, $_POST['test_desc']);
        return $R;
    }  
    /**
     * 
     * @param type $lenguaje
     * @param type $test_id
     * @return type
     * @throws ControladorEudistaException
     */
    private function _consultarTestimonios($lenguaje, $test_id = null) {
        $_objFam = new DAO_Testimonios();
        $_objFam->setOrdenar(array('test_id DESC'));
        $_objFam->habilita1ResultadoEnArray();
        if (!empty($test_id)) {
            $_objFam->set_test_id($test_id);
        }
        if (!$arrFam = $_objFam->consultar()) {
            throw new ControladorEudistaException("No se encontro elemento", 0);
        } 
        $R = array();
        foreach ($arrFam as $_objTemFa) {
            // obtener titulo
            if($_objTemFa instanceof DAO_Testimonios){}
            /*$_objCeuTitulo = $this->_getTextos($_objTemFa, "titulo", $lenguaje);
            $langId = $_objCeuTitulo->get_test_id();
            if(empty($langId)){
                continue;
            }*/
            // obtener descripcion
            $_objTextoDesc = $this->_getTextos($_objTemFa, "desc", $lenguaje);
            $aux = array(
                'id_articulo' => $_objTemFa->get_test_id(),
                'lang' => $_objTextoDesc->get_langLengua(),
                'test_lengua_nativa' => $_objTemFa->get_test_lengua_nativa(),
                //'test_titulo' => $_objCeuTitulo->get_test_texto(),
                'test_desc' => $_objTextoDesc->get_lang_texto(),
                'imgPerfil' => $_objTemFa->get_imgPerfil(),
                'nombre' => $_objTemFa->get_uNombre()
            );
            $R[] = $aux;
        }
        $this->_mensaje = 'Datos encontrados';
        return $R;
    }
    /**
     * Traer la lista de categorias de oraciones en su correspondiante idioma
     * @return type
     */
    private function _listarCategoriaOraciones($lengua) {
        $_objMT = new MTablas();
        $arrCatego =  $_objMT->getTablaCheckBox(4,NULL,$lengua);
        $dato = each($arrCatego);
        $jsonValoresOracion = $_objMT->getTablaCheckBox(5,$dato['key']);
        $jsonLista = each($jsonValoresOracion);
        $arrCatego = json_decode($jsonLista['value']);
        $R = array();
        foreach($arrCatego as $key => $valor){
            $R[] = array(
                'cod_categoria' => $key,
                'nom_categoria' => $valor
            );
        }
        return $R;
    }
    /*
Array
(
    [cantos_eudistas] => DAO_CantosEudistas
    [cjm] => DAO_Cjm
    [familia_eudista] => DAO_FamiliaEudista
    [formar_jesus] => DAO_FormarAJesus
    [novedades_noticias] => DAO_Noticias
    [temas_fundamentales] => DAO_TemasFundamentales
    [oraciones] => DAO_Oraciones
    [testimonios] => DAO_Testimonios
)     */
    /**
     * 
     */
    private function _enviarMailSugerencias() {
        $lengua = $_POST['lang'];
        $_objMT = new MTablas();
        $datos = array();
        switch ($_POST['nom_seccion']){
            case 'cantos_eudistas':
                $datos = $this->_consultarCantosEudistas($lengua,$_POST['id_articulo']);
                break;
            case 'cjm':
                $datos = $this->_consultarCjm($lengua,$_POST['id_articulo']);
                break;
            case 'familia_eudista':
                $datos = $this->_consultarFamiliaEudista($lengua,$_POST['id_articulo']);
                break;
            case 'formar_jesus':
                $datos = $this->_consultarFormarAJesus($lengua,$_POST['id_articulo']);
                break;
            case 'novedades_noticias':
                $datos = $this->_consultarNoticias($lengua,$_POST['id_articulo']);
                break;
            case 'temas_fundamentales':
                $datos = $this->_consultarTemasFundamentales($lengua,$_POST['id_articulo']);
                break;
            case 'oraciones':
                $datos = $this->_consultarOraciones($lengua,$_POST['id_articulo']);
                break;
            case 'testimonios':
                $datos = $this->_consultarTestimonios($lengua,$_POST['id_articulo']);
                break;
        }
        $titulo = '';
        foreach($datos as $claves => $valores){
            if(strpos($claves, "titulo") || strpos($claves, "tematica")){
                $titulo = $valores;
                break;
            }
        }
        //print_r($datos);
        //die();
        if(!is_array($datos) || count($datos) < 1){
            return false;
        }
        if(!$myfile = fopen($_SERVER['DOCUMENT_ROOT']."eudista/admin/plantillas/plantilla_mail.html", "r") ) {
            return false;
        }
        $html = fread($myfile,filesize($_SERVER['DOCUMENT_ROOT']."eudista/admin/plantillas/plantilla_mail.html"));
        fclose($myfile);
        $search = array('{lengua}','{logo}','{sponsor}','{present}','{message}','{and_more}');
        $replace = array($lengua,'App Eudista','Uniminuto',"Sugerencia de traducción '$titulo'" ,$_POST['titulo'],$_POST['texto']);
        $plantilla = str_replace($search, $replace, $html);
        // MAIL
        $para      = $this->_correo_sugerencias;
        $titulo    = 'Traducción sugerida';
        $mensaje   = 'Traducción sugerida App Eudista';
        $cabeceras = array(
            'From: webmaster@example.com',
            'Content-type: text/html; charset=iso-8859-1',
            'Reply-To: webmaster@example.com',
            'X-Mailer: PHP/' . phpversion()
        );
        mail($para, $titulo, $mensaje, implode("\r\n", $cabeceras));
        $this->_mensaje = 'Tu sugerencia ha sido enviada correctamente';
        return true;
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
        $_objTexto->set_lang_lengua($this->_getCodigoLenguaje($codLang));
        $_objTexto->consultar(); // se consulta para obtener llave primaria y modificar si es necesario
        $_objTexto->set_lang_texto($texto);
        if (!$_objTexto->guardar()) {
            throw new ControladorEudistaException("No se pudo almacenar $seccion  ".$_objDAO->getTabla() ." " . $_objTexto->get_sql_error(), 0);
        }
        return $_objTexto;
    }
    /**
     * 
     * @param DAOGeneral $objDao
     * @param type $codLang
     * @return boolean true:no hay mas lenguas para el registro false: existen mas lenguas
     * @throws ControladorEudistaException
     */
    private function _eliminarTexto(DAOGeneral $objDao, $codLang) {
        $_objTexto = new DAO_Textos();
        $_objTexto->set_lang_tbl($objDao->getTabla());
        $_objTexto->set_lang_lengua($this->_getCodigoLenguaje($codLang));
        $_objTexto->set_lang_id_tbl($objDao->getValorPrimario());
        if(!$_objTexto->eliminar()){
            throw new ControladorEudistaException("Error ".$_objTexto->get_sql_error());
        }
        $this->_mensaje = "Dato eliminado correctamente";
        $_objTexto = new DAO_Textos();
        $_objTexto->set_lang_tbl($objDao->getTabla());
        $_objTexto->set_lang_id_tbl($objDao->getValorPrimario());
        if($_objTexto->existeTextoDeLaTabla() == 0){
            return TRUE;
        }
        return false;
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
