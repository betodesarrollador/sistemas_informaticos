<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AutorizaPagoModel extends Db{

	private $usuario_id;
	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function validarEdicion($Conex){
		
			$select = "SELECT	COUNT(*) AS en_edicion 	FROM depreciacion_activo da	WHERE da.estado = 'A'";
			$data = $this -> DbFetchAll($select,$Conex,true);
			return $data[0]['en_edicion'];
	}

	public function validarAnterior($anio,$mes,$fecha_ini_dep,$Conex){
			$fecha_ini=$anio.'-'.$mes.'-01';

			$select = "SELECT	COUNT(*) AS en_edicion 	FROM depreciacion_activo da	
			WHERE da.fecha BETWEEN DATE_SUB('$fecha_ini',INTERVAL 1 MONTH) AND LAST_DAY(DATE_SUB('$fecha_ini',INTERVAL 1 MONTH)) AND da.estado IN ('A','C')";
			$data = $this -> DbFetchAll($select,$Conex,true);
			
			if($data[0]['en_edicion']>0 || ($fecha_ini==$fecha_ini_dep)){
				return true;
			}else{
				return false;
			}
			
			
	}

	public function generateReporte($desde,$hasta,$consulta_proveedor,$Conex){
			$select = "(SELECT
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id=f.proveedor_id) AS proveedor,					
					f.codfactura_proveedor,
					f.fecha_factura_proveedor,
					f.vence_factura_proveedor,
					f.concepto_factura_proveedor,
					(SELECT IF(cre_item_factura_proveedor>deb_item_factura_proveedor, cre_item_factura_proveedor,deb_item_factura_proveedor )as valor FROM item_factura_proveedor WHERE factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) as valor_factura_proveedor,
					
					(SELECT IF(SUM(ra.rel_valor_abono_factura)>0,SUM(ra.rel_valor_abono_factura),0)  AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' ) as abonos,
					
					((SELECT IF(cre_item_factura_proveedor>deb_item_factura_proveedor, cre_item_factura_proveedor,deb_item_factura_proveedor )as valor FROM item_factura_proveedor WHERE factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1)-(SELECT IF(SUM(ra.rel_valor_abono_factura)>0,SUM(ra.rel_valor_abono_factura),0)  AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C'  )) AS saldo
					
					
					FROM factura_proveedor f
				WHERE f.fecha_factura_proveedor between '$desde' AND '$hasta' AND f.valor_factura_proveedor>0 AND f.autoriza_pago=0 AND f.estado_factura_proveedor='C' $consulta_proveedor)
			UNION ALL
			(SELECT
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id=f.proveedor_id) AS proveedor,					
					f.codfactura_proveedor,
					f.fecha_factura_proveedor,
					f.vence_factura_proveedor,
					f.concepto_factura_proveedor,
					(SELECT IF(cre_item_factura_proveedor>deb_item_factura_proveedor, cre_item_factura_proveedor,deb_item_factura_proveedor )as valor FROM item_factura_proveedor WHERE factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1) as valor_factura_proveedor,
					
					(SELECT IF(SUM(ra.rel_valor_abono_factura)>0,SUM(ra.rel_valor_abono_factura),0)  AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C' ) as abonos,
					
					((SELECT IF(cre_item_factura_proveedor>deb_item_factura_proveedor, cre_item_factura_proveedor,deb_item_factura_proveedor )as valor FROM item_factura_proveedor WHERE factura_proveedor_id=f.factura_proveedor_id AND contra_factura_proveedor=1)-(SELECT IF(SUM(ra.rel_valor_abono_factura)>0,SUM(ra.rel_valor_abono_factura),0)  AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C'  )) AS saldo
					
					
					FROM factura_proveedor f
				WHERE f.fecha_factura_proveedor between '$desde' AND '$hasta' AND f.valor_factura_proveedor>0 AND f.autoriza_pago=1 AND f.estado_factura_proveedor='C'
				AND  f.valor_factura_proveedor > f.valor_autorizado
				$consulta_proveedor)
			
			
			
			";
				//echo $select;
			$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
	}

	public function generateReporte1($desde,$hasta,$consulta_proveedor,$Conex){
			$select = "SELECT
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id=f.proveedor_id) AS proveedor,					
					f.codfactura_proveedor,
					f.fecha_factura_proveedor,
					f.vence_factura_proveedor,
					f.concepto_factura_proveedor,
					f.valor_factura_proveedor,
					f.valor_autorizado,
					CONCAT('\'',f.aut_fecha_factura,'\'')as aut_fecha_factura,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, usuario u WHERE t.tercero_id=u.tercero_id AND u.usuario_id=f.aut_usuario_id) AS usuario,
					
					(f.valor_factura_proveedor-(SELECT IF(SUM(ra.rel_valor_abono_factura)>0,SUM(ra.rel_valor_abono_factura),0)  AS abonos FROM relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C'  $saldos)	)
					
					AS saldo
					FROM factura_proveedor f
				WHERE f.aut_fecha_factura between '$desde 00:00:00' AND '$hasta 23:59:59' AND f.valor_factura_proveedor>0 AND f.autoriza_pago=1 AND f.estado_factura_proveedor='C' $consulta_proveedor
			
			";
				//exit($select);
			$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
	}

	public function generateReporteexcel($desde,$hasta,$Conex){
			$select = "(SELECT
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id=f.proveedor_id) AS proveedor,					
					f.codfactura_proveedor,
					f.fecha_factura_proveedor,
					f.vence_factura_proveedor,
					f.concepto_factura_proveedor,
					f.valor_factura_proveedor,
					(f.valor_factura_proveedor-(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C'  $saldos)) AS saldo					
				FROM factura_proveedor f
				WHERE f.fecha_factura_proveedor between '$desde' AND '$hasta' AND f.valor_factura_proveedor>0 AND f.autoriza_pago=0 AND f.estado_factura_proveedor='C' $consulta_proveedor)
			UNION ALL
			(SELECT
					f.factura_proveedor_id,
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS consecutivo,
					(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, proveedor p WHERE t.tercero_id=p.tercero_id AND p.proveedor_id=f.proveedor_id) AS proveedor,					
					f.codfactura_proveedor,
					f.fecha_factura_proveedor,
					f.vence_factura_proveedor,
					f.concepto_factura_proveedor,
					f.valor_factura_proveedor,
					(f.valor_factura_proveedor-(SELECT SUM(ra.rel_valor_abono_factura) AS abonos FROM  relacion_abono_factura ra, abono_factura_proveedor ab 
					WHERE ra.factura_proveedor_id=f.factura_proveedor_id AND ab.abono_factura_proveedor_id=ra.abono_factura_proveedor_id AND ab.estado_abono_factura='C'  $saldos)) AS saldo					
				FROM factura_proveedor f
				WHERE f.fecha_factura_proveedor between '$desde' AND '$hasta' AND f.valor_factura_proveedor>0 AND f.autoriza_pago=1 AND f.estado_factura_proveedor='C'
				AND  f.valor_factura_proveedor > f.valor_autorizado 
				$consulta_proveedor)
			
			";
			//echo $select;
			$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
	}


	public function Contabilizar($empresa_id,$usuario_id,$oficina_id,$modifica,$Conex){
		
		include_once("UtilidadesContablesModelClass.php");
		$utilidadesContables = new UtilidadesContablesModel(); 	
		$desde = $this -> requestDataForQuery('desde','date');
		$hasta = $this -> requestDataForQuery('hasta','date');
		$facturas = substr($_REQUEST['facturas'], 0, -1);
		
		$this -> Begin($Conex);


		if($facturas!=''){
			
			$facturas_id = explode(',',$facturas);
			
			foreach($facturas_id as $factura){
				
				$factura_proveedor = explode('=',$factura);
				
				$factura_proveedor_id = $factura_proveedor[0];
				$valor_autorizado     = $factura_proveedor[1];
				
				$valor_autorizado     = str_replace("$","",$valor_autorizado);
				$valor_autorizado     = str_replace(".","",$valor_autorizado);
				$valor_autorizado     = str_replace(",",".",$valor_autorizado);
				
				if($valor_autorizado>0 && $factura_proveedor_id>0){
					$sql = "UPDATE factura_proveedor SET autoriza_pago='1', aut_usuario_id=$usuario_id, valor_autorizado = $valor_autorizado, aut_fecha_factura=NOW() WHERE factura_proveedor_id IN ($factura_proveedor_id)";
					//exit($sql);
					$result = $this -> query($sql,$Conex,true);
				}
				
			}
				
			
	
			$this -> Commit($Conex);
			return 'si';
				
	
		}else{
			$this -> Rollback($Conex);
			exit("No se selecciono Ninguna Factura");	
		}
	}


  

}
	
?>
