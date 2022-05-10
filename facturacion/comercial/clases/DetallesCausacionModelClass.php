<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesModel extends Db{

  private $Permisos;
  
  public function getImputacionesContables($factura_proveedor_id,$empresa_id,$oficina_id,$Conex){
	   	
	if(is_numeric($factura_proveedor_id)){

		 $select      = "SELECT COUNT(*) AS movimientos FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
		 $result      = $this -> DbFetchAll($select,$Conex);

		 $movimientos = $result[0]['movimientos'];
	 
	 	 if($movimientos ==0){
			 
			$select      = "SELECT fuente_servicio_cod  FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
			$result      = $this -> DbFetchAll($select,$Conex);
		 	$fuente_ser  = $result[0]['fuente_servicio_cod'];

			if($fuente_servicio_cod=="'CO'"){

		 
		  $comisiones_id 	= $this -> requestDataForQuery('comisiones_id','integer');
		  

		  $select="SELECT (SELECT proveedor_id FROM  proveedor WHERE c.comercial_id=co.comercial_id AND co.tercero_id=tr.tercero_id AND tercero_id = tr.tercero_id ) AS proveedor_id
		  FROM tercero tr, comisiones c,comercial co 
		  WHERE c.comisiones_id = $comisiones_id AND co.tercero_id=tr.tercero_id AND c.comercial_id=co.comercial_id";
		  
		
	      $result = $this -> DbFetchAll($select,$Conex,false);
		  
		  if($result[0]['proveedor_id']!=0 && $result[0]['proveedor_id']!='' && $result[0]['proveedor_id']!=NULL){
		  		$proveedor_id=$result[0]['proveedor_id'];
				  $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,comisiones_id,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor) 
								VALUES ($factura_proveedor_id,$comisiones_id,$valor,$fecha_factura_proveedor,$vence_factura_proveedor,$concepto_factura_proveedor,$proveedor_id,$fuente_servicio_cod,'A',$usuario_id,$oficina_id,$ingreso_factura_proveedor)"; 
								
			$this -> query($insert,$Conex);
			
	  	  }
	  
		  
	  $select_item      = "SELECT d.detalle_comision_puc_id  FROM   detalle_comisiones_puc d 
							 WHERE d.comision_id=$comisiones_id";
	  $result_item      = $this -> DbFetchAll($select_item,$Conex);
		
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
							d.base_comision,
							d.porcentaje_comision,					  
							d.formula_comision,					  
							d.desc_comision AS desc_factura_proveedor,
							d.deb_item_comision,
							d.cre_item_comision,
							d.contra_comision
					FROM factura_proveedor f,   detalle_comisiones_puc d, puc pu
					WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.comision_id=f.comisiones_id AND d.detalle_comision_puc_id=$result_items[detalle_comision_puc_id] AND pu.puc_id=d.puc_id"; 
					
					
			$this -> query($insert,$Conex);
			$this -> Commit($Conex);	
	  }
		  
	  }elseif($fuente_ser=='OC'){

				$select_item      = "SELECT i.item_puc_liquida_id  FROM  item_puc_liquida_orden i,  factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id=f.orden_compra_id";
				$result_item      = $this -> DbFetchAll($select_item,$Conex);
				foreach($result_item as $result_items){
					
					$item_factura_proveedor_id 	= $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
					$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
							SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id, i.puc_id, 
							IF(pu.requiere_tercero=1,(SELECT tercero_id FROM proveedor  WHERE proveedor_id=f.proveedor_id),NULL) AS tercero,
							IF(pu.requiere_tercero=1,(SELECT t.numero_identificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS numero_identificacion,
							IF(pu.requiere_tercero=1,(SELECT t.digito_verificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS digito_verificacion,
							IF(pu.requiere_centro_costo=1,(SELECT centro_de_costo_id 	FROM orden_compra WHERE orden_compra_id=f.orden_compra_id),NULL) AS centro_de_costo,
							IF(pu.requiere_centro_costo=1,(SELECT c.codigo 	FROM orden_compra o, centro_de_costo c WHERE o.orden_compra_id=f.orden_compra_id AND c.centro_de_costo_id=o.centro_de_costo_id),NULL) AS codigo_centro_costo,							
							i.base_item_puc_liquida, i.porcentaje_item_puc_liquida, i.formula_item_puc_liquida, i.desc_item_puc_liquida, i.deb_item_puc_liquida, i.cre_item_puc_liquida,i.contra_liquida_orden
							FROM item_puc_liquida_orden i,  factura_proveedor f, puc pu  
							WHERE f.factura_proveedor_id=$factura_proveedor_id AND i.orden_compra_id=f.orden_compra_id AND i.item_puc_liquida_id=$result_items[item_puc_liquida_id] AND pu.puc_id=i.puc_id"; 
					$this -> query($insert,$Conex);
				}
			}elseif($fuente_ser=='CO'){
				
				$select_item      = "SELECT d.detalle_comision_puc_id  FROM  factura_proveedor f,   detalle_comisiones_puc d 
									 WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.comision_id=f.comisiones_id";
				$result_item      = $this -> DbFetchAll($select_item,$Conex);
				
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
									d.base_comision,
								 	d.porcentaje_comision,					  
									d.formula_comision,					  
									d.desc_comision, AS desc_factura_proveedor,
									d.deb_item_comision,,
									d.cre_item_comision,,
									d.contr_comision,
							FROM factura_proveedor f,   detalle_comisiones_puc d, puc pu
							WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.comision_id=f.comisiones_id AND d.detalle_comision_puc_id=$result_items[detalle_comision_puc_id] AND pu.puc_id=d.puc_id"; 

					$this -> query($insert,$Conex);
				}

			}elseif($fuente_ser=='RE'){
				
				$select_item      = "SELECT d.item_puc_liquida_re_id  FROM  factura_proveedor f,  item_puc_liquida_reexpedido d 
									 WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.liquidacion_reexpedido_id=f.liquidacion_reexpedido_id AND (d.deb_item_puc_liquida_re>0 OR d.cre_item_puc_liquida>0)";
				$result_item      = $this -> DbFetchAll($select_item,$Conex);
				
				foreach($result_item as $result_items){
					
					$item_factura_proveedor_id 	= $this -> DbgetMaxConsecutive("item_factura_proveedor","item_factura_proveedor_id",$Conex,true,1);
					$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
							SELECT 	$item_factura_proveedor_id,
									f.factura_proveedor_id,
									d.puc_id,

									IF(pu.requiere_tercero=1,(SELECT tercero_id FROM proveedor  WHERE proveedor_id=f.proveedor_id),NULL) AS tercero,
									IF(pu.requiere_tercero=1,(SELECT t.numero_identificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS numero_identificacion,
									IF(pu.requiere_tercero=1,(SELECT t.digito_verificacion FROM proveedor p, tercero t  WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id),NULL) AS digito_verificacion,
									IF(pu.requiere_centro_costo=1,(SELECT centro_de_costo_id 	FROM centro_de_costo WHERE oficina_id=f.oficina_id),NULL) AS centro_de_costo,
									IF(pu.requiere_centro_costo=1,(SELECT c.codigo 	FROM centro_de_costo c WHERE c.oficina_id=f.oficina_id),NULL) AS codigo_centro_costo,							
									d.base_item_puc_liquida_re,
								 	d.porcentaje_item_puc_liquida_re,					  
									d.formula_item_puc_liquida_re,					  
									d.desc_item_puc_liquida_re AS desc_factura_proveedor,
									d.deb_item_puc_liquida_re,
									d.cre_item_puc_liquida,
									d.contra_liquida_reexpedido
							FROM factura_proveedor f,   item_puc_liquida_reexpedido d, puc pu
							WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.liquidacion_reexpedido_id=f.liquidacion_reexpedido_id AND d.item_puc_liquida_re_id=$result_items[item_puc_liquida_re_id] AND pu.puc_id=d.puc_id"; 

					$this -> query($insert,$Conex);
				}

			}elseif($fuente_ser=='NN'){
				
			  $total_pagar=0;
			  $parcial='';
			  $contra=0;
			  $impuesto=0;
			  $subtotal=0;

			  $selectm      = "SELECT t.valor_manual, t.puc_manual  FROM factura_proveedor f, tipo_bien_servicio t 
			  					WHERE f.factura_proveedor_id=$factura_proveedor_id AND t.tipo_bien_servicio_id=f.tipo_bien_servicio_id";
			  $resultm      = $this -> DbFetchAll($selectm,$Conex);
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

				$result_item      = $this -> DbFetchAll($select_item,$Conex);
				foreach($result_item as $resultado){

					 $ingresa=0;
					 if(($resultado[porcentaje]=='' || $resultado[porcentaje]==NULL) && $resultado[contra_bien_servicio]!=1){
						 
							 $parcial	= $resultado[total];
							 $subtotal++;
							 $base		= 'NULL';
							 $formula	= 'NULL';
							 $porcentaje= 'NULL';
							 $ingresa=1;
					
					 }elseif($resultado[porcentaje]>0 && $resultado[contra_bien_servicio]!=1 &&  $resultado[monto]<=$resultado[total] && (($resultado[exento]=='RT' && $resultado[autorete]=='N' ) || ($resultado[exento]=='IC' && $resultado[retei]=='N') || ($resultado[exento]=='NN') )){
						 
							 $base		= $resultado[total];
							 $formula	= $resultado[formula];
							 $porcentaje= $resultado[porcentaje];
							 $calculo 	= str_replace("BASE",$base,$formula);
							 $calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
							 $select1   = "SELECT $calculo AS valor_total";
							 $result1   = $this -> DbFetchAll($select1 ,$Conex);
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
					
					
						if($valor_manual==0 && $puc_manual==0){
							$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,centro_de_costo_id,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
									SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id,c.puc_id,$resultado[tercero],$resultado[centro_costo],'$base','$porcentaje','$formula',
									(SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS desc_factura_proveedor,'$debito_insert','$credito_insert',c.contra_bien_servicio
									FROM codpuc_bien_servicio c,  factura_proveedor f  
									WHERE f.factura_proveedor_id=$factura_proveedor_id AND c.tipo_bien_servicio_id=f.tipo_bien_servicio_id AND c.codpuc_bien_servicio_id=$resultado[codpuc_bien_servicio_id]"; 
							$this -> query($insert,$Conex);
						}elseif($puc_manual==0){
							$insert="INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,centro_de_costo_id,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
									SELECT 	$item_factura_proveedor_id,f.factura_proveedor_id,c.puc_id,$resultado[tercero],$resultado[centro_costo],NULL,'$porcentaje','$formula',
									(SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id) AS desc_factura_proveedor,'0.00','0.00',c.contra_bien_servicio
									FROM codpuc_bien_servicio c,  factura_proveedor f  
									WHERE f.factura_proveedor_id=$factura_proveedor_id AND c.tipo_bien_servicio_id=f.tipo_bien_servicio_id AND c.codpuc_bien_servicio_id=$resultado[codpuc_bien_servicio_id]"; 
							$this -> query($insert,$Conex);
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
	  (SELECT CONCAT(codigo,' - ',nombre) FROM centro_de_costo WHERE centro_de_costo_id = i.centro_de_costo_id) AS centro_de_costo 
	  FROM item_factura_proveedor i WHERE i.factura_proveedor_id = $factura_proveedor_id";

	  $result = $this -> DbFetchAll($select,$Conex);
	  
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
      $base_factura_proveedor    = $this -> requestDataForQuery('base_factura_proveedor','numeric');
      $deb_item_factura_proveedor= $this -> requestDataForQuery('deb_item_factura_proveedor','numeric');
      $cre_item_factura_proveedor= $this -> requestDataForQuery('cre_item_factura_proveedor','numeric');
	  $contra_factura_proveedor	 = $this -> requestDataForQuery('contra_factura_proveedor','integer');
	  
	
      $insert = "INSERT INTO item_factura_proveedor 
	            (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor) 
	            VALUES  
				($item_factura_proveedor_id,$factura_proveedor_id,$puc_id,$tercero_id,IF($tercero_id>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),IF($tercero_id>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),$centro_de_costo_id,$centro_de_costo,$base_factura_proveedor,
				(SELECT  ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ),					  
				(SELECT  ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ),
				$desc_factura_proveedor,$deb_item_factura_proveedor,$cre_item_factura_proveedor,$contra_factura_proveedor)";
				// exit('TEST'.$insert); 
      $this -> query($insert,$Conex,true); 
	
	$this -> Commit($Conex);
	
	return $item_factura_proveedor_id;

  }

  public function Updates($empresa_id,$oficina_id,$Campos,$Conex){

  	$this -> Begin($Conex);

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
					contra_factura_proveedor=$contra_factura_proveedor
					WHERE  item_factura_proveedor_id = $item_factura_proveedor_id";
	
      $this -> query($update,$Conex,true); 
	
	$this -> Commit($Conex);
	
	return $item_factura_proveedor_id;

  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $item_factura_proveedor_id = $this -> requestDataForQuery('item_factura_proveedor_id','integer');
      $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_factura_proveedor    = $this -> requestDataForQuery('desc_factura_proveedor','text');	  
      //$base_factura_proveedor    = $this -> requestDataForQuery('base_factura_proveedor','integer');
      $deb_item_factura_proveedor= $this -> requestDataForQuery('deb_item_factura_proveedor','numeric');
      $cre_item_factura_proveedor= $this -> requestDataForQuery('cre_item_factura_proveedor','numeric');
	
      $update = "UPDATE item_factura_proveedor SET 
	  				tercero_id=$tercero_id,
					centro_de_costo_id=$centro_de_costo_id,
					desc_factura_proveedor=$desc_factura_proveedor,
					/*base_factura_proveedor=$base_factura_proveedor,*/
					deb_item_factura_proveedor = $deb_item_factura_proveedor,
					cre_item_factura_proveedor = $cre_item_factura_proveedor 
					WHERE  item_factura_proveedor_id = $item_factura_proveedor_id";
	
      $this -> query($update,$Conex,true);
	
	$this -> Commit($Conex);
	
	return $item_factura_proveedor_id;

  }


  public function getTipo($factura_proveedor_id,$Conex){
	 $select   = "SELECT t.puc_manual FROM factura_proveedor f, tipo_bien_servicio t  
	 			WHERE f.factura_proveedor_id = $factura_proveedor_id AND t.tipo_bien_servicio_id=f.tipo_bien_servicio_id "; 
	 $result = $this -> DbFetchAll($select,$Conex);
	 $tipo=$result[0][puc_manual];
	 return $tipo;


  }
  
  
  public function selectCuentaPuc($puc_id,$factura_proveedor_id,$Conex){
	  
	 $select   = "SELECT requiere_centro_costo,requiere_tercero FROM puc WHERE puc_id = $puc_id"; 
	 $requires = $this -> DbFetchAll($select,$Conex);
	 
	 $select = "SELECT * FROM impuesto_oficina WHERE empresa_id = (SELECT o.empresa_id FROM factura_proveedor f, oficina o WHERE 
																   f.factura_proveedor_id = $factura_proveedor_id AND o.oficina_id=f.oficina_id)
	            AND oficina_id = (SELECT oficina_id FROM factura_proveedor WHERE 
																   factura_proveedor_id = $factura_proveedor_id)
				AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)";
				
      $impuesto = $this -> DbFetchAll($select,$Conex);				
	  
	  if(!count($impuesto) > 0){
		  
	    $select   = "SELECT * FROM impuesto WHERE puc_id = $puc_id";				
        $impuesto = $this -> DbFetchAll($select,$Conex);						  
		  
      }
	  
	  $requiere_centro_costo = $requires[0]['requiere_centro_costo'] == 1 ? 'true' : 'false';
	  $requiere_tercero      = $requires[0]['requiere_tercero']      == 1 ? 'true' : 'false';
	  $require_base          = count($impuesto) > 0                       ? 'true' : 'false';
	  
	  $requieresCuenta=array(requiere_centro_costo=>$requiere_centro_costo,requiere_tercero=>$requiere_tercero,
							 require_base=>$require_base);
	  
	  return $requieresCuenta;	 
      
	  
  }
  
  public function selectImpuesto($puc_id,$base_factura_proveedor,$factura_proveedor_id,$Conex){
	
	
	  $select = "SELECT ip.naturaleza,imp.* FROM  impuesto ip, impuesto_periodo_contable imp 
	  WHERE imp.periodo_contable_id = (SELECT p.periodo_contable_id  FROM factura_proveedor f, periodo_contable p, oficina of WHERE f.factura_proveedor_id = $factura_proveedor_id AND of.oficina_id=f.oficina_id AND p.anio=YEAR(f.fecha_factura_proveedor) AND p.empresa_id=of.empresa_id )
	  AND imp.impuesto_id = (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id) AND imp.impuesto_id = ip.impuesto_id";
      $impuesto = $this -> DbFetchAll($select,$Conex);				
	  		  
	  $porcentaje    = $impuesto[0]['porcentaje'];
	  $impuesto_id   = $impuesto[0]['impuesto_id'];
	  $naturaleza    = $impuesto[0]['naturaleza'];
	  $formula       = $impuesto[0]['formula'];
		  
      $calculo = str_replace("BASE",$base_factura_proveedor,$formula);
	  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
		  
	  $select     = "SELECT $calculo AS valor_total";
      $result     = $this -> DbFetchAll($select ,$Conex);
	  $valorTotal = $result[0]['valor_total'];
		  
      return array(valor => $valorTotal, naturaleza =>$naturaleza);	  
		  	
	  
  }

   
}



?>