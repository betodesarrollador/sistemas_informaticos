<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_GuiaEncomiendaModel extends Db{
  
  public function getGuia($oficina_id,$empresa_id,$Conex){
  
	$rango_desde = $_REQUEST['rango_desde'];
    $rango_hasta = $_REQUEST['rango_hasta'];
    $guias = $_REQUEST['guias'];
	$orden_servicio = $_REQUEST['orden_servicio'];
    $fecha_guia_crea = $_REQUEST['fecha_guia_crea'];
	
	$rangos='';
	$ordensql='';
	$fechasql='';
	
	if($rango_desde>0 && $rango_hasta>0) $rangos=" AND r.numero_guia BETWEEN ".$rango_desde." AND ".$rango_hasta." ";
	if($guias!="") $guias=" AND r.numero_guia IN(".$guias.")";
	if($orden_servicio>0 ) $ordensql=" AND r.solicitud_id= ".$orden_servicio." ";	
	if($fecha_guia_crea!='' && $fecha_guia_crea!='NULL' && $fecha_guia_crea!=NULL ) $fechasql=" AND r.fecha_guia= '".$fecha_guia_crea."' ";	
	
    $guia     = array();
	//	(SELECT nombre FROM clase_servicio_mensajeria WHERE clase_servicio_mensajeria_id = r.clase_servicio_mensajeria_id) AS clase_servicio,				
	$select = "SELECT r.fecha_guia,r.valor_flete,r.valor_seguro,r.valor_otros,r.valor_total,r.peso_volumen, r.zona,	(SELECT abreviatura FROM medida WHERE medida_id=r.medida_id) AS medida,
	(SELECT nombre_corto FROM tipo_servicio_mensajeria WHERE tipo_servicio_mensajeria_id = r.tipo_servicio_mensajeria_id) AS tipo_servicio,
	(SELECT logo FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS logo,
	(SELECT pagina_web FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS pagina_web,
	(SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id))) AS empresa,
	(SELECT concat_ws('- ',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id))) AS numero_identificacion,
	(SELECT nombre FROM oficina WHERE oficina_id = r.oficina_id) AS oficina,(SELECT direccion FROM oficina WHERE oficina_id = r.oficina_id) AS direccion,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM oficina WHERE oficina_id = r.oficina_id)) AS ciudad,
	(SELECT habilitacion FROM resolucion_habilitacion_men WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS resolucion_habilitacion,
	(SELECT fecha_habilitacion FROM resolucion_habilitacion_men WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS fecha_habilitacion,	
	(SELECT habilitacion FROM resolucion_habilitacion_men WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS resolucion_ministerio,
	(SELECT  fecha_habilitacion  FROM resolucion_habilitacion_men WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS fecha_resolucion,	
	(SELECT rango_manif_ini FROM resolucion_habilitacion_men WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS rango_manif_ini,	
	(SELECT rango_manif_fin FROM resolucion_habilitacion_men WHERE empresa_id = (SELECT empresa_id FROM oficina WHERE oficina_id = r.oficina_id)) AS rango_manif_fin,


	(SELECT numero_resolucion FROM rango_guia_encomienda WHERE tipo='C' AND ESTADO='A' ORDER BY fecha_rango_guia DESC LIMIT 1) AS resolucion_dian,
	(SELECT  fecha_rango_guia  FROM rango_guia_encomienda WHERE tipo='C' AND ESTADO='A' ORDER BY fecha_rango_guia DESC LIMIT 1) AS fecha_dian,	
	(SELECT rango_guia_encomienda_ini FROM rango_guia_encomienda WHERE tipo='C' AND ESTADO='A' ORDER BY fecha_rango_guia DESC LIMIT 1) AS rango_dian_ini,	
	(SELECT rango_guia_encomienda_fin FROM rango_guia_encomienda WHERE tipo='C' AND ESTADO='A' ORDER BY fecha_rango_guia DESC LIMIT 1) AS rango_dian_fin,

	(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,

	(SELECT cod_postal  FROM ubicacion WHERE ubicacion_id = r.origen_id) AS postal_origen,
	(SELECT cod_postal  FROM ubicacion WHERE ubicacion_id = r.destino_id) AS postal_destino,

	(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id = r.origen_id)) AS depto_origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id = r.destino_id)) AS depto_destino,	
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id =(SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id = r.origen_id))) AS pais_origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id =(SELECT ubi_ubicacion_id FROM ubicacion WHERE ubicacion_id = r.destino_id))) AS pais_destino,	
	(SELECT CONCAT_WS(' - ',u.nombre,(SELECT nombre FROM ubicacion WHERE ubicacion_id=u.ubi_ubicacion_id )) FROM ubicacion u WHERE u.ubicacion_id=r.origen_id ) AS origen1,
	(SELECT CONCAT_WS(' - ',u.nombre,(SELECT nombre FROM ubicacion WHERE ubicacion_id=u.ubi_ubicacion_id )) FROM ubicacion u WHERE u.ubicacion_id=r.destino_id ) AS destino1,
	
	r.*,CONCAT(r.prefijo,r.numero_guia) AS numero_guia_codigo,CONCAT(r.prefijo,LPAD(r.numero_guia,8,'0')) AS numero_guia_bar,(SELECT CONCAT('OFICINA: ',nombre,', TEL: ',telefono) FROM oficina WHERE oficina_id = r.oficina_id) AS oficina_responsable,
	r.estado_mensajeria_id,
	(SELECT direccion FROM tercero t, empresa e WHERE e.empresa_id= $empresa_id AND t.tercero_id = e.tercero_id) AS direccion1
	FROM guia_encomienda r WHERE r.guia_encomienda_id>0 $guias $rangos  $ordensql $fechasql  ORDER BY r.guia_encomienda_id ASC";	//echo $select;
	//r.oficina_id = $oficina_id
	$result  = $this -> DbFetchAll($select,$Conex);	
	$guia = $result;	
	
	for($i = 0; $i < count($guia); $i++){	
	  $guia_id = $guia[$i]['guia_id'];
	  $estado    = $guia[$i]['estado'];
	  //$select    = "SELECT * FROM detalle_guia WHERE guia_id = $guia_id";
	  //$result    = $this -> DbFetchAll($select,$Conex);	
	  //$guia[$i]['detalles_guia'] = $result;		  
	  
	  if($estado == 'M'){	  
	     $select = "SELECT * FROM detalle_despacho WHERE guia_id = $guia_id";
	     $result = $this -> DbFetchAll($select,$Conex);			 
		 
		 if(count($result) > 0){		 
		    $manifiesto_id      = $result[0]['manifiesto_id'];
		    $despachos_urbanos_id = $result[0]['despachos_urbanos_id'];			
			
			if(is_numeric($manifiesto_id)){			
			  $select = "SELECT placa,manifiesto FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	          $result = $this -> DbFetchAll($select,$Conex);			  
			  $guia[$i]['manifiesto'] = $result[0]['manifiesto'];
			  $guia[$i]['placa']      = $result[0]['placa'];		  					  
			
			}/*else if(is_numeric($despachos_urbanos_id)){			
			    $select = "SELECT placa,manifiesto FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	            $result = $this -> DbFetchAll($select,$Conex);			  
			    $guia[$i]['manifiesto'] = $result[0]['manifiesto'];
			    $guia[$i]['placa']      = $result[0]['placa'];			
			  }*/		 
		 } }	  
	}			
	return $guia;	
  }
  
  public function getOficinas($empresa_id,$Conex){  
     $select = "SELECT * FROM oficina WHERE empresa_id = $empresa_id"; 
     $result = $this -> DbFetchAll($select,$Conex);
     return $result;  
  }   
}

?>