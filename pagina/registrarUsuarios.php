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
    <style>
        body {
            font-family: sans-serif;
        }

        form {
            opacity: 1.3;
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
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center" style="background-image: url('../pagina/assets/registro.jpeg'); background-size: cover; background-position: center;">
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
        // Esperar a que el DOM esté cargado antes de ejecutar el script
        document.addEventListener('DOMContentLoaded', function() {
            const registroForm = document.getElementById('registroForm');

            registroForm.addEventListener('submit', async (event) => {
                event.preventDefault();

                // Ocultar todos los mensajes de error
                document.querySelectorAll('.error-modal').forEach(modal => modal.style.display = 'none');

                try {
                    const response = await fetch('../BD/registro.php', {
                        method: 'POST',
                        body: new FormData(registroForm)
                    });

                    if (response.ok) {
                        alert("Usuario registrado exitosamente.");
                        registroForm.reset();
                    } else {
                        const errors = await response.json();
                        for (const field in errors) {
                            const errorModal = document.getElementById(field + 'Error');
                            if (errorModal) {
                                errorModal.textContent = errors[field];
                                errorModal.style.display = 'block';
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert("Error en el registro. Por favor, inténtalo de nuevo.");
                }
            });
        });
    </script>
</body>

</html>