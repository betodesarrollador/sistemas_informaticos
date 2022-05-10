<?php
require_once("../../../framework/clases/ViewClass.php"); 
final class CargaNominaLayout extends View{
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
   
   public function setImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   
   
   
   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   
   
   public function setCampos($campos){
     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("CargaNominaClass.php","CargaNomina","CargaNomina");	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 
     $this -> TplInclude -> IncludeCss("../css/movimientoscontables.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");     
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		  
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");	 
     $this -> TplInclude -> IncludeJs("../js/carganomina.js");
	 
     $this -> assign("CSSSYSTEM",	 $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	 $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		 $Form1 -> FormBegin());
     $this -> assign("FORM1END",	 $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	 $this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));	 
     $this -> assign("ENCABEZADOID", $this -> objectsHtml -> GetobjectHtml($this -> fields[encabezado_registro_id]));
     $this -> assign("CONSECUTIVO",	 $this -> objectsHtml -> GetobjectHtml($this -> fields[consecutivo]));
	 $this -> assign("OFICINASID",	 $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
     $this -> assign("FECHA",		 $this -> objectsHtml -> GetobjectHtml($this -> fields[fecha]));
	 $this -> assign("VALOR",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[valor]));	 
	 $this -> assign("NUMEROSOPORTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero_soporte]));	 	 
	 $this -> assign("TERCERO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));	 	 
	 $this -> assign("TERCEROID",    $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));	 	 	 
	 $this -> assign("CONCEPTO",	 $this -> objectsHtml -> GetobjectHtml($this -> fields[concepto]));
	 $this -> assign("SCAN",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[scan_documento]));	 
	 $this -> assign("PUCID",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));	 	 
	 $this -> assign("ESTADO",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
	 $this -> assign("ANULADO",	     $this -> objectsHtml -> GetobjectHtml($this -> fields[anulado]));	 
	 $this -> assign("MSJ_ANULADO",  "<span id='msj_anulado'>ANULADO</span>");	 	 
	 $this -> assign("FECHAREG"     ,date("Y-m-d"));	  	 
	 $this -> assign("FECHAREGISTRO",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro]));	  
	 $this -> assign("FECHAREGISTROSTATIC",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_registro_static]));	  	 
	 $this -> assign("TEXTOSOPORTE","<label id='texto_soporte'>N&deg; Soporte:</label>");	  
	 $this -> assign("TEXTOTERCERO","<label id='texto_tercero'>Tercero :</label>");	
     $this -> assign("ARCHIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[archivo]));
	 
	 /***********************
	     Anulacion Registro
	 ***********************/
	 
	 $this -> assign("FECHALOG",$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_log]));	   
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[observaciones]));	   	 
	 
	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   $this -> assign("CONTABILIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[contabilizar]));	   	 	   
	 }
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 
	   
	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   
   }
//LISTA MENU
  
   public function setEmpresas($empresas){
	 $this -> fields[empresa_id]['options'] = $empresas;
     $this -> assign("EMPRESASID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	   
   }
      
   public function setTiposDocumento($tipos_documento){
	 $this -> fields[tipo_documento_id]['options'] = $tipos_documento;
     $this -> assign("TIPOSDOCUMENTOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_documento_id]));	   	   
   }
   
   public function setFormaPago($formas_pago){
	 $this -> fields[forma_pago_id]['options'] = $formas_pago;
     $this -> assign("FPAGO",$this -> objectsHtml -> GetobjectHtml($this -> fields[forma_pago_id]));	   	   	   
   }
   
   public function setUsuarioId($usuario){
	 $this -> fields[usuario_id]['value'] = $usuario;
     $this -> assign("USUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));	  
	 $this -> fields[usuario_id_static]['value'] = $usuario;
     $this -> assign("USUARIOIDSTATIC",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id_static]));	   
	 
   }   
      
   public function setUsuarioModifica($usuario){
   
	 $this -> fields[modifica]['value'] = $usuario;
     $this -> assign("MODIFICA",$this -> objectsHtml -> GetobjectHtml($this -> fields[modifica]));	  
     $this -> assign("MODIF","<span id='modifica_nombre'>$usuario</span>");	  	 
	 
	 $this -> fields[modifica_static]['value'] = $usuario;
     $this -> assign("MODIFICASTATIC",$this -> objectsHtml -> GetobjectHtml($this -> fields[modifica_static]));	  
	 
   }
   
   
   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }
   public function RenderMain(){
   
        $this -> RenderLayout('carganomina.tpl');
	 
   }

}

?>