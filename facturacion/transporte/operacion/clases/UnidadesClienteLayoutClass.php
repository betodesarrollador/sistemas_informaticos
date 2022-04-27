<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class UnidadesClienteLayout extends View{

   private $fields;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("UnidadesClienteClass.php","UnidadesClienteForm","UnidadesClienteForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/operacion/css/solicitud_servicios.css");	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/swfobject.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery-uploader/jquery.uploadify.v2.1.0.min.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/operacion/js/UnidadesCliente.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
     $this -> assign("CSSSYSTEM",	 $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	 $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		 $Form1 -> FormBegin());
     $this -> assign("FORM1END",	 $Form1 -> FormEnd());
     $this -> assign("ARCHIVOSOLICITUD",$this -> objectsHtml -> GetobjectHtml($this -> fields[archivo_solicitud]));            
     
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
     
     
   }

//LISTA MENU

   public function setClientes($clientes){

     $this -> fields[cliente_id][options] = $clientes;
     $this->assign("CLIENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	   
   }


   public function RenderMain(){
      
        $this -> RenderLayout('UnidadesCliente.tpl');
	 
   }


}


?>