<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class SalidaTurnoLayout extends View{

   private $fields;
   private $Guardar;


   public function setGuardar($Permiso){
   $this -> Guardar = $Permiso;
 }
    
   
     public function SetCampos($campos){
		 
	require_once("../../../framework/clases/FormClass.php");
	
	$Form1      = new Form("SalidaTurnoClass.php","SalidaTurnoForm","SalidaTurnoForm");	 

	 $this -> fields = $campos;
	 //exit $campos;
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
	 $this -> TplInclude ->  IncludeCss("sistemas_informaticos/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");	
 
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	  $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/general.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/operacion/js/SalidaTurno.js");
	 $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.filestyle.js");
	 
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
	 $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());

	 $this -> assign("EXCEL",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[generar_excel]));		 
    $this -> assign("OBSERVACION",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[observacion_salida]));	
    $this -> assign("USUARIO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_salida_id]));
    $this -> assign("ENTURNAMIENTOID",   $this -> objectsHtml -> GetobjectHtml($this -> fields[enturnamiento_id]));
    $this -> assign("FECHASALIDA",   $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_salida_turno]));
    $this -> assign("ESTADO",   $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
    

    if($this -> Guardar)
     $this -> assign("SALIDA", $this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

	 
   }


   /*public function setMuelle($muelle_id){
      $this -> fields[muelle_id]['options'] = $muelle_id;
      $this -> assign("MUELLEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[muelle_id])); 
   }*/

//// GRID ////  
   public function SetGridSalidaTurno($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDSalidaTurno",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('SalidaTurno.tpl');
	 
   }


}


?>