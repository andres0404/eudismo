<?php

include_once 'class.DAO.php';

class DAO_Cjm extends DAOGeneral {

    protected $_cjm_id;
    protected $_id_usuario;
    protected $_cjm_orden;
    protected $_cjm_fecha;
    protected $_cjm_estado;
    protected $_cjm_imagen;
    protected $_tabla = 'cjm';
    protected $_primario = 'cjm_id';
    protected $_ordenar = array();
    protected $_mapa = array(
        'cjm_id' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'cjm_orden' => array('tipodato' => 'integer'),
        'cjm_fecha' => array('tipodato' => 'date'),
        'cjm_estado' => array('tipodato' => 'integer'),
        'cjm_imagen' => array('tipodato' => 'varchar')
    );
    function get_cjm_imagen() {
        return $this->_cjm_imagen;
    }

    function set_cjm_imagen($_cjm_imagen) {
        $this->_cjm_imagen = $_cjm_imagen;
    }

        function get_cjm_id() {
        return $this->_cjm_id;
    }

    function get_id_usuario() {
        return $this->_id_usuario;
    }

    function get_cjm_orden() {
        return $this->_cjm_orden;
    }

    function get_cjm_fecha() {
        return $this->_cjm_fecha;
    }

    function get_cjm_estado() {
        return $this->_cjm_estado;
    }

    function set_cjm_id($_cjm_id) {
        $this->_cjm_id = $_cjm_id;
    }

    function set_id_usuario($_id_usuario) {
        $this->_id_usuario = $_id_usuario;
    }

    function set_cjm_orden($_cjm_orden) {
        $this->_cjm_orden = $_cjm_orden;
    }

    function set_cjm_fecha($_cjm_fecha) {
        $this->_cjm_fecha = $_cjm_fecha;
    }

    function set_cjm_estado($_cjm_estado) {
        $this->_cjm_estado = $_cjm_estado;
    }


}
