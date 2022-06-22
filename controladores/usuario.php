<?php

include_once 'conexion.php';
class Usuario  extends Conexion{

    private $nombre ;
    private $username;
    private $tipo;

    public function existeUsuario($user,$pass){

        $md5pass = md5($pass);

        $params = [
            "user" => $user,
            "pass" => $pass,
        ];
        
        $query = $this-> consultaQ( "SELECT * FROM usuario WHERE username = :user AND password = :pass",$params);
        

        
        // if(count($query)){
        //     return true;
        // }else{
        //     return false;
        // }
        if($query->rowCount()){
            return true;
        }else{
            return false;
        }


    }

    public function setearUser($user){

        $params = [
            "user" => $user,
        ];
        $query = $this-> consultaQ( "SELECT * FROM usuario WHERE username = :user ",$params);

        foreach($query as $currentUser){
            $this-> nombre = $currentUser['nombre'];
            $this-> username = $currentUser['username'];
            $this-> tipo = $currentUser['tipo'];
        }

    }
    public function obtenerNombre(){
        return $this->nombre;
    }

    public function obtenerTipo(){
        return $this->tipo;
    }

}


?>