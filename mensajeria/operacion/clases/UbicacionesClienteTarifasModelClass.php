<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class UbicacionesClienteTarifasModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  

//LISTA MENU

  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D' 
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  }
  
  public function saveDetalleUbicacionesClienteTarifas($cliente_id,$ubicaciones,$Conex){
  
     $this -> Begin($Conex);
     
	   $delete = "DELETE FROM ubicacion_cliente_tarifa WHERE cliente_id = $cliente_id";
	   $result = $this -> query($delete,$Conex);

       $ubicacion_cliente_tarifa_id  = $this -> DbgetMaxConsecutive("ubicacion_cliente_tarifa","ubicacion_cliente_tarifa_id",$Conex,false,1);			          
       for($i = 0; $i < count($ubicaciones); $i++){
       		 
         $nombre                  = $ubicaciones[$i]['nombre'];
         $ubicacion_id            = $ubicaciones[$i]['ubicacion_id'];
         
         $insert = "INSERT INTO ubicacion_cliente_tarifa (ubicacion_cliente_tarifa_id,nombre,ubicacion_id,cliente_id) 
		 VALUES ($ubicacion_cliente_tarifa_id,'$nombre',$ubicacion_id,$cliente_id)";

         $this -> query($insert,$Conex,true);

         if($this -> GetNumError() > 0){
           return false;
         }     
		 
		 
		 $ubicacion_cliente_tarifa_id++;
       
       }  
     
     
     $this -> Commit($Conex);
  
     return true;
  }

   
}



?>