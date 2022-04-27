<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class EjecutivoModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosEjecutivoTerceroId($tercero_id,$Conex){
	  
  
     $select    = "SELECT 
	 					c.*,
						t.*,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion, 
						(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco 
				   	FROM tercero t 
				   		LEFT JOIN ejecutivo c ON t.tercero_id = c.tercero_id 
	                WHERE t.tercero_id = $tercero_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }
  
  public function selectDatosEjecutivoNumeroId($numero_identificacion,$Conex){
	  
  
     $select    = "SELECT 
	 					c.*,
						t.*, 
				   		(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion, 
						(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco 
				   	FROM tercero t 
						LEFT JOIN ejecutivo c ON t.tercero_id = c.tercero_id 
	                WHERE t.numero_identificacion = $numero_identificacion";
	  
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
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
	  $email 	          	  = $this -> requestDataForQuery('email','text');
	  $regimen_id 	          = $this -> requestDataForQuery('regimen_id','integer');
	  
	  $insert = "INSERT INTO tercero (tercero_id,ubicacion_id,tipo_persona_id,tipo_identificacion_id,numero_identificacion,digito_verificacion,
									  primer_apellido,segundo_apellido, primer_nombre,segundo_nombre,razon_social,sigla,telefono,movil,direccion,email,regimen_id) 
	  				VALUES 
									($tercero_id,$ubicacion_id,$tipo_persona_id,$tipo_identificacion_id,$numero_identificacion,$digito_verificacion,
									 $primer_apellido,$segundo_apellido,$primer_nombre,$segundo_nombre,$razon_social,$sigla,$telefono,$movil,$direccion,$email,$regimen_id)"; 
	  $this -> query($insert,$Conex);
      $this -> assignValRequest('tercero_id',$tercero_id);
      $this -> DbInsertTable("ejecutivo",$Campos,$Conex,true,false);  
	  $this -> Commit($Conex);  
	
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
      $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);
	  if($_REQUEST['ejecutivo_id'] == 'NULL'){
	    $this -> DbInsertTable("ejecutivo",$Campos,$Conex,true,false);			
      }else{
          $this -> DbUpdateTable("ejecutivo",$Campos,$Conex,true,false);
		  $tercero_id        = $this -> requestDataForQuery('tercero_id','integer');
		  				  			
	  }
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("ejecutivo",$Campos,$Conex,true,false);
  }	
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"tercero",$Campos);
	 return $Data -> GetData();
   }
	 	
  public function GetTipoId($Conex){
	return $this  -> DbFetchAll("SELECT tipo_identificacion_id AS value,nombre AS text FROM tipo_identificacion ORDER BY nombre
	ASC",$Conex,$ErrDb = false);
  }
	
   public function GetTipoPersona($Conex){
	return $this -> DbFetchAll("SELECT tipo_persona_id AS value,nombre AS text FROM tipo_persona",$Conex,
	$ErrDb = false);
   }

   public function GetTipoRegimen($Conex){
	return $this -> DbFetchAll("SELECT regimen_id AS value,nombre AS text FROM regimen",$Conex,
	$ErrDb = false);
   }

   public function GetTipoCuenta($Conex){
	return $this -> DbFetchAll("SELECT tipo_cta_id AS value,nombre_tipo_cuenta AS text FROM tipo_cuenta",$Conex,
	$ErrDb = false);
   }

   public function getOficinas($Conex){
	return $this -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina",$Conex,
	$ErrDb = false);
   }
   public function GetQueryEjecutivosGrid(){
	   	   
   $Query = "SELECT
   			(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_id,
			t.numero_identificacion,
			t.digito_verificacion,
			(SELECT nombre FROM tipo_persona WHERE tipo_persona_id = t.tipo_persona_id) AS tipo_persona_id, 
			t.primer_apellido,
   			t.segundo_apellido,
			t.primer_nombre,
			t.segundo_nombre,
			t.razon_social,
			t.sigla,
			(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion,
			t.direccion,
			t.telefono,
			t.movil,
			t.telefax,
			t.apartado,
			t.email,
			c.numcuenta_ejecutivo,
			(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE tipo_cta_id=c.tipo_cta_id) AS tip_cuenta,
			(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco, 
			IF(c.estado_ejecutivo='B','BLOQUEADO','DISPONIBLE')AS estado
			FROM tercero t, ejecutivo c 
			WHERE t.tercero_id = c.tercero_id";
   return $Query;
   }
}

?>