// JavaScript Document
var map;
//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){
		
	var parametros  = new Array({campos:"punto_referencia_id",valores:$('#punto_referencia_id').val()});
	var forma       = document.forms[0];
	var controlador = 'PuestosControlClass.php';
	
	FindRow(parametros,forma,controlador,null,function(resp){
													   
	  if($('#guardar'))    $('#guardar').attr("disabled","true");	
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  if($('#borrar'))     $('#borrar').attr("disabled","");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");

		var lat = $('#x').val();
		var lon = $('#y').val();
		var nom = $('#nombre').val();
		
		if( $.trim(lat) != "NULL" ){
			
			try{
			 addMarkerPlace(lat,lon,nom);
			}catch(e){
			
			}
		}

	});
}


function PuestosControlOnSaveUpdate(formulario,resp){
	
      Reset(formulario);
	  clearFind();
	  $("#refresh_QUERYGRID_PuestosControl").click();
	  
	  $("#imprimir").val("0");
	  $("#mapear,#estado").val("1");	  
	  
	  if($('#guardar'))    $('#guardar').attr("disabled","");
	  if($('#actualizar')) $('#actualizar').attr("disabled","true");
	  if($('#borrar'))     $('#borrar').attr("disabled","true");
	  if($('#limpiar'))    $('#limpiar').attr("disabled","");
	  
	  alertJquery($.trim(resp));

		var lat = $('#x').val();
		var lon = $('#y').val();
		var nom = $('#nombre').val();
		
		if( $.trim(lat) != "NULL" )
			addMarkerPlace(lat,lon,nom);

}


function PuestosControlOnDelete(formulario,resp){
	
   Reset(formulario);
   clearFind();
   
   $("#imprimir").val("0");
   $("#mapear,#estado").val("1");	  
	  
   $("#refresh_QUERYGRID_PuestosControl").click();   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
   
   alertJquery($.trim(resp));
}

function PuestosControlOnReset(){
	
  clearFind();
  
  $("#imprimir").val("0");
  $("#mapear,#estado").val("1");	    
  
  $('#guardar').attr("disabled","");
  $('#actualizar').attr("disabled","true");
  $('#borrar').attr("disabled","true");
  $('#limpiar').attr("disabled","");  
  
  //initialize();
  
}

//eventos asignados a los objetos
$(document).ready(function(){
  
	//evento que busca los datos ingresados
/*	$("#nombre").blur(function(){
	
		var nombre = $("#nombre").val(); 
 	 	var QueryString = "ACTIONCONTROLER=ComprobarNombre&nombre="+nombre;
	 
		$.ajax({
			url        : "PuestosControlClass.php?rand="+Math.random(),
			data       : QueryString,
			beforeSend : function(){
		  
			},
			success    : function(response){
		  
		  	try{
		
				var responseArray         	= $.parseJSON(response); 
				var punto_referencia_id     = responseArray[0]['punto_referencia_id'];
		
		
				if(parseInt(punto_referencia_id)>0 && $('#punto_referencia_id').val()==''){

					$('#guardar').attr("disabled","true");
					$('#actualizar').attr("disabled","true");
					$('#borrar').attr("disabled","true");
					 alertJquery("Ya Existe un Punto de Referencia con este Nombre. <br>Por favor Verifique.");
				
				}else if(parseInt(punto_referencia_id)>0 && $('#punto_referencia_id').val()!='' &&  parseInt(punto_referencia_id)!=parseInt($('#punto_referencia_id').val()) ){

					$('#guardar').attr("disabled","true");
					$('#actualizar').attr("disabled","true");
					$('#borrar').attr("disabled","true");
					 alertJquery("Ya Existe un Punto de Referencia con este Nombre. <br> Por favor Verifique.");
				
				}else if($('#punto_referencia_id').val()==''){
					$('#guardar').attr("disabled","");
					$('#actualizar').attr("disabled","true");
					$('#borrar').attr("disabled","true");
					
				}else if($('#punto_referencia_id').val()!=''){
					$('#guardar').attr("disabled","true");
					$('#actualizar').attr("disabled","");
					$('#borrar').attr("disabled","");

				}
		  	}catch(e){
				if($('#punto_referencia_id').val()==''){
					$('#guardar').attr("disabled","");
					$('#actualizar').attr("disabled","true");
					$('#borrar').attr("disabled","true");
					
				}else if($('#punto_referencia_id').val()!=''){
					$('#guardar').attr("disabled","true");
					$('#actualizar').attr("disabled","");
					$('#borrar').attr("disabled","");

				}		  	
			}
		  
		}});
	});
*/
	//evento que busca los datos ingresados
	$("#x").blur(function(){
		comprobar_coordenadas();
	});

	//evento que busca los datos ingresados
	$("#y").blur(function(){
		comprobar_coordenadas();
	});

/*    try{
	  initialize();
      $("#map").css("display","");	  
	}catch(e){
       alertJquery("El complemento googleMaps solo funciona con conexion a la Internet");
	   $("#map").css("display","none");
  	 }
*/
  
  $("#guardar").click(function(){
	  var formulario = document.getElementById('PuestosControlForm');
      Send(formulario,'onclickSave',null,PuestosControlOnSaveUpdate);  	  
  });

});

/**
* se construlle el mapa con sus 
* respectivas opciones
*/
function comprobar_coordenadas(){

	var x = $("#x").val(); 
	var y = $("#y").val(); 
	var QueryString = "ACTIONCONTROLER=ComprobarCoordenadas&x="+x+"&y="+y;
 
	$.ajax({
		url        : "PuestosControlClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
	  
		},
		success    : function(response){
	  
		try{
	
			var responseArray         	= $.parseJSON(response); 
			var punto_referencia_id     = responseArray[0]['punto_referencia_id'];
	
	
			if(parseInt(punto_referencia_id)>0 && $('#punto_referencia_id').val()==''){

				$('#guardar').attr("disabled","true");
				$('#actualizar').attr("disabled","true");
				$('#borrar').attr("disabled","true");
				 alertJquery("Ya Existe un Punto de Referencia con estas Coordenadas. <br>Por favor Verifique.");
			
			}else if(parseInt(punto_referencia_id)>0 && $('#punto_referencia_id').val()!='' &&  parseInt(punto_referencia_id)!=parseInt($('#punto_referencia_id').val()) ){

				$('#guardar').attr("disabled","true");
				$('#actualizar').attr("disabled","true");
				$('#borrar').attr("disabled","true");
				 alertJquery("Ya Existe un Punto de Referencia con estas Coordenadas. <br> Por favor Verifique.");
			
			}else if($('#punto_referencia_id').val()==''){
				$('#guardar').attr("disabled","");
				$('#actualizar').attr("disabled","true");
				$('#borrar').attr("disabled","true");
				
			}else if($('#punto_referencia_id').val()!=''){
				$('#guardar').attr("disabled","true");
				$('#actualizar').attr("disabled","");
				$('#borrar').attr("disabled","");

			}
		}catch(e){
			if($('#punto_referencia_id').val()==''){
				$('#guardar').attr("disabled","");
				$('#actualizar').attr("disabled","true");
				$('#borrar').attr("disabled","true");
				
			}else if($('#punto_referencia_id').val()!=''){
				$('#guardar').attr("disabled","true");
				$('#actualizar').attr("disabled","");
				$('#borrar').attr("disabled","");

			}		  	
		}
	  
	}});

}
function initialize() {
  
  var myLatlng = new google.maps.LatLng(4.570867987483645, -74.297333);
    var myOptions = {
      zoom: 6,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  
  centerChanged();
  google.maps.event.addListener(map, 'center_changed', centerChanged);

}

/**
* se agregan las marcas en el mapa
* luego de que se carga la informacion
* de la ubicacion en el formulario
*/
function addMarkerPlace(lat,lon,nom){
	
	var marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat,lon), 
        map: map,
        title:nom
    });  
}


/**
* funciones para obtener el centro actual
* del mapa y ponerlo en el pie de pagina
* del mismo
*/
function centerChanged() {
	var latlng = getCenterLatLngText();
	document.getElementById('latlng').innerHTML = latlng;
}
function getCenterLatLngText() {
    return '(' + map.getCenter().lat() +','+ map.getCenter().lng() +')';
}
