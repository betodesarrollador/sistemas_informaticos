<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class RutasModel extends Db{

  
  public function Save($Conex){
  
    $this -> Begin($Conex);
   
		$origen_id	  = $this -> requestDataForQuery('origen_id','integer');
		$destino_id	  = $this -> requestDataForQuery('destino_id','integer');
		$ruta	      = $this -> requestDataForQuery('ruta','text');
		$pasador_vial = $this -> requestDataForQuery('pasador_vial','text');
		$distancia 	  = $this -> requestDataForQuery('distancia','numeric');
		$estado_ruta  = $this -> requestDataForQuery('estado_ruta','integer');
		
		$ruta_id 	 = $this -> DbgetMaxConsecutive("ruta","ruta_id",$Conex,true,1);			
		
		$insert = "INSERT INTO ruta(ruta_id,origen_id,destino_id,ruta,pasador_vial,distancia,estado_ruta) 
				   VALUES ($ruta_id,$origen_id,$destino_id,$ruta,$pasador_vial,$distancia,$estado_ruta)";
	
		$this -> query($insert,$Conex,true);
		
		$detalle_ruta_id = $this -> DbgetMaxConsecutive("detalle_ruta","detalle_ruta_id",$Conex,true,1);
		
		$insert = "INSERT INTO detalle_ruta (detalle_ruta_id,ruta_id,ubicacion_id,orden_det_ruta) VALUES 
		           ($detalle_ruta_id,$ruta_id,$origen_id,1)";
				   
		$this -> query($insert,$Conex,true);
		
		$detalle_ruta_id = $this -> DbgetMaxConsecutive("detalle_ruta","detalle_ruta_id",$Conex,true,1);		
		
		$insert = "INSERT INTO detalle_ruta (detalle_ruta_id,ruta_id,ubicacion_id,orden_det_ruta) VALUES 
		           ($detalle_ruta_id,$ruta_id,$destino_id,2)";
				   
		$this -> query($insert,$Conex,true);						   
	 
    $this -> Commit($Conex);
	 
	return $ruta_id;
	
  }

  public function Update($Campos,$Conex){

	$ruta_id	  = $this -> requestDataForQuery('ruta_id','integer');
	$origen_id	  = $this -> requestDataForQuery('origen_id','integer');
	$destino_id	  = $this -> requestDataForQuery('destino_id','integer');
	$ruta	      = $this -> requestDataForQuery('ruta','text');
	$pasador_vial = $this -> requestDataForQuery('pasador_vial','text');
	$distancia 	  = $this -> requestDataForQuery('distancia','numeric');
	$estado_ruta  = $this -> requestDataForQuery('estado_ruta','numeric');
	
	$update = "UPDATE ruta SET 
				origen_id=$origen_id,
				destino_id=$destino_id,
				ruta=$ruta,
				pasador_vial=$pasador_vial,
				distancia=$distancia,
				estado_ruta=$estado_ruta 
			WHERE ruta_id=$ruta_id";

     $this -> query($update,$Conex,true);

  }

  public function Delete($Campos,$Conex){
	  
    $ruta_id = $this -> requestDataForQuery('ruta_id','integer');
	 
 	$this -> Begin($Conex);

	  $delete = "DELETE FROM detalle_ruta WHERE ruta_id =  $ruta_id";	  
	  $this -> query($delete,$Conex,true);
	
 	  $this -> DbDeleteTable("ruta",$Campos,$Conex,true,false);
	
	$this -> Commit($Conex);
	
  }
  
  public function getDataMap($Conex){
  
	$ruta_id = $this -> requestData('ruta_id');
	
/*	$select = "SELECT 
				IF(punto_referencia_id >0,(SELECT x FROM punto_referencia WHERE punto_referencia_id=dt.punto_referencia_id),u.x) AS lat, 
				IF(punto_referencia_id >0,(SELECT y FROM punto_referencia WHERE punto_referencia_id=dt.punto_referencia_id),u.y) AS lon, 
				IF(punto_referencia_id >0,(SELECT nombre FROM punto_referencia WHERE punto_referencia_id=dt.punto_referencia_id),u.nombre) AS nom 
				FROM detalle_ruta dt
				WHERE dt.ruta_id=$ruta_id
				AND u.ubicacion_id=dt.ubicacion_id
				AND u.x IS NOT NULL
				AND u.y IS NOT NULL
				ORDER BY dt.orden_det_ruta";*/
				
    $select = "SELECT pr.x AS lat, pr.y AS lon,pr.nombre AS nom FROM detalle_ruta dt, punto_referencia pr WHERE 
	           dt.ruta_id = $ruta_id AND dt.punto_referencia_id = pr.punto_referencia_id AND
			   pr.x is not null AND pr.y is not null UNION ALL SELECT pr.x AS lat, pr.y AS lon,pr.nombre AS nom FROM detalle_ruta 
			   dt, ubicacion pr WHERE dt.ruta_id = $ruta_id AND NOT dt.punto_referencia_id > 0 AND dt.ubicacion_id = 
			   pr.ubicacion_id AND pr.x is not null AND pr.y is not null";				
				
			
	return $this -> DbFetchAll($select,$Conex,true);  
	  
  }


//LISTA MENU
  public function GetEstadoRuta($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'ACTIVA' ), 1 => array ( 'value' => '0', 'text' => 'INACTIVA' ) );
	return  $opciones;
  }
 

//BUSQUEDA
  public function selectRutas($rutaId,$Conex){
  
    $select = "SELECT r.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.destino_id) AS destino,
	(SELECT COUNT(*) cantidad FROM detalle_ruta dr, punto_referencia pr WHERE dr.ruta_id = r.ruta_id AND pr.punto_referencia_id=dr.punto_referencia_id AND pr.tipo_punto!=3 ) AS cantidad
	FROM ruta r WHERE ruta_id = $rutaId";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
  }


//// GRID ////
  public function getQueryRutasGrid(){
	   	   
     $Query = "SELECT r.ruta,
	 			(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
				r.pasador_vial, 
				r.distancia,
				(SELECT COUNT(*) as movimientos FROM detalle_ruta WHERE ruta_id=r.ruta_id) AS puntos,
				IF(r.estado_ruta=1,'ACTIVA','INACTIVA') AS estado_ruta
				FROM ruta r";
   
     return $Query;
   }
   
}



?>