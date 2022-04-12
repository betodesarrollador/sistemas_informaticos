<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_HV_ConductorModel extends Db{ 
  
  public function getConductor($Conex){
 
    $conductor_id = $this -> requestDataForQuery('conductor_id','integer');
	
	if(is_numeric($conductor_id)){

  	    $select = "SELECT t.tercero_id,t.tipo_persona_id,t.tipo_identificacion_id,(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion,t.numero_identificacion,t.digito_verificacion,
			      t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social,
						  t.sigla,
						  c.conductor_id,
						  c.categoria_id,
						  c.tipo_sangre_id,
						  c.estado_civil_id,
(SELECT estado_civil FROM estado_civil WHERE estado_civil_id = c.estado_civil_id) AS estado_civil,
						  c.nivel_educativo_id,
						  t.ubicacion_id,
						  (SELECT nombre 
							  FROM ubicacion 
							  WHERE ubicacion_id=t.ubicacion_id) 
						  AS ubicacion,
						  t.direccion,
						  t.telefono,
						  t.movil,					
						  c.conductor_id,
						  c.lugar_expedicion_cedula,
						  c.estatura,
						  c.senales_particulares,
						  c.tipo_vivienda,
						  c.barrio,
						  c.tiempo_antiguedad_vivienda,
						  c.personas_a_cargo,
						  c.numero_hijos,
						  c.arrendatario,
						  c.telefono_arrendatario,
						  c.empresa_cargo1,
						  c.telefono_empresa_cargo1,
						  c.ciudad_empresa_cargo1,
						  c.nombre_persona_atendio1,
						  c.cargo_persona_atendio1,
						  c.tiempo_lleva_cargando1,
						  c.rutas1,
						  c.tipo_mercancia1,
						  c.viajes_realizados1,
						  c.empresa_cargo2,
						  c.telefono_empresa_cargo2,
						  c.ciudad_empresa_cargo2,
						  c.nombre_persona_atendio2,
						  c.cargo_persona_atendio2,
						  c.tiempo_lleva_cargando2,
						  c.rutas2,
						  c.tipo_mercancia2,
						  c.viajes_realizados2,
						  c.empresa_cargo3,
						  c.telefono_empresa_cargo3,
						  c.ciudad_empresa_cargo3,
						  c.nombre_persona_atendio3,
						  c.cargo_persona_atendio3,
						  c.tiempo_lleva_cargando3,
						  c.rutas3,
						  c.tipo_mercancia3,
						  c.viajes_realizados3,
						  c.referencia1,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia1_id) AS ciudad_referencia1_id,
						  c.telefono_referencia1,
						  c.referencia2,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia2_id) AS ciudad_referencia2_id,
						  c.telefono_referencia2,
						  c.referencia3,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia3_id) AS ciudad_referencia3_id,
						  c.telefono_referencia3,
						  c.categoria_id,
						  c.tipo_sangre_id,
						  c.estado_civil_id,
						  c.nivel_educativo_id,
						  c.fecha_ingreso_cond,
						  c.numero_licencia_cond,
						  c.vencimiento_licencia_cond,
						  c.fecha_nacimiento_cond,
						  c.libreta_mil_cond,
						  c.distrito_mil_cond,
						  c.eps_cond,
						  c.arp_cond,
						  c.antecedente_judicial_cond,
						  c.contacto_cond,
						  c.tel_contacto_cond,
						  c.foto,
						  c.cedulaescan,
						  c.licenciaescan,
						  c.pasadoescan,
						  c.epsescan,
						  c.arpescan,
						  c.huellaindiceizq,
						  c.huellapulgarizq,
						  c.huellapulgarder,
						  c.huellaindiceder,
						  c.estado,
(SELECT categoria FROM categoria_licencia WHERE categoria_id = c.categoria_id) AS categoria,
						  ((YEAR(CURDATE())-YEAR(fecha_nacimiento_cond)) - (RIGHT(CURDATE(),5)<RIGHT(fecha_nacimiento_cond,5))) AS edad,
                                                  (SELECT tipo_sangre FROM tipo_sangre WHERE tipo_sangre_id = c.tipo_sangre_id) AS tipo_sangre,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo1) AS ciudad_empresa_cargo1_txt,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo2) AS ciudad_empresa_cargo2_txt,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_empresa_cargo3) AS ciudad_empresa_cargo3_txt,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia1_id) AS ciudad_referencia1_txt,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia2_id) AS ciudad_referencia2_txt,
						  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia3_id) AS ciudad_referencia3_txt  FROM tercero t LEFT JOIN conductor c  ON t.tercero_id = c.tercero_id  WHERE c.conductor_id = $conductor_id";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
  
   
}


?>