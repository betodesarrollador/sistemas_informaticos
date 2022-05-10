<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class Imp_HV_ConductorLayout extends View{

   private $fields;

   
   public function setIncludes(){
   
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/bases/css/Imp_HV_Conductor.css");
	 
	 $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css","print");
     $this -> TplInclude -> IncludeCss("../../../transporte/bases/css/Imp_HV_Conductor.css","print");	 
	 
	 $this -> assign("CSSSYSTEM", $this -> TplInclude -> GetCssInclude());
	 
   }
  
   
   public function setConductor($conductor){

     $this -> assign("NOMBRE1",              $conductor[0]['primer_nombre']);
     $this -> assign("NOMBRE2",              $conductor[0]['segundo_nombre']);
     $this -> assign("APELLIDO1",            $conductor[0]['primer_apellido']);
     $this -> assign("APELLIDO2",            $conductor[0]['segundo_apellido']);
     $this -> assign("TIPOID",               $conductor[0]['tipo_identificacion']);
	  $this -> assign("NUMEROID",             $conductor[0]['numero_identificacion']);
     $this -> assign("EXPEDIDAEN",           $conductor[0]['lugar_expedicion_cedula']);
     $this -> assign("FECHA",                date("Y-m-d"));
     $this -> assign("FECHANAC",             $conductor[0]['fecha_nacimiento_cond']);
     $this -> assign("EDAD",                 $conductor[0]['edad']);
     $this -> assign("ESTATURA",             $conductor[0]['estatura']);
     $this -> assign("TIPOSANGRE",           $conductor[0]['tipo_sangre']);
     $this -> assign("SENALES",              $conductor[0]['senales_particulares']);
     $this -> assign("ANTECEDENTES",         $conductor[0]['antecedente_judicial_cond']);
     $this -> assign("LIBRETA",              $conductor[0]['libreta_mil_cond']);
     $this -> assign("EPS",                  $conductor[0]['eps_cond']);
     $this -> assign("ARP",                  $conductor[0]['arp_cond']);
     $this -> assign("LICENCIA",             $conductor[0]['numero_licencia_cond']);
     $this -> assign("CATEGORIA",            $conductor[0]['categoria']);
	  $this -> assign("DIRECCION",            $conductor[0]['direccion']);
     $this -> assign("VENLICEN",             $conductor[0]['vencimiento_licencia_cond']);		
     $this -> assign("UBICACION",            $conductor[0]['ubicacion']);		
     $this -> assign("TIPOVIV",              $conductor[0]['tipo_vivienda']);		
     $this -> assign("BARRIO",               $conductor[0]['barrio']);		
     $this -> assign("TELEFONO",             $conductor[0]['telefono']);		
     $this -> assign("MOVIL",                $conductor[0]['movil']);		
     $this -> assign("ANTIGUEDAD",           $conductor[0]['tiempo_antiguedad_vivienda']);		
     $this -> assign("ESTADOCIVIL",          $conductor[0]['estado_civil']);		
     $this -> assign("CONTACTOCOND",         $conductor[0]['contacto_cond']);		
     $this -> assign("PERSONASCARGO",        $conductor[0]['personas_a_cargo']);		
     $this -> assign("NUMEROHIJOS",          $conductor[0]['numero_hijos']);		
     $this -> assign("ARENDATARIO",          $conductor[0]['arrendatario']);		
     $this -> assign("TELEFONO",             $conductor[0]['telefono']);
     $this -> assign("EMPRESACARGO1",        $conductor[0]['empresa_cargo1']);
     $this -> assign("TELEFONOCARGO1",       $conductor[0]['telefono_empresa_cargo1']);
     $this -> assign("PERSONACARGO1",        $conductor[0]['nombre_persona_atendio1']);
     $this -> assign("CARGOCARGO1",          $conductor[0]['cargo_persona_atendio1']);
     $this -> assign("TIEMPOCARGO1",         $conductor[0]['tiempo_lleva_cargando1']);
     $this -> assign("RUTASCARGO1",          $conductor[0]['rutas1']);
     $this -> assign("TIPOMERCANCIACARGO1",  $conductor[0]['tipo_mercancia1']);
    $this -> assign("VIAJESREALIZADOSCARGO1",$conductor[0]['viajes_realizados1']);
     $this -> assign("CIUDADEMPRESACARGO1",  $conductor[0]['ciudad_empresa_cargo1']);
     $this -> assign("EMPRESACARGO2",        $conductor[0]['empresa_cargo2']);
     $this -> assign("TELEFONOCARGO2",       $conductor[0]['telefono_empresa_cargo2']);
     $this -> assign("PERSONACARGO2",        $conductor[0]['nombre_persona_atendio2']);
     $this -> assign("CARGOCARGO2",          $conductor[0]['cargo_persona_atendio2']);
     $this -> assign("TIEMPOCARGO2",         $conductor[0]['tiempo_lleva_cargando2']);
     $this -> assign("RUTASCARGO2",          $conductor[0]['rutas2']);
     $this -> assign("TIPOMERCANCIACARGO2",  $conductor[0]['tipo_mercancia2']);
    $this -> assign("VIAJESREALIZADOSCARGO2",$conductor[0]['viajes_realizados2']);
     $this -> assign("CIUDADEMPRESACARGO2",  $conductor[0]['ciudad_empresa_cargo2']);
     $this -> assign("EMPRESACARGO3",        $conductor[0]['empresa_cargo3']);
     $this -> assign("TELEFONOCARGO3",       $conductor[0]['telefono_empresa_cargo3']);
     $this -> assign("PERSONACARGO3",        $conductor[0]['nombre_persona_atendio3']);
     $this -> assign("CARGOCARGO3",          $conductor[0]['cargo_persona_atendio3']);
     $this -> assign("TIEMPOCARGO3",         $conductor[0]['tiempo_lleva_cargando3']);
     $this -> assign("RUTASCARGO3",          $conductor[0]['rutas3']);
     $this -> assign("TIPOMERCANCIACARGO3",  $conductor[0]['tipo_mercancia3']);
    $this -> assign("VIAJESREALIZADOSCARGO3",$conductor[0]['viajes_realizados3']);
     $this -> assign("CIUDADEMPRESACARGO3",  $conductor[0]['ciudad_empresa_cargo3']);
     $this -> assign("REFERENCIA1",          $conductor[0]['referencia1']);
     $this -> assign("CIUDADREFERENCIA1",    $conductor[0]['ciudad_referencia1_id']);
     $this -> assign("TELEFONOREFERENCIA1",  $conductor[0]['telefono_referencia1']);
     $this -> assign("REFERENCIA2",          $conductor[0]['referencia2']);
     $this -> assign("CIUDADREFERENCIA2",    $conductor[0]['ciudad_referencia2_id']);
     $this -> assign("TELEFONOREFERENCIA2",  $conductor[0]['telefono_referencia2']);
     $this -> assign("REFERENCIA3",          $conductor[0]['referencia3']);
     $this -> assign("CIUDADREFERENCIA3",    $conductor[0]['ciudad_referencia3_id']);
     $this -> assign("TELEFONOREFERENCIA3",  $conductor[0]['telefono_referencia3']);
	  $this -> assign("NOMBRE_USUARIO",       $conductor[0]['nombre_usuario']);
	  $this -> assign("CIUDAD",               $conductor[0]['ciudad_oficina']);
	  $this -> assign("LOGO",                 $conductor[0]['logo']);

	        	
     $this -> assign("FOTO",     $conductor[0]['foto']);
     $this -> assign("HUELLA1",  $conductor[0]['huellaindiceizq']);
     $this -> assign("HUELLA2",  $conductor[0]['huellapulgarizq']);
     $this -> assign("HUELLA3",  $conductor[0]['huellapulgarder']);
     $this -> assign("HUELLA4",  $conductor[0]['huellaindiceder']);
   
   }
  
   public function RenderMain(){

      $numero_identificacion = $_REQUEST['numero_identificacion'];
      //$this -> exportToPdf('Imp_HV_Conductor.tpl',"$numero_identificacion");
	 
      $this -> RenderLayout('Imp_HV_Conductor.tpl');

   }


}

?>