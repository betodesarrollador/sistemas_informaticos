<?php

require_once("../../../framework/clases/ViewClass.php"); 


final class Imp_ReportesTareasLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
    // la variable DETALLES tiene la consulta a la base de datos, setTareas se la asigna a $detalllas y ella hace lo mismo con DETALLES
   public function setTareas($detalles){    
     
    $this -> assign("DETALLES",$detalles);       
  }

   
// Esa funcion redirige a la vista Imp_ReporteTareas.tpl, archivos/reporte_tareas se guardaran los pdf de la impresion
   public function RenderMainpdf(){
	   
	  $ruta="../../../archivos/reporte_tareas/";


		$this -> exportToPdf('Imp_ReporteTareas.tpl','reporte_tareas',$ruta);   	 

   }


}

?>