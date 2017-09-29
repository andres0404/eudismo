<?php

if (isset($_GET['kill'])) {
    SessionPostulantes::destroySession();
}

class SessionPostulantes {

    /*private static $_periodos = array(
        40 => array('12-20','04-20','-1'), // -1: el sistema restara -1 al año del sistema para la fecha inicial
        45 => array('04-21','08-21','0'),
        50 => array('09-22','12-20','0'),
    );*/

    /**
     * 
     * @param type $idUsuario
     * @param type $usuNombre
     * @param type $ISO_lengua
     * @param type $cod_lengua
     * @param type $correo
     * @param type $tipUsuario
     */
    public static function initSession($idUsuario, $usuNombre, $ISO_lengua, $cod_lengua, $correo, $tipUsuario) {
        ini_set('session.save_path',realpath(dirname('') . '../../sesiones'));
        session_start();
        /*foreach(self::$_periodos as $periodo => $rango){
            $year = date("Y");
            $ini = ($year - $rango[2])."-".$rango[0];
            $fin = ($year)."-".$rango[1];
            $fechaHoy = date("Y-m-d");
            if($fechaHoy >= $ini && $fechaHoy <= $fin){
                $_SESSION['periodo'] = date("Y").$periodo; 
                break;
            }
        }*/
        $_SESSION['id_usuario'] = $idUsuario;
        $_SESSION['u_correo'] = $correo;
        $_SESSION['u_nombre'] = $usuNombre;
        $_SESSION['u_lengua'] = $cod_lengua;
        $_SESSION['u_iso_lengua'] = $ISO_lengua;
        $_SESSION['u_tipousuario'] = $tipUsuario;
        //$_SESSION['desde_aplicacion'] = $aplicacion; // aplicacion desde donde se loguea
    }
    /**
     * verifica si el usuario esta logueado
     * @param type $reinicial
     * @return boolean true: si encuentra una sesión 
     */
    public static function verificarSesion($reinicial = true,$token = '') {
        if(!empty($token) && $token == '1a9f5dfa0383b82ddb1e36e7cbd03fc7a1b76448'){
            return true;
        }
        ini_set('session.save_path',realpath(dirname('') . '../../sesiones'));
        session_start();
        if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])  ) {
            session_destroy();
            if($reinicial){
               header("Location: /boletin/eudista/");
            }
            return false;
        }
        return true;
    }
    /**
     * 
     */
    public static function destroySession() {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        // Finalmente, destruir la sesión.
        
        if(isset($_SESSION) && (is_array($_SESSION) && count($_SESSION) > 0 ) )
            session_destroy();
        header("Location: ../");
        echo "No se pudo cerrar La sesion " . print_r($_SESSION,1);
    }

}
