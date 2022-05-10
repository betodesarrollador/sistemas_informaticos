<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class reporteRemesasModel extends Db{

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
  
    $fecha_inicio      = $this -> requestData('fecha_inicio');
    $fecha_final       = $this -> requestData('fecha_final');
    $opciones_cliente  = $this -> requestData('opciones_cliente');
    $cliente_id        = $this -> requestData('cliente_id');
    $opciones_oficinas = $this -> requestData('opciones_oficinas');	
    $oficina_id        = $this -> requestData('oficina_id');
    $opciones_estado   = $this -> requestData('opciones_estado');	
    $estado            = $this -> requestData('estado');
	
	if($opciones_cliente == 'U'){
	 $condicionCliente = " AND r.cliente_id IN ($cliente_id) ";
	}else{
	    $condicionCliente = null;
	  }
	  
	if($opciones_oficinas == 'U'){
	 $condicionOficinas = " AND r.oficina_id IN ($oficina_id) ";
	}else{
	    $condicionOficinas = " AND r.oficina_id IN ($oficina_id) ";
	  }
	  
	if($opciones_estado == 'U'){
	 $condicionEstado = " AND r.estado IN ('$estado') ";
	}else{
	 
	   $estado          = str_replace(',',"','",$estado);
	   $condicionEstado = " AND r.estado IN ('$estado')";
	 }
	
  
     $select = "SELECT r.numero_remesa,r.fecha_remesa,'MC' AS tipo,m.manifiesto,(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) FROM cliente c, tercero t 
	 WHERE c.cliente_id=r.cliente_id AND c.tercero_id=t.tercero_id)  AS cliente,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS 
	 origen,(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,(SELECT codigo FROM producto WHERE producto_id=r.producto_id) 
	 AS codigo,r.descripcion_producto,r.peso,r.cantidad,r.valor, r.estado FROM remesa r, manifiesto m, detalle_despacho d WHERE r.remesa_id 
	 = d.remesa_id AND d.manifiesto_id = m.manifiesto_id AND r.fecha_remesa BETWEEN '$fecha_inicio' AND '$fecha_final' $condicionCliente 
	 $condicionOficinas $condicionEstado ";	 
	 
     $result = $this -> DbFetchAll($select,$Conex,true);	 
	 	 
	 return  $result;
  
  }  
  
    
   
}


?>