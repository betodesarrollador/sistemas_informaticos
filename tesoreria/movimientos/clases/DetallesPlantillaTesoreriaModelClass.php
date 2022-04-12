<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class DetallesPlantillaTesoreriaModel extends Db{

	private $Permisos;
  
  	public function getImputacionesContables($plantilla_tesoreria_id,$empresa_id,$oficina_id,$Conex){
	   	
		if(is_numeric($plantilla_tesoreria_id)){

			$select      = "SELECT COUNT(*) AS movimientos FROM item_plantilla_tesoreria WHERE plantilla_tesoreria_id = $plantilla_tesoreria_id";
			$result      = $this -> DbFetchAll($select,$Conex);
		 	$movimientos = $result[0]['movimientos'];
	 
	 	 	if($movimientos ==0){
	
				$total_pagar=0;
				$parcial='';
				$contra=0;
				$impuesto=0;
				$subtotal=0;

				$selectm = "SELECT t.valor_manual, t.puc_manual, t.tercero_manual, t.centro_manual, f.concepto_plantilla_tesoreria  FROM plantilla_tesoreria f, tipo_bien_servicio_teso t 
				WHERE f.plantilla_tesoreria_id=$plantilla_tesoreria_id AND t.tipo_bien_servicio_teso_id=f.tipo_bien_servicio_teso_id";
				$resultm        = $this -> DbFetchAll($selectm,$Conex);
				$valor_manual   = $resultm[0]['valor_manual'];
				$puc_manual	  = $resultm[0]['puc_manual'];
				$tercero_manual = $resultm[0]['tercero_manual'];
				$centro_manual  = $resultm[0]['centro_manual'];
				$concepto_plantilla_tesoreria  = $resultm[0]['concepto_plantilla_tesoreria'];
				
				$select_item  = "SELECT c.codpuc_bien_servicio_teso_id,c.natu_bien_servicio_teso,c.contra_bien_servicio_teso,c.puc_id,c.codpuc_bien_servicio_teso_id,
				IF(pu.requiere_tercero=1,(SELECT tercero_id FROM proveedor WHERE proveedor_id=f.proveedor_id),NULL) AS tercero, c.tercero_id, c.centro_costo_id,pu.requiere_tercero,pu.requiere_centro_costo,
				IF(pu.requiere_centro_costo=1,(SELECT centro_de_costo_id FROM centro_de_costo WHERE oficina_id =$oficina_id AND empresa_id=$empresa_id),NULL) AS centro_costo,			
				(SELECT autoret_proveedor FROM proveedor WHERE proveedor_id=f.proveedor_id) AS autorete,				
				(SELECT retei_proveedor FROM proveedor WHERE proveedor_id=f.proveedor_id) AS retei,								
				(SELECT exentos FROM impuesto WHERE puc_id = c.puc_id AND empresa_id=$empresa_id) AS exento,
				(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=c.puc_id AND i.empresa_id = $empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND   io.oficina_id=$oficina_id) AS porcentaje,					  
				(SELECT ipc.formula FROM impuesto i,impuesto_oficina io,impuesto_periodo_contable ipc,periodo_contable pc 
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id) AS formula,					  
				(SELECT ipc.monto FROM impuesto i,impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id) AS monto, f.valor_plantilla_tesoreria AS total 
				FROM codpuc_bien_servicio_teso c, plantilla_tesoreria f, puc pu 
				WHERE f.plantilla_tesoreria_id = $plantilla_tesoreria_id AND c.tipo_bien_servicio_teso_id=f.tipo_bien_servicio_teso_id AND pu.puc_id=c.puc_id 
				ORDER BY c.contra_bien_servicio_teso ASC, c.codpuc_bien_servicio_teso_id ASC";
				
				$result_item      = $this -> DbFetchAll($select_item,$Conex);		  
				
		  		foreach($result_item as $resultado){

			 		if(($resultado[porcentaje]=='' || $resultado[porcentaje]==NULL) && $resultado[contra_bien_servicio_teso]!=1){
						 
						$parcial	= $resultado[total];
						$subtotal++;
						$base		= 'NULL';
						$formula	= 'NULL';
						$porcentaje= 'NULL';
					
				   	}elseif($resultado[porcentaje]>0 && $resultado[contra_bien_servicio_teso]!=1 &&  $resultado[monto]<=$resultado[total] && (($resultado[exento]=='RT' && $resultado[autorete]=='N' ) || ($resultado[exento]=='IC' && $resultado[retei]=='N') || ($resultado[exento]=='NN') )){
						 
						 $base		= $resultado[total];
						 $formula	= $resultado[formula];
						 $porcentaje= $resultado[porcentaje];
						 $calculo 	= str_replace("BASE",$base,$formula);
						 $calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
						 $select1   = "SELECT $calculo AS valor_total";
						 $result1   = $this -> DbFetchAll($select1 ,$Conex);
						 $parcial 	= $result1[0]['valor_total'];
						 $impuesto++;							
							
					 }elseif($resultado[contra_bien_servicio_teso]==1){
							$parcial	= $total_pagar;
							$contra++;
							$base		= 'NULL';
							$formula	= 'NULL';
							$porcentaje = 'NULL';
					 }
					 
					 if($resultado[natu_bien_servicio_teso]=='D' && $resultado[contra_bien_servicio_teso]!=1){
						 $total_pagar	= $total_pagar+$parcial;
					 }elseif($resultado[natu_bien_servicio_teso]=='C' && $resultado[contra_bien_servicio_teso]!=1){
						 $total_pagar	= $total_pagar-$parcial;
					 }
					 
					 if($resultado[natu_bien_servicio_teso]=='D'){
						$debito_insert= $parcial;
						$credito_insert='0';
					 }elseif($resultado[natu_bien_servicio_teso]=='C'){
						$debito_insert= '0';
						$credito_insert=$parcial;						 
					 }					 

					 $parcial = number_format($parcial,2,'.','');
					 $descripcion = $resultado[codpuc_bien_servicio_teso];
					
					 $item_plantilla_tesoreria_id = $this -> DbgetMaxConsecutive("item_plantilla_tesoreria","item_plantilla_tesoreria_id",$Conex,true,1);
					
					  if($valor_manual==1){
						  $debito_insert= '0';
						  $credito_insert='0';
					  }
				  
					  if($centro_manual==0 && $resultado[requiere_centro_costo]==1 && $resultado[centro_costo_id]>0){
						$centro_costo_id = $resultado[centro_costo_id];
						$codigo = "(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id =".$resultado[centro_costo_id].")";					
						
					  }elseif($centro_manual==0 && $resultado[requiere_centro_costo]==0 && !$resultado[centro_costo_id]>0){
						$centro_costo_id = 'NULL';
						$codigo = 'NULL';				
	
					  }elseif($centro_manual==1 && $resultado[requiere_centro_costo]==1 && $resultado[centro_costo]>0){
						$centro_costo_id = $resultado[centro_costo];
						$codigo = "(SELECT codigo FROM centro_de_costo WHERE centro_de_costo_id =".$resultado[centro_costo].")";					
	
					  }else{
						$centro_costo_id = 'NULL';
						$codigo = 'NULL';				
						  
					  }

					  if($tercero_manual==0 && $resultado[requiere_tercero]==1 && $resultado[tercero_id]>0){
						$tercero_id = $resultado[tercero_id];
						$numero_identificacion = "(SELECT numero_identificacion FROM tercero WHERE tercero_id=".$resultado[tercero_id].")";		
						$digito_verificacion = "(SELECT digito_verificacion FROM tercero WHERE tercero_id=".$resultado[tercero_id].")";		
						
					  }elseif($tercero_manual==0 && $resultado[requiere_tercero]==0 && !$resultado[tercero_id]>0){
						$tercero_id = 'NULL';
						$numero_identificacion = 'NULL';	
						$digito_verificacion = 'NULL';	
	
					  }elseif($tercero_manual==1 && $resultado[requiere_tercero]==1 && $resultado[tercero]>0){
						$tercero_id = $resultado[tercero];
						$numero_identificacion = "(SELECT numero_identificacion FROM tercero WHERE tercero_id=".$resultado[tercero].")";
						$digito_verificacion = "(SELECT digito_verificacion FROM tercero WHERE tercero_id=".$resultado[tercero].")";
	
					  }else{
						$tercero_id = 'NULL';
						$numero_identificacion = 'NULL';
						$digito_verificacion = 'NULL';	
						  
					  }

		
					  $insert="INSERT INTO item_plantilla_tesoreria
					  (item_plantilla_tesoreria_id,plantilla_tesoreria_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,
					  base_plantilla_tesoreria,porcentaje_plantilla_tesoreria,formula_plantilla_tesoreria,desc_plantilla_tesoreria,deb_item_plantilla_tesoreria,
					  cre_item_plantilla_tesoreria,contra_plantilla_tesoreria)
					  SELECT $item_plantilla_tesoreria_id, f.plantilla_tesoreria_id, $resultado[puc_id], $tercero_id, $numero_identificacion, $digito_verificacion,
					  $centro_costo_id, $codigo, '$base', '$porcentaje', '$formula',
					  IF('$concepto_plantilla_tesoreria'!='','$concepto_plantilla_tesoreria',(SELECT TRIM(nombre) FROM puc WHERE puc_id=c.puc_id)) AS desc_plantilla_tesoreria, '$debito_insert', '$credito_insert', c.contra_bien_servicio_teso
					  FROM codpuc_bien_servicio_teso c, plantilla_tesoreria f WHERE f.plantilla_tesoreria_id=$plantilla_tesoreria_id 
					  AND c.tipo_bien_servicio_teso_id=f.tipo_bien_servicio_teso_id AND c.codpuc_bien_servicio_teso_id=$resultado[codpuc_bien_servicio_teso_id]"; 
					  //echo $insert;
					  $this -> query($insert,$Conex);	
			  	}			
		 }
	
	  $select  = "SELECT i.*, (SELECT estado_plantilla_tesoreria FROM plantilla_tesoreria WHERE plantilla_tesoreria_id=i.plantilla_tesoreria_id ) AS estado,
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
	  FROM item_plantilla_tesoreria i WHERE i.plantilla_tesoreria_id = $plantilla_tesoreria_id";

	  $result = $this -> DbFetchAll($select,$Conex);
	  
	}else{
   	    $result = array();
	 }	
	return $result;  
  }  
    
  public function Save($usuario_id,$empresa_id,$oficina_id,$Campos,$Conex){
	  	  
  	$this -> Begin($Conex);

      $item_plantilla_tesoreria_id 	= $this -> DbgetMaxConsecutive("item_plantilla_tesoreria","item_plantilla_tesoreria_id",$Conex,true,1);
      $plantilla_tesoreria_id      	= $this -> requestDataForQuery('plantilla_tesoreria_id','integer');
	  $puc_id             	 	 	= $this -> requestDataForQuery('puc_id','integer');
	  $tercero_id             	 	= $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 	= $this -> requestDataForQuery('centro_de_costo_id','integer');
   	  $centro_de_costo     	 	 	= $this -> requestDataForQuery('centro_de_costo','text');
      $desc_plantilla_tesoreria    	= $this -> requestDataForQuery('desc_plantilla_tesoreria','text');	  
      $base_plantilla_tesoreria    	= $this -> requestDataForQuery('base_plantilla_tesoreria','integer');
      $deb_item_plantilla_tesoreria	= $this -> requestDataForQuery('deb_item_plantilla_tesoreria','numeric');
      $cre_item_plantilla_tesoreria	= $this -> requestDataForQuery('cre_item_plantilla_tesoreria','numeric');
	  $contra_plantilla_tesoreria	= $this -> requestDataForQuery('contra_plantilla_tesoreria','integer');	  
	  
      $insert = "INSERT INTO item_plantilla_tesoreria 
	  (item_plantilla_tesoreria_id,plantilla_tesoreria_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,
	  base_plantilla_tesoreria,
	  porcentaje_plantilla_tesoreria,formula_plantilla_tesoreria,desc_plantilla_tesoreria,deb_item_plantilla_tesoreria,cre_item_plantilla_tesoreria,contra_plantilla_tesoreria) 
	  VALUES  
	  ($item_plantilla_tesoreria_id,$plantilla_tesoreria_id,$puc_id,$tercero_id,
	  IF($tercero_id>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),
	  IF($tercero_id>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),
	  $centro_de_costo_id,$centro_de_costo,$base_plantilla_tesoreria,
	  (SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
	  WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
	  AND ipc.periodo_contable_id=pc.periodo_contable_id AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id 
	  AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id),					  
	  (SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id 
	  AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id AND ipc.periodo_contable_id=pc.periodo_contable_id AND ipc.impuesto_id=i.impuesto_id 
	  AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id),
	  $desc_plantilla_tesoreria,$deb_item_plantilla_tesoreria,$cre_item_plantilla_tesoreria,$contra_plantilla_tesoreria)";
     
	  $this -> query($insert,$Conex);	
	  $this -> Commit($Conex);	
	  return $item_plantilla_tesoreria_id;
  }

  public function Updates($empresa_id,$oficina_id,$Campos,$Conex){

  	$this -> Begin($Conex);

      $item_plantilla_tesoreria_id = $this -> requestDataForQuery('item_plantilla_tesoreria_id','integer');
	  $puc_id             	 	 = $this -> requestDataForQuery('puc_id','integer');
	  $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
   	  $centro_de_costo     	 	 = $this -> requestDataForQuery('centro_de_costo','text');
      $desc_plantilla_tesoreria    = $this -> requestDataForQuery('desc_plantilla_tesoreria','text');	  
      $base_plantilla_tesoreria    = $this -> requestDataForQuery('base_plantilla_tesoreria','integer');
      $deb_item_plantilla_tesoreria= $this -> requestDataForQuery('deb_item_plantilla_tesoreria','numeric');
      $cre_item_plantilla_tesoreria= $this -> requestDataForQuery('cre_item_plantilla_tesoreria','numeric');
	  $contra_plantilla_tesoreria	 = $this -> requestDataForQuery('contra_plantilla_tesoreria','integer');	  
	
      $update = "UPDATE item_plantilla_tesoreria SET 
	  tercero_id=$tercero_id,numero_identificacion=IF($tercero_id>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),
	  digito_verificacion=IF($tercero_id>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_id),NULL),
	  puc_id=$puc_id,centro_de_costo_id=$centro_de_costo_id,codigo_centro_costo=$centro_de_costo,desc_plantilla_tesoreria=$desc_plantilla_tesoreria,
      base_plantilla_tesoreria=$base_plantilla_tesoreria,
	  porcentaje_plantilla_tesoreria = (SELECT ipc.porcentaje FROM impuesto i,impuesto_oficina io,impuesto_periodo_contable ipc,periodo_contable pc 
      WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
	  AND ipc.periodo_contable_id=pc.periodo_contable_id AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id 
	  AND io.oficina_id=$oficina_id ),formula_plantilla_tesoreria=(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
	  WHERE i.puc_id=$puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
	  AND ipc.periodo_contable_id=pc.periodo_contable_id AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id 
	  AND io.oficina_id=$oficina_id ),deb_item_plantilla_tesoreria = $deb_item_plantilla_tesoreria,cre_item_plantilla_tesoreria = $cre_item_plantilla_tesoreria,
	  contra_plantilla_tesoreria=$contra_plantilla_tesoreria WHERE item_plantilla_tesoreria_id = $item_plantilla_tesoreria_id";
	
      $this -> query($update,$Conex,true); 	
	  $this -> Commit($Conex);	
	  return $item_plantilla_tesoreria_id;
  }

  public function Update($Campos,$Conex){

  	$this -> Begin($Conex);

      $item_plantilla_tesoreria_id = $this -> requestDataForQuery('item_plantilla_tesoreria_id','integer');
      $tercero_id             	 = $this -> requestDataForQuery('tercero_id','integer');
      $centro_de_costo_id     	 = $this -> requestDataForQuery('centro_de_costo_id','integer');
      $desc_plantilla_tesoreria    = $this -> requestDataForQuery('desc_plantilla_tesoreria','text');	  
      $base_plantilla_tesoreria    = $this -> requestDataForQuery('base_plantilla_tesoreria','integer');
      $deb_item_plantilla_tesoreria= $this -> requestDataForQuery('deb_item_plantilla_tesoreria','numeric');
      $cre_item_plantilla_tesoreria= $this -> requestDataForQuery('cre_item_plantilla_tesoreria','numeric');
	
      $update = "UPDATE item_plantilla_tesoreria SET tercero_id=$tercero_id,centro_de_costo_id=$centro_de_costo_id,desc_plantilla_tesoreria=$desc_plantilla_tesoreria,
      deb_item_plantilla_tesoreria = $deb_item_plantilla_tesoreria, cre_item_plantilla_tesoreria = $cre_item_plantilla_tesoreria 
	  WHERE item_plantilla_tesoreria_id = $item_plantilla_tesoreria_id";
	
      $this -> query($update,$Conex,true);	
	  $this -> Commit($Conex);	
	  return $item_plantilla_tesoreria_id;
  }
  
    public function Delete($Campos,$Conex){

    $item_plantilla_tesoreria_id = $_REQUEST['item_plantilla_tesoreria_id'];
	
    $insert = "DELETE FROM item_plantilla_tesoreria WHERE item_plantilla_tesoreria_id = $item_plantilla_tesoreria_id";
	
    $this -> query($insert,$Conex,true);	

  }

  public function getTipo($plantilla_tesoreria_id,$Conex){
	 $select   = "SELECT t.puc_manual, t.centro_manual,t.tercero_manual FROM plantilla_tesoreria f, tipo_bien_servicio_teso t  
	 WHERE f.plantilla_tesoreria_id = $plantilla_tesoreria_id AND t.tipo_bien_servicio_teso_id=f.tipo_bien_servicio_teso_id"; 
	 $result = $this -> DbFetchAll($select,$Conex); //echo  $select;
	 return $result;
  }
  
  public function selectCuentaPuc($puc_id,$plantilla_tesoreria_id,$Conex){
	  
	 $select   = "SELECT requiere_centro_costo,requiere_tercero FROM puc WHERE puc_id = $puc_id"; 
	 $requires = $this -> DbFetchAll($select,$Conex);
	 
	 $select = "SELECT * FROM impuesto_oficina WHERE empresa_id = (SELECT o.empresa_id FROM plantilla_tesoreria f, oficina o WHERE 
	 f.plantilla_tesoreria_id = $plantilla_tesoreria_id AND o.oficina_id=f.oficina_id) AND oficina_id = (SELECT oficina_id FROM plantilla_tesoreria WHERE 
	 plantilla_tesoreria_id = $plantilla_tesoreria_id) AND impuesto_id IN (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id)";
				
      $impuesto = $this -> DbFetchAll($select,$Conex);				
	  
	  if(!count($impuesto) > 0){		  
	    $select   = "SELECT * FROM impuesto WHERE puc_id = $puc_id";				
        $impuesto = $this -> DbFetchAll($select,$Conex);		  
      }
	  
	  $requiere_centro_costo = $requires[0]['requiere_centro_costo'] == 1 ? 'true' : 'false';
	  $requiere_tercero      = $requires[0]['requiere_tercero']      == 1 ? 'true' : 'false';
	  $require_base          = count($impuesto) > 0                       ? 'true' : 'false';
	  
	  $requieresCuenta=array(requiere_centro_costo=>$requiere_centro_costo,requiere_tercero=>$requiere_tercero,require_base=>$require_base);
	  return $requieresCuenta;	  
  }
  
  public function selectImpuesto($puc_id,$base_plantilla_tesoreria,$plantilla_tesoreria_id,$Conex){	
	
	  $select = "SELECT ip.naturaleza,imp.* FROM impuesto ip, impuesto_periodo_contable imp 
	  WHERE imp.periodo_contable_id = (SELECT p.periodo_contable_id FROM plantilla_tesoreria f, periodo_contable p, oficina of 
	  WHERE f.plantilla_tesoreria_id = $plantilla_tesoreria_id AND of.oficina_id=f.oficina_id AND p.anio=YEAR(f.fecha_plantilla_tesoreria) AND p.empresa_id=of.empresa_id)
	  AND imp.impuesto_id = (SELECT impuesto_id FROM impuesto WHERE puc_id = $puc_id) AND imp.impuesto_id = ip.impuesto_id";
      
	  $impuesto = $this -> DbFetchAll($select,$Conex);	  		  
	  $porcentaje    = $impuesto[0]['porcentaje'];
	  $impuesto_id   = $impuesto[0]['impuesto_id'];
	  $naturaleza    = $impuesto[0]['naturaleza'];
	  $formula       = $impuesto[0]['formula'];
		  
      $calculo = str_replace("BASE",$base_plantilla_tesoreria,$formula);
	  $calculo = str_replace("PORCENTAJE",$porcentaje,$calculo);		  
		  
	  $select2     = "SELECT $calculo AS valor_total";
      $result     = $this -> DbFetchAll($select2 ,$Conex);
	  $valorTotal = $result[0]['valor_total'];
		  
      return array(valor => $valorTotal, naturaleza =>$naturaleza);		  
  }
   
}

?>