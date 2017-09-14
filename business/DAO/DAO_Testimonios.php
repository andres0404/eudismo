<?php

include_once 'class.DAO.php';

class DAO_Testimonios extends DAOGeneral {

    protected $_test_id;
    protected $_id_usuario;
    protected $_test_foto;
    protected $_test_lengua_nativa;
    protected $_test_estado;

    protected $_tabla = 'testimonios';
    protected $_primario = 'test_id';
    protected $_ordenar = array();
    
    protected $_mapa = array(
        'test_id' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'test_foto' => array('tipodato' => 'varchar'),
        'test_lengua_nativa' => array('tipodato' => 'integer'),
        'test_estado' => array('tipodato' => 'integer')
    );
    
    function get_test_id() {
        return $this->_test_id;
    }

    function get_id_usuario() {
        return $this->_id_usuario;
    }

    function get_test_foto() {
        return $this->_test_foto;
    }

    function get_ordenar() {
        return $this->_ordenar;
    }

    function set_test_id($_test_id) {
        $this->_test_id = $_test_id;
    }

    function set_id_usuario($_id_usuario) {
        $this->_id_usuario = $_id_usuario;
    }

    function set_test_foto($_test_foto) {
        $this->_test_foto = $_test_foto;
    }

    function set_ordenar($_ordenar) {
        $this->_ordenar = $_ordenar;
    }
    function get_test_lengua_nativa() {
        return $this->_test_lengua_nativa;
    }

    function set_test_lengua_nativa($_test_lengua_nativa) {
        $this->_test_lengua_nativa = $_test_lengua_nativa;
    }

    function get_test_estado() {
        return $this->_test_estado;
    }

    function set_test_estado($_test_estado) {
        $this->_test_estado = $_test_estado;
    }



}