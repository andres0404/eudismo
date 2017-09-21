<?php
include_once 'class.DAO.php'; 

class DAO_FamiliaEudista extends DAOGeneral {
    
    protected $_fame_id;
    protected $_id_usuario;
    protected $_fame_fecha;
    protected $_fame_id_padre;
    protected $_fame_estado;
    
    
    protected $_tabla = 'familia_eudista';
    protected $_primario = 'fame_id';
    protected $_ordenar = array();
    
    
    protected $_mapa = array(
            'fame_id' => array('tipodato' => 'integer'),
            'id_usuario' => array('tipodato' => 'integer'),
            'fame_fecha' => array('tipodato' => 'date'),
            'fame_id_padre' => array('tipodato' => 'integer'),
            'fame_estado' => array('tipodato' => 'integer')
        );
        function get_fame_id_padre() {
            return $this->_fame_id_padre;
        }

        function set_fame_id_padre($_fame_id_padre) {
            $this->_fame_id_padre = $_fame_id_padre;
        }

                function get_fame_id() {
            return $this->_fame_id;
        }

        function get_id_usuario() {
            return $this->_id_usuario;
        }

        function get_fame_fecha() {
            return $this->_fame_fecha;
        }


        function get_fame_estado() {
            return $this->_fame_estado;
        }

        function set_fame_id($_fame_id) {
            $this->_fame_id = $_fame_id;
        }

        function set_id_usuario($_id_usuario) {
            $this->_id_usuario = $_id_usuario;
        }

        function set_fame_fecha($_fame_fecha) {
            $this->_fame_fecha = $_fame_fecha;
        }

      

        function set_fame_estado($_fame_estado) {
            $this->_fame_estado = $_fame_estado;
        }



}