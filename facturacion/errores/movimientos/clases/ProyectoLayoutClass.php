<?php

require_once("../../../framework/clases/ViewClass.php");

final class ProyectoLayout extends View{

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
   
    $Form1      = new Form("ProyectoClass.php","ProyectoForm","ProyectoForm");
   
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
    //$this -> TplInclude -> IncludeJs("/talpaprueba/framework/js/generalterceros.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");

    $this -> TplInclude -> IncludeJs("../../../errores/movimientos/js/Proyecto.js");
    $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");

    $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
    $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
    $this -> assign("FORM1",$Form1 -> FormBegin());
    $this -> assign("FORM1END",$Form1 -> FormEnd());
    $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
    $this -> assign("PARAMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[proyecto_id]));
    $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));       
    $this -> assign("FECHAINICIO",      $this -> getObjectHtml($this -> fields[fecha_inicio]));
    $this -> assign("FECHAFINAL",      $this -> getObjectHtml($this -> fields[fecha_final]));
    $this -> assign("CLIENTEID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
    $this -> assign("ESTADO", $this -> getObjectHtml($this -> fields[estado])); 
    $this -> assign("FECHAREGISTRO",  $this -> getObjectHtml($this -> fields[fecha_registro]));
    $this -> assign("CLIENTE",   $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
    $this -> assign("USUARIOID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
    $this -> assign("FECHAACT",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza]));
    $this -> assign("USUARIOACT",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id]));
   
   if($this -> Guardar)
     $this -> assign("GUARDAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   
   if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
   
   if($this -> Borrar)
     $this -> assign("BORRAR",  $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
   
   if($this -> Limpiar)
     $this -> assign("LIMPIAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
 }

 /*public function SetTipoBarrio($barrio){
   $this -> fields[barrio_id]['options'] = $barrio;
    $this -> assign("BARRIOID",      $this -> getObjectHtml($this -> fields[barrio_id]));
 }*/

 public function SetGridProyecto($Attributes,$Titles,$Cols,$Query){
  require_once("../../../framework/clases/grid/JqGridClass.php");
  $TableGrid = new JqGrid();
  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
  $this -> assign("GRIDProyecto",$TableGrid -> RenderJqGrid());
  $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
  $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
}


public function RenderMain(){
 $this ->RenderLayout('Proyecto.tpl');
}

}

?>