<?php

require_once("../../../framework/clases/ViewClass.php");

final class MySqlLayout extends View{

 private $fields;
 private $Guardar;
 
 public function setGuardar($Permiso){
   $this -> Guardar = $Permiso;
 }
 
 public function setCampos($campos){

   require_once("../../../framework/clases/FormClass.php");
   
   $Form1      = new Form("MySqlClass.php","MySqlForm","MySqlForm");
   
   $this -> fields = $campos;
   
   $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
   $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
   $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
   $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css"); 

   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");

   $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");

   $this -> TplInclude -> IncludeJs("../js/MySql.js");
   $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
   
   $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
   $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
   $this -> assign("FORM1",$Form1 -> FormBegin());
   $this -> assign("FORM1END",$Form1 -> FormEnd());
   $this -> assign("QUERY",$this -> objectsHtml -> GetobjectHtml($this -> fields[query]));
   
   if($this -> Guardar)
     $this -> assign("EJECUTAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[ejecutar]));
 }

public function setDB($db){

  $this -> assign("DATABASES",$db);	  
 
 } 

public function RenderMain(){
 $this ->RenderLayout('MySql.tpl');
}

}

?>