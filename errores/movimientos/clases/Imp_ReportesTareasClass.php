<?php

final class Imp_Reporte{
  
  public function __construct(){
  
  }
// print Out fubcion para la impresion
  public function printOut($fecha_inicio,$fecha_final,$Conex){
   
    // Requerimos los siguientes archivos
      require_once("Imp_ReportesTareasLayoutClass.php");
      require_once("Imp_ReportesTareasModelClass.php");
		
      // Instanciamos sus clases
      $Layout = new Imp_ReportesTareasLayout();
      $Model  = new Imp_ReportesTareasModel();		
	
// llamamos lafuncion setIncludes que esta en Imp_ReportesTareasLayoutClass.php
      $Layout -> setIncludes();
      // Le enviamos los parametro a getTareas al modelo Imp_ReportesTareasModelClass.php
	    $Layout -> setTareas($Model -> getTareas($fecha_inicio,$fecha_final,$Conex));
    
// llamamos lafuncion RenderMainpdf que no redigira a la vista, esa funcion esta en Imp_ReportesTareasLayoutClass.php
      $Layout -> RenderMainpdf();

}

}

?>