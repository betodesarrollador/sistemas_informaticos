<?php
require_once("../../../framework/clases/ViewClass.php");
final class ParametroReporteLayout extends View{
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
	 
	 $Form1      = new Form("ParametroReporteClass.php","ParametroReporteForm","ParametroReporteForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/generalterceros.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../js/ParametroReporte.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	
	
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",$Form1 -> FormBegin());
	 $this -> assign("FORM1END",$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));		
	 $this -> assign("PARAMETROID",$this -> objectsHtml -> GetobjectHtml($this -> fields[parametro_reporte_contable_id]));			
	 $this -> assign("UTILIDAD",$this -> objectsHtml -> GetobjectHtml($this -> fields[utilidad]));				 	 
	 $this -> assign("UTILIDADID",$this -> objectsHtml -> GetobjectHtml($this -> fields[utilidad_id]));				 			
	 $this -> assign("PERDIDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[perdida]));				 	 
	 $this -> assign("PERDIDAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[perdida_id]));				 
	 $this -> assign("UTILIDADCIERRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[utilidad_cierre]));				 	 
	 $this -> assign("PERDIDACIERRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[perdida_cierre]));		 	 	 
	 $this -> assign("UTILIDADCIERREID",$this -> objectsHtml -> GetobjectHtml($this -> fields[utilidad_cierre_id]));				 	 
	 $this -> assign("PERDIDACIERREID",$this -> objectsHtml -> GetobjectHtml($this -> fields[perdida_cierre_id]));		 
	 $this -> assign("CONTADOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contador_nombres]));		 	 
	 $this -> assign("CONTADORCARGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[contador_cargo]));		 	 
	 $this -> assign("CONTADORCEDULA",$this -> objectsHtml -> GetobjectHtml($this -> fields[contador_cedula]));		 
	 $this -> assign("CONTADORTARJETAPROFESIONAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[contador_tarjeta_profesional]));		 
	 $this -> assign("REVISOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[revisor_nombres]));		 	 
	 $this -> assign("REVISORCARGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[revisor_cargo]));		 		 
	 $this -> assign("REVISORCEDULA",$this -> objectsHtml -> GetobjectHtml($this -> fields[revisor_cedula]));		 	 	  
	 $this -> assign("REVISORTARJETAPROFESIONAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[revisor_tarjeta_profesional]));		 	 
	 $this -> assign("REPRESENTANTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[representante_nombres]));		 	 
	 $this -> assign("REPRESENTANTECARGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[representante_cargo]));		 	 
	 $this -> assign("REPRESENTANTECEDULA",$this -> objectsHtml -> GetobjectHtml($this -> fields[representante_cedula]));		
			
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
	       
   public function SetGridParametroReporte($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 
	 $head = "'<head>".
	 
	 $TableGrid -> GetJqGridJs()." ".
	 
	 $TableGrid -> GetJqGridCss()."
	 
	 </head>";
	 
	 $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
	 
	 return "<html>".$head." ".$body."</html>";
	 
   }
	 
   public function RenderMain(){
	 $this ->RenderLayout('ParametroReporte.tpl');
   }
   
   
}
?>