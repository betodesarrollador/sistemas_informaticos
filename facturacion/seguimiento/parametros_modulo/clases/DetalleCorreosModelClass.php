<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetalleCorreosModel extends Db{

  private $Permisos;
  
  public function getDetallesCorreos($Conex){
  
    $novedad_id = $_REQUEST['novedad_id'];
	
	if(is_numeric($novedad_id)){
	
	  $select  = "SELECT r.*,
	  (SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM usuario u, tercero t WHERE  u.usuario_id = r.usuario_id AND t.tercero_id=u.tercero_id) AS usuario 
	  FROM reporte_novedad r 
	  WHERE r.novedad_id = $novedad_id ";
	
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }
    
  public function Save($Campos,$Conex){
  
    $novedad_id         = $this -> requestDataForQuery('novedad_id','integer'); 
    $reporte_novedad_id = $this -> requestDataForQuery('reporte_novedad_id','integer');
    $usuario_id     	= $this -> requestDataForQuery('usuario_id','integer');
    $correo 			= $this -> requestDataForQuery('correo','text'); 

    $reporte_novedad_id = $this -> DbgetMaxConsecutive("reporte_novedad","reporte_novedad_id",$Conex);	
	$reporte_novedad_id = ($reporte_novedad_id + 1);

    $insert = "INSERT INTO reporte_novedad (reporte_novedad_id,novedad_id,usuario_id,correo) 
	           VALUES ($reporte_novedad_id,$novedad_id,$usuario_id,$correo)";
	
    $this -> query($insert,$Conex);
	
	return $reporte_novedad_id;

  }

  public function Update($Campos,$Conex){

    $novedad_id         = $this -> requestDataForQuery('novedad_id','integer'); 
    $reporte_novedad_id = $this -> requestDataForQuery('reporte_novedad_id','integer');
    $usuario_id     	= $this -> requestDataForQuery('usuario_id','integer');
    $correo 			= $this -> requestDataForQuery('correo','text'); 


    $update = "UPDATE reporte_novedad SET usuario_id = $usuario_id,correo = $correo
	WHERE reporte_novedad_id = $reporte_novedad_id";
    $this -> query($update,$Conex);

  }

  public function Delete($Campos,$Conex){

    $reporte_novedad_id    = $this -> requestDataForQuery('reporte_novedad_id','integer');
    $delete = "DELETE FROM reporte_novedad WHERE reporte_novedad_id = $reporte_novedad_id";
    $this -> query($delete,$Conex);	

  }
 


   
}



?>