<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SubtotalModel extends Db{

  private $Permisos;
  
 /* public function getDetalles($factura_id,$empresa_id,$oficina_id,$Conex){
	    	
	 if(is_numeric($factura_id)){
		  $total_pagar=0;
		  $parcial='';
		  $contra=0;
		  $subtotal=0;
		  $i=0;
		  $select  = "SELECT  c.despuc_bien_servicio_factura,
					  c.natu_bien_servicio_factura,
					  c.contra_bien_servicio_factura,
					  c.tercero_bien_servicio_factura,
					  c.ret_tercero_bien_servicio_factura,
					   c.aplica_ingreso,
					  c.puc_id,
					  d.formula_factura,
					  IF(d.valor_liquida>0,d.valor_liquida,(d.deb_item_factura+d.cre_item_factura)) AS total 
					 FROM detalle_factura_puc d, factura f, codpuc_bien_servicio_factura c
					 WHERE f.factura_id = $factura_id AND d.factura_id= f.factura_id AND c.tipo_bien_servicio_factura_id=f.tipo_bien_servicio_factura_id AND c.puc_id= d.puc_id  ORDER BY c.contra_bien_servicio_factura";

	     $result = $this -> DbFetchAll($select,$Conex);

		 foreach($result as $resultado){

			 $parcial		= $resultado['total'];
			 $parcial		= number_format($parcial,2,'.','');
			 $descripcion	= $resultado[despuc_bien_servicio_factura];
			 $result[$i]	= array(despuc_bien_servicio_factura=>$descripcion,valor=>$parcial,aplica_ingreso=>$resultado[aplica_ingreso],natu_bien_servicio_factura=>$resultado[natu_bien_servicio_factura],puc_id=>$resultado[puc_id],contra_bien_servicio_factura=>$resultado[contra_bien_servicio_factura],tercero_bien_servicio_factura=>$resultado[tercero_bien_servicio_factura],ret_tercero_bien_servicio_factura=>$resultado[ret_tercero_bien_servicio_factura]);	
		 	$i++;
		 }
		 
		 return $result;
	}else{
   	    $result = array();
	}
  
  }*/

 public function getDetalles($abono_factura_id,$empresa_id,$oficina_id,$Conex){
	    	
	 if(is_numeric($abono_factura_id)){
		 $select="SELECT i.item_abono_id,						
							i.abono_factura_id,
							i.relacion_abono_id,
							i.puc_id,
							(SELECT codigo_puc FROM puc WHERE puc_id = i.puc_id)AS codigo_puc,
							i.tercero_id,
							i.numero_identificacion,
							i.digito_verificacion,
							i.centro_de_costo_id,
							i.codigo_centro_costo,
							i.base_abono,
						    i.porcentaje_abono,
							i.formula_abono,
							i.desc_abono,
							i.deb_item_abono,
							i.cre_item_abono
					FROM item_abono i WHERE i.abono_factura_id=$abono_factura_id";
				
		$result = $this -> DbFetchAll($select,$Conex,true);
		 
		 return $result;
	  }
  
  }
 
	public function arrayRemesas($causaciones_abono_factura,$remesas,$Conex){
		
		$subtotal     = 0;
		$sub_costos   = 0;
		$ter_costos = [];
		$terid_costos = [];
		$complemento = [];
		$j            = 0;
		
		$item = explode(',',$remesas);
		
		foreach($item as $item_id){
			if($item_id!=''){
				
				$select = "SELECT
							r.remesa_id,
							r.numero_remesa,
							r.origen_id,
							r.destino_id,
							r.producto_id,
							r.descripcion_producto,
							r.cantidad,
							r.valor_facturar,
							r.valor_costo,
							r.conductor_id,
							
							(SELECT t.tercero_id FROM detalle_despacho d,  tenedor  t 
							 WHERE d.remesa_id=r.remesa_id AND t.tenedor_id=IF(d.manifiesto_id>0,
							(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id=d.manifiesto_id AND estado!='A') ,
							(SELECT tenedor_id FROM  despachos_urbanos  WHERE despachos_urbanos_id=d.despachos_urbanos_id AND estado!='A')) LIMIT 1 ) AS tercero_id,
							(SELECT df.factura_id FROM detalle_factura df, factura f WHERE df.remesa_id=r.remesa_id AND  f.factura_id!=$causaciones_abono_factura AND f.estado!='I' AND df.factura_id=f.factura_id AND df.remesa_id IS NOT NULL LIMIT 1) AS facturado
							FROM remesa r
							WHERE r.remesa_id='$item_id'";
        
				$result = $this -> DbFetchAll($select,$Conex,true);

				
				foreach($result as $resultado){

				    $subtotal = $subtotal + $resultado['valor_facturar'];
										
					$sub_costos       =  $sub_costos + round($resultado['valor_costo']);
					$ter_costos[$j]   =round($resultado['valor_costo']); 
				    $terid_costos[$j] = $resultado['tercero_id']; 
					$complemento[$j]  = $resultado['complemento'].'- Remesa: '.$resultado['numero_remesa'];
					$j++;
				}

			}
		}
		
		
		return array('sub_costos'  => $sub_costos,
					 'subtotal'    => $subtotal,
					 'ter_costos'  => $ter_costos,
					 'terid_costos'=> $terid_costos,
					 'complemento' => $complemento
					 );
	}
	
	
	public function arrayOrdenes($ordenes,$Conex){
		
		$subtotal = 0;
		
		$item     = explode(',',$ordenes);
		
		foreach($item as $item_id){
			if($item_id!=''){

				$ordenes_id.=$item_id.",";

				$select = "SELECT
							o.orden_servicio_id,
							o.centro_de_costo_id,
							i.item_liquida_servicio_id,
							i.desc_item_liquida_servicio,
							i.cant_item_liquida_servicio,
							i.valoruni_item_liquida_servicio,
							(i.cant_item_liquida_servicio*i.valoruni_item_liquida_servicio) AS valor_total
							FROM orden_servicio o, item_liquida_servicio i
							WHERE o.orden_servicio_id='$item_id' AND i.orden_servicio_id=o.orden_servicio_id";

				$result = $this -> DbFetchAll($select,$Conex,true);

				foreach($result as $result_item){

					$subtotal           =  $subtotal + $result_item['valor_total'];
					$centro_de_costo_id = $result_item['centro_de_costo_id'];
				}

			}
		}
		
		return array('subtotal'  		   => $subtotal,
					 'centro_de_costo_id'  => $centro_de_costo_id
					 );
		
	}

  public function previsual($actualizar,$valores_abono_factura,$aplica_total_factura,$previsual,$remesas,$ordenes,$empresa_id,$oficina_id,$usuario_id,$Conex){
	
	  $abono_factura_id = $_REQUEST['abono_factura_id'];

	  $tipo_documento_id 		     = $this -> requestDataForQuery('tipo_de_documento_id','integer');
	  $cliente_id 				     = $this -> requestDataForQuery('cliente_id','integer');	
	  $causaciones_abono_factura 	 = $this -> requestDataForQuery('factura_id','integer');	
	  $fecha 						 = $this -> requestDataForQuery('fecha_nota','date');		
	  $concepto_abono_factura 	     = $this -> requestDataForQuery('concepto','text');
	  $motivo_nota				     = $this -> requestDataForQuery('motivo_nota','integer');
	  $ingreso_abono_factura		 = date("Y-m-d H:i:s");
	  $estado_abono_factura 		 = $this -> requestDataForQuery('estado','alphanum');	
	  $tipo_bien_servicio_factura_id = $this -> requestDataForQuery('tipo_bien_servicio_factura','integer');	
	  $valor_abono_factura 		     = $this -> requestDataForQuery('valor_nota','numeric');
	  $valor_comp				     = str_replace("'","",$valor_abono_factura);
	  
	$this -> Begin($Conex);

	if($abono_factura_id>0 && $previsual != 1 && $actualizar == 1 && $estado_abono_factura != 'C'){

		$select="SELECT item_abono_id FROM item_abono WHERE abono_factura_id = $abono_factura_id";
		$result_item = $this -> DbFetchAll($select,$Conex,true);
		$item_abono_id = $result_item[0]['item_abono_id'];
		
		if($item_abono_id>0){
			$delete="DELETE FROM item_abono WHERE abono_factura_id=$abono_factura_id";
			$result = $this->query($delete, $Conex, true);	
		}

		$select="SELECT relacion_abono_id FROM relacion_abono WHERE abono_factura_id=$abono_factura_id";
		$result_relacion = $this -> DbFetchAll($select,$Conex,true);
		$relacion_abono_id = $result_relacion[0]['relacion_abono_id'];
		
		if($relacion_abono_id>0){
			$delete="DELETE FROM relacion_abono WHERE abono_factura_id=$abono_factura_id";
			$result = $this->query($delete, $Conex, true);
		}

		$delete="DELETE FROM abono_factura WHERE abono_factura_id=$abono_factura_id";
		$result = $this->query($delete, $Conex, true);
        
		if($remesas != ''){
			$update="UPDATE remesa SET estado = 'FT' WHERE remesa_id IN(SELECT remesa_id FROM detalle_factura WHERE factura_id = $causaciones_abono_factura)";
			$result = $this->query($update, $Conex, true);
		}else if($ordenes != ''){
            $update="UPDATE orden_servicio SET estado = 'F' WHERE orden_servicio_id IN(SELECT orden_servicio_id FROM detalle_factura WHERE factura_id = $causaciones_abono_factura)";
            $result = $this->query($update, $Conex, true);
		}

	}

	
	
	$select_tercero = "SELECT tercero_id FROM cliente WHERE cliente_id=$cliente_id";
	$result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
	$tercero_id = $result_tercero[0]['tercero_id'];
	
	
	$abono_factura_id = $this -> DbgetMaxConsecutive("abono_factura","abono_factura_id",$Conex,true,1);
	$insert="INSERT INTO abono_factura (abono_factura_id,
	                                    tipo_documento_id,
										cliente_id,
										fecha,
										valor_abono_factura,
										valor_neto_factura,
										concepto_abono_factura,
										causaciones_abono_factura,
										valores_abono_factura,
										usuario_id,
										oficina_id,
										ingreso_abono_factura,
										estado_abono_factura,
										motivo_nota) 

	                             VALUES ($abono_factura_id,
								         $tipo_documento_id,
										 $cliente_id,
										 $fecha,
										 $valor_abono_factura,
										 $valor_abono_factura,
										 $concepto_abono_factura,
										 $causaciones_abono_factura,
										 '$valores_abono_factura',
										 $usuario_id,
										 $oficina_id,
										 '$ingreso_abono_factura',
										 $estado_abono_factura,
										 $motivo_nota)";
    
	$result = $this->query($insert, $Conex, true);

	/* $select_rel_abono = "SELECT MAX(cre_item_abono)AS rel_valor_abono FROM item_abono WHERE deb_item_abono=0 AND abono_factura_id=$abono_factura_id";
	$result_rel_abono = $this -> DbFetchAll($select_rel_abono,$Conex,true);
	$rel_valor_abono = $result_rel_abono[0]['rel_valor_abono'];
	exit($rel_valor_abono.' si'.$valor_abono_factura); */

	$relacion_abono_id  = $this -> DbgetMaxConsecutive("relacion_abono","relacion_abono_id",$Conex,true,1);	

	$insert_item = "INSERT INTO relacion_abono (relacion_abono_id,
	                                            factura_id,
												abono_factura_id,
												rel_valor_abono)
												 
						                 VALUES ($relacion_abono_id,
										         $causaciones_abono_factura,
												 $abono_factura_id,
												 '$valor_abono_factura')"; 	
	$this -> query($insert_item,$Conex,true);

	  $subtotal     = 0;
	  $sub_costos   = 0;
	  $ter_costos = [];
	  $terid_costos = [];
	  $complemento = [];
	  $sub_total_orden_remesa = 0;

	   $select_centro 	   = "SELECT centro_de_costo_id,codigo FROM centro_de_costo  WHERE oficina_id=$oficina_id";
	   $result_centro 	   = $this -> DbFetchAll($select_centro,$Conex,true);
	   $centro_de_costo_id = $result_centro[0]['centro_de_costo_id'];
	   $centro_costo_cod   = $result_centro[0]['codigo'];

	   // Condicional para cuando escogen Ordenes y remesas a liberar
		if($remesas != '' && $remesas != 'NULL' && $remesas != NULL && 
		   $ordenes != '' && $ordenes != 'NULL' && $ordenes != NULL ||
		   
		   (($aplica_total_factura == 1 && ($ordenes == '' || $ordenes == 'NULL' || $ordenes == null)) &&
		   ( $aplica_total_factura == 1 && ($remesas == '' || $remesas == 'NULL' || $remesas == null)))){
		
			if($aplica_total_factura == 1){
				
				$subtotal = $valor_abono_factura;
				
			}else{
				
				$datos_remesa = $this->arrayRemesas($causaciones_abono_factura,$remesas,$Conex);
			
				$subtotal_remesa = $datos_remesa['subtotal'];
				$sub_costos      = $datos_remesa['sub_costos'];
				$ter_costos   	 = $datos_remesa['ter_costos'];
				$terid_costos 	 = $datos_remesa['terid_costos'];
				$complemento  	 = $datos_remesa['complemento'];
				
				$datos_orden         = $this->arrayOrdenes($ordenes,$Conex);
			
				$subtotal_orden      = $datos_orden['subtotal'];
				$centro_de_costo_id  = $datos_orden['centro_de_costo_id'];
				
				$subtotal 				=  $subtotal_remesa;
				$sub_total_orden_remesa =  $subtotal_orden; 
				
				/* exit('Variables Remesa : <br> subtotal remesa :'.number_format($subtotal_remesa,0,",",".").'<br> sub_costos 	   : '.number_format($sub_costos,0,",",".").
				  '<br><br>Variables Orden : <br>subtotal Orden : '.number_format($subtotal_orden,0,",",".")); */
				
			}
		
		// Condicional para cuando escogen remesas a liberar
		}else if($remesas != '' && $remesas != 'NULL' && $remesas != NULL || ($aplica_total_factura == 1 && $ordenes == '') || ($aplica_total_factura == 1 && $ordenes == 'NULL')){
		   
		if($aplica_total_factura == 1){

			 $subtotal = $valor_abono_factura;

		}else{
			
			$datos        = $this->arrayRemesas($causaciones_abono_factura,$remesas,$Conex);
			
			$subtotal     = $datos['subtotal'];
			$sub_costos   = $datos['sub_costos'];
			$ter_costos   = $datos['ter_costos'];
			$terid_costos = $datos['terid_costos'];
			$complemento  = $datos['complemento'];

		}

		
	// Condicional para cuando escogen ordenes a liberar
	}elseif($ordenes != '' && $ordenes != 'NULL' && $ordenes != NULL || ($aplica_total_factura == 1 && $remesas == '') || ($aplica_total_factura == 1 && $remesas == 'NULL')){
		
		if($aplica_total_factura == 1){

			 $subtotal = $valor_abono_factura;

		}else{
		
			$datos        = $this->arrayOrdenes($ordenes,$Conex);
			
			$subtotal            = $datos['subtotal'];
			$centro_de_costo_id  = $datos['centro_de_costo_id'];
			
	    }

	}else{

		$subtotal = $valor_abono_factura;
	    $aplica_total_factura = 1;
		
	}

	    $total_pagar= 0;
		$total_liqui= 0;
		$parcial='';
		$valor_liqui='';

		$select_com  = "SELECT COUNT(*) AS num_cuentas 
				 FROM devpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.tercero_bien_servicio_factura=1 AND c.activo=1 ";
		
		$result_com = $this -> DbFetchAll($select_com,$Conex,true);

		$select_com  = "SELECT consecutivo_factura FROM factura  f
				       WHERE f.factura_id=$causaciones_abono_factura ";
		$result_contra = $this -> DbFetchAll($select_com,$Conex,true);

		$select_clien = "SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente
						 FROM cliente p, tercero t WHERE p.cliente_id=$cliente_id AND t.tercero_id=p.tercero_id"; 
		$result_clien = $this -> DbFetchAll($select_clien,$Conex,true);	

	
    $select  = "SELECT  c.devpuc_bien_servicio_factura_id,
	                    c.tipo_bien_servicio_factura_id,
				        c.puc_id,
						c.despuc_bien_servicio_factura,
				        c.natu_bien_servicio_factura,
				        c.contra_bien_servicio_factura,
				        c.tercero_bien_servicio_factura,
				        c.ret_tercero_bien_servicio_factura,
				        c.reteica_bien_servicio_factura,
				        c.aplica_ingreso,
						c.aplica_tenedor,

				       (SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
				       (SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
				       (SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,			
					   (SELECT autoret_cliente_factura  FROM cliente WHERE cliente_id=$cliente_id ) AS autorete,				
					   (SELECT retei_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS retei,			
					   (SELECT renta_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS renta,								
					   (SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,

						(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
						WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
						AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,	

						(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
						WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
						AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,			

						(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
						WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
						AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto	

				 FROM devpuc_bien_servicio_factura  c
				 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura!=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura ASC, c.aplica_ingreso ASC ";
        
		$result = $this -> DbFetchAll($select,$Conex,true);

		if(!count($result)>0 && $remesas == ''){
			if($previsual != 1){
				$this -> Rollback($Conex);
			    return "Atención, El tipo de servicio no tiene configuradas las cuentas para devolución";
			}
		}
	   
		$residual=0;
		
		// Para cuando liberan ordenes y no remesas
		
		if(($ordenes != '' && $ordenes != 'NULL' && $ordenes != NULL) && 
		   ($remesas == '' || $remesas == 'NULL'  || $remesas == NULL) || 
		   ($aplica_total_factura == 1 && $remesas == '') || 
		   ($aplica_total_factura == 1 && $remesas == 'NULL')){ 

				foreach($result as $resultado){
					$debito	= '';
					$credito	= '';
					$ingresa	= 0;		 

					if(($resultado['porcentaje']=='' || $resultado['porcentaje']==NULL) && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1){
							$parcial	= $subtotal;
							$residual	= $parcial;
							$valor_liqui= $subtotal;
							$puc_descu_nom ="FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
							$base		= '';
							$porcentaje	= '';
							$formula	= '';
							$ingresa	= 1;
					
					}elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 &&  $resultado['monto']<=$valor_comp && (($resultado['exento']=='RT' && $resultado['autorete']=='N' ) || ($resultado['exento']=='IC' && $resultado['retei']=='N') || ($resultado['exento']=='CR' && $resultado['renta']=='N') || ($resultado['exento']=='NN')  || ($resultado['exento']=='IV') || ($resultado['exento']=='RIV') || ($resultado['exento']=='RIC' && $resultado['retei']=='N')) ){


							$formula	= $resultado['formula'];
							$porcentaje = $resultado['porcentaje'];
							$formula1	= $resultado['formula'];
							$porcentaje1= $resultado['porcentaje'];
							

							$base		= $resultado['reteica_bien_servicio_factura']==1? $subtotal:($subtotal);
							$calculo 	= str_replace("BASE",$base,$formula);
							$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
							$select1   = "SELECT $calculo AS valor_total";
							$result1   = $this -> DbFetchAll($select1 ,$Conex,true);
							$parcial 	= ceil($result1[0]['valor_total']);
							
							$base1		=  $subtotal;
							$calculo1 	= str_replace("BASE",$base1,$formula1);
							$calculo1 	= str_replace("PORCENTAJE",$porcentaje1,$calculo1);		  
							$select2   = "SELECT $calculo1 AS valor_total";
							$result2   = $this -> DbFetchAll($select2 ,$Conex,true);
							$puc_descu_nom ="CANC FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
							$valor_liqui= ceil($result2[0]['valor_total']);
							$ingresa	= 1;
							
					
					}elseif($resultado['tercero_bien_servicio_factura']==1){
					
						$i=0;
						foreach($ter_costos as $ter_costo){

							if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
								$total_pagar	= $total_pagar;
								$debito		= number_format(abs(round($total_pagar)),2,'.','');
								$credito		= '0.00';
								
							}elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
								$total_pagar	= $total_pagar;
								$debito		= '0.00';
								$credito		= number_format(abs(round($total_pagar)),2,'.','');			 
							}elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
								$debito		= number_format(abs(round($total_pagar)),2,'.','');	 
								$credito		= '0.00';
							}elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
								$debito		= '0.00';
								$credito		= number_format(abs(round($total_pagar)),2,'.','');			 
							}

							$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
							$centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
							$tercero = $resultado['puc_tercero']==1 ? $tercero_id : 'NULL';

							//aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
							if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
								$tercero = $tercero;
							}elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
								$tercero = $tercero_id;
							}else{
								$tercero == 'NULL';
							}
							

							if($centro_costo!='NULL'){
								$select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
								$result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
								$centro_costo_cod = $result_centro[0]['codigo'];
							}else{
								$centro_costo_cod = 'NULL';
							}

							if($tercero >0){
								$select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
								$result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
					
								$numero_iden_des= $result_tercero[0]['numero_identificacion'];
								$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
							}else{
								$numero_iden_des = 'NULL';
								$digito_iden_des = 'NULL';
							}

							$descripcion='';
							$descripcion= $complemento[$i];  
							$base		= '';
							$porcentaje	= '';
							$formula	= '';
							$tercero_pro = $tercero_id;
							$valor_liqui= round($ter_costo);
							$valor_liqui =	number_format(abs($valor_liqui),2,'.','');

							$insert_descu = "INSERT INTO item_abono (
													item_abono_id,						
													abono_factura_id,
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
													$abono_factura_id,
													$relacion_abono_id,
													$resultado[puc_id],
													$tercero,
													$numero_iden_des,
													$digito_iden_des,
													$centro_costo,
													'$centro_costo_cod',
													'$base',
													'$porcentaje',
													'$formula',
													'$puc_descu_nom',
													'$debito',
													'$credito'
											)"; 
									
							$this -> query($insert_descu,$Conex,true);
									
							$select_ret  = "SELECT  c.devpuc_bien_servicio_factura_id,
														c.tipo_bien_servicio_factura_id,
														c.puc_id,
														c.despuc_bien_servicio_factura,
														c.natu_bien_servicio_factura,
														c.contra_bien_servicio_factura,
														c.tercero_bien_servicio_factura,
														c.ret_tercero_bien_servicio_factura,
														c.reteica_bien_servicio_factura,
														c.aplica_ingreso,
														c.aplica_tenedor,

													(SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
													(SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
													(SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,			
													(SELECT autoret_cliente_factura  FROM cliente WHERE cliente_id=$cliente_id ) AS autorete,				
													(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS retei,			
													(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS renta,								
													(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,

														(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
														WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
														AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,	

														(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
														WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
														AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,			

														(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
														WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
														AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto	

												FROM devpuc_bien_servicio_factura  c
												WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";
														
							$result_ret = $this -> DbFetchAll($select_ret,$Conex,true);
							foreach($result_ret as $result_ret){

								if($result_ret['formula']!='' && $result_ret['porcentaje']>0 &&  $result_ret['monto']<=$valor_comp && (($result_ret['exento']=='RT' && $result_ret['autorete']!='S' && $resultado['autorete']!='S' ) || ($result_ret['exento']=='IC' && $result_ret['retei']!='S'  && $resultado['retei']!='S') || ($result_ret['exento']=='CR' && $result_ret['renta']!='S' && $resultado['renta']!='S') || ($result_ret['exento']=='NN') || ($result_ret['exento']=='RIC' && $result_ret['retei']!='S' && $resultado['retei']!='S'))){ 

										$formula	= $result_ret['formula'];
										$porcentaje= $result_ret['porcentaje'];
										$descripcion = $result_ret['puc_nombre'].' - '.$complemento[$i];

										$base		= round($ter_costo);
										$calculo 	= str_replace("BASE",$base,$formula);
										$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
										$select2   = "SELECT $calculo AS valor_total";
										$result2   = $this -> DbFetchAll($select2 ,$Conex,true);
										$parcial 	= round($result2[0]['valor_total']);
										$valor_liqui= round($result2[0]['valor_total']);
										
									
									if($result_ret['natu_bien_servicio_factura']=='D' && $result_ret['contra_bien_servicio_factura']!=1){
										$total_pagar	= $total_pagar+$parcial;
										$debito		= number_format(abs($parcial),2,'.','');
										$credito		= '0.00';
										
									}elseif($result_ret['natu_bien_servicio_factura']=='C' && $result_ret['contra_bien_servicio_factura']!=1){
										$total_pagar	= $total_pagar-$parcial;
										$debito		= '0.00';
										$credito		= number_format(abs($parcial),2,'.','');			 
									}elseif($result_ret['natu_bien_servicio_factura']=='D' && $result_ret['contra_bien_servicio_factura']==1){
										$debito		= number_format(abs($parcial),2,'.','');	 
										$credito		= '0.00';
									}elseif($result_ret['natu_bien_servicio_factura']=='C' && $result_ret['contra_bien_servicio_factura']==1){	 
										$debito		= '0.00';
										$credito		= number_format(abs($parcial),2,'.','');			 
									}
						
						
									$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
									$centro_costo = $result_ret['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
									$tercero = $result_ret['puc_tercero']==1 ? $tercero_id : 'NULL';

									//aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
									if($result_ret['puc_tercero']==1 && $result_ret['aplica_tenedor']==1){
										$tercero = $terid_costos[$i];
									}elseif($result_ret['puc_tercero']==1 && $result_ret['aplica_tenedor']==0){
										$tercero = $tercero;
									}else{
										$tercero == 'NULL';
									}
									
										if($centro_costo!='NULL'){
											$select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
											$result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
											$centro_costo_cod = $result_centro[0]['codigo'];
										}else{
											$centro_costo_cod = 'NULL';
										}

									if($tercero >0){
										$select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
										$result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
							
										$numero_iden_des= $result_tercero[0]['numero_identificacion'];
										$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
									}else{
										$numero_iden_des = 'NULL';
										$digito_iden_des = 'NULL';
									}

									$contra_bien_servicio_factura = $result_ret['contra_bien_servicio_factura'];
									$puc_id = $result_ret['puc_id'];
									$valor_liqui = number_format(abs($valor_liqui),2,'.','');
								
							
									$insert_descu = "INSERT INTO item_abono (
													item_abono_id,						
													abono_factura_id,
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
													$abono_factura_id,
													$relacion_abono_id,
													$puc_id,
													$tercero,
													$numero_iden_des,
													$digito_iden_des,
													$centro_costo,
													'$centro_costo_cod',
													'$base',
													'$porcentaje',
													'$formula',
													'$puc_descu_nom',
													'$debito',
													'$credito'
											)"; 
										
									$this -> query($insert_descu,$Conex,true);
									
								}
								
							}  
							$i++;
							
						}
					}elseif($resultado['contra_bien_servicio_factura']==1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 ){
							$parcial	= $total_pagar;
							$valor_liqui= $total_liqui;
							
							
							
							
							if($valor_liqui!=$parcial){ 

								$diferencia=$valor_liqui-$parcial;						
								$parcial=$valor_liqui; 

								if($diferencia > 0){
									
									$update1 = "UPDATE item_abono 
											SET  deb_item_abono=(deb_item_abono + ".$diferencia.") 
											WHERE abono_factura_id=$abono_factura_id AND deb_item_abono>0 LIMIT 1";
											$this -> query($update1,$Conex,true); 
											
								}

							}
							
							$base		= '';
							$porcentaje	= '';
							$formula	= '';	
							$puc_idcon	= $resultado['puc_id'];
							$ingresa	= 1;
					
					}elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']==1 &&  $residual>0 && ($resultado['exento']=='RIC' && $resultado['retei']!='S' && $resultado['retei']!='S')){
								
							$formula	= $resultado['formula'];
							$porcentaje = $resultado['porcentaje'];

							$base		= $residual;
							$calculo 	= str_replace("BASE",$base,$formula);
							$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
							$select2   = "SELECT $calculo AS valor_total";
							$result2   = $this -> DbFetchAll($select2 ,$Conex,true);
							$parcial 	= round($result2[0]['valor_total']);
							$ingresa	= 1;	
						
					}				 
					
					if($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1  && $resultado['aplica_ingreso']!=1 && $ingresa==1){
						
						
						
						if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
							
							$total_pagar	= $total_pagar+$parcial;
							$total_liqui	= $total_liqui+$valor_liqui;	
							
									 
							$debito		= number_format(abs($parcial),2,'.','');	
							$credito		= '0.00';
							
						}elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
							$total_pagar	= $total_pagar-$parcial;
							$total_liqui	= $total_liqui-$valor_liqui;
												 
							$debito		= '0.00';
							$credito		= number_format(abs($parcial),2,'.','');			 
						}elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
							$debito		= number_format(abs($parcial),2,'.','');	 
							$credito		= '0.00';
						}elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
							$debito		= '0.00';
							$credito		= number_format(abs($parcial),2,'.','');			 
						}
						

						$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
						$centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
						
						$tercero = $resultado['puc_tercero']==1 ? $tercero_id : 'NULL';

						//aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
							if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
								$tercero = $tercero_id;
							}elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
								$tercero = $tercero;
							}else{
								$tercero == 'NULL';
							}
					
							if($centro_costo!='NULL'){
								$select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
								$result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
								$centro_costo_cod = $result_centro[0]['codigo'];
							}else{
								$centro_costo_cod = 'NULL';
							}

							if($tercero >0){
								$select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
								$result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
					
								$numero_iden_des= $result_tercero[0]['numero_identificacion'];
								$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
							}else{
								$numero_iden_des = 'NULL';
								$digito_iden_des = 'NULL';
							}

						$valor_liqui = number_format(abs($valor_liqui),2,'.','');
						
						$insert_descu = "INSERT INTO item_abono (
													item_abono_id,						
													abono_factura_id,
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
													$abono_factura_id,
													$relacion_abono_id,
													$resultado[puc_id],
													$tercero,
													$numero_iden_des,
													$digito_iden_des,
													$centro_costo,
													'$centro_costo_cod',
													'$base',
													'$porcentaje',
													'$formula',
													'$puc_descu_nom',
													'$debito',
													'$credito'
											)"; 
											
									$this -> query($insert_descu,$Conex,true);
					
					}elseif($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1  && $resultado['aplica_ingreso']==1 && $ingresa==1){

						if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
							$debito		= number_format(round(abs($parcial)),2,'.','');			 
							$credito		= '0.00';
							$valor_liqui	= number_format(round(abs($parcial)),2,'.','');
							
						}elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
							$debito		= '0.00';
							$credito		= number_format(round(abs($parcial)),2,'.','');		
							$valor_liqui	= number_format(round(abs($parcial)),2,'.','');
						}elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
							$debito		= number_format(round(abs($parcial)),2,'.','');			 
							$credito		= '0.00';
							$valor_liqui	= number_format(round(abs($parcial)),2,'.','');						 
						}elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
							$debito		= '0.00';
							$credito		= number_format(round(abs($parcial)),2,'.','');		
							$valor_liqui	= number_format(round(abs($parcial)),2,'.','');						 
						}

						$select_ter_emp  = "SELECT tercero_id FROM empresa  WHERE empresa_id=$empresa_id";
						$result_ter_emp = $this -> DbFetchAll($select_ter_emp,$Conex,true);

						$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);
						$centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
						$tercero_1 = $resultado['puc_tercero']==1 ? $result_ter_emp[0]['tercero_id'] : 'NULL';

						//aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
							if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
								$tercero_1 = $tercero_id;
							}elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
								$tercero_1 = $tercero_1;
							}else{
								$tercero_1 == 'NULL';
							}
						
							if($centro_costo!='NULL'){
								$select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
								$result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
								$centro_costo_cod = $result_centro[0]['codigo'];
							}else{
								$centro_costo_cod = 'NULL';
							}

							if($tercero_1 >0){
								$select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero_1";
								$result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
					
								$numero_iden_des= $result_tercero[0]['numero_identificacion'];
								$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
							}else{
								$numero_iden_des = 'NULL';
								$digito_iden_des = 'NULL';
							}

						$valor_liqui=number_format(round(abs($valor_liqui)),2,'.','');
						
						$insert_descu = "INSERT INTO item_abono (
													item_abono_id,						
													abono_factura_id,
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
													$abono_factura_id,
													$relacion_abono_id,
													$resultado[puc_id],
													$tercero_1,
													$numero_iden_des,
													$digito_iden_des,
													$centro_costo,
													'$centro_costo_cod',
													'$base',
													'$porcentaje',
													'$formula',
													'$puc_descu_nom',
													'$debito',
													'$credito'
											)"; 
											
									$this -> query($insert_descu,$Conex,true);
					}
				}

			if($previsual != 1 && $motivo_nota != 3 && $motivo_nota != 4){
					$select="SELECT estado_orden_servicio, orden_servicio_id FROM orden_servicio WHERE orden_servicio_id IN($ordenes)";
                    $result = $this->DbFetchAll($select,$Conex,true);

					for($i=0;$i<count($result);$i++){

						$estado = $result[$i]['estado_orden_servicio'];
						$orden_servicio_id = $result[$i]['orden_servicio_id'];
	
					   if($estado != 'L'){
	
							$update="UPDATE orden_servicio SET estado_orden_servicio = 'L' WHERE orden_servicio_id = $orden_servicio_id";
							$this->query($update,$Conex,true);
	
					   }
					}
			}
			
		// Para cuando liberan remesas y no ordenes siempre y cuando aplique total factura sea igual a 1
		//Tambien ingresa cuando liberan ordenes y remesas
		}else if(($remesas != '' && $remesas != 'NULL' && $remesas != NULL) || 
				 ($aplica_total_factura == 1 && $ordenes == '') || 
				 ($aplica_total_factura == 1 && $ordenes == 'NULL')){ 
																		
		//si aplica total factura = 1 es porque el valor lo estan agragando manualmente 
		 if($aplica_total_factura==1){

			if($result_com[0]['num_cuentas']>0){

			//CUANDO EXISTE CONFIGURACION PARA TERCEROS
		    foreach($result as $resultado){
				 $debito	= '';
				 $credito	= '';
				 $ingresa	= 0;		 

				 if(($resultado['porcentaje']=='' || $resultado['porcentaje']==NULL) && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1){
					 
						$parcial	= $subtotal;
						$residual	= $parcial;
						$valor_liqui= $subtotal;
						$puc_descu_nom ="FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$base		= '';
						$porcentaje	= '';
						$formula	= '';
						$ingresa	= 1;
				
				 }elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 &&  $resultado['monto']<=$valor_comp && (($resultado['exento']=='RT' && $resultado['autorete']=='N' ) || ($resultado['exento']=='IC' && $resultado['retei']=='N') || ($resultado['exento']=='CR' && $resultado['renta']=='N') || ($resultado['exento']=='NN')  || ($resultado['exento']=='IV') || ($resultado['exento']=='RIV') || ($resultado['exento']=='RIC' && $resultado['retei']=='N')) ){


						$formula	= $resultado['formula'];
						$porcentaje = $resultado['porcentaje'];
						$formula1	= $resultado['formula'];
						$porcentaje1= $resultado['porcentaje'];
						
						$base		= $resultado['reteica_bien_servicio_factura']==1 ? 
						($subtotal+$sub_total_orden_remesa) : ($subtotal-$sub_costos+$sub_total_orden_remesa);
						
						$calculo 	= str_replace("BASE",$base,$formula);
						$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
						$select1   = "SELECT $calculo AS valor_total";
						$result1   = $this -> DbFetchAll($select1 ,$Conex,true);
						$parcial 	= ceil($result1[0]['valor_total']);
						
						$base1		=  $subtotal;
						$calculo1 	= str_replace("BASE",$base1,$formula1);
						$calculo1 	= str_replace("PORCENTAJE",$porcentaje1,$calculo1);		  
						$select2   = "SELECT $calculo1 AS valor_total";
						$result2   = $this -> DbFetchAll($select2 ,$Conex,true);
                        $puc_descu_nom ="CANC FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$valor_liqui= ceil($result2[0]['valor_total']);
						$ingresa	= 1;
						
				
				 }elseif($resultado['tercero_bien_servicio_factura']==1){
				
					 $i=0;
					 foreach($ter_costos as $ter_costo){

						 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
							 $total_pagar	= $total_pagar;
							 $debito		= number_format(abs(round($total_pagar)),2,'.','');
							 $credito		= '0.00';
							 
						 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
							 $total_pagar	= $total_pagar;
							 $debito		= '0.00';
							 $credito		= number_format(abs(round($total_pagar)),2,'.','');			 
						 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
							 $debito		= number_format(abs(round($total_pagar)),2,'.','');	 
							 $credito		= '0.00';
						 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
							 $debito		= '0.00';
							 $credito		= number_format(abs(round($total_pagar)),2,'.','');			 
						 }

						 $item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
						 $centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
						 $tercero = $resultado['puc_tercero']==1 ? $tercero_id : 'NULL';

						  //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero = $tercero;
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero = $tercero_id;
						 }else{
							 $tercero == 'NULL';
						 }
						 

						 if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						 }else{
							 $centro_costo_cod = 'NULL';
						 }

						 if($tercero >0){
							 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
							 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
				
							$numero_iden_des= $result_tercero[0]['numero_identificacion'];
							$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 }else{
							 $numero_iden_des = 'NULL';
							 $digito_iden_des = 'NULL';
						 }

						 $descripcion='';
						 $descripcion= $complemento[$i];  
						 $base		= '';
						 $porcentaje	= '';
						 $formula	= '';
						 $tercero_pro = $tercero_id;
						 $valor_liqui= round($ter_costo);
						 $valor_liqui =	number_format(abs($valor_liqui),2,'.','');

						$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
								
						$this -> query($insert_descu,$Conex,true);
								
						  $select_ret  = "SELECT  c.devpuc_bien_servicio_factura_id,
													c.tipo_bien_servicio_factura_id,
													c.puc_id,
													c.despuc_bien_servicio_factura,
													c.natu_bien_servicio_factura,
													c.contra_bien_servicio_factura,
													c.tercero_bien_servicio_factura,
													c.ret_tercero_bien_servicio_factura,
													c.reteica_bien_servicio_factura,
													c.aplica_ingreso,
													c.aplica_tenedor,

												(SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
												(SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
												(SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,			
												(SELECT autoret_cliente_factura  FROM cliente WHERE cliente_id=$cliente_id ) AS autorete,				
												(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS retei,			
												(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS renta,								
												(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,

													(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
													WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
													AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,	

													(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
													WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
													AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,			

													(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
													WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
													AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto	

											FROM devpuc_bien_servicio_factura  c
											WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";
													
						 $result_ret = $this -> DbFetchAll($select_ret,$Conex,true);
						 foreach($result_ret as $result_ret){

							if($result_ret['formula']!='' && $result_ret['porcentaje']>0 &&  $result_ret['monto']<=$valor_comp && (($result_ret['exento']=='RT' && $result_ret['autorete']!='S' && $resultado['autorete']!='S' ) || ($result_ret['exento']=='IC' && $result_ret['retei']!='S'  && $resultado['retei']!='S') || ($result_ret['exento']=='CR' && $result_ret['renta']!='S' && $resultado['renta']!='S') || ($result_ret['exento']=='NN') || ($result_ret['exento']=='RIC' && $result_ret['retei']!='S' && $resultado['retei']!='S'))){ 

									$formula	= $result_ret['formula'];
									$porcentaje= $result_ret['porcentaje'];
									$descripcion = $result_ret['puc_nombre'].' - '.$complemento[$i];

									$base		= round($ter_costo);
									$calculo 	= str_replace("BASE",$base,$formula);
									$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
									$select2   = "SELECT $calculo AS valor_total";
									$result2   = $this -> DbFetchAll($select2 ,$Conex,true);
									$parcial 	= round($result2[0]['valor_total']);
									$valor_liqui= round($result2[0]['valor_total']);
									
								
								 if($result_ret['natu_bien_servicio_factura']=='D' && $result_ret['contra_bien_servicio_factura']!=1){
									 $total_pagar	= $total_pagar+$parcial;
									 $debito		= number_format(abs($parcial),2,'.','');
									 $credito		= '0.00';
									 
								 }elseif($result_ret['natu_bien_servicio_factura']=='C' && $result_ret['contra_bien_servicio_factura']!=1){
									 $total_pagar	= $total_pagar-$parcial;
									 $debito		= '0.00';
									 $credito		= number_format(abs($parcial),2,'.','');			 
								 }elseif($result_ret['natu_bien_servicio_factura']=='D' && $result_ret['contra_bien_servicio_factura']==1){
									 $debito		= number_format(abs($parcial),2,'.','');	 
									 $credito		= '0.00';
								 }elseif($result_ret['natu_bien_servicio_factura']=='C' && $result_ret['contra_bien_servicio_factura']==1){	 
									 $debito		= '0.00';
									 $credito		= number_format(abs($parcial),2,'.','');			 
								 }
					
					
								 $item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
								 $centro_costo = $result_ret['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
								 $tercero = $result_ret['puc_tercero']==1 ? $tercero_id : 'NULL';

								  //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                  if($result_ret['puc_tercero']==1 && $result_ret['aplica_tenedor']==1){
							          $tercero = $terid_costos[$i];
						           }elseif($result_ret['puc_tercero']==1 && $result_ret['aplica_tenedor']==0){
                                      $tercero = $tercero;
						           }else{
							          $tercero == 'NULL';
						           }
                                
								    if($centro_costo!='NULL'){
										$select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
										$result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
										$centro_costo_cod = $result_centro[0]['codigo'];
									}else{
										$centro_costo_cod = 'NULL';
									}

								if($tercero >0){
									$select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
									$result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
						
									$numero_iden_des= $result_tercero[0]['numero_identificacion'];
									$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
								}else{
									$numero_iden_des = 'NULL';
									$digito_iden_des = 'NULL';
								}

								 $contra_bien_servicio_factura = $result_ret['contra_bien_servicio_factura'];
								 $puc_id = $result_ret['puc_id'];
								 $valor_liqui = number_format(abs($valor_liqui),2,'.','');
							
						
								$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$puc_id,
												$tercero,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
									
						         $this -> query($insert_descu,$Conex,true);
								
							 }
						  	 
						 }  
						 $i++;
						
					 }
				 }elseif($resultado['contra_bien_servicio_factura']==1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 ){
						$parcial	= $total_pagar;
						$valor_liqui= $total_liqui;
						
						
						
						
						if($valor_liqui!=$parcial){ 

							$diferencia=$valor_liqui-$parcial;						
							$parcial=$valor_liqui; 

							if($diferencia > 0){
								
								$update1 = "UPDATE item_abono 
										   SET  deb_item_abono=(deb_item_abono + ".$diferencia.") 
										   WHERE abono_factura_id=$abono_factura_id AND deb_item_abono>0 LIMIT 1";
										   $this -> query($update1,$Conex,true); 
										   
							}


						}
						
						$base		= '';
						$porcentaje	= '';
						$formula	= '';	
						$puc_idcon	= $resultado['puc_id'];
						$ingresa	= 1;
				
				 }elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']==1 &&  $residual>0 && ($resultado['exento']=='RIC' && $resultado['retei']!='S' && $resultado['retei']!='S')){
					 		
						$formula	= $resultado['formula'];
						$porcentaje = $resultado['porcentaje'];

						$base		= $residual;
						$calculo 	= str_replace("BASE",$base,$formula);
						$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
						$select2   = "SELECT $calculo AS valor_total";
						$result2   = $this -> DbFetchAll($select2 ,$Conex,true);
						$parcial 	= round($result2[0]['valor_total']);
						$ingresa	= 1;	
					 
				 }				 
				 
				 if($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1  && $resultado['aplica_ingreso']!=1 && $ingresa==1){
				
					 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){

						 $total_pagar	= $total_pagar+$parcial;
						 $total_liqui	= $total_liqui+$valor_liqui;
									 
						 $debito		= number_format(abs($parcial),2,'.','');	
						 $credito		= '0.00';
						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
						 $total_pagar	= $total_pagar-$parcial;
						 $total_liqui	= $total_liqui-$valor_liqui;
										 
						 $debito		= '0.00';
						 $credito		= number_format(abs($parcial),2,'.','');			 
					 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
						 $debito		= number_format(abs($parcial),2,'.','');	 
						 $credito		= '0.00';
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
						 $debito		= '0.00';
						 $credito		= number_format(abs($parcial),2,'.','');			 
					 }
					 

					$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
					$centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
					
					$tercero = $resultado['puc_tercero']==1 ? $tercero_id : 'NULL';

					//aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero = $tercero_id;
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero = $tercero;
						 }else{
							 $tercero == 'NULL';
						 }
                   
					    if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						}else{
							 $centro_costo_cod = 'NULL';
						}

					    if($tercero >0){
							 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
							 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
				
							$numero_iden_des= $result_tercero[0]['numero_identificacion'];
							$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 }else{
							 $numero_iden_des = 'NULL';
							 $digito_iden_des = 'NULL';
						 }

                    $valor_liqui = number_format(abs($valor_liqui),2,'.','');
					 
					 $insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
										
						         $this -> query($insert_descu,$Conex,true);
				
				}elseif($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1  && $resultado['aplica_ingreso']==1 && $ingresa==1){

					 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
						 $debito		= number_format(round(abs($parcial)),2,'.','');			 
						 $credito		= '0.00';
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');
						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
						 $debito		= '0.00';
						 $credito		= number_format(round(abs($parcial)),2,'.','');		
 						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');
					 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
						 $debito		= number_format(round(abs($parcial)),2,'.','');			 
						 $credito		= '0.00';
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
						 $debito		= '0.00';
						 $credito		= number_format(round(abs($parcial)),2,'.','');		
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');						 
					 }

					 $select_ter_emp  = "SELECT tercero_id FROM empresa  WHERE empresa_id=$empresa_id";
					 $result_ter_emp = $this -> DbFetchAll($select_ter_emp,$Conex,true);

					 $item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);
					 $centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
					 $tercero_1 = $resultado['puc_tercero']==1 ? $result_ter_emp[0]['tercero_id'] : 'NULL';

					 //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero_1 = $tercero_id;
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero_1 = $tercero_1;
						 }else{
							 $tercero_1 == 'NULL';
						 }
                    
					    if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						}else{
							 $centro_costo_cod = 'NULL';
						}

					     if($tercero_1 >0){
							 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero_1";
							 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
				
							$numero_iden_des= $result_tercero[0]['numero_identificacion'];
							$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 }else{
							 $numero_iden_des = 'NULL';
							 $digito_iden_des = 'NULL';
						 }

					 $valor_liqui=number_format(round(abs($valor_liqui)),2,'.','');
					 
					 $insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero_1,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
										
						         $this -> query($insert_descu,$Conex,true);
				}
			} 
			
			}else{

				foreach ($result as $resultado) {
					$debito = '';
					$credito = '';
					$ingresa = 0;
					$descripcion = '';
					$descripcion = $resultado[puc_nombre];

					if (($resultado[porcentaje] == '' || $resultado[porcentaje] == null) && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {

						$parcial = $subtotal;
						$residual = $parcial;
						$valor_liqui = $subtotal;
						$base = '';
						$porcentaje = '';
						$formula = '';
						$ingresa = 1;

					} elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $resultado[monto] <= $valor_comp && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

						if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {

							$resultado[puc_id] = $result_ric[0]['puc_id'];
							$descripcion = $result_ric[0]['descripcion'];
							$formula = $result_ric[0]['formula'];
							$porcentaje = $result_ric[0]['porcentaje'];

						} else {

							$formula = $resultado[formula];
							$porcentaje = $resultado[porcentaje];

						}
						$base = $subtotal;
						$calculo = str_replace("BASE", $base, $formula);
						$calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
						$select1 = "SELECT $calculo AS valor_total";
						$result1 = $this->DbFetchAll($select1, $Conex);
						$parcial = round($result1[0]['valor_total']);
						$valor_liqui = round($result1[0]['valor_total']);
						$ingresa = 1;

					} elseif ($resultado[contra_bien_servicio_factura] == 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1) {
						
						
						
						$parcial = $total_pagar;
						$valor_liqui = $total_liqui;
						
						
					
						$base = '';
						$porcentaje = '';
						$formula = '';
						$puc_idcon = $resultado[puc_id];
						$ingresa = 1;

					} elseif ($resultado[porcentaje] > 0 && $resultado[contra_bien_servicio_factura] != 1 && $resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $residual > 0 && (($resultado[exento] == 'RT' && $resultado[autorete] == 'N') || ($resultado[exento] == 'IC' && $resultado[retei] == 'N') || ($resultado[exento] == 'CR' && $resultado[renta] == 'N') || ($resultado[exento] == 'NN') || ($resultado[exento] == 'IV') || ($resultado[exento] == 'RIV') || ($resultado[exento] == 'RIC' && $resultado[retei] == 'N'))) {

						if ($impuesto_id > 0 && $resultado[exento] == 'RIC') {

							$resultado[puc_id] = $result_ric[0]['puc_id'];
							$descripcion = $result_ric[0]['descripcion'];
							$formula = $result_ric[0]['formula'];
							$porcentaje = $result_ric[0]['porcentaje'];

						} else {

							$formula = $resultado[formula];
							$porcentaje = $resultado[porcentaje];

						}

						$base = $residual;
						$calculo = str_replace("BASE", $base, $formula);
						$calculo = str_replace("PORCENTAJE", $porcentaje, $calculo);
						$select2 = "SELECT $calculo AS valor_total";
						$result2 = $this->DbFetchAll($select2, $Conex);
						$parcial = round($result2[0]['valor_total']);
						$ingresa = 1;

					}

					if ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] != 1 && $ingresa == 1) {

						if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
							
							$total_pagar = $total_pagar + $parcial;
							$total_liqui = $total_liqui + $valor_liqui;
							
							
							
							$debito = number_format(abs($parcial), 2, '.', '');
							$credito = '0.00';

						} elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
							
							$total_pagar = $total_pagar - $parcial;
							$total_liqui = $total_liqui - $valor_liqui;
							
							
							
							$debito = '0.00';
							$credito = number_format(abs($parcial), 2, '.', '');
						} elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
							$debito = number_format(abs($parcial), 2, '.', '');
							$credito = '0.00';
						} elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
							$debito = '0.00';
							$credito = number_format(abs($parcial), 2, '.', '');
						}

						$item_abono_id = $this->DbgetMaxConsecutive("item_abono", "item_abono_id", $Conex, true, 1);
						$centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
						$tercero = $resultado[puc_tercero] == 1 ? $tercero_id : 'NULL';
						$valor_liqui = number_format(abs($valor_liqui), 2, '.', '');

						$insert = "INSERT INTO
							item_abono (
								item_abono_id,						
								abono_factura_id,
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
								cre_item_abono
							)
							VALUES (
								$item_abono_id,
								$abono_factura_id,
								$relacion_abono_id,
								$resultado[puc_id],
								$tercero_id,
								IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),
								IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),
								$centro_costo,
								IF($centro_costo>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id=$centro_costo),NULL),
								'$base',
								'$porcentaje',
								'$formula',
								'$descripcion',
								'$debito',
								'$credito'
							)";
						
						$this->query($insert, $Conex, true);

					} elseif ($resultado[tercero_bien_servicio_factura] != 1 && $resultado[ret_tercero_bien_servicio_factura] != 1 && $resultado[aplica_ingreso] == 1 && $ingresa == 1) {

						if ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] != 1) {
							$debito = number_format(round(abs($parcial)), 2, '.', '');
							$credito = '0.00';
							$valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
							
							

						} elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] != 1) {
							$debito = '0.00';
							$credito = number_format(round(abs($parcial)), 2, '.', '');
							$valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
							
						

						} elseif ($resultado[natu_bien_servicio_factura] == 'D' && $resultado[contra_bien_servicio_factura] == 1) {
							$debito = number_format(round(abs($parcial)), 2, '.', '');
							$credito = '0.00';
							$valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
							
							

						} elseif ($resultado[natu_bien_servicio_factura] == 'C' && $resultado[contra_bien_servicio_factura] == 1) {
							$debito = '0.00';
							$credito = number_format(round(abs($parcial)), 2, '.', '');
							$valor_liqui = number_format(round(abs($parcial)), 2, '.', '');
							
						

						}

						$select_ter_emp = "SELECT tercero_id FROM empresa WHERE empresa_id=$empresa_id";
						$result_ter_emp = $this->DbFetchAll($select_ter_emp, $Conex, true);

						$item_abono_id = $this->DbgetMaxConsecutive("item_abono", "item_abono_id", $Conex, true, 1);
						$centro_costo = $resultado[puc_centro] == 1 ? $centro_de_costo_id : 'NULL';
						$tercero_1 = $resultado[puc_tercero] == 1 ? $result_ter_emp[0][tercero_id] : 'NULL';
						$valor_liqui = number_format(round(abs($valor_liqui)), 2, '.', '');
						
					

						$insert = "INSERT INTO
							item_abono (
								item_abono_id,						
								abono_factura_id,
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
								cre_item_abono
							)
							VALUES (
								$item_abono_id,
								$abono_factura_id,
								$relacion_abono_id,
								$resultado[puc_id],
								$tercero_1,
								IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),
								IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),
								$centro_costo,
								IF($centro_costo>0,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id=$centro_costo),NULL),
								'$base',
								'$porcentaje',
								'$formula',
								'$descripcion',
								'$debito',
								'$credito'
							)";
						$this->query($insert, $Conex, true);

					}
				}

			}

		 }else{

			
		    if($result_com[0]['num_cuentas']>0){
		    //CUANDO EXISTE CONFIGURACION PARA TERCEROS
		    foreach($result as $resultado){
				 $debito	= '';
				 $credito	= '';
				 $ingresa	= 0;		 

				 if(($resultado['porcentaje']=='' || $resultado['porcentaje']==NULL) && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1){
							
					    $parcial	= abs($subtotal-$sub_costos+$sub_total_orden_remesa);
						$residual	= $parcial;
						$valor_liqui= $subtotal;
						
						$puc_descu_nom ="FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$base		= '';
						$porcentaje	= '';
						$formula	= '';
						$ingresa	= 1;
				
				 }elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 &&  $resultado['monto']<=$valor_comp && (($resultado['exento']=='RT' && $resultado['autorete']=='N' ) || ($resultado['exento']=='IC' && $resultado['retei']=='N') || ($resultado['exento']=='CR' && $resultado['renta']=='N') || ($resultado['exento']=='NN')  || ($resultado['exento']=='IV') || ($resultado['exento']=='RIV') || ($resultado['exento']=='RIC' && $resultado['retei']=='N')) ){


						$formula	= $resultado['formula'];
						$porcentaje = $resultado['porcentaje'];
						$formula1	= $resultado['formula'];
						$porcentaje1= $resultado['porcentaje'];
						

					    $base		= $resultado['reteica_bien_servicio_factura']==1? 
						($subtotal+$sub_total_orden_remesa) : ($subtotal-$sub_costos+$sub_total_orden_remesa);
						$calculo 	= str_replace("BASE",$base,$formula);
						$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
						$select1    = "SELECT $calculo AS valor_total";
						$result1    = $this -> DbFetchAll($select1 ,$Conex,true);
						$parcial 	= ceil($result1[0]['valor_total']);
						
						$base1		=  $subtotal+$sub_total_orden_remesa;
						$calculo1 	= str_replace("BASE",$base1,$formula1);
						$calculo1 	= str_replace("PORCENTAJE",$porcentaje1,$calculo1);		  
						$select2    = "SELECT $calculo1 AS valor_total";
						$result2    = $this -> DbFetchAll($select2 ,$Conex,true);
                        $puc_descu_nom ="CANC FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$valor_liqui= ceil($result2[0]['valor_total']);
						$ingresa	= 1;
						
						
				
				 }elseif($resultado['tercero_bien_servicio_factura']==1){
				
					 $i=0;
					 foreach($ter_costos as $ter_costo){

						 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
							 $total_pagar	= $total_pagar+round($ter_costo);
							 $debito		= number_format(abs(round($ter_costo)),2,'.','');
							 $credito		= '0.00';
							 
						 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
							 $total_pagar	= $total_pagar-round($ter_costo);
							 $debito		= '0.00';
							 $credito		= number_format(abs(round($ter_costo)),2,'.','');	
							 
						 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
							 $debito		= number_format(abs(round($ter_costo)),2,'.','');	 
							 $credito		= '0.00';
						 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
							 $debito		= '0.00';
							 $credito		= number_format(abs(round($ter_costo)),2,'.','');			 
						 }

						 $item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
						 $centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
						 $tercero = $resultado['puc_tercero']==1 ? $terid_costos[$i] : 'NULL';

						  //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero = $tercero;
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero = $tercero_id;
						 }else{
							 $tercero == 'NULL';
						 }
						 

						 if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						 }else{
							 $centro_costo_cod = 'NULL';
						 }

						 if($tercero >0){
							 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
							 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
				
							$numero_iden_des= $result_tercero[0]['numero_identificacion'];
							$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 }else{
							 $numero_iden_des = 'NULL';
							 $digito_iden_des = 'NULL';
						 }

						 $descripcion='';
						 $descripcion= $complemento[$i];  
						 $base		= '';
						 $porcentaje	= '';
						 $formula	= '';
						 $tercero_pro = $terid_costos[$i];
						 $valor_liqui= round($ter_costo);
						 $valor_liqui =	number_format(abs($valor_liqui),2,'.','');
						 
						

						$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
								
						$this -> query($insert_descu,$Conex,true);
								
						  $select_ret  = "SELECT  c.devpuc_bien_servicio_factura_id,
													c.tipo_bien_servicio_factura_id,
													c.puc_id,
													c.despuc_bien_servicio_factura,
													c.natu_bien_servicio_factura,
													c.contra_bien_servicio_factura,
													c.tercero_bien_servicio_factura,
													c.ret_tercero_bien_servicio_factura,
													c.reteica_bien_servicio_factura,
													c.aplica_ingreso,
													c.aplica_tenedor,

												(SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
												(SELECT requiere_centro_costo FROM puc WHERE puc_id=c.puc_id) AS puc_centro,
												(SELECT requiere_tercero FROM puc WHERE puc_id=c.puc_id) AS puc_tercero,			
												(SELECT autoret_cliente_factura  FROM cliente WHERE cliente_id=$cliente_id ) AS autorete,				
												(SELECT retei_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS retei,			
												(SELECT renta_cliente_factura FROM cliente WHERE cliente_id=$cliente_id ) AS renta,								
												(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,

													(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
													WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
													AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,	

													(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
													WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
													AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,			

													(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
													WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
													AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto	

											FROM devpuc_bien_servicio_factura  c
											WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura";
													
						 $result_ret = $this -> DbFetchAll($select_ret,$Conex,true);
						 foreach($result_ret as $result_ret){

							if($result_ret['formula']!='' && $result_ret['porcentaje']>0 &&  $result_ret['monto']<=$valor_comp && (($result_ret['exento']=='RT' && $result_ret['autorete']!='S' && $resultado['autorete']!='S' ) || ($result_ret['exento']=='IC' && $result_ret['retei']!='S'  && $resultado['retei']!='S') || ($result_ret['exento']=='CR' && $result_ret['renta']!='S' && $resultado['renta']!='S') || ($result_ret['exento']=='NN') || ($result_ret['exento']=='RIC' && $result_ret['retei']!='S' && $resultado['retei']!='S'))){ 

									$formula	= $result_ret['formula'];
									$porcentaje= $result_ret['porcentaje'];
									$descripcion = $result_ret['puc_nombre'].' - '.$complemento[$i];

									$base		= round($ter_costo);
									$calculo 	= str_replace("BASE",$base,$formula);
									$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
									$select2    = "SELECT $calculo AS valor_total";
									$result2    = $this -> DbFetchAll($select2 ,$Conex,true);
									$parcial 	= round($result2[0]['valor_total']);
									$valor_liqui= round($result2[0]['valor_total']);
									
								
									
								 if($result_ret['natu_bien_servicio_factura']=='D' && $result_ret['contra_bien_servicio_factura']!=1){
									 $total_pagar	= $total_pagar+$parcial;
									 $debito		= number_format(abs($parcial),2,'.','');
									 $credito		= '0.00';
									 
								 }elseif($result_ret['natu_bien_servicio_factura']=='C' && $result_ret['contra_bien_servicio_factura']!=1){
									 $total_pagar	= $total_pagar-$parcial;
									 $debito		= '0.00';
									 $credito		= number_format(abs($parcial),2,'.','');
									 			 
								 }elseif($result_ret['natu_bien_servicio_factura']=='D' && $result_ret['contra_bien_servicio_factura']==1){
									 $debito		= number_format(abs($parcial),2,'.','');	 
									 $credito		= '0.00';
								 }elseif($result_ret['natu_bien_servicio_factura']=='C' && $result_ret['contra_bien_servicio_factura']==1){	 
									 $debito		= '0.00';
									 $credito		= number_format(abs($parcial),2,'.','');
									 		 
								 }
					
					
								 $item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
								 $centro_costo = $result_ret['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
								 $tercero = $result_ret['puc_tercero']==1 ? $tercero_id : 'NULL';

								  //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                                  if($result_ret['puc_tercero']==1 && $result_ret['aplica_tenedor']==1){
							          $tercero = $terid_costos[$i];
						           }elseif($result_ret['puc_tercero']==1 && $result_ret['aplica_tenedor']==0){
                                      $tercero = $tercero;
						           }else{
							          $tercero == 'NULL';
						           }
                                
								    if($centro_costo!='NULL'){
										$select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
										$result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
										$centro_costo_cod = $result_centro[0]['codigo'];
									}else{
										$centro_costo_cod = 'NULL';
									}

								if($tercero >0){
									$select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
									$result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
						
									$numero_iden_des= $result_tercero[0]['numero_identificacion'];
									$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
								}else{
									$numero_iden_des = 'NULL';
									$digito_iden_des = 'NULL';
								}

								 $contra_bien_servicio_factura = $result_ret['contra_bien_servicio_factura'];
								 $puc_id = $result_ret['puc_id'];
								 $valor_liqui = number_format(abs($valor_liqui),2,'.','');
								 
								
							
						
								$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$puc_id,
												$tercero,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
									
						         $this -> query($insert_descu,$Conex,true);
								
							 }
						  	 
						 }  
						 $i++;
						
					 }
				 }elseif($resultado['contra_bien_servicio_factura']==1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 ){
						$parcial	= $total_pagar;
						$valor_liqui= $total_liqui;
						
						
					
						if($valor_liqui!=$parcial){ 
												   
							
							$diferencia=$valor_liqui-$parcial;						
							$parcial   =$valor_liqui; 
							
						}
						
						$base		= '';
						$porcentaje	= '';
						$formula	= '';	
						$puc_idcon	= $resultado['puc_id'];
						$ingresa	= 1;
				
				 }elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']==1 &&  $residual>0 && ($resultado['exento']=='RIC' && $resultado['retei']!='S' && $resultado['retei']!='S')){
					 		
						$formula	= $resultado['formula'];
						$porcentaje = $resultado['porcentaje'];

						$base		= $residual;
						$calculo 	= str_replace("BASE",$base,$formula);
						$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
						$select2   = "SELECT $calculo AS valor_total";
						$result2   = $this -> DbFetchAll($select2 ,$Conex,true);
						$parcial 	= round($result2[0]['valor_total']);
						
						$ingresa	= 1;	
					 
				 }				 
				 
				 if($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1  && $resultado['aplica_ingreso']!=1 && $ingresa==1){
					 
					
				      
					 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){

						 $total_pagar	= $total_pagar+$parcial;
						 $total_liqui	= $total_liqui+$valor_liqui+$sub_total_orden_remesa;	
									 
						 $debito		= number_format(abs($parcial),2,'.','');	
						 $credito		= '0.00';
						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
						 $total_pagar	= $total_pagar-$parcial;
						 $total_liqui	= $total_liqui-$valor_liqui;
											 
						 $debito		= '0.00';
						 $credito		= number_format(abs($parcial),2,'.','');	
						 		 
					 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
						 $debito		= number_format(abs($parcial),2,'.','');	 
						 $credito		= '0.00';
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
						 $debito		= '0.00';
						 $credito		= number_format(abs($parcial),2,'.','');
						 	 
					 }
					 

					$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
					$centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
					
					$tercero = $resultado['puc_tercero']==1 ? $tercero_id : 'NULL';

					//aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero = $terid_costos[$i];
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero = $tercero;
						 }else{
							 $tercero == 'NULL';
						 }
                   
					    if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						}else{
							 $centro_costo_cod = 'NULL';
						}

					    if($tercero >0){
							 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
							 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
				
							$numero_iden_des= $result_tercero[0]['numero_identificacion'];
							$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 }else{
							 $numero_iden_des = 'NULL';
							 $digito_iden_des = 'NULL';
						 }

                    $valor_liqui = number_format(abs($valor_liqui),2,'.','');
					 
					 $insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
										
						         $this -> query($insert_descu,$Conex,true);
				
				}elseif($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1  && $resultado['aplica_ingreso']==1 && $ingresa==1){

					 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
						 $debito		= number_format(round(abs($parcial)),2,'.','');			 
						 $credito		= '0.00';
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');
						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
						 $debito		= '0.00';
						 $credito		= number_format(round(abs($parcial)),2,'.','');		
 						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');
					 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
						 $debito		= number_format(round(abs($parcial)),2,'.','');			 
						 $credito		= '0.00';
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
						 $debito		= '0.00';
						 $credito		= number_format(round(abs($parcial)),2,'.','');		
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');						 
					 }

					 $select_ter_emp  = "SELECT tercero_id FROM empresa  WHERE empresa_id=$empresa_id";
					 $result_ter_emp = $this -> DbFetchAll($select_ter_emp,$Conex,true);

					 $item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);
					 $centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
					 $tercero_1 = $resultado['puc_tercero']==1 ? $result_ter_emp[0]['tercero_id'] : 'NULL';

					 //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero_1 = $terid_costos[$i];
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero_1 = $tercero_1;
						 }else{
							 $tercero_1 == 'NULL';
						 }
                    
					    if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						}else{
							 $centro_costo_cod = 'NULL';
						}

					     if($tercero_1 >0){
							 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero_1";
							 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
				
							$numero_iden_des= $result_tercero[0]['numero_identificacion'];
							$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 }else{
							 $numero_iden_des = 'NULL';
							 $digito_iden_des = 'NULL';
						 }

					 $valor_liqui=number_format(round(abs($valor_liqui)),2,'.','');
					 
					 $insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero_1,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
										
						         $this -> query($insert_descu,$Conex,true);
				}
			}  
			
		}else{

			//CUANDO NO EXISTE CONFIGURACION PARA TERCEROS
			foreach($result as $resultado){
				
				 $debito	= '';
				 $credito	= '';
				 $ingresa	= 0;		 
				
				 if(($resultado['porcentaje']=='' || $resultado['porcentaje']==NULL) && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1){
					 
						$parcial	= $subtotal;
						$residual	= $parcial;
						$valor_liqui= $subtotal;
						$puc_descu_nom ="FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$base		= '';
						$porcentaje	= '';
						$formula	= '';
						$ingresa	= 1;
						
					}elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 &&  $resultado['monto']<=$valor_comp && (($resultado['exento']=='RT' && $resultado['autorete']=='N' ) || ($resultado['exento']=='IC' && $resultado['retei']=='N') || ($resultado['exento']=='CR' && $resultado['renta']=='N') || ($resultado['exento']=='NN')  || ($resultado['exento']=='IV') || ($resultado['exento']=='RIV') || ($resultado['exento']=='RIC' && $resultado['retei']=='N')) ){
						
						$formula	= $resultado['formula'];
						$porcentaje= $resultado['porcentaje'];
						
						$base		= $subtotal;
						$calculo 	= str_replace("BASE",$base,$formula);
						$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
						$select1   = "SELECT $calculo AS valor_total";
						$result1   = $this -> DbFetchAll($select1 ,$Conex);
						$parcial 	= round($result1[0]['valor_total']);
						$puc_descu_nom ="CANC FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$ingresa	= 1;
				
				 }elseif($resultado['contra_bien_servicio_factura']==1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 ){
						$parcial	= $total_pagar;
						$valor_liqui= $total_liqui;
						$base		= '';
						$porcentaje	= '';
						$formula	= '';	
						$puc_idcon	= $resultado['puc_id'];
						$puc_descu_nom = "CANC. FACTURAS: ".$result_clien[0]['cliente']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$ingresa	= 1;
				
				 }elseif($resultado['porcentaje']>0 && $resultado['contra_bien_servicio_factura']!=1 && $resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']==1 &&  $residual>0 && (($resultado['exento']=='RT' && $resultado['autorete']=='N' ) || ($resultado['exento']=='IC' && $resultado['retei']=='N') || ($resultado['exento']=='CR' && $resultado['renta']=='N') || ($resultado['exento']=='NN')  || ($resultado['exento']=='IV') || ($resultado['exento']=='RIV') || ($resultado['exento']=='RIC' && $resultado['retei']=='N')) ){
					 
						$formula	= $resultado['formula'];
						$porcentaje = $resultado['porcentaje'];
								
						$base		= $residual;
						$calculo 	= str_replace("BASE",$base,$formula);
						$calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
						$select2   = "SELECT $calculo AS valor_total";
						$result2   = $this -> DbFetchAll($select2 ,$Conex);
						$parcial 	= round($result2[0]['valor_total']);
						$puc_descu_nom ="CANC FACT: ".$result_contra[0]['consecutivo_factura']." CONCEPTO: ".str_replace("'", "",$concepto_abono_factura);
						$ingresa	= 1;
					 
				 }
				 
				 
				 if($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1 && $resultado['aplica_ingreso']!=1 && $ingresa==1){
				
					 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){					 
						$total_pagar	= $total_pagar+$parcial;
						$total_liqui	= $total_liqui+$valor_liqui; 
						$debito		= number_format(abs($parcial),2,'.','');		 
						 $credito		= '0.00'; 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){					 
						 $total_pagar	= $total_pagar-$parcial;
						 $total_liqui	= $total_liqui-$valor_liqui; 
						 $debito		= '0.00';
						 $credito		= number_format(abs($parcial),2,'.','');			 
					 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
						 $debito		= number_format(abs($parcial),2,'.','');	 
						 $credito		= '0.00';
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
						 $debito		= '0.00';
						 $credito		= number_format(abs($parcial),2,'.','');			 
					 }
					 
					 
					$item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
					 $centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
					 $tercero = $resultado['puc_tercero']==1 ? $tercero_id : 'NULL';

					 //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero = $terid_costos[$i];
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero = $tercero;
						 }else{
							 $tercero == 'NULL';
						 }
                     
					    if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						}else{
							 $centro_costo_cod = 'NULL';
						}

					     if($tercero >0){
							 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero";
							 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
				
							$numero_iden_des= $result_tercero[0]['numero_identificacion'];
							$digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 }else{
							 $numero_iden_des = 'NULL';
							 $digito_iden_des = 'NULL';
						 }

						$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito',
												'$credito'
										)"; 
										
						$this -> query($insert_descu,$Conex,true);	
				
				}elseif($resultado['tercero_bien_servicio_factura']!=1 && $resultado['ret_tercero_bien_servicio_factura']!=1  && $resultado['aplica_ingreso']==1 && $ingresa==1){
				
                         
					 if($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']!=1){
						 $debito		= number_format(round(abs($parcial)),2,'.','');
						 $credito		= '0.00';
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');
						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']!=1){
						 $debito		= '0.00';
						 $credito		= number_format(round(abs($parcial)),2,'.','');	
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');		
						 
					 }elseif($resultado['natu_bien_servicio_factura']=='D' && $resultado['contra_bien_servicio_factura']==1){
						 $debito		= number_format(round(abs($parcial)),2,'.','');	 
						 $credito		= '0.00';
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');	
						 
					 }elseif($resultado['natu_bien_servicio_factura']=='C' && $resultado['contra_bien_servicio_factura']==1){	 
						 $debito		= '0.00';
						 $credito		= number_format(round(abs($parcial)),2,'.','');	
						 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');
						 
					 }
					 
					 $select_ter_emp  = "SELECT tercero_id FROM empresa WHERE empresa_id=$empresa_id";
					 $result_ter_emp = $this -> DbFetchAll($select_ter_emp,$Conex,true);

					 $item_abono_id 	= $this -> DbgetMaxConsecutive("item_abono","item_abono_id",$Conex,true,1);	
			
					 $centro_costo = $resultado['puc_centro']==1 ? $centro_de_costo_id : 'NULL';
					 $tercero_1 = $resultado['puc_tercero']==1 ? $result_ter_emp[0]['tercero_id'] : 'NULL';

					 //aqui validamos si dejamos el tercero del cliente o el tercero del tenedor
                         if($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==1){
							 $tercero_1 = $terid_costos[$i];
						 }elseif($resultado['puc_tercero']==1 && $resultado['aplica_tenedor']==0){
                            $tercero_1 = $tercero_1;
						 }else{
							 $tercero_1 == 'NULL';
						 }

					 $valor_liqui = number_format(round(abs($valor_liqui)),2,'.','');

					    if($centro_costo!='NULL'){
							 $select_centro 	 = "SELECT codigo FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo";
							 $result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,true);
							 $centro_costo_cod = $result_centro[0]['codigo'];
						}else{
							 $centro_costo_cod = 'NULL';
						}

					 if($tercero_1>0){

						 $select_tercero  = "SELECT numero_identificacion, digito_verificacion FROM tercero WHERE tercero_id=$tercero_1";
						 $result_tercero = $this -> DbFetchAll($select_tercero,$Conex,true);
						 
						 $numero_iden_des= $result_tercero[0]['numero_identificacion'];
						 $digito_iden_des = $result_tercero['digito_verificacion']!='' ? $result_tercero['digito_verificacion'] : 'NULL';
						 
					 }else{
						$numero_iden_des = 'NULL';
						$digito_iden_des = 'NULL';
					 }
						$insert_descu = "INSERT INTO item_abono (
												item_abono_id,						
												abono_factura_id,
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
												$abono_factura_id,
												$relacion_abono_id,
												$resultado[puc_id],
												$tercero_1,
												$numero_iden_des,
												$digito_iden_des,
												$centro_costo,
												'$centro_costo_cod',
												'$base',
												'$porcentaje',
												'$formula',
												'$puc_descu_nom',
												'$debito_des_uni',
												'$credito_des_uni'
										)"; 
										
						$this -> query($insert_descu,$Conex,true);	

				}
			}
		}
	   }

		if($previsual != 1 && $motivo_nota != 3 && $motivo_nota != 4){

			if($remesas != ''){

			$select="SELECT estado, remesa_id FROM remesa WHERE remesa_id IN ($remesas)";
            $result = $this->DbFetchAll($select,$Conex,true);

                for($i=0;$i<count($result);$i++){

						$estado = $result[$i]['estado'];
						$remesa_id = $result[$i]['remesa_id'];
	
					   if($estado != 'LQ'){
							$update="UPDATE remesa SET estado = 'LQ' WHERE remesa_id = $remesa_id";
							$this->query($update,$Conex,true);

							$update="UPDATE detalle_factura SET liberada = 1 WHERE remesa_id = $remesa_id AND factura_id = $causaciones_abono_factura";
							$this->query($update,$Conex,true);
					   }


				}

			}

			if($ordenes!=''){
                $select="SELECT estado_orden_servicio, orden_servicio_id FROM orden_servicio WHERE orden_servicio_id IN ($ordenes)";
                $result = $this->DbFetchAll($select,$Conex,true);

                for($i=0;$i<count($result);$i++){

						$estado_orden_servicio = $result[$i]['estado_orden_servicio'];
						$orden_servicio_id = $result[$i]['orden_servicio_id'];
	
					   if($estado_orden_servicio != 'LQ'){
							$update="UPDATE orden_servicio SET estado_orden_servicio = 'L' WHERE orden_servicio_id = $orden_servicio_id";
							$this->query($update,$Conex,true);

							$update="UPDATE detalle_factura SET liberada = 1 WHERE orden_servicio_id = $orden_servicio_id AND factura_id = $causaciones_abono_factura";
							$this->query($update,$Conex,true);
					   }


		        }
			}

			
		}
	}

		$select="SELECT i.item_abono_id,						
							i.abono_factura_id,
							i.relacion_abono_id,
							i.puc_id,
							(SELECT codigo_puc FROM puc WHERE puc_id = i.puc_id)AS codigo_puc,
							i.tercero_id,
							i.numero_identificacion,
							i.digito_verificacion,
							i.centro_de_costo_id,
							i.codigo_centro_costo,
							i.base_abono,
						    i.porcentaje_abono,
							i.formula_abono,
							i.desc_abono,
							i.deb_item_abono,
							i.cre_item_abono
					FROM item_abono i WHERE i.abono_factura_id=$abono_factura_id";
				
		$result = $this -> DbFetchAll($select,$Conex,true);	
       
		if($previsual == 1){	
			$this -> Rollback($Conex);
			return $result;
		}else if($previsual == 0){
			$this -> Commit($Conex);
			return $result;	
		}

  }

}



?>
