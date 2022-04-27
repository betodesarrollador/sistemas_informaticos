<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LegalizarModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  		
  public function Save($Campos,$Conex,$usuario_id){

    $this -> assignValRequest('fecha_registro',date('Y-m-d : h:i:s'));
    $this -> assignValRequest('usuario_id',$usuario_id);
	 
    $this -> DbInsertTable("wms_recepcion",$Campos,$Conex,true,false);	

    if($this -> GetNumError() > 0){
			   return false;
		}else{
          return $recepcion_id = $this -> DbgetMaxConsecutive("wms_recepcion","recepcion_id",$Conex,false,0);
    }
  }
	
  public function Update($Campos,$Conex, $usuario_actualiza_id){		

    $this -> assignValRequest('fecha_actualiza',date('Y-m-d : h:i:s' ));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza_id);

    $this -> DbUpdateTable("wms_recepcion",$Campos,$Conex,true,false);	
    if($this -> GetNumError() > 0){
			   return false;
		}else{
          return $recepcion_id = $this -> DbgetMaxConsecutive("wms_recepcion","recepcion_id",$Conex,false,0);
    }
  }


   public function Cancellation($usuario_anula_id,$Campos,$Conex){		

    $recepcion_id = $this -> requestDataForQuery('recepcion_id','integer');
    $fecha_anulacion = $this -> requestDataForQuery('fecha_anulacion','date');
    $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');

        $update="UPDATE wms_enturnamiento SET estado = 'D' WHERE enturnamiento_id =(SELECT enturnamiento_id FROM wms_recepcion WHERE recepcion_id=$recepcion_id AND estado != 'A')";
        $this -> query($update,$Conex,true);

        $update="UPDATE wms_recepcion SET estado = 'A', fecha_anulacion = $fecha_anulacion, observacion_anulacion = $observacion_anulacion, usuario_anula_id= $usuario_anula_id
                 WHERE recepcion_id=$recepcion_id";
        $this -> query($update,$Conex,true);
      			
	 return $recepcion_id;
	
  }
	
  public function Delete($recepcion_id,$Campos,$Conex){
    
    $select="SELECT * FROM wms_recepcion_detalle WHERE recepcion_id = $recepcion_id";
    $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

    if($result>0){
       $delete="DELETE FROM wms_recepcion_detalle WHERE recepcion_id = $recepcion_id";
       $this -> query($delete,$Conex,true);
    }
    $this -> DbDeleteTable("wms_recepcion",$Campos,$Conex,true,false);
    return true;
  }				 	
   
   public function selectLegalizar($Conex){
      
      $recepcion_id = $this -> requestDataForQuery('recepcion_id','integer');
      $select         = "SELECT r.*,
                        (SELECT v.placa FROM wms_vehiculo v,wms_enturnamiento e WHERE v.wms_vehiculo_id=e.wms_vehiculo_id AND e.enturnamiento_id=r.enturnamiento_id) AS placa 
	                       FROM wms_recepcion r WHERE r.recepcion_id = $recepcion_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
      return $result;
      
   }

   public function getQueryLegalizarGrid(){
         
     $Query = "SELECT r.recepcion_id,
               r.fecha,
               IF(r.estado='P','PENDIENTE',IF(r.estado ='L','LEGALIZADA',IF(r.estado = 'I','INGRESADA','ANULADA')))AS estado, 
              (SELECT v.placa FROM wms_vehiculo v,wms_enturnamiento e WHERE v.wms_vehiculo_id=e.wms_vehiculo_id AND e.enturnamiento_id=r.enturnamiento_id) AS placa,
		        	(SELECT CONCAT_WS( ' ' ,t.primer_nombre,t.primer_apellido) FROM tercero t WHERE t.tercero_id=(SELECT u.tercero_id FROM usuario u WHERE u.usuario_id=r.usuario_id) ) AS usuario_registra,
               r.fecha_registro,
              (SELECT CONCAT_WS(' ' ,t.primer_nombre,t.primer_apellido) FROM tercero t WHERE t.tercero_id=(SELECT u.tercero_id FROM usuario u WHERE u.usuario_id=r.usuario_actualiza_id) ) AS usuario_actualiza, 
              r.usuario_actualiza_id, r.fecha_actualiza FROM wms_recepcion r";
     
     return $Query;
   
   }
   

}


?>