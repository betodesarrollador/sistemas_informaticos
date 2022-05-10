<?php

require_once("../../../framework/clases/ViewClass.php");

final class CambioFechasLayout extends View{

   private $fields;
   
   /*public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }*/
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   /*public function setBorrar($Permiso){
   	 $this -> Borrar = $Permiso;
   }
   
   public function setAnular($Permiso){
   	 $this -> Anular = $Permiso;
   }     
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }*/
   
   public function setCampos($campos){
     
	 require_once("../../../framework/clases/FormClass.php");	 
	 $Form1 = new Form("CambioFechasClass.php","CambioFechasForm","CambioFechasForm");	 
	
	 $this -> fields = $campos;	 
     
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
	 $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/ui.jqgrid.css");
	 
	 $this -> TplInclude -> IncludeCss("/velotax/mensajeria/operacion/css/CambioFechas.css");
	  
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");		 
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");		 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/operacion/js/CambioFechas.js");	 	 
     //$this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 
	 
     $this -> assign("CSSSYSTEM",	   		  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			  $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				  $Form1 -> FormBegin());
     $this -> assign("FORM1END",			  $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("OFICINAID",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
     $this -> assign("OFICINAIDSTATIC",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id_static]));
	 
	 // ----- INFORMACION GENERAL ----- // 	 
	 $this -> assign("ID",				   	$this -> objectsHtml -> GetobjectHtml($this -> fields[guia_id]));	 
     $this -> assign("GUIA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_guia]));
     $this -> assign("FECHAGUIA",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_guia]));
     $this -> assign("FECHAENVIO",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_envio]));
     $this -> assign("FECHAPUENTE",		   	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_puente]));
     $this -> assign("FECHAOFCENTREGA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ofc_entrega]));
     $this -> assign("HORAOFCENTREGA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_ent]));
     $this -> assign("FECHAENTREGA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_entrega]));
     $this -> assign("HORAENTREGA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[hora_entrega]));
	 $this -> assign("ORIGEN",		$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));
	 $this -> assign("ORIGENID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));
	 $this -> assign("DESTINO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
	 $this -> assign("DESTINOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));
	 $this -> assign("NOMREMITENTE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_remitente]));
	 $this -> assign("NOMDESTINATARIO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_destinatario]));
	 $this -> assign("TELREMITENTE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_remitente]));
	 $this -> assign("TELDESTINATARIO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_destinatario]));
	 $this -> assign("DIREMITENTE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_remitente]));
	 $this -> assign("DIDESTINATARIO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_destinatario]));
	 
	///////////////////////////////////////////////////////////
	
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
    /* if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));

	   
     if($this -> Anular)
     $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));     
	   $this -> assign("ANULA",$this -> objectsHtml -> GetobjectHtml($this -> fields[anula]));	   
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));

     if($this -> Imprimir){	   
	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	   $this -> assign("PRINTOUT",$this -> objectsHtml -> GetobjectHtml($this -> fields[print_out]));	   
	   $this -> assign("PRINTCANCEL",$this -> objectsHtml -> GetobjectHtml($this -> fields[print_cancel]));	   	   	   
	 }	   */
   }

   public function SetEstadoMensajeria($EstadoMensajeria){
	 $this -> fields[estado_mensajeria_id]['options'] = $EstadoMensajeria;
	 $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_mensajeria_id]));
   }   

   public function RenderMain(){
		$this -> RenderLayout('CambioFechas.tpl');
   }
}

?>