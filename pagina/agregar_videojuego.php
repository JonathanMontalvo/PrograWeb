<!DOCTYPE html>
<html>

<head>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!--  <style>
        body {
            /* Sustituye 'URL_DEL_GIF' con la URL de tu GIF */
            background: url('./assets/fondo_agregar_videojuego.gif') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
    </style>-->
</head>

<body>
    <div class="container mt-3 d-flex justify-content-center">
        <div class="bg-dark text-white p-3 rounded">
            <h2><i class="fas fa-gamepad"></i> Agregar un nuevo videojuego</h2>
            <form id="gameForm">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user-ninja"></i> Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el nombre"
                        required>
                </div>
                <div class="form-group">
                    <label for="rating"><i class="fas fa-star"></i> Clasificación</label>
                    <input type="text" class="form-control" id="rating" name="rating"
                        placeholder="Ingresa la clasificación" required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-scroll"></i> Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="Ingresa la descripción" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price"><i class="fas fa-tag"></i> Precio</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                        placeholder="Ingresa el precio" required>
                </div>
                <div class="form-group">
                    <label for="company"><i class="fas fa-industry"></i> Compañía</label>
                    <input type="text" class="form-control" id="company" name="company"
                        placeholder="Ingresa la compañía" required>
                </div>
                <div class="form-group">
                    <label for="quantity"><i class="fas fa-dice"></i> Cantidad</label>
                    <input type="number" class="form-control" id="quantity" name="quantity"
                        placeholder="Ingresa la cantidad" required>
                </div>
                <div class="form-group">
                    <label for="release-date"><i class="fas fa-calendar-alt"></i> Fecha de Lanzamiento</label>
                    <input type="date" class="form-control" id="release-date" name="release-date" required>
                </div>
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Guardar</button>
            </form>
        </div>

        <script>
            $(document).ready(function () {
                $("#gameForm").submit(function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "../BD/insertar_videojuegos.php",
                        data: formData,
                        success: function (result) {
                            console.log(result);
                        }
                    })
                })
            })
        </script>
</body>

</html>