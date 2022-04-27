<?php

require_once("../../../framework/clases/ViewClass.php");

final class AlertasLayout extends View{

 private $fields;
 private $Guardar;
 
 public function setGuardar($Permiso){
   $this -> Guardar = $Permiso;
 }
 
 public function setCampos($campos){

   require_once("../../../framework/clases/FormClass.php");
   
   $Form1      = new Form("AlertasClass.php","AlertasForm","AlertasForm");
   
   $this -> fields = $campos;
   
   $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
   $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
   $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
   $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css"); 
   $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	

   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
   
   $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");

   $this -> TplInclude -> IncludeJs("../js/Alertas.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
   
   $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
   $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
   $this -> assign("FORM1",$Form1 -> FormBegin());
   $this -> assign("MENSAJE",$this -> objectsHtml -> GetobjectHtml($this -> fields[mensaje]));
   $this -> assign("FECHAINICIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio]));
   $this -> assign("FECHAFIN",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_fin]));;
   $this -> assign("ALLMODULOS",    $this -> objectsHtml -> GetobjectHtml($this -> fields[all_modulos]));
   $this -> assign("ARCHIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[archivo]));
   $this -> assign("MODULOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[modulos]));
   $this -> assign("EMPRESAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresas]));
   $this -> assign("LINKVIDEO",$this -> objectsHtml -> GetobjectHtml($this -> fields[link_video]));
   $this -> assign("FORM1END",$Form1 -> FormEnd());
   
   if($this -> Guardar)
     $this -> assign("GUARDAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
 }

public function setDB($db){

  $this -> assign("DATABASES",$db);	  
 
 } 

public function SetModulos($modulos){
      $this -> fields[select_modulos]['options'] = $modulos;
      $this -> assign("SELECTMODULOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[select_modulos]));
}

public function RenderMain(){
 $this ->RenderLayout('Alertas.tpl');
}

}

?>