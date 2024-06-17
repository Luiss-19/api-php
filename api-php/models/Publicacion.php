<?php

require_once "../connection/Connection.php";
require_once "../models/Usuario.php";

class Publicacion {

    public static function crearPublicacion($correo, $titulo, $descripcion) {
        $usuario_id = self::obtenerIdUsuario($correo);
        
        if (!$usuario_id) {
            return ['success' => false, 'message' => 'Usuario no encontrado'];
        }

        $db = new Connection();
        $titulo = $db->real_escape_string($titulo);
        $descripcion = $db->real_escape_string($descripcion);

        $queryInsert = "INSERT INTO registro_de_usuarios (titulo, descripcion, usuario_id) 
                       VALUES ('$titulo', '$descripcion', '$usuario_id')";

        if ($db->query($queryInsert)) {
            $db->close();
            return ['success' => true, 'message' => 'Publicación creada correctamente'];
        } else {
            $error = $db->error;
            $db->close();
            return ['success' => false, 'message' => 'Error al crear la publicación: ' . $error];
        }
    }

    public static function actualizarPublicacion($correo, $titulo, $descripcion) {
        $usuario_id = self::obtenerIdUsuario($correo);

        if (!$usuario_id) {
            return ['success' => false, 'message' => 'Usuario no encontrado'];
        }

        $db = new Connection();
        $titulo = $db->real_escape_string($titulo);
        $descripcion = $db->real_escape_string($descripcion);

        $query = "UPDATE registro_de_usuarios
                  SET titulo = '$titulo', descripcion = '$descripcion'
                  WHERE usuario_id = '$usuario_id'";

        if ($db->query($query)) {
            $db->close();
            return ['success' => true, 'message' => 'Publicación actualizada correctamente'];
        } else {
            $error = $db->error;
            $db->close();
            return ['success' => false, 'message' => 'Error al actualizar la publicación: ' . $error];
        }
    }

    private static function obtenerIdUsuario($correo) {
        $db = new Connection();
        $correo = $db->real_escape_string($correo);
        $query = "SELECT id FROM registros_de_usuarios WHERE correo = '$correo'";
        $result = $db->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['id'];
        } else {
            return null;
        }
    }

}

?>
