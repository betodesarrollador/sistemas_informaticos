<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class VehiculosModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function vencimientoSoatEsunAnioMayor($vencimiento_soat,$Conex){
  
     $select = "SELECT DATEDIFF('$vencimiento_soat',NOW()) AS dias";
     $result = $this -> DbFetchAll($select,$Conex,true); 
	 $dias   = $result[0]['dias'];
	 
	 if($dias > 365){
	   return true;
	 }else{
	     return false;
	   }
	   
  }
  
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
    $this -> DbInsertTable("vehiculo",$Campos,$Conex,true,false);
  }

  public function Update($Campos,$Conex){
    $this -> DbUpdateTable("vehiculo",$Campos,$Conex,true,false);
  }

  public function Delete($Campos,$Conex){
    $this -> SetConex($Conex);
  	$this -> DbDeleteTable("vehiculo",$Campos,$Conex,true,false);
	
  }


//LISTA MENU
  public function GetConfig($Conex){
	return $this  -> DbFetchAll("SELECT configuracion AS value,descripcion_config AS text FROM configuracion ORDER BY configuracion ",$Conex,true);
  }
  
  public function GetCarroceria($Conex){
	return $this -> DbFetchAll("SELECT carroceria_id AS value,carroceria AS text FROM carroceria ORDER BY carroceria",$Conex,true);
  }

  public function getTipoVehiculo($Conex){

    $select = "SELECT tipo_vehiculo_id AS value,descripcion AS text FROM tipo_vehiculo ORDER BY descripcion";
    $result = $this -> DbFetchAll($select,$Conex,true); 

    return $result;

  }

  public function getTipoCuenta($Conex){

    $select = "SELECT tipo_cta_id AS value,nombre_tipo_cuenta AS text FROM tipo_cuenta ORDER BY nombre_tipo_cuenta ASC";
    $result = $this -> DbFetchAll($select,$Conex,true); 

    return $result;

  }
  
  public function getBancos($Conex){

     $select = "SELECT 	banco_id AS value,nombre_banco AS text  FROM banco ORDER BY nombre_banco ASC";
     $result = $this -> DbFetchAll($select,$Conex,true);

     return $result;

  }

  public function GetCombustible($Conex){
	return $this -> DbFetchAll("SELECT combustible_id AS value,combustible AS text FROM combustible ORDER BY combustible",$Conex,true);
  }

  public function getAseguradoras($Conex){

    $select = "SELECT aseguradora_id AS value,concat(nombre_aseguradora,' ',nit_aseguradora) AS text FROM aseguradora ORDER BY nombre_aseguradora ASC";
    $result = $this -> DbFetchAll($select,$Conex);

    return $result;

  }
 

//BUSQUEDA
  public function selectVehiculosId($PlacaId,$Conex){
  
  $select = "SELECT v.*, /* m.marca, l.linea,*/ (SELECT marca FROM marca WHERE marca_id = v.marca_id) AS marca,  (SELECT linea FROM linea WHERE linea_id = v.linea_id) AS linea, /*cl.color,*/ (SELECT color FROM color WHERE color_id = v.color_id) AS color,CONCAT_WS(' ',trt.numero_identificacion,trt.primer_apellido,trt.segundo_apellido,trt.primer_nombre,trt.segundo_nombre,trt.razon_social) AS tenedor,trt.numero_identificacion AS cedula_nit_tenedor,(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = trt.tipo_persona_id) AS tipo_persona_tenedor,trt.telefono AS telefono_tenedor,trt.movil AS celular_tenedor,trt.direccion AS direccion_tenedor,trt.email AS email_tenedor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = trt.ubicacion_id) AS ciudad_tenedor,(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE tipo_cta_id = tn.tipo_cta_id) AS tipo_cuenta_tenedor,(SELECT nombre_banco FROM banco WHERE banco_id = tn.banco_id) AS banco_cuenta_tenedor,tn.numero_cuenta_tene AS numero_cuenta_tenedor,CONCAT_WS(' ',pr.numero_identificacion,pr.primer_apellido,pr.segundo_apellido,pr.primer_nombre,pr.segundo_nombre,pr.razon_social) AS propietario,pr.numero_identificacion AS cedula_nit_propietario,(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = pr.tipo_persona_id) AS tipo_persona_propietario,pr.telefono AS telefono_propietario,pr.movil AS celular_propietario,pr.direccion AS direccion_propietario,pr.email AS email_propietario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = trt.ubicacion_id) AS ciudad_propietario,(SELECT CONCAT_WS(' ',numero_identificacion,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS conductor,(SELECT CONCAT_WS(' ',numero_identificacion,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = v.persona_aprobo_id) AS  persona_aprobo,
   (SELECT CONCAT_WS(' ',numero_identificacion,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = v.persona_reviso_id) AS  persona_reviso,s.nombre_aseguradora AS aseguradora_soat, (SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,(SELECT marca_remolque FROM marca_remolque WHERE marca_remolque_id = (SELECT marca_remolque_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS marca_remolque,(SELECT tipo_remolque FROM tipo_remolque WHERE tipo_remolque_id = (SELECT tipo_remolque_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS tipo_remolque,(SELECT modelo_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS modelo_remolque,(SELECT nombre FROM ubicacion WHERE ubicacion_id = v.ciudad_vehiculo_id) AS ciudad_vehiculo


								FROM vehiculo v, /*marca m, linea l, color cl,*/ tenedor tn, tercero trt, tercero pr, aseguradora s
								WHERE v.placa_id = $PlacaId
								/*AND v.marca_id=m.marca_id 
								AND v.linea_id=l.linea_id 
								AND v.color_id=cl.color_id */
								AND v.tenedor_id= tn.tenedor_id AND tn.tercero_id = trt.tercero_id
								AND v.propietario_id=pr.tercero_id
								AND v.aseguradora_soat_id=s.aseguradora_id";
								
    $result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
	
  }
  
  public function selectVehiculosPlaca($Placa,$Conex){
  
   $select = "SELECT v.*,  /*m.marca,l.linea, */ (SELECT marca FROM marca WHERE marca_id = v.marca_id) AS marca,  (SELECT linea FROM linea WHERE linea_id = v.linea_id) AS linea, /*cl.color,*/ (SELECT color FROM color WHERE color_id = v.color_id) AS color,CONCAT_WS(' ',trt.numero_identificacion,trt.primer_apellido,trt.segundo_apellido,trt.primer_nombre,trt.segundo_nombre,trt.razon_social) AS tenedor,trt.numero_identificacion AS cedula_nit_tenedor,(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = trt.tipo_persona_id) AS tipo_persona_tenedor,trt.telefono AS telefono_tenedor,trt.movil AS celular_tenedor,trt.direccion AS direccion_tenedor,trt.email AS email_tenedor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = trt.ubicacion_id) AS ciudad_tenedor,(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE tipo_cta_id = tn.tipo_cta_id) AS tipo_cuenta_tenedor,(SELECT nombre_banco FROM banco WHERE banco_id = tn.banco_id) AS banco_cuenta_tenedor,tn.numero_cuenta_tene AS numero_cuenta_tenedor,CONCAT_WS(' ',pr.numero_identificacion,pr.primer_apellido,pr.segundo_apellido,pr.primer_nombre,pr.segundo_nombre,pr.razon_social) AS propietario,pr.numero_identificacion AS cedula_nit_propietario,(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = pr.tipo_persona_id) AS tipo_persona_propietario,pr.telefono AS telefono_propietario,pr.movil AS celular_propietario,pr.direccion AS direccion_propietario,pr.email AS email_propietario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = trt.ubicacion_id) AS ciudad_propietario,(SELECT CONCAT_WS(' ',numero_identificacion,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS conductor,(SELECT CONCAT_WS(' ',numero_identificacion,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = v.persona_aprobo_id) AS  persona_aprobo,
   (SELECT CONCAT_WS(' ',numero_identificacion,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = v.persona_reviso_id) AS  persona_reviso,



									s.nombre_aseguradora AS aseguradora_soat, (SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,(SELECT marca_remolque FROM marca_remolque WHERE marca_remolque_id = (SELECT marca_remolque_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS marca_remolque,(SELECT tipo_remolque FROM tipo_remolque WHERE tipo_remolque_id = (SELECT tipo_remolque_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS tipo_remolque,(SELECT modelo_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS modelo_remolque,(SELECT nombre FROM ubicacion WHERE ubicacion_id = v.ciudad_vehiculo_id) AS ciudad_vehiculo


								FROM vehiculo v, /*marca m, linea l, color cl,*/ tenedor tn, tercero trt, tercero pr, aseguradora s
								WHERE upper(trim(v.placa))like  upper(trim('$Placa')) 
								/*AND v.marca_id=m.marca_id 
								AND v.linea_id=l.linea_id 
								AND v.color_id=cl.color_id*/ 
								AND v.tenedor_id= tn.tenedor_id AND tn.tercero_id = trt.tercero_id
								AND v.propietario_id=pr.tercero_id
								AND v.aseguradora_soat_id=s.aseguradora_id";
								
    $result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
	
  } 


  public function getDataRemolque($placa_remolque_id,$Conex){

     $select = "SELECT *,(SELECT marca_remolque FROM marca_remolque WHERE marca_remolque_id = m.marca_remolque_id) AS marca_remolque,(SELECT tipo_remolque FROM tipo_remolque WHERE tipo_remolque_id = m.tipo_remolque_id) AS tipo_remolque FROM remolque m WHERE placa_remolque_id = $placa_remolque_id";

     $result = $this -> DbFetchAll($select,$Conex,true);

     return $result;

  } 

  public function getDataPropietario($propietario_id,$Conex){

     $select = "SELECT tr.*,(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = tr.tipo_persona_id) as tipo_persona,(SELECT nombre FROM ubicacion WHERE ubicacion_id = tr.ubicacion_id) AS ubicacion FROM tercero tr WHERE tr.tercero_id = $propietario_id";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }

  public function getDataTenedor($tenedor_id,$Conex){

     $select = "SELECT tn.*,tr.*,(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = tr.tipo_persona_id) as tipo_persona,(SELECT nombre FROM ubicacion WHERE ubicacion_id = tr.ubicacion_id) AS ubicacion,(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE tipo_cta_id = tn.tipo_cta_id) AS tipo_cuenta,(SELECT nombre_banco FROM banco WHERE banco_id = tn.banco_id) AS entidad_bancaria FROM tenedor tn, tercero tr WHERE tn.tenedor_id = $tenedor_id AND tn.tercero_id = tr.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }
  
  public function selectRequiereRemolque($tipo_vehiculo_id,$Conex){
  
      $select   = "SELECT remolque FROM tipo_vehiculo WHERE tipo_vehiculo_id = $tipo_vehiculo_id";
      $result   = $this -> DbFetchAll($select,$Conex,false);
	  
	  $requiere = $result[0]['remolque'];
	  
	  if($requiere == 1){
	    return true;
	  }else{
	       return false;
	    }
  
  }
  
  public function selectReferenciasConductor($conductor_id,$Conex){
  
     $select = "SELECT referencia1,ciudad_referencia1_id,telefono_referencia1,referencia2,ciudad_referencia2_id,telefono_referencia2,referencia3,
	ciudad_referencia3_id,telefono_referencia3,(SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia1_id) 
	AS ciudad_referencia1,(SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia2_id) AS ciudad_referencia2,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = c.ciudad_referencia3_id) AS ciudad_referencia3 FROM conductor c WHERE conductor_id = $conductor_id";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;
	   
  }

//// GRID ////
  public function getQueryVehiculosGrid(){
     $Query = "SELECT 
				v.placa,
				(SELECT marca FROM marca WHERE marca_id=v.marca_id) AS marca,
				(SELECT linea FROM linea WHERE linea_id=v.linea_id) AS linea,
				v.configuracion,(SELECT carroceria FROM carroceria WHERE carroceria_id = v.carroceria_id) AS carroceria,
				v.modelo_vehiculo,v.modelo_repotenciado,
				(SELECT color FROM color WHERE color_id=v.color_id) AS color,
				(SELECT combustible FROM combustible WHERE combustible_id=v.combustible_id) AS combustible,
				v.motor,v.chasis,v.peso_vacio,v.capacidad,v.alto_vehiculo,v.ancho_vehiculo,largo_vehiculo,CONCAT_WS('-',t.numero_identificacion,t.digito_verificacion) AS identificacion_tenedor, CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social) AS tenedor,
				CONCAT_WS('-',p.numero_identificacion,p.digito_verificacion) AS identificacion_propietario, CONCAT_WS(' ',p.primer_apellido,p.segundo_apellido,p.primer_nombre,p.segundo_nombre,p.razon_social) AS propietario,v.tecnomecanico_vehiculo,v.vencimiento_tecno_vehiculo,v.numero_soat,(SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = v.aseguradora_soat_id) AS aseguradora,v.vencimiento_soat,IF(v.propio = 1,'SI','NO') AS propio,v.estado
			FROM vehiculo v, tercero t, tercero p, tenedor tn
			WHERE v.tenedor_id=tn.tenedor_id AND tn.tercero_id = t.tercero_id AND v.propietario_id=p.tercero_id";
     return $Query;
   }
   
}



?>