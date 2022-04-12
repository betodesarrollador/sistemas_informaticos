// JavaScript Document
$(document).ready(function(){	
    if(isNumber(parseInt($("#periodo_contable_id").val()))){ 
        LlenarFormPeriodo();
    }
});

function LlenarFormPeriodo(){
	
RequiredRemove();

var params     = new Array({campos:"periodo_contable_id",valores:$('#periodo_contable_id').val()});
var formulario = document.forms[0];
var url        = 'PeriodosClass.php';

FindRow(params,formulario,url,null,null);

if($('#guardar'))    $('#guardar').attr("disabled","true");
if($('#actualizar')) $('#actualizar').attr("disabled","");
if($('#borrar'))     $('#borrar').attr("disabled","");
if($('#limpiar'))    $('#limpiar').attr("disabled","");

}


function showTable(){
  
    var frame_grid =  document.getElementById('frame_grid');
    
      //Se valida que el iFrame no exista
      if(frame_grid == null ){
  
      var QueryString   = 'ACTIONCONTROLER=showGrid';
  
      $.ajax({
        url        : "PeriodosClass.php?rand="+Math.random(),
        data       : QueryString,
         async     : false,
        beforeSend : function(){
        showDivLoading();
        },
        success    : function(resp){
          console.log(resp);
          try{
            
            var iframe           = document.createElement('iframe');
            iframe.id            ='frame_grid';
            iframe.style.cssText = "border:0; height: 400px; background-color:transparent";
            //iframe.scrolling   = 'no';
            
            document.body.appendChild(iframe); 
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(resp);
            iframe.contentWindow.document.close();
            
            $('#mostrar_grid').removeClass('btn btn-warning btn-sm');
            $('#mostrar_grid').addClass('btn btn-secondary btn-sm');
            $('#mostrar_grid').html('Ocultar tabla');
            
          }catch(e){
            
            console.log(e);
            
          }
          removeDivLoading();
        } 
      });
      
    }else{
      
        $('#frame_grid').remove();
        $('#mostrar_grid').removeClass('btn btn-secondary btn-sm');
        $('#mostrar_grid').addClass('btn btn-warning btn-sm');
        $('#mostrar_grid').html('Mostrar tabla');
      
    }
    
  }

function ReplicarMeses(formulario) {

    if (ValidaRequeridos(formulario)) {

        var periodo_contable_id = $("#periodo_contable_id").val();
        var empresa_id = $("#empresa_id").val();
        var anio = $("#anio").val();

        var QueryString = "ACTIONCONTROLER=onclickCrearMeses&periodo_contable_id=" + periodo_contable_id + "&empresa_id=" + empresa_id + "&anio=" + anio;

                $.ajax({

                    url: "PeriodosClass.php",
                    data: QueryString,
                    beforeSend: function () { },
                    success: function (response) {

                        if (response =='true') {

                             alertJquery("Se ingresaron correctamente los meses contables.");

                        } else {
                            alertJquery(response, "Error");
                        }
                    }/*fin del success*/
                });


    } else {
        alertJquery("Faltan campos obligatorios por diligenciar", "validacion");
    }

}

function PeriodoOnSaveOnUpdateonDelete(formulario,resp){

   Reset(formulario);
   clearFind();
   setFocusFirstFieldForm(formulario);   
   $("#refresh_QUERYGRID_periodo_contable").click();
   
   if($('#guardar'))    $('#guardar').attr("disabled","");
   if($('#actualizar')) $('#actualizar').attr("disabled","true");
   if($('#borrar'))     $('#borrar').attr("disabled","true");
   if($('#limpiar'))    $('#limpiar').attr("disabled","");
	
   alertJquery(resp,"Periodo Contable");
   
}
function PeriodoOnReset(formulario){
	
	Reset(formulario);
    clearFind();	
    setFocusFirstFieldForm(formulario);	
	
    if($('#guardar'))    $('#guardar').attr("disabled","");
    if($('#actualizar')) $('#actualizar').attr("disabled","true");
    if($('#borrar'))     $('#borrar').attr("disabled","true");
    if($('#limpiar'))    $('#limpiar').attr("disabled","");	
}

function viewCierre(encabezado_registro_id) {
    
	window.open("../../movimientos/clases/CierresClass.php?encabezado_registro_id="+encabezado_registro_id);

}