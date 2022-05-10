<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ParametrosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	$parametros_reporte_trafico_id 	 = $this -> DbgetMaxConsecutive("parametros_reporte_trafico","parametros_reporte_trafico_id",$Conex,true,1);
 	$this -> assignValRequest('parametros_reporte_trafico_id',$parametros_reporte_trafico_id);
    $this -> DbInsertTable("parametros_reporte_trafico",$Campos,$Conex,true,false);
	if(!strlen(trim($this -> GetError())) > 0){
		return $parametros_reporte_trafico_id; 
	}
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("parametros_reporte_trafico",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("parametros_reporte_trafico",$Campos,$Conex,true,false);
  }

//BUSQUEDA
  public function selectParametros($parametros_reporte_trafico_id,$Conex){
  
    $select = "SELECT p.parametros_reporte_trafico_id, p.cliente_id,
	 			(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS client FROM cliente c, tercero t WHERE c.cliente_id=p.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
	            p.minuto,
				p.horas,
				p.dias,
				p.tiempo_rojo,
				p.tiempo_amarillo,
				p.tiempo_verde,				
				p.estado
	 			FROM parametros_reporte_trafico p WHERE p.parametros_reporte_trafico_id=$parametros_reporte_trafico_id";
	
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }


//LISTA MENU
  public function GetMinuto($Conex){
	$opciones = array ( 0 => array ( 'value' => 'CQ', 'text' => 'CADA QUINCE MINUTOS' ), 1 => array ( 'value' => 'CT', 'text' => 'CADA TREINTA MINUTOS' ), 2 => array ( 'value' => 'UV', 'text' => 'UNA VEZ CADA HORA' ) );
	return  $opciones;
  }
  
  public function GetHoras($Conex){
	$opciones = array ( 0 => array ( 'value' => 'CH', 'text' => 'CADA HORA' ), 1 => array ( 'value' => 'C2', 'text' => 'CADA DOS HORAS' ), 2 => array ( 'value' => 'C3', 'text' => 'CADA TRES HORAS' ), 3 => array ( 'value' => 'C4', 'text' => 'CADA CUATRO HORAS' ), 4 => array ( 'value' => 'C8', 'text' => 'CADA OCHO HORAS' ) );
	return  $opciones;
  }
  
  public function GetDias($Conex){
	$opciones = array ( 0 => array ( 'value' => 'TD', 'text' => 'TODOS LOS DIAS' ), 1 => array ( 'value' => 'LV', 'text' => 'LUNES A VIERNES' ), 2 => array ( 'value' => 'LS', 'text' => 'LUNES A SABADO' ) );
	return  $opciones;
  }
  
  public function GetEstado($Conex){
	$opciones = array ( 0 => array ( 'value' => 'A', 'text' => 'ACTIVA' ), 1 => array ( 'value' => 'I', 'text' => 'INACTIVA' ) );
	return  $opciones;
  }

  public function getDataCliente($cliente_id,$Conex){

    $select = "SELECT p.parametros_reporte_trafico_id, p.cliente_id,
	 			(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS client FROM cliente c, tercero t WHERE c.cliente_id=p.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
	            p.minuto,
				p.horas,
				p.dias,
				p.tiempo_rojo,
				p.tiempo_amarillo,
				p.tiempo_verde,				
				p.estado
	 			FROM parametros_reporte_trafico p WHERE p.cliente_id=$cliente_id";
     $result = $this -> DbFetchAll($select,$Conex,false);
     return $result;

  }

 

//BUSQUEDA


//// GRID ////
  public function getQueryParametrosGrid(){
	   	   
     $Query = "SELECT 
	 			(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS client FROM cliente c, tercero t WHERE c.cliente_id=p.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
	            CASE p.minuto WHEN 'CQ' THEN 'CADA QUINCE MINUTOS' WHEN 'CT' THEN 'CADA TREINTA MINUTOS' WHEN 'UV' THEN 'UNA VEZ CADA HORA' ELSE 'NO APLICA' END AS minuto,
				CASE p.horas WHEN 'CH' THEN 'CADA HORA' WHEN 'C2' THEN 'CADA DOS HORAS' WHEN 'C3' THEN 'CADA TRES HORAS' WHEN 'C4' THEN 'CADA CUATRO HORAS' WHEN 'C8' THEN 'CADA OCHO HORAS'  ELSE 'NO APLICA' END AS horas,
				CASE p.dias WHEN 'TD' THEN 'TODOS LOS DIAS' WHEN 'LV' THEN 'LUNES A VIERNES' WHEN 'LS' THEN 'LUNES A SABADO' ELSE 'NO APLICA' END AS dias,
				p.tiempo_rojo,
				p.tiempo_amarillo,
				p.tiempo_verde,				
				IF(p.estado='A','ACTIVO','INACTIVA') AS estado
	 			FROM parametros_reporte_trafico p ";
   
     return $Query;
   }
   
}



?>