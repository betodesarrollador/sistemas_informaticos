<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteAprobacionDespachosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function getOficinas($empresa_id,$oficina_id,$Conex){  
  
   $select = "SELECT oficina_id AS value, nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id";
   $result = $this -> DbFetchAll($select,$Conex);	  
   return $result;	  	    
   
  }  
  
  public function selectInformacionRemesas($empresa_id,$oficina_id,$Conex){
  
    $fecha_inicio       = $this -> requestData('fecha_inicio');
    $fecha_final        = $this -> requestData('fecha_final');
    $opciones_conductor = $this -> requestData('opciones_conductor');
    $conductor_id       = $this -> requestData('conductor_id');
    $opciones_placa     = $this -> requestData('opciones_placa');
    $placa_id           = $this -> requestData('placa_id');		
    $opciones_oficinas  = $this -> requestData('opciones_oficinas');	
    $oficina_id         = $this -> requestData('oficina_id');
    $opciones_estado    = $this -> requestData('opciones_estado');	
    $estado             = $this -> requestData('estado');
	
	if($opciones_conductor == 'U'){
	 $condicionConductor = " AND m.conductor_id IN ($conductor_id) ";
	}else{
	    $condicionConductor = null;
	  }	  
	  
	if($opciones_placa == 'U'){
	 $condicionPlaca = " AND m.placa_id IN ($placa_id) ";
	}else{
	    $condicionPlaca = null;
	  }	  	  

	$condicionOficinas = " AND m.oficina_id IN ($oficina_id) ";	  

	$estado            = str_replace(',',"','",$estado);
	$condicionEstado   = " AND m.estado IN ('$estado')";
	
    $select = "SELECT m.manifiesto_id,
		(SELECT nombre FROM oficina WHERE oficina_id=m.oficina_id) AS oficina, 
		m.placa,m.manifiesto,IF(m.propio =1,'SI','NO') AS propio,m.estado,m.fecha_mc AS fecha_planilla,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=m.origen_id) AS origen,
		(SELECT nombre FROM ubicacion WHERE ubicacion_id=m.destino_id) AS destino,
		IF(m.reportado_ministerio2 =1,'SI','NO') AS reportado_ministerio2,m.aprobacion_ministerio2,
		IF(m.reportado_ministerio3 =1,'SI' ,'NO') AS reportado_ministerio3,m.aprobacion_ministerio3,
		IF(m.estado='A', IF(anulado_ministerio=1,'SI','NO') ,'N/A') AS anulado_ministerio,
		IF(m.estado='A', IF(anulado_ministerio=1,m.anulacion_ministerio,' ') ,'N/A') AS anulacion_ministerio
		FROM manifiesto m 
		WHERE m.fecha_mc BETWEEN '$fecha_inicio' AND '$fecha_final' $condicionPlaca $condicionConductor $condicionOficinas $condicionEstado 
		 ORDER BY m.fecha_mc ASC";	 
	 	 
     $data      = $this -> DbFetchAll($select,$Conex,true);	  
	  
	 		 
	 $arrayResult = array();
	 
	 if(is_array($data) && is_array($data2)){
	   $arrayResult = array_merge($data,$data2);
	 }else if(is_array($data) && !is_array($data2)){
	     $arrayResult = $data;	 
	   }else if(!is_array($data) && is_array($data2)){
	       $arrayResult = $data2;	 	   
	     }		 
			 
	 return  array(data => $arrayResult, impuestos => $impuestos, descuentos => $descuentos);
  
  }        
   
}

?>