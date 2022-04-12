// JavaScript Document
$(document).ready(function(){	
	indexarOrden();
	checkedAll();
	linkDetalles();
});

function linkDetalles(){
	$("a[name=saveDetalleReexpedido]").attr("href","javascript:void(0)");
	
	$("a[name=saveDetalleReexpedido]").focus(function(){
		var celda = this.parentNode;
		$(celda).addClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleReexpedido]").blur(function(){
		var celda = this.parentNode;
		$(celda).removeClass("focusSaveRow");
    });
	
	$("a[name=saveDetalleReexpedido]").click(function(){
		saveDetalle(this);
    });	
}

/*function saveDetalleReexpedido(){	
	$("input[name=procesar]:checked").each(function(){	
		saveDetalle(this);	
	});
}*/

function saveDetalle(obj){
	
	var row = obj.parentNode.parentNode;

	if(validaRequeridosDetalle(obj,row)){

	  var Celda                = obj.parentNode;
	  var Fila                 = Celda.parentNode;
	  var Tabla                = Fila.parentNode;
	  var detalle_despacho_guia_id  =  $(Fila).find("input[name=detalle_despacho_guia_id]").val();	
	  var doc_prov_rxp         = $(Fila).find("input[name=doc_prov_rxp]").val();	  	  
	  var valor_prov_rxp       = $(Fila).find("input[name=valor_prov_rxp]").val();
	  	
	  if(doc_prov_rxp.length > 0 || valor_prov_rxp.length > 0){
	    	      	      
	      var QueryString = "ACTIONCONTROLER=onclickSave&detalle_despacho_guia_id="+detalle_despacho_guia_id+"&doc_prov_rxp="+
		  doc_prov_rxp+"&valor_prov_rxp="+valor_prov_rxp;
	      
	      $.ajax({
		      url        : "DetalleReexpedidosClass.php",
		      data       : QueryString,
		      beforeSend : function(){
			    setMessageWaiting();
		      },
		      success    : function(response){
		      
			      if(response=='true'){
			
				      $(Celda).removeClass("focusSaveRow");
				      
				      checkRow();
				      linkDetalles();
					  parent.total_costo();
				      updateGrid();					 
				      setMessage('Se guardo exitosamente.');
		      
			      }else{
				      setMessage(response);
			      }			      
		      }		      
	      }); 
     }   
  }
}

function deleteDetalleReexpedido(obj,detalle_despacho_guia_id){	
	
	var Fila          = obj.parentNode.parentNode;	
	var QueryString   = "ACTIONCONTROLER=deleteDetalleReexpedido&detalle_despacho_guia_id="+detalle_despacho_guia_id;
	
	$.ajax({
		   
		url        : "DetalleReexpedidosClass.php",
		data       : QueryString,
		beforeSend : function(){},
		success    : function(response){
			if( $.trim(response) == 'true'){				
				var numRow = (Fila.rowIndex - 1);
				Fila.parentNode.deleteRow(numRow);				
			}else{
				alertJquery(response);
			}
		}
	});
}

function deleteDetallesReexpedido(){
	$("input[name=procesar]:checked").each(function(){
		deleteDetalleReexpedido(this);
	});
}	

function indexarOrden(){
	$("#tableDespacho tbody > tr").each(function(index){
		if ( $(this).find("input[name=detalle]").val() != (index+1) ){
			$(this).find("input[name=detalle]").val((index+1));
		}
	});
}

function checkedAll(){
	$("#checkedAll").click(function(){
		if($(this).is(":checked")){
			$("#tableDespacho input[name=procesar]").attr("checked","true");
		}else{
			$("#tableDespacho input[name=procesar]").attr("checked","");
		}	
	});
}

function updateGrid(){
	parent.updateGrid();
}