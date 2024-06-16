<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('usuarios.php');

session_start();

$db = new Database();
$encontrar = $db->verificarDriver();
if ($encontrar) {
    $cnn = $db->getConnection();
    $usrModelo = new Usuarios($cnn);
    $login = $_POST["Correo"];
    $password = sha1($_POST["pws"]);
    $data = "CORREO ='" . $login . "' AND contrasenia= '" . $password . "'";
    $usuarios = $usrModelo->validaLogin($data);

    if ($usuarios) {
        $name = $usuarios['nombre'];
        $l_name = $usuarios['apellido_paterno'];
        $s_name = $usuarios['apellido_materno'];
        $_SESSION["usr"] = $name . " " . $l_name . " " . $s_name;
        $rol = $usuarios['rol'];
        if ($rol == 'CLIENTE') {
            header('Location: ../pagina/usuario_videojuegos.php');
            exit;
        } else {
            header('Location: ../pagina/adminVideojuegos.php');
            exit;
        }
    } else {
        require_once ("../pagina/Login_Usuarios.php");
        echo "<script>setTimeout(function() { alert('Usuario o contraseña incorrecta'); }, 200);</script>";
    }
}
?>