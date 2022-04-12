<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
require_once("../../../framework/clases/UtilidadesContablesModelClass.php");
final class MayoryBalanceModel extends Db{
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
     
  
  public function getCuentasBalance($nivel,$Conex){
	  
     $select = "SELECT puc_id AS value, nombre AS text FROM puc WHERE nivel = $nivel 
	            AND estado = 'A' ORDER BY codigo_puc ASC";
     $result = $this -> DbFetchAll($select,$Conex,true);            
	 
	 return $result;	  
	  
  }
  
	public function getSaldoCuenta($opcierre,$puc_id,$desde,$hasta,$centro_de_costo_id,$tercero_id,$empresa_id,$Conex){
	  
		$utilidadesContables = new UtilidadesContablesModel();
		 
	    $cuentasMovimiento = $utilidadesContables -> getCuentasMovimiento($puc_id,$Conex);
		$fechaSaldoBalance = $utilidadesContables -> getCondicionSaldosBalanceGeneral($empresa_id);	  
		$dataCuenta        = array();
		if ($opcierre=='N') {
			$condicion_cierre=" AND e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1)";
		}else{
			$condicion_cierre=" ";
		}
		if(strlen($cuentasMovimiento)>0){
		  
			if($tercero_id == 'NULL'){
			  
				$select = "SELECT nombre,naturaleza,codigo_puc FROM puc WHERE puc_id = $puc_id";
				$result                   = $this->DbFetchAll($select,$Conex,true);
				$dataCuenta['codigo_puc'] = $result[0]['codigo_puc'];
				$dataCuenta['nombre_puc'] = $result[0]['nombre'];
				$naturaleza               = $result[0]['naturaleza'];
				
				$select = "SELECT SUM(debito) AS sadebito, SUM(credito) AS sacredito 
							FROM encabezado_de_registro e,imputacion_contable i,puc p 
							WHERE e.fecha <= DATE_SUB('$desde',INTERVAL 1 DAY)
								AND e.encabezado_registro_id = i.encabezado_registro_id
								AND i.puc_id IN ($cuentasMovimiento) 
								AND i.puc_id = p.puc_id
								$condicion_cierre
								AND i.centro_de_costo_id IN ($centro_de_costo_id)"; 

				$result						= $this->DbFetchAll($select,$Conex,true);
				$dataCuenta['sadebito']		= $result[0]['sadebito'];
				$dataCuenta['sacredito']	= $result[0]['sacredito'];
				if ($naturaleza == 'C') {
					$sacredito = $dataCuenta['sacredito']-$dataCuenta['sadebito'];
					if ($sacredito < 0) {
						$sadebito = $sadedibo + abs($sacredito);
						$sacredito = 0;
					}
						$dataCuenta['sacredito'] = $sacredito;
						$dataCuenta['sadebito'] = $sadebito;
				}else{
					$sadebito=$dataCuenta['sadebito']-$dataCuenta['sacredito'];
					if ($sadebito < 0) {
						$sacredito = $sacredito + abs($sadebito);
						$sadebito = 0;
					}
						$dataCuenta['sadebito'] = $sadebito;
						$dataCuenta['sacredito'] = $sacredito;
				}
				$select = "SELECT
								SUM(debito) AS debito,
								SUM(credito) AS credito
							FROM
								imputacion_contable ic,
								encabezado_de_registro e,
								puc p
							WHERE
								e.estado!='A'
								AND ic.encabezado_registro_id=e.encabezado_registro_id
								AND e.fecha BETWEEN ('$desde') AND ('$hasta')
								AND ic.centro_de_costo_id IN ($centro_de_costo_id)
								AND ic.puc_id = p.puc_id
								$condicion_cierre
								AND ic.puc_id IN ($cuentasMovimiento)";  
				$result               		= $this->DbFetchAll($select,$Conex,true);
				$dataCuenta['debito'] 		= $result[0]['debito'];		  	  
				$dataCuenta['credito']		= $result[0]['credito'];
				
				if($dataCuenta['credito']>0 || $dataCuenta['debito']>0){
					if ($naturaleza == 'C') {
						if(($dataCuenta['sacredito']==0 || $dataCuenta['sacredito']=='')  && ($dataCuenta['credito']==0 || $dataCuenta['credito']=='')){
							$dataCuenta['nuevo_saldoc'] = 0;							
							$dataCuenta['nuevo_saldod'] = ($dataCuenta['sadebito']+$dataCuenta['debito']);							
						}else{
							//$nvsaldoc = ($dataCuenta['sacredito']+$dataCuenta['credito'])-($dataCuenta['debito']);
							$nvsaldoc = (($dataCuenta['sacredito']-$dataCuenta['sadebito'])+($dataCuenta['credito']-$dataCuenta['debito']));
							if ($nvsaldoc < 0) {
								$nvsaldod = $nvsaldod + abs($nvsaldoc);
								$nvsaldoc = 0;
							}
							$dataCuenta['nuevo_saldoc'] = $nvsaldoc;
							$dataCuenta['nuevo_saldod'] = $nvsaldod;
							
						}
					}else{
						if(($dataCuenta['sadebito']==0 || $dataCuenta['sadebito']=='')  && ($dataCuenta['debito']==0 || $dataCuenta['debito']=='')){
							$dataCuenta['nuevo_saldod'] = 0;							
							$dataCuenta['nuevo_saldoc'] = ($dataCuenta['sacredito']+$dataCuenta['credito']);							
							
						}else{
							//$nvsaldod = ($dataCuenta['sadebito']+$dataCuenta['debito'])-($dataCuenta['credito']);
							$nvsaldod = (($dataCuenta['sadebito']-$dataCuenta['sacredito'])+($dataCuenta['debito']-$dataCuenta['credito']));
							if ($nvsaldod < 0) {
								$nvsaldoc = $nvsaldoc + abs($nvsaldod);
								$nvsaldod = 0;
							}
							$dataCuenta['nuevo_saldod'] = $nvsaldod;
							$dataCuenta['nuevo_saldoc'] = $nvsaldoc;
						}
					}
				}else{
					$dataCuenta['nuevo_saldod'] = $dataCuenta['sadebito'];
					$dataCuenta['nuevo_saldoc'] = $dataCuenta['sacredito'];
					
				}
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
	  
	  $select = "
	  SELECT DISTINCT i.tercero_id FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE 
	  e.fecha BETWEEN $fechaSaldoBalance AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.encabezado_registro_id = 
	  i.encabezado_registro_id AND i.puc_id = $puc_id AND i.puc_id = p.puc_id AND 
	  i.centro_de_costo_id IN ($centro_de_costo_id)
	  
	  UNION 
			  
	  SELECT DISTINCT i.tercero_id FROM 
	  encabezado_de_registro e,imputacion_contable i WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND 
	  e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id = $puc_id
	  AND i.centro_de_costo_id IN ($centro_de_costo_id) ";
	  $terceros = $this->DbFetchAll($select,$Conex,true); 
	  
	  for($i = 0; $i < count($terceros); $i++){
		  
		  $tercero_id = is_null($terceros[$i]['tercero_id'])?'NULL':$terceros[$i]['tercero_id'];
		  
		  $select = "
		  
				  SELECT i.tercero_id,(CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE 
				  SUM(credito - debito) END) AS
				  saldo_anterior FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.fecha BETWEEN 
				  $fechaSaldoBalance	AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.encabezado_registro_id = 
				  i.encabezado_registro_id AND i.puc_id = $puc_id AND i.tercero_id = $tercero_id AND 
				  i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY i.tercero_id	      
		  ";
			  
		  $saldos = $this->DbFetchAll($select,$Conex,true);
	
		  $select = "
		  
				  SELECT i.tercero_id,SUM(debito) AS debito, SUM(credito) AS credito FROM encabezado_de_registro e,
				  imputacion_contable i WHERE e.fecha BETWEEN '$desde' AND '$hasta' AND 
				  e.encabezado_registro_id = i.encabezado_registro_id AND i.tercero_id = $tercero_id 
				  AND i.puc_id = $puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) GROUP BY i.tercero_id	  
			  
		  ";
			  
		  $movimientos = $this->DbFetchAll($select,$Conex,true);	  		  
		  
		  $saldo_anterior = is_numeric($saldos[0]['saldo_anterior'])?$saldos[0]['saldo_anterior']:0;
		  $debito         = is_numeric($movimientos[0]['debito'])?$movimientos[0]['debito']:0;
		  $credito        = is_numeric($movimientos[0]['credito'])?$movimientos[0]['credito']:0;						
		  
		  $tercero_id    = is_null($saldos[0]['tercero_id'])?$movimientos[0]['tercero_id']:$saldos[0]['tercero_id'];
		  
		  $select        = "SELECT CONCAT_WS('-',numero_identificacion,digito_verificacion) AS numero_identificacion,CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS nombre_tercero FROM tercero WHERE tercero_id = $tercero_id";
		  $datos_tercero = $this->DbFetchAll($select,$Conex); 
			
		  $dataCuenta[$i]['cuenta']          = '&nbsp;&nbsp;'.$datos_tercero[0]['nombre_tercero'];
		  $dataCuenta[$i]['codigo_puc']      = '&nbsp;&nbsp;'.$datos_tercero[0]['numero_identificacion'];	          		    
		  $dataCuenta[$i]['saldo_anterior']  = $saldos[0]['saldo_anterior'];
		  $dataCuenta[$i]['debito']  = $debito;				          		    
		  $dataCuenta[$i]['credito'] = $credito;				          		    		  
		
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