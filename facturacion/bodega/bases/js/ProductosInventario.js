// JavaScript Document
function setDataFormWithResponse(){
    var producto_id = $('#producto_id').val();
    RequiredRemove();
	
	var f = new Date();
	var fecha_inicio= $('#fecha_inicio').val();
	var fecha_final = $('#fecha_final').val();
	
    var parametros  = new Array({campos:"producto_id",valores:$('#producto_id').val()});
	var forma       = document.forms[0];
	var controlador = 'ProductosInventarioClass.php';
	document.getElementById('detalleProducto').src = 'DetalleProductoClass.php?producto_id='+producto_id;
	document.getElementById('kardexrapido').src = '../../bases/clases/reporteKardexClass.php?ACTIONCONTROLER=generateReport&opciones_producto=U&fecha_inicio='+fecha_inicio+'&fecha_final='+fecha_final+'&producto_id='+producto_id;
	
	
	FindRow(parametros,forma,controlador,null,function(resp){
	  var datos = $.parseJSON(resp);
	  
	  document.getElementById('imagen_preview').src = datos[0]['imagen'];
	 
	  $('#cuadro_imagen_producto').show();
      if($('#guardar'))    $('#guardar').attr("disabled","true");
      if($('#actualizar')) $('#actualizar').attr("disabled","");
      if($('#borrar'))     $('#borrar').attr("disabled","");
      if($('#limpiar'))    $('#limpiar').attr("disabled","");	 


    });

}

function ProductosInventarioOnSave(formulario,resp){
  
   try{
	    var dataResp = $.parseJSON(resp);	 
	  
	   var producto_id = dataResp[0]['producto_id']
	   if(producto_id>0){
		   $('#producto_id').val(producto_id);
		   clearFind();
		   setFocusFirstFieldForm(formulario);      
		   $("#refresh_QUERYGRID_wms_productos_inv").click();
			document.getElementById('detalleProducto').src = 'DetalleProductoClass.php?producto_id='+producto_id;
		   //resetDetalle('detalleProducto');   
		   if($('#guardar'))    $('#guardar').attr("disabled","true");
		   if($('#actualizar')) $('#actualizar').attr("disabled","");
		   if($('#borrar'))     $('#borrar').attr("disabled","");
		   if($('#limpiar'))    $('#limpiar').attr("disabled","");
		   
		   alertJquery("Se ingreso correctamente un nuevo Producto.","Productos");
		   
	   }
	   else{
		   alertJquery(resp,"Productos");
	   }
   }catch(e){
	   console.log("Error : "+e);
   }
}
function ProductosInventarioOnUpdate(formulario,resp){
   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);      
   $("#refresh_QUERYGRID_wms_productos_inv").click();
   resetDetalle('detalleProducto');   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Productos");
}

function ProductosInventarioOnDelete(formulario,resp){
   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);      
   $("#refresh_QUERYGRID_wms_productos_inv").click();
   resetDetalle('detalleProducto');   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   alertJquery(resp,"Productos");
}

function ProductosInventarioOnReset(formulario){
	
    clearFind();	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
	
	var ff = new Date();
	var fecha_final = ff.getFullYear()+'-'+(ff.getMonth()+1)+'-'+ff.getDate();
	var fi = new Date(ff.setDate(ff.getDate() -10));
	var fecha_inicial = fi.getFullYear()+'-'+(fi.getMonth()+1)+'-'+fi.getDate();
	
	$('#fecha_inicio').val(fecha_inicial);	
	$('#fecha_final').val(fecha_final);	

	document.getElementById('imagen_preview').src = '';
	  $('#cuadro_imagen_producto').hide();

	  document.getElementById('detalleProducto').src = '';
	document.getElementById('kardexrapido').src = '';
	
	
	

	
}

function calcularCodigoInt(){

	var linea_producto_id = $("#linea_producto_id").val();

		var QueryString = "ACTIONCONTROLER=getCodigo&linea_producto_id="+linea_producto_id;
	 

		  $.ajax({
			url        : "ProductosInventarioClass.php",
			data       : QueryString,
			beforeSend : function(){

			},
				success : function(response){

					try{
						var codigo = $.parseJSON(response);

						$("#codigo_interno").val(codigo);
					}catch(e){
						console.log(e);

					}

				
			}	 
		 });
	  
}




$(document).ready(function(){
						   
  $("#guardar,#actualizar").click(function(){
	  
	  var formulario = document.getElementById('ProductosInventarioForm');
	  
	  if(ValidaRequeridos(formulario)){ 
	    if(this.id == 'guardar'){
         		Send(formulario,'onclickSave',null,ProductosInventarioOnSave)
		}else{
	            Send(formulario,'onclickUpdate',null,ProductosInventarioOnUpdate)
				
		  }
	  }
	  	  
  });
  
	$("#procesado").change(function(){
										
		var procesado = this.value;
	  
		if(procesado=='S'){
			$("#detalleProcesado").css("display","");
		}else{
			$("#detalleProcesado").css("display","none");
		}
	});
  
    $("#iva").change(function(){
	  var iva = this.value;
	  
	    if(iva == 'S'){
        	$("#impuesto").css("display","");
			//$("#placa_remolque_hidden").addClass("obligatorio");
		}else{
	       $("#impuesto").css("display","none");
				
		  }
  });

	$("#linea_producto_as").blur(function(){
										
		var linea_producto_id = $("#linea_producto_id").val();

		var QueryString = "ACTIONCONTROLER=getCodigo&linea_producto_id="+linea_producto_id;
	 

		  $.ajax({
			url        : "ProductosInventarioClass.php",
			data       : QueryString,
			beforeSend : function(){

			},
				success : function(response){

					try{
						var codigo = $.parseJSON(response);

						$("#codigo_interno").val(codigo);
					}catch(e){
						console.log(e);

					}

				
			}	 
		 });
	  
		
	});

	$("#detalleProcesado").css("display","none");

});
	
