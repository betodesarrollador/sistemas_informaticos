<?php

require_once("../../../framework/clases/ViewClass.php");

final class PeriodosUIAFLayout extends View{

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
	 
	 $Form1 = new Form("PeriodosUIAFClass.php","PeriodosUIAFForm","PeriodosUIAFForm");	 	 
	 
	 $this -> fields = $campos;       
  	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/dhtmlgoodies_calendar.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");	
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");	
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.treeTable.css");	
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");	
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/dhtmlgoodies_calendar.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/parametros_modulo/js/PeriodosUIAF.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.treeTable.js");	 		 	 
	 
     $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",$Form1 -> FormBegin());
     $this -> assign("FORM1END",$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("PERIODOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[periodo_uiaf_id]));
     $this -> assign("ANIO",$this -> objectsHtml -> GetobjectHtml($this -> fields[anio]));	 	 
     $this -> assign("DESDE",$this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));	 
     $this -> assign("HASTA",$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));	 	 
     $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado]));
     $this -> assign("MOSTRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[mostrar]));	 
     $this -> assign("NUMERO",$this -> objectsHtml -> GetobjectHtml($this -> fields[numero]));	 
	 	 	 	 	 
     if($this -> Guardar)    
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));	 	 	 
	   
	 if($this -> Actualizar) 
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));	     
	   
	 if($this -> Borrar)     
	   $this -> assign("BORRAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));	 	 	 	 
	   
	 if($this -> Limpiar)    
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 	 	 	 	 	 
   }
	 
   
   public function setEmpresas($Empresas){
   
     $this -> fields[empresa_id]['options'] = $Empresas;
	 $this -> assign("EMPRESAS",$this -> objectsHtml -> GetobjectHtml($this -> fields[empresa_id]));	

   }
      
    public function SetGridPeriodo($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDPERIODO",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }   
   
        
   public function RenderMain(){ 
 	  
     $this -> RenderLayout('PeriodosUIAF.tpl');
	 
   }
	 

}


?>