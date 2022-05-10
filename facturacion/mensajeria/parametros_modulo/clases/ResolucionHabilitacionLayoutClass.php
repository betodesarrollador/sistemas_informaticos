<?php

require_once("../../../framework/clases/ViewClass.php");

final class ResolucionHabilitacionLayout extends View{

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
	 
	 $Form1      = new Form("ResolucionHabilitacionClass.php","ResolucionHabilitacionForm","ResolucionHabilitacionForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/parametros_modulo/css/resolucionhabilitacion.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");		 
	 
//     $this -> TplInclude -> IncludeCss("/velotax/seguimiento/parametros_modulo/css/ResolucionHabilitacion.css");	 
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/iColorPicker.js");	
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/parametros_modulo/js/ResolucionHabilitacion.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("HABILITACIONID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[habilitacion_id]));
     $this -> assign("HABILITACION",	$this -> objectsHtml -> GetobjectHtml($this -> fields[habilitacion]));
     $this -> assign("FECHA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_habilitacion]));
     $this -> assign("CODEMPRESA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_empresa]));

   /*  $this -> assign("NUMRESOLUCION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_resolucion]));
     $this -> assign("FECHARESOLUCION",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_resolucion]));*/
     $this -> assign("CODADUANERO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_usuario_aduanero]));
	 
     $this -> assign("INICIAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_manif_ini]));

     $this -> assign("FINAL",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_manif_fin]));
     $this -> assign("INICIALURBANO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_despacho_urbano_ini]));

     $this -> assign("FINALURBANO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_despacho_urbano_fin]));
     $this -> assign("INICIALREMESA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_guia_ini]));

     $this -> assign("FINALREMESA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[rango_guia_fin]));

     $this -> assign("ASIGNADO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[asignado_rango_manif]));	 
	 
     $this -> assign("SALDO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_rango_manif]));	 
	 

     $this -> assign("ASIGNADODESPACHO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[asignado_rango_despacho_urbano]));	 
	 
     $this -> assign("SALDODESPACHO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_rango_despacho_urbano]));	 


     $this -> assign("ASIGNADOREMESA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[asignado_rango_remesa]));	 
	 
     $this -> assign("SALDOREMESA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_rango_remesa]));	 
	 
	 
	 
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
   
   public function setCodRegional($codigo_regional){
   
     $this->fields[codigo_regional]['options'] = $codigo_regional;
	 $this->assign("CODIGOREGIONAL",$this->objectsHtml->GetobjectHtml($this->fields[codigo_regional]));	

   }


//// GRID ////
   public function SetGridResolucionHabilitacion($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDResolucionHabilitacion",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('ResolucionHabilitacion.tpl');
	 
   }


}


?>