<?php
require_once("../../../framework/clases/ViewClass.php");
final class PlanCuentasLayout extends View{
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
	 
	 $Form1 = new Form("PlanCuentasClass.php","PlanCuentasForm","PlanCuentasForm");	 	 
	 
	 $this -> fields = $campos;       
  	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/dhtmlgoodies_calendar.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");	
     $this -> TplInclude -> IncludeCss("../css/plancuentas.css");	 
      //$this -> TplInclude -> IncludeCss("..//css/bootstrap.min.css"); 
       $this -> TplInclude -> IncludeCss("../css/sweetalert2.min.css"); 
         $this -> TplInclude -> IncludeCss("../css/animate.css");    
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");	
     $this -> TplInclude -> IncludeJs("../../../framework/js/dhtmlgoodies_calendar.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		 
     $this -> TplInclude -> IncludeJs("../js/plancuentas.js");
      $this -> TplInclude -> IncludeJs("../js/jquery-3.3.1.min.js");
       $this -> TplInclude -> IncludeJs("../js/sweetalert2.all.min.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.treeTable.js");	
      		 	 
	 
     $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",$Form1 -> FormBegin());
     $this -> assign("FORM1END",$Form1 -> FormEnd());
     $this -> assign("PUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_id]));
     $this -> assign("PUCPUC",$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_puc]));	 	 	 
     $this -> assign("PUCPUCID",$this -> objectsHtml -> GetobjectHtml($this -> fields[puc_puc_id]));	 	 
     $this -> assign("CODIGOPUC",$this -> objectsHtml -> GetobjectHtml($this -> fields[codigo_puc]));	 
     $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre]));
     $this -> assign("NATURALEZA",$this -> objectsHtml -> GetobjectHtml($this -> fields[naturaleza]));	 
     $this -> assign("REQUIERECENTROCOSTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[requiere_centro_costo]));	 
     $this -> assign("REQUIERETERCERO",$this -> objectsHtml -> GetobjectHtml($this -> fields[requiere_tercero]));
     $this -> assign("REQUIERESUCURSAL",$this -> objectsHtml -> GetobjectHtml($this -> fields[requiere_sucursal]));	      
     $this -> assign("CONTRAPARTIDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[contrapartida]));	      
     $this -> assign("NIVEL",$this -> objectsHtml -> GetobjectHtml($this -> fields[nivel]));	 
     $this -> assign("MOVIMIENTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[movimiento]));	
     $this -> assign("CORRIENTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[corriente]));		 
	 $this -> assign("ACTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[activo]));
	 $this -> assign("INACTIVO",$this -> objectsHtml -> GetobjectHtml($this -> fields[inactivo]));	 
	 			 	 	 	 	 
     if($this -> Guardar)    
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
   	   $this -> assign("DESCARGAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
	   
	 if($this -> Actualizar) 
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));	     
	   
	 if($this -> Borrar)     
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));	 	 	 	 
	   
	 if($this -> Limpiar)    
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 	 	 	 	 	 
   }
   
   public function setEmpresas($empresas){
     $this -> fields[empresa_id][options]	= $empresas;
	 $this -> assign("EMPRESAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	 
   }   
   
   public function setVarSuggets($usuario_id){
     $this -> fields[busqueda][suggest][vars] = "usuario_id=$usuario_id";
     $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
   }
	      
   public function RenderMain(){ 
     $this -> RenderLayout('plancuentas.tpl');
	 
   }
	 
}

?>