$(document).ready(function(){
	$("#all").click(function(){ 
		setFacturas();
	});
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
	$("input[name=id]").each(function(){
		total++;														
	});	
	
	$("input[name=id]:checked").each(function(){
		cont++;														
	});	
	if(cont!=total) document.getElementById('all').checked=false; else document.getElementById('all').checked=true;
	
}
function generateReporte(form){
	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
	
	var QueryString = "ContabilizarClass.php?ACTIONCONTROLER=generateReporte&desde="+desde+"&hasta="+hasta;
	$("#frameDepreciados").attr("src",QueryString);

}

function generateReporteExcel(form){
	var desde=$("#desde").val();
	var hasta=$("#hasta").val();
	
	var QueryString = "ContabilizarClass.php?ACTIONCONTROLER=generateReporte&download=SI&desde="+desde+"&hasta="+hasta;
	 document.location.href = QueryString;
}

function beforePrint(formulario){

	var desde=$("#desde").val();
	var hasta=$("#hasta").val();

   if(ValidaRequeridos(formulario)){
	 var QueryString = "ContabilizarClass.php?ACTIONCONTROLER=generateReporte&printers=si&desde="+desde+"&hasta="+hasta;  
	   popPup(QueryString,'Impresion Pendientes',800,600);
   }else{
	 alertJquery("Por favor ingrese los datos requeridos","Validacion");
   }
}
function alerta_auxi(mensaje){
	 alertJquery(mensaje,"Validacion");
}
function contabilizar(form){
	var desde= parent.document.getElementById('desde').value;
	var hasta= parent.document.getElementById('hasta').value;	
	var facturas='';
	$("input[name=id]:checked").each(function(){
		facturas+=$(this).val()+",";
	});		

	
	var QueryString = "ACTIONCONTROLER=onclickContabilizar&desde="+desde+"&hasta="+hasta+"&facturas="+facturas;
	$.ajax({
		url        : "ContabilizarClass.php?rand="+Math.random(),
		data       : QueryString,
		beforeSend : function(){
			showDivLoading();
		},
		success    : function(resp){
			try{

				 parent.alerta_auxi(resp);

				var QueryString = "ContabilizarClass.php?ACTIONCONTROLER=generateReporte&desde="+desde+"&hasta="+hasta;
				parent.document.getElementById('frameDepreciados').src=QueryString;


			}catch(e){
				//alertJquery(resp,"Error");
			}
			removeDivLoading();
		}
	});

}

function ResetForm(formulario){
	var f=new Date();
	var anio= f.getFullYear();
	Reset(formulario);
	$("#frameDepreciados").attr("src",'');
	
	var objSelect = document.getElementById('periodo_contable_id'); 
	var numOp     = objSelect.options.length ;
	objSelect.options[0].selected=false;		
   
   for(var i = 0; i < numOp; i++ ){
	 objSelect.options[i].selected = true;
   }
	
}