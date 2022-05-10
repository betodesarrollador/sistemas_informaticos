<?php

require_once("../../../framework/clases/ViewClass.php");

final class RecepcionProductoLayout extends View{

 private $fields;
 private $Guardar;
 private $Actualizar;
 private $Salida;
 private $Borrar;
 private $Limpiar;
 
 public function setGuardar($Permiso){
   $this -> Guardar = $Permiso;
 }
 
 public function setActualizar($Permiso){
   $this -> Actualizar = $Permiso;
 }   

 public function setSalida($Permiso){
   $this -> Salida = $Permiso;
 }   
 
 public function setBorrar($Permiso){
   $this -> Borrar = $Permiso;
 }      
 
 public function setLimpiar($Permiso){
   $this -> Limpiar = $Permiso;
 }   
 
 public function setCampos($campos){

   require_once("../../../framework/clases/FormClass.php");
   
   $Form1      = new Form("RecepcionProductoClass.php","RecepcionProductoForm","RecepcionProductoForm");
   
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

   $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/operacion/js/RecepcionProducto.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");
   
   $this -> assign("CSSSYSTEM",     $this      -> TplInclude -> GetCssInclude());
   $this -> assign("JAVASCRIPT",    $this      -> TplInclude -> GetJsInclude());
   $this -> assign("FORM1",        $Form1      -> FormBegin());
   $this -> assign("FORM1END",     $Form1      -> FormEnd());
   $this -> assign("BUSQUEDA",      $this      -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
   $this -> assign("ENTURNAMIENTOID",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[enturnamiento_id]));
   $this -> assign("FECHA",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
   $this -> assign("VEHICULOID",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[wms_vehiculo_id]));       
   $this -> assign("PLACA",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[placa]));
   $this -> assign("MUELLE",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[muelle]));  
   $this -> assign("MUELLEID",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[muelle_id]));  
   $this -> assign("FECHASALIDA",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_salida_turno]));
   $this -> assign("ESTADO",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
   $this -> assign("OBSERVACION",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[observacion_salida]));
   $this -> assign("ARCHIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[archivo]));
   
   $this -> assign("USUARIOID",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id])); 
   $this -> assign("FECHAREGISTRO",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro])); 
   $this -> assign("USUARIOACTUALIZA", $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id])); 
   $this -> assign("FECHAACTUALIZA",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza])); 
   $this -> assign("USUARIOSTATIC",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_salida_id])); 

   if($this -> Guardar)
     $this -> assign("GUARDAR",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   
   if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",  $this      -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
     $this -> assign("SALIDA",  $this      -> objectsHtml -> GetobjectHtml($this -> fields[salida]));
   
   if($this -> Borrar)
     $this -> assign("BORRAR",      $this      -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
   
   if($this -> Limpiar)
     $this -> assign("LIMPIAR",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
 }

 public function SetGridEnturnamiento($Attributes,$Titles,$Cols,$Query){
  require_once("../../../framework/clases/grid/JqGridClass.php");
  $TableGrid = new JqGrid();
  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
  $this -> assign("GRIDENTURNAMIENTO",$TableGrid -> RenderJqGrid());
  $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
  $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
}


public function RenderMain(){
 $this ->RenderLayout('RecepcionProducto.tpl');
}

}

?>