<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ProyectosModel extends Db{

  private $Permisos;
  
  public function getProy($tercero_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($tercero_id)){

	  $select  = "select cp.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) AS comercial from tercero WHERE tercero_id=(SELECT tercero_id FROM comercial where comercial_id=cp.comercial_id)) as comercial from cliente_proyecto cp where cliente_id=(select cliente_id from cliente where tercero_id=$tercero_id)";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
   public function getComercial($Conex){
  
	
	  $select  = " SELECT (SELECT CONCAT_WS( ' ', razon_social, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido )) as text, 
					(SELECT c.comercial_id )as value 
					FROM tercero t ,comercial c where t.tercero_id=c.tercero_id ORDER BY value asc ";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	
	  return $result;
  }

  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tercero_id 					 = $this -> requestDataForQuery('tercero_id','integer');
      $cliente_proyecto_id			 = $this -> DbgetMaxConsecutive("cliente_proyecto","cliente_proyecto_id",$Conex,true,1);
      $nombre_proyecto			     = $this -> requestDataForQuery('nombre_proyecto','text');
      $codigo_proyecto				 = $this -> requestDataForQuery('codigo_proyecto','text	');	  
	  $estado_proyecto 				 = $this -> requestDataForQuery('estado_proyecto','text');
	  $comercial_id					 = $this -> requestDataForQuery('comercial_id','text');
	 
	  
		$insert = "INSERT INTO cliente_proyecto  
	            (cliente_proyecto_id,cliente_id,codigo,nombre,estado,comercial_id) 
	            VALUES  
				($cliente_proyecto_id,(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id),$codigo_proyecto,$nombre_proyecto,$estado_proyecto,$comercial_id)";

      $this -> query($insert,$Conex);
	$this -> Commit($Conex);
	
	return $cliente_proyecto_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

     $tercero_id 					 = $this -> requestDataForQuery('tercero_id','integer');
      $cliente_proyecto_id			 = $this -> DbgetMaxConsecutive("cliente_proyecto","cliente_proyecto_id",$Conex,true,1);
      $nombre_proyecto			     = $this -> requestDataForQuery('nombre_proyecto','text');
      $codigo_proyecto				 = $this -> requestDataForQuery('codigo_proyecto','text	');	  
	  $estado_proyecto 				 = $this -> requestDataForQuery('estado_proyecto','text');
	  $comercial_id					 = $this -> requestDataForQuery('comercial_id','text');
	 
	  
      $update = "UPDATE cliente_proyecto SET 
	  				nombre=$nombre_proyecto,
					codigo=$codigo_proyecto,
					estado=$estado_proyecto
					comercial_id=$comercial_id
					WHERE  cliente_proyecto_id = $cliente_proyecto_id";

    $this -> query($update,$Conex);
	$this -> Commit($Conex);
	return $cliente_proyecto_id;
  }

  public function Delete($Campos,$Conex){

    $cliente_proyecto_id = $_REQUEST['cliente_proyecto_id'];
	
    $insert = "DELETE FROM cliente_proyecto WHERE cliente_proyecto_id = $cliente_proyecto_id";
    $this -> query($insert,$Conex);	

  }

}
?>