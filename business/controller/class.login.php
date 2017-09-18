<?php
        header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        
include_once '../globals.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/DAO/DAO_Usuarios.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/class.sessions.php';

class Login{
    
    private $_url = "";

    private $_usuario;
    private $_clave;
    private $_tipo_usuario;
    private $_nombre;

    public static function run(){
        $_obj = new self();
        $_obj->_establecerDatos();
        $_obj->_verificarDatosUsuario();
    }
    
    private function _establecerDatos(){
        //print_r($_POST);
        $this->_usuario = $_POST['u_correo'];
        $this->_clave = sha1($_POST['u_clave']);
    }
    /**
     * Verificacion y logueo de usuario
     */
    private function _verificarDatosUsuario() {
        $_objUsu = new DAO_Usuarios();
        $_objUsu->set_u_correo($this->_usuario);
        $_objUsu->set_u_clave($this->_clave);
        $_objUsu->set_u_activo(1);
        //$_objUsu->set_u_tipo_usuario(array(4,5)); // administrador
        //$_objUsu->set_namespace("uvd_usuarios");
        //print_r($_objUsu);
        $_objUsu->consultar();
        //echo $_objUsu->getQuery();
        $id = $_objUsu->get_id_usuario();
        $this->_nombre = $_objUsu->get_u_nombre();
        $this->_tipo_usuario = $_objUsu->get_u_tipousuario();
        //print_r($_objUsu);
        if(empty($id)){
            $this->_respuesta(false);
        }else{
            SessionPostulantes::initSession(
                    $id,
                    $_objUsu->get_u_nombre(),
                    $_objUsu->get_u_ISOLengua(),
                    $_objUsu->get_u_lengua(),
                    $_objUsu->get_u_correo(),
                    $_objUsu->get_u_tipo_usuario()
                );
            $this->_respuesta(true);
        }
    }
    /**
     * 
     * @param type $respuesta
     */
    private function _respuesta($respuesta){
        $arrRespu = array();
        if($respuesta){
            $arrRespu = array("ok" => 1, "url" => $this->_url, "mensaje" => "Bienvenido {$this->_nombre} ", "tipo_usuario" => $this->_tipo_usuario, "token" => 1);
        }else{
            $arrRespu = array("ok" => "0", "url" => "", "mensaje" => "Error en las credenciales", "tipo_usuario" => "","token" => 0);
        }
        header('Content-type: application/json');   
        //echo "oh!";
        echo json_encode($arrRespu);
    }
    
    
}

if(isset($_POST['u_correo']) && isset($_POST['u_clave'])){
    Login::run();
}