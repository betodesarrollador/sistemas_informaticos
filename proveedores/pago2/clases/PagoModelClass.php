<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class PagoModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosPagoId($abono_factura_proveedor_id,$Conex){
     $select    = "SELECT a.*,
	 					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=a.encabezado_registro_id) AS numero_soporte
					FROM abono_factura_proveedor  a 
	                WHERE a.abono_factura_proveedor_id = $abono_factura_proveedor_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }

   public function GetTipoPago($Conex){
	   
	   
	   
	return $this -> DbFetchAll("SELECT c.cuenta_tipo_pago_id AS value,(SELECT CONCAT_WS(' ',codigo_puc,nombre) AS nombre FROM puc WHERE puc_id=c.puc_id ) AS text FROM cuenta_tipo_pago c WHERE c.forma_pago_id = 15",$Conex,
	$ErrDb = false);
	
	/*return $this -> DbFetchAll("SELECT puc_id as value,CONCAT_WS(' - ',nombre,puc_id) as text FROM parametros_descuento_factura_proveedor WHERE estado=1",$Conex,
	$ErrDb = false);
	*/
   }
   
   public function GetDocumento($Conex){
	return $this -> DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento  WHERE de_cierre=0 AND de_traslado=0 AND pago_factura_proveedor=1",$Conex,
	$ErrDb = false);
   }

   public function getDocumentorev($Conex){
	return $this -> DbFetchAll("SELECT tipo_documento_id  AS value,nombre AS text FROM tipo_de_documento  WHERE de_cierre=0 AND de_traslado=0 AND pago_factura_proveedor=1",$Conex,
	$ErrDb = false);
   }

  public function getCausalesAnulacion($Conex){
		
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;		
  }


  public function getDataCliente($cliente_id,$Conex){

     $select = "SELECT tr.numero_identificacion AS cliente_nit
	 			FROM cliente c, tercero tr 
				WHERE c.cliente_id=$cliente_id AND tr.tercero_id = c.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }  
  public function SelectSolicitud($factura_proveedor_id,$Conex){
  
    $select = "SELECT
				CASE f.fuente_factura_proveedorcion_cod WHEN 'OS' THEN 'Ordenes de Servicio' ELSE 'Remesas' END AS tipo,
				f.consecutivo_factura_proveedor
				FROM factura_proveedor f
				WHERE f.factura_proveedor_id=$factura_proveedor_id";

	$result = $this -> DbFetchAll($select,$Conex,false);

	return $result;  
  
  }
  
  public function getDataFactura($abono_factura_proveedor_id,$Conex){

     $select = "SELECT 
						(SELECT t.numero_identificacion FROM  cliente p, tercero t WHERE p.cliente_id=a.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_nit,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM  cliente p, tercero t WHERE p.cliente_id=a.cliente_id AND  t.tercero_id=p.tercero_id ) AS cliente_nombre						
	 			FROM abono_factura_proveedor a
				WHERE a.abono_factura_proveedor_id = $abono_factura_proveedor_id ";

     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }  
  
 /*  public function Save($empresa_id,$oficina_id,$usuario_id,$Campos,$Conex){  
  
    include_once("UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 
	  
 	$this -> Begin($Conex);
		
	  $fecha					 =	$this -> requestDataForQuery("fecha","integer");
	  $fechaMes                  = substr($fecha,0,10);	
	  $oficina_id                = $this -> requestDataForQuery("oficina_id","integer");	  
	  $tipo_documento_id 	     = $this -> requestDataForQuery("tipo_documento_id","integer");
      $encabezado_de_registro_id = $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);
	  $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	  $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	  $consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);
	  $descripcion            	 = $this -> requestDataForQuery("concepto","text");
	  $puc_id        			 = $this -> requestDataForQuery("cuenta_tipo_pago_id","integer");
	  $valor         			 = $this -> requestDataForQuery("valor","integer");
	  $cliente_id         			 = $this -> requestDataForQuery("cliente_id","integer");
	  $valor_encabezado          = str_replace(",",".",str_replace(".","",$valor));	 
	   
	  $sel_tercero ="SELECT tercero_id FROM cliente WHERE cliente_id=$cliente_id";
	  $res_tercero = $this -> DbFetchAll($sel_tercero,$Conex); 
	  $tercero_id    = $res_tercero[0]['tercero_id'];	 
	   
      $fecha_registro=date("Y-m-d h:i:s");	
      $this -> assignValRequest('encabezado_registro_id',$encabezado_de_registro_id);		
      $this -> assignValRequest('periodo_contable_id',$periodo_contable_id);		
      $this -> assignValRequest('mes_contable_id',$mes_contable_id);		
      $this -> assignValRequest('consecutivo',$consecutivo);		
      $this -> assignValRequest('anulado','0');			  
	
	   $select = "SELECT CONCAT(primer_nombre,' ',segundo_nombre,' ',primer_apellido,' ',segundo_apellido,'-',numero_identificacion) AS usuario FROM tercero 
	   WHERE tercero_id = (SELECT tercero_id FROM usuario WHERE usuario_id = $usuario_id)";
	   $result = $this -> DbFetchAll($select,$Conex,true);
	   
	   $modifica= $result[0]['usuario'];	   	 
		
    
     $insert_encabezado ="INSERT INTO encabezado_de_registro(encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id)
	 VALUES ($encabezado_de_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$valor_encabezado,$tercero_id,$periodo_contable_id,$mes_contable_id,$consecutivo,'$fecha',$descripcion,$puc_id,'A','$fecha_registro','$modifica',$usuario_id)";
	//echo $insert_encabezado;
	 $this -> query($insert_encabezado,$Conex,true);	   						
			 
	  if(!strlen(trim($this -> GetError())) > 0){
	  
	   if(is_numeric($puc_id)){
	  
	     if(!$utilidadesContables -> requiereTercero($puc_id,$Conex)){
		    $tercero_id            = 'NULL';
			$numero_identificacion = 'NULL';
			$digito_verificacion   = 'NULL';
			
		 }else{
		  
		   if(is_numeric($tercero_id)){
			   
			 $numero_identificacion = $utilidadesContables -> getNumeroIdentificacionTercero($tercero_id,$Conex);
			 $digito_verificacion   = $utilidadesContables -> getDigitoVerificacionTercero($tercero_id,$Conex);
			 
			 if(!is_numeric($digito_verificacion)){ $digito_verificacion = 'NULL';}
			
			} 
			 
		   }
		
		 if($utilidadesContables -> requiereCentroCosto($puc_id,$Conex)){
		 
		    $centro_de_costo_id  = $utilidadesContables -> getCentroCostoId($oficina_id,$Conex);
			$codigo_centro_costo = $utilidadesContables -> getCentroCostoCod($oficina_id,$Conex);
		   
		 }else{
		     $centro_de_costo_id  = 'NULL';
			 $codigo_centro_costo = 'NULL';
		   }
		   
		 if(($utilidadesContables -> requiereTercero($puc_id,$Conex) && !is_numeric($tercero_id)) || ($utilidadesContables -> requiereCentroCosto($puc_id,$Conex) && !is_numeric($centro_de_costo_id))){
			
	        $this -> Commit($Conex);		 
  	        return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));			
			
		 }else{
		
             $imputacion_contable_id = $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);		 
			 
			 $select_natu = "SELECT naturaleza FROM parametros_descuento_factura_proveedor WHERE puc_id=$puc_id ";
			 $result_natu =  $result = $this -> DbFetchAll($select_natu,$Conex); 
	
			 $naturaleza             = $result_natu[0]['naturaleza'];
			 
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
	                    VALUES ($imputacion_contable_id,$encabezado_de_registro_id,$puc_id,$tercero_id,$numero_identificacion,$digito_verificacion,$centro_de_costo_id,$codigo_centro_costo,$descripcion,$base,$debito,$credito)";		 
				//echo $insert;		
               $this -> query($insert,$Conex,true);	   						
			 
			 }
			 
			 
			 //INSERCION DE LOS IMPUESTOS 
			 $factura_proveedor_id= $this -> requestData('factura_proveedors');	  
			 
			 $puc = "SELECT c.puc_id,c.natu_bien_servicio_factura_proveedor FROM codpuc_bien_servicio_factura_proveedor c WHERE c.tipo_bien_servicio_factura_proveedor_id= (SELECT tipo_bien_servicio_factura_proveedor_id FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id) AND ( (c.natu_bien_servicio_factura_proveedor='D') OR ((c.natu_bien_servicio_factura_proveedor='C' AND c.puc_id IN (SELECT puc_id FROM impuesto WHERE estado='A')) ))";
			 $result = $this -> DbFetchAll($puc,$Conex); 
		 //echo $puc;
			foreach($result as $result_items){
				
				$naturaleza = $result_items['natu_bien_servicio_factura_proveedor'];
				
				$select_requ   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio 
							FROM puc WHERE puc_id =$result_items[puc_id]"; 
							
				 $requires = $this -> DbFetchAll($select_requ,$Conex,true);
				
				 $centro_de_costo_id	   = $requires[0]['requiere_centro_costo'] == 1 ? $centro_de_costo_id : 'NULL';
				 $codigo_centro_costo	   = $requires[0]['requiere_centro_costo'] == 1 ? $codigo_centro_costo : 'NULL';
				 $tercero_id		       = $requires[0]['requiere_tercero']      == 1 ? $tercero_id : 'NULL';
				 $numero_identificacion = $requires[0]['requiere_tercero']      == 1 ? $numero_identificacion : 'NULL';
				 $digito_verificacion   = $requires[0]['requiere_tercero']      == 1 ? $digito_verificacion : 'NULL';
				 
				 $select = "SELECT impuesto_id FROM impuesto_oficina WHERE empresa_id = $empresa_id
							AND oficina_id = $oficina_id
							AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $result_items[puc_id])";
							//echo $select;
				  $impuesto = $this -> DbFetchAll($select,$Conex,true);				
				  
				  if(count($impuesto) > 0){
						
						$impuesto_id =  $impuesto[0]['impuesto_id'] ;
						$select_impuesto = "SELECT porcentaje,formula FROM impuesto_periodo_contable WHERE periodo_contable_id=$periodo_contable_id AND impuesto_id= $impuesto_id ";
						//echo $select_impuesto;
						$result_impuesto = $this -> DbFetchAll($select_impuesto,$Conex,true);	
						
						$select_descripcion ="SELECT descripcion FROM impuesto WHERE impuesto_id = $impuesto_id";
						$result_descripcion = $this -> DbFetchAll($select_descripcion,$Conex,true);	
						
						$descripcion = "'".$result_descripcion[0]['descripcion']."'";
						
						  $porcentaje    = $result_impuesto[0]['porcentaje'];
						  $formula       = $result_impuesto[0]['formula'];
						  $base          = str_replace(",",".",str_replace(".","",$valor));	 
							  
						  $calculo = str_replace("BASE",$base,$formula);
						  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
							  
						  $select     = "SELECT $calculo AS valor_total";
						 // echo $select;
						  $result     = $this -> DbFetchAll($select ,$Conex,true);
						  $valorTotal = round($result[0]['valor_total']);
							
							if($naturaleza == 'D'){
								$debito  = $valorTotal;
								$credito = 0;
							}else{
								$debito  = 0;
								$credito = $valorTotal;
							}	
							
					}else {
						 $valor          = str_replace(",",".",str_replace(".","",$valor));	 
						
						   if($naturaleza == 'D'){
								$debito  = $valor;
								$credito = 0;
							}else{
								$debito  = 0;
								$credito = $valor;
							}	
					}
				
				$insert = "INSERT INTO imputacion_contable (imputacion_contable_id,encabezado_registro_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,descripcion,base,debito,credito) 
	                    VALUES ($imputacion_contable_id,$encabezado_de_registro_id,$result_items[puc_id],$tercero_id,$numero_identificacion,$digito_verificacion,$centro_de_costo_id,$codigo_centro_costo,$descripcion,$base,$debito,$credito)";	
						
				$this -> query($insert,$Conex,true);	   						
			 
					
			}
				
	         $this -> Commit($Conex);		 
  	       return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));			
				 
		 
		   }  
	   	
	  
	   }else{
	   
	      $this -> Commit($Conex);		 
  	      //return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));	   
		 return array(array(encabezado_registro_id => $encabezado_de_registro_id, consecutivo => $consecutivo));			
			
	   
	     }
	  

	 }
	  
  }
*/

  public function Save($empresa_id,$Campos,$Conex){	

	include_once("UtilidadesContablesModelClass.php");
	$utilidadesContables = new UtilidadesContablesModel(); 
	
    $this -> Begin($Conex);
	
	$abono_factura_proveedor_id = $this -> DbgetMaxConsecutive("abono_factura_proveedor","abono_factura_proveedor_id",$Conex,true,1);
	$numero_soporte 			= $this -> requestDataForQuery('numero_soporte','alphanum');
	$cuenta_tipo_pago_id		= $this -> requestDataForQuery('cuenta_tipo_pago_id','integer');
	$tipo_documento_id 			= $this -> requestDataForQuery('tipo_documento_id','integer');
	$cliente_id 				= $this -> requestDataForQuery('cliente_id','integer');	
	$fecha 						= $this -> requestDataForQuery('fecha','date');	
	$num_cheque 				= $this -> requestDataForQuery('num_cheque','text');	
	$concepto_abono_factura_proveedor 	= $this -> requestDataForQuery('concepto_abono_factura_proveedor','text');	
	$causaciones_abono_factura_proveedor 	= $this -> requestDataForQuery('causaciones_abono_factura_proveedor','text');	
	$descuentos_items 			= $this -> requestDataForQuery('descuentos_items','text');	
	$valores_abono_factura_proveedor 		= $this -> requestDataForQuery('valores_abono_factura_proveedor','text');	
	$valor_descu_factura_proveedor  		= $this -> requestDataForQuery('valor_descu_factura_proveedor','numeric');	
	$valor_neto_factura_proveedor  		= $this -> requestDataForQuery('valor_neto_factura_proveedor','numeric');		
	$usuario_id 				= $this -> requestDataForQuery('usuario_id','integer');		  	  
	$oficina_id					= $this -> requestDataForQuery('oficina_id','integer');		  
	$ingreso_abono_factura_proveedor		= $this -> requestDataForQuery('ingreso_abono_factura_proveedor','date');
	$estado_abono_factura_proveedor 		= $this -> requestDataForQuery('estado_abono_factura_proveedor','alphanum');
	$observaciones				= $this -> requestDataForQuery('observaciones','text');
	$fact_comp='';
	
	$observaciones 				=str_replace("'","",$observaciones);
	 $fechaMes                  = substr(str_replace("'","",$fecha),0,10);		
	 $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	 $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
	  
	
	
	$descuentos_frac = explode('=',$descuentos_items);
	$id_des_ind		 ='';
	$value_des		 ='';
	$x=0;

	foreach($descuentos_frac as $descu_frac){
		$id_descu=explode('-',$descu_frac);
		if($id_descu[1]!='' && $id_descu[0]!=''){
			$id_des_ind[$x]=$id_descu[1];
			$value_des[$x]=$id_descu[0];
			$x++;
		}
	}

	$causacion_id				= str_replace("'","",$causaciones_abono_factura_proveedor);
	$causacion_id				= explode(',',$causacion_id);

	$valores_id					= str_replace("'","",$valores_abono_factura_proveedor);
	$valores_id					= explode('=',$valores_id);
	$valor_tot_pago				= 0;
	
	foreach($valores_id as $valor_pago){
		$valor_pagos = str_replace(".","",$valor_pago);
		$valor_pagos = str_replace(",",".",$valor_pagos);		
		$valor_tot_pago = $valor_tot_pago+$valor_pagos;
	}
	
	$select_codigo ="SELECT codigo FROM tipo_de_documento WHERE tipo_documento_id=$tipo_documento_id";
 	 $result_codigo = $this -> DbFetchAll($select_codigo,$Conex,false);
	 $codigo_documento = $result_codigo[0]['codigo'];
	 
	 $select_sucursal ="SELECT codigo_centro FROM oficina WHERE oficina_id = $oficina_id";
	 $result_sucursal = $this -> DbFetchAll($select_sucursal,$Conex,false);
	 $codigo_sucursal = $result_sucursal[0]['codigo_centro'];
	 
	 $consecutivo_final = str_pad($abono_factura_proveedor_id, 5, "0", STR_PAD_LEFT);
	 
	 $consecutivo_documento = $codigo_sucursal.$codigo_documento.$consecutivo_final;
	 
	  $sel_tercero ="SELECT tercero_id FROM cliente WHERE cliente_id=$cliente_id";
	  $res_tercero = $this -> DbFetchAll($sel_tercero,$Conex); 
	  $tercero_id    = $res_tercero[0]['tercero_id'];	
	  
	   if(is_numeric($tercero_id)){
		 
			 $numero_identificacion = $utilidadesContables -> getNumeroIdentificacionTercero($tercero_id,$Conex);
			 $digito_verificacion   = $utilidadesContables -> getDigitoVerificacionTercero($tercero_id,$Conex);
			 
			 if(!is_numeric($digito_verificacion)) $digito_verificacion = 'NULL';
			
			} 

 	$centro_de_costo_id  = $utilidadesContables -> getCentroCostoId($oficina_id,$Conex);
	$codigo_centro_costo = $utilidadesContables -> getCentroCostoCod($oficina_id,$Conex);
	
	
	$insert = "INSERT INTO abono_factura_proveedor (abono_factura_proveedor_id,cuenta_tipo_pago_id,num_cheque,tipo_documento_id,cliente_id,fecha,valor_abono_factura_proveedor,valor_descu_factura_proveedor,valor_neto_factura_proveedor,concepto_abono_factura_proveedor,causaciones_abono_factura_proveedor,descuentos_items,valores_abono_factura_proveedor,usuario_id,oficina_id,ingreso_abono_factura_proveedor,estado_abono_factura_proveedor,consecutivo_documento) 
				VALUES ($abono_factura_proveedor_id,$cuenta_tipo_pago_id,$num_cheque,$tipo_documento_id,$cliente_id,$fecha,'$valor_tot_pago',$valor_descu_factura_proveedor,$valor_neto_factura_proveedor,$concepto_abono_factura_proveedor,$causaciones_abono_factura_proveedor,$descuentos_items,$valores_abono_factura_proveedor,$usuario_id,$oficina_id,$ingreso_abono_factura_proveedor,$estado_abono_factura_proveedor,$consecutivo_documento)"; 
				
	$this -> query($insert,$Conex);

	$select_clien = "SELECT 
					CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente
					FROM cliente p, tercero t WHERE p.cliente_id=$cliente_id AND t.tercero_id=p.tercero_id"; 
	$result_clien = $this -> DbFetchAll($select_clien,$Conex,true);	

	$select_tipo = "SELECT c.puc_id,
					p.requiere_centro_costo,
					p.requiere_tercero,
					c.cuenta_tipo_pago_natu, 
					TRIM(p.nombre) AS nombre,
					(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS por_emp,					  
					(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
					WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS for_emp					  
					FROM cuenta_tipo_pago c, puc p WHERE c.cuenta_tipo_pago_id=$cuenta_tipo_pago_id AND p.puc_id=c.puc_id"; 

	$result_tipo = $this -> DbFetchAll($select_tipo,$Conex);			
	$puc_tipo 	 = $result_tipo[0][puc_id];
	$pucnom_tipo = 'NOTA CREDITO: '.$result_clien[0][cliente];
	$porcen_tipo = $result_tipo[0][por_emp];	
	$formul_tipo = $result_tipo[0][for_emp];
	$natu_tipo 	 = $result_tipo[0][cuenta_tipo_pago_natu];

	$j=0;	
	$final_credito_pago=0;
	$final_debito_pago=0;
	
	
	
	foreach($causacion_id as $causaciones){
		
		 if($causaciones>0){
			
			$valor_debito_total = 0 ;
			$valor_credito_total = 0 ;
			
			$relacion_abono_id 			= $this -> DbgetMaxConsecutive("relacion_abono","relacion_abono_id",$Conex,true,1);	
			$insert_item = "INSERT INTO relacion_abono (relacion_abono_id,factura_proveedor_id,abono_factura_proveedor_id,rel_valor_abono,rel_valor_descu) 
						VALUES ($relacion_abono_id,$causaciones,$abono_factura_proveedor_id,'$valor_neto_factura_proveedor',0)"; 
			$this -> query($insert_item,$Conex);	
			//echo $insert_item;
			 
			//Inicio nuevos items
			
			/*$select_pago = "SELECT c.puc_id FROM cuenta_tipo_pago c WHERE c.cuenta_tipo_pago_id=$cuenta_tipo_pago_id";
			$result_pago = $this -> DbFetchAll($select_pago,$Conex); 
			
			$puc_pago    = $result_pago[0][puc_id];
			
			$select_requ   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio 
							FROM puc WHERE puc_id =$puc_pago"; 
							
				 $requires = $this -> DbFetchAll($select_requ,$Conex,true);
				
				 $centro_de_costo_id	   = $requires[0]['requiere_centro_costo'] == 1 ? $centro_de_costo_id : 'NULL';
				 $codigo_centro_costo	   = $requires[0]['requiere_centro_costo'] == 1 ? $codigo_centro_costo : 'NULL';
				 $tercero_id		       = $requires[0]['requiere_tercero']      == 1 ? $tercero_id : 'NULL';
				 $numero_identificacion = $requires[0]['requiere_tercero']      == 1 ? $numero_identificacion : 'NULL';
				 $digito_verificacion   = $requires[0]['requiere_tercero']      == 1 ? $digito_verificacion : 'NULL';
					
				 $debito_pago       = str_replace(",",".",str_replace(".","",$valor_neto_factura_proveedor));	 
				 $credito_pago      = 0;*/
				 
				 
				 $puc = "SELECT c.puc_id FROM codpuc_bien_servicio_factura_proveedor c WHERE c.tipo_bien_servicio_factura_proveedor_id= (SELECT tipo_bien_servicio_factura_proveedor_id FROM factura_proveedor WHERE factura_proveedor_id=$causaciones) AND contra_bien_servicio_factura_proveedor = 1";
			 $result = $this -> DbFetchAll($puc,$Conex); 
			
			$puc_final 		= $result[0]['puc_id'];
			
			$select_requ   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio 
							FROM puc WHERE puc_id =$puc_final"; 
							
				 $requires = $this -> DbFetchAll($select_requ,$Conex,true);
				
				 $centro_de_costo_id	   = $requires[0]['requiere_centro_costo'] == 1 ? $centro_de_costo_id : 'NULL';
				 $codigo_centro_costo	   = $requires[0]['requiere_centro_costo'] == 1 ? $codigo_centro_costo : 'NULL';
				 $tercero_id		       = $requires[0]['requiere_tercero']      == 1 ? $tercero_id : 'NULL';
				 $numero_identificacion = $requires[0]['requiere_tercero']      == 1 ? $numero_identificacion : 'NULL';
				 $digito_verificacion   = $requires[0]['requiere_tercero']      == 1 ? $digito_verificacion : 'NULL';
				 
				 $descripcion = "$observaciones";
				 $debito_pago       = str_replace(",",".",str_replace(".","",$valor_neto_factura_proveedor));	 
				 $credito_pago      = 0;
				 
				$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
				$insert_pago = "INSERT INTO item_abono (
							item_abono_id,						
							abono_factura_proveedor_id,
							relacion_abono_id,
							puc_id,
							tercero_id,
							numero_identificacion,
							digito_verificacion,
							centro_de_costo_id,
							codigo_centro_costo,
							porcentaje_abono,
							formula_abono,
							desc_abono,
							deb_item_abono,
							cre_item_abono) 
					VALUES (
							$item_abono_id,
							$abono_factura_proveedor_id,
							$relacion_abono_id,
							$puc_final,
							$tercero_id,
							$numero_identificacion,
							$digito_verificacion,
							$centro_de_costo_id,
							$codigo_centro_costo,
							'',
							'',
							'".$descripcion."',
							$debito_pago,
							$credito_pago
					)"; 
					//echo $insert_pago;
			$this -> query($insert_pago,$Conex);
						
			$valor_debito_total = $valor_debito_total+$debito_pago;
			$valor_credito_total = $valor_credito_total+$credito_pago;
			
			
			
			  $puc = "SELECT c.puc_id,c.natu_bien_servicio_factura_proveedor FROM codpuc_bien_servicio_factura_proveedor c WHERE c.tipo_bien_servicio_factura_proveedor_id= (SELECT tipo_bien_servicio_factura_proveedor_id FROM factura_proveedor WHERE factura_proveedor_id=$causaciones) AND ( (c.natu_bien_servicio_factura_proveedor='D') OR ((c.natu_bien_servicio_factura_proveedor='C' AND c.puc_id IN (SELECT puc_id FROM impuesto WHERE estado='A')) )) AND contra_bien_servicio_factura_proveedor = 0";
			 $result = $this -> DbFetchAll($puc,$Conex); 
			
			foreach($result as $result_items){
				
				$naturaleza = $result_items['natu_bien_servicio_factura_proveedor'];
				
				$select_requ   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio 
							FROM puc WHERE puc_id =$result_items[puc_id]"; 
							
				 $requires = $this -> DbFetchAll($select_requ,$Conex,true);
				
				 $centro_de_costo_id	   = $requires[0]['requiere_centro_costo'] == 1 ? $centro_de_costo_id : 'NULL';
				 $codigo_centro_costo	   = $requires[0]['requiere_centro_costo'] == 1 ? $codigo_centro_costo : 'NULL';
				 $tercero_id		       = $requires[0]['requiere_tercero']      == 1 ? $tercero_id : 'NULL';
				 $numero_identificacion = $requires[0]['requiere_tercero']      == 1 ? $numero_identificacion : 'NULL';
				 $digito_verificacion   = $requires[0]['requiere_tercero']      == 1 ? $digito_verificacion : 'NULL';
				 
				 $select = "SELECT impuesto_id FROM impuesto_oficina WHERE empresa_id = $empresa_id
							AND oficina_id = $oficina_id
							AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $result_items[puc_id])";
							//echo $select;
				  $impuesto = $this -> DbFetchAll($select,$Conex,true);				
				  
				  if(count($impuesto) > 0){
						
						$impuesto_id =  $impuesto[0]['impuesto_id'] ;
						$select_impuesto = "SELECT porcentaje,formula FROM impuesto_periodo_contable WHERE periodo_contable_id=$periodo_contable_id AND impuesto_id= $impuesto_id ";
						//echo $select_impuesto;
						$result_impuesto = $this -> DbFetchAll($select_impuesto,$Conex,true);	
						
						$select_descripcion ="SELECT descripcion FROM impuesto WHERE impuesto_id = $impuesto_id";
						$result_descripcion = $this -> DbFetchAll($select_descripcion,$Conex,true);	
						
						$descripcion = "'".$result_descripcion[0]['descripcion']."'";
						
						  $porcentaje    = $result_impuesto[0]['porcentaje'];
						  $formula       = $result_impuesto[0]['formula'];
						  $base          = str_replace(",",".",str_replace(".","",$valor_neto_factura_proveedor));	 

							  
						  $calculo = str_replace("BASE",$base,$formula);
						  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
							  
						  $select     = "SELECT $calculo AS valor_total";
						 // echo $select;
						  $result     = $this -> DbFetchAll($select ,$Conex,true);
						  $valorTotal = round($result[0]['valor_total']);
							
							if($naturaleza == 'C'){
								$debito  = $valorTotal;
								$credito = 0;
							}else{
								$debito  = 0;
								$credito = $valorTotal;
							}	
							
							 $porcentaje    = "'".$porcentaje."'";
						  $formula          = "'".$formula."'";
							$valor = $base;
					}else {
						
							$porcentaje    = 'NULL';
						  $formula       = 'NULL';
						  
						 $valor          = str_replace(",",".",str_replace(".","",$valor_neto_factura_proveedor));	 
						
						   if($naturaleza == 'C'){
								$debito  = $valor;
								$credito = 0;
							}else{
								$debito  = 0;
								$credito = $valor;
							}	
					}
				
				
				$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
				$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_proveedor_id,
												relacion_abono_id,
												puc_id,
												tercero_id,
												numero_identificacion,
												digito_verificacion,
												centro_de_costo_id,
												codigo_centro_costo,
												base_abono,
												porcentaje_abono,
												formula_abono,
												desc_abono,
												deb_item_abono,
												cre_item_abono) 
										VALUES (
												$item_abono_id,
												$abono_factura_proveedor_id,
												$relacion_abono_id,
												$result_items[puc_id],
												$tercero_id,
												$numero_identificacion,
												$digito_verificacion,
												$centro_de_costo_id,
												$codigo_centro_costo,
												$valor,
												$porcentaje,
												$formula,
												$descripcion,
												$debito,
												$credito
										)"; 
										//echo $insert_descu;
						$this -> query($insert_descu,$Conex);
						
			$valor_debito_total = $valor_debito_total+$debito;
			$valor_credito_total = $valor_credito_total+$credito;
			
			 
					
			}
			
			$valor_credito_final = $valor_debito_total - $valor_credito_total;
			$valor_debito_final = 0;
			
			/*$puc = "SELECT c.puc_id FROM codpuc_bien_servicio_factura_proveedor c WHERE c.tipo_bien_servicio_factura_proveedor_id= (SELECT tipo_bien_servicio_factura_proveedor_id FROM factura_proveedor WHERE factura_proveedor_id=$causaciones) AND contra_bien_servicio_factura_proveedor = 1";
			 $result = $this -> DbFetchAll($puc,$Conex); 
			
			$puc_final 		= $result[0]['puc_id'];
			
			$select_requ   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio 
							FROM puc WHERE puc_id =$puc_final"; 
							
				 $requires = $this -> DbFetchAll($select_requ,$Conex,true);
				
				 $centro_de_costo_id	   = $requires[0]['requiere_centro_costo'] == 1 ? $centro_de_costo_id : 'NULL';
				 $codigo_centro_costo	   = $requires[0]['requiere_centro_costo'] == 1 ? $codigo_centro_costo : 'NULL';
				 $tercero_id		       = $requires[0]['requiere_tercero']      == 1 ? $tercero_id : 'NULL';
				 $numero_identificacion = $requires[0]['requiere_tercero']      == 1 ? $numero_identificacion : 'NULL';
				 $digito_verificacion   = $requires[0]['requiere_tercero']      == 1 ? $digito_verificacion : 'NULL';
				 
				 $descripcion = "$observaciones";*/
				 
				 $select_pago = "SELECT c.puc_id FROM cuenta_tipo_pago c WHERE c.cuenta_tipo_pago_id=$cuenta_tipo_pago_id";
			$result_pago = $this -> DbFetchAll($select_pago,$Conex); 
			
			$puc_pago    = $result_pago[0][puc_id];
			
			$select_requ   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio 
							FROM puc WHERE puc_id =$puc_pago"; 
							
				 $requires = $this -> DbFetchAll($select_requ,$Conex,true);
				
				 $centro_de_costo_id	   = $requires[0]['requiere_centro_costo'] == 1 ? $centro_de_costo_id : 'NULL';
				 $codigo_centro_costo	   = $requires[0]['requiere_centro_costo'] == 1 ? $codigo_centro_costo : 'NULL';
				 $tercero_id		       = $requires[0]['requiere_tercero']      == 1 ? $tercero_id : 'NULL';
				 $numero_identificacion = $requires[0]['requiere_tercero']      == 1 ? $numero_identificacion : 'NULL';
				 $digito_verificacion   = $requires[0]['requiere_tercero']      == 1 ? $digito_verificacion : 'NULL';
					
				 $debito_pago       = str_replace(",",".",str_replace(".","",$valor_neto_factura_proveedor));	 
				 $credito_pago      = 0;
				 
			$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
				$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_proveedor_id,
												relacion_abono_id,
												puc_id,
												tercero_id,
												numero_identificacion,
												digito_verificacion,
												centro_de_costo_id,
												codigo_centro_costo,
												porcentaje_abono,
												formula_abono,
												desc_abono,
												deb_item_abono,
												cre_item_abono) 
										VALUES (
												$item_abono_id,
												$abono_factura_proveedor_id,
												$relacion_abono_id,
												$puc_pago,
												$tercero_id,
												$numero_identificacion,
												$digito_verificacion,
												$centro_de_costo_id,
												$codigo_centro_costo,
												NULL,
												NULL,
												'".$pucnom_tipo."',
												$valor_debito_final,
												$valor_credito_final
										)"; 
						$this -> query($insert_descu,$Conex);
			
			
			//Fin nuevos items

			
		 }
	 }

	 if(!strlen(trim($this -> GetError())) > 0){
		$this -> Commit($Conex);		 
		return $abono_factura_proveedor_id;
	 }
	

  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);

	  if($_REQUEST['abono_factura_proveedor_id'] != 'NULL'){
		$abono_factura_proveedor_id	= $this -> requestDataForQuery('abono_factura_proveedor_id','integer');	
		$tipo_documento_id 			= $this -> requestDataForQuery('tipo_documento_id','integer');
		$fecha 						= $this -> requestDataForQuery('fecha','date');	
		$num_cheque 				= $this -> requestDataForQuery('num_cheque','text');	
		
	  
	    $update = "UPDATE abono_factura_proveedor SET tipo_documento_id=$tipo_documento_id, fecha=$fecha, num_cheque=$num_cheque
					WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id"; 
		$this -> query($update,$Conex);
	  	if(!strlen(trim($this -> GetError())) > 0){
			$this -> Commit($Conex);
		}		
	  }
  }
  
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"abono_factura_proveedor",$Campos);
	 return $Data -> GetData();
   }
	 	
  public function cancellation($Conex){
	 

	$this -> Begin($Conex);

	$abono_factura_proveedor_id	= $this -> requestDataForQuery('abono_factura_proveedor_id','integer');
	$causal_anulacion_id  		= $this -> requestDataForQuery('causal_anulacion_id','integer');
	$anul_abono_factura_proveedor   		= $this -> requestDataForQuery('anul_abono_factura_proveedor','text');
	$desc_anul_abono_factura_proveedor  	= $this -> requestDataForQuery('desc_anul_abono_factura_proveedor','text');
	$anul_usuario_id          	= $this -> requestDataForQuery('anul_usuario_id','integer');	
	  
	
	$select = "SELECT encabezado_registro_id FROM abono_factura_proveedor WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id";	
	$result = $this -> DbFetchAll($select,$Conex); 
	$encabezado_registro_id = $result[0]['encabezado_registro_id'];
	

	if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL){	 

		$insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		$desc_anul_abono_factura_proveedor AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		$this -> query($insert,$Conex,true);

		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{
			$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
			imputacion_contable_anulada_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id AS 
			encabezado_registro_anulado_id,centro_de_costo_id,codigo_centro_costo,numero,valor,amortiza,deprecia,base,porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id FROM 
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
						$update = "UPDATE abono_factura_proveedor   SET estado_abono_factura_proveedor= 'I',
									causal_anulacion_id = $causal_anulacion_id,
									anul_abono_factura_proveedor=$anul_abono_factura_proveedor,
									desc_anul_abono_factura_proveedor =$desc_anul_abono_factura_proveedor,
									anul_usuario_id=$anul_usuario_id
								WHERE abono_factura_proveedor_id 	=$abono_factura_proveedor_id";	
						$this -> query($update,$Conex);		
					
					   $this -> Commit($Conex);			
					}

				}

			}

		}
	}else{
		$update = "UPDATE abono_factura_proveedor   SET estado_abono_factura_proveedor= 'I',
					causal_anulacion_id = $causal_anulacion_id,
					anul_abono_factura_proveedor=$anul_abono_factura_proveedor,
					desc_anul_abono_factura_proveedor =$desc_anul_abono_factura_proveedor,
					anul_usuario_id=$anul_usuario_id
				WHERE abono_factura_proveedor_id 	=$abono_factura_proveedor_id";	
		$this -> query($update,$Conex);		
	
	   $this -> Commit($Conex);			
		
	}

  }

  public function reversar($empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){
	 

	$this -> Begin($Conex);

	$abono_factura_proveedor_id			= $this -> requestDataForQuery('abono_factura_proveedor_id','integer');
	$rever_documento_id  		= $this -> requestDataForQuery('rever_documento_id','integer');
	$rever_abono_factura_proveedor   		= $this -> requestDataForQuery('rever_abono_factura_proveedor','text');
	$desc_rever_abono_factura_proveedor  	= $this -> requestDataForQuery('desc_rever_abono_factura_proveedor','text');
	$rever_usuario_id          	= $this -> requestDataForQuery('rever_usuario_id','integer');	
	  
	$select 	= "SELECT a.abono_factura_proveedor_id,
					  a.valor_abono_factura_proveedor,
					  a.ingreso_abono_factura_proveedor,
					  a.concepto_abono_factura_proveedor,
					  (SELECT tercero_id  FROM  cliente WHERE cliente_id=a.cliente_id) AS tercero,
					  (SELECT puc_id  FROM cuenta_tipo_pago  WHERE cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS puc_contra,
					  a.tipo_documento_id  AS tipo_documento					  
				FROM abono_factura_proveedor a WHERE a.abono_factura_proveedor_id=$abono_factura_proveedor_id";	
	$result 	= $this -> DbFetchAll($select,$Conex); 
	
	$select_con = "SELECT (MAX(consecutivo)+1) AS consecutivo FROM encabezado_de_registro 
					WHERE tipo_documento_id=$rever_documento_id AND  oficina_id=$oficina_id AND empresa_id=$empresa_id";
	$result_con	= $this -> DbFetchAll($select_con,$Conex);		

	$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
					WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
	$result_usu	= $this -> DbFetchAll($select_usu,$Conex);	



	$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
	$tipo_documento_id		= $rever_documento_id;	
	$valor					= $result[0]['valor_abono_factura_proveedor'];
	$numero_soporte			= $result[0]['concepto_abono_factura_proveedor'];	
	$tercero_id				= $result[0]['tercero'];
	
    include_once("UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 		
	
    $fechaMes                  = substr(date("Y-m-d"),0,10);		
    $periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
    $mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
    $consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);		
	
	
	$fecha					= date("Y-m-d H:m");
	$concepto				= 'Reversar pago: '.$result[0]['concepto_abono_factura_proveedor'];
	$puc_id					= $result[0]['puc_contra'];
	$fecha_registro			= date("Y-m-d H:m");
	$modifica				= $result_usu[0]['usuario'];
	$numero_documento_fuente= $result[0]['abono_factura_proveedor_id'];
	$id_documento_fuente	= $result[0]['abono_factura_proveedor_id'];
	$con_fecha_abono_factura_proveedor= $fecha_registro;	
	

	$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
						mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
						VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
						$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
						//echo $insert;
	$this -> query($insert,$Conex);
	
	$select_item = "SELECT item_abono_id FROM item_abono WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id";
	$result_item = $this -> DbFetchAll($select_item,$Conex);	
	
	foreach($result_item as $result_items){
		$imputacion_contable_id	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);	
		$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id, tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
						SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_abono,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(cre_item_abono+deb_item_abono),base_abono,porcentaje_abono,
						formula_abono,cre_item_abono,deb_item_abono
						FROM item_abono WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id AND item_abono_id=$result_items[item_abono_id]"; 
						//echo $insert_item;
		$this -> query($insert_item,$Conex);
	}
	
	if(strlen($this -> GetError()) > 0){
		$this -> Rollback($Conex);
	}else{		
	
		$update = "UPDATE abono_factura_proveedor SET rev_encabezado_registro_id=$encabezado_registro_id,	
					estado_abono_factura_proveedor= 'A',
					rever_usuario_id = $rever_usuario_id,
					rever_abono_factura_proveedor=$rever_abono_factura_proveedor,
					desc_rever_abono_factura_proveedor=$desc_rever_abono_factura_proveedor,
					rever_documento_id=$rever_documento_id
				WHERE abono_factura_proveedor_id =$abono_factura_proveedor_id";	
		$this -> query($update,$Conex);		  
	
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
			
		}else{		
			$this -> Commit($Conex);
			return true;
		}  
	}  

  }

  public function getTotalDebitoCredito($encabezado_registro_id,$Conex){
	  
	  $select = "SELECT SUM(debito) AS debito,SUM(credito) AS credito FROM imputacion_contable WHERE encabezado_registro_id = 
	             $encabezado_registro_id";

      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result; 

	 
  }

  public function getContabilizarReg($abono_factura_proveedor_id,$empresa_id,$oficina_id,$usuario_id,$Conex){
	 
	$this -> Begin($Conex);
		
		$select 	= "SELECT a.abono_factura_proveedor_id,
						  a.valor_abono_factura_proveedor,
						  a.ingreso_abono_factura_proveedor,
						  a.fecha,
						  a.num_cheque,
						  a.cuenta_tipo_pago_id,
						  a.concepto_abono_factura_proveedor,
						  (SELECT tercero_id  FROM  cliente WHERE cliente_id=a.cliente_id) AS tercero,
						  (SELECT puc_id  FROM cuenta_tipo_pago  WHERE cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS puc_contra,
						  a.tipo_documento_id 					  
					FROM abono_factura_proveedor a WHERE a.abono_factura_proveedor_id=$abono_factura_proveedor_id";	
		$result 	= $this -> DbFetchAll($select,$Conex); 

		$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
		$tipo_documento_id		= $result[0]['tipo_documento_id'];	
		$valor					= $result[0]['valor_abono_factura_proveedor'];
		$numero_soporte			= $result[0]['concepto_abono_factura_proveedor'];	
		$tercero_id				= $result[0]['tercero'];
		$periodo_contable_id	= $periodoContable;
		$mes_contable_id		= $mesContable;
		$fecha					= $result[0]['fecha'];
		$num_cheque				= $result[0]['num_cheque']!='' ? "'".$result[0]['num_cheque']."'":'NULL';
		$concepto				= $result[0]['concepto_abono_factura_proveedor'];
		$puc_id					= $result[0]['puc_contra'];
		$fecha_registro			= date("Y-m-d H:m");
		$numero_documento_fuente= $result[0]['abono_factura_proveedor_id'];
		$id_documento_fuente	= $result[0]['abono_factura_proveedor_id'];
		$con_fecha_abono_factura_proveedor= $fecha_registro;	
		$cuenta_tipo_pago_id	= $result[0][cuenta_tipo_pago_id];


		include_once("UtilidadesContablesModelClass.php");
		  
		$utilidadesContables = new UtilidadesContablesModel(); 		
		
		$fechaMes                  = substr($fecha,0,10);		
		$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
		$mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
		$consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex);		


		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);		
		$modifica	= $result_usu[0]['usuario'];

		$select_pago = "SELECT forma_pago_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id=$cuenta_tipo_pago_id";
		$result_pago = $this -> DbFetchAll($select_pago,$Conex);		
		$forma_pago_id	= $result_pago[0]['forma_pago_id'];


		$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$forma_pago_id,'$valor',$num_cheque,$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
		$this -> DbFetchAll($insert,$Conex); 

		$select_item = "SELECT item_abono_id FROM item_abono WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id";
		$result_item = $this -> DbFetchAll($select_item,$Conex);	
		
		foreach($result_item as $result_items){

			$imputacion_contable_id	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_abono,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_abono+cre_item_abono),base_abono,porcentaje_abono,
							formula_abono,deb_item_abono,cre_item_abono
							FROM item_abono WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id AND item_abono_id=$result_items[item_abono_id]"; 
			$this -> DbFetchAll($insert_item,$Conex);
		}
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{		
		
			$update = "UPDATE abono_factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,	
						estado_abono_factura_proveedor= 'C',
						con_usuario_id = $usuario_id,
						con_fecha_abono_factura_proveedor='$con_fecha_abono_factura_proveedor'
					WHERE abono_factura_proveedor_id =$abono_factura_proveedor_id";	
			$this -> query($update,$Conex);		  
		
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
				
			}else{		
				$this -> Commit($Conex);
				return true;
			}  
		}  
  }

  public function mesContableEstaHabilitado($empresa_id,$oficina_id,$ingreso_abono_factura_proveedor,$Conex){
	  
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND 
	                  oficina_id = $oficina_id AND '$ingreso_abono_factura_proveedor' BETWEEN fecha_inicio AND fecha_final";
      $result = $this -> DbFetchAll($select,$Conex);
	  
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
		 $result = $this -> DbFetchAll($select,$Conex);		 
		 return $result[0]['estado'] == 1? true : false;		 
	   }
	  
  }  

  public function selectEstadoEncabezadoRegistro($abono_factura_proveedor_id,$Conex){
	  
    $select = "SELECT estado_abono_factura_proveedor FROM abono_factura_proveedor  WHERE abono_factura_proveedor_id = $abono_factura_proveedor_id";	  
	$result = $this -> DbFetchAll($select,$Conex); 
	$estado = $result[0]['estado_abono_factura_proveedor'];
	return $estado;	  
	  
  }
		

   public function GetQueryPagoGrid(){
	   	   
   $Query = "SELECT a.fecha,
   					a.ingreso_abono_factura_proveedor, 
					(SELECT nombre  FROM tipo_de_documento  WHERE tipo_documento_id=a.tipo_documento_id) AS tipo_doc,	   
					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=a.encabezado_registro_id) AS num_ref,
					(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS cliente FROM tercero WHERE tercero_id=p.tercero_id) AS cliente,
					(SELECT CONCAT_WS(' - ',(SELECT nombre FROM forma_pago WHERE forma_pago_id=c.forma_pago_id ),(SELECT CONCAT_WS(' ',codigo_puc,nombre) AS nombre FROM puc WHERE puc_id=c.puc_id )) AS text FROM cuenta_tipo_pago c WHERE c.cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS forma_pago,
					a.concepto_abono_factura_proveedor,
					a.valor_abono_factura_proveedor,
					CASE a.estado_abono_factura_proveedor  WHEN 'A' THEN 'ACTIVA' WHEN 'I' THEN 'ANULADA' ELSE 'CONTABILIZADA' END AS estado_abono_factura_proveedor
			FROM abono_factura_proveedor a, cliente p
		WHERE p.cliente_id=a.cliente_id ORDER BY a.fecha DESC LIMIT 0,200";
		
   return $Query;
   }
}

?>