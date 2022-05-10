<?php


require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LiquidacionModel extends Db{
  
  public function selectOficinas($empresa_id,$Conex){
  
     $select = "SELECT oficina_id AS value, nombre AS text FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 
	 return $result;
  
  }

  public function anticiposGeneroEgreso($manifiesto,$Conex){  
  
     $select = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM manifiesto 
	            WHERE TRIM(manifiesto) = TRIM('$manifiesto'))";
				
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 	 
	 for($i = 0; $i < count($result); $i++){
	 
	   $encabezado_registro_id = $result[$i]['encabezado_registro_id'];				
	 
	   if(!is_numeric($encabezado_registro_id)){
	     return false;
	   }
	 
	 }
	 
	 return true;
	 
  }   
  
  public function selectManifiesto($manifiesto_id,$Conex){
  
     $select = "SELECT manifiesto_id,manifiesto,tenedor,tenedor_id,placa,placa_id,(SELECT nombre FROM ubicacion 
	 WHERE ubicacion_id = m.origen_id) AS origen,origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,destino_id
	 FROM manifiesto m WHERE manifiesto_id = $manifiesto_id";
	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	
	 return $result;	 
	   
  }
  
  public function selectLiquidacionManifiesto($manifiesto_id,$Conex){
   
     $liquidacion = array();
	 
	 $select = "SELECT valor_flete,valor_neto_pagar,saldo_por_pagar FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
  	 $result = $this  -> DbFetchAll($select,$Conex);
	  
	 $liquidacion[0]['valor_flete']      = $result[0]['valor_flete'];
	 $liquidacion[0]['valor_neto_pagar'] = $result[0]['valor_neto_pagar'];
	 $liquidacion[0]['saldo_por_pagar']  = $result[0]['saldo_por_pagar'];	 	 
	   
     $select = "SELECT * FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){	 
	   $liquidacion[0]['impuestos'] = $result;	 
	 }	 
	 
	 $select = "SELECT dm.*,d.calculo FROM descuentos_manifiesto dm, tabla_descuentos d WHERE dm.manifiesto_id = $manifiesto_id AND dm.descuento_id = d.descuento_id";
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){
	   $liquidacion[0]['descuentos'] = $result;	 	 
	 } 
	 
	 $select = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){
	   $liquidacion[0]['anticipos'] = $result;	 	 
	 } 	 
	
	 return $liquidacion;
  
  }
      
  public function existeLiquidacion($manifiesto_id,$Conex){
  
     $select = "SELECT * FROM liquidacion_despacho WHERE fuente_servicio_cod = 'MC' AND manifiesto_id = $manifiesto_id";
     $result = $this  -> DbFetchAll($select,$Conex,true);	    
	 
	 if(count($result) > 0){
	   return true;
	 }else{
	     return false;
	   }
  
  }
  
  public function getEstadoLiquidacion($manifiesto_id,$Conex){
  
     $select = "SELECT * FROM liquidacion_despacho WHERE fuente_servicio_cod = 'MC' AND manifiesto_id = $manifiesto_id";
     $result = $this  -> DbFetchAll($select,$Conex,true);	   
	 
	 return $result[0]['estado_liquidacion'];
  
  }
  		
  public function Save($Campos,$empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){		
     	
	$this -> Begin($Conex);
	
      require_once("UtilidadesContablesModelClass.php");	
      $UtilidadesContables = new UtilidadesContablesModel();
	  
      $oficina_pago_id = $_REQUEST['oficina_id'];

      $select = "SELECT nombre FROM oficina WHERE oficina_id = $oficina_pago_id";
	  $result = $this  -> DbFetchAll($select,$Conex,true);	
	  
      $LugarPago = $result[0]['nombre'];	  	

	  $liquidacion_despacho_id   = $this -> DbgetMaxConsecutive("liquidacion_despacho","liquidacion_despacho_id",$Conex,false,1);	
	  $centro_de_costo_id        = $UtilidadesContables -> getCentroCostoId($oficina_id,$Conex);
	  $tenedor_id                = $this -> requestData('tenedor_id');
   	  $fecha                     = $this -> requestData('fecha');
	  $numero_despacho           = $this -> requestData('manifiesto');
	  $manifiesto                = $this -> requestData('manifiesto');	  
	  $manifiesto_id             = $this -> requestData('manifiesto_id');
	  $fuente_servicio_cod       = 'MC';
	  $estado_liquidacion        = 'L';
	  	  
	  $select                    = "SELECT oficina_id FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
	  $dataOficinaPlanillo       = $this  -> DbFetchAll($select,$Conex,true);		   	  	  
	  $oficina_planillo_id       = $dataOficinaPlanillo[0]['oficina_id'];
	  
	  if($centro_de_costo_id > 0){
	  	  
	  $select = "SELECT * FROM parametros_liquidacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
	  $result = $this  -> DbFetchAll($select,$Conex,true);		   

	  if(!count($result) > 0){
	    print "<p align='center'>No ha ingresado los parametros de liquidacion!!<br>estos parametros se asignan por Paramtros Modulo -> Liquidacion</p>";
		$this -> RollBack($Conex);
		exit();
	  }else{
	  
    	  $tipo_documento_id          = $result[0]['tipo_documento_id'];
          $flete_pactado_id           = $result[0]['flete_pactado_id'];
		  $naturaleza_flete_pactado   = $result[0]['naturaleza_flete_pactado'];
		  
          $sobre_flete_id             = $result[0]['sobre_flete_id'];
		  $naturaleza_sobre_flete     = $result[0]['naturaleza_sobre_flete'];		  
		  
		  $anticipo_id                = $result[0]['anticipo_id'];
		  $naturaleza_anticipo        = $result[0]['naturaleza_anticipo'];
		  $saldo_por_pagar_id         = $result[0]['saldo_por_pagar_id'];
		  $naturaleza_saldo_por_pagar = $result[0]['naturaleza_saldo_por_pagar']; 
		  $saldo_por_pagar            = 0; 		
		  
		  if(!is_numeric($flete_pactado_id))   exit("<div align='center'>Aun no ha parametrizado la cuenta contable para concepto de flete</div>
 		                                             <div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");
		  if(!is_numeric($sobre_flete_id))     exit("<div align='center'><b>Aun no ha parametrizado la cuenta contable para concepto de sobre flete</b></div>
 		                                             <div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");		  
		  if(!is_numeric($anticipo_id))        exit("<div align='center'><b>Aun no ha parametrizado la cuenta contable para concepto de anticipos</b></div>
 		                                             <div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");		  
		  if(!is_numeric($saldo_por_pagar_id)) exit("<div align='center'><b>Aun no ha parametrizado la cuenta contable para concepto de saldo pagar</b></div>
 		                                             <div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");			  
		  
	      $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)";
	      $result = $this  -> DbFetchAll($select,$Conex,true);			   
	   
	      $tercero_id            = $result[0]['tercero_id'];
		  $numero_identificacion = strlen(trim($result[0]['numero_identificacion'])) > 0 ? $result[0]['numero_identificacion'] : 'NULL';
		  $digito_verificacion   = strlen(trim($result[0]['digito_verificacion'])) > 0   ? $result[0]['digito_verificacion']   : 'NULL'; 		   
	      $tercero_diferencia_id = strlen(trim($result[0]['tercero_id'])) > 0   ?          $result[0]['tercero_id']            : 'NULL';		   		   			   
		  
	      $select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_planillo_id";
	      $result = $this  -> DbFetchAll($select,$Conex,true);			   
	   
	      $centro_de_costo_id  = $result[0]['centro_de_costo_id'];
		  $codigo_centro_costo = strlen(trim($result[0]['codigo'])) > 0 ? "'{$result[0]['codigo']}'" : 'NULL'; 
		  
		  if(is_numeric($centro_de_costo_id)){	
		  				
			$valor_flete             = $this -> removeFormatCurrency($_REQUEST['valor_flete']);
			$valor_sobre_flete       = $this -> removeFormatCurrency($_REQUEST['valor_sobre_flete']);			
	        $saldo_por_pagar         = $this -> removeFormatCurrency($_REQUEST['saldo_por_pagar']); 			
			$observacion_sobre_flete = $this -> requestDataForQuery('observacion_sobre_flete','text');
			$observaciones           = $this -> requestDataForQuery('observaciones','text');			
            $consecutivo             = $numero_despacho;				  	  
			
			if(!is_numeric($valor_sobre_flete)) $valor_sobre_flete = 0;
					  
		    $insert = "INSERT INTO liquidacion_despacho (liquidacion_despacho_id,fecha,tipo_documento_id,tercero_id,centro_de_costo_id,numero_despacho,fuente_servicio_cod
			,oficina_id,estado_liquidacion,valor_despacho,valor_sobre_flete,observacion_sobre_flete,manifiesto_id,concepto,consecutivo,observaciones,saldo_por_pagar) VALUES ($liquidacion_despacho_id,'$fecha',$tipo_documento_id,$tercero_id,$centro_de_costo_id,'$numero_despacho','$fuente_servicio_cod'
			,$oficina_pago_id,'$estado_liquidacion',$valor_flete,$valor_sobre_flete,$observacion_sobre_flete,$manifiesto_id,'MC: $numero_despacho   Lugar Autorizado Para Pago : $LugarPago',$consecutivo,$observaciones,$saldo_por_pagar);";									
			
			$this -> query($insert,$Conex,true);
						
		    if($this -> GetNumError() > 0){
	          $this -> RollBack($Conex);
			  exit();
			}else{			

                $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);		        
				
				if($naturaleza_flete_pactado == 'D'){
				  $debito  = $valor_flete;
				  $credito = 0;
				}else{
				    $debito  = 0;
				    $credito = $valor_flete;
				  }
				  
				$puc_id = $flete_pactado_id;
				
				if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){     
				  $tercero_liquidacion_id             = $tercero_id; 
				  $numero_identificacion_liquidacion  = $numero_identificacion; 
				  $digito_verificacion_liquidacion    = $digito_verificacion;
				}else{
				     $tercero_liquidacion_id             = 'NULL'; 
				     $numero_identificacion_liquidacion  = 'NULL'; 
				     $digito_verificacion_liquidacion    = 'NULL';				
				    }
				
				if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
				    $centro_costo_liquidacion_id     = $centro_de_costo_id; 
				    $codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
				}else{
				      $centro_costo_liquidacion_id     = 'NULL'; 
				      $codigo_centro_costo_liquidacion = 'NULL'; 				
				  }
				  
				$descripcion = "FLETE PACTADO MC: $numero_despacho ";
				
				$insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,centro_de_costo_id,
				codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,base,debito,credito,valor_flete,valor,descripcion) 
				VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,$puc_id,$centro_costo_liquidacion_id,
				$codigo_centro_costo_liquidacion,$tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,
				NULL,$debito,$credito,1,$valor_flete,'$descripcion');";
				
				$this -> query($insert,$Conex,true);												
				
                $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);		        
				
				if($naturaleza_sobre_flete == 'D'){
				  $debito  = $valor_sobre_flete;
				  $credito = 0;
				}else{
				    $debito  = 0;
				    $credito = $valor_sobre_flete;
				  }
				  
				$puc_id = $sobre_flete_id;
				
				if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){     
				  $tercero_liquidacion_id             = $tercero_id; 
				  $numero_identificacion_liquidacion  = $numero_identificacion; 
				  $digito_verificacion_liquidacion    = $digito_verificacion;
				}else{
				     $tercero_liquidacion_id             = 'NULL'; 
				     $numero_identificacion_liquidacion  = 'NULL'; 
				     $digito_verificacion_liquidacion    = 'NULL';				
				    }
				
				if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
				    $centro_costo_liquidacion_id     = $centro_de_costo_id; 
				    $codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
				}else{
				      $centro_costo_liquidacion_id     = 'NULL'; 
				      $codigo_centro_costo_liquidacion = 'NULL'; 				
				  }								
			
				$descripcion = "SOBRE FLETE MC: $numero_despacho ";
				
				$insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,centro_de_costo_id,
				codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,base,debito,credito,valor_sobre_flete,valor,descripcion) 
				VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,$puc_id,$centro_costo_liquidacion_id,
				$codigo_centro_costo_liquidacion,$tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,
				NULL,$debito,$credito,1,$valor_sobre_flete,'$descripcion');";
				
				$this -> query($insert,$Conex,true);				

				if(is_array($_REQUEST['impuestos'])){
				
				  $impuestos = $_REQUEST['impuestos'];
				  $base      = $valor_flete;
				  				  		
				  for($i = 0; $i < count($impuestos); $i++){
 				  
                    $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);					
                    $impuestos_manifiesto_id = $impuestos[$i]['impuestos_manifiesto_id'];
                    $impuesto_id             = $impuestos[$i]['impuesto_id'];
					$nombre                  = $impuestos[$i]['nombre'];
					$base                    = $impuestos[$i]['base'] > 0 ? $impuestos[$i]['base'] : 'NULL';					
					$valor                   = $this -> removeFormatCurrency($impuestos[$i]['valor']);
										
					$select = "SELECT i.* FROM tabla_impuestos ti, impuesto i WHERE ti.empresa_id = $empresa_id AND ti.oficina_id = $oficina_planillo_id 
					AND ti.impuesto_id = $impuesto_id AND ti.impuesto_id = i.impuesto_id";
         	        $result = $this  -> DbFetchAll($select,$Conex,true);						
															
					if(count($result) > 0){
					
					  $puc_id     = $result[0]['puc_id'];
					  $naturaleza = $result[0]['naturaleza'];
					  
					  if($naturaleza == 'D'){
					    $debito  = $valor;
						$credito = 0; 
					  }else{
					      $debito  = 0;
						  $credito = $valor;					  
					    }
												
					  //$saldo_por_pagar = ($saldo_por_pagar - $valor);						
					  
						if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){     
						  $tercero_liquidacion_id             = $tercero_id; 
						  $numero_identificacion_liquidacion  = $numero_identificacion; 
						  $digito_verificacion_liquidacion    = $digito_verificacion;
						}else{
							 $tercero_liquidacion_id             = 'NULL'; 
							 $numero_identificacion_liquidacion  = 'NULL'; 
							 $digito_verificacion_liquidacion    = 'NULL';				
							}
						
						if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
							$centro_costo_liquidacion_id     = $centro_de_costo_id; 
							$codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
						}else{
							  $centro_costo_liquidacion_id     = 'NULL'; 
							  $codigo_centro_costo_liquidacion = 'NULL'; 				
						  }
								
					  $periodo_contable_id = $UtilidadesContables -> getPeriodoContableId($fecha,$Conex);
										  					  
					  $select = "SELECT porcentaje,formula FROM impuesto_periodo_contable WHERE impuesto_id = $impuesto_id AND periodo_contable_id 
					  = $periodo_contable_id";			  
					   
					  $dataImpuesto = $this -> DbFetchAll($select,$Conex);
					  
					  if(count($dataImpuesto) > 0){
					  
					     $porcentaje  = $dataImpuesto[0]['porcentaje'];
						 $formula     = $dataImpuesto[0]['formula'];
					     $descripcion = "$nombre MC: $numero_despacho";
						 
				         $insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id, 
						 liquidacion_despacho_id,puc_id,centro_de_costo_id,codigo_centro_costo,tercero_id,
						 numero_identificacion,digito_verificacion,base,debito,credito,
						 impuesto,impuestos_manifiesto_id,valor,porcentaje,formula,descripcion) VALUES ($detalle_liquidacion_despacho_id,
						 $liquidacion_despacho_id,$puc_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,
						 $tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,$base,$debito,
						 $credito,1,$impuestos_manifiesto_id,$valor,$porcentaje,'$formula','$descripcion');";
							
				        $this -> query($insert,$Conex,true);						  
					  }else{
					       $anio = substr($fecha,0,4);
					       exit("No existen parametros para el impuesto [ $nombre ] en el periodo $anio");
					    }
					  				  
					
					}else{
				      print "No ha configurado el impuesto [ $nombre ] en modulo de transporte!!!  $select";
	 		          $this -> RollBack($Conex);
					  exit();
					 }
					 
				  
				  }

				
				}
								
				
				if(is_array($_REQUEST['descuentos'])){
								
				  $descuentos = $_REQUEST['descuentos'];
				  				  								  
				  for($i = 0; $i < count($descuentos); $i++){
 				  
                    $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);					

                    $descuentos_manifiesto_id = $descuentos[$i]['descuentos_manifiesto_id'];
                    $descuento_id             = $descuentos[$i]['descuento_id'];
                    $nombre                   = $descuentos[$i]['nombre'];
                    $valor                    = $this -> removeFormatCurrency($descuentos[$i]['valor']);
					$base                     = $descuentos[$i]['base'];
					
                    if(is_numeric($descuento_id)){					
										
					$select = "SELECT * FROM tabla_descuentos WHERE descuento_id = $descuento_id";
         	        $result = $this  -> DbFetchAll($select,$Conex,true);	
					
										
					if(count($result) > 0){
					
					  $puc_id     = $result[0]['puc_id'];					
					  $naturaleza = $result[0]['naturaleza'];					
						
					  if($naturaleza == 'D'){
						$debito  = $valor;
						$credito = 0;
					  }else{
						  $debito  = 0;
						  $credito = $valor;					
						}
						
                      //$saldo_por_pagar = ($saldo_por_pagar - $valor);						
					  
						if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){     
						  $tercero_liquidacion_id             = $tercero_id; 
						  $numero_identificacion_liquidacion  = $numero_identificacion; 
						  $digito_verificacion_liquidacion    = $digito_verificacion;
						}else{
							 $tercero_liquidacion_id             = 'NULL'; 
							 $numero_identificacion_liquidacion  = 'NULL'; 
							 $digito_verificacion_liquidacion    = 'NULL';				
							}
						
						if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
							$centro_costo_liquidacion_id     = $centro_de_costo_id; 
							$codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
						}else{
							  $centro_costo_liquidacion_id     = 'NULL'; 
							  $codigo_centro_costo_liquidacion = 'NULL'; 				
						  }					  					  
					  
					  $descripcion = "$nombre MC: $numero_despacho";
					   
				      $insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,centro_de_costo_id,codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,base,debito,credito,descuento,descuentos_manifiesto_id,valor,descripcion) 
				      VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,$puc_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,$debito,$credito,1,$descuentos_manifiesto_id,$valor,'$descripcion');";
					  					  							
				      $this -> query($insert,$Conex,true);					  
					
					}else{
				      print "No ha configurado la tabla de descuentos aun!!!";
	 		          $this -> RollBack($Conex);
					  exit();
					 }
					 
				   }	
				   
				  }  
					 
				
				}
		
				
				if(is_array($_REQUEST['anticipos'])){				
				  				  																
                  $anticipos = $_REQUEST['anticipos'];												
																  
				  for($i = 0; $i < count($anticipos); $i++){
 				  
                    $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);					

                      $anticipos_manifiesto_id = $anticipos[$i]['anticipos_manifiesto_id'];
					  
					  
					  if(is_numeric($anticipos_manifiesto_id)){
					  
                      $valor                   = $this -> removeFormatCurrency($anticipos[$i]['valor']);																									
					  $numero_anticipo         = $anticipos[$i]['numero'];
					  $puc_id                  = $anticipo_id;						  	  				
						
					  if($naturaleza_anticipo == 'D'){
						$debito  = $valor;
						$credito = 0;
					  }else{
						  $debito  = 0;
						  $credito = $valor;					
						}
					  
					   //$saldo_por_pagar = ($saldo_por_pagar - $valor);
					  
						if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){ 
						
						  $tenedor_id = $_REQUEST['tenedor_id'];
						  
						  $select      = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id =  $tenedor_id)";
						  $dataTenedor = $this  -> DbFetchAll($select,$Conex,true);
						    
						  $tercero_liquidacion_id             = $dataTenedor[0]['tercero_id']; 
						  $numero_identificacion_liquidacion  = strlen(trim($dataTenedor[0]['numero_identificacion'])) > 0 ? $dataTenedor[0]['numero_identificacion'] : 'NULL'; 
						  $digito_verificacion_liquidacion    = strlen(trim($dataTenedor[0]['digito_verificacion'])) > 0 ? $dataTenedor[0]['digito_verificacion'] : 'NULL'; 
						  
						}else{
							 $tercero_liquidacion_id             = 'NULL'; 
							 $numero_identificacion_liquidacion  = 'NULL'; 
							 $digito_verificacion_liquidacion    = 'NULL';				
							}
						
						if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
							$centro_costo_liquidacion_id     = $centro_de_costo_id; 
							$codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
						}else{
							  $centro_costo_liquidacion_id     = 'NULL'; 
							  $codigo_centro_costo_liquidacion = 'NULL'; 				
						  }						  					  
					  
                      $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);					  
					  
					  $descripcion = "ANTICIPO $numero_anticipo MC: $numero_despacho";
					  
				      $insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,
				      centro_de_costo_id,codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,base,debito,credito,
					  anticipo,anticipos_manifiesto_id,valor,descripcion) VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,
					  $puc_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,
					  $debito,$credito,1,$anticipos_manifiesto_id,$valor,'$descripcion');";
															
				      $this -> query($insert,$Conex,true);	
					  
					  $update = "UPDATE anticipos_manifiesto SET detalle_liquidacion_despacho_id = $detalle_liquidacion_despacho_id 
					             WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id";				  
								 
					  $this -> query($update,$Conex,true);		 
					  
					  }
					
                     }
				  
				}
				
			  if($saldo_por_pagar > 0){	
				
			  if($naturaleza_saldo_por_pagar == 'D'){
			    $debito  = $saldo_por_pagar;
			    $credito = 0;			  
			  }else{
			      $debito  = 0;
				  $credito = $saldo_por_pagar;			  
			    }
			  
		      $puc_id =  $saldo_por_pagar_id;

			if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){     
			  $tercero_liquidacion_id             = $tercero_id; 
			  $numero_identificacion_liquidacion  = $numero_identificacion; 
			  $digito_verificacion_liquidacion    = $digito_verificacion;
			}else{
				 $tercero_liquidacion_id             = 'NULL'; 
				 $numero_identificacion_liquidacion  = 'NULL'; 
				 $digito_verificacion_liquidacion    = 'NULL';				
				}
			
			if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){ 
				$centro_costo_liquidacion_id     = $centro_de_costo_id; 
				$codigo_centro_costo_liquidacion = $codigo_centro_costo; 				
			}else{
				  $centro_costo_liquidacion_id     = 'NULL'; 
				  $codigo_centro_costo_liquidacion = 'NULL'; 				
			  }		  			  
				
              $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);				
				
			  $descripcion = "SALDO MC: $numero_despacho";
			  	
              $insert = "INSERT INTO detalle_liquidacion_despacho(detalle_liquidacion_despacho_id,liquidacion_despacho_id,
			  puc_id,centro_de_costo_id,codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,
			  base,debito,credito,contrapartida,saldo_pagar,valor,descripcion) VALUES ($detalle_liquidacion_despacho_id,
			  $liquidacion_despacho_id,$puc_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,
			  $tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,$debito,$credito,1,1,
			  $saldo_por_pagar,'$descripcion');";
								
		      $this -> query($insert,$Conex,true);				
			  
		      }
			   		  
		    }

		  
		  }else{
		    print "No ha asignado un centro de costo la oficina !!!";
	 		$this -> RollBack($Conex);
			exit();
		   }
		  
	  
	    }
		
	  $update = "UPDATE manifiesto SET estado = 'L' WHERE manifiesto_id = $manifiesto_id";	
	  $this -> query($update,$Conex,true);	
	  
     $valor_total_flete = ($valor_flete + $valor_sobre_flete);

     $select  = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = 
	             $manifiesto_id) AND clase_remesa = 'NN'";
     $remesas = $this  -> DbFetchAll($select,$Conex,true);		 
	 
	 $valor_facturar_total = 0;
	 
	 for($i = 0; $i < count($remesas); $i++){
	 
	   $valor_facturar_total += $remesas[$i]['valor_facturar'];
	   
	   if(!$remesas[$i]['valor_facturar'] > 0){
	      $this -> RollBack($Conex);
	      exit("<div align='center'>Debe liquidar todas las remesa del manifiesto primero!!</div>");
	   }
	   
	 }
	 
	 if($valor_facturar_total > 0){
	 
	   for($i = 0; $i < count($remesas); $i++){
	 
	     $remesa_id      = $remesas[$i]['remesa_id'];
	     $valor_facturar = $remesas[$i]['valor_facturar'];
	     $porcentaje     = ($valor_facturar * 100) / $valor_facturar_total;
	     $valor_costo    = ($porcentaje * $valor_total_flete) / 100;
	   
	     $update = "UPDATE remesa SET valor_costo = $valor_costo, conductor_id = (SELECT conductor_id FROM manifiesto WHERE 
		            manifiesto_id = $manifiesto_id) WHERE remesa_id = $remesa_id";
				  
	     $this -> query($update,$Conex,true);  				  	   
	 
	   }	  
	 
	 }else{
	 
	     if(count($remesas) > 0){
	      $this -> RollBack($Conex);
		  exit("<div align='center'>Debe liquidar las remesas de este manifiesto primero!!!</div>");	 
		 }
		 
	   }
		
      $this -> Commit($Conex);	
	  
      exit("$liquidacion_despacho_id");		  	
		
	 }else{
	     exit('Esta oficina no tiene asignado un centro de costo!!!');
	     $this -> RollBack($Conex);
		 exit();
	   }

 

	
  }
	
  public function Update($Campos,$empresa_id,$oficina_id,$Conex){
  
   $this -> Begin($Conex);
  
    $estado_liquidacion                     = $_REQUEST['estado_liquidacion'];  
    $detalle_liquidacion_valor_flete_id     = $_REQUEST['detalle_liquidacion_valor_flete_id']; 
	$valor_flete                            = $this -> removeFormatCurrency($_REQUEST['valor_flete']); 
	$valor_sobre_flete                      = $this -> removeFormatCurrency($_REQUEST['valor_sobre_flete']); 	
    $detalle_liquidacion_valor_sobre_flete_id = $_REQUEST['detalle_liquidacion_valor_sobre_flete_id'];
	$detalle_liquidacion_saldo_por_pagar_id = $_REQUEST['detalle_liquidacion_saldo_por_pagar_id']; 
	$saldo_por_pagar                        = $this -> removeFormatCurrency($_REQUEST['saldo_por_pagar']); 
	$liquidacion_despacho_id                = $_REQUEST['liquidacion_despacho_id'];
	
    $select                    = "SELECT oficina_id FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM 
	                              liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id)";
	$dataOficinaPlanillo       = $this  -> DbFetchAll($select,$Conex,true);		   	  	  
	$oficina_planillo_id       = $dataOficinaPlanillo[0]['oficina_id'];	
	
	if($estado_liquidacion != 'L'){
	   exit("Liquidacion no puede ser modificado, estado cambio!!!!!");
	}
	
	  $select = "SELECT * FROM parametros_liquidacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
	  $result = $this  -> DbFetchAll($select,$Conex,true);		   

	  if(!count($result) > 0){
	    print "<p align='center'>No ha ingresado los parametros de liquidacion!!<br>estos parametros se asignan por Paramtros Modulo -> Liquidacion</p>";
		$this -> RollBack($Conex);
		exit();
	  }else{
	  
    	$tipo_documento_id          = $result[0]['tipo_documento_id'];
        $flete_pactado_id           = $result[0]['flete_pactado_id'];
		$sobre_flete_id             = $result[0]['sobre_flete_id'];
		$naturaleza_flete_pactado   = $result[0]['naturaleza_flete_pactado'];
		$anticipo_id                = $result[0]['anticipo_id'];
		$naturaleza_anticipo        = $result[0]['naturaleza_anticipo'];
		$saldo_por_pagar_id         = $result[0]['saldo_por_pagar_id'];
		$naturaleza_saldo_por_pagar = $result[0]['naturaleza_saldo_por_pagar']; 	
		$oficina_lugar_pago_id      = $this -> requestData('oficina_id'); 					
		$observacion_sobre_flete    = $this -> requestDataForQuery('observacion_sobre_flete','text');
		$observaciones              = $this -> requestDataForQuery('observaciones','text');			
		  				
 	    $update = "UPDATE liquidacion_despacho SET oficina_id = $oficina_lugar_pago_id,valor_despacho = $valor_flete,valor_sobre_flete = $valor_sobre_flete,
		saldo_por_pagar = $saldo_por_pagar,observaciones = $observaciones,observacion_sobre_flete = $observacion_sobre_flete,tipo_documento_id = $tipo_documento_id WHERE 
		liquidacion_despacho_id = $liquidacion_despacho_id";				        
		
		$this -> query($update,$Conex,true);  
		
		if($naturaleza_flete_pactado == 'D'){
		  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $flete_pactado_id,debito = $valor_flete,credito = 0, valor = $valor_flete 
		  WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_valor_flete_id";		
		  $this -> query($update,$Conex,true);	
		  
		  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $sobre_flete_id,debito = $valor_sobre_flete,credito = 0, valor = $valor_sobre_flete 
		  WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_valor_sobre_flete_id";		
		  $this -> query($update,$Conex,true);			  	
		}else{
		    $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $flete_pactado_id,debito = 0,credito = $valor_flete, valor = $valor_flete 
		    WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_valor_flete_id";		
		    $this -> query($update,$Conex,true);
			
		  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $sobre_flete_id,debito = 0,credito = $valor_sobre_flete, valor = $valor_sobre_flete 
		  WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_valor_sobre_flete_id";		
		  $this -> query($update,$Conex,true);			  								  
		 }	
		
		
		if($naturaleza_saldo_por_pagar == 'D'){
		  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $saldo_por_pagar_id,debito = $saldo_por_pagar,credito = 0,
		  valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_saldo_por_pagar_id";		
		  $this -> query($update,$Conex,true);		
		}else{
		    $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $saldo_por_pagar_id,debito = 0,credito = $saldo_por_pagar,
		    valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_saldo_por_pagar_id";		
		    $this -> query($update,$Conex,true);				  
		 }	
		
		$this -> query($update,$Conex,true);	
		
		if(is_array($_REQUEST['impuestos'])){
		
		  $impuestos = $_REQUEST['impuestos'];
	
		  for($i = 0; $i < count($impuestos); $i++){
		  
			$detalle_liquidacion_despacho_id = $impuestos[$i]['detalle_liquidacion_despacho_id'];
			$valor                           = $this -> removeFormatCurrency($impuestos[$i]['valor']);
			$impuesto_id                     = $impuestos[$i]['impuesto_id'];
			
			$select = "SELECT i.* FROM tabla_impuestos ti, impuesto i WHERE ti.empresa_id = $empresa_id AND ti.oficina_id = $oficina_planillo_id 
			AND ti.impuesto_id = $impuesto_id AND ti.impuesto_id = i.impuesto_id";
			
			$result     = $this  -> DbFetchAll($select,$Conex,true);							
			$puc_id     = $result[0]['puc_id'];
			$naturaleza = $result[0]['naturaleza'];
			
			if($naturaleza == 'D'){
			  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $puc_id,debito = $valor,credito = 0,valor = $valor WHERE 
			  detalle_liquidacion_despacho_id = $detalle_liquidacion_despacho_id";		
			  $this -> query($update,$Conex,true);			
			}else{
			  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $puc_id,debito = 0,credito = $valor,valor = $valor WHERE 
			  detalle_liquidacion_despacho_id = $detalle_liquidacion_despacho_id";		
			  $this -> query($update,$Conex,true);						
			  }
		  
		  }
		
		}
		
		if(is_array($_REQUEST['descuentos'])){
		
		  $descuentos = $_REQUEST['descuentos'];		  		 
		  	
		  for($i = 0; $i < count($descuentos); $i++){
		  
			$detalle_liquidacion_despacho_id = $descuentos[$i]['detalle_liquidacion_despacho_id'];
			$valor                           = $this -> removeFormatCurrency($descuentos[$i]['valor']);
			$descuento_id                    = $descuentos[$i]['descuento_id'];
			
			$select = "SELECT * FROM tabla_descuentos WHERE descuento_id = $descuento_id";
   	        $result = $this  -> DbFetchAll($select,$Conex,true);				
			
			$puc_id     = $result[0]['puc_id'];
			$naturaleza = $result[0]['naturaleza'];
			
			if($naturaleza == 'D'){
			  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $puc_id,debito = $valor,credito = 0,valor = $valor WHERE 
			  detalle_liquidacion_despacho_id = $detalle_liquidacion_despacho_id";		
			  $this -> query($update,$Conex,true);			
			}else{
			    $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $puc_id,debito = 0,credito = $valor,valor = $valor WHERE 
				detalle_liquidacion_despacho_id = $detalle_liquidacion_despacho_id";		
			    $this -> query($update,$Conex,true);						
			  }
					  
		  }
		
		}
	
   }	      
   
     $valor_total_flete = ($valor_flete + $valor_sobre_flete);

     $select  = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = (SELECT 
	 manifiesto_id FROM liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id)) AND clase_remesa = 'NN'";
	 
     $remesas = $this  -> DbFetchAll($select,$Conex,true);		 
	 
	 $valor_facturar_total = 0;
	 
	 for($i = 0; $i < count($remesas); $i++){
	 
	   $valor_facturar_total += $remesas[$i]['valor_facturar'];
	 
	   if(!$remesas[$i]['valor_facturar'] > 0)  {
	     $this -> RollBack($Conex);
		 exit("<div align='center'>Debe liquidar todas las remesas antes de liquidar el manifiesto!!</div>");
	   }
	   
	 }
	 
	 if($valor_facturar_total > 0){
	 
	   for($i = 0; $i < count($remesas); $i++){
	 
	     $remesa_id      = $remesas[$i]['remesa_id'];
	     $valor_facturar = $remesas[$i]['valor_facturar'];
	     $porcentaje     = ($valor_facturar * 100) / $valor_facturar_total;
	     $valor_costo    = ($porcentaje * $valor_total_flete) / 100;
	   
	     $update = "UPDATE remesa SET valor_costo = $valor_costo, conductor_id = (SELECT conductor_id FROM manifiesto WHERE 
		            manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id)) WHERE remesa_id = $remesa_id";
				  
	     $this -> query($update,$Conex,true);  				  	   
	 
	    }   
	 
	 }else{
	 
	     if(count($remesas) > 0){
	      $this -> RollBack($Conex);
	      exit("<div align='center'>Debe liquidar las remesas primero!!</div>");
		 }
		 
	   }
	   
	   
	
   $this -> Commit($Conex);
  
  }
	
  public function Delete($Campos,$Conex){
	
  }				 			
				
  public function getTiposDocumentoContable($Conex){
	  
	$select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento ORDER BY nombre 	ASC";
	$result = $this  -> DbFetchAll($select,$Conex);
	
	return $result;
  }
	   
   public function selectLiquidacion($liquidacion_despacho_id,$Conex){
	   	   	  
	$liquidacion = array();
	
	$select = "SELECT ld.liquidacion_despacho_id,ld.encabezado_registro_id,ld.fecha,ld.oficina_id,ld.estado_liquidacion,m.manifiesto_id,m.manifiesto,m.tenedor,m.tenedor_id,
	m.placa,m.placa_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,m.origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) 
	 AS destino,m.destino_id,CONCAT('LIQUIDACION MC: ',m.manifiesto) AS concepto,ld.valor_sobre_flete,ld.observacion_sobre_flete,ld.observaciones FROM manifiesto m, 
	 liquidacion_despacho ld WHERE m.manifiesto_id = ld.manifiesto_id AND ld.liquidacion_despacho_id = $liquidacion_despacho_id";
	 
	$result = $this  -> DbFetchAll($select,$Conex,true);	 
	 
    $liquidacion = $result;	 
	
    $select = "SELECT valor,detalle_liquidacion_despacho_id FROM detalle_liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id 
	AND valor_flete = 1";				
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	$liquidacion[0]['valor_flete']                        = $result[0]['valor'];	
	$liquidacion[0]['detalle_liquidacion_valor_flete_id'] = $result[0]['detalle_liquidacion_despacho_id'];	
	
	
    $select = "SELECT valor,detalle_liquidacion_despacho_id FROM detalle_liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id 
	AND valor_sobre_flete = 1";				
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	$liquidacion[0]['valor_sobre_flete']                        = $result[0]['valor'];	
	$liquidacion[0]['detalle_liquidacion_valor_sobre_flete_id'] = $result[0]['detalle_liquidacion_despacho_id'];
			
		
    $select = "SELECT valor,detalle_liquidacion_despacho_id FROM detalle_liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id 
	AND saldo_pagar = 1";				
	$result = $this -> DbFetchAll($select,$Conex,true);		
	
    $liquidacion[0]['saldo_por_pagar']                        = $result[0]['valor'];
	$liquidacion[0]['detalle_liquidacion_saldo_por_pagar_id'] = $result[0]['detalle_liquidacion_despacho_id'];	
	
    $select = "SELECT im.*,dl.detalle_liquidacion_despacho_id,dl.impuestos_manifiesto_id,dl.valor FROM detalle_liquidacion_despacho 
	dl,impuestos_manifiesto im WHERE dl.liquidacion_despacho_id = $liquidacion_despacho_id AND dl.impuesto = 1 AND dl.impuestos_manifiesto_id = 
	im.impuestos_manifiesto_id";	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				 
	if(count($result) > 0){	 
	  $liquidacion[0]['impuestos'] = $result;	 
	}	
	
	$valor_neto_pagar = $liquidacion[0]['valor_flete'];
	
	for($i = 0; $i < count($liquidacion[0]['impuestos']); $i++){
	
	  $valor_neto_pagar -= $liquidacion[0]['impuestos'][$i]['valor'];

	}

	$liquidacion[0]['valor_neto_pagar'] = $valor_neto_pagar;		
	
    $select = "SELECT dm.*,d.calculo,dl.detalle_liquidacion_despacho_id,dl.descuentos_manifiesto_id,dl.valor FROM detalle_liquidacion_despacho 
	dl,descuentos_manifiesto dm,tabla_descuentos d WHERE dl.liquidacion_despacho_id = $liquidacion_despacho_id AND dl.descuento = 1 AND 
	dl.descuentos_manifiesto_id = dm.descuentos_manifiesto_id AND dm.descuento_id = d.descuento_id";	
	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				 
	if(count($result) > 0){	 
	  $liquidacion[0]['descuentos'] = $result;	 
	}	
	
    $select = "SELECT am.*,dl.detalle_liquidacion_despacho_id,dl.anticipos_manifiesto_id,dl.valor FROM detalle_liquidacion_despacho dl, 
	anticipos_manifiesto am WHERE dl.liquidacion_despacho_id = $liquidacion_despacho_id AND dl.anticipo = 1 AND dl.anticipos_manifiesto_id = 
	am.anticipos_manifiesto_id";	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				 
	if(count($result) > 0){	 
	  $liquidacion[0]['anticipos'] = $result;	 
	}	
		
	return $liquidacion;   
		   
   }

   public function getColumnsImpGridLiquidacion($Conex){
      
//      $select    = "SELECT DISTINCT im.nombre FROM detalle_liquidacion_despacho dl,impuestos_manifiesto im WHERE dl.impuestos_manifiesto_id = im.impuestos_manifiesto_id";

	  $select    = "SELECT DISTINCT nombre FROM tabla_impuestos ORDER BY nombre ASC";  
	  $impuestos = $this -> DbFetchAll($select,$Conex,true);		  
	  
	  for($i = 0; $i < count($impuestos); $i++){
	     $impuestos[$i]['comparar'] = $impuestos[$i]['nombre'];	  		   	  	  	  
	     $impuestos[$i]['nombre']   = strtoupper(preg_replace( "([ ]+)", "", str_replace('%','',$impuestos[$i]['nombre'])));	
	  }
	  
	  
	  return $impuestos;        
   
   }
   
   
   public function getColumnsDesGridLiquidacion($Conex){
      
//      $select     = "SELECT DISTINCT dm.nombre FROM detalle_liquidacion_despacho dl,descuentos_manifiesto dm WHERE dl.descuentos_manifiesto_id = dm.descuentos_manifiesto_id";

      $select     = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos ORDER BY nombre ASC";
	  $descuentos = $this -> DbFetchAll($select,$Conex,true);	
	  
	  for($i = 0; $i < count($descuentos); $i++){
	     $descuentos[$i]['comparar'] = $descuentos[$i]['nombre'];	 	  
	     $descuentos[$i]['nombre']   = strtoupper(str_replace('.','',preg_replace( "([ ]+)", "",$descuentos[$i]['nombre'])));	  	  	   	  	  		 
	  }
	  	 	 
	  return $descuentos;        
   
   }
      
//// GRID ////   
  public function getQueryManifiestosGrid($oficina_id,$colsImpuestos,$colsDescuentos){
	   	     	 
	 for($i = 0; $i < count($colsImpuestos); $i++){	 	 	 
	   $column            = $colsImpuestos[$i]['nombre'];
	   $comparar          = $colsImpuestos[$i]['comparar'];
	   $columnsImpuestos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho WHERE impuesto = 1 AND impuestos_manifiesto_id IN (SELECT impuestos_manifiesto_id 
	   FROM impuestos_manifiesto ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND ip.manifiesto_id = m.manifiesto_id)) AS $column,";	 
	 }

	 for($i = 0; $i < count($colsDescuentos); $i++){	 
	   $column             = $colsDescuentos[$i]['nombre'];
	   $comparar           = $colsDescuentos[$i]['comparar'];	   
	   $columnsDescuentos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho WHERE descuento = 1 AND descuentos_manifiesto_id IN (SELECT descuentos_manifiesto_id 
	   FROM descuentos_manifiesto dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.manifiesto_id = m.manifiesto_id)) AS $column,";	 
	 }	 	 
	 
	 $Query = "SELECT m.manifiesto,m.fecha_mc AS fecha_manifiesto,ld.fecha AS fecha_liquidacion,(SELECT nombre FROM oficina WHERE oficina_id = ld.oficina_id) AS lugar_autorizado_pago, m.placa,m.numero_identificacion_tenedor,m.tenedor,ld.valor_despacho+ld.valor_sobre_flete AS valor_total,
	 (SELECT SUM(valor) FROM detalle_liquidacion_despacho dld WHERE anticipo = 1 AND liquidacion_despacho_id = ld.liquidacion_despacho_id) AS anticipos,$columnsImpuestos $columnsDescuentos ld.saldo_por_pagar
	 FROM liquidacion_despacho ld, manifiesto m WHERE ld.manifiesto_id = m.manifiesto_id";
     
   
     return $Query;
   }
   

}


?>