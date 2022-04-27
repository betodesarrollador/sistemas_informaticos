<?php
require_once("../../../framework/clases/ViewClass.php");
final class DocumentosLayout extends View{
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
	 
	 $Form1 = new Form("DocumentosClass.php","DocumentosForm","DocumentosForm");	 	 
	 
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
     $this -> TplInclude -> IncludeJs("../js/documentos.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.treeTable.js");	 		 	 
	 
     $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",$Form1 -> FormBegin());
     $this -> assign("FORM1END",$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("DOCUMENTOSID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));
     $this -> assign("CODIGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo]));	 
     $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
     $this -> assign("CONSECUTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo]));	 
     $this -> assign("CONSECUTIVOPOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo_por]));	 	 
     $this -> assign("CONSECUTIVOANUAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo_periodo]));	 	 
     $this -> assign("TEXTOTERCERO",$this -> objectsHtml -> GetobjectHtml($this -> fields[texto_tercero]));	 
     $this -> assign("TEXTOSOPORTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[texto_soporte]));	 	 	 
     $this -> assign("REQUIERESOPORTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[requiere_soporte]));	 	 	 	 	  	 	 	 	 
     $this -> assign("DECIERRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[de_cierre]));
     $this -> assign("DETRASLADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[de_traslado]));	 	 
     $this -> assign("DEANTICIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[de_anticipo]));	 
     $this -> assign("DEDEVOLUCION",$this -> objectsHtml -> GetobjectHtml($this -> fields[de_devolucion]));	
     $this -> assign("PAGOFACTURA",$this -> objectsHtml -> GetobjectHtml($this -> fields[pago_factura]));		 
     $this -> assign("PAGOPROVEEDOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[pago_proveedor]));
     $this -> assign("NOTACREDITO",$this -> objectsHtml -> GetobjectHtml($this -> fields[nota_credito]));			 	 	 	 	  	 	 	 	 	 
     $this -> assign("NOTADEBITO",$this -> objectsHtml -> GetobjectHtml($this -> fields[nota_debito]));			 	 	 	 	  	 	 	 	 	 
	 
	 
	 	 	 	 	 
     if($this -> Guardar)    
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));	 	 	 
	   
	 if($this -> Actualizar) 
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));	     
	   
	 if($this -> Borrar)     
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));	 	 	 	 
	   
	 if($this -> Limpiar)    
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 	 	 	 	 	 
   }
   
	public function setEmpresas($empresas){
	 $this -> fields[empresa_id]['options'] = $empresas;
     $this -> assign("EMPRESASID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));			  
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
 	  
     $this -> RenderLayout('documentos.tpl');
	 
   }
	 
}

?>