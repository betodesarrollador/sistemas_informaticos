<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesGuiaToREModel extends Db{

  private $Permisos;
  
  public function Save($Campos,$Conex){
  
   $this -> Begin($Conex);  
	$reexpedido_id = $this -> requestDataForQuery('reexpedido_id','integer');
	$guia_id     = $this -> requestDataForQuery('guia_id','integer');

    $insert = "INSERT INTO detalle_despacho_guia (reexpedido_id,guia_id) VALUES ($reexpedido_id,$guia_id)";	
    $this -> query($insert,$Conex,true);
	
	$update = "UPDATE guia SET estado_mensajeria_id = 4 WHERE guia_id = $guia_id";
    $this -> query($update,$Conex,true);	
	
	$this -> Commit($Conex);
	
	return $guia_id;
  }  
  
  
  public function getFiltro1($fecha,$depa_consul,$cliente_consul,$desti_consul,$oficina_id,$Conex){ 
	   	
    $select = "SELECT CONCAT('<input type=\"checkbox\" name=\"procesar\" id=\"',r.numero_guia,'\" value=\"',r.guia_id,'\" />') AS link,
			  r.numero_guia AS guia,r.remitente AS remitente, r.direccion_destinatario,
			  (SELECT CONCAT_WS( ' - ', u1.nombre, u2.nombre ) FROM ubicacion u1, ubicacion u2 WHERE u1.ubicacion_id = r.destino_id
			  AND u1.ubi_ubicacion_id = u2.ubicacion_id) AS destino,r.destinatario AS destinatario,r.fecha_guia AS fecha 
			  FROM guia r 
			  WHERE  (r.estado_mensajeria_id = 1 OR r.estado_mensajeria_id = 2 ) 
			   $fecha $depa_consul $cliente_consul $desti_consul";	
		 // WHERE r.oficina_id = $oficina_id AND (r.estado_mensajeria_id = 1 OR r.estado_mensajeria_id = 2 ) 
		  //echo $select;
		  $results = $this -> DbFetchAll($select,$Conex);
		  return $results;
  }   
  
  
  
 
}

?>