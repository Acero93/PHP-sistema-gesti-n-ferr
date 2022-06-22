<?php
    include_once("controladores/conexion.php");


    // $sql ="INSERT INTO `prueba`.`alumno` (`nombre`, `appat`) VALUES ('Camila', 'Aravena');";
        // Conexion::conexionBD()->exec($sql);

    $con = new conexion();

    $usuario  = $_POST['usuario'];
    $password = $_POST['password'];
    $query    = "SELECT * FROM ";


    session_start();





?>