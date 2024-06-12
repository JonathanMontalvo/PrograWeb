<?php
// Dentro de la misma página, después del formulario y el script
class Database
{
    private $connection;

    public function __construct()
    {
    }

    public function verificarDriver()
    {
        $miArray = (PDO::getAvailableDrivers());
        $encontrado = false;
        foreach ($miArray as $n) {
            if ($n == 'mysql') {
                $encontrado = true;
                break;
            }
        }
        return $encontrado;
    }

    public function getConnection()
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $dns = "mysql:host=localhost;dbname=venta_videojuegos";
        $user = "root";
        $password = "";
        $this->connection = new PDO($dns, $user, $password, $options);
        $this->connection->exec("SET CHARACTER SET UTF8");
        return $this->connection;
    }
}

$db = new Database();

// Validaciones del lado del servidor
$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $correo = $_POST['correo'];
    $contrasenia = $_POST['contrasenia'];

    // Validaciones Mejoradas
    if (!preg_match("/^[a-zA-Z]+$/", $nombre)) {
        $errores['nombre'] = "El nombre solo puede contener letras.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $apellido_paterno)) {
        $errores['apellido_paterno'] = "El apellido paterno solo puede contener letras.";
    }
    if (!preg_match("/^[a-zA-Z]+$/", $apellido_materno)) {
        $errores['apellido_materno'] = "El apellido materno solo puede contener letras.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo electrónico no es válido.";
    }
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $contrasenia)) {
        $errores['contrasenia'] = "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
    }

    // Validación de fecha de nacimiento (puedes usar una expresión regular o strtotime para verificar el formato)
    $fechaNacimientoTimestamp = strtotime($fecha_nacimiento);
    if ($fechaNacimientoTimestamp === false) {
        $errores['fecha_nacimiento'] = "La fecha de nacimiento no es válida.";
    } else {
        $fecha_nacimiento = date('Y-m-d', $fechaNacimientoTimestamp); // Convertir a formato YYYY-MM-DD
    }

    if (empty($errores)) {
        try {
            $conn = $db->getConnection();

            // Hash de la contraseña (¡MUY IMPORTANTE!)
            $hashed_password = password_hash($contrasenia, PASSWORD_DEFAULT);

            // Prepared Statements (forma más segura)
            $sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, fecha_nacimiento, correo, contrasenia, rol) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $correo, $hashed_password, "CLIENTE"]);

            // Enviar respuesta de éxito
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        } catch (PDOException $e) {
            // Enviar error en formato JSON
            header('Content-Type: application/json');
            http_response_code(500); // Código de error del servidor
            echo json_encode(['error' => 'Error al registrar usuario: ' . $e->getMessage()]);
            exit;
        }
    } else {
        // Enviar errores de validación en formato JSON
        header('Content-Type: application/json');
        http_response_code(400); // Código de solicitud incorrecta
        echo json_encode($errores);
        exit;
    }
}
?>