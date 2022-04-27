<?php

require_once("../../../framework/clases/ViewClass.php");

final class OrdenCompraLayout extends View{

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
	 
	 $Form1      = new Form("OrdenCompraClass.php","OrdenCompraForm","OrdenCompraForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/OrdenCompra.css");	 
	 
//     $this -> TplInclude -> IncludeCss("/velotax/seguimiento/parametros_modulo/css/OrdenCompra.css");	 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/OrdenCompra.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("ORDENID",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[ordencompra_id]));
     $this -> assign("AGENCIA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
     $this -> assign("SERVICONEX",	$this -> objectsHtml -> GetobjectHtml($this -> fields[servi_conex_id]));
	 
     $this -> assign("ORDEN",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[orden_compra]));
     $this -> assign("FECHA",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
     $this -> assign("PROVEEDOR",   $this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor]));
     $this -> assign("PROVEEDORID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));
     $this -> assign("PROVEEDORDOC",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion]));
     $this -> assign("DIRECCION",   $this -> objectsHtml -> GetobjectHtml($this -> fields[direccion]));
     $this -> assign("TELEFONO",    $this -> objectsHtml -> GetobjectHtml($this -> fields[telefono]));
	 
	 	 
	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

//LISTA MENU
   public function setEmpresas($Empresas){
     $this->fields[empresa_id]['options'] = $Empresas;
	 $this->assign("EMPRESAS",$this->objectsHtml->GetobjectHtml($this->fields[empresa_id]));
   }
   
   public function SetServiConexo($servi_conex_id){
	 $this -> fields[servi_conex_id]['options'] = $servi_conex_id;
     $this -> assign("SERVICONEX",$this -> objectsHtml -> GetobjectHtml($this -> fields[servi_conex_id])); 
   }
	 
   


//// GRID ////
   public function SetGridOrdenCompra($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDOrdenCompra",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('OrdenCompra.tpl');
	 
   }


}


?>