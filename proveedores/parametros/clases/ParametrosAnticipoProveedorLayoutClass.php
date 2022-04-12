<?php

require_once("../../../framework/clases/ViewClass.php");

final class ParametrosAnticipoProveedorLayout extends View{

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
	 
	 $Form1      = new Form("ParametrosAnticipoProveedorClass.php","ParametrosAnticipoProveedorForm","ParametrosAnticipoProveedorForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("/sistemas_informaticos/framework/css/jquery.alerts.css");

	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/funciones.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/proveedores/parametros/js/ParametrosAnticipoProveedor.js");
	 $this -> TplInclude -> IncludeJs("/sistemas_informaticos/framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",				$Form1 -> FormBegin());
	 $this -> assign("FORM1END",			$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("OFICINAID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));		 	 
	 $this -> assign("PARAMETROANTICIPOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[parametros_anticipo_proveedor_id]));	 
	 $this -> assign("PUC",                 $this -> objectsHtml -> GetobjectHtml($this -> fields[puc])); 	 
	 $this -> assign("PUCID",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));	 
	 $this -> assign("NOMBRE",	            $this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
	 $this -> assign("NATURALEZA",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza]));	 
	 
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
   
   public function SetTiposDocumentoContable($DocumentosContables){
	 $this -> fields[tipo_documento_id]['options'] = $DocumentosContables;
	 $this -> assign("DOCUMENTOCONTABLE",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));	 
   }
   
   public function SetNaturalezas($naturalezas){
	 $this -> fields[naturaleza_id]['options'] = $naturalezas;
	 $this -> assign("NATURALEZA",$this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza_id]));
   }

   
   public function SetGridParametrosAnticipoProveedor($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $this -> assign("GRIDIMPUESTOS",$TableGrid -> RenderJqGrid());
	 $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
	 $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }
	 

   public function RenderMain(){
	 $this ->RenderLayout('ParametrosAnticipoProveedor.tpl');
   }

}

?>