<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_LiquidacionGuiasModel extends Db{

  
  public function getEncabezado($liquidacion_guias_cliente_id,$Conex){
  
	
	if(is_numeric($liquidacion_guias_cliente_id)){
		
       $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = of.empresa_id) AS logo, 
	    (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
		(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla_emp, 
		(SELECT CONCAT_WS(' - ',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
		(SELECT ti.nombre FROM tercero te, tipo_identificacion ti WHERE te.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=te.tipo_identificacion_id) AS  tipo_identificacion_emp,
		(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion_emp,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad_emp,
		(SELECT descripcion FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_identificacion,
		(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido) AS nombre_cliente FROM tercero te WHERE te.tercero_id=c.tercero_id) AS nombre_cliente,
		CASE e.estado WHEN 'A' THEN 'ANULADO' WHEN 'F' THEN 'FACTURADO' ELSE 'LIQUIDADO' END AS estado_liq,
		(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido) AS nombre_usuario FROM tercero te WHERE te.tercero_id=u.tercero_id) AS nombre_usuario,		
		e.*,
		t.*
        FROM  liquidacion_guias_cliente  e, oficina of, tercero t, cliente c, usuario u WHERE e.liquidacion_guias_cliente_id  = $liquidacion_guias_cliente_id AND of.oficina_id=e.oficina_id AND e.cliente_id=c.cliente_id AND e.usuario_id=u.usuario_id";			
		//echo $select;
	   $result = $this -> DbFetchAll($select,$Conex);	  
	   
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getimputaciones($liquidacion_guias_cliente_id,$Conex){
  
	$resultf=array();
	$i=0;
	if(is_numeric($liquidacion_guias_cliente_id)){
				
       	$select = "SELECT
					r.liquidacion_guias_cliente_id,
					r.fecha_inicial,
					r.fecha_final,
					r.valor,
					YEAR(g.fecha_guia) AS fecha_guia,
					g.tipo_envio_id,
					g.tipo_servicio_mensajeria_id
					FROM liquidacion_guias_cliente r, detalle_liq_guias_cliente d, guia g
					WHERE r.liquidacion_guias_cliente_id=$liquidacion_guias_cliente_id AND d.liquidacion_guias_cliente_id=r.liquidacion_guias_cliente_id
					AND g.guia_id=d.guia_id GROUP BY g.tipo_envio_id, g.tipo_servicio_mensajeria_id";
		
		$result = $this -> DbFetchAll($select,$Conex,false); 
				
		foreach($result as $resultado){
			for($p=1;$p<=5;$p++){		
				$inicial=(($p*1000)-1000);
				$inicial=$inicial>0?($inicial+1):$inicial; 
				$final=$p*1000;
				
				$select_tipo = "SELECT
								COUNT(*) AS cantidad, SUM(g.valor_total) AS valor_facturar,
								(SELECT nombre_corto FROM tipo_servicio_mensajeria WHERE tipo_servicio_mensajeria_id=$resultado[tipo_servicio_mensajeria_id]) AS tipo_mensajeria,
								(SELECT nombre FROM tipo_envio WHERE tipo_envio_id=$resultado[tipo_envio_id]) AS tipo_envio								
								FROM  detalle_liq_guias_cliente d, guia g
								WHERE d.liquidacion_guias_cliente_id=$resultado[liquidacion_guias_cliente_id] 
								AND g.guia_id=d.guia_id AND g.tipo_envio_id=$resultado[tipo_envio_id]  AND g.peso BETWEEN $inicial AND $final
								AND g.tipo_servicio_mensajeria_id=$resultado[tipo_servicio_mensajeria_id]";
	
				$result_tipo = $this -> DbFetchAll($select_tipo,$Conex,false);   
				if($result_tipo[0][cantidad]>0){
					$resultf[$i]['descripcion']		=" ".$result_tipo[0][tipo_mensajeria]." ".$result_tipo[0][tipo_envio]." Kg".$p;
					$resultf[$i]['cantidad'] 		= $result_tipo[0][cantidad]>0 ? $result_tipo[0][cantidad]:0;
					$resultf[$i]['valor_facturar'] 	= $result_tipo[0][valor_facturar]>0 ? $result_tipo[0][valor_facturar] : 0;
					$resultf[$i]['subtotal'] 		=  $subtotal + $result_tipo[0][valor_facturar];
					$i++;
				}
			}
		}

	  
	}else{
   	    $resultf = array();
   }
	return $resultf;
  }


  public function getTotal($liquidacion_guias_cliente_id,$Conex){
  
    $liquidacion_guias_cliente_id = $this -> requestDataForQuery('liquidacion_guias_cliente_id','integer');
	
	if(is_numeric($liquidacion_guias_cliente_id)){
				
 	$select = "SELECT
					COUNT(*) AS cantidad
					FROM liquidacion_guias_cliente r, detalle_liq_guias_cliente d, guia g
					WHERE r.liquidacion_guias_cliente_id=$liquidacion_guias_cliente_id AND d.liquidacion_guias_cliente_id=r.liquidacion_guias_cliente_id
					AND g.guia_id=d.guia_id ";
		
		$result = $this -> DbFetchAll($select,$Conex,false); 
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getTotales($liquidacion_guias_cliente_id,$Conex){
  
    $liquidacion_guias_cliente_id = $this -> requestDataForQuery('liquidacion_guias_cliente_id','integer');
	
	if(is_numeric($liquidacion_guias_cliente_id)){
				
        $select = "SELECT SUM(debito) AS total		
         FROM  detalle_liquidacion_despacho    WHERE liquidacion_despacho_id = $liquidacion_despacho_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

}


?>