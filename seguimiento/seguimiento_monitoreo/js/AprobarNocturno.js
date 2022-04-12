// JavaScript Document
var map;
var points    = new Array();
var markRoute = new Array();


function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"trafico_nocturno_id",valores:$('#trafico_nocturno_id').val()});
	var forma       = document.forms[0];
	var controlador = 'AprobarNocturnoClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){	   
    
	   var trafico_id =  $.trim($('#trafico_id').val());
       
	   setCoordinatesMapRoute(trafico_id);
	   if($('#actualizar')) $('#actualizar').attr("disabled","");
	   if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
	   
    }); 
		
}

function setCoordinatesMapRoute(trafico_id){
  points      = new Array();
  markRoute   = new Array();
  var trafico_id = parseInt(trafico_id);	
  
  if(isNumber(trafico_id)){
	  
	  var QueryString = "ACTIONCONTROLER=setDataMap&trafico_id="+trafico_id;
	  
	  $.ajax({
		url     : "AprobarNocturnoClass.php",
		data    : QueryString,
		success : function(response){
            markRoute = eval("("+ response + ")");
			initialize();
        }
		
      });

	  
  }

}


function AprobarNocturnoOnUpdate(formulario,resp){
  
	  if($.trim(resp) == 'true'){
		   var trafico_id = $("#trafico_id").val();
		   alertJquery("Actualizado Satisfactoriamente","Trafico Nocturno");

		  var QueryString = "ACTIONCONTROLER=setEstado&trafico_id="+trafico_id;
		  
		  $.ajax({
			url     : "AprobarNocturnoClass.php",
			data    : QueryString,
			success : function(estado){
				$("#estado").val(estado);
				if(estado!='N' ){
				   if($('#actualizar')) $('#actualizar').attr("disabled","true");
				   if($('#limpiar'))    $('#limpiar').attr("disabled","");		 
				
				}
			}
			
		  });

		   
      }else{
		   alertJquery("Error Actualizando","Trafico Nocturno");

	  }

}



function AprobarNocturnoOnReset(){
  $('#actualizar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
  clearFind();
  initialize();
}


//eventos asignados a los objetos
$(document).ready(function(){
    
  $("#renderMap").click(function(){
    setCoordinatesMapRoute($("#trafico_id").val());
  });
  
  
  
  var trafico_nocturno_id  = $("#trafico_nocturno_id").val();
  
  if(trafico_nocturno_id.length > 0){
     setDataFormWithResponse();
  }
});
  
  

/**
* se construye el mapa con sus 
* respectivas opciones
*/
function initialize() {
	
try{
	  
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
  
}catch(e){
	//alertJquery('Error google');
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