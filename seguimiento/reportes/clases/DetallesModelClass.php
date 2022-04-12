<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;

  public function getReporteUlt($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' AND t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL  ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' AND t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL  ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' AND t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL  ';
		}
		if($tipo=='ALL'){
			$tipo="";
		}else{
			$tipo=" AND t.estado IN ('".str_replace(",","','",$tipo)."') "; 
		}
		if($tipo_nov=='NULL'){
			$tipo_nov=" ";
		}else{
			$tipo_nov=" AND t.trafico_id IN (SELECT ds.trafico_id FROM detalle_seguimiento ds WHERE ds.novedad_id IN (".$tipo_nov.")) "; 
		}

		$select = "SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				IF(t.seguimiento_id>0,'Seguimiento No',IF(t.manifiesto_id>0,'Manifiesto No','Despacho No')) AS tipo_doc,				
				IF(t.seguimiento_id>0,t.seguimiento_id,IF(t.manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS numero,
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT u.nombre FROM ubicacion u, detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id AND u.ubicacion_id=ds.ubicacion_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.fecha_reporte, ds.hora_reporte DESC LIMIT 0,1) AS ubicacion_punto,
				(SELECT punto_referencia FROM detalle_seguimiento WHERE trafico_id=t.trafico_id AND fecha_reporte IS NOT NULL  ORDER BY fecha_reporte, hora_reporte DESC LIMIT 0,1 ) AS punto_referencia,
				(SELECT n.novedad FROM novedad_seguimiento n, detalle_seguimiento ds WHERE ds.trafico_id=t.trafico_id AND n.novedad_id=ds.novedad_id AND ds.fecha_reporte IS NOT NULL  ORDER BY ds.fecha_reporte, ds.hora_reporte DESC LIMIT 0,1) AS novedad,
				(SELECT obser_deta FROM detalle_seguimiento WHERE trafico_id=t.trafico_id AND fecha_reporte IS NOT NULL  ORDER BY fecha_reporte, hora_reporte DESC LIMIT 0,1 ) AS obser_deta,
				(SELECT fecha_reporte FROM detalle_seguimiento WHERE trafico_id=t.trafico_id AND fecha_reporte IS NOT NULL  ORDER BY fecha_reporte, hora_reporte DESC LIMIT 0,1 ) AS fecha_reporte,
				(SELECT hora_reporte FROM detalle_seguimiento WHERE trafico_id=t.trafico_id AND fecha_reporte IS NOT NULL  ORDER BY fecha_reporte, hora_reporte DESC LIMIT 0,1 ) AS hora_reporte,
				(SELECT usuario FROM detalle_seguimiento WHERE trafico_id=t.trafico_id AND fecha_reporte IS NOT NULL  ORDER BY fecha_reporte, hora_reporte DESC LIMIT 0,1 ) AS usuario
				FROM trafico t
				WHERE  t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' ".$tipodocu." ".$tipo." ".$tipo_nov."  
				AND (t.seguimiento_id = (SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=t.seguimiento_id  ".$consul_cond.") OR
				t.manifiesto_id = (SELECT manifiesto_id FROM manifiesto WHERE manifiesto_id=t.manifiesto_id  ".$consul_cond." ) OR
				t.despachos_urbanos_id = (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id  ".$consul_cond."))						
				 ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC 
				
				 ";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }

  public function getReporte1($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){
	  
	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}
	   	
		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,								
				t.seguimiento_id AS numero,				
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,				
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id AND placa_id=$placa_id $consul_cond)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id AND du.placa_id=$placa_id $consul_cond)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,				
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id AND m.placa_id=$placa_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				
				";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }

  public function getReporte2($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,				
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id AND placa_id=$placa_id $consul_cond)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id AND du.placa_id=$placa_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,								
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id AND m.placa_id=$placa_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }


  public function getReporte3($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,				
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id AND placa_id=$placa_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,								
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND  t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id AND du.placa_id=$placa_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,								
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id AND m.placa_id=$placa_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }


  public function getReporte4($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND  ds.novedad_id=$tipo_nov AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id AND placa_id=$placa_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND ds.novedad_id=$tipo_nov AND t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id AND du.placa_id=$placa_id $consul_cond)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				UNION ALL
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND ds.novedad_id=$tipo_nov AND t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id AND m.placa_id=$placa_id $consul_cond)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				";

    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }


  public function getReporte5($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,								
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE placa_id=$placa_id $consul_cond  )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.manifiesto_id IN (SELECT manifiesto_id FROM manifiesto WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.despachos_urbanos_id IN (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )				
				
				
				 ";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }
  
  public function getReporte6($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.manifiesto_id IN (SELECT manifiesto_id FROM manifiesto WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.despachos_urbanos_id IN (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )				
				
				
				 ";

    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;

  }

  public function getReporte7($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo'  AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo'  AND t.manifiesto_id IN (SELECT manifiesto_id FROM manifiesto WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo'  AND t.despachos_urbanos_id IN (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )				
				
				
				 ";

    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }

  public function getReporte8($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$placa_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo'  AND ds.novedad_id=$tipo_nov AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo'  AND ds.novedad_id=$tipo_nov AND t.manifiesto_id IN (SELECT manifiesto_id FROM manifiesto WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )
				
				UNION
				
				(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo'  AND ds.novedad_id=$tipo_nov AND t.despachos_urbanos_id IN (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE placa_id=$placa_id $consul_cond )	
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida 
				BETWEEN '$desde_h' AND '$hasta_h'  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )				
				
				 ";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }


  public function getReporte9($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

	   	
		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,						
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				UNION ALL
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				";

    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }

  public function getReporte10($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id $consul_cond)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM $tipodocu trafico t, detalle_seguimiento ds
				WHERE ds.novedad_id=$tipo_nov AND t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;

  }

  public function getReporte11($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND  t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  
  }

  public function getReporte12($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$cliente_id,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "(SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Seguimiento No' AS tipo_doc,				
				t.seguimiento_id AS numero,
				(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND  ds.novedad_id=$tipo_nov AND t.seguimiento_id IN (SELECT seguimiento_id FROM seguimiento WHERE cliente_id=$cliente_id $consul_cond )
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC  )
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Despacho No' AS tipo_doc,				
				(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS numero,
				(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND ds.novedad_id=$tipo_nov AND t.despachos_urbanos_id IN (SELECT d.despachos_urbanos_id FROM detalle_despacho d, remesa r, despachos_urbanos du WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.despachos_urbanos_id IS NOT NULL AND du.despachos_urbanos_id=d.despachos_urbanos_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h' 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )	
				
				
				UNION ALL
				
				
                (SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				'Manifiesto No' AS tipo_doc,				
				(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS numero,
				(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND ds.novedad_id=$tipo_nov AND t.manifiesto_id IN (SELECT d.manifiesto_id FROM detalle_despacho d, remesa r, manifiesto m WHERE  r.cliente_id=$cliente_id $consul_cond AND d.remesa_id=r.remesa_id AND d.manifiesto_id IS NOT NULL AND m.manifiesto_id=d.manifiesto_id)
				AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC )							
				";

    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;

  }

  public function getReporte13($oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				IF(t.seguimiento_id>0,'Seguimiento No',IF(t.manifiesto_id>0,'Manifiesto No','Despacho No')) AS tipo_doc,				
				IF(t.seguimiento_id>0,t.seguimiento_id,IF(t.manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS numero,
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'
				AND (t.seguimiento_id = (SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=t.seguimiento_id  ".$consul_cond.") OR
				t.manifiesto_id = (SELECT manifiesto_id FROM manifiesto WHERE manifiesto_id=t.manifiesto_id  ".$consul_cond.") OR
				t.despachos_urbanos_id = (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id  ".$consul_cond."))						 
				ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC, ds.orden_det_ruta ASC   "; 
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
		    
  
  }

  public function getReporte14($tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "SELECT  t.trafico_id,t.fecha_inicial_salida,t.hora_inicial_salida,	
				IF(t.seguimiento_id>0,'Seguimiento No',IF(t.manifiesto_id>0,'Manifiesto No','Despacho No')) AS tipo_doc,						
				IF(t.seguimiento_id>0,t.seguimiento_id,IF(t.manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS numero,
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'  
				AND (t.seguimiento_id = (SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=t.seguimiento_id  ".$consul_cond.") OR
				t.manifiesto_id = (SELECT manifiesto_id FROM manifiesto WHERE manifiesto_id=t.manifiesto_id  ".$consul_cond.") OR
				t.despachos_urbanos_id = (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id  ".$consul_cond."))						
				 ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC 				
				 ";

    	$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
  
  }

  public function getReporte15($tipo,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				IF(t.seguimiento_id>0,'Seguimiento No',IF(t.manifiesto_id>0,'Manifiesto No','Despacho No')) AS tipo_doc,				
				IF(t.seguimiento_id>0,t.seguimiento_id,IF(t.manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS numero,
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu t.estado='$tipo' AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida BETWEEN '$desde_h' AND '$hasta_h'  
				AND (t.seguimiento_id = (SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=t.seguimiento_id  ".$consul_cond.") OR
				t.manifiesto_id = (SELECT manifiesto_id FROM manifiesto WHERE manifiesto_id=t.manifiesto_id  ".$consul_cond.") OR
				t.despachos_urbanos_id = (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id  ".$consul_cond."))						
				 ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC 
				
				 ";
    	$result = $this -> DbFetchAll($select,$Conex,true);
		return $result;
		
  }


  public function getReporte16($tipo,$tipo_nov,$oficina_id,$desde,$hasta,$desde_h,$hasta_h,$tipo_doc,$consul_cond,$LIMITE,$Conex){

	    if($tipo_doc=='ALL'){	
			$tipodocu = '';
		}elseif($tipo_doc=='MF'){
			$tipodocu = ' t.manifiesto_id IS NOT NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NULL AND ';
		}elseif($tipo_doc=='DU'){	
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NULL AND t.despachos_urbanos_id IS NOT NULL AND ';
		}elseif($tipo_doc=='DP'){
			$tipodocu = ' t.manifiesto_id IS  NULL AND t.seguimiento_id IS NOT NULL AND t.despachos_urbanos_id IS  NULL AND ';
		}

		$select = "SELECT 
				t.trafico_id,
				t.fecha_inicial_salida,
				t.hora_inicial_salida,	
				IF(t.seguimiento_id>0,'Seguimiento No',IF(t.manifiesto_id>0,'Manifiesto No','Despacho No')) AS tipo_doc,				
				IF(t.seguimiento_id>0,t.seguimiento_id,IF(t.manifiesto_id>0,(SELECT manifiesto FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT despacho FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS numero,
				IF(t.seguimiento_id>0,(SELECT placa FROM seguimiento WHERE seguimiento_id=t.seguimiento_id),IF(t.manifiesto_id>0,(SELECT placa FROM manifiesto WHERE manifiesto_id=t.manifiesto_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id))) AS placa,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.origen_id) AS origen,	
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.destino_id) AS destino,					
				(SELECT ruta FROM ruta WHERE ruta_id=t.ruta_id) AS ruta,
				t.escolta_recibe,									
				t.escolta_entrega,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=ds.ubicacion_id) AS ubicacion_punto,
				ds.punto_referencia,
				(SELECT novedad FROM novedad_seguimiento WHERE novedad_id=ds.novedad_id) AS novedad,
				ds.obser_deta,
				ds.fecha_reporte,
				ds.hora_reporte,
				ds.usuario
				FROM trafico t, detalle_seguimiento ds
				WHERE $tipodocu ds.novedad_id=$tipo_nov AND t.estado='$tipo' AND ds.trafico_id=t.trafico_id AND t.fecha_inicial_salida BETWEEN '$desde' AND '$hasta' AND t.hora_inicial_salida  BETWEEN '$desde_h' AND '$hasta_h'
				AND (t.seguimiento_id = (SELECT seguimiento_id FROM seguimiento WHERE seguimiento_id=t.seguimiento_id  ".$consul_cond.") OR
				t.manifiesto_id = (SELECT manifiesto_id FROM manifiesto WHERE manifiesto_id=t.manifiesto_id  ".$consul_cond." ) OR
				t.despachos_urbanos_id = (SELECT despachos_urbanos_id FROM despachos_urbanos WHERE despachos_urbanos_id=t.despachos_urbanos_id  ".$consul_cond."))						
				  ORDER BY t.fecha_inicial_salida DESC, t.hora_inicial_salida DESC 				
				 ";
    	$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;
  }


}

?>