<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class DetalleSeguimientoLayout extends View{

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
   
   public function setDetallesSeguimiento($detallesSeguimiento){
   
     $this -> assign("DETALLESSEGUIMIENTO",$detallesSeguimiento);	  
   
   } 
   
   public function setFechaHoraSalida($fecha,$hora,$FechaHoraSalida){
   
     $this -> assign("FECHASALIDA",$FechaHoraSalida[0]['fecha_inicial_salida']);
	 $this -> assign("HORASALIDA",$FechaHoraSalida[0]['hora_inicial_salida']);

     $this -> assign("FECHAACTUAL",$fecha);
	 $this -> assign("HORAACTUAL",$hora);

   }   

   public function setNovedad($Novedad){
   
     $this -> assign("NOVEDAD",$Novedad);
   
   }   

   public function setCausal($Novedad){
   
     $this -> assign("CAUSAL",$Novedad);
   
   }   

   public function setRemesa($Remesas){
   
     $this -> assign("REMESAS",$Remesas);
   
   }   

   public function setIncludes(){
	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/roa/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/roa/seguimiento/seguimiento_monitoreo/css/detalle_seguimiento.css");	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.autocomplete.css");	 	 
     $this -> TplInclude -> IncludeCss("/roa/framework/css/jquery.alerts.css");		 
	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.autocomplete.js");	
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.tablednd.js");	 
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/funcionesDetalle.js");
     $this -> TplInclude -> IncludeJs("/roa/seguimiento/seguimiento_monitoreo/js/detalle_seguimiento.js");
     $this -> TplInclude -> IncludeJs("/roa/framework/js/jquery.alerts.js");	 		 
	  	  
	 $this -> assign("CSSSYSTEM",	  $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	  $this -> TplInclude -> GetJsInclude());
     $this -> assign("TRAFICOID", 	  $_REQUEST['trafico_id']);	 

   }

   public function RenderMain(){
   
        $this -> RenderLayout('DetalleSeguimiento.tpl');
	 
   }


}


?>