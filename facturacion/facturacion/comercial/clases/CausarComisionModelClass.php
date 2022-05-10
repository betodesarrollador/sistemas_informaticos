<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class CausarComisionModel extends Db{
		
  private $UserId;
  private $Permisos;
  
  public function SetUsuarioId($UserId,$CodCId){	  
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($UserId,$CodCId);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	  return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
  public function selectDatosCausarComisionId($factura_proveedor_id,$Conex){
     $select    = "SELECT f.*,
	 					(SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=f.encabezado_registro_id) AS numero_soporte,
						(SELECT COUNT(*) AS pagos FROM relacion_abono_factura r, abono_factura_proveedor a WHERE r.factura_proveedor_id=f.factura_proveedor_id AND a.abono_factura_proveedor_id=r.abono_factura_proveedor_id AND (a.estado_abono_factura='A' OR a.estado_abono_factura='C') ) AS numero_pagos
					FROM factura_proveedor f 
	                WHERE f.factura_proveedor_id = $factura_proveedor_id";
     $result    = $this -> DbFetchAll($select,$Conex);
     return $result;					  			
	  
  }

    

  public function getDataComisionesSel($concepto_item,$Conex){
		
	$select = "SELECT 
            o.fecha_inicio, o.fecha_final,
            CONCAT_WS(' ',t.razon_social, t.primer_nombre, t.primer_apellido) AS cliente, 
            o.valor_neto_pagar, IF(o.tipo_liquidacion='R','RECAUDO','VENTA') AS tipo
			FROM comisiones o, cliente c, tercero t
			WHERE o.comisiones_id IN ($concepto_item) AND  o.estado='L' 
            AND c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id";
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result;		
  }
        
  public function getCausalesAnulacion($Conex){
		
	$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
	$result = $this -> DbFetchAll($select,$Conex);
	
	return $result;		
  }


  public function getDataComercial($comercial_id,$Conex){

     $select = "SELECT tr.numero_identificacion AS proveedor_nit,
                (SELECT p.proveedor_id FROM proveedor p WHERE p.tercero_id=tr.tercero_id ) AS proveedor_id
					
	 			FROM comercial p, tercero tr
				WHERE  p.comercial_id=$comercial_id AND tr.tercero_id = p.tercero_id";
     $result = $this -> DbFetchAll($select,$Conex,false);

     return $result;

  }  
    
  public function SaveProveedor($usuario_id,$comercial_id,$Conex){
     $proveedor_id 	 = $this -> DbgetMaxConsecutive("proveedor","proveedor_id",$Conex,true,1);
     $insert = "INSERT INTO proveedor (proveedor_id,tercero_id,autoret_proveedor,retei_proveedor,renta_proveedor,fecha_ingreso) 
                SELECT $proveedor_id,p.tercero_id,p.autoret_comercial,p.retei_comercial,p.renta_comercial,'".date('Y-m-d')."'
	 			FROM comercial p WHERE  p.comercial_id=$comercial_id ";
     $this -> query($insert,$Conex,true);

     return $proveedor_id;

  }
    
  
	public function getDataFactura($factura_proveedor_id,$Conex){

     $select = "SELECT 
	 					f.comisiones_id,
						f.fecha_factura_proveedor,
						f.fuente_servicio_cod,
						f.vence_factura_proveedor,
						f.codfactura_proveedor,
						f.concepto_factura_proveedor,
						f.tipo_bien_servicio_id,
						f.proveedor_id,
						f.valor_factura_proveedor as valor,
						(SELECT t.numero_identificacion FROM  proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND  t.tercero_id=p.tercero_id ) AS proveedor_nit,
						(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM  proveedor p, tercero t WHERE p.proveedor_id=f.proveedor_id AND  t.tercero_id=p.tercero_id ) AS proveedor_nombre,
						IF(f.liquidacion_despacho_id>0,
						  	(SELECT numero_despacho FROM liquidacion_despacho  WHERE liquidacion_despacho_id=f.liquidacion_despacho_id),
							(SELECT consecutivo FROM liquidacion_reexpedido  WHERE liquidacion_reexpedido_id=f.liquidacion_reexpedido_id))as num_referencia						
	 			FROM factura_proveedor f 
				WHERE f.factura_proveedor_id = $factura_proveedor_id ";

     $result = $this -> DbFetchAll($select,$Conex,true);

     return $result;

  }  


  public function Save($usuario_id,$oficina_id,$Campos,$Conex){	

   
	  $this -> Begin($Conex);
	  $factura_proveedor_id 	 = $this -> DbgetMaxConsecutive("factura_proveedor","factura_proveedor_id",$Conex,true,1);
	  $fuente_servicio_cod 		 = $this -> requestDataForQuery('fuente_servicio_cod','alphanum');
	  $fecha_factura_proveedor 	 = $this -> requestDataForQuery('fecha_factura_proveedor','date');		  
	  $vence_factura_proveedor 	 = $this -> requestDataForQuery('vence_factura_proveedor','date');	
	  $ingreso_factura_proveedor = $this -> requestDataForQuery('ingreso_factura_proveedor','date');
	  $valor					 = $this -> requestDataForQuery('valor','numeric');
	  $concepto_factura_proveedor= $this -> requestDataForQuery('concepto_factura_proveedor','text');
      $concepto                  = $this -> requestDataForQuery('concepto','text');
      $concepto_item             = $this -> requestDataForQuery('concepto_item','text');
      $proveedor_id             = $this -> requestDataForQuery('proveedor_id','integer');
      $comercial_id             = $this -> requestDataForQuery('comercial_id','integer');


      $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor) 
                    VALUES ($factura_proveedor_id,$valor,$fecha_factura_proveedor,$vence_factura_proveedor,$concepto_factura_proveedor,$proveedor_id,$fuente_servicio_cod,'A',$usuario_id,$oficina_id,$ingreso_factura_proveedor)"; 

      $this -> query($insert,$Conex,true);

      //aca 


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

    //echo $insert;	
$this -> query($insert,$Conex);
$this -> Commit($Conex);	
}


if(!strlen(trim($this -> GetError())) > 0){
$this -> Begin($Conex);
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
              f.comisiones_id,
              CASE f.fuente_servicio_cod WHEN 'CO' THEN 'Comisiones  ' WHEN 'MC' THEN 'Manifiesto de Carga No ' ELSE 'Despacho Urbano No ' END AS tipo_soporte,
               (SELECT comisiones_id FROM  comisiones  WHERE comisiones_id=f.comisiones_id) AS numero_soporte_ord,						  
              (SELECT tercero_id  FROM  proveedor WHERE proveedor_id=f.proveedor_id) AS tercero,
              (SELECT puc_id  FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id AND contra_bien_servicio=1) AS puc_contra,
              IF(f.tipo_bien_servicio_id>0,(SELECT tipo_documento_id  FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),(SELECT tipo_documento_id  FROM comisiones WHERE comisiones_id =f.comisiones_id )) AS tipo_documento					  
        FROM factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id";

        //echo $select;

$result 	= $this -> DbFetchAll($select,$Conex); 

$select_sum = "SELECT SUM(deb_item_factura_proveedor) AS debito, SUM(cre_item_factura_proveedor) AS credito FROM  item_factura_proveedor 
            WHERE factura_proveedor_id=$factura_proveedor_id ";
$result_sum	= $this -> DbFetchAll($select_sum,$Conex);	

if($result_sum[0][debito]!=$result_sum[0][credito]){
$this -> Rollback($Conex);
exit("<div align='center'>Debe parametrizar correctamente las cuentas, Las sumas de debito y credito no son iguales!!!</div>");	 
}


$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
            WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";

$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

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
$comisiones_id			= $result[0]['comisiones_id'];
$con_fecha_factura_prov = $fecha_registro;	

$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
                mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,fuente_servicio_cod,numero_documento_fuente,id_documento_fuente)
                VALUES($encabezado_registro_id,1,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
                $mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$fuente_servicio_cod','$numero_documento_fuente',$id_documento_fuente)"; 

$this -> query($insert,$Conex);
$this -> Commit($Conex);

$this -> Begin($Conex);
$select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";

$result_item      = $this -> DbFetchAll($select_item,$Conex);
foreach($result_item as $result_items){
$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
                SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
                formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor
                FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 

$this -> query($insert_item,$Conex);

}


if(strlen($this -> GetError()) > 0){
$this -> Rollback($Conex);
}else{		
$this -> Commit($Conex);

$update = "UPDATE factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,	
            estado_factura_proveedor= 'C',
            con_usuario_id = $usuario_id,
            con_fecha_factura_proveedor='$con_fecha_factura_prov'
        WHERE factura_proveedor_id=$factura_proveedor_id";	
$this -> query($update,$Conex);		  

if(strlen($this -> GetError()) > 0){
    $this -> Rollback($Conex);

}  
} 	

if($fuente_servicio_cod=="'CO'"){

    $update = "UPDATE comisiones  SET estado='C' 
    WHERE   comisiones_id = $comisiones_id";
    $this -> query($update,$Conex);

}	


return $factura_proveedor_id;
}
  }
	
  public function Update($Campos,$Conex){	
    $this -> Begin($Conex);

	  if($_REQUEST['factura_proveedor_id'] != 'NULL'){
		$factura_proveedor_id 		= $this -> requestDataForQuery('factura_proveedor_id','integer');	
		$fuente_servicio_cod 		= $this -> requestDataForQuery('fuente_servicio_cod','alphanum');
		$fecha_factura_proveedor 	= $this -> requestDataForQuery('fecha_factura_proveedor','date');		  
		$vence_factura_proveedor 	= $this -> requestDataForQuery('vence_factura_proveedor','date');	
		$usuario_id					= $this -> requestDataForQuery('usuario_id','integer');	
		$oficina_id					= $this -> requestDataForQuery('oficina_id','integer');		  
		$ingreso_factura_proveedor	= $this -> requestDataForQuery('ingreso_factura_proveedor','date');	
		$concepto_factura_proveedor= $this -> requestDataForQuery('concepto_factura_proveedor','text');
		
		if($fuente_servicio_cod=="'OC'"){
		
		  $codfactura_proveedor 	= $this -> requestDataForQuery('codfactura_proveedor','alphanum');
		  
		  $update = "UPDATE factura_proveedor SET  	codfactura_proveedor=$codfactura_proveedor,
		  											fecha_factura_proveedor=$fecha_factura_proveedor,
													vence_factura_proveedor=$vence_factura_proveedor,
													concepto_factura_proveedor=$concepto_factura_proveedor
						WHERE factura_proveedor_id=$factura_proveedor_id"; 
		
		}elseif($fuente_servicio_cod=="'MC'"){
		
		  $update = "UPDATE factura_proveedor SET  	fecha_factura_proveedor=$fecha_factura_proveedor,
													vence_factura_proveedor=$vence_factura_proveedor,
													concepto_factura_proveedor=$concepto_factura_proveedor
						WHERE factura_proveedor_id=$factura_proveedor_id"; 
		
		}elseif($fuente_servicio_cod=="'DU'"){
		
		  $update = "UPDATE factura_proveedor SET  	fecha_factura_proveedor=$fecha_factura_proveedor,
													vence_factura_proveedor=$vence_factura_proveedor,
													concepto_factura_proveedor=$concepto_factura_proveedor													
						WHERE factura_proveedor_id=$factura_proveedor_id"; 

		}elseif($fuente_servicio_cod=="'RE'"){
		
		  $update = "UPDATE factura_proveedor SET  	fecha_factura_proveedor=$fecha_factura_proveedor,
													vence_factura_proveedor=$vence_factura_proveedor,
													concepto_factura_proveedor=$concepto_factura_proveedor													
						WHERE factura_proveedor_id=$factura_proveedor_id"; 

		}elseif($fuente_servicio_cod=="'NN'"){
		
		  $update = "UPDATE factura_proveedor SET  	fecha_factura_proveedor=$fecha_factura_proveedor,
													vence_factura_proveedor=$vence_factura_proveedor,
													concepto_factura_proveedor=$concepto_factura_proveedor													
						WHERE factura_proveedor_id=$factura_proveedor_id"; 

		}
		$this -> query($update,$Conex);
	  	if(!strlen(trim($this -> GetError())) > 0){
			$this -> Commit($Conex);
		}		
	  }
  }
  
		
   public function ValidateRow($Conex,$Campos){
	 require_once("../../../framework/clases/ValidateRowClass.php");
	 $Data = new ValidateRow($Conex,"factura_proveedor",$Campos);
	 return $Data -> GetData();
   }
	 	
  public function cancellation($Conex){
	 

	$this -> Begin($Conex);

      $factura_proveedor_id 		= $this -> requestDataForQuery('factura_proveedor_id','integer');
      $causal_anulacion_id  		= $this -> requestDataForQuery('causal_anulacion_id','integer');
      $anul_factura_proveedor   	= $this -> requestDataForQuery('anul_factura_proveedor','text');
	  $desc_anul_factura_proveedor  = $this -> requestDataForQuery('desc_anul_factura_proveedor','text');
	  $anul_usuario_id          	= $this -> requestDataForQuery('anul_usuario_id','integer');	
	  
	  $select = "SELECT fuente_servicio_cod,orden_compra_id,liquidacion_despacho_id,liquidacion_reexpedido_id, encabezado_registro_id FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";	
	  $result = $this -> DbFetchAll($select,$Conex); 
	  $fuente = $result[0]['fuente_servicio_cod'];	  
	  $orden  = $result[0]['orden_compra_id'];	  
	  $liquida= $result[0]['liquidacion_despacho_id'];	
	  $liquidacion_reexpedido_id= $result[0]['liquidacion_reexpedido_id'];	
	  $encabezado_registro_id = $result[0]['encabezado_registro_id'];
	  
	  if($fuente=='OC'){
			$update = "UPDATE orden_compra  SET estado_orden_compra='L' 
			WHERE   orden_compra_id = $orden";
			$this -> query($update,$Conex);
			
		}elseif($fuente=='MC'){
			$update = "UPDATE liquidacion_despacho  SET estado_liquidacion='L' 
			WHERE   liquidacion_despacho_id = $liquida";
			$this -> query($update,$Conex);

		}elseif($fuente=='DU'){
			$update = "UPDATE liquidacion_despacho  SET estado_liquidacion='L' 
			WHERE   liquidacion_despacho_id = $liquida";
			$this -> query($update,$Conex);

		}elseif($fuente=='RE'){
			$update = "UPDATE liquidacion_reexpedido  SET estado_liquidacion_reexpedido='L' 
			WHERE    	liquidacion_reexpedido_id = $liquidacion_reexpedido_id";
			$this -> query($update,$Conex,true);

	  }
	  $select1 = "SELECT encabezado_registro_id FROM encabezado_de_registro_anulado WHERE encabezado_registro_id=$encabezado_registro_id";	
	  $result1 = $this -> DbFetchAll($select1,$Conex); 
	  if($encabezado_registro_id>0 && $encabezado_registro_id!='' && $encabezado_registro_id!=NULL && !$result1[0]['encabezado_registro_id']>0){	 
		  		  
		  $insert = "INSERT INTO encabezado_de_registro_anulado SELECT $encabezado_registro_id AS 
		  encabezado_de_registro_anulado_id,encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,
		  forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,mes_contable_id,consecutivo,
		  fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,$causal_anulacion_id AS causal_anulacion_id,
		  $desc_anul_factura_proveedor AS observaciones FROM encabezado_de_registro WHERE encabezado_registro_id = $encabezado_registro_id";
		
		  $this -> query($insert,$Conex,true);
	
		  if(strlen($this -> GetError()) > 0){
		  	$this -> Rollback($Conex);
		  }else{
			$insert = "INSERT INTO imputacion_contable_anulada SELECT  imputacion_contable_id AS  
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
	  
	  $update = "UPDATE factura_proveedor SET estado_factura_proveedor= 'I',
	  				causal_anulacion_id = $causal_anulacion_id,
					anul_factura_proveedor=$anul_factura_proveedor,
					desc_anul_factura_proveedor =$desc_anul_factura_proveedor,
					anul_usuario_id=$anul_usuario_id
	  			WHERE factura_proveedor_id=$factura_proveedor_id";	
      $this -> query($update,$Conex);		  
	
	  if(strlen($this -> GetError()) > 0){
	  	$this -> Rollback($Conex);
	  }else{		
      	$this -> Commit($Conex);			
	  }  
  }

  public function getTotalDebitoCredito($factura_proveedor_id,$Conex){
	  
	  $select = "SELECT SUM(deb_item_factura_proveedor) AS debito,SUM(cre_item_factura_proveedor) AS credito,
	  (SELECT COUNT(*) FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND  contra_factura_proveedor=1) AS contrapartidas,
	  (SELECT liquidacion_despacho_id FROM factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id ) AS liquidacion_despacho_id	  
	  FROM item_factura_proveedor  WHERE factura_proveedor_id=$factura_proveedor_id";

      $result = $this -> DbFetchAll($select,$Conex);
	  
	  return $result; 
	  
  }

  public function getContabilizarReg($factura_proveedor_id,$empresa_id,$oficina_id,$usuario_id,$mesContable,$periodoContable,$Conex){
	 
    include_once("UtilidadesContablesModelClass.php");
	  
	$utilidadesContables = new UtilidadesContablesModel(); 	 
	 
	$this -> Begin($Conex);
		
		$select 	= "SELECT f.factura_proveedor_id,
						  f.encabezado_registro_id,
						  f.fuente_servicio_cod,
						  f.tipo_bien_servicio_id, 		
						  f.valor_factura_proveedor,
						  f.orden_compra_id,
						  f.codfactura_proveedor,
						  f.fecha_factura_proveedor,
						  f.concepto_factura_proveedor,
						  f.liquidacion_despacho_id,
						  f.liquidacion_reexpedido_id,
						  CASE f.fuente_servicio_cod WHEN 'OC' THEN 'Orden de Compra No ' WHEN 'MC' THEN 'Manifiesto de Carga No ' ELSE 'Despacho Urbano No ' END AS tipo_soporte,
						  (SELECT numero_despacho FROM  liquidacion_despacho  WHERE liquidacion_despacho_id=f.liquidacion_despacho_id) AS numero_soporte_ord,						  
						  (SELECT tercero_id  FROM  proveedor WHERE proveedor_id=f.proveedor_id) AS tercero,
						  (SELECT puc_id  FROM codpuc_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id AND contra_bien_servicio=1) AS puc_contra,
						  IF(f.tipo_bien_servicio_id>0,(SELECT tipo_documento_id  FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),(SELECT tipo_documento_id  FROM liquidacion_despacho WHERE liquidacion_despacho_id =f.liquidacion_despacho_id )) AS tipo_documento					  
					FROM factura_proveedor f WHERE f.factura_proveedor_id=$factura_proveedor_id";	
					
					echo $select;
		$result 	= $this -> DbFetchAll($select,$Conex); 

		 if($result[0]['encabezado_registro_id']>0 && $result[0]['encabezado_registro_id']!=''){
		  exit('Ya esta en proceso la contabilizaci&oacute;n de la Causacion.<br>Por favor Verifique.');
		 }


		$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
		$result_usu	= $this -> DbFetchAll($select_usu,$Conex);				

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
		$this -> query($insert,$Conex);
		
		$select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
		$result_item      = $this -> DbFetchAll($select_item,$Conex);
		foreach($result_item as $result_items){
			$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
			$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
							formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor
							FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 
			$this -> query($insert_item,$Conex);
		}
		
		if(strlen($this -> GetError()) > 0){
			$this -> Rollback($Conex);
		}else{		
		
			$update = "UPDATE factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,	
						estado_factura_proveedor= 'C',
						con_usuario_id = $usuario_id,
						con_fecha_factura_proveedor='$con_fecha_factura_prov'
					WHERE factura_proveedor_id=$factura_proveedor_id";	
			$this -> query($update,$Conex);		  
			if($liquidacion_despacho_id>0){
				$update = "UPDATE liquidacion_despacho SET encabezado_registro_id=$encabezado_registro_id	
						WHERE  liquidacion_despacho_id=$liquidacion_despacho_id";	
				$this -> query($update,$Conex);		  
			}
			if(strlen($this -> GetError()) > 0){
				$this -> Rollback($Conex);
				
			}else{		
				$this -> Commit($Conex);
				return true;
			}  
		}  
  }

  public function mesContableEstaHabilitado($empresa_id,$oficina_id,$fecha_factura_proveedor,$Conex){
	  
      $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND 
	                  oficina_id = $oficina_id AND '$fecha_factura_proveedor' BETWEEN fecha_inicio AND fecha_final";
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

  public function selectEstadoEncabezadoRegistro($factura_proveedor_id,$Conex){
	  
    $select = "SELECT estado_factura_proveedor FROM factura_proveedor  WHERE factura_proveedor_id = $factura_proveedor_id";	  
	$result = $this -> DbFetchAll($select,$Conex); 
	$estado = $result[0]['estado_factura_proveedor'];
	
	return $estado;	  
	  
  }
		
   public function GetFuente($Conex){
	return $this -> DbFetchAll("SELECT fuente_servicio_cod AS value,fuente_servicio_nom AS text FROM fuente_servicio",$Conex,
	$ErrDb = false);
   }

   public function GetServinn($Conex){
	return $this -> DbFetchAll("SELECT tipo_bien_servicio_id AS value,nombre_bien_servicio AS text FROM tipo_bien_servicio WHERE fuente_servicio_cod='NN'",$Conex,
	$ErrDb = false);
   }

   public function GetQueryCausarComisionGrid(){
	   	   
   $Query = "SELECT (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = f.encabezado_registro_id) AS consecutivo, f.ingreso_factura_proveedor, 
   					f.orden_compra_id,
					f.codfactura_proveedor,
					IF(f.liquidacion_despacho_id>0,(SELECT numero_despacho FROM liquidacion_despacho WHERE liquidacion_despacho_id=f.liquidacion_despacho_id),(SELECT consecutivo FROM liquidacion_reexpedido WHERE liquidacion_reexpedido_id=f.liquidacion_reexpedido_id)) AS num_ref,
					(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) AS proveedor FROM tercero WHERE tercero_id=p.tercero_id) AS proveedor,
					(SELECT fuente_servicio_nom FROM fuente_servicio WHERE fuente_servicio_cod=f.fuente_servicio_cod) AS fuente_nombre,
					(SELECT nombre_bien_servicio FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id) AS tipo_servicio,
					f.fecha_factura_proveedor,
					f.vence_factura_proveedor,
					CASE f.estado_factura_proveedor WHEN 'A' THEN 'CAUSADA' WHEN 'I' THEN 'ANULADA' ELSE 'CONTABILIZADA' END AS estado_factura_proveedor
			FROM factura_proveedor f, proveedor p
		WHERE p.proveedor_id=f.proveedor_id";
		
   return $Query;
   }
}

?>