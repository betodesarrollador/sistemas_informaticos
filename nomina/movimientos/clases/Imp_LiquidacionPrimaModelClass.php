<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class Imp_LiquidacionPrimaModel extends Db{ 
  
 /* public function getLiquidacion($select_deb_total,$select_cre_total,$select_deb,$select_cre,$select_debExt,$select_creExt,$select_sal,$empresa_id,$Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT ln.*, dl.*,

				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				 $select_deb $select_debExt $select_cre $select_creExt $select_sal $select_deb_total $select_cre_total
				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 

				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base 				

				FROM liquidacion_prima ln, detalle_prima_puc dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id ) 
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id )
				AND dl.liquidacion_prima_id=ln.liquidacion_prima_id AND ln.estado!='A' GROUP BY ln.contrato_id ORDER BY empleado";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true); 
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

*/
  public function getConceptoDebito($Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT dl.desc_prima
				FROM liquidacion_prima ln, detalle_prima_puc dl
				WHERE ln.liquidacion_prima_id=$liquidacion_prima_id  
				AND dl.liquidacion_prima_id=ln.liquidacion_prima_id AND dl.deb_item_prima>0 AND ln.estado!='A' 
				GROUP BY ln.consecutivo ORDER BY dl.detalle_prima_puc_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getConceptoCredito($Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT dl.concepto
				FROM liquidacion_prima ln, detalle_prima_puc dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id ) 
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id )
				AND dl.liquidacion_prima_id=ln.liquidacion_prima_id AND dl.credito>0 AND dl.sueldo_pagar=0 AND ln.estado!='A'  AND dl.concepto_area_id IS NULL
				GROUP BY dl.concepto ORDER BY dl.detalle_prima_puc_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


  public function getConceptoDebitoExt($Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT dl.concepto_area_id, (SELECT descripcion FROM concepto_area WHERE concepto_area_id=dl.concepto_area_id) AS concepto
				FROM liquidacion_prima ln, detalle_prima_puc dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id ) 
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id )
				AND dl.liquidacion_prima_id=ln.liquidacion_prima_id AND dl.debito>0 AND dl.sueldo_pagar=0 AND ln.estado!='A' AND dl.concepto_area_id IS NOT NULL
				GROUP BY dl.concepto_area_id ORDER BY dl.detalle_prima_puc_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getConceptoCreditoExt($Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT dl.concepto_area_id, (SELECT descripcion FROM concepto_area WHERE concepto_area_id=dl.concepto_area_id) AS concepto
				FROM liquidacion_prima ln, detalle_prima_puc dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id ) 
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id )
				AND dl.liquidacion_prima_id=ln.liquidacion_prima_id AND dl.credito>0 AND dl.sueldo_pagar=0 AND ln.estado!='A'  AND dl.concepto_area_id IS NOT NULL
				GROUP BY dl.concepto_area_id ORDER BY dl.detalle_prima_puc_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


  public function getConceptoSaldo($Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT dl.concepto
				FROM liquidacion_prima ln, detalle_prima_puc dl
				WHERE ln.fecha_inicial = (SELECT fecha_inicial FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id ) 
				AND ln.fecha_final = (SELECT fecha_final FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id )
				AND dl.liquidacion_prima_id=ln.liquidacion_prima_id AND (dl.credito+dl.debito)>0  AND dl.sueldo_pagar=1 AND ln.estado!='A' 
				GROUP BY dl.concepto ORDER BY dl.detalle_prima_puc_id ASC  ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  //desprendible de pago
  public function getLiquidacion($desprendibles,$empresa_id,$Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT ln.*,
				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 

				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base ,				
				
				IF((SELECT DATEDIFF(ln.fecha_liquidacion,(SELECT c.fecha_inicio	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id )))>180,180,(SELECT DATEDIFF(ln.fecha_liquidacion,(SELECT c.fecha_inicio	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id )))-1)as dias				


				FROM liquidacion_prima ln
				WHERE ln.liquidacion_prima_id IN(SELECT liquidacion_prima_id FROM liquidacion_prima WHERE consecutivo = (SELECT consecutivo FROM liquidacion_prima WHERE liquidacion_prima_id = $liquidacion_prima_id))";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }
  
  public function getLiquidacion1($desprendibles,$empresa_id,$Conex){
 
    $liquidacion_prima_id = $this -> requestDataForQuery('liquidacion_prima_id','integer');
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT ln.*,
				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 

				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base,
				
				IF((SELECT DATEDIFF(ln.fecha_liquidacion,c.fecha_inicio))>180,180,(SELECT DATEDIFF(ln.fecha_liquidacion,c.fecha_inicio))as dias				

				FROM liquidacion_prima ln
				WHERE ln.contrato_id =(SELECT contrato_id FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id )
				AND ln.fecha_final <= (SELECT fecha_final FROM liquidacion_prima WHERE liquidacion_prima_id=$liquidacion_prima_id ) AND ln.estado!='A' 
				 ORDER BY empleado ASC, ln.fecha_final DESC LIMIT 0, $desprendibles";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getDetalles($liquidacion_prima_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT  IF(dl.deb_item_prima>0,dl.deb_item_prima,dl.cre_item_prima)as valor
				FROM  detalle_prima_puc dl
				WHERE dl.liquidacion_prima_id = $liquidacion_prima_id AND contrapartida=1";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
		$result = $result[0]['valor'];
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


  public function getLiquidacion2($liquidacion_prima_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT ln.*,
				(SELECT logo FROM empresa WHERE empresa_id = $empresa_id) AS logo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)AS nombre_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nombre_empresa,
				(SELECT CONCAT_WS(' - ',t.numero_identificacion,t.digito_verificacion)AS nit_emp FROM empresa e, tercero t WHERE e.empresa_id = $empresa_id AND e.tercero_id=t.tercero_id) AS nit_empresa,					

				(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS empleado,
				(SELECT t.numero_identificacion 
					FROM empleado e, tercero t, contrato c  WHERE c.contrato_id=ln.contrato_id AND e.empleado_id=c.empleado_id AND t.tercero_id=e.tercero_id) AS identificacion, 

				(SELECT ca.nombre_cargo	FROM cargo ca, contrato c  WHERE c.contrato_id=ln.contrato_id AND c.cargo_id=ca.cargo_id) AS cargo, 
				(SELECT c.sueldo_base	FROM  contrato c  WHERE c.contrato_id=ln.contrato_id ) AS sueldo_base 				

				FROM liquidacion_prima ln
				WHERE ln.liquidacion_prima_id=$liquidacion_prima_id 
				 ORDER BY ln.liquidacion_prima_id DESC ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }

  public function getLiquidacion3($liquidacion_prima_id,$empresa_id,$Conex){
 
	
	if(is_numeric($liquidacion_prima_id)){

  	     $select = "SELECT ln.*		FROM liquidacion_prima ln
				WHERE ln.liquidacion_prima_id=$liquidacion_prima_id AND ln.estado!='A' ";
				
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
    }
	return $result;
  }


   
}


?>