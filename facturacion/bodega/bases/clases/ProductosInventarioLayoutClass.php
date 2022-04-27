<?php

require_once("../../../framework/clases/ViewClass.php");

final class ProductosInventarioLayout extends View{

   private $fields;
   
   public function SetGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function SetActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
   
   public function SetBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }      
   
   public function SetLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("ProductosInventarioClass.php","ProductosInventarioForm","ProductosInventarioForm");
	 
	   $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");
	 
	   $this -> TplInclude -> IncludeCss("sistemas_informaticos/bodega/bases/css/detalles.css");
	
	   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/general.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/bases/js/ProductosInventario.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");
	   $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("PRODUCTOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id]));
     $this -> assign("NOMBRE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
     $this -> assign("ESTADO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
     $this -> assign("REFERENCIA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[referencia]));
     $this -> assign("TIPO_VALUACION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_valuacion]));
     $this -> assign("CODIGOBARRA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_barra]));
     $this -> assign("IMAGEN",				$this -> objectsHtml -> GetobjectHtml($this -> fields[imagen]));
     $this -> assign("PROCESADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[procesado]));	 
     $this -> assign("STOCKMIN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[stock_min]));	 
     $this -> assign("STOCKMAX",			$this -> objectsHtml -> GetobjectHtml($this -> fields[stock_max]));	 
     $this -> assign("DESCRIPCION",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descripcion]));	 
     $this -> assign("IVA",					$this -> objectsHtml -> GetobjectHtml($this -> fields[iva]));	 

     $this -> assign("CODIGO",         $this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_interno]));  
	 
	   $this -> assign("FECHAINICIO",					$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_inicio]));	 
	   $this -> assign("FECHAFINAL",					$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_final]));	 

    $this -> assign("PROVEEDOR",          $this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor]));  
    $this -> assign("PROVEEDORID",         $this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id]));  

    $this -> assign("LINEAPRODUCTO",          $this -> objectsHtml -> GetobjectHtml($this -> fields[linea_producto]));  
    //$this -> assign("LINEAPRODUCTOID",         $this -> objectsHtml -> GetobjectHtml($this -> fields[linea_producto_id]));  

    $this -> assign("TIPOVENTA",         $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_venta]));  

	 	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }
	 
    public function SetLineaProducto($LineaProducto){
      $this -> fields[linea_producto_id]['options'] = $LineaProducto;
      $this -> assign("PRODUCTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[linea_producto_id]));
    }

    public function SetMedida($medida){
      $this -> fields[medida_id]['options'] = $medida;
      $this -> assign("MEDIDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[medida_id]));
    }

    public function SetImpuestos($impuestos){
      $this -> fields[impuesto_id]['options'] = $impuestos;
      $this -> assign("IMPUESTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[impuesto_id]));
    }

    public function SetEmpaque($Empaque){
      $this -> fields[tipo_empaque_inv_id]['options'] = $Empaque;
      $this -> assign("EMPAQUE",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_empaque_inv_id]));
    }


    public function SetGridProductosInventario($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDPARAMETROS",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('ProductosInventario.tpl');
    }

}

?>