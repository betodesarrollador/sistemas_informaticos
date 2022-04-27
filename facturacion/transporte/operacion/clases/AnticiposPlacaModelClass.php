<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class AnticiposPlacaModel extends Db{

  
  
  public function TieneAnticiposPlaca($placa_id,$Conex){
  
    $select = "SELECT * FROM vehiculo WHERE placa_id = $placa_id";
	$result = $this -> DbFetchAll($select,$Conex);
	 
	if(count($result) > 0){
	  return true;
	}else{
	     return false;
	  }  
  
  }
  
  public function selectConductor($conductor_id,$Conex){
  
     $select = "SELECT c.conductor_id,concat_ws(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
	 AS nombre,t.numero_identificacion,IF(DATE(vencimiento_licencia_cond) < DATE(NOW()),'SI','NO') AS 
	 licencia_vencio, c.vencimiento_licencia_cond FROM conductor c,tercero t  WHERE t.tercero_id = c.tercero_id AND 
	  c.conductor_id = $conductor_id";
	  
	 $dataConductor   = $this -> DbFetchAll($select,$Conex,true);
	 $licencia_vencio = $dataConductor[0]['licencia_vencio'];
	 
	 if($licencia_vencio == 'SI'){
	 
	   $update = "UPDATE conductor SET estado = 'B' WHERE conductor_id = $conductor_id";
	   $result = $this -> query($update,$Conex,true);
	 
	 }
	
	 return $dataConductor; 
  
  }  

  public function selectTenedor($tenedor_id,$Conex){
  
     $select = "SELECT c.tenedor_id,concat_ws(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
	 AS tenedor,t.numero_identificacion AS numero_identificacion_tenedor FROM tenedor c,tercero t  WHERE t.tercero_id = c.tercero_id AND 
	  c.tenedor_id = $tenedor_id";
	  
	 $dataTenedor   = $this -> DbFetchAll($select,$Conex,true);
	
	 return $dataTenedor; 
  
  }  

  
    public function selectVehiculo($placa_id,$Conex){
  
     $select = "SELECT 
	 (IF(DATE(vencimiento_soat) < DATE(NOW()),'SI','NO')) AS soat_vencio,
	 (IF(DATE(vencimiento_tecno_vehiculo) < DATE(NOW()),'SI','NO'))  AS tecnicomecanica_vencio,
	 (SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS tenedor,v.tenedor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS numero_identificacion_tenedor,
	conductor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS	numero_identificacion,
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS nombre,
	(SELECT vencimiento_licencia_cond FROM conductor WHERE conductor_id = v.conductor_id) AS vencimiento_licencia_cond,(SELECT IF(DATE(vencimiento_licencia_cond) < DATE(NOW()),'SI','NO') FROM conductor WHERE conductor_id = v.conductor_id) AS licencia_vencio,v.propio 
	FROM vehiculo v WHERE placa_id = $placa_id ";	  
			
	$dataVehiculo    = $this -> DbFetchAll($select,$Conex,true);
	
	$soat_vencio            = $dataVehiculo[0]['soat_vencio'];
	$tecnicomecanica_vencio = $dataVehiculo[0]['tecnicomecanica_vencio'];
	$licencia_vencio        = $dataVehiculo[0]['licencia_vencio'];
	$conductor_id           = $dataVehiculo[0]['conductor_id'];	
	
	if($licencia_vencio == 'SI'){
	
	  $update = "UPDATE conductor SET estado = 'B' WHERE conductor_id = $conductor_id";
	  $result = $this -> query($update,$Conex,true);
	
	}
	
	if($tecnicomecanica_vencio == 'SI' || $soat_vencio == 'SI'){
	
	  $update = "UPDATE vehiculo SET estado = 'B' WHERE placa_id = $placa_id";
	  $result = $this -> query($update,$Conex,true);
	  	
	}
	
	return $dataVehiculo; 
  
  } 



}

?>