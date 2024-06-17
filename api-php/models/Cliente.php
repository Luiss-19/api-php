<?php

    require_once "connection/Connection.php";

    class Cliente {

        public static function getAll() {                                            //se crea una función estática getAll
            $db = new Connection();                                                 //se crea una instancia de la clase Connection
            $query = "SELECT*FROM registro_de_usuarios";                           
            $resultados = $db->query($query);                                //se ejecuta la consulta 
            if (!$resultados) {                                                  // Manejo de errores
                die("Error en la ejecución de la consulta: " . $db->error);
            }

            $datos = [];                                                            //se crea un arreglo vacío    
            if($resultados->num_rows > 0){                                             //si el número de filas es mayor a 0
                while($row = $resultados-> fetch_assoc()) {                          //mientras haya filas, se recorre el arreglo
                    $datos[] = [                                                    //se agrega un nuevo elemento al arreglo                                    
                        'id' => $row['id'],
                        'nombre' => $row['nombre'],
                        'apellido' => $row['apellido'],
                        'correo' => $row['correo'],
                        'password' => $row['password'],
                        'roll' => $row['roll'],
                    ];                                                   
                } //end while
                return $datos;
            } //end if
            $resultados->free();                                // Liberar los resultados para liberar memoria
            $db->close();                                      // Cerrar la conexión a la base de datos
            return $datos;
        } //end function getAll

        public static function getWhere($id_registro_de_usuarios) {                             //se crea una función estática getWhere 
            $db = new Connection();                                                                        //se crea una instancia de la clase Connection
            $query = "SELECT*FROM registro_de_usuarios WHERE id=$id_registro_de_usuarios";               //se crea la consulta
            $resultados = $db->query($query);                                                            //se ejecuta la consulta
            if (!$resultados) {                                                                         // Manejo de errores
                die("Error en la ejecución de la consulta: " . $db->error);
            }
            $datos = [];                                                                                //se crea un arreglo vacío    
            if($resultados->num_rows > 0){                                                                 //si el número de filas es mayor a 0
                while($row = $resultados-> fetch_assoc()) {                                           //mientras haya filas, se recorre el arreglo
                    $datos[] = [                                                                     //se agrega un nuevo elemento al arreglo                                       
                        'id' => $row['id'],
                        'nombre' => $row['nombre'],
                        'apellido' => $row['apellido'],
                        'correo' => $row['correo'],
                        'password' => $row['password'],
                        'roll' => $row['roll'],
                    ];                                                   
                } //end while
                return $datos;
            } //end if
            $resultados->free();                                // Liberar los resultados para liberar memoria
            $db->close();                                      // Cerrar la conexión a la base de datos
            return $datos;
        } //end function getWhere

        public static function insert($nombre, $apellido, $correo, $password, $roll) {          //se crea una función estática insert
            $db = new Connection();
            $query = "INSERT INTO registro_de_usuarios(nombre, apellido, correo, password, roll)                              
            VALUES('".$nombre."','".$apellido."','".$correo."','".$password."','".$roll."')";                           //se crea la consulta para insertar datos y se concatenan los valores de esta forma para php ' ".$variable." ' para que aparezcan como texto (string)
            $resultados = $db->query($query);                                                                 //se ejecuta la consulta 
            if (!$resultados) {                                                                         // Manejo de errores
                die("Error en la ejecución de la consulta: " . $db->error);
            }
            if($db->affected_rows > 0){                                                                                     //si el número de filas afectadas es mayor a 0
                return TRUE;                                                                                           //se ejecuta la condicion y devuelve un TRUE en caso que si haya filas afectadas
            }//end if                                                                                                   
            return FALSE;                                                                                             //Devuelve un FALSE en caso que no haya filas afectadas
        } //end function insert

        public static function update($id_registro_de_usuarios, $nombre, $apellido, $correo, $password, $roll) {                                     //se crea una función estática insert
            $db = new Connection();
            $query = "UPDATE registro_de_usuarios SET                               
            nombre='".$nombre."', apellido='".$apellido."', correo='".$correo."', password='".$password."', roll='".$roll."'
            WHERE id = $id_registro_de_usuarios";                                                                       //se crea la consulta para actiañozar datos y se insertan los valores de esta forma para php variable_en_la_base_datos'".$variable." ' 
            $resultados = $db->query($query);  // Ejecutar la consulta
            if (!$resultados) {                                                                                     // Manejo de errores
                die("Error en la ejecución de la consulta: " . $db->error);
            }
            if($db->affected_rows>0){                                                                                     //si el número de filas afectadas es mayor a 0
                return TRUE;                                                                                           //se ejecuta la condicion y devuelve un TRUE en caso que si haya filas afectadas
            }//end if                                                                                                   
            return FALSE;                                                                                             //Devuelve un FALSE en caso que no haya filas afectadas
        } //end function update

        public static function delete($id_registro_de_usuarios) {                                   //se crea una función estática delete
            $db = new Connection();
            $query = "DELETE FROM registro_de_usuarios WHERE id=$id_registro_de_usuarios";
            $resultados = $db->query($query);  // Ejecutar la consulta
            if (!$resultados) {                                                                         // Manejo de errores
                die("Error en la ejecución de la consulta: " . $db->error);
            }
            if($db->affected_rows){
                return TRUE;
            } //end if
            return FALSE;
        } //end function delete

        public static function login($correo, $password) {     //se crea función estática login
            $db = new Connection();
            if ($db->connect_error) {       // Manejo de errores
                die("Error en la conexión: " . $db->connect_error);
            }
    
            $query = "SELECT id, nombre FROM clientes WHERE correo = '$correo' AND password = '$password'";
            $resultado = $db->query($query);

            if ($resultado && $resultado->num_rows == 1) {
                $usuario = $resultado->fetch_assoc();  // Obtener los datos del usuario
                $db->close();               // Se cierra la conexión
                return ['id' => $usuario['id'], 'nombre' => $usuario['nombre']];        // Devolver los datos del usuario
            } 
            else {
                $db->close();       // Se cierra la conexión  
                return FALSE;       // Si no se encuentra al usuario, devolver false
            } //end else
    }
        
}//end class Cliente

