<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");
final class MovimientosContablesModel extends Db{
  private $mes_contable_id;
  private $periodo_contable_id; 
  
  public function getTerceroModifica($usuario_id,$Conex){
	   
	   $select = "SELECT tercero_id FROM usuario WHERE usuario_id = $usuario_id";
	   $result = $this -> DbFetchAll($select,$Conex,true);
	   
	   return $result[0]['tercero_id'];
   }
   
   public function getUsuarioModifica($usuario_id,$Conex){
	   
	   $select = "SELECT CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido,'-',numero_identificacion) AS usuario FROM tercero 
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
  
  public function generarExcel($encabezado_registro_id,$Conex){
	   	
	if(is_numeric($encabezado_registro_id)){
	
	
	  $select  = "SELECT (SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,
	  (SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = i.tercero_id ) AS nombre,
	  (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,(SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo,i.descripcion, FLOOR((i.debito*1)) as debito,  FLOOR((i.credito*1))as credito FROM imputacion_contable i WHERE encabezado_registro_id = $encabezado_registro_id";
	
	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	  }
	
	return $result;
  
  }																 
     
  public function Save($dir_file,$oficina_id,$usuario,$usuario_id,$Campos,$Conex){  
	
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
	
      $this -> assignValRequest('fecha_registro',date("Y-m-d H:i:s"));	
      $this -> assignValRequest('encabezado_registro_id',$encabezado_de_registro_id);		
      $this -> assignValRequest('periodo_contable_id',$periodo_contable_id);		
      $this -> assignValRequest('mes_contable_id',$mes_contable_id);		
      $this -> assignValRequest('consecutivo',$consecutivo);		
      $this -> assignValRequest('anulado','0');			  
      $this -> assignValRequest('modifica',$usuario);		
	  $this -> assignValRequest('usuario_id',$usuario_id);		
      $this -> DbInsertTable("encabezado_de_registro",$Campos,$Conex,true,false);
	
	  if(!strlen(trim($this -> GetError())) > 0){
	   
		 $update = "UPDATE encabezado_de_registro SET scan_documento='$dir_file' WHERE encabezado_registro_id = $encabezado_de_registro_id";
		  $this -> query($update,$Conex,true);
	
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
			}

	  
	   $puc_id        = $this -> requestData('puc_id');
	   $tercero_id    = $this -> requestData('tercero_id');	 
	   $forma_pago_id = $this -> requestData('forma_pago_id');	  
	   $valor         = $this -> requestData('valor');	  	   
	   
	   if(is_numeric($puc_id)){
	   
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
		 
		 if($utilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
		 
		    $centro_de_costo_id  = $utilidadesContables -> getCentroCostoId($oficina_id,$Conex);
			$codigo_centro_costo = $utilidadesContables -> getCentroCostoCod($oficina_id,$Conex);
		   
		 }else{
		     $centro_de_costo_id  = 'NULL';
			 $codigo_centro_costo = 'NULL';
		   }
		   
		 if(($utilidadesContables -> requiereTercero($puc_id,$Conex) && !is_numeric($tercero_id)) || ($utilidadesContables -> requiereCentroCosto($puc_id,$Conex) && 
		    !is_numeric($centro_de_costo_id))){
			
	        $this -> Commit($Conex);		 
  	        return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));			
			
		 }else{
		 
             $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);		 
			 $descripcion            = $this -> requestData('concepto');
			 $naturaleza             = $utilidadesContables -> getNaturalezaTipoPago($forma_pago_id,$puc_id,$Conex);
			 
			 if($naturaleza != null){
		 
		       if($naturaleza == 'D'){
			     $debito  = $valor;
				 $credito = 0;
			   }else{
			       $debito  = 0;
			       $credito = $valor;
			     }
		 
		       $base = 'NULL';
			   		 
               $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,encabezado_registro_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,descripcion,base,debito,credito) 
	                    VALUES ($imputacion_contable_id,$encabezado_de_registro_id,$puc_id,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_de_costo_id,$codigo_centro_costo,'$descripcion',$base,$debito,$credito)";		 
						
               $this -> query($insert,$Conex,true);	   						
			 
			 }
			 
	         $this -> Commit($Conex);		 
  	         return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));			 
		 
		   }  
	   	
	  
	   }else{
	   
	      $this -> Commit($Conex);		 
  	      return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));	   
	   
	     }
	  
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
public function Update($dir_file,$Campos,$usuario,$usuario_id,$Conex){
	include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
	
	$utilidadesContables = new UtilidadesContablesModel(); 
			
	$this -> Begin($Conex);
	
	  $fechaMes                  = substr($this -> requestData("fecha"),0,10);	
	  $oficina_id                = $this -> requestData("oficina_id");
	  $tipo_documento_id 	     = $this -> requestData("tipo_documento_id");
	  $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	  $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	  
	   // inicio fragmento restricciones
	  $encabezado_registro_id    = $this -> requestData("encabezado_registro_id");
	  $select1 = "SELECT oficina_id, tipo_documento_id, id_documento_fuente FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";	  
	  $result1 = $this -> DbFetchAll($select1,$Conex,true); 
	  
	  if($result1[0]['oficina_id']!=$oficina_id){
		  return 1;
	  }
	
	  if($result1[0]['tipo_documento_id']!=$tipo_documento_id){
		  return 2;
	  } 
		  
	  //if($result1[0][id_documento_fuente]!='') exit('No se puede Editar el documento Contable,<br> Esto debido a que proviene de un modulo<br> Por favor Verifique');
	  // fin fragmento restricciones
		
      $this -> assignValRequest('periodo_contable_id',$periodo_contable_id);	
	  $this -> assignValRequest('anulado',0);	
      $this -> assignValRequest('mes_contable_id',$mes_contable_id);		
	  $this->assignValRequest('modifica', $usuario);
	  $this->assignValRequest('usuario_id', $usuario_id);
  
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
  
  
  public function cancellation($Conex,$usuario_id){
	//inicio fragmento para saber si viene de otro modulo
	$encabezado_registro_id = $this -> requestDataForQuery('encabezado_registro_id','integer');
    $select = "SELECT id_documento_fuente,DATABASE() AS db FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
    $result = $this -> DbFetchAll($select,$Conex,true);
  
    $select_COLUMN_encabezado_registro_id  = "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
	WHERE COLUMN_NAME = 'encabezado_registro_id' AND TABLE_SCHEMA = "."'".$result[0][db]."'";
	

	$result_COLUMN = $this -> DbFetchAll($select_COLUMN_encabezado_registro_id,$Conex,true);

$array_modulo =array("../../../facturacion/pago/clases/PagoClass.php" => abono_factura,"../../../proveedores/pago/clases/PagoClass.php" => abono_factura_proveedor,"Nomina" => abono_nomina,"../../../transporte/operacion/clases/AnticiposClass.php?rand=1" => anticipos_despacho,"../../../transporte/operacion/clases/AnticiposClass.php?rand=2" => anticipos_manifiesto,"../../../transporte/operacion/clases/AnticiposClass.php?rand=3" => anticipos_particular,"../../../transporte/operacion/clases/AnticiposClass.php?rand=4" => anticipos_particular2,"../../../transporte/operacion/clases/CierreContadoClass.php" => cierre_contado,"Comisiones" => comisiones,"../../../transporte/operacion/clases/DespachosUrbanosClass.php" => despachos_urbanos,"Activos Fijos" => entrada_activo,"../../../facturacion/factura/clases/FacturaClass.php" => factura,"Facturacion Pos" => factura_pos,"../../../proveedores/causar/clases/CausarClass.php" => factura_proveedor,"../../../transporte/operacion/clases/LegalizacionClass.php" => legalizacion_manifiesto,"../../../transporte/operacion/clases/LegalizacionDespachosClass.php" => legalizacion_despacho,"../../../transporte/operacion/clases/LegalizacionParticularesClass.php" => legalizacion_particular,"../../../nomina/movimientos/clases/CesantiasClass.php" => liquidacion_cesantias,"../../../nomina/movimientos/clases/LiquidacionFinalClass.php" => liquidacion_definitiva,"../../../transporte/operacion/clases/LiquidacionDescuClass.php" => liquidacion_despacho,"../../../transporte/operacion/clases/LiquidacionDescuDespaClass.php" => liquidacion_despacho_descu,"transporte" => liquidacion_despacho_sobre,"../../../nomina/movimientos/clases/RegistrarClass.php?rand=1" => liquidacion_novedad,"../../../nomina/movimientos/clases/PatronalesClass.php" => liquidacion_patronal,"../../../nomina/movimientos/clases/PrimaClass.php" => liquidacion_prima,"../../../nomina/movimientos/clases/ProvisionesClass.php" => liquidacion_provision,"../../../nomina/movimientos/clases/VacacionClass.php" => liquidacion_vacaciones,"../../../transporte/operacion/clases/ManifiestosClass.php" => manifiesto,"../../../nomina/movimientos/clases/NovedadClass.php" => novedad_fija,"../../../tesoreria/movimientos/clases/PlantillaTesoreriaClass.php" => plantilla_tesoreria,"Activos Fijos" => salida_activo,"Activos Fijos" => valorizacion_activo,"../../../transporte/operacion/clases/RemesasContadoClass.php" => remesa,"../../../nomina/movimientos/clases/RegistrarClass.php?rand=2" => liquidacion_nomina);
	
for ($i=0; $i < mysqli_num_rows(mysqli_query($Conex['conex'],$select_COLUMN_encabezado_registro_id)) ; $i++) { 

		$tabla = $result_COLUMN[$i][TABLE_NAME];

		$select_encabezado_registro_id = "SELECT encabezado_registro_id FROM $tabla WHERE encabezado_registro_id = $encabezado_registro_id";

		$result_encabezado_registro_id = $this -> DbFetchAll($select_encabezado_registro_id,$Conex,true);

		if($result_encabezado_registro_id[0][encabezado_registro_id] > 0 &&  $result_COLUMN[$i][TABLE_NAME]!= 'encabezado_de_registro' &&  $result_COLUMN[$i][TABLE_NAME]!= 'imputacion_contable' && $result_COLUMN[$i][TABLE_NAME]!= 'encabezado_de_registro'){

			foreach($array_modulo as $nombre_modulo => $nombre_tabla ){

				if($nombre_tabla == $tabla){
					//die($nombre_modulo."<br> nombre tabla :".$nombre_tabla);
					$modulo= $nombre_modulo;

				}

			}

			break;

		}
	}

	if($result[0][id_documento_fuente]>0 && $modulo != '' ){ exit("Este Registro Contable fue generado desde <a href = '$modulo' target=_blank> FORMULARIO</a>\n\nPor favor realice la anulaci&oacute;n desde el respectivo m&oacute;dulo"); } 
	//fin fragmento para saber si viene de otro modulo

	$this -> Begin($Conex);
      $encabezado_registro_id = $this -> requestDataForQuery('encabezado_registro_id','integer');
      $causal_anulacion_id    = $this -> requestDataForQuery('causal_anulacion_id','integer');
      $observaciones          = $this -> requestDataForQuery('observaciones','text');
	
	  $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
      encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
      forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
	  fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
	  $observaciones AS observaciones,$usuario_id AS usuario_anula, NOW() AS fecha_anulacion, usuario_actualiza, fecha_actualiza  FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
	
	  $this -> query($insert,$Conex,true);
	
      if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	  }else{
	  
	    $insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
		imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
		encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,
		area_id,departamento_id,unidad_negocio_id,sucursal_id FROM 
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
	
	public function getModulo($encabezado_registro_id,$Conex){
	
    $select = "SELECT DATABASE() AS db FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
	
    $result = $this -> DbFetchAll($select,$Conex,true);
  
    $select_COLUMN_encabezado_registro_id  = "SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
	WHERE COLUMN_NAME = 'encabezado_registro_id' AND TABLE_SCHEMA = "."'".$result[0][db]."'";

	$result_COLUMN = $this -> DbFetchAll($select_COLUMN_encabezado_registro_id,$Conex,true);
	
	$array_modulo['FACTURACION'][0]='abono_factura';
	$array_modulo['FACTURACION'][1]='factura';
	$array_modulo['FACTURACION'][2]='nota_debito';
	$array_modulo['PROVEEDORES'][0]='abono_factura_proveedor';
	$array_modulo['PROVEEDORES'][1]='factura_proveedor';
	$array_modulo['NOMINA'][0]     ='abono_nomina';
	$array_modulo['NOMINA'][1]     ='liquidacion_cesantias';
	$array_modulo['NOMINA'][2]     ='liquidacion_definitiva';
	$array_modulo['NOMINA'][3]     ='liquidacion_novedad';
	$array_modulo['NOMINA'][4]     ='liquidacion_patronal';
	$array_modulo['NOMINA'][5]     ='liquidacion_prima';
	$array_modulo['NOMINA'][6]     ='liquidacion_provision';
	$array_modulo['NOMINA'][7]     ='liquidacion_vacaciones';
	$array_modulo['NOMINA'][8]     ='novedad_fija';
	$array_modulo['NOMINA'][9]     ='liquidacion_nomina';
	$array_modulo['TRANSPORTE'][0] ='anticipos_despacho';
	$array_modulo['TRANSPORTE'][1] ='anticipos_manifiesto';
	$array_modulo['TRANSPORTE'][2] ='anticipos_particular';
	$array_modulo['TRANSPORTE'][3] ='anticipos_particular2';
	$array_modulo['TRANSPORTE'][4] ='cierre_contado';
	$array_modulo['TRANSPORTE'][5] ='despachos_urbanos';
	$array_modulo['TRANSPORTE'][6] ='legalizacion_manifiesto';
	$array_modulo['TRANSPORTE'][7] ='legalizacion_despacho';
	$array_modulo['TRANSPORTE'][8] ='legalizacion_particular';
	$array_modulo['TRANSPORTE'][9] ='liquidacion_despacho';
	$array_modulo['TRANSPORTE'][10]='liquidacion_despacho_descu';
	$array_modulo['TRANSPORTE'][11]='liquidacion_despacho_sobre';
	$array_modulo['TRANSPORTE'][12]='remesa';
	$array_modulo['Comisiones'][0] ='comisiones';
	$array_modulo['Facturacion Pos'][0]  ='factura_pos';
	$array_modulo['TESORERIA'][0]        ='plantilla_tesoreria';
	$array_modulo['Activos Fijos'][0]    ='salida_activo';
	$array_modulo['Activos Fijos'][1]    ='valorizacion_activo';
	$array_modulo['Activos Fijos'][2]    ='entrada_activo';
	$array_modulo['CONTABILIDAD'][0]     ='imputacion_contable_nivel4';
	
	for ($i=0; $i < mysqli_num_rows(mysqli_query($Conex['conex'],$select_COLUMN_encabezado_registro_id)) ; $i++) { 

		$tabla = $result_COLUMN[$i][TABLE_NAME];

		$select_encabezado_registro_id = "SELECT encabezado_registro_id FROM $tabla WHERE encabezado_registro_id = $encabezado_registro_id";

		$result_encabezado_registro_id = $this -> DbFetchAll($select_encabezado_registro_id,$Conex,true);

		if($result_encabezado_registro_id[0][encabezado_registro_id] > 0 &&  $result_COLUMN[$i][TABLE_NAME]!= 'encabezado_de_registro' &&  $result_COLUMN[$i][TABLE_NAME]!= 'imputacion_contable' && $result_COLUMN[$i][TABLE_NAME]!= 'encabezado_de_registro_anulado' && $result_COLUMN[$i][TABLE_NAME]!= 'imputacion_contable_anulada'){

			foreach($array_modulo as $nombre_modulo => $nombre_tabla ){
				
				/* $prueba = $prueba.'<br> base de datos : '.$tabla.'------ Modulo : '.$nombre_modulo.' -- cantidad de tablas :'.count($array_modulo[$nombre_modulo]);  */

				for ($i=0; $i < count($array_modulo[$nombre_modulo]); $i++) { 
																			 
					
					//$prueba = $prueba.'<br> base de datos : '.$array_modulo[$nombre_modulo][$i].' -- tabla :'.$tabla; 
					if($array_modulo[$nombre_modulo][$i] == $tabla){

						$modulo= $nombre_modulo;
	
					}													 
					
				}

			}

			break;

		}
	}
	

	return $modulo;

	}
	
	public function getEncabezadoRegistro($encabezado_registro_id,$Conex){
		
		$modulo = $this ->getModulo($encabezado_registro_id,$Conex);
				
        $select = "SELECT e.*,(SELECT CONCAT_WS(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = e.empresa_id)) AS empresa,(SELECT concat(codigo_centro,' - ',nombre) FROM oficina WHERE oficina_id = e.oficina_id) AS oficina,(SELECT IF(razon_social IS NULL,CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido),razon_social) FROM tercero WHERE tercero_id = e.tercero_id) AS tercero,
		
		(SELECT numero_identificacion FROM tercero WHERE tercero_id = e.tercero_id) AS identificacion,
		
		(SELECT telefono FROM tercero WHERE tercero_id = e.tercero_id) AS telefono,
		
		'$modulo' AS modulo,
		
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