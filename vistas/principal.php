<?php

$a = "";
$b = "";
$c = "";



include_once("controladores/conexion.php");
// include_once("controladores/usuario.php");


    // $sql ="INSERT INTO `prueba`.`alumno` (`nombre`, `appat`) VALUES ('Camila', 'Aravena');";
        // Conexion::conexionBD()->exec($sql);

    $newCon = new conexion();



?>
<!doctype html>


<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


        <script src="modelo/js_config/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
        <link   rel="shortcut icon" href="#">

    <!-- Bootstrap CSS -->
    <link href="modelo/css_config/bootstrap.min.css" rel="stylesheet"gin="anonymous">
    <link href="modelo/css_config/datatables.min.css" rel="stylesheet"gin="anonymous">
    <link href="modelo/css/estilos.css" rel="stylesheet"gin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap4.min.css"/>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

    <!-- Select2 CSS --> 
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> 

    <!-- jQuery --> 
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  -->

    <!-- Select2 JS --> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    


    <title>Sistema de Gestión y Control M&D</title>
  </head>
  <body>

    <!-- cuerpo -->
    <div class="wrapper">
    <nav id="sidebar" class="col-xs-6  col-md-6 col-lg-6">
        <div class="sidebar-header">
          <section> 
          <h2>BIENVENIDO</h2>
          <h3 id="nam"> <?php echo strtoupper($usuario->obtenerNombre()); ?> </h3>

          </section>

           
            <hr>
        </div>
        <ul class="list-unstyled components">
            <p>MENUS</p>
            <li> <a href="#" onclick="CargaInicio()">INICIO</a> </li>

            
            <li> <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Administración</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li> <a href="#"  onclick="MenuClientes(1)">Adm. Clientes</a> </li>
                    <li> <a href="#"  onclick="MenuClientes(2)">Adm. Productos</a> </li>
                    <li> <a href="#"  onclick="MenuClientes(3)">Adm. Pedidos  </a> </li>
                    <?php  
                          $tipo = $usuario->obtenerTipo();
                        if($tipo == 1){
                          echo "<li> <a href='#'  onclick='MenuClientes(4)'>Adm. Usuario </a> </li>";
                          // echo "<li> <a href='#'  data-toggle='modal' data-target='#config'>Configuración BD  </a> </li>";
                        }
                           
                    ?>
                    
                    
                </ul>
            </li>

            <!-- <li> <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Disponible 0</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    <li> <a href="#">algo 1</a> </li>
                    <li> <a href="#">algo 2</a> </li>
                    <li> <a href="#">algo 3</a> </li>
                </ul>
            </li>

            <li> <a href="#">Dispo 1</a> </li>
            <li> <a href="#">Disponible 2</a> </li>
            <li> <a href="#">Disponible 3</a> </li>
            <li> <a href="#">Disponible 4</a> </li> -->
        </ul>
        <ul class="list-unstyled CTAs">
            <li> <a href="controladores/logout.php" class="Csesion">Cerrar Sesión</a> </li>
            <li> <p style="font-size:14px ;" class="Csesion text-center" >DESARROLADO POR DANIEL ARACENA</p>  </li>
            <li> <a href="https://www.facebook.com/AceroHDa" class="Csesion"> FACEBOOK</a> </li>
            <li> <a href="https://www.instagram.com/dachcero/" class="Csesion">  INSTAGRAM</a> </li>

        </ul>
    </nav>
    <div class="content col-xs-12 col-md-12 col-lg-12">


            <nav class="navbar navbar-expand-lg navbar-light bg-light"> 
              <button type="button" id="sidebarCollapse" class="btn btn-info"> 
                <i class="bi bi-layout-text-sidebar-reverse"> MENÚ</i> 
              </button>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span> 
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"> <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#">1</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#">2</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#">3</a> </li>
                    </ul>
                </div>
            </nav>
          <div class="content-wrapper" >
            <div class="row" id="ped"> 

              <div class=" col-1 text-center" id="">
                    
                    <div id="cont1" name="cabecera" > 
                      

                    </div>
                   
                    <div id="cont11" name="cuerpo" class="text-left"> 
                      

                    </div>
                    
              </div>
              <div class=" col-xs-10 col-md-10 col-lg-10" id="">
                    <div id="cont2" class="text-center" name="cabecera" >

                    </div>
                    <div class="container" id="cont22"  name="cuerpo" style="font-size: 14px; " >

                    </div>

              </div>


            </div>


        </div>

      </div>


    </div>
</div>

<!-- MODALES -->


<!-- MODAL AGREGAR PEDIDO -->
<div class="modal" id="MoPedido" style="overflow-y: scroll;">
    <div class="modal-ku ">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
        <div class="container text-center" id="tituloPEDIDO">
          <h3 class="modal-title">Nuevo Pedido</h3>
        </div>
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        </div>
          <!-- Modal body -->
              
                  <div class="container-fluid col-xs-12 col-md-12 col-lg-12 text-center">
                  <!-- <h4> Datos Cliente </h4> -->

                        <div class="row">
                          <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                               <p style="margin-bottom:5px; font-size: 14px;"  > Código Pedido</p>
                              <input style="margin-bottom:5px;" class="text-center" type="text" placeholder="SIN ASIGNAR" id="IDPedido" size="8" maxlength="8" disabled>
                          </div>


                          <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                               <p style="margin-bottom:5px; font-size: 14px;" > Código Cliente </p>
                              <input style="margin-bottom:5px; " class="text-center" type="text" placeholder="" id="IDClientePedido" size="8" maxlength="8" disabled>
                          </div>

                          <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                               <p style="margin-bottom:5px; font-size: 14px;" > RUN Cliente</p>
                               <input style="margin-bottom:5px; " class="text-center" type="text" placeholder="" id="RUNClientePedido" size="8" maxlength="8" disabled>
                          </div>

                          <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                               <p style="margin-bottom:5px; font-size: 14px;" > Fecha Emisión</p>
                              <input style="margin-bottom:5px; " class="text-center" type="text" placeholder="SIN ASIGNAR" id="FECHAClientePedido" size="8" maxlength="8" disabled>
                          </div>


                        </div>

                        <div class="row">
                          

                            <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                              <p style="margin-bottom:5px; font-size: 14px;" > Nombre cliente</p>
                              <input style="margin-bottom:5px; width:200px;" class="text-center" type="text"  maxlength="8"  placeholder="" id="NOMBREClientePedido" disabled>
                            </div>
                            
                            <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                              <p style="margin-bottom:5px; font-size: 14px;" > Direción</p>
                              <input style="margin-bottom:5px; width:200px;" class="text-center" type="text" maxlength="13"  placeholder="" id="DIRClientePedido" disabled>
                            </div>
                            
                            <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                              <p style="margin-bottom:5px; font-size: 14px;" > Teléfono</p>
                              <input style="margin-bottom:5px; width:130px;" class="text-center" type="text"  maxlength="9"placeholder="Teléfono" id="TELClientePedido" disabled>
                            </div>

                            
                            <div class="container col-xs-3 col-md-3 col-lg-3 text-center"> 
                                    <p style="margin-bottom:5px; font-size: 14px;" > Fecha Entrega</p>
                                    <input style="margin-bottom:5px; width:130px;  font-size: 12px; " class="text-center" type="date" placeholder="SIN ASIGNAR" value="05-05-2022" id="FECHAENTREGAClientePedido" size="8" maxlength="8"  required min=<?php $hoy=date("Y-m-d"); echo $hoy;?>>


                            </div>


                              


                        </div>

                  </div>

                  <div class="container-fluid col-xs-12 col-md-12 col-lg-12 text-center">
                    <div class="row">
                      <div class="container col-xs-12 col-md-12 col-lg-12 text-center"> 
                        <div class="row">
                          <div class="container  col-3 text-center">
                                  <p style="margin-bottom:5px;" > Productos </p>

                                  <select style="width:200px; font-size: 10px;" id="Productos" class="">
                                      <!-- <option value="" selected>Seleccione un producto</option> -->
                                  </select>

                          </div>

                          <div class="container  col-3 text-center">
                                  <p style="margin-bottom:5px;" > STOCK </p>
                                  <input style="margin-bottom:5px; width:100px; " class="text-center" type="number" placeholder="STOCK" id="STOCK" size="5" maxlength="5" disabled>


                          </div>
                          
                          <div class="container  col-3 text-center">
                                  <p style="margin-bottom:5px;" > Cantidad </p>
                                  <input style="margin-bottom:5px; width:70px; " class="text-center" type="number" placeholder="" id="ProductoCantidad" size="5" maxlength="5" min="0"  required disabled>
                                  

                          </div>

                          <div class="container  col-3 text-center">

                                   <button style="margin-top:30px; width:130px; font-size: 12px;" type="button" class="btn btn-success" onclick="AgregarDetalle();" >Agregar Producto</button>

                          </div>

                        </div>

                      </div>
                    </div>

                  </div>
                  <br>

                  <div class="row">
                    <div class="container text-center">
                    <p style="margin-bottom:5px;" > Comentario adicional </p>
                      <textarea style="margin-bottom:10px;  font-size: 12px;" id="comentarioPedido"  rows="2" cols="20" type="text" placeholder="Agrege un Comentario."  maxlength="250" >

                      </textarea>
                          <!-- <input style="margin-top:30px; width:60px; height:60px;  font-size: 12px;" type="text" placeholder="Agrege un Comentario." size="30" maxlength="60" > -->


                    </div>
                  </div>
                  <br> 
                  <div class="row"> 
                    <div class="container col-10 text-center ">
                                  <table class="Tcabecera" id="TBPedido">
                                    <tr class="Tcabecera">
                                        <!-- <th class="Tdato">Linea</th> -->
                                        <th class="Tdato">Codigo</th>
                                        <th style="width: 150px;" class="Tdato">Nombre</th>
                                        <th style="width: 150px;" class="Tdato">Descripción</th>
                                        <th style="width: 130px;"  class="Tdato">Precio U.</th>
                                        <th class="Tdato">Cantidad</th>
                                        <th style="width: 100px;" class="Tdato">total linea</th>
                                        <th style="width: 100px;" class="Tdato">Eliminar Detalle</th>
                                    </tr>

                                  </table>
                    </div>
                    <div class="container-fluid col-2 text-center ">
                              <table class="Tcabecera">
                                    <tr class="Tcabecera">
                                        <th class="Tdato">TOTAL PEDIDO</th>
                                    </tr>
                                    <td id="TOTALP" >
                                        <h4>$.</h4> 
                                    </td>

                                  </table>

                              </div>
                  </div>
          <!-- Modal footer -->
        <div class="modal-footer text-center">
          <div class="container text-center" id="btnPedido"> 
              <!-- <button type="button" id="btnPedido" class='btn btn-success' onclick='GenerarPedido(1);' >Generar Pedido</button>
              <button type="button" class="btn btn-warning" onclick="LimpiarAllDetalles();" >Limpiar Detalles</button>
              <button type="button" class="btn btn-secondary" onclick="CerrarModal();" >Cerrar</button> -->

            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> -->
          </div>
        </div>
        
      </div>
    </div>
  </div>
<!-- FIN LISTAR EXISTENCIAS -->






<!-- <div class="modal" id="MoPedido">
    <div class="modal-ku ">
      <div class="modal-content"> -->
      
        <!-- Modal Header -->
        <!-- <div class="modal-header">
          <div class="container text-center">
            <h4 class="modal-title"></h4>
          </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div> -->
          <!-- Modal body -->
              
              <!-- <div class="modal-body center modal-ku " id="cuerpoPedido" style="display: flex;"> 
              </div>
           -->
          <!-- Modal footer -->
        <!-- <div class="modal-footer text-center">
          <div class="container text-center"> 
            <button type="button" class='btn btn-primary' onclick='' >algo</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
        
      </div>
    </div>
  </div> -->
<!-- FIN AGREGAR PEDIDO -->

<!-- MODAL LISTAR EXISTENCIAS -->
<div class="modal" id="MoLEN" style="overflow-y: scroll;">
    <div class="modal-ku ">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
        <div class="container text-center">
          <h4 class="modal-title">Existencias Negativas</h4>
        </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <!-- Modal body -->
              
              <div class="modal-body center modal-ku " id="cuerpoLEN" style="display: flex;"> 
              </div>
          
          <!-- Modal footer -->
        <div class="modal-footer text-center">
          <div class="container text-center"> 
            <button type="button" class='btn btn-primary' onclick='ResetearExistencia();' >Resetear Todos</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
        
      </div>
    </div>
  </div>
<!-- FIN LISTAR EXISTENCIAS -->




<!-- AGREGAR CATEGORIA -->
<div class="modal fade in" id="MoCAT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header  d-block ">
        <h5 class="modal-title text-center" id="exampleModalLabel">Añadir Categoría</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


          <div class="container-fluid col-xs-12 col-md-12 col-lg-12 center">


          <input class="center" type="text" placeholder="NOMBRE CATEGORIA" id="nombreCAT" required >

          </div>
          <br>
          <br>

          <div id="" class="container-fluid col-xs-12 col-md-12 col-lg-12 center">



            <select style="width:200px; font-size: 10px;" id="selectCAT" class="">
                                      <!-- <option value="" selected>Seleccione un producto</option> -->
            </select>
            <button style="width:100px; font-size: 10px;" type="button" class="btn btn-primary" onclick="EliminarCAT();">Eliminar</button>

          </div>



      </div> 

      <div class="modal-footer justify-content-center" id="btnCAT">
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal" ">Cancelar</button> --> -->
          
        
      </div>
    </div>
  </div>
</div>
<!-- FIN AGREGAR categoria -->

<!-- MODAL INGRESAR CLIENTE -->
<div class="modal fade in" id="MoAgCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header  d-block " id="tituloCliente" >
        <h5 class="modal-title text-center" id="exampleModalLabel">Añadir Nuevo cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="formcliente">  
          <div class="container-fluid col-xs-12 col-md-12 col-lg-12 text-center">

              <input class="text-center" type="text" placeholder="RUN" id="rut" size="8" maxlength="8" required>
              <span> - </span>
              <input class="text-center" type="text" placeholder="CV" id="cv" size="1" maxlength="1" required>
              <div class="col-lg-12">
                <input class="text-center" type="text" placeholder="Vendedor" id="vendedor" size="10" maxlength="20" required>
                <span></span>
                <input class="text-center" type="number" placeholder="Plazo" id="plazo" size="2" min="0" max="99"  style ='width:70px;' required>
              </div>
              <input class="text-center" type="text" placeholder="Nombre" id="nombre" required>
              <span></span>
              <input class="text-center" type="text" placeholder="Apellido" id="appat" required>
              <span></span>
              <input class="text-center" type="text" placeholder="Dirección" id="dir" required>
              <input class="text-center" type="number" placeholder="Teléfono" id="tel" required>
              <input class="text-center" type="text" placeholder="Nombre Empresa" id="NEmpresa" required>
              <input class="text-center" type="text" placeholder="RUT Empresa" id="REmpresa" size="10" maxlength="10" required>

          </div>
      </div> 
    </form>
      <div class="modal-footer justify-content-center" id="btns">

      </div>
    </div>
   
  </div>
</div>

<!-- FIN AGREGAR CLIENTE -->


<!-- AGREGAR PRODUCTO -->
<div class="modal fade in" id="MoAgProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header  d-block ">
        <h5 class="modal-title text-center" id="exampleModalLabel">Añadir Nuevo Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


          <div class="container-fluid col-xs-12 col-md-12 col-lg-12 center">


          <input class="center" type="text" placeholder="CODIGO" id="cod" required>
          <input class="center" type="text" placeholder="NOMBRE PRODUCTO" id="nombreP" required >
          <input class="center" type="text" placeholder="DESCRIPCIÓN" id="desc" required>
          
          <select style="width:200px; font-size: 10px;" id="selectCAT2" class="">
                                      <!-- <option value="" selected>Seleccione un producto</option> -->
           </select>
          <input class="center" type="text" placeholder="PRECIO" id="precio" required>
          <input class="center" type="text" placeholder="CANTIDAD" id="exi" required>
          </div>
      </div> 

      <div class="modal-footer justify-content-center" id="btnP">
          <!-- <button type="button" class="btn btn-primary" onclick="AgregarCliente(0)">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" ">Cancelar</button> -->
          
        
      </div>
    </div>
  </div>
</div>
<!-- FIN AGREGAR PRODUCTO -->

<!-- AGREGAR USUARIO -->
<div class="modal fade in" id="MoAgUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header  d-block ">
        <h5 class="modal-title text-center" id="ModUser">	Agregar Nuevo Usuario </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


          <div class="container-fluid col-xs-12 col-md-12 col-lg-12 center">


            <input class="center" type="text" placeholder="NOMBRE" id="nombreU" required >
            <input class="center" type="text" placeholder="NOMBRE USUARIO" id="nombreUsername" required>
            <input class="center" type="text" placeholder="CONTRASEÑA" id="passU" required>
            <select name="tipo" id="tipoU">
              <option value="2">Colaborador</option>
              <option value="1">Administrador</option>
              
            </select>
          </div>
      </div> 

      <div class="modal-footer justify-content-center" id="btnU">
          <!-- <button type="button" class="btn btn-primary" onclick="Agregar(4)">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" ">Cancelar</button> -->
          
        
      </div>
    </div>
  </div>
</div>
<!-- FIN AGREGAR USUARIO -->




<!-- config bf -->
<div class="modal fade in" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog " role="document">
    <div class="modal-content ">
      <div class="modal-header  d-block ">
        <h5 class="modal-title text-center" id="exampleModalLabel">config del servidor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

          <div class="container-fluid col-xs-10 col-md-10 col-lg-10">
            
              <div class="row col-xs-12 col-md-12 col-lg-12" style="padding-top:10px;" >
                  <!-- <div class="d-flex justify-content-center" > -->
                      <div class=" col-md-12 col-md-12 mr-auto">
                        <input class="col-md-12 col-md-12" type=" text" placeholder="servidor" id="servidor" required>
                      </div>
                      <div class=" col-md-12 col-md-12 ml-auto">
                        <input class="col-md-12 col-md-12" type="text" placeholder="nombre" id="nombre" required >
                      </div>
                      <div class="col-xs-12 col-md-12 col-lg-12">
                      <input class="col-md-12 col-md-12" type="text" placeholder="contraseña" id="password" required>
                    </div>
                  <!-- </div> -->
              </div>

          </div>
      </div> 

      <div class="modal-footer justify-content-center" id="btnP">
          <!-- <button type="button" class="btn btn-primary" onclick="AgregarCliente(0)">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal" ">Cancelar</button> -->
          
        
      </div>
    </div>
  </div>
</div>
<!-- fin config -->




<!-- visuales -->
<ons-modal var="modal">   

</ons-modal>



<!-- MODAL CARGANDO -->

<div class="modal modal-static" id="carga" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="opacity:0.7;" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body text-center" >
          <img class="loading-image" style="height: 180px;width: 180px; padding-top: 20px;" src="http://www.downgraf.com/wp-content/uploads/2014/09/01-progress.gif">


              <p class="loading-text" style="  color: #000;font-size: 15px;">Procesando..</p>

					</div>
				</div>
			</div>
</div>

<!-- FIN CARGAR -->


<!-- MODAL CONFIRMA -->
  <div class="modal modal-static" id="carga" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="opacity:0.7;" >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body text-center" >
            <img class="loading-image" style="height: 180px;width: 180px; padding-top: 20px;" src="http://www.downgraf.com/wp-content/uploads/2014/09/01-progress.gif">


                <p class="loading-text" style="  color: #000;font-size: 15px;">Procesando..</p>

            </div>
          </div>
        </div>
  </div>


<!-- FIN CONFIRMA -->



<!-- fin visuales  -->
   <!-- REFERENCIAS -->

    <script src="modelo/js_config/bootstrap.min.js" ></script>
    <script src="modelo/js_config/datatables.min.js" ></script>
    <script type="text/javascript" src="modelo/js_config/bootstrap-confirmation.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="modelo/js/funciones.js?v=1.1"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    

  </body>
</html>