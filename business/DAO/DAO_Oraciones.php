<?php

include_once 'class.DAO.php';

class DAO_Oraciones extends DAOGeneral {
    
    
    protected $_ora_id;
    protected $_id_usuario;
    protected $_ora_categoria;
    protected $_ora_fecha;
    protected $_ora_estado;
    
    protected $_tabla = 'oraciones';
    protected $_primario = 'ora_id';
    protected $_ordenar = array();
    
    
    
    protected $_mapa = array(
        'ora_id' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'ora_categoria' => array('tipodato' => 'integer'),
        'ora_fecha' => array('tipodato' => 'date'),
        'ora_estado' => array('tipodato' => 'integer'),
    );
    
    function get_ora_id() {
        return $this->_ora_id;
    }

    function get_id_usuario() {
        return $this->_id_usuario;
    }

    function get_ora_categoria() {
        return $this->_ora_categoria;
    }

    function get_ora_fecha() {
        return $this->_ora_fecha;
    }

    function get_ora_estado() {
        return $this->_ora_estado;
    }

    function set_ora_id($_ora_id) {
        $this->_ora_id = $_ora_id;
    }

    function set_id_usuario($_id_usuario) {
        $this->_id_usuario = $_id_usuario;
    }

    function set_ora_categoria($_ora_categoria) {
        $this->_ora_categoria = $_ora_categoria;
    }

    function set_ora_fecha($_ora_fecha) {
        $this->_ora_fecha = $_ora_fecha;
    }

    function set_ora_estado($_ora_estado) {
        $this->_ora_estado = $_ora_estado;
    }




}
