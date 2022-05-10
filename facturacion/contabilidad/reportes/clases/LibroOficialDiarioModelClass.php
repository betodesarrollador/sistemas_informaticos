<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class LibroOficialDiarioModel extends Db{
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
	public function getEmpresas($usuario_id,$Conex){
		$select =	"SELECT e.empresa_id AS value, 
						CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text 
					FROM empresa e,tercero t
					WHERE t.tercero_id = e.tercero_id
					AND e.empresa_id IN (SELECT empresa_id 
											FROM empresa 
											WHERE empresa_id IN (SELECT empresa_id
																	FROM opciones_actividad
																	WHERE usuario_id = $usuario_id
																)
					)";
		$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
		return $result;
	}
	
	public function getSaldoCuenta($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$empresa_id,$Conex){
	  
		$utilidadesContables = new UtilidadesContablesModel();
	  
		$cuentasMovimiento = $utilidadesContables -> getCuentasMovimiento($puc_id,$Conex);
		$fechaSaldoBalance = $utilidadesContables -> getCondicionSaldosBalanceGeneral($empresa_id);	  
		$dataCuenta        = array();
		if ($opcierre=='N') {
			$condicion_cierre=" AND edr.tipo_documento_id IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1)";
		}else{
			$condicion_cierre="";
		}
		if(strlen($cuentasMovimiento)>0){
	  
			if($tercero_id == 'NULL'){
				$select = "SELECT
							(SELECT nombre FROM tipo_de_documento where edr.tipo_documento_id=tipo_documento_id) AS nombre, 
							SUM(debito) AS debito,
							SUM(credito) AS credito
						FROM
							imputacion_contable ic,
							encabezado_de_registro edr
						WHERE
							edr.estado!='A'
							AND ic.encabezado_registro_id=edr.encabezado_registro_id
							AND edr.fecha BETWEEN ('$desde') AND ('$hasta')
							AND edr.oficina_id IN ($centro_de_costo_id)
							AND ic.puc_id IN ($cuentasMovimiento)
							$condicion_cierre
						GROUP BY
							nombre
						ORDER BY
	 						 nombre";
				$result						= $this->DbFetchAll($select,$Conex,true);
				$dataCuenta=$result;
			}
		 
		}
		return $dataCuenta;
    }

	public function getSaldoCuentaTerceros($puc_id,$desde,$hasta,$centro_de_costo_id,$empresa_id,$Conex){
		$utilidadesContables = new UtilidadesContablesModel();	  
		$fechaSaldoBalance   = $utilidadesContables -> getCondicionSaldosBalanceGeneral($empresa_id);	  
		$dataCuenta          = array();
		$select = "SELECT nombre,naturaleza FROM puc WHERE puc_id = $puc_id";
		$result               = $this->DbFetchAll($select,$Conex,true);
		$naturaleza           = $result[0]['naturaleza'];		  
		$select = "SELECT DISTINCT i.tercero_id 
						FROM encabezado_de_registro e,imputacion_contable i,puc p 
						WHERE e.fecha BETWEEN $fechaSaldoBalance 
							AND DATE_SUB('$desde',INTERVAL 1 DAY)
							AND e.encabezado_registro_id = i.encabezado_registro_id
							AND i.puc_id = $puc_id
							AND i.puc_id = p.puc_id
							AND i.centro_de_costo_id IN ($centro_de_costo_id)
					UNION 
					SELECT DISTINCT i.tercero_id 
						FROM encabezado_de_registro e,imputacion_contable i 
						WHERE e.fecha BETWEEN '$desde' AND '$hasta' 
							AND	e.encabezado_registro_id = i.encabezado_registro_id
							AND i.puc_id = $puc_id
							AND i.centro_de_costo_id IN ($centro_de_costo_id) ";
		$terceros = $this->DbFetchAll($select,$Conex,true); 
		for($i = 0; $i < count($terceros); $i++){
			$tercero_id = is_null($terceros[$i]['tercero_id'])?'NULL':$terceros[$i]['tercero_id'];
			$select = "SELECT i.tercero_id,SUM(debito) AS debito, SUM(credito) AS credito 
							FROM encabezado_de_registro e, imputacion_contable i 
							WHERE e.fecha BETWEEN '$desde' AND '$hasta' 
								AND	e.encabezado_registro_id = i.encabezado_registro_id 
								AND i.tercero_id = $tercero_id 
								AND i.puc_id = $puc_id 
								AND i.centro_de_costo_id IN ($centro_de_costo_id) 
							GROUP BY i.tercero_id";
			$movimientos 	= $this->DbFetchAll($select,$Conex,true);
			$debito         = is_numeric($movimientos[0]['debito'])?$movimientos[0]['debito']:0;
			$credito        = is_numeric($movimientos[0]['credito'])?$movimientos[0]['credito']:0;
			$tercero_id    = is_null($saldos[0]['tercero_id'])?$movimientos[0]['tercero_id']:$saldos[0]['tercero_id'];
			$select			= "SELECT CONCAT_WS('-',numero_identificacion,digito_verificacion) AS numero_identificacion,CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS nombre_tercero FROM tercero WHERE tercero_id = $tercero_id";
			$datos_tercero 	= $this->DbFetchAll($select,$Conex); 

			$dataCuenta[$i]['cuenta']			= '&nbsp;&nbsp;'.$datos_tercero[0]['nombre_tercero'];
			$dataCuenta[$i]['codigo_puc']		= '&nbsp;&nbsp;'.$datos_tercero[0]['numero_identificacion'];
			$dataCuenta[$i]['debito']			= $debito;				          		    
			$dataCuenta[$i]['credito']			= $credito;	  
		}
		return $dataCuenta;
	}
	
	public function getCuentasBalance($nivel,$Conex){
		$select = "SELECT puc_id AS value,CONCAT_WS(' ',codigo_puc,nombre) AS text FROM puc WHERE nivel = $nivel AND estado = 'A' ORDER BY codigo_puc ASC";
		$result = $this -> DbFetchAll($select,$Conex,true);            
		return $result;	  
	}
	public function selectSubCuentas($codigo_puc,$Conex){   
		$select = "SELECT puc_id,codigo_puc,nombre,movimiento FROM puc WHERE puc_puc_id = (SELECT puc_id FROM puc WHERE TRIM(codigo_puc) = TRIM('$codigo_puc')) ORDER BY codigo_puc ASC";
		$result = $this -> DbFetchAll($select,$Conex,true); 	 
		return $result;     
	}
	public function getCuentaMayor($puc_id,$nivel,$Conex){
		if(strlen(trim($puc_id)) > 0){
			$select = "SELECT puc_id,nivel FROM puc WHERE puc_id = (SELECT puc_puc_id FROM puc WHERE puc_id = $puc_id)";
			$result = $this	-> DbFetchAll($select,$Conex);
			$nivelMayor = $result[0]['nivel'];
			$puc_id		= $result[0]['puc_id'];
			if($nivelMayor == $nivel){
				return $puc_id;
			}
			else{
				return $this -> getCuentaMayor($puc_id,$nivel,$Conex);
			}
		}
		else{
			return null;
		}
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