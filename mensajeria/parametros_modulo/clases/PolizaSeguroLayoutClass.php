<?php

require_once("../../../framework/clases/ViewClass.php");

final class PolizaSeguroLayout extends View{

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
	 
	 $Form1      = new Form("PolizaSeguroClass.php","PolizaSeguroForm","PolizaSeguroForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("/velotax/transporte/parametros_modulo/css/PolizaSeguro.css");	 
	 
//     $this -> TplInclude -> IncludeCss("/velotax/seguimiento/parametros_modulo/css/PolizaSeguro.css");	 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/iColorPicker.js");	
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("/velotax/transporte/parametros_modulo/js/PolizaSeguro.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("POLIZAID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[poliza_empresa_id]));
     $this -> assign("POLIZA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[numero]));
     $this -> assign("EXPEDICION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_expedicion]));
     $this -> assign("VENCIMIENTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_vencimiento]));
     $this -> assign("VALOR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[costo_poliza]));
	 
	 
     $this -> assign("DEDUCIBLE",$this -> objectsHtml -> GetobjectHtml($this -> fields[deducible]));
     $this -> assign("VALORMAXIMO",$this -> objectsHtml -> GetobjectHtml($this -> fields[valor_maximo_despacho]));
     $this -> assign("VALORMINIMO",$this -> objectsHtml -> GetobjectHtml($this -> fields[modelo_minimo_vehiculo]));
     $this -> assign("HORAINICIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_inicio_permitida]));	
     $this -> assign("HORAFINAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_final_permitida]));		  	 	 	 
     $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));		  	 	 	 	  
	 
	 
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
   
     $this->fields[empresa_id]['options'] = $Empresas;
	 $this->assign("EMPRESAS",$this->objectsHtml->GetobjectHtml($this->fields[empresa_id]));	

   }
   
   public function setAseguradora($aseguradora_id){
   
     $this->fields[aseguradora_id]['options'] = $aseguradora_id;
	 $this->assign("ASEGURADORA",$this->objectsHtml->GetobjectHtml($this->fields[aseguradora_id]));	

   }


//// GRID ////
   public function SetGridPolizaSeguro($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDPOLIZASEGURO",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('PolizaSeguro.tpl');
	 
   }


}


?>