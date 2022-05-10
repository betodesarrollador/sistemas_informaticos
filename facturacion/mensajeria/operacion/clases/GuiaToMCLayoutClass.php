<?php

require_once("../../../framework/clases/ViewClass.php");

final class GuiaToMCLayout extends View{

   private $fields;
   
   public function setIncludes(){
	 
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");	 	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/GuiaToMC.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");		 
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js"); 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");	 

	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());
   }
   
   public function setCampos($campos){
	   
     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("GuiaToMCClass.php","GuiaToMCForm","GuiaToMCForm");
	   
  	 $this -> fields = $campos;
	 
	 $this -> assign("FORM1",		    $Form1 -> FormBegin());
     $this -> assign("FORM1END",	    $Form1 -> FormEnd());
	 $this -> assign("DESPACHAR",	 	$this -> getObjectHtml($this -> fields[despachar]));
	 $this -> assign("APLICAR", 	 	$this -> getObjectHtml($this -> fields[aplicar_filtro]));
	 $this -> assign("LIMPIAR", 	 	$this -> getObjectHtml($this -> fields[limpiar]));
	 $this -> assign("MANIFIESTOID", 	$this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto_id]));
	 $this -> assign("DESTINO",		 	$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
	 $this -> assign("DESTINOID",	 	$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));
	 $this -> assign("DEPARTAMENTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[departamento]));
	 $this -> assign("DEPARTAMENTOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[departamento_id]));	 
     $this -> assign("FECHA",		 	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));	
     $this -> assign("FECHAGUIA",	 	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_guia]));

   }

/// GRID ////
   public function SetGridGuiaToMC($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDGuiaToMC",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
   }

   public function RenderMain(){
   
        $this -> RenderLayout('GuiaToMC.tpl');	 
   }
}

?>