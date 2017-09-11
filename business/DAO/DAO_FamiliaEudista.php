<?php
include_once 'class.DAO.php'; 

class DAO_FamiliaEudista extends DAOGeneral {
    
    protected $_id_usuario;
    protected $_imei;
    protected $_usu_nombre;
    
    protected $_tabla = 'scan_usuarios';
    protected $_primario = 'id_usuario';
    protected $_ordenar = array();
    protected $_mapa = array(
        //  id_elem => array('tipodato' ,'label','ayuda','opciones'=>array('valor'=>'label'), 'sql')
            'id_usuario' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'),
        'id_usuario' => array('tipodato' => 'integer'), 
        );
        function get_id_usuario() {
            return $this->_id_usuario;
        }

        function get_imei() {
            return $this->_imei;
        }

        function get_usu_nombre() {
            return $this->_usu_nombre;
        }

        function set_id_usuario($_id_usuario) {
            $this->_id_usuario = $_id_usuario;
        }

        function set_imei($_imei) {
            $this->_imei = $_imei;
        }

        function set_usu_nombre($_usu_nombre) {
            $this->_usu_nombre = $_usu_nombre;
        }


}