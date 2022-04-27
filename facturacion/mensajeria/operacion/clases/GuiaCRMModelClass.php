<?php
require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class GuiaCRMModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
	public function Save($Campos,$oficina_id,$empresa_id,$modifica,$usuario_id,$Conex){
		$guia_id = $this -> DbgetMaxConsecutive("guia","guia_id",$Conex,false,1);
		$this -> assignValRequest('guia_id',$guia_id);
		$this -> assignValRequest('oficina_id',$oficina_id);
		$this -> assignValRequest('estado_mensajeria_id',1);
		$this -> assignValRequest('crm',1);
		$this -> assignValRequest('facturado',1);
		$this -> assignValRequest('usuario_id',$usuario_id);
		$this -> assignValRequest('valor_manejo',0);
		$prefijo = $_REQUEST['prefijo'];
		$fecha_guia =$_REQUEST['fecha_guia'];
		$valor_total =$this -> requestDataForQuery('valor_total','numeric');
		
		 $remitente_id =$_REQUEST['remitente_id'];
		 $doc_remitente =$_REQUEST['doc_remitente'];
		 $remitente =$_REQUEST['remitente'];
		 $direccion_remitente =$_REQUEST['direccion_remitente'];
		 $telefono_remitente =$_REQUEST['telefono_remitente'];
		 $correo_remitente =$_REQUEST['correo_remitente'];
		 $origen_id =$_REQUEST['origen_id'];
		
		 $destinatario_id =$_REQUEST['destinatario_id'];
		 $doc_destinatario =$_REQUEST['doc_destinatario'];
		 $destinatario =$_REQUEST['destinatario'];
		 $direccion_destinatario =$_REQUEST['direccion_destinatario'];
		 $telefono_destinatario =$_REQUEST['telefono_destinatario'];
		 $correo_destinatario =$_REQUEST['correo_destinatario'];
		 $destino_id =$_REQUEST['destino_id'];
		 
		$this -> Begin($Conex);	
		
		if(($remitente_id=='NULL' || $remitente_id=='') && $doc_remitente>0){
			
			 
			 $remitente_destinatario_id = $this -> DbgetMaxConsecutive("remitente_destinatario","remitente_destinatario_id",$Conex,false,1);
			 $insert = "INSERT INTO remitente_destinatario (remitente_destinatario_id,numero_identificacion,tipo_identificacion_id,nombre,direccion,telefono,correo_remitente,ubicacion_id,tipo,estado,guia)
						VALUES ($remitente_destinatario_id,$doc_remitente,1,'$remitente','$direccion_remitente','$telefono_remitente','$correo_remitente',$origen_id,'R','D',1)";
			 $this -> query($insert,$Conex,true);  
			 $this -> assignValRequest('remitente_id',$remitente_destinatario_id);

			
		}elseif($remitente_id>0){
			 $update = "UPDATE remitente_destinatario SET nombre='$remitente', direccion='$direccion_remitente',telefono='$telefono_remitente',correo_remitente='$correo_remitente',ubicacion_id= $origen_id
			 	WHERE remitente_destinatario_id=$remitente_id";
			 $this -> query($update,$Conex,true); 

		}
		
		if(($destinatario_id=='NULL' || $destinatario_id=='') && $doc_destinatario>0){
			 
			 $remitente_destinatario_id = $this -> DbgetMaxConsecutive("remitente_destinatario","remitente_destinatario_id",$Conex,false,1);
			 $insert = "INSERT INTO remitente_destinatario (remitente_destinatario_id,numero_identificacion,tipo_identificacion_id,nombre,direccion,telefono,correo_destinatario,ubicacion_id,tipo,estado,guia)
						VALUES ($remitente_destinatario_id,$doc_destinatario,1,'$destinatario','$direccion_destinatario','$telefono_destinatario','$correo_destinatario',$destino_id,'D','D',1)";
			 $this -> query($insert,$Conex,true); 
			 $this -> assignValRequest('destinatario_id',$remitente_destinatario_id);
		}elseif($destinatario_id>0){
			 $update = "UPDATE remitente_destinatario SET nombre='$destinatario', direccion='$direccion_destinatario',telefono='$telefono_destinatario',correo_destinatario='$correo_destinatario' ,ubicacion_id= $destino_id
			 	WHERE remitente_destinatario_id=$destinatario_id";
			 $this -> query($update,$Conex,true); 
		
		}
		
		if($_REQUEST['numero_guia']>0){
			$numero_guia = $_REQUEST['numero_guia'];
			
			$select1 = "SELECT  guia_id FROM guia WHERE  numero_guia=$numero_guia AND prefijo='$prefijo'  AND manual=0 AND crm=1";//oficina_id = $oficina_id AND
			$result1 = $this -> DbFetchAll($select1,$Conex,true);
			if($result1[0]['guia_id']>0){ exit('Ya existe una la Guia CRM '.$numero_guia.' para esta oficina'); }
			
		}else{
			$select = "SELECT MAX(numero_guia) AS numero_guia FROM guia WHERE  manual=0 AND crm=1";//oficina_id = $oficina_id  AND
			$result = $this -> DbFetchAll($select,$Conex,true);
			$numero_guia = ($result[0]['numero_guia']+1);
		}
		
		$selectcom = "SELECT p.*, t.tipo_documento_id FROM rango_guia_crm p, tipo_bien_servicio_factura t WHERE p.tipo='C' AND  p.estado='A' AND t.tipo_bien_servicio_factura_id=p.tipo_bien_servicio_factura_id"; //p.oficina_id = $oficina_id AND
		$resultcom = $this -> DbFetchAll($selectcom,$Conex,true);					
	    $tercero_id=$resultcom[0]['tercero_id'];
		if(count($resultcom) > 1){
			exit('Existen mas de dos Parametros de Contados Activos para esta oficina');
		}elseif(count($resultcom)==0){
			exit('No Existe Parametro de Contado Activo para esta oficina');
		}
		

		if(is_numeric($numero_guia)){
			$select = "SELECT rango_guia_crm_fin,prefijo FROM rango_guia_crm WHERE tipo='C' AND  estado = 'A'";//oficina_id = $oficina_id AND
			$result = $this -> DbFetchAll($select,$Conex,true);
			$rango_guia_crm_fin = $result[0]['rango_guia_crm_fin'];
			$prefijo = $result[0]['prefijo'];

			// echo $numero_guia;
			if($numero_guia > $rango_guia_crm_fin){
				print 'El numero de Guia para esta oficina a superado el limite definido<br>debe actualizar el rango de Guias asignado para esta oficina !!!';
				return false;
			}
		}else{
			$select = "SELECT rango_guia_crm_ini, prefijo FROM rango_guia_crm WHERE tipo='C' AND  estado = 'A'"; //oficina_id = $oficina_id AND
			$result = $this -> DbFetchAll($select,$Conex,true);
			$rango_guia_crm_ini = $result[0]['rango_guia_crm_ini'];
			$prefijo = $result[0]['prefijo'];
			if(is_numeric($rango_guia_crm_ini)){
				$numero_guia = $rango_guia_crm_ini;
			}else{
				print 'Debe Definir un rango de Guias para la oficina!!!';
				return false;
			}
		}
		if($_REQUEST['tipo_servicio_mensajeria_id']!=2){
			$origen_id=$_REQUEST['origen_id'];
			$destino_id=$_REQUEST['destino_id'];

			if($origen_id==$destino_id){ 
				$tipo_envio_id=2;
			}else{
				$tipo_envio_id=$this -> getTipoEnvio1($destino_id,$Conex);
			}
			$tipo_envio_id=$tipo_envio_id>0 ? $tipo_envio_id : 'NULL';
			$this -> assignValRequest('tipo_envio_id',$tipo_envio_id);
		}
		$this -> assignValRequest('prefijo',$prefijo);
		$this -> assignValRequest('numero_guia',$numero_guia);
		$this -> assignValRequest('hora_guia',date('H:i:s'));
		
			$this -> DbInsertTable("guia",$Campos,$Conex,true,false);
			if($this -> GetNumError() > 0){
				return false;
			}else{

				if($resultcom[0]['tipo_bien_servicio_factura_id']>0){
					
					//inicio
					$cliente_id= $_REQUEST['cliente_id'];
					$tipo_bien_servicio_factura_id = $resultcom[0]['tipo_bien_servicio_factura_id'];
					$select_centro 	 = "SELECT centro_de_costo_id FROM centro_de_costo  WHERE oficina_id=$oficina_id";
					$result_centro 	 = $this -> DbFetchAll($select_centro,$Conex,false);
					$centro_de_costo_id = $result_centro[0][centro_de_costo_id];
					$cliente_id='NULL';
				
					$total_pagar= 0;
					$total_liqui= 0;
					$parcial='';
					$valor_liqui='';
					$subtotal=$valor_total;
					$valor_comp=$valor_total;
			
					$select_com  = "SELECT COUNT(*) AS num_cuentas 
							 FROM codpuc_bien_servicio_factura  c
							 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.tercero_bien_servicio_factura=1 AND c.activo=1 ";
					
					$result_com = $this -> DbFetchAll($select_com,$Conex);
			
					$select  = "SELECT  c.despuc_bien_servicio_factura,
							  c.natu_bien_servicio_factura,
							  c.contra_bien_servicio_factura,
							  c.tercero_bien_servicio_factura,
							  c.ret_tercero_bien_servicio_factura,
							  c.reteica_bien_servicio_factura,
							  c.aplica_ingreso,
							  c.puc_id,
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
							 FROM codpuc_bien_servicio_factura  c
							 WHERE c.tipo_bien_servicio_factura_id=$tipo_bien_servicio_factura_id AND c.ret_tercero_bien_servicio_factura!=1 AND c.activo=1 ORDER BY c.contra_bien_servicio_factura ASC, c.aplica_ingreso ASC ";
			
					$result = $this -> DbFetchAll($select,$Conex,true);
					$residual=0;
					if($result_com[0][num_cuentas]>0){
						exit('No se permite parametrizar la guia contado/contraentrega con un tipo de servicio configurado para Tercero');	
					}else{
						//CUANDO NO EXISTE CONFIGURACION PARA TERCEROS 

						foreach($result as $resultado){
							 $debito	= '';
							 $credito	= '';
							 $ingresa	= 0;
							 $descripcion	= '';
							 $descripcion	= $resultado[puc_nombre];			 
							
							 if(($resultado[porcentaje]=='' || $resultado[porcentaje]==NULL) && $resultado[contra_bien_servicio_factura]!=1 && $resultado[tercero_bien_servicio_factura]!=1 && $resultado[ret_tercero_bien_servicio_factura]!=1 && $resultado[aplica_ingreso]!=1){
								 
									$parcial	= $subtotal;
									$residual	= $parcial;
									$valor_liqui= $subtotal;
									$base		= 'NULL';
									$porcentaje	= 'NULL';
									$formula	= '';
									$ingresa	= 1;

							 }elseif($resultado[porcentaje]>0 && $resultado[contra_bien_servicio_factura]!=1 && $resultado[tercero_bien_servicio_factura]!=1 && $resultado[ret_tercero_bien_servicio_factura]!=1 && $resultado[aplica_ingreso]!=1 &&  $resultado[monto]<=$valor_comp && (($resultado[exento]=='RT' && $resultado[autorete]=='N' ) || ($resultado[exento]=='IC' && $resultado[retei]=='N') || ($resultado[exento]=='CR' && $resultado[renta]=='N') || ($resultado[exento]=='NN')) ){
							
									 $base		= $subtotal;
									 $formula	= $resultado[formula];
									 $porcentaje= $resultado[porcentaje];
									 $calculo 	= str_replace("BASE",$base,$formula);
									 $calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
									 $select1   = "SELECT $calculo AS valor_total";
									 $result1   = $this -> DbFetchAll($select1 ,$Conex);
									 $parcial 	= round($result1[0]['valor_total']);
									 $valor_liqui= round($result1[0]['valor_total']);
									 $ingresa	= 1;
							
							 }elseif($resultado[contra_bien_servicio_factura]==1 && $resultado[tercero_bien_servicio_factura]!=1 && $resultado[ret_tercero_bien_servicio_factura]!=1 && $resultado[aplica_ingreso]!=1 ){
									$parcial	= $total_pagar;
									$valor_liqui= $total_liqui;
									$base		= 'NULL';
									$porcentaje	= 'NULL';
									$formula	= '';	
									$puc_idcon	= $resultado[puc_id];
									$ingresa	= 1;
							
							 }elseif($resultado[porcentaje]>0 && $resultado[contra_bien_servicio_factura]!=1 && $resultado[tercero_bien_servicio_factura]!=1 && $resultado[ret_tercero_bien_servicio_factura]!=1 && $resultado[aplica_ingreso]==1 &&  $residual>0 && (($resultado[exento]=='RT' && $resultado[autorete]=='N' ) || ($resultado[exento]=='IC' && $resultado[retei]=='N') || ($resultado[exento]=='CR' && $resultado[renta]=='N') || ($resultado[exento]=='NN')) ){
								 
								 $base		= $residual;
								 $formula	= $resultado[formula];
								 $porcentaje= $resultado[porcentaje];
								 $calculo 	= str_replace("BASE",$base,$formula);
								 $calculo 	= str_replace("PORCENTAJE",$porcentaje,$calculo);		  
								 $select2   = "SELECT $calculo AS valor_total";
								 $result2   = $this -> DbFetchAll($select2 ,$Conex);
								 $parcial 	= round($result2[0]['valor_total']);
			
								 $ingresa	= 1;
								 
							 }
							 
							 
							 if($resultado[tercero_bien_servicio_factura]!=1 && $resultado[ret_tercero_bien_servicio_factura]!=1  && $ingresa==1 &&  $resultado[contra_bien_servicio_factura]!=1 ){
							
								 if($resultado[natu_bien_servicio_factura]=='D' && $resultado[contra_bien_servicio_factura]!=1){
									 $total_pagar	= $total_pagar+$parcial;
									 $total_liqui	= $total_liqui+$valor_liqui;					 
									 $debito		= number_format(abs($parcial),2,'.','');		 
									 $credito		= '0.00';
									 
								 }elseif($resultado[natu_bien_servicio_factura]=='C' && $resultado[contra_bien_servicio_factura]!=1){
									 $total_pagar	= $total_pagar-$parcial;
									 $total_liqui	= $total_liqui-$valor_liqui;					 
									 $debito		= '0.00';
									 $credito		= number_format(abs($parcial),2,'.','');			 
								 }elseif($resultado[natu_bien_servicio_factura]=='D' && $resultado[contra_bien_servicio_factura]==1){
									 $debito		= number_format(abs($parcial),2,'.','');	 
									 $credito		= '0.00';
								 }elseif($resultado[natu_bien_servicio_factura]=='C' && $resultado[contra_bien_servicio_factura]==1){	 
									 $debito		= '0.00';
									 $credito		= number_format(abs($parcial),2,'.','');			 
								 }
								 
								 $detalle_guia_puc_id 	= $this -> DbgetMaxConsecutive("detalle_guia_puc","detalle_guia_puc_id",$Conex,true,1);
								 $centro_costo = $resultado[puc_centro]==1 ? $centro_de_costo_id : 'NULL';
								 $tercero = $resultado[puc_tercero]==1 ? $tercero_id : 'NULL';
								 $valor_liqui = number_format(abs($valor_liqui),2,'.','');
								 
								 $insert = "INSERT INTO detalle_guia_puc (detalle_guia_puc_id,guia_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,debito,credito,valor_liquida,contra)
											VALUES ($detalle_guia_puc_id,$guia_id,$resultado[puc_id],$tercero,IF($tercero>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero),NULL),IF($tercero>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),$base,$porcentaje,'$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
								 $this -> query($insert,$Conex,true); 
							
							}elseif($resultado[tercero_bien_servicio_factura]!=1 && $resultado[ret_tercero_bien_servicio_factura]!=1  && $ingresa==1 &&  $resultado[contra_bien_servicio_factura]==1){
			
								 if($resultado[natu_bien_servicio_factura]=='D' && $resultado[contra_bien_servicio_factura]!=1){
									 $debito		= number_format(round(abs($parcial)),2,'.','');
									 $credito		= '0.00';
									 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');	
									 
								 }elseif($resultado[natu_bien_servicio_factura]=='C' && $resultado[contra_bien_servicio_factura]!=1){
									 $debito		= '0.00';
									 $credito		= number_format(round(abs($parcial)),2,'.','');			
									 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');	
									 
								 }elseif($resultado[natu_bien_servicio_factura]=='D' && $resultado[contra_bien_servicio_factura]==1){
									 $debito		= number_format(round(abs($parcial)),2,'.','');	 
									 $credito		= '0.00';
									 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');	
									 
								 }elseif($resultado[natu_bien_servicio_factura]=='C' && $resultado[contra_bien_servicio_factura]==1){	 
									 $debito		= '0.00';
									 $credito		= number_format(round(abs($parcial)),2,'.','');	
									 $valor_liqui	= number_format(round(abs($parcial)),2,'.','');	
									 
								 }
								 
								 $select_ter_emp  = "SELECT tercero_id FROM empresa WHERE empresa_id=$empresa_id";
								 $result_ter_emp = $this -> DbFetchAll($select_ter_emp,$Conex);
			
								 $detalle_guia_puc_id 	= $this -> DbgetMaxConsecutive("detalle_guia_puc","detalle_guia_puc_id",$Conex,true,1);
								 $centro_costo = $resultado[puc_centro]==1 ? $centro_de_costo_id : 'NULL';
								 $tercero_1 = $resultado[puc_tercero]==1 ? $result_ter_emp[0][tercero_id] : 'NULL';
								 $valor_liqui = number_format(round(abs($valor_liqui)),2,'.','');
								 
								 $insert = "INSERT INTO detalle_guia_puc (detalle_guia_puc_id,guia_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura,porcentaje_factura,formula_factura,desc_factura,debito,credito,valor_liquida,contra)
											VALUES ($detalle_guia_puc_id,$guia_id,$resultado[puc_id],$tercero_1,IF($tercero_1>0,(SELECT numero_identificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),IF($tercero_1>0,(SELECT digito_verificacion FROM tercero WHERE tercero_id=$tercero_1),NULL),$centro_costo,IF($centro_costo>0,(SELECT codigo  FROM centro_de_costo  WHERE centro_de_costo_id=$centro_costo),NULL),$base,$porcentaje,'$formula','$descripcion','$debito','$credito','$valor_liqui',$resultado[contra_bien_servicio_factura])";
								 $this -> query($insert,$Conex,true);
			
							}
						} 
						
						include_once("UtilidadesContablesModelClass.php");
						$utilidadesContables = new UtilidadesContablesModel(); 	 		
						
						$encabezado_registro_id	   = $this -> DbgetMaxConsecutive("encabezado_de_registro","encabezado_registro_id",$Conex,true,1);
						$tipo_documento_id         = $resultcom[0]['tipo_documento_id'];	
						$fecha					   = $fecha_guia;		
	    				$fechaMes                  = substr($fecha,0,10);	
	    				$periodo_contable_id       = $utilidadesContables -> getPeriodoContableId($fechaMes,$Conex);
	    				$mes_contable_id           = $utilidadesContables -> getMesContableId($fechaMes,$periodo_contable_id,$Conex);
						$consecutivo			   = $numero_guia;

						$concepto				= 'GUIA CONTADO '.$numero_guia.' '.$numero_soporte;
						$puc_id					= $puc_idcon;
						$fecha_registro			= date("Y-m-d H:i");
						

						
						$insert="INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
											mes_contable_id,consecutivo,fecha,concepto,puc_id,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
											VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor_total','$numero_guia',$tercero_id,$periodo_contable_id,
											$mes_contable_id,$consecutivo,'$fecha','$concepto',NULL,'C','$fecha_registro','$modifica',$usuario_id,'$numero_guia',$guia_id)"; 
						$this -> query($insert,$Conex,true);  
						

						$select_item      = "SELECT detalle_guia_puc_id FROM detalle_guia_puc WHERE guia_id=$guia_id";
						$result_item      = $this -> DbFetchAll($select_item,$Conex);
						foreach($result_item as $result_items){
						  $imputacion_contable_id 	= $this -> DbgetMaxConsecutive("imputacion_contable","imputacion_contable_id",$Conex,true,1);
						  $insert_item ="INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,
						  centro_de_costo_id,codigo_centro_costo,valor,base,porcentaje,formula,debito,credito)
						  SELECT $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura,$encabezado_registro_id,centro_de_costo_id,
						  codigo_centro_costo,(debito+credito),base_factura,porcentaje_factura,
						  formula_factura,debito,credito
						  FROM detalle_guia_puc WHERE guia_id=$guia_id AND detalle_guia_puc_id=$result_items[detalle_guia_puc_id]"; 
						  $this -> query($insert_item,$Conex);
						}
						$update = "UPDATE guia SET encabezado_registro_id=$encabezado_registro_id
								WHERE guia_id=$guia_id";	
						$this -> query($update,$Conex,true);		  
						

					}
			
					//fin
					
				}

			}
		$this -> Commit($Conex);
		return $numero_guia;  
	}
  public function Update($oficina_id,$Campos,$Conex){
	$this -> Begin($Conex);	
	    $guia_id = $_REQUEST['guia_id'];
		$this -> assignValRequest('valor_manejo',0);
		$this -> DbUpdateTable("guia",$Campos,$Conex,true,false);
		if($this -> GetNumError() > 0){
			return false;
		}else{		   
		    if($this -> GetNumError() > 0){
			  return false;
		    }		  
		}		
	$this -> Commit($Conex);
  }  

  public function Delete($Campos,$Conex){	  
	$this -> Begin($Conex);	
		$guia_id  = $this -> requestDataForQuery('guia_id','integer');		
//		$delete     = "DELETE FROM contacto_guia WHERE guia_id = $guia_id"; 
//		$this -> query($delete,$Conex);		
		$delete     = "DELETE FROM detalle_guia WHERE guia_id = $guia_id"; 
		$this -> query($delete,$Conex);		
		$this -> DbDeleteTable("guia",$Campos,$Conex,true,false);		
	$this -> Commit($Conex);
  }
  
  public function cancellation($guia_id,$causal_anulacion_id,$observacion_anulacion,$usuario_anulo_id,$Conex){  

	$select = "SELECT estado_mensajeria_id FROM guia WHERE guia_id = $guia_id";
	$result = $this -> DbFetchAll($select,$Conex,true);
	if($result[0]['estado_mensajeria_id']!=1) exit('No se puede Anular Guias que no esten en Estado Alistamniento');

   $this -> Begin($Conex);  
     $update = "UPDATE guia SET estado_mensajeria_id = 8,causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE guia_id = $guia_id AND estado_mensajeria_id=1";	 
	 $this -> query($update,$Conex,true);	 
   $this -> Commit($Conex);  
  }    

//LISTA MENU

  public function chequear($oficina_id,$Conex){ 
     $select = "SELECT o.*,
				(SELECT t.tipo_identificacion_id FROM  tercero t, cliente c WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id)  AS tipo_identificacion_remitente_id,
	   			(SELECT CONCAT_WS(' ',t.razon_social,t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) FROM tercero t, cliente c WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) AS remitente,
				(SELECT t.numero_identificacion FROM tercero t, cliente c WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) AS doc_remitente,
				IF(o.cliente_id>0,o.direccion, (SELECT t.direccion FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS direccion_remitente,
				IF(o.cliente_id>0,o.telefono,(SELECT t.telefono FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS telefono_remitente,
				IF(o.cliente_id>0,o.ubicacion_id, (SELECT t.ubicacion_id FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS origen_id,				  				
			    IF(o.cliente_id>0,(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.ubicacion_id), (SELECT (SELECT nombre FROM ubicacion WHERE ubicacion_id=t.ubicacion_id) FROM tercero t, cliente c  WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) ) AS origen			  

	 FROM oficina o WHERE o.oficina_id = $oficina_id ";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  


  public function GetPrefijo($Conex){ 
  	
		$select = "SELECT rango_guia_crm_fin, prefijo FROM rango_guia_crm WHERE tipo='C' AND  estado = 'A'";//oficina_id = $oficina_id AND
		$result = $this -> DbFetchAll($select,$Conex,true);
		$prefijo = $result[0]['prefijo'];
		return $prefijo;    
  }  


  public function getCalcularTarifaCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria_cliente
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id AND cliente_id=$cliente_id
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularTarifa($tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_mensajeria
	 WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id 
	 AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularTarifaMasivoCliente($cliente_id,$tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_masivo_cliente WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id  AND cliente_id=$cliente_id
	  AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getCalcularTarifaMasivo($tipo_servicio_mensajeria_id,$tabla,$tipo_envio_id,$anio,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_masivo WHERE tipo_envio_id = $tipo_envio_id AND tipo_servicio_mensajeria_id = $tipo_servicio_mensajeria_id 
	  AND periodo=(SELECT periodo_contable_id FROM periodo_contable WHERE anio=$anio LIMIT 1)";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  
	
   public function getCalcularTarifaEspecial($tipo_servicio_mensajeria_id,$origen_id,$destino_id,$Conex,$oficina_id){ 
  	
     $select = "SELECT * FROM tarifas_especiales WHERE   origen_id=$origen_id AND destino_id = $destino_id AND tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = true);
	 return $result;    
  } 

  public function getCalcularCosto($destino_id,$anio,$Conex,$oficina_id){ 
     $select = "SELECT * FROM tarifas_destino WHERE ubicacion_id = $destino_id AND periodo=$anio";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result;    
  }  

  public function getTipoEnvio1($origen_id,$destino_id,$Conex){ 
     /*$select = "SELECT tipo_envio_id FROM ubicacion WHERE ubicacion_id = $destino_id";*/
     $select ="SELECT tipo_envio_id FROM tarifas_especiales WHERE origen_id=$origen_id AND destino_id=$destino_id";
	 $result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	 return $result[0]['tipo_envio_id'];    
  }  


//BUSQUEDA
  public function selectGuia($Conex){  
    $guia_id  = $this -> requestDataForQuery('guia_id','integer');
	$dataGuia = array();    				
    $select = "SELECT r.*,
	(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM remitente_destinatario WHERE remitente_destinatario_id = r.remitente_id AND remitente_destinatario_id = r.destinatario_id)) AS cliente,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino FROM guia r WHERE r.guia_id = $guia_id";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false); 
	$dataGuia[0]['guia'] = $result;	
	return $dataGuia;
  }
  
  public function selectGuiaComplemento($numero_guia,$Conex){	  
	$dataGuia = array();    				
    $select = "SELECT r.*,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = 
	(SELECT tercero_id FROM remitente_destinatario WHERE remitente_destinatario_id = r.remitente_id AND remitente_destinatario_id = r.destinatario_id)) AS cliente,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino FROM guia r WHERE TRIM(r.numero_guia) = TRIM('$numero_guia')";				
	$result = $this -> DbFetchAll($select,$Conex,$ErrDb = false);
	$guia_id                         = $result[0]['guia_id'];	
	$result[0]['guia_id']            = null;
	$result[0]['numero_guia']  		 = $result[0]['numero_guia'];
//	$result[0]['numero_guia_padre']  = null;						
	$dataGuia[0]['guia']             = $result;	
	return $dataGuia;
  }    
  
//////////////////////////////////////////

  public function getClientes($oficina_id,$Conex){
	  

	  $select1 = "SELECT cliente_id 
	  FROM oficina WHERE oficina_id = $oficina_id";
	  $result1 = $this -> DbFetchAll($select1,$Conex);

	  if($result1[0][cliente_id]>0){
		  $cliente_id=$result1[0][cliente_id];
		  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)
		   															  
		  FROM tercero WHERE tercero_id = c.tercero_id) AS text, $cliente_id AS selected		 FROM cliente c WHERE estado = 'D' AND   cliente_id= $cliente_id ORDER BY nombre_cliente ASC";
		  $result = $this -> DbFetchAll($select,$Conex);
	
	  }else{
		  $select = "SELECT cliente_id AS value,(SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) 
		  FROM tercero WHERE tercero_id = c.tercero_id) AS text FROM cliente c WHERE estado = 'D'   ORDER BY nombre_cliente ASC";
		  $result = $this -> DbFetchAll($select,$Conex);
	  }
	  return $result;	  
	  
  }

    public function GetTipoEnvio($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_envio_id AS value,nombre AS text FROM tipo_envio WHERE tipo_envio_id IN (1,3) ORDER BY nombre ASC",$Conex,false);
    return $result;
  }

   public function GetTipoMedida($Conex){
	$result = $this -> DbFetchAll("SELECT medida_id AS value,medida AS text, '38' AS selected FROM medida WHERE mensajeria=1 ORDER BY medida ASC",$Conex,false);
    return $result;
  }
    public function GetTipoServicio($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_servicio_mensajeria_id AS value,nombre AS text FROM tipo_servicio_mensajeria WHERE guia=1 AND tipo_servicio_mensajeria_id IN(5,7) ORDER BY nombre ASC",$Conex,false);
    return $result;
  }  
/*
    public function GetClaseServicio($Conex){
	$result = $this -> DbFetchAll("SELECT clase_servicio_mensajeria_id AS value,nombre AS text FROM clase_servicio_mensajeria ORDER BY nombre ASC",$Conex,false);
    return $result;
  }*/  
  
    public function GetEstadoMensajeria($Conex){
	$result = $this -> DbFetchAll("SELECT estado_mensajeria_id AS value,nombre_estado AS text FROM estado_mensajeria ORDER BY nombre_estado ASC",$Conex,false);
    return $result;
  }   

    public function GetMotivoDevolucion($Conex){
	$result = $this -> DbFetchAll("SELECT motivo_devolucion_id AS value,nombre AS text FROM motivo_devolucion ORDER BY nombre ASC",$Conex,false);
    return $result;
  } 
  
    public function GetFormaPago($Conex){
	$result = $this -> DbFetchAll("SELECT forma_pago_mensajeria_id AS value,nombre AS text FROM forma_pago_mensajeria ORDER BY nombre ASC",$Conex,false);
    return $result;
  }     
  
    public function GetTipoIdentificacion($Conex){
	$result = $this -> DbFetchAll("SELECT tipo_identificacion_id AS value, nombre AS text FROM tipo_identificacion ORDER BY nombre ASC",$Conex,false);
    return $result;
  }   

   public function getTabla($tipo_servicio_mensajeria_id,$Conex){	   
	  $select = "SELECT tabla FROM  tipo_servicio_mensajeria   WHERE tipo_servicio_mensajeria_id=$tipo_servicio_mensajeria_id";
	  $result = $this -> DbFetchAll($select,$Conex);	
	  return $result;
   
   }

   public function selectTipoEnvio($TipoServicioId,$Conex){	   
	   if($TipoServicioId == 1){
	      $select = "SELECT tm.tipo_envio_id AS value, nombre AS text FROM tipo_envio tm WHERE tm.tipo_envio_id IN (1,3)";
	      $result = $this -> DbFetchAll($select,$Conex);	
	   }
	    elseif($TipoServicioId == 2){
		      // $select = "SELECT tc.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tc.tipo_envio_id) AS text FROM tarifas_carga tc";
	           $select = "SELECT tm.tipo_envio_id AS value, nombre AS text FROM tipo_envio tm WHERE tm.tipo_envio_id IN (1,3)";
			   $result = $this -> DbFetchAll($select,$Conex);		
		}
		 else{
			 $select = "SELECT te.tipo_envio_id AS value, nombre AS text FROM tipo_envio te WHERE te.tipo_envio_id IN (1,3)";
	         $result = $this -> DbFetchAll($select,$Conex);	
	     }		 
	   return $result;	   
   }  
  
   public function selectTipoEnvioSelected($TipoServicioId,$TipoEnvioId,$Conex){	   
	   if($TipoServicioId == 1){
	      $select = "SELECT tm.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tm.tipo_envio_id) AS text FROM tarifas_mensajeria tm";
	      $result = $this -> DbFetchAll($select,$Conex);	
	   }elseif($TipoServicioId == 2){
		       //$select = "SELECT tc.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tc.tipo_envio_id) AS text FROM tarifas_carga tc";
		       $select = "SELECT tm.tipo_envio_id AS value,(SELECT nombre FROM tipo_envio WHERE tipo_envio_id = tm.tipo_envio_id) AS text FROM tarifas_mensajeria tm";
	           $result = $this -> DbFetchAll($select,$Conex);		
		}else{
			 $select = "SELECT tco.tipo_envio_id AS value,(SELECT nombre FROM convencion WHERE convencion_id = tco.tipo_envio_id) AS text FROM tarifas_correo_24_horas tco";
	         $result = $this -> DbFetchAll($select,$Conex);	
	    }		 
	   return $result;	 	   
   }  

  public function selectDataRemitenteDestinatario($remitente_destinatario_id,$Conex){
  
    $select = "SELECT r.*,CONCAT_WS(' ',nombre,primer_apellido,segundo_apellido) AS remitente_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS ubicacion 
	FROM remitente_destinatario r WHERE remitente_destinatario_id 	= $remitente_destinatario_id";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  }

  public function selectDataRemitenteDestinatarioDoc($doc_remitente,$Conex){
  
    $select = "SELECT r.*,CONCAT_WS(' ',nombre,primer_apellido,segundo_apellido) AS remitente_destinatario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = r.ubicacion_id) AS ubicacion 
	FROM remitente_destinatario r WHERE numero_identificacion 	= $doc_remitente";
	
	$result = $this -> DbFetchAll($select,$Conex,true);
	
	return $result; 
  
  }

  
   public function getCausalesAnulacion($Conex){		
		$select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion ORDER BY nombre";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
    }  

   public function GetCiudad($oficina_id,$Conex){		
		$select = "SELECT u.ubicacion_id ,u.nombre FROM oficina o, ubicacion u WHERE o.oficina_id=$oficina_id AND u.ubicacion_id=o.ubicacion_id ";
		$result = $this -> DbFetchAll($select,$Conex);		
		return $result;				
    }  

//////////////////////////////////////////
//// GRID ////
  public function getQueryGuiaOficinasGrid($oficina_id){
     $Query = "SELECT CONCAT_WS('',r.prefijo,r.numero_guia) AS guia,
	 			r.orden_despacho,
				r.fecha_guia,
				(SELECT nombre FROM ubicacion WHERE ubicacion_id=r.origen_id) AS origen,
			  (SELECT nombre FROM ubicacion WHERE ubicacion_id=r.destino_id) AS destino,
			  r.remitente,
			  r.destinatario,
			  r.telefono_destinatario,
			  r.correo_destinatario,
			  r.direccion_destinatario,
			  r.correo_remitente,
			  r.referencia_producto,
			  r.cantidad,
			  r.peso,
			  r.peso_volumen,
			  r.observaciones,
			  (SELECT nombre_estado FROM estado_mensajeria WHERE estado_mensajeria_id = r.estado_mensajeria_id) AS estado
			  FROM guia r,  oficina o 
			  WHERE r.oficina_id = $oficina_id  AND r.oficina_id = o.oficina_id AND r.crm=1 ORDER BY r.numero_guia DESC LIMIT 0,300";	 
     return $Query;
  }
   
	
}

?>