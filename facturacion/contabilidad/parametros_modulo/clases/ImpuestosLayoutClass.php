<?php
require_once("../../../framework/clases/ViewClass.php");
final class ImpuestosLayout extends View{
   private $fields;
   
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
	 
	 $Form1      = new Form("ImpuestosClass.php","ImpuestosForm","ImpuestosForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../js/impuestos.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",				$Form1 -> FormBegin());
	 $this -> assign("FORM1END",			$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("IMPUESTOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[impuesto_id]));
	 $this -> assign("OFICINAID",           $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
	 $this -> assign("PUC",                 $this -> objectsHtml -> GetobjectHtml($this -> fields[puc]));
	 $this -> assign("PUCID",               $this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));	 
	 $this -> assign("NOMBRE",	            $this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
	 $this -> assign("DESCRIPCION",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));
	 $this -> assign("EXENTOS",		        $this -> objectsHtml -> GetobjectHtml($this -> fields[exentos]));
	 $this -> assign("SUBCODIGO",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[subcodigo]));
	 $this -> assign("NATURALEZA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza]));	
	 $this -> assign("AYUDA",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[ayuda]));		 	 	 
	 $this -> assign("ESTADO",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	 $this -> assign("PARATERCEROS",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[para_terceros]));	
	 $this -> assign("UBICACION",                 $this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
	 $this -> assign("UBICACIONID",               $this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));	 
	 	
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }
   
   public function setEmpresas($Empresas){
     $this -> fields[empresa_id]['options'] = $Empresas;
	 $this -> assign("EMPRESAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	
   }	 
	 
     
   public function SetGridImpuestos($Attributes,$Titles,$Cols,$Query){
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
	 $this ->RenderLayout('impuestos.tpl');
   }
}
?>