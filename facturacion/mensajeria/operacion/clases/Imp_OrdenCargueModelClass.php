<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_OrdenCargueModel extends Db{

  
  public function getOrdenCargue($Conex){
  
 
        $orden_cargue_id = $this -> requestDataForQuery('orden_cargue_id','integer');
		$ip_server = $this -> getIpServerPublic();

	if(is_numeric($orden_cargue_id)){
	
	    $empresa_id = $_SESSION['oficina']['empresa_id'];
	    $oficina_id = $_REQUEST['oficina']['oficina_id'];
				
        $select = "SELECT (SELECT logo AS logos FROM empresa WHERE empresa_id = of.empresa_id) AS logo,(SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social,(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla, (SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad, 
		(SELECT ti.nombre FROM tercero t, tipo_identificacion ti WHERE t.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion_emp,
		o.consecutivo,o.cliente,o.cliente_nit,o.cliente_tel,o.direccion_cargue,DATE(fecha_ingreso) AS fecha_ingre,
		(SELECT nombre_contacto FROM contacto WHERE contacto_id=o.contacto_id) AS contacto,
		(SELECT foto  AS fotos FROM conductor WHERE conductor_id =o.conductor_id) AS foto_conductor,
		(SELECT archivo_imagen_frontal  AS archivo_imagen_frontals  FROM vehiculo WHERE placa_id=o.placa_id) AS foto_vehiculo,		
		(SELECT tipo_servicio FROM tipo_servicio WHERE tipo_servicio_id=o.tipo_servicio_id) AS tipo_servicio,
		o.fecha,o.hora,o.producto,o.peso,o.peso_volumen,o.cantidad_cargue,o.placa,o.placa_remolque,o.marca,o.linea,o.modelo,o.modelo_repotenciado,
		o.serie,o.color,o.carroceria,o.registro_nacional_carga,o.configuracion,o.peso_vacio,o.numero_soat,o.nombre_aseguradora,o.vencimiento_soat,
		o.numero_identificacion,o.nombre,o.direccion_conductor,o.telefono_conductor,o.ciudad_conductor,o.categoria_licencia_conductor, 	    
		o.numero_licencia_cond, 	
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.origen_id) AS origen,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.destino_id) AS destino,
		(SELECT TRIM(medida) FROM medida WHERE medida_id=o.unidad_peso_id) AS unidad_peso,
		(SELECT TRIM(medida) FROM medida WHERE medida_id=o.unidad_volumen_id) AS unidad_volumen,
		 of.nombre AS nom_oficina,
		 of.direccion AS dir_oficna,
		 of.telefono  AS tel_oficina,
		 (SELECT TRIM(nombre) FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi,
		 o.estado, o.observaciones
         FROM orden_cargue o, oficina of WHERE o.orden_cargue_id = $orden_cargue_id AND of.oficina_id=o.oficina_id";		

	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }
   
}


?>