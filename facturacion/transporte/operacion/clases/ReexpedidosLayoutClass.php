<?php

require_once("../../../framework/clases/ViewClass.php");

final class ReexpedidosLayout extends View{

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
	 
	 $Form1 = new Form("ReexpedidosClass.php","ReexpedidosForm","ReexpedidosForm"); 	 
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/Reexpedidos.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("REMESAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[remesa_id]));
     $this -> assign("NUMEROREMESA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_remesa]));
     $this -> assign("REEXPEDIDOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[reexpedido_id]));
     $this -> assign("REEXPEDIDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[reexpedido]));
	 
     $this -> assign("FECHA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_rxp]));
	 $this -> assign("PROVEEDOR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor]));	 
     $this -> assign("PROVEEDORID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id]));
     $this -> assign("ORIGEN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));
     $this -> assign("ORIGENID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));
     $this -> assign("DESTINO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
     $this -> assign("DESTINOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));
     $this -> assign("GUIAPROVEEDOR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guia_rxp]));
     $this -> assign("VALOR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_rxp]));
     $this -> assign("OBSERVACIONES",	$this -> objectsHtml -> GetobjectHtml($this -> fields[obser_rxp]));
     
	 
	 
	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }


//LISTA MENU


//// GRID ////
   public function SetGridReexpedidos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDREEXPEDIDOS",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this ->RenderLayout('Reexpedidos.tpl');
	 
   }


}


?>