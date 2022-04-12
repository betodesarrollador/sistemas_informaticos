// JavaScript Document
$(document).ready(function(){
	$("#guiar").click(function(){
		var numDetalles = 0;
		$(document).find("input[type=checkbox]:checked").each(function(){
			numDetalles++;
		});
		if (numDetalles==0) {
			alertJquery('Usted no ha seleccionado ninguna solicitud para facturar','Aviso');
		}else{
			parent.botonGuardar();
			setSolicitud();
		}
	});
});

function setSolicitud(){
	var solicitudes  = new Array ();
	var i = 0;
	// var novo;
	$(document).find("input[type=checkbox]:checked").each(function(){
		var solicitud_id = this.value;
		var guias = $.trim($(this.parentNode.parentNode).find("td[aria-describedby=QUERYGRID_SolicServToGuiaPaqueteo_guia]").text());
		if (guias >  0) {
			solicitudes[i] = solicitud_id;
			i++;
			// novo = novo+","+solicitud_id;
		}else if(guias==0){
			alertJquery("Esta orden de Servicio no tiene guias para liquidar.","Validacion")
		}
	});
	parent.cargaDatos(solicitudes);
}