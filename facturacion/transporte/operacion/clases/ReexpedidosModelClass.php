<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ReexpedidosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
  public function Save($Campos,$Conex){
	
    $reexpedido_id = $this -> DbgetMaxConsecutive("reexpedido","reexpedido_id",$Conex);
	$reexpedido_id++;
	$reexpedido    = $reexpedido_id;
	
	$this -> assignValRequest('reexpedido_id',$reexpedido_id);
	$this -> assignValRequest('reexpedido',$reexpedido);
    
	$this -> DbInsertTable("reexpedido",$Campos,$Conex,true,false);
	
	return array(array(reexpedido_id=>$reexpedido_id, reexpedido=>$reexpedido));
	
  }

  public function Update($Campos,$Conex){
  	
    $this -> DbUpdateTable("reexpedido",$Campos,$Conex,true,false);
	
  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("reexpedido",$Campos,$Conex,true,false);
  }


//LISTA MENU

    
 

//BUSQUEDA
  public function selectReexpedidos($reexpedido_id,$Conex){
    				
   $select = "SELECT 
				r.reexpedido_id,
				r.reexpedido,
   				r.remesa_id,
	 			(SELECT UPPER(numero_remesa) FROM remesa WHERE remesa_id=r.remesa_id) 
				AS numero_remesa,
				r.fecha_rxp,
				r.proveedor_id,
	 			(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) 
					FROM tercero t, proveedor p 
					WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) 
				AS proveedor,
				r.origen_id,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) 
				AS origen,
				r.destino_id,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) 
				AS destino,
				r.guia_rxp,
				r.valor_rxp,
				r.obser_rxp
	 		FROM reexpedido r
			WHERE r.reexpedido_id=$reexpedido_id";
				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }
   


//// GRID ////
  public function getQueryReexpedidosGrid(){
	   	   
     $Query = "SELECT 
	 			(SELECT numero_remesa FROM remesa WHERE remesa_id=r.remesa_id) AS numero_remesa,
				r.reexpedido,
				r.fecha_rxp,
	 			(SELECT (CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) 
					FROM tercero t, proveedor p 
					WHERE r.proveedor_id=p.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
				guia_rxp,valor_rxp,obser_rxp
	 		FROM reexpedido r";
   
     return $Query;
   }
   
}



?>