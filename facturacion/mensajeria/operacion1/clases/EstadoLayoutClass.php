<?php

require_once("../../../framework/clases/ViewClass.php");

final class EstadoLayout extends View{

   private $fields;
   
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");	 
	 $Form1 = new Form("EstadoClass.php","EstadoForm","EstadoForm"); 	 
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     //$this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/Manifiestos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/Estado.css");
 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/Estado.js"); 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("OFICINAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
	 $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	  
	 $this -> assign("USUARIOREGISTRA",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_registra]));	  
	 $this -> assign("USUARIONUMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_registra_numero_identificacion]));  
     
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
   }



   public function RenderMain(){   
        $this ->RenderLayout('Estado.tpl');	 
   }
}

?>