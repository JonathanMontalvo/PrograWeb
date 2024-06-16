<?php
include ('../layout/NavAdmin.php');
?>
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
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
    <h1>-</h1>
    <div class="container">
        <h1 class="mt-5 text-center">Lista de Videojuegos</h1>

        <button type="button" id="btnAgregar" class="btn btn-success" data-toggle="modal" data-target="#miModalAgregar">
            <i class="fas fa-plus"></i> Agregar
        </button>

        <div class="modal fade" id="miModalAgregar" tabindex="-1" role="dialog" aria-labelledby="miModalAgregarLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-agregar">
                    <div id="modalContentAgregar">
                        <!-- Aquí se cargará el contenido del modal -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="miModalEditar" tabindex="-1" role="dialog" aria-labelledby="miModalEditarLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-editar">
                    <div id="modalContentEditar">
                        <!-- Aquí se cargará el contenido del modal -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmación de eliminación -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres eliminar este videojuego?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <table id="tablaVideojuegos" class="table table-striped table-bordered">
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
    <script>
        $(document).ready(function () {
            // Variable para guardar el ID del videojuego
            var videojuegoId;
            // Variable para guardar la fila del videojuego
            var videojuegoRow;

            // Inicializar los modales de Bootstrap
            var myDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'), {});
            var myModalAgregar = new bootstrap.Modal(document.getElementById('miModalAgregar'), {});
            var myModalEditar = new bootstrap.Modal(document.getElementById('miModalEditar'), {});

            // Realizar una solicitud AJAX para obtener los datos de videojuegos
            $.ajax({
                url: '../BD/Consultar_videojuegos.php', // Archivo PHP que envía los datos de videojuegos
                method: 'GET', // Usamos GET ya que no estamos enviando datos
                dataType: 'json',
                success: function (response) {
                    // Iterar sobre los datos recibidos y agregar filas a la tabla
                    $.each(response, function (index, videojuego) {
                        var row = '<tr>';
                        row += '<td>' + videojuego.id + '</td>';
                        row += '<td>' + videojuego.nombre + '</td>';
                        row += '<td>' + videojuego.clasificacion + '</td>';
                        row += '<td>' + videojuego.descripcion + '</td>';
                        row += '<td>' + videojuego.precio + '</td>';
                        row += '<td>' + videojuego.compania + '</td>';
                        row += '<td>' + videojuego.fecha_lanzamiento + '</td>';
                        row += '<td><button class="btn btn-success btn-sm">ver</button></td>';
                        row += '<td><button class="btn btn-info btn-sm btn-editar">editar</button></td>';
                        row += '<td><button class="btn btn-danger btn-sm">eliminar</button></td>';
                        row += '</tr>';
                        $('#tablaVideojuegos tbody').append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener datos de videojuegos:', error);
                }
            });

            // Manejar el evento click de los botones de acción
            $('#tablaVideojuegos').on('click', '.btn-success', function () {
                var row = $(this).closest('tr');
                $('#tablaVideojuegos tbody tr').hide(); // Ocultar todas las filas
                row.show(); // Mostrar solo la fila seleccionada
                $('#btnAgregar').hide();
                $('#mostrarTodo').show(); // Mostrar el botón para mostrar todas las filas
            });

            // Manejar el evento click del botón "Mostrar Todo"
            $('#mostrarTodo').on('click', function () {
                $('#tablaVideojuegos tbody tr').show(); // Mostrar todas las filas
                $(this).hide(); // Ocultar el botón "Mostrar Todo"
                $('#btnAgregar').show();
            });

            // Manejar el evento click de los botones de editar
            $('#tablaVideojuegos').on('click', '.btn-editar', function () {
                // Obtener el ID del videojuego
                var row = $(this).closest('tr');
                var id = row.find('td:nth-child(1)').text();

                // Limpiar contenido anterior del modal
                $('#modalContentAgregar').empty();

                // Cargar nuevo contenido en el modal
                $.get('editar_videojuego.php', { id: id }, function (response, status, xhr) {
                    if (status == "error") {
                        alert("Error: " + xhr.status + " " + xhr.statusText);
                    } else {
                        console.log(response);
                        console.log("Contenido editar cargado exitosamente!");
                        $('#modalContentEditar').html(response);
                        myModalEditar.show();
                    }
                });
            });

            // Manejar el evento click de los botones de eliminar
            $('#tablaVideojuegos').on('click', '.btn-danger', function () {
                // Abrir el modal de confirmación de eliminación
                myDeleteModal.show();
                // Guardar el ID del videojuego
                var row = $(this).closest('tr');
                videojuegoRow = row;
                videojuegoId = row.find('td:nth-child(1)').text();
            });

            // Manejar el evento click del botón de eliminar en el modal
            $(document).on('click', '#confirmDeleteModal .btn-danger', function () {
                console.log('Eliminando videojuego con ID: ' + videojuegoId);
                // Realizar una solicitud AJAX para eliminar el videojuego
                $.ajax({
                    type: "POST",
                    url: "../BD/eliminar_videojuego.php",
                    data: {
                        videojuegoId: videojuegoId
                    },
                    success: function (result) {
                        if (result == "Videojuego eliminado exitosamente") {
                            // Eliminar la fila de la tabla
                            videojuegoRow.remove();
                        }
                        myDeleteModal.hide();
                        setTimeout(function () {
                            alert(result);
                        }, 200);
                    }
                });
            });

            // Manejar el evento click del botón de agregar
            $('#btnAgregar').on('click', function () {
                // Limpiar contenido anterior del modal
                $('#modalContentEditar').empty();

                // Cargar nuevo contenido en el modal
                $.get('agregar_videojuego.php', function (response, status, xhr) {
                    if (status == "error") {
                        alert("Error: " + xhr.status + " " + xhr.statusText);
                    } else {
                        SVGAnimateMotionElement
                        console.log(response);
                        console.log("Contenido agregar cargado exitosamente!");
                        $('#modalContentAgregar').html(response);
                        myModalAgregar.show();
                    }
                });
            });

        });
    </script>
</body>

</html>