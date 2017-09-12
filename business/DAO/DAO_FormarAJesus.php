<?php

include_once 'class.DAO.php';

class DAO_FormarAJesus extends DAOGeneral {

    protected $_fj_id;
    protected $_id_usuario;
    protected $_fj_fecha_publicacion;
    protected $_fj_tematica;
    protected $_fj_fecha;
    protected $_fj_estado;
    
    protected $_tabla = 'formar_jesus';
    protected $_primario = 'fj_id';
    protected $_ordenar = array();
    protected $_mapa = array(
        'fj_id' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'fj_fecha_publicacion' => array('tipodato' => 'integer'),
        'fj_tematica' => array('tipodato' => 'integer'),
        'fj_fecha' => array('tipodato' => 'date'),
        'fj_estado' => array('tipodato' => 'integer'),
    );
    
    function get_fj_id() {
        return $this->_fj_id;
    }

    function get_id_usuario() {
        return $this->_id_usuario;
    }

    function get_fj_fecha_publicacion() {
        return $this->_fj_fecha_publicacion;
    }

    function get_fj_tematica() {
        return $this->_fj_tematica;
    }

    function get_fj_fecha() {
        return $this->_fj_fecha;
    }

    function get_fj_estado() {
        return $this->_fj_estado;
    }

    function set_fj_id($_fj_id) {
        $this->_fj_id = $_fj_id;
    }

    function set_id_usuario($_id_usuario) {
        $this->_id_usuario = $_id_usuario;
    }

    function set_fj_fecha_publicacion($_fj_fecha_publicacion) {
        $this->_fj_fecha_publicacion = $_fj_fecha_publicacion;
    }

    function set_fj_tematica($_fj_tematica) {
        $this->_fj_tematica = $_fj_tematica;
    }

    function set_fj_fecha($_fj_fecha) {
        $this->_fj_fecha = $_fj_fecha;
    }

    function set_fj_estado($_fj_estado) {
        $this->_fj_estado = $_fj_estado;
    }



}
