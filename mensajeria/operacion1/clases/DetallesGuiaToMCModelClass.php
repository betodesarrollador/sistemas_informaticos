<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesGuiaToMCModel extends Db{

  private $Permisos;
  
  public function Save($Campos,$Conex){
  
   $this -> Begin($Conex);
  
	$manifiesto_id = $this -> requestDataForQuery('manifiesto_id','integer');
	$guia_id     = $this -> requestDataForQuery('guia_id','integer');

    $insert = "INSERT INTO detalle_despacho (manifiesto_id,guia_id) VALUES ($manifiesto_id,$guia_id)";	
    $this -> query($insert,$Conex);
	
	$update = "UPDATE guia SET estado_mensajeria_id = 2 WHERE guia_id = $guia_id";
    $this -> query($update,$Conex,true);	
	
	$this -> Commit($Conex);
	
	return $guia_id;
  }  
  
public function getFiltro($oficina_id,$Conex){ 
	   	
    $select = "SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia,r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino,r.destinatario AS destinatario,r.fecha_guia AS fecha 
			  FROM guia r WHERE r.oficina_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 AND r.desbloqueada = 0
	 	      UNION 
			  SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia, r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino, r.destinatario AS destinatario, r.fecha_guia AS fecha 
			  FROM guia r WHERE r.desbloqueada = 1 AND r.oficina_desbloquea_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 ORDER BY destino";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  foreach($results as $items){
		  
		  $result[$i]=array(guia=>$items[guia],remitente=>$items[remitente],link=>$items[link],destino=>$items[destino],
		  destinatario=>$items[destinatario],fecha=>$items[fecha]);	
		  $i++;
		  }
		  
		  return $result;
  } 
  
  public function getFiltro1($destino_id,$oficina_id,$Conex){ 
	   	
    $select = "SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia,r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino,r.destinatario AS destinatario,r.fecha_guia AS fecha 
			  FROM guia r WHERE r.oficina_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 AND r.desbloqueada = 0 AND r.destino_id = $destino_id 
	 	      UNION 
			  SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia, r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino, r.destinatario AS destinatario, r.fecha_guia AS fecha 
			  FROM guia r WHERE r.desbloqueada = 1 AND r.oficina_desbloquea_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 AND r.destino_id = $destino_id";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  foreach($results as $items){
		  
		  $result[$i]=array(guia=>$items[guia],remitente=>$items[remitente],link=>$items[link],destino=>$items[destino],
		  destinatario=>$items[destinatario],fecha=>$items[fecha]);	
		  $i++;
		  }
		  
		  return $result;
  }   
  
  public function getFiltro2($fecha,$oficina_id,$Conex){ 
	   	
    $select = "SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia,r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino,r.destinatario AS destinatario,r.fecha_guia AS fecha 
			  FROM guia r WHERE r.oficina_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 AND r.fecha_guia = '$fecha' 
	 	      UNION 
			  SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia, r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino, r.destinatario AS destinatario, r.fecha_guia AS fecha 
			  FROM guia r WHERE r.desbloqueada = 1 AND r.oficina_desbloquea_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 AND r.fecha_guia = '$fecha' ORDER BY destino";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  foreach($results as $items){
		  
		  $result[$i]=array(guia=>$items[guia],remitente=>$items[remitente],link=>$items[link],destino=>$items[destino],
		  destinatario=>$items[destinatario],fecha=>$items[fecha]);	
		  $i++;
		  }
		  
		  return $result;
  }   
  
  public function getFiltro3($departamento_id,$oficina_id,$Conex){ 
	   	
    $select = "SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia,r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubi_ubicacion_id = $departamento_id 
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino,
			  r.destinatario AS destinatario,r.fecha_guia AS fecha 
			  FROM guia r WHERE r.oficina_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 AND r.destino_id = $departamento_id
	 	      UNION 
			  SELECT CONCAT('<input type=\"checkbox\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia, r.remitente AS remitente,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubi_ubicacion_id = $departamento_id 
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino, 
			  r.destinatario AS destinatario, r.fecha_guia AS fecha 
			  FROM guia r WHERE r.desbloqueada = 1 AND r.oficina_desbloquea_id = $oficina_id AND r.estado_mensajeria_id = 1 AND r.planilla = 1 AND r.destino_id = $departamento_id";	
		  
		  //echo $select;
		  
		  $results = $this -> DbFetchAll($select,$Conex);
		  
		  $i=0;
		  foreach($results as $items){
		  
		  $result[$i]=array(guia=>$items[guia],remitente=>$items[remitente],link=>$items[link],destino=>$items[destino],
		  destinatario=>$items[destinatario],fecha=>$items[fecha]);	
		  $i++;
		  }
		  
		  return $result;
  }  
 
}

?>