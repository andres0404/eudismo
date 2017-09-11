<?php

include_once 'class.DAO.php';

class DAO_TemasFundamentales extends DAOGeneral {

    protected $_temf_id;
    protected $_id_usuario;
    protected $_temf_orden;
    protected $_temf_fecha;
    protected $_temf_estado;
    protected $_tabla = 'temas_fundamentales';
    protected $_primario = 'temf_id';
    protected $_ordenar = array();
    protected $_mapa = array(
        'temf_id' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'temf_orden' => array('tipodato' => 'integer'),
        'temf_fecha' => array('tipodato' => 'date'),
        'temf_estado' => array('tipodato' => 'integer'),
    );
    function get_temf_id() {
        return $this->_temf_id;
    }

    function get_id_usuario() {
        return $this->_id_usuario;
    }

    function get_temf_orden() {
        return $this->_temf_orden;
    }

    function get_temf_fecha() {
        return $this->_temf_fecha;
    }

    function get_temf_estado() {
        return $this->_temf_estado;
    }

    function set_temf_id($_temf_id) {
        $this->_temf_id = $_temf_id;
    }

    function set_id_usuario($_id_usuario) {
        $this->_id_usuario = $_id_usuario;
    }

    function set_temf_orden($_temf_orden) {
        $this->_temf_orden = $_temf_orden;
    }

    function set_temf_fecha($_temf_fecha) {
        $this->_temf_fecha = $_temf_fecha;
    }

    function set_temf_estado($_temf_estado) {
        $this->_temf_estado = $_temf_estado;
    }


}
