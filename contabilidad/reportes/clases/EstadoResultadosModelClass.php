<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class EstadoResultadosModel extends Db{
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
  
   public function getCuentasBalance($Conex,$nivel){
	  
     $select = "SELECT puc_id AS value,CONCAT_WS(' ',codigo_puc,nombre) AS text FROM puc WHERE nivel = $nivel 
	            AND estado = 'A' AND SUBSTRING(codigo_puc,1,1) IN (4,5,6) ORDER BY codigo_puc ASC ";
				//echo $select;
     $result = $this -> DbFetchAll($select,$Conex,true);            
	 
	 return $result;	  
	  
  }
  
  
   public function getRegistrosFecha($desde,$hasta,$centro_de_costo_id,$nivel,$cuentas,$opciones_cuentas,$clase,$Conex){
	   
	  
	   if($opciones_cuentas=='U'){
	   	 $cuenta	= explode(',',$cuentas);
	   }else if($opciones_cuentas == 'T'){
		   $select = "SELECT (puc_id) as cuentas FROM puc WHERE nivel =$nivel AND SUBSTRING(codigo_puc,1,1) =$clase ORDER BY codigo_puc asc  ";
		  	//die('select : '.$select);
		   $result = $this -> DbFetchAll($select,$Conex,true);  
		   
		   $cuentas = '';
		   
		   for($i==0;$i<count($result);$i++){
			   $cuentas = $cuentas == '' ? $result[$i+0]['cuentas'] : $cuentas.",".$result[$i+0]['cuentas'];
			  
		   }

	 	  $cuenta	= explode(',',$cuentas);
	   }
	   $i=0;
	   
	   if ($opcierre=='N') {
	     	$condicion_cierre=" AND e.tipo_documento_id IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1)";
	     }else{
	     	$condicion_cierre=" ";
	     }
	 
	foreach($cuenta as $cuenta_puc){
			
	   $select = "SELECT (SELECT codigo_puc FROM puc WHERE puc_id=$cuenta_puc )as codigo,(SELECT nombre FROM puc WHERE puc_id=$cuenta_puc )as cuenta,
	   (IF(DATE_FORMAT('$desde','%m-%d')='01-01',0, (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN (SELECT CONCAT(DATE_FORMAT('$desde','%Y'),'-01-01') ) AND ( SELECT DATE_SUB('$desde',INTERVAL 1 DAY)) AND  
			e.encabezado_registro_id = i.encabezado_registro_id  AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))  ))as saldo,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 1 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id  AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as enero,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 2 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as febrero,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 3 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as marzo,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 4 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as abril,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 5 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as mayo,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 6 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as junio,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 7 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as julio,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 8 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as agosto,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 9 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as septiembre,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 10 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as octubre,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 11 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as noviembre,
	   
	   (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND DATE_FORMAT(e.fecha,'%m') = 12 AND  DATE_FORMAT(e.fecha,'%y')=DATE_FORMAT('$desde','%y')	AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND e.encabezado_registro_id NOT IN (SELECT encabezado_registro_id FROM encabezado_de_registro_anulado) AND i.puc_id= $cuenta_puc 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))as diciembre
	   
	   
	   ";
	
	   $resultado = $this -> DbFetchAll($select,$Conex,true);   
	   
	  $total_movimientos = $resultado[0][saldo]+$resultado[0][enero]+$resultado[0][febrero]+$resultado[0][marzo]+$resultado[0][abril]+$resultado[0][mayo]+$resultado[0][junio]+$resultado[0][julio]+$resultado[0][agosto]+$resultado[0][septiembre]+$resultado[0][octubre]+$resultado[0][noviembre]+$resultado[0][diciembre];
	 /* if(intval($total_movimientos)>0){
	  echo $select."<br>";}*/
	   $result[$i]=array(total=>$total_movimientos,codigo=>$resultado[0][codigo],cuenta=>$resultado[0][cuenta],saldo=>$resultado[0][saldo],enero=>$resultado[0][enero],febrero=>$resultado[0][febrero],marzo=>$resultado[0][marzo],abril=>$resultado[0][abril],mayo=>$resultado[0][mayo],junio=>$resultado[0][junio],julio=>$resultado[0][julio],agosto=>$resultado[0][agosto],septiembre=>$resultado[0][septiembre],octubre=>$resultado[0][octubre],noviembre=>$resultado[0][noviembre],diciembre=>$resultado[0][diciembre]);
	   $i++;
	  
	}
	return $result;
   }
  
//LISTA MENU
  
  public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
	public function selectNaturaleza($puc,$Conex){
		$select="SELECT naturaleza FROM puc WHERE puc_id=$puc";
		$result= $this -> DbFetchAll($select,$Conex,true);
		return $result;
	}   
   
   public function getSaldoCuentasBalance($opcierre,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex){
		
	
	$select1 = "SELECT puc_id FROM puc WHERE codigo_puc IN ('4','5','6','7')";
	$result1 = $this->DbFetchAll($select1, $Conex, $ErrDb = false);

	  $cuentasMovimiento4Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[0]['puc_id'],$Conex);	  	  //4
	  $cuentasMovimiento5Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[1]['puc_id'],$Conex);	  	  //5
	  $cuentasMovimiento6Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[2]['puc_id'],$Conex);	  	  //6
	  $cuentasMovimiento7Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[3]['puc_id'],$Conex);
	  
	  
	     if ($opcierre=='N') {
	     	$condicion_cierre=" AND e.tipo_documento_id  NOT IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1)";
	     }else{
	     	$condicion_cierre=" ";
	     }
	    
	  if($opciones_centros == 'T'){
		  
		if($cuentasMovimiento7Nivel1 != ''){
			
		$consulNivel7 = "UNION ALL 
	
		(SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM 
			
		(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
		p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
		puc p WHERE  e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
		AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
		AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre GROUP BY cuenta) saldo1 LEFT JOIN 
		
		(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
		p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
		puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
		AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
		AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL $condicion_cierre GROUP BY cuenta) saldo2 ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta)";
			
		}else{
			$consulNivel7 = "";
		}
	  
       $select = "
	     (
		
			SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM 
			
			(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
			p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
			imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
			AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre GROUP BY cuenta) saldo1 LEFT JOIN				
			
			(SELECT SUBSTRING(p.codigo_puc,1,1) 
			AS cuenta,(CASE WHEN  
			p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
			imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
			AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL $condicion_cierre GROUP BY cuenta) saldo2 ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta
		
		) 
				
		UNION ALL 
	  
	   (
	   
	   SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM
	   
	   (SELECT SUBSTRING(p.codigo_puc,1,1) 
	   AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
	   AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre GROUP BY cuenta) saldo1  LEFT JOIN 
	   
       (SELECT SUBSTRING(p.codigo_puc,1,1) 
	   AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
	   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL $condicion_cierre GROUP BY cuenta) saldo2  ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta)
	   
		UNION ALL 

		(
			SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM 
			
			(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
			p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
			imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
			AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre GROUP BY cuenta) saldo1 LEFT JOIN				
			
			(SELECT SUBSTRING(p.codigo_puc,1,1) 
			AS cuenta,(CASE WHEN  
			p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
			imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
			AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL $condicion_cierre GROUP BY cuenta) saldo2 ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta

		)$consulNivel7";
	   
	   
	  
	  }else{
		  
		if($cuentasMovimiento7Nivel1 != ''){
			
			$consulNivel7 = "UNION ALL 
				
			(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
			 p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
			 puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
			 AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
			 AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)  GROUP BY cuenta)";
			
		}else{
			$consulNivel7 = "";
		}
		
	  
         $select = "(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	     p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
		 imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
	     AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
	     AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta) UNION ALL 
	  
	    (SELECT SUBSTRING(p.codigo_puc,1,1) 
	    AS cuenta,(CASE WHEN  
	    p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	    puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
	    AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
	    AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)  GROUP BY cuenta)   UNION ALL 
	  	  
	   (SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	    p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	    puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde'	 
	    AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
	    AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)  GROUP BY cuenta) $consulNivel7";	  	  
	    } 	  
	    	  	  	  	  	  	  	     
	 $result = $this -> DbFetchAll($select,$Conex,true);       
	 
	 return $result;
   
   
   }
   
   public function getSaldoUtilidadPerdidaNivel1($opcierre,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex){


   
	$select1 = "SELECT puc_id FROM puc WHERE codigo_puc IN ('4','5','6','7')";
	$result1 = $this->DbFetchAll($select1, $Conex, $ErrDb = false);


	  $cuentasMovimiento4Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[0]['puc_id'],$Conex);	  	  //4
	  $cuentasMovimiento5Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[1]['puc_id'],$Conex);	  	  //5
	  $cuentasMovimiento6Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[2]['puc_id'],$Conex);	  	  //6
	  $cuentasMovimiento7Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[3]['puc_id'],$Conex);

	     if ($opcierre=='N') {
	     	$condicion_cierre=" AND e.tipo_documento_id IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1)";
	     }else{
	     	$condicion_cierre=" ";
	     }
	   
	  if($opciones_centros == 'T'){ 
	       
		  if(strlen(trim($cuentasMovimiento4Nivel1)) > 0){
		  
			$selectUtilidadPerdida4 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE 
			WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro e,    
			imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - 
			credito) ELSE  SUM(credito - debito) END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) 
			AS saldo FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL)) AS saldo";
			
			$result                = $this -> DbFetchAll($selectUtilidadPerdida4,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida4 = $result[0]['saldo'];
			
			
		  }
		  
		  if(strlen(trim($cuentasMovimiento5Nivel1)) > 0){
		  
			$selectUtilidadPerdida5 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)) + ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN 
			SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL))) AS saldo";	  
			
			$result                = $this -> DbFetchAll($selectUtilidadPerdida5,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida5 = $result[0]['saldo'];		
			
		  }
		  
		  if(strlen(trim($cuentasMovimiento6Nivel1)) > 0){
		  
			$selectUtilidadPerdida6 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro 
			e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - 
			credito) ELSE  SUM(credito - debito) END) > 0,(CASE 
			WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro e,    
			imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))) AS saldo";	  
			
			$result                = $this -> DbFetchAll($selectUtilidadPerdida6,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida6 = $result[0]['saldo'];			
			
		  }
		  
		  if(strlen(trim($cuentasMovimiento7Nivel1)) > 0){
		  
			$selectUtilidadPerdida7 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro 
			e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - 
			credito) ELSE  SUM(credito - debito) END) > 0,(CASE 
			WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro e,    
			imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id))) AS saldo";	  
			$result                = $this -> DbFetchAll($selectUtilidadPerdida7,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida7 = $result[0]['saldo'];					
			
		  }	 
	  
	  
	  }else{
	  
			  if(strlen(trim($cuentasMovimiento4Nivel1)) > 0){
			  
				$selectUtilidadPerdida4 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
				AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)";
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida4,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida4 = $result[0]['saldo'];
				
				
			  }
			  
			  if(strlen(trim($cuentasMovimiento5Nivel1)) > 0){
			  
				$selectUtilidadPerdida5 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE  WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
				AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida5,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida5 = $result[0]['saldo'];		
				
			  }
			  
			  if(strlen(trim($cuentasMovimiento6Nivel1)) > 0){
			  
				$selectUtilidadPerdida6 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
				AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida6,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida6 = $result[0]['saldo'];			
				
			  }
			  
			  if(strlen(trim($cuentasMovimiento7Nivel1)) > 0){
			  
				$selectUtilidadPerdida7 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
				AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida7,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida7 = $result[0]['saldo'];					
				
			  }	 
	  
	  	  
	    } 	  	   
		 
      $saldoUtilidadPerdida = ($saldoUtilidadPerdida4 - $saldoUtilidadPerdida5 - $saldoUtilidadPerdida6 - $saldoUtilidadPerdida7);
	  echo $saldoUtilidadPerdida4."-".$saldoUtilidadPerdida5."-".$saldoUtilidadPerdida6."-".$saldoUtilidadPerdida7."=".$saldoUtilidadPerdida;
	  return $saldoUtilidadPerdida;
   
   }
      
   public function selectSubCuentas($codigo_puc,$Conex){
   
     $select = "SELECT puc_id,codigo_puc,nombre,movimiento FROM puc WHERE puc_puc_id = (SELECT puc_id FROM puc WHERE TRIM(codigo_puc) = 
	 TRIM('$codigo_puc')) ORDER BY codigo_puc ASC";
     $result = $this -> DbFetchAll($select,$Conex,true); 
	 
	 return $result;     
   
   }
   
   public function getSaldoCuenta($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex){
   
       $cuentasMovimiento = $utilidadesContables -> getCuentasMovimiento($puc_id,$Conex);
	     if ($opcierre=='N') {
	     	$condicion_cierre=" AND e.tipo_documento_id IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1)";
	     }else{
	     	$condicion_cierre="";
	     }
	    
	   if(strlen(trim($cuentasMovimiento)) > 0){
				  
		   if($opciones_centros == 'T'){	
					  
			$select = "SELECT (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
			> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' $condicion_cierre AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' 
			THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
			> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' $condicion_cierre AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL) AS saldo";	  
					
			$result = $this -> DbFetchAll($select,$Conex,true); 	
		   
		   }else{
		   
			$select = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
			> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado = 'C' AND e.fecha BETWEEN '$desde' AND '$hasta' $condicion_cierre AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) 
			AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
					
			$result = $this -> DbFetchAll($select,$Conex,true); 	   
		   
		   
			 }
			 
		}
		 
		 return is_numeric($result[0]['saldo']) ? $result[0]['saldo'] : 0;
   
   }
   
   public function getCodigoPucUtilidadPerdida($nivel,$saldo,$utilidadesContables,$Conex){
   
     $select = "SELECT p.* FROM parametro_reporte_contable p";
	 $data   = $this -> DbFetchAll($select,$Conex,true); 
	 
	 if(count($data) > 0){
	 	 
	  $utilidad_id = $data[0]['utilidad_id'];
	  $perdida_id  = $data[0]['perdida_id'];
	 
	  if($saldo > 0){
	 
	   $puc_id =  $utilidadesContables -> getCuentaMayor($utilidad_id,$nivel,$Conex);
	   
	   return strlen(trim($puc_id)) > 0 ? $puc_id : $utilidad_id;  	   
			 
	  }else{
	 
      	   $puc_id =  $utilidadesContables -> getCuentaMayor($perdida_id,$nivel,$Conex);
		   
		   return strlen(trim($puc_id)) > 0 ? $puc_id : $perdida_id;  
	 
	   }
	   
	 }else{
	      exit("No ha parametrizado aun las cuentas de utilidad y/o perdida");	 
	   }  
	  
	   	 
   
   }
   
  public function selectSaldoTercerosBalance($opcierre,$empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$desde,$hasta,$utilidadesContables,$Conex){
	     if ($opcierre=='N') {
	     	$condicion_cierre=" AND e.tipo_documento_id IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1)";
	     }else{
	     	$condicion_cierre=" ";
	     }
  
     if($opciones_centros == 'T'){
	 
      $select = "
	  
	  SELECT t.puc_id,t.tercero_id,t.tercero,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM
	  
      ((SELECT i.tercero_id,i.puc_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social),
	  t.numero_identificacion) AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i,tercero t, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id) 
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,'SIN TERCERO' AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id IS NULL)
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social),
	  t.numero_identificacion) AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i,tercero t, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IS NULL AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id) 	  
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,'SIN TERCERO' AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IS NULL AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id IS NULL)) t, puc p WHERE t.puc_id = p.puc_id GROUP BY tercero,puc_id ORDER BY tercero ASC
	  
	  
	  
	  ";    
	 	 
	 }else{
	 
      $select = "SELECT t.puc_id,t.tercero_id,t.tercero,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS 
	  saldo FROM
	  
      ((SELECT i.tercero_id,i.puc_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social),
	  t.numero_identificacion) AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i,tercero t, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id) 
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,'SIN TERCERO' AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id $condicion_cierre AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id IS NULL)
	 
	  ) t, puc p WHERE t.puc_id = p.puc_id GROUP BY tercero,puc_id ORDER BY tercero,puc_id ASC";
	   }
	   
  
     $result = $this -> DbFetchAll($select,$Conex,true);    
	 
	 return $result;	        
  
  }   
}
?>