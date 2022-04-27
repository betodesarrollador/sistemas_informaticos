<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_DevolucionModel extends Db{
  
  public function getDevolucion($oficina_id,$Conex,$usuario){
  
	$devolucion_id=$_REQUEST['devolucion_id'];			
	$select = "SELECT
				r.fecha_dev,
				(SELECT t.numero_identificacion FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS identificacion_prove,
				(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
			
				(SELECT (CONCAT_WS(' - ',t.numero_identificacion, digito_verificacion)) FROM empresa e, tercero t WHERE t.tercero_id=t.tercero_id AND e.tercero_id=t.tercero_id) AS id_empresa,
				(SELECT razon_social FROM empresa e, tercero t WHERE t.tercero_id=t.tercero_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT logo FROM empresa e, tercero t WHERE t.tercero_id=t.tercero_id AND e.tercero_id=t.tercero_id) AS logo,
				(SELECT telefono FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS telefono, 
				(SELECT movil FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS movil,
				(SELECT direccion FROM tercero t, proveedor p WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS direccion,
				(SELECT u.nombre FROM ubicacion u, oficina o WHERE r.oficina_id=o.oficina_id AND o.ubicacion_id=u.ubicacion_id) AS ciudad_devolucion,
				r.usuario_registra,
				r.estado
			FROM 
				devolucion r
			WHERE 
				r.devolucion_id=$devolucion_id";	
	// echo $select;
	
	$result  = $this -> DbFetchAll($select,$Conex,true);	
	$devolucion = $result;
	
	
			
	return $devolucion;
	
  }
  

 public function getDetalle($oficina_id,$Conex,$usuario){
  
	$devolucion_id=$_REQUEST['devolucion_id'];

	$select = "SELECT
					g.numero_guia,
					g.valor_flete AS valor_dev,
					g.fecha_guia,
					g.destinatario,
					g.direccion_destinatario,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=g.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=g.destino_id) AS destino,
					g.descripcion_producto,
					(SELECT cd.causal FROM causal_devolucion cd WHERE dd.causal_devolucion_id=cd.causal_devolucion_id) AS causal
				FROM
					detalle_devolucion dd,
					guia g
				WHERE
					dd.devolucion_id=$devolucion_id
					AND g.guia_id=dd.guia_id
				ORDER BY
					g.numero_guia
					ASC
				";	
	
	$result  = $this -> DbFetchAll($select,$Conex,true);	
			
	return $result;
	
  }
   
}


?>