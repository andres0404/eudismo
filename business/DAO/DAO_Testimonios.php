<?php

include_once 'class.DAO.php';

class DAO_Testimonios extends DAOGeneral {

    protected $_test_id;
    protected $_id_usuario;
    protected $_test_lengua_nativa;
    protected $_test_estado;
    protected $_imgPerfil;
    protected $_uNombre;

    protected $_tabla = 'testimonios';
    protected $_primario = 'test_id';
    protected $_ordenar = array();
    
    protected $_mapa = array(
        'test_id' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'test_lengua_nativa' => array('tipodato' => 'integer'),
        'test_estado' => array('tipodato' => 'integer'),
        'imgPerfil' => array('tipodato' => 'varchar','sql' => '(SELECT u_img_perfil FROM usuarios WHERE usuarios.id_usuario = testimonios.id_usuario)'),
        'uNombre' => array('tipodato' => 'varchar','sql' => '(SELECT u_nombre FROM usuarios WHERE usuarios.id_usuario = testimonios.id_usuario)')
    );
    function get_uNombre() {
        return $this->_uNombre;
    }

    function set_uNombre($_uNombre) {
        $this->_uNombre = $_uNombre;
    }

        function get_imgPerfil() {
        return $this->_imgPerfil;
    }

    function set_imgPerfil($_imgPerfil) {
        $this->_imgPerfil = $_imgPerfil;
    }    
    function get_test_id() {
        return $this->_test_id;
    }

    function get_id_usuario() {
        return $this->_id_usuario;
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