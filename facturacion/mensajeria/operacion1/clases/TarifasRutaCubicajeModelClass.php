<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TarifasRutaCubicajeModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosTarifasRutaCubicajeId($tarifa_ruta_cubicaje_id,$Conex){
     $select    = "SELECT
	 					t.*,
							(SELECT nombre 
							 FROM ubicacion 
							 WHERE ubicacion_id=t.origen_id) 
						AS origen, 
							(SELECT nombre 
							 FROM ubicacion 
							 WHERE ubicacion_id=t.destino_id) 
						AS destino FROM tarifa_ruta_cubicaje  t 
	                WHERE t.tarifa_ruta_cubicaje_id = $tarifa_ruta_cubicaje_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  public function getClientes($Conex){
	  
	  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D' 
	             ORDER BY nombre_cliente ASC";
				 
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result;	  
	  
  }  
    
  public function Save($Campos,$Conex){	
  	$this -> DbInsertTable("tarifa_ruta_cubicaje",$Campos,$Conex,true,false);  	
  }
	
  public function Update($Campos,$Conex){	
  	$this -> DbUpdateTable("tarifa_ruta_cubicaje",$Campos,$Conex,true,false);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tarifa_ruta_cubicaje",$Campos,$Conex,true,false);
  }	
		
   public function GetQueryTarifasRutaCubicajeGrid(){
	   	   
   $Query = "SELECT tr.tarifa_ruta_cubicaje_id,(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
							FROM cliente c, tercero t  
							WHERE tr.cliente_id=c.cliente_id 
							AND c.tercero_id=t.tercero_id
						)
					AS cliente,
							(SELECT nombre 
							 FROM ubicacion 
							 WHERE ubicacion_id=tr.origen_id) 
						AS origen, 
							(SELECT nombre 
							 FROM ubicacion 
							 WHERE ubicacion_id=tr.destino_id) 
						AS destino,desde,hasta ,valor FROM tarifa_ruta_cubicaje tr ORDER BY cliente,origen,destino,desde,hasta ASC";
   return $Query;
   }
}

?>