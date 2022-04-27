<?php
require_once("../../../framework/clases/ViewClass.php");
final class CertificadosLayout extends View{
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
	 
	 $Form1      = new Form("CertificadosClass.php","CertificadosForm","CertificadosForm");
	 
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
	 $this -> TplInclude -> IncludeJs("../../../framework/js/generalterceros.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../js/Certificados.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",$Form1 -> FormBegin());
	 $this -> assign("FORM1END",$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("CERTIFICADOSID",$this -> objectsHtml -> GetobjectHtml($this -> fields[certificados_id]));
	 $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));		 	 
	 $this -> assign("ENTIDAD",$this -> objectsHtml -> GetobjectHtml($this -> fields[entidad]));		 	 	 
	 $this -> assign("DECRETO",$this -> objectsHtml -> GetobjectHtml($this -> fields[decreto]));		 	 	 	
	 $this -> assign("NUMERO",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_certificado]));		 	 	 		
	 $this -> assign("ACTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[activo]));
	 $this -> assign("INACTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[inactivo]));
			
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
	       
   public function SetGridCertificados($Attributes,$Titles,$Cols,$Query){
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
	 $this ->RenderLayout('Certificados.tpl');
   }
}
?>