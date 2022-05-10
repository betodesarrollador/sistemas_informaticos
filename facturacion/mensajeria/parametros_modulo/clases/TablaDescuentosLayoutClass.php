<?php

require_once("../../../framework/clases/ViewClass.php");

final class TablaDescuentosLayout extends View{

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
	 
	 $Form1      = new Form("TablaDescuentosClass.php","TablaDescuentosForm","TablaDescuentosForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("/velotax/transporte/parametros_modulo/css/TablaDescuentos.css");	 
	 
//     $this -> TplInclude -> IncludeCss("/velotax/seguimiento/parametros_modulo/css/TablaDescuentos.css");	 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("/velotax/transporte/parametros_modulo/js/TablaDescuentos.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("DESCUENTOID", 	$this -> objectsHtml -> GetobjectHtml($this -> fields[descuento_id]));
//     $this -> assign("BASEDESCUENTOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[base_desc_id]));
     $this -> assign("AGENCIA",	    	$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
     $this -> assign("DESCUENTO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[descuento]));
  //   $this -> assign("PORCENTAJE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[porcentaje_descu]));
     $this -> assign("PUC",				$this -> objectsHtml -> GetobjectHtml($this -> fields[puc]));
     $this -> assign("NATURALEZA",      $this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza]));	 	
     $this -> assign("PUCID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));
//     $this -> assign("TIPO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_descuento]));

     $this -> assign("CALCULO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[calculo]));
     $this -> assign("PORCENTAJE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[porcentaje]));	 
     $this -> assign("ESTADO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
     $this -> assign("VISIBLE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[visible_en_impresion]));
 
	 
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
   
   public function setOficinas(){
     $this->fields[oficina_id]['options'] = $Empresas;
	 $this->assign("OFICINAS",$this->objectsHtml->GetobjectHtml($this->fields[oficina_id]));	   
   }
   
  /*public function setBases($bases){
     $this->fields[base_desc_id]['options'] = $bases;
	 $this->assign("BASEDESCUENTOID",$this->objectsHtml->GetobjectHtml($this->fields[base_desc_id]));	   	   
   }*/


//// GRID ////
   public function SetGridTablaDescuentos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDTablaDescuentos",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('TablaDescuentos.tpl');
	 
   }


}


?>