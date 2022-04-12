<?php

require_once("../../../framework/clases/ViewClass.php");

final class CrearMuelleLayout extends View{

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
   
   $Form1      = new Form("CrearMuelleClass.php","CrearMuelleForm","CrearMuelleForm");
   
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
   //$this -> TplInclude -> IncludeJs("/talpaprueba/framework/js/generalterceros.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");

   $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/parametros_modulo/js/CrearMuelle.js");
   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");
   
   $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
   $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
   $this -> assign("FORM1",$Form1 -> FormBegin());
   $this -> assign("FORM1END",$Form1 -> FormEnd());
   $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
   $this -> assign("PARAMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[muelle_id]));
   $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));       
   $this -> assign("USUARIOACTUALIZA",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id]));
   $this -> assign("FECHAACTUALIZA",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza]));
   $this -> assign("FECHAREGISTRO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));
   $this -> assign("USUARIO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
   $this -> assign("USUARIOSTATIC",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_static]));
   $this -> assign("BODEGA",   $this -> objectsHtml -> GetobjectHtml($this -> fields[bodega]));
   $this -> assign("BODEGAID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[bodega_id]));
  //  $this -> assign("AREA",   $this -> objectsHtml -> GetobjectHtml($this -> fields[area]));
   $this -> assign("CODIGO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[codigo]));
   $this -> assign("ESTADO",        $this      -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
   
   if($this -> Guardar)
     $this -> assign("GUARDAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   
   if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
   
   if($this -> Borrar)
     $this -> assign("BORRAR",  $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
   
   if($this -> Limpiar)
     $this -> assign("LIMPIAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
 }

 /*public function SetTipoUbicacion($ubicacion){
   $this -> fields[tipo_ubicacion_id]['options'] = $ubicacion;
  $this -> assign("UBICACION",   $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_ubicacion_id]));
 }*/

 public function SetGridCrearMuelle($Attributes,$Titles,$Cols,$Query){
  require_once("../../../framework/clases/grid/JqGridClass.php");
  $TableGrid = new JqGrid();
  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
  $this -> assign("GRIDCrearMuelle",$TableGrid -> RenderJqGrid());
  $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
  $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
}


public function RenderMain(){
 $this ->RenderLayout('CrearMuelle.tpl');
}

}

?>