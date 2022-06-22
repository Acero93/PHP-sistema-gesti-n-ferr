<?php   

include_once 'controladores/usuario.php';
include_once 'controladores/sesion_usuario.php';
include_once 'controladores/conexion.php';


$sesionUsuario = new SesionUsuario();
$usuario      = new Usuario();

if(isset($_SESSION['user'])){
    // echo "hay sesion";
    $usuario->setearUser($sesionUsuario->obtenerUsuarioActual());
    include_once 'vistas/principal.php';
}else if(isset($_POST['username']) && isset($_POST['password'])){
    // echo("validación de login");
    $userForm = $_POST['username'];
    $passForm = $_POST['password'];

    if($usuario->existeUsuario($userForm,$passForm)){
        // echo "Usuario Validado";
        $sesionUsuario->setearUsuarioActual($userForm);
        $usuario->setearUser($userForm);
        include_once 'vistas/principal.php';
    }else{
        // echo "Nombre de usuario y/o password incorrecto";
        $errorLogin =  "Nombre de usuario y/o password incorrecto";
        include_once 'vistas/login.php';
    }

}else{
    // echo"pico";
    include_once 'vistas/login.php';
}


?>
<html>
    
    <link href="modelo/css/estilos.css" rel="stylesheet"gin="anonymous">
</html>
