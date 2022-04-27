// JavaScript Document
var map;

//funcion para cargar los datos desde BUSCAR
function setDataFormWithResponse(){

	var parametros  = new Array({campos:"ubicacion_id",valores:$('#ubicacion_id').val()});
	var forma       = document.forms[0];
	var controlador = 'UbicacionClass.php';

	FindRow(parametros,forma,controlador,null,function(resp){

		if($('#actualizar')) $('#actualizar').attr("disabled","");
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

function UbicacionOnSaveUpdate(formulario,resp){

	$("#refresh_QUERYGRID_Ubicacion").click();

	if($('#guardar'))    $('#guardar').attr("disabled","true");
	if($('#actualizar')) $('#actualizar').attr("disabled","");
	if($('#borrar'))     $('#borrar').attr("disabled","true");
	if($('#limpiar'))    $('#limpiar').attr("disabled","");

	alertJquery($.trim(resp));

	var lat = $('#x').val();
	var lon = $('#y').val();
	var nom = $('#nombre').val();

	if( $.trim(lat) != "NULL" )
	addMarkerPlace(lat,lon,nom);
}

function UbicacionOnReset(){
	$('#guardar').attr("disabled","true");
	$('#actualizar').attr("disabled","true")
	$('#borrar').attr("disabled","true")
	$('#limpiar').attr("disabled","true");
}
//eventos asignados a los objetos
$(document).ready(function(){

	try{
		initialize();
		$("#map").css("display","");
	}catch(e){
		alertJquery("El complemento googleMaps solo funciona con conexion a la Internet");
		$("#map").css("display","none");
	}
});
/**
* se construlle el mapa con sus 
* respectivas opciones
*/
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