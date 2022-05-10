<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class OrdenCompraModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
	
	$oficina_id     = $this -> requestDataForQuery('oficina_id','integer');
	
	/*se optiene el consecutivo de la orden de compra por oficina*/
	$orden_compra   = $this -> DbgetMaxConsecutive("ordencompra_conexo WHERE oficina_id=$oficina_id","orden_compra",$Conex,false,1);
	$ordencompra_id = $this -> DbgetMaxConsecutive("ordencompra_conexo","ordencompra_id",$Conex,false,1);
	
	$this -> assignValRequest('orden_compra',$orden_compra);
	$this -> assignValRequest('ordencompra_id',$ordencompra_id);
	
    $this -> DbInsertTable("ordencompra_conexo",$Campos,$Conex,true,false);
	
	return array(
				array(ordencompra_id=>$ordencompra_id),
				array(orden_compra=>$orden_compra)
			);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("ordencompra_conexo",$Campos,$Conex,true,false);
  }

  public function Delete($Campos,$Conex){
	$this -> Begin($Conex);
		$ordencompra_id  = $this -> requestDataForQuery('ordencompra_id','integer');
		$delete          = "DELETE FROM detalle_ordenconexo WHERE ordencompra_id=$ordencompra_id; ";
		
		$this -> query($delete,$Conex);
		
		$this -> DbDeleteTable("ordencompra_conexo",$Campos,$Conex,true,false);
	$this -> Commit($Conex);
  }


//LISTA MENU 	
  public function getEmpresas($usuario_id,$Conex){
   
    $select = "SELECT 
	 			e.empresa_id AS value,
	 				CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) 
				AS text 
				FROM empresa e,tercero t 
	 			WHERE t.tercero_id = e.tercero_id 
				AND e.empresa_id IN 
					(SELECT empresa_id 
					 FROM oficina 
					 WHERE oficina_id IN 
					 	(SELECT oficina_id 
						 FROM opciones_actividad 
						 WHERE usuario_id = $usuario_id)
					)";
	 
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 
	return $result;
  }
  
  public function GetServiConexo($Conex){
	return $this -> DbFetchAll("SELECT servi_conex_id AS value, servi_conex AS text FROM servicio_conexo WHERE estado LIKE 'A' ORDER BY servi_conex",$Conex,$ErrDb = false);
  }
	
  
 

//BUSQUEDA
  public function selectOrdenCompra($Conex){
    
	$ordencompra_id = $this -> requestDataForQuery('ordencompra_id','integer');
	
    $select = "SELECT 
					o.empresa_id,
					oc.*,
						CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre)
					AS proveedor,
					t.numero_identificacion,
					t.direccion,
					t.telefono
				FROM ordencompra_conexo oc, oficina o, tercero t 
				WHERE oc.ordencompra_id=$ordencompra_id
				AND oc.oficina_id=o.oficina_id
				AND oc.tercero_id=t.tercero_id";

	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }
  
  public function selectProveedor($Conex){
    
	$tercero_id = $this -> requestDataForQuery('tercero_id','integer');
	
    $select = "SELECT 
					numero_identificacion,
					direccion,
					telefono
				FROM tercero 
				WHERE tercero_id=$tercero_id";

	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	
	return $result;
  }


//// GRID ////
  public function getQueryOrdenCompraGrid(){
	   	   
     $Query = "SELECT 
	 			orden_compra,
					(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id)
				AS agencia,
					(SELECT servi_conex FROM servicio_conexo WHERE servi_conex_id=o.servi_conex_id) 
				AS servi_conex,
				fecha,
					(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id=o.tercero_id)
				AS proveedor,
					(SELECT CONCAT_WS('-',numero_identificacion,digito_verificacion) FROM tercero WHERE tercero_id=o.tercero_id)
				AS identificacion
				FROM ordencompra_conexo o";
   
     return $Query;
   }
   
}



?>