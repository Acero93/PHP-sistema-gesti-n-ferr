let idc;
let val;
let validado;
let totalpedido = 0;
let Prod;
let fechaActual ;
let fechaEntrega;
let lastID = 0;
let FilasIniciales= 0;
let total = 0;
let totalInicial = 0;
let totalAgregado = 0;
let T = 0;

// alert("texto");
// console.log("texto");

$(document).ready(function(){

	window.onload = function() {
		var reloading = sessionStorage.getItem("reloading");
			if (reloading) {
				sessionStorage.removeItem("reloading");
				$("#sidebar").toggleClass('active');
				ListarPedidos();
			}
		}

	$('[data-toggle="tooltip"]').tooltip(); 
	
	$("#sidebarCollapse").on('click', function(){
		
		$("#sidebar").toggleClass('active');
	
	});

		  // Initialize select2
		  $("#Productos").select2();
		  $("#Productos").select2({ dropdownCssClass: "myFont" });

		  $("#selectCAT2").select2();
		  $("#selectCAT2").select2({ dropdownCssClass: "myFont" });
	


	$('#MoAgCliente').on('hidden.bs.modal', function (e) {//deja en blanco los inputs agregar cliente
		
		$(this).find("input,textarea,select").val('').end();

	})
	
	$('#MoCAT').on('hidden.bs.modal', function (e) {//deja en blanco los inputs agregar cliente
		
			$('#nombreCAT').val("");


	})


	$('#MoPedido').on('hidden.bs.modal', function (e) {
		CerrarModal();
		
		
		totalAgregado = 0;
		totalInicial = 0;
		sessionStorage.setItem("reloading", "true");
        document.location.reload();
	})

	$("#vendedor").focusin(function(){


		rutCompleto = $("#rut").val() +"-"+ $("#cv").val();

		// console.log(rutCompleto);
		var Fn = {
			// Valida el rut con su cadena completa "XXXXXXXX-X"
			validaRut : function (rutCompleto) {
				if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
					return false;
				var tmp 	= rutCompleto.split('-');
				var digv	= tmp[1]; 
				var rut 	= tmp[0];
				if ( digv == 'K' ) digv = 'k' ;
				return (Fn.dv(rut) == digv );
			},
			dv : function(T){
				var M=0,S=1;
				for(;T;T=Math.floor(T/10))
					S=(S+T%10*(9-M++%6))%11;
				return S?S-1:'k';
			}
		}

	
		if (Fn.validaRut(rutCompleto) == false){
			alert("rut invalido, favor verificar");
			$("#rut").val("");
			$("#cv").val("");
			$('#cv').focus();
		}

	});

	
	$('#Productos').change(function() {
		var codigo = $("#Productos option:selected").val();
		traerDatosProductos(codigo);



	});
	


});


// var Datos =  new FormData();
// //1f
// Datos.set("nombre","daniel");
// //2f
// Datos.set("nombre","nibaldo");


// AGREGAR
function Agregar(op){ //para agregar y actualizar
	
	ValidaCampos();

 	if(validado == true){

	
		if(op == 0){

			// Cargando();
			// alert($("#nombre").val());
			
			// var formData = new FormData();
			// formData.append('funcion', 'AgregaCliente');
			// formData.append('nombre', $("#nombre").val());
			// formData.append('rut',$("#run").val());
			
			// AGREGAR AL AJAX PARA USAR FORMDATA
				// data: formData,
				// processData: false,
				// contentType: false,
				// $('input').each(function() {
					// if(!$(this).val()){
					// 	alert('Some fields are empty');
					//    return false;


						$.ajax({

							url: "vistas/Clientes.php",
							type: "POST",
							async: false,
							data: {
								funcion	 	: "AgregaCliente",
								nombre		: $("#nombre").val(),
								appat		: $("#appat").val(),
								rut			: $("#rut").val(),
								direccion	: $("#dir").val(),
								telefono	: $("#tel").val(),
								NEmpresa	: $("#NEmpresa").val(),
								REmpresa	: $("#REmpresa").val(),
								plazo 		: $("#plazo").val(),
								vendedor	: $("#vendedor").val(),
							
							},
							
							//  PARA CUANDO  SE QUIERA HACER ALGUNA ACCIÓN MIENTRAS SE SE ENVIA LA FUNCIÓN
							beforeSend: function () {
								//mostramos gif "cargando"
								$('#MoAgCliente').modal('hide');
								$('#tituloCliente').html('Nuevo Cliente');
								Cargando(0);
								//antes de enviar la petición al fichero PHP, mostramos mensaje
								
							},
							success: function(data){
								
								ListarClientes();
									
							}
						});


		}
		if(op == 1){


			$.ajax({

				url: "vistas/Clientes.php",
				type: "POST",
				async: false,
				data: {
					funcion		: "ModificaCliente",
					idcliente	: idc, //global
					nombre		: $("#nombre").val(),
					appat		: $("#appat").val(),
					rut			: $("#rut").val() + $("#cv").val(),
					direccion	: $("#dir").val(),
					telefono	: $("#tel").val(),
					NEmpresa	: $("#NEmpresa").val(),
					REmpresa	: $("#REmpresa").val(),
					plazo 		: $("#plazo").val(),
					vendedor	: $("#vendedor").val(),
				
					
				},
				
				beforeSend: function () {
					$("#MoAgCliente").modal("hide");
					Cargando(0);

				},
		
		
				success: function(data){
					
					ListarClientes();
					
				}
			});


		}

		if(op == 2){


			// ValidaCampos("Cliente");

			if($('#selectCAT2 option:selected').val() == "0x0"){
				alert("debe elegir una categoría valida.");
			}else{
			

				$.ajax({

					url: "vistas/Clientes.php",
					type: "POST",
					async: false,
					data: {
						funcion		: "AgregaProducto",
						codigo		: $("#cod").val(),
						nombre		: $("#nombreP").val(),
						descripcion	: $("#desc").val(),
						precioU		: $("#precio").val(),
						categoria	: $('#selectCAT2 option:selected').text(),
						existencia  : $("#exi").val(),			
					},
					
					beforeSend: function () {
						$("#MoAgProducto").modal("hide");
						Cargando(0);

					},
			
			
					success: function(data){
						
						ListarProductos();
						
					}
				});
			}

		}
		if(op == 22){

			if($('#selectCAT2 option:selected').val() == "0x0"){
				alert("debe elegir una categoría valida.");
			}else{
				$.ajax({

					url: "vistas/Clientes.php",
					type: "POST",
					async: false,
					data: {
						funcion		: "ModificaProducto",
						idproducto	: idc,
						codigo		: $("#cod").val(),
						nombre		: $("#nombreP").val(),
						descripcion	: $("#desc").val(),
						categoria	: $('#selectCAT2 option:selected').text(),
						precioU		: $("#precio").val(),
						existencia  : $("#exi").val(),


					},
					
					beforeSend: function () {
						$("#MoAgProducto").modal("hide");
						Cargando(0);

					},
			
			
					success: function(data){
						
						ListarProductos();
						
					}
				});
			}

		}

		if(op == 4){


			// ValidaCampos("Cliente");

			$.ajax({

				url: "vistas/Clientes.php",
				type: "POST",
				async: false,
				data: {
					funcion		: "AgregaUsuario",
					nombre		: $("#nombreU").val(),
					username	: $("#nombreUsername").val(),
					password	: $("#passU").val(),
					tipo  		: $("#tipoU").val(),
					

					
				},
				
				beforeSend: function () {
					$("#MoAgUsuario").modal("hide");
					Cargando(0);

				},
				success: function(data){
					
					ListarUsuarios();
				}
			});


		}
		if(op == 44){


			$.ajax({

				url: "vistas/Clientes.php",
				type: "POST",
				async: false,
				data: {
					funcion		: "ModificaUsuario",
					idUsuario	: idc,
					nombre		: $("#nombreU").val(),
					username	: $("#nombreUsername").val(),
					password	: $("#passU").val(),
					tipo  		: $("#tipoU").val(),
					


				},
				
				beforeSend: function () {
					$("#MoAgUsuario").modal("hide");
					Cargando(0);

				},
		
		
				success: function(data){
					
					ListarUsuarios();
					
				}
			});


		}
 	}

}

// Reseteo Existencias

function ResetearExistencia(tipo,id){
		$.ajax({

			url: "vistas/Clientes.php",
			type: "POST",
			async: false,
			data: {
				funcion		: "ResetearExistenciasNegativas",
				tipo		: tipo,
				idproducto	: id,
				
			},
	
			beforeSend: function () {

				Cargando(0);
			},
	
			success: function(data){
				ListarExistenciasNegativas();
				ListarProductos();
			}
		});

}	


//MODIFICAR

function ModificarCliente(idcliente){

	let currentRow=$("#"+idcliente).closest("tr"); 
         
	let id=currentRow.find("td:eq(0)").html(); 
	let nombre=currentRow.find("td:eq(1)").html(); 
	let appat=currentRow.find("td:eq(2)").html(); 
	let rut=currentRow.find("td:eq(3)").html(); 
	let direccion=currentRow.find("td:eq(4)").html(); 
	let telefono=currentRow.find("td:eq(5)").html(); 
	let NEmpresa=currentRow.find("td:eq(6)").html(); 
	let REmpesa=currentRow.find("td:eq(7)").html(); 
	let Plazo=currentRow.find("td:eq(8)").html(); 
	let Vendedor=currentRow.find("td:eq(9)").html(); 

	let cv = rut.charAt(rut.length - 1);

	idc = id;
	$("#nombre").val(nombre);
	$("#appat").val(appat);
	$("#rut").val(rut);
	$("#cv").val(cv);
	$("#dir").val(direccion);
	$("#tel").val(telefono);
	$("#NEmpresa").val(NEmpresa);
	$("#REmpresa").val(REmpesa);
	$("#plazo").val(Plazo);
	$("#vendedor").val(Vendedor);


	$("#MoAgCliente").modal("show");
	$('#tituloCliente').html('Actualizar Datos');
	Limpia('div','btns');


	$("#btns").html("<button type='button' class='btn btn-primary' onclick='Agregar(1)'>Guardar</button><button type='button' class='btn btn-secondary' data-dismiss='modal' '>Cancelar</button>");
	// $("#btns").append("");

    

}

function ModificarProducto(idproducto){

	let currentRow=$("#"+idproducto).closest("tr");

        

	let id=$("#"+idproducto).closest("tr");

	
	let codigo=currentRow.find("td:eq(0)").html(); 
	let nombre=currentRow.find("td:eq(1)").html(); 
	let descripcion=currentRow.find("td:eq(2)").html(); 
	let categoria=currentRow.find("td:eq(3)").html();
	let precio=currentRow.find("td:eq(4)").html();  
	let existencia=currentRow.find("td:eq(5)").html(); 

	
	 idc = idproducto;
	 $("#cod").val(codigo),
	 $("#nombreP").val(nombre),
	 $("#desc").val(descripcion),
	 $("#cat").val(categoria),
	 $("#precio").val(precio),
	 $("#exi").val(existencia),




	 $("#MoAgProducto").modal("show");
	 
	 Limpia('div','btns');
	 $("#btnP").html("<button type='button' class='btn btn-primary'  name='MODIFICAR' onclick='Agregar(22);'>Guardar</button><button type='button' class='btn btn-secondary' data-dismiss='modal' '>Cancelar</button>");
	// $("#btns").append("");
}
function ModificarUsuario(idUsuario){

	let currentRow=$("#"+idUsuario).closest("tr");

	// let id=$("#"+idUsuario).closest("tr");

	
	let nombre=currentRow.find("td:eq(0)").html(); 
	let username=currentRow.find("td:eq(1)").html(); 
	let password=currentRow.find("td:eq(2)").html(); 
	let tipo=currentRow.find("td:eq(3)").html(); 

	
	if(tipo == "Administrador"){
		tipoU= 1;
	} 
	if(tipo == "Colaborador"){
		tipoU= 2;
	}

	idc = idUsuario;
	 $("#nombreU").val(nombre);
	 $("#nombreUsername").val(username);
	 $("#passU").val(password);
	 $("#tipoU option[value="+tipoU+"]").attr('selected','selected');
	 $("#ModUser").html("Modificar Usuario");


	 $("#MoAgUsuario").modal("show");
	 Limpia('div','btns');
	 $("#btnU").html("<button type='button' class='btn btn-primary'  name='MODIFICAR' onclick='Agregar(44);'>Guardar</button><button type='button' class='btn btn-secondary' data-dismiss='modal' '>Cancelar</button>");

	// $("#btns").append("");
}


//ELIMIANR
function EliminaClienteUsuario(tipo,idcliente){

	if(tipo == 3){ // tipo 3 clientes

		let currentRow=$("#"+idcliente).closest("tr");        
		let id=currentRow.find("td:eq(0)").html();

		$.ajax({

			url: "vistas/Clientes.php",
			type: "POST",
			async: false,
			data: {
				funcion		: "EliminaCliente",
				idcliente	: id
				
			},
	
			beforeSend: function () {

				Cargando(0);
			},
	
			success: function(data){
				
				ListarClientes();
				
			}
		});

	}

	idUsuario = idcliente;
	if(tipo == 4){ // tipo 4 usuarios

		let currentRow=$("#"+idUsuario).closest("tr");        
		let id=currentRow.find("td:eq(0)").html();

		$.ajax({

			url: "vistas/Clientes.php",
			type: "POST",
			async: false,
			data: {
				funcion		: "EliminarUsuario",
				idUsuario	: idUsuario
				
			},
	
			beforeSend: function () {

				Cargando(0);
			},
	
			success: function(data){
				
				ListarUsuarios();
				
			}
		});

	}

}
function EliminaProducto(idproducto){
		$.ajax({

			url: "vistas/Clientes.php",
			type: "POST",
			async: false,
			data: {
				funcion		: "EliminarProducto",
				idproducto: idproducto
				
			},
	
			beforeSend: function () {

				Cargando(0);
			},
	
			success: function(data){
				
				ListarExistenciasNegativas();
				
			}
		});

	

}



//LISTAR
function ListarClientes(){
	Limpia('div','btns');
	$("#btns").html("<button type='button' class='btn btn-primary' onclick='Agregar(0)'>Guardar</button><button type='button' class='btn btn-secondary' data-dismiss='modal' '>Cancelar</button>");
	// $("#btns").append("");
	
	
    $.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion : "ListarClientes",
			
		},      
        beforeSend: function () {
            
				Cargando(0);
           
        },


		success: function(data){
		
		setTimeout(function () {
			
			
			
			$("#cont11").html("<br><br><br><br><h2>Acciones</h2><br><br><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#MoAgCliente'>Ingresar Cliente</button>");
			$("#cont2").html("<h1>Listado, Gestión de Usuarios</h1>");
			$("#cont22").html(data);

			$("#tablaClientes").DataTable({


				paging: true,
				searching: true,
				info: true,
				bSort: true,
				pagingType: "simple_numbers",
				order: [[ 0, "desc" ]],
				dom: "<'row'<'col-sm-12'><'col-sm-offset-3 col-sm-2 text-center'B>>" +
					"<'row'<'col-sm-6  ml-auto'l> <'col-sm-offset-6 col-sm-6 text-center'f>>" +
					// "<'row'<'col-sm-offset-6 col-sm-6 text-center'f>>" +
					"<'row'<'col-sm-12'><'tbbr'>>" +
					"<'row'<'col-sm-12 col-md-12 col-lg-12'tr>>" +
					"<'row'<'col-sm-6 text-center'i ><'col-sm-offset-5 col-sm-6 text-center'p>>",
				language: {
					"lengthMenu": "Mostrar _MENU_ registros por pag.",
					"zeroRecords": "<center>No se encontraron registros.</center>",
					"infoEmpty": "Sin resultados",
					"infoFiltered": "(filtrado de _MAX_ registros)",
					"search": "Buscar: ",
					"searchPlaceholder"	: "ID, Nombre, RUT, Otro. ",
					"sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
					"paginate": {
						"first":      "Primera",
						"last":       "Ultima",
						"next":       "Siguiente",
						"previous":   "Anterior"
								}
						},
				
				buttons: 

				[{
					extend		: 'pdf',
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar PDF"><span class="bi bi-file-earmark-pdf">PDF</span></div>',
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
					orientation	: 'landscape',
					className	: 'btn btn-outline-danger btn-sm',
					messageTop 	: 'Lista de Clientes registrados',
					messageTop 	: '<br> Nota: Lista todos los clientes registrados en el sistema. <br>'
				},
				{	
					extend		: 'excel',
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar EXCEL"><span class="bi bi-file-earmark-excel">Excel</span></div>',
					className	: 'btn btn-outline-success btn-sm',
					messageTop 	: 'Lista de Clientes registrados',
					messageTop 	: '<br> Nota: Lista todos los clientes registrados en el sistema. <br>'
				},
	
				{
					extend		: "print",
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9] },
					text		: '<div><span class="bi bi-printer-fill">Imprimir</span></div>',
					className	: 'btn btn-outline-info',
					messageTop 	: 'Lista de Clientes registrados',
					messageTop 	: '<br> Nota: Lista todos los clientes registrados en el sistema. <br>'
				}],

				"columnDefs": [
				 { targets: [0,2,3], searchable: true },
				 { targets: [5] , orderable: false}
				]
			});
		//
		}, 1000);
		}
		
	});
}

function ListarProductos(){

	Limpia('div','btns');

	$("#btnP").html("<button type='button' class='btn btn-primary' onclick='Agregar(2)'>Guardar</button><button type='button' class='btn btn-secondary' data-dismiss='modal' >Cancelar</button>");

	
	// $("#btnP").append("");
	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion : "ListarProductos",
			
		},      
        beforeSend: function () {
            
				Cargando(0);
           
        },


		success: function(data){
		
		setTimeout(function () {
			//dos
			
			$.ajax({

				url: "vistas/Clientes.php",
				type: "POST",
				async: false,
				data: {
					funcion			: "datosCategoria",
					
				},      
				beforeSend: function () {
					
						Cargando(0);
				   
				},
		
				success: function(data){
					
					$("#selectCAT2").html(data);
		
					
		
				}
			
			});
			
			$("#cont11").html("<br><br><br><br><h2>Acciones</h2><br><br><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#MoAgProducto'>Ingresar Producto</button>" +
			"<br><br><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#MoLEN' onclick='ListarExistenciasNegativas()';>Listar Existencia Negativas</button>" +
			"<br><br><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#MoCAT' onclick='ListarCategorias()';>Categorías</button>");

			$("#cont2").html("<h1>Listado y Gestión de Productos</h1>");
			$("#cont22").html(data);

			$("#tablaProductos").DataTable({


				paging: true,
				searching: true,
				info: true,
				bSort: true,
				pagingType: "simple_numbers",
				order: [[ 0, "desc" ]],
				dom: "<'row'<'col-sm-12'><'col-sm-offset-3 col-sm-2 text-center'B>>" +
					"<'row'<'col-sm-6 'l> <'col-sm-offset-6 col-sm-6 text-center'f>>" +
					// "<'row'<'col-sm-offset-6 col-sm-6 text-center'f>>" +
					"<'row'<'col-sm-12'><'tbbr'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-6 text-center'i ><'col-sm-offset-5 col-sm-6 text-center'p>>",
				language: {
					"lengthMenu": "Mostrar _MENU_ registros por pag.",
					"zeroRecords": "<center>No se encontraron registros.</center>",
					"infoEmpty": "Sin resultados",
					"infoFiltered": "(filtrado de _MAX_ registros)",
					"search": "Buscar: ",
					"searchPlaceholder"	: "Código, Nombre, Categoría. ",
					"sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
					"paginate": {
						"first":      "Primera",
						"last":       "Ultima",
						"next":       "Siguiente",
						"previous":   "Anterior"
								}
						},
				
				buttons: 

				[{
					extend		: 'pdf',
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar PDF"><span class="bi bi-file-earmark-pdf">PDF</span></div>',
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5] },
					orientation	: 'landscape',
					className	: 'btn btn-outline-danger btn-sm',
					messageTop 	: 'Lista de Productos ',
					messageTop 	: '<br> Nota: Lista todos los productos registrados en el sistema. <br>'
				},
				{	
					extend		: 'excel',
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5] },
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar EXCEL"><span class="bi bi-file-earmark-excel">Excel</span></div>',
					className	: 'btn btn-outline-success btn-sm',
					messageTop 	: 'Lista de Productos ',
					messageTop 	: '<br> Nota: Lista todos los productos registrados en el sistema. <br>'
				},
	
				{
					extend		: "print",
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5] },
					text		: '<div><span class="bi bi-printer-fill">Imprimir</span></div>',
					className	: 'btn btn-outline-info',
					messageTop 	: 'Lista de Productos ',
					messageTop 	: '<br> Nota: Lista todos los productos registrados en el sistema. <br>'
				}],

				"columnDefs": [
				 { targets: [0,2,3], searchable: true },
				 { targets: [6] , orderable: false}
				]
			});
		//
		}, 1000);
		}
		
	});

}

function ListarExistenciasNegativas(){
	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion : "ListarExistenciasNegativas",
			
		},      
        beforeSend: function () {
            
				Cargando(0);
           
        },


		success: function(data){
		
		setTimeout(function () {
		
			$("#cuerpoLEN").html(data);
			$("#tablaLEN").DataTable({


				paging: true,
				searching: true,
				info: true,
				bSort: true,
				pagingType: "simple_numbers",
				order: [[ 0, "desc" ]],
				dom: "<'row'<'col-sm-12'><'col-sm-offset-3 col-sm-2 text-center'B>>" +
					"<'row'<'col-sm-6  ml-auto'l><'col-sm-offset-6 col-sm-6 text-center'f>>" +
					"<'row'<'col-sm-12'><'tbbr'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-6 text-center'i ><'col-sm-offset-5 col-sm-6 text-center'p>>",
				language: {
					"lengthMenu": "Mostrar _MENU_ registros por pag.",
					"zeroRecords": "<center>No se encontraron registros.</center>",
					"infoEmpty": "Sin resultados",
					"infoFiltered": "(filtrado de _MAX_ registros)",
					"search": "Buscar: ",
					"searchPlaceholder"	: "Código, Nombre, Categoría. ",
					"sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
					"paginate": {
						"first":      "Primera",
						"last":       "Ultima",
						"next":       "Siguiente",
						"previous":   "Anterior"
								}
						},
				
				buttons: 

				[{
					extend		: 'pdf',
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar PDF"><span class="bi bi-file-earmark-pdf">PDF</span></div>',
					exportOptions: { columns: [ 0, 1, 2, 3, 4] },
					orientation	: 'landscape',
					className	: 'btn btn-outline-danger btn-sm',
					title		: 'Lista de Productos Existenciaas Negativas (LEN)',
					messageTop 	: '<br> Nota: solo contempla los productos con existencia negativ. <br>'
				},
				{	
					extend		: 'excel',
					exportOptions: { columns: [ 0, 1, 2, 3, 4] },
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar EXCEL"><span class="bi bi-file-earmark-excel">Excel</span></div>',
					className	: 'btn btn-outline-success btn-sm',
					messageTop 	: 'Lista de Productos Existenciaas Negativas (LEN)',
					messageTop 	: '<br> Nota: solo contempla los productos con existencia negativ. <br>'

				},
	
				{
					extend		: "print",
					exportOptions: { columns: [ 0, 1, 2, 3, 4] },
					text		: '<div><span class="bi bi-printer-fill">Imprimir</span></div>',
					className	: 'btn btn-outline-info',
					title		: 'Lista de Productos Existenciaas Negativas (LEN)',
					messageTop 	: '<br> Nota: solo contempla los productos con existencia negativo. <br><br>'

				}],

				"columnDefs": [
				 { targets: [0,2,3], searchable: true },
				 { targets: [5] , orderable: false}
				]
			});
		//
		}, 1000);
		}
		
	});

}

function ListarUsuarios(){

	Limpia('div','btns');

	$("#btnU").html("<button type='button' class='btn btn-primary' onclick='Agregar(4)'>Registrar </button><button type='button' class='btn btn-secondary' data-dismiss='modal' >Cancelar</button>");

	// $("#btnP").append("");
	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion : "ListarUsuarios",
			
		},      
        beforeSend: function () {
            
				Cargando(0);
           
        },


		success: function(data){
		
		setTimeout(function () {
			
			
			
			$("#cont11").html("<br><br><br><br><h2>Acciones</h2><br><br><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#MoAgUsuario'>Ingresar Nuevo Usuario</button>");
			$("#cont2").html("<h1>Listado y Gestión de Usuarios</h1>");
			$("#cont22").html(data);

			$("#tablaUsuarios").DataTable({

				paging: true,
				searching: true,
				info: true,
				bSort: true,
				pagingType: "simple_numbers",
				order: [[ 0, "desc" ]],
				dom: "<'row'<'col-sm-12'><'col-sm-offset-3 col-sm-2 text-center'B>>" +
					"<'row'<'col-sm-6  ml-auto'l><'col-sm-offset-6 col-sm-6 text-center'f>>" +
					"<'row'<'col-sm-12'><'tbbr'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-6 text-center'i ><'col-sm-offset-5 col-sm-6 text-center'p>>",
				language: {
					"lengthMenu": "Mostrar _MENU_ registros por pag.",
					"zeroRecords": "<center>No se encontraron registros.</center>",
					"infoEmpty": "Sin resultados",
					"infoFiltered": "(filtrado de _MAX_ registros)",
					"search": "Buscar: ",
					"searchPlaceholder"	: "Código, Nombre, Categoría. ",
					"sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
					"paginate": {
						"first":      "Primera",
						"last":       "Ultima",
						"next":       "Siguiente",
						"previous":   "Anterior"
								}
						},
				
				buttons: 

				[{
					extend		: 'pdf',
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar PDF"><span class="bi bi-file-earmark-pdf">PDF</span></div>',
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5] },
					orientation	: 'landscape',
					className	: 'btn btn-outline-danger btn-sm',
					messageTop 	: 'Lista de Usuarios ',
					messageTop 	: '<br> Nota: Lista todos los usuarios colaboradores y administradores registrados en el sistema. <br>'
				},
				{	
					extend		: 'excel',
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5] },
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar EXCEL"><span class="bi bi-file-earmark-excel">Excel</span></div>',
					className	: 'btn btn-outline-success btn-sm',
					messageTop 	: 'Lista de Usuarios ',
					messageTop 	: '<br> Nota: Lista todos los usuarios colaboradores y administradores registrados en el sistema. <br>'
				},
	
				{
					extend		: "print",
					exportOptions: { columns: [ 0, 1, 2, 3, 4, 5] },
					text		: '<div><span class="bi bi-printer-fill">Imprimir</span></div>',
					className	: 'btn btn-outline-info',
					messageTop 	: 'Lista de Usuarios ',
					messageTop 	: '<br> Nota: Lista todos los usuarios colaboradores y administradores registrados en el sistema. <br>'
				}],

				"columnDefs": [
				 { targets: [0,2,3], searchable: true },
				 { targets: [5] , orderable: false}
				]
			});
		//
		}, 1000);
		}
		
	});

}

function ListarPedidos(){
	$("#cont11").html("");
	$("#cont2").html("");


	
	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion : "ListarPedidos",
			
		},      
        beforeSend: function () {
            
				Cargando(0);
           
        },


		success: function(data){
		
		setTimeout(function () {
			Limpia('div','btns');
			$("#cont2").html("<h1>Listado y Gestión de Pedidos</h1>");
			$("#cont22").html(data);
			$("#tablaPedidos").DataTable({
				

				paging: true,
				searching: true,
				info: true,
				bSort: true,
				pagingType: "simple_numbers",
				order: [[ 0, "desc" ]],
				dom: "<'row'<'col-sm-12'><'col-sm-offset-3 col-sm-2 text-center'B>>" +
				"<'row'<'col-sm-6  ml-auto'l> <'col-sm-offset-6 col-sm-6 text-center'f>>" +
				// "<'row'<'col-sm-offset-6 col-sm-6 text-center'f>>" +
				"<'row'<'col-sm-12'><'tbbr'>>" +
				"<'row'<'col-sm-12 col-md-12 col-lg-12'tr>>" +
				"<'row'<'col-sm-6 text-center'i ><'col-sm-offset-5 col-sm-6 text-center'p>>",
				language: {
					"lengthMenu": "Mostrar _MENU_ registros por pag.",
					"zeroRecords": "<center>No se encontraron registros.</center>",
					"infoEmpty": "Sin resultados",
					"infoFiltered": "(filtrado de _MAX_ registros)",
					"search": "Buscar: ",
					"searchPlaceholder"	: "Código, Nombre, Categoría. ",
					"sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registros",
					"paginate": {
						"first":      "Primera",
						"last":       "Ultima",
						"next":       "Siguiente",
						"previous":   "Anterior"
								}
						},
				
				buttons: 

				[{
					extend		: 'pdf',
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar PDF"><span class="bi bi-file-earmark-pdf">PDF</span></div>',
					exportOptions: { columns: [ 0, 1, 2, 3, 4] },
					orientation	: 'landscape',
					className	: 'btn btn-outline-danger btn-sm',
					title		: 'Lista de Pedidos',
					messageTop 	: '<br> Nota: Listado de pedidos agendados en el sistema <br>'
				},
				{	
					extend		: 'excel',
					exportOptions: { columns: [ 0, 1, 2, 3, 4] },
					text		: '<div data-toggle="tooltip" data-placement="top" title="Presionar para descargar EXCEL"><span class="bi bi-file-earmark-excel">Excel</span></div>',
					className	: 'btn btn-outline-success btn-sm',
					messageTop 	: 'Lista de Productos Existenciaas Negativas (LEN)',
					messageTop 	: '<br> Nota: solo contempla los productos con existencia negativ. <br>'

				},
	
				{
					extend		: "print",
					exportOptions: { columns: [ 0, 1, 2, 3, 4] },
					text		: '<div><span class="bi bi-printer-fill">Imprimir</span></div>',
					className	: 'btn btn-outline-info',
					title		: 'Lista de Productos Existenciaas Negativas (LEN)',
					messageTop 	: '<br> Nota: solo contempla los productos con existencia negativo. <br><br>'

				}],

				"columnDefs": [
				 { targets: [0,2,3], searchable: true },
				 { targets: [5] , orderable: false}
				]
			});
		//
		}, 1000);
		}
		
	});

}

function ListarCategorias(){

	$("#btnCAT").html("<button  type='button' class='btn btn-primary' onclick='GuardarCategoria();'>Guardar</button>"+
	"<br><br><button type='button' class='btn btn-secondary' data-dismiss='modal' >Cancelar</button> ")

	$("#selectCAT").select2();
	$("#selectCAT").select2({ dropdownCssClass: "myFont" });

	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion			: "datosCategoria",
			
		},      
		beforeSend: function () {
			
				Cargando(0);
		   
		},

		success: function(data){
			
			$("#selectCAT").html(data);

			

		}
	
	});

}

function GuardarCategoria(){
	if($("#nombreCAT").val() == ""){
		alert("El campo está vacío, favor de ingresar un Nombre.");
	}else{
		$.ajax({

			url: "vistas/Clientes.php",
			type: "POST",
			async: false,
			data: {
				funcion		: "guardarCategoria",
				nombreCAT	: $('#nombreCAT').val(),

				
			},      
			beforeSend: function () {
				
					// Cargando(0);
			   
			},
	
			success: function(data){
				
				$.ajax({

					url: "vistas/Clientes.php",
					type: "POST",
					async: false,
					data: {
						funcion			: "datosCategoria",
						
					},      
					beforeSend: function () {
						
							Cargando(0);
					   
					},
			
					success: function(data){
						
						alert("categoria registrada correctamente");
						$("#selectCAT").html(data);	
			
						$('#nombreCAT').val("");
			
					}
				
				});
				

				
	
			}
		
		});

	}
}

function EliminarCAT(){

	if($('#selectCAT option:selected').val() == "0x0"){
		alert("Debe escoger una categoria valida registrada.");
	}else{


		$.ajax({
	
			url: "vistas/Clientes.php",
			type: "POST",
			async: false,
			data: {
				function	: "EliminarCategoria",
				idCategoria	: $('#selectCAT option:selected').val(),
				
			},      
			beforeSend: function () {
				
					Cargando(0);
			   
			},
	
			success: function(data){
				alert("Categoria Eliminada");
				
				$.ajax({

					url: "vistas/Clientes.php",
					type: "POST",
					async: false,
					data: {
						funcion			: "datosCategoria",
						
					},      
					beforeSend: function () {
						
							// Cargando(0);
					   
					},
			
					success: function(data){
						
						$("#selectCAT").html(data);
			
						
			
					}
				
				});
				
	
			}
		
		});

	}

}

function LlenarPedido(id){

	$("#btnPedido").html("<button type='button' class='btn btn-success' onclick='GenerarPedido(1);' >Generar Pedido</button>" +
	"<button type='button' class='btn btn-warning  'onclick='LimpiarAllDetalles();' >Limpiar Detalles</button> "+
	"<button type='button' class='btn btn-secondary ' onclick='CerrarModal();' >Cerrar</button> ");
	$("#tituloPEDIDO").html("<h3 class='modal-title'>Crear Nuevo Pedido</h3>");	


	$("#FECHAENTREGAClientePedido").val("");



	$("#IDPedido").val("");

	let today = new Date();
	let dd = String(today.getDate()).padStart(2, '0');
	let mm = String(today.getMonth() + 1).padStart(2, '0'); 
	let yyyy = today.getFullYear();

	fechaActual = dd+ '/' + mm + '/' + yyyy;

	
	$("#FECHAClientePedido").val(fechaActual);


	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion			: "datosClientes",
			idCliente 		: id,
			
		},      
        beforeSend: function () {
            
				Cargando(0);
           
        },

		success: function(data){
			
			setTimeout(function () {
			
				let datos = data.split(",");

				$("#IDClientePedido").val(datos[0]);
				$("#RUNClientePedido").val(datos[1]);
				$("#NOMBREClientePedido").val(datos[2]);
				$("#DIRClientePedido").val(datos[3]);
				$("#TELClientePedido").val(datos[4]);

				$.ajax({

					url: "vistas/Clientes.php",
					type: "POST",
					async: false,
					data: {
						funcion			: "datosProductos",
						
					},      
					beforeSend: function () {
						
							Cargando(0);
					   
					},
			
					success: function(data){
						
						$("#Productos").html(data);

						
			
					}
				
				});

				
				// $('#Productos').append($('<option>', {
				// 	value: ,
				// 	text: 'Option Text'
				// }));

			

			}, 1500);

		}
	
	});



}


function traerDatosProductos(codigo){



	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion			: "datosProductos",
			tipo			: 1,
			codigo			: codigo,
			
		},      
		beforeSend: function () {
			
				// Cargando(0);
		   
		},

		success: function(data){
			// $("#Productos").html(data);
			Prod = data.split(",");
			
			console.log(data);

			$("#STOCK").val(Prod[4]);



		}
	
	});



	if ( $("#STOCK").val() == ""){

		$("#ProductoCantidad").prop('disabled', true);
		
	}else{
		$("#ProductoCantidad").prop('disabled', false);
	}


}


function AgregarDetalle(){

	contadorFilas = $("#TBPedido tr").length;
	
	// FilasIniciales =contadorFilas;

	contadorFilas = contadorFilas;
	Cantidad = $("#ProductoCantidad").val();
	Stock	= $("#STOCK").val();
	
	if(Cantidad != 0 ||  $('#Productos option:selected').val() != 0){

	

		// if(Cantidad > Stock){

		// 	alert("Está agregando al pedido una cantidad mayor al stock disponible registrado, Si lo agrega las cantidades que excedan serán guardadas como negativas");

		// }


			td =  "<tr id='detalle_"+contadorFilas+"'>"+
				// " <td class='Tdato'> "+ contadorFilas + " </td> "+
				" <td class='Tdato'> "+ Prod[0]+ " </td> "+
				" <td class='Tdato'> "+ Prod[1]+ " </td> "+
				" <td class='Tdato'> "+ Prod[2]+ " </td> "+
				" <td class='Tdato'> "+ Prod[3]+ " </td> "+
				" <td class='Tdato'> "+ Cantidad +" </td>";
			
			valor = Prod[3];
			total = valor * Cantidad;

			// console.log("inicial " + totalInicial);
			// // console.log("agregado " + totalAgregado);
			// console.log("totalAgregado 1 " + totalAgregado);
			// console.log("total? " + total);

			// totalAgregado =  totalAgregado + total;

			// console.log("totalAgregado 2 " + totalAgregado);

			td = td +  " <td class='Tdato' id='TOT_"+contadorFilas+"'> "+ total + " </td>";
			td = td +" <td class='Tdato'  style='font-size:9px;' id='borrar_"+contadorFilas+"'> <button data-toggle='tooltip' title='Elimina el detalle actual'  type='button' class='btn btn-success btn-sm btn-more-less' onclick='EliminaDetalle(0,0,"+contadorFilas+")'><i class='bi bi-x-square'></i></button></td> </tr>";

			console.log("FI"+FilasIniciales);
			console.log("CF"+contadorFilas);
			
			

			let anterior = contadorFilas - 1;


			
			console.log("anterior"+anterior);



			if (anterior > 0){
				$("#borrar_"+anterior+"").html("No Modificable");
			}
			
	
			$("#TBPedido").append(td);
			// totalpedido = totalpedido + total;

			// $("#TOTALP").html("<p style='font-size: 20px; color: black; ' > $."+totalpedido+"</p>" );
			

			$("#ProductoCantidad").val(0);
	
	}else{
		alert("Está ingresando una cantidad con valor 0, O no ha elegido un producto de la lista. Favor verifique");
		$("#ProductoCantidad").val(0);
	}



	// $.ajax({

	// 	url: "vistas/Clientes.php",
	// 	type: "POST",
	// 	async: false,
	// 	data: {
	// 		funcion			: "datosProductos",
			
	// 	},      
	// 	beforeSend: function () {
			
	// 			// Cargando(0);
		   
	// 	},

	// 	success: function(data){
			
	// 		$("#Productos").html(data);

			

	// 	}
	
	// });
	ObtenerTotal();

}


function EliminaDetalle(idDEtalle,tipo,fila){
	
	
	// totalpedido =  totalpedido - $("#id_detalle_"+idDEtalle+"").text();

	let currentRow=$("#detalle_"+fila+"").closest("tr");

	// let id=$("#"+idUsuario).closest("tr");

	
	// let totalFila =currentRow.find("td:eq(5)").text(); 


	// totalAgregado = totalAgregado - totalFila;
	


	$("#TOTALP").html("<p style='font-size: 20px; color: black; ' > $. "+ totalAgregado +" </p>" );

	$("#detalle_"+fila+"").remove();

	ObtenerTotal();


	// $.ajax({

	// 	url: "vistas/Clientes.php",
	// 	type: "POST",
	// 	async: false,
	// 	data: {
	// 		funcion			: "EliminarDetallePedido",
	// 		idPedido		: $("#IDPedido").val(),
	// 		idDetPedido		: idDEtalle,
	// 		tipo			: tipo,
			
	// 	},      
	// 	beforeSend: function () {
			
	// 			Cargando(0);
		   
	// 	},

	// 	success: function(data){
			
	// 		// ListarPedidos();

	// 		let cod = $('#Productos option:selected').val();
				let anterior =  fila - 1
				$("#borrar_"+anterior+"").html(" <button data-toggle='tooltip' title='Elimina el detalle actual'  type='button' class='btn btn-success btn-sm btn-more-less' onclick='EliminaDetalle(0,0,"+anterior+")'><i class='bi bi-x-square'></i></button> ");
	
			$.ajax({

				url: "vistas/Clientes.php",
				type: "POST",
				async: false,
				data: {
					funcion			: "datosProductos",
					
				},      
				beforeSend: function () {
					
						// Cargando(0);
				   
				},
		
				success: function(data){
					
					$("#Productos").html(data);

					$("#Productos select").val(cod).change();
					$("#STOCK").val(0);
		
				}
			
			});

	// 	}	
	
	// });

}



function LimpiarDetalle(filaAgregada){

	


	$("#detalle_"+filaAgregada+"").remove();

	ObtenerTotal();

}

function LimpiarAllDetalles(){
	filas = $("#TBPedido tr").length;

	for(i=0;i<filas;i++){
		$("#detalle_"+i+"").remove();
	}

	$("#STOCK").val("");
	$("#Productos").val("0x0");

	$("#TOTALP").html("<p style='font-size: 20px; color: black; ' > $--- </p>" );
	
	

}



function CerrarModal(){
	LimpiarAllDetalles();
	$("#MoPedido").modal('hide');


}

function GenerarPedido(tipo){




	filas = $("#TBPedido tr").length;
	fecha = $("#FECHAENTREGAClientePedido").val();
	
	idPedido_ = $("#IDPedido").val();

	if (idPedido_ == ""){
		idPedido_ = 0;
	}

	if( filas == 0 || fecha == ""){

		alert("No hay detalles Agregados o Fecha de entrega valida, favor verifique.");
	}else{

		if(tipo==1){


			console.log(fecha);
			var parte = fecha.split("-");

			// var dia	  = parseInt(parte[2]);
			// var mes = parseInt(parte[1]);
			// var anio  = parseInt(parte[0]);

			var dia	  = parte[2];
			var mes   = parte[1];
			var anio  = parte[0];

			fechaEntrega = anio+"-"+mes+"-"+dia;

			$.ajax({

				url: "vistas/Clientes.php",
				type: "POST",
				async: false,
				data: {
					funcion			: "AgregarPedido",
					// idPedido		: idPedido_ ,
					ID_Cliente		: $("#IDClientePedido").val(),
					comentario		: $("#comentarioPedido").val(),
					nombreVendedor  :$("#nam").text(),
					fEntrega 		: fechaEntrega,
					tPedido			: totalpedido

					
				},      
				beforeSend: function () {
					
						Cargando(0);
				
				},

				success: function(data){

					filas = $("#TBPedido tr").length;
					lastID = data;
				}
			
			});

		}
			if( lastID == 0){
				lastID = $("#IDPedido").val();
			}
			FilasIniciales = FilasIniciales + 1;
			for(i=FilasIniciales;i<filas;i++){

										
				let currentRow=$("#detalle_"+i+"").closest("tr");        
				let codigo =currentRow.find("td:eq(0)").text();
				// let nombre =currentRow.find("td:eq(1)").text();
				// let descripcion =currentRow.find("td:eq(2)").text();
				// let precioU =currentRow.find("td:eq(3)").text();
				let cantidad =currentRow.find("td:eq(4)").text();
				let Tlinea =currentRow.find("td:eq(5)").text();

				console.log("FI:"+FilasIniciales );
				console.log("Filas: "+filas);
				// console.log(descripcion);
				// console.log(precioU);
				// console.log(cantidad);


						$.ajax({

							url: "vistas/Clientes.php",
							type: "POST",
							async: false,
							data: {

								funcion			: "AgregarDetallePedido",
								idPedido		: lastID ,
								linea 			: i,
								codigo			: codigo.trim(),
								// nombre  		: nombre,
								// descripcion 	: descripcion,
								// precioU			: precioU,
								cantidad		: cantidad.trim(),
								Tlinea 			: Tlinea.trim(),

								
							},      
							beforeSend: function () {
								
									Cargando(0);
							
							},

							success: function(data){

							}
						
						});

			}

			alert("pedido generado correctamente");
			ListarPedidos();
			CerrarModal();
			sessionStorage.setItem("reloading", "true");
            document.location.reload();

	}	
}

function ModificarPedido(linea){

	totalInicial = 0;
	// alert("ATENCIÓN : Si elimina detalles estos serán sacados inmediatamente de los registros.")
	$("#btnPedido").html("<button type='button' class='btn btn-success' onclick='GenerarPedido(2);' >Guardar Cambios</button>" +
	// "<button type='button' class='btn btn-warning  'onclick='EliminaDetalle(00,2);' >Borrar todos los Detalles</button> "+
	"<button type='button' class='btn btn-secondary ' onclick='CerrarModal();' >Cerrar</button> ");
	$("#tituloPEDIDO").html("<h3 class='modal-title'>Modificar Pedido</h3>");	



	$("#MoPedido").modal("show");

	let currentRow=$("#"+linea+"").closest("tr");

	// let id=$("#"+idUsuario).closest("tr");

	
	let CODpedido		=currentRow.find("td:eq(0)").text(); 
	let CODcliente		=currentRow.find("td:eq(1)").text(); 
	let rut				=currentRow.find("td:eq(2)").text(); 
	let nombreCliente	=currentRow.find("td:eq(3)").text(); 
	let direccion		=currentRow.find("td:eq(4)").text(); 
	let telefono		=currentRow.find("td:eq(5)").text(); 
	let comentario		=currentRow.find("td:eq(6)").text(); 
	// let nombreVendedor 	=currentRow.find("td:eq(7)").text(); 
	let fechaEmision	=currentRow.find("td:eq(8)").text(); 
	let fechaEntrega	=currentRow.find("td:eq(9)").text(); 
	
	f= fechaEntrega.split("-");

	dia  = f[0];
	mes  = f[1];
	anio = f[2];
	fechaE = anio+"-"+mes+"-"+dia;

	

	 $("#IDPedido").val(CODpedido);
	 $("#IDClientePedido").val(CODcliente);
	 $("#RUNClientePedido").val(rut);
	 $("#NOMBREClientePedido").val(nombreCliente);
	 $("#DIRClientePedido").val(direccion);
	 $("#TELClientePedido").val(telefono);
	 $("#comentarioPedido").val(comentario);
	 $("#FECHAClientePedido").val(fechaEmision);
	 $("#FECHAENTREGAClientePedido").val(fechaE);

	 $.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion		: "traeComentario",
			idPedido	: CODpedido,
			
		},

		beforeSend: function () {

			Cargando(0);
		},

		success: function(data){
			
			// alert(data);
			$("#comentarioPedido").val(data);

		}
	});
	 


	 $.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion			: "datosProductos",
			
		},      
		beforeSend: function () {
			
				Cargando(0);
		   
		},

		success: function(data){
			
			$("#Productos").html(data);

			

		}
	
	});
		console.log(CODpedido);
	$.ajax({

		

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion			: "ListarDetallesPedidos",
			idPedido 		: CODpedido,
			
		},      
		beforeSend: function () {
			
				Cargando(0);
		   
		},

		success: function(data){

			$("#TBPedido").append(data);

			FilasIniciales =  $("#TBPedido tr").length;

			for(i=0;i<FilasIniciales;i++){
				let detAgregado= $("#detalle_"+i+"").closest("tr");
				let totalFila= detAgregado.find("td:eq(5)").text(); 

				if (totalFila == ""){
					totalFila = 0;
				}

				

				// let id=$("#"+idUsuario).closest("tr");
				
				

				totalInicial = totalInicial + parseInt(totalFila);

				totalAgregado = totalInicial;

				//verificar

			
			}

			$("#TOTALP").html("<p style='font-size: 20px; color: black; ' > $."+totalInicial+"</p>" );

		}
	
	});

	// FilasIniciales = 0;
	ObtenerTotal();
}


function ObtenerTotal(){
	$("#TOTALP").html("");
	let p =0;


	filas = $("#TBPedido tr").length;

	// console.log("filas :"+filas);
	for (i=1;i<filas;i++){


		// let filaDetalle = $("#detalle_"+i+"").closest("tr");
		// let totalFila 	= filaDetalle.find("td:eq(5)").text(); 


		let totalFila 	= $("#TOT_"+i+"").text(); 

		// console.log("fila: " + i);
		// console.log("totalFila:"+totalFila);
	
		if (totalFila == ""){
			totalFila = 0;
		}

		p 	=  p +  parseInt(totalFila);
		
		// console.log("tot agregado 2:"+p);


	}
	totalpedido = totalpedido + p;

	$("#TOTALP").html("<p style='font-size: 20px; color: black; ' > $."+p+"</p>" );

	// filas = 0;
	// let totalF=0;

	// contadorFilas = $("#TBPedido tr").length;

	// contadorFilas = contadorFilas - 1 ;
	// $("#TOTALP").html("");

	// if(contadorFilas == 0){
	// 	$("#TOTALP").html("<p style='font-size: 20px; color: black; ' > $.---</p>" );

	// }else{
	// 	for(i=0;i<contadorFilas;i++){


	// 		let currentRow=$("#detalle_"+i+"").closest("tr");        
	// 		let totalLinea =currentRow.find("td:eq(5)").text();
			

	// 		console.log(currentRow);
	// 		console.log(totalLinea);
	// 		if (totalLinea == ""){
	// 			totalLinea = 0;
	// 		}
			
	// 		totalF = ( parseInt(totalF) + parseInt(totalLinea) );

	// 	}

		

	// 	$("#TOTALP").html("<p style='font-size: 20px; color: black; ' > $."+totalF+"</p>" );
	// }	

}

function EliminarPedido(idPedido){

	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion			: "EliminarPedido",
			idPedido		: idPedido,
			
		},      
		beforeSend: function () {
			
				Cargando(0);
		   
		},

		success: function(data){
			
			ListarPedidos();

			

		}
	
	});

}


function EntregarProducto(id){

	$.ajax({

		url: "vistas/Clientes.php",
		type: "POST",
		async: false,
		data: {
			funcion			: "EntregarProducto",
			idPedido		: id,
			
		},      
		beforeSend: function () {
			
				Cargando(0);
		   
		},

		success: function(data){
			
			ListarPedidos();

			

		}
	
	});
}

// FUNCIONES VISUALES

function CargaInicio(){
	$("#cont1").empty();
	$("#cont2").empty();
	
}

function MuestraMenu(){
	$("#sidebar").toggleClass('active');
}

function MenuClientes(m){
	MuestraMenu();
	$("#cont1").html("");
	$("#cont22").html("");

	if(m == 1){
		ListarClientes();
	}
	if(m == 2){
		ListarProductos();
	}
	if(m == 3){
		ListarPedidos();
	}
	if(m == 4){
		ListarUsuarios();
	}

}

function Cargando(op){

	if( op == 0){
			
		$('#carga').modal('show');
		setTimeout(function () {
			
			$('#carga').modal('hide');
		}, 1000);

	}


}

function Limpia(tipo,nombre){


	if(tipo == "div"){
		$("#"+nombre).html("");
	}
	if(tipo == "val"){
		$("#"+nombre).val("");
	}
	

}

///
// OTRAS



function Prueba (){

        
    $.ajax({

		url: "controladores/Accion.php",
		type: "POST",
		async: false,
		data: {
			funcion		: "Prueba",
			nombre		: Nombre,
			
		},

        //  PARA CUANDO  SE QUIERA HACER ALGUNA ACCIÓN MIENTRAS SE SE ENVIA LA FUNCIÓN
        
        // beforeSend: function () {
        //     //mostramos gif "cargando"
        //     jQuery('#loading_spinner').show();
        //     //antes de enviar la petición al fichero PHP, mostramos mensaje
        //     jQuery("#resultado").html("Déjame pensar un poco...");
        // },


		success: function(data){
			
			
		}
	});

}


function Testeo(val){

	if(val == true ){
		alert("FUNCA!");
	}else{
		alert("NO FUNCA");
	}


}



function ValidaCampos(){

	 validado =  false; 

	if($("#MoAgCliente").is(':visible') == true){	


		$('#MoAgCliente input').each(function() {

			val =  0;
			if($(this).val() === ""){	
				val = val+1;
			}
		});
	}

	if($("#MoAgProducto").is(':visible') == true){	

		$('#MoAgProducto input').each(function() {

			val =  0;
			if($(this).val() === ""){	
				val = val+1;
			}
		});
	}
	
	if($("#MoAgUsuario").is(':visible') == true){	

		$('#MoAgUsuario input').each(function() {

			val =  0;
			if($(this).val() === ""){	
				val = val+1;
			}
		});
	}

	if (val == 0){
		validado = true;
	}else{
		alert("hay campos vacios,favor revisar");
	}
	return validado;

}


