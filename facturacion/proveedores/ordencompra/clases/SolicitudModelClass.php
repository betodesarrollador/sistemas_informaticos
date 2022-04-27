<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class SolicitudModel extends Db{
		
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
   public function selectOficina($Conex){
	return $this  -> DbFetchAll("SELECT oficina_id AS value,nombre AS text FROM oficina  ORDER BY nombre ASC",$Conex,$ErrDb = false);
  }
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex,true);
  }
  
  public function selectDatosSolicitudId($pre_orden_compra_id,$Conex){
     $select    = "SELECT 
	 				o.pre_orden_compra_id, 
					o.consecutivo,
					o.fecha_pre_orden_compra,
					o.centro_de_costo_id,
					o.proveedor_id,
					o.area_id,
					o.departamento_id,
					o.unidad_negocio_id,
					CONCAT_WS(' ',primer_apellido,segundo_apellido,primer_nombre,segundo_nombre,razon_social) AS proveedor,
					t.telefono AS proveedor_tele,
					t.direccion AS proveedor_direccion,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS proveedor_ciudad,
					p.contac_proveedor AS proveedor_contacto,
					t.email AS proveedor_correo,
					o.observ_pre_orden_compra,
					o.estado_pre_orden_compra,
					o.usuario_id,
					o.ingreso_pre_orden_compra,
					o.oficina_id as sucursal_id,
					o.placa_id,
					o.kilometraje,
					(SELECT placa FROM vehiculo WHERE placa_id = o.placa_id)as placa
					FROM pre_orden_compra o, proveedor p, tercero t 
	                WHERE o.pre_orden_compra_id = $pre_orden_compra_id AND p.proveedor_id=o.proveedor_id AND t.tercero_id=p.tercero_id ";
	$result    = $this -> DbFetchAll($select,$Conex,true);
     return $result;					  			
	  
  }
  public function selectDepartamento($Conex){
		$select         = "SELECT departamento_id AS value, nombre AS text FROM departamento WHERE estado='D'";
		$result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
		return $result;
	}

	public function selectUnidadNegocio($Conex){
		$select         = "SELECT unidad_negocio_id AS value, nombre AS text FROM unidad_negocio WHERE estado = 'D'";
		$result         = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
		return $result;
	}
	
	public function getArea($departamento_id,$Conex){

		$select="SELECT area_id AS value, nombre AS text 
			FROM area WHERE departamento_id = $departamento_id AND estado = 'D'";
		   
		$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;

	}
	public function getArea1($orden_id,$Conex){

		$select="SELECT area_id AS value, nombre AS text 
			FROM area 
			WHERE departamento_id = (SELECT departamento_id FROM pre_orden_compra WHERE pre_orden_compra_id=$orden_id)";
		   
		$result = $this -> DbFetchAll($select,$Conex,true);

		return $result;

	}

  public function liquidar($empresa_id,$oficina_id,$Conex){
	 

	$this -> Begin($Conex);

	  $pre_orden_compra_id    		= $this -> requestDataForQuery('pre_orden_compra_id','integer');
	  $liq_usuario_id       	= $this -> requestDataForQuery('liq_usuario_id','integer');
	  $fec_liq_pre_orden_compra    	= $this -> requestDataForQuery('fec_liq_pre_orden_compra','text');
	  $descrip_liq_pre_orden_compra = $this -> requestDataForQuery('descrip_liq_pre_orden_compra','text');
	  $descrip_pre_orden_compra 	= $this -> requestDataForQuery('descrip_pre_orden_compra','text');
	
	 $select      = "SELECT COUNT(*) AS movimientos FROM item_liquida_orden WHERE pre_orden_compra_id=$pre_orden_compra_id";
	 $result      = $this -> DbFetchAll($select,$Conex,true);
	 $movimientos = $result[0]['movimientos'];
 
	 if($movimientos ==0){
		 $select_cic      = "SELECT item_pre_orden_compra_id FROM item_pre_orden_compra WHERE pre_orden_compra_id=$pre_orden_compra_id";
		 $result_cic      = $this -> DbFetchAll($select_cic,$Conex,true);
		 foreach($result_cic as $item_id){
			$item_liquida_orden_id 		= $this -> DbgetMaxConsecutive("item_liquida_orden","item_liquida_orden_id",$Conex,true,1);
			 
			$insert="INSERT INTO item_liquida_orden (item_liquida_orden_id,pre_orden_compra_id,cant_item_liquida_orden,desc_item_liquida_orden,valoruni_item_liquida_orden,fecha_item_liquida,usuario_id)
					SELECT $item_liquida_orden_id,pre_orden_compra_id,cant_item_pre_orden_compra,desc_item_pre_orden_compra,valoruni_item_pre_orden_compra,fecha_item_orden,usuario_id  FROM item_pre_orden_compra WHERE item_pre_orden_compra_id=$item_id[item_pre_orden_compra_id]"; 
			$this -> DbFetchAll($insert,$Conex,true);
		}
	 }
	  
	  
	  $total_pagar=0;
	  $parcial='';
	  $select  = "SELECT  c.despuc_bien_servicio,
				c.natu_bien_servicio,
				c.contra_bien_servicio,
				c.puc_id,
				(SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
				(SELECT autoret_proveedor FROM proveedor WHERE proveedor_id=o.proveedor_id ) AS autorete,				
				(SELECT retei_proveedor FROM proveedor WHERE proveedor_id=o.proveedor_id ) AS retei,
				(SELECT renta_proveedor FROM proveedor WHERE proveedor_id=o.proveedor_id ) AS renta,
				(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
				(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,	
				(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,					  
				(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
				WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
				AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,					  						  
				
				(SELECT SUM(valoruni_item_liquida_orden*cant_item_liquida_orden) AS total FROM  item_liquida_orden  WHERE pre_orden_compra_id=o.pre_orden_compra_id) AS total,
				o.descrip_pre_orden_compra,
				o.centro_de_costo_id,
				o.area_id,o.departamento_id,o.unidad_negocio_id,o.sucursal_id
				FROM codpuc_bien_servicio  c, pre_orden_compra o 
				WHERE o.pre_orden_compra_id = $pre_orden_compra_id AND c.tipo_bien_servicio_id=o.tipo_bien_servicio_id ORDER BY c.contra_bien_servicio";

	 $result = $this -> DbFetchAll($select,$Conex,true);
	 
	 foreach($result as $resultado){
		 $debito	= '';
		 $credito	= '';
		 $ingresa	= 0;
		 if(($resultado[porcentaje]=='' || $resultado[porcentaje]==NULL) && $resultado[contra_bien_servicio]!=1){
				$ingresa	= 1;			 
				$parcial	= $resultado[total];
				$base		= '';
				$porcentaje	= '';
				$formula	= '';
		
		 }elseif($resultado[porcentaje]>0 && $resultado[contra_bien_servicio]!=1 &&  $resultado[monto]<=$resultado[total] && (($resultado[exento]=='RT' && $resultado[autorete]=='N' ) || ($resultado[exento]=='IC' && $resultado[retei]=='N') || ($resultado[exento]=='CR' && $resultado[renta]=='N') || ($resultado[exento]=='NN') )){
			 	 $ingresa	= 1;
				 $base		= $resultado[total];
				 $formula	= $resultado[formula];
				 $porcentaje= $resultado[porcentaje];
				 $calculo 	= str_replace("BASE",$base,$formula);
				 $calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
				 $select1   = "SELECT $calculo AS valor_total";
				 $result1   = $this -> DbFetchAll($select1 ,$Conex,true);
				 $parcial 	= $result1[0]['valor_total'];
				
				
		 }elseif($resultado[contra_bien_servicio]==1){
			  	$ingresa	= 1;
				$parcial	= $total_pagar;
				$base		= '';
				$porcentaje	= '';
				$formula	= '';				
		 }
		 $descripcion	= $resultado[puc_nombre];
		 if($ingresa==1){
			 if($resultado[natu_bien_servicio]=='D' && $resultado[contra_bien_servicio]!=1){
				 $total_pagar	= $total_pagar+$parcial;
				 $debito		= number_format($parcial,2,'.','');			 
				 $credito		= '0.00';
				 
			 }elseif($resultado[natu_bien_servicio]=='C' && $resultado[contra_bien_servicio]!=1){
				 $total_pagar	= $total_pagar-$parcial;
				 $debito		= '0.00';
				 $credito		= number_format($parcial,2,'.','');					 
			 }elseif($resultado[natu_bien_servicio]=='D' && $resultado[contra_bien_servicio]==1){
				 $debito		= number_format($parcial,2,'.','');			 
				 $credito		= '0.00';
			 }elseif($resultado[natu_bien_servicio]=='C' && $resultado[contra_bien_servicio]==1){	 
				 $debito		= '0.00';
				 $credito		= number_format($parcial,2,'.','');					 
			 }
			 
			 $item_puc_liquida_id 	= $this -> DbgetMaxConsecutive("item_puc_liquida_orden","item_puc_liquida_id",$Conex,true,1);
			 
			 $insert = "INSERT INTO item_puc_liquida_orden (item_puc_liquida_id,pre_orden_compra_id,puc_id,base_item_puc_liquida,porcentaje_item_puc_liquida,formula_item_puc_liquida,desc_item_puc_liquida,deb_item_puc_liquida,cre_item_puc_liquida,contra_liquida_orden,centro_de_costo_id,area_id,departamento_id,unidad_negocio_id,sucursal_id)
						VALUES ($item_puc_liquida_id,$pre_orden_compra_id,$resultado[puc_id],'$base','$porcentaje','$formula','$resultado[descrip_pre_orden_compra]','$debito','$credito',$resultado[contra_bien_servicio],$resultado[centro_de_costo_id],$resultado[area_id],$resultado[departamento_id],$resultado[unidad_negocio_id],$resultado[sucursal_id])";
						//exit($insert);
			 $this -> query($insert,$Conex,true);			
		 }
	 }

	  $update = "UPDATE pre_orden_compra SET liq_usuario_id=$liq_usuario_id, fec_liq_pre_orden_compra=$fec_liq_pre_orden_compra, estado_pre_orden_compra='L', descrip_liq_pre_orden_compra=$descrip_liq_pre_orden_compra 
	  				WHERE pre_orden_compra_id=$pre_orden_compra_id AND estado_pre_orden_compra='A'"; 
	  $this -> query($update,$Conex,true);
	
	  if(strlen($this -> GetError()) > 0){
	  	$this -> Rollback($Conex);
	  }else{		
      	$this -> Commit($Conex);			
	  }  
  }

  public function Checkconfig($pre_orden_compra_id,$empresa_id,$oficina_id,$Conex){
	 
	  $contra=0;
	  $impuesto=0;
	  $subtotal=0;
	  
	  $select  = "SELECT  c.despuc_bien_servicio,
		c.natu_bien_servicio,
		c.contra_bien_servicio,
		c.puc_id,
		(SELECT nombre FROM puc WHERE puc_id=c.puc_id) AS puc_nombre,
		
		(SELECT autoret_proveedor FROM proveedor WHERE proveedor_id=o.proveedor_id ) AS autorete,				
		(SELECT retei_proveedor FROM proveedor WHERE proveedor_id=o.proveedor_id ) AS retei,	
		(SELECT renta_proveedor FROM proveedor WHERE proveedor_id=o.proveedor_id ) AS renta,		
		(SELECT exentos FROM impuesto WHERE puc_id=c.puc_id AND empresa_id=$empresa_id ) AS exento,
		(SELECT ipc.porcentaje FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
		WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
		AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS porcentaje,	
		(SELECT  ipc.monto FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
		WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
		AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS monto,					  
		(SELECT ipc.formula FROM impuesto i, impuesto_oficina io, impuesto_periodo_contable ipc, periodo_contable pc 
		WHERE i.puc_id=c.puc_id AND i.empresa_id=$empresa_id AND i.estado='A' AND pc.anio=Year(CURDATE()) AND pc.empresa_id=$empresa_id 
		AND ipc.periodo_contable_id=pc.periodo_contable_id 	AND ipc.impuesto_id=i.impuesto_id AND io.impuesto_id=ipc.impuesto_id AND io.empresa_id=$empresa_id AND io.oficina_id=$oficina_id ) AS formula,					  						  
		
		(SELECT SUM(valoruni_item_liquida_orden*cant_item_liquida_orden) AS total FROM  item_liquida_orden  WHERE pre_orden_compra_id=o.pre_orden_compra_id) AS total
		FROM codpuc_bien_servicio  c, pre_orden_compra o 
		WHERE o.pre_orden_compra_id = $pre_orden_compra_id AND c.tipo_bien_servicio_id=o.tipo_bien_servicio_id ORDER BY c.contra_bien_servicio";

	 $result = $this -> DbFetchAll($select,$Conex,true);
	 
	 foreach($result as $resultado){
		 if(($resultado[porcentaje]=='' || $resultado[porcentaje]==NULL) && $resultado[contra_bien_servicio]!=1){
			 
			$subtotal++;		
			
		 }elseif($resultado[porcentaje]>0 && $resultado[contra_bien_servicio]!=1 &&  $resultado[monto]<=$resultado[total] && (($resultado[exento]=='RT' && $resultado[autorete]=='N' ) || ($resultado[exento]=='IC' && $resultado[retei]=='N') || ($resultado[exento]=='CR' && $resultado[renta]=='N')  || ($resultado[exento]=='NN') )){
			
			$impuesto++;
				
		 }elseif($resultado[contra_bien_servicio]==1){
			 
			$contra++;				
		 }
	 }
	if($subtotal==1 && $impuesto>=0 && $contra==1 ){
		return 'si';
	}else{
		return 'no';	
	}
	
  }

  public function getDataProveedor($proveedor_id,$Conex){

     $select = "SELECT tr.telefono AS proveedor_tele,tr.direccion AS proveedor_direccion,p.contac_proveedor AS proveedor_contacto,tr.email AS proveedor_correo,(SELECT nombre FROM ubicacion WHERE ubicacion_id=tr.ubicacion_id) AS proveedor_ciudad  
	 FROM proveedor p, tercero tr WHERE p.proveedor_id = $proveedor_id AND tr.tercero_id = p.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }
  public function getCausalesAnulacion($Conex){
		
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;		
  }

  public function getTotal($pre_orden_compra_id,$Conex){
	  
	  $select = "SELECT SUM(valoruni_item_pre_orden_compra) AS subtotal,SUM(valoruni_item_pre_orden_compra*cant_item_pre_orden_compra) AS total FROM item_pre_orden_compra  WHERE pre_orden_compra_id=$pre_orden_compra_id";

      $result = $this -> DbFetchAll($select,$Conex,true);
	  
	  return $result; 
	  
  }

	
  
  public function Save($Campos,$Conex){	

    $this -> Begin($Conex);
		
	  $pre_orden_compra_id    	= $this -> DbgetMaxConsecutive("pre_orden_compra","pre_orden_compra_id",$Conex,true,1);
  	  $fecha_pre_orden_compra 	= $this -> requestDataForQuery('fecha_pre_orden_compra','date');
	  $descrip_pre_orden_compra = $this -> requestDataForQuery('descrip_pre_orden_compra','text');
	  $observ_pre_orden_compra 	= $this -> requestDataForQuery('observ_pre_orden_compra','text');
	  $centro_de_costo_id	= $this -> requestDataForQuery('centro_de_costo_id','integer');
	  $proveedor_id    		= $this -> requestDataForQuery('proveedor_id','integer');
	  $tipo_bien_servicio_id= $this -> requestDataForQuery('tipo_bien_servicio_id','integer');
	  $forma_compra_venta_id= $this -> requestDataForQuery('forma_compra_venta_id','integer');
	  $estado_pre_orden_compra	= "'A'";
	  $usuario_id           = $this -> requestDataForQuery('usuario_id','integer');
	  $oficina_id           = $this -> requestDataForQuery('oficina_id','integer');
	  $area_id           	= $this -> requestDataForQuery('area_id','integer');
	  $departamento_id      = $this -> requestDataForQuery('departamento_id','integer');
	  $sucursal_id  	    = $this -> requestDataForQuery('sucursal_id','integer');
	  $unidad_negocio_id    = $this -> requestDataForQuery('unidad_negocio_id','integer');
      $ingreso_pre_orden_compra	= $this -> requestDataForQuery('ingreso_pre_orden_compra','date');
	  
	  $placa_id	= $this -> requestDataForQuery('placa_id','integer');
	  $kilometraje	= $this -> requestDataForQuery('kilometraje','integer');
	  
	  //si ingresan l aplaca y el kilometraje
	  if($placa_id!='' && $kilometraje>0){
		    $select_veh = "SELECT IF(kilometraje IS NULL,0,kilometraje)as kilom_ant FROM vehiculo WHERE placa_id=$placa_id";
		    $result_veh = $this -> DbFetchAll($select_veh,$Conex,true); 
	  		$kilom_ant = $result_veh[0]['kilom_ant'];
			//si el kilometraje de la orden de compra es mayor a la que tenia registrada
			if($kilometraje>$kilom_ant){
				$update_veh="UPDATE vehiculo SET kilometraje = $kilometraje WHERE placa_id=$placa_id";
				$this -> query($update_veh,$Conex,true);
			}

	  }
	  

	  $select_con = "SELECT (MAX(consecutivo)+1) AS consecut FROM pre_orden_compra  WHERE 	oficina_id = $oficina_id";	  
	  $result_con = $this -> DbFetchAll($select_con,$Conex,true); 
	  $consecutivo = $result_con[0]['consecut']>0 ?$result_con[0]['consecut']:1;


	  $insert = "INSERT INTO pre_orden_compra (pre_orden_compra_id,consecutivo,fecha_pre_orden_compra,descrip_pre_orden_compra,observ_pre_orden_compra,centro_de_costo_id,proveedor_id,estado_pre_orden_compra,usuario_id,ingreso_pre_orden_compra,oficina_id,area_id,departamento_id,unidad_negocio_id,sucursal_id,placa_id,kilometraje) 
	  				VALUES ($pre_orden_compra_id,$consecutivo,$fecha_pre_orden_compra,$observ_pre_orden_compra,$observ_pre_orden_compra,$centro_de_costo_id,$proveedor_id,$estado_pre_orden_compra,$usuario_id,$ingreso_pre_orden_compra,$oficina_id,$area_id,$departamento_id,$unidad_negocio_id,$sucursal_id,$placa_id,$kilometraje)"; 
			//echo $insert;		
	  $this -> query($insert,$Conex,true);

	  if(!strlen(trim($this -> GetError())) > 0){
	  	$this -> Commit($Conex);		 
  	  	return array(pre_orden_compra_id=>$pre_orden_compra_id,consecutivo=>$consecutivo);
	  }
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);
	
	  $pre_orden_compra_id    	= $this -> requestDataForQuery('pre_orden_compra_id','integer');
  	  $fecha_pre_orden_compra 	= $this -> requestDataForQuery('fecha_pre_orden_compra','date');
	  $descrip_pre_orden_compra = $this -> requestDataForQuery('descrip_pre_orden_compra','text');
	  $observ_pre_orden_compra 	= $this -> requestDataForQuery('observ_pre_orden_compra','text');
   	  $centro_de_costo_id	= $this -> requestDataForQuery('centro_de_costo_id','integer');
	  $proveedor_id    		= $this -> requestDataForQuery('proveedor_id','integer');
	  $tipo_bien_servicio_id= $this -> requestDataForQuery('tipo_bien_servicio_id','integer');
	  $forma_compra_venta_id= $this -> requestDataForQuery('forma_compra_venta_id','integer');
	  $estado_pre_orden_compra	= $this -> requestDataForQuery('estado_pre_orden_compra','alphanum');
	  $usuario_id           = $this -> requestDataForQuery('usuario_id','integer');
	  $oficina_id           = $this -> requestDataForQuery('oficina_id','integer');
      $area_id           	= $this -> requestDataForQuery('area_id','integer');
	  $departamento_id      = $this -> requestDataForQuery('departamento_id','integer');
	  $sucursal_id  	    = $this -> requestDataForQuery('sucursal_id','integer');
	  $unidad_negocio_id    = $this -> requestDataForQuery('unidad_negocio_id','integer');
      $ingreso_pre_orden_compra	= $this -> requestDataForQuery('ingreso_pre_orden_compra','date');
	  $placa_id	= $this -> requestDataForQuery('placa_id','integer');
	  $kilometraje	= $this -> requestDataForQuery('kilometraje','integer');
	  
	  
	   //si ingresan l aplaca y el kilometraje
	  if($placa_id!='' && $kilometraje>0){
		    $select_veh = "SELECT IF(kilometraje IS NULL,0,kilometraje)as kilom_ant FROM vehiculo WHERE placa_id=$placa_id";
		    $result_veh = $this -> DbFetchAll($select_veh,$Conex,true); 
	  		$kilom_ant = $result_veh[0]['kilom_ant'];
			//si el kilometraje de la orden de compra es mayor a la que tenia registrada
			if($kilometraje>$kilom_ant){
				$update_veh="UPDATE vehiculo SET kilometraje = $kilometraje WHERE placa_id=$placa_id";
				$this -> query($update_veh,$Conex,true);
			}

	  }
	  
	
	  if($_REQUEST['pre_orden_compra_id'] == 'NULL'){
		  $insert = "INSERT INTO pre_orden_compra (pre_orden_compra_id,fecha_pre_orden_compra,descrip_pre_orden_compra,observ_pre_orden_compra,centro_de_costo_id,proveedor_id,tipo_bien_servicio_id,forma_compra_venta_id,estado_pre_orden_compra,usuario_id,ingreso_pre_orden_compra,oficina_id,area_id,departamento_id,unidad_negocio_id,sucursal_id) 
						VALUES ($pre_orden_compra_id,$fecha_pre_orden_compra,$descrip_pre_orden_compra,$observ_pre_orden_compra,$centro_de_costo_id,$proveedor_id,$tipo_bien_servicio_id,$forma_compra_venta_id,$estado_pre_orden_compra,$usuario_id,i$ngreso_pre_orden_compra,$oficina_id,$area_id,$departamento_id,$unidad_negocio_id,$sucursal_id)"; 
		  $this -> query($insert,$Conex,true);
	
		  if(!strlen(trim($this -> GetError())) > 0){
			$this -> Commit($Conex);		 
			return $pre_orden_compra_id;
		  }
      }else{
		  $update = "UPDATE pre_orden_compra SET fecha_pre_orden_compra= $fecha_pre_orden_compra,
						descrip_pre_orden_compra = $descrip_pre_orden_compra,
						observ_pre_orden_compra = $observ_pre_orden_compra,
						centro_de_costo_id=$centro_de_costo_id,
						proveedor_id=$proveedor_id,
						area_id=$area_id,departamento_id=$departamento_id,unidad_negocio_id=$unidad_negocio_id,sucursal_id=$sucursal_id,
						tipo_bien_servicio_id =$tipo_bien_servicio_id,
						forma_compra_venta_id=$forma_compra_venta_id,
						placa_id = $placa_id,
						kilometraje = $kilometraje
					WHERE pre_orden_compra_id=$pre_orden_compra_id";	
		  $this -> query($update,$Conex,true);
		  if(!strlen(trim($this -> GetError())) > 0){
			  $this -> Commit($Conex);
			  return $pre_orden_compra_id;
		  }
     }
	
  }
  
  public function cancellation($Conex){
	 

	$this -> Begin($Conex);

      $pre_orden_compra_id 			= $this -> requestDataForQuery('pre_orden_compra_id','integer');
      $causal_anulacion_id  	= $this -> requestDataForQuery('causal_anulacion_id','integer');
      $anul_pre_orden_compra    	= $this -> requestDataForQuery('anul_pre_orden_compra','text');
	  $desc_anul_pre_orden_compra   = $this -> requestDataForQuery('desc_anul_pre_orden_compra','text');
	  $anul_usuario_id          = $this -> requestDataForQuery('anul_usuario_id','integer');	
	  
	  $update = "UPDATE pre_orden_compra SET estado_pre_orden_compra= 'I',
	  				causal_anulacion_id = $causal_anulacion_id,
					anul_pre_orden_compra=$anul_pre_orden_compra,
					desc_anul_pre_orden_compra =$desc_anul_pre_orden_compra,
					anul_usuario_id=$anul_usuario_id
	  			WHERE pre_orden_compra_id=$pre_orden_compra_id";	
      $this -> query($update,$Conex,true);		  
	
	  if(strlen($this -> GetError()) > 0){
	  	$this -> Rollback($Conex);
	  }else{		
      	$this -> Commit($Conex);			
	  }  
  }

  public function selectEstadoEncabezadoRegistro($pre_orden_compra_id,$Conex){
	  
    $select = "SELECT estado_pre_orden_compra FROM pre_orden_compra  WHERE 	pre_orden_compra_id = $pre_orden_compra_id";	  
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$estado = $result[0]['estado_pre_orden_compra'];
	
	return $estado;	  
	  
  }

  public function selectItemliquida($pre_orden_compra_id,$Conex){
	  
    $select = "SELECT COUNT(*) AS movimientos FROM  item_pre_orden_compra   WHERE 	pre_orden_compra_id = $pre_orden_compra_id";	  
	$result = $this -> DbFetchAll($select,$Conex,true); 
	$totali = $result[0]['movimientos'];
	
	return $totali;	  
	  
  }

		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"pre_orden_compra",$Campos);
	 return $Data -> GetData();
   }
	 	
   public function GetTipoPago($Conex){
	return $this -> DbFetchAll("SELECT forma_compra_venta_id AS value,nombre AS text FROM forma_compra_venta",$Conex,
	$ErrDb = false);
   }

   public function getCentroCosto($Conex){
	return $this -> DbFetchAll("SELECT centro_de_costo_id AS value,nombre AS text FROM centro_de_costo",$Conex,
	$ErrDb = false);
   }


   public function GetQuerySolicitudGrid(){

     $Query    	= "SELECT 
					 CONCAT('','<a href=\"javascript:void(0)\" onClick=\"viewDoc(',pre_orden_compra_id,')\">',o.consecutivo,'</a>') AS pre_orden_compra_id,
	 				(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
					o.fecha_pre_orden_compra AS fecha_pre_orden_compra,
					CONCAT_WS(' ',t.primer_apellido,t.segundo_apellido,t.primer_nombre,t.segundo_nombre,t.razon_social) AS proveedor_nombre,
					t.telefono AS proveedor_tele,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) AS proveedor_ciudad,

					CASE o.estado_pre_orden_compra WHEN 'A' THEN 'ACTIVO' WHEN 'C' THEN 'CAUSADA' WHEN 'L' THEN 'LIQUIDADA' ELSE 'ANULADA' END AS estado,
					(SELECT c.nombre FROM centro_de_costo c WHERE o.centro_de_costo_id = c.centro_de_costo_id)AS centro_de_costo
					FROM pre_orden_compra o, proveedor p, tercero t 
	                WHERE p.proveedor_id=o.proveedor_id AND t.tercero_id=p.tercero_id   ";
   return $Query;
   }
}

?>