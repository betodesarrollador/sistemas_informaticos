<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DespachosLayout extends View{

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
	 
     $Form1 = new Form("DespachosClass.php","DespachosForm","DespachosForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/reportes/js/Despachos.js"); 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");		 
	 
     $this -> assign("CSSSYSTEM",	   $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	   $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		   $Form1 -> FormBegin());
     $this -> assign("FORM1END",	   $Form1 -> FormEnd());
     $this -> assign("FECHAINICIO",    $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio]));	 
     $this -> assign("FECHAFINAL",     $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));	 	 
     $this -> assign("OPCIONESCONDUCTOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_conductor]));	 	 	 
     $this -> assign("CONDUCTOR",        $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor]));	 	 	 	 
     $this -> assign("CONDUCTORID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_id]));	 	 	 	 
     $this -> assign("OPCIONESPLACA",  $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_placa]));	 	 	 	 	 	 
     $this -> assign("PLACA",          $this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));	 	 	 	 
     $this -> assign("PLACAID",        $this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));	 	 	 	 	 	 	 
     $this -> assign("OPCIONESOFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_oficina]));	 	 
     $this -> assign("OPCIONESESTADO", $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_estado]));	 	 	 
     $this -> assign("OFICINAID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 	 	 	 	 	 	 
     $this -> assign("ESTADO",         $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	 	 	 	 	 	 	 	 

     $this -> assign("OPCIONESDOC", $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_documento]));	 	 	 
     $this -> assign("DOCUMENTO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[documento]));	 	 	 	 	 	 	 

   }

//LISTA MENU

   public function setOficinas($oficinas){
	 $this -> fields[oficina_id]['options'] = $oficinas;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));      
   } 

   public function RenderMain(){   
     $this -> RenderLayout('Despachos.tpl');	 
   }

}


?>