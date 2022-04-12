function viewDocument(encabezado_registro_id){
	
  var QueryString = "LibrosAuxiliaresClass.php?ACTIONCONTROLER=viewDocument&encabezado_registro_id="+encabezado_registro_id;
  var title       = "Visualizacion DOcumento Contable";
  var width       = 900;
  var height      = 600;
    
  popPup(QueryString,title,width,height);  
	
}