<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Videojuegos</title>
    <!-- Incluyendo Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <h1>Si</h1>
    <div class="container">
        <h1 class="mt-5">Lista de Videojuegos</h1>
        <table id="tablaVideojuegos" class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Clasificación</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Compañía</th>
                    <th>Fecha de Lanzamiento</th>
                    <th>Detalles</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button id="mostrarTodo" class="btn btn-primary mt-3" style="display:none;">Mostrar Todo</button>
    </div>
    <!-- Incluyendo jQuery y Bootstrap JS -->

    <script>
        $(document).ready(function(){
            // Realizar una solicitud AJAX para obtener los datos de videojuegos
            $.ajax({
                url: '../BD/Consultar_videojuegos.php', // Archivo PHP que envía los datos de videojuegos
                method: 'GET', // Usamos GET ya que no estamos enviando datos
                dataType: 'json',
                success: function(response){
                    // Iterar sobre los datos recibidos y agregar filas a la tabla
                    $.each(response, function(index, videojuego){
                        var row = '<tr>';
                        row += '<td>' + videojuego.id + '</td>';
                        row += '<td>' + videojuego.nombre + '</td>';
                        row += '<td>' + videojuego.clasificacion + '</td>';
                        row += '<td>' + videojuego.descripcion + '</td>';
                        row += '<td>' + videojuego.precio + '</td>';
                        row += '<td>' + videojuego.compania + '</td>';
                        row += '<td>' + videojuego.fecha_lanzamiento + '</td>';
                        row += '<td><button class="btn btn-success btn-sm">ver</button></td>';
                        row += '<td><button class="btn btn-info btn-sm">editar</button></td>';
                        row += '<td><button class="btn btn-danger btn-sm">eliminar</button></td>';
                        row += '</tr>';
                        $('#tablaVideojuegos tbody').append(row);
                    });
                },
                error: function(xhr, status, error){
                    console.error('Error al obtener datos de videojuegos:', error);
                }
            });

            // Manejar el evento click de los botones de acción
            $('#tablaVideojuegos').on('click', '.btn-success', function(){
                var row = $(this).closest('tr');
                $('#tablaVideojuegos tbody tr').hide(); // Ocultar todas las filas
                row.show(); // Mostrar solo la fila seleccionada
                $('#mostrarTodo').show(); // Mostrar el botón para mostrar todas las filas
            });

            // Manejar el evento click del botón "Mostrar Todo"
            $('#mostrarTodo').on('click', function(){
                $('#tablaVideojuegos tbody tr').show(); // Mostrar todas las filas
                $(this).hide(); // Ocultar el botón "Mostrar Todo"
            });

            // Manejar el evento click de los botones de editar
            $('#tablaVideojuegos').on('click', '.btn-info', function(){
                // Aquí puedes agregar el código para manejar la acción del botón de editar
            });

            // Manejar el evento click de los botones de eliminar
            $('#tablaVideojuegos').on('click', '.btn-danger', function(){
                // Aquí puedes agregar el código para manejar la acción del botón de eliminar
            });
        });
    </script>
</body>
</html>
