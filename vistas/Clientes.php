<?php

include_once("../controladores/conexion.php");
include_once '../controladores/usuario.php';

$con = new Conexion();
$usuario  = new Usuario();

$funcion   = $_POST['funcion'];




if($funcion == "datosClientes" ){

    $idcliente	= $_POST['idCliente'];  
    $sql ="SELECT * FROM `cliente` WHERE `ID_Cliente` = $idcliente "; 

    $LENQ = $con->consultaQuery($sql);
    $datos="";
    foreach($LENQ as $clienteQ){
        $datos = $datos . $clienteQ['ID_Cliente'].",";
        $datos = $datos . $clienteQ['RutCliente'].",";
        $datos = $datos . $clienteQ['Nombre'].",";
        $datos = $datos . $clienteQ['Direccion'].",";
        $datos = $datos . $clienteQ['Telefono'];
    }
    echo $datos;
   
    exit;


}

if($funcion == "datosProductos" ){


 
    $tipo = $_POST['tipo'];  
    $Codigoproducto = $_POST['codigo'];  
    $datos="";

    if($tipo == 1){ 
        $sql ="SELECT * FROM `producto` WHERE `Codigo` = '$Codigoproducto' "; 
        $p = $con->consultaQuery($sql);
     
        foreach( $p as $producto){
            $datos = $datos . $producto['Codigo'].",";
            $datos = $datos . $producto['Nombre'].",";
            $datos = $datos . $producto['Descripcion'].",";
            $datos = $datos . $producto['Precio_unitario'].",";
            $datos = $datos . $producto['Existencia'];
        }

    }else{
        $sql ="SELECT * FROM `producto` "; 
        $LENQ = $con->consultaQuery($sql);

        $datos = $datos ."<option value='0x0' selected>Seleccione un producto</option>";

        foreach($LENQ as $productos){
            $datos = $datos ."  <option value=".$productos['Codigo']." >cod: ".$productos['Codigo']." || ".$productos['Nombre']."</option>";
            // $datos = $datos ."  <option value=".$productos['Codigo']." >".$productos['Nombre']." &nbsp;&nbsp;&nbsp; STOCK:&nbsp;".$productos['Existencia']."</option>";

        }

    }
    echo $datos;
   
    exit;


}


if($funcion == "datosCategoria" ){

        $sql ="SELECT * FROM `categoria` "; 
        $LENQ = $con->consultaQuery($sql);
        $datos ="";

        $datos = $datos ."<option value='0x0' selected>Seleccione una categoria para editarla </option>";

        foreach($LENQ as $cat){
            $datos = $datos ."  <option value=".$cat['ID_Categoria']." > ".$cat['Nombre']."</option>";
            // $datos = $datos ."  <option value=".$productos['Codigo']." >".$productos['Nombre']." &nbsp;&nbsp;&nbsp; STOCK:&nbsp;".$productos['Existencia']."</option>";

        }

    
    echo $datos;
   
    exit;


}

if($funcion == "EliminarCategoria" ){

    $idCategoria= $_POST['idCategoria'];  

    $sql = " DELETE FROM `cof80210_ofimyd`.`categoria` WHERE  `ID_Categoria`= $idCategoria";
    
    $elimina=  $con ->EjecutaQuery($sql);
    exit;

}

if($funcion == "guardarCategoria" ){
    $nombreCAT= $_POST['nombreCAT'];  
    
    $sql2 ="INSERT INTO `cof80210_ofimyd`.`categoria`  (`Nombre`)
    VALUES ('$nombreCAT')";
    
    
    $inserta=  $con ->EjecutaQuery($sql2);

    echo true;
    exit;


}




if($funcion == "ListarExistenciasNegativas" ){
    
    $sql ="SELECT * FROM `producto` WHERE `Existencia` < 0"; 
    $LENQ = $con->consultaQuery($sql);

    $tabla="<div class='container text-center'>"; 
    $tabla= $tabla."<table id='tablaLEN' class='table table-bordered table-condensed table-hover'>";
    $tabla= $tabla."<thead>"; 
    $tabla= $tabla." <tr class='even'>"  ;
    $tabla= $tabla."     <th class = 'text-center'>Código</th>";       
    $tabla= $tabla."     <th class = 'text-center' style ='min-width:100px;' >Nombre</th>";      
    $tabla= $tabla."     <th class = 'text-center'>Descripción</th>";      
    $tabla= $tabla."     <th class = 'text-center'>Categoría</th>";   
    $tabla= $tabla."     <th class = 'text-center'>Existencia</th>";
    $tabla= $tabla."     <th class = 'text-center'>Acción</th>";
    $tabla= $tabla." </tr>";    
    $tabla= $tabla."</thead>"; 
    $tabla= $tabla."<tbody>";
    foreach($LENQ as $LEN){

        $tabla= $tabla."<tr id=".$LEN['ID_Producto'].">"; 
        
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$LEN['Codigo']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$LEN['Nombre']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$LEN['Descripcion']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$LEN['Categoria']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$LEN['Existencia']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'><button data-toggle='tooltip' title='Resetea a 0 las existencias negativas del producto seleccionado'  type='button' class='btn btn-success btn-sm btn-more-less' onclick='ResetearExistencia(1,".$LEN['ID_Producto'].")'><i class='bi bi-pencil-square'></i></button></td>";

        $tabla= $tabla."</tr>";  
    }
    $tabla= $tabla."</tbody>";
    $tabla= $tabla."</table>";
    $tabla= $tabla."</div>"; 


    echo $tabla;
    // echo $cabeceraListaCliente;

    exit;


}


if($funcion == "ResetearExistenciasNegativas" ){

    $tipo	= $_POST['tipo'];  
    $idproducto	= $_POST['idproducto'];  

    if($tipo ==  0){
        $sql = "UPDATE `cof80210_ofimyd`.`producto` SET `Existencia`='0'WHERE  `existencia` < 0 ";
    }else{  
        $sql = "UPDATE `cof80210_ofimyd`.`producto` SET `Existencia`='0'WHERE  `ID_Producto`=$idproducto";
    }

    
    $updatea =  $con ->EjecutaQuery($sql);
    exit;

}


if($funcion == "EntregarProducto" ){

    $idUsuario	= $_POST['idPedido'];  


    $sql = "UPDATE `cof80210_ofimyd`.`pedido` SET `estado`= 2 WHERE  `ID_Pedido`=$idUsuario";
    $updatea =  $con ->EjecutaQuery($sql);
    exit;

}



if($funcion == "traeComentario" ){

    $idPedido	= $_POST['idPedido'];  

    
    $sql ="SELECT * FROM `pedido` WHERE `ID_Pedido` =  $idPedido "; 
    $comentario = $con->consultaQuery($sql);

    foreach($comentario as $com){
        $C = $com['comentario'];
    }

    echo $C;
exit;


}


if($funcion == "AgregarPedido" ){

    $idcliente	= $_POST['ID_Cliente'];
    $comentario	= $_POST['comentario'];  
    $FechaEntrega	= $_POST['fEntrega'];  
    $TotalPedido	= $_POST['tPedido'];  
    $nombreVendedor =$_POST['nombreVendedor'];



    $sql1 ="SELECT * FROM `cliente` WHERE `ID_Cliente` = $idcliente "; 

    $datosCliente = $con->consultaQuery($sql1);
    
    foreach( $datosCliente as $dcliente){

        $rut       = $dcliente['RutCliente'];
        $nombre    = $dcliente['Nombre'];
        $direccion = $dcliente['Direccion'];
        $telefono  = $dcliente['Telefono'];
        

    }

    $fechaEmision= date('Y-m-d');

    $sql2 ="INSERT INTO `cof80210_ofimyd`.`pedido`  (`ID_Cliente`, `rut`, `nombre`, `direccion`, `telefono`, `comentario`, `fecha_emision`, `fecha_entrega`, `vendedor`, `total_pedido`, `estado`)
    VALUES ('$idcliente', '$rut', '$nombre', '$direccion', '$telefono', '$comentario', '$fechaEmision', '$FechaEntrega', '$nombreVendedor', '$TotalPedido', '1')";
    
    
    $last_id = $con->EjecutaQuery($sql2);

  

    echo $last_id;

    exit;


}

if($funcion == "AgregarDetallePedido" ){

    $id_Pedido  	= $_POST['idPedido'];
    $linea	        = $_POST['linea'];  
    $codigo	        = $_POST['codigo'];  
    // $nombre	        = $_POST['nombre'];  
    // $descripcion    = $_POST['descripcion'];
    // $precioU        = $_POST['precioU'];
    $cantidad       = $_POST['cantidad'];
    $Tlinea         = $_POST['Tlinea'];
    

    $sql1 ="SELECT * FROM `producto` WHERE `Codigo` = '$codigo' ";
    $producto = $con->consultaQuery($sql1);


    foreach($producto as $p ){

        $ExistenciaActual = $p['Existencia'];

        $nombre	        = $p['Nombre'];  
        $descripcion    = $p['Descripcion'];
        $precioU        = $p['Precio_unitario'];

    }



    $ExistenciaRestante =   $ExistenciaActual - $cantidad ;

    $sql1 = "UPDATE `cof80210_ofimyd`.`producto` SET `Existencia`='$ExistenciaRestante' WHERE  `Codigo`= '$codigo' ";
    $updatea =  $con ->EjecutaQuery($sql1);


    $sql2 ="INSERT INTO `cof80210_ofimyd`.`det_pedido`  (`ID_Pedido`, `linea`, `codigo`, `nombre`, `descripcion`, `precio_unitario`, `cantidad`, `total_linea`)
    VALUES ('$id_Pedido', '$linea', '$codigo', '$nombre', '$descripcion', '$precioU', '$cantidad', '$Tlinea')";
    
    
    $inserta=  $con ->EjecutaQuery($sql2);

    echo true;
    exit;


}


if($funcion == "ModificaPedido" ){

    $idUsuario	= $_POST['idUsuario'];  
    $nombre		= $_POST['nombre']; 
    $username   = $_POST['username'];  
    $password	= $_POST['password']; 
    $tipo	    = $_POST['tipo']; 

    $sql = "UPDATE `cof80210_ofimyd`.`usuario` SET `id_usuario`='$idUsuario', `nombre`='$nombre', `username`='$username', `password`='$password', `tipo`='$tipo' WHERE  `id_usuario`=$idUsuario";
    $updatea =  $con ->EjecutaQuery($sql);
    exit;

}
if($funcion == "EliminarPedido" ){

    $idPedido	= $_POST['idPedido'];  


        //resta el valor del detalle eliminado al total del pedido
        $sql1 ="SELECT * FROM `det_pedido` WHERE `id_pedido` =$idPedido  "; 
        $Cantidad = $con->consultaQuery($sql1);


        foreach($Cantidad as $cant ){

            $codigo     = $cant['codigo'];
            $existencia = $cant['cantidad'];
            $totalDEtalle      = $cant['total_linea'];



            
            //devuelve existencia al producto
                
                $sql4 ="SELECT * FROM `producto` WHERE `Codigo` ='$codigo'  ";
                $pro = $con->consultaQuery($sql4);


                foreach($pro as $productillo){

                    $exisD =  $productillo['Existencia'];
                }

                $totalExistencia = $exisD  + $existencia ;


                
                $sql5 = "UPDATE `cof80210_ofimyd`.`producto` SET `Existencia`='$totalExistencia'   WHERE  `Codigo`= '$codigo' ";
                $updatea2 =  $con ->EjecutaQuery($sql5);


                $sql6 = " DELETE FROM `cof80210_ofimyd`.`det_pedido` WHERE  `ID_Pedido`=$idPedido ";
                $Pedidos = $con->consultaQuery($sql6);



        }



    $sql = " DELETE FROM `cof80210_ofimyd`.`pedido` WHERE  `ID_Pedido`=$idPedido";
    
    $elimina=  $con ->EjecutaQuery($sql);






    exit;

}


if($funcion == "EliminarDetallePedido" ){

    $idPedido	= $_POST['idPedido'];  
    $idDetPedido= $_POST['idDetPedido']; 
    $tipo	    = $_POST['tipo']; 
    


    if ($tipo == 1){

        //resta el valor del detalle eliminado al total del pedido
                    $sql1 ="SELECT * FROM `det_pedido` WHERE `id_pedido` =$idPedido AND `id_det_pedido` = $idDetPedido "; 
                    $Cantidad = $con->consultaQuery($sql1);


                    foreach($Cantidad as $cant ){

                        $codigo     = $cant['codigo'];
                        $existencia = $cant['cantidad'];
                        $totalDEtalle      = $cant['total_linea'];
                    }


                    $sql2 ="SELECT * FROM `pedido` WHERE `id_pedido` =$idPedido "; 
                    $Cantidad = $con->consultaQuery($sql2);
                
                
                    foreach($Cantidad as $cant ){
                
                        $totalPedido     = $cant['total_pedido'];
                
                    }
                
                    $Tot =   $totalPedido - $totalDEtalle ;
                
                
                
                    $sql3 = "UPDATE `cof80210_ofimyd`.`pedido` SET `total_pedido`=$Tot   WHERE  `id_pedido` =$idPedido";
                    $updatea1 =  $con ->EjecutaQuery($sql3);
                
                    


                //devuelve existencia al producto
                    
                    $sql4 ="SELECT * FROM `producto` WHERE `Codigo` ='$codigo'  ";
                    $pro = $con->consultaQuery($sql4);


                    foreach($pro as $productillo){

                        $exisD =  $productillo['Existencia'];
                    }

                    $totalExistencia = $exisD  + $existencia ;


                    
                    $sql5 = "UPDATE `cof80210_ofimyd`.`producto` SET `Existencia`='$totalExistencia'   WHERE  `Codigo`= '$codigo' ";
                    $updatea2 =  $con ->EjecutaQuery($sql5);


                    $sql6 = " DELETE FROM `cof80210_ofimyd`.`det_pedido` WHERE  `ID_Pedido`=$idPedido AND `id_det_pedido` = $idDetPedido";
                    $Pedidos = $con->consultaQuery($sql6);

    }




    if($tipo == 2){

        $sql5 = " DELETE FROM `cof80210_ofimyd`.`det_pedido` WHERE  `ID_Pedido`=$idPedido";
        $Pedidos = $con->consultaQuery($sql5);

    }





    exit;

}


if($funcion == "LimpiaDetallex" ){

    $idPedido	= $_POST['idPedido'];
    $tot	    = $_POST['totalix'];


    $sql0 ="SELECT * FROM `det_pedido` WHERE  `id_pedido`=$idPedido " ; 
    $detalles = $con->consultaQuery($sql0);

    foreach($detalles  as $detalle){

        $codigo = $detalle['codigo'];
        $cantidad = $detalle['cantidad'];

    }


    $sql1 ="SELECT * FROM `producto` WHERE `Codigo` = '$codigo' ";
    $prod = $con->consultaQuery($sql1);


    foreach($prod as $p ){

        $ExistenciaActual = $p['Existencia'];

    }

    $EXI = $ExistenciaActual + $cantidad;



    $sql2 = "UPDATE `cof80210_ofimyd`.`producto` SET `Existencia`='$EXI' WHERE  `ID_Pedido`=$idPedido";
    $updatea =  $con ->EjecutaQuery($sql2);






    $sql3= " DELETE FROM `cof80210_ofimyd`.`pedido` WHERE  `ID_Pedido`=$idPedido";
    $EliminaPedido = $con->consultaQuery($sql3);

    $idPedido	= $_POST['idPedido'];
    $sql4 = " DELETE FROM `cof80210_ofimyd`.`det_pedido` WHERE  `id_pedido`=$idPedido";
    $EliminaDetallePedido = $con->consultaQuery($sql4);

    
    $sql5 = "UPDATE `cof80210_ofimyd`.`pedido` SET `total_pedido`='$tot' WHERE  `ID_Pedido`=$idPedido";
    $updatea =  $con ->EjecutaQuery($sql5);



    exit;

}


if($funcion == "ListarPedidos" ){
    
    $sql ="SELECT * FROM `pedido`"; 
    $Pedidos = $con->consultaQuery($sql);






   $tabla="<div class='container col-md-12 col-lg-12'>"; 
   $tabla= $tabla."<table id='tablaPedidos' class='table table-bordered table-condensed table-hover'>";
   $tabla= $tabla."<thead>"; 
   $tabla= $tabla." <tr class='even'>"  ;
   $tabla= $tabla."     <th class = 'text-center'>Cod. Pedido</th>";      
   $tabla= $tabla."     <th class = 'text-center'>Cod. Cliente</th>";      
   $tabla= $tabla."     <th class = 'text-center'>RUT</th>";  
   $tabla= $tabla."     <th class = 'text-center'>Nombre</th>";  
   $tabla= $tabla."     <th class = 'text-center'>Dirección</th>";
   $tabla= $tabla."     <th class = 'text-center'>Teléfono</th>";
   $tabla= $tabla."     <th class = 'text-center'>Comentario</th>";
   $tabla= $tabla."     <th class = 'text-center'>Nombre Vendedor</th>";

   $tabla= $tabla."     <th class = 'text-center'>Fecha Emisión</th>";
   $tabla= $tabla."     <th class = 'text-center'>Fecha Entrega</th>";
   $tabla= $tabla."     <th class = 'text-center'>Total Pedido</th>";
   $tabla= $tabla."     <th class = 'text-center'>Estado</th>";
   $tabla= $tabla."     <th class = 'text-center' style=' width: 150px;' >Acción</th>";
   
   $tabla= $tabla." </tr>";    
   $tabla= $tabla."</thead>"; 


   $tabla= $tabla."<tbody>";
    foreach($Pedidos as $pedido){

        $Femision= explode('-', $pedido['fecha_emision']);
        $day   = $Femision[2];
        $month = $Femision[1];
        $year  = $Femision[0];
        $FFemision = "$day-$month-$year";

        $Fentrega = explode('-', $pedido['fecha_entrega']);
        $dayF     = $Fentrega[2];
        $monthF   = $Fentrega[1];
        $yearF    = $Fentrega[0];
        $FFentrega = "$dayF-$monthF-$yearF";
        
        switch ($pedido['estado']) {
            case 1:
                $td1 ="    <td style='padding-top: 0px;  padding-bottom: 0px; background-color:yellow; '> Programado </td>";
                $td2 ="    <td style='padding-top: 0px; padding-bottom: 0px;'><button data-toggle='tooltip' title='Establece como entregado el pedido'  type='button' class='btn btn-success btn-sm btn-more-less' onclick='EntregarProducto(".$pedido['ID_Pedido'].")'><i class='bi bi-check-square-fill'></i></button><button data-toggle='tooltip' title='Modifica datos del pedido'  type='button' class='btn btn-warning btn-sm btn-more-less' onclick=' ModificarPedido(".$pedido['ID_Pedido'].")'><i class='bi bi-pencil-square'></i></button><button data-toggle='tooltip' title='Elimina el registro del pedido seleccionado.' class ='btn btn-danger btn-sm btn-more-less' onclick='EliminarPedido(".$pedido['ID_Pedido'].")'><i class='bi bi-x-square'></i></button></td>";
                break;
            case 2:
                $td1 ="    <td style='padding-top: 0px; padding-bottom: 0px; background-color:green; '> Entregado </td>";
                // $td2 ="    <td> -- </td>";
                $td2 ="    <td style='padding-top: 0px; padding-bottom: 0px;'><button data-toggle='tooltip' title='Establece como entregado el pedido'  type='button' class='btn btn-success btn-sm btn-more-less' onclick='EntregarProducto(".$pedido['ID_Pedido'].")'><i class='bi bi-check-square-fill'></i></button><button data-toggle='tooltip' title='Modifica datos del pedido'  type='button' class='btn btn-warning btn-sm btn-more-less' onclick=' ModificarPedido(".$pedido['ID_Pedido'].")'><i class='bi bi-pencil-square'></i></button><button data-toggle='tooltip' title='Elimina el registro del pedido seleccionado.' class ='btn btn-danger btn-sm btn-more-less' onclick='EliminarPedido(".$pedido['ID_Pedido'].")'><i class='bi bi-x-square'></i></button></td>";

                break;
            case 3;
                $td1= "    <td style='padding-top: 0px; padding-bottom: 0px; background-color:red; '> Cancelado </td>";
            break;
        }

        
        $tabla= $tabla."<tr  style='background-color:red;' class='' id=".$pedido['ID_Pedido']. ">";  
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['ID_Pedido']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['ID_Cliente']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['rut']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['nombre']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['direccion']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['telefono']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['comentario']."</td>";
        // $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['rut_vendedor']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['vendedor']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$FFemision."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$FFentrega."</td>";

        $sql2 ="SELECT * FROM `det_pedido` WHERE `id_pedido` = ". $pedido['ID_Pedido']." "; 
        $det_pedido = $con->consultaQuery($sql2);
        $valor = 0;
        foreach($det_pedido as $detalleLinea){
    
            $val =  $detalleLinea['total_linea'];
            $valor = $valor + $val;
        }


        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>$.".$valor."</td>";

        $tabla= $tabla.$td1;

        // $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$pedido['estado']."</td>";
        $tabla= $tabla.$td2;

        $tabla= $tabla."</tr>";  

    }

    $tabla= $tabla."</tbody>";
    $tabla= $tabla."</table>";
    $tabla= $tabla."</div>"; 


    echo $tabla;
    // echo $cabeceraListaCliente;

    exit;


}

if($funcion == "ListarDetallesPedidos" ){
    $idPedido	= $_POST['idPedido'];  

    $sql ="SELECT * FROM `det_pedido` WHERE `id_pedido` =$idPedido "; 
    $Pedidos = $con->consultaQuery($sql);

    $tabla="";

    $i = 0;

    foreach($Pedidos as $pedido){

        $i = $i + 1;
        // $tabla = $tabla. "<tr id='detalle_". $pedido['linea']."'>";
         $tabla = $tabla. "<tr id='detalle_". $i ."'>";
        $tabla = $tabla. " <input id='id_detalle_".$pedido['id_det_pedido']."' value='".$pedido['id_det_pedido']."' name='prodId' type='hidden'  > ";
        $tabla = $tabla. " <td class='Tdato'> ". $pedido['codigo']. " </td> ";
        $tabla = $tabla. " <td class='Tdato'> ". $pedido['nombre']. " </td> ";
        $tabla = $tabla. " <td class='Tdato'> ". $pedido['descripcion']. " </td> ";
        $tabla = $tabla. " <td class='Tdato'> ". $pedido['precio_unitario']." </td>";
        $tabla = $tabla. " <td class='Tdato'> ". $pedido['cantidad']." </td>";
        // $tabla = $tabla. " <td class='Tdato' id='TOT_".$pedido['linea']."' > ". $pedido['total_linea']." </td>";
        $tabla = $tabla. " <td class='Tdato' id='TOT_".$i."' > ". $pedido['total_linea']." </td>";


        // $tabla = $tabla. " <td class='Tdato'> <button data-toggle='tooltip' title='Elimina el detalle actual'  type='button' class='btn btn-success btn-sm btn-more-less' onclick='EliminaDetalle(".$pedido['id_det_pedido'].",1,". $pedido['linea'].")'><i class='bi bi-x-square'></i></button></td>";
        $tabla = $tabla. " <td class='Tdato' style='font-size:9px;'>  No Modificable  </td>";

        $tabla = $tabla. "</tr>";


    }
    echo $tabla;
    // echo $cabeceraListaCliente;

    exit;


}


if($funcion == "AgregaUsuario" ){

    // $idUsuario	= $_POST['idUsuario'];  
    $nombre		= $_POST['nombre']; 
    $username   = $_POST['username'];  
    $password	= $_POST['password']; 
    $tipo	    = $_POST['tipo']; 

    $sql ="INSERT INTO `cof80210_ofimyd`.`usuario`  ( `nombre`, `username`, `password`,tipo) VALUES ('$nombre', '$username', '$password',$tipo)";
    $insert = $con->EjecutaQuery($sql);
    exit;
}

if($funcion == "ModificaUsuario" ){

    $idUsuario	= $_POST['idUsuario'];  
    $nombre		= $_POST['nombre']; 
    $username   = $_POST['username'];  
    $password	= $_POST['password']; 
    $tipo	    = $_POST['tipo']; 

    $sql = "UPDATE `cof80210_ofimyd`.`usuario` SET `id_usuario`='$idUsuario', `nombre`='$nombre', `username`='$username', `password`='$password', `tipo`='$tipo' WHERE  `id_usuario`=$idUsuario";
    $updatea =  $con ->EjecutaQuery($sql);
    exit;

}
if($funcion == "EliminarUsuario" ){

    $idUsuario	= $_POST['idUsuario'];  

    $sql = " DELETE FROM `cof80210_ofimyd`.`usuario` WHERE  `id_usuario`=$idUsuario";
    
    $elimina=  $con ->EjecutaQuery($sql);
    exit;

}

if($funcion == "ListarUsuarios" ){
    
    $sql ="SELECT * FROM `usuario`"; 
    $Usuarios = $con->consultaQuery($sql);

   $tabla="<div class='container col-md-8 col-lg-8'>"; 
   $tabla= $tabla."<table id='tablaProductos' class='table table-bordered table-condensed table-hover'>";
   $tabla= $tabla."<thead>"; 
   $tabla= $tabla." <tr class='even'>"  ;
   $tabla= $tabla."     <th class = 'text-center'>Nombre</th>";      
   $tabla= $tabla."     <th class = 'text-center'>Nombre Usuario</th>";      
   $tabla= $tabla."     <th class = 'text-center'>Contraseña</th>";  
   $tabla= $tabla."     <th class = 'text-center'>Tipo Usuario</th>";
   $tabla= $tabla."     <th class = 'text-center'>Acción</th>";
   
   $tabla= $tabla." </tr>";    
   $tabla= $tabla."</thead>"; 


   $tabla= $tabla."<tbody>";
    foreach($Usuarios as $usuario){

        $tabla= $tabla."<tr id=".$usuario['id_usuario'].">"; 
        
        if ($usuario['tipo'] == 1){
            $tipoU = "Administrador";
        }
        if ($usuario['tipo'] == 2){
            $tipoU = "Colaborador";
        }
        

        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$usuario['nombre']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$usuario['username']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$usuario['password']."</td>";
        $tabla= $tabla."    <td value='".$usuario['tipo']."' style='padding-top: 0px; padding-bottom: 0px;'>".$tipoU."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'><button data-toggle='tooltip' title='Modifica el usuario seleccionado'  type='button' class='btn btn-warning btn-sm btn-more-less' onclick=' ModificarUsuario(".$usuario['id_usuario'].")'><i class='bi bi-pencil-square'></i></button><button data-toggle='tooltip' title='Elimina el registro del producto.' class ='btn btn-danger btn-sm btn-more-less' onclick=' EliminaClienteUsuario(4,".$usuario['id_usuario'].")')'><i class='bi bi-x-square'></i></button></td>";

        $tabla= $tabla."</tr>";  

    }

    $tabla= $tabla."</tbody>";
    $tabla= $tabla."</table>";
    $tabla= $tabla."</div>"; 


    echo $tabla;
    // echo $cabeceraListaCliente;

    exit;


}





if($funcion == "AgregaProducto" ){

    $codigo		= $_POST['codigo'];  
    $nombre		= $_POST['nombre']; 
    $descripcion= $_POST['descripcion'];  
    $categoria	= $_POST['categoria']; 
    $precioU	= $_POST['precioU']; 
    $existencia	= $_POST['existencia']; 

    $sql ="INSERT INTO `cof80210_ofimyd`.`producto`  (`Codigo`, `Nombre`, `Descripcion`,`Precio_unitario`, `Categoria`,Existencia) VALUES ('$codigo','$nombre', '$descripcion',$precioU, '$categoria',$existencia)";
    $insert = $con->EjecutaQuery($sql);
    exit;
}

if($funcion == "ModificaProducto" ){

    $idproducto	= $_POST['idproducto'];  
    $codigo		= $_POST['codigo'];  
    $nombre		= $_POST['nombre']; 
    $descripcion= $_POST['descripcion'];  
    $categoria	= $_POST['categoria']; 
    $precioU	= $_POST['precioU']; 
    $existencia	= $_POST['existencia']; 

    $sql = "UPDATE `cof80210_ofimyd`.`producto` SET `Codigo`='$codigo', `Nombre`='$nombre', `Descripcion`='$descripcion', `Categoria`='$categoria',`Precio_unitario` = $precioU , `Existencia`= '$existencia' WHERE  `ID_Producto`=$idproducto";
    $updatea =  $con ->EjecutaQuery($sql);
    exit;

}
if($funcion == "EliminarProducto" ){

    $idproducto	= $_POST['idproducto'];  

    $sql = " DELETE FROM `cof80210_ofimyd`.`producto` WHERE  `ID_Producto`=$idproducto";
    
    $elimina=  $con ->EjecutaQuery($sql);
    exit;

}

if($funcion == "ListarProductos" ){
    
    $sql ="SELECT * FROM `producto`"; 
    $productos = $con->consultaQuery($sql);

   $tabla="<div class='container col-md-8 col-lg-8'>"; 
   $tabla= $tabla."<table id='tablaProductos' class='table table-bordered table-condensed table-hover'>";
   $tabla= $tabla."<thead>"; 
   $tabla= $tabla." <tr class='even'>"  ;
   $tabla= $tabla."     <th class = 'text-center'>Código</th>";       
   $tabla= $tabla."     <th class = 'text-center' style ='min-width:100px;' >Nombre</th>";      
   $tabla= $tabla."     <th class = 'text-center'>Descripción</th>";      
   $tabla= $tabla."     <th class = 'text-center'>Categoría</th>";  
   $tabla= $tabla."     <th class = 'text-center'>Precio</th>";  
   $tabla= $tabla."     <th class = 'text-center'  >Existencia</th>";
   $tabla= $tabla."     <th class = 'text-center '>Acción</th>";
   
   $tabla= $tabla." </tr>";    
   $tabla= $tabla."</thead>"; 


   $tabla= $tabla."<tbody>";
    foreach($productos as $producto){

        $tabla= $tabla."<tr id=".$producto['ID_Producto'].">"; 
        
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$producto['Codigo']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$producto['Nombre']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$producto['Descripcion']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$producto['Categoria']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$producto['Precio_unitario']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px;'>".$producto['Existencia']."</td>";
        $tabla= $tabla."    <td style='padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'><button data-toggle='tooltip' title='Modifica el producto seleccionado'  type='button' class='btn btn-warning btn-sm btn-more-less' onclick=' ModificarProducto(".$producto['ID_Producto'].")'><i class='bi bi-pencil-square'></i></button><button data-toggle='tooltip' title='Elimina el registro del producto.' class ='btn btn-danger btn-sm btn-more-less' onclick=' EliminaProducto(".$producto['ID_Producto'].")')'><i class='bi bi-x-square'></i></button></td>";

        $tabla= $tabla."</tr>";  

    }

    $tabla= $tabla."</tbody>";
    $tabla= $tabla."</table>";
    $tabla= $tabla."</div>"; 


    echo $tabla;
    // echo $cabeceraListaCliente;

    exit;


}





if($funcion == "AgregaCliente"){
    
    $nombre    = $_POST['nombre'];
    $appat     = $_POST['appat'];
    $rut       = $_POST['rut'];
    $direccion = $_POST['direccion'];
    $telefono  = $_POST['telefono'];
    $NEmpresa  = $_POST['NEmpresa'];
    $REmpresa  = $_POST['REmpresa'];
    $plazo     = $_POST['plazo'];
    $vendedor  = $_POST['vendedor'];
 
    
    $sql ="INSERT INTO `cof80210_ofimyd`.`cliente` (`Nombre`, `Appat`, `RutCliente`, `Direccion`, `Telefono`, `NombreEmpresa`, `RutEmpresa`,`Plazo`,`Vendedor`,`FechaInsert`,`Estado`) VALUES ('$nombre', '$appat', '$rut', '$direccion', $telefono, '$NEmpresa','$REmpresa','$plazo','$vendedor',NOW(),'1')";

    $insert = $con->EjecutaQuery($sql);


    exit;

}

if($funcion == "ModificaCliente"){

    $idcliente = $_POST['idcliente'];
    $nombre    = $_POST['nombre'];
    $appat     = $_POST['appat'];
    $rut       = $_POST['rut'];
    $direccion = $_POST['direccion'];
    $telefono  = $_POST['telefono'];
    $NEmpresa  = $_POST['NEmpresa'];
    $REmpresa  = $_POST['REmpresa'];
    $plazo     = $_POST['plazo'];
    $vendedor  = $_POST['vendedor'];

    $sql = "UPDATE `cof80210_ofimyd`.`cliente` SET `Nombre`='$nombre', `Appat`='$appat', `RutCliente`='$rut', `Direccion`='$direccion', `Telefono`='$telefono', `NombreEmpresa`='$NEmpresa', `Plazo`='$plazo'  ,`Vendedor`='$vendedor'  WHERE  `ID_Cliente`=$idcliente";

    $updatea =  $con ->EjecutaQuery($sql);
    exit;
}

if($funcion == "EliminaCliente"){

    $idcliente = $_POST['idcliente'];

    $sql = " DELETE FROM `cof80210_ofimyd`.`cliente` WHERE  `ID_Cliente`=$idcliente";
    
    $elimina=  $con ->EjecutaQuery($sql);
    exit;
}

if ($funcion == "ListarClientes"){

    $sql ="SELECT * FROM `cof80210_ofimyd`.`cliente`";
    $clientes = $con->consultaQuery($sql);

   $tabla="<div class='container col-xs-12 col-md-12 col-lg-12'>"; 
   $tabla= $tabla."<table id='tablaClientes' class='table table-bordered table-condensed table-hover'>";
   $tabla= $tabla."<thead>"; 
   $tabla= $tabla." <tr class='even' style ='padding-top: 2px; padding-buttom: 2px;'>"  ;
   $tabla= $tabla."     <th class = 'text-center' >ID</th>";       
   $tabla= $tabla."     <th class = 'text-center'>Nombre</th>";      
   $tabla= $tabla."     <th class = 'text-center'>Apellido</th>";      
   $tabla= $tabla."     <th class = 'text-center'>Rut</th>";  
   $tabla= $tabla."     <th class = 'text-center'>Dirección</th>"; 
   $tabla= $tabla."     <th class = 'text-center'>Teléfono</th>";
   $tabla= $tabla."     <th class = 'text-center'>Empresa</th>"; 
   $tabla= $tabla."     <th class = 'text-center'  style ='min-width:100px;'>RUT Empresa</th>";
   $tabla= $tabla."     <th class = 'text-center'style ='min-width:100px;'>Plazo de Pago</th>";
   $tabla= $tabla."     <th class = 'text-center'>Vendedor</th>";
   $tabla= $tabla."     <th class = 'text-center' style ='min-width:110px;'>Acción</th>";   
   $tabla= $tabla." </tr>";    
   $tabla= $tabla."</thead>"; 


   $tabla= $tabla."<tbody>";
    foreach($clientes as $cliente){

        $tabla= $tabla."<tr id=".$cliente['ID_Cliente']." style = '' >"; 

        $tabla= $tabla."    <td class = 'align-center' style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle; max-width: 5px;min-width: 5px; overflow:hidden;white-space:nowrap;text-overflow: ellipsis;' >".$cliente['ID_Cliente']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['Nombre']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['Appat']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['RutCliente']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['Direccion']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['Telefono']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['NombreEmpresa']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['RutEmpresa']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['Plazo']."</td>";
        $tabla= $tabla."    <td style = 'padding-top: 0px; padding-bottom: 0px; vertical-align: middle;  overflow:hidden;white-space:nowrap;text-overflow: ellipsis;'>".$cliente['Vendedor']."</td>";
        
        // $tabla= $tabla."    <td style = 'vertical-align: middle; max-width: 40px;min-width: 30px;'><button class ='btn btn-warning btn-sm' onclick=' ModificarCliente(".$cliente['ID_Cliente'].")' >Editar</button><button class ='btn btn-danger btn-sm' onclick=' EliminaClienteUsuario(3,".$cliente['ID_Cliente'].")' >Eliminar</button></td>";
        $tabla= $tabla."    <td style = ' padding-top: 0px; padding-bottom: 0px; vertical-align: middle; '><button   title='Generar pedido para el cliente actual' type='button' class='btn btn-success btn-sm btn-more-less'  data-toggle='modal' data-target='#MoPedido' onclick='LlenarPedido(".$cliente['ID_Cliente'].")'><i class='bi bi-file-earmark-plus-fill'></i></button><button  data-toggle='tooltip' title='Modifica el cliente seleccionado' type='button' class='btn btn-warning btn-sm btn-more-less' onclick=' ModificarCliente(".$cliente['ID_Cliente'].")'><i class='bi bi-pencil-square'></i></button><button data-toggle='tooltip' title='Elimina el usuario actual' class ='btn btn-danger btn-sm btn-more-less' onclick=' EliminaClienteUsuario(3,".$cliente['ID_Cliente'].")')'><i class='bi bi-x-square'></i></button></td>";


        // 
        $tabla= $tabla."</tr>";  

    }

    $tabla= $tabla."</tbody>";
    $tabla= $tabla."</table>";
    $tabla= $tabla."</div>"; 

    echo $tabla;
    // echo $cabeceraListaCliente;

    exit;

}



?>