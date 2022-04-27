<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class MovimientosContablesContabilizadosModel extends Db{

  private $Permisos;
  
  

//// GRID ////
  public function getQueryManifiestoSinRemesaGrid(){
	
		
	$Query = "SELECT 
            du.despachos_urbanos_id,
            du.despacho AS numero_planilla,'DU' AS tipo,
            (SELECT o.nombre FROM oficina o WHERE o.oficina_id=du.oficina_id) AS oficina,
            (SELECT CONCAT_WS(' ', t.primer_apellido, t.segundo_apellido, t.primer_nombre, t.segundo_nombre) FROM tercero t WHERE t.tercero_id = (SELECT c.tercero_id FROM conductor c WHERE c.conductor_id = du.conductor_id)) AS conductor,
            (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = (SELECT c.tercero_id FROM conductor c WHERE c.conductor_id = du.conductor_id)) AS numero_identificacion_conductor,
            (SELECT CONCAT_WS(' ', t.primer_apellido, t.segundo_apellido, t.primer_nombre, t.segundo_nombre) FROM tercero t WHERE t.tercero_id = (SELECT te.tercero_id FROM tenedor te WHERE te.tenedor_id = du.tenedor_id)) AS tenedor,
            (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = (SELECT te.tercero_id FROM tenedor te WHERE te.tenedor_id = du.tenedor_id)) AS numero_identificacion_tenedor,
            'NO' AS nacional,
            IF((SELECT v.propio FROM vehiculo v WHERE v.placa_id = du.placa_id)=0, 'NO','SI') AS propio,
            (CASE WHEN du.estado='A' THEN 'ANULADO' WHEN du.estado='P' THEN 'PENDIENTE' WHEN du.estado='M' THEN 'MANIFESTADO' WHEN du.estado='L' THEN 'LIQUIDADO' ELSE 'CUMPLIDO' END) AS estado,
            du.fecha_du AS fecha,
            (SELECT u.nombre FROM ubicacion u WHERE du.origen_id = u.ubicacion_id) AS origen,
            (SELECT u.nombre FROM ubicacion u WHERE du.destino_id = u.ubicacion_id) AS destino,
            (SELECT COUNT(*) FROM anticipos_despacho ad WHERE ad.despachos_urbanos_id=du.despachos_urbanos_id) AS numero_anticipos
            
	          FROM despachos_urbanos du
            LEFT JOIN detalle_despacho dd ON dd.despachos_urbanos_id = du.despachos_urbanos_id
            WHERE dd.despachos_urbanos_id IS NULL AND du.estado != 'A'
            
            UNION ALL

            SELECT 
            mc.manifiesto_id,
            mc.manifiesto AS numero_planilla,'MC' AS tipo,
            (SELECT o.nombre FROM oficina o WHERE o.oficina_id=mc.oficina_id) AS oficina,
            (SELECT CONCAT_WS(' ', t.primer_apellido, t.segundo_apellido, t.primer_nombre, t.segundo_nombre) FROM tercero t WHERE t.tercero_id = (SELECT c.tercero_id FROM conductor c WHERE c.conductor_id = mc.conductor_id)) AS conductor,
            (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = (SELECT c.tercero_id FROM conductor c WHERE c.conductor_id = mc.conductor_id)) AS numero_identificacion_conductor,
            (SELECT CONCAT_WS(' ', t.primer_apellido, t.segundo_apellido, t.primer_nombre, t.segundo_nombre) FROM tercero t WHERE t.tercero_id = (SELECT te.tercero_id FROM tenedor te WHERE te.tenedor_id = mc.tenedor_id)) AS tenedor,
            (SELECT t.numero_identificacion FROM tercero t WHERE t.tercero_id = (SELECT te.tercero_id FROM tenedor te WHERE te.tenedor_id = mc.tenedor_id)) AS numero_identificacion_tenedor,
            'NO' AS nacional,
            IF((SELECT v.propio FROM vehiculo v WHERE v.placa_id = mc.placa_id)=0, 'NO','SI') AS propio,
            (CASE WHEN mc.estado='A' THEN 'ANULADO' WHEN mc.estado='P' THEN 'PENDIENTE' WHEN mc.estado='M' THEN 'MANIFESTADO' WHEN mc.estado='L' THEN 'LIQUIDADO' ELSE 'CUMPLIDO' END) AS estado,
            mc.fecha_mc AS fecha,
            (SELECT u.nombre FROM ubicacion u WHERE mc.origen_id = u.ubicacion_id) AS origen,
            (SELECT u.nombre FROM ubicacion u WHERE mc.destino_id = u.ubicacion_id) AS destino,
            (SELECT COUNT(*) FROM anticipos_manifiesto ad WHERE ad.manifiesto_id=mc.manifiesto_id) AS numero_anticipos
            
	          FROM manifiesto mc
            LEFT JOIN detalle_despacho dd ON dd.manifiesto_id = mc.manifiesto_id
            WHERE dd.manifiesto_id IS NULL AND mc.estado != 'A'
            ";
   
     return $Query;
   }
   
}



?>