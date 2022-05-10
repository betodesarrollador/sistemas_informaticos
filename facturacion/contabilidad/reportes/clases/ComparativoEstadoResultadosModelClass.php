<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class ComparativoEstadoResultadosModel extends Db{
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
  
//LISTA MENU
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }
   
   public function getSaldoCuentasBalance($desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex){
   	  
	 $select1 = "SELECT puc_id FROM puc WHERE codigo_puc IN ('4','5','6','7')";
	 $result1 = $this->DbFetchAll($select1, $Conex, $ErrDb = false);

	  $cuentasMovimiento4Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[0]['puc_id'],$Conex);	  	  
	  $cuentasMovimiento5Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[1]['puc_id'],$Conex);	  	  
	  $cuentasMovimiento6Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[2]['puc_id'],$Conex);	  	  
	  $cuentasMovimiento7Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[3]['puc_id'],$Conex);	
	  	  	
	    
	  if($opciones_centros == 'T'){
	  
       $select = "
	     (
		
			SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM 
			
			(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
			p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
			imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde'	 
			AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta) saldo1 LEFT JOIN				
			
			(SELECT SUBSTRING(p.codigo_puc,1,1) 
			AS cuenta,(CASE WHEN  
			p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
			imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde'	 
			AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL GROUP BY cuenta) saldo2 ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta
		
		) 
				
		UNION ALL 
	  
	   (
	   
	   SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM
	   
	   (SELECT SUBSTRING(p.codigo_puc,1,1) 
	   AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
	   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta) saldo1  LEFT JOIN 
	   
       (SELECT SUBSTRING(p.codigo_puc,1,1) 
	   AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
	   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL GROUP BY cuenta) saldo2  ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta
	   
	   
	   )
	   
	   
	   
	   UNION ALL 
	   
	   (
	  	
		
		SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM 
		  
	  (SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
	   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta) saldo1 LEFT JOIN 
	   
	   (SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
	   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL GROUP BY cuenta) saldo2 ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta
	   
	   
	   
	   )
	   
	   
	   /*
	   UNION ALL 
	   
	   (
	  	
		
		SELECT saldo1.cuenta,(IF(saldo1.saldo is null,0,saldo1.saldo)+IF(saldo2.saldo is  null,0,saldo2.saldo)) AS saldo FROM 
		  
	  (SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
	   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta) saldo1 LEFT JOIN 
	   
	   (SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	   p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	   puc p WHERE e.fecha BETWEEN '$desde'	 
	   AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
	   AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL GROUP BY cuenta) saldo2 ON saldo1.cuenta = saldo2.cuenta GROUP BY saldo1.cuenta
	   
	   
	   
	   )	*/   
	   ";	  
	   
	  }else{
	  
         $select = "(SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	     p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, 
		 imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde'	 
	     AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
	     AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta) UNION ALL 
	  
	    (SELECT SUBSTRING(p.codigo_puc,1,1) 
	    AS cuenta,(CASE WHEN  
	    p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	    puc p WHERE e.fecha BETWEEN '$desde'	 
	    AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
	    AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta)   UNION ALL 
	  	  
	   (SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	    p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	    puc p WHERE e.fecha BETWEEN '$desde'	 
	    AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
	    AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta)   /* UNION ALL 
	  	  
	   (SELECT SUBSTRING(p.codigo_puc,1,1) AS cuenta,(CASE WHEN  
	    p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM encabezado_de_registro e, imputacion_contable i,
	    puc p WHERE e.fecha BETWEEN '$desde'	 
	    AND '$hasta' AND  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
	    AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY cuenta) */ ";	  	  
	  
	    } 	  
	    	  	  	  	  	  	  	     
	  
	 $result = $this -> DbFetchAll($select,$Conex,true);       
	 
	 return $result;
   
   
   }
   
   public function getSaldoUtilidadPerdidaNivel1($desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$utilidadesContables,$Conex){
   
	   $select1 = "SELECT puc_id FROM puc WHERE codigo_puc IN ('4','5','6','7')";
	   $result1 = $this->DbFetchAll($select1, $Conex, $ErrDb = false);

	  $cuentasMovimiento4Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[0]['puc_id'],$Conex);	  	  
	  $cuentasMovimiento5Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[1]['puc_id'],$Conex);	  	  
	  $cuentasMovimiento6Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[2]['puc_id'],$Conex);	  	  
	  $cuentasMovimiento7Nivel1 = $utilidadesContables -> getCuentasMovimiento($result1[3]['puc_id'],$Conex);		   
	   
	  if($opciones_centros == 'T'){ 
	       
		  if(strlen(trim($cuentasMovimiento4Nivel1)) > 0){
		  
			$selectUtilidadPerdida4 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE 
			WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro e,    
			imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - 
			credito) ELSE  SUM(credito - debito) END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) 
			AS saldo FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL)) AS saldo";
			
			$result                = $this -> DbFetchAll($selectUtilidadPerdida4,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida4 = $result[0]['saldo'];
			
			
		  }
		  
		  if(strlen(trim($cuentasMovimiento5Nivel1)) > 0){
		  
			$selectUtilidadPerdida5 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)) + ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN 
			SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL))) AS saldo";	  
			
			$result                = $this -> DbFetchAll($selectUtilidadPerdida5,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida5 = $result[0]['saldo'];		
			
		  }
		  
		  if(strlen(trim($cuentasMovimiento6Nivel1)) > 0){
		  
			$selectUtilidadPerdida6 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro 
			e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - 
			credito) ELSE  SUM(credito - debito) END) > 0,(CASE 
			WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro e,    
			imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id))) AS saldo";	  
			
			$result                = $this -> DbFetchAll($selectUtilidadPerdida6,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida6 = $result[0]['saldo'];			
			
		  }
		  
		  if(strlen(trim($cuentasMovimiento7Nivel1)) > 0){
		  
			$selectUtilidadPerdida7 = "SELECT ((SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) 
			END) > 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro 
			e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - 
			credito) ELSE  SUM(credito - debito) END) > 0,(CASE 
			WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM encabezado_de_registro e,    
			imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id))) AS saldo";	  
			
			$result                = $this -> DbFetchAll($selectUtilidadPerdida7,$Conex,$ErrDb = false); 
			$saldoUtilidadPerdida7 = $result[0]['saldo'];					
			
		  }	 
	  
	  
	  }else{
	  
			  if(strlen(trim($cuentasMovimiento4Nivel1)) > 0){
			  
				$selectUtilidadPerdida4 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento4Nivel1) 
				AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)";
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida4,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida4 = $result[0]['saldo'];
				
				
			  }
			  
			  if(strlen(trim($cuentasMovimiento5Nivel1)) > 0){
			  
				$selectUtilidadPerdida5 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE  WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento5Nivel1) 
				AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida5,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida5 = $result[0]['saldo'];		
				
			  }
			  
			  if(strlen(trim($cuentasMovimiento6Nivel1)) > 0){
			  
				$selectUtilidadPerdida6 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento6Nivel1) 
				AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida6,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida6 = $result[0]['saldo'];			
				
			  }
			  
			  if(strlen(trim($cuentasMovimiento7Nivel1)) > 0){
			  
				$selectUtilidadPerdida7 = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
				> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
				encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
				e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento7Nivel1) 
				AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
				
				$result                = $this -> DbFetchAll($selectUtilidadPerdida7,$Conex,$ErrDb = false); 
				$saldoUtilidadPerdida7 = $result[0]['saldo'];					
				
			  }	 
	  
	  	  
	    } 	  	   
		 
      $saldoUtilidadPerdida = ($saldoUtilidadPerdida4 - $saldoUtilidadPerdida5 - $saldoUtilidadPerdida6 - $saldoUtilidadPerdida7);
	  
	  return $saldoUtilidadPerdida;
   
   }
      
   public function selectSubCuentas($codigo_puc,$Conex){
   
     $select = "SELECT puc_id,codigo_puc,nombre,movimiento FROM puc WHERE puc_puc_id = (SELECT puc_id FROM puc WHERE TRIM(codigo_puc) = 
	 TRIM('$codigo_puc')) ORDER BY codigo_puc ASC";
     $result = $this -> DbFetchAll($select,$Conex,true); 
	 
	 return $result;     
   
   }
   
   public function getSaldoCuenta($puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Model,$utilidadesContables,$Conex){
   
       $cuentasMovimiento = $utilidadesContables -> getCuentasMovimiento($puc_id,$Conex);
   
	   
	   if(strlen(trim($cuentasMovimiento)) > 0){
				  
		   if($opciones_centros == 'T'){	
					  
			$select = "SELECT (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
			> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)) + (SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' 
			THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
			> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL) AS saldo";	  
					
			$result = $this -> DbFetchAll($select,$Conex,true); 	
		   
		   }else{
		   
			$select = "SELECT IF(ABS(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) 
			> 0,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END),0) AS saldo FROM 
			encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND  
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) 
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)";	  
					
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
   
  public function selectSaldoTercerosBalance($empresa_id,$puc_id,$opciones_centros,$centro_de_costo_id,$desde,$hasta,$utilidadesContables,$Conex){   
  
     if($opciones_centros == 'T'){
	 
      $select = "
	  
	  SELECT t.puc_id,t.tercero_id,t.tercero,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS saldo FROM
	  
      ((SELECT i.tercero_id,i.puc_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social),
	  t.numero_identificacion) AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i,tercero t, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id) 
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,'SIN TERCERO' AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id IS NULL)
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social),
	  t.numero_identificacion) AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i,tercero t, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id) 	  
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,'SIN TERCERO' AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IS NULL AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id IS NULL)) t, puc p WHERE t.puc_id = p.puc_id GROUP BY tercero,puc_id ORDER BY tercero ASC
	  
	  
	  
	  ";    
	 	 
	 }else{
	 
      $select = "SELECT t.puc_id,t.tercero_id,t.tercero,(CASE WHEN p.naturaleza = 'D' THEN SUM(debito - credito) ELSE  SUM(credito - debito) END) AS 
	  saldo FROM
	  
      ((SELECT i.tercero_id,i.puc_id,CONCAT_WS(' - ',CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social),
	  t.numero_identificacion) AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i,tercero t, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id) 
	  
	  UNION ALL 
	  
	  (SELECT i.tercero_id,i.puc_id,'SIN TERCERO' AS tercero,i.debito,i.credito FROM 
	  encabezado_de_registro e, imputacion_contable i, puc p WHERE e.empresa_id = $empresa_id AND e.encabezado_registro_id 
	  = i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND e.fecha 
	  BETWEEN '$desde' AND '$hasta' AND i.tercero_id IS NULL)
	 
	  ) t, puc p WHERE t.puc_id = p.puc_id GROUP BY tercero,puc_id ORDER BY tercero,puc_id ASC";
	   }
	   
  
     $result = $this -> DbFetchAll($select,$Conex,true);    
	 
	 return $result;	        
  
  }   
   
   
}

?>