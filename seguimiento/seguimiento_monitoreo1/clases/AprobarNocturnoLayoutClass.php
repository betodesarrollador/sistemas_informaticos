<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class AprobarNocturnoLayout extends View{

   private $fields;
   
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("AprobarNocturnoClass.php","AprobarNocturnoForm","AprobarNocturnoForm");	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/AprobarNocturno.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");	
 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/seguimiento_monitoreo/js/AprobarNocturno.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 	
	 
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
     $this -> assign("FORM1",			  $Form1 -> FormBegin());
     $this -> assign("FORM1END",		  $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		  $this -> getObjectHtml($this -> fields[busqueda]));
     $this -> assign("TRAFICOID",	  	  $this -> getObjectHtml($this -> fields[trafico_id]));
  	 $this -> assign("TRAFICONOCID",  	  $this -> getObjectHtml($this -> fields[trafico_nocturno_id]));	 
     $this -> assign("NUMERO",			  $this -> getObjectHtml($this -> fields[numero]));
     $this -> assign("FECHA",			  $this -> getObjectHtml($this -> fields[fecha]));
	 $this -> assign("AGENCIA",			  $this -> getObjectHtml($this -> fields[agencia]));
     $this -> assign("PLACA",			  $this -> getObjectHtml($this -> fields[placa]));
     $this -> assign("MARCA",		  	  $this -> getObjectHtml($this -> fields[marca]));
     $this -> assign("COLOR",		  	  $this -> getObjectHtml($this -> fields[color]));
	 $this -> assign("LINKGPS",			  $this -> getObjectHtml($this -> fields[link_gps]));
     $this -> assign("USUARIOGPS",		  $this -> getObjectHtml($this -> fields[usuario_gps]));
     $this -> assign("CLAVEGPS",		  $this -> getObjectHtml($this -> fields[clave_gps]));
	 $this -> assign("CONDUCTOR",		  $this -> getObjectHtml($this -> fields[conduct]));
  	 $this -> assign("CATEGORIA",		  $this -> getObjectHtml($this -> fields[categoria]));	 
	 
     $this -> assign("CELULAR",	  		  $this -> getObjectHtml($this -> fields[celular]));
     $this -> assign("ESCOLTARECIBE",	  $this -> getObjectHtml($this -> fields[escolta_recibe]));
  	 $this -> assign("ESCOLTAENTREGA",    $this -> getObjectHtml($this -> fields[escolta_entrega]));
  	 $this -> assign("ORIGEN",      	  $this -> getObjectHtml($this -> fields[origen]));
  	 $this -> assign("DESTINO",			  $this -> getObjectHtml($this -> fields[destino]));
  	 $this -> assign("FECHAINI",		  $this -> getObjectHtml($this -> fields[fecha_inicial_salida]));
  	 $this -> assign("HORAINI",		  	  $this -> getObjectHtml($this -> fields[hora_inicial_salida]));	 
	 
	 $this -> assign("RUTAS",		  	  $this -> getObjectHtml($this -> fields[ruta]));	
	 $this -> assign("AUTORIZA",		  $this -> getObjectHtml($this -> fields[autoriza_nocturno]));		
	 
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> getObjectHtml($this -> fields[actualizar]));
	   
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> getObjectHtml($this -> fields[limpiar]));
   }

//LISTA MENU

 	public function SetNocturno($Nocturno){
     $this -> fields[t_nocturno][options] = $Nocturno;
	 $this -> assign("NOCTURNO",$this -> GetObjectHtml($this -> fields[t_nocturno]));

   }
   public function SetEstadoSeg($EstadoSeg){
     $this -> fields[estado][options] = $EstadoSeg;
	 $this -> assign("ESTADO",$this -> GetObjectHtml($this -> fields[estado]));
   } 
   public function SetAprobar($Aprobar){
     $this -> fields[autoriza_nocturno][options] = $Aprobar;
	 $this -> assign("AUTORIZAR",$this -> GetObjectHtml($this -> fields[autoriza_nocturno]));
   } 
   



   public function RenderMain(){
        $this -> RenderLayout('AprobarNocturno.tpl');
	 
   }
}


?>