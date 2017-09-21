<?php
        header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        
//include_once '../globals.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/DAO/DAO_Usuarios.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/eudista/business/class.sessions.php';

class Login{
    
    private $_url = "";

    private $_usuario;
    private $_clave;
    private $_tipo_usuario;
    private $_nombre;

    public static function run(){
        if(isset($_POST['funcion'])){
            $_obj = new self();
            switch ($_POST['funcion']){
                case 1:// loguear
                    $_obj->_establecerDatos($_POST['u_correo'],$_POST['u_correo']);
                    $_obj->_verificarDatosUsuario();
                    break;
                case 2: // Registrar + logueo
                    $_obj->_registrarYLoguear();
                    break;
                case 3: // registrar
                    $_obj->_registrarUsuario();
                    break;
            }
        }
    }
    /**
     * 
     * @param type $uCorreo
     * @param type $uClave
     */
    private function _establecerDatos($uCorreo,$uClave){
        //print_r($_POST);
        $this->_usuario = $uCorreo;
        $this->_clave = sha1($uClave);
    }
    /**
     * Registrar y loguear usuario
     */
    private function _registrarYLoguear() {
        $_objUsu = $this->_registrarUsuario();
        if(!($_objUsu instanceof DAO_Usuarios)){
            $this->_respuesta(false, "No se pudo registrar usuario");
            return false;
        }
        $this->_establecerDatos($_objUsu->get_u_correo(),$_POST['u_correo']);
        $this->_verificarDatosUsuario();
    }
    /**
     * Registrarse 
     * @return boolean|\DAO_Usuarios
     */
    private function _registrarUsuario() {
        $_objUsu = new DAO_Usuarios();
        if(isset($_POST['id_usuario'])){
            $_objUsu->set_id_usuario($_POST['id_usuario']);
        }
        //$_objUsu->set_u_tipousuario($_POST['u_tipousuario']);
        $_objUsu->set_u_tipousuario(1);
        $_objUsu->set_u_lengua($_POST['u_lengua']);
        $_objUsu->set_u_nombre($_POST['u_nombre']);
        $_objUsu->set_u_correo($_POST['u_correo']);
        $_objUsu->set_u_clave(sha1($_POST['u_correo']));
        $_objUsu->set_u_activo(1);
        $_objUsu->set_u_img_perfil($_POST['u_img_perfil']);
        //print_r($_objUsu);
        if(!$_objUsu->guardar()) {
            return false;
        }
        return $_objUsu;
    }
    
    /**
     * Verificacion y logueo de usuario
     */
    private function _verificarDatosUsuario() {
        $_objUsu = new DAO_Usuarios();
        $_objUsu->set_u_correo($this->_usuario);
        //$_objUsu->set_u_clave($this->_clave);
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
                    $_objUsu->get_u_tipousuario()
                );
            $this->_respuesta(true,'Bienvenido a nuestra App Eudista',$_objUsu->getArray());
        }
    }
    /**
     * 
     * @param type $respuesta
     */
    private function _respuesta($respuesta,$mensaje = '',$datos = null){
        $arrRespu = array();
        if($respuesta){
            $arrRespu = array("ok" => 1, 
                "url" => $this->_url, 
                "mensaje" => (empty($mensaje) ? "Bienvenido {$this->_nombre} " : $mensaje) , 
                "tipo_usuario" => $this->_tipo_usuario, 
                "datos" => $datos,
                "token" => 1);
        }else{
            $arrRespu = array("ok" => "0", "url" => "", "mensaje" => (empty($mensaje) ? "Error en las credenciales" : $mensaje), "tipo_usuario" => "","token" => 0);
        }
        header('Content-type: application/json');   
        //echo "oh!";
        echo json_encode($arrRespu);
    }
    
    
}

if(isset($_POST['u_correo']) && isset($_POST['u_nombre'])){
    Login::run();
}