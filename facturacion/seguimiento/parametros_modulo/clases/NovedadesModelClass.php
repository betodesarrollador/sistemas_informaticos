<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class NovedadesModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	$novedad_id 	 = $this -> DbgetMaxConsecutive("novedad_seguimiento","novedad_id",$Conex,true,1);
 	$this -> assignValRequest('novedad_id',$novedad_id);
    $this -> DbInsertTable("novedad_seguimiento",$Campos,$Conex,true,false);
	if(!strlen(trim($this -> GetError())) > 0){
		return $novedad_id; 
	}
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("novedad_seguimiento",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("novedad_seguimiento",$Campos,$Conex,true,false);
  }


//LISTA MENU
  public function GetAlertasPanico($Conex){
	return $this  -> DbFetchAll("SELECT alerta_id AS value,CONCAT(alerta_panico,'-',color_alerta_panico) AS text FROM alerta_panico ORDER BY alerta_panico",$Conex,$ErrDb = false);
  }
  
  public function GetDetiene($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'SI' ), 1 => array ( 'value' => '0', 'text' => 'NO' ) );
	return  $opciones;
  }
  
  public function GetReporte($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'SI' ), 1 => array ( 'value' => '0', 'text' => 'NO' ) );
	return  $opciones;
  }

  public function GetReporteCLiente($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'AUTOMATICAMENTE' ), 1 => array ( 'value' => '2', 'text' => 'CONSOLIDADO' ), 2 => array ( 'value' => '0', 'text' => 'NO' ) );
	return  $opciones;
  }

  public function GetEstadoNovedad($Conex){
	$opciones = array ( 0 => array ( 'value' => '1', 'text' => 'ACTIVA' ), 1 => array ( 'value' => '0', 'text' => 'INACTIVA' ) );
	return  $opciones;
  }
  
 

//BUSQUEDA


//// GRID ////
  public function getQueryNovedadesGrid(){
	   	   
     $Query = "SELECT CONCAT('<div style=\"background:',ap.color_alerta_panico,'\">&nbsp;</div>') as color,
	            ns.novedad,ap.alerta_panico,
				IF(ns.finaliza_recorrido=1,'SI','NO') AS finaliza_recorrido,
				IF(ns.detiene_recorrido_novedad=1,'SI','NO') AS detiene_recorrido_novedad,
				tiempo_detenido_novedad,
	 			CASE ns.reporte_cliente WHEN '1' THEN 'AUTOMATICAMENTE' WHEN '2' THEN 'CONSOLIDADO' ELSE 'NO' END AS reporte_cliente,
	 			IF(ns.reporte_interno=1,'SI','NO') AS reporte_interno,
				IF(ns.finaliza_remesa=1,'SI','NO') AS finaliza_remesa,
				IF(ns.requiere_remesa=1,'SI','NO') AS requiere_remesa,
				IF(ns.estado_novedad=1,'ACTIVA','INACTIVA') AS estado_novedad
	 			FROM novedad_seguimiento ns LEFT JOIN alerta_panico ap ON ns.alerta_id=ap.alerta_id";
   
     return $Query;
   }
   
}



?>