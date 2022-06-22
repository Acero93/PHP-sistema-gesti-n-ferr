<?php

class Conexion{


        
       private $dsn = "mysql:host=localhost;dbname=prueba";
        // $servername = "localhost";
        // $database = "Prueba";
       private $username = "root";
       private $password = "";
       private $conexion;


    //https://www.phpmyadmin.co/sql.php?server=1&db=sql10475958&table=cliente&pos=0
//     Host: sql10.freesqldatabase.com
// Database name: sql10475958
// Database user: sql10475958
// Database password: FNahpQ3nmk
// Port number: 3306


       public function __construct()
       {

            try{
                
                $this->conexion =  new PDO($this->dsn,$this->username,$this->password);
                // $conexion = new PDO($dsn,$username,$password);

                $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                // echo("Conexión exitosa");
    
            }catch(PDOException $error){
                echo ("Conexión fallida , ERROR:".$error);
                print_r('Error connection: ' . $error->getMessage());
            }
            
            return $this->conexion;
       }




    public function EjecutaQuery($sql){

        $this->conexion->exec($sql);

        return $this->conexion->lastInsertId();
    
        
    }

    public function consultaQuery($sql){

       $consulta= $this->conexion->prepare($sql);
       $consulta->execute();
       return $consulta->fetchAll();

    }


    public function consultaQ($sql,$params){

        $consulta= $this->conexion->prepare($sql);
        $consulta->execute($params);


        
        return $consulta;
 
     }


     public function datosCliente($sql){

        $resultado =  $this->conexion->prepare($sql);
        $resultado->execute();
        $datos=$resultado->fetch(PDO::FETCH_NUM);


        return $datos;
        
     }
 
}
?>
