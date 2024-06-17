<?php

require_once "../connection/Connection.php";

class Usuario {

    public static function login($correo, $password) {
        $db = new Connection(); // Crear una instancia de la conexión a la base de datos
        $query = "SELECT * FROM registro_de_usuarios WHERE correo = '$correo'";

        $resultados = $db->query($query);          // Ejecutar la consulta

        if (!$resultados) {                             //Manejo de errores
            error_log("Error al ejecutar la consulta: " . $db->error);
        }

        if ($resultados->num_rows == 1) {
            $usuario = $resultados->fetch_assoc();

            if ($usuario['password'] === $password) {               // Verificar si la contraseña coincide
                $token = bin2hex(random_bytes(16)); // Generar un token

                $updateQuery = "UPDATE registro_de_usuarios SET token = '$token' WHERE id = " . $usuario['id'];    // Actualizar el token en la base de datos con una query
                if (!$db->query($updateQuery)) {
                    die("Ocurrió un error al actualizar el token " . $db->error);
                }
                
                $usuario['token'] = $token;
                $db->close();
                return $usuario; // Indicar éxito en la autenticación
                
            }
        }

        $db->close();
        return false; // Indicar falla en la autenticación
    }

    public static function validarToken($token) {
        $db = new Connection();
        $query = "SELECT*FROM registro_de_usuarios WHERE token = '$token'";  //Diseño y alamacenamiento de la query para la consulta del token 
      
        $resultado = $db->query($query);      // Ejecutar la consulta

        if (!$resultado) {
            error_log("Error al ejecutar la consulta: " . $db->error);  //Impresion de mensaje de error en caso de generarse un error
        }

        if ($resultado->num_rows == 1) {
            $usuario = $resultado->fetch_assoc();
            $db->close();
            return $usuario; // Devolver el usuario encontrado
        }

        $db->close();
        return null; // Devolver nulo si no se encontró ningún usuario con el token dado
    }

    public static function validarDatos($nombre, $apellido, $usuario) {
        return $usuario['nombre'] === $nombre && $usuario['apellido'] === $apellido;  // Validar si el nombre y apellido coinciden con los datos del usuario
    }
}
