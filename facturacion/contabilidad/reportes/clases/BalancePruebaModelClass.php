<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
require_once("../../../framework/clases/UtilidadesContablesModelClass.php");

final class BalancePruebaModel extends Db{

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
      
   public function selectSubCuentas($codigo_puc,$Conex){   
   
     $select = "SELECT puc_id,codigo_puc,nombre,movimiento FROM puc WHERE puc_puc_id = (SELECT puc_id FROM puc WHERE 
	 TRIM(codigo_puc) = TRIM('$codigo_puc')) ORDER BY codigo_puc ASC";
	 
     $result = $this -> DbFetchAll($select,$Conex,true); 	 
	 
	 return $result;     
   
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
     
 public function getCuentasBalanceSeparadas($Conex,$nivel){
	  
     $select = "SELECT p.puc_id FROM puc p WHERE p.nivel = $nivel 
	            AND p.estado = 'A'   ORDER BY p.codigo_puc ASC";
				
     $result = $this -> DbFetchAll($select,$Conex,true);

     $respuesta = ''; 

     foreach ($result as $items) {
		$respuesta.=$items['puc_id'].",";
	 }           

	 return substr($respuesta, 0,-1);	  
	  
  }
 
 public function getSubCuentasBalance($Conex,$cuenta,$niveles,$nivel){
	 	
		if(strpos($cuenta, ',')){
			
			$array = explode(',',$cuenta);
			
			for ($i=0; $i < count($array) ; $i++) { 
												   
				$consul_cuenta = $i == (count($array)-1) ? $consul_cuenta." codigo_puc LIKE '$array[$i]%'" : $consul_cuenta." codigo_puc LIKE '$array[$i]%' OR";
				
			}
			
		}else{
			
			$consul_cuenta = " codigo_puc LIKE '$cuenta%'";
		}
		$select = "SELECT puc_id AS value,CONCAT_WS(' ',codigo_puc,nombre) AS text FROM puc WHERE ($consul_cuenta) AND nivel IN ($niveles) AND estado = 'A' ORDER BY codigo_puc ";
		
       
		$result = $this->DbFetchAll($select, $Conex, true);
		return $result;
	  
  }

 public function getCuentasBalanceSeparadas5($Conex,$nivel){
	  
     $select = "SELECT p.codigo_puc AS value FROM puc p WHERE p.nivel = $nivel 
	            AND p.estado = 'A' AND p.puc_id IN (SELECT i.puc_id FROM imputacion_contable i WHERE i.debito != 0 OR i.credito!=0 AND i.puc_id = p.puc_id)  ORDER BY p.codigo_puc ASC"; 

     $result = $this -> DbFetchAll($select,$Conex,true);

     $respuesta = ''; 

     foreach ($result as $items) {
                	$respuesta.=$items['value'].",";
                }           
	 
	 return substr($respuesta, 0,-1);	  
	
  }

  public function getCuentasBalancePrincipal($Conex,$nivel){
	  
	$subconsulta = $nivel == 5 ? "AND p.puc_id IN (SELECT i.puc_id FROM imputacion_contable i WHERE i.debito != 0 OR i.credito!=0 AND i.puc_id = p.puc_id)":'';

     $select = "SELECT p.codigo_puc AS value,CONCAT_WS(' ',p.codigo_puc,p.nombre) AS text FROM puc p WHERE p.nivel = $nivel 
	            AND p.estado = 'A' AND p.codigo_puc IS NOT NULL AND p.nombre IS NOT NULL $subconsulta ORDER BY p.codigo_puc";
				
     $result = $this -> DbFetchAll($select,$Conex,true);            
	 
	return $result;	  
	  
  }
      

  
  public function getCuentasBalance($Conex,$nivel){
	  
	$subconsulta = $nivel == 5 ? "AND p.puc_id IN (SELECT i.puc_id FROM imputacion_contable i WHERE i.debito != 0 OR i.credito!=0 AND i.puc_id = p.puc_id)":'';

     $select = "SELECT p.codigo_puc AS value,CONCAT_WS(' ',p.codigo_puc,p.nombre) AS text FROM puc p WHERE p.nivel = $nivel 
	            AND p.estado = 'A' AND p.codigo_puc IS NOT NULL AND p.nombre IS NOT NULL $subconsulta ORDER BY p.codigo_puc";
				
     $result = $this -> DbFetchAll($select,$Conex,true);            
	 
	 $respuesta = ''; 

     foreach ($result as $items) {
                	$respuesta.=$items['value'].",";
                }           
	 
	 return substr($respuesta, 0,-1);	  
	  
  }



    public function getSaldosCuentas($opcierre,$desde,$hasta,$centro_de_costo_id,$cuentas,$Conex){//nuevo
																								  
		if ($opcierre=='N') {
			
			$condicion_cierre=" AND (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1) OR (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND i.puc_id IN (SELECT p.puc_id from puc p, parametro_reporte_contable pr where (p.puc_id=pr.utilidad_cierre_id OR p.puc_id=pr.perdida_cierre_id) AND pr.parametro_reporte_contable_id = 1)) )";
			
		}else{
			
			$condicion_cierre="";
		
		}


    $select = "(SELECT p.puc_id, p.codigo_puc AS cod_puc,p.nombre, p.naturaleza,
				 '' AS codigo_puc, '0' AS tipo_link,
				'' AS cuenta, 
				'' AS saldo_anterior, 
				'' AS debito, 
				'' AS credito, 
				'' AS nuevo_saldo, 
				IF(p.naturaleza='D', SUM(IF(e.fecha < '$desde',(i.debito - i.credito),0)), 
				SUM(IF(e.fecha < '$desde',(i.credito - i.debito),0)) ) AS saldo_anterior_cuenta,
				SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.debito,0)) AS debito_cuenta,
				SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.credito,0)) AS credito_cuenta

	 			FROM puc p, imputacion_contable i, encabezado_de_registro e 
				WHERE p.puc_id IN ($cuentas) $condicion_cierre AND i.puc_id=p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)  
				AND e.encabezado_registro_id = i.encabezado_registro_id AND e.estado='C' AND e.fecha <= '$hasta'
				GROUP BY  i.puc_id)
	 
	 			UNION ALL
				
	 			(SELECT p.puc_id, p.codigo_puc AS cod_puc,p.nombre, p.naturaleza,
				t.numero_identificacion AS codigo_puc, '1' AS tipo_link,
				CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cuenta,
				IF(p.naturaleza='D',  SUM(IF(e.fecha < '$desde',(i.debito - i.credito),0)),
				SUM(IF(e.fecha < '$desde',(i.credito - i.debito),0)) )  AS saldo_anterior,
				SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.debito,0)) AS debito, 
				SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.credito,0)) AS credito,
				IF(p.naturaleza='D',
				   ((IFNULL((SUM(IF(e.fecha < '$desde',(i.debito - i.credito),0))),0)+SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.debito,0)))-(SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.credito,0)))), 
				    ((IFNULL((SUM(IF(e.fecha < '$desde',(i.credito - i.debito),0))),0)+SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.credito,0)))-(SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.debito,0))))) AS nuevo_saldo,

				'' AS saldo_anterior_cuenta,
				'' AS debito_cuenta,
				'' AS credito_cuenta

	 			FROM puc p, imputacion_contable i, encabezado_de_registro e, tercero t 
				WHERE p.puc_id IN ($cuentas) $condicion_cierre AND i.puc_id=p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)  
				AND e.encabezado_registro_id = i.encabezado_registro_id AND e.estado='C' AND e.fecha <= '$hasta'
				AND t.tercero_id=i.tercero_id
				GROUP BY i.tercero_id, i.puc_id)
				ORDER BY cod_puc, codigo_puc"; 
				
     $result = $this -> DbFetchAll($select,$Conex,true);            
	 
	 return $result;	  
	  
  }
	
    public function getSaldosCuentasTercero($desde,$hasta,$centro_de_costo_id,$cuentas,$Conex){//nuevo


    $select = "SELECT p.puc_id, p.codigo_puc AS cod_puc,p.nombre, p.naturaleza,
				t.numero_identificacion AS codigo_puc, '1' AS tipo_link,
				CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS cuenta,
				IF(p.naturaleza='D',  SUM(IF(e.fecha < '$desde',(i.debito - i.credito),0)),
				SUM(IF(e.fecha < '$desde',(i.credito - i.debito),0)) )  AS saldo_anterior,
				SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.debito,0)) AS debito, 
				SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.credito,0)) AS credito,
				IF(p.naturaleza='D',
				   ((IFNULL((SUM(IF(e.fecha < '$desde',(i.debito - i.credito),0))),0)+SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.debito,0)))-(SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.credito,0)))), 
				    ((IFNULL((SUM(IF(e.fecha < '$desde',(i.credito - i.debito),0))),0)+SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.credito,0)))-(SUM(IF(e.fecha BETWEEN '$desde' AND '$hasta',i.debito,0))))) AS nuevo_saldo,

				'' AS saldo_anterior_cuenta,
				'' AS debito_cuenta,
				'' AS credito_cuenta

	 			FROM puc p, imputacion_contable i, encabezado_de_registro e, tercero t 
				WHERE p.puc_id = $cuentas AND i.puc_id=p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id)  
				AND e.encabezado_registro_id = i.encabezado_registro_id AND e.estado='C' AND e.fecha <= '$hasta'
				AND t.tercero_id=i.tercero_id
				GROUP BY i.tercero_id, i.puc_id
				ORDER BY cod_puc, codigo_puc"; 
				
     $result = $this -> DbFetchAll($select,$Conex,true);            
	 
	 return $result;	  
	  
  }
  
	public function getSaldoCuenta($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$tercero_id,$empresa_id,$Conex){

		$utilidadesContables = new UtilidadesContablesModel();

		$cuentasMovimiento = $utilidadesContables -> getCuentasMovimiento($puc_id,$Conex);
		$fechaSaldoBalance = $utilidadesContables -> getCondicionSaldosBalanceGeneral($empresa_id,$desde);	  
		$dataCuenta        = array();
		
		if ($opcierre=='N') {
		$condicion_cierre=" AND (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1) OR (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND i.puc_id IN (SELECT p.puc_id from puc p, parametro_reporte_contable pr where (p.puc_id=pr.utilidad_cierre_id OR p.puc_id=pr.perdida_cierre_id) AND pr.parametro_reporte_contable_id = 1)) )";
		}else{
		$condicion_cierre="";
		}
		
		
		if($opciones_centros=='T'){ 
			$consulta_centro="";		
		}else{
			$consulta_centro="AND i.centro_de_costo_id IN ($centro_de_costo_id)";		
		}
		
			  
		if(strlen($cuentasMovimiento)>0){
			
			if($tercero_id == 'NULL' || $tercero_id== '' || $tercero_id== null){

				$select = "SELECT nombre,naturaleza,codigo_puc,puc_id FROM puc WHERE puc_id = $puc_id";
				$result                   = $this->DbFetchAll($select,$Conex,true);
				$dataCuenta['puc_id']     = $result[0]['puc_id'];
				$dataCuenta['cuenta']     = $result[0]['nombre'];		  
				$dataCuenta['codigo_puc'] = $result[0]['codigo_puc'];		  		  
				$naturaleza               = $result[0]['naturaleza'];	
				
				$select = "SELECT (CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE 
				SUM(credito - debito) END) AS
				saldo_anterior
				
				 FROM encabezado_de_registro e,imputacion_contable i,puc p 
				WHERE e.fecha BETWEEN 
				
				(CASE WHEN SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT DATE_ADD(ec.fecha,INTERVAL 1 DAY) ),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE estado='C' AND empresa_id =
				$empresa_id)) FROM encabezado_de_registro ec WHERE ec.estado='C' AND tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento 
				WHERE de_cierre = 1) AND empresa_id = $empresa_id)
				
				ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE 
				estado='C' AND empresa_id = $empresa_id) END)
					
	 
	 			AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.estado='C' AND e.encabezado_registro_id = i.encabezado_registro_id  AND i.puc_id IN ($cuentasMovimiento) AND i.puc_id = p.puc_id $consulta_centro $condicion_cierre";
					
					
				$result                       = $this->DbFetchAll($select,$Conex,true);
				$dataCuenta['saldo_anterior'] = $result[0]['saldo_anterior'];

				$select = "SELECT SUM(debito) AS debito, SUM(credito) AS credito FROM encabezado_de_registro e,
				imputacion_contable i WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND 
				e.estado='C' AND e.encabezado_registro_id = i.encabezado_registro_id  AND i.puc_id IN ($cuentasMovimiento) 
				$consulta_centro $condicion_cierre";
				
				$result                = $this->DbFetchAll($select,$Conex,true);
				$dataCuenta['debito']  = $result[0]['debito'];		  	  
				$dataCuenta['credito'] = $result[0]['credito'];	
				
				if($naturaleza == 'C'){
					$saldo_anterior = is_numeric($dataCuenta['saldo_anterior'])?$dataCuenta['saldo_anterior']:0;
					$debito         = is_numeric($dataCuenta['debito'])?$dataCuenta['debito']:0;
					$credito        = is_numeric($dataCuenta['credito'])?$dataCuenta['credito']:0;						  

					$dataCuenta['nuevo_saldo'] = ($saldo_anterior+$credito)-($debito);				          

				}else{
					$saldo_anterior = is_numeric($dataCuenta['saldo_anterior'])?$dataCuenta['saldo_anterior']:0;
					$debito         = is_numeric($dataCuenta['debito'])?$dataCuenta['debito']:0;
					$credito        = is_numeric($dataCuenta['credito'])?$dataCuenta['credito']:0;

					$dataCuenta['nuevo_saldo'] = ($saldo_anterior+$debito)-($credito);

				}


			}else{

			$select = "SELECT nombre,naturaleza,puc_id,codigo_puc FROM puc WHERE puc_id = $puc_id";
			$result               = $this->DbFetchAll($select,$Conex,true);
			$dataCuenta['puc_id']     = $result[0]['puc_id'];
			$dataCuenta['cuenta'] = $result[0]['nombre'];
			$dataCuenta['puc_id'] = $puc_id;
			$dataCuenta['codigo_puc'] = $result[0]['codigo_puc'];
			$naturaleza           = $result[0]['naturaleza'];

	 			$select = "SELECT (CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE 
				SUM(credito - debito) END) AS
				saldo_anterior FROM encabezado_de_registro e,imputacion_contable i,puc p 
				WHERE e.fecha BETWEEN 
				
				(CASE WHEN SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT DATE_ADD(ec.fecha,INTERVAL 1 DAY) ),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE estado='C' AND empresa_id =
				$empresa_id)) FROM encabezado_de_registro ec WHERE ec.estado='C' AND tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento 
				WHERE de_cierre = 1) AND empresa_id = $empresa_id)
				
				ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE 
				estado='C' AND empresa_id = $empresa_id) END)
					
				AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.estado='C' $condicion_cierre AND e.encabezado_registro_id = i.encabezado_registro_id  AND i.puc_id IN ($cuentasMovimiento) AND i.puc_id = p.puc_id $consulta_centro AND i.tercero_id=$tercero_id";
				
				$result                       = $this->DbFetchAll($select,$Conex,true);
				$dataCuenta['saldo_anterior'] = $result[0]['saldo_anterior'];

				$select = "SELECT SUM(i.debito) AS debito, SUM(i.credito) AS credito FROM encabezado_de_registro e,
				imputacion_contable i WHERE e.fecha BETWEEN '$desde' AND '$hasta'  AND 
				e.estado='C' AND e.encabezado_registro_id = i.encabezado_registro_id $condicion_cierre AND i.puc_id IN ($cuentasMovimiento) 
				$consulta_centro  AND i.tercero_id=$tercero_id";
			//echo $select;
					$result                = $this->DbFetchAll($select,$Conex,true);
					
			$dataCuenta['debito']  = $result[0]['debito'];		  	  
			$dataCuenta['credito'] = $result[0]['credito'];		  	  		  
			
			
			if($naturaleza == 'C'){

				$saldo_anterior = is_numeric($dataCuenta['saldo_anterior'])?$dataCuenta['saldo_anterior']:0;
				$debito         = is_numeric($dataCuenta['debito'])?$dataCuenta['debito']:0;
				$credito        = is_numeric($dataCuenta['credito'])?$dataCuenta['credito']:0;						  

				$dataCuenta['nuevo_saldo'] = ($saldo_anterior+$credito)-($debito);				          

			}else{

				$saldo_anterior = is_numeric($dataCuenta['saldo_anterior'])?$dataCuenta['saldo_anterior']:0;
				$debito         = is_numeric($dataCuenta['debito'])?$dataCuenta['debito']:0;
				$credito        = is_numeric($dataCuenta['credito'])?$dataCuenta['credito']:0;						  				 
				$dataCuenta['nuevo_saldo'] = ($saldo_anterior+$debito)-($credito);

			}

		}
	}

	return $dataCuenta;

	}
	
  public function getSaldoCuentaTerceros($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$opciones_centros,$empresa_id,$Conex){
	  
	  $utilidadesContables = new UtilidadesContablesModel();	  
	  $fechaSaldoBalance   = $utilidadesContables -> getCondicionSaldosBalanceGeneral($empresa_id);	  
	  $dataCuenta          = array();
	  	  
	  $select = "SELECT nombre,naturaleza FROM puc WHERE puc_id = $puc_id";
	  $result               = $this->DbFetchAll($select,$Conex,true);
	  $naturaleza           = $result[0]['naturaleza'];
	  
	  	if($opciones_centros=='T'){ 
			$consulta_centro="";		
		}else{
			$consulta_centro="AND i.centro_de_costo_id IN ($centro_de_costo_id)";		
		}
	  
		if ($opcierre=='N') {
			
			$condicion_cierre=" AND (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1) OR (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND i.puc_id IN (SELECT p.puc_id from puc p, parametro_reporte_contable pr where (p.puc_id=pr.utilidad_cierre_id OR p.puc_id=pr.perdida_cierre_id) AND pr.parametro_reporte_contable_id = 1)))";	
				
			}else{
				
			$condicion_cierre="";
			
			}
	  
	  $select = "SELECT DISTINCT i.tercero_id,(SELECT CONCAT_WS(' ',primer_apellido,razon_social) AS nom 
	  
	  FROM tercero WHERE tercero_id=i.tercero_id)AS nombre FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE 
	  e.fecha BETWEEN (CASE WHEN SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT DATE_ADD(ec.fecha,INTERVAL 1 DAY)),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE estado='C' AND empresa_id =
	 $empresa_id)) FROM encabezado_de_registro ec WHERE ec.estado='C' AND tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento 
	 WHERE de_cierre = 1) AND empresa_id = $empresa_id)
	 
	  ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE 
	 estado='C' AND empresa_id = $empresa_id) END)
					 AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.estado='C' AND e.encabezado_registro_id = i.encabezado_registro_id  AND i.puc_id = $puc_id AND i.puc_id = p.puc_id $consulta_centro $condicion_cierre
	  
	  UNION
	  
			  
	  SELECT DISTINCT i.tercero_id,(SELECT CONCAT_WS(' ',primer_apellido,razon_social) AS nom FROM tercero WHERE tercero_id=i.tercero_id)AS nombre FROM 
	  encabezado_de_registro e,imputacion_contable i WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND 
	  e.estado='C' AND e.encabezado_registro_id = i.encabezado_registro_id  AND i.puc_id = $puc_id
	$consulta_centro $condicion_cierre
	  
	  ORDER BY nombre ASC";
	  
	 

	  $terceros = $this->DbFetchAll($select,$Conex,true); 
	  
	  for($i = 0; $i < count($terceros); $i++){
		  
		  $tercero_id = is_null($terceros[$i]['tercero_id'])?'NULL':$terceros[$i]['tercero_id'];
		  
		  $select_sal = "
		  
				  SELECT i.tercero_id,(CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE 
				  SUM(credito - debito) END) AS
				  saldo_anterior 
				  
				  FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN 
				  (CASE WHEN SUBSTRING(p.codigo_puc,1,1) IN (4,5,6,7) THEN (SELECT IF(MAX(ec.encabezado_registro_id) > 0, (SELECT DATE_ADD(ec.fecha,INTERVAL 1 DAY)),(SELECT MIN(fecha) FROM encabezado_de_registro WHERE estado='C' AND empresa_id =
	 $empresa_id)) FROM encabezado_de_registro ec WHERE ec.estado='C' AND tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento 
	 WHERE de_cierre = 1) AND empresa_id = $empresa_id)
	 
	 ELSE (SELECT MIN(fecha) FROM encabezado_de_registro WHERE 
	 estado='C' AND empresa_id = $empresa_id) END)
						AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.estado='C' AND e.encabezado_registro_id = i.encabezado_registro_id  AND i.puc_id = $puc_id AND i.tercero_id = $tercero_id AND 
				  i.puc_id = p.puc_id $consulta_centro $condicion_cierre GROUP BY i.tercero_id	      
		  ";
			  
		  $saldos = $this->DbFetchAll($select_sal,$Conex,true);
	
		  $select_mov = "
		  
				  SELECT i.tercero_id,SUM(debito) AS debito, SUM(credito) AS credito FROM encabezado_de_registro e,
				  imputacion_contable i WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND 
				  e.estado='C' AND e.encabezado_registro_id = i.encabezado_registro_id  AND i.tercero_id = $tercero_id 
				  AND i.puc_id = $puc_id $consulta_centro $condicion_cierre GROUP BY i.tercero_id	  
			  
		  ";
		  
		  $movimientos = $this->DbFetchAll($select_mov,$Conex,true);	  		  
		  
		  $saldo_anterior = is_numeric($saldos[0]['saldo_anterior'])?$saldos[0]['saldo_anterior']:0;
		  $debito         = is_numeric($movimientos[0]['debito'])?$movimientos[0]['debito']:0;
		  $credito        = is_numeric($movimientos[0]['credito'])?$movimientos[0]['credito']:0;						
		  
		  $tercero_id    = is_null($saldos[0]['tercero_id'])?$movimientos[0]['tercero_id']:$saldos[0]['tercero_id'];
		  
		  $select        = "SELECT CONCAT_WS('-',numero_identificacion,digito_verificacion) AS numero_identificacion,CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social,'-',numero_identificacion) AS nombre_tercero FROM tercero WHERE tercero_id = $tercero_id";
		  $datos_tercero = $this->DbFetchAll($select,$Conex); 

			
		  $dataCuenta[$i]['cuenta']          = $datos_tercero[0]['nombre_tercero'];
		  $dataCuenta[$i]['codigo_puc']      = $datos_tercero[0]['numero_identificacion'];	          		    
		  $dataCuenta[$i]['saldo_anterior']  = $saldos[0]['saldo_anterior'];
		  $dataCuenta[$i]['debito']  = $debito;				          		    
		  $dataCuenta[$i]['credito'] = $credito;				          		    		  
		  $dataCuenta[$i]['puc_id'] = $puc_id;				          		    		  
		  $dataCuenta[$i]['tipo_link'] = 1;
		  $dataCuenta[$i]['tipo_tercero_id'] = "&tercero_id=$tercero_id";				          		    		  				          		    		  
		
		  if($naturaleza == 'C'){
			  			  
			$dataCuenta[$i]['nuevo_saldo'] = ($saldo_anterior+$credito)-($debito);				          
			
		   }else{
  				 
				$dataCuenta[$i]['nuevo_saldo'] = ($saldo_anterior+$debito)-($credito);
		
			}		  
		  
	  }
	  	  	  
      return $dataCuenta;
	  
    }	
	
	public function esCuentaMovimiento($puc_id,$Conex){
		
		$select = "SELECT movimiento FROM puc WHERE puc_id = $puc_id";
		$result = $this->DbFetchAll($select,$Conex);
		
		if($result[0]['movimiento']==1){
		  return true;
		}else{
			return false;
		  }
		
	}
  
      
}

?>