<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SemiRemolquesModel extends Db{

  public function tenedorFueReportadoMinisterio($tenedor_id,$Conex){
  
    $select = "SELECT reportado_ministerio FROM tenedor WHERE tenedor_id = $tenedor_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }

  }
  
  public function propietarioFueReportadoMinisterio($propietario_id,$Conex){

    $select = "SELECT reportado_ministerio FROM tercero WHERE tercero_id = $propietario_id";
    $result = $this -> DbFetchAll($select,$Conex,true); 
	
	if($result[0]['reportado_ministerio'] == 1){
	  return true;
	}else{
	    return false;
	  }
  
  
  }
  
  public function getPesoMaximoConfiguracion($configuracion,$Conex){
  
     $select = "SELECT peso_maximo FROM configuracion WHERE configuracion = '$configuracion'";
     $result = $this -> DbFetchAll($select,$Conex,true); 	 
	 
	 if(is_numeric($result[0]['peso_maximo'])){
	   return $result[0]['peso_maximo'];
	 }else{
	     return 0;
	   }
  
  }
  
  public function getGalonesMinimoConfiguracion($configuracion,$Conex){
  
     $select = "SELECT galones_minimo FROM configuracion WHERE configuracion = '$configuracion'";
     $result = $this -> DbFetchAll($select,$Conex,true); 	 
	 
	 if(is_numeric($result[0]['galones_minimo'])){
	   return $result[0]['galones_minimo'];
	 }else{
	     return 0;
	   }    
  
  }
  
  public function getGalonesMaximoConfiguracion($configuracion,$Conex){
  
     $select = "SELECT galones_maximo FROM configuracion WHERE configuracion = '$configuracion'";
     $result = $this -> DbFetchAll($select,$Conex,true); 	 
	 
	 if(is_numeric($result[0]['galones_maximo'])){
	   return $result[0]['galones_maximo'];
	 }else{
	     return 0;
	   }  
  
  }			    

  
  public function Save($Campos,$Conex){
    $this -> DbInsertTable("remolque",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
	$Id = $_REQUEST[placa_remolque];
    $this -> SetConex($Conex);
    $this -> DbUpdateTable("remolque",$Campos,$Conex,true,false);

  }

  public function Delete($Campos,$Conex){
  	$Id = $_REQUEST[placa_remolque];
    $this -> SetConex($Conex);
  	$this -> DbDeleteTable("remolque",$Campos,$Conex,true,false);
	
  }


//LISTA MENU
  public function GetConfig($Conex){
	return $this  -> DbFetchAll("SELECT tipo_remolque_id AS value,tipo_remolque AS text FROM tipo_remolque ORDER BY tipo_remolque_id ",$Conex,true);
  }
  
  public function GetCarroceria($Conex){
  
    $select = "SELECT carroceria_id AS value,carroceria AS text FROM carroceria WHERE carroceria_id <> 0 ORDER BY carroceria";  
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
	
  }
 

//BUSQUEDA
  public function selectSemiremolques($Placa,$Conex){
	return $this -> DbFetchAll("SELECT r.*, 
							   (SELECT mr.marca_remolque FROM marca_remolque mr WHERE mr.marca_remolque_id = r.marca_remolque_id) AS marca_remolque,
							   (SELECT CONCAT_WS(' ',t1.numero_identificacion,t1.primer_apellido,t1.segundo_apellido,t1.primer_nombre,t1.segundo_nombre,t1.razon_social) FROM tercero t1 WHERE t1.tercero_id= (SELECT tercero_id FROM tenedor WHERE tenedor_id = r.tenedor_id)) AS tenedor,
							   (SELECT CONCAT_WS(' ',t2.numero_identificacion,t2.primer_apellido,t2.segundo_apellido,t2.primer_nombre,t2.segundo_nombre,t2.razon_social) FROM tercero t2 WHERE t2.tercero_id=r.propietario_id) AS propietario
								FROM remolque r WHERE r.placa_remolque LIKE TRIM('$Placa')",$Conex,true);
  }


//// GRID ////
  public function getQueryRemolquesGrid(){
  
     $Query = "SELECT placa_remolque,modelo_remolque,(select tipo_remolque from tipo_remolque where tipo_remolque_id = r.tipo_remolque_id) as tipo_remolque,(select carroceria from carroceria where carroceria_id = r.carroceria_remolque_id ) as carroceria,peso_vacio_remolque,capacidad_carga_remolque,
	 (select marca_remolque from marca_remolque where marca_remolque_id = r.marca_remolque_id) AS marca,
	 (select concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) from tercero where tercero_id = r.propietario_id)  as propietario,(select concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) from tercero where tercero_id = (select tercero_id from tenedor where tenedor_id = r.tenedor_id)) as tenedor,estado  FROM remolque r"; 
     return $Query;
  }
   
}
?>