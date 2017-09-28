<?php


class ConexionSQL {
    private static $_conData;
    private static $_obj = null;
    private $_error;
    private $_errno;
    private $_link;
    /**
     *
     * @var Conexiones
     */
    private $_conexiones ;
    /**
     * Antes de generar una conexion ejecutar este metodo para establecer a que base de datos se conectara
     * @param Conexiones $_obj
     */
    public static function setConData(Conexiones $_obj){
        self::$_conData = $_obj;
    }
    /**
     * Obtener instancia de conexion (previamente debio ejecutarse el metodo setConData en caso que la conexion haya fallado)
     * @return ConexionSQL
     */
    public static function getInstance(){
        if(self::$_obj === null){
            self::$_obj = new self();
        }
        return self::$_obj;
    }
    
    public function __construct() {
        // generar conexion
        if(!(self::$_conData instanceof Conexiones)){
            self::setConData(Conexiones::getConLocal());
        }
        $this->_conectar();
    }
    /**
     * TRANSACCION
     */
    public static function begin(){
        $con = self::getInstance();
        $con->consultar("BEGIN");
    }
    public static function commit(){
        $con = self::getInstance();
        $con->consultar("COMMIT");
    }
    public static function rollback(){
        $con = self::getInstance();
        $con->consultar("ROLLBACK");
    }
    /**
     * genera la conexion con la base de datos
     * @throws ConexionSQLException
     */
    private function _conectar(){
        //print_r(self::$_conData);
        if(!$this->_link = mysqli_connect(self::$_conData->getServer(), self::$_conData->getUsername(), self::$_conData->getPassword())){
            throw new ConexionSQLException("No se pudo conectar. ".  mysqli_error($this->_link));
        }
        if(!mysqli_select_db($this->_link,self::$_conData->getDatabase())){
            throw new ConexionSQLException("No se pudo seleccionar base de datos ".  mysqli_error($this->_link));
        }
        mysqli_set_charset($this->_link,'utf8');
    }
    /**
     * 
     * @param type $query
     * @return type
     */
    public function consultar($query){
        if(!$result = mysqli_query($this->_link,$query)){
            $this->_errno = mysqli_errno($this->_link);
            $this->_error = mysqli_error($this->_link);
        }
        return $result;
    }
    /**
     * Obtener el ultimo id creado en la insercion
     * @return integer
     */
    public function getUltimoIdInsertado(){
        return mysqli_insert_id($this->_link);
    }
    /**
     * Obtener numero de filas de una consulta
     * @param type $id
     * @return type
     */
    public function getNumeroFilasConsultadas($id){
        return mysqli_num_rows($id);
    }
    /**
     * 
     * @param type $id
     * @return type
     */
    public function obenerFila($id) {
        if(!empty($id)){
            return mysqli_fetch_array($id, MYSQL_ASSOC);
        }
        return false;
    }
    /**
     * 
     * @return type
     */
    function get_error() {
        return $this->_error;
    }
    
    function get_errno(){
        return $this->_errno;
    }


}
class ConexionSQLException extends Exception{}

class Conexiones{
    
    private $_server;
    private $_username;
    private $_password;
    private $_database;
    
    private static $_conexiones = array(
        'local' => array(
            'server' => '10.0.30.28',
            'username' => 'uvd_usr',
            'password' => '1.5Y7u.p3Bv2',
            'database' => 'uvd_eudista'          
        ),
        'localhost' => array(
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'uvd_eudista'        
        ),
    );
    public function getServer(){
        return $this->_server;
    }
    public function getUsername(){
        return $this->_username;
    }
    public function getPassword(){
        return $this->_password;
    }
    public function getDatabase(){
        return $this->_database;
    }
    /**
     * 
     * @return Conexiones
     */
    public static function getConLocal(){
         return self::_getConexion('local');
    }
    /**
     * 
     * @param type $nomConexion
     * @return \self
     */
    private static function _getConexion($nomConexion){
        $_obj = new self();
        $_obj->_server = self::$_conexiones[$nomConexion]['server'];
        $_obj->_username = self::$_conexiones[$nomConexion]['username'];
        $_obj->_password = self::$_conexiones[$nomConexion]['password'];
        $_obj->_database = self::$_conexiones[$nomConexion]['database'];
        return $_obj;
    }
}

