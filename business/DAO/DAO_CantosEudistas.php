<?php

include_once 'class.DAO.php';

class DAO_CantosEudistas extends DAOGeneral {
    
    
    protected $_ceu_id;
    protected $_id_usuario;
    protected $_ceu_fecha;
    protected $_ceu_url_multimedia;
    protected $_ceu_estado;
    protected $_ceu_url;
    
    protected $_tabla = 'cantos_eudistas';
    protected $_primario = 'ceu_id';
    protected $_ordenar = array();
    
    protected $_mapa = array(
        'ceu_id' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'ceu_url_multimedia' => array('tipodato' => 'varchar'),
        'ceu_fecha' => array('tipodato' => 'date'),
        'ceu_estado' => array('tipodato' => 'integer'),
        'ceu_url' => array('tipodato' => 'varchar')
    );
    
    function get_ceu_id() {
        return $this->_ceu_id;
    }

    function get_id_usuario() {
        return $this->_id_usuario;
    }
    function get_ceu_url() {
        return $this->_ceu_url;
    }

    function set_ceu_url($_ceu_url) {
        $this->_ceu_url = $_ceu_url;
    }

        function get_ceu_fecha() {
        return $this->_ceu_fecha;
    }

    function get_ceu_url_multimedia() {
        return $this->_ceu_url_multimedia;
    }

    function get_ceu_estado() {
        return $this->_ceu_estado;
    }

    function set_ceu_id($_ceu_id) {
        $this->_ceu_id = $_ceu_id;
    }

    function set_id_usuario($_id_usuario) {
        $this->_id_usuario = $_id_usuario;
    }

    function set_ceu_fecha($_ceu_fecha) {
        $this->_ceu_fecha = $_ceu_fecha;
    }

    function set_ceu_url_multimedia($_ceu_url_multimedia) {
        $this->_ceu_url_multimedia = $_ceu_url_multimedia;
    }

    function set_ceu_estado($_ceu_estado) {
        $this->_ceu_estado = $_ceu_estado;
    }


}
