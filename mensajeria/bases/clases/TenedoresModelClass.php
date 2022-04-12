<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class TenedoresModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function Save($Campos,$Conex){
  
    $this -> Begin($Conex);
					
	  $tercero_id             = $this -> DbgetMaxConsecutive("tercero","tercero_id",$Conex,true,1);
	  $ubicacion_id           = $this -> requestDataForQuery('ubicacion_id','integer');
	  $tipo_persona_id        = $this -> requestDataForQuery('tipo_persona_id','integer');
	  $tipo_identificacion_id = $this -> requestDataForQuery('tipo_identificacion_id','integer');
	  $numero_identificacion  = $this -> requestDataForQuery('numero_identificacion','bigint');
	  $digito_verificacion    = $this -> requestDataForQuery('digito_verificacion','integer');
	  $primer_apellido        = $this -> requestDataForQuery('primer_apellido','text');
	  $segundo_apellido       = $this -> requestDataForQuery('segundo_apellido','text');
	  $primer_nombre 	      = $this -> requestDataForQuery('primer_nombre','text');
	  $segundo_nombre 	      = $this -> requestDataForQuery('segundo_nombre','text');
	  $razon_social 	      = $this -> requestDataForQuery('razon_social','alphanum');
	  $sigla                  = $this -> requestDataForQuery('sigla','alphanum');
	  $telefono               = $this -> requestDataForQuery('telefono','alphanum');
	  $movil 	              = $this -> requestDataForQuery('movil','alphanum');
	  $direccion 	          = $this -> requestDataForQuery('direccion','alphanum');
	  $renta_proveedor 	          = $this -> requestDataForQuery('renta_proveedor','alphanum');
	
	  $insert = "INSERT INTO tercero (tercero_id,ubicacion_id,tipo_persona_id,tipo_identificacion_id,numero_identificacion,digito_verificacion,primer_apellido,segundo_apellido, primer_nombre,segundo_nombre,razon_social,sigla,telefono,movil,direccion,renta_proveedor) 
	  VALUES 
($tercero_id,$ubicacion_id,$tipo_persona_id,$tipo_identificacion_id,$numero_identificacion,$digito_verificacion,$primer_apellido,$segundo_apellido,
	  $primer_nombre,$segundo_nombre,$razon_social,$sigla,$telefono,$movil,$direccion,$renta_proveedor)"; 
	  
	  $this -> query($insert,$Conex,true);
	  	
      $this -> assignValRequest('tercero_id',$tercero_id);
	  	 	  
      $this -> DbInsertTable("tenedor",$Campos,$Conex,true,false);  
	  
      $this -> assignValRequest('numcuenta_proveedor',$_REQUEST['numero_cuenta_tene']);	  
      $this -> assignValRequest('estado_proveedor','A');	  	  	  
	  
      $this -> DbInsertTable("proveedor",$Campos,$Conex,true,false);  	  	  
	  
	  
	$this -> Commit($Conex);  
  }
  
  public function  seRegistroProveedor($Conex){
  
    $terceroId = $_REQUEST['tercero_id'];
    $select = "SELECT * FROM proveedor WHERE tercero_id = $terceroId";
    $result = $this -> DbFetchAll($select,$Conex);
       
    if(count($result) > 0){
     return true;
    }else{
       return false;
     }     
  
  }

  public function Update($Campos,$Conex){
  
    $this -> DbUpdateTable("tercero",$Campos,$Conex,false,false);
	
    if($this -> seRegistroTenedor($Conex)){
        $this -> DbUpdateTable("tenedor",$Campos,$Conex,false,false);
    }else{
          $this -> DbInsertTable("tenedor",$Campos,$Conex,false,false);    
     }
	 
    $this -> assignValRequest('numcuenta_proveedor',$_REQUEST['numero_cuenta_tene']);  	 
	 
    if($this -> seRegistroProveedor($Conex)){
        $this -> DbUpdateTable("proveedor",$Campos,$Conex,true,false);
    }else{
          $this -> DbInsertTable("proveedor",$Campos,$Conex,true,false);    
     }
	 
     
  }

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("tenedor",$Campos,$Conex,true,false);
  }
  
  private function seRegistroTenedor($Conex){
	  
    $terceroId = $_REQUEST['tercero_id'];
    $select = "SELECT * FROM tenedor WHERE tercero_id = $terceroId";
    $result = $this -> DbFetchAll($select,$Conex);
       
    if(count($result) > 0){
     return true;
    }else{
       return false;
     }
  }


	//LISTA MENU
  public function GetTipoPersona($Conex){
	return $this -> DbFetchAll("SELECT tipo_persona_id AS value,nombre AS text FROM tipo_persona ORDER BY nombre ASC",$Conex,$ErrDb = false);
   }
  
  public function GetTipoId($Conex){
	return $this  -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion WHERE ministerio = 1  ORDER BY nombre 	ASC",$Conex,$ErrDb = false);
  }
  
  public function GetTipoCuenta($Conex){
	return $this  -> DbFetchAll("SELECT tipo_cta_id AS value,nombre_tipo_cuenta AS text FROM tipo_cuenta ORDER BY nombre_tipo_cuenta ASC",$Conex,$ErrDb = false);
  }
  
  public function GetEntidadBancaria($Conex){
	return $this  -> DbFetchAll("SELECT categoria_id AS value,categoria AS text FROM categoria_licencia ORDER BY categoria ASC",$Conex,$ErrDb = false);
  }

  public function getBancos($Conex){

    $select = "SELECT banco_id AS value,nombre_banco AS text FROM banco ORDER BY nombre_banco ASC";
    $result = $this  -> DbFetchAll($select,$Conex,false);

    return $result;    

  }
 

//BUSQUEDA
  public function selectTenedoresporId($Id,$Conex){
  
   $select = "SELECT t.tercero_id,t.tipo_persona_id,t.tipo_identificacion_id,t.numero_identificacion,t.digito_verificacion,t.primer_apellido,
   t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social,t.sigla,te.tenedor_id,
   t.ubicacion_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion,
   t.direccion,t.telefono,t.movil,t.retei_proveedor,t.autoret_proveedor,
   te.tipo_cta_id,te.numero_cuenta_tene,te.banco_id,te.renta_proveedor,
   (SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social,sigla) FROM tercero WHERE tercero_id=te.banco_id) AS banco,
   te.fecha_data_tene,te.calificacion_data_tene,
   te.estado,te.documentos,'B' AS estado
   FROM tercero t  LEFT JOIN tenedor te ON t.tercero_id = te.tercero_id 
   WHERE t.tercero_id = $Id";
    
   $result =  $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
   return $result;
  }
  
  public function selectTenedoresporNumId($Id,$Conex){
  
   $select = "SELECT t.tercero_id,t.tipo_persona_id,t.tipo_identificacion_id,t.numero_identificacion,t.digito_verificacion,t.primer_apellido,
   t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social,t.sigla,te.tenedor_id,
   t.ubicacion_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion,
   t.direccion,t.telefono,t.movil,t.retei_proveedor,t.autoret_proveedor,
   te.tipo_cta_id,te.numero_cuenta_tene,te.banco_id,te.renta_proveedor,
   (SELECT CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social,sigla) FROM tercero WHERE tercero_id=te.banco_id) AS banco,
   te.fecha_data_tene,te.calificacion_data_tene,
   te.estado,te.documentos,'B' AS estado
   FROM tercero t  LEFT JOIN tenedor te ON t.tercero_id = te.tercero_id 
   WHERE t.numero_identificacion = $Id";
    
   $result =  $this -> DbFetchAll($select,$Conex,$ErrDb = false);
   
   return $result;
  
  }



//// GRID ////
  public function getQueryTenedoresGrid(){
	   	   
     $Query = "	SELECT (SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion,
	 			(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = t.tipo_persona_id) AS tipo_persona,
				t.numero_identificacion,t.digito_verificacion,t.primer_apellido,t.segundo_apellido,
	 			t.primer_nombre,t.segundo_nombre,t.razon_social,t.sigla,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion,
				t.direccion,t.telefono,t.movil,
				(SELECT CONCAT_WS('',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social) FROM tercero WHERE tercero_id=te.banco_id) AS banco,
				(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE tipo_cta_id=te.tipo_cta_id) AS nombre_tipo_cuenta,
				te.numero_cuenta_tene,te.fecha_data_tene,te.calificacion_data_tene,
				te. estado
	 			FROM tercero t, tenedor te
	 			WHERE t.tercero_id=te.tercero_id";
   
     return $Query;
   }
   
}



?>