
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: sans-serif;
            background-image: url('./assets/registro.jpeg'); /* Reemplaza con la ruta a tu imagen */
            background-size: cover; /* Cubrir toda la pantalla */
            background-position: center; /* Centrar la imagen */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: rgba(255, 255, 255, 0.7); /* Fondo semitransparente para el formulario */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            width: 100%; /* Ancho completo del botón */
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
        }
    </style>
</head>
<body>

<form method="post">
    <h2>Registro de Usuario</h2>
    </label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>
    <div id="nombreError" class="error-modal"></div><br><br>

    </label for="apellido_paterno">Apellido Paterno:</label>
    <input type="text" id="apellido_paterno" name="apellido_paterno" required>
    <div id="apellidoPaternoError" class="error-modal"></div><br><br>

    </label for="apellido_materno">Apellido Materno:</label>
    <input type="text" id="apellido_materno" name="apellido_materno" required>
    <div id="apellidoMaternoError" class="error-modal"></div><br><br>
    
    </label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
    <div id="fechaNacimientoError" class="error-modal"></div><br><br>

    <label for="correo">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" required>
    <div id="correoError" class="error-modal"></div><br><br>

    <label for="contrasenia">Contraseña:</label>
    <input type="password" id="contrasenia" name="contrasenia" required>
    <div id="contraseniaError" class="error-modal"></div><br><br>

    <input type="submit" value="Registrar">
</form>

<script>
    const form = document.querySelector('form');
    const errorModals = document.querySelectorAll('.error-modal');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        errorModals.forEach(modal => modal.style.display = 'none');

        try {
            const response = await fetch('../BD/registro.php', {
                method: 'POST',
                body: new FormData(form)
            });

            if (response.ok) {
                alert("Usuario registrado exitosamente.");
                form.reset(); // Limpiar el formulario después del registro exitoso
            } else {
                const errors = await response.json();

                for (const field in errors) {
                    const errorModal = document.getElementById(field + 'Error');
                    if (errorModal) {
                        errorModal.textContent = errors[field];
                        errorModal.style.display = 'block';

                        const inputRect = document.getElementById(field).getBoundingClientRect();
                        errorModal.style.left = (inputRect.right + 5) + 'px';
                        errorModal.style.top = inputRect.top + 'px';
                    }
                }
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>

</body>
</html>
