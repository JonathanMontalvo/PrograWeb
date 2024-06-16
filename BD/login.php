<?php
// Incluir archivos necesarios
require_once('database.php');
require_once('orm.php');
require_once('usuarios.php');

// Iniciar sesión
session_start();

// Función para validar correo
function validarCorreo($correo)
{
    $errores = false;
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores = true;
    }
    return $errores;
}

// Verificar si se está recibiendo la solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Crear instancia de la base de datos
    $db = new Database();
    $encontrar = $db->verificarDriver();

    if ($encontrar) {
        // Establecer conexión a la base de datos
        $cnn = $db->getConnection();
        $usrModelo = new Usuarios($cnn);

        // Obtener datos del formulario POST
        $login = $_POST["Correo"];
        $password = sha1($_POST["pws"]); // NOTA: sha1 no es seguro, considera usar password_hash y password_verify

        // Construir la condición para la consulta
        $data = "CORREO ='" . $login . "' AND contrasenia= '" . $password . "'";

        // Validar el correo electrónico
        $errores = validarCorreo($login);

        if ($errores == false) {
            // Validar el inicio de sesión
            $usuarios = $usrModelo->validaLogin($data);

            if ($usuarios) {
                // Obtener información del usuario
                $name = $usuarios['nombre'];
                $l_name = $usuarios['apellido_paterno'];
                $s_name = $usuarios['apellido_materno'];
                $_SESSION["usr"] = $name . " " . $l_name . " " . $s_name;
                $rol = $usuarios['rol'];

                // Preparar la respuesta JSON con éxito y rol del usuario
                if ($rol == 'CLIENTE') {
                    $response = array(
                        'success' => true,
                        'role' => "CLIENTE"  // Rol del usuario
                    );
                } else {
                    $response = array(
                        'success' => true,
                        'role' => "ADMIN"  // Rol del usuario
                    );
                }
            } else {
                // Respuesta de inicio de sesión fallido
                $response = array('success' => false);
            }
        } else {
            // Respuesta de correo electrónico no válido
            $response = array('success' => false);
        }
        header('Content-Type: application/json');

        // Devolver la respuesta JSON al cliente
        echo json_encode($response);
        exit; // Salir para evitar cualquier salida adicional
    }
}
?>
