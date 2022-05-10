<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class ContabilizarModel extends Db{

	private $usuario_id;
	private $Permisos;

	public function SetUsuarioId($usuario_id,$oficina_id){
		$this -> Permisos = new PermisosForm();
		$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
	}

	public function getPermiso($ActividadId,$Permiso,$Conex){
		return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
	}

	public function generateReporte($desde,$hasta,$Conex){


		$select = "(SELECT f.factura_proveedor_id AS id,
				'CAUSACION' AS tipo,
				f.fecha_factura_proveedor AS fecha,
				f.vence_factura_proveedor AS vencimiento,
				f.codfactura_proveedor AS numero_referencia,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
				FROM tercero t, proveedor p WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
				f.valor_factura_proveedor AS valor,
			    (SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=IF(f.tipo_bien_servicio_id>0,(SELECT tipo_documento_id  FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),(SELECT tipo_documento_id  FROM liquidacion_despacho WHERE liquidacion_despacho_id =f.liquidacion_despacho_id ))) AS tipo_documento
			FROM factura_proveedor f
			WHERE f.fecha_factura_proveedor between '$desde' AND '$hasta' AND f.estado_factura_proveedor='A')
			UNION ALL
			
			(SELECT af.abono_factura_proveedor_id AS id,
			 'PAGO' AS tipo,
			 af.fecha AS fecha,
			 'N/A' AS vencimiento,
			 'N/A' AS numero_referencia,
			 (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
			 FROM tercero t, proveedor p WHERE p.proveedor_id=af.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
			 af.valor_abono_factura AS valor,
			(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=af.tipo_documento_id) AS tipo_documento

			 FROM abono_factura_proveedor af
			 WHERE af.fecha between '$desde' AND '$hasta' AND af.estado_abono_factura='A')";
		$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
	}

	public function generateReporteexcel($desde,$hasta,$Conex){


		$select = "(SELECT 
				'CAUSACION' AS tipo,
				f.fecha_factura_proveedor AS fecha,
				f.vence_factura_proveedor AS vencimiento,
				f.codfactura_proveedor AS numero_referencia,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
				FROM tercero t, proveedor p WHERE p.proveedor_id=f.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
				f.valor_factura_proveedor AS valor,
			    (SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=IF(f.tipo_bien_servicio_id>0,(SELECT tipo_documento_id  FROM tipo_bien_servicio WHERE tipo_bien_servicio_id=f.tipo_bien_servicio_id),(SELECT tipo_documento_id  FROM liquidacion_despacho WHERE liquidacion_despacho_id =f.liquidacion_despacho_id ))) AS tipo_documento
			FROM factura_proveedor f
			WHERE f.fecha_factura_proveedor between '$desde' AND '$hasta' AND f.estado_factura_proveedor='A')
			UNION ALL
			
			(SELECT 
			 'PAGO' AS tipo,
			 af.fecha AS fecha,
			 'N/A' AS vencimiento,
			 'N/A' AS numero_referencia,
			 (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
			 FROM tercero t, proveedor p WHERE p.proveedor_id=af.proveedor_id AND t.tercero_id=p.tercero_id) AS proveedor,
			 af.valor_abono_factura AS valor,
			(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=af.tipo_documento_id) AS tipo_documento

			 FROM abono_factura_proveedor af
			 WHERE af.fecha between '$desde' AND '$hasta' AND af.estado_abono_factura='A')";
		$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
	}

	public function Contabilizar($empresa_id,$usuario_id,$oficina_id,$modifica,$Conex){
		include_once("UtilidadesContablesModelClass.php");
		$utilidadesContables = new UtilidadesContablesModel(); 	
		
		$causaciones_ok=0;
		$causaciones_mal=0;
		$pagos_ok=0;
		$pagos_mal=0;
		
		$facturas = substr($_REQUEST['facturas'], 0, -1);
		$facturas = explode(',',$facturas);
		
		$select ="SELECT *	FROM empresa e, tercero t  WHERE  e.empresa_id=$empresa_id AND t.tercero_id=e.tercero_id  "; 
		$empresa = $this -> DbFetchAll($select,$Conex,true);
		$tercero_id = $empresa[0]['tercero_id'];
		$digito_verificacion = $empresa[0]['digito_verificacion']>=0 ? $empresa[0]['digito_verificacion']: 'NULL';


		if(count($facturas)>0){
			for($i=0;$i<count($facturas);$i++){
				$id_p=explode("-",$facturas[$i]);
				
				if($id_p[1]=='CAUSACION'){

					$factura_proveedor_id=$id_p[0];

					$this -> Begin($Conex);
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
					
			
					$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
									WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
					$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);				
			
					$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
					$tipo_documento_id		= $result[0]['tipo_documento'];	
					$valor					= $result[0]['valor_factura_proveedor'];
					$numero_soporte			= $result[0]['codfactura_proveedor'] !='' ? $result[0]['codfactura_proveedor'] : $result[0]['numero_soporte_ord'];	
					$tercero_id				= $result[0]['tercero'];
					
					
					$fechaMes                  = substr($result[0]['fecha_factura_proveedor'],0,10);		
					$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex,true);
					$mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex,true);
					$consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex,true);
					
					
					
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

					
					$select_contra = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND contra_factura_proveedor=1";
					$result_contra = $this -> DbFetchAll($select_contra,$Conex,true);
					
					if(!count($result_contra)>0){exit("No Ha seleccionado una contrapartida!!!");}
					
					$select_item      = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
					$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
					foreach($result_item as $result_items){
						$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
						$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id)
										SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
										formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,area_id,departamento_id,unidad_negocio_id,sucursal_id
										FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]"; 
						$this -> query($insert_item,$Conex,true);
					}
					
					if(strlen($this -> GetError()) > 0){
						$this -> Rollback($Conex);
						$causaciones_mal++;			
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
							$causaciones_mal++;							
						}else{		
							$this -> Commit($Conex);
							$causaciones_ok++;


						}  
					}  



				}elseif($id_p[1]=='PAGO'){
					$abono_factura_proveedor_id=$id_p[0];
					$this -> Begin($Conex);
					$select 	= "SELECT a.abono_factura_proveedor_id,
									  a.valor_abono_factura,
									  a.ingreso_abono_factura,
									  a.fecha,
									  a.num_cheque,
									  a.cuenta_tipo_pago_id,
									  a.concepto_abono_factura,
									  (SELECT tercero_id  FROM  proveedor WHERE proveedor_id=a.proveedor_id) AS tercero,
									  (SELECT puc_id  FROM cuenta_tipo_pago  WHERE cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS puc_contra,
									  a.tipo_documento_id 					  
								FROM abono_factura_proveedor a WHERE a.abono_factura_proveedor_id=$abono_factura_proveedor_id";	
					$result 	= $this -> DbFetchAll($select,$Conex,true); 
			
					$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
					
					$tipo_documento_id		= $result[0]['tipo_documento_id'];	
					
					
					$valor					= $result[0]['valor_abono_factura'];
					$numero_soporte			= $result[0]['concepto_abono_factura'];	
					$tercero_id				= $result[0]['tercero'];
					
					$fecha					= $result[0]['fecha'];
					$num_cheque				= $result[0]['num_cheque']!='' ? "'".$result[0]['num_cheque']."'":'NULL';
					
					
					$fechaMes                  = substr($fecha,0,10);		
					$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex,true);
					$mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex,true);
					$consecutivo               = $utilidadesContables -> getConsecutivo($oficina_id,$tipo_documento_id,$periodo_contable_id,$Conex,true);			
							
					$concepto				= $result[0]['concepto_abono_factura'];
					$puc_id					= $result[0]['puc_contra'];
					$fecha_registro			= date("Y-m-d H:m");
					$numero_documento_fuente= $result[0]['abono_factura_proveedor_id'];
					$id_documento_fuente	= $result[0]['abono_factura_proveedor_id'];
					$con_fecha_abono_factura= $fecha_registro;	
					$cuenta_tipo_pago_id	= $result[0][cuenta_tipo_pago_id];
			
			
					$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
									WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
					$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);		
					$modifica	= $result_usu[0]['usuario'];
			
					$select_pago = "SELECT forma_pago_id FROM cuenta_tipo_pago WHERE cuenta_tipo_pago_id=$cuenta_tipo_pago_id";
					$result_pago = $this -> DbFetchAll($select_pago,$Conex,true);		
					$forma_pago_id	= $result_pago[0]['forma_pago_id'];
			
			
					$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,forma_pago_id,valor,numero_soporte,tercero_id,periodo_contable_id,
										mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
										VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,$forma_pago_id,'$valor',$num_cheque,$tercero_id,$periodo_contable_id,
										$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
										
					$this -> DbFetchAll($insert,$Conex,true);
			
					$select_item = "SELECT item_abono_factura_id FROM item_abono_factura WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id";
					$result_item = $this -> DbFetchAll($select_item,$Conex,true);	
					
					foreach($result_item as $result_items){
			
						$imputacion_contable_id	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
						$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,porcentaje,formula,debito,credito)
										SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_abono_factura,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_abono_factura+cre_item_abono_factura),base_abono_factura,porcentaje_abono_factura,
										formula_abono_factura,deb_item_abono_factura,cre_item_abono_factura
										FROM item_abono_factura WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id AND item_abono_factura_id=$result_items[item_abono_factura_id]"; 
						$this -> DbFetchAll($insert_item,$Conex,true);
					}
					if(strlen($this -> GetError()) > 0){
						$this -> Rollback($Conex);
						$pagos_mal++;
					}else{		
					
						$update = "UPDATE abono_factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,	
									estado_abono_factura= 'C',
									con_usuario_id = $usuario_id,
									con_fecha_abono_factura='$con_fecha_abono_factura'
								WHERE abono_factura_proveedor_id =$abono_factura_proveedor_id";	
						$this -> query($update,$Conex,true);		  
					
						if(strlen($this -> GetError()) > 0){
							$this -> Rollback($Conex);
							$pagos_mal++;
						}else{		
							$this -> Commit($Conex);
							$pagos_ok++;
							
						}  
					}  

					
				}
			}
			return 'Causaciones Contabilizadas: '.$causaciones_ok.'<br>'.'Causaciones NO Contabilizadas: '.$causaciones_mal.'<br>'.'Pagos Contabilizadas: '.$pagos_ok.'<br>'.'Pagos NO Contabilizadas: '.$pagos_mal.'<br>';
		}else{
			exit("No se selecciono Ningun Registro");	
		}
	}

}
	
?>
