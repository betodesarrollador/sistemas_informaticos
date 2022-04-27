$(document).ready(function(){
	$("#all").click(function(){ 
		setFacturas();
	});
	
		///INICIO VALIDACION FECHAS DE REPORTE
	
  	$('#desde').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechad)>today)) {
	  		alertJquery('Esta fecha no puede ser mayor a la fecha final o mayor a hoy.');
	  		return this.value = $('#hasta').val();
	  	};
	});

	$('#hasta').change(function(){

	  	var fechah = $('#hasta').val();
	  	var fechad = $('#desde').val();
	  	var today = new Date();

	  	if ((Date.parse(fechah) < Date.parse(fechad)) || (Date.parse(fechah)>today)) {
	  		alertJquery('Esta fecha no puede ser menor a la fecha de inicio o mayor a hoy.');
	  		return this.value = $('#desde').val();
	  	};
	});
	
	///FIN VALIDACION FECHAS DE REPORTE

	
});
function setFacturas(){
	
	if(document.getElementById('all').checked==true){
		$("input[type=checkbox]").each(function(){
			this.checked=true;														
		});	
			
	}else{
	
		$("input[type=checkbox]").each(function(){
			this.checked=false;														
		});	
	}
}
function comparar(){
	var cont=0; 
	var total=0;
	$("input[name=factura_proveedor_id]").each(function(){
		total++;														
	});	
	
	$("input[name=factura_proveedor_id]:checked").each(function(){
		cont++;														
	});	
	if(cont!=total) document.getElementById('all').checked=false; else document.getElementById('all').checked=true;
	
}
function generateReporte(form){
	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
	var proveedor_id=$("#proveedor_hidden").val();
	
	var QueryString = "AutorizaPagoClass.php?ACTIONCONTROLER=generateReporte&desde="+desde+"&hasta="+hasta+"&proveedor_id="+proveedor_id;
	$("#frameDepreciados").attr("src",QueryString);

}

function generateReporteExcel(form){
	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
	var proveedor_id=$("#proveedor_hidden").val();
	
	var QueryString = "AutorizaPagoClass.php?ACTIONCONTROLER=generateReporte&download=SI&desde="+desde+"&hasta="+hasta+"&proveedor_id="+proveedor_id;
	 document.location.href = QueryString;
}

function generateReporteExcelAutorizados(form){
	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
	var proveedor_id=$("#proveedor_hidden").val();
	
	var QueryString = "AutorizaPagoClass.php?ACTIONCONTROLER=generateReporte1&download=SI&desde="+desde+"&hasta="+hasta+"&proveedor_id="+proveedor_id;
	 document.location.href = QueryString;
}




function beforePrint(form){

	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
var proveedor_id=$("#proveedor_hidden").val();
	
   if(ValidaRequeridos(form)){
	 var QueryString = "AutorizaPagoClass.php?ACTIONCONTROLER=generateReporte1&printers=si&desde="+desde+"&hasta="+hasta+"&proveedor_id="+proveedor_id;  
	   popPup(QueryString,'Impresion Pendientes',800,600);
   }else{
	 alertJquery("Por favor ingrese los datos requeridos","Validacion");
   }
}

function beforePrint1(form){

	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
var proveedor_id=$("#proveedor_hidden").val();
	
   if(ValidaRequeridos(form)){
	 var QueryString = "AutorizaPagoClass.php?ACTIONCONTROLER=generateReporte&printers=si&desde="+desde+"&hasta="+hasta+"&proveedor_id="+proveedor_id;  
	   popPup(QueryString,'Impresion Pendientes',800,600);
   }else{
	 alertJquery("Por favor ingrese los datos requeridos","Validacion");
   }
}

function recargar(){
	
	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
	var proveedor_id=$("#proveedor_hidden").val();
	
	var QueryString = "AutorizaPagoClass.php?ACTIONCONTROLER=generateReporte&desde="+desde+"&hasta="+hasta+"&proveedor_id="+proveedor_id;
	$("#frameDepreciados").attr("src",QueryString);

}
function contabilizar(form){
	var desde= parent.document.getElementById('desde').value;
	var hasta= parent.document.getElementById('hasta').value;	
	var facturas='';
	$("input[name=factura_proveedor_id]:checked").each(function(){
        var fila =$(this).parent().parent();
		var valor_autorizado = fila.find("input[name=saldo]").val();
		facturas+=$(this).val()+"="+valor_autorizado+",";
	});		

	
	var QueryString = "ACTIONCONTROLER=onclickContabilizar&desde="+desde+"&hasta="+hasta+"&facturas="+facturas;
	$.ajax({
		url        : "AutorizaPagoClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){
			try{
				if(resp=='si'){
					alertJquery("Facturas Pendientes Autorizadas","Proceso finalizado");
					parent.recargar();					
				}else{
					alertJquery(resp,"Validacion");
				}
			}catch(e){
				alertJquery(resp,"Error :"+e);
				ResetForm(form);
			}
			removeDivLoading();
		}
	});

}

function ResetForm(form){
	
	$("#desde,#hasta").val("");	 	 	 	 

	$("#frameDepreciados").attr("src","/rotterdan/framework/tpl/blank.html");	

}
