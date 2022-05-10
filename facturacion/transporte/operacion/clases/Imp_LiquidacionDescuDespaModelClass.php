<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_LiquidacionDescuDespaModel extends Db{

  
  public function getEncabezado($liquidacion_despacho_descu_id,$Conex){
  
	
	if(is_numeric($liquidacion_despacho_descu_id)){
		
       $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = of.empresa_id) AS logo, (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
		(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla_emp, 
		(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
		(SELECT ti.nombre FROM tercero te, tipo_identificacion ti WHERE te.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=te.tipo_identificacion_id) AS  tipo_identificacion_emp,
		(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion_emp,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad_emp,
		(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = e.encabezado_registro_id) AS doc_contable,
		(SELECT texto_soporte FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_soporte,
		(SELECT texto_tercero FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_tercero,		
		
		(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS tipo_documento,
		
		(SELECT descripcion FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion,
		e.*,
		t.*,
		of.nombre AS nom_oficina,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi,IF(e.despachos_urbanos_id IS NOT NULL,(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id),(SELECT placa FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id)) AS placa,IF(e.despachos_urbanos_id IS NOT NULL,(SELECT nombre FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id),(SELECT nombre FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id)) AS conductor,IF(e.despachos_urbanos_id IS NOT NULL,(SELECT fecha_du FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id),(SELECT fecha_du FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id)) AS fecha_planilla,(
		
		
		SELECT nombre FROM ubicacion WHERE ubicacion_id = 
		
		IF(e.despachos_urbanos_id IS NOT NULL,(SELECT origen_id FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id),(SELECT origen_id FROM despachos_urbanos WHERE 
		despachos_urbanos_id = e.despachos_urbanos_id))	)AS origen,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = 		
		IF(e.despachos_urbanos_id IS NOT NULL,(SELECT destino_id FROM despachos_urbanos WHERE despachos_urbanos_id = e.despachos_urbanos_id),(SELECT destino_id FROM despachos_urbanos WHERE 
		despachos_urbanos_id = e.despachos_urbanos_id))		) AS destino
        FROM  liquidacion_despacho_descu  e, oficina of, tercero t WHERE e.liquidacion_despacho_descu_id  = $liquidacion_despacho_descu_id AND of.oficina_id=e.oficina_id AND t.tercero_id=e.tercero_id";			
	
	   $result = $this -> DbFetchAll($select,$Conex);	// echo  $select;
	   
	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getimputaciones($liquidacion_despacho_descu_id,$Conex){
  
	
	if(is_numeric($liquidacion_despacho_descu_id)){
				
        $select = "SELECT i.*,
				(SELECT codigo_puc FROM puc WHERE puc_id=i.puc_id) AS puc_cod				
         FROM   detalle_liquidacion_despacho_descu i   WHERE i.liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getTotal($liquidacion_despacho_descu_id,$Conex){
  
    $liquidacion_despacho_descu_id = $this -> requestDataForQuery('liquidacion_despacho_descu_id','integer');
	
	if(is_numeric($liquidacion_despacho_descu_id)){
				
        $select = "SELECT SUM(debito) AS total_debito, SUM(credito) AS total_credito		
         FROM  detalle_liquidacion_despacho_descu    WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);// echo $select;

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getTotales($liquidacion_despacho_descu_id,$Conex){
  
    $liquidacion_despacho_descu_id = $this -> requestDataForQuery('liquidacion_despacho_descu_id','integer');
	
	if(is_numeric($liquidacion_despacho_descu_id)){
				
        $select = "SELECT SUM(debito) AS total		
         FROM  detalle_liquidacion_despacho_descu    WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

}


?>