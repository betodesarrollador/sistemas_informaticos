<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_ExtrasLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../css/Imp_Extras.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../css/Imp_Extras.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }  
   
  public function setextras($extras){

	 $this -> assign("LOGO",$extras[0]['logo']);
	 $this -> assign("EMPLEADO",$extras[0]['empleado']);
     $this -> assign("EXTRAID",$extras[0]['hora_extra_id']);	 
     $this -> assign("IDENTIFICACION",$extras[0]['identificacion']);
	 $this -> assign("FECHA_INI",$extras[0]['fecha_inicial']);
     $this -> assign("FECHA_FIN",$extras[0]['fecha_final']);
     $this -> assign("EXTRASD",$extras[0]['horas_diurnas']);
     $this -> assign("VREXTRASD",$extras[0]['vr_horas_diurnas']);	 
     $this -> assign("EXTRASN",$extras[0]['horas_nocturnas']);
     $this -> assign("VREXTRASN",$extras[0]['vr_horas_nocturnas']);	 
     $this -> assign("EXTRASDF",$extras[0]['horas_diurnas_fes']);
     $this -> assign("VREXTRASDF",$extras[0]['vr_horas_diurnas_fes']);	 
     $this -> assign("EXTRASNF",$extras[0]['horas_nocturnas_fes']);
     $this -> assign("VREXTRASNF",$extras[0]['vr_horas_nocturnas_fes']);	 
	 $this -> assign("HORARECARGO",$extras[0]['horas_recargo_noc']);
	 $this -> assign("HORADOCFEST",$extras[0]['horas_recargo_doc']);
	 $this -> assign("VRHORARECARGO",$extras[0]['vr_horas_recargo_noc']);	 
	 $this -> assign("VRHORADOCFEST",$extras[0]['vr_horas_recargo_doc']);	 
	 $this -> assign("NOMBRE_EMP",$extras[0]['razon_social_emp']);
	 $this -> assign("NUMEROID",$extras[0]['numero_identificacion_emp']);
	 $this -> assign("DIRECCION",$extras[0]['direccion_emp']);
	 $this -> assign("CIUDAD",$extras[0]['ciudad_emp']);

     //$this -> assign("SUELDO_BASE",$extras[0]['sueldo_base']);
     //$this -> assign("FECHA_INICIO",$extras[0]["fecha_inicio"]);   
	 //$this -> assign("REPRESENTANTE_LEGAL",$extras[0]["representante_legal"]);  
	 //$this -> assign("NUMERO_CONTRATO",$contrato[0]["numero_contrato"]);   
   
   }
   
   public function setTotal($total){  
     $this -> assign("TOTAL",$total[0]);       
   }
  
   public function RenderMain(){

      //$numero_identificacion = $_REQUEST['numero_identificacion'];
      //$this -> exportToPdf('Imp_contrato.tpl',"$numero_identificacion");
	 
      $this -> RenderLayout('Imp_Extras.tpl');

   }


}

?>