<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class reporteDescuadresModel extends Db{
	private $Permisos;
	public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
	}
	public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}
	public function GetOficina($Conex){
		return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,$ErrDb = false);
	}
	public function GetTrazabilidad($Conex){
		$opciones=array(0=>array('value'=>'DD','text'=>'DOCUMENTOS DESCUADRADOS'),
						1=>array('value'=>'MC','text'=>'MOVIMIENTOS SIN CENTRO DE COSTO'),
						2=>array('value'=>'MT','text'=>'CUENTA PARAMETRO TERCERO SI, CON MOVIMIENTOS SIN TERCEROS'),
						3=>array('value'=>'MP','text'=>'CUENTA PARAMETRO TERCERO NO, CON MOVIMIENTOS CON TERCEROS'),
						4=>array('value'=>'MM','text'=>'MOVIMIENTOS CUENTAS MAYORES'),
						5=>array('value'=>'DA','text'=>'DOCUMENTOS EN EDICION'),
						6=>array('value'=>'DM','text'=>'DOCUMENTOS ANULADOS CON MOVIMIENTOS'),
						7=>array('value'=>'MS','text'=>'MOVIMIENTOS SIN CODIGO CONTABLE'),
		                );
		return $opciones;
	}
	public function GetSi_Pro($Conex){
		$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
		return $opciones;
	}  

	public function getReporte1($desde,$hasta,$Conex){
		$select = "
				SELECT  e.encabezado_registro_id, e.consecutivo AS consecutivo,e.fecha,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero,
				(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
				(SELECT SUM(debito) AS debito FROM imputacion_contable WHERE 
			encabezado_registro_id = e.encabezado_registro_id) AS total_debito,(SELECT SUM(credito) AS credito FROM imputacion_contable WHERE 
			encabezado_registro_id = e.encabezado_registro_id) AS total_credito,d.saldo AS descuadre FROM  encabezado_de_registro e, tipo_de_documento td,
			oficina o,(SELECT e.encabezado_registro_id,abs(sum(debito)- sum(credito)) AS saldo FROM encabezado_de_registro e, imputacion_contable i WHERE
		
			e.encabezado_registro_id = i.encabezado_registro_id GROUP BY e.encabezado_registro_id HAVING abs(sum(debito)- sum(credito)) > 0) d WHERE 
		
			d.encabezado_registro_id = e.encabezado_registro_id AND e.tipo_documento_id = td.tipo_documento_id AND e.oficina_id = o.oficina_id 
		
			AND e.fecha BETWEEN '$desde' AND '$hasta'
		
			ORDER BY e.encabezado_registro_id
					"; //echo $select;
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}


	public function getReporte2($desde,$hasta,$Conex){
		$select = "SELECT
						e.encabezado_registro_id, e.consecutivo AS consecutivo,
						e.fecha,
						(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
						(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero
						
					FROM
						encabezado_de_registro e 
					WHERE
						e.fecha BETWEEN '$desde' AND '$hasta' AND estado='E'
					ORDER BY
						e.encabezado_registro_id
					"; //echo $select;
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}
	public function getReporte3($desde,$hasta,$Conex){ 
		$select = "SELECT
						e.encabezado_registro_id,
						e.consecutivo AS consecutivo,
						e.fecha,
						(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
						(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero
						
					FROM
						imputacion_contable i, encabezado_de_registro e 
					WHERE
						i.encabezado_registro_id=e.encabezado_registro_id AND i.puc_id IN (SELECT puc_id FROM puc WHERE nivel=5 AND requiere_centro_costo=1) AND i.centro_de_costo_id IS NULL AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.estado = 'C' 
					ORDER BY
						e.encabezado_registro_id
					"; 
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}
	public function getReporte4($desde,$hasta,$Conex){ 
		$select = "SELECT
						e.encabezado_registro_id, e.consecutivo AS consecutivo,
						e.fecha,
						(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
						(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero
						
					FROM
						imputacion_contable i, encabezado_de_registro e 
					WHERE
						i.encabezado_registro_id=e.encabezado_registro_id AND i.puc_id IN (SELECT puc_id FROM puc WHERE nivel=5 AND requiere_tercero=1) AND i.tercero_id IS NULL AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.estado='C' 
					ORDER BY
						e.encabezado_registro_id
					"; //echo $select;
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}
	public function getReporte5($desde,$hasta,$Conex){ 
		$select = "SELECT
						e.encabezado_registro_id, e.consecutivo AS consecutivo,
						e.fecha,
						(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
						(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero
						
					FROM
						imputacion_contable i, encabezado_de_registro e 
					WHERE
						i.encabezado_registro_id=e.encabezado_registro_id AND i.puc_id IN (SELECT puc_id FROM puc WHERE nivel!=5) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.estado='C' 
					ORDER BY
						e.encabezado_registro_id
					"; //echo $select;
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}
	public function getReporte6($desde,$hasta,$Conex){ 
		$select = "SELECT
						e.encabezado_registro_id, e.consecutivo AS consecutivo,
						e.fecha,
						(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
						(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero
						
					FROM
						imputacion_contable i, encabezado_de_registro e 
					WHERE
						i.encabezado_registro_id=e.encabezado_registro_id AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.estado='A' AND (i.debito>0 OR i.credito>0)
					ORDER BY
						e.encabezado_registro_id
					"; //echo $select;
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}
	public function getReporte7($desde,$hasta,$Conex){ 
		$select = "SELECT
						e.encabezado_registro_id, e.consecutivo AS consecutivo,
						e.fecha,
						(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
						(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero
						
					FROM
						imputacion_contable i, encabezado_de_registro e 
					WHERE
						i.encabezado_registro_id=e.encabezado_registro_id AND i.puc_id NOT IN (SELECT puc_id FROM puc) AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.estado='C' 
					ORDER BY
						e.encabezado_registro_id
					"; //echo $select;
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}
	public function getReporte8($desde,$hasta,$Conex){ 
		$select = "SELECT
						e.encabezado_registro_id, e.consecutivo AS consecutivo,
						e.fecha,
						(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=e.tipo_documento_id)AS tipo_documento,
						(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS tercero FROM tercero t WHERE t.tercero_id=e.tercero_id)AS tercero
						
					FROM
						imputacion_contable i, encabezado_de_registro e 
					WHERE
						i.encabezado_registro_id=e.encabezado_registro_id AND i.puc_id IN (SELECT puc_id FROM puc WHERE nivel=5 AND requiere_tercero=0) AND i.tercero_id IS NOT NULL AND e.fecha BETWEEN '$desde' AND '$hasta' AND e.estado='C' 
					ORDER BY
						e.encabezado_registro_id
					"; //echo $select;
					
		$result = $this -> DbFetchAll($select,$Conex,true);//print_r($result);
		return $result;
	}
	
}
?>