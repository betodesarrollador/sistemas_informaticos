<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AdministrativaModel extends Db{

  private $Permisos;
  
  public function getOper($tercero_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($tercero_id)){

	  $select  = "SELECT c.cliente_factura_administrativa_id,
				  c.nombre_cliente_administrativa,
				  c.telefono_cliente_administrativa,
				  c.direccion_cliente_administrativa,
				  c.correo_cliente_factura_administrativa,
				  c.cargo_cliente_administrativa,
	  			  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ubicacion_id) AS ciudad,
				  c.ubicacion_id
	  FROM cliente_factura_administrativa  c, cliente cf  WHERE cf.tercero_id=$tercero_id AND c.cliente_id = cf.cliente_id";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tercero_id 					 = $this -> requestDataForQuery('tercero_id','integer');
      $cliente_factura_administrativa_id  = $this -> DbgetMaxConsecutive("cliente_factura_administrativa","cliente_factura_administrativa_id",$Conex,true,1);
      $nombre_cliente_administrativa      = $this -> requestDataForQuery('nombre_cliente_administrativa','text');
      $telefono_cliente_administrativa    = $this -> requestDataForQuery('telefono_cliente_administrativa','alphanum');	  
	 // $direccion_cliente_administrativa 	 = $this -> requestDataForQuery('direccion_cliente_administrativa','text');
	  $correo_cliente_factura_administrativa = $this -> requestDataForQuery('correo_cliente_factura_administrativa','text');
	  $cargo_cliente_administrativa 	 	 = $this -> requestDataForQuery('cargo_cliente_administrativa','text');	  
      //$ubicacion_id            		 = $this -> requestDataForQuery('ubicacion_id','integer');
	  
		$insert = "INSERT INTO cliente_factura_administrativa  
	            (cliente_factura_administrativa_id,cliente_id,nombre_cliente_administrativa,telefono_cliente_administrativa,correo_cliente_factura_administrativa,cargo_cliente_administrativa) 
	            VALUES  
				($cliente_factura_administrativa_id,(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id),$nombre_cliente_administrativa,$telefono_cliente_administrativa,$correo_cliente_factura_administrativa,$cargo_cliente_administrativa)";

      $this -> query($insert,$Conex);
	$this -> Commit($Conex);
	
	return $cliente_factura_administrativa_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $tercero_id             		 = $this -> requestDataForQuery('tercero_id','integer');
      $cliente_factura_administrativa_id  = $this -> requestDataForQuery('cliente_factura_administrativa_id','integer');
      $nombre_cliente_administrativa      = $this -> requestDataForQuery('nombre_cliente_administrativa','text');
      $telefono_cliente_administrativa    = $this -> requestDataForQuery('telefono_cliente_administrativa','alphanum');	  
	  //$direccion_cliente_administrativa 	 	= $this -> requestDataForQuery('direccion_cliente_administrativa','text');
	  $correo_cliente_factura_administrativa = $this -> requestDataForQuery('correo_cliente_factura_administrativa','text');
	  $cargo_cliente_administrativa 	 	 = $this -> requestDataForQuery('cargo_cliente_administrativa','text');	  
      //$ubicacion_id            		 = $this -> requestDataForQuery('ubicacion_id','integer');

      $update = "UPDATE cliente_factura_administrativa SET 
	  				nombre_cliente_administrativa=$nombre_cliente_administrativa,
					telefono_cliente_administrativa=$telefono_cliente_administrativa,
					correo_cliente_factura_administrativa=$correo_cliente_factura_administrativa,
					cargo_cliente_administrativa=$cargo_cliente_administrativa
					WHERE  cliente_factura_administrativa_id = $cliente_factura_administrativa_id";

    $this -> query($update,$Conex);
	$this -> Commit($Conex);
	return $cliente_factura_administrativa_id;
  }

  public function Delete($Campos,$Conex){

    $cliente_factura_administrativa_id = $_REQUEST['cliente_factura_administrativa_id'];
	
    $insert = "DELETE FROM cliente_factura_administrativa WHERE cliente_factura_administrativa_id = $cliente_factura_administrativa_id";
    $this -> query($insert,$Conex);	

  }

}
?>