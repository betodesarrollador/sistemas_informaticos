<?php

require_once("../../../framework/clases/ViewClass.php");

final class Crear_BodegaLayout extends View{

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
	 
	 $Form1      = new Form("Crear_BodegaClass.php", "Crear_BodegaForm","Crear_BodegaForm");	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("sistemas_informaticos/bodega/parametros_modulo/css/Crear_Bodega.css");	 
	 
//     $this -> TplInclude -> IncludeCss("sistemas_informaticos/seguimiento/parametros_modulo/css/Crear_Bodega.css");	 
	 
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/iColorPicker.js");	
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/framework/js/jquery.alerts.js");	 		   
     $this -> TplInclude -> IncludeJs("sistemas_informaticos/bodega/parametros_modulo/js/Crear_Bodega.js");
	 
     $this -> assign("CSSSYSTEM",	$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		$Form1 -> FormBegin());
     $this -> assign("FORM1END",	$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));

    $this->assign("NOMBRE",    $this->objectsHtml->GetobjectHtml($this->fields[nombre]));
    $this->assign("BODEGA_ID",    $this->objectsHtml->GetobjectHtml($this->fields[bodega_id]));
    $this->assign("CODIGOBOD",    $this->objectsHtml->GetobjectHtml($this->fields[codigo_bodega]));
    $this->assign("LATITUD",    $this->objectsHtml->GetobjectHtml($this->fields[latitud]));
    $this->assign("LONGITUD",    $this->objectsHtml->GetobjectHtml($this->fields[longitud]));
    $this->assign("UBICACION",    $this->objectsHtml->GetobjectHtml($this->fields[ubicacion]));
    $this->assign("UBICACION_ID",    $this->objectsHtml->GetobjectHtml($this->fields[ubicacion_id]));
     $this->assign("ALTO",    $this->objectsHtml->GetobjectHtml($this->fields[alto]));
     $this->assign("LARGO",    $this->objectsHtml->GetobjectHtml($this->fields[largo]));
     $this->assign("ANCHO",    $this->objectsHtml->GetobjectHtml($this->fields[ancho]));
     $this->assign("AREA",    $this->objectsHtml->GetobjectHtml($this->fields[area]));
     $this->assign("VOLUMEN",    $this->objectsHtml->GetobjectHtml($this->fields[volumen]));
    $this->assign("USUARIO_ID",    $this->objectsHtml->GetobjectHtml($this->fields[usuario_id]));
    $this->assign("USUARIO_ACTUALIZA_ID",    $this->objectsHtml->GetobjectHtml($this->fields[usuario_actualiza_id]));
    $this->assign("FECHA_ACTUALIZA",    $this->objectsHtml->GetobjectHtml($this->fields[fecha_actualiza]));
    $this->assign("FECHA_REGISTRO",    $this->objectsHtml->GetobjectHtml($this->fields[fecha_registro]));

    
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
   public function SetGridCrear_Bodega($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDBODEGA",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",		$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",			$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('Crear_Bodega.tpl');
	 
   }


}


?>