<?php
require_once("../../../framework/clases/ViewClass.php"); 

final class ReporteGuiasLayout extends View{

   private $fields;
   
   public function SetImprimir($Permiso){
  	 $this -> Imprimir = $Permiso;
   } 
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
     $Form1 = new Form("ReporteGuiasClass.php","ReporteGuiasForm","ReporteGuiasForm");
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");	 	 
     $this -> TplInclude -> IncludeCss("/velotax/mensajeria/reportes/css/reportes.css");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/mensajeria/reportes/js/ReporteGuias.js"); 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funcionesDetalle.js");	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js");		 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqeffects/jquery.magnifier.js");
	 $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
	 
     $this -> assign("CSSSYSTEM",	    $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	    $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		    $Form1 -> FormBegin());
     $this -> assign("FORM1END",	    $Form1 -> FormEnd());    
     $this -> assign("ORIGEN",         	$this -> objectsHtml -> GetobjectHtml($this -> fields[origen]));     
     $this -> assign("ORIGENID",       	$this -> objectsHtml -> GetobjectHtml($this -> fields[origen_id]));     
     $this -> assign("DESTINO",        	$this -> objectsHtml -> GetobjectHtml($this -> fields[destino]));
     $this -> assign("DESTINOID",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[destino_id]));    
     $this -> assign("ESTADO",         	$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_id]));
 	 $this -> assign("ALLESTADO",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[all_estado]));
	 $this -> assign("TIP_SERV",        $this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_mensajeria_id]));
 	 $this -> assign("ALLSERV",	   		$this -> objectsHtml -> GetobjectHtml($this -> fields[all_servicio]));	 
     $this -> assign("OFICINA",         $this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
 	 $this -> assign("ALLOFICINA",	   	$this -> objectsHtml -> GetobjectHtml($this -> fields[all_oficina]));
	 $this -> assign("DESTINATARIO",        	$this -> objectsHtml -> GetobjectHtml($this -> fields[destinatario]));  
     $this -> assign("DESTINATARIOID",      	$this -> objectsHtml -> GetobjectHtml($this -> fields[destinatario_id]));
	 $this -> assign("REMITENTE",        	$this -> objectsHtml -> GetobjectHtml($this -> fields[remitente]));  
     $this -> assign("REMITENTEID",      	$this -> objectsHtml -> GetobjectHtml($this -> fields[remitente_id]));
	 $this -> assign("USUARIO",        $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario]));  
     $this -> assign("USUARIOID",      $this -> objectsHtml -> GetobjectHtml($this -> fields[usuario_id]));
     $this -> assign("DESDE",          	$this -> objectsHtml -> GetobjectHtml($this -> fields[desde]));       
     $this -> assign("HASTA",          	$this -> objectsHtml -> GetobjectHtml($this -> fields[hasta]));     
	 
	 $this -> assign("GENERAR",			$this -> objectsHtml -> GetobjectHtml($this -> fields[generar]));	
	 $this -> assign("GENERAREXCEL",	$this -> objectsHtml -> GetobjectHtml($this -> fields[generar_excel]));	
	 $this -> assign("EXCELFORMATO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[excel_formato]));
	 $this -> assign("EXCELFILTRADO",	$this -> objectsHtml -> GetobjectHtml($this -> fields[excel_formato1]));
	 $this -> assign("FOTOS",	$this -> objectsHtml -> GetobjectHtml($this -> fields[fotos]));
	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));
   }

//LISTA MENU
    public function SetOficina($oficina){
	  $this -> fields[oficina_id]['options'] = $oficina;
      $this -> assign("OFICINA",$this -> objectsHtml -> GetobjectHtml($this -> fields[oficina_id]));
    }
	
	public function SetSi_Usu($Si_Usu){ 
	  $this -> fields[si_usuario]['options'] = $Si_Usu;
      $this -> assign("SI_USU",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_usuario]));
    }

   /* public function setCliente($datos){
	  $this -> fields[cliente_id]['value'] = $datos[0]['cliente_id'];
      $this -> assign("CLIENTEID",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente_id]));

	  $this -> fields[cliente]['value'] = $datos[0]['cliente'];
      $this -> assign("CLIENTE",$this -> objectsHtml -> GetobjectHtml($this -> fields[cliente]));

    }*/

    public function SetSi_Des($Si_des){
	  $this -> fields[si_destinatario]['options'] = $Si_des;
      $this -> assign("SI_DES",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_destinatario]));
    }
	
	public function SetSi_Rem($Si_rem){
	  $this -> fields[si_remitente]['options'] = $Si_rem;
      $this -> assign("SI_REM",$this -> objectsHtml -> GetobjectHtml($this -> fields[si_remitente]));
    }

    public function SetEstado($estado){
    $this -> fields[estado_id]['options'] = $estado;
      $this -> assign("ESTADO",$this -> objectsHtml -> GetobjectHtml($this -> fields[estado_id]));
    }
	
	public function SetServicio($servicio){
    $this -> fields[tipo_servicio_mensajeria_id]['options'] = $servicio;
      $this -> assign("TIP_SERV",$this -> objectsHtml -> GetobjectHtml($this -> fields[tipo_servicio_mensajeria_id]));
    }
	
   public function RenderMain(){   
     $this -> RenderLayout('ReporteGuias.tpl');	 
   }
}

?>