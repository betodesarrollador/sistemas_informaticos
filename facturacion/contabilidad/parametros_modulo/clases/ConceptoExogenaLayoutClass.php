<?php
require_once("../../../framework/clases/ViewClass.php");
final class ConceptoExogenaLayout extends View{
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
	 
	 $Form1 = new Form("ConceptoExogenaClass.php","ConceptoExogenaForm","ConceptoExogenaForm");	 	 
	 
	 $this -> fields = $campos;       
  	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/dhtmlgoodies_calendar.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.treeTable.css");	
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/dhtmlgoodies_calendar.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../js/ConceptoExogena.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.treeTable.js");	 		 	 
	 
     $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",$Form1 -> FormBegin());
     $this -> assign("FORM1END",$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("CONCEPTOEXOGENAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[concepto_exogena_id]));
     $this -> assign("CODIGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo]));	 
     $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));	 
     $this -> assign("DESCRIPCION",$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));
 	 	 	 	 
     $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	 	 				 
	 	 	 	 	 
     if($this -> Guardar)    
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));	 	 	 
	   
	 if($this -> Actualizar) 
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));	     
	   
	 if($this -> Borrar)     
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));	 	 	 	 
	   
	 if($this -> Limpiar)    
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 	 	 	 	 	 
   }
	 
   
   public function setEmpresas($Empresas){   
     $this -> fields[empresa_id]['options'] = $Empresas;
	 $this -> assign("EMPRESAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	
   }
   
   public function setOficinas($Oficinas){   
     $this -> fields[oficina_id]['options'] = $Oficinas;
	 $this -> assign("OFICINAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	
   } 
   
   public function setVehiculos($vehiculos){   
     $this -> fields[placa_id]['options'] = $vehiculos;
	 $this -> assign("VEHICULOS",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));	
   }        
   
    public function SetGridCentrosCosto($Attributes,$Titles,$Cols,$Query){
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
 	  
     $this -> RenderLayout('ConceptoExogena.tpl');
	 
   }
	 
}

?>