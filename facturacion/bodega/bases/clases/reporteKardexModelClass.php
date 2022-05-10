<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteKardexModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getOficinas($empresa_id,$oficina_id,$Conex){  
  
   $select = "SELECT oficina_id AS value, nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id";
   $result = $this -> DbFetchAll($select,$Conex);	  
   return $result;	  	    
   
  }  
  
  public function selectInformacionProductos($empresa_id,$oficina_id,$Conex){
  
    $fecha_inicio      = $this -> requestDataForQuery('fecha_inicio','date');
    $fecha_final       = $this -> requestDataForQuery('fecha_final','date');
   
    $opciones_producto  = $this -> requestData('opciones_producto');
    $producto_id        = $this -> requestData('producto_id');		
    
	if($opciones_producto == 'U'){
	 $condicionProducto = " AND p.producto_id IN ($producto_id) ";
	}else{
	    $condicionProducto = '';
	}	  
	  
	
	  
	$select_productos = "SELECT p.producto_id, p.nombre, p.referencia, p.codigo_barra,COALESCE((SELECT dp.valor FROM    wms_detalle_precios        dp WHERE dp.producto_id=p.producto_id ORDER BY dp.fecha DESC LIMIT 1),0)as valor_unitario   FROM wms_producto_inv p WHERE p.estado ='A' $condicionProducto";
	$result_productos = $this -> DbFetchAll($select_productos,$Conex,true);
	
	 for($i = 0; $i < count($result_productos); $i++){
		 
		 $producto_temp_id = $result_productos[$i]['producto_id'];
		 
		 $arrayReporte[$i]['producto_id'] 	= $result_productos[$i]['producto_id'];
		 $arrayReporte[$i]['nombre'] 		= $result_productos[$i]['nombre'];
		 $arrayReporte[$i]['referencia'] 	= $result_productos[$i]['referencia'];
		 $arrayReporte[$i]['codigo_barra'] 	= $result_productos[$i]['codigo_barra'];
		 $arrayReporte[$i]['valor_unitario'] 	= $result_productos[$i]['valor_unitario'];
		 		 
		 $select_saldo_anterior = "SELECT COALESCE((SELECT SUM(IF((SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)='C',de.cantidad_recibida,de.peso_total)) as cant FROM    wms_detalle_entrada_producto    de,    wms_entrada_producto     e WHERE e.fecha<$fecha_inicio AND e.estado ='C' AND de.entrada_producto_id=e.entrada_producto_id AND  de.producto_id=$producto_temp_id),0)-COALESCE((SELECT SUM(IF((SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)='C',de.cantidad_enviada,de.peso_total)) as cant FROM    wms_detalle_salida_producto   de,  wms_salida_producto  e WHERE e.fecha<$fecha_inicio AND e.estado ='C' AND de.salida_producto_id=e.salida_producto_id AND  de.producto_id=$producto_temp_id),0)AS saldo_anterior";
		 $result_saldo_anterior = $this -> DbFetchAll($select_saldo_anterior,$Conex,true);
		 
		 $arrayReporte[$i]['saldo_anterior'] = $result_saldo_anterior[0]['saldo_anterior'];

		 $select_saldo_anterior_cant = "SELECT COALESCE((SELECT SUM(de.cantidad_recibida) as cant FROM    wms_detalle_entrada_producto    de,    wms_entrada_producto     e WHERE e.fecha<$fecha_inicio AND e.estado ='C' AND de.entrada_producto_id=e.entrada_producto_id AND  de.producto_id=$producto_temp_id),0)-COALESCE((SELECT SUM(de.cantidad_enviada) as cant FROM    wms_detalle_salida_producto   de,  wms_salida_producto  e WHERE e.fecha<$fecha_inicio AND e.estado ='C' AND de.salida_producto_id=e.salida_producto_id AND  de.producto_id=$producto_temp_id),0)AS saldo_anterior_cant";
		
		 $result_saldo_anterior_cant = $this -> DbFetchAll($select_saldo_anterior_cant,$Conex,true);
		 
		 $arrayReporte[$i]['saldo_anterior_cantidad'] = $result_saldo_anterior_cant[0]['saldo_anterior_cant'];


		 $select_movimientos = "(SELECT 
		 								e.entrada_producto_id AS id,
										e.fecha,
		 								e.observacion,
										e.consecutivo,
										de.cantidad_recibida AS cantidad,
										de.peso_total,

										(SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)AS tipo_venta,


										IF((SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)='P',de.peso_total,IF((de.cantidad_recibida)>0,de.cantidad_recibida,0.00)) AS sum_cantidad,
										

										'E' as tipo,
										(IF((SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)='C',de.cantidad_recibida,de.peso_total)*(SELECT dp.valor FROM    wms_detalle_precios        dp WHERE dp.producto_id=de.producto_id AND dp.valor>0 ORDER BY dp.fecha DESC LIMIT 1))as valor_total,

										(SELECT dp.valor FROM    wms_detalle_precios        dp WHERE dp.producto_id=de.producto_id AND dp.valor>0 ORDER BY dp.fecha DESC LIMIT 1)as valor_uni

										FROM    wms_detalle_entrada_producto    de,    wms_entrada_producto     e WHERE e.fecha BETWEEN $fecha_inicio AND $fecha_final AND e.estado ='C' AND de.entrada_producto_id=e.entrada_producto_id AND  de.producto_id=$producto_temp_id ORDER BY e.fecha ASC)
										UNION ALL
		 						       (SELECT 
										e.salida_producto_id AS id,
										e.fecha,
										e.observacion,
										e.consecutivo,
										de.cantidad_enviada AS cantidad,
										de.peso_total,

										(SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)AS tipo_venta,
                                        
                                        IF((SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)='P',de.peso_total,IF((de.cantidad_enviada)>0,de.cantidad_enviada,0.00)) AS sum_cantidad,
										
										'S' as tipo,

										(IF((SELECT p.tipo_venta FROM wms_producto_inv p WHERE p.producto_id=de.producto_id)='C',de.cantidad_enviada,de.peso_total)*(SELECT dp.valor FROM    wms_detalle_precios        dp WHERE dp.producto_id=de.producto_id AND dp.valor>0 ORDER BY dp.fecha DESC LIMIT 1))as valor_total,

										(SELECT dp.valor FROM    wms_detalle_precios        dp WHERE dp.producto_id=de.producto_id AND dp.valor>0 ORDER BY dp.fecha DESC LIMIT 1)as valor_uni 

										FROM    wms_detalle_salida_producto   de,  wms_salida_producto  e WHERE e.fecha BETWEEN $fecha_inicio AND $fecha_final AND e.estado ='C' AND de.salida_producto_id=e.salida_producto_id AND  de.producto_id=$producto_temp_id) ORDER BY fecha ASC
		 
		 
		 ";
		
		 $result_movimientos = $this -> DbFetchAll($select_movimientos,$Conex,true);
		 
		 $arrayReporte[$i]['movimientos'] =$result_movimientos;
		 
	 }
			 
	 return  $arrayReporte;
	 
  }        
   
}

?>