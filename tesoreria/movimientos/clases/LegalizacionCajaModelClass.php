<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LegalizacionCajaModel extends Db{
  
  public function selectCostosDeLegalizacion($empresa_id,$oficina_id,$Conex){  
     $select = "SELECT d.* FROM parametros_legalizacion_caja p,detalle_parametros_legalizacion_caja d WHERE p.empresa_id = $empresa_id AND 
	 p.oficina_id = $oficina_id AND p.parametros_legalizacion_caja_id = d.parametros_legalizacion_caja_id ORDER BY nombre_cuenta ASC";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 return $result;  
  }
  
  public function selectCentroCosto($empresa_id,$Conex){  
     $select = "SELECT centro_de_costo_id, nombre FROM centro_de_costo WHERE empresa_id = $empresa_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 return $result;  
  }  
  
  public function tope($legalizacion_caja_id,$fecha_legalizacion,$total_costos_legalizacion_caja,$oficina_id,$Conex){  
     $select = "SELECT ((valor*porcentaje)/100) AS tope FROM tope_reembolso WHERE '$fecha_legalizacion' BETWEEN fecha_inicio AND fecha_final AND oficina_id = $oficina_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 $tope = $result[0]['tope'];
	
		if($total_costos_legalizacion_caja <= $tope){
		    	return 'SI';	
			}else{				
				return 'Ha sobre pasado el tope por $'.($total_costos_legalizacion_caja-$tope).' , Borre el ultimo registro para poder guardar y legalizar.';
		     }		 	 
  }
  
  public function selectEstadoEncabezadoRegistro($legalizacion_caja_id,$Conex){ 
    $select = "SELECT estado_legalizacion FROM legalizacion_caja WHERE legalizacion_caja_id = $legalizacion_caja_id";	  
	$result = $this -> DbFetchAll($select,$Conex); 
	$estado = $result[0]['estado_legalizacion'];	
    return $estado;
  }      

  public function Save($Campos,$empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){	
  
    $consulta = "SELECT legalizacion_caja_id AS id FROM legalizacion_caja WHERE oficina_id = $oficina_id  
	AND estado_legalizacion = 'E'";
	$condicion = $this  -> DbFetchAll($consulta,$Conex,true);
	
	$validacion = $condicion[0]['id'];

	if($validacion > 0){
	exit ("No se puede guardar, ya existe una legalizacion en Edicion");
	}else{	
	
	$legalizacion_caja_id = $this -> DbgetMaxConsecutive("legalizacion_caja","legalizacion_caja_id",$Conex,false,1);	

    $consulta1 = "SELECT tipo_documento_id FROM parametros_legalizacion_caja WHERE oficina_id = $oficina_id  AND empresa_id = $empresa_id";
	$parame = $this  -> DbFetchAll($consulta1,$Conex,true);

    $this -> assignValRequest('estado_legalizacion','E');  
	$this -> Begin($Conex);	
	$this -> assignValRequest('legalizacion_caja_id',$legalizacion_caja_id);	
	$this -> assignValRequest('tipo_documento_id',$parame[0][tipo_documento_id]);	
	$this -> DbInsertTable("legalizacion_caja",$Campos,$Conex,true,false);
	
	if($this -> GetNumError() > 0){
		return false;
	}else{
		
		if(is_array($_REQUEST['costos_legalizacion_caja'])){
		
			$_REQUEST['costos_legalizacion_caja'] = array_values($_REQUEST['costos_legalizacion_caja']);
			
			for($i = 0; $i < count($_REQUEST['costos_legalizacion_caja']); $i++){
			
				$costos_legalizacion_caja_id  				= $this->DbgetMaxConsecutive("costos_legalizacion_caja","costos_legalizacion_caja_id",$Conex,false,1);	
				$detalle_parametros_legalizacion_caja_id 	= $_REQUEST['costos_legalizacion_caja'][$i]['d_p_l_c_id'];				  
				$tercero_id                         		= $_REQUEST['costos_legalizacion_caja'][$i]['tercero_id'];
				$centro_de_costo_id                         = $_REQUEST['costos_legalizacion_caja'][$i]['cc_id'];
				$detalle_costo                         		= $_REQUEST['costos_legalizacion_caja'][$i]['det_c'];
				$fecha                         				= $_REQUEST['costos_legalizacion_caja'][$i]['fe'];
				$fecha										= $fecha !='' ? "'".$fecha."'" : 'NULL';
				
				$select = "SELECT CONCAT_WS('',numero_identificacion,digito_verificacion,'-', primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido,
				razon_social) as tercero  FROM tercero WHERE tercero_id = $tercero_id";
				$data_tercero 	= $this  -> DbFetchAll($select,$Conex,true);						
				$tercero       = $data_tercero[0]['tercero'];
				$valor			= $this -> removeFormatCurrency($_REQUEST['costos_legalizacion_caja'][$i]['valor']);
				
				if($valor>0 && $tercero_id>0 && $detalle_parametros_legalizacion_caja_id>0){ 
				
				$insert = "INSERT INTO costos_legalizacion_caja (costos_legalizacion_caja_id,detalle_parametros_legalizacion_caja_id,tercero,tercero_id,valor,legalizacion_caja_id,
				centro_de_costo_id,detalle_costo,fecha) 
				VALUES ($costos_legalizacion_caja_id,$detalle_parametros_legalizacion_caja_id,'$tercero',$tercero_id,$valor,$legalizacion_caja_id,$centro_de_costo_id,'$detalle_costo',$fecha)";
					
					$this -> query($insert,$Conex,true);
					
					if($this -> GetNumError() > 0){
						return false;
					}			  
				}
			}			  
		}
   }
  
  $this -> Commit($Conex);
	}
 }   
	
  public function Update($Campos,$empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){	
		 
	$legalizacion_caja_id = $this -> requestData('legalizacion_caja_id');
	
	$this -> assignValRequest('estado_legalizacion','E');	
	$this -> Begin($Conex);
    $this -> DbUpdateTable("legalizacion_caja",$Campos,$Conex,true,false);
	
	if($this -> GetNumError() > 0){
			return false;
	 }else{		
		      $delete = "DELETE FROM costos_legalizacion_caja WHERE legalizacion_caja_id = $legalizacion_caja_id";
			  $this -> query($delete,$Conex,true);		
		
			  if(is_array($_REQUEST['costos_legalizacion_caja'])){
			  
			   $_REQUEST['costos_legalizacion_caja'] = array_values($_REQUEST['costos_legalizacion_caja']);

               for($i = 0; $i < count($_REQUEST['costos_legalizacion_caja']); $i++){
								
				 $costos_legalizacion_caja_id	= $this->DbgetMaxConsecutive("costos_legalizacion_caja","costos_legalizacion_caja_id",$Conex,false,1);	
				 $detalle_parametros_legalizacion_caja_id	= $_REQUEST['costos_legalizacion_caja'][$i]['d_p_l_c_id'];				  
				 $tercero_id			= $_REQUEST['costos_legalizacion_caja'][$i]['tercero_id'];
				 $centro_de_costo_id	= $_REQUEST['costos_legalizacion_caja'][$i]['cc_id'];
				 $detalle_costo			= $_REQUEST['costos_legalizacion_caja'][$i]['det_c'];	
				 $fecha                 = $_REQUEST['costos_legalizacion_caja'][$i]['fe'];
 				 $fecha					= $fecha !='' ? "'".$fecha."'" : 'NULL';

				 $select = "SELECT CONCAT_WS('',numero_identificacion,digito_verificacion,'-',primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',
				 segundo_apellido,razon_social) as tercero FROM tercero WHERE tercero_id = $tercero_id";
				 $data_tercero = $this  -> DbFetchAll($select,$Conex,true);						
				 $tercero      = $data_tercero[0]['tercero'];
				 
				 $valor		= $this -> removeFormatCurrency($_REQUEST['costos_legalizacion_caja'][$i]['valor']);
				 if($valor>0 && $tercero_id>0 && $detalle_parametros_legalizacion_caja_id>0){ 
					 $insert = "INSERT INTO costos_legalizacion_caja (costos_legalizacion_caja_id,detalle_parametros_legalizacion_caja_id,tercero,tercero_id,valor,
					 legalizacion_caja_id,centro_de_costo_id,detalle_costo,fecha) VALUES
					 ($costos_legalizacion_caja_id,$detalle_parametros_legalizacion_caja_id,'$tercero',$tercero_id,$valor,$legalizacion_caja_id,
					 $centro_de_costo_id,'$detalle_costo',$fecha)";					  
					 $this -> query($insert,$Conex,true);
						
					  if($this -> GetNumError() > 0){
						return false;
					  }			  
				    }
			      }	
			  }			
		}
								
    $this -> Commit($Conex);		
  }
  
  public function legalizar($empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){
  
	$this -> Begin($Conex);
	
	require_once("UtilidadesContablesModelClass.php");	
	$UtilidadesContables = new UtilidadesContablesModel();    
	
	$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,false,1);		
	$legalizacion_caja_id	= $this -> requestData('legalizacion_caja_id');
	//$fecha					= $this -> requestData('fecha_legalizacion');      
	$fecha					= date("Y-m-d");      
	$fecha_registro			= date("Y-m-d");
	//$fecha_registro		    = $this -> requestData('fecha_legalizacion');

	$total_costos_legalizacion_caja = 0;
	$totalDebito    = 0;
	$totalCredito   = 0;	

	$select_com = "SELECT encabezado_registro_id FROM legalizacion_caja WHERE legalizacion_caja_id = $legalizacion_caja_id";
	$result_com = $this  -> DbFetchAll($select_com,$Conex,true);   
	if($result_com[0]['encabezado_registro_id']>0){
		exit('La legalizacion ya esta Contabilizada o esta en el proceso');
	}

	$tercero                = "SELECT tercero_id FROM empresa WHERE empresa_id = $empresa_id"; 
	$result_tercero			= $this  -> DbFetchAll($tercero,$Conex,true);   
	$tercero_id 			= $result_tercero[0]['tercero_id'];	
	
	$select = "SELECT * FROM parametros_legalizacion_caja WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
	$result = $this  -> DbFetchAll($select,$Conex,true);   
	$tipo_documento_id = $result[0]['tipo_documento_id'];
	
	$select1 = "SELECT descripcion FROM legalizacion_caja WHERE legalizacion_caja_id = $legalizacion_caja_id";
	$result1 = $this  -> DbFetchAll($select1,$Conex,true);   
	$concepto = $result1[0]['descripcion'];	

    $numeroidentificacion  = "SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id = $tercero_id";
	$identificacion 		 = $this  -> DbFetchAll($numeroidentificacion,$Conex,true);						
	$numero_identificacion = $identificacion[0]['numero_identificacion'];
	$digito_verificacion   = $identificacion[0]['digito_verificacion'];	
	
	$estado                  = 'C';
	
	$periodo_contable_id = $UtilidadesContables -> getPeriodoContableId($fecha,$Conex); 
	$mes_contable_id     = $UtilidadesContables -> getMesContableId($fecha,$periodo_contable_id,$Conex); 
	$consecutivoRegistro = $UtilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);
	
	$valor = 0;
	
	$insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id, empresa_id, oficina_id, tipo_documento_id, valor, tercero_id, periodo_contable_id, mes_contable_id,
	consecutivo, fecha, concepto, estado, fecha_registro, modifica, usuario_id) 
	VALUES ($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$valor,$tercero_id,$periodo_contable_id,$mes_contable_id,$consecutivoRegistro,'$fecha','$concepto',
	'$estado','$fecha_registro','$modifica',$usuario_id)";

    $this -> query($insert,$Conex,true);   
	$update = "UPDATE legalizacion_caja SET  encabezado_registro_id = $encabezado_registro_id WHERE legalizacion_caja_id = $legalizacion_caja_id";   
	$this -> query($update,$Conex,true);		   
   
	if(!$this -> GetNumError() > 0){
   
	  $select = "SELECT * FROM parametros_legalizacion_caja WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
	  $result = $this  -> DbFetchAll($select,$Conex,true);					
	  
	  $parametros_legalizacion_caja_id	= $result[0]['parametros_legalizacion_caja_id'];
	  $cuenta_puc_id               		= $result[0]['contrapartida_id'];
	  $base                             = 0;
	  $naturaleza_contrapartida         = $result[0]['naturaleza_contrapartida'];		   		   
	  
	  $total_costos_legalizacion_caja = 0;
		  
		  if(is_array($_REQUEST['costos_legalizacion_caja'])){						  

			for($i = 0; $i < count($_REQUEST['costos_legalizacion_caja']); $i++){				  
							  
			 $detalle_parametros_legalizacion_caja_id = $_REQUEST['costos_legalizacion_caja'][$i]['d_p_l_c_id'];				  				  				      
			 $imputacion_contable_id  = $this->DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);							  
			 $select  = "SELECT * FROM detalle_parametros_legalizacion_caja WHERE detalle_parametros_legalizacion_caja_id = $detalle_parametros_legalizacion_caja_id";
			 $result  = $this  -> DbFetchAll($select,$Conex,true);
			  
			 $puc_id        = $result[0]['puc_id'];
			 $naturaleza    = $result[0]['naturaleza'];
			 $nombre_cuenta = $result[0]['nombre_cuenta']; 					  
			 $tercero_lega_id    = $_REQUEST['costos_legalizacion_caja'][$i]['tercero_id'];
			 $descripcion_det    = $_REQUEST['costos_legalizacion_caja'][$i]['det_c'];
			 if($_REQUEST['costos_legalizacion_caja'][$i]['fe']!='') $descripcion_det=$descripcion_det.' - Fecha: '.$_REQUEST['costos_legalizacion_caja'][$i]['fe'];
			 $base			= 0;
			 $valor		    = $this -> removeFormatCurrency($_REQUEST['costos_legalizacion_caja'][$i]['valor']);
	  
	  		if ($puc_id > 0 && $tercero_lega_id >0 && $valor > 0){
	  
			 $select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_id";
			 $result = $this  -> DbFetchAll($select,$Conex,true);			   
			 
			 $centro_de_costo_id      = $result[0]['centro_de_costo_id'];
			 $codigo_centro_costo     = "'".$result[0]['codigo']."'";				  
			  
			  if($naturaleza == 'D'){
				$debito  = $valor;
				$credito = 0;
				
			  }else{
				  $debito  = 0;
				  $credito = $valor;					  
				}
				
			  $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);
               $numeroiden  = "SELECT numero_identificacion,digito_verificacion FROM tercero WHERE tercero_id = $tercero_lega_id";
	           $iden 		  = $this  -> DbFetchAll($numeroidentificacion,$Conex,true);						
	           $numero_iden = $iden[0]['numero_identificacion'];
	           $digito_veri = $iden[0]['digito_verificacion'];			  
			  
			 if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){
			 
			  $tercero_imputacion_id            = $tercero_lega_id;					 
			  $numero_identificacion_imputacion = $numero_iden;					 
			  $digito_verificacion_imputacion   = is_numeric($digito_veri) ? $digito_veri : 'NULL';					 
			  
			 }else{
				  $tercero_imputacion_id            = 'NULL';					 
				  $numero_identificacion_imputacion = 'NULL';					 
				  $digito_verificacion_imputacion   = 'NULL';	
			   }  					 
			 
			 if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){						  
					  $centro_de_costo_imputacion_id  = $centro_de_costo_id;
					  $codigo_centro_costo_imputacion = $codigo_centro_costo;									   
			 }else{
				 
				 $centro_de_costo_imputacion_id  = 'NULL';
				 $codigo_centro_costo_imputacion = 'NULL';					 
			   }				   
	
	          $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,
			  centro_de_costo_id,codigo_centro_costo,base,valor,debito,credito,descripcion) 
			  VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$puc_id,$encabezado_registro_id,
			  $centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,$base,$valor,$debito,$credito,'$descripcion_det')";
				
			  $this -> query($insert,$Conex,true);
			 $total_costos_legalizacion_caja += $valor;
			 $totalDebito   += $debito;
			 $totalCredito  += $credito;			
				
			  if($this -> GetNumError() > 0){
				return false;
			  }							
			 } 
			} 		  	  
		  }
		
	 $select = "SELECT * FROM puc WHERE puc_id = $cuenta_puc_id";
	 $result = $this  -> DbFetchAll($select,$Conex,true);			 
	 
	 if(!count($result) > 0){
	   exit("<p align='center'>La cuenta que se utiliza como contrapartida no esta bien configurada<br>Por favor revise : Parametros Legalización!!!</p>");			 
	 }	  
	  
	 $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);		   				
	 $tercero_id             = $tercero_id;
	 $base                   = 0;
	 
	   $valor = $total_costos_legalizacion_caja;
	   
			  if($naturaleza_contrapartida == 'C'){
				$debito  = 0;
				$credito = $total_costos_legalizacion_caja;
				
			  }else{
				  $debito  = $total_costos_legalizacion_caja;
				  $credito = 0;					  
				}		 
	 
	 if($UtilidadesContables -> requiereTercero($cuenta_puc_id,$Conex)){
	 
	  $tercero_imputacion_id            = $tercero_id;					 
	  $numero_identificacion_imputacion = $numero_identificacion;					 
	  $digito_verificacion_imputacion   = is_numeric($digito_verificacion) ? $digito_verificacion : 'NULL';				 
	  
	 }else{
		  $tercero_imputacion_id            = 'NULL';					 
		  $numero_identificacion_imputacion = 'NULL';					 
		  $digito_verificacion_imputacion   = 'NULL';	
	   }  					 
	 
	 if($UtilidadesContables -> requiereCentroCosto($cuenta_puc_id,$Conex)){		 
	   $centro_de_costo_imputacion_id  = $centro_de_costo_id;
	   $codigo_centro_costo_imputacion = $codigo_centro_costo;	   
	 }else{
		 
		 $centro_de_costo_imputacion_id  = 'NULL';
		 $codigo_centro_costo_imputacion = 'NULL';					 
	   }	
	   
			 $totalDebito   += $debito;
			 $totalCredito  += $credito;	   
	   
             $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,
			  centro_de_costo_id,codigo_centro_costo,base,valor,debito,credito,descripcion) 
			  VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$cuenta_puc_id,$encabezado_registro_id,
			  $centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,$base,$valor,$debito,$credito,'$concepto')";					  

    $this -> query($insert,$Conex,true);
				
	  if($this -> GetNumError() > 0){
		return false;
	  }	 
	}	
	
	$update = "UPDATE legalizacion_caja SET estado_legalizacion = 'C', fecha_legalizacion='$fecha' WHERE legalizacion_caja_id = $legalizacion_caja_id";	
    $this -> query($update,$Conex,true);

  // echo $totalDebito.'-'.$totalCredito;
	if($totalDebito == $totalCredito){
	
	   $this -> Commit($Conex);	
	
	   $select2         = "SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id";
       $result2         = $this -> DbFetchAll($select2,$Conex);		
	   $tipo_documento = $result[0]['nombre'];
	
       $arrayResponse = array();
	   $arrayResponse = array(tipo_documento => $tipo_documento, consecutivo => $consecutivoRegistro, legalizacion_caja_id => $legalizacion_caja_id, encabezado_registro_id => $encabezado_registro_id);
	
	
	}else{
	
	   $this -> RollBack($Conex);	
	
       $arrayResponse = array();
	   $arrayResponse = array(error => "<div align='center'>No existen sumas iguales, por favor verifique los parametros de legalizacion</div><div align='center'><br>Por <b>Modulo Tesoreria -> Parametros Modulo -> Parametros Legalizacion</b></div>");
	}

   return $arrayResponse;   
  
  }
	
  public function Delete($Campos,$Conex){  }	
  
  public function cancellation($legalizacion_caja_id,$Conex){	 

	$this -> Begin($Conex);

      $legalizacion_caja_id 		  = $this -> requestDataForQuery('legalizacion_caja_id','integer');
      $causal_anulacion_id  		  = $this -> requestDataForQuery('causal_anulacion_id','integer');
      $anul_legalizacion_caja   	  = $this -> requestDataForQuery('anul_legalizacion_caja','text');
	  $desc_anul_legalizacion_caja    = $this -> requestDataForQuery('desc_anul_legalizacion_caja','text');
	  $anul_usuario_id          	  = $this -> requestDataForQuery('anul_usuario_id','integer');	
	  $anul_oficina_id          	  = $this -> requestDataForQuery('anul_oficina_id','integer');		  
	  
	  $select = "SELECT encabezado_registro_id FROM legalizacion_caja WHERE legalizacion_caja_id=$legalizacion_caja_id";	
	  $result = $this -> DbFetchAll($select,$Conex); 
	  $encabezado_registro_id = $result[0]['encabezado_registro_id'];
	 
	  if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){	 
		  
		  $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		  encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		  forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		  fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		  $desc_anul_legalizacion_caja AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		
		  $this -> query($insert,$Conex,true);
	
		  if(strlen($this -> GetError()) > 0){
		  	$this -> Rollback($Conex);
		  }else{
			$insert = "INSERT INTO imputacion_contable_anulada SELECT imputacion_contable_id AS  
			imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
			encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito FROM 
			imputacion_contable WHERE encabezado_registro_id = $encabezado_registro_id";
			  
			$this -> query($insert,$Conex,true);
			
			if(strlen($this -> GetError()) > 0){
			  $this -> Rollback($Conex);
			}else{	
			
			  $update = "UPDATE encabezado_de_registro SET estado = 'A',anulado = 1 WHERE encabezado_registro_id = $encabezado_registro_id";	  
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
	  
	  $update = "UPDATE legalizacion_caja SET estado_legalizacion= 'A', causal_anulacion_id = $causal_anulacion_id, anul_legalizacion_caja=$anul_legalizacion_caja,
	  desc_anul_legalizacion_caja =$desc_anul_legalizacion_caja,anul_usuario_id=$anul_usuario_id, anul_oficina_id=$anul_oficina_id 
	  WHERE legalizacion_caja_id=$legalizacion_caja_id";	
      $this -> query($update,$Conex);	

	  if(strlen($this -> GetError()) > 0){
	  	$this -> Rollback($Conex);
	  }else{		
      	$this -> Commit($Conex);			
	  }  
  }   
	   
   public function selectLegalizacionCaja($legalizacion_caja_id,$Conex){
	   	   	  
	$dataLegalizacion = array();
    				
    $select = "SELECT l.*, (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=l.encabezado_registro_id) AS numero_documento 
	FROM legalizacion_caja l WHERE legalizacion_caja_id = $legalizacion_caja_id";				
	$result = $this -> DbFetchAll($select,$Conex,true);	
	$dataLegalizacion[0]['legalizacion_caja'] = $result;
	
    $select = "SELECT c.*, CONVERT(c.tercero USING latin1) FROM costos_legalizacion_caja c WHERE c.legalizacion_caja_id = $legalizacion_caja_id";	
	$result = $this -> DbFetchAll($select,$Conex,true);					
	$dataLegalizacion[0]['costos_legalizacion_caja'] = $result;	
	
	return $dataLegalizacion; 		   
   }
   
   public function selectOficinasEmpresa($empresa_id,$oficina_id,$Conex){   
     $select = "SELECT oficina_id AS value,nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	   
     return $result;   
   }
   
  public function getCausalesAnulacion($Conex){	
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex);	
	return $result;		
  }
   
  public function getQueryLegalizacionGrid($oficina_id){  	   
   $Query = "SELECT (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = f.encabezado_registro_id) AS consecutivo, f.fecha_legalizacion, 
	(SELECT nombre FROM oficina WHERE oficina_id = f.oficina_id) AS oficina, f.descripcion,
	CASE f.estado_legalizacion WHEN 'A' THEN 'ANULADA' WHEN 'C' THEN 'CONTABILIZADA' ELSE 'EN EDICION' END AS estado_legalizacion
	FROM legalizacion_caja f WHERE f.oficina_id=$oficina_id ORDER BY f.fecha_legalizacion DESC LIMIT 0,200";		
   return $Query;
   }   

}

?>