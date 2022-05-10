<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SocioModel extends Db{

  private $Permisos;
  
  public function getSocios($tercero_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($tercero_id)){

	  $select  = "SELECT c.cliente_factura_socio_id,
				  c.nombre_cliente_socio,
				  c.id_cliente_socio,
				  c.direccion_cliente_socio,
	  			  (SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ubicacion_id) AS ciudad,
				  c.ubicacion_id
	  FROM cliente_factura_socio c, cliente cf  WHERE cf.tercero_id=$tercero_id AND c.cliente_id = cf.cliente_id";
	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
  public function Save($Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $tercero_id 				= $this -> requestDataForQuery('tercero_id','integer');
      $cliente_factura_socio_id = $this -> DbgetMaxConsecutive("cliente_factura_socio","cliente_factura_socio_id",$Conex,true,1);
      $nombre_cliente_socio     = $this -> requestDataForQuery('nombre_cliente_socio','text');
      $id_cliente_socio    		= $this -> requestDataForQuery('id_cliente_socio','alphanum');	  
	  $direccion_cliente_socio 	= $this -> requestDataForQuery('direccion_cliente_socio','text');
      $ubicacion_id            	= $this -> requestDataForQuery('ubicacion_id','integer');
	  
		$insert = "INSERT INTO cliente_factura_socio  
	            (cliente_factura_socio_id,cliente_id,nombre_cliente_socio,id_cliente_socio,direccion_cliente_socio,ubicacion_id) 
	            VALUES  
				($cliente_factura_socio_id,(SELECT cliente_id FROM cliente WHERE tercero_id=$tercero_id),$nombre_cliente_socio,$id_cliente_socio,$direccion_cliente_socio,$ubicacion_id)";

      $this -> query($insert,$Conex);
	$this -> Commit($Conex);
	
	return $cliente_factura_socio_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $tercero_id             	= $this -> requestDataForQuery('tercero_id','integer');
      $cliente_factura_socio_id = $this -> requestDataForQuery('cliente_factura_socio_id','integer');
      $nombre_cliente_socio     = $this -> requestDataForQuery('nombre_cliente_socio','text');
      $id_cliente_socio    		= $this -> requestDataForQuery('id_cliente_socio','alphanum');	  
	  $direccion_cliente_socio 	= $this -> requestDataForQuery('direccion_cliente_socio','text');
      $ubicacion_id            	= $this -> requestDataForQuery('ubicacion_id','integer');

      $update = "UPDATE cliente_factura_socio SET 
	  				nombre_cliente_socio=$nombre_cliente_socio,
					id_cliente_socio=$id_cliente_socio,
					direccion_cliente_socio=$direccion_cliente_socio,
					ubicacion_id=$ubicacion_id
					WHERE  cliente_factura_socio_id = $cliente_factura_socio_id";
    $this -> query($update,$Conex);
	$this -> Commit($Conex);
	return $cliente_factura_socio_id;
  }

  public function Delete($Campos,$Conex){

    $cliente_factura_socio_id = $_REQUEST['cliente_factura_socio_id'];
	
    $insert = "DELETE FROM cliente_factura_socio WHERE cliente_factura_socio_id = $cliente_factura_socio_id";
    $this -> query($insert,$Conex);	

  }

}
?>