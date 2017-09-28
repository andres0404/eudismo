<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/class.conexion.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MTablas {
    
    private $_idTabla;
    private $_idDato;
    private $_valor;
    private $_orden;
    
    public function __construct() {
        ;
    }
    
    /**
     * Devuelve un array del tipo array(id_dato => valor)
     * @param type $idTabla
     * @param type $idDato
     * @param type $valor Que coincida con el valor, array('funcion' => 'campo')
     * @param type $orden array(1:id 2:valor, asc desc)
     * @param type $tipReturn modifica tipo de array devuelto 1: array(id_dato => valor) 2: array(valor => valor) 3: array(id_dato => id_dato)
     */
    public static function getTablaCheckBox($idTabla, $idDato = null,$valor = NULL,$orden = null, $tipReturn = 1) {
        $obj = new self();
        $obj->_idTabla = $idTabla;
        $obj->_idDato = $idDato;
        $obj->_valor = $valor;
        $obj->_orden = $orden;
        if(!$R = $obj->_consultar()){
            return array();
        }
        $checkArray = array();
        for($i = 0; $i < count($R) ; $i++){
            if($tipReturn == 1) {
                $checkArray[$R[$i]['id_valor']] = $R[$i]['valor'];
            }else if($tipReturn == 2){
                $checkArray[$R[$i]['valor']] = $R[$i]['valor'];
            }else{
                $checkArray[$R[$i]['id_valor']] = $R[$i]['id_valor'];
            }
        }
        return $checkArray;
    }
    /**
     * Cosultar maestro de tablas
     * @return boolean
     */
    private function _consultar() {
        $where = "";
        if(!empty($this->_idDato)){
            $where = "AND b.id_valor = $this->_idDato ";
        }
        if(!empty($this->_valor)){
            if(is_array($this->_valor)){
                $aux = each($this->_valor);
                $where = "AND b.valor {$aux['key']} '{$aux['value']}' ";
            }else{
                $where = "AND b.valor = '$this->_valor' ";
            }
            
        }
        $query = "SELECT  a.nom_tabla,b.* FROM 
mt_tablas a,
mt_contenidos b
WHERE a.id_tablas = {$this->_idTabla}
AND a.estado = 1 $where
AND a.id_tablas  = b.id_tabla
AND b.estado = 1";
        
        if(is_array($this->_orden) && count($this->_orden) == 2){
            $query .= (" ORDER BY " . ($this->_orden[0] == 1 ? "id_valor " : "valor ") . $this->_orden[1]  );
        }
        $con = ConexionSQL::getInstance();
        $id = $con->consultar($query);
        if($res = $con->obenerFila($id)){
            $R = array();
            do{
                $aux = array();
                foreach($res as $key => $valor){
                    if(!is_numeric($key)){
                        $aux[$key] = $valor;
                    }
                }
                $R[] = $aux;
            }while($res = $con->obenerFila($id));
            return $R;
        }
        return false;
    }
}