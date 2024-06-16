<?php
include ('../layout/Nav.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/Estilos.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            font-family: sans-serif;
        }

        form {
            opacity: 1.3;
        }

        body {
            padding-top: 70px;
            /* Adjust this value as needed to fit your navbar */
        }


        .error-modal {
            display: none;
            position: absolute;
            background-color: #f44336;
            color: white;
            padding: 5px;
            border-radius: 5px;
            z-index: 1;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center"
        style="background-image: url('../pagina/assets/registro.jpeg'); background-size: cover; background-position: center;">
        <form id="registroForm" method="post" class="bg-white p-4 rounded shadow-sm" style="width: 300px;">
            <h2 class="text-center mb-3">Registro de Usuario</h2>

            <div class="mb-2">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
                <div id="nombreError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="apellido_paterno" class="form-label">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                <div id="apellidoPaternoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="apellido_materno" class="form-label">Apellido Materno:</label>
                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
                <div id="apellidoMaternoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                <div id="fechaNacimientoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
                <div id="correoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="contrasenia" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                <div id="contraseniaError" class="error-modal"></div>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrar</button>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            // Establecer la fecha máxima para fecha_nacimiento
            var hoy = new Date();
            var fechaMaxima = new Date(hoy.getFullYear() - 18, hoy.getMonth(), hoy.getDate());
            $('#fecha_nacimiento').attr('max', fechaMaxima.toISOString().split('T')[0]);

            $("#registroForm").submit(function (e) {
                e.preventDefault(); // Prevent the default form submission

                // Ocultar todos los mensajes de error
                $('.error-modal').hide();

                var nombre = $('#nombre').val();
                var apellido_paterno = $('#apellido_paterno').val();
                var apellido_materno = $('#apellido_materno').val();
                var correo = $('#correo').val();
                var contrasenia = $('#contrasenia').val();
                var fecha_nacimiento = $('#fecha_nacimiento').val();

                var errores = {};

                // Validaciones Mejoradas
                if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/.test(nombre)) {
                    errores['nombre'] = "El nombre solo puede contener letras y acentos.";
                }
                if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/.test(apellido_paterno)) {
                    errores['apellido_paterno'] = "El apellido paterno solo puede contener letras y acentos.";
                }
                if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/.test(apellido_materno)) {
                    errores['apellido_materno'] = "El apellido materno solo puede contener letras y acentos.";
                }
                if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(correo)) {
                    errores['correo'] = "El correo electrónico no es válido.";
                }
                if (!/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/.test(contrasenia)) {
                    errores['contrasenia'] = "La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.";
                }

                // Si hay errores, mostrarlos y no continuar con el envío del formulario
                if (Object.keys(errores).length > 0) {
                    for (var key in errores) {
                        $('#' + key + 'Error').text(errores[key]).show();
                    }
                    return;
                }

                // Si no hay errores, continuar con el envío del formulario
                var formData = $(this).serialize(); // Serialize the form data

                $.ajax({
                    type: "POST",
                    url: '../BD/registro.php', // The URL where you want to POST the data
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        alert("Usuario registrado exitosamente.");
                        $('#registroForm').trigger("reset");
                        // Redirigir a adminVideojuegos.php
                        window.location.href = 'Login_Usuarios.php';
                    },
                    error: function (xhr, status, error) {
                        const errors = JSON.parse(xhr.responseText);
                        for (const field in errors) {
                            $('#' + field + 'Error').text(errors[field]).show();
                        }
                    }
                });
            });
        });

    </script>
</body>

</html>