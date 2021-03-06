<?php

include_once 'class.DAO.php';

class DAO_Usuarios extends DAOGeneral {

    protected $_id_usuario;
    protected $_u_tipousuario;
    protected $_u_lengua;
    protected $_u_ISOLengua;
    protected $_u_nombre;
    protected $_u_correo;
    protected $_u_clave;
    protected $_u_activo;
    protected $_u_img_perfil;

    protected $_tabla = 'usuarios';
    protected $_primario = 'id_usuario';
    protected $_ordenar = array();
    
    protected $_mapa = array(
        'id_usuario' => array('tipodato' => 'integer'),
        'u_tipousuario' => array('tipodato' => 'integer'),
        'u_lengua' => array('tipodato' => 'integer'),
        'u_ISOLengua' => array('tipodato' => 'varchar','sql' => '(SELECT valor FROM mt_contenidos WHERE mt_contenidos.id_tabla = 4 AND mt_contenidos.id_valor = usuarios.u_lengua limit 1)'),
        'u_nombre' => array('tipodato' => 'varcahr'),
        'u_correo' => array('tipodato' => 'varchar'),
        'u_clave' => array('tipodato' => 'varchar'),
        'u_activo' => array('tipodato' => 'integer'),
        'u_img_perfil' => array('tipodato' => 'varchar')
    );
    
    function verificarCorreo(){
        $query = "SELECT * FROM usuarios WHERE u_correo = '$this->_u_correo'";
        
    }
    
    function get_u_img_perfil() {
        return $this->_u_img_perfil;
    }

    function set_u_img_perfil($_u_img_perfil) {
        $this->_u_img_perfil = $_u_img_perfil;
    }    
    function get_u_ISOLengua() {
        return $this->_u_ISOLengua;
    }

    function set_u_ISOLengua($_u_ISOLengua) {
        $this->_u_ISOLengua = $_u_ISOLengua;
    }
    function get_id_usuario() {
        return $this->_id_usuario;
    }

    function set_id_usuario($_id_usuario) {
        $this->_id_usuario = $_id_usuario;
    }    
    function get_u_tipousuario() {
        return $this->_u_tipousuario;
    }

    function get_u_lengua() {
        return $this->_u_lengua;
    }

    function get_u_nombre() {
        return $this->_u_nombre;
    }

    function get_u_correo() {
        return $this->_u_correo;
    }

    function get_u_clave() {
        return $this->_u_clave;
    }

    function get_u_activo() {
        return $this->_u_activo;
    }

    function set_u_tipousuario($_u_tipousuario) {
        $this->_u_tipousuario = $_u_tipousuario;
    }

    function set_u_lengua($_u_lengua) {
        $this->_u_lengua = $_u_lengua;
    }

    function set_u_nombre($_u_nombre) {
        $this->_u_nombre = $_u_nombre;
    }

    function set_u_correo($_u_correo) {
        $this->_u_correo = $_u_correo;
    }

    function set_u_clave($_u_clave) {
        $this->_u_clave = $_u_clave;
    }

    function set_u_activo($_u_activo) {
        $this->_u_activo = $_u_activo;
    }


}
