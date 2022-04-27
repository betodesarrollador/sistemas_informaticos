<?php

require_once("../../../framework/clases/ViewClass.php");

final class InformeDiarioLayout extends View{

 private $fields;
 private $Guardar;
 private $Actualizar;
 private $Borrar;
 private $Limpiar;
 
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
   
    $Form1      = new Form("InformeDiarioClass.php","InformeDiarioForm","InformeDiarioForm");
    $this -> fields = $campos;
    
    $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
    $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
    $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
    $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css"); 
    $this->TplInclude->IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
    $this->TplInclude->IncludeCss("../../../framework/css/jqgrid/ui.jqgrid.css");
    
    
    $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
    
    
    $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
    
    $this -> TplInclude -> IncludeJs("../../../errores/movimientos/js/InformeDiario.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
    
    $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
    $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
    $this -> assign("FORM1",$Form1 -> FormBegin());
    $this -> assign("FORM1END",$Form1 -> FormEnd());
    $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
    $this -> assign("INFORMEDIARIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[informe_id]));
    $this->assign("USUARIO", $this->objectsHtml->GetobjectHtml($this->fields[usuario]));
    $this->assign("USUARIOID", $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));
    $this->assign("QUEHICEHOY", $this->objectsHtml->GetobjectHtml($this->fields[quehicehoy]));
    $this->assign("DOTOMORROW", $this->objectsHtml->GetobjectHtml($this->fields[dotomorrow]));
    $this->assign("NOVEDADES", $this->objectsHtml->GetobjectHtml($this->fields[novedades]));
    
  
   if($this -> Guardar)
     $this -> assign("GUARDAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   
   if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
    

   if($this -> Limpiar)
     $this -> assign("LIMPIAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
 }

 public function setNovedades($novedades){
  $this -> fields[novedad_informe_diario_id]['options'] = $novedades;
  $this -> assign("NOVEDADES",$this -> objectsHtml -> GetobjectHtml($this -> fields[novedad_informe_diario_id]));			  
}

public function RenderMain(){
 $this ->RenderLayout('InformeDiario.tpl');
}

}

?>