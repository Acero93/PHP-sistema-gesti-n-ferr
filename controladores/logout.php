<?php 
    include_once 'sesion_usuario.php';

    $sesionUsuario = new SesionUsuario();

    $sesionUsuario->cerrarSesion();

    header("location: ../index.php");



?>