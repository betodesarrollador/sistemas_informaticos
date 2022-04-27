<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class CargaNominaModel extends Db{
  private $Permisos;
  private $mes_contable_id;
  private $periodo_contable_id;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  
  public function getTerceroModifica($usuario_id,$Conex){
	   
	   $select = "SELECT tercero_id FROM usuario WHERE usuario_id = $usuario_id";
	   $result = $this -> DbFetchAll($select,$Conex,true);
	   
	   return $result[0]['tercero_id'];
   }
   
   public function getUsuarioModifica($usuario_id,$Conex){
	   
	   $select = "SELECT CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido,' ',razon_social,'-',numero_identificacion) AS usuario FROM tercero 
	   WHERE tercero_id = (SELECT tercero_id FROM usuario WHERE usuario_id = $usuario_id)";
	   $result = $this -> DbFetchAll($select,$Conex,true);
	   
	   return $result[0]['usuario'];	   
	   
   }  
   
  public function mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha,$Conex){
	  
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND 
	                  oficina_id = $oficina_id AND '$fecha' BETWEEN fecha_inicio AND fecha_final";
				 
      $result = $this -> DbFetchAll($select,$Conex,true);				 
	  
	  $this -> mes_contable_id = $result[0]['mes_contable_id'];
	  
	  return $result[0]['estado'] == 1 ? true : false;
	  
  }
	
  public function PeriodoContableEstaHabilitado($Conex){
	  
	 $mes_contable_id = $this ->  mes_contable_id;
	 
	 if(!is_numeric($mes_contable_id)){
		return false;
     }else{		 
		 $select = "SELECT estado FROM periodo_contable WHERE periodo_contable_id = (SELECT periodo_contable_id FROM 
                         mes_contable WHERE mes_contable_id = $mes_contable_id)";
		 $result = $this -> DbFetchAll($select,$Conex,true);		 
		 return $result[0]['estado'] == 1? true : false;		 
	   }
	  
  }  
  
  public function selectCuentasFormaPago($forma_pago_id,$Conex){
  
    $select = "SELECT puc_id AS value,codigo_puc AS text FROM puc WHERE puc_id IN (SELECT puc_id FROM cuenta_tipo_pago WHERE forma_pago_id = $forma_pago_id)";
    $result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;
  
  }																			 
     
  public function Save($dir_file,$oficina_id,$Campos,$camposArchivo,$usuario_id,$Conex){  
  
    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 
	  
 	$this -> Begin($Conex);
	
	  $fechaMes                  = substr($this -> requestData("fecha"),0,10);	
	  $oficina_id                = $this -> requestData("oficina_id");	  
	  $tipo_documento_id 	     = $this -> requestData("tipo_documento_id");
      $encabezado_de_registro_id = $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);
	  $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	  $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	  $consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);
	  $modifica					 = $this->getUsuarioModifica($usuario_id,$Conex);
	
      $this -> assignValRequest('fecha_registro',date("Y-m-d h:i:s"));	
      $this -> assignValRequest('encabezado_registro_id',$encabezado_de_registro_id);		
      $this -> assignValRequest('periodo_contable_id',$periodo_contable_id);		
      $this -> assignValRequest('mes_contable_id',$mes_contable_id);		
      $this -> assignValRequest('consecutivo',$consecutivo);		
	  $this -> assignValRequest('modifica',$modifica);		
	  $this -> assignValRequest('usuario_id',$usuario_id);		
      $this -> assignValRequest('anulado','0');			  
      $this -> DbInsertTable("encabezado_de_registro",$Campos,$Conex,true,false);
	
	  if(!strlen(trim($this -> GetError())) > 0){

		$update = "UPDATE encabezado_de_registro SET scan_documento='$dir_file' WHERE encabezado_registro_id = $encabezado_de_registro_id";
		  $this -> query($update,$Conex,true);
	
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}
		  	   
	   foreach($camposArchivo as $valor){
		 if(is_numeric($valor[0]) && ($valor[4]>0 || $valor[5]>0)  ){
			   
			   	$tercero_id='';
				$numero_identificacion='';
				$digito_verificacion='';
				
				$select = "SELECT puc_id FROM puc WHERE codigo_puc=$valor[0]";
				$result = $this -> DbFetchAll($select,$Conex,true);		 
				$puc_id = $result[0]['puc_id'];	
				if($puc_id=='' && $valor[0]>0)
					exit('EL codigo contable '.$valor[0].', No se encuentra parametrizado');
					
				$select1 = "SELECT tercero_id FROM tercero WHERE numero_identificacion=$valor[2]";
				$result1 = $this -> DbFetchAll($select1,$Conex,true);		 
				$tercero_id = $result1[0]['tercero_id'];	
				if($tercero_id=='' && $valor[2]!='')
					exit('EL Tercero '.$valor[2].', No se encuentra en el sistema');
				//echo $tercero_id.'-';
				$select2 = "SELECT centro_de_costo_id, codigo  FROM centro_de_costo WHERE CAST( codigo AS SIGNED )='".intval($valor[1])."'";
				$result2 = $this -> DbFetchAll($select2,$Conex,true);		 
				$centro_de_costo_id = $result2[0]['centro_de_costo_id'];
				$codigo_centro_costo = "'".$result2[0]['codigo']."'";
				if($centro_de_costo_id=='' && $valor[1]!='')
					exit('EL Centro de Costo '.$valor[1].', No se encuentra en el sistema');
				 if(!$utilidadesContables -> requiereTercero($puc_id,$Conex)){
					$tercero_id            = 'NULL'; 
					$numero_identificacion = 'NULL';
					$digito_verificacion   = 'NULL';
				 }else{
				 
				   if(is_numeric($tercero_id)){ 
				 
					 $numero_identificacion = $utilidadesContables -> getNumeroIdentificacionTercero($tercero_id,$Conex);
					 $digito_verificacion   = $utilidadesContables -> getDigitoVerificacionTercero($tercero_id,$Conex);
					 
					 if(!is_numeric($digito_verificacion)) $digito_verificacion = 'NULL';
					
					} 
					 
				 }
				 
				 if(!$utilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
					 $centro_de_costo_id  = 'NULL';
					 $codigo_centro_costo = 'NULL';
				 }
			    if($valor[4]!='') $debito=$valor[4]; else $debito=0;
			    if($valor[5]!='') $credito=$valor[5]; else $credito=0;
				//echo $tercero_id.'<br>';
				$imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);   
				$insert = "INSERT INTO imputacion_contable  (
								imputacion_contable_id,
								tercero_id,
								numero_identificacion,
								digito_verificacion,
								puc_id,
								descripcion,
								encabezado_registro_id,
								centro_de_costo_id,
								codigo_centro_costo,
								valor,
								debito,
								credito) 
						 VALUES ($imputacion_contable_id,
								 $tercero_id,
								 $numero_identificacion,
								 $digito_verificacion,
								 $puc_id,
								 '".trim($valor[3])."',
								 $encabezado_de_registro_id,
								 $centro_de_costo_id,
								 $codigo_centro_costo,
								 (".$debito."+".$credito."),
								 '$debito',
								 '$credito'
								 );"; 
				$this -> query($insert,$Conex,true);
				
				if($this -> GetNumError() > 0){
				 $this -> Rollback($Conex);	
				 return false;
				}
			//}else{
			  //exit('Al parecer el archivo tiene registros incorrectos o con formulas internas');	
			}
	     }
		 
	     $this -> Commit($Conex);		 
  	     return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));	   
	   
	   }else{
		  $this -> Rollback($Conex);
		  return false;		   
	   }
  }
  
  public function registroTieneMovimientos($encabezado_registro_id,$Conex){
  
     $select      = "SELECT COUNT(*) AS movimientos FROM imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id ";
	 $result      = $this -> DbFetchAll($select,$Conex,true);
	 $movimientos = $result[0]['movimientos'];
	 
	 if($movimientos > 0){
	   return true;
	 }else{
	    return false;
	   }
  
  }  
  
  public function registroTieneSumasIguales($encabezado_registro_id,$Conex){
  
     $select = "SELECT ABS(SUM(debito-credito)) AS saldo FROM imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id ";
	 $result = $this -> DbFetchAll($select,$Conex,true);
	 $saldo  = $result[0]['saldo'];
	 
	 if($saldo > 0){
	   return false;
	 }else{
	    return true;
	   }
  
  }  
  public function Update($dir_file,$Campos,$Conex){
    include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 
	    
	$this -> Begin($Conex);
	
	  $fechaMes                  = substr($this -> requestData("fecha"),0,10);	
	  $oficina_id                = $this -> requestData("oficina_id");
	  $tipo_documento_id 	     = $this -> requestData("tipo_documento_id");
	  $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	  $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	  //$consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);
		
	  $encabezado_registro_id    = $this -> requestData("encabezado_registro_id");
	  
      $this -> assignValRequest('periodo_contable_id',$periodo_contable_id);		
      $this -> assignValRequest('mes_contable_id',$mes_contable_id);		
      //$this -> assignValRequest('consecutivo',$consecutivo);		
		  
      $this -> DbUpdateTable("encabezado_de_registro",$Campos,$Conex,true,false);
	  
	  if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{
	      $update = "UPDATE encabezado_de_registro SET scan_documento='$dir_file' WHERE encabezado_registro_id = $encabezado_registro_id";
		  $this -> query($update,$Conex,true);
	
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}else{
			  $this -> Commit($Conex);	
			}	  		  
	    }
	  	
  } 
  
  
  public function selectEstadoEncabezadoRegistro($encabezado_registro_id,$Conex){
	  
    $select = "SELECT estado FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";	  
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$estado = $result[0]['estado'];
	
	return $estado;	  
	  
  }
  
  public function cancellation($Conex){
	$this -> Begin($Conex);
      $encabezado_registro_id = $this -> requestDataForQuery('encabezado_registro_id','integer');
      $causal_anulacion_id    = $this -> requestDataForQuery('causal_anulacion_id','integer');
      $observaciones          = $this -> requestDataForQuery('observaciones','text');
	
	  $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
      encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
      forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
	  fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
	  $observaciones AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
	
	  $this -> query($insert,$Conex,true);
	
      if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{
	  
	    $insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
		imputacion_contable_anulada_id,tercero_id,puc_id,descripcion,encabezado_registro_id AS 
		encabezado_registro_anulado_id,centro_de_costo_id,numero,valor,amortiza,deprecia,base,debito,credito FROM 
		imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
			   
        $this -> query($insert,$Conex,true);
		
        if(strlen($this -> GetError()) > 0){
		  $this -> Rollback($Conex);
	    }else{	
		
		  $update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = 
		             $encabezado_registro_id";	  
          $this -> query($update,$Conex,true);	
		  
          if(strlen($this -> GetError()) > 0){
		    $this -> Rollback($Conex);
	      }else{	
			
            $update = "UPDATE imputacion_contable SET debito = 0,credito = 0 WHERE encabezado_registro_id=$encabezado_registro_id";
            $this -> query($update,$Conex);			  
			
            if(strlen($this -> GetError()) > 0){
		      $this -> Rollback($Conex);
	        }else{		
               $this -> Commit($Conex);			
			  }
		  
		    }
		  
		  }
	   }

  }
  
  public function getTotalDebitoCredito($encabezado_registro_id,$Conex){
	  
	  $select = "SELECT SUM(debito) AS debito,SUM(credito) AS credito FROM imputacion_contable WHERE encabezado_registro_id = 
	             $encabezado_registro_id";
      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result; 
	  
  }

//LISTA MENU
   public function getEmpresas($usuario_id,$Conex){
   
     $select = "SELECT e.empresa_id AS value,
	 CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS text FROM empresa e,tercero t 
	 WHERE t.tercero_id = e.tercero_id AND e.empresa_id IN (SELECT empresa_id FROM empresa WHERE empresa_id IN (SELECT empresa_id FROM 
	 opciones_actividad WHERE usuario_id = $usuario_id))";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;
   
   }     
   
	public function getPeriodosContables($Conex){
		
    $select = "SELECT periodo_contable_id AS value,anio AS text FROM periodo_contable ORDER BY anio ASC";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;		
		
    }
	
	public function getTiposDocumento($Conex){
		
     $select = "SELECT tipo_documento_id AS value,CONCAT(codigo,' - ',nombre) AS text FROM tipo_de_documento ORDER BY codigo ASC";
	 
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);    
	 
	 return $result;		
		
    }
	
	public function getFormasPago($Conex){
		
		$select = "SELECT forma_pago_id AS value,nombre AS text FROM forma_pago ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
		
	}
	
	public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;		
		
    }
	
	public function getTitulosDocumento($tipo_documento_id,$Conex){
		
		$select = "SELECT * FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id";
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
		
    }
	
	public function getEncabezadoRegistro($encabezado_registro_id,$Conex){
				
        $select = "SELECT e.*,(SELECT CONCAT_WS(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = e.empresa_id)) AS empresa,(SELECT concat(codigo_centro,' - ',nombre) FROM oficina WHERE oficina_id = e.oficina_id) AS oficina,(SELECT IF(razon_social IS NULL,CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido),razon_social) FROM tercero WHERE tercero_id = e.tercero_id) AS tercero,
		
		(SELECT numero_identificacion FROM tercero WHERE tercero_id = e.tercero_id) AS identificacion,
		
		(SELECT telefono FROM tercero WHERE tercero_id = e.tercero_id) AS telefono,
		
		(SELECT CONCAT(codigo_puc,'-',nombre) FROM puc WHERE puc_id = e.puc_id) AS puc,(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS documento,(SELECT nombre FROM forma_pago WHERE forma_pago_id = e.forma_pago_id) AS forma_pago,(SELECT texto_soporte FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS texto_soporte,(SELECT texto_tercero FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS texto_tercero FROM encabezado_de_registro e WHERE encabezado_registro_id = $encabezado_registro_id";
		
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
		
    }
	
	public function getEncabezadoRegistroAnulado($encabezado_registro_id,$Conex){
				
        $select = "SELECT e.*,(SELECT CONCAT_WS(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = e.empresa_id)) AS empresa,(SELECT concat(codigo_centro,' - ',nombre) FROM oficina WHERE oficina_id = e.oficina_id) AS oficina,(SELECT CONCAT(numero_identificacion,'-',IF(razon_social IS NULL,CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido),razon_social)) FROM tercero WHERE tercero_id = e.tercero_id) AS tercero,(SELECT CONCAT(codigo_puc,'-',nombre) FROM puc WHERE puc_id = e.puc_id) AS puc,(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS documento,(SELECT nombre FROM forma_pago WHERE forma_pago_id = e.forma_pago_id) AS forma_pago,(SELECT texto_soporte FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS texto_soporte,(SELECT texto_tercero FROM tipo_de_documento WHERE tipo_documento_id = e.tipo_documento_id) AS texto_tercero FROM encabezado_de_registro_anulado e WHERE encabezado_registro_id = $encabezado_registro_id";
		
		$result = $this -> DbFetchAll($select,$Conex,true);
		
		return $result;
		
    } 	

   
}
?>