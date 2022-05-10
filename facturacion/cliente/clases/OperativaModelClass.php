<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class OperativaModel extends Db{

  private $Permisos;
  
  public function getOper($tercero_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($tercero_id)){

	  $select  = "SELECT c.cliente_factura_operativa_id,
				  c.nombre_cliente_operativa,
				  c.telefono_cliente_operativa,
				  c.direccion_cliente_operativa,
				  c.correo_cliente_factura_operativa,
				  c.cargo_cliente_operativa,
	  			  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ubicacion_id) AS ciudad,
				  c.ubicacion_id
	  FROM cliente_factura_operativa  c, cliente cf  WHERE cf.tercero_id=$tercero_id AND c.cliente_id = cf.cliente_id";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tercero_id 					 = $this -> requestDataForQuery('tercero_id','integer');
      $cliente_factura_operativa_id  = $this -> DbgetMaxConsecutive("cliente_factura_operativa","cliente_factura_operativa_id",$Conex,true,1);
      $nombre_cliente_operativa      = $this -> requestDataForQuery('nombre_cliente_operativa','text');
      $telefono_cliente_operativa    = $this -> requestDataForQuery('telefono_cliente_operativa','alphanum');	  
	  $direccion_cliente_operativa 	 = $this -> requestDataForQuery('direccion_cliente_operativa','text');
	  $correo_cliente_factura_operativa = $this -> requestDataForQuery('correo_cliente_factura_operativa','text');
	  $cargo_cliente_operativa 	 	 = $this -> requestDataForQuery('cargo_cliente_operativa','text');	  
      $ubicacion_id            		 = $this -> requestDataForQuery('ubicacion_id','integer');
	  
		$insert = "INSERT INTO cliente_factura_operativa  
	            (cliente_factura_operativa_id,cliente_id,nombre_cliente_operativa,telefono_cliente_operativa,direccion_cliente_operativa,correo_cliente_factura_operativa,cargo_cliente_operativa,ubicacion_id) 
	            VALUES  
				($cliente_factura_operativa_id,(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id),$nombre_cliente_operativa,$telefono_cliente_operativa,$direccion_cliente_operativa,$correo_cliente_factura_operativa,$cargo_cliente_operativa,$ubicacion_id)";

      $this -> query($insert,$Conex);
	$this -> Commit($Conex);
	
	return $cliente_factura_operativa_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $tercero_id             		 = $this -> requestDataForQuery('tercero_id','integer');
      $cliente_factura_operativa_id  = $this -> requestDataForQuery('cliente_factura_operativa_id','integer');
      $nombre_cliente_operativa      = $this -> requestDataForQuery('nombre_cliente_operativa','text');
      $telefono_cliente_operativa    = $this -> requestDataForQuery('telefono_cliente_operativa','alphanum');	  
	  $direccion_cliente_operativa 	 	= $this -> requestDataForQuery('direccion_cliente_operativa','text');
	  $correo_cliente_factura_operativa = $this -> requestDataForQuery('correo_cliente_factura_operativa','text');
	  $cargo_cliente_operativa 	 	 = $this -> requestDataForQuery('cargo_cliente_operativa','text');	  
      $ubicacion_id            		 = $this -> requestDataForQuery('ubicacion_id','integer');

      $update = "UPDATE cliente_factura_operativa SET 
	  				nombre_cliente_operativa=$nombre_cliente_operativa,
					telefono_cliente_operativa=$telefono_cliente_operativa,
					direccion_cliente_operativa=$direccion_cliente_operativa,
					correo_cliente_factura_operativa=$correo_cliente_factura_operativa,
					cargo_cliente_operativa=$cargo_cliente_operativa,
					ubicacion_id=$ubicacion_id
					WHERE  cliente_factura_operativa_id = $cliente_factura_operativa_id";

    $this -> query($update,$Conex);
	$this -> Commit($Conex);
	return $cliente_factura_operativa_id;
  }

  public function Delete($Campos,$Conex){

    $cliente_factura_operativa_id = $_REQUEST['cliente_factura_operativa_id'];
	
    $insert = "DELETE FROM cliente_factura_operativa WHERE cliente_factura_operativa_id = $cliente_factura_operativa_id";
    $this -> query($insert,$Conex);	

  }

}
?>