<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class SeguimientoLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   public function setAnular($Permiso){
   	 $this -> Anular = $Permiso;
   }
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("SeguimientoClass.php","SeguimientoForm","SeguimientoForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/operacion/css/Seguimiento.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/operacion/js/Seguimiento.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",		$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",		$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",			$Form1 -> FormBegin());
     $this -> assign("FORM1END",		$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 
     $this -> assign("SEGUIMIENTOID",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[seguimiento_id]));
     $this -> assign("DOCUMENTOCLIENTE",  $this -> objectsHtml -> GetobjectHtml($this -> fields[documento_cliente]));	 	 
     $this -> assign("SERVICIOTRANSPORTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[servicio_transporte_id]));
	 $this -> assign("FECHA",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));	 	 
     $this -> assign("OFICINAIDSTATIC",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id_static]));	 
     $this -> assign("OFICINAID",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
     $this -> assign("USUARIOIDSTATIC",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id_static]));	 
     $this -> assign("USUARIOID",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	 
	 $this -> assign("FECHAINGRESOSTAT",  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ingreso_static]));
     $this -> assign("FECHAINGRESO",	  $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_ingreso]));
	 $this -> assign("ESTADO",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));	 

	 $this -> assign("CLIENTE",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));
     $this -> assign("CLIENTEID",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
     $this -> assign("CLIENTENIT",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_nit]));
	 $this -> assign("CLIENTETEL",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_tel]));	
	 $this -> assign("CLIENTEMOV",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_movil]));	
	 $this -> assign("CLIENTEDIR",		$this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_cargue]));		 
	 $this -> assign("CONTACTOS",		$this -> objectsHtml -> GetobjectHtml($this -> fields[contacto_id]));		 
 
     $this -> assign("ORIGEN",			$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));
     $this -> assign("ORIGENID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));
     $this -> assign("DESTINO",			$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
     $this -> assign("DESTINOID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));	 
     
     
     $this -> assign("PLACAVEHICULO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));
     $this -> assign("PLACAVEHICULOID",	$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));
	 
     $this -> assign("REMOLQUE",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[remolque]));	 
	 	 
     $this -> assign("MARCAVEHICULO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[marca]));
     $this -> assign("LINEAVEHICULO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[linea]));	 	 
     $this -> assign("MODELOVEHICULO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[modelo]));
     $this -> assign("MODELOREPOTENCIADOVEHICULO",$this -> objectsHtml -> GetobjectHtml($this -> fields[modelo_repotenciado]));
     $this -> assign("SERIEVEHICULO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[serie]));	 
     $this -> assign("COLORVEHICULO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[color]));
     $this -> assign("CARROCERIAVEHICULO",	   $this -> objectsHtml -> GetobjectHtml($this -> fields[carroceria]));
     $this -> assign("REGISTRONALCARGAVEHICULO",  $this -> objectsHtml -> GetobjectHtml($this -> fields[registro_nacional_carga]));
     $this -> assign("CONFIGURACIONVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[configuracion]));
     $this -> assign("PESOVACIOVEHICULO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[peso_vacio]));
 	 	 	 	 	
     $this -> assign("NUMEROSOATVEHICULO",		    $this -> objectsHtml -> GetobjectHtml($this -> fields[numero_soat]));
     $this -> assign("ASEGURADORASOATVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_aseguradora]));

     $this -> assign("VENCIMIENTOSOATVEHICULO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[vencimiento_soat]));
     
     $this -> assign("PLACAREMOLQUE",		$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_remolque]));
     $this -> assign("PLACAREMOLQUEID",		$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_remolque_id]));	 
     $this -> assign("CONDUCTORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_id]));
     $this -> assign("NUMEROIDENTIFICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_identificacion]));
     $this -> assign("NOMBRECONDUCTOR",			  $this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
	 
     $this -> assign("DIRECCIONCONDUCTOR",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[direccion_conductor]));
     $this -> assign("CATEGORIALICENCIACONDUCTOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[categoria_licencia_conductor]));	 	 
     $this -> assign("TELEFONOCONDUCTOR",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[telefono_conductor]));
     $this -> assign("MOVILCONDUCTOR",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[movil_conductor]));
     $this -> assign("CORREOCONDUCTOR",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[correo_conductor]));
	 $this -> assign("CIUDADCONDUCTOR",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[ciudad_conductor]));	 	 	 	 	 
	 
	 $this -> assign("VALORFACTURAR",             $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_facturar]));	 		 	 	 
	 
     $this -> assign("OBSERVACIONES",		      $this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));	     	 
     $this -> assign("FECHASALIDA",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_estimada_salida]));	 	 	 
     $this -> assign("HORASALIDA",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[hora_estimada_salida]));	 	 
     $this -> assign("VALORFLETE",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_flete]));	 	 	 	 
     $this -> assign("NETOPAGAR",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[valor_neto_pagar]));	 	 	 	 
     $this -> assign("SALDOPAGAR",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[saldo_por_pagar]));	 		 
	 
	 
	 
	 //ANULACION

     $this -> assign("FECHALOG",		      		  $this -> objectsHtml -> GetobjectHtml($this -> fields[anul_seguimiento]));
     $this -> assign("USUARIOANULID",		          $this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));
     $this -> assign("DESCRIPCIONANULACION",		  $this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_seguimiento]));

     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   
	   
	   
	   
   }
   
   public function setDescuentos($descuentos){
	 $this -> assign("DESCUENTOS",$descuentos);   
   }
   
   public function setImpuestos($impuestos){
	 $this -> assign("IMPUESTOS",$impuestos);      
   }   
   
//LISTA MENU

   public function SetTipo($Tipos){
     $this -> fields[tipo][options] = $Tipos;
	 $this -> assign("TIPO",$this -> GetObjectHtml($this -> fields[tipo]));
   }

   
//// GRID ////
   public function SetGridSeguimiento($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDSeguimiento",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
   }

   public function RenderMain(){
        $this -> RenderLayout('Seguimiento.tpl');
   }
}
?>