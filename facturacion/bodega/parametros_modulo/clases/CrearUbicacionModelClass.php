<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CrearUbicacionModel extends Db{

  private $usuario_id;
  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }

  public function GetEstadoProductos($Conex){
	return $this -> DbFetchAll("SELECT estado_producto_id AS value,CONCAT_WS(' - ',codigo,nombre)AS text FROM wms_estado_producto WHERE estado='A'",$Conex,$ErrDb = false);
   }
  		
  public function Save($estado_producto,$usuario_id,$Campos,$Conex){	
    
    $this -> assignValRequest('fecha_registro',date('Y-m-d H:i:s'));
    $fecha_registro = date('Y-m-d H:i:s');

    $this -> DbInsertTable("wms_ubicacion_bodega",$Campos,$Conex,true,false);

    $estado_producto_id = explode(",", $estado_producto);
        
	   for($i=0; $i<count($estado_producto_id); $i++){
        $ubicacion_bodega_id  = $this -> DbgetMaxConsecutive("wms_ubicacion_bodega","ubicacion_bodega_id",$Conex,true,0);
        $estado_ubicacion_id  = $this -> DbgetMaxConsecutive("wms_estado_ubicacion","estado_ubicacion_id",$Conex,true,1);
        
        $insert="INSERT INTO wms_estado_ubicacion (estado_ubicacion_id,estado_producto_id,ubicacion_bodega_id,estado,usuario_id,fecha_registro) 
                VALUES ($estado_ubicacion_id,$estado_producto_id[$i],$ubicacion_bodega_id,'A',$usuario_id,'$fecha_registro')";
        $result1 = $this -> query($insert,$Conex,true);
     }
  }

  /* public function GetTipoUbicacion($Conex){
  return $this  -> DbFetchAll("SELECT tipo_ubicacion_id AS value, nombre AS text FROM  tipo_ubicacion ORDER BY  nombre",$Conex,$ErrDb = false);  
  
  }*/
	
  public function Update($estado_producto,$ubicacion_bodega_id,$usuario_actualiza,$Campos,$Conex){	
    
    $this -> assignValRequest('fecha_actualiza',date('Y-m-d H:i:s'));
    $this -> assignValRequest('usuario_actualiza_id',$usuario_actualiza);
    $fecha_actualiza = date('Y-m-d H:i:s');

    $this -> DbUpdateTable("wms_ubicacion_bodega",$Campos,$Conex,true,false);	

      $delete="DELETE FROM wms_estado_ubicacion WHERE ubicacion_bodega_id = $ubicacion_bodega_id";
	    $result1 = $this -> query($delete,$Conex,true);
	
	    $estado_producto_id = explode(",", $estado_producto);
      
	   for($i=0; $i<count($estado_producto_id); $i++){
    
        $estado_ubicacion_id  = $this -> DbgetMaxConsecutive("wms_estado_ubicacion","estado_ubicacion_id",$Conex,true,1);
        
        $insert="INSERT INTO wms_estado_ubicacion (estado_ubicacion_id,estado_producto_id,ubicacion_bodega_id,estado,usuario_actualiza_id,fecha_actualiza) 
                VALUES ($estado_ubicacion_id,$estado_producto_id[$i],$ubicacion_bodega_id,'A',$usuario_actualiza,'$fecha_actualiza')";
                
        $result1 = $this -> query($insert,$Conex,true);
     }
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("wms_ubicacion_bodega",$Campos,$Conex,true,false);
	
  }				 	
   
   public function selectCrearUbicacion($Conex){
      
      $ubicacion_bodega_id = $this -> requestDataForQuery('ubicacion_bodega_id','integer');
      $select         = "SELECT t.ubicacion_bodega_id,
                                t.nombre,
                                t.bodega_id,
                                t.codigo,
                                t.estado,
                                t.area,
                                t.usuario_id,
                                t.fecha_registro,
                                t.usuario_actualiza_id,
                                t.fecha_actualiza,
                                (SELECT w.nombre FROM wms_bodega w WHERE w.bodega_id=t.bodega_id) AS bodega 
                                FROM wms_ubicacion_bodega t WHERE t.ubicacion_bodega_id = $ubicacion_bodega_id";	 
      $result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);

      $data[0]['ubicacion_bodega'] = $result;

       $select="SELECT e.estado_producto_id AS estado_producto FROM wms_estado_ubicacion u,wms_estado_producto e,wms_ubicacion_bodega b 
	              WHERE e.estado_producto_id=u.estado_producto_id AND u.ubicacion_bodega_id=b.ubicacion_bodega_id
                AND b.ubicacion_bodega_id = $ubicacion_bodega_id";
              
	     $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
      if($result > 0){
        $data[0]['estado_ubicacion'] = $result;	
      }else{
        $data[0]['estado_ubicacion'] = null;
      }
      return $data;
      
   }

   public function getQueryCrearUbicacionGrid(){
         
     $Query = "SELECT t.ubicacion_bodega_id,
                t.nombre,
                (SELECT w.nombre FROM wms_bodega w WHERE w.bodega_id=t.bodega_id) AS bodega,
                t.area,
                t.codigo,
                (SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=t.usuario_id)AS usuario,
                t.fecha_registro,
                IF(t.usuario_actualiza_id!=0,(SELECT CONCAT_WS(' ',te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido,te.razon_social)AS usuario_actualiza_id FROM tercero te, usuario u WHERE te.tercero_id = u.tercero_id AND u.usuario_id=t.usuario_actualiza_id),'N/A')AS usuario_actualiza_id,
                IF(t.fecha_actualiza!='',t.fecha_actualiza,'N/A')AS fecha_actualiza,
                IF(t.estado = 'A','ACTIVO','INACTIVO') AS estado
                FROM wms_ubicacion_bodega t  
                ORDER BY t.nombre ASC";
   
     return $Query;
   
   }
   

}


?>