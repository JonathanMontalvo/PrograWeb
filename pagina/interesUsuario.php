<?php
include ('../layout/NavUsu.php');
?>
<!DOCTYPE html>
<html>

<head>
    <!-- CSS de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
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

<body style="background-color: #c4c4c4;">
    <h1>-</h1>
    <br><br>
    <div class="container mb-3 d-flex justify-content-center">
        <div class="bg-dark text-white p-3 rounded">
            <h2><i class="fas fa-gamepad"></i> Editar Usuario</h2>
            <form id="gameForm">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user-ninja"></i> Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingresa el correo"
                        required>
                </div>
                <div class="form-group">
                    <label for="company"><i class="fas fa-key"></i> Nueva Contraseña</label>
                    <input type="password" class="form-control" id="contrasenia" name="contrasenia"
                        placeholder="Ingresa la contraseña">
                    <div id="contraseniaError" class="error-modal"></div>
                </div>
                <div class="form-group">
                    <label for="release-date"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required
                        max="">
                </div>
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Establecer la fecha máxima para fecha_nacimiento
            var hoy = new Date();
            var fechaMaxima = new Date(hoy.getFullYear() - 18, hoy.getMonth(), hoy.getDate());
            $('#fecha_nacimiento').attr('max', fechaMaxima.toISOString().split('T')[0]);

            $.ajax({
                url: '../BD/obtener_usuario.php', // Cambia esto al nombre del archivo PHP que obtenga los datos del videojuego
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.error) {
                        console.error('Error:', response.error);
                        return;
                    }
                    // Llenar el formulario con los datos del videojuego
                    $('#correo').val(response.correo);
                    $('#fecha_nacimiento').val(response.fecha_nacimiento);
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener datos del videojuego:', error);
                }
            });

            $("#gameForm").submit(function (e) {
                e.preventDefault();

                // Ocultar todos los mensajes de error
                $('.error-modal').hide();
                var contrasenia = $('#contrasenia').val();

                var formData = $(this).serialize();

                var errores = {};

                if (contrasenia && !/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d\W_]{8,}$/.test(contrasenia)) {
                    errores['contrasenia'] = "La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.";
                }

                // Si hay errores, mostrarlos y no continuar con el envío del formulario
                if (Object.keys(errores).length > 0) {
                    for (var key in errores) {
                        $('#' + key + 'Error').text(errores[key]).show();
                    }
                    // Hide the error messages after 1 second
                    setTimeout(function () {
                        $('.error-modal').fadeOut();
                    }, 1000);
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "../BD/update_usuario.php",
                    data: formData,
                    success: function (result) {
                        console.log(result);
                        // Redirigir a adminVideojuegos.php
                        alert('Actualización realizada correctamente')
                        window.location.href = 'interesUsuario.php';
                    }
                });
            });
        });

    </script>
</body>

</html>