<?php

ini_set("memory_limit","1024M");

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DeclaracionModel extends Db{

  private $Permisos;
  private $mes_contable_id;
  private $periodo_contable_id;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getCodigoPuc($puc_id,$Conex){
  
    $select = "SELECT codigo_puc FROM puc WHERE puc_id = $puc_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result[0]['codigo_puc'];  
  }
  
  public function selectAuxiliarCentrosTerceros($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$tipo_impuesto,$desde,$hasta,$agrupar,$Conex){
   
    include_once("../../../framework/clases/utilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();
	$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);
    $arrayResult         = array();

    if($opciones_centros == 'T'){ 
	  	       $consul_ordensql="p.codigo_puc, e.fecha";
      $select="SELECT 
				  e.encabezado_registro_id,
				  
				  (SELECT codigo FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_doc,
				  IF(i.tercero_id>0,i.tercero_id,-1) AS tercero_id,
				  IF(i.tercero_id>0,
				 (SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre, segundo_nombre,razon_social) FROM tercero WHERE tercero_id=i.tercero_id),
				 'SIN TERCERO')	AS tercero,
				 
				 IF(i.tercero_id>0,
				 (SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre, segundo_nombre,razon_social) FROM tercero WHERE tercero_id=i.tercero_id),
				 (SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre, segundo_nombre,razon_social) FROM tercero WHERE tercero_id=e.tercero_id))	AS tercero_formato,

				 IF(i.tercero_id>0,
				 (SELECT u.nombre FROM tercero t, ubicacion u WHERE u.ubicacion_id=t.ubicacion_id AND t.tercero_id=i.tercero_id),
				 'No registra')	AS ciudad,

				  IF(i.tercero_id>0,
				 (SELECT numero_identificacion FROM tercero WHERE tercero_id=i.tercero_id),
				 'SIN TERCERO')	AS tercero_iden,

				  p.puc_id,
				  CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
				  e.fecha,
				  o.codigo_centro AS oficina,
				  td.codigo AS documento,
				  (SELECT IF(centro_de_costo_id>0,codigo,'N/A') FROM centro_de_costo WHERE centro_de_costo_id=i.centro_de_costo_id ) AS centro_costo,
				  e.consecutivo,
				  i.descripcion,
				  IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #  ', e.numero_soporte),' ') AS cheque,
				  i.porcentaje,
				  i.debito,
				  i.credito, 
				  i.base,
				  e.fecha AS fecha_reg
				  FROM encabezado_de_registro e, imputacion_contable i, tipo_de_documento td, puc p, oficina o 
				 WHERE  e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id 
				 AND (i.centro_de_costo_id IN ($centro_de_costo_id) OR  i.centro_de_costo_id IS NULL) AND i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos='$tipo_impuesto')  
				 AND i.puc_id = p.puc_id  AND e.tipo_documento_id = td.tipo_documento_id 	AND e.oficina_id = o.oficina_id 
				 ORDER BY $consul_ordensql ASC ";
				  
	}else{
	       $consul_ordensql="p.codigo_puc, e.fecha";
		  $select = "(SELECT e.encabezado_registro_id,t.tercero_id,
			CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,
			segundo_nombre,razon_social),	t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
			e.fecha,o.codigo_centro AS oficina,td.codigo AS documento,cc.codigo AS centro_costo,e.consecutivo,i.descripcion,
			IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #  ',e.numero_soporte),'') AS cheque,i.base,i.debito,i.credito
		  FROM encabezado_de_registro e, imputacion_contable i, tercero t, tipo_de_documento td, centro_de_costo cc,puc p, oficina o 
		  WHERE  e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND 
		  i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos='$tipo_impuesto')    AND i.puc_id = p.puc_id AND 
		  i.tercero_id = t.tercero_id AND e.tipo_documento_id = td.tipo_documento_id 	AND e.oficina_id = o.oficina_id AND i.centro_de_costo_id = 
		  cc.centro_de_costo_id  ORDER BY $consul_ordensql ASC)  
		  
		  UNION ALL 
		  (SELECT 
		  e.encabezado_registro_id,-1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS 
		  codigo_puc,e.fecha,o.codigo_centro AS oficina,td.codigo AS documento,cc.codigo AS centro_costo,e.consecutivo,i.descripcion,IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #   ',e.numero_soporte),'') AS cheque,i.base,i.debito,i.credito 
		  FROM encabezado_de_registro e, imputacion_contable i, tipo_de_documento td, centro_de_costo cc,puc p, oficina o 
		  WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND i.centro_de_costo_id 
		  IN ($centro_de_costo_id) AND i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos='$tipo_impuesto')   AND i.puc_id = p.puc_id AND i.tercero_id IS NULL AND 
		  e.tipo_documento_id = td.tipo_documento_id 	AND e.oficina_id = o.oficina_id AND i.centro_de_costo_id = cc.centro_de_costo_id  
		  ORDER BY   $consul_ordensql ASC)	";	

	}
	
    $arrayResult = $this -> DbFetchAll($select,$Conex,true);    	
	
	if($agrupar == 'cuenta'){ 

		$select = "SELECT DISTINCT i.puc_id 
		FROM encabezado_de_registro e, imputacion_contable i 
		WHERE  e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND 
		i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos='$tipo_impuesto')   ORDER BY e.fecha ASC";
		
		$cuentasMovimiento = $this -> DbRecordToText($select,$Conex,true);		
		  
		$desdeSaldoTercero  = null;
		$hastaSaldoTercero  = $desde;   
	
		 if($opciones_centros == 'T'){	
		 
			 $select = "
			 
			 (SELECT p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
			(CASE WHEN  p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo
			FROM encabezado_de_registro e, 	 imputacion_contable i,puc p 
			WHERE  e.encabezado_registro_id = i.encabezado_registro_id
			 AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos='$tipo_impuesto')   
			 AND i.puc_id NOT IN ($cuentasMovimiento) AND e.fecha <= 
			 DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY)  GROUP BY i.puc_id  ORDER BY p.codigo_puc )  	 
			 
			 UNION ALL
			  
			 (SELECT p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
			(CASE WHEN   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo
			 FROM encabezado_de_registro e,  imputacion_contable i,puc p 
			 WHERE e.encabezado_registro_id = i.encabezado_registro_id
			 AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos='$tipo_impuesto')   
			 AND i.puc_id NOT IN ($cuentasMovimiento) AND e.fecha <= 
			 DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY)  
			 GROUP BY i.puc_id  ORDER BY p.codigo_puc) ";	
			
		 }else{
		 
			 $select = "(SELECT p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
			(CASE WHEN  p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo,
			 e.fecha AS fecha_reg 
			FROM encabezado_de_registro e, 	 imputacion_contable i,puc p 
			 WHERE  e.encabezado_registro_id = i.encabezado_registro_id
			 AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN (SELECT puc_id FROM impuesto WHERE exentos='$tipo_impuesto')  
			 AND i.puc_id NOT IN ($cuentasMovimiento) AND e.fecha <= 
			 DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY)  
			 GROUP BY i.puc_id  ORDER BY p.codigo_puc,e.fecha) ";	
	
		 }
		
		if(strlen($cuentasMovimiento)>0){  
			$saldoTercerosSinMov = $this -> DbFetchAll($select,$Conex,true);    	
		}else{
			$saldoTercerosSinMov;    	
		}
		
		if(is_array($saldoTercerosSinMov)){
		
		  if(is_array($arrayResult)){ 
		  	
			$arrayResult = array_values(array_merge($arrayResult,$saldoTercerosSinMov));	  
			if($cuenta_desde_id!=$cuenta_hasta_id && $opciones_centros != 'T'){ 
				$arrayResult = $this -> sortResultByField($arrayResult,'fecha',SORT_ASC);  	  	  
				$arrayResult = $this -> sortResultByField($arrayResult,'codigo_puc',SORT_ASC);  	  	  
			}
		  }else{
			  $arrayResult = $saldoTercerosSinMov;	  	  
		  }
		  
		}else{
		
			 if(!is_array($arrayResult)){
			   $arrayResult = array();
			 }else{
				if($cuenta_desde_id!=$cuenta_hasta_id){	 	
					$arrayResult = $this -> sortResultByField($arrayResult,'codigo_puc',SORT_ASC);  	  	  
				}else{ 
					$arrayResult = $this -> sortResultByField($arrayResult,'codigo_puc',SORT_ASC);  	  	  
				}
				
			 }
		
		  }
	 }  

  	return $arrayResult;
  
  }
  //AND i.puc_id IN (SELECT puc_id FROM impuestos WHERE exentos='$tipo_impuesto')  

  
  public function selectSaldoCentrosPuc($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$puc_id,$desde,$Conex){  
  
    include_once("../../../framework/clases/utilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();
	$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
    $arrayResult         = array();  
  
    $select = "SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM 
	 encabezado_de_registro e, imputacion_contable i,puc p WHERE  e.encabezado_registro_id 
	 = i.encabezado_registro_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND 
	 i.puc_id = $puc_id AND e.fecha <= DATE_SUB('$desde',INTERVAL 1 DAY) GROUP BY i.puc_id";    
  
     $result = $this -> DbFetchAll($select,$Conex,true);    
	 
	 return strlen(trim($result[0]['saldo'])) > 0 ? $result[0]['saldo'] : 0;	        
  
  }  
  
  
  public function getNaturalezaCodigoPuc($puc_id,$Conex){
  
    $select = "SELECT naturaleza FROM puc WHERE puc_id = $puc_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result[0]['naturaleza'];  
  
  }
  
}


?>