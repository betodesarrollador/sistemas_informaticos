  <?php
require_once("../../../framework/clases/ViewClass.php");



final class crearEncuestaLayout extends View{

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
    
    $Form1      = new Form("crearEncuestaClass.php","CrearEncuestaForm","CrearEncuestaForm");
    
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
    
    $this -> TplInclude -> IncludeJs("../../../errores/servicioCliente/js/crearEncuesta.js");
    
    $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
    echo('test9<br>');
    $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
    $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
    $this -> assign("FORM1",$Form1 -> FormBegin());
    $this -> assign("FORM1END",$Form1 -> FormEnd()); 
/*     $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
    $this -> assign("PARAMID",$this -> objectsHtml -> GetobjectHtml($this -> fields[actividad_programada_id]));
    $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));  
    $this -> assign("CLIENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
    $this -> assign("CLIENTEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id])); 
    $this -> assign("RESPONSABLE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[responsable]));
    $this -> assign("RESPONSABLEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_id]));     
    $this -> assign("DESCRIPCION",      $this -> getObjectHtml($this -> fields[descripcion]));
    $this -> assign("FECHAINI",      $this -> getObjectHtml($this -> fields[fecha_inicial]));
    $this -> assign("FECHAFIN",      $this -> getObjectHtml($this -> fields[fecha_final]));
    $this -> assign("FECHACIERRE",      $this -> getObjectHtml($this -> fields[fecha_cierre]));
    $this -> assign("FECHAINIREAL",      $this -> getObjectHtml($this -> fields[fecha_inicial_real]));
    $this -> assign("FECHAFINREAL",      $this -> getObjectHtml($this -> fields[fecha_final_real]));
    $this -> assign("ARCHIVO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[archivo]));
    $this -> assign("ESTADO", $this -> getObjectHtml($this -> fields[estado])); 
    $this -> assign("FECHAREGISTRO",  $this -> getObjectHtml($this -> fields[fecha_registro]));
    $this -> assign("PRIORIDAD",   $this -> objectsHtml -> GetobjectHtml($this -> fields[prioridad]));
    $this -> assign("USUARIOID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
    $this -> assign("USUARIOCIERRE",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_cierre_id]));
    $this -> assign("FECHACIERREREAL",      $this -> getObjectHtml($this -> fields[fecha_cierre_real]));
    $this -> assign("OBSERVACION",      $this -> getObjectHtml($this -> fields[observacion_cierre]));
    $this -> assign("FECHAACT",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_actualiza]));
    $this -> assign("USUARIOACT",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza_id]));

   
   if($this -> Guardar)
     $this -> assign("GUARDAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   
   if($this -> Actualizar)
     $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
      $this	->	assign("CERRAR",				$this	->	objectsHtml	->	GetobjectHtml($this	->	fields[cerrar]));
   
   if($this -> Borrar)
     $this -> assign("BORRAR",  $this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
   
   if($this -> Limpiar)
     $this -> assign("LIMPIAR", $this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar])); */
 }


public function RenderMain(){
  echo('test8<br>');
 $this ->RenderLayout('crearEncuesta.tpl');
}
 
}

?>