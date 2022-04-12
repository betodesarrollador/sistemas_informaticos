<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reportesContratosModel extends Db{

  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  


   public function GetSi_Pro($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
    public function GetSi_Pro2($Conex){
	$opciones=array(0=>array('value'=>'1','text'=>'UNO'),1=>array('value'=>'ALL','text'=>'TODOS'));
	return $opciones;
   }
   
  public function getReporteMC1($desde,$hasta,$Conex){ 	  
	  
		
	if($desde!='NULL' ){
		$consul_desde = " AND c.fecha_inicio >= '$desde' ";
	}else{
		$consul_desde = "";
	}

	if($hasta!='NULL' ){
		$consul_hasta = " AND c.fecha_inicio >= '$hasta' ";
	}else{
		$consul_hasta = "";
	}
 
	    $select = "SELECT
				 c.numero_contrato,
				 c.fecha_inicio,
				 c.fecha_terminacion,
				 c.fecha_terminacion_real,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion, 
				c.sueldo_base,
				c.subsidio_transporte,
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE c.contrato_id>=0 $consul_desde $consul_hasta ORDER BY c.numero_contrato";	  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  } 
  
	public function getReporteMC2($empleado_id,$desde,$hasta,$Conex){ 	
		
			
	if($desde!='NULL' ){
		$consul_desde = " AND c.fecha_inicio >= '$desde' ";
	}else{
		$consul_desde = "";
	}

	if($hasta!='NULL' ){
		$consul_hasta = " AND c.fecha_inicio >= '$hasta' ";
	}else{
		$consul_hasta = "";
	}
 
	    $select = "SELECT
				 c.numero_contrato,
				 c.fecha_inicio,
				 c.fecha_terminacion,
				 c.fecha_terminacion_real,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion,
				c.sueldo_base,
				c.subsidio_transporte,
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE c.empleado_id IN ($empleado_id) $consul_desde $consul_hasta  ORDER BY c.numero_contrato";	  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  } 

	public function getReporteMC3($cargo_id,$desde,$hasta,$Conex){ 	  
		
			
	if($desde!='NULL' ){
		$consul_desde = " AND c.fecha_inicio >= '$desde' ";
	}else{
		$consul_desde = "";
	}

	if($hasta!='NULL' ){
		$consul_hasta = " AND c.fecha_inicio >= '$hasta' ";
	}else{
		$consul_hasta = "";
	}
 
	    $select = "SELECT 
				 c.numero_contrato,
				 c.fecha_inicio,
				 c.fecha_terminacion,
				 c.fecha_terminacion_real,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion,
				c.sueldo_base,
				c.subsidio_transporte,
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE  c.cargo_id IN ($cargo_id) $consul_desde $consul_hasta  ORDER BY c.numero_contrato";	  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  } 

public function getReporteMC4($empleado_id,$cargo_id,$desde,$hasta,$Conex){ 	 
	
		
	if($desde!='NULL' ){
		$consul_desde = " AND c.fecha_inicio >= '$desde' ";
	}else{
		$consul_desde = "";
	}

	if($hasta!='NULL' ){
		$consul_hasta = " AND c.fecha_inicio >= '$hasta' ";
	}else{
		$consul_hasta = "";
	}
 
	    $select = "SELECT
				 c.numero_contrato,
				 c.fecha_inicio,
				 c.fecha_terminacion,
				 c.fecha_terminacion_real,
				(SELECT CONCAT_WS(' ', t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, empleado e
      			 WHERE t.tercero_id=e.tercero_id AND c.empleado_id=e.empleado_id)AS empleado,
				(SELECT nombre FROM tipo_contrato WHERE tipo_contrato_id=c.tipo_contrato_id)AS tipo_contrato,
				(SELECT nombre_cargo FROM cargo WHERE cargo_id=c.cargo_id)AS cargo,
				(SELECT nombre FROM motivo_terminacion WHERE motivo_terminacion_id=c.motivo_terminacion_id)AS motivo_terminacion,
				c.sueldo_base,
				c.subsidio_transporte,
				(SELECT nombre FROM centro_de_costo co WHERE co.centro_de_costo_id=c.centro_de_costo_id)AS centro_de_costo,
				CASE periodicidad WHEN 'H' THEN 'HORAS' WHEN 'D' THEN 'DIAS' WHEN 'S' THEN 'SEMANAL' WHEN 'Q' THEN 'QUINCENAL' ELSE 'MENSUAL' END AS periodicidad,
				(SELECT nombre FROM causal_despido ca WHERE ca.causal_despido_id=c.causal_despido_id)AS causal_despido,
				CASE estado WHEN 'A' THEN 'ACTIVO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FINALIZADO' ELSE 'ANULADA' END AS estado
				FROM contrato c WHERE c.empleado_id IN ($empleado_id) AND c.cargo_id IN ($cargo_id) $consul_desde $consul_hasta  ORDER BY c.numero_contrato";	  
		  
		  //echo $select;		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  } 

}

?>