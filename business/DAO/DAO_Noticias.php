<?php

include_once 'class.DAO.php';

class DAO_Noticias extends DAOGeneral {
    
    
    protected $_novt_id;
    protected $_novt_fecha;
    protected $_novt_estado;

    protected $_tabla = 'novedades_noticias';
    protected $_primario = 'novt_id';
    protected $_ordenar = array();
    
    protected $_mapa = array(
        'novt_id' => array('tipodato' => 'integer'),
        'novt_fecha' => array('tipodato' => 'integer'),
        'novt_estado' => array('tipodato' => 'varchar')
    );
    function get_novt_id() {
        return $this->_novt_id;
    }

    function get_novt_fecha() {
        return $this->_novt_fecha;
    }

    function get_novt_estado() {
        return $this->_novt_estado;
    }

    function set_novt_id($_novt_id) {
        $this->_novt_id = $_novt_id;
    }

    function set_novt_fecha($_novt_fecha) {
        $this->_novt_fecha = $_novt_fecha;
    }

    function set_novt_estado($_novt_estado) {
        $this->_novt_estado = $_novt_estado;
    }



}
