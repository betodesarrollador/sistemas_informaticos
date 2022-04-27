<?php

ini_set("memory_limit","1024M");

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LibrosAuxiliaresModel extends Db{

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
  
  public function selectAuxiliarCentrosTerceros($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$cuentas,$desde,$hasta,$agrupar,$Conex){
   
    include_once("UtilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();
	$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);
    $arrayResult         = array();

    if($opciones_centros == 'T'){ //echo 'no';
	
      $select="SELECT 
				  e.encabezado_registro_id,
				  IF(i.tercero_id>0,i.tercero_id,-1) AS tercero_id,
				  IF(i.tercero_id>0,
				 (SELECT CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre, segundo_nombre,razon_social),numero_identificacion) FROM tercero WHERE tercero_id=i.tercero_id),
				 'SIN TERCERO')	AS tercero,
				  p.puc_id,
				  CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
				  e.fecha,
				  o.codigo_centro AS oficina,
				  td.codigo AS documento,
				  (SELECT IF(centro_de_costo_id>0,codigo,'N/A') FROM centro_de_costo WHERE centro_de_costo_id=i.centro_de_costo_id ) AS centro_costo,
				  e.consecutivo,
				  i.descripcion,
				  IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #  ', e.numero_soporte),' ') AS cheque,
				  i.debito,
				  i.credito, 
				  e.fecha AS fecha_reg
				  FROM encabezado_de_registro e, imputacion_contable i, tipo_de_documento td, puc p, oficina o 
				 WHERE e.tipo_documento_id  IN ($documentos) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id 
				 AND (i.centro_de_costo_id IN ($centro_de_costo_id) OR  i.centro_de_costo_id IS NULL) AND  i.puc_id IN ($cuentas) 
				 AND i.puc_id = p.puc_id  AND e.tipo_documento_id = td.tipo_documento_id 	AND e.oficina_id = o.oficina_id 
				 ORDER BY p.codigo_puc, i.tercero_id, e.fecha ASC ";
				  

	}else{

      $select = "(SELECT e.encabezado_registro_id,t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,
	  segundo_nombre,razon_social),	t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS 
	  codigo_puc,e.fecha,o.codigo_centro AS oficina,td.codigo AS documento,cc.codigo AS centro_costo,e.consecutivo,i.descripcion,
	  IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #  ', e.numero_soporte),' ') AS cheque,i.debito,i.credito 
	  FROM encabezado_de_registro e, imputacion_contable i, tercero t, tipo_de_documento td, centro_de_costo cc,puc p, oficina o WHERE 
	  e.tipo_documento_id IN ($documentos) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND 
	  i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas)  AND i.puc_id = p.puc_id AND 
	  i.tercero_id = t.tercero_id AND e.tipo_documento_id = td.tipo_documento_id 	AND e.oficina_id = o.oficina_id AND i.centro_de_costo_id = 
	  cc.centro_de_costo_id  ORDER BY p.codigo_puc,tercero,e.fecha,oficina,documento,centro_costo,e.consecutivo ASC) 
	  UNION ALL (SELECT 
	  e.encabezado_registro_id,-1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS 
	  codigo_puc,e.fecha,o.codigo_centro AS oficina,td.codigo AS documento,cc.codigo AS centro_costo,e.consecutivo,i.descripcion,
	  IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #  ', e.numero_soporte),' ') AS cheque,i.debito,i.credito 
	  FROM encabezado_de_registro e, imputacion_contable i, tipo_de_documento td, centro_de_costo cc,puc p, oficina o 
	  WHERE e.tipo_documento_id  IN ($documentos) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND i.centro_de_costo_id 
	  IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas)  AND i.puc_id = p.puc_id AND i.tercero_id IS NULL AND 
	  e.tipo_documento_id = td.tipo_documento_id 	AND e.oficina_id = o.oficina_id AND i.centro_de_costo_id = cc.centro_de_costo_id  
	  ORDER BY p.codigo_puc,tercero,e.fecha,oficina,documento,centro_costo,e.consecutivo ASC)	";		

	  }
	
    $arrayResult = $this -> DbFetchAll($select,$Conex,true);    	
	
	if($agrupar == 'defecto'){ 

    $select = "SELECT DISTINCT i.tercero_id FROM encabezado_de_registro e, imputacion_contable i WHERE e.tipo_documento_id IN 
	($documentos) 
	AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND i.centro_de_costo_id IN 
	($centro_de_costo_id)
	AND  i.puc_id IN ($cuentas)  ORDER BY e.fecha ASC";

    $tercerosMovimiento = $this -> DbRecordToText($select,$Conex,true);		

    $select = "SELECT DISTINCT i.puc_id FROM encabezado_de_registro e, imputacion_contable i WHERE e.tipo_documento_id IN 
	($documentos) 
	AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND i.centro_de_costo_id IN 
	($centro_de_costo_id)
	AND  i.puc_id IN ($cuentas)   ORDER BY e.fecha ASC";
	
    $cuentasMovimiento = $this -> DbRecordToText($select,$Conex,true);		

    $desdeSaldoTercero  = null;
	$hastaSaldoTercero  = $desde;   

	if(strlen(trim($tercerosMovimiento)) > 0){
	
     if($opciones_centros == 'T'){	 
	 
     $select = "(SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
	 t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg  FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id NOT IN 
	 ($tercerosMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentasMovimiento) AND e.fecha 
	 BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc)  
	 
	 UNION ALL
	 
     (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg  FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id IS NULL AND i.puc_id = 
	 p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentasMovimiento) AND e.fecha 
	 BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc)  	
	 
	 UNION ALL
	  
    (SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
	 t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg  FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id NOT IN 
	 ($tercerosMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND i.puc_id IN ($cuentasMovimiento) AND e.fecha 
	 BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc)  	  
	 
	 
	 UNION ALL
	 
	 
     (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg  FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id IS NULL AND i.puc_id = 
	 p.puc_id AND i.centro_de_costo_id IS NULL AND i.puc_id IN ($cuentasMovimiento) AND e.fecha 
	 BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc)  	 
	 
	 	 
	 UNION ALL (SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
	 t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg  FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id AND 
	 i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND i.puc_id NOT IN ($cuentasMovimiento) 
	 AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id 
	 GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc)
	 
	 
     UNION ALL (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg  FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id AND 
	 i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND i.puc_id NOT IN ($cuentasMovimiento) 
	 AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc)	 
	 
	 
	 UNION ALL (SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
	 t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg  FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id AND 
	 i.centro_de_costo_id IS NULL AND  i.puc_id IN ($cuentas) AND i.puc_id NOT IN ($cuentasMovimiento) 
	 AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc)	 
	 
	 
    UNION ALL (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id AND 
	 i.centro_de_costo_id IS NULL AND  i.puc_id IN ($cuentas) AND i.puc_id NOT IN ($cuentasMovimiento) 
	 AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc)	 ORDER BY  fecha_reg ASC	 
	 
	 ";	 	//echo 	$select;

	 }else{

	 
     $select = "(SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
	 t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id NOT IN 
	 ($tercerosMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentasMovimiento) AND e.fecha 
	 BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc,e.fecha)  
	 
	 
	 UNION ALL
	 
	 
     (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id IS NULL AND i.puc_id = 
	 p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentasMovimiento) AND e.fecha 
	 BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc,e.fecha)  	 
	 
	 
	 
	 UNION ALL (SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
	 t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id AND 
	 i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND i.puc_id NOT IN ($cuentasMovimiento) 
	 AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc,e.fecha)
	 
	 
	  UNION ALL (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
	 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc 
	 p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id AND 
	 i.tercero_id IS NULL AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND i.puc_id 
	 NOT IN ($cuentasMovimiento) 
	 AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id  
	 ORDER BY tercero,p.codigo_puc,e.fecha)  ORDER BY  fecha_reg ASC	 ";	 

	   }
	

	
	}else{
	
       if($opciones_centros == 'T'){	
	
		  /* $select = "SELECT i.tercero_id
		   
			FROM encabezado_de_registro e,  imputacion_contable i,puc p		   
		   ";*/
		   
		   
		   $select = "(SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
		   t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
		   (CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg 
		   
		   FROM encabezado_de_registro e, 
		   imputacion_contable i,puc p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id 
		   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND 
		   e.fecha BETWEEN $fechaDesdeSaldo AND 
		   DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  ) 
		   
		   UNION ALL 
           
		   (SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
		   t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
		   (CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE SUM(credito - debito) END) AS saldo , e.fecha AS fecha_reg
		   FROM encabezado_de_registro e, 
		   imputacion_contable i,puc p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id 
		   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND  i.puc_id IN ($cuentas) AND 
		   e.fecha BETWEEN $fechaDesdeSaldo AND 
		   DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  ) 
		   
		   UNION ALL 		   
		   
		   (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN 
		   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg 
		   FROM encabezado_de_registro e, 
		   imputacion_contable i,puc 
		   p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id 
		   AND i.tercero_id 
		   IS NULL AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND e.fecha BETWEEN 
		   (CASE WHEN 
		   SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT fecha FROM encabezado_de_registro WHERE 
		   encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id = $empresa_id)) FROM 
		   encabezado_de_registro ec WHERE tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND empresa_id = 
		   $empresa_id) WHEN SUBSTRING(p.codigo_puc,1,1) IN (1,2,3) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT fecha FROM 
		   encabezado_de_registro WHERE encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM encabezado_de_registro 
		   WHERE empresa_id
			= $empresa_id)) FROM encabezado_de_registro ec WHERE mes_contable_id IN (SELECT mes_contable_id FROM mes_contable WHERE mes_trece = 1) AND 
			empresa_id = $empresa_id) ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id = $empresa_id) END) AND 
		   DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id  )
		   
		   UNION ALL 		   
		   (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN 
		   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, 
		   imputacion_contable i,puc 
		   p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id 
		   AND i.tercero_id 
		   IS NULL AND i.centro_de_costo_id IS NULL AND  i.puc_id IN ($cuentas) AND e.fecha BETWEEN 
		   (CASE WHEN 
		   SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT fecha FROM encabezado_de_registro WHERE 
		   encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id = $empresa_id)) FROM 
		   encabezado_de_registro ec WHERE tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND empresa_id = 
		   $empresa_id) WHEN SUBSTRING(p.codigo_puc,1,1) IN (1,2,3) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT fecha FROM 
		   encabezado_de_registro WHERE encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM encabezado_de_registro 
		   WHERE empresa_id
			= $empresa_id)) FROM encabezado_de_registro ec WHERE mes_contable_id IN (SELECT mes_contable_id FROM mes_contable WHERE mes_trece = 1) AND 
			empresa_id = $empresa_id) ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id = $empresa_id) END) AND 
		   DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY tercero_id,i.puc_id )	 ORDER BY  fecha_reg  ASC		   
		   "; //echo $select;
	   	 	 //echo '6';
	   }else{
	   
		   $select = "(SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,
		   t.segundo_nombre,t.razon_social),t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
		   (CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, 
		   imputacion_contable i,puc p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id 
		   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND 
		   e.fecha BETWEEN $fechaDesdeSaldo AND 
		   DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id GROUP BY i.tercero_id,i.puc_id  ORDER BY tercero,p.codigo_puc) 
		   
		   UNION ALL 
		   
		   (SELECT -1 AS tercero_id,'SIN TERCERO' AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN 
		   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, 
		   imputacion_contable i,puc 
		   p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = p.puc_id 
		   AND i.tercero_id 
		   IS NULL AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) AND e.fecha BETWEEN 
		   (CASE WHEN 
		   SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT fecha FROM encabezado_de_registro WHERE 
		   encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id = $empresa_id)) FROM 
		   encabezado_de_registro ec WHERE tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND empresa_id = 
		   $empresa_id) WHEN SUBSTRING(p.codigo_puc,1,1) IN (1,2,3) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT fecha FROM 
		   encabezado_de_registro WHERE encabezado_registro_id = ec.encabezado_registro_id),(SELECT MIN(fecha) FROM encabezado_de_registro 
		   WHERE empresa_id
			= $empresa_id)) FROM encabezado_de_registro ec WHERE mes_contable_id IN (SELECT mes_contable_id FROM mes_contable WHERE mes_trece = 1) AND 
			empresa_id = $empresa_id) ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE empresa_id = $empresa_id) END) AND 
		   DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) GROUP BY i.tercero_id,i.puc_id  ORDER BY tercero,p.codigo_puc)  ORDER BY  fecha_reg ASC";	   
	   	

	     }
	
	  }
	  
    $saldoTercerosSinMov = $this -> DbFetchAll($select,$Conex,true);    	
	
	if(is_array($saldoTercerosSinMov)){
	
	  if(is_array($arrayResult)){
	    $arrayResult = array_values(array_merge($arrayResult,$saldoTercerosSinMov));	
	  }else{
	      $arrayResult = $saldoTercerosSinMov;	  	  
	    }
		
        //$arrayResult = $this -> sortResultByField($arrayResult,'fecha',SORT_ASC);	  	  	  
		//$arrayResult = $this -> sortResultByField($arrayResult,'tercero',SORT_ASC);	 
		//echo 'sisi4';	
	  
	}else{
	
	     if(!is_array($arrayResult)){
		   $arrayResult = array();
		 }else{
		      			  			  
			$arrayResult = $this -> sortResultByField($arrayResult,'tercero',SORT_ASC);  	  	  
			  	//echo 'sisi3';	 			  
		  }
	
	  }
	  
	  
	}else if($agrupar == 'cuenta'){ 
    $select = "SELECT DISTINCT i.puc_id FROM encabezado_de_registro e, imputacion_contable i 
	WHERE e.tipo_documento_id IN 
	($documentos) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND 
	i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) ORDER BY e.fecha ASC";
	
    $cuentasMovimiento = $this -> DbRecordToText($select,$Conex,true);
	if($cuentasMovimiento==''){
		//echo 'No existen Movimientos de las cuentas para el d&iacute;a '.$desde;
	}else{
	  
		$desdeSaldoTercero  = null;
		$hastaSaldoTercero  = $desde;   
	
		 if($opciones_centros == 'T'){	
		 
		 $select = "
		 
		 (SELECT p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
		 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, 
		 imputacion_contable i,puc p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id
		 AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas) 
		  AND i.puc_id NOT IN ($cuentasMovimiento) AND e.fecha BETWEEN $fechaDesdeSaldo AND 
		 DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY)  GROUP BY i.puc_id  ORDER BY p.codigo_puc)  	 
		 
		 UNION ALL
		  
		 (SELECT p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
		 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, 
		 imputacion_contable i,puc p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id
		 AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND i.puc_id IN ($cuentas)  
		  AND i.puc_id NOT IN ($cuentasMovimiento) AND e.fecha BETWEEN $fechaDesdeSaldo AND 
		 DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY)  GROUP BY i.puc_id  ORDER BY p.codigo_puc) ORDER BY  fecha_reg ASC  	
		 ";	
	
		 }else{
		 
		 
		 $select = "(SELECT p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN  
		 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
		 imputacion_contable i,puc p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id
		 AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas)  
		 AND i.puc_id NOT IN ($cuentasMovimiento) AND e.fecha BETWEEN $fechaDesdeSaldo AND 
		 DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY)  GROUP BY i.puc_id  ORDER BY p.codigo_puc,e.fecha) ";	 
		 
	
		}
		
		  
		$saldoTercerosSinMov = $this -> DbFetchAll($select,$Conex,true);    	
		
		if(is_array($saldoTercerosSinMov)){
		
		  if(is_array($arrayResult)){
			$arrayResult = array_values(array_merge($arrayResult,$saldoTercerosSinMov));	  
		  }else{
			  $arrayResult = $saldoTercerosSinMov;	  	  
			}
			
			$arrayResult = $this -> sortResultByField($arrayResult,'codigo_puc',SORT_ASC);	  	  	  
			//$arrayResult = $this -> sortResultByField($arrayResult,'fecha_reg',SORT_ASC);
			//echo 'sisi2';	 	
		  
		}else{
		
			 if(!is_array($arrayResult)){
			   $arrayResult = array();
			 }else{
										  
				$arrayResult = $this -> sortResultByField($arrayResult,'codigo_puc',SORT_ASC);  	  	  
				//$arrayResult = $this -> sortResultByField($arrayResult,'fecha_reg',SORT_ASC);  	  	  
				 //echo 'sisi1';	 			  
			  }
		
		  }
		  
		  
		
		
		 }  
	}
	 
  	return $arrayResult;
  
  }
  
  public function selectSaldoCentrosTercero($tercero_id,$empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$puc_id,$desde,$Conex){  
  
    include_once("UtilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();
	$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
    $arrayResult         = array();   
  
     $select = "SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM 
	 encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id 
	 = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND 
	 i.puc_id = $puc_id AND e.fecha <= DATE_SUB('$desde',INTERVAL 1 DAY) AND i.tercero_id = t.tercero_id 
	 GROUP BY i.tercero_id,i.puc_id";    
  
     $result = $this -> DbFetchAll($select,$Conex,true);    
	
	 return strlen(trim($result[0]['saldo'])) > 0 ? $result[0]['saldo'] : 0;	        
  
  }
  
  public function selectSaldoCentrosPuc($empresa_id,$opciones_centros,$centro_de_costo_id,$documentos,$puc_id,$desde,$Conex){  
  
    include_once("UtilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();
	$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
    $arrayResult         = array();  
  
    $select = "SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM 
	 encabezado_de_registro e, imputacion_contable i,puc p WHERE e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id 
	 = i.encabezado_registro_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND 
	 i.puc_id = $puc_id AND e.fecha <=  DATE_SUB('$desde',INTERVAL 1 DAY) GROUP BY i.puc_id";    
  
     $result = $this -> DbFetchAll($select,$Conex,true);    
	 
	 return strlen(trim($result[0]['saldo'])) > 0 ? $result[0]['saldo'] : 0;	        
  
  }  
  
  public function selectAuxiliarCentrosTercero($empresa_id,$opciones_centros,$centro_de_costo_id,$tercero_id,
  $documentos,$cuentas,$desde,$hasta,$agrupar,$Conex){
											   
    include_once("UtilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel();
	$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
    $arrayResult         = array();

    if($opciones_centros == 'T'){
	
    $select = "SELECT 
				e.encabezado_registro_id,
				t.tercero_id,
				CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social), t.numero_identificacion) AS tercero,
				p.puc_id,
				CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,
				e.fecha,
				o.codigo_centro AS oficina,
				td.codigo AS documento,
				(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id=i.centro_de_costo_id ) AS centro_costo,
				e.consecutivo,
				i.descripcion,
				IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #  ',e.numero_soporte),'') AS cheque,
				i.debito,
				i.credito, 
				e.fecha AS fecha_reg 
				FROM  encabezado_de_registro e, imputacion_contable i, tercero t, tipo_de_documento td, puc p, oficina o 
				WHERE e.tipo_documento_id IN ($documentos) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id 
				AND i.tercero_id =  $tercero_id   AND (i.centro_de_costo_id IN ($centro_de_costo_id) OR i.centro_de_costo_id IS NULL)  AND   i.puc_id IN ($cuentas)
				AND i.puc_id = p.puc_id AND  i.tercero_id = t.tercero_id AND e.tipo_documento_id = td.tipo_documento_id 	
				AND e.oficina_id = o.oficina_id  ORDER BY p.codigo_puc, e.fecha ASC";
	 //echo $select;	 	   	 	
	}else{
	
      $select = "SELECT e.encabezado_registro_id,t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social),
	  t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,e.fecha,o.codigo_centro AS 
	  oficina,td.codigo AS documento,cc.codigo AS centro_costo,e.consecutivo,i.descripcion,
	  IF(e.forma_pago_id='4',CONCAT_WS(' ',' # CH #  ',e.numero_soporte),'') AS cheque,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i, tercero t, tipo_de_documento td, centro_de_costo cc,puc p, oficina o WHERE e.tipo_documento_id 
	  IN ($documentos) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id
	  AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas)  AND i.puc_id = p.puc_id AND 
	  i.tercero_id = t.tercero_id AND e.tipo_documento_id = td.tipo_documento_id 	AND e.oficina_id = o.oficina_id AND i.centro_de_costo_id = 
	  cc.centro_de_costo_id  ORDER BY p.codigo_puc,tercero,e.fecha,oficina,documento,centro_costo,e.consecutivo ASC";	
	
	
	  }

    $arrayResult = $this -> DbFetchAll($select,$Conex,true);    	

    $select = "SELECT DISTINCT i.puc_id FROM encabezado_de_registro e, imputacion_contable i WHERE e.tipo_documento_id IN ($documentos) 
	AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id 
	AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) ORDER BY e.fecha ASC";
	
    $cuentasMovimiento  = $this -> DbRecordToText($select,$Conex,true);		
  
    $desdeSaldoTercero  = null;
	$hastaSaldoTercero  = $desde;   
    
	if(strlen(trim($cuentasMovimiento)) > 0){

	 
    if($opciones_centros == 'T'){
		 
     $select = "(SELECT e.encabezado_registro_id,t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
	 t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	 THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE 
	 e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id 
	 NOT IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND  i.puc_id IN ($cuentas) 
	  AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	 = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc)
	 
	 
	 UNION ALL 
	 
     (SELECT e.encabezado_registro_id,t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
 	 t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	 THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE 
	 e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id 
	 NOT IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas) 
	  AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	 = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc)	 

 
	 UNION ALL 
	 
     (SELECT e.encabezado_registro_id,t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
 	 t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	 THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE 
	 e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id 
	 NOT IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND  i.puc_id IN ($cuentas) 
	 AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	 = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc)	  
	 
	 "; //echo  $select;

	 }else{
	
       $select = "(SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
	   t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	   THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE
	   e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id 
	   NOT IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas) 
	   AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	   = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc)
	 
	 
	   UNION ALL 
	 
      (SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
 	  t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	  THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE 
	  e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND i.puc_id 
	  NOT IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas)  
	   AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	  = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc)  ORDER BY fecha_reg ASC";	 
	 	 

	   }
	
	}else{
	
     if($opciones_centros == 'T'){
	
     $select = "(SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
	 t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	 THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE 
	 e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND 
	 i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas) 
	  AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	 = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc) 
	 
	 UNION ALL
	 
     (SELECT t.tercero_id,CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
	 t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	 THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo, e.fecha AS fecha_reg FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE 
	 e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND 
	 i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND i.puc_id IN ($cuentas)  
	  AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	 = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc)	 ORDER BY fecha_reg ASC 
	 
	 "; 

	 }else{
	 
       $select = "SELECT t.tercero_id,
	   CONCAT_WS(' - ',CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social),
	   t.numero_identificacion) AS tercero,p.puc_id,CONCAT_WS(' - ',p.codigo_puc,p.nombre) AS codigo_puc,(CASE WHEN p.naturaleza = 'D' 
	   THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,puc p, tercero t WHERE 
	   e.tipo_documento_id IN ($documentos) AND e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id AND 
	   i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.puc_id IN ($cuentas) 
	   AND e.fecha BETWEEN $fechaDesdeSaldo AND DATE_SUB('$hastaSaldoTercero',INTERVAL 1 DAY) AND i.tercero_id 
	   = t.tercero_id GROUP BY i.tercero_id,i.puc_id ORDER BY tercero,p.codigo_puc,e.fecha";	 


	    }
	
	  }
	  
    $saldoTercerosSinMov = $this -> DbFetchAll($select,$Conex,true);    
	
	if(is_array($saldoTercerosSinMov)){
	
	   $arrayResult = array_values(array_merge($arrayResult,$saldoTercerosSinMov));	
	   //$arrayResult = $this -> sortResultByField($arrayResult,'fecha_reg',SORT_ASC);		  
	   //$arrayResult = $this -> sortResultByField($arrayResult,'codigo_puc',SORT_ASC);		  
	   //echo 'sisi1';
	}else{
		  $arrayResult = $this -> sortResultByField($arrayResult,'fecha',SORT_ASC);		  
		  //echo 'sisis';
	}

  return $arrayResult;
  
  }
  
  public function getNaturalezaCodigoPuc($puc_id,$Conex){
  
    $select = "SELECT naturaleza FROM puc WHERE puc_id = $puc_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 	
	
	return $result[0]['naturaleza'];  
  
  }
  
}


?>