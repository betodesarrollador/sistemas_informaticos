<?php

require_once("../../../framework/clases/ViewClass.php");

final class ArchivoPlanoLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   
  
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("ArchivoPlanoClass.php","ArchivoPlanoForm","ArchivoPlanoForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("../../../proveedores/plano/css/ArchivoPlano.css");	
	 $this -> TplInclude ->  IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

	
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude ->  IncludeJs("../../../framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/general.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../proveedores/plano/js/ArchivoPlano.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());

	 $this -> assign("OFICINA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	
	 $this -> assign("TIPO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));		 
	 $this -> assign("DESDE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));		 	 
	 $this -> assign("HASTA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));		 	  
	 $this -> assign("PROVEEDOR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor]));	
	 $this -> assign("PROVEEDORID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[proveedor_id]));
 	 $this -> assign("ALLOFFICE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[all_oficina]));
 	 $this -> assign("SALDOS",			$this -> objectsHtml -> GetobjectHtml($this -> fields[saldos]));


     $this -> assign("GENERAR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));
 	 $this -> assign("DESCARGAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descargar]));	

	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   

    }

    public function SetOficina($oficina){
	  $this -> fields[oficina_id]['options'] = $oficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }

    public function SetTipo($tipos){
	  $this -> fields[tipo]['options'] = $tipos;
      $this -> assign("TIPO",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));
    }
   
	//--------------------------------------------Grid proveedores
	public function SetGridProveedores($Attributes,$Titles,$Cols,$Query){
      require_once("../../../framework/clases/grid/JqGridClass.php");
	  $TableGrid = new JqGrid();
 	  $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
      $this -> assign("GRIDPROVEEDORES",$TableGrid -> RenderJqGrid());
      $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
      $this -> assign("TABLEGRIDJS",$TableGrid -> GetJqGridJs());
    }
	//--------------------------------Grid proveedores
	
    public function RenderMain(){
      $this ->RenderLayout('ArchivoPlano.tpl');
    }

}

?>