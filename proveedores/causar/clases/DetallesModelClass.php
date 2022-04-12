<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($factura_proveedor_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($factura_proveedor_id)){

		 $select      = "SELECT COUNT(*) AS movimientos FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
		 $result      = $this -> DbFetchAll($select,$Conex,true);

		 $movimientos = $result[0]['movimientos'];
	 
	 	 if($movimientos ==0){
			 
			$select      = "SELECT fuente_servicio_cod  FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
			$result      = $this -> DbFetchAll($select,$Conex,true);
		 	$fuente_ser  = $result[0]['fuente_servicio_cod'];

			if($fuente_ser=='OC'){
				
				 $this -> Begin($Conex);
				 //buscamos si tiene anticipos:
				$select_anticipos = "SELECT anticipos_cruzar FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";	
				
				$result_anticipo      = $this -> DbFetchAll($select_anticipos,$Conex,true);
				
				$anticipos_cruzar = $result_anticipo[0]['anticipos_cruzar'];
				
				$select_ordenes = "SELECT GROUP_CONCAT(orden_compra_id) as ordenes_id, COUNT(*)as cantidad FROM detalle_factura_proveedor WHERE factura_proveedor_id = $factura_proveedor_id";
				$result_ordenes = $this -> DbFetchAll($select_ordenes,$Conex,true);
				
				$orden_compra_id = $result_ordenes[0]['ordenes_id'];
				$cantidad        = $result_ordenes[0]['cantidad'];
				
				
				//si no tiene los adicionamos a la consulta para que realice el proceso normalmente
				if($anticipos_cruzar!='' || $cantidad > 1){$contra="AND contra_liquida_orden =0"; }else{$contra="";}
				
				
				
				
				
				
				
				$select_item      = "SELECT i.item_puc_liquida_id  FROM  item_puc_liquida_orden i WHERE i.orden_compra_id IN($orden_compra_id) $contra";
				//exit($select_item);
				$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
				foreach($result_item as $result_items){
					
									
					$item_factura_proveedor_id 	= $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
					$insert = "INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,sucursal_id,area_id,departamento_id,unidad_negocio_id,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
							SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id, i.puc_id, 
							IF(pu.requiere_tercero=1,(SELECT tercero_id FROM proveedor  WHERE proveedor_id=f.proveedor_id),NULL) AS tercero,
							IF(pu.requiere_tercero=1,(SELECT t.numero_identificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS numero_identificacion,
							IF(pu.requiere_tercero=1,(SELECT t.digito_verificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS digito_verificacion,
							IF(pu.requiere_centro_costo=1,(SELECT centro_de_costo_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS centro_de_costo,
							IF(pu.requiere_centro_costo=1,(SELECT c.codigo 	FROM orden_compra o, centro_de_costo c WHERE o.orden_compra_id=i.orden_compra_id AND c.centro_de_costo_id=o.centro_de_costo_id),NULL) AS codigo_centro_costo,
							
							IF(pu.requiere_sucursal=1,(SELECT oficina_id FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS sucursal_id,
							IF(pu.area=1,(SELECT area_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS area_id,
							
							IF(pu.departamento=1,(SELECT departamento_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS departamento_id,
							IF(pu.unidadnegocio=1,(SELECT unidad_negocio_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS unidad_negocio_id,
							
							
							i.base_item_puc_liquida, i.porcentaje_item_puc_liquida, i.formula_item_puc_liquida, i.desc_item_puc_liquida, i.deb_item_puc_liquida, i.cre_item_puc_liquida,i.contra_liquida_orden
							FROM item_puc_liquida_orden i,  factura_proveedor f, puc pu  
							WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id IN($orden_compra_id) AND i.item_puc_liquida_id=$result_items[item_puc_liquida_id] AND pu.puc_id=i.puc_id"; 
							
							$this -> query($insert,$Conex,true);
					
					
					}
					
					
				//si tiene anticipos insertamos sus valores y sus cuentas
				
				if($anticipos_cruzar!='' || $cantidad > 1){
					
				 
				 $total_anticipos = 0;
				 
				 if($anticipos_cruzar!=''){
					// exit($anticipos_cruzar."***********1111");
					$anticipos_id = explode(',',$anticipos_cruzar);
					
					foreach($anticipos_id as $anticipo){
						
						$anticipo = substr($anticipo,1);
						if($anticipo>0){
						   
							$select ="SELECT ap.valor,ap.consecutivo, (SELECT puc_id FROM parametros_anticipo_proveedor WHERE parametros_anticipo_proveedor_id = ap.parametros_anticipo_proveedor_id) as puc_id, (SELECT naturaleza FROM parametros_anticipo_proveedor WHERE parametros_anticipo_proveedor_id = ap.parametros_anticipo_proveedor_id) as naturaleza FROM anticipos_proveedor ap WHERE ap.anticipos_proveedor_id = $anticipo";
							//echo $select.'<hr>';
							$result = $this -> DbFetchAll($select,$Conex,true);
							
							$puc_id = $result[0]['puc_id'];
							$valor = $result[0]['valor'];
							$naturaleza = $result[0]['naturaleza'];
							$consecutivo = $result[0]['consecutivo'];
							
							$total_anticipos +=$valor;
							
							$item_factura_proveedor_id 	= $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
							$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,sucursal_id,area_id,departamento_id,unidad_negocio_id,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor) 
									SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id, $puc_id, 
									IF(pu.requiere_tercero=1,(SELECT tercero_id FROM proveedor  WHERE proveedor_id=f.proveedor_id),NULL) AS tercero,
									IF(pu.requiere_tercero=1,(SELECT t.numero_identificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS numero_identificacion,
									IF(pu.requiere_tercero=1,(SELECT t.digito_verificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS digito_verificacion,
									IF(pu.requiere_centro_costo=1,(SELECT centro_de_costo_id 	FROM orden_compra WHERE orden_compra_id=f.orden_compra_id),NULL) AS centro_de_costo,
									IF(pu.requiere_centro_costo=1,(SELECT c.codigo 	FROM orden_compra o, centro_de_costo c WHERE o.orden_compra_id=f.orden_compra_id AND c.centro_de_costo_id=o.centro_de_costo_id),NULL) AS codigo_centro_costo,
									
									IF(pu.requiere_sucursal=1,(SELECT sucursal_id FROM orden_compra WHERE orden_compra_id=f.orden_compra_id),NULL) AS sucursal_id,
									IF(pu.area=1,(SELECT area_id 	FROM orden_compra WHERE orden_compra_id=f.orden_compra_id),NULL) AS area_id,
									
									IF(pu.departamento=1,(SELECT departamento_id 	FROM orden_compra WHERE orden_compra_id=f.orden_compra_id),NULL) AS departamento_id,
									IF(pu.unidadnegocio=1,(SELECT unidad_negocio_id 	FROM orden_compra WHERE orden_compra_id=f.orden_compra_id),NULL) AS unidad_negocio_id,
									
									
									0, 0, 0, 'ANTICIPO No $consecutivo', IF('$naturaleza'='C',$valor,0), IF('$naturaleza'='D',$valor,0),0
									FROM   factura_proveedor f, puc pu  
									WHERE f.factura_proveedor_id=$factura_proveedor_id AND pu.puc_id=$puc_id"; 
									//exit($insert);
							$this -> query($insert,$Conex,true);
						}
					}
				  }
					
					
					$item_factura_proveedor_id 	= $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
					$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,sucursal_id,area_id,departamento_id,unidad_negocio_id,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
							SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id, i.puc_id, 
							
							IF(pu.requiere_tercero=1,(SELECT tercero_id FROM proveedor  WHERE proveedor_id=f.proveedor_id),NULL) AS tercero,
							IF(pu.requiere_tercero=1,(SELECT t.numero_identificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS numero_identificacion,
							IF(pu.requiere_tercero=1,(SELECT t.digito_verificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS digito_verificacion,
							IF(pu.requiere_centro_costo=1,(SELECT centro_de_costo_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS centro_de_costo,
							IF(pu.requiere_centro_costo=1,(SELECT c.codigo 	FROM orden_compra o, centro_de_costo c WHERE o.orden_compra_id=i.orden_compra_id AND c.centro_de_costo_id=o.centro_de_costo_id),NULL) AS codigo_centro_costo,
							
							IF(pu.requiere_sucursal=1,(SELECT sucursal_id FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS sucursal_id,
							IF(pu.area=1,(SELECT area_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS area_id,
							
							IF(pu.departamento=1,(SELECT departamento_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS departamento_id,
							IF(pu.unidadnegocio=1,(SELECT unidad_negocio_id 	FROM orden_compra WHERE orden_compra_id=i.orden_compra_id),NULL) AS unidad_negocio_id,
							
							
							i.base_item_puc_liquida, i.porcentaje_item_puc_liquida, i.formula_item_puc_liquida, f.concepto_factura_proveedor, IF(SUM(i.deb_item_puc_liquida)>0,(SUM(i.deb_item_puc_liquida)-$total_anticipos),0), IF(SUM(i.cre_item_puc_liquida)>0,(SUM(i.cre_item_puc_liquida)-$total_anticipos),0),i.contra_liquida_orden
							FROM item_puc_liquida_orden i,  factura_proveedor f, puc pu  
							WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id IN($orden_compra_id) AND contra_liquida_orden = 1 AND pu.puc_id=i.puc_id"; 
							//exit($insert);
					$this -> query($insert,$Conex,true);
					
					
				}
				
				//exit("por si acaso");
				$this -> Commit($Conex);
				
			}elseif($fuente_ser=='MC' || $fuente_ser=='DU'){
				
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
			}elseif($fuente_ser=='NN'){
				
			  $total_pagar=0;
			  $parcial='';
			  $contra=0;
			  $impuesto=0;
			  $subtotal=0;

			  $selectm      = "SELECT t.valor_manual, t.puc_manual  FROM factura_proveedor f, tipo_bien_servicio t 
			  					WHERE f.factura_proveedor_id=$factura_proveedor_id AND t.tipo_bien_servicio_id=f.tipo_bien_servicio_id";
			  $resultm      = $this -> DbFetchAll($selectm,$Conex,true);
			  $valor_manual = $resultm[0]['valor_manual'];
			  $puc_manual 	= $resultm[0]['puc_manual'];


			  $select_item  = "SELECT  c.despuc_bien_servicio,
						  c.natu_bien_servicio,
						  c.contra_bien_servicio,
						  c.puc_id,
						  c.codpuc_bien_servicio_id,
						  IF(pu.requiere_tercero=1,(SELECT tercero_id FROM proveedor  WHERE proveedor_id=f.proveedor_id),NULL) AS tercero,
						  IF(pu.requiere_centro_costo=1,(SELECT centro_de_costo_id 	 FROM centro_de_costo WHERE oficina_id =$oficina_id AND empresa_id=$empresa_id),NULL) AS centro_costo,			
							(SELECT autoret_proveedor FROM proveedor WHERE proveedor_id=f.proveedor_id ) AS autorete,				
							(SELECT retei_proveedor FROM proveedor WHERE proveedor_id=f.proveedor_id ) AS retei,								
							(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
							(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
							WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
							AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,					  
							(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
							WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
							AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,					  
							(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
							WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
							AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,					  
						  f.valor_factura_proveedor AS total
						 FROM codpuc_bien_servicio  c, factura_proveedor f, puc pu 
						 WHERE f.factura_proveedor_id = $factura_proveedor_id AND c.tipo_bien_servicio_id=f.tipo_bien_servicio_id AND pu.puc_id=c.puc_id 
						 ORDER BY c.contra_bien_servicio ASC, c.codpuc_bien_servicio_id ASC";
//echo $select_item;
				$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
				foreach($result_item as $resultado){

					 $ingresa=0;
					 if(($resultado[porcentaje]=='' || $resultado[porcentaje]==NULL) && $resultado[contra_bien_servicio]!=1){
						 
							 $parcial	= $resultado[total];
							 $subtotal++;
							 $base		= 'NULL';
							 $formula	= 'NULL';
							 $porcentaje= 'NULL';
							 $ingresa=1;
					
					 }elseif($resultado[porcentaje]>0 && $resultado[contra_bien_servicio]!=1 &&  $resultado[monto]<=$resultado[total] && (($resultado[exento]=='RT' && $resultado[autorete]=='N' ) || ($resultado[exento]=='IC' && $resultado[retei]=='N') || ($resultado[exento]=='RIC' && $resultado[retei]=='N') || ($resultado[exento]=='IV') || ($resultado[exento]=='NN') )){
						 
							 $base		= $resultado[total];
							 $formula	= $resultado[formula];
							 $porcentaje= $resultado[porcentaje];
							 $calculo 	= str_replace("BASE",$base,$formula);
							 $calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
							 $select1   = "SELECT $calculo AS valor_total";
							 $result1   = $this -> DbFetchAll($select1 ,$Conex,true);
							 $parcial 	= $result1[0]['valor_total'];
							 $impuesto++;
							 $ingresa=1;
							
							
					 }elseif($resultado[contra_bien_servicio]==1){
							$parcial	= $total_pagar;
							$contra++;
							 $base		= 'NULL';
							 $formula	= 'NULL';
							 $porcentaje= 'NULL';
							 $ingresa=1;

					 }
					 
					 if($ingresa==1){
						 
						 if($resultado[natu_bien_servicio]=='D' && $resultado[contra_bien_servicio]!=1){
							 $total_pagar	= $total_pagar+$parcial;
						 }elseif($resultado[natu_bien_servicio]=='C' && $resultado[contra_bien_servicio]!=1){
							 $total_pagar	= $total_pagar-$parcial;
						 }
						 
						 if($resultado[natu_bien_servicio]=='D'){
							$debito_insert= $parcial;
							$credito_insert='0';
						 }elseif($resultado[natu_bien_servicio]=='C'){
							$debito_insert= '0';
							$credito_insert=$parcial;
							 
						 }
						 
						 $parcial		= number_format($parcial,2,'.','');
						 $descripcion	= $resultado[despuc_bien_servicio];
	
						
						$item_factura_proveedor_id 	= $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
					
						$resultado[tercero] = $resultado[tercero] == '' ? 'NULL' : $resultado[tercero];
						if($valor_manual==0 && $puc_manual==0){
							
							$centro_costo_ingresa = $resultado[centro_costo] != 'NULL' ? $resultado[centro_costo] :'NULL';
							
							$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,centro_de_costo_id,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
									SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id,c.puc_id,$resultado[tercero],$centro_costo_ingresa,'$base','$porcentaje','$formula',
									(SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS desc_factura_proveedor,'$debito_insert','$credito_insert',c.contra_bien_servicio
									FROM codpuc_bien_servicio c,  factura_proveedor f  
									WHERE f.factura_proveedor_id=$factura_proveedor_id AND c.tipo_bien_servicio_id=f.tipo_bien_servicio_id AND c.codpuc_bien_servicio_id=$resultado[codpuc_bien_servicio_id]"; 
									
							$this -> DbFetchAll($insert,$Conex,true);
						}elseif($puc_manual==0){
							$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,centro_de_costo_id,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
									SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id,c.puc_id,$resultado[tercero],$resultado[centro_costo],NULL,'$porcentaje','$formula',
									(SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS desc_factura_proveedor,'0.00','0.00',c.contra_bien_servicio
									FROM codpuc_bien_servicio c,  factura_proveedor f  
									WHERE f.factura_proveedor_id=$factura_proveedor_id AND c.tipo_bien_servicio_id=f.tipo_bien_servicio_id AND c.codpuc_bien_servicio_id=$resultado[codpuc_bien_servicio_id]"; 
							$this -> DbFetchAll($insert,$Conex,true);
						}
					 }

				}
			}
		 }

	
	  $select  = "SELECT i.*, (SELECT estado_factura_proveedor FROM factura_proveedor WHERE factura_proveedor_id=i.factura_proveedor_id ) AS estado,
	  (SELECT concat(codigo_puc)  FROM puc WHERE puc_id = i.puc_id) AS codigo_puc,
	  (SELECT concat(codigo_puc,' - ',nombre)  FROM puc WHERE puc_id = i.puc_id) AS puc,
	  (SELECT numero_identificacion FROM tercero WHERE tercero_id = i.tercero_id) AS numero_identificacion,
	  (SELECT CONCAT_WS(' ',numero_identificacion,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social,sigla) FROM tercero WHERE tercero_id = i.tercero_id) AS tercero,
	  (SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,
	  (SELECT requiere_tercero FROM puc WHERE puc_id = i.puc_id) AS requiere_tercero,	  
  	  (SELECT requiere_centro_costo FROM puc WHERE puc_id = i.puc_id) AS requiere_centro_costo,	
  	  (SELECT COUNT(*) AS requiere_base_ofi FROM impuesto_oficina io, impuesto im WHERE im.puc_id = i.puc_id AND im.empresa_id=$empresa_id AND io.impuesto_id=im.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id) AS requiere_base_ofi,
  	  (SELECT COUNT(*) AS requiere_base_emp FROM impuesto WHERE puc_id = i.puc_id AND empresa_id=$empresa_id AND estado='A') AS requiere_base_emp,	  
	 (SELECT  codigo  FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS codigo,(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo,(SELECT codigo FROM area WHERE area_id = i.area_id)as codigo_area, (SELECT codigo FROM departamento WHERE departamento_id = i.departamento_id)as codigo_dep,(SELECT codigo FROM unidad_negocio WHERE unidad_negocio_id = i.unidad_negocio_id)as nombre_unidad,(SELECT codigo_centro FROM oficina WHERE oficina_id=i.sucursal_id ) as sucursal
	  FROM item_factura_proveedor i WHERE i.factura_proveedor_id = $factura_proveedor_id ORDER BY i.contra_factura_proveedor,i.item_factura_proveedor_id ASC";

	  $result = $this -> DbFetchAll($select,$Conex,true);
	  
	}else{
   	    $result = array();
	 }
	
	return $result;
  
  }
  
    
  public function Save($usuario_id,$empresa_id,$oficina_id,$Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $item_factura_proveedor_id = $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
      $factura_proveedor_id      = $this -> requestDataForQuery('factura_proveedor_id','integer');
	  $puc_id             	 	 = $this -> requestDataForQuery('puc_id','integer');
	  $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
   	  $centro_de_costo     	 	 = $this -> requestDataForQuery('centro_de_costo','text');
      $desc_factura_proveedor    = $this -> requestDataForQuery('desc_factura_proveedor','text');	  
      $base_factura_proveedor    = $this -> requestDataForQuery('base_factura_proveedor','integer');
      $deb_item_factura_proveedor= $this -> requestDataForQuery('deb_item_factura_proveedor','numeric');
      $cre_item_factura_proveedor= $this -> requestDataForQuery('cre_item_factura_proveedor','numeric');
	  $contra_factura_proveedor	 = $this -> requestDataForQuery('contra_factura_proveedor','integer');
	  
	  $sucursal_id            = $this -> requestDataForQuery('sucursal_id','text');	  
	  $area_id                = $this -> requestDataForQuery('area_id','text');	  
	  $departamento_id        = $this -> requestDataForQuery('departamento_id','text');	  
	  $unidad_negocio_id       = $this -> requestDataForQuery('unidad_negocio_id','text');	
	  
	 if($_REQUEST['contra_factura_proveedor']==1){

	 	$update = "UPDATE item_factura_proveedor SET 
					contra_factura_proveedor=0
					WHERE  factura_proveedor_id = $factura_proveedor_id";
      	$this -> query($update,$Conex,true); 
	 }
	 
      $insert = "INSERT INTO item_factura_proveedor 
	            (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor,sucursal_id,area_id,departamento_id,unidad_negocio_id)  
	            VALUES  
				($item_factura_proveedor_id,$factura_proveedor_id,$puc_id,$tercero_id,IF($tercero_id>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),IF($tercero_id>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),$centro_de_costo_id,$centro_de_costo,$base_factura_proveedor,
				(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ),					  
				(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ),
				$desc_factura_proveedor,$deb_item_factura_proveedor,$cre_item_factura_proveedor,$contra_factura_proveedor,$sucursal_id,$area_id,$departamento_id,$unidad_negocio_id)";
				//echo $insert;
      $this -> query($insert,$Conex,true); 

	 $select   = "SELECT encabezado_registro_id FROM factura_proveedor WHERE factura_proveedor_id = $factura_proveedor_id "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);
	 $encabezado_registro_id	= $result[0]['encabezado_registro_id'];

	 if($encabezado_registro_id>0){

 		 $delete = "DELETE FROM imputacion_contable WHERE encabezado_registro_id = (SELECT encabezado_registro_id FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id)";
		 $this -> query($delete,$Conex,true);	

		 $select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
		 $result_item      = $this -> DbFetchAll($select_item,$Conex,true);
		 foreach($result_item as $result_items){
			 $imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			 $insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito,sucursal_id,area_id,departamento_id,unidad_negocio_id) 
									SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
									formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,sucursal_id,area_id,departamento_id,unidad_negocio_id
									FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 
			 $this -> query($insert_item,$Conex,true);
	 	}
	 }
		 
	$this -> Commit($Conex);
	
	return $item_factura_proveedor_id;

  }

  public function Updates($empresa_id,$oficina_id,$Campos,$Conex){

  	$this -> Begin($Conex);

	  $factura_proveedor_id 		= $this -> requestData('factura_proveedor_id');
      $item_factura_proveedor_id = $this -> requestDataForQuery('item_factura_proveedor_id','integer');
	  $puc_id             	 	 = $this -> requestDataForQuery('puc_id','integer');
	  $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
   	  $centro_de_costo     	 	 = $this -> requestDataForQuery('centro_de_costo','text');
      $desc_factura_proveedor    = $this -> requestDataForQuery('desc_factura_proveedor','text');	  
      $base_factura_proveedor    = $this -> requestDataForQuery('base_factura_proveedor','numeric');
      $deb_item_factura_proveedor= $this -> requestDataForQuery('deb_item_factura_proveedor','numeric');
      $cre_item_factura_proveedor= $this -> requestDataForQuery('cre_item_factura_proveedor','numeric');
	  $contra_factura_proveedor	 = $this -> requestDataForQuery('contra_factura_proveedor','integer');	  
	  
	   $sucursal_id            = $this -> requestDataForQuery('sucursal_id','text');	  
	  $area_id                = $this -> requestDataForQuery('area_id','text');	  
	  $departamento_id        = $this -> requestDataForQuery('departamento_id','text');	  
	  $unidad_negocio_id       = $this -> requestDataForQuery('unidad_negocio_id','text');

	 if($_REQUEST['contra_factura_proveedor']==1){

	 	$update = "UPDATE item_factura_proveedor SET 
					contra_factura_proveedor=0
					WHERE  factura_proveedor_id = $factura_proveedor_id";
      	$this -> query($update,$Conex,true); 
	 }

      $update = "UPDATE item_factura_proveedor SET 
	  				tercero_id=$tercero_id,
					numero_identificacion=IF($tercero_id>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),
					digito_verificacion=IF($tercero_id>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),
					puc_id=$puc_id,
					centro_de_costo_id=$centro_de_costo_id,
					codigo_centro_costo=$centro_de_costo,
					desc_factura_proveedor=$desc_factura_proveedor,
					base_factura_proveedor=$base_factura_proveedor,
					porcentaje_factura_proveedor=(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
						WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
						AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ),					  
					formula_factura_proveedor=(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
						WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
						AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ),					  					
					deb_item_factura_proveedor = $deb_item_factura_proveedor,
					cre_item_factura_proveedor = $cre_item_factura_proveedor,
					contra_factura_proveedor=$contra_factura_proveedor,sucursal_id=$sucursal_id,area_id=$area_id,departamento_id=$departamento_id,unidad_negocio_id=$unidad_negocio_id
					
					WHERE  item_factura_proveedor_id = $item_factura_proveedor_id";
	
      $this -> query($update,$Conex,true);

	 $select   = "SELECT encabezado_registro_id FROM factura_proveedor WHERE factura_proveedor_id = $factura_proveedor_id "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);
	 $encabezado_registro_id	= $result[0]['encabezado_registro_id'];

	 if($encabezado_registro_id>0){
		 
		$delete = "DELETE FROM imputacion_contable WHERE encabezado_registro_id = (SELECT encabezado_registro_id FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id)";
		$this -> query($delete,$Conex,true);	
		 
	 	$select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
	 	$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
	 	foreach($result_item as $result_items){
		 	$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
		 	$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito,sucursal_id,area_id,departamento_id,unidad_negocio_id)
								SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
								formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,sucursal_id,area_id,departamento_id,unidad_negocio_id
								FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 
		 $this -> query($insert_item,$Conex,true);
	 	}
	 }
	 $this -> Commit($Conex);
	
	return $item_factura_proveedor_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);
	
	  $factura_proveedor_id 		= $this -> requestData('factura_proveedor_id');
      $item_factura_proveedor_id = $this -> requestDataForQuery('item_factura_proveedor_id','integer');
  	  $puc_id             	 	 = $this -> requestDataForQuery('puc_id','integer');
      $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_factura_proveedor    = $this -> requestDataForQuery('desc_factura_proveedor','text');	  
      //$base_factura_proveedor    = $this -> requestDataForQuery('base_factura_proveedor','integer');
      $deb_item_factura_proveedor= $this -> requestDataForQuery('deb_item_factura_proveedor','numeric');
      $cre_item_factura_proveedor= $this -> requestDataForQuery('cre_item_factura_proveedor','numeric');
	  $contra_factura_proveedor	 = $this -> requestDataForQuery('contra_factura_proveedor','integer');
	  
	  $sucursal_id            = $this -> requestDataForQuery('sucursal_id','text');	  
	  $area_id                = $this -> requestDataForQuery('area_id','text');	  
	  $departamento_id        = $this -> requestDataForQuery('departamento_id','text');	  
	  $unidad_negocio_id       = $this -> requestDataForQuery('unidad_negocio_id','text');
		
		//exit($contra_factura_proveedor."contrapar");
		
	 if($contra_factura_proveedor==1){

	 	$update = "UPDATE item_factura_proveedor SET 
					contra_factura_proveedor=0
					WHERE  factura_proveedor_id = $factura_proveedor_id";
      	$this -> query($update,$Conex,true); 
		
		$update_contra = "contra_factura_proveedor=$contra_factura_proveedor,";
	 }

      $update = "UPDATE item_factura_proveedor SET 
	  				tercero_id=$tercero_id,
					puc_id=$puc_id,
					centro_de_costo_id=$centro_de_costo_id,
					desc_factura_proveedor=$desc_factura_proveedor,
					deb_item_factura_proveedor = $deb_item_factura_proveedor,
					cre_item_factura_proveedor = $cre_item_factura_proveedor, 
					$update_contra
					sucursal_id=$sucursal_id,area_id=$area_id,departamento_id=$departamento_id,unidad_negocio_id=$unidad_negocio_id
					WHERE  item_factura_proveedor_id = $item_factura_proveedor_id";
			  //echo $update;	
      $this -> query($update,$Conex,true);


	 $select   = "SELECT encabezado_registro_id FROM factura_proveedor  WHERE factura_proveedor_id = $factura_proveedor_id "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);
	 $encabezado_registro_id	= $result[0]['encabezado_registro_id'];
	 
	 if($encabezado_registro_id>0){
		 
 		 $delete = "DELETE FROM imputacion_contable WHERE encabezado_registro_id = (SELECT encabezado_registro_id FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id)";
		 $this -> query($delete,$Conex,true);	

		 $select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
		 $result_item      = $this -> DbFetchAll($select_item,$Conex,true);
		 foreach($result_item as $result_items){
			 $imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			 $insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito,sucursal_id,area_id,departamento_id,unidad_negocio_id)
									SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
									formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,sucursal_id,area_id,departamento_id,unidad_negocio_id
									FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 
			 $this -> query($insert_item,$Conex,true);
	 	}
	 }
	
	$this -> Commit($Conex);
	
	return $item_factura_proveedor_id;

  }

  public function Delete($Campos,$Conex){

    $item_factura_proveedor_id  = $this -> requestData('item_factura_proveedor_id');
	$factura_proveedor_id 		= $this -> requestData('factura_proveedor_id');

    $this -> Begin($Conex);

	 $select   = "SELECT encabezado_registro_id FROM factura_proveedor  
	 			WHERE factura_proveedor_id = $factura_proveedor_id "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);
	 $encabezado_registro_id	= $result[0]['encabezado_registro_id'];
	 
     $delete = "DELETE FROM item_factura_proveedor WHERE item_factura_proveedor_id = $item_factura_proveedor_id ";
     $this -> query($delete,$Conex,true);	
	 
	 if($encabezado_registro_id>0){
		 $delete = "DELETE FROM imputacion_contable WHERE encabezado_registro_id = (SELECT encabezado_registro_id FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id)";
		 $this -> query($delete,$Conex,true);	
		 
		 $select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
		 $result_item      = $this -> DbFetchAll($select_item,$Conex,true);
		 	foreach($result_item as $result_items){
				$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
				$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito,sucursal_id,area_id,departamento_id,unidad_negocio_id)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
							formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,sucursal_id,area_id,departamento_id,unidad_negocio_id
							FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 
				$this -> query($insert_item,$Conex,true);
		}
		
	 }
	$this -> Commit($Conex);

  }


  public function getTipo($factura_proveedor_id,$Conex){
	 $select   = "SELECT t.puc_manual FROM factura_proveedor f, tipo_bien_servicio t  
	 			WHERE f.factura_proveedor_id = $factura_proveedor_id AND t.tipo_bien_servicio_id=f.tipo_bien_servicio_id "; 
	 $result = $this -> DbFetchAll($select,$Conex,true);
	 $tipo=$result[0][puc_manual];
	 return $tipo;


  }
  
  
  public function selectCuentaPuc($puc_id,$factura_proveedor_id,$Conex){
	  
	 $select   = "SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio,contrapartida FROM puc WHERE puc_id = $puc_id"; 
	 $requires = $this -> DbFetchAll($select,$Conex,true);
	 
	 $select = "SELECT * FROM impuesto_oficina WHERE empresa_id = (SELECT o.empresa_id FROM factura_proveedor f, oficina o WHERE 
																   f.factura_proveedor_id = $factura_proveedor_id AND o.oficina_id=f.oficina_id)
	            AND oficina_id = (SELECT oficina_id FROM factura_proveedor WHERE 
																   factura_proveedor_id = $factura_proveedor_id)
				AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)";
			
      $impuesto = $this -> DbFetchAll($select,$Conex,true);				
	  
	  if(!count($impuesto) > 0){
		  
	    $select   = "SELECT * FROM impuesto WHERE puc_id = $puc_id";				
        $impuesto = $this -> DbFetchAll($select,$Conex,true);						  
		  
      }
	  
	  $requiere_centro_costo = $requires[0]['requiere_centro_costo'] == 1 ? 'true' : 'false';
	  $requiere_tercero      = $requires[0]['requiere_tercero']      == 1 ? 'true' : 'false';
	  $requiere_sucursal     = $requires[0]['requiere_sucursal']      == 1 ? 'true' : 'false';
	$requiere_area           = $requires[0]['area']      == 1 ? 'true' : 'false';
	$requiere_departamento   = $requires[0]['departamento']      == 1 ? 'true' : 'false';
	$requiere_unidad         = $requires[0]['unidadnegocio']      == 1 ? 'true' : 'false';
	$contrapartida           = $requires[0]['contrapartida']      == 1 ? 'true' : 'false';
	  //$require_base          = count($impuesto) > 0   ? 'true' : 'false';
	  $requiere_base          = $impuesto[0]['impuesto_id']      > 0 ? 'true' : 'false';
	 //exit(count($impuesto)." ---- ");	
	  $requieresCuenta=array(requiere_centro_costo=>$requiere_centro_costo,requiere_tercero=>$requiere_tercero,
							 requiere_base=>$requiere_base,requiere_area=>$requiere_area,requiere_departamento=>$requiere_departamento,requiere_unidad=>$requiere_unidad,requiere_sucursal=>$requiere_sucursal,contrapartida=>$contrapartida);
	  
	  return $requieresCuenta;	 
      
	  
  }
  
  public function selectImpuesto($puc_id,$base_factura_proveedor,$factura_proveedor_id,$empresa_id,$oficina_id,$Conex){
	
	
	  $select = "SELECT ip.naturaleza,imp.* FROM  impuesto ip, impuesto_periodo_contable imp 
	  WHERE imp.periodo_contable_id = (SELECT p.periodo_contable_id  FROM factura_proveedor f, periodo_contable p, oficina of WHERE f.factura_proveedor_id = $factura_proveedor_id AND of.oficina_id=f.oficina_id AND p.anio=YEAR(f.fecha_factura_proveedor) AND p.empresa_id=of.empresa_id )
	  AND imp.impuesto_id = (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id) AND imp.impuesto_id = ip.impuesto_id";
	 
	 $select="SELECT i.*,
	  			(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
					WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,
				
					(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
					WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
					AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula	
	  
	  FROM impuesto i WHERE i.empresa_id =$empresa_id AND puc_id=$puc_id ";
	 // exit($select);
	 
      $impuesto = $this -> DbFetchAll($select,$Conex,true);				
	  		  
	  $porcentaje    = $impuesto[0]['porcentaje'];
	  $impuesto_id   = $impuesto[0]['impuesto_id'];
	  $naturaleza    = $impuesto[0]['naturaleza'];
	  $formula       = $impuesto[0]['formula'];
		  
      $calculo = str_replace("BASE",$base_factura_proveedor,$formula);
	  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
		  
	  $select     = "SELECT $calculo AS valor_total";
      $result     = $this -> DbFetchAll($select ,$Conex,true);
	  $valorTotal = $result[0]['valor_total'];
		  
      return array(valor => $valorTotal, naturaleza =>$naturaleza);	  
		  	
	  
  }

   
}



?>