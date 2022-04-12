<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class RegistroNovedadesLayout extends View{

   private $fields;
   
   
   public function setActualizar($Permiso){
   	 $this -> Actualizar = $Permiso;
   }
   
   
   public function setLimpiar($Permiso){
  	 $this -> Limpiar = $Permiso;
   }
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }
   public function SetAnular($Permiso){
  	 $this -> Anular = $Permiso;
   }   
   
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("RegistroNovedadesClass.php","RegistroNovedadesForm","RegistroNovedadesForm");	 	 
	 
	 $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/DatosBasicos.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/RegistroNovedades.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");	
 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
	 $this -> TplInclude ->  IncludeCss("/roa/framework/css/jqgrid/redmond/jquery-ui-1.8.2.custom.css");
	 $this -> TplInclude ->  IncludeJs("/roa/framework/js/jqgrid/jquery-ui-1.8.2.custom.min.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/seguimiento_monitoreo/js/RegistroNovedades.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 	
	 
	 
     $this -> assign("CSSSYSTEM",		  $this -> TplInclude -> getCssInclude());
     $this -> assign("JAVASCRIPT",		  $this -> TplInclude -> getJsInclude());
     $this -> assign("FORM1",			  $Form1 -> FormBegin());
     $this -> assign("FORM1END",		  $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",		  $this -> getObjectHtml($this -> fields[busqueda]));
     $this -> assign("TRAFICOID",	  	  $this -> getObjectHtml($this -> fields[trafico_id]));
     $this -> assign("NUMERO",			  $this -> getObjectHtml($this -> fields[numero]));
     $this -> assign("FECHA",			  $this -> getObjectHtml($this -> fields[fecha]));
	 
     $this -> assign("APROB_MIN",		  $this -> getObjectHtml($this -> fields[aprobacion_min]));
     $this -> assign("FECHA_APROB_MIN",	  $this -> getObjectHtml($this -> fields[fecha_aprob_min]));
	 
     $this -> assign("CLIENTES",		  $this -> getObjectHtml($this -> fields[clientes]));	 
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
     $this -> assign("ESCOLTARECIBEID",	  $this -> getObjectHtml($this -> fields[apoyo_id_recibe]));
  	 $this -> assign("ESCOLTAENTREGAID",  $this -> getObjectHtml($this -> fields[apoyo_id_entrega]));
	 $this ->  assign("NOTACONTROLADOR",  $this -> getObjectHtml($this -> fields[nota_controlador]));
	 $this ->  assign("GUARDARNOTA",	  $this -> getObjectHtml($this -> fields[guardar_nota]));
	 
  	 $this -> assign("ORIGEN",      	  $this -> getObjectHtml($this -> fields[origen]));
  	 $this -> assign("DESTINO",			  $this -> getObjectHtml($this -> fields[destino]));
  	 $this -> assign("FECHAINI",		  $this -> getObjectHtml($this -> fields[fecha_inicial_salida]));
  	 $this -> assign("HORAINI",		  	  $this -> getObjectHtml($this -> fields[hora_inicial_salida]));	 
	 
	 $this -> assign("RUTAS",		  	  $this -> getObjectHtml($this -> fields[ruta_id]));	
	 $this -> assign("RUTAHIDDEN",		  $this -> getObjectHtml($this -> fields[rutahidden]));	
	 $this -> assign("ESTADOHIDDEN",	  $this -> getObjectHtml($this -> fields[estadohidden]));	
	 
	 $this -> assign("FRECUENCIA",	  $this -> getObjectHtml($this -> fields[frecuencia]));	
	 

	 /***********************
	     Anulacion Registro
	 ***********************/
	 
	 $this -> assign("FECHALOG",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_trafico]));	   
	 $this -> assign("OBSERVACIONES",$this -> objectsHtml -> GetobjectHtml($this -> fields[desc_anul_trafico]));	   	 

	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> getObjectHtml($this -> fields[actualizar]));

	 if($this -> Anular)
	   $this -> assign("ANULAR",	$this -> objectsHtml -> GetobjectHtml($this -> fields[anular]));	   

	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",	$this -> getObjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Imprimir)	   
   	   $this -> assign("IMPRIMIR",$this -> objectsHtml -> GetobjectHtml($this -> fields[imprimir]));	   
	   
   	   $this -> assign("PASARURBANO",$this -> objectsHtml -> GetobjectHtml($this -> fields[mover_a_urbano]));	   	   
	   
	   //-----------------------Regresar a trafico-------------------------//
	   $this -> assign("REGRESARTRAFICO",$this -> objectsHtml -> GetobjectHtml($this -> fields[regresar_trafico]));
	   //-----------------------Regresar a trafico-------------------------//
	   
	   
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
   
   public function setCausalesAnulacion($causales){
	 $this -> fields[causal_anulacion_id]['options'] = $causales;
     $this -> assign("CAUSALESID",$this -> objectsHtml -> GetobjectHtml($this -> fields[causal_anulacion_id]));	  	   
   }

   public function setUsuarioId($usuario,$oficina){
	 $this -> fields[anul_usuario_id]['value'] = $usuario;
     $this -> assign("ANULUSUARIOID",$this -> objectsHtml -> GetobjectHtml($this -> fields[anul_usuario_id]));	  
	 
	 
   }   



   public function RenderMain(){
        $this -> RenderLayout('RegistroNovedades.tpl');
	 
   }
}


?>