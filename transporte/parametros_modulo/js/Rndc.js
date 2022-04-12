// JavaScript Document
//funcion para cargar los datos desde BUSCAR
function RndcOnSaveUpdate(formulario,resp){
	  if($('#actualizar')) $('#actualizar').attr("disabled","");
	  alertJquery($.trim(resp));
}
