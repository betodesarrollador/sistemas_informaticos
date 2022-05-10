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


		$select = "(SELECT f.factura_id AS id,
				'FACTURA' AS tipo,
				f.fecha AS fecha,
				f.vencimiento AS vencimiento,
				f.consecutivo_factura AS consecutivo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
				FROM tercero t, cliente p WHERE p.cliente_id=f.cliente_id AND t.tercero_id=p.tercero_id) AS cliente,
				f.valor AS valor,
			    (SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=f.tipo_documento_id) AS tipo_documento
			FROM factura f
			WHERE f.fecha between '$desde' AND '$hasta' AND f.estado='A')
			UNION ALL
			
			(SELECT af.abono_factura_id AS id,
			 'PAGO' AS tipo,
			 af.fecha AS fecha,
			 'N/A' AS vencimiento,
			 'N/A' AS numero_referencia,
			 (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
			 FROM tercero t, cliente p WHERE p.cliente_id=af.cliente_id AND t.tercero_id=p.tercero_id) AS cliente,
			 af.valor_abono_factura AS valor,
			(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=af.tipo_documento_id) AS tipo_documento
			 FROM abono_factura af
			 WHERE af.fecha between '$desde' AND '$hasta' AND af.estado_abono_factura='A')";
		$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
	}

	public function generateReporteexcel($desde,$hasta,$Conex){


		$select = "(SELECT 
				'FACTURA' AS tipo,
				f.fecha AS fecha,
				f.vencimiento AS vencimiento,
				f.consecutivo_factura AS consecutivo,
				(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
				FROM tercero t, cliente p WHERE p.cliente_id=f.cliente_id AND t.tercero_id=p.tercero_id) AS cliente,
				f.valor AS valor,
			    (SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=f.tipo_documento_id) AS tipo_documento
			FROM factura f
			WHERE f.fecha between '$desde' AND '$hasta' AND f.estado='A')
			UNION ALL
			
			(SELECT 
			 'PAGO' AS tipo,
			 af.fecha AS fecha,
			 'N/A' AS vencimiento,
			 'N/A' AS numero_referencia,
			 (SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) 
			 FROM tercero t, cliente p WHERE p.cliente_id=af.cliente_id AND t.tercero_id=p.tercero_id) AS cliente,
			 af.valor_abono_factura AS valor,
			(SELECT nombre FROM tipo_de_documento WHERE tipo_documento_id=af.tipo_documento_id) AS tipo_documento
			 FROM abono_factura af
			 WHERE af.fecha between '$desde' AND '$hasta' AND af.estado_abono_factura='A')";
		$data = $this -> DbFetchAll($select,$Conex,true);
		return $data;
	}

	public function Contabilizar($empresa_id,$usuario_id,$oficina_id,$modifica,$Conex){
		include_once("../../../framework/clases/UtilidadesContablesModelClass.php");
		$utilidadesContables = new UtilidadesContablesModel(); 	
		
		$facturas_ok=0;
		$facturas_mal=0;
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
				
				if($id_p[1]=='FACTURA'){

					$factura_id=$id_p[0];

					$this -> Begin($Conex);
					
					$select 	= "SELECT f.factura_id,
									  f.fuente_facturacion_cod,
									  f.tipo_bien_servicio_factura_id, 		
									  f.consecutivo_factura, 
									  f.consecutivo_factura, 
									  f.valor,
									  f.fecha,
									  f.concepto_item,
									  f.encabezado_registro_id,
									  f.tipo_documento_id,
									  CASE f.fuente_facturacion_cod WHEN 'OS' THEN 'Ordenes de Servicio'  ELSE 'Remesas' END AS tipo_soporte,
									  (SELECT tercero_id  FROM  cliente WHERE cliente_id=f.cliente_id) AS tercero,
									  (SELECT puc_id  FROM codpuc_bien_servicio_factura WHERE tipo_bien_servicio_factura_id=f.tipo_bien_servicio_factura_id AND contra_bien_servicio_factura=1 AND activo=1) AS puc_contra
								FROM factura f WHERE f.factura_id=$factura_id";	
					$result 	= $this -> DbFetchAll($select,$Conex,true); 
			
					 if($result[0]['encabezado_registro_id']>0 && $result[0]['encabezado_registro_id']!=''){
					  exit('Ya esta en proceso la contabilizaci&oacute;n de la Factura.<br>Por favor Verifique.');
					 }
			
			
					$select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t 
									WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
					$result_usu	= $this -> DbFetchAll($select_usu,$Conex,true);				
			
					$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
					$tip_documento			= $result[0]['tipo_documento_id'];	
					$tipo_documento_id      = $result[0]['tipo_documento_id'];	
					$valor					= $result[0]['valor'];
					$numero_soporte			= $result[0]['consecutivo_factura'];	
					$tercero_id				= $result[0]['tercero'];
					$concepto_item			= $result[0]['concepto_item'];
					$forma_pago_id			= $result_pago[0]['forma_pago_id'];
					
							
					$fecha					   = $result[0]['fecha'];		
					$fechaMes                  = substr($fecha,0,10);		
					$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex,true);
					$mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex,true);
					
					if($mes_contable_id>0 && $periodo_contable_id>0){
						$consecutivo			= $result[0]['consecutivo_factura'];
										
						$concepto				= 'Facturacion '.$result[0]['tipo_soporte'].' '.$numero_soporte;
						$puc_id					= $result[0]['puc_contra'];
						$fecha_registro			= date("Y-m-d H:m");
						$modifica				= $result_usu[0]['usuario'];
						$fuente_facturacion_cod	= $result[0]['fuente_facturacion_cod'];
						$numero_documento_fuente= $numero_soporte;
						$id_documento_fuente	= $result[0]['factura_id'];
						$con_fecha_factura		= $fecha_registro;	
				
						$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
											mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
											VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tip_documento,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
											$mes_contable_id,$consecutivo,'$fecha','$concepto',$puc_id,'C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)"; 
						$this -> query($insert,$Conex,true);  
						
						$area_id='';
						$departamento_id='';
						$unidad_negocio_id='';
						$centro_de_costo_id='';
						$sucursal_id='';
						
						if($fuente_facturacion_cod=='OS'){  
							$item				= str_replace("'","",$concepto_item);
							$item				= explode(',',$item);
							
							$orden_id = explode('-',$item[0]);
							
							$select_datos="SELECT os.area_id,os.departamento_id,os.unidad_negocio_id,os.centro_de_costo_id,(SELECT cc.codigo FROM centro_de_costo cc WHERE cc.centro_de_costo_id=os.centro_de_costo_id)as codigo_centro,os.sucursal_id FROM orden_servicio os WHERE os.orden_servicio_id=$orden_id[0] ";
							////echo $select_datos;
							$result_datos=$this -> DbFetchAll($select_datos,$Conex,true);	
							
							$area_id=$result_datos[0]['area_id'];
							$departamento_id=$result_datos[0]['departamento_id'];
							$unidad_negocio_id=$result_datos[0]['unidad_negocio_id'];
							$centro_de_costo_id=$result_datos[0]['centro_de_costo_id'];
							$sucursal_id=$result_datos[0]['sucursal_id'];
							$codigo_centro=$result_datos[0]['codigo_centro'];
						
				
						}
						$select_item      = "SELECT detalle_factura_puc_id,puc_id  FROM  detalle_factura_puc WHERE factura_id=$factura_id";
						$result_item      = $this -> DbFetchAll($select_item,$Conex,true);
						foreach($result_item as $result_items){
							
							$select_requieres="SELECT requiere_centro_costo,requiere_tercero,requiere_sucursal,area,departamento,unidadnegocio FROM puc WHERE puc_id =$result_items[puc_id] ";
							$result_requieres      = $this -> DbFetchAll($select_requieres,$Conex,true);
							////echo $select_requieres;
							
							$centro_de_costo_id = $result_requieres[0]['requiere_centro_costo']==1 ? $centro_de_costo_id : 'NULL';
							$area_id = $result_requieres[0]['area']==1 ? $area_id : 'NULL'	;
							$departamento_id = $result_requieres[0]['departamento']==1 ? $departamento_id : 'NULL';
							$unidad_negocio_id = $result_requieres[0]['unidadnegocio']==1 ? $unidad_negocio_id : 'NULL';
							$sucursal_id = $result_requieres[0]['sucursal']==1 ? $sucursal_id : 'NULL';
							$codigo_centro = $result_requieres[0]['requiere_centro_costo']==1 ? $codigo_centro : 'NULL';
							
							
							$imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
							$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito,area_id,departamento_id,unidad_negocio_id,sucursal_id)
											SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura,$encabezado_registro_id,$centro_de_costo_id,codigo_centro_costo,(deb_item_factura+cre_item_factura),base_factura,porcentaje_factura,
											formula_factura,deb_item_factura,cre_item_factura,$area_id,$departamento_id,$unidad_negocio_id,$sucursal_id
											FROM detalle_factura_puc WHERE factura_id=$factura_id AND detalle_factura_puc_id=$result_items[detalle_factura_puc_id]"; 
											

							$this -> query($insert_item,$Conex,true);
						}
			
						if(strlen($this -> GetError()) > 0){
							$this -> Rollback($Conex);
							$facturas_mal++;
						}else{		
						
							$update = "UPDATE factura SET encabezado_registro_id=$encabezado_registro_id,	
										estado= 'C',
										con_usuario_id = $usuario_id,
										con_fecha_factura='$con_fecha_factura'
									WHERE factura_id=$factura_id";	
							$this -> query($update,$Conex,true);		  
						
							if(strlen($this -> GetError()) > 0){
								$this -> Rollback($Conex);
								$facturas_mal++;
							}else{		
								$this -> Commit($Conex);
								$facturas_ok++;
							}  
						}  
			
					}else{
						exit("No es posible contabilizar");
					}



				}elseif($id_p[1]=='PAGO'){
					$abono_factura_id=$id_p[0];
					
					$this -> Begin($Conex);
					$select 	= "SELECT a.abono_factura_id,
									  a.valor_abono_factura,
									  a.ingreso_abono_factura,
									  a.fecha,
									  a.num_cheque,
									  a.cuenta_tipo_pago_id,
									  a.concepto_abono_factura,
									  (SELECT tercero_id  FROM  cliente WHERE cliente_id=a.cliente_id) AS tercero,
									  (SELECT puc_id  FROM cuenta_tipo_pago  WHERE cuenta_tipo_pago_id=a.cuenta_tipo_pago_id) AS puc_contra,
									  a.tipo_documento_id 					  
								FROM abono_factura a WHERE a.abono_factura_id=$abono_factura_id";	
					$result 	= $this -> DbFetchAll($select,$Conex); 
			
					$encabezado_registro_id	= $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);	
					$tipo_documento_id		= $result[0]['tipo_documento_id'];	
					$valor					= $result[0]['valor_abono_factura'];
					$numero_soporte			= $result[0]['concepto_abono_factura'];	
					$tercero_id				= $result[0]['tercero'];
					$periodo_contable_id	= $periodoContable;
					$mes_contable_id		= $mesContable;
					$fecha					= $result[0]['fecha'];
					$num_cheque				= $result[0]['num_cheque']!='' ? "'".$result[0]['num_cheque']."'":'NULL';
					$concepto				= $result[0]['concepto_abono_factura'];
					$puc_id					= $result[0]['puc_contra'];
					$fecha_registro			= date("Y-m-d H:m");
					$numero_documento_fuente= $result[0]['abono_factura_id'];
					$id_documento_fuente	= $result[0]['abono_factura_id'];
					$con_fecha_abono_factura= $fecha_registro;	
					$cuenta_tipo_pago_id	= $result[0][cuenta_tipo_pago_id];
			
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
			
					$select_item = "SELECT item_abono_id FROM item_abono WHERE abono_factura_id=$abono_factura_id";
					$result_item = $this -> DbFetchAll($select_item,$Conex);	
					
					foreach($result_item as $result_items){
			
						$imputacion_contable_id	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
						$insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
										SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_abono,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_abono+cre_item_abono),base_abono,porcentaje_abono,
										formula_abono,deb_item_abono,cre_item_abono
										FROM item_abono WHERE abono_factura_id=$abono_factura_id AND item_abono_id=$result_items[item_abono_id]"; 
						$this -> DbFetchAll($insert_item,$Conex);
					}
					if(strlen($this -> GetError()) > 0){
						$this -> Rollback($Conex);
						$pagos_mal++;

					}else{		
					
						$update = "UPDATE abono_factura SET encabezado_registro_id=$encabezado_registro_id,	
									estado_abono_factura= 'C',
									con_usuario_id = $usuario_id,
									con_fecha_abono_factura='$con_fecha_abono_factura'
								WHERE abono_factura_id =$abono_factura_id";	
						$this -> query($update,$Conex);		  
					
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
			return 'Facturas Contabilizadas: '.$facturas_ok.'<br>'.'Facturas NO Contabilizadas: '.$facturas_mal.'<br>'.'Pagos Contabilizadas: '.$pagos_ok.'<br>'.'Pagos NO Contabilizadas: '.$pagos_mal.'<br>';
		}else{
			exit("No se selecciono Ningun Registro");	
		}
	}


}
	
?>
