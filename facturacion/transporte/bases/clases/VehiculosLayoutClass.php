<?php

require_once("../../../framework/clases/ViewClass.php"); 

final class VehiculosLayout extends View{

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
	 
     $Form1 = new Form("VehiculosClass.php","VehiculosForm","VehiculosForm",$this -> actividad_id); 	 
	 
     $this -> fields = $campos; 
	 
     $this -> TplInclude -> IncludeCss("../../../framework/css/ajax-dynamic-list.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/reset.css");
     $this -> TplInclude -> IncludeCss("../../../framework/css/general.css");
     $this -> TplInclude -> IncludeCss("../../../transporte/bases/css/Vehiculos.css"); 
     $this -> TplInclude -> IncludeCss("../../../framework/css/jquery.alerts.css");	
	 
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqcalendar/jquery.ui.datepicker-es.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jqueryform.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.filestyle.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/funciones.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-list.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/ajax-dynamic-list.js");
     $this -> TplInclude -> IncludeJs("../../../transporte/bases/js/Vehiculos.js");
     $this -> TplInclude -> IncludeJs("../../../framework/js/jquery.alerts.js");	 	
	 
     $this -> assign("CSSSYSTEM",	              $this -> TplInclude -> GetCssInclude());
     $this -> assign("JAVASCRIPT",	            $this -> TplInclude -> GetJsInclude());
     $this -> assign("FORM1",		                $Form1 -> FormBegin());
     $this -> assign("FORM1END",	              $Form1 -> FormEnd());
     $this -> assign("BUSQUEDA",	              $this -> getObjectHtml($this -> fields[busqueda]));
     $this -> assign("PLACA",		                $this -> getObjectHtml($this -> fields[placa]));
     $this -> assign("PLACAID",		              $this -> getObjectHtml($this -> fields[placa_id]));
     $this -> assign("EMPRESAID",	              $this -> getObjectHtml($this -> fields[empresa_id]));
     $this -> assign("EMPRESAIDSTATIC",	        $this -> getObjectHtml($this -> fields[empresa_id_static]));
     $this -> assign("NUMEROEJES",	            $this -> getObjectHtml($this -> fields[numero_ejes]));
     $this -> assign("MARCA",		                $this -> getObjectHtml($this -> fields[marca]));
     $this -> assign("MARCAID",		              $this -> getObjectHtml($this -> fields[marca_id]));
     $this -> assign("PLACAREMOLQUE",	          $this -> getObjectHtml($this -> fields[placa_remolque]));
     $this -> assign("PLACAREMOLQUEID",	        $this -> getObjectHtml($this -> fields[placa_remolque_id]));
     $this -> assign("MARCAREMOLQUE",	          $this -> getObjectHtml($this -> fields[marca_remolque]));
     $this -> assign("MODELOREMOLQUE",	        $this -> getObjectHtml($this -> fields[modelo_remolque]));
     $this -> assign("TIPOREMOLQUE",	          $this -> getObjectHtml($this -> fields[tipo_remolque]));
     $this -> assign("EMPRESAAFILIADOVEHICULO", $this -> getObjectHtml($this -> fields[empresa_afiliado]));
     $this -> assign("NUMEROCARNET",            $this -> getObjectHtml($this -> fields[numero_carnet]));
     $this -> assign("VENCIMIENTOAFILIACION",   $this -> getObjectHtml($this -> fields[vencimiento_afiliacion]));
     $this -> assign("CIUDADVEHICULO",          $this -> getObjectHtml($this -> fields[ciudad_vehiculo]));
     $this -> assign("CIUDADVEHICULOID",        $this -> getObjectHtml($this -> fields[ciudad_vehiculo_id]));
     $this -> assign("TELEFONOVEHICULO",        $this -> getObjectHtml($this -> fields[telefono_vehiculo]));
     $this -> assign("LINEA",		                $this -> getObjectHtml($this -> fields[linea]));	 
     $this -> assign("LINEAID",		              $this -> getObjectHtml($this -> fields[linea_id]));	 
     $this -> assign("CARROCERIA",	            $this -> getObjectHtml($this -> fields[carroceria_id]));
     $this -> assign("MODELO",		              $this -> getObjectHtml($this -> fields[modelo_vehiculo]));
     $this -> assign("MODELOREPOTENCIADO",      $this -> getObjectHtml($this -> fields[modelo_repotenciado]));
     $this -> assign("COLOR",		                $this -> getObjectHtml($this -> fields[color]));
     $this -> assign("COLORID",		              $this -> getObjectHtml($this -> fields[color_id]));
     $this -> assign("COMBUSTIBLE",	            $this -> getObjectHtml($this -> fields[combustible_id]));
     $this -> assign("TARJETAPROPIEDAD",        $this -> getObjectHtml($this -> fields[tarjeta_propiedad]));
     $this -> assign("MOTOR",		                $this -> getObjectHtml($this -> fields[motor]));
     $this -> assign("CHASIS",		              $this -> getObjectHtml($this -> fields[chasis]));
     $this -> assign("PESOVACIO",	              $this -> getObjectHtml($this -> fields[peso_vacio]));
     $this -> assign("CAPACIDADCARGA",	        $this -> getObjectHtml($this -> fields[capacidad]));
     $this -> assign("UNIDADCAPACIDADCARGA",	  $this -> getObjectHtml($this -> fields[unidad_capacidad_carga]));	 	 
     $this -> assign("IDENTIDADTENEDOR",        $this -> getObjectHtml($this -> fields[tenedor_id]));
     $this -> assign("NOMBRETENEDOR",	          $this -> getObjectHtml($this -> fields[tenedor]));
     $this -> assign("IDENTIDADPROPIETARIO",    $this -> getObjectHtml($this -> fields[propietario_id]));
     $this -> assign("NOMBREPROPIETARIO",       $this -> getObjectHtml($this -> fields[propietario]));
     $this -> assign("TECNOMECANICO",	          $this -> getObjectHtml($this -> fields[tecnomecanico_vehiculo]));
     $this -> assign("VENCETECNOMECANICO",      $this -> getObjectHtml($this -> fields[vencimiento_tecno_vehiculo]));
     $this -> assign("REGISTRONACIONALCARGA",   $this -> getObjectHtml($this -> fields[registro_nacional_carga]));
    // $this -> assign("RESOLUCIONEXPEDICION",  $this -> getObjectHtml($this -> fields[resolucion_expedicion]));
     $this -> assign("MONITOREOSATELITAL",      $this -> getObjectHtml($this -> fields[monitoreo_satelital]));	 
     $this -> assign("LINKMONITOREOSATELITAL",  $this -> getObjectHtml($this -> fields[link_monitoreo_satelital]));	 
     $this -> assign("USUARIO",                 $this -> getObjectHtml($this -> fields[usuario]));	 
     $this -> assign("PASSWORD",                $this -> getObjectHtml($this -> fields[password]));	 
     $this -> assign("PROPIO",                  $this -> getObjectHtml($this -> fields[propio]));	 	 
     $this -> assign("TIPOPERSONAPROPIETARIO",  $this -> getObjectHtml($this -> fields[tipo_persona_propietario]));	 
     $this -> assign("CEDULANITPROPIETARIO",    $this -> getObjectHtml($this -> fields[cedula_nit_propietario]));	 
     $this -> assign("TELEFONOPROPIETARIO",     $this -> getObjectHtml($this -> fields[telefono_propietario]));	 
     $this -> assign("CELULARPROPIETARIO",      $this -> getObjectHtml($this -> fields[celular_propietario]));	 
     $this -> assign("DIRECCIONPROPIETARIO",    $this -> getObjectHtml($this -> fields[direccion_propietario]));	 
     $this -> assign("CIUDADPROPIETARIO",       $this -> getObjectHtml($this -> fields[ciudad_propietario]));	  
     $this -> assign("EMAILPROPIETARIO",        $this -> getObjectHtml($this -> fields[email_propietario]));	
     $this -> assign("TIPOPERSONATENEDOR",      $this -> getObjectHtml($this -> fields[tipo_persona_tenedor]));	 
     $this -> assign("CEDULANITTENEDOR",        $this -> getObjectHtml($this -> fields[cedula_nit_tenedor]));	 
     $this -> assign("TELEFONOTENEDOR",         $this -> getObjectHtml($this -> fields[telefono_tenedor]));	 
     $this -> assign("CELULARTENEDOR",          $this -> getObjectHtml($this -> fields[celular_tenedor]));	 
     $this -> assign("DIRECCIONTENEDOR",        $this -> getObjectHtml($this -> fields[direccion_tenedor]));	 
     $this -> assign("CIUDADTENEDOR",           $this -> getObjectHtml($this -> fields[ciudad_tenedor]));	  
     $this -> assign("EMAILTENEDOR",            $this -> getObjectHtml($this -> fields[email_tenedor])); 
     $this -> assign("NUMEROCUENTATENEDOR",     $this -> getObjectHtml($this -> fields[numero_cuenta_tenedor])); 
     $this -> assign("TIPOCUENTATENEDOR",       $this -> getObjectHtml($this -> fields[tipo_cuenta_tenedor])); 
     $this -> assign("BANCOCUENTATENEDOR",      $this -> getObjectHtml($this -> fields[banco_cuenta_tenedor])); 
	 
	   $this -> assign("RUT",	        		        $this -> objectsHtml -> GetobjectHtml($this -> fields[rut]));	
	   $this -> assign("SEGURIDADSOCIAL",	        $this -> objectsHtml -> GetobjectHtml($this -> fields[seguridad_social]));	
	   $this -> assign("VENCSEGURIDADSOCIAL",	    $this -> objectsHtml -> GetobjectHtml($this -> fields[venc_seguridad_social]));	
	   $this -> assign("VENCINVIMA",	            $this -> objectsHtml -> GetobjectHtml($this -> fields[venc_invima]));	
	   $this -> assign("FUMIGACION",	            $this -> objectsHtml -> GetobjectHtml($this -> fields[fumigacion]));	
	
	 
	 
	   $this -> assign("CONDUCTOR",                       $this -> getObjectHtml($this -> fields[conductor])); 
     $this -> assign("CONDUCTORID",                     $this -> getObjectHtml($this -> fields[conductor_id])); 	 
     $this -> assign("FOTOLATERAL",                     $this -> getObjectHtml($this -> fields[archivo_imagen_lateral])); 
     $this -> assign("FOTOFRONTAL",                     $this -> getObjectHtml($this -> fields[archivo_imagen_frontal])); 
     $this -> assign("FOTOTRASERA",                     $this -> getObjectHtml($this -> fields[archivo_imagen_trasera])); 	 	 	 	 
     $this -> assign("ARCHIVOCEDULACONDUCTOR",          $this -> getObjectHtml($this -> fields[archivo_cedula_conductor])); 
     $this -> assign("ARCHIVOLICENCIACONDUCTOR",        $this -> getObjectHtml($this -> fields[archivo_licencia_conductor])); 
     $this -> assign("ARCHIVOARPCONDUCTOR",             $this -> getObjectHtml($this -> fields[archivo_arp_conductor])); 
     $this -> assign("ARCHIVOAFILIACIONPOSCONDUCTOR",   $this -> getObjectHtml($this -> fields[archivo_pos_conductor])); 
     $this -> assign("ARCHIVOANTECEDENTESCONDUCTOR",    $this -> getObjectHtml($this -> fields[archivo_antecedentes_conductor])); 
     $this -> assign("ARCHIVOCEDULAPROPIETARIOVEHICULO",$this -> getObjectHtml($this -> fields[archivo_cedula_propietario])); 
     $this -> assign("ARCHIVOTARJETAPROPIEDADVEHICULO", $this -> getObjectHtml($this -> fields[archivo_targeta_propiedad_vehiculo])); 
     $this -> assign("ARCHIVOCONTRATOLEASING",          $this -> getObjectHtml($this -> fields[archivo_contrato_leasing])); 
     $this -> assign("ARCHIVORUTPROPIETARIOTENEDOR",    $this -> getObjectHtml($this -> fields[archivo_rut_propietario])); 
     $this -> assign("ARCHIVOREGISTRONACIONALCARGA",    $this -> getObjectHtml($this -> fields[archivo_registro_nacional_carga])); 
     $this -> assign("ARCHIVOREGISTRONACIONALREMOLQUE", $this -> getObjectHtml($this -> fields[archivo_registro_nacional_remolque])); 
     $this -> assign("ARCHIVOREVISIONTECNOMECANICA",    $this -> getObjectHtml($this -> fields[archivo_revision_tecnomecanica])); 
     $this -> assign("ARCHIVOAFILIACIONEMPRESATRANSPORTE",$this -> getObjectHtml($this -> fields[archivo_afiliacion_empresa_transporte])); 
     $this -> assign("ARCHIVOSOAT",                     $this -> getObjectHtml($this -> fields[archivo_soat])); 
     $this -> assign("RESPONSABLEVERIFICACION1",        $this -> getObjectHtml($this -> fields[responsable_verificacion1])); 
     $this -> assign("PERSONAQUEATENDIO1",              $this -> getObjectHtml($this -> fields[nombre_persona_atendio1])); 
	 
	 
     $this -> assign("CIUDADPERSONAQUEATENDIO1",    $this -> getObjectHtml($this -> fields[ciudad_persona_atendio1])); 
     $this -> assign("CIUDADIDPERSONAQUEATENDIO1",  $this -> getObjectHtml($this -> fields[ciudad_persona_atendio1_id])); 
     $this -> assign("TELEFONOPERSONAQUEATENDIO1",  $this -> getObjectHtml($this -> fields[telefono_persona_atendio1])); 	 	 	 
	 
	 
     $this -> assign("TIPOVERIFICACION1",           $this -> getObjectHtml($this -> fields[tipo_verificacion1])); 
     $this -> assign("RESPONSABLEVERIFICACION2",    $this -> getObjectHtml($this -> fields[responsable_verificacion2])); 
     $this -> assign("PERSONAQUEATENDIO2",          $this -> getObjectHtml($this -> fields[nombre_persona_atendio2])); 
	 
     $this -> assign("CIUDADPERSONAQUEATENDIO2",    $this -> getObjectHtml($this -> fields[ciudad_persona_atendio2])); 
     $this -> assign("CIUDADIDPERSONAQUEATENDIO2",  $this -> getObjectHtml($this -> fields[ciudad_persona_atendio2_id])); 
     $this -> assign("TELEFONOPERSONAQUEATENDIO2",  $this -> getObjectHtml($this -> fields[telefono_persona_atendio2])); 	 	 	 	 	 
	 
	 
     $this -> assign("TIPOVERIFICACION2",             $this -> getObjectHtml($this -> fields[tipo_verificacion2])); 
     $this -> assign("RESPONSABLEVERIFICACION3",      $this -> getObjectHtml($this -> fields[responsable_verificacion3])); 
     $this -> assign("RESPONSABLEVERIFICACION1STATIC",$this -> getObjectHtml($this -> fields[responsable_verificacion1_static])); 
     $this -> assign("RESPONSABLEVERIFICACION2STATIC",$this -> getObjectHtml($this -> fields[responsable_verificacion2_static])); 
     $this -> assign("RESPONSABLEVERIFICACION3STATIC",$this -> getObjectHtml($this -> fields[responsable_verificacion3_static])); 
     $this -> assign("PERSONAQUEATENDIO3",            $this -> getObjectHtml($this -> fields[nombre_persona_atendio3])); 
	 
     $this -> assign("CIUDADPERSONAQUEATENDIO3",      $this -> getObjectHtml($this -> fields[ciudad_persona_atendio3])); 
     $this -> assign("CIUDADIDPERSONAQUEATENDIO3",    $this -> getObjectHtml($this -> fields[ciudad_persona_atendio3_id])); 
     $this -> assign("TELEFONOPERSONAQUEATENDIO3",    $this -> getObjectHtml($this -> fields[telefono_persona_atendio3])); 	 		 
	 
	 
     $this -> assign("TIPOVERIFICACION3",             $this -> getObjectHtml($this -> fields[tipo_verificacion3])); 
     $this -> assign("FECHACONFIRMACION",             $this -> getObjectHtml($this -> fields[fecha_confirmacion])); 
     $this -> assign("APROBACION",                    $this -> getObjectHtml($this -> fields[aprobacion])); 
     $this -> assign("APROBO",                        $this -> getObjectHtml($this -> fields[persona_aprobo])); 
     $this -> assign("APROBOID",                      $this -> getObjectHtml($this -> fields[persona_aprobo_id])); 
     $this -> assign("REVISO",                        $this -> getObjectHtml($this -> fields[persona_reviso])); 	
     $this -> assign("REVISOID",                      $this -> getObjectHtml($this -> fields[persona_reviso_id])); 
     $this -> assign("SOAT",		                      $this -> getObjectHtml($this -> fields[numero_soat]));
     $this -> assign("ASEGSOATID",	                  $this -> getObjectHtml($this -> fields[aseguradora_soat_id]));
     $this -> assign("VENCESOAT",	                    $this -> getObjectHtml($this -> fields[vencimiento_soat]));
	 
	 $this -> assign("USUARIOID",	                      $this -> getObjectHtml($this -> fields[usuario_id]));
     $this -> assign("FECHAACTUAL",	                  $this -> getObjectHtml($this -> fields[fecha_actual]));
	 $this -> assign("OFICINAID",	                      $this -> getObjectHtml($this -> fields[oficina_id]));
	 $this -> assign("FECHAINGRESO",	                  $this -> getObjectHtml($this -> fields[fecha_ingreso]));
	 
	 $this -> assign("KILOMETRAJE",	                    $this -> getObjectHtml($this -> fields[kilometraje]));
	 $this -> assign("GRUPTRABAJO",	                    $this -> getObjectHtml($this -> fields[gruptrabajo]));
	 $this -> assign("NOVEDADES",	                      $this -> getObjectHtml($this -> fields[novedades]));
	 $this -> assign("FECHAGENERAL",	                  $this -> getObjectHtml($this -> fields[general]));
	 
	 $this -> assign("FRENOS",	                        $this -> getObjectHtml($this -> fields[frenos]));
	 $this -> assign("SINCRONI",	                      $this -> getObjectHtml($this -> fields[sincroni]));
	 $this -> assign("DIRECCION",	                      $this -> getObjectHtml($this -> fields[direccion]));
	 $this -> assign("ALINEACION",	                    $this -> getObjectHtml($this -> fields[alineacion]));

	 
     if($this -> Guardar)
	   $this -> assign("GUARDAR",$this -> getObjectHtml($this -> fields[guardar]));
	   
	 if($this -> Actualizar)
	   $this -> assign("ACTUALIZAR",$this -> getObjectHtml($this -> fields[actualizar]));
	   
	 if($this -> Borrar)
	   $this -> assign("BORRAR",$this -> getObjectHtml($this -> fields[borrar]));
	   
	 if($this -> Limpiar)
	   $this -> assign("LIMPIAR",$this -> getObjectHtml($this -> fields[limpiar]));
	   
	 if($this -> Imprimir)
	   $this -> assign("IMPRIMIR",$this -> getObjectHtml($this -> fields[imprimir]));	   
	   
	   
   }


//LISTA MENU

    public function setPlacaid($placa_id){

      $this -> fields[placa_id]['value'] = $placa_id;

        $this -> assign("PLACAID",$this -> objectsHtml -> GetobjectHtml($this -> fields[placa_id]));	  	   

      }

   public function setEstado(){
   
     if(!$this -> CambiarEstado) $this -> fields[estado][disabled] = 'true';
	 
     $this -> assign("ESTADO",	$this -> getObjectHtml($this -> fields[estado]));	   	        
   
   }

   public function SetConfig($TipoConfig){
       $this -> fields[configuracion][options] = $TipoConfig;
       $this -> assign("CONFIGURACION",$this -> getObjectHtml($this -> fields[configuracion]));
   }

   public function SetTipoVehiculo($tipos_vehiculo){
       $this -> fields[tipo_vehiculo_id][options] = $tipos_vehiculo;
       $this -> assign("TIPOVEHICULO",$this -> getObjectHtml($this -> fields[tipo_vehiculo_id]));
   }
   
   public function SetCarroceria($TipoCarroceria){
       $this -> fields[carroceria_id]['options'] = $TipoCarroceria;
       $this -> assign("CARROCERIA",$this -> getObjectHtml($this -> fields[carroceria_id])); 
   }
   
   public function SetCombustible($TipoCombustible){
     $this -> fields[combustible_id]['options'] = $TipoCombustible;
     $this -> assign("COMBUSTIBLE",$this -> getObjectHtml($this -> fields[combustible_id])); 
   }

   public function SetAseguradoras($aseguradoras){
     $this -> fields[aseguradora_soat_id]['options'] = $aseguradoras;
     $this -> assign("ASEGSOATID",$this -> getObjectHtml($this -> fields[aseguradora_soat_id])); 
   } 
   
   


//// GRID ////
   public function SetGridVehiculos($Attributes,$Titles,$Cols,$Query){
     require_once("../../../framework/clases/grid/JqGridClass.php");
	 $TableGrid = new JqGrid();
 	 $TableGrid -> SetJqGrid($Attributes,$Titles,$Cols,$Query);
	 
     $this -> assign("GRIDVEHICULO",$TableGrid -> RenderJqGrid());
     $this -> assign("TABLEGRIDCSS",$TableGrid -> GetJqGridCss());
     $this -> assign("TABLEGRIDJS",	$TableGrid -> GetJqGridJs());
   }


   public function RenderMain(){
   
        $this -> RenderLayout('vehiculo.tpl');
	 
   }


}


?>