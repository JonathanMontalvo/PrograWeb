<?php
require_once('database.php'); // Asegúrate de que la ruta sea correcta
require_once('orm.php');

// Crear una instancia de Database para obtener la conexión
$db = new Database();
$conn = $db->getConnection();

// Crear una instancia de Orm con la conexión
$orm = new Orm(null, 'usuarios', $conn);

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido_paterno = trim($_POST['apellido_paterno']);
    $apellido_materno = trim($_POST['apellido_materno']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = trim($_POST['correo']);
    $contrasenia = $_POST['contrasenia'];

    // Validaciones mejoradas
    if (!preg_match("/^[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]+$/", $nombre)) {
        $errores['nombre'] = "El nombre solo puede contener letras y espacios.";
    }
    if (!preg_match("/^[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]+$/", $apellido_paterno)) {
        $errores['apellido_paterno'] = "El apellido paterno solo puede contener letras y espacios.";
    }
    if (!preg_match("/^[a-zA-Z\sñÑáéíóúÁÉÍÓÚ]+$/", $apellido_materno)) {
        $errores['apellido_materno'] = "El apellido materno solo puede contener letras y espacios.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo electrónico no es válido.";
    }

    // Validación de contraseña (al menos 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial)
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $contrasenia)) {
        $errores['contrasenia'] = "La contraseña debe tener al menos 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial.";
    }

    // Validación de fecha de nacimiento (mayor de 18 años)
    $hoy = new DateTime();
    $minimo = $hoy->modify('-18 years');
    $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fecha_nacimiento);
    if (!$fechaNacimiento || $fechaNacimiento >= $minimo) {
        $errores['fecha_nacimiento'] = "Debes ser mayor de 18 años.";
    }

    // Encriptar la contraseña (SHA1)
    $contraseniaEncriptada = sha1($contrasenia);

    if (empty($errores)) {
        try {
            // Preparar los datos para el ORM (sin los dos puntos en las claves)
            $data = [
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'fecha_nacimiento' => $fecha_nacimiento,
                'correo' => $correo,
                'contrasenia' => $contraseniaEncriptada,
                'rol' => "CLIENTE"
            ];

            // Usar el método insert del ORM
            if ($orm->insert($data)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'Error al registrar usuario.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Error en la base de datos.']);
            error_log('Error al registrar usuario: ' . $e->getMessage());
        }
    } else {
        echo json_encode(['errors' => $errores]);
    }
}
?>