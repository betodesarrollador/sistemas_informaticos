
function OnclickGenerar(formulario){

	var serial        = $("#num_serial").val();
	var codigo        = $("#codigo").val();
	var codigo_barra  = $("#codigo_barra").val();
	
	/* if(serial == '' && codigo == ''){ */
	if(serial == ''){

		/* alertJquery("Por favor digite un codigo o serial de el producto(s) que desea filtrar !! ","Validacion"); */
		alertJquery("Por favor digite el <b>serial</b> de el producto que desea consultar !! ","Validacion");
		
	}else{

			var QueryString = "ReporteSeguimientoProductoClass.php?ACTIONCONTROLER=generateFile&download=false&serial="+serial+"&codigo_barra="+codigo_barra;

			$("#frameReporte").attr("src",QueryString);

			showDivLoading();	 	   

			$("#frameReporte").load(function(response){
				
				removeDivLoading();
			
			}); 

	}
	
}

function OnclickGenerarExcel(){

	 var serial        = $("#num_serial").val();
	var codigo        = $("#codigo").val();
	var codigo_barra  = $("#codigo_barra").val();
	
	/* if(serial == '' && codigo == ''){ */
	if(serial == ''){

		/* alertJquery("Por favor digite un codigo o serial de el producto(s) que desea filtrar !! ","Validacion"); */
		alertJquery("Por favor digite el <b>serial</b> de el producto que desea consultar !! ","Validacion");
		
	}else{

			var QueryString = "ReporteSeguimientoProductoClass.php?ACTIONCONTROLER=generateFile&download=true&serial="+serial+"&codigo_barra="+codigo_barra;

			$("#frameReporte").attr("src",QueryString);

	}
}

/* function beforePrint(formulario){
	
   if(ValidaRequeridos(formulario)){
	 var QueryString = "ReporteSeguimientoProductoClass.php?ACTIONCONTROLER=generateFile&download=false&"+FormSerialize(formulario);
	 popPup(QueryString,'Impresion Reporte',800,600);
	   
   }
} */
	