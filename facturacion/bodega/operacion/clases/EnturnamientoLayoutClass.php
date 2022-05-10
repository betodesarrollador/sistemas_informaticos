<?php

require_once("../../../framework/clases/ViewClass.php");

final class EnturnamientoLayout extends View{

 private $fields;
 private $Guardar;
 private $Actualizar;
 private $Anular;
 private $Borrar;
 private $Limpiar;
 
 public function setGuardar($Permiso){
   $this -> Guardar = $Permiso;
 }
 
 public function setActualizar($Permiso){
   $this -> Actualizar = $Permiso;
 }   

 public function setAnular($Permiso){
   $this -> Anular = $Permiso;
 }   
 
 public function setBorrar($Permiso){
   $this -> Borrar = $Permiso;
 }      
 
 public function setLimpiar($Permiso){
   $this -> Limpiar = $Permiso;
 }   
 
 public function setCampos($campos){

   require_once("../../../framework/clases/FormClass.php");
   
   $Form1      = new Form("EnturnamientoClass.php","EnturnamientoForm","EnturnamientoForm");
   
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

   $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/operacion/js/Enturnamiento.js");
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
   $this -> assign("FECHAANULACION",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_anula_turno]));
   $this -> assign("ESTADO",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
   $this -> assign("OBSERVACION",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[observacion_anulacion]));
   $this -> assign("MARCAID",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[marca_id]));
   $this -> assign("MARCA",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[marca]));
   $this -> assign("TIPOVEHICULOID",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[tipo_vehiculo_id]));
   $this -> assign("COLORID",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[color_id]));
   $this -> assign("COLOR",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[color]));
   $this -> assign("NOMBRECONDUCTOR",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[nombre_conductor]));
   $this -> assign("CEDULACONDUCTOR",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[cedula_conductor]));
   $this -> assign("TELCONDUCTOR",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[telefono_conductor]));
   $this -> assign("TELAYUDANTE",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[telefono_ayudante]));
   $this -> assign("SOAT",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[soat]));
   $this -> assign("TECNOMECANICA",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[tecnomecanica]));
   
   $this -> assign("USUARIOID",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id])); 
   $this -> assign("FECHAREGISTRO",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro])); 
   $this -> assign("USUARIOACTUALIZA", $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id])); 
   $this -> assign("FECHAACTUALIZA",   $this      -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza])); 
   $this -> assign("USUARIOSTATIC",    $this      -> objectsHtml -> GetobjectHtml($this -> fields[usuario_anula_id])); 

   if($this -> Guardar)
     $this -> assign("GUARDAR",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   
   if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",  $this      -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
     $this -> assign("ANULAR",  $this      -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
   
   if($this -> Borrar)
     $this -> assign("BORRAR",      $this      -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
   
   if($this -> Limpiar)
     $this -> assign("LIMPIAR",     $this      -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
 }

  public function SetTipoVehiculo($tipos_vehiculo){
       $this -> fields[tipo_vehiculo_id][options] = $tipos_vehiculo;
       $this -> assign("TIPOVEHICULOID",$this -> getObjectHtml($this -> fields[tipo_vehiculo_id]));
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
 $this ->RenderLayout('Enturnamiento.tpl');
}

}

?>