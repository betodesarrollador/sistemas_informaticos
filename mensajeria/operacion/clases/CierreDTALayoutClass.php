<?php

require_once("../../../framework/clases/ViewClass.php");

final class CierreDTALayout extends View{

   private $fields;
   private $Guardar;
   private $Actualizar;
   private $Borrar;
   private $Limpiar;
      
   public function setActualizar($Permiso){
	 $this -> Actualizar = $Permiso;
   }   
   
   public function setAnular($Permiso){
	 $this -> Anular = $Permiso;      
   }
   
   public function setImprimir($Imprimir){
	 $this -> Imprimir = $Imprimir;
   }      
   
   public function setLimpiar($Permiso){
	 $this -> Limpiar = $Permiso;
   }   
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1      = new Form("CierreDTAClass.php","CierreDTAForm","CierreDTAForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");

	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");	 	 
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/generalterceros.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/cierreDTA.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",		$Form1 -> FormBegin());
	 $this -> assign("FORM1END",		$Form1 -> FormEnd());
	 
     $this -> assign("MANIFIESTOCARGA",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[manifiesto]));	 	 	 	 	 
     $this -> assign("DESPACHOURBANO",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[despacho]));	 	 	 	 	 	 	 
     $this -> assign("CLIENTE",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	 	 	 	 	 
     $this -> assign("CLIENTEID",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));	 	 	 	 	 	 
     $this -> assign("DTAID",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[dta_id]));	 	 	 	 
     $this -> assign("NUMEROFORMULARIO",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_formulario]));	 	 	 	 	 
     $this -> assign("FECHACONSIGNACION",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_consignacion]));	 	 	 	 	 	 	 
     $this -> assign("FECHAENTREGADTA",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_entrega_dta]));	 	 	 	 	 	 	 	 
     $this -> assign("NUMEROCONTENEDORDTA",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_contenedor_dta]));	 
     $this -> assign("NAVIERA",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[naviera]));	 	 
	 
	 
     $this -> assign("TARA",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[tara]));	 	 
     $this -> assign("TIPO",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));	 	 	 
     $this -> assign("NUMEROPRECINTO",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_precinto]));	 	 	 	 	 	 	 	 	 	 	 	 	 		

     $this -> assign("CLIENTE",		                  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	 	 	 	 	 	 		
     $this -> assign("NUMEROIDENTIFICACIONCLIENTE",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion_cliente]));	 	 	 	 	 	 	 	 	 		 	 
     $this -> assign("CODIGO",	                      $this -> objectsHtml -> GetobjectHtml($this -> fields[codigo]));	 	 	 	 	 	 	 	 	 		 
     $this -> assign("PRODUCTO",	                  $this -> objectsHtml -> GetobjectHtml($this -> fields[producto]));	 	 	 	 	 	 	 	 	 	
     $this -> assign("PRODUCTOID",	                  $this -> objectsHtml -> GetobjectHtml($this -> fields[producto_id]));	 	 	 	 	 	 	 	 	 		 
     $this -> assign("PESO",	                      $this -> objectsHtml -> GetobjectHtml($this -> fields[peso]));	 	 	 	 	 	 	 	 	 		 	 
     $this -> assign("RESPONSABLEDIAN",	              $this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_dian]));	 	 	 	 	 	 	 $this -> assign("RESPONSABLEEMPRESA",            $this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_empresa]));	 	 	 	 	 	 	 	 	 		 	 	     
	 $this -> assign("OBSERVACIONES",	              $this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones_dta]));	
	 
     $this -> assign("FECHACIERRE",	                  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_cierre]));	 	 	 	 	 	 	 	 	 		 	 
	 $this -> assign("RESPONSABLEDIANENTREGA",$this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_dian_entrega]));	 	 	 	 	 	 	 $this -> assign("RESPONSABLEEMPRESAENTREGA",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[responsable_empresa_entrega]));		  	 	 	 	 	 		
	 $this -> assign("NOVEDADES",	                  $this -> objectsHtml -> GetobjectHtml($this -> fields[novedades]));		  	 	 	 	 	 	 	 $this -> assign("IMAGENPRUEBAENTREGA",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[imagen_prueba_entrega]));	
     $this -> assign("ESTADODTA",		              $this -> objectsHtml -> GetobjectHtml($this -> fields[estado_dta]));			 		
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[cancelacion]));	   
	   
	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }  
   
   public function setZonasFrancas($zonasFrancas){
   	  
     $this -> fields[zonas_francas_id][options] = $zonasFrancas;
	 $this -> assign("ZONASFRANCASID",$this -> objectsHtml -> GetobjectHtml($this -> fields[zonas_francas_id]));	  
   
   }
      
   public function SetGridCierreDTA($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $this -> assign("GRIDDTA",$TableGrid -> RenderJqGrid());
	 $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
	 $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }
	 

   public function RenderMain(){
	 $this ->RenderLayout('CierreDTA.tpl');
   }

}

?>