<?php

require_once("../../../framework/clases/ViewClass.php");

final class posicionLayout extends View{

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
   
   $Form1      = new Form("posicionClass.php","posicionForm","posicionForm");
   
   $this -> fields = $campos;
   
   $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");
   $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
   $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
   $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css"); 

   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");

   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
  
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");

   $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/parametros_modulo/js/posicion.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");
   
   $this -> assign("CSSSYSTEM",     $this      -> TplInclude -> GetCssInclude());
   $this -> assign("JAVASCRIPT",    $this      -> TplInclude -> GetJsInclude());
   $this -> assign("FORM1",        $Form1      -> FormBegin());
   $this -> assign("FORM1END",     $Form1      -> FormEnd());
   $this -> assign("BUSQUEDA",      $this      -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
   $this -> assign("POSICIONID",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[posicion_id]));
   $this -> assign("CODIGO",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[codigo]));
   $this -> assign("NOMBRE",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));       
   $this -> assign("ESTADO",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
   $this -> assign("UBICACION",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_bodega]));  
   $this -> assign("UBICACIONID",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_bodega_id]));
   
   $this -> assign("USUARIOID",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id])); 
   $this -> assign("FECHAREGISTRO",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro])); 
   $this -> assign("USUARIOACTUALIZA", $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id])); 
   $this -> assign("FECHAACTUALIZA",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza])); 
   $this -> assign("USUARIOSTATIC",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id_static])); 

   if($this -> Guardar)
     $this -> assign("GUARDAR",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   
   if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",  $this      -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
   
   if($this -> Borrar)
     $this -> assign("BORRAR",      $this      -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
   
   if($this -> Limpiar)
     $this -> assign("LIMPIAR",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
 }

 public function SetGridposicion($Attributes,$Titles,$Cols,$Query){
  require_once("../../../framework/clases/grid/JqGridClass.php");
  $TableGrid = new JqGrid();
  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
  $this -> assign("GRIDPOSICION",$TableGrid -> RenderJqGrid());
  $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
  $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
}


public function RenderMain(){
 $this ->RenderLayout('posicion.tpl');
}

}

?>