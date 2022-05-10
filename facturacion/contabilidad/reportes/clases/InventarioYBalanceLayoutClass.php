<?php
require_once("../../../framework/clases/ViewClass.php"); 
final class InventarioYBalanceLayout extends View{
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
  public function SetAnular($Permiso){
  $this -> Anular = $Permiso;
  }   
  public function SetImprimir($Permiso){
  $this -> Imprimir = $Permiso;
  }   
   
   public function setCampos($campos){
     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("InventarioYBalanceClass.php","InventarioYBalance","InventarioYBalance");	 	 
	 $Form2 = new Form("ReporteInventarioYBalanceClass.php","ReporteInventarioYBalance","ReporteInventarioYBalance");	 	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");		 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");     
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js"); 
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 		  
     $this -> TplInclude -> IncludeJs("../js/InventarioYBalance.js");
	 
     $this -> assign("CSSSYSTEM",	 $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	 $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		 $Form1 -> FormBegin());
     $this -> assign("FORM1END",	 $Form1 -> FormEnd());
     $this -> assign("FORM2",		 $Form2 -> FormBegin());
     $this -> assign("FORM2END",	 $Form2 -> FormEnd());	 
	 
     $this -> assign("OFICINAID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	 
     $this -> assign("CENTROSTODOS",   $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_centros]));
     $this -> assign("CUENTASTODAS",   $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_cuentas]));      
     $this -> assign("OPCIERRE",   $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_cierre]));	 	 	 
	 
     $this -> assign("DESDE",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));
     $this -> assign("HASTA",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));	 
     $this -> assign("NIVEL",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[nivel]));	 
     $this -> assign("TERCERO",        $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero]));
     $this -> assign("TERCEROID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[tercero_id]));	 	
     $this -> assign("OPTERCERO",      $this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_tercero]));
     $this -> assign("GENERAR",        $this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));
     $this -> assign("EXCEL",	       $this -> objectsHtml -> GetobjectHtml($this -> fields[excel]));
       $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	 
	   
   }
//LISTA MENU
  
   public function setEmpresas($empresas){
	 $this -> fields[empresa_id]['options'] = $empresas;
     $this -> assign("EMPRESASID",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	   
   }
   
   public function setOficinas($oficinas){
	 $this -> fields[oficina_id]['options'] = $oficinas;
     $this -> assign("OFICINAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	   
   }
   public function setCentrosCosto($centros){
	 $this -> fields[centro_de_costo_id]['options'] = $centros;
     $this -> assign("CENTROCOSTOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[centro_de_costo_id]));	   
   }   
 
   public function setCuentasPuc($cuentas){
     $this -> assign("CUENTAS",$cuentas);	 	   
   }
	     
   public function setNivelesPuc($niveles){	   
     $this -> assign("NIVEL",$niveles);	      
   }
 
   public function RenderMain(){  
     $this -> RenderLayout('InventarioYBalance.tpl');	 
   }

}

?>