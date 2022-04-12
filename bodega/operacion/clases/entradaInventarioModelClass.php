<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class entradaInventarioModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($recepcion_id,$Campos,$usuario_id,$Conex){

    $this -> assignValRequest('fecha_registro',date('Y-m-d : h:i:s'));
    $this -> assignValRequest('usuario_id',$usuario_id);
	 
    $this -> DbInsertTable("wms_entrada",$Campos,$Conex,true,false);	

    if($this -> GetNumError() > 0){
			   return false;
		}else{
          $update="UPDATE wms_recepcion SET estado = 'I' WHERE recepcion_id = $recepcion_id";
          $this -> query($update,$Conex,true);

          return $entrada_id = $this -> DbgetMaxConsecutive("wms_entrada","entrada_id",$Conex,false,0);
    }
  
  }

  public function Update($Campos,$Conex,$usuario_actualiza_id){		

    $this -> assignValRequest('fecha_actualiza',date('Y-m-d : h:i:s' ));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza_id);

    $this -> DbUpdateTable("wms_entrada",$Campos,$Conex,true,false);	
    if($this -> GetNumError() > 0){
			   return false;
		}else{
          return $entrada_id = $this -> DbgetMaxConsecutive("wms_entrada","entrada_id",$Conex,false,0);
    }
  }

  public function Cancellation($usuario_anula_id,$Campos,$Conex){		

    $entrada_id = $this -> requestDataForQuery('entrada_id','integer');
    $fecha_anula_entrada = $this -> requestDataForQuery('fecha_anula_entrada','date');
    $observacion_anulacion = $this -> requestDataForQuery('observacion_anulacion','text');

    $select ="SELECT s.serial FROM wms_alistamiento_salida_detalle s, wms_entrada_detalle d 
              WHERE s.serial=d.serial AND d.entrada_id = $entrada_id";
              $result = $this -> DbFetchAll($select,$Conex,true);
              $serial = $result[0]['serial'];

      if($serial > 0){
          exit("¡No es posible anular la Entrada porque este producto ya cuenta con un Alistamiento!");
      }else{

        $update="UPDATE wms_recepcion SET estado = 'L' WHERE recepcion_id =(SELECT recepcion_id FROM wms_entrada WHERE entrada_id=$entrada_id AND estado != 'A')";
        $this -> query($update,$Conex,true);

        $update="UPDATE wms_entrada SET estado = 'A', fecha_anula_entrada = $fecha_anula_entrada, observacion_anulacion = $observacion_anulacion, usuario_anula_id= $usuario_anula_id
                 WHERE entrada_id=$entrada_id";
        $this -> query($update,$Conex,true);

        $select="SELECT entrada_detalle_id FROM wms_entrada_detalle WHERE entrada_id = $entrada_id";
        $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
        $entrada_detalle_id = $result[0]['entrada_detalle_id'];

        $delete="DELETE FROM wms_entrada_detalle WHERE entrada_id = $entrada_id";
        $this -> query($delete,$Conex,true);

        if($entrada_detalle_id>0){
          $delete="DELETE FROM wms_inventario WHERE detalle_entrada_producto_id = $entrada_detalle_id";
          $this -> query($delete,$Conex,true);
        }
	      return $entrada_id;
      }
  }

  public function Delete($entrada_id,$Campos,$Conex){
    
    $select="SELECT entrada_detalle_id FROM wms_entrada_detalle WHERE entrada_id = $entrada_id";
    $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

    if($result>0){
       $delete="DELETE FROM wms_entrada_detalle WHERE entrada_id = $entrada_id";
       $this -> query($delete,$Conex,true);
    }
    $this -> DbDeleteTable("wms_entrada",$Campos,$Conex,true,false);
    return true;
  }	
  
//BUSQUEDA

 public function selectEntrada($entrada_id,$Conex){

    $select = "SELECT e.entrada_id, e.fecha, e.estado, e.usuario_id,e.fecha_registro,e.usuario_actualiza_id, e.fecha_actualiza,e.recepcion_id,
    (SELECT CONCAT_WS(' ','Recepcion N° : ',r.recepcion_id) AS valor 
		FROM wms_recepcion r  WHERE  r.recepcion_id=e.recepcion_id) AS recepcion
    FROM wms_entrada e WHERE e.entrada_id=$entrada_id";
    
    $result = $this -> DbfetchAll($select,$Conex);

    return $result;

  }

//// GRID ////
  public function getQueryentradaInventarioGrid(){
	   	   
     $Query = "SELECT 

     e.entrada_id,

     (SELECT CONCAT_WS(' ','Recepcion N° : ',r.recepcion_id) FROM wms_recepcion r  WHERE r.recepcion_id=e.recepcion_id) AS recepcion,
     IF(e.estado='P','PENDIENTE',IF(e.estado='I','INGRESADA',IF(e.estado='IN','INVENTARIO','ANULADA'))) AS estado,

     (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, usuario u WHERE u.usuario_id=e.usuario_id AND u.tercero_id=t.tercero_id) AS usuario,
     
     e.fecha,

     e.fecha_registro,

     (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, usuario u WHERE u.usuario_id=e.usuario_actualiza_id AND u.tercero_id=t.tercero_id) AS usuario_actualiza,

     e.fecha_actualiza

     

    

    FROM wms_entrada e";
     
    return $Query;

   }
   
}



?>