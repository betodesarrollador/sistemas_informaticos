// JavaScript Document
$(document).ready(function(){
    $("input[type=text]:first").focus();
    checkedAll();
	checkRow();
	linkContactos();
	autocompleteEstadoContacto();
});


function checkedAll(){
	$("#checkedAll").click(function(){
		if($(this).is(":checked")){
			$("input[name=procesar]").attr("checked","true");
		}else{
			$("input[name=procesar]").attr("checked","");
		}
	});
}


function checkRow(){
	$("input[type=text]").keyup(function(event){
		var Tecla = event.keyCode;
		var Fila  = this.parentNode.parentNode;
		
		$(Fila).find("input[name=procesar]").attr("checked","true");
	});
}


/***************************************************************
	  lista inteligente para el estado del contacto con jquery
**************************************************************/
function autocompleteEstadoContacto(){
	
	$("input[name=estado_contacto]").autocomplete("/roa/framework/clases/ListaInteligente.php?consulta=estado_contacto",{
		width: 260,
		selectFirst: false
	});
	
	$("input[name=estado_contacto]").result(function(event, data, formatted){
		if (data) $(this).next().val(data[1]);
	});
}



/***************************************************************
	  Funciones para el objeto de guardado en los contactos
***************************************************************/
function linkContactos(){

	$("a[name=saveContacto]").attr("href","javascript:void(0)");
	
	$("a[name=saveContacto]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
	});
	
	$("a[name=saveContacto]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
	});
	
	$("a[name=saveContacto]").click(function(){
		saveContacto(this);
	});
}



function saveContacto(obj){

	var row = obj.parentNode.parentNode;
	
	if(validaRequeridosDetalle(obj,row)){
		
		var Celda              = obj.parentNode;
		var Fila               = obj.parentNode.parentNode;
		var contacto_id	       = $(Fila).find("input[name=contacto_id]").val();
		var cliente_id         = $("#cliente_id").val();
		var nombre_contacto    = $(Fila).find("input[name=nombre_contacto]").val();
		var cargo_contacto     = $(Fila).find("input[name=cargo_contacto]").val();
		var dir_contacto       = $(Fila).find("input[name=dir_contacto]").val();
		var tel_contacto       = $(Fila).find("input[name=tel_contacto]").val();
		var cel_contacto       = $(Fila).find("input[name=cel_contacto]").val();
		var email_contacto     = $(Fila).find("input[name=email_contacto]").val();
		var estado_contacto_id = $(Fila).find("input[name=estado_contacto_id]").val();
		var checkProcesar      = $(Fila).find("input[name=procesar]");
		
		if(!contacto_id.length > 0){
			if( $('#guardar',parent.document).length > 0 ){/*se valida el permiso de guardar*/
				contacto_id    = 'NULL';
				
				var QueryString = "ACTIONCONTROLER=onclickSave&cliente_id="+cliente_id+"&contacto_id="+contacto_id+
				"&nombre_contacto="+nombre_contacto+"&cargo_contacto="+cargo_contacto+"&dir_contacto="+dir_contacto+
				"&tel_contacto="+tel_contacto+"&cel_contacto="+cel_contacto+"&email_contacto="+email_contacto+"&estado_contacto_id="+estado_contacto_id;
				
				$.ajax({
					
					url        : "ContactosClass.php",
					data       : QueryString,
					beforeSend : function(){},
					success    : function(response){
						
						if(!isNaN(response)){
							
							$(Fila).find("input[name=contacto_id]").val(response);
							
							var Table   = document.getElementById('tableContactos');
							var numRows = (Table.rows.length - 1);
							var newRow  = Table.insertRow(numRows);
							
							$(newRow).html($("#clon").html());
							$(newRow).find("input[name=nombre_contacto]").focus();
							
							autocompleteEstadoContacto();
							linkContactos();
							checkRow();
							
							checkProcesar.attr("checked","");
							$(Celda).removeClass("focusSaveRow");
							
						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});
			}
		}else{
			if( $('#actualizar',parent.document).length > 0 ){/*se valida el persmiso de actualizar*/
				var QueryString = "ACTIONCONTROLER=onclickUpdate&cliente_id="+cliente_id+"&contacto_id="+contacto_id+
				"&nombre_contacto="+nombre_contacto+"&cargo_contacto="+cargo_contacto+"&dir_contacto="+dir_contacto+
				"&tel_contacto="+tel_contacto+"&cel_contacto="+cel_contacto+"&email_contacto="+email_contacto+"&estado_contacto_id="+estado_contacto_id;
				
				$.ajax({
					
					url        : "ContactosClass.php",
					data       : QueryString,
					beforeSend : function(){},
					success    : function(response){
					
						if( $.trim(response) == 'true'){
							checkProcesar.attr("checked","");
							$(Fila).find("a[name=saveContacto]").parent().addClass("focusSaveRow");
						}else{
							alertJquery(response);
						}
					}/*fin del success*/
				});
			}
		}
	}
}



function deleteContacto(obj){
	
	var Celda           = obj.parentNode;
	var Fila            = obj.parentNode.parentNode;
	var contacto_id	= $(Fila).find("input[name=contacto_id]").val();
	var QueryString     = "ACTIONCONTROLER=onclickDelete&contacto_id="+contacto_id;
	
	if(contacto_id.length > 0){
		if( $('#borrar',parent.document).length > 0 ){/*se valida el permiso de borrar*/
			$.ajax({
				
				url        : "ContactosClass.php",
				data       : QueryString,
				beforeSend : function(){},
				success    : function(response){
					
					if( $.trim(response) == 'true'){
						
						var numRow = (Fila.rowIndex - 1);
						Fila.parentNode.deleteRow(numRow);
						
					}else{
						alertJquery(response);
					}
				}/*fin del success*/
			});
		}
	}else{
		alertJquery('No puede eliminar elementos que no han sido guardados');
		$(Fila).find("input[name=procesar]").attr("checked","");
	}
}



function saveContactos(){
	$("input[name=procesar]:checked").each(function(){
		saveContacto(this);
	});
}

function deleteContactos(){
	$("input[name=procesar]:checked").each(function(){
		deleteContacto(this);
	});
}