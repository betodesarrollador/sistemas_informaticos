<?php

require_once("../../../framework/clases/ViewClass.php");

final class PersonalizadoLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   }   
  
   
   public function SetCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1      = new Form("PersonalizadoClass.php","PersonalizadoForm","PersonalizadoForm");
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");
	 $this -> TplInclude -> IncludeCss("/roa/seguimiento/reportes/css/Personalizado.css");	
	 $this -> TplInclude -> IncludeCss("/roa/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");

	
	 $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
	 $this -> TplInclude ->  IncludeJs("/roa/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
	 $this -> TplInclude -> IncludeJs("/roa/framework/js/ajaxupload.3.6.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/general.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/reportes/js/Personalizado.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");
	 $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.filestyle.js");
	
     $this -> assign("CSSSYSTEM",			$this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",			$this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",				$Form1 -> FormBegin());
     $this -> assign("FORM1END",			$Form1 -> FormEnd());

	 $this -> assign("OFICINA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));	
	 $this -> assign("TIPO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo]));		
	 $this -> assign("TIPO_DOC",			$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_doc]));		
	 $this -> assign("DESDE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));		 	 
	 $this -> assign("HASTA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));		 	  
	 $this -> assign("DESDEH",				$this -> objectsHtml -> GetobjectHtml($this -> fields[desde_h]));		 	 
	 $this -> assign("HASTAH",				$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta_h]));		 	  

	 $this -> assign("SOLOUNO",				$this -> objectsHtml -> GetobjectHtml($this -> fields[solouno]));		 	  

	 $this -> assign("CLIENTE",				$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));	
	 $this -> assign("CLIENTEID",			$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	 $this -> assign("PLACA",				$this -> objectsHtml -> GetobjectHtml($this -> fields[placa]));	
	 $this -> assign("PLACAID",				$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));
	 $this -> assign("ALLOFFICE",			$this -> objectsHtml -> GetobjectHtml($this -> fields[all_oficina]));

     $this -> assign("GENERAR",				$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
	 $this -> assign("DESCARGAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descargar]));	
	 $this -> assign("DESCARGAR_CSV",			$this -> objectsHtml -> GetobjectHtml($this -> fields[descargar_csv]));	
     $this -> assign("CONDUCTOR",        $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor]));	 	 	 	 
     $this -> assign("CONDUCTORID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[conductor_id]));	 	 	 	 
	$this -> assign("OPCIONESCONDUCTOR",$this -> objectsHtml -> GetobjectHtml($this -> fields[opciones_conductor]));	 	 	
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

    public function SetTipo_nov($tipos){
	  $this -> fields[tipo_nov]['options'] = $tipos;
      $this -> assign("TIPO_NOV",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_nov]));
    }

    public function SetSi_Pro($Si_pro){
	  $this -> fields[si_cliente]['options'] = $Si_pro;
      $this -> assign("SI_CLI",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_cliente]));

	  $this -> fields[si_placa]['options'] = $Si_pro;
      $this -> assign("SI_PLA",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_placa]));
	  
    }


    public function RenderMain(){
      $this ->RenderLayout('Personalizado.tpl');
    }

}

?>