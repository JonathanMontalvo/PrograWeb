<?php
require_once('database.php');
require_once('orm.php');
require_once('usuarios.php');

$db = new Database();
$encontrar = $db->verificarDriver();
if ($encontrar) {
    $cnn = $db->getConnection();
    $usrModelo = new Usuarios($cnn);
    $login = $_POST["Correo"];
    $password = $_POST["pws"];
    $data = "CORREO ='" . $login . "' AND contrasenia= '" . $password . "'";
    $usuarios = $usrModelo->validaLogin($data);

    if ($usuarios) {
        $usr = $usuarios['nombre'];
        $_SESSION["usr"] = $usr;
        $rol = $usuarios['rol'];
       
        if ($rol == 'CLIENTE') {
            // require_once ("../sesion/homeUsr.php");
        } else {
            require_once ("../pagina/adminVideojuegos.php");
        }
    } else {
        // require_once ("../sesion/index.php");
    }
}
?>
