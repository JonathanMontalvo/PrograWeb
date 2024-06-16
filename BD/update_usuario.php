<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('usuarios.php');
session_start();

function validarDatos($data)
{
    $errores = [];

    // Validar que los campos no estén vacíos o solo contengan espacios en blanco
    foreach ($data as $campo => $valor) {
        if (trim($valor) === '') {
            $errores[] = "El campo '$campo' no puede estar vacío o solo contener espacios en blanco.";
        }
    }

    // Validar que el correo sea válido
    if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo electrónico no es válido.";
    }

    // Validación de fecha de nacimiento
    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $data['fecha_nacimiento']);
    $hoy = new DateTime();
    $minimo = $hoy->modify('-18 years');

    if (!$fechaNacimiento) {
        $errores['fecha_nacimiento'] = "La fecha de nacimiento no es válida. Usa el formato YYYY-MM-DD.";
    } elseif ($fechaNacimiento >= $minimo) {
        $errores['fecha_nacimiento'] = "Debes tener al menos 18 años.";
    }

    // Validar que la contraseña tenga mayúsculas, minúsculas y números
    if (isset($data['contrasenia']) && !preg_match("/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d\W_]{8,}$/", $data['contrasenia'])) {
        $errores['contrasenia'] = "La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.";
    }

    return $errores;
}

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $usuariosModelo = new Usuarios($cnn);

    // Verificar si se recibió un ID válido
    $id = $_SESSION["id"];

    // Datos para actualizar
    $actualizar = [
        'correo' => $_POST['correo'],
        'fecha_nacimiento' => $_POST['fecha_nacimiento']
    ];

    // Si la contraseña se envía, agregarla a los datos para actualizar
    if (!empty($_POST['contrasenia'])) {
        $actualizar['contrasenia'] = $_POST['contrasenia'];
    }

    // Validar los datos antes de la actualización
    $errores = validarDatos($actualizar);

    if (empty($errores)) {
        // Transformar la contraseña a sha1 después de la validación
        if (isset($actualizar['contrasenia'])) {
            $actualizar['contrasenia'] = sha1($_POST['contrasenia']);
        }
        // Actualizar el usuario
        if ($usuariosModelo->updateByID($id, $actualizar)) {
            echo "Datos actualizados correctamente.";
        } else {
            echo "No se logró actualizar.";
        }
    } else {
        foreach ($errores as $error) {
            echo $error . "<br>";
        }
    }
}
?>