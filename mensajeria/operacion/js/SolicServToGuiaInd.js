// JavaScript Document
var detalle_ss_id;

$(document).ready(function(){
	$("#guiar").click(function(){
		setGuias();
	});
});
function chequear(obj){
	if(obj.checked==false){
		document.getElementById('all1').checked=false;
	}
	
}
function todos1(){
	if(document.getElementById('all1').checked==true){
		$("input[type=checkbox]").each(function(){
		
			this.checked=true;
		
		});	
	}else{
		$("input[type=checkbox]").each(function(){
		
			this.checked=false;
		
		});	
		
	}
}
function setGuias(){
	var guias_id='';
	if(document.getElementById('all1').checked==true){
		guias_id='todas';
		parent.document.forms[0]['guias_id'].value = guias_id;
		parent.previsual();
			
	}else{
	
		$("input[type=checkbox]:checked").each(function(){
			guias_id+=$(this).val()+",";
		});	
		guias_id= guias_id.substring(0, guias_id.length-1);
		parent.document.forms[0]['guias_id'].value = guias_id;
		parent.previsual();
	}
}
