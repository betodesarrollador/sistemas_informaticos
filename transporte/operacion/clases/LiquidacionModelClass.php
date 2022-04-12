<?php


require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LiquidacionModel extends Db{ 
	
   public function selectManifiestos($Conex){
  
    $select = "SELECT * FROM manifiesto m WHERE m.propio =0 AND m.aprobacion_ministerio3 IS NULL
 	AND m.aprobacion_ministerio2 IS NOT NULL AND (m.estado='L' OR m.estado='M') AND m.fecha_mc<='2015-12-15' AND m.manifiesto_id NOT IN ( 11662, 15319,  15493, 16416,16894, 16936) ";

	$result = $this -> DbFetchAll($select,$Conex,true);	
	
	return $result;
	  
  }
	
 
   public function selectRemesasManifiesto($manifiesto_id,$Conex){
  
    $select = "SELECT numero_remesa,remesa_id,estado,tipo_remesa_id,peso,peso_costo, cliente_id 
	FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE	manifiesto_id = $manifiesto_id)";

	$result = $this -> DbFetchAll($select,$Conex,true);	
	
	return $result;
	  
  }

  public function selectOficinas($empresa_id,$Conex){
  
     $select = "SELECT oficina_id AS value, nombre AS text FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 
	 return $result;
  
  }

  public function anticiposGeneroEgreso($manifiesto,$Conex){  
  
     $select = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM manifiesto 
	            WHERE TRIM(manifiesto) = TRIM('$manifiesto')) AND devolucion=0 AND estado !='A'";
				
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
  
     $select = "SELECT manifiesto_id,manifiesto,tenedor,tenedor_id,placa,placa_id,fecha_entrega_mcia_mc,fecha_estimada_salida,(SELECT nombre FROM ubicacion 
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

     $select = "SELECT SUM(IF(r.peso_costo>0,r.peso_costo,r.peso)) AS peso, SUM(IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen)) AS peso_volumen,SUM(IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad)) AS cantidad, SUM(r.valor_costo) AS valor_costos
	 FROM detalle_despacho dd, remesa r, manifiesto m  WHERE dd.manifiesto_id = $manifiesto_id AND r.remesa_id=dd.remesa_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){	 
	   $liquidacion[0]['valor_costos'] = $result[0][valor_costos];	
	   $liquidacion[0]['peso_total'] = $result[0][peso];	 
	   $liquidacion[0]['peso_vol_total'] = $result[0][peso_volumen];
	   $liquidacion[0]['cantidad_total'] = $result[0][cantidad];
	 }	 

     $select = "SELECT r.remesa_id,r.numero_remesa,r.tipo_liquidacion,IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad) AS cantidad, r.estado,r.valor_facturar,
	 IF(r.peso_costo>0,r.peso_costo,r.peso) AS peso,IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen) AS peso_volumen,r.valor_unidad_costo,(SELECT valor_flete FROM manifiesto WHERE manifiesto_id = $manifiesto_id) AS valor_costo,
	 (SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,
	 (SELECT producto_empresa FROM producto WHERE producto_id = r.producto_id) AS  producto,
	 (SELECT medida FROM medida WHERE   medida_id = r.medida_id) AS unidad
	 FROM detalle_despacho dd, remesa r  WHERE dd.manifiesto_id = $manifiesto_id AND r.remesa_id=dd.remesa_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex,true);
	 
	 if(count($result) > 0){	 
	   $liquidacion[0]['remesa_dat'] = $result;	 
	 }	 

     $select = "SELECT t.*,m.*,
	 (SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = t.cliente_id)) AS clientess,
	 (SELECT placa FROM vehiculo WHERE placa_id = t.placa_id) AS  placa
	 FROM  tiempos_clientes_remesas t, manifiesto m WHERE t.manifiesto_id = $manifiesto_id AND t.manifiesto_id=m.manifiesto_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){	 
	   $liquidacion[0]['tiempos_dat'] = $result;	 
	 }	 

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
	 
	 $select = "SELECT a.*,
	 (a.valor-IF((SELECT SUM(valor) FROM anticipos_manifiesto WHERE sub_anticipos_manifiesto_id=a.anticipos_manifiesto_id AND a.estado !='A')>0,
	(SELECT SUM(valor) FROM	anticipos_manifiesto WHERE sub_anticipos_manifiesto_id=a.anticipos_manifiesto_id AND a.estado !='A'),0)) AS valor 
	 FROM anticipos_manifiesto a  WHERE a.manifiesto_id = $manifiesto_id AND a.devolucion=0 AND a.estado !='A'";
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){
	   $liquidacion[0]['anticipos'] = $result;	 	 
	 } 	 
	
	 return $liquidacion;
  
  }
      
  public function existeLiquidacion($manifiesto_id,$Conex){
  
     $select = "SELECT * FROM liquidacion_despacho WHERE fuente_servicio_cod = 'MC' AND manifiesto_id = $manifiesto_id  AND estado_liquidacion!='A'";
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
	  
	  $select_apli              = "SELECT COUNT(*) AS total_retei FROM detalle_despacho d, remesa r, cliente c 
	  								WHERE d.manifiesto_id = $manifiesto_id AND r.remesa_id=d.remesa_id AND c.cliente_id=r.cliente_id AND r.estado!='AN' AND c.retei_cliente_factura='S'";
	  $result_apli       		= $this  -> DbFetchAll($select_apli,$Conex,true);		   	  	  
	  $total_retei				=   $result_apli[0]['total_retei'];
			  
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
			$autoriza_pago           = $this -> requestDataForQuery('autoriza_pago','text');
            $consecutivo             = $numero_despacho;				  	  
			
			if(!is_numeric($valor_sobre_flete)) $valor_sobre_flete = 0;
			$baseimpuesto= $valor_sobre_flete+$valor_flete;
					  
		    $insert = "INSERT INTO liquidacion_despacho (liquidacion_despacho_id,fecha,tipo_documento_id,tercero_id,centro_de_costo_id,numero_despacho,fuente_servicio_cod
			,oficina_id,estado_liquidacion,valor_despacho,valor_sobre_flete,observacion_sobre_flete,manifiesto_id,concepto,consecutivo,observaciones,saldo_por_pagar,autoriza_pago) VALUES ($liquidacion_despacho_id,'$fecha',$tipo_documento_id,$tercero_id,$centro_de_costo_id,'$numero_despacho','$fuente_servicio_cod'
			,$oficina_pago_id,'$estado_liquidacion',$valor_flete,$valor_sobre_flete,$observacion_sobre_flete,$manifiesto_id,'MC: $numero_despacho   Lugar Autorizado Para Pago : $LugarPago',$consecutivo,$observaciones,$saldo_por_pagar,$autoriza_pago);";									
			
			$this -> query($insert,$Conex,true);
			$insert_log=$insert;		
			
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
				//echo $insert;
				$this -> query($insert,$Conex,true);												
				
				
			if($valor_sobre_flete>0){ 
				
				
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
				//echo $insert;
				$this -> query($insert,$Conex,true);				
			}
				if(is_array($_REQUEST['impuestos'])){
				
				  $impuestos = $_REQUEST['impuestos'];
				  $base      = $valor_flete;
				  				  		
				  for($i = 0; $i < count($impuestos); $i++){
 				  
                    $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);					
                    $impuestos_manifiesto_id = $impuestos[$i]['impuestos_manifiesto_id'];
                    $impuesto_id             = $impuestos[$i]['impuesto_id'];
					$nombre                  = $impuestos[$i]['nombre'];
					$base                    = $impuestos[$i]['base'] > 0 ? $impuestos[$i]['base'] : 'NULL';	
					if($baseimpuesto!=$base) $base =$baseimpuesto;
					$valor                   = $this -> removeFormatCurrency($impuestos[$i]['valor']);
										
					$select = "SELECT i.*,ti.* FROM tabla_impuestos ti, impuesto i WHERE ti.empresa_id = $empresa_id AND ti.oficina_id = $oficina_planillo_id 
					AND ti.impuesto_id = $impuesto_id AND ti.impuesto_id = i.impuesto_id";
         	        $result = $this  -> DbFetchAll($select,$Conex,true);						
					$pagar_impuesto_id=$result[0]['pagar_impuesto_id'];
					
					if(count($result) > 0){

					  if($total_retei>0 && $result[0]['ica']==1 && $result[0]['exentos']=='IC' ){
						  
						if(!is_numeric($pagar_impuesto_id)){ exit("No se ha parametrizado en Tabla Impuestos, El campo Impuesto a Pagar!!"); }
						$select = "SELECT i.*,ti.* FROM tabla_impuestos ti, impuesto i WHERE ti.empresa_id = $empresa_id AND ti.oficina_id = $oficina_planillo_id 
						AND ti.impuesto_id = $impuesto_id AND ti.pagar_impuesto_id = i.impuesto_id";
						$result = $this  -> DbFetchAll($select,$Conex,true);						

					  }

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
					   
					  $dataImpuesto = $this -> DbFetchAll($select,$Conex,true);
					  
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
							//echo $insert;
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
					
                    if(is_numeric($descuento_id) && $valor > 0){					
										
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
					  		//echo $insert;			  							
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
							//echo $insert;								
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
			  //echo $insert;			
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
	
	 if(is_array($_REQUEST['tiempos'])){
		$tiempos = $_REQUEST['tiempos'];	
		for($i = 0; $i < count($tiempos); $i++){	
			 $update = "UPDATE  tiempos_clientes_remesas 
			 			SET fecha_llegada_descargue = '".$tiempos[$i]['fecha_llegada_descargue']."', 
						hora_llegada_descargue = '".$tiempos[$i]['hora_llegada_descargue']."',
			 			fecha_entrada_descargue = '".$tiempos[$i]['fecha_entrada_descargue']."', 
						hora_entrada_descargue = '".$tiempos[$i]['hora_entrada_descargue']."',
						fecha_salida_descargue = '".$tiempos[$i]['fecha_salida_descargue']."', 
						hora_salida_descargue = '".$tiempos[$i]['hora_salida_descargue']."'
						WHERE tiempos_clientes_remesas_id =".$tiempos[$i]['tiempos_clientes_remesas_id']."";
					  //echo $update;
			 $this -> query($update,$Conex,true);  				  	   
		}
	 }
	 if(is_array($_REQUEST['remesa'])){
		$con_rem=0;
		$acum_costos=0;
		$remesa = $_REQUEST['remesa'];												
																  
		for($i = 0; $i < count($remesa); $i++){	
			if($remesa[$i]['valor_costo']!=''){
				$con_rem++;		
				$acum_costos = $acum_costos + str_replace('.','',$remesa[$i]['valor_costo']); 
			}
		}
		
		if( count($remesa)==$con_rem){
			$tip_guardar_rem='costo';	
			if($acum_costos!=$valor_total_flete){
				print "<p align='center'>La Sumatoria del Flete + sobre flete, No coincide con la sumatoria de los costos de las remesas!!<br>Por favor verifique</p>";
				$this -> RollBack($Conex);
				exit();
			}
		}elseif($con_rem==0){
			$tip_guardar_rem='total';				
		}else{
			print "<p align='center'>Debe de asignar los valores de costo por todas las remesas!!<br>De lo contrario deje todos los campos de valor de costo por remesa vacios e ingrese un valor total de flete</p>";
			$this -> RollBack($Conex);
			exit();
		}
	 }
	 if($tip_guardar_rem=='total'){
		 $select  = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = 
					 $manifiesto_id) AND clase_remesa = 'NN'";
		 $remesas = $this  -> DbFetchAll($select,$Conex,true);		 
		 
		 $valor_facturar_total = 0;
		 
		 for($i = 0; $i < count($remesas); $i++){
		 
		   $valor_facturar_total = $valor_facturar_total + $remesas[$i]['valor_facturar'];
		   
		   if(!$remesas[$i]['valor_facturar'] > 0){
			  $this -> RollBack($Conex);
			  exit("<div align='center'>Debe liquidar todas las remesa del manifiesto primero!!</div>");
		   }
		   
		   /*if($remesas[$i]['estado']=='FT' ){
			   $this -> RollBack($Conex);
			  exit("<div align='center'>la remesa ".$remesas[$i]['numero_remesa']." ya esta Facturada!!!</div>");	 	 
		   }*/		   
		   
		 }
		 
		 if($valor_facturar_total > 0){
		 
		   for($i = 0; $i < count($remesas); $i++){
		 
			 $remesa_id      = $remesas[$i]['remesa_id'];
			 $valor_facturar = $remesas[$i]['valor_facturar'];
			 $porcentaje     = ($valor_facturar  / $valor_facturar_total) * 100;
			 $valor_costo    = round(($porcentaje * $valor_total_flete) / 100);
		   
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
		 
	 }elseif($tip_guardar_rem=='costo'){

		 if(is_array($_REQUEST['remesa'])){

			$remesa = $_REQUEST['remesa'];												
																	  
			for($i = 0; $i < count($remesa); $i++){	
				
				 if(($remesa[$i]['estado']=='LQ' || $remesa[$i]['estado']=='FT') && $remesa[$i]['valor_costo']!=''){
					 $valor_costo= $remesa[$i]['valor_costo']!='' ? str_replace('.','',$remesa[$i]['valor_costo']): 'NULL';
					 $cantidad= $remesa[$i]['cantidad']!='' ? str_replace('.','',$remesa[$i]['cantidad']): 'NULL';
					 $peso_volumen= $remesa[$i]['peso_volumen']!='' ? str_replace('.','',$remesa[$i]['peso_volumen']): 'NULL';
					 $peso= $remesa[$i]['peso']!='' ? str_replace('.','',$remesa[$i]['peso']): 'NULL';
					 $valor_unidad_costo= $remesa[$i]['valor_unidad_costo']!='' ? str_replace('.','',$remesa[$i]['valor_unidad_costo']): 'NULL';
					 
					 $update = "UPDATE remesa SET valor_costo = ".$valor_costo.", 
								cantidad_costo = ".$cantidad.", 
								peso_volumen_costo = ". $peso_volumen.",
								peso_costo = ".$peso.",
								valor_unidad_costo = ".$valor_unidad_costo.",
								conductor_id = (SELECT conductor_id FROM manifiesto WHERE manifiesto_id = $manifiesto_id) 
								WHERE remesa_id = ".$remesa[$i]['remesa_id']."";
							  
					 $this -> query($update,$Conex,true);  				  	   
				 }else{
					 $this -> RollBack($Conex);
					 //(if($remesa[$i]['estado']=='FT' ){
						//  exit("<div align='center'>la remesa ".$remesa[$i]['numero_remesa']." ya esta Facturada!!!</div>");	 	 
					 //}else{
						 exit("<div align='center'>Debe liquidar la remesa ".$remesa[$i]['numero_remesa']." primero!!!</div>");	 	 
					 //}
				 }
			}
		 }
	
	 }
	       //causacion para chiquinquira  aca
	  $factura_proveedor_id 	 = $this -> DbgetMaxConsecutive("factura_proveedor","factura_proveedor_id",$Conex,true,1);
  	  $numero_soporte 			 = $consecutivo;
	  $fuente_servicio_cod 		 = 'MC';
	  $fecha_factura_proveedor 	 = $fecha;		  
	  $vence_factura_proveedor 	 = $this -> requestDataForQuery('vencimiento','date');	
	  $ingreso_factura_proveedor = date('Y-m-d H:m');
	  $valor					 = $saldo_por_pagar;
	  $concepto_factura_proveedor= 'CAUSACION MC: '.$numero_soporte;


		  
	  $select="SELECT l.tercero_id,
				(SELECT proveedor_id FROM proveedor WHERE tercero_id=l.tercero_id) AS proveedor_id
				FROM liquidacion_despacho l 
				WHERE l.liquidacion_despacho_id=$liquidacion_despacho_id";
	  $result = $this -> DbFetchAll($select,$Conex,true);
	 
	  if($result[0]['proveedor_id']!=0 && $result[0]['proveedor_id']!='' && $result[0]['proveedor_id']!=NULL){
		  $proveedor_id=$result[0]['proveedor_id'];
	  }else{
		  $proveedor_id 	 = $this -> DbgetMaxConsecutive("proveedor","proveedor_id",$Conex,true,1);
		  
		  $insert = "INSERT INTO proveedor (proveedor_id,tercero_id,estado_proveedor,autoret_proveedor,retei_proveedor) 
						VALUES ($proveedor_id,$tercero_id,'A','N','N')"; 
		  $this -> query($insert,$Conex,true);
		
	  }


	  $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,liquidacion_despacho_id,codfactura_proveedor,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor) 
					VALUES ($factura_proveedor_id,$liquidacion_despacho_id,'$numero_soporte',$valor,'$fecha_factura_proveedor',$vence_factura_proveedor,'$concepto_factura_proveedor',$proveedor_id,'$fuente_servicio_cod','A',$usuario_id,$oficina_id,'$ingreso_factura_proveedor')"; 

	  $this -> query($insert,$Conex,true);


	  $this -> assignValRequest('factura_proveedor_id',$factura_proveedor_id);

	  $select_item      = "SELECT d.detalle_liquidacion_despacho_id  FROM  factura_proveedor f,   detalle_liquidacion_despacho d 
							 WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.liquidacion_despacho_id=f.liquidacion_despacho_id AND d.valor>0";
	  $result_item      = $this -> DbFetchAll($select_item,$Conex,true);
		
	  foreach($result_item as $result_items){
			
			$item_factura_proveedor_id 	= $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
			$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
					SELECT 	$item_factura_proveedor_id,
							f.factura_proveedor_id,
							d.puc_id,
							IF(pu.requiere_tercero=1,d.tercero_id,NULL) AS tercero,
							IF(pu.requiere_tercero=1,d.numero_identificacion,NULL) AS numero_identificacion,
							IF(pu.requiere_tercero=1,d.digito_verificacion,NULL) AS digito_verificacion,									
							IF(pu.requiere_centro_costo=1,d.centro_de_costo_id,NULL) AS centro_costo,
							IF(pu.requiere_centro_costo=1,d.codigo_centro_costo,NULL) AS codigo_centro_costo,
							d.base,
							d.porcentaje,					  
							d.formula,					  
							d.descripcion AS desc_factura_proveedor,
							d.debito,
							d.credito,
							d.contrapartida
					FROM factura_proveedor f,   detalle_liquidacion_despacho d, puc pu
					WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.liquidacion_despacho_id=f.liquidacion_despacho_id AND d.detalle_liquidacion_despacho_id=$result_items[detalle_liquidacion_despacho_id] AND pu.puc_id=d.puc_id"; 
			$this -> query($insert,$Conex,true);
	  }

	  if(!strlen(trim($this -> GetError())) > 0){

		$update = "UPDATE liquidacion_despacho  SET estado_liquidacion='C' 
		WHERE   liquidacion_despacho_id = $liquidacion_despacho_id";
		$this -> query($update,$Conex,true);
	  }
	  

	  include_once("UtilidadesContablesModelClass.php");
	  
	  $utilidadesContables = new UtilidadesContablesModel(); 	 
	 
		
	  $select 	= "SELECT f.factura_proveedor_id,
						  f.fuente_servicio_cod,
						  f.tipo_bien_servicio_id, 		
						  f.valor_factura_proveedor,
						  f.orden_compra_id,
						  f.codfactura_proveedor,
						  f.fecha_factura_proveedor,
						  f.concepto_factura_proveedor,
						  f.liquidacion_despacho_id,
						  CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra No ' WHEN 'MC' THEN 'Manifiesto de Carga No ' ELSE 'Despacho Urbano No ' END AS tipo_soporte,
						  (SELECT numero_despacho FROM  liquidacion_despacho  WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS numero_soporte_ord,						  
						  (SELECT tercero_id  FROM  proveedor WHERE proveedor_id=f.proveedor_id) AS tercero,
						  (SELECT puc_id  FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id AND contra_bien_servicio=1) AS puc_contra,
						  IF(f.tipo_bien_servicio_id>0,(SELECT tipo_documento_id  FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),(SELECT tipo_documento_id  FROM liquidacion_despacho WHERE liquidacion_despacho_id =f.liquidacion_despacho_id )) AS tipo_documento					  
					FROM factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id";	
					
		$result 	= $this -> DbFetchAll($select,$Conex,true); 

		$select_sum = "SELECT SUM(deb_item_factura_proveedor) AS debito, SUM(cre_item_factura_proveedor) AS credito FROM  item_factura_proveedor 
						WHERE factura_proveedor_id=$factura_proveedor_id ";
		$result_sum	= $this -> DbFetchAll($select_sum,$Conex,true);	
		
		//echo $result_sum[0][debito].'-'.$result_sum[0][credito];
		if($result_sum[0][debito]!=$result_sum[0][credito]){
			$this -> Rollback($Conex);
			exit("<div align='center'>Debe parametrizar correctamente las cuentas, Las sumas de debito y credito no son iguales!!! <br> Debitos: ".$result_sum[0][debito]." <br> Creditos: ".$result_sum[0][credito]."</div>");	 
		}


		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);				

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		$tipo_documento_id		= $result[0]['tipo_documento'];	
		$valor					= $result[0]['valor_factura_proveedor'];
		$numero_soporte			= $result[0]['codfactura_proveedor'] !='' ? $result[0]['codfactura_proveedor'] : $result[0]['numero_soporte_ord'];	
		$tercero_id				= $result[0]['tercero'];
		
		
	    $fechaMes                  = substr($result[0]['fecha_factura_proveedor'],0,10);		
	    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	    $consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);		
		
		$fecha					= $result[0]['fecha_factura_proveedor'];
		$concepto				= $result[0]['concepto_factura_proveedor'];
		$puc_id					= $result[0]['puc_contra']!='' ? $result[0]['puc_contra']:'NULL';
		$fecha_registro			= date("Y-m-d H:m");
		$modifica				= $result_usu[0]['usuario'];
		$fuente_servicio_cod	= $result[0]['fuente_servicio_cod'];
		$numero_documento_fuente= $numero_soporte;
		$id_documento_fuente	= $result[0]['factura_proveedor_id'];
		$liquidacion_despacho_id= $result[0]['liquidacion_despacho_id'];
		$con_fecha_factura_prov = $fecha_registro;	

		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente)"; 
		$this -> query($insert,$Conex,true);
		
		$select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
		$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
		foreach($result_item as $result_items){
			$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
							formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor
							FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 
			$this -> query($insert_item,$Conex,true);
		}
		
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{		
		
			$update = "UPDATE factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,	
						estado_factura_proveedor= 'C',
						con_usuario_id = $usuario_id,
						con_fecha_factura_proveedor='$con_fecha_factura_prov'
					WHERE factura_proveedor_id=$factura_proveedor_id";	
			$this -> query($update,$Conex,true);		  
			if($liquidacion_despacho_id>0){
				$update = "UPDATE liquidacion_despacho SET encabezado_registro_id=$encabezado_registro_id	
						WHERE  liquidacion_despacho_id=$liquidacion_despacho_id";	
				$this -> query($update,$Conex,true);		  
			}
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
				
			}  
		}  
	  //fin causacion chiquinquira
	 $this -> setLogTransaction_extra('liquidacion_despacho',$insert_log,$Conex,'INSERT');
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
   
	 require_once("UtilidadesContablesModelClass.php");	
    $UtilidadesContables = new UtilidadesContablesModel();
  
    $estado_liquidacion                     = $_REQUEST['estado_liquidacion'];  
    $detalle_liquidacion_valor_flete_id     = $_REQUEST['detalle_liquidacion_valor_flete_id']; 
	$valor_flete                            = $this -> removeFormatCurrency($_REQUEST['valor_flete']); 
	$valor_sobre_flete                      = $this -> removeFormatCurrency($_REQUEST['valor_sobre_flete']); 	
    $detalle_liquidacion_valor_sobre_flete_id = $_REQUEST['detalle_liquidacion_valor_sobre_flete_id'];
	$detalle_liquidacion_saldo_por_pagar_id = $_REQUEST['detalle_liquidacion_saldo_por_pagar_id']; 
	$saldo_por_pagar                        = $this -> removeFormatCurrency($_REQUEST['saldo_por_pagar']); 
	$liquidacion_despacho_id                = $_REQUEST['liquidacion_despacho_id'];
	$tenedor_id                = $this -> requestData('tenedor_id');
	$numero_despacho           = $this -> requestData('manifiesto');
	
    $select                    = "SELECT oficina_id FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM 
	                              liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id)";
	$dataOficinaPlanillo       = $this  -> DbFetchAll($select,$Conex,true);		   	  	  
	$oficina_planillo_id       = $dataOficinaPlanillo[0]['oficina_id'];	

	$select_apli              = "SELECT COUNT(*) AS total_retei FROM detalle_despacho d, remesa r, cliente c 
								WHERE d.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id) 
								AND r.remesa_id=d.remesa_id AND c.cliente_id=r.cliente_id AND r.estado!='AN' AND c.retei_cliente_factura='S'";
	$result_apli       		= $this  -> DbFetchAll($select_apli,$Conex,true);		   	  	  
	$total_retei				=   $result_apli[0]['total_retei'];

	/*if($estado_liquidacion != 'L' || $estado_liquidacion != 'C'){
	   exit("Liquidacion no puede ser modificado, estado cambio!!!!!");
	}*/
	
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
		$autoriza_pago              = $this -> requestDataForQuery('autoriza_pago','text');	
		
		if($estado_liquidacion == 'C'){
			
			$actualiza = "UPDATE liquidacion_despacho SET autoriza_pago =  $autoriza_pago WHERE 
		liquidacion_despacho_id = $liquidacion_despacho_id";
		$this -> query($actualiza,$Conex,true); 
			
		}else{
		
 	    $update = "UPDATE liquidacion_despacho SET oficina_id = $oficina_lugar_pago_id,valor_despacho = $valor_flete,valor_sobre_flete =      $valor_sobre_flete,
		saldo_por_pagar = $saldo_por_pagar,observaciones = $observaciones,observacion_sobre_flete = $observacion_sobre_flete,tipo_documento_id = $tipo_documento_id, autoriza_pago =  $autoriza_pago WHERE 
		liquidacion_despacho_id = $liquidacion_despacho_id";				        
		$this -> query($update,$Conex,true);  
		$update_log=$update;		
		
		
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
		
		
		/*if($naturaleza_saldo_por_pagar == 'D'){
		  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $saldo_por_pagar_id,debito = $saldo_por_pagar,credito = 0,
		  valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_saldo_por_pagar_id";		
		  $this -> query($update,$Conex,true);		
		}else{
		    $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $saldo_por_pagar_id,debito = 0,credito = $saldo_por_pagar,
		    valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_saldo_por_pagar_id";		
		    $this -> query($update,$Conex,true);				  
		 }	*/
		 
		if($naturaleza_saldo_por_pagar == 'D'){
			if($detalle_liquidacion_saldo_por_pagar_id>0){
		  		$update = "UPDATE detalle_liquidacion_despacho SET puc_id = $saldo_por_pagar_id,debito = $saldo_por_pagar,credito = 0,
		  		valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_saldo_por_pagar_id";		
		  		$this -> query($update,$Conex,true);
			}else{

			  $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)";
			  $result = $this  -> DbFetchAll($select,$Conex,true);			   
		   
			  $tercero_id            = $result[0]['tercero_id'];
			  $numero_identificacion = strlen(trim($result[0]['numero_identificacion'])) > 0 ? $result[0]['numero_identificacion'] : 'NULL';
			  $digito_verificacion   = strlen(trim($result[0]['digito_verificacion'])) > 0   ? $result[0]['digito_verificacion']   : 'NULL'; 		   
			  $tercero_diferencia_id = strlen(trim($result[0]['tercero_id'])) > 0   ?          $result[0]['tercero_id']            : 'NULL';		   		   			   

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

			
			$select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_planillo_id";
			$result2 = $this  -> DbFetchAll($select,$Conex,true);			   
			
			$centro_de_costo_id  = $result2[0]['centro_de_costo_id'];
			$codigo_centro_costo = strlen(trim($result2[0]['codigo'])) > 0 ? "'{$result2[0]['codigo']}'" : 'NULL'; 

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
			  $liquidacion_despacho_id,$saldo_por_pagar_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,
			  $tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,$saldo_por_pagar,0,1,1,
			  $saldo_por_pagar,'$descripcion');";

		      $this -> query($insert,$Conex,true);				

		  }
		}else{
			if($detalle_liquidacion_saldo_por_pagar_id>0){	
		   		$update = "UPDATE detalle_liquidacion_despacho SET puc_id = $saldo_por_pagar_id,debito = 0,credito = $saldo_por_pagar,
		    	valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_id = $detalle_liquidacion_saldo_por_pagar_id";		
		    	$this -> query($update,$Conex,true);				  
		 }else{
	
			  $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)";
			  $result = $this  -> DbFetchAll($select,$Conex,true);			   
		   
			  $tercero_id            = $result[0]['tercero_id'];
			  $numero_identificacion = strlen(trim($result[0]['numero_identificacion'])) > 0 ? $result[0]['numero_identificacion'] : 'NULL';
			  $digito_verificacion   = strlen(trim($result[0]['digito_verificacion'])) > 0   ? $result[0]['digito_verificacion']   : 'NULL'; 		   
			  $tercero_diferencia_id = strlen(trim($result[0]['tercero_id'])) > 0   ?          $result[0]['tercero_id']            : 'NULL';		   		   			   

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

			
			$select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_planillo_id";
			$result2 = $this  -> DbFetchAll($select,$Conex,true);			   
			
			$centro_de_costo_id  = $result2[0]['centro_de_costo_id'];
			$codigo_centro_costo = strlen(trim($result2[0]['codigo'])) > 0 ? "'{$result2[0]['codigo']}'" : 'NULL'; 

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
			  $liquidacion_despacho_id,$saldo_por_pagar_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,
			  $tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,0,$saldo_por_pagar,1,1,
			  $saldo_por_pagar,'$descripcion');";
	
		      $this -> query($insert,$Conex,true);				

			}
		 }	

		
		$this -> query($update,$Conex,true);	
		
		if(is_array($_REQUEST['impuestos'])){
		 $valor_sobre_flete = $valor_sobre_flete>0 ? $valor_sobre_flete : 0;
  		 $baseimpuesto= $valor_sobre_flete+$valor_flete;
		 $base =$baseimpuesto;
		  $impuestos = $_REQUEST['impuestos'];
	
		  for($i = 0; $i < count($impuestos); $i++){
		  
			$detalle_liquidacion_despacho_id = $impuestos[$i]['detalle_liquidacion_despacho_id'];
			$valor                           = $this -> removeFormatCurrency($impuestos[$i]['valor']);
			$impuesto_id                     = $impuestos[$i]['impuesto_id'];
			
			$select = "SELECT i.*,ti.* FROM tabla_impuestos ti, impuesto i WHERE ti.empresa_id = $empresa_id AND ti.oficina_id = $oficina_planillo_id 
			AND ti.impuesto_id = $impuesto_id AND ti.impuesto_id = i.impuesto_id";
			$result     = $this  -> DbFetchAll($select,$Conex,true);	
			$pagar_impuesto_id=$result[0]['pagar_impuesto_id'];

		    if($total_retei>0 && $result[0]['ica']==1 && $result[0]['exentos']=='IC' ){
			  
				if(!is_numeric($pagar_impuesto_id)){ exit("No se ha parametrizado en Tabla Impuestos, El campo Impuesto a Pagar!!"); }
				$select = "SELECT i.*,ti.* FROM tabla_impuestos ti, impuesto i WHERE ti.empresa_id = $empresa_id AND ti.oficina_id = $oficina_planillo_id 
				AND ti.impuesto_id = $impuesto_id AND ti.pagar_impuesto_id = i.impuesto_id";
				$result = $this  -> DbFetchAll($select,$Conex,true);						

		    }

			$puc_id     = $result[0]['puc_id'];
			$naturaleza = $result[0]['naturaleza'];
			
			if($naturaleza == 'D'){
			  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $puc_id,debito = $valor,credito = 0,valor = $valor, base=$base WHERE 
			  detalle_liquidacion_despacho_id = $detalle_liquidacion_despacho_id";		
			  $this -> query($update,$Conex,true);			
			}else{
			  $update = "UPDATE detalle_liquidacion_despacho SET puc_id = $puc_id,debito = 0,credito = $valor,valor = $valor, base=$base WHERE 
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
	
   
   
   
     $valor_total_flete = ($valor_flete + $valor_sobre_flete);

	 if(is_array($_REQUEST['tiempos'])){
		$tiempos = $_REQUEST['tiempos'];	
		for($i = 0; $i < count($tiempos); $i++){	
			 $update = "UPDATE  tiempos_clientes_remesas 
			 			SET fecha_llegada_descargue = '".$tiempos[$i]['fecha_llegada_descargue']."', 
						hora_llegada_descargue = '".$tiempos[$i]['hora_llegada_descargue']."',
			 			fecha_entrada_descargue = '".$tiempos[$i]['fecha_entrada_descargue']."', 
						hora_entrada_descargue = '".$tiempos[$i]['hora_entrada_descargue']."',
						fecha_salida_descargue = '".$tiempos[$i]['fecha_salida_descargue']."', 
						hora_salida_descargue = '".$tiempos[$i]['hora_salida_descargue']."'
						WHERE tiempos_clientes_remesas_id =".$tiempos[$i]['tiempos_clientes_remesas_id']."";
					   //echo $update;
			 $this -> query($update,$Conex,true);  				  	   
		}
	 }

	 if(is_array($_REQUEST['remesa'])){
		$con_rem=0; 
		$acum_costos=0;
		$remesa = $_REQUEST['remesa'];												
																  
		for($i = 0; $i < count($remesa); $i++){	
			if($remesa[$i]['valor_costo']!=''){
				$con_rem++;				
				$acum_costos = $acum_costos + str_replace('.','',$remesa[$i]['valor_costo']); 
			}
		}
		if( count($remesa)==$con_rem){
			$tip_guardar_rem='costo';	
			if($acum_costos!=$valor_total_flete){
				print "<p align='center'>La Sumatoria del Flete + sobre flete, No coincide con la sumatoria de los costos de las remesas!!<br>Por favor verifique</p>";
				$this -> RollBack($Conex);
				exit();
			}
			
		}elseif($con_rem==0){
			$tip_guardar_rem='total';				
		}else{
			print "<p align='center'>Debe de asignar los valores de costo por todas las remesas!!<br>De lo contrario deje todos los campos de valor de costo por remesa vacios e ingrese un valor total de flete</p>";
			$this -> RollBack($Conex);
			exit();
		}
	 }
	 if($tip_guardar_rem=='total'){

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
		   if($remesas[$i]['estado']=='FT' ){
			   $this -> RollBack($Conex);
			  exit("<div align='center'>la remesa ".$remesas[$i]['numero_remesa']." ya esta Facturada, No se puede Actualizar!!!</div>");	 	 
		   }		   
		   
		   
		 }
		 
		 if($valor_facturar_total > 0){
		 
		   for($i = 0; $i < count($remesas); $i++){
		 
			 $remesa_id      = $remesas[$i]['remesa_id'];
			 $valor_facturar = $remesas[$i]['valor_facturar'];
			 $porcentaje     = ($valor_facturar / $valor_facturar_total) * 100 ;
			 $valor_costo    = round(($porcentaje * $valor_total_flete) / 100);
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
	 }elseif($tip_guardar_rem=='costo'){

		 if(is_array($_REQUEST['remesa'])){

			$remesa = $_REQUEST['remesa'];												
																	  
			for($i = 0; $i < count($remesa); $i++){	
				
				 if($remesa[$i]['estado']=='LQ' && $remesa[$i]['valor_costo']!=''){
					 $valor_costo= $remesa[$i]['valor_costo']!='' ? str_replace('.','',$remesa[$i]['valor_costo']): 'NULL';
					 $cantidad= $remesa[$i]['cantidad']!='' ? str_replace('.','',$remesa[$i]['cantidad']): 'NULL';
					 $peso_volumen= $remesa[$i]['peso_volumen']!='' ? str_replace('.','',$remesa[$i]['peso_volumen']): 'NULL';
					 $peso= $remesa[$i]['peso']!='' ? str_replace('.','',$remesa[$i]['peso']): 'NULL';
					 $valor_unidad_costo= $remesa[$i]['valor_unidad_costo']!='' ? str_replace('.','',$remesa[$i]['valor_unidad_costo']): 'NULL';
					 
					 $update = "UPDATE remesa SET valor_costo = ".$valor_costo.", 
								cantidad_costo = ".$cantidad.", 
								peso_volumen_costo = ".$peso_volumen.",
								peso_costo = ".$peso.",
								valor_unidad_costo = ".$valor_unidad_costo.",
								conductor_id = (SELECT conductor_id FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id))
								WHERE remesa_id = ".$remesa[$i]['remesa_id']."";
							  
					 $this -> query($update,$Conex,true);  				  	   
				 }else{
					 $this -> RollBack($Conex);
					 if($remesa[$i]['estado']=='FT' ){
						  exit("<div align='center'>la remesa ".$remesa[$i]['numero_remesa']." ya esta Facturada!!!</div>");	 	 
					 }else{
						 exit("<div align='center'>Debe liquidar la remesa ".$remesa[$i]['numero_remesa']." primero!!!</div>");	 	 
					 }
					 
				 }
			}
		 }
	
	 }
	   
   $this -> setLogTransaction_extra('liquidacion_despacho',$update_log,$Conex,'UPDATE');
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
	m.placa,m.placa_id,m.fecha_entrega_mcia_mc,m.fecha_estimada_salida,ld.autoriza_pago,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,m.origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) 
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
	
	//pedazo johnatan inicio
  	 $select = "SELECT SUM(IF(r.peso_costo>0,r.peso_costo,r.peso)) AS peso, SUM(IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen)) AS peso_volumen,SUM(IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad)) AS cantidad, SUM(r.valor_costo) AS valor_costos
	 FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho  WHERE liquidacion_despacho_id = $liquidacion_despacho_id) AND r.remesa_id=dd.remesa_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 /*	
     $select = "SELECT SUM(r.peso) AS peso, SUM(r.peso_volumen) AS peso_volumen,SUM(r.cantidad) AS cantidad, SUM(r.valor_costo) AS valor_costos
	 FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho  WHERE liquidacion_despacho_id = $liquidacion_despacho_id) AND r.remesa_id=dd.remesa_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex); */
	 
	 if(count($result) > 0){	
	   $liquidacion[0]['valor_costos'] = $result[0][valor_costos];	
	   $liquidacion[0]['peso_total'] = $result[0][peso];	 
	   $liquidacion[0]['peso_vol_total'] = $result[0][peso_volumen];
	   $liquidacion[0]['cantidad_total'] = $result[0][cantidad];
	 }	 

     $select = "SELECT r.remesa_id,r.numero_remesa,r.tipo_liquidacion,IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad) AS cantidad,r.estado,r.valor_facturar,
	 IF(r.peso_costo>0,r.peso_costo,r.peso) AS peso,IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen) AS peso_volumen,r.valor_unidad_costo,r.valor_costo,
	 (SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,
	 (SELECT producto_empresa FROM producto WHERE producto_id = r.producto_id) AS  producto,
	 (SELECT medida FROM medida WHERE   medida_id = r.medida_id) AS unidad
	 FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho  WHERE liquidacion_despacho_id = $liquidacion_despacho_id) AND r.remesa_id=dd.remesa_id";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){	 
	   $liquidacion[0]['remesa_dat'] = $result;	 
	 }

     $select = "SELECT t.*,
	 (SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = t.cliente_id)) AS clientess,
	 (SELECT placa FROM vehiculo WHERE placa_id = t.placa_id) AS  placa
	 FROM  tiempos_clientes_remesas t WHERE t.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho  WHERE liquidacion_despacho_id = $liquidacion_despacho_id) ";	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	 
	 if(count($result) > 0){	 
	   $liquidacion[0]['tiempos_dat'] = $result;	 
	 }	 

	//pedazo johnatan fin
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
	am.anticipos_manifiesto_id  AND am.devolucion=0";	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				 
	if(count($result) > 0){	 
	  $liquidacion[0]['anticipos'] = $result;	 
	}	
		
	return $liquidacion;   
		   
   }
   
       public function cancellation($liquidacion_despacho_id,$manifiesto_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){
  
   $this -> Begin($Conex);
   
     $select =  "SELECT COUNT(de.remesa_id) AS remesas FROM remesa r, detalle_despacho de WHERE r.remesa_id=de.remesa_id AND r.estado = 'FT' AND de.manifiesto_id=$manifiesto_id";
	 
    $result = $this -> DbFetchAll($select,$Conex,true);	
	
	if($result[0]['remesas']>0) exit("Existen remesas ya facturadas asociadas a este manifiesto.<br> NO se puede Anular!!");
     $update = "UPDATE liquidacion_despacho SET estado_liquidacion = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE liquidacion_despacho_id = $liquidacion_despacho_id";
	 
	 $this -> query($update,$Conex,true);
	 
	 $update = "UPDATE manifiesto SET estado = 'M' WHERE manifiesto_id IN (SELECT manifiesto_id FROM liquidacion_despacho WHERE liquidacion_despacho_id = $liquidacion_despacho_id) AND manifiesto_id NOT IN (SELECT manifiesto_id FROM liquidacion_despacho WHERE liquidacion_despacho_id != $liquidacion_despacho_id AND estado_liquidacion!='A' AND manifiesto_id IS NOT NULL)";
	 
	
	 
	 $this -> query($update,$Conex,true);	 	  	 
	 
   $this -> Commit($Conex);
  
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

      $select     = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos WHERE descuento_anticipos=0 ORDER BY nombre ASC";
	  $descuentos = $this -> DbFetchAll($select,$Conex,true);	
	  
	  for($i = 0; $i < count($descuentos); $i++){
	     $descuentos[$i]['comparar'] = $descuentos[$i]['nombre'];	 	  
	     $descuentos[$i]['nombre']   = strtoupper(str_replace('.','',preg_replace( "([ ]+)", "",$descuentos[$i]['nombre'])));	  	  	   	  	  		 
	  }
	  	 	 
	  return $descuentos;        
   
   }
   
   public function getCausalesAnulacion($Conex){
		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion WHERE documento = 'RM' ORDER BY 
		nombre";
		$result = $this -> DbFetchAll($select,$Conex);
		
		return $result;		
		
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