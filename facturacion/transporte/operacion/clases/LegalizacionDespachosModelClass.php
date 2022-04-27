<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class LegalizacionDespachosModel extends Db{
 
  
  public function anticiposGeneroEgreso($despachos_urbanos_id,$Conex){
    
     $select = "SELECT * FROM anticipos_despacho WHERE despachos_urbanos_id = $despachos_urbanos_id";
				
  	 $result = $this  -> DbFetchAll($select,$Conex);	
	 	 
	 for($i = 0; $i < count($result); $i++){
	 
	   $encabezado_registro_id = $result[$i]['encabezado_registro_id'];				
	 
	   if(!is_numeric($encabezado_registro_id)){
	     return false;
	   }
	 
	 }
	 
	 return true;
	 
  }  
  
  public function selectManifiesto($despachos_urbanos_id,$Conex){
  
     $select = "SELECT despachos_urbanos_id,despacho,nombre AS conductor,conductor_id,placa,placa_id,(SELECT nombre FROM ubicacion 
	 WHERE ubicacion_id = m.origen_id) AS origen,origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,destino_id 
	 FROM despachos_urbanos m WHERE despachos_urbanos_id = $despachos_urbanos_id";
	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	
	 return $result;	 
	   
  }
  
  public function selectAnticiposManifiesto($despachos_urbanos_id,$Conex){
  
     $select = "SELECT a.*,(SELECT concat_ws(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE 
	 tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = a.conductor_id)) AS conductor FROM anticipos_despacho a WHERE 
	 despachos_urbanos_id = $despachos_urbanos_id";
	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	
	 return $result;
  
  }
  
  public function selectCostosDeViaje($empresa_id,$oficina_id,$Conex){
  
     $select = "SELECT d.* FROM parametros_legalizacion p,detalle_parametros_legalizacion d WHERE p.empresa_id = $empresa_id AND 
	 p.oficina_id = $oficina_id AND p.parametros_legalizacion_id = d.parametros_legalizacion_id ORDER BY nombre_cuenta ASC";
	 
  	 $result = $this  -> DbFetchAll($select,$Conex);
	
	 return $result;
  
  }

  public function getTotalDebitoCredito($empresa_id,$oficina_id,$legalizacion_despacho_id,$Conex){ 
	  $select = "SELECT SUM(IF(d.naturaleza='D',c.valor,0)) AS debito,SUM(IF(d.naturaleza='C',c.valor,0)) AS credito 
	  FROM costos_viaje_despacho c, detalle_parametros_legalizacion d  
	  WHERE c.legalizacion_despacho_id=$legalizacion_despacho_id AND d.detalle_parametros_legalizacion_id=c.detalle_parametros_legalizacion_id";
      $result = $this -> DbFetchAll($select,$Conex);

	  $select1 = "SELECT SUM(valor) AS anticipos FROM anticipos_despacho WHERE legalizacion_despacho_id = $legalizacion_despacho_id";	
	  $result1 = $this -> DbFetchAll($select1,$Conex,true);	
	
	  $select2 = "SELECT * 	  FROM parametros_legalizacion 
	  WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
      $result2 = $this -> DbFetchAll($select2,$Conex);
	  
	  $debito=0;
	  $credito=0;
	  $dife=0;
	  
	  $credito= $credito+$result[0][credito];
 	  $debito= $debito+$result[0][debito];	  
	  
	  
	  if( $result2[0][naturaleza_contrapartida]=='C'){
		   $credito= $credito+$result1[0][anticipos];
	  }else{
		   $debito= $debito+$result1[0][anticipos];	
	  }
	  
	  $dife=$credito-$debito;
	  
	  if($dife==0){
		$result3[0][debito]=$debito;
		$result3[0][credito]=$credito;		
		return $result3; 
	  }elseif(!$dife==0 &&  $result2[0][diferencia_favor_conductor_id]!=''  &&  $result2[0][diferencia_favor_empresa_id]!=''){
		  
		  if($dife<0){
			  if( $result2[0][naturaleza_diferencia_favor_conductor]=='C'){
				  $credito= $credito+abs($dife);
			  }else{
				  $debito= $debito+abs($dife);
			  }
		  }elseif(dife>0){
			  if( $result2[0][naturaleza_diferencia_favor_empresa]=='C'){
				  $credito= $credito+abs($dife);
			  }else{
				  $debito= $debito+abs($dife);
			  }
		  }
		  $result3[0][debito]=$debito;
		  $result3[0][credito]=$credito;		
	  }else{
		exit('No esta configurado los parametros. Por favor verifique'); 
	  }

	  
	  
  }

  public function Save($Campos,$empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){	
		 
    require_once("UtilidadesContablesModelClass.php");
	
	$UtilidadesContables = new UtilidadesContablesModel();		 
		 
	$legalizacion_despacho_id = $this -> DbgetMaxConsecutive("legalizacion_despacho","legalizacion_despacho_id",$Conex,false,1);	
	$conductor_id             = $this -> requestData('conductor_id');
	$despacho                 = $this -> requestData('despacho');	
    $despachos_urbanos_id	  = $this -> requestData('despachos_urbanos_id');
    $this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('elaboro',$modifica);
	
	
	$select = "SELECT * FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
	
	$dataDespacho = $this  -> DbFetchAll($select,$Conex,true);						
	$placa_id       = $dataDespacho[0]['placa_id'];

	$select = "SELECT * FROM centro_de_costo WHERE placa_id = $placa_id";
	
	$dataCentroVehiculo           = $this  -> DbFetchAll($select,$Conex,true);						
	$centro_costo_vehiculo_id     = $dataCentroVehiculo[0]['centro_de_costo_id'];
	$codigo_centro_costo_vehiculo = "'".$dataCentroVehiculo[0]['codigo']."'";		
		
	$this -> Begin($Conex);

        $this -> assignValRequest('legalizacion_despacho_id',$legalizacion_despacho_id);	
		$this -> DbInsertTable("legalizacion_despacho",$Campos,$Conex,true,false);
		
		if($this -> GetNumError() > 0){
			return false;
		}else{
		
		    if($this -> GetNumError() > 0){
			  return false;
			}else{
						
			  if(is_array($_REQUEST['anticipos'])){
			  
			   $_REQUEST['anticipos'] = array_values($_REQUEST['anticipos']);

               for($i = 0; $i < count($_REQUEST['anticipos']); $i++){
												 
                 $anticipos_despacho_id = $_REQUEST['anticipos'][$i]['anticipos_despacho_id'];
				  
				 $update = "UPDATE anticipos_despacho SET legalizacion_despacho_id = $legalizacion_despacho_id,estado='L' WHERE 
				 anticipos_despacho_id = $anticipos_despacho_id";
				  
				  $this -> query($update,$Conex,true);
					
				  if($this -> GetNumError() > 0){
					return false;
				  }			  
			  
			    }						
				
			  
			  }
			  			  			  
			  if(is_array($_REQUEST['costos_viaje'])){
			  
			   $_REQUEST['costos_viaje'] = array_values($_REQUEST['costos_viaje']);

               for($i = 0; $i < count($_REQUEST['costos_viaje']); $i++){
								
				 $costos_viaje_despacho_id  = $this->DbgetMaxConsecutive("costos_viaje_despacho","costos_viaje_despacho_id",$Conex,false,1);	
				 $detalle_parametros_legalizacion_id = $_REQUEST['costos_viaje'][$i]['detalle_parametros_legalizacion_id'];				  
				 $tercero_id                         = $_REQUEST['costos_viaje'][$i]['tercero_id'];

				 $select = "SELECT CONCAT_WS('',numero_identificacion,digito_verificacion,'-', primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido,razon_social) as tercero  FROM tercero WHERE tercero_id = $tercero_id";
				 $data_tercero = $this  -> DbFetchAll($select,$Conex,true);						
				 $tercero       = $data_tercero[0]['tercero'];
				
				 $valor                              = $this -> removeFormatCurrency($_REQUEST['costos_viaje'][$i]['valor']);
				 if($valor>0 && $tercero_id>0 && $detalle_parametros_legalizacion_id>0){ 
					 $insert = "INSERT INTO costos_viaje_despacho (costos_viaje_despacho_id,detalle_parametros_legalizacion_id,tercero,tercero_id,
					 valor,legalizacion_despacho_id) VALUES ($costos_viaje_despacho_id,$detalle_parametros_legalizacion_id,'$tercero',$tercero_id,
					 $valor,$legalizacion_despacho_id)";
					  
					  $this -> query($insert,$Conex,true);
						
					  if($this -> GetNumError() > 0){
						return false;
					  }			  
				 }
			    }						
				
			  
			  }
						
			
		   }
			
		}
									

	$update = "UPDATE despachos_urbanos SET estado = 'L' WHERE despachos_urbanos_id = $despachos_urbanos_id";	
    $this -> query($update,$Conex,true);		
	
    $this -> Commit($Conex);
		
  }   
	
  public function Update($Campos,$empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){	
		 
    require_once("UtilidadesContablesModelClass.php");
	
	$UtilidadesContables = new UtilidadesContablesModel();		 
		 
	$legalizacion_despacho_id = $this -> requestData('legalizacion_despacho_id');
	$conductor_id             = $this -> requestData('conductor_id');
	$despacho                 = $this -> requestData('despacho');	
    $despachos_urbanos_id	  = $this -> requestData('despachos_urbanos_id');	
			
	$this -> Begin($Conex);

		$this -> DbUpdateTable("legalizacion_despacho",$Campos,$Conex,true,false);
		
		if($this -> GetNumError() > 0){
			return false;
		}else{
		
		      $delete = "DELETE FROM costos_viaje_despacho WHERE legalizacion_despacho_id = $legalizacion_despacho_id";
			  $this -> query($delete,$Conex,true);
		
		
			  if(is_array($_REQUEST['costos_viaje'])){
			  
			   $_REQUEST['costos_viaje'] = array_values($_REQUEST['costos_viaje']);

               for($i = 0; $i < count($_REQUEST['costos_viaje']); $i++){
								
				 $costos_viaje_despacho_id  = $this->DbgetMaxConsecutive("costos_viaje_despacho","costos_viaje_despacho_id",$Conex,false,1);	
				 $detalle_parametros_legalizacion_id = $_REQUEST['costos_viaje'][$i]['detalle_parametros_legalizacion_id'];				  
				 $tercero_id                         = $_REQUEST['costos_viaje'][$i]['tercero_id'];

				 $select = "SELECT CONCAT_WS('',numero_identificacion,digito_verificacion,'-', primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido,razon_social) as tercero  FROM tercero WHERE tercero_id = $tercero_id";
				 $data_tercero = $this  -> DbFetchAll($select,$Conex,true);						
				 $tercero       = $data_tercero[0]['tercero'];
				 
				 $valor                              = $this -> removeFormatCurrency($_REQUEST['costos_viaje'][$i]['valor']);
				 if($valor>0 && $tercero_id>0 && $detalle_parametros_legalizacion_id>0){ 
					 $insert = "INSERT INTO costos_viaje_despacho (costos_viaje_despacho_id,detalle_parametros_legalizacion_id,tercero,tercero_id,
					 valor,legalizacion_despacho_id) VALUES ($costos_viaje_despacho_id,$detalle_parametros_legalizacion_id,'$tercero',$tercero_id,
					 $valor,$legalizacion_despacho_id)";
					  
					  $this -> query($insert,$Conex,true);
						
					  if($this -> GetNumError() > 0){
						return false;
					  }			  
				 }
			    }						
				
			  
			  }
			
		}
									

	$update = "UPDATE despachos_urbanos SET estado = 'L' WHERE despachos_urbanos_id = $despachos_urbanos_id";	
    $this -> query($update,$Conex,true);		
	
    $this -> Commit($Conex);
		
  }
  
  public function contabilizar($empresa_id,$oficina_id,$modifica,$usuario_id,$Conex){
  
	$this -> Begin($Conex);
	
    require_once("UtilidadesContablesModelClass.php");	
	$UtilidadesContables = new UtilidadesContablesModel();    
   
	$encabezado_registro_id     = $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,false,1);		
	$legalizacion_despacho_id   = $this -> requestData('legalizacion_despacho_id');
	$despachos_urbanos_id       = $this -> requestData('despachos_urbanos_id');
	$conductor_id               = $this -> requestData('conductor_id');
 	$fecha                      = $this -> requestData('fecha');      
    $fecha_registro             = date("Y-m-d");
	
	$select = "SELECT * FROM despachos_urbanos WHERE despachos_urbanos_id = $despachos_urbanos_id";
	
	$dataManifiesto = $this  -> DbFetchAll($select,$Conex,true);						
	$placa_id       = $dataManifiesto[0]['placa_id'];

	$select = "SELECT * FROM centro_de_costo WHERE placa_id = $placa_id";
	
	$dataCentroVehiculo           = $this  -> DbFetchAll($select,$Conex,true);						
	$centro_costo_vehiculo_id     = $dataCentroVehiculo[0]['centro_de_costo_id'];
	$codigo_centro_costo_vehiculo = "'".$dataCentroVehiculo[0]['codigo']."'";		

   $select = "SELECT * FROM parametros_legalizacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
   $result = $this  -> DbFetchAll($select,$Conex,true);		   
   
   $tipo_documento_id = $result[0]['tipo_documento_id'];
   
   $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = $conductor_id)";
   $result = $this  -> DbFetchAll($select,$Conex,true);			   
   
   $tercero_id            = $result[0]['tercero_id'];		   		   
   $tercero_diferencia_id = $result[0]['tercero_id'];	
   $numero_identificacion = $result[0]['numero_identificacion'];
   $digito_verificacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';		   		   
		   
   $select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_id";
   $result = $this  -> DbFetchAll($select,$Conex,true);			   
   
   $centro_de_costo_id      = $result[0]['centro_de_costo_id'];
   $codigo_centro_costo     = "'".$result[0]['codigo']."'";		   
   $numero_despacho         = $_REQUEST['despacho'];		
   $numero_soporte          = $_REQUEST['despacho'];		
   $numero_documento_fuente = $_REQUEST['despacho'];		
   $id_documento_fuente     = $_REQUEST['despachos_urbanos_id'];		
   $forma_pago_id           = $_REQUEST['forma_pago_id'];   		   
   $origen                  = $_REQUEST['origen'];   		
   $destino                 = $_REQUEST['destino'];   				      
   $concepto                = $_REQUEST['concepto'];   		   
   $observaciones           = "$origen - $destino";   		   
   $fuente_servicio_cod     = 'DU';		   
   $estado_liquidacion      = 'L';
   $estado                  = 'C';
   
   $periodo_contable_id = $UtilidadesContables -> getPeriodoContableId($fecha,$Conex); 
   $mes_contable_id     = $UtilidadesContables -> getMesContableId($fecha,$periodo_contable_id,$Conex); 
   $consecutivoRegistro = $UtilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$Conex);
   
	$valor = 0;
	
	if(is_array($_REQUEST['anticipos'])){
	
	   for($i = 0; $i < count($_REQUEST['anticipos']); $i++){
          $valor += $_REQUEST['anticipos'][$i]['valor']; 										 		 
	   }
	   
	}   
	   
   $insert = "INSERT INTO  encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,
   tercero_id,periodo_contable_id,mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,
   numero_documento_fuente,id_documento_fuente,anulado,observaciones) VALUES ($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$valor,'$numero_soporte',
   $tercero_id,$periodo_contable_id,$mes_contable_id,$consecutivoRegistro,'$fecha','$concepto','$estado','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod',
   '$numero_documento_fuente',$id_documento_fuente,0,'$observaciones')";
   
   $this -> query($insert,$Conex,true);
   
   $update = "UPDATE legalizacion_despacho SET encabezado_registro_id = $encabezado_registro_id WHERE legalizacion_despacho_id 
   = $legalizacion_despacho_id";
   
   $this -> query($update,$Conex,true);		   
   
   if(!$this -> GetNumError() > 0){
   
		 $select = "SELECT * FROM parametros_legalizacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
		 $result = $this  -> DbFetchAll($select,$Conex,true);					
			
		 $totalDebito                           = 0;
		 $totalCredito                          = 0;					
			
		 $parametros_legalizacion_id            = $result[0]['parametros_legalizacion_id'];
		 $cuenta_puc_anticipos_id               = $result[0]['contrapartida_id'];
		 $base                                  = 0;
		 $naturaleza_contrapartida              = $result[0]['naturaleza_contrapartida'];		   		   
		 $diferencia_favor_conductor_id         = $result[0]['diferencia_favor_conductor_id'];		   		   
		 $naturaleza_diferencia_favor_conductor = $result[0]['naturaleza_diferencia_favor_conductor'];		   		   
		 $diferencia_favor_empresa_id           = $result[0]['diferencia_favor_empresa_id'];		   		   
		 $naturaleza_diferencia_favor_empresa   = $result[0]['naturaleza_diferencia_favor_empresa'];		   		   				 
		
		 $total_anticipos = 0;
		
		  if(is_array($_REQUEST['anticipos'])){

		   $descripcion_diferencia = null;
		   $num_anticipos         = 0;	

		   for($i = 0; $i < count($_REQUEST['anticipos']); $i++){
											 

			 $detalle_liquidacion_despacho_id = $this -> DbgetMaxConsecutive("detalle_liquidacion_despacho","detalle_liquidacion_despacho_id",$Conex,false,1);		   
			 $puc_id                          = $cuenta_puc_anticipos_id;
			 $conductor_id                    = $_REQUEST['anticipos'][$i]['conductor_id'];
			 $numero                          = $_REQUEST['anticipos'][$i]['numero'];
			 $consecutivo                     = $_REQUEST['anticipos'][$i]['consecutivo'];					 
			 $descripcion                     = "ANTICIPO:$consecutivo - DU:$numero_soporte";
			 
			 $descripcion_diferencia .= "$consecutivo,";
			 $num_anticipos++;						 
			 
			 if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){
			 
			  $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = $conductor_id)";
			  $result = $this  -> DbFetchAll($select,$Conex,true);			   
   
			  $tercero_imputacion_id            = $result[0]['tercero_id'];					 
			  $numero_identificacion_imputacion = $result[0]['numero_identificacion'];					 
			  $digito_verificacion_imputacion   = is_numeric($result[0]['digito_verificacion']) ? $result[0]['digito_verificacion'] : 'NULL';
			  
			 }else{
				  $tercero_imputacion_id            = 'NULL';					 
				  $numero_identificacion_imputacion = 'NULL';					 
				  $digito_verificacion_imputacion   = 'NULL';	
			   }  					 
			 
			 if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
			   $centro_de_costo_imputacion_id  = $centro_de_costo_id ;
			   $codigo_centro_costo_imputacion = $codigo_centro_costo;
			 }else{
				 $centro_de_costo_imputacion_id  = 'NULL';
				 $codigo_centro_costo_imputacion = 'NULL';					 
			   }

			 $valor = $this -> removeFormatCurrency($_REQUEST['anticipos'][$i]['valor']);
			 
			 if($naturaleza_contrapartida == 'D'){
			   $debito  = $valor;
			   $credito = 0;
			 }else{
				 $debito  = 0;
				 $credito = $valor;					 
			   }
			   
		
			 $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);	
			 
			 $totalDebito   += $debito;
			 $totalCredito  += $credito;					 	   				
		
			 $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,base,valor,debito,credito,descripcion) 
			 VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$puc_id,$encabezado_registro_id,$centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,$base,$valor,$debito,$credito,'$descripcion')";
			  
			  $this -> query($insert,$Conex,true);
				
			  if($this -> GetNumError() > 0){
				return false;
			  }	
			  
			  $total_anticipos += $valor;	  
		  
			}						
			
		  
		  }	
		  
		  $descripcion_diferencia = substr($descripcion_diferencia,0,strlen($descripcion_diferencia) - 1);
		  
		  if($num_anticipos > 1){
			$descripcion_diferencia  = "ANTICIPOS: $descripcion_diferencia  - MC:$numero_soporte";
		  }else{
			 $descripcion_diferencia = "ANTICIPO: $descripcion_diferencia - MC:$numero_soporte";				  
			}				  
		  
		  $total_costos_viaje = 0;
		  
		  if(is_array($_REQUEST['costos_viaje'])){
						  

			for($i = 0; $i < count($_REQUEST['costos_viaje']); $i++){				  
							  
			  $detalle_parametros_legalizacion_id = $_REQUEST['costos_viaje'][$i]['detalle_parametros_legalizacion_id'];				  				  				      $imputacion_contable_id             = $this->DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);							  
			  $select  = "SELECT * FROM detalle_parametros_legalizacion WHERE detalle_parametros_legalizacion_id = 
			  $detalle_parametros_legalizacion_id";
			  $result  = $this  -> DbFetchAll($select,$Conex,true);
			  
			  $puc_id        = $result[0]['puc_id'];
			  $naturaleza    = $result[0]['naturaleza'];
			  $nombre_cuenta = $result[0]['nombre_cuenta']; 					  
			  $tercero_id    = $_REQUEST['costos_viaje'][$i]['tercero_id'];
			  $base       = 0;
			  $valor      = $this -> removeFormatCurrency($_REQUEST['costos_viaje'][$i]['valor']);
			  
			  if($naturaleza == 'D'){
				$debito  = $valor;
				$credito = 0;
			  }else{
				  $debito  = 0;
				  $credito = $valor;					  
				}
				
			  $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);
			  
			 if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){
			 
			  $tercero_imputacion_id            = $tercero_id;					 
			  $numero_identificacion_imputacion = $numero_identificacion;					 
			  $digito_verificacion_imputacion   = is_numeric($digito_verificacion) ? $digito_verificacion : 'NULL';					 
			  
			 }else{
				  $tercero_imputacion_id            = 'NULL';					 
				  $numero_identificacion_imputacion = 'NULL';					 
				  $digito_verificacion_imputacion   = 'NULL';	
			   }  					 
			 
			 if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
			   
				  if(is_numeric($centro_costo_vehiculo_id)){
					$centro_de_costo_imputacion_id  = $centro_costo_vehiculo_id;
					$codigo_centro_costo_imputacion = $codigo_centro_costo_vehiculo;
				  }else{						  
					  $centro_de_costo_imputacion_id  = $centro_de_costo_id;
					  $codigo_centro_costo_imputacion = $codigo_centro_costo;						  						
					}
								   
			 }else{
				 $centro_de_costo_imputacion_id  = 'NULL';
				 $codigo_centro_costo_imputacion = 'NULL';					 
			   }	
			   
			   
			  $descripcion = "$nombre_cuenta - DU:$numero_soporte";		
			  
			 $totalDebito   += $debito;
			 $totalCredito  += $credito;					  		  		   				
		
			  $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,base,valor,debito,credito,descripcion) 
			  VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$puc_id,$encabezado_registro_id,$centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,$base,$valor,$debito,$credito,'$descripcion')";
			  
			  $this -> query($insert,$Conex,true);
				
			  if($this -> GetNumError() > 0){
				return false;
			  }							
			  
			$total_costos_viaje += $valor;
			}
		  
		  
		  }				  			
   
	 
	  $diferencia = abs($total_anticipos - $total_costos_viaje);
	
	  if($total_anticipos > $total_costos_viaje){
	  
		$puc_id = $diferencia_favor_empresa_id;
		
		if($naturaleza_diferencia_favor_empresa == 'D'){
		  $debito  = $diferencia;
		  $credito = 0;			
		}else{
		   $debito  = 0;
		   $credito = $diferencia;							
		 }

	  }else{
	  
		  $puc_id = $diferencia_favor_conductor_id;
		  
		  if($naturaleza_diferencia_favor_conductor == 'D'){

			$debito  = $diferencia;
			$credito = 0;			
		  }else{
			 $debito  = 0;
			 $credito = $diferencia;							
		   }				  
		  
		  
	   }
	   
	 $select = "SELECT * FROM puc WHERE puc_id = $puc_id";
	 $result = $this  -> DbFetchAll($select,$Conex,true);			 
	 
	 if(!count($result) > 0){
	   exit("<p align='center'>La cuenta que se utiliza como contrapartida no esta bien configurada<br>Por favor revise : Costos vehiculo !!!</p>");			 
	 }
	  
	  
	 $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,false,1);		   				
	 $tercero_id             = $tercero_diferencia_id;
	 $base                   = 0;
	 
	 if($UtilidadesContables -> requiereTercero($puc_id,$Conex)){
	 
	  $tercero_imputacion_id            = $tercero_id;					 
	  $numero_identificacion_imputacion = $numero_identificacion;					 
	  $digito_verificacion_imputacion   = is_numeric($digito_verificacion) ? $digito_verificacion : 'NULL';				 
	  
	 }else{
		  $tercero_imputacion_id            = 'NULL';					 
		  $numero_identificacion_imputacion = 'NULL';					 
		  $digito_verificacion_imputacion   = 'NULL';	
	   }  					 
	 
	 if($UtilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
	   $centro_de_costo_imputacion_id  = $centro_de_costo_id ;
	   $codigo_centro_costo_imputacion = $codigo_centro_costo;
	 }else{
		 $centro_de_costo_imputacion_id  = 'NULL';
		 $codigo_centro_costo_imputacion = 'NULL';					 
	   }		
	   
			 $totalDebito   += $debito;
			 $totalCredito  += $credito;			   		 
					
	 $insert = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,base,valor,debito,credito,descripcion) 
			 VALUES ($imputacion_contable_id,$tercero_imputacion_id,$numero_identificacion_imputacion,$digito_verificacion_imputacion,$puc_id,$encabezado_registro_id,$centro_de_costo_imputacion_id,$codigo_centro_costo_imputacion,$base,$valor,$debito,$credito,'$descripcion_diferencia')";					  
			 
	  $this -> query($insert,$Conex,true);
				
	  if($this -> GetNumError() > 0){
		return false;
	  }	  
   
   
	}		   		

	
	$update = "UPDATE despachos_urbanos SET estado = 'L' WHERE despachos_urbanos_id = $despachos_urbanos_id";	
    $this -> query($update,$Conex,true);	
	
	if($totalDebito == $totalCredito){
	
	   $this -> Commit($Conex);	
	
	   $select         = "SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = $tipo_documento_id";
       $result         = $this -> DbFetchAll($select,$Conex);		
	   $tipo_documento = $result[0]['nombre'];
	
       $arrayResponse = array();
	   $arrayResponse = array(tipo_documento => $tipo_documento, consecutivo => $consecutivoRegistro, legalizacion_manifiesto_id => $legalizacion_manifiesto_id, encabezado_registro_id => $encabezado_registro_id);
	
	
	}else{
	
	   $this -> RollBack($Conex);	
	
       $arrayResponse = array();
	   $arrayResponse = array(error => "<div align='center'>No existen sumas iguales, por favor verifique los parametros de legalizacion</div><div align='center'><br>Por <b>Modulo Transporte -> Parametros Modulo -> Costos Vehiculos</b></div>");
	   	    
	  }

   return $arrayResponse;		
		  
  
  }
	
  public function Delete($Campos,$Conex){
  
  	$this -> DbDeleteTable("parametros_anticipo",$Campos,$Conex,true,false);
	
  }				 	
	   
   public function selectLegalizacionDespachos($legalizacion_despacho_id,$Conex){
	   	   	  
	$dataLegalizacion = array();
    				
    $select = "SELECT l.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = l.origen_id) AS origen,(SELECT nombre FROM ubicacion 
	WHERE ubicacion_id = l.destino_id) AS destino FROM legalizacion_despacho l WHERE legalizacion_despacho_id = $legalizacion_despacho_id";				
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	$dataLegalizacion[0]['legalizacion_despacho'] = $result;
	
    $select = "SELECT * FROM anticipos_despacho WHERE legalizacion_despacho_id = $legalizacion_despacho_id";	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				
	$dataLegalizacion[0]['anticipos_despacho'] = $result;	
	
    $select = "SELECT c.*, CONVERT(c.tercero USING latin1) FROM costos_viaje_despacho c WHERE c.legalizacion_despacho_id = $legalizacion_despacho_id";	
	$result = $this -> DbFetchAll($select,$Conex,true);	
				
	$dataLegalizacion[0]['costos_viaje_despacho'] = $result;		
		
	return $dataLegalizacion;   
		   
   }
   
   public function selectOficinasEmpresa($empresa_id,$oficina_id,$Conex){
   
     $select = "SELECT oficina_id AS value,nombre AS text,'$oficina_id' AS selected FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);	
   
     return $result;
   
   }
   
   	public function getFormasPago($Conex){
	
	   $select = "SELECT forma_pago_id AS value,nombre AS text FROM forma_pago ORDER BY nombre ASC";
       $result = $this -> DbFetchAll($select,$Conex,false);
     
       return $result;  		  	   
	   	
	}
	
   
   public function getQueryLegalizacionGrid(){
	   	   
     $Query = "SELECT (SELECT razon_social FROM tercero WHERE tercero_id = (SELECT tercero_id FROM empresa WHERE empresa_id = p.empresa_id)) AS empresa,(SELECT nombre FROM oficina WHERE oficina_id = p.oficina_id) AS oficina,(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id = p.tipo_documento_id) AS tipo_documento,(SELECT codigo_puc FROM puc WHERE puc_id = p.puc_id) AS puc,p.nombre,p.naturaleza FROM parametros_anticipo p ";
   
     return $Query;
   }
   

}

?>