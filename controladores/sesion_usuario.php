<?php

    class SesionUsuario{

        public function __construct(){
            session_start();
        }

        public function setearUsuarioActual($user){
            $_SESSION['user'] = $user;
        }

        public function obtenerUsuarioActual(){
            return $_SESSION['user'];
        }

        public function cerrarSesion(){
            session_unset();
            session_destroy();
        }

    }

?>