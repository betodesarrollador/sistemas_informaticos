<?php

require_once("../../../framework/clases/ViewClass.php");

final class TarifasRutaCubicajeLayout extends View{

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
	 
     $Form1      = new Form("TarifasRutaCubicajeClass.php","TarifasRutaCubicajeForm","TarifasRutaCubicajeForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
	
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/general.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/tarifasrutacubicaje.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TARIFASCLIENTEID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[tarifa_ruta_cubicaje_id]));
     $this -> assign("ORIGEN",				$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));	 
     $this -> assign("ORIGENID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));
	 $this -> assign("DESTINO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));	 
     $this -> assign("DESTINOID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));
     $this -> assign("DESDE",			    $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));
     $this -> assign("HASTA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));	 
	 $this -> assign("VALOR",		    	$this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));
	
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	  
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	 
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	  
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
    }  
	
   public function setClientes($clientes){

     $this -> fields[cliente_id][options] = $clientes;
     $this->assign("CLIENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	   
   }

   
    public function SetGridTarifasRutaCubicaje($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDTARIFAS",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
     
    public function RenderMain(){
      $this ->RenderLayout('tarifasrutacubicaje.tpl');
    }

}

?>