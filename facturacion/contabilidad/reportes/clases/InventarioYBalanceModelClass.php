<?php
require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";
require_once "../../../framework/clases/UtilidadesContablesModelClass.php";
final class InventarioYBalanceModel extends Db
{
    private $Permisos;
    private $mes_contable_id;
    private $periodo_contable_id;

    public function SetUsuarioId($usuario_id, $oficina_id)
    {
        $this->Permisos = new PermisosForm();
        $this->Permisos->SetUsuarioId($usuario_id, $oficina_id);
    }

    public function getPermiso($ActividadId, $Permiso, $Conex)
    {
        return $this->Permisos->getPermiso($ActividadId, $Permiso, $Conex);
    }

//LISTA MENU
    public function getEmpresas($usuario_id, $Conex)
    {

        $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM
	 opciones_actividad WHERE usuario_id = $usuario_id))";

        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

        return $result;

    }

    public function selectSubCuentas($codigo_puc, $Conex)
    {

        $select = "SELECT puc_id,codigo_puc,nombre,movimiento FROM puc WHERE puc_puc_id = (SELECT puc_id FROM puc WHERE
	 TRIM(codigo_puc) = TRIM('$codigo_puc')) ORDER BY codigo_puc ASC";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getCodigoPucUtilidadPerdida($nivel, $saldo, $utilidadesContables, $Conex)
    {

        $select = "SELECT p.* FROM parametro_reporte_contable p";
        $data = $this->DbFetchAll($select, $Conex, true);

        if (count($data) > 0) {

            $utilidad_id = $data[0]['utilidad_id'];
            $perdida_id = $data[0]['perdida_id'];

            if ($saldo > 0) {

                $puc_id = $utilidadesContables->getCuentaMayor($utilidad_id, $nivel, $Conex);

                return strlen(trim($puc_id)) > 0 ? $puc_id : $utilidad_id;

            } else {

                $puc_id = $utilidadesContables->getCuentaMayor($perdida_id, $nivel, $Conex);

                return strlen(trim($puc_id)) > 0 ? $puc_id : $perdida_id;

            }

        } else {
            exit("No ha parametrizado aun las cuentas de utilidad y/o perdida");
        }

    }

    public function getCuentasBalance($Conex)
    {
        $select = "SELECT
					puc_id AS value,
					CONCAT_WS(' ',codigo_puc,nombre) AS text
				FROM
					puc
				WHERE
					nivel = 1
					AND estado = 'A'
					AND puc_id < 4
				ORDER BY
					codigo_puc
				ASC";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;
    }

    public function getCuentasBalance2($Conex)
    {
        $select = "SELECT
					puc_id AS value,
					CONCAT_WS(' ',codigo_puc,nombre) AS text
				FROM
					puc
				WHERE
					nivel = 1
					AND estado = 'A'
					AND puc_id > 3
					AND puc_id < 8
				ORDER BY
					codigo_puc
				ASC";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;
    }
    public function getDatosCuenta($puc, $Conex)
    {
        $select = "SELECT
					puc_id AS value,
					nombre AS text
				FROM
					puc
				WHERE
					puc_id=$puc
					AND estado = 'A'
				ORDER BY
					codigo_puc
				ASC";
        $result = $this->DbFetchAll($select, $Conex, true);
        return $result;
    }

    public function getSaldoCuenta($opcierre, $puc_id, $desde, $hasta, $centro_de_costo_id, $tercero_id, $empresa_id, $Conex)
    {

        $utilidadesContables = new UtilidadesContablesModel();
        $cuentasMovimiento = $utilidadesContables->getCuentasMovimiento($puc_id, $Conex);
        $fechaSaldoBalance = $utilidadesContables->getCondicionSaldosBalanceGeneral($empresa_id);
        $dataCuenta = array();
        if ($opcierre == 'N') {
            $condicion_cierre = " AND (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1) OR (e.tipo_documento_id IN (SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND i.puc_id IN (SELECT p.puc_id from puc p, parametro_reporte_contable pr where (p.puc_id=pr.utilidad_cierre_id OR p.puc_id=pr.perdida_cierre_id) AND pr.parametro_reporte_contable_id = 1)) )";
        } else {
            $condicion_cierre = "";
        }
        if (strlen($cuentasMovimiento) > 0) {

            $select = "SELECT nombre,naturaleza,codigo_puc FROM puc WHERE puc_id = $puc_id";
            $result = $this->DbFetchAll($select, $Conex, true);
            $dataCuenta['cuenta'] = $result[0]['nombre'];
            $dataCuenta['codigo_puc'] = $result[0]['codigo_puc'];
            $naturaleza = $result[0]['naturaleza'];

            if ($tercero_id == 'NULL') {

                $select = "SELECT (CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE
				SUM(credito - debito) END) AS
				saldo_anterior FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado='C' AND e.fecha <= DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.encabezado_registro_id =
				i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND
				i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre";

                $result = $this->DbFetchAll($select, $Conex, true);

                $dataCuenta['saldo_anterior'] = $result[0]['saldo_anterior'];

                $select = "SELECT SUM(debito) AS debito, SUM(credito) AS credito FROM encabezado_de_registro e,
				imputacion_contable i WHERE e.estado='C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND
				e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento)
				AND i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre";

                $result = $this->DbFetchAll($select, $Conex, true);
                $dataCuenta['debito'] = $result[0]['debito'];
                $dataCuenta['credito'] = $result[0]['credito'];
                if ($naturaleza == 'C') {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $credito) - ($debito);
                } else {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $debito) - ($credito);
                }

            } else {

                $select = "SELECT (CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE
				SUM(credito - debito) END) AS
				saldo_anterior FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado='C' AND  e.fecha <= DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.encabezado_registro_id =
				i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND
				i.centro_de_costo_id IN ($centro_de_costo_id) AND i.tercero_id IN ($tercero_id) $condicion_cierre";

                $result = $this->DbFetchAll($select, $Conex, true);
				

                $dataCuenta['saldo_anterior'] = $result[0]['saldo_anterior'];

                $select = "SELECT p.puc_id, SUM(debito) AS debito, SUM(credito) AS credito FROM encabezado_de_registro e,
				imputacion_contable i,puc p WHERE e.estado='C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND
				e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento)
				AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.tercero_id
				IN ($tercero_id) $condicion_cierre GROUP BY p.puc_id";

                $result = $this->DbFetchAll($select, $Conex, true);
                $dataCuenta['debito'] = $result[0]['debito'];
                $dataCuenta['credito'] = $result[0]['credito'];
                if ($naturaleza == 'C') {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $credito) - ($debito);
                } else {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $debito) - ($credito);
                }
            }
        }
        return $dataCuenta;
    }
    public function getSaldoCuenta1($opcierre, $puc_id, $desde, $hasta, $centro_de_costo_id, $tercero_id, $empresa_id, $Conex)
    {
        $utilidadesContables = new UtilidadesContablesModel();
        $cuentasMovimiento = $utilidadesContables->getCuentasMovimiento($puc_id, $Conex);
        $fechaSaldoBalance = $utilidadesContables->getCondicionSaldosBalanceGeneral($empresa_id);
        $dataCuenta = array();
        if ($opcierre == 'N') {
            $condicion_cierre = " AND (e.tipo_documento_id IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre != 1))"; /*OR (e.tipo_documento_id IN(SELECT tipo_documento_id FROM tipo_de_documento WHERE de_cierre = 1) AND i.puc_id IN(939970,939971))";*/
        } else {
            $condicion_cierre = "";
        }
        if (strlen($cuentasMovimiento) > 0) {
            if ($tercero_id == 'NULL') {
				
                $select = "SELECT nombre,naturaleza,codigo_puc FROM puc WHERE puc_id = $puc_id";
				
                $result = $this->DbFetchAll($select, $Conex, true);
				
                $dataCuenta['cuenta'] = $result[0]['nombre'];
				
                $dataCuenta['codigo_puc'] = $result[0]['codigo_puc'];
				
                $naturaleza = $result[0]['naturaleza'];
				
                $select = "SELECT (CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE
				SUM(credito - debito) END) AS
				saldo_anterior FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado='C' AND e.fecha BETWEEN
				$fechaSaldoBalance	AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.encabezado_registro_id =
				i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND
				i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre";
                $result = $this->DbFetchAll($select, $Conex, true);
                $dataCuenta['saldo_anterior'] = $result[0]['saldo_anterior'];
                $select = "SELECT SUM(debito) AS debito, SUM(credito) AS credito FROM encabezado_de_registro e,
				imputacion_contable i WHERE e.estado='C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND
				e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento)
				AND i.centro_de_costo_id IN ($centro_de_costo_id) $condicion_cierre";
                $result = $this->DbFetchAll($select, $Conex, true);
                $dataCuenta['debito'] = $result[0]['debito'];
                $dataCuenta['credito'] = $result[0]['credito'];
                if ($naturaleza == 'C') {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $credito) - ($debito);
                } else {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $debito) - ($credito);
                }

            } else {
                $select = "SELECT nombre,naturaleza FROM puc WHERE puc_id = $puc_id";
                $result = $this->DbFetchAll($select, $Conex, true);
                $dataCuenta['cuenta'] = $result[0]['nombre'];
                $naturaleza = $result[0]['naturaleza'];
                $select = "SELECT tercero_id,saldos.saldo_anterior
			(SELECT i.tercero_id,(CASE WHEN p.naturaleza='D' THEN SUM(debito - credito) ELSE
			SUM(credito - debito) END) AS
			saldo_anterior FROM encabezado_de_registro e,imputacion_contable i,puc p WHERE e.estado='C' AND e.fecha BETWEEN
			$fechaSaldoBalance	AND DATE_SUB('$desde',INTERVAL 1 DAY) AND  e.encabezado_registro_id =
			i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento) AND i.puc_id = p.puc_id AND
			i.centro_de_costo_id IN ($centro_de_costo_id) AND i.tercero_id IN ($tercero_id) $condicion_cierre GROUP BY tercero_id)
			saldos,

			SELECT p.puc_id,SUM(debito) AS debito, SUM(credito) AS credito FROM encabezado_de_registro e,
			imputacion_contable i,puc p WHERE e.estado='C' AND e.fecha BETWEEN '$desde' AND '$hasta' AND
			e.encabezado_registro_id = i.encabezado_registro_id AND i.puc_id IN ($cuentasMovimiento)
			AND i.puc_id = p.puc_id AND i.centro_de_costo_id IN ($centro_de_costo_id) AND i.tercero_id
			IN ($tercero_id) $condicion_cierre GROUP BY p.puc_id
			";
                $result = $this->DbFetchAll($select, $Conex, true);
                $dataCuenta['debito'] = $result[0]['debito'];
                $dataCuenta['credito'] = $result[0]['credito'];
                if ($naturaleza == 'C') {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $credito) - ($debito);
                } else {
                    $saldo_anterior = is_numeric($dataCuenta['saldo_anterior']) ? $dataCuenta['saldo_anterior'] : 0;
                    $debito = is_numeric($dataCuenta['debito']) ? $dataCuenta['debito'] : 0;
                    $credito = is_numeric($dataCuenta['credito']) ? $dataCuenta['credito'] : 0;
                    $dataCuenta['nuevo_saldo'] = ($saldo_anterior + $debito) - ($credito);
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

    public function esCuentaMovimiento($puc_id, $Conex)
    {

        $select = "SELECT movimiento FROM puc WHERE puc_id = $puc_id";
        $result = $this->DbFetchAll($select, $Conex);

        if ($result[0]['movimiento'] == 1) {
            return true;
        } else {
            return false;
        }

    }

}
