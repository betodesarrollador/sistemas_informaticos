<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_HV_VehiculoModel extends Db{

  private $Permisos;
  
  
  public function getVehiculo($Conex){
  
    $placa_id = $this -> requestDataForQuery('placa_id','integer');
	
	if(is_numeric($placa_id)){
	
           $select = "SELECT v.*, (SELECT logo FROM empresa WHERE empresa_id = v.empresa_id) AS logo,m.marca,(SELECT descripcion FROM tipo_vehiculo WHERE tipo_vehiculo_id = v.tipo_vehiculo_id) AS tipo_vehiculo,(SELECT combustible FROM combustible WHERE combustible_id = v.combustible_id) AS combustible, (SELECT combustible FROM combustible WHERE combustible_id = v.combustible_id) AS tipo_combustible,	  				
(SELECT carroceria FROM carroceria WHERE carroceria_id = v.carroceria_id) AS carroceria, (SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,

 (SELECT marca_remolque FROM marca_remolque WHERE marca_remolque_id = (SELECT marca_remolque_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS marca_remolque,(SELECT modelo_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS modelo_remolque,(SELECT tipo_remolque FROM tipo_remolque WHERE tipo_remolque_id = (SELECT tipo_remolque_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS tipo_remolque,(SELECT nombre FROM ubicacion WHERE ubicacion_id = v.ciudad_vehiculo_id) AS ciudad_vehiculo,(SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = v.aseguradora_soat_id) AS asegura_soat,

(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = (SELECT tipo_persona_id FROM tercero WHERE tercero_id = v.propietario_id)) AS tipo_persona_propietario, (SELECT numero_identificacion FROM tercero WHERE tercero_id = v.propietario_id) AS cedula_nit_propietario,

(SELECT digito_verificacion FROM tercero WHERE tercero_id = v.propietario_id) AS dv_nit_propietario,

(SELECT telefono FROM tercero WHERE tercero_id = v.propietario_id) AS telefono_propietario,
(SELECT movil FROM tercero WHERE tercero_id = v.propietario_id) AS celular_propietario,(SELECT direccion FROM tercero WHERE tercero_id = v.propietario_id) AS direccion_propietario,

(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = v.propietario_id)) AS ciudad_propietario,

(SELECT email FROM tercero WHERE tercero_id = v.propietario_id) AS email_propietario,


l.linea, cl.color, 
							    	CONCAT_WS(' ',trt.numero_identificacion,trt.primer_apellido,trt.segundo_apellido,trt.primer_nombre,trt.segundo_nombre,trt.razon_social) AS tenedor,



(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = (SELECT tipo_persona_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS tipo_persona_tenedor, (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS cedula_nit_tenedor,

(SELECT digito_verificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS dv_nit_tenedor,

(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS telefono_tenedor,
(SELECT movil FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS celular_tenedor,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS direccion_tenedor,

(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS ciudad_tenedor,

(SELECT email FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS email_tenedor,


					(SELECT nombre_banco FROM banco WHERE 	banco_id = (SELECT 	banco_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) 
					AS banco,
					(SELECT nombre_tipo_cuenta 
						FROM tipo_cuenta tc, tenedor tn
						WHERE tc.tipo_cta_id=tn.tipo_cta_id
						AND tn.tenedor_id=v.tenedor_id) 
					AS tipo_cuenta,
					(SELECT tn.numero_cuenta_tene
						FROM tenedor tn
						WHERE tn.tenedor_id=v.tenedor_id) 
					AS numero_cuenta_tene,

									CONCAT_WS(' ',pr.numero_identificacion,pr.primer_apellido,pr.segundo_apellido,pr.primer_nombre,pr.segundo_nombre,pr.razon_social) AS propietario,
									s.nombre_aseguradora AS aseguradora_soat,


IF(archivo_cedula_conductor 	 IS NULL,'&nbsp;','X') AS archivo_cedula_conductor,
IF(archivo_licencia_conductor 	 IS NULL,'&nbsp;','X') AS archivo_licencia_conductor,
IF(archivo_antecedentes_conductor 	 IS NULL,'&nbsp;','X') AS archivo_antecedentes_conductor,
IF(archivo_arp_conductor 	 IS NULL,'&nbsp;','X') AS archivo_arp_conductor,
IF(archivo_pos_conductor 	 IS NULL,'&nbsp;','X') AS archivo_pos_conductor,
IF(archivo_cedula_propietario 	 IS NULL,'&nbsp;','X') AS archivo_cedula_propietario,
IF(archivo_targeta_propiedad_vehiculo 	 IS NULL,'&nbsp;','X') AS archivo_targeta_propiedad_vehiculo,
IF(archivo_rut_propietario 	 IS NULL,'&nbsp;','X') AS archivo_rut_propietario,
IF(archivo_contrato_leasing 	 IS NULL,'&nbsp;','X') AS archivo_contrato_leasing,
IF(archivo_registro_nacional_carga 	 IS NULL,'&nbsp;','X') AS archivo_registro_nacional_carga,
IF(archivo_registro_nacional_remolque 	 IS NULL,'&nbsp;','X') AS archivo_registro_nacional_remolque,
IF(archivo_revision_tecnomecanica 	 IS NULL,'&nbsp;','X') AS archivo_revision_tecnomecanica,
IF(archivo_afiliacion_empresa_transporte 	 IS NULL,'&nbsp;','X') AS archivo_afiliacion_empresa_transporte,IF(archivo_soat IS NULL,'&nbsp;','X') AS archivo_soat,(SELECT concat_ws(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = v.persona_reviso_id) AS reviso,

(SELECT concat_ws(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = v.persona_aprobo_id) AS aprobo,v.responsable_verificacion1

								FROM vehiculo v, marca m, linea l, color cl, tenedor tn, tercero pr, aseguradora s, tercero trt
								WHERE v.placa_id=$placa_id 
								AND v.marca_id=m.marca_id 
								AND v.linea_id=l.linea_id
								AND v.color_id=cl.color_id 
								AND v.tenedor_id=tn.tenedor_id AND tn.tercero_id = trt.tercero_id
								AND v.propietario_id=pr.tercero_id
								AND v.aseguradora_soat_id=s.aseguradora_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  
  public function getTenedor($Conex){
  
    $placa_id = $this -> requestDataForQuery('placa_id','integer');
	
	if(is_numeric($placa_id)){
	
	  $select  = "SELECT 
	  				(SELECT CONCAT_WS(' ', t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social) 
						FROM tercero t, tenedor tn 
						WHERE t.tercero_id=tn.tercero_id 
						AND tn.tenedor_id=v.tenedor_id) 
					AS nombre_tenedor,
					(SELECT CONCAT_WS(' ',ti.nombre,t.numero_identificacion)
						FROM tercero t, tenedor tn, tipo_identificacion ti
						WHERE ti.tipo_identificacion_id=t.tipo_identificacion_id
						AND t.tercero_id=tn.tercero_id 
						AND tn.tenedor_id=v.tenedor_id) 
					AS identi_tenedor,
					(SELECT nombre 
						FROM tercero t, tenedor tn, ubicacion u 
						WHERE u.ubicacion_id=t.ubicacion_id
						AND t.tercero_id=tn.tercero_id 
						AND tn.tenedor_id=v.tenedor_id) 
					AS ubicacion,
					(SELECT t.direccion
						FROM tercero t, tenedor tn 
						WHERE t.tercero_id=tn.tercero_id 
						AND tn.tenedor_id=v.tenedor_id) 
					AS direccion,
					(SELECT CONCAT_WS('-',t.telefono,t.movil)
						FROM tercero t, tenedor tn 
						WHERE t.tercero_id=tn.tercero_id 
						AND tn.tenedor_id=v.tenedor_id) 
					AS telefonos,
					
					(SELECT CONCAT_WS(' ', t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social) 
						FROM tercero t, tenedor tn 
						WHERE t.tercero_id=tn.banco_id 
						AND tn.tenedor_id=v.tenedor_id) 
					AS banco,
					(SELECT nombre_tipo_cuenta 
						FROM tipo_cuenta tc, tenedor tn
						WHERE tc.tipo_cta_id=tn.tipo_cta_id
						AND tn.tenedor_id=v.tenedor_id) 
					AS tipo_cuenta,
					(SELECT tn.numero_cuenta_tene
						FROM tenedor tn
						WHERE tn.tenedor_id=v.tenedor_id) 
					AS numero_cuenta_tene
					
				FROM vehiculo v
				WHERE v.placa_id=$placa_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
  
  public function getPropietario($Conex){
  
    $placa_id = $this -> requestDataForQuery('placa_id','integer');
	
	if(is_numeric($placa_id)){
	
	  $select  = "SELECT  
	  				(SELECT CONCAT_WS(' ', t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social) 
						FROM tercero t 
						WHERE t.tercero_id=v.propietario_id) 
					AS nombre_propietario,
					(SELECT CONCAT_WS(' ',ti.nombre,t.numero_identificacion)
						FROM tercero t, tipo_identificacion ti
						WHERE ti.tipo_identificacion_id=t.tipo_identificacion_id
						AND t.tercero_id=v.propietario_id) 
					AS identi_propietario,
					(SELECT nombre 
						FROM tercero t, ubicacion u 
						WHERE u.ubicacion_id=t.ubicacion_id
						AND t.tercero_id=v.propietario_id) 
					AS ubicacion,
					(SELECT t.direccion
						FROM tercero t 
						WHERE t.tercero_id=v.propietario_id) 
					AS direccion,
					(SELECT CONCAT_WS('-',t.telefono,t.movil)
						FROM tercero t 
						WHERE t.tercero_id=v.propietario_id) 
					AS telefonos
					
				FROM vehiculo v
				WHERE v.placa_id=$placa_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
   
}



?>