<?php

    class Connection extends mysqli {
        function __construct() {
            parent::__construct('localhost','root','','api_back_php');
            $this->set_charset('utf8');
            $this->connect_errno == NULL ? 'Se inició la conexión a la base de datos exitosamente' : die ('Error al intentar conectarse a la base de datos, por favor intente de nuevo');
        }//end function __construct

    } //end class Connection 

