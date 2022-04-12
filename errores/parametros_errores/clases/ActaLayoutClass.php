<?php
require_once("../../../framework/clases/ViewClass.php");
final class ActaLayout extends View{
   private $fields;
   private $Guardar;
   private $Actualizar;
   private $Borrar;
   private $Limpiar;
   
   public function setGuardar($Permiso){
	 $this -> Guardar = $Permiso;
   }
   
   public function setActualizar($Permiso){
	 $this -> Actualizar = $Permiso;
   }  
   
   public function setImprimir($Permiso)
    {
        $this->Imprimir = $Permiso;
    }
   
   public function setBorrar($Permiso){
	 $this -> Borrar = $Permiso;
   }      
   
   public function setLimpiar($Permiso){
	 $this -> Limpiar = $Permiso;
   }   
   
   public function setCampos($campos){
     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1      = new Form("ActaClass.php","ActaForm","ActaForm");
	 
	 $this -> fields = $campos;
	
	 $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css"); 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
	 $this -> TplInclude -> IncludeCss("../../../framework/css/jqgrid/ui.jqgrid.css");
 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
 
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
	 //$this -> TplInclude -> IncludeJs("/talpaprueba/framework/js/generalterceros.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
	 $this -> TplInclude -> IncludeJs("../js/Acta.js");
	 $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");
	 
	 $this -> assign("CSSSYSTEM",$this -> TplInclude -> GetCssInclude());
	 $this -> assign("JAVASCRIPT",$this -> TplInclude -> GetJsInclude());
	 $this -> assign("FORM1",$Form1 -> FormBegin());
	 $this -> assign("FORM1END",$Form1 -> FormEnd());
	 $this -> assign("BUSQUEDA",$this -> objectsHtml -> GetobjectHtml($this -> fields[busqueda]));
	 $this -> assign("ACTAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[acta_id]));
	 $this -> assign("FECHA",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fecha_acta]));
	 $this -> assign("NOMBRE",$this -> objectsHtml -> GetobjectHtml($this -> fields[nombre_acta]));		 	 
	 $this -> assign("CLIENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));
	 $this -> assign("CLIENTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));		 	 	 
	 $this -> assign("UBICACIONID",$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion_id]));
	 $this -> assign("UBICACION",$this -> objectsHtml -> GetobjectHtml($this -> fields[ubicacion]));
	 $this -> assign("ASUNTO",$this -> objectsHtml -> GetobjectHtml($this -> fields[asunto]));
	 $this -> assign("USUARIOREGISTRA",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_registra]));
	 $this -> assign("USUARIOACTUALIZA",$this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_actualiza]));
			
	 if($this -> Guardar)
	   $this -> assign("GUARDAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar){
	   $this -> assign("ACTUALIZAR",$this -> objectsHtml -> GetobjectHtml($this -> fields[actualizar]));
	   $this -> assign("ENVIOMAIL",$this -> objectsHtml -> GetobjectHtml($this -> fields[envio_mail]));
	}
	
	if($this->Imprimir)
		$this->assign("IMPRIMIR", $this->objectsHtml->GetobjectHtml($this->fields[imprimir]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[limpiar]));
   }

   public function setPQR($pqr_id){
	$this -> fields[pqr_id]['options'] = $pqr_id;
	$this -> assign("PQRID",$this -> objectsHtml -> GetobjectHtml($this -> fields[pqr_id]));	   
  }  
	       
   public function SetGridActa($Attributes,$Titles,$Cols,$Query){
	 require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 $head = "'<head>".
	 
	 $TableGrid -> GetJqGridJs()." ".
	 
	 $TableGrid -> GetJqGridCss()."
	 
	 </head>";
	 
	 $body = "<body>".$TableGrid -> RenderJqGrid()."</body>";
	 
	 return "<html>".$head." ".$body."</html>";
   }
	 
   public function RenderMain(){
	 $this ->RenderLayout('Acta.tpl');
   }
}
?>