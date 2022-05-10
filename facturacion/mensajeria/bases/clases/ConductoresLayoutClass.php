<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class ConductoresLayout extends View{

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
   
   public function setImprimir($Permiso){
     $this -> Imprimir = $Permiso;
   }
   
   public function setCambioEstado($Permiso){
     $this -> CambiarEstado = $Permiso;   
   }
   
   public function setCampos($campos){

     require_once("../../../framework/clases/FormClass.php");
	 
	 $Form1 = new Form("ConductoresClass.php","ConductoresForm","ConductoresForm");	 	 
	 
	 $this -> fields = $campos;
	 
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/general.css");
     $this -> TplInclude -> IncludeCss("/velotax/transporte/bases/css/Conductores.css");
     $this -> TplInclude -> IncludeCss("/velotax/framework/css/jquery.alerts.css");
	 
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("/velotax/transporte/bases/js/Conductores.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jqeffects/jquery.magnifier.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("/velotax/framework/js/jquery.alerts.js"); 
	 
	  
     $this -> assign("CSSSYSTEM",	     $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	     $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		     $Form1 -> FormBegin());
     $this -> assign("FORM1END",	     $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	     $this -> getObjectHtml($this -> fields[busqueda]));
     $this -> assign("CONDUCTORID",	     $this -> getObjectHtml($this -> fields[conductor_id])); 
     $this -> assign("TERCEROID",	     $this -> getObjectHtml($this -> fields[tercero_id])); 
     $this -> assign("TIPOPERSONA",	     $this -> getObjectHtml($this -> fields[tipo_persona_id]));
     $this -> assign("TIPOIDENTIFICACION",   $this -> getObjectHtml($this -> fields[tipo_identificacion_id]));
     $this -> assign("NUMEROIDENTIFICACION", $this -> getObjectHtml($this -> fields[numero_identificacion])); 
     $this -> assign("LUGAREXPEDICION",      $this -> getObjectHtml($this -> fields[lugar_expedicion_cedula])); 
     $this -> assign("PRIMERAPELLIDO",	     $this -> getObjectHtml($this -> fields[primer_apellido]));
     $this -> assign("SEGUNDOAPELLIDO",	     $this -> getObjectHtml($this -> fields[segundo_apellido]));
     $this -> assign("PRIMERNOMBRE",	     $this -> getObjectHtml($this -> fields[primer_nombre]));
     $this -> assign("OTROSNOMBRES",	     $this -> getObjectHtml($this -> fields[segundo_nombre]));
     $this -> assign("DIRECCIONRESIDENCIA",  $this -> getObjectHtml($this -> fields[direccion]));
     $this -> assign("TIPOVIVIENDA",         $this -> getObjectHtml($this -> fields[tipo_vivienda]));
     $this -> assign("BARRIO",               $this -> getObjectHtml($this -> fields[barrio]));
     $this -> assign("UBICACION",	     $this -> getObjectHtml($this -> fields[ubicacion]));
     $this -> assign("UBICACIONID",	     $this -> getObjectHtml($this -> fields[ubicacion_id]));
     $this -> assign("TELEFONOFIJO",	     $this -> getObjectHtml($this -> fields[telefono]));
     $this -> assign("TELEFONOCELULAR",	     $this -> getObjectHtml($this -> fields[movil]));
     $this -> assign("ANTIGUEDADVIVIENDA",   $this -> getObjectHtml($this -> fields[tiempo_antiguedad_vivienda]));
     $this -> assign("FECHANACIMIENTO",	     $this -> getObjectHtml($this -> fields[fecha_nacimiento_cond]));
     $this -> assign("EDAD",	             $this -> getObjectHtml($this -> fields[edad]));
     $this -> assign("ESTATURA",	     $this -> getObjectHtml($this -> fields[estatura]));
     $this -> assign("TIPOSANGRE",	     $this -> getObjectHtml($this -> fields[tipo_sangre_id]));
     $this -> assign("SENALES",	             $this -> getObjectHtml($this -> fields[senales_particulares]));
     $this -> assign("CATEGORIALICENCIA",    $this -> getObjectHtml($this -> fields[categoria_id]));
     $this -> assign("NUMEROLICENCIA",	     $this -> getObjectHtml($this -> fields[numero_licencia_cond]));
     $this -> assign("VENCIMIENTOLICENCIA",  $this -> getObjectHtml($this -> fields[vencimiento_licencia_cond]));
     $this -> assign("NOMBRECOMPANERO",	     $this -> getObjectHtml($this -> fields[contacto_cond]));
     $this -> assign("PERSONASACARGO",	     $this -> getObjectHtml($this -> fields[personas_a_cargo]));
     $this -> assign("NUMEROHIJOS",	     $this -> getObjectHtml($this -> fields[numero_hijos]));
     $this -> assign("ARRENDATARIO",	     $this -> getObjectHtml($this -> fields[arrendatario]));
     $this -> assign("TELEFONOARRENDATARIO", $this -> getObjectHtml($this -> fields[telefono_arrendatario]));
     $this -> assign("TELEFONOCOMPANERO",    $this -> getObjectHtml($this -> fields[tel_contacto_cond]));
     $this -> assign("LIBRETAMILITAR",	     $this -> getObjectHtml($this -> fields[libreta_mil_cond]));
     $this -> assign("DISTRITOMILITAR",	     $this -> getObjectHtml($this -> fields[distrito_mil_cond]));
     $this -> assign("EPS",		     $this -> getObjectHtml($this -> fields[eps_cond]));
     $this -> assign("ARP",		     $this -> getObjectHtml($this -> fields[arp_cond]));
//      $this -> assign("ANTJUDICIALES",	     $this -> getObjectHtml($this -> fields[antecedente_judicial_cond]));
     $this -> assign("HUELLAINDICEIZQ",	     $this -> getObjectHtml($this -> fields[huellaindiceizq]));
     $this -> assign("HUELLAPULGARIZQ",	     $this -> getObjectHtml($this -> fields[huellapulgarizq]));
     $this -> assign("HUELLAPULGARDER",	     $this -> getObjectHtml($this -> fields[huellapulgarder]));
     $this -> assign("HUELLAINDICEDER",	     $this -> getObjectHtml($this -> fields[huellaindiceder]));
	 
	 
     $this -> assign("CARGAPRIMERAVEZ",	     $this -> getObjectHtml($this -> fields[carga_por_primera_vez]));	 
     $this -> assign("EMPRESACARGO1",	     $this -> getObjectHtml($this -> fields[empresa_cargo1]));
     $this -> assign("TELEFONOEMPRESACARGO1",$this -> getObjectHtml($this -> fields[telefono_empresa_cargo1]));
     $this -> assign("CIUDADEMPRESACARGO1TXT",$this -> getObjectHtml($this -> fields[ciudad_empresa_cargo1_txt]));
     $this -> assign("CIUDADEMPRESACARGO1",  $this -> getObjectHtml($this -> fields[ciudad_empresa_cargo1]));
     $this -> assign("NOMBREPERSONAATENDIO1",$this -> getObjectHtml($this -> fields[nombre_persona_atendio1]));
     $this -> assign("CARGOPERSONAATENDIO1", $this -> getObjectHtml($this -> fields[cargo_persona_atendio1]));
     $this -> assign("TIEMPOLLEVACARGANDO1", $this -> getObjectHtml($this -> fields[tiempo_lleva_cargando1]));
     $this -> assign("RUTAS1",               $this -> getObjectHtml($this -> fields[rutas1]));
     $this -> assign("TIPOMERCANCIA1",       $this -> getObjectHtml($this -> fields[tipo_mercancia1]));
     $this -> assign("VIAJESREALIZADOS1",    $this -> getObjectHtml($this -> fields[viajes_realizados1]));
     $this -> assign("EMPRESACARGO2",	     $this -> getObjectHtml($this -> fields[empresa_cargo2]));
     $this -> assign("TELEFONOEMPRESACARGO2",$this -> getObjectHtml($this -> fields[telefono_empresa_cargo2]));
     $this -> assign("CIUDADEMPRESACARGO2TXT",$this -> getObjectHtml($this -> fields[ciudad_empresa_cargo2_txt]));
     $this -> assign("CIUDADEMPRESACARGO2",  $this -> getObjectHtml($this -> fields[ciudad_empresa_cargo2]));
     $this -> assign("NOMBREPERSONAATENDIO2",$this -> getObjectHtml($this -> fields[nombre_persona_atendio2]));
     $this -> assign("CARGOPERSONAATENDIO2", $this -> getObjectHtml($this -> fields[cargo_persona_atendio2]));
     $this -> assign("TIEMPOLLEVACARGANDO2", $this -> getObjectHtml($this -> fields[tiempo_lleva_cargando2]));
     $this -> assign("RUTAS2",               $this -> getObjectHtml($this -> fields[rutas2]));
     $this -> assign("TIPOMERCANCIA2",       $this -> getObjectHtml($this -> fields[tipo_mercancia2]));
     $this -> assign("VIAJESREALIZADOS2",    $this -> getObjectHtml($this -> fields[viajes_realizados2]));
     $this -> assign("EMPRESACARGO3",	     $this -> getObjectHtml($this -> fields[empresa_cargo3]));
     $this -> assign("TELEFONOEMPRESACARGO3",$this -> getObjectHtml($this -> fields[telefono_empresa_cargo3]));
     $this -> assign("CIUDADEMPRESACARGO3TXT",$this -> getObjectHtml($this -> fields[ciudad_empresa_cargo3_txt]));
     $this -> assign("CIUDADEMPRESACARGO3",  $this -> getObjectHtml($this -> fields[ciudad_empresa_cargo3]));
     $this -> assign("NOMBREPERSONAATENDIO3",$this -> getObjectHtml($this -> fields[nombre_persona_atendio3]));
     $this -> assign("CARGOPERSONAATENDIO3", $this -> getObjectHtml($this -> fields[cargo_persona_atendio3]));
     $this -> assign("TIEMPOLLEVACARGANDO3", $this -> getObjectHtml($this -> fields[tiempo_lleva_cargando3]));
     $this -> assign("RUTAS3",               $this -> getObjectHtml($this -> fields[rutas3]));
     $this -> assign("TIPOMERCANCIA3",       $this -> getObjectHtml($this -> fields[tipo_mercancia3]));
     $this -> assign("VIAJESREALIZADOS3",    $this -> getObjectHtml($this -> fields[viajes_realizados3]));
     $this -> assign("REFERENCIA1",          $this -> getObjectHtml($this -> fields[referencia1]));
     $this -> assign("CIUDADREFERENCIA1TXT", $this -> getObjectHtml($this -> fields[ciudad_referencia1_txt]));
     $this -> assign("CIUDADREFERENCIA1",    $this -> getObjectHtml($this -> fields[ciudad_referencia1_id]));
     $this -> assign("TELEFONOREFERENCIA1",  $this -> getObjectHtml($this -> fields[telefono_referencia1]));
     $this -> assign("REFERENCIA2",          $this -> getObjectHtml($this -> fields[referencia2]));
     $this -> assign("CIUDADREFERENCIA2TXT", $this -> getObjectHtml($this -> fields[ciudad_referencia2_txt]));
     $this -> assign("CIUDADREFERENCIA2",    $this -> getObjectHtml($this -> fields[ciudad_referencia2_id]));
     $this -> assign("TELEFONOREFERENCIA2",  $this -> getObjectHtml($this -> fields[telefono_referencia2]));
     $this -> assign("REFERENCIA3",          $this -> getObjectHtml($this -> fields[referencia3]));
     $this -> assign("CIUDADREFERENCIA3TXT", $this -> getObjectHtml($this -> fields[ciudad_referencia3_txt]));
     $this -> assign("CIUDADREFERENCIA3",    $this -> getObjectHtml($this -> fields[ciudad_referencia3_id]));
     $this -> assign("TELEFONOREFERENCIA3",  $this -> getObjectHtml($this -> fields[telefono_referencia3]));
     $this -> assign("FOTO",		    $this -> getObjectHtml($this -> fields[foto]));
     $this -> assign("CEDULAESCAN",	    $this -> getObjectHtml($this -> fields[cedulaescan]));
     $this -> assign("LICENCIAESCAN",	    $this -> getObjectHtml($this -> fields[licenciaescan]));
     $this -> assign("EPSESCAN",	    $this -> getObjectHtml($this -> fields[epsescan]));
     $this -> assign("ARPESCAN",	    $this -> getObjectHtml($this -> fields[arpescan]));
	 
     
     if($this -> Guardar)
	   $this -> assign("GUARDAR",		$this -> getObjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",	$this -> getObjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",		$this -> getObjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",		$this -> getObjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Imprimir)	   
	   $this -> assign("IMPRIMIR",		$this -> getObjectHtml($this -> fields[imprimir]));	   
	   
   }
	
	//LISTA MENU
	
   public function setEstado(){
   
     if(!$this -> CambiarEstado) $this -> fields[estado][disabled] = 'true';
	 
     $this -> assign("ESTADO",	$this -> getObjectHtml($this -> fields[estado]));	   	        
   
   }	
	
   public function SetTiposId($TiposId){
     $this -> fields[tipo_identificacion_id][options] = $TiposId;
	 $this -> assign("TIPOIDENTIFICACION",	$this -> getObjectHtml($this -> fields[tipo_identificacion_id]));
   }

   public function SetGrupoSangre($GrupoSangre){
   	 $this -> fields[tipo_sangre_id]['options'] = $GrupoSangre;
     $this -> assign("TIPOSANGRE",			$this -> getObjectHtml($this -> fields[tipo_sangre_id]));
   }

   public function SetCategoriaLic($CategoriaLic){
   	 $this -> fields[categoria_id]['options'] = $CategoriaLic;
     $this -> assign("CATEGORIALICENCIA",	$this -> getObjectHtml($this -> fields[categoria_id]));
   }
   
   public function SetEstadoCivil($EstadoCivil){
   	 $this -> fields[estado_civil_id]['options'] = $EstadoCivil;
     $this -> assign("ESTADOCIVIL",			$this -> getObjectHtml($this -> fields[estado_civil_id]));
   }
	
	//// GRID ////
   public function SetGridConductores($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php"); 
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
     $this -> assign("GRIDCONDUCTORES",	$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",	$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",		$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('conductor.tpl');
	 
   }


}


?>