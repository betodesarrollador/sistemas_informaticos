<?php

require_once("../../../framework/clases/ViewClass.php");

final class CrearCiudadLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }   
      
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }   
   
   public function setCampos($campos){	 	

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("CrearCiudadClass.php","CrearCiudadForm","CrearCiudadForm");	 	 
	 
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
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/parametros_modulo/js/CrearCiudad.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");	 		 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.treeTable.js");	 		 	 
	 
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",			$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
     $this -> assign("TIPO_UBI",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_ubicacion]));
     $this -> assign("CIUDAD",				$this -> objectsHtml -> GetobjectHtml($this -> fields[ciudad]));
     $this -> assign("COD_CIUDAD",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cod_ciudad]));
     $this -> assign("DEPARTAMENTO",		$this -> objectsHtml -> GetobjectHtml($this -> fields[departamento]));
     $this -> assign("NOM_DEPARTAMENTO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[nom_departamento]));	 	 	 
     $this -> assign("PAIS",				$this -> objectsHtml -> GetobjectHtml($this -> fields[pais]));
     $this -> assign("UBIUBICACIONID",	    $this -> getObjectHtml($this -> fields[ubi_ubicacion_id]));
     $this -> assign("UBICACIONID",	    	$this -> getObjectHtml($this -> fields[ubicacion_id]));
	 
	 
	 	 	 	 	 
     if($this -> Guardar)    
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));	 	 	 
	   
	 if($this -> Actualizar) 
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));	     
	   	   
	 if($this -> Limpiar)    
	   $this -> assign("LIMPIAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));		 	 	 	 	 	 	 
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
 	  
     $this -> RenderLayout('CrearCiudad.tpl');
	 
   }
	 

}


?>