<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TrasladosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	   $traslado_id  	 = $this -> DbgetMaxConsecutive("wms_traslado","traslado_id",$Conex,true,1);
     $this -> assignValRequest('traslado_id',$traslado_id);
     $this -> assignValRequest('fecha_registro',date('Y-m-d H:i:s'));
     $this -> DbInsertTable("wms_traslado",$Campos,$Conex,true,false);

     $result = (array(fecha_registro=>date('Y-m-d H:i:s'),traslado_id=>$traslado_id));
  if(!strlen(trim($this -> GetError())) > 0){

		return  $result;
  }
  
  }

  public function Update($Campos,$usuario_actualiza,$Conex){
   
    $this -> assignValRequest('fecha_actualiza',date('Y-m-d H:i:s'));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza);
    $this -> DbUpdateTable("wms_traslado",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("wms_traslado",$Campos,$Conex,true,false);
  }

   public function getCausalesAnulacion($Conex){

    $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
    $result = $this -> DbFetchAll($select,$Conex);		
    return $result;				
  }  

  public function cancellation($traslado_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
    $this -> Begin($Conex);

      $update = "UPDATE wms_traslado SET estado = 'I' WHERE traslado_id= $traslado_id"; 
      $this -> query($update,$Conex,true);	 	  	 
      
    $this -> Commit($Conex);
  
  } 

  public function getProducto($Conex){

  $select = "SELECT  producto_id AS value, nombre AS text FROM wms_producto_inv";

  $result = $this -> DbfetchAll($select,$Conex);

  return $result;

  }
  
//BUSQUEDA

 public function selectTraslados($traslado_id,$Conex){

  $select = "SELECT p.traslado_id,p.fecha,p.producto_id,p.usuario_id,p.fecha_registro,p.usuario_actualiza_id,p.fecha_actualiza,p.estado
          FROM wms_traslado p  WHERE p.traslado_id = $traslado_id";

  $result = $this -> DbfetchAll($select,$Conex,true);

  return $result;

  }

//// GRID ////
  public function getQueryTrasladosGrid(){
	   	   
     $Query = "SELECT p.traslado_id,p.fecha,(SELECT entrada_id FROM wms_traslado_detalle WHERE traslado_id=p.traslado_id)AS entrada_id,          (SELECT nombre FROM wms_producto_inv WHERE producto_id=p.producto_id)AS producto_id,(SELECT cantidad FROM                          wms_traslado_detalle WHERE traslado_id=p.traslado_id)AS cantidad,(SELECT serial FROM wms_traslado_detalle WHERE                    traslado_id=p.traslado_id)AS serial,
              (SELECT nombre FROM wms_ubicacion_bodega WHERE ubicacion_bodega_id=(SELECT ubicacion_bodega_id FROM wms_traslado_detalle WHERE traslado_id=p.traslado_id))AS ubicacion_bodega_id,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id  FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=p.usuario_id)AS usuario_id,p.fecha_registro,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_actualiza_id  FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=p.usuario_actualiza_id)AS usuario_actualiza_id,p.fecha_actualiza,IF(p.estado ='A','ACTIVO','ANULADO')AS estado
              FROM wms_traslado p";
     return $Query;
   }
   
}



?>