<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AlistamientoModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
  $this -> Permisos = new PermisosForm();
  $this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
     $alistamiento_salida_id  	 = $this -> DbgetMaxConsecutive("wms_alistamiento_salida","alistamiento_salida_id",$Conex,true,1);
     $this -> assignValRequest('alistamiento_salida_id',$alistamiento_salida_id);
     $this -> assignValRequest('fecha_registro',date('Y-m-d H:i:s'));
     $this -> DbInsertTable("wms_alistamiento_salida",$Campos,$Conex,true,false);

     $result = (array(fecha_registro=>date('Y-m-d H:i:s'),alistamiento_salida_id=>$alistamiento_salida_id));
  if(!strlen(trim($this -> GetError())) > 0){

    return  $result;
  }
  
  }

  public function Update($Campos,$usuario_actualiza,$Conex){
   
    $this -> assignValRequest('fecha_actualiza',date('Y-m-d H:i:s'));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza);
    $this -> DbUpdateTable("wms_alistamiento_salida",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
    $this -> DbDeleteTable("wms_alistamiento_salida",$Campos,$Conex,true,false);
  }

  public function getMuelle($Conex){

  $select = "SELECT  muelle_id AS value, nombre AS text FROM wms_muelle";

  $result = $this -> DbfetchAll($select,$Conex);

  return $result;

  }

  public function getCausalesAnulacion($Conex){

    $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
    $result = $this -> DbFetchAll($select,$Conex);		
    return $result;				
  }  

  public function cancellation($alistamiento_salida_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
    $this -> Begin($Conex);

      $update = "UPDATE wms_alistamiento_salida SET estado = 'I' WHERE alistamiento_salida_id= $alistamiento_salida_id"; 
      $this -> query($update,$Conex,true);	 	  	 
      
    $this -> Commit($Conex);
  
  } 
  
//BUSQUEDA

 public function selectAlistamiento($alistamiento_salida_id,$Conex){

  $select = "SELECT p.alistamiento_salida_id,p.fecha,p.muelle_id,p.turno,p.usuario_id,p.fecha_registro,p.usuario_actualiza_id,p.fecha_actualiza,p.estado
          FROM wms_alistamiento_salida p  WHERE p.alistamiento_salida_id = $alistamiento_salida_id";

  $result = $this -> DbfetchAll($select,$Conex,true);

  return $result;

  }

//// GRID ////
  public function getQueryAlistamientoGrid(){
          
     $Query = "SELECT p.alistamiento_salida_id,p.fecha,p.turno,(SELECT nombre FROM wms_muelle WHERE muelle_id=p.muelle_id)AS muelle_id,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id  FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=p.usuario_id)AS usuario_id,p.fecha_registro,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_actualiza_id  FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=p.usuario_actualiza_id)AS usuario_actualiza_id,p.fecha_actualiza,(CASE WHEN p.estado='A' THEN 'ALISTAMIENTO' WHEN p.estado='I' THEN 'ANULADO' WHEN p.estado='E' THEN 'ENTURNADO' WHEN p.estado='D' THEN 'DESPACHADO' END)AS estado
          FROM wms_alistamiento_salida p";
     return $Query;
   }
   
}



?>