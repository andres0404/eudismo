<?php

include_once 'class.DAO.php';

class DAO_Textos extends DAOGeneral {

    protected $_lang_id;
    protected $_lang_tbl;
    protected $_lang_id_tbl;
    protected $_lang_lengua;
    protected $_lang_texto;
    protected $_lang_seccion;
    protected $_langLengua;


    protected $_tabla = 'lang_textos';
    protected $_primario = 'lang_id';
    protected $_ordenar = array();
    
    protected $_mapa = array(
        'lang_id' => array('tipodato' => 'integer'),
        'lang_tbl' => array('tipodato' => 'varchar'),
        'lang_id_tbl' => array('tipodato' => 'integer'),
        'lang_lengua' => array('tipodato' => 'integer'),
        'lang_texto' => array('tipodato' => 'varchar'),
        'lang_seccion' => array('tipodato' => 'varchar'),
        'langLengua' => array('tipodato' => 'varchar','sql' => '(SELECT valor FROM mt_contenidos WHERE id_tabla = 4 AND id_valor = lang_textos.lang_lengua )')
    );
    
    function get_langLengua() {
        return $this->_langLengua;
    }

    function set_langLengua($_langLengua) {
        $this->_langLengua = $_langLengua;
    }

        function get_lang_id() {
        return $this->_lang_id;
    }

    function get_lang_tbl() {
        return $this->_lang_tbl;
    }

    function get_lang_id_tbl() {
        return $this->_lang_id_tbl;
    }

    function get_lang_lengua() {
        return $this->_lang_lengua;
    }

    function get_lang_texto() {
        return $this->_lang_texto;
    }

    function get_lang_seccion() {
        return $this->_lang_seccion;
    }

    function set_lang_id($_lang_id) {
        $this->_lang_id = $_lang_id;
    }

    function set_lang_tbl($_lang_tbl) {
        $this->_lang_tbl = $_lang_tbl;
    }

    function set_lang_id_tbl($_lang_id_tbl) {
        $this->_lang_id_tbl = $_lang_id_tbl;
    }

    function set_lang_lengua($_lang_lengua) {
        $this->_lang_lengua = $_lang_lengua;
    }

    function set_lang_texto($_lang_texto) {
        $this->_lang_texto = $_lang_texto;
    }

    function set_lang_seccion($_lang_seccion) {
        $this->_lang_seccion = $_lang_seccion;
    }

    function existeTextoDeLaTabla(){
        $query = "select count(*) total from {$this->_tabla} where lang_tbl = '{$this->_lang_tbl}'  AND lang_id_tbl = $this->_lang_id_tbl ";
        $con = ConexionSQL::getInstance();
        $id = $con->consultar($query);
        if($res = $con->obenerFila($id)){
            return $res['total'];
        }
        return false;
    }

}
