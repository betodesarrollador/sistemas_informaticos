<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class CalculoTarifasRutaCubicajeLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("CalculoTarifasRutaCubicajeClass.php","CalculoTarifasRutaCubicajeForm","CalculoTarifasRutaCubicajeForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/solicitud_servicios.css");	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	
 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-uploader/swfobject.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery-uploader/jquery.uploadify.v2.1.0.min.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/CalculoTarifasRutaCubicaje.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("SOLICITUDID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[solicitud_servicio_tarifar_id]));
     $this -> assign("FECHA",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));	 	 
     $this -> assign("FECHASTATIC",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_static]));	 	 	 	 
     $this -> assign("CLIENTEID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));	 
     $this -> assign("OFICINA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina]));
     $this -> assign("OFICINAID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 	  	
     $this -> assign("OFICINAHIDDEN",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_hidden]));
     $this -> assign("OFICINAIDHIDDEN",	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id_hidden]));	 	  	
     $this -> assign("ARCHIVOSOLICITUD",$this -> objectsHtml -> GetobjectHtml($this -> fields[archivo_solicitud]));
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
     if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
     if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
     if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

//LISTA MENU

   public function setClientes($clientes){

     $this -> fields[cliente_id][options] = $clientes;
     $this->assign("CLIENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	   
   }


   public function RenderMain(){
   
        $this -> RenderLayout('CalculoTarifasRutaCubicaje.tpl');
	 
   }


}


?>