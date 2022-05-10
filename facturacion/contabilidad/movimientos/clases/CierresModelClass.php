<?php
ini_set("memory_limit","1024M");

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CierresModel extends Db{

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

	/***** selectEstadoEncabezadoRegistro ( Selecionr estado para anular) ***** */
	public function selectEstadoEncabezadoRegistro($encabezado_registro_id,$Conex){
		
		$select = "SELECT estado FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";	  
		$result = $this -> DbFetchAll($select,$Conex,true); 
		$estado = $result[0]['estado'];
		
		return $estado;	  
		
	}

	/****** metodo para la consulta validar el formulario cierrefin ****** */
	public function validarCierreFin($periodo_contable_id,$Conex){

		$encabezado_registro_id = $this -> requestDataForQuery('encabezado_registro_id','integer');

   		// consulta para la validacion del formulario cierrefin
		$select ="SELECT er.encabezado_registro_id, er.tipo_documento_id, er.periodo_contable_id, pc.anio FROM encabezado_de_registro er, periodo_contable pc, tipo_de_documento td WHERE er.tipo_documento_id = td.tipo_documento_id AND er.periodo_contable_id = pc.periodo_contable_id AND td.de_cierre = 1 AND er.periodo_contable_id > $periodo_contable_id";

		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;	
		}
               // validarPeriodo
		public function validarPeriodo($encabezado_registro_id,$Conex){
			$select = "SELECT periodo_contable_id FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
			$result = $this->DbFetchAll($select,$Conex,true);
			return $result;
		}
	/**** termina el metodo validarCierreFin ***** */
	
	/******* function cancellation ******* */
	public function cancellation($Conex){

		$this -> Begin($Conex);

		$encabezado_registro_id = $this -> requestDataForQuery('encabezado_registro_id','integer');
		$causal_anulacion_id    = $this -> requestDataForQuery('causal_anulacion_id','integer');
		$observaciones          = $this -> requestDataForQuery('observaciones','text');

		$select = "SELECT e.periodo_contable_id, mc.mes_contable_id, e.estado FROM encabezado_de_registro e,  mes_contable mc  
		WHERE  e.encabezado_registro_id=$encabezado_registro_id AND mc.periodo_contable_id=e.periodo_contable_id  ";
		$result = $this -> DbFetchAll($select,$Conex,true); 
		$periodo_contable_id = $result[0][periodo_contable_id];

		$update="UPDATE periodo_contable SET estado=1 WHERE periodo_contable_id=$periodo_contable_id";
		$this -> query($update,$Conex,true);
		
		$update1="UPDATE mes_contable SET estado=1 WHERE periodo_contable_id=$periodo_contable_id";
		$this -> query($update1,$Conex,true);

		$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$observaciones AS observaciones, usuario_anula, fecha_anulacion, usuario_actualiza, fecha_actualiza FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";

		
		
		$this -> query($insert,$Conex,true);
		
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{
			
			$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
			imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
			encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id FROM 
			imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
			
			$this -> query($insert,$Conex,true);
			
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{	
				
				$update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = 
				$encabezado_registro_id";	  
				$this -> query($update,$Conex,true);	
				
				if(strlen($this -> GetError()) > 0){
					$this -> Rollback($Conex);
				}else{	
					
					$update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
					$this -> query($update,$Conex);			  
					
					if(strlen($this -> GetError()) > 0){
						$this -> Rollback($Conex);
					}else{		
						$this -> Commit($Conex);			
					}
					
				}
				
			}

		}
	}

	public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;		
		
	}

	public function getCodigoPuc($puc_id,$Conex){
		
		$select = "SELECT codigo_puc FROM puc WHERE puc_id = $puc_id";
		$result = $this -> DbFetchAll($select,$Conex,true); 	
		
		return $result[0]['codigo_puc'];  
	}

	public function getEmpTercero($empresa_id,$Conex){
		
		$select = "SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id";
		$result = $this -> DbFetchAll($select,$Conex,true); 	
		
		return $result[0]['tercero_id'];  
	}

	public function getDocumentos($Conex){
		
		$select = "SELECT tipo_documento_id AS value, nombre AS text FROM tipo_de_documento WHERE de_cierre = 1";
		$result = $this -> DbFetchAll($select,$Conex,true); 	
		
		return $result;  
	}

	public function naturalezaorigen($puc_id,$Conex){
		
		$select = "SELECT naturaleza FROM puc WHERE puc_id = $puc_id";
		$result = $this -> DbFetchAll($select,$Conex,true); 	
		
		return $result[0]['naturaleza'];  
	}


	
	public function selectSaldoCuentaTercero($desde,$hasta,$Conex){  
		
		include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
		
		$utilidadesContables = new UtilidadesContablesModel();
		$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
		$arrayResult         = array();   
		
		$select = "
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  
		AND  p.codigo_puc LIKE '4%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  
		AND  p.codigo_puc LIKE '5%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  
		AND  p.codigo_puc LIKE '6%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  
		AND  p.codigo_puc LIKE '7%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id  ORDER BY e.fecha ASC)

		";
		
		$result = $this -> DbFetchAll($select,$Conex,true);    
		
		return  $result;	        
		
	}

	public function selectSaldoCuentaTerceroUnCentro($centro_de_costo_id,$desde,$hasta,$Conex){  
		
		include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
		
		$utilidadesContables = new UtilidadesContablesModel();
		$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
		$arrayResult         = array();   
		
		$select = "
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '4%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '5%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '6%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, i.tercero_id,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '7%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.tercero_id,i.puc_id, i.centro_de_costo_id  ORDER BY e.fecha ASC) 

		";   
		
		$result = $this -> DbFetchAll($select,$Conex,true);    
		
		return  $result;	        
		
	}
	public function selectSaldoCuentasinTerceroUnCentro($centro_de_costo_id,$desde,$hasta,$Conex){  
		
		include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
		
		$utilidadesContables = new UtilidadesContablesModel();
		$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
		$arrayResult         = array();   
		
		$select = "
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, 	
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '4%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.puc_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, 
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '5%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.puc_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, 
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '6%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.puc_id ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, 
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  AND i.centro_de_costo_id=$centro_de_costo_id
		AND  p.codigo_puc LIKE '7%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY  i.puc_id ORDER BY e.fecha ASC) 

		";   
		
		$result = $this -> DbFetchAll($select,$Conex,true);    
		
		return  $result;	        
		
	}

	public function selectSaldoCuentasinTercero($desde,$hasta,$Conex){  
		
		include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
		
		$utilidadesContables = new UtilidadesContablesModel();
		$fechaDesdeSaldo     = $utilidadesContables -> getCondicionSaldosAuxiliares($empresa_id);	
		$arrayResult         = array();   
		
		$select = "
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, 
		i.centro_de_costo_id,i.codigo_centro_costo, i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  
		AND  p.codigo_puc LIKE '4%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY i.centro_de_costo_id,i.puc_id  ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo,
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id 
		AND  p.codigo_puc LIKE '5%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY i.centro_de_costo_id,i.puc_id   ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, 
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id  
		AND  p.codigo_puc LIKE '6%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY i.centro_de_costo_id,i.puc_id   ORDER BY e.fecha ASC)
		
		UNION ALL
		
		(SELECT (CASE WHEN p.naturaleza = 'D' THEN SUM(i.debito - i.credito) ELSE  SUM(i.credito - i.debito) END) AS saldo, 
		i.centro_de_costo_id,i.codigo_centro_costo,i.puc_id, e.fecha AS fecha_ord
		FROM  encabezado_de_registro e, imputacion_contable i,puc p, tercero t 
		WHERE  e.encabezado_registro_id  = i.encabezado_registro_id  AND i.puc_id = p.puc_id 
		AND  p.codigo_puc LIKE '7%' AND p.movimiento=1  AND e.fecha BETWEEN '$desde' AND '$hasta' AND i.tercero_id = t.tercero_id 
		GROUP BY i.centro_de_costo_id,i.puc_id   ORDER BY e.fecha ASC) 

		";   
		
		$result = $this -> DbFetchAll($select,$Conex,true);    
		
		return  $result;	        
		
	}

	public function Save($periodo_contable_id,$desde,$hasta,$encabezado_registro_id,$insert_enc,$insert,$insert1,$Conex){  
		
		$this -> Begin($Conex); 
		$this -> query($insert_enc,$Conex,true);	

		if(!strlen(trim($this -> GetError())) > 0){
			
			for($i=0;$i<count($insert);$i++){
				$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);

				$insert_com="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,
				puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,
				valor,debito,credito
				) VALUES(
				$imputacion_contable_id,";
				$this -> query($insert_com.$insert[$i],$Conex,true);		

				if($this -> GetNumError() > 0){
					return false;
				}

			}

			if($insert1!=''){
				$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
				$insert1_com="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,
				puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,
				valor,debito,credito
				) VALUES(
				$imputacion_contable_id,";
				
				$this -> query($insert1_com.$insert1,$Conex,true);
				if($this -> GetNumError() > 0){
					return false;
				}
			}
			$update="UPDATE mes_contable SET estado=2 WHERE fecha_inicio BETWEEN '$desde' AND '$hasta' OR fecha_final BETWEEN '$desde' AND '$hasta'";
			$this -> query($update,$Conex,true);

			if($this -> GetNumError() > 0){
				return false;
			}


			$select = "SELECT COUNT(*) AS movi FROM mes_contable WHERE estado=1 AND periodo_contable_id=$periodo_contable_id AND mes_trece=0";
			$result = $this -> DbFetchAll($select,$Conex,true); 
			
			if(!$result[0][movi]>0){

				$update="UPDATE mes_contable SET estado=2 WHERE mes=13 AND mes_trece=1 AND  periodo_contable_id=$periodo_contable_id";
				$this -> query($update,$Conex,true);
				
				if($this -> GetNumError() > 0){
					return false;
				}

				$update="UPDATE periodo_contable SET estado=0, fecha_cierre='".date('Y-m-d')."' WHERE periodo_contable_id=$periodo_contable_id";
				$this -> query($update,$Conex,true);

				if($this -> GetNumError() > 0){
					return false;
				}

			}
			
			$this -> Commit($Conex);		
			
			return $encabezado_registro_id;
		}
		
		
	}
	
	/***** funcion Delete ***** */
	public function Delete($Campos,$Conex){

		$this -> Begin($Conex); 	
		
		$encabezado_registro_id=$_REQUEST[encabezado_registro_id];
		
		$select = "SELECT e.periodo_contable_id, mc.mes_contable_id, e.estado FROM encabezado_de_registro e,  mes_contable mc  
		WHERE  e.encabezado_registro_id=$encabezado_registro_id AND mc.periodo_contable_id=e.periodo_contable_id  ";
		$result = $this -> DbFetchAll($select,$Conex,true); 
		$periodo_contable_id = $result[0][periodo_contable_id];
		if($result[0][estado]=='A') exit('El cierre contable esta anulado.<br> No se puede borrar');

		$select1 = "SELECT e.encabezado_registro_id, e.estado FROM encabezado_de_registro  e 
		WHERE  e.fecha>(SELECT fecha FROM encabezado_de_registro WHERE encabezado_registro_id=$encabezado_registro_id)
		AND e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre=1) AND e.estado!='A'";
		$result1 = $this -> DbFetchAll($select1,$Conex,true); 
		if($result1[0][encabezado_registro_id]>0) exit('El cierre contable no se puede Borrar, ya que hay un cierre posterior.');

		$select2 = "SELECT e.encabezado_registro_id FROM encabezado_de_registro  e 
		WHERE e.encabezado_registro_id=$encabezado_registro_id AND 
		(e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM abono_factura) 
		OR e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM abono_factura_proveedor)
		OR e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM factura_proveedor)
		OR e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM factura )
		OR e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM anticipos_despacho)
		OR e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM anticipos_manifiesto)
		OR e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM legalizacion_manifiesto)
		OR e.encabezado_registro_id IN (SELECT encabezado_registro_id FROM legalizacion_despacho))";
		$result2 = $this -> DbFetchAll($select2,$Conex,true); 
		if($result2[0][encabezado_registro_id]>0) exit('El cierre contable no se puede Borrar, ya que esta relacionado en otro Modulo.');

		$update="UPDATE periodo_contable SET estado=1 WHERE periodo_contable_id=$periodo_contable_id";
		$this -> query($update,$Conex,true);
		
		$update1="UPDATE mes_contable SET estado=1 WHERE periodo_contable_id=$periodo_contable_id";
		$this -> query($update1,$Conex,true);
		
		$delete="DELETE FROM  imputacion_contable WHERE encabezado_registro_id=$encabezado_registro_id";
		$this -> query($delete,$Conex,true);
		$this -> DbDeleteTable("encabezado_de_registro",$Campos,$Conex,true,false);
		
		$this -> Commit($Conex);	
	}				 	

	
}


?>