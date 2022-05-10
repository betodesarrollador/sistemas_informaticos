<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_LiquidacionModel extends Db{

  
  public function getEncabezado($liquidacion_despacho_id,$Conex){
  
	
	if(is_numeric($liquidacion_despacho_id)){
	
		/*		
        $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = of.empresa_id) AS logo, (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
		(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla_emp, 
		(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
		(SELECT ti.nombre FROM tercero te, tipo_identificacion ti WHERE te.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=te.tipo_identificacion_id) AS  tipo_identificacion_emp,
		(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion_emp,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad_emp,

		(SELECT texto_soporte FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_soporte,
		(SELECT texto_tercero FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_tercero,		
		
		(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS tipo_documento,
		
		(SELECT descripcion FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion,
		(SELECT nombre FROM forma_pago WHERE forma_pago_id=e.forma_pago_id) AS  formapago,		
		e.*,
		t.*,
		of.nombre AS nom_oficina,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi
        FROM encabezado_de_registro  e, oficina of, tercero t WHERE e.encabezado_registro_id = $encabezado_registro_id AND of.oficina_id=e.oficina_id AND t.tercero_id=e.tercero_id";		*/
		
		
		
       $select = "SELECT (SELECT logo FROM empresa WHERE empresa_id = of.empresa_id) AS logo, (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS razon_social_emp,
		(SELECT sigla FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS sigla_emp, 
		(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS  numero_identificacion_emp,
		(SELECT ti.nombre FROM tercero te, tipo_identificacion ti WHERE te.tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id) AND ti.tipo_identificacion_id=te.tipo_identificacion_id) AS  tipo_identificacion_emp,
		(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id)) AS direccion_emp,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = of.empresa_id))) AS ciudad_emp,

		(SELECT texto_soporte FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_soporte,
		(SELECT texto_tercero FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id) AS texto_tercero,		
		
		(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS tipo_documento,
		
		(SELECT descripcion FROM tipo_identificacion WHERE tipo_identificacion_id=t.tipo_identificacion_id) AS  tipo_identificacion,
		/*(SELECT nombre FROM forma_pago WHERE forma_pago_id=e.forma_pago_id) AS  formapago,		*/
		
		'' AS  formapago,
		e.*,
		t.*,
		of.nombre AS nom_oficina,
		e.observaciones AS observaciones,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=of.ubicacion_id) AS ciudad_ofi
        FROM  liquidacion_despacho  e, oficina of, tercero t WHERE e.liquidacion_despacho_id  = $liquidacion_despacho_id AND of.oficina_id=e.oficina_id AND t.tercero_id=e.tercero_id";			
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getimputaciones($liquidacion_despacho_id,$Conex){
  
	
	if(is_numeric($liquidacion_despacho_id)){
				
        $select = "SELECT i.*,
				(SELECT codigo_puc FROM puc WHERE puc_id=i.puc_id) AS puc_cod				
         FROM   detalle_liquidacion_despacho i   WHERE i.liquidacion_despacho_id = $liquidacion_despacho_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }


  public function getTotal($liquidacion_despacho_id,$Conex){
  
    $liquidacion_despacho_id = $this -> requestDataForQuery('liquidacion_despacho_id','integer');
	
	if(is_numeric($liquidacion_despacho_id)){
				
        $select = "SELECT SUM(debito) AS total_debito, SUM(credito) AS total_credito		
         FROM  detalle_liquidacion_despacho    WHERE liquidacion_despacho_id = $liquidacion_despacho_id ";		
	
	    $result = $this -> DbFetchAll($select,$Conex);

	  
	}else{
   	    $result = array();
	  }
	return $result;
  }

  public function getTotales($liquidacion_despacho_id,$Conex){
  
    $liquidacion_despacho_id = $this -> requestDataForQuery('liquidacion_despacho_id','integer');
	
	if(is_numeric($liquidacion_despacho_id)){
				
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