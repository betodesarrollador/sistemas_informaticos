<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getReporteE1($oficina_id,$desde,$hasta,$estado,$Conex){
	  
	   	
	$select = " SELECT
					a.consecutivo consecutivo,(SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.fecha_arqueo fecha_arqueo, a.total_efectivo total_efectivo, a.total_cheque total_cheque, a.saldo_auxiliar saldo_auxiliar, CASE a.estado_arqueo WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado 
				FROM arqueo_caja a
				WHERE a.oficina_id IN ($oficina_id) AND a.estado_arqueo='$estado' AND a.fecha_arqueo BETWEEN '$desde' AND '$hasta'
				ORDER BY a.fecha_arqueo ASC, a.consecutivo ASC";
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], oficina=>$items[oficina],fecha_arqueo=>$items[fecha_arqueo],total_efectivo=>$items[total_efectivo],total_cheque=>$items[total_cheque],saldo_auxiliar=>$items[saldo_auxiliar],estado_arqueo=>$items[estado]);	
			$i++;
		}

		return $result;
  
  }

  public function getReporteA1($oficina_id,$desde,$hasta,$estado,$Conex){
	   	
	$select = " SELECT
					a.consecutivo consecutivo, (SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.fecha_arqueo fecha_arqueo, a.total_efectivo total_efectivo, a.total_cheque total_cheque, a.saldo_auxiliar saldo_auxiliar, CASE a.estado_arqueo consecutivo WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado
				FROM arqueo_caja a
				WHERE a.oficina_id IN ($oficina_id) AND a.estado_arqueo='$estado' AND a.fecha_arqueo BETWEEN '$desde' AND '$hasta'
				ORDER BY a.fecha_arqueo ASC, a.consecutivo ASC";

    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], oficina=>$items[oficina], fecha_arqueo=>$items[fecha_arqueo],total_efectivo=>$items[total_efectivo],total_cheque=>$items[total_cheque],saldo_auxiliar=>$items[saldo_auxiliar],estado_arqueo=>$items[estado]);	
			$i++;
		}

		return $result;
  
  }

  public function getReporteC1($oficina_id,$desde,$hasta,$estado,$Conex){
	   	
	$select = " SELECT
					a.consecutivo consecutivo, (SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.fecha_arqueo fecha_arqueo, a.total_efectivo total_efectivo, a.total_cheque total_chaque, a.saldo_auxiliar saldo_auxiliar, CASE a.estado_arqueo WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado
				FROM arqueo_caja a
				WHERE a.oficina_id IN ($oficina_id) AND a.estado_arqueo='$estado' AND a.fecha_arqueo BETWEEN '$desde' AND '$hasta'
				ORDER BY a.fecha_arqueo ASC, a.consecutivo ASC";

    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], oficina=>$items[oficina], fecha_arqueo=>$items[fecha_arqueo],total_efectivo=>$items[total_efectivo],total_cheque=>$items[total_cheque],saldo_auxiliar=>$items[saldo_auxiliar],estado_arqueo=>$items[estado]);	
			$i++;
		}

	return $result;
  
  }
  public function getReporteALL1($oficina_id,$desde,$hasta,$estado,$Conex){

	$select = " SELECT
					a.consecutivo consecutivo, (SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.fecha_arqueo fecha_arqueo, a.total_efectivo total_efectivo, a.total_cheque total_chaque, a.saldo_auxiliar saldo_auxiliar, CASE a.estado_arqueo WHEN 'A' THEN 'ANULADO' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado
				FROM arqueo_caja a
				WHERE a.oficina_id IN ($oficina_id) AND a.fecha_arqueo BETWEEN '$desde' AND '$hasta'
				ORDER BY a.fecha_arqueo ASC, a.consecutivo ASC";
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], oficina=>$items[oficina], fecha_arqueo=>$items[fecha_arqueo],total_efectivo=>$items[total_efectivo],total_cheque=>$items[total_cheque],saldo_auxiliar=>$items[saldo_auxiliar],estado_arqueo=>$items[estado]);	
			$i++;
		}

		return $result;

}
}

?>