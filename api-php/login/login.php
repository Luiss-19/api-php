<?php

    require_once "../models/Usuario.php";

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $datos = json_decode(file_get_contents('php://input'), true);  //se decodifica el contenido de la petición para manejor de datos mediante flujo de solo lectura datos solicitados
    
            if ($datos != null && isset($datos['correo'], $datos['password'])) {    //Se erifica si los datos no son nulos y contienen 'correo' y 'password'
                $correo = $datos['correo'];   //Se obtiene el correo del JSON
                $password = $datos['password'];  //Se obtiene el password del JSON
    
                $result = Usuario::login($correo, $password);  //Se utiliza al método login de la clase Usuario para autenticar al usuario y obtener el token
                if ($result !== false && isset($result['token'])) {   // Se verificar si la autenticación fue exitosa y se generó un token
                    echo json_encode(['status' => 'success','usuario' => $result]);     // Si se obtiene el token correctamente, preparar la respuesta JSON con todos los datos del usuario
                    http_response_code(200);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al generar el token']);  // Generación de mensaje de error al generar el token durante el proceso
                    http_response_code(500); // Error interno del servidor
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos, por favor intente de nuevo']);    // Si faltan datos en la solicitud se genera mensaje de error para insertarlos completamente
                http_response_code(400); // Solicitud incorrecta
            }
            break;
        default:
            http_response_code(405); // Mensaje de error en caso de realizar el procedimiento incorrectamente: Método no permitido
            break;
    }