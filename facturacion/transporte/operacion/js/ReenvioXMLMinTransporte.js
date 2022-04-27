// JavaScript Document
$(document).ready(function(){

  //$("#message").dialog();	
  
   $("#tipo").change(function(){
  	  document.getElementById('frameResult').src = "ReenvioXMLMinTransporteClass.php?ACTIONCONTROLER=generateReport&"+Math.random()+"&tipo="+this.value;								

   });
	
						   
});

function deshabilitaBoton(formulario){
	
	var btnEnviar      = formulario.enviar;		
	var reconstruir    = formulario.reconstruir;		
	var reconstruirXML = $(btnEnviar.parentNode.parentNode.parentNode).find("input[name=reconstruirXML]").attr("checked");	
	
	$("input[name=enviar]").attr("disabled","true");

	reconstruir.value  = reconstruirXML;
		
	return true;

}

function reportarBases() {

	jConfirm("¿ Esta seguro que desea reportar TODAS las bases ?", "Validacion",

		function (r) {
			if (r) {

				$.ajax({
					url: "reportarBases.php?rand=" + Math.random(),
					beforeSend: function () {
						showDivLoading();
					},
					success: function (resp) {
						try {

							alertJquery(resp, "Bases");

						} catch (e) {

							alertJquery("Se presento un error :" + e, "Error");

						}

						removeDivLoading();

					}
				});


			} else {
				return false;
			}
		});

}