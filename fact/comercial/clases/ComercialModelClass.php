<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ComercialModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosComercialTerceroId($tercero_id,$Conex){
	  
  
     $select    = "SELECT 
	 					c.*,
						t.*,
						(SELECT pc.rec_rango1 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango1,
						(SELECT pc.rec_rango2 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango2,
						(SELECT pc.rec_rango3 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango3,
						(SELECT pc.rec_rango4 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango4,
						
						(SELECT pc.fac_rango1 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango1,
						(SELECT pc.fac_rango2 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango2,
						(SELECT pc.fac_rango3 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango3,
						(SELECT pc.fac_rango4 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango4,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion, 
						(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco
						
				  FROM  tercero t 
				   		LEFT JOIN  comercial c ON t.tercero_id = c.tercero_id
	                WHERE t.tercero_id = $tercero_id ";
					//echo $select;
     $result    = $this -> DbFetchAll($select,$Conex,true);
     return $result;					  			
	  //pc.*,porcentaje_comision_comercial pc ,AND pc.comercial_id=c.comercial_id
  }
  
  public function selectDatosComercialNumeroId($numero_identificacion,$Conex){
	  
  
     $select    = "SELECT 
	 					c.*,
						t.*, 
						(SELECT pc.rec_rango1 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango1,
						(SELECT pc.rec_rango2 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango2,
						(SELECT pc.rec_rango3 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango3,
						(SELECT pc.rec_rango4 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as rec_rango4,
						
						(SELECT pc.fac_rango1 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango1,
						(SELECT pc.fac_rango2 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango2,
						(SELECT pc.fac_rango3 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango3,
						(SELECT pc.fac_rango4 FROM  porcentaje_comision_comercial pc WHERE pc.comercial_id=c.comercial_id)as fac_rango4,
				   		(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion, 
						(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco
				   	FROM tercero t 
						LEFT JOIN comercial c ON t.tercero_id = c.tercero_id 
	                WHERE t.numero_identificacion = $numero_identificacion";
	  
     $result    = $this -> DbFetchAll($select,$Conex,true);
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
	  
	  $rec_rango1          		  = $this -> requestDataForQuery('rec_rango1','text');
	  $rec_rango2       	      = $this -> requestDataForQuery('rec_rango2','text');
	  $rec_rango3			      = $this -> requestDataForQuery('rec_rango3','text');
	  $rec_rango4 		          = $this -> requestDataForQuery('rec_rango4','text');
	  
	  $fac_rango1          		  = $this -> requestDataForQuery('fac_rango1','text');
	  $fac_rango2          		  = $this -> requestDataForQuery('fac_rango2','text');
	  $fac_rango3          		  = $this -> requestDataForQuery('fac_rango3','text');
	  $fac_rango4          		  = $this -> requestDataForQuery('fac_rango4','text');
	 
	  $renta_comercial 	      = $this -> requestDataForQuery('renta_comercial','alpha');
	  $retei_comercial 	      = $this -> requestDataForQuery('retei_comercial','alpha');
	  $autoret_comercial 	  = $this -> requestDataForQuery('autoret_comercial','alpha');	  

	  $insert = "INSERT INTO tercero (tercero_id,ubicacion_id,tipo_persona_id,tipo_identificacion_id,numero_identificacion,digito_verificacion,
									  primer_apellido,segundo_apellido, primer_nombre,segundo_nombre,razon_social,sigla,telefono,movil,direccion,email,regimen_id, retei_comercial,autoret_comercial,renta_comercial) 
	  				VALUES 
									($tercero_id,$ubicacion_id,$tipo_persona_id,$tipo_identificacion_id,$numero_identificacion,$digito_verificacion,
									 $primer_apellido,$segundo_apellido,$primer_nombre,$segundo_nombre,$razon_social,$sigla,$telefono,$movil,$direccion,$email,$regimen_id, $retei_comercial,$autoret_comercial,$renta_comercial)"; 
	  
	  $this -> query($insert,$Conex);
	  
      $this -> assignValRequest('tercero_id',$tercero_id);
      $this -> DbInsertTable("comercial",$Campos,$Conex,true,false); 
	 
	
	  
	  $insert = "INSERT INTO porcentaje_comision_comercial (comercial_id,rec_rango1,rec_rango2,rec_rango3,rec_rango4,fac_rango1,fac_rango2,fac_rango3,fac_rango4) VALUES ($comercial_id,$rec_rango1,$rec_rango2,$rec_rango3,$rec_rango4,$fac_rango1,$fac_rango2,$fac_rango3,$fac_rango4)";
	 //echo $insert;
	 $this -> query($insert,$Conex);
	  
	  $this -> Commit($Conex); 
  }
	
  public function Update($Campos,$Conex){	
  
	$comercial_id  						 = $_REQUEST['comercial_id'] ;
	$porcentaje_comision_comercial_id    = $this -> DbgetMaxConsecutive("porcentaje_comision_comercial","porcentaje_comision_comercial_id",$Conex,true,1);
	
	  $rec_rango1          		  = $this -> requestDataForQuery('rec_rango1','text');
	  $rec_rango2       	      = $this -> requestDataForQuery('rec_rango2','text');
	  $rec_rango3			      = $this -> requestDataForQuery('rec_rango3','text');
	  $rec_rango4 		          = $this -> requestDataForQuery('rec_rango4','text');
	  
	 $fac_rango1          		  = $this -> requestDataForQuery('fac_rango1','text');
	  $fac_rango2          		  = $this -> requestDataForQuery('fac_rango2','text');
	  $fac_rango3          		  = $this -> requestDataForQuery('fac_rango3','text');
	  $fac_rango4          		  = $this -> requestDataForQuery('fac_rango4','text');
	 
	 $rec_rango1  = $rec_rango1>0 || $rec_rango1!='NULL' ? $rec_rango1  : 0;  
	 $rec_rango2  = $rec_rango2>0 || $rec_rango2!='NULL'? $rec_rango2  : 0;  
	 $rec_rango3  = $rec_rango3>0 || $rec_rango3!='NULL' ? $rec_rango3  : 0;  
	 $rec_rango4  = $rec_rango4>0 || $rec_rango4!='NULL' ? $rec_rango4  : 0;  
	 
	 $fac_rango1  = $fac_rango1>0 || $fac_rango1!='NULL' ? $fac_rango1  : 0;  
	 $fac_rango2  = $fac_rango2>0 || $fac_rango2!='NULL' ? $fac_rango2  : 0;  
	 $fac_rango3  = $fac_rango3>0 || $fac_rango3!='NULL' ? $fac_rango3  : 0;  
	 $fac_rango4  = $fac_rango4>0 || $fac_rango4!='NULL' ? $fac_rango4  : 0;  
	 
	
	$select = "SELECT comercial_id FROM porcentaje_comision_comercial WHERE comercial_id = $comercial_id ";
	$result    = $this -> DbFetchAll($select,$Conex);
	if($result[0]['comercial_id']>0)
	{
		$update="UPDATE porcentaje_comision_comercial SET rec_rango1=$rec_rango1, rec_rango2 = $rec_rango2, rec_rango3 = $rec_rango3, rec_rango4=$rec_rango4
		,fac_rango1=$fac_rango1,fac_rango2=$fac_rango2,fac_rango3=$fac_rango3,fac_rango4=$fac_rango4 WHERE comercial_id=$comercial_id";
		$this -> query($update,$Conex);
		//echo $update;
	}else{
		
		$insert = "INSERT INTO porcentaje_comision_comercial (porcentaje_comision_comercial_id,comercial_id,rec_rango1,rec_rango2,rec_rango3,rec_rango4,fac_rango1,fac_rango2,fac_rango3,fac_rango4) VALUES ($porcentaje_comision_comercial_id,$comercial_id,$rec_rango1,$rec_rango2,$rec_rango3,$rec_rango4,$fac_rango1,$fac_rango2,$fac_rango3,$fac_rango4)";
		//echo $insert;
		$this -> query($insert,$Conex);
	
	}
   
   
  
   
   $this -> Begin($Conex);
   
      $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);
	  if($comercial_id == 'NULL'){
	    $this -> DbInsertTable("comercial",$Campos,$Conex,true,false);	
		
      }else{
          $this -> DbUpdateTable("comercial",$Campos,$Conex,true,false);
		  $tercero_id        = $this -> requestDataForQuery('tercero_id','integer');
		 // $this -> DbTable("porcentaje_comision_comercial",$Campos,$Conex,true,false);
		  		  				  			
	  }
	  
	   
	$this -> Commit($Conex);
  }
  
  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("comercial",$Campos,$Conex,true,false);
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
   public function GetQueryComercialesGrid(){
	   	   
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
			c.numcuenta_comercial,
			(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE tipo_cta_id=c.tipo_cta_id) AS tip_cuenta,
			(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco, 
			IF(c.estado_comercial='B','BLOQUEADO','DISPONIBLE')AS estado
			FROM tercero t, comercial c 
			WHERE t.tercero_id = c.tercero_id";
   return $Query;
   }
}

?>