<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TiemposManifiestosModel extends Db{

  private $Permisos;
  
  
  public function getTiemposManifiesto($Conex){
  
	$manifiesto_id = $this -> requestDataForQuery('manifiesto_id','integer');
	
	if(is_numeric($manifiesto_id)){
	
		$select  = "SELECT t.*, (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente 
		WHERE cliente_id = t.cliente_id)) AS cliente FROM tiempos_clientes_remesas t WHERE manifiesto_id = $manifiesto_id";	
		
	  	$result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	  	  
	return $result;
  }
  
  public function Update($Conex){

   $this -> Commit($Conex);

    $tiempos_clientes_remesas_id = $this -> requestData('tiempos_clientes_remesas_id');
    $fecha_llegada_cargue        = $this -> requestData('fecha_llegada_cargue');
    $hora_llegada_cargue         = $this -> requestData('hora_llegada_cargue');
    $fecha_entrada_cargue        = $this -> requestData('fecha_entrada_cargue');
    $hora_entrada_cargue         = $this -> requestData('hora_entrada_cargue');
    $fecha_salida_cargue         = $this -> requestData('fecha_salida_cargue');
    $hora_salida_cargue          = $this -> requestData('hora_salida_cargue');
	
	$update = "UPDATE tiempos_clientes_remesas SET fecha_llegada_cargue = '$fecha_llegada_cargue',hora_llegada_cargue = '$hora_llegada_cargue', fecha_entrada_cargue = '$fecha_entrada_cargue', hora_entrada_cargue = '$hora_entrada_cargue',fecha_salida_cargue = '$fecha_salida_cargue', hora_salida_cargue = '$hora_salida_cargue' WHERE tiempos_clientes_remesas_id = $tiempos_clientes_remesas_id ";
	
	$this -> query($update,$Conex,true);
	
	$update = "UPDATE remesa SET fecha_llegada_cargue = '$fecha_llegada_cargue',hora_llegada_cargue = '$hora_llegada_cargue', fecha_entrada_cargue = '$fecha_entrada_cargue', hora_entrada_cargue = '$hora_entrada_cargue',fecha_salida_cargue = '$fecha_salida_cargue', hora_salida_cargue = '$hora_salida_cargue' WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = (SELECT manifiesto_id FROM tiempos_clientes_remesas WHERE tiempos_clientes_remesas_id = $tiempos_clientes_remesas_id ))";
	
   	$this -> query($update,$Conex,true);

   $this -> Commit($Conex);  
  
  }
 

//BUSQUEDA
   
}



?>