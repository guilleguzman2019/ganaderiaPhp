<?php
require_once 'config.php';

echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tabla con Selects</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>

        body {
            font-family: "Montserrat", sans-serif;
        }

        .bg-verde-manzana {
            background-color: #b1d365;
        }
        .text-verde-manzana {
            color: #b1d365;
        }

        thead{

            background-color: #b1d365;
            color:white;
        }

        .bg-titulo {
            background-color: #95a670;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .select-group .form-control {
            display: inline-block;
            width: 90%;
            margin-right: 10px;
        }

        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .floating-button-icon {
            font-size: 20px;
            margin-top: 15px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="bg-titulo text-center mb-4">
            <h2>Metodología Pradia Manejo de Inventario</h2>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 select-group">
                <label>Fecha</label>
                <select class="form-control bg-verde-manzana text-white">
                    <option value="opcion1">Opción 1</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
            </div>
            <div class="col-md-4 select-group">
                <label>Finca</label>
                <select class="form-control bg-verde-manzana text-white">
                    <option value="opcion1">Opción 1</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
            </div>
            <div class="col-md-4 select-group">
                <label>Manada</label>
                <select class="form-control bg-verde-manzana text-white">
                    <option value="opcion1">Opción 1</option>
                    <option value="opcion2">Opción 2</option>
                    <option value="opcion3">Opción 3</option>
                </select>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Código Animal</th>
                                <th>Peso</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>';
 
 
append_to_sheet();

 
function append_to_sheet() {

    $item_id = '01D7ZCKL3GUAMAT3WR6FCYSSU4ZE6VZKYA';
    $table = 'Table1';

    $tokenJSON = file_get_contents('token.txt');

    // Decodifica el JSON para obtener un array asociativo
    $tokenArray = json_decode($tokenJSON, true);

    // Extrae el valor de 'access_token'
    $accessToken = $tokenArray['access_token'];
 
    try {
 
        $client = new GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://graph.microsoft.com',
        ]);


        $response = $client->request("GET", "/v1.0/me/drive/items/01D7ZCKL3GUAMAT3WR6FCYSSU4ZE6VZKYA/workbook/tables/Table1/rows/", [
            'headers' => [
                'Authorization' => 'Bearer '. $accessToken
            ],
            'verify' => false,
        ]);

        $responseData = json_decode($response->getBody(), true);


        $arrayRow = [];


        if (isset($responseData['value'])) {
            foreach ($responseData['value'] as $index => $row) {

                $codigo = $row['values'][0][1];
                $peso= $row['values'][0][6];


                echo '<tr id="'.$index.'" class="text-center">
                        <td>'.$codigo.'</td>
                        <td>'.$peso.'</td>
                        <td>
                            <button class="btn btn-info editarBtn" data-toggle="modal" data-target="#editarModal">Editar</button>
                            <button class="btn btn-danger eliminarBtn">Eliminar</button>
                        </td>
                    </tr>';


            }
        }

        echo '</tbody>
                        </table>
                    </div>
                </div>
                </div>
                </div>

                <!-- Modal para editar -->
                <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Animal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="codigo">Código:</label>
                                <input type="text" class="form-control" id="codigo" placeholder="Código del Animal">
                            </div>
                            <div class="form-group">
                                <label for="peso">Peso:</label>
                                <input type="text" class="form-control" id="peso" placeholder="Peso del Animal">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary guardarCambiosBtn">Guardar Cambios</button>
                    </div>
                </div>
                </div>
                </div>

                <!-- Modal para agregar nueva fila -->
                <div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="agregarModalLabel">Nuevo Animal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="codigoNuevo">Código:</label>
                                        <input type="text" class="form-control" id="codigoNuevo" placeholder="Código del Animal">
                                    </div>
                                    <div class="form-group">
                                        <label for="pesoNuevo">Peso:</label>
                                        <input type="text" class="form-control" id="pesoNuevo" placeholder="Peso del Animal">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary agregarFilaBtn">Agregar Fila</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botón flotante para agregar fila -->
                <div class="floating-button" data-toggle="modal" data-target="#agregarModal">
                    <div class="floating-button-icon">+</div>
                </div>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <script>
                $(document).ready(function() {
                let codigoEditado = "";
                let pesoEditado = "";

                let filaSeleccionada;

                // Evento al hacer clic en el botón de editar
                $(".editarBtn").click(function() {
                    // Guardar la fila seleccionada
                    filaSeleccionada = $(this).closest("tr");

                    // Obtener valores de la fila
                    let codigoEditado = filaSeleccionada.find("td:eq(0)").text();
                    let pesoEditado = filaSeleccionada.find("td:eq(1)").text();

                    // Asignar valores al modal
                    $("#codigo").val(codigoEditado);
                    $("#peso").val(pesoEditado);
                });

                // Evento al hacer clic en el botón de guardar cambios
                $(".guardarCambiosBtn").click(function() {
                    // Actualizar valores en la fila
                    filaSeleccionada.find("td:eq(0)").text($("#codigo").val());
                    filaSeleccionada.find("td:eq(1)").text($("#peso").val());

                    let codigoNuevo = $("#codigo").val();
                    let pesoNuevo = $("#peso").val();

                    // Cerrar modal
                    $("#editarModal").modal("hide");

                    var rowId = filaSeleccionada.attr("id"); 

                    let url = "https://graph.microsoft.com/v1.0/me/drive/items/01D7ZCKL3GUAMAT3WR6FCYSSU4ZE6VZKYA/workbook/tables/Table1/rows/itemAt(index=" + rowId + ")";
    
                    $.ajax({
                        url: url,
                        type: "PATCH",
                        headers: {
                            "Authorization": "Bearer " + "'.$accessToken.'",
                            "Content-Type": "application/json"
                        },
                        data: JSON.stringify({
                            "index": rowId,
                            values: [[null, codigoNuevo, null, null, null, null, pesoNuevo, null, null, null, null, null, null, null, null, null, null]] // Asegúrate de enviar solo los campos que quieres actualizar
                        }),
                        success: function(response) {
                            console.log("exitoso", response);
                        },
                        error: function(error) {
                            console.error("error", error);
                        }
                    });
                });

                // Evento al hacer clic en el botón de eliminar
                $(".eliminarBtn").click(function() {
                    $(this).closest("tr").remove();

                    let filaSeleccionada = $(this).closest("tr");

                    console.log(filaSeleccionada.attr("id"));

                    var rowId = filaSeleccionada.attr("id"); 


                    // Hacer la solicitud DELETE a la API de Microsoft Graph
                    $.ajax({
                    url: "https://graph.microsoft.com/v1.0/me/drive/items/01D7ZCKL3GUAMAT3WR6FCYSSU4ZE6VZKYA/workbook/tables/Table1/rows/itemAt(index=" + rowId + ")",
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + "'.$accessToken.'" // Reemplaza accessToken con tu token
                    },
                    success: function() {
                        // Si la fila se eliminó correctamente, la eliminamos de la tabla
                        fila.remove();
                        console.log("elimino");
                    },
                    error: function(error) {
                        console.error("Error al eliminar la fila:", error);
                    }
                    });
                    });
                });

                $(".agregarFilaBtn").click(function() {
                    // Obtener valores del formulario
                    let codigoNuevo = $("#codigoNuevo").val();
                    let pesoNuevo = $("#pesoNuevo").val();
                
                    // Crear un objeto con los datos para la nueva fila
                    let nuevaFila = {
                        "values": [
                            [null, codigoNuevo, null, null, null, null, pesoNuevo,null, null, null, null, null, null, null, null, null, null]
                        ]
                    };
                
                    // Realizar una solicitud POST para agregar la fila
                    $.ajax({
                        url: "https://graph.microsoft.com/v1.0/me/drive/items/01D7ZCKL3GUAMAT3WR6FCYSSU4ZE6VZKYA/workbook/tables/Table1/rows/add",
                        type: "POST",
                        headers: {
                            "Authorization": "Bearer " + "'.$accessToken.'", // Reemplaza accessToken con tu token
                            "Content-Type": "application/json"
                        },
                        data: JSON.stringify(nuevaFila),
                        success: function(response) {
                            // Si la solicitud es exitosa, agrega la nueva fila a la tabla HTML
                            let filaHtml = `
                                <tr class="text-center">
                                    <td>${codigoNuevo}</td>
                                    <td>${pesoNuevo}</td>
                                    <td>
                                        <button class="btn btn-info editarBtn" data-toggle="modal" data-target="#editarModal">Editar</button>
                                        <button class="btn btn-danger eliminarBtn">Eliminar</button>
                                    </td>
                                </tr>
                            `;
                            $("tbody").append(filaHtml);
                
                            // Cerrar modal
                            $("#agregarModal").modal("hide");
                
                            // Limpiar campos del formulario
                            $("#codigoNuevo").val("");
                            $("#pesoNuevo").val("");

                            location.reload();
                        },
                        error: function(error) {
                            // Manejar errores aquí
                            console.log(error);
                        }
                    });
                });

                </script>
                </body>
                </html>';


    } catch(Exception $e) {

    $tokenJSON = file_get_contents('token.txt');

    // Decodifica el JSON para obtener un array asociativo
    $tokenArray = json_decode($tokenJSON, true);

    // Extrae el valor de 'access_token'
    $refresh_token = $tokenArray['refresh_token'];

    $client = new GuzzleHttp\Client(['base_uri' => 'https://login.microsoftonline.com']);
    
    $response = $client->request('POST', '/common/oauth2/v2.0/token', [
                    'form_params' => [
                        "grant_type" => "refresh_token",
                        "refresh_token" => $refresh_token,
                        "client_id" => ONEDRIVE_CLIENT_ID,
                        "client_secret" => ONEDRIVE_CLIENT_SECRET,
                        "scope" => ONEDRIVE_SCOPE,
                        "redirect_uri" => ONEDRIVE_CALLBACK_URL,
                    ],
                ]);

    $responseData = $response->getBody()->getContents();

    $jsonData = json_decode($responseData, true);

    $archivoToken = 'token.txt';

    // Abre el archivo en modo escritura
    $file = fopen($archivoToken, 'w');

    // Escribe el token en el archivo
    if ($file) {
        fwrite($file, json_encode($jsonData));
        fclose($file);
    }

    append_to_sheet();

        
    }
}


