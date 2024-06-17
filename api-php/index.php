<?php
    require_once "models/Cliente.php";
    

    switch ($_SERVER['REQUEST_METHOD']) {               //se crea un switch con la variable $_SERVER y con el indice 'REQUEST_METHOD' para manejar los método de petición realizando petición al archivo index.php
        case 'GET': 
            if(isset($_GET['id'])) {                                //verifica si existe el indice 'id' en la variable $_GET
                echo json_encode(Cliente::getWhere($_GET['id']));  //se imprime en formato json el resultado de la función getWhere
            } //end if
            else {
                echo json_encode(Cliente::getAll());               //se imprime en formato json el resultado de la función getAll
            } //end else             
            break; 
        case 'POST':
            $datos= json_decode(file_get_contents('php://input', true));     //se decodifica el contenido de la petición para manejor de datos mediante flujo de solo lectura datos solicitados
            if (isset($datos->nombre) && isset($datos->apellido) && isset($datos->correo) && isset($datos->password) && isset($datos->roll)) {  //se verifica si existen los datos solicitados
                if(Cliente::insert($datos->nombre, $datos->apellido, $datos->correo, $datos->password, $datos->roll)) {     //se verifica si se insertaron los datos
                    echo 'se carga correctamente la solicitud';     //se imprime el mensaje de éxito
                    http_response_code(200);           //se imprime el código de respuesta por correcto
                } //end if
                else {
                    http_response_code(400);            //se imprime el código de respuesta por error
                } //end else
            }   //end if
            else {
                http_response_code(405);                //se imprime el código de respuesta que no pudo accederse a la petición por método no permitido
            } //end else
            break;

        case 'PUT':
            $datos= json_decode(file_get_contents('php://input', true));     //se decodifica el contenido de la petición para manejor de datos mediante flujo de solo lectura datos solicitados
            if (isset($datos->id) && isset($datos->nombre) && isset($datos->apellido) && isset($datos->correo) && isset($datos->password) && isset($datos->roll)) {  //se verifica si existen los datos solicitados
                if(Cliente::update($datos->id, $datos->nombre, $datos->apellido, $datos->correo, $datos->password, $datos->roll)) {     //se verifica si se insertaron los datos
                    echo 'Se ejecuta correctamente la solicitud';     //se imprime el mensaje de éxito
                    http_response_code(200);           //se imprime el código de respuesta por correcto
                } //end if
                else {
                    http_response_code(400);            //se imprime el código de respuesta por error
                } //end else
            }   //end if
            else {
                http_response_code(405);                //se imprime el código de respuesta que no pudo accederse a la petición por método no permitido
            } //end else
            break;

        case 'DELETE':
            if (isset($GET['id'])){
                if(Cliente::delete($_GET['id'])){
                    echo 'se carga elimina corectamente la información de la solicitud';     //se imprime el mensaje de éxito
                    http_response_code(200);           //se imprime el código de respuesta por correcto
                } //end if
                else {
                    http_response_code(400);            //se imprime el código de respuesta por error
                } //end else
                } //end if
                else {
                    http_response_code(405);                //se imprime el código de respuesta que no pudo accederse a la petición
                } //end else
            break;
        default:
            break;
    }