function viewDocument(encabezado_registro_id){
	
  var QueryString = "../../../contabilidad/reportes/clases/LibrosAuxiliaresClass.php?ACTIONCONTROLER=viewDocument&encabezado_registro_id="+encabezado_registro_id;
  var title       = "Visualizacion DOcumento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}


function viewMC(manifiesto_id){
	
  var QueryString = "../../../transporte/operacion/clases/ManifiestosClass.php?ACTIONCONTROLER=onclickPrint&manifiesto_id="+manifiesto_id;
  var title       = "Visualizacion DOcumento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}

function viewDU(despacho_urbano_id){
	
  var QueryString = "../../../transporte/operacion/clases/DespachosUrbanosClass.php?ACTIONCONTROLER=onclickPrint&despacho_urbano_id="+despacho_urbano_id;
  var title       = "Visualizacion DOcumento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}