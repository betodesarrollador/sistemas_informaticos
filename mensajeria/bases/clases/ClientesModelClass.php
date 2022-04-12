<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ClientesModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosClientesTerceroId($tercero_id,$Conex){
	  
  
     $select    = "SELECT 
						c.*,						
	 					t.*,
						c.estado AS estado,
						r.remitente_destinatario_id, 	
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion, 
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=c.rep_ubicacion_id) AS ciurepre_cliente_factura, 
						(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) AS banco 
				   	FROM tercero t 
				   		LEFT JOIN cliente c ON t.tercero_id = c.tercero_id 
						LEFT JOIN remitente_destinatario r ON t.tercero_id = r.tercero_id 
	                WHERE t.tercero_id = $tercero_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }

  
  public function selectDatosClientesNumeroId($numero_identificacion,$Conex){
	  
  
     $select    = "SELECT 
						c.*, 
	 					t.*,
						IF(c.estado IS NULL,'B',c.estado) AS estado,
						r.remitente_destinatario_id, 	
				   		(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS ubicacion, 
						(SELECT nombre_banco FROM banco WHERE 	banco_id=c.banco_id) AS banco 
				   	FROM tercero t 
						LEFT JOIN cliente c ON t.tercero_id = c.tercero_id 
						LEFT JOIN remitente_destinatario r ON t.tercero_id = r.tercero_id 
	                WHERE t.numero_identificacion = $numero_identificacion";
	  
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }  
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
					
	  $tercero_id             	 = $_REQUEST['tercero_id']>0 ? $_REQUEST['tercero_id'] : $this -> DbgetMaxConsecutive("tercero","tercero_id",$Conex,true,1);
	  $cliente_id             	 = $this->DbgetMaxConsecutive("cliente","cliente_id",$Conex,false,1);
   	  $remitente_destinatario_id = $this->DbgetMaxConsecutive("remitente_destinatario","remitente_destinatario_id",$Conex,false,1);	  
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
	  $nombre                 = strlen(trim($_REQUEST['razon_social'])) > 0 ? $_REQUEST['razon_social'] : 
								  $_REQUEST['primer_nombre'].' '.$_REQUEST['segundo_nombre'].' '.
								  $_REQUEST['primer_apellido'].' '.$_REQUEST['segundo_apellido'];	
								  
	  if(!$_REQUEST['tercero_id']>0 || $_REQUEST['tercero_id'] == 'NULL'){
		  $insert = "INSERT INTO tercero (tercero_id,ubicacion_id,tipo_persona_id,tipo_identificacion_id,numero_identificacion,digito_verificacion,
										  primer_apellido,segundo_apellido, primer_nombre,segundo_nombre,razon_social,sigla,telefono,movil,direccion,email,regimen_id) 
						VALUES 
										($tercero_id,$ubicacion_id,$tipo_persona_id,$tipo_identificacion_id,$numero_identificacion,$digito_verificacion,
										 $primer_apellido,$segundo_apellido,$primer_nombre,$segundo_nombre,$razon_social,$sigla,$telefono,$movil,$direccion,$email,$regimen_id)"; 
		  $this -> query($insert,$Conex,true);
		  $this -> assignValRequest('tercero_id',$tercero_id);
	  }else{
		  $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);		
	  }
      $this -> assignValRequest('cliente_id',$cliente_id);
      $this -> DbInsertTable("cliente",$Campos,$Conex,true,false);  

	  $insert1 = "INSERT INTO remitente_destinatario (remitente_destinatario_id,cliente_id,tercero_id,tipo_identificacion_id,
	  numero_identificacion,digito_verificacion,nombre,direccion,telefono,ubicacion_id,tipo,estado) VALUES($remitente_destinatario_id,$cliente_id,$tercero_id,$tipo_identificacion_id,
	  $numero_identificacion,$digito_verificacion,'$nombre',$direccion,$telefono,$ubicacion_id,'R','D')";
	  $this -> query($insert1,$Conex,true);
	  $this -> Commit($Conex);  
	  return array(array(tercero_id => $tercero_id,cliente_id => $cliente_id,remitente_destinatario_id => $remitente_destinatario_id));
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
      $this -> DbUpdateTable("tercero",$Campos,$Conex,true,false);
	  if($_REQUEST['cliente_id'] == 'NULL'){
		  
		$cliente_id = $this -> DbgetMaxConsecutive("cliente","cliente_id",$Conex,false,1);
		$this -> assignValRequest('cliente_id',$cliente_id);
	    $this -> DbInsertTable("cliente",$Campos,$Conex,true,false);

		$remitente_destinatario_id = $this->DbgetMaxConsecutive("remitente_destinatario","remitente_destinatario_id",$Conex,false,1);
		
		$tercero_id             = $_REQUEST['tercero_id'];
		$tipo_identificacion_id = $_REQUEST['tipo_identificacion_id'];			
		$numero_identificacion  = $_REQUEST['numero_identificacion'];
		$digito_verificacion    = $_REQUEST['digito_verificacion'];
		$nombre                 = strlen(trim($_REQUEST['razon_social'])) > 0 ? $_REQUEST['razon_social'] : 
								  $_REQUEST['primer_nombre'].' '.$_REQUEST['segundo_nombre'].' '.
								  $_REQUEST['primer_apellido'].' '.$_REQUEST['segundo_apellido'];	
		$direccion              = $_REQUEST['direccion'];								
		$telefono               = $_REQUEST['telefono'];
		$ubicacion_id           = $_REQUEST['ubicacion_id'];									  		
		
		$insert = "INSERT INTO remitente_destinatario (remitente_destinatario_id,cliente_id,tercero_id,tipo_identificacion_id,
		numero_identificacion,digito_verificacion,nombre,direccion,telefono,ubicacion_id,tipo,estado)  
		VALUES($remitente_destinatario_id,$cliente_id,$tercero_id,$tipo_identificacion_id,
		'$numero_identificacion','$digito_verificacion','$nombre','$direccion','$telefono',$ubicacion_id,'R','A')";
  
		$this -> query($insert,$Conex);			

      }else{
        $this -> DbUpdateTable("cliente",$Campos,$Conex,true,false);

		$remitente_destinatario_id = $_REQUEST["remitente_destinatario_id"];			
		$numero_identificacion     = $_REQUEST['numero_identificacion'];
		$tipo_identificacion_id    = $_REQUEST['tipo_identificacion_id'];						
		$digito_verificacion       = $_REQUEST['digito_verificacion'];
		$nombre                    = strlen(trim($_REQUEST['razon_social'])) > 0 ? $_REQUEST['razon_social'] : 
									 $_REQUEST['primer_nombre'].' '.$_REQUEST['segundo_nombre'].' '.
									 $_REQUEST['primer_apellido'].' '.$_REQUEST['segundo_apellido'];
		$direccion              = $_REQUEST['direccion'];								
		$telefono               = $_REQUEST['telefono'];
		$ubicacion_id           = $_REQUEST['ubicacion_id'];										 			
		
		$update = "UPDATE remitente_destinatario SET tipo_identificacion_id = $tipo_identificacion_id,numero_identificacion ='$numero_identificacion',digito_verificacion='$digito_verificacion',nombre='$nombre',direccion='$direccion',
		telefono='$telefono',ubicacion_id=$ubicacion_id WHERE remitente_destinatario_id = $remitente_destinatario_id";
		
		$this -> query($update,$Conex);				

	  }
	$this -> Commit($Conex);
	return $cliente_id;	
  }

	  public function duplicar($Conex){
		 
	
		$this -> Begin($Conex);

			$cliente_id					= $this -> requestDataForQuery('cliente_id','integer');
		  	$tipo_servicio_mensajeria_id= $this -> requestDataForQuery('tipo_servicio_mensajeria_id','integer');
		  	$periodo  					= $this -> requestDataForQuery('periodo','integer');
		  	$periodo_final    			= $this -> requestDataForQuery('periodo_final','integer');
			
			if ($tipo_servicio_mensajeria_id==2){	
			
			$select = "SELECT * FROM tarifas_masivo_cliente WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id AND periodo=$periodo AND
						cliente_id=$cliente_id";
		  	$result	=	$this -> DbFetchAll($select,$Conex,true);		  

		  	if (count($result)==0) {
				exit('No Existen Tarifas Creadas con Este Tipo de Servicio para este Cliente en el Periodo Base Seleccionado. <br> Por favor Verifique.');
		  	}

		  	$select2 = "SELECT tarifas_masivo_cliente_id FROM tarifas_masivo_cliente WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id AND
					  periodo=$periodo_final AND cliente_id=$cliente_id";
		  	$result2	=	$this -> DbFetchAll($select2,$Conex,true);
		  	if (count($result2)>0) {
				exit('Ya se Crearon Tarifas de Masivo en el Periodo Final con el Mismo Tipo de Servicio.');
			}else{
					for($i=0;$i<count($result);$i++){

					  $tarifas_masivo_cliente_id	= $this	->	DbgetMaxConsecutive("tarifas_masivo_cliente","tarifas_masivo_cliente_id",$Conex,true,1);
					  $cliente_id 					= $result[$i]['cliente_id'];					  
					  $tipo_servicio_mensajeria_id 	= $result[$i]['tipo_servicio_mensajeria_id'];
					  $tipo_envio_id 				= $result[$i]['tipo_envio_id'];
					  $rango_inicial 				= $result[$i]['rango_inicial'];
					  $rango_final 					= $result[$i]['rango_final'];					  
					  $vr_min_declarado 			= $result[$i]['vr_min_declarado'];
					  $valor_min 					= $result[$i]['valor_min'];
					  $valor_max 					= $result[$i]['valor_max'];
					  $porcentaje_seguro 			= $result[$i]['porcentaje_seguro'];
					  $periodo 						= $result[$i]['periodo'];
					  $usuario 						= $result[$i]['usuario'];	
					  $oficina 						= $result[$i]['oficina'];				  
					  
					  $insert 	= "INSERT INTO tarifas_masivo_cliente (tarifas_masivo_cliente_id,cliente_id, tipo_servicio_mensajeria_id, tipo_envio_id,
								rango_inicial, rango_final, vr_min_declarado, valor_min, valor_max, porcentaje_seguro, periodo,  usuario, oficina) 
								VALUES ($tarifas_masivo_cliente_id, $cliente_id, $tipo_servicio_mensajeria_id, $tipo_envio_id, $rango_inicial, $rango_final, 
								$vr_min_declarado, $valor_min, $valor_max, $porcentaje_seguro, $periodo_final,  $usuario, $oficina)";	
					  //$result1	=	$this -> DbFetchAll($insert,$Conex,true);
					  //echo $insert;
					  $this -> query($insert,$Conex,true);
					}
				}
			}else{
				
		  		$select = "SELECT * FROM tarifas_mensajeria_cliente WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id AND periodo=$periodo AND 
						cliente_id=$cliente_id";
			  	$result	=	$this -> DbFetchAll($select,$Conex,true);		  
	
			  	if (count($result)==0) {
					exit('No Existen Tarifas Creadas con Este Tipo de Servicio en el Periodo Base Seleccionado. <br> Por favor Verifique.');
			  	}
	
			  	$select2 = "SELECT tarifas_mensajeria_cliente_id FROM tarifas_mensajeria_cliente WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id AND
						  periodo=$periodo_final AND cliente_id=$cliente_id";
			  	$result2	=	$this -> DbFetchAll($select2,$Conex,true);
		  	if (count($result2)>0) {
				exit('Ya se Crearon Tarifas de Mensajeria en el Periodo Final con el Mismo Tipo de Servicio.');
			}else{
					for($i=0;$i<count($result);$i++){

					  $tarifas_mensajeria_cliente_id= $this	->	DbgetMaxConsecutive("tarifas_mensajeria_cliente","tarifas_mensajeria_cliente_id",$Conex,true,1);
					  $cliente_id 					= $result[$i]['cliente_id'];					  
					  $tipo_servicio_mensajeria_id 	= $result[$i]['tipo_servicio_mensajeria_id'];
					  $tipo_envio_id 				= $result[$i]['tipo_envio_id'];
					  $vr_min_declarado 			= $result[$i]['vr_min_declarado'];
					  $vr_kg_inicial_min 			= $result[$i]['vr_kg_inicial_min'];
					  $vr_kg_inicial_max 			= $result[$i]['vr_kg_inicial_max'];
					  $vr_kg_adicional_min 			= $result[$i]['vr_kg_adicional_min'];
					  $vr_kg_adicional_max 			= $result[$i]['vr_kg_adicional_max']>0 ? $result[$i]['vr_kg_adicional_max']: 'NULL';
					  $periodo 						= $result[$i]['periodo'];
					  $porcentaje_seguro 			= $result[$i]['porcentaje_seguro'];
					  $usuario 						= $result[$i]['usuario'];	
					  $oficina 						= $result[$i]['oficina'];				  
					  
					  $insert 	= "INSERT INTO tarifas_mensajeria_cliente (tarifas_mensajeria_cliente_id, cliente_id, tipo_servicio_mensajeria_id, tipo_envio_id, 
								vr_min_declarado, vr_kg_inicial_min, vr_kg_inicial_max, vr_kg_adicional_min, vr_kg_adicional_max, periodo, porcentaje_seguro,
								usuario, oficina) 
								VALUES ($tarifas_mensajeria_cliente_id, $cliente_id, $tipo_servicio_mensajeria_id, $tipo_envio_id, $vr_min_declarado, 
								$vr_kg_inicial_min, $vr_kg_inicial_max, $vr_kg_adicional_min, $vr_kg_adicional_max, $periodo_final, $porcentaje_seguro,
								$usuario, $oficina)";	
					  //$result1	=	$this -> DbFetchAll($insert,$Conex,true);
					  //echo $insert;
					  $this -> query($insert,$Conex,true);
					}
				}
			}
		$this -> Commit($Conex);	  
		
	  }

	public function GetTipoMensajeria($Conex){
		$result =  $this  -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre_corto AS text FROM tipo_servicio_mensajeria ORDER BY nombre_corto ASC",$Conex,false);
		return $result;
	}

	public function GetPeriodo($Conex){
		$result =  $this  -> DbFetchAll("SELECT periodo_contable_id AS value, anio AS text FROM periodo_contable WHERE estado=1 ORDER BY anio ASC",$Conex,false);
		return $result;
	}

  public function Delete($Campos,$Conex){
  	$this -> DbDeleteTable("cliente",$Campos,$Conex,true,false);
	$this -> DbDeleteTable("remitente_destinatario",$Campos,$Conex,true,false);
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

   public function GetBanco($Conex){
	return $this -> DbFetchAll("SELECT banco_id AS value,nombre_banco AS text FROM banco",$Conex,
	$ErrDb = false);
   }


   public function GetQueryClientesGrid(){
	   	   
   $Query = "SELECT 
   			(SELECT nombre FROM tipo_identificacion WHERE tipo_identificacion_id = t.tipo_identificacion_id) AS tipo_identificacion_id,
			t.numero_identificacion,
			digito_verificacion,
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
			c.numcuenta_cliente_factura,
			(SELECT nombre_tipo_cuenta FROM tipo_cuenta WHERE 	tipo_cta_id=c.tipo_cta_id) AS tip_cuenta,
			(SELECT nombre_banco FROM banco WHERE banco_id=c.banco_id) 	AS banco, 
			(SELECT CONCAT_WS(' ',te.razon_social,te.primer_nombre,te.segundo_nombre,te.primer_apellido,te.segundo_apellido)AS comercial FROM comercial co, tercero te WHERE co.comercial_id=c.comercial_id AND co.tercero_id=te.tercero_id) AS comercial,			
			IF(c.estado='B','BLOQUEADO','DISPONIBLE')AS estado
		FROM tercero t,cliente c 
		WHERE t.tercero_id = c.tercero_id";
		
   return $Query;
   }
}

?>