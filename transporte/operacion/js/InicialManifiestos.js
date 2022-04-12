
$(document).ready(function () {
  if (intervalo) {
    clearInterval(intervalo);
    var intervalo = window.setInterval(function () { updateGrid() }, 50000);
  } else {
    var intervalo = window.setInterval(function () { updateGrid() }, 50000);
  }

  var QueryString = "ACTIONCONTROLER=ProximosVencer";

  $.ajax({
    url: "InicialManifiestosClass.php",
    data: QueryString,
    beforeSend: function () {
    },
    success: function (response) {

      var data = $.parseJSON(response);

      if (data != null) {

        msj = "\n<div align='center'><h3>¡Se encuentran vehiculos con documentos porximos a vencer\n por favor revise!</h3>";



        jConfirm(msj, "Documentos proximos a vencer",
          function (r) {

            if (r) {

                frameAnticipo();

            } else {

              return false;
            }
          });
      }
    }

  });

}); 


function frameAnticipo() { 

  $("#detalleFrameVencimiento").attr("src", "../../reportes/clases/vencimientoVehClass.php?"+"&rand=" + Math.random());
    $("#divDatosFrame").dialog({
      title: 'Listado Vehiculos',
      width: 700,
      height: 450,
      closeOnEscape: true,
      show: 'scale',
      hide: 'scale'
    });
}

// JavaScript Document
function updateGrid(){
  $("#refresh_QUERYGRID_Manifiestos").click();
  $("#refresh_QUERYGRID_Manifiestos1").click();	
  $("#refresh_QUERYGRID_conductores").click();
}


function reloadGrid(){
  $("#refresh_QUERYGRID_Manifiestos").click();	
  $("#refresh_QUERYGRID_Manifiestos1").click();	   	
  $("#refresh_QUERYGRID_conductores").click();	    	   
}