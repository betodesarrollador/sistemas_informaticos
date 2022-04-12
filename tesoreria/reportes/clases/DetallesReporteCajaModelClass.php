<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesReporteCajaModel extends Db{

  private $Permisos;
  
  public function getReporteE1($oficina_id,$desde,$hasta,$estado,$Conex){
	   	
	$select = " SELECT
					a.legalizacion_caja_id consecutivo,(SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.descripcion descripcion, a.fecha_legalizacion fecha, a.elaboro elaboro, a.total_costos_legalizacion_caja costo, CASE a.estado_legalizacion WHEN 'A' THEN 'Anulado' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado 
				FROM legalizacion_caja a
				WHERE oficina_id IN ($oficina_id) AND estado_legalizacion='$estado' AND fecha_legalizacion BETWEEN '$desde' AND '$hasta'
				ORDER BY fecha ASC, consecutivo ASC";
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], fecha=>$items[fecha], descripcion=>$items[descripcion], elaboro=>$items[elaboro], oficina=>$items[oficina], costo=>$items[costo], estado=>$items[estado]);	
			$i++;
		}

		return $result;
  
  }

  public function getReporteA1($oficina_id,$desde,$hasta,$estado,$Conex){

	$select = " SELECT
					a.legalizacion_caja_id consecutivo,(SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.descripcion descripcion, a.fecha_legalizacion fecha, a.elaboro elaboro, a.total_costos_legalizacion_caja costo, CASE a.estado_legalizacion WHEN 'A' THEN 'Anulado' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado 
				FROM legalizacion_caja a
				WHERE oficina_id IN ($oficina_id) AND estado_legalizacion='$estado' AND fecha_legalizacion BETWEEN '$desde' AND '$hasta'
				ORDER BY fecha ASC, consecutivo ASC";
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], fecha=>$items[fecha], descripcion=>$items[descripcion], elaboro=>$items[elaboro], oficina=>$items[oficina], costo=>$items[costo], estado=>$items[estado]);	
			$i++;
		}

		return $result;
  
  }

  public function getReporteC1($oficina_id,$desde,$hasta,$estado,$Conex){

	$select = " SELECT
					a.legalizacion_caja_id consecutivo,(SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.descripcion descripcion, a.fecha_legalizacion fecha, a.elaboro elaboro, a.total_costos_legalizacion_caja costo, CASE a.estado_legalizacion WHEN 'A' THEN 'Anulado' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado 
				FROM legalizacion_caja a
				WHERE oficina_id IN ($oficina_id) AND estado_legalizacion='$estado' AND fecha_legalizacion BETWEEN '$desde' AND '$hasta'
				ORDER BY fecha ASC, consecutivo ASC";
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], fecha=>$items[fecha], descripcion=>$items[descripcion], elaboro=>$items[elaboro], oficina=>$items[oficina], costo=>$items[costo], estado=>$items[estado]);	
			$i++;
		}

		return $result;
  
  }
  public function getReporteALL1($oficina_id,$desde,$hasta,$estado,$Conex){

	$select = " SELECT
					a.legalizacion_caja_id consecutivo,(SELECT o.nombre FROM oficina o WHERE o.oficina_id=a.oficina_id) AS oficina, a.descripcion descripcion, a.fecha_legalizacion fecha, a.elaboro elaboro, a.total_costos_legalizacion_caja costo, CASE a.estado_legalizacion WHEN 'A' THEN 'Anulado' WHEN 'C' THEN 'CERRADO' WHEN 'E' THEN 'EDICION' END as estado 
				FROM legalizacion_caja a
				WHERE oficina_id IN ($oficina_id) AND fecha_legalizacion BETWEEN '$desde' AND '$hasta'
				ORDER BY fecha ASC, consecutivo ASC";
    	$results = $this -> DbFetchAll($select,$Conex);
		$i=0;
		
		foreach($results as $items){
			$result[$i]=array(consecutivo=>$items[consecutivo], fecha=>$items[fecha], descripcion=>$items[descripcion], elaboro=>$items[elaboro], oficina=>$items[oficina], costo=>$items[costo], estado=>$items[estado]);	
			$i++;
		}

		return $result;
}
}

?>