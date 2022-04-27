// JavaScript Document
var map;
var points    = new Array();
var markRoute = new Array();


function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"ruta_id",valores:$('#ruta_id').val()});
	var forma       = document.forms[0];
	var controlador = 'RutasClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
		  
	 var rutaId = $('#ruta_id').val();	 
     var url    = "DetalleRutaClass.php?ruta_id="+rutaId+"&rand="+Math.random();
	 
	 $("#detalleRuta").attr("src",url);
	 
	 //setCoordinatesMapRoute(rutaId);		 
	 
	 if($('#guardar'))    $('#guardar').attr("disabled","true");
	 if($('#actualizar')) $('#actualizar').attr("disabled","");
	 if($('#borrar'))     $('#borrar').attr("disabled","");
	 if($('#limpiar'))    $('#limpiar').attr("disabled","");
													   
    });


		
}

function setCoordinatesMapRoute(ruta_id){
	
  points      = new Array();
  markRoute   = new Array();
  var ruta_id = parseInt(ruta_id);	
  
  if(isNumber(ruta_id)){
	  
	  var QueryString = "ACTIONCONTROLER=setDataMap&ruta_id="+ruta_id;
	  
	  $.ajax({
		url     : "RutasClass.php",
		data    : QueryString,
		success : function(response){
			
		//markRoute = eval("("+ response + ")");
		
		 markRoute = $.parseJSON(response);
		
		 if($.isArray(markRoute) && markRoute.length > 0 && $.trim(response) != 'null'){				
			 /*initialize();
			 $("#map_canvas").css("display","");*/
		 }else{
			   //alertJquery("No hay puntos para mostrar en el mapa","Puntos de Ruta");
			   //$("#map_canvas").css("display","none");
		   }
			

        }
		
      });

	  
  }

}


function RutasOnSave(formulario,resp){
	
      $("#refresh_QUERYGRID_Rutas").click();	  
	  
	  var ruta_id = parseInt(resp);
	  	  
      if(isNumber(ruta_id)){

		$('#ruta_id').val(ruta_id);
		
		if($('#guardar'))    $('#guardar').attr("disabled","true");
		if($('#actualizar')) $('#actualizar').attr("disabled","");
		if($('#borrar'))     $('#borrar').attr("disabled","");
		if($('#limpiar'))    $('#limpiar').attr("disabled","");

	    var rutaId = resp;
	    var url    = "DetalleRutaClass.php?ruta_id="+rutaId+"&rand="+Math.random();

		//setCoordinatesMapRoute(rutaId);
	    $("#detalleRuta").attr("src",url);
		 alertJquery("Guardado Exitosamente<br>Por favor Ingrese Puntos de Referencia","Rutas");  
		  
	  }else {
		   alertJquery("Ocurrio una inconsistencia : "+resp);
		 }
		 	  
	
}

function RutasOnUpdate(formulario,resp){
	
      $("#refresh_QUERYGRID_Rutas").click();
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","true");
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  
	  
      if($.trim(resp) == 'true'){
		  
	    var rutaId = $('#ruta_id').val();
	    var url    = "DetalleRutaClass.php?ruta_id="+rutaId+"&rand="+Math.random();
		//setCoordinatesMapRoute(rutaId);		
	    $("#detalleRuta").attr("src",url);
		
		alertJquery("Se actualizo exitosamente");
		  
	  }else {
		   alertJquery("Ocurrio una inconsistencia : "+resp);
		 }
		 

}


function RutasOnDelete(formulario,resp){
	
   clearFind();
   Reset(document.getElementById('RutasForm'));
   rutasOnReset();
   initialize();
   $("#refresh_QUERYGRID_Rutas").click();   
   alertJquery(resp);  
   
	
}

function rutasOnReset(){
	
  clearFind();
  $("#detalleRuta").attr("src","/roa/framework/tpl/blank.html");
  
  document.getElementById('estado_ruta').value = 1;
  
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","true");  
  initialize();  
  
}

//eventos asignados a los objetos
$(document).ready(function(){
  
  
  $("#detalleRuta").attr("src","/roa/framework/tpl/blank.html");
  
  $("input[id=saveDetallesRuta]").click(function(){
										
    window.frames[0].saveDetallesRuta();
	
  });
  
  
  $("input[id=deleteDetallesRuta]").click(function(){
										
    window.frames[0].deleteDetallesRuta();
	
  });
  
  $("input[id=renderMap]").click(function(){
    //setCoordinatesMapRoute($("#ruta_id").val());
  });
  
//  $("#map_canvas").css("display","none");
  
  $("#detalleRuta").attr("height","400");
  
});


/**
* se construlle el mapa con sus 
* respectivas opciones
*/
function initialize() {
  if(markRoute){
    var myLatlng = new google.maps.LatLng(markRoute[0].lat,markRoute[0].lon);
      var myOptions = {
        zoom: 8,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  
  
    for(var i = 0; i < markRoute.length; i++){
	  points[i] = addMarkerPlace(markRoute[i].lat,markRoute[i].lon,markRoute[i].nom);
    }
  
  
    var rutaView = new google.maps.Polyline({
  	  map:map,
	  path: points,
	  strokeColor: "#FF0000",
	  strokeOpacity: 1.0,
	  strokeWeight: 2
    });
  }
}

/**
* se agregan las marcas en el mapa
* luego de que se carga la informacion
* de la ubicacion en el formulario
*/
function addMarkerPlace(lat,lon,nom){
	
	marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat,lon), 
        map: map,
        title:nom
    });
	return marker.position;
}

function updateGrid(){
   $("#refresh_QUERYGRID_Rutas").click();   	
}