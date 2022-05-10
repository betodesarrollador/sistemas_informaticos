<?php

require_once("../../../framework/clases/DbClass.php");
require_once("../../../framework/clases/PermisosFormClass.php");

final class OrdenCargueModel extends Db{

  private $Permisos;
  
  public function SetUsuarioId($usuario_id,$oficina_id){
	$this -> Permisos = new PermisosForm();
	$this -> Permisos -> SetUsuarioId($usuario_id,$oficina_id);
  }
  
  public function getPermiso($ActividadId,$Permiso,$Conex){
	return $this -> Permisos -> getPermiso($ActividadId,$Permiso,$Conex);
  }
  
    public function getTipoEmpaque($Conex){
  	
      $select = "SELECT empaque_id AS value,empaque AS text FROM empaque WHERE empaque_id IS NOT NULL ORDER BY empaque";  
	  $result =  $this -> DbFetchAll($select,$Conex,true);	
		
	return $result;	
	
  }
  
  public function Save($oficina_id,$Campos,$Conex){
	
    $select = "SELECT (MAX(consecutivo)+1) AS conse FROM orden_cargue WHERE oficina_id=$oficina_id";
    $result = $this -> DbFetchAll($select,$Conex);
	$consecutivo= $result[0][conse]>0 ? $result[0][conse]:1;

    $orden_cargue_id    = $this -> DbgetMaxConsecutive("orden_cargue","orden_cargue_id",$Conex,true,1);	
    $this -> assignValRequest('orden_cargue_id',$orden_cargue_id);
	$this -> assignValRequest('consecutivo',$consecutivo);
    $this -> Begin($Conex);
      $this -> DbInsertTable("orden_cargue",$Campos,$Conex,true,false);
    $this -> Commit($Conex);
    return array(array(orden_cargue_id=>$orden_cargue_id,consecutivo=>$consecutivo));
  }
  
  public function Update($Campos,$Conex){ 

    $this -> Begin($Conex);
     $this -> DbUpdateTable("orden_cargue",$Campos,$Conex,true,false);
    $this -> Commit($Conex);
	 
  }

  public function SaveRemesa($usuario_id,$usuarioNombres,$usuario_numero_identificacion,$Campos,$oficina_id,$empresa_id,$Conex){
	
	$this -> assignValRequest('usuario_id',$usuario_id);
    $this -> assignValRequest('usuario_registra',$usuarioNombres);
	$remesa_id     = $this -> DbgetMaxConsecutive("remesa","remesa_id",$Conex,false,1);		
	$numero_remesa = $this -> requestData('numero_remesa');

	$datos_poliza = $this -> getPoliza($empresa_id,$Conex);
	if($datos_poliza[0]['aseguradora_id']>0){
		$aseguradora_id = $datos_poliza[0]['aseguradora_id'];
		$numero_poliza = $datos_poliza[0]['numero'];
		$fecha_vencimiento_poliza = $datos_poliza[0]['fecha_vencimiento'];
		
	}else{
		exit('Por favor configure una P&oacute;liza para la empresa');	
	}

	$tipo_remesa_id=1;	
	$naturaleza_id=1;	
	$clase_remesa='NN';
	$fecha_remesa=date("Y-m-d");	
	$solicitud_id=$Campos[0]['solicitud_id']? "'".$Campos[0]['solicitud_id']."'" : 'NULL';
	$orden_cargue_id = $_REQUEST['orden_cargue_id'];
	$orden_despacho=$Campos[0]['orden_despacho']!=''? "'".$Campos[0]['orden_despacho']."'" : 'NULL';
	$cliente_id=$Campos[0]['cliente_id'];
	
	$propietario_mercancia_id=$Campos[0]['propietario_mercancia_id'];
	$propietario_mercancia= $Campos[0]['cliente_nit'].' - '.$Campos[0]['cliente'];
	$numero_identificacion_propietario_mercancia = $Campos[0]['cliente_nit'];
	$tipo_identificacion_propietario_mercancia=$Campos[0]['tipo_identificacion_propietario_mercancia'];
	
	$origen_id = $Campos[0]['origen_id'];	
	$destino_id = $Campos[0]['destino_id'];	
	
	$remitente_id = $Campos[0]['remitente_id'];	
	$remitente = $Campos[0]['remitente'];	
	$direccion_remitente= $Campos[0]['direccion_cargue'];	
	$telefono_remitente= $Campos[0]['telefono_remitente'];	
	$tipo_identificacion_remitente_id = $Campos[0]['tipo_identificacion_remitente_id'];
	$doc_remitente = $Campos[0]['doc_remitente'];
	$digito_verificacion_remitente = $Campos[0]['digito_verificacion_remitente']!='' ? $Campos[0]['digito_verificacion_remitente'] : 'NULL';
	
	$destinatario_id = $Campos[0]['destinatario_id'];
	$destinatario = $Campos[0]['destinatario'];	
	$direccion_destinatario= $Campos[0]['direccion_destinatario'];	
	$telefono_destinatario= $Campos[0]['telefono_destinatario'];
	$tipo_identificacion_destinatario_id = $Campos[0]['tipo_identificacion_destinatario_id'];
	$doc_destinatario = $Campos[0]['doc_destinatario'];
	$digito_verificacion_destinatario = $Campos[0]['digito_verificacion_destinatario']!='' ? $Campos[0]['digito_verificacion_destinatario'] : 'NULL';


	$producto_id = $Campos[0]['producto_id'];	
	$descripcion_producto = $Campos[0]['producto'];	
	$cantidad = $Campos[0]['cantidad_cargue']>0 ? $Campos[0]['cantidad_cargue'] : 0;
	$peso = $Campos[0]['peso']>0 ? $Campos[0]['peso'] : 0;
	$peso_volumen = $Campos[0]['peso_volumen']>0 ? $Campos[0]['peso_volumen'] : 0;
	$empaque_id = $Campos[0]['empaque_id'];
	$medida_id = $Campos[0]['medida_id']!='' ? $Campos[0]['medida_id']:39;
	
	$titular_manifiesto_id = $Campos[0]['tenedor_id'];
	$ciudad_titular_manifiesto_divipola =$Campos[0]['ciudad_titular_manifiesto_divipola'];
	$titular_manifiesto =$Campos[0]['tenedor'];
	$numero_identificacion_titular_manifiesto=$Campos[0]['numero_identificacion_tenedor'];
	$direccion_titular_manifiesto=$Campos[0]['direccion_tenedor'];
	$telefono_titular_manifiesto=$Campos[0]['telefono_tenedor'];	
	$telefono_titular_manifiesto=$Campos[0]['telefono_tenedor'];	
	$ciudad_titular_manifiesto=$Campos[0]['ciudad_tenedor'];	
	
	$placa_id=$Campos[0]['placa_id'];	
	$placa=$Campos[0]['placa'];	
	$propio=$Campos[0]['propio'];
	$placa_remolque_id=$Campos[0]['placa_remolque_id']!='' ? $Campos[0]['placa_remolque_id'] : 'NULL';
	
	$marca=$Campos[0]['marca'];
	$linea=$Campos[0]['linea'];
	$modelo=$Campos[0]['modelo']>0 ? $Campos[0]['modelo'] : 'NULL';
	$modelo_repotenciado=$Campos[0]['modelo_repotenciado']>0 ? $Campos[0]['modelo_repotenciado'] : 'NULL';
	$serie=$Campos[0]['serie'];
	$color=$Campos[0]['color'];
	$carroceria=$Campos[0]['carroceria'];
	$registro_nacional_carga=$Campos[0]['registro_nacional_carga'];
	$configuracion=$Campos[0]['configuracion'];
	$peso_vacio=$Campos[0]['peso_vacio'];
	$numero_soat=	$Campos[0]['numero_soat'];
	$nombre_aseguradora=	$Campos[0]['nombre_aseguradora'];
	$vencimiento_soat=	$Campos[0]['vencimiento_soat'];
	$placa_remolque =	$Campos[0]['placa_remolque'];
	$propietario =	$Campos[0]['propietario'];
	$conductor_id  = $Campos[0]['conductor_id'];
    $fecha  = $Campos[0]['fecha'];
    $fecha_recogida  = $Campos[0]['fecha'];
    

	$select_v = "SELECT (SELECT ti.codigo_ministerio   FROM tercero t, tipo_identificacion ti WHERE t.tercero_id=r.propietario_id AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS	tipo_identificacion_propietario_codigo,
			(SELECT ti.codigo_ministerio   FROM tenedor te, tercero t, tipo_identificacion ti WHERE te.tenedor_id=r.tenedor_id AND  t.tercero_id=te.tercero_id AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_identificacion_tenedor_codigo,
			(SELECT ti.codigo_ministerio   FROM conductor te, tercero t, tipo_identificacion ti WHERE te.conductor_id=$conductor_id AND  t.tercero_id=te.tercero_id AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_identificacion_conductor_codigo
				FROM vehiculo r WHERE r.placa_id = $placa_id ";
        $result_v = $this->DbFetchAll($select_v, $Conex, true);
        $tipo_identificacion_propietario_codigo = $result_v[0]['tipo_identificacion_propietario_codigo'];

        $numero_identificacion_propietario = $Campos[0]['numero_identificacion_propietario'];
        $direccion_propietario = $Campos[0]['direccion_propietario'];
        $telefono_propietario = $Campos[0]['telefono_propietario'];
        $ciudad_propietario = $Campos[0]['ciudad_propietario'];
        $tenedor = $Campos[0]['tenedor'];
        $tenedor_id = $Campos[0]['tenedor_id'];
        $tipo_identificacion_tenedor_codigo = $result_v[0]['tipo_identificacion_tenedor_codigo'];
        $numero_identificacion_tenedor = $Campos[0]['numero_identificacion_tenedor'];
        $direccion_tenedor = $Campos[0]['direccion_tenedor'];
        $telefono_tenedor = $Campos[0]['telefono_tenedor'];
        $ciudad_tenedor = $Campos[0]['ciudad_tenedor'];
        $tipo_identificacion_conductor_codigo = $result_v[0]['tipo_identificacion_conductor_codigo'];
        $numero_identificacion = $Campos[0]['numero_identificacion'];
        $numero_licencia_cond = $Campos[0]['numero_licencia_cond'];

        $nombre = $Campos[0]['nombre'];
        $direccion_conductor = $Campos[0]['direccion_conductor'];
        $telefono_conductor = $Campos[0]['telefono_conductor'];
        $ciudad_conductor = $Campos[0]['ciudad_conductor'];
        $categoria_licencia_conductor = $Campos[0]['categoria_licencia_conductor'];
        //$tipo_liquidacion = $Campos[0]['tipo_liquidacion'];

        if ($placa_remolque_id > 0) {
            $select_r = "SELECT (SELECT CONCAT_WS(' ',razon_social,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido)  FROM tercero WHERE tercero_id=r.propietario_id) AS propietario_remolque,
					(SELECT ti.codigo_ministerio   FROM tercero t, tipo_identificacion ti WHERE t.tercero_id=r.propietario_id AND ti.tipo_identificacion_id=t.tipo_identificacion_id) AS tipo_identificacion_propietario_remolque_codigo,
					(SELECT numero_identificacion FROM tercero WHERE tercero_id=r.propietario_id) AS 	numero_identificacion_propietario_remolque,
					(SELECT direccion FROM tercero WHERE tercero_id=r.propietario_id) AS 	direccion_propietario_remolque,
					(SELECT telefono FROM tercero WHERE tercero_id=r.propietario_id) AS 	telefono_propietario_remolque

					FROM remolque r WHERE r.placa_remolque_id = $placa_remolque_id ";
            $result_r = $this->DbFetchAll($select_r, $Conex, true);

            $propietario_remolque = "'" . $result_r[0]['propietario_remolque'] . "'";
            $tipo_identificacion_propietario_remolque_codigo = "'" . $result_r[0]['tipo_identificacion_propietario_remolque_codigo'] . "'";
            $numero_identificacion_propietario_remolque = "'" . $result_r[0]['numero_identificacion_propietario_remolque'] . "'";
            $direccion_propietario_remolque = "'" . $result_r[0]['direccion_propietario_remolque'] . "'";
            $telefono_propietario_remolque = "'" . $result_r[0]['telefono_propietario_remolque'] . "'";

        } else {
            $propietario_remolque = 'NULL';
            $tipo_identificacion_propietario_remolque_codigo = 'NULL';
            $numero_identificacion_propietario_remolque = 'NULL';
            $direccion_propietario_remolque = 'NULL';
            $telefono_propietario_remolque = 'NULL';

        }

        if ($solicitud_id > 0) {
            $select_p = "SELECT valor_facturar, valor_costo FROM solicitud_valores
				WHERE solicitud_id = $solicitud_id ORDER BY  fecha,  valores_solicitud_id DESC";
            $result_p = $this->DbFetchAll($select_p, $Conex, true);
        }else{
			$valor_facturar1 = $Campos[0]['valor_facturar'];
			$tipo_liquidacion = $Campos[0]['tipo_liquidacion'];
			$valor_unidad_facturar1 = $Campos[0]['valor_unidad_facturar'];
		}

        $valor_unidad_costo = intval($result_p[0]['valor_costo']) ? intval($result_p[0]['valor_costo']) : 0;
        $valor_unidad_facturar = intval($result_p[0]['valor_facturar']) ? intval($result_p[0]['valor_facturar']) : $valor_unidad_facturar1;

        $valor_costo = intval($result_p[0]['valor_costo']) ? intval($result_p[0]['valor_costo']) : 0;
        $valor_facturar = intval($result_p[0]['valor_facturar']) ? intval($result_p[0]['valor_facturar']) : $valor_facturar1;
        $valor_declarado_kilo = ($Campos[0]['valor_declarado'] / $Campos[0]['peso_declarado']);
        $valor_declarado = intval($peso * $valor_declarado_kilo);

        if (is_numeric($numero_remesa)) {

            $select = "SELECT rango_remesa_fin FROM rango_remesa WHERE oficina_id = $oficina_id AND estado = 'A'";
            $result = $this->DbFetchAll($select, $Conex, true);
            $rango_remesa_fin = $result[0]['rango_remesa_fin'];

            if ($numero_remesa > $rango_remesa_fin) {
                print 'El numero de remesa para esta oficina a superado el limite definido<br>debe actualizar el rango de RemesasMasivo asignado para esta oficina !!!';
                return false;
            }

        } else {

            $select = "SELECT MAX(numero_remesa) AS numero_remesa FROM remesa WHERE oficina_id = $oficina_id";
            $result = $this->DbFetchAll($select, $Conex, true);

            $numero_remesa = $result[0]['numero_remesa'];

            if (is_numeric($numero_remesa)) {

                $select = "SELECT rango_remesa_fin FROM rango_remesa WHERE oficina_id = $oficina_id AND estado = 'A'";
                $result = $this->DbFetchAll($select, $Conex, true);
                $rango_remesa_fin = $result[0]['rango_remesa_fin'];

                $numero_remesa += 1;

                if ($numero_remesa > $rango_remesa_fin) {
                    print 'El numero de remesa para esta oficina a superado el limite definido<br>debe actualizar el rango de RemesasMasivo asignado para esta oficina !!!';
                    return false;
                }

            } else {

                $select = "SELECT rango_remesa_ini FROM rango_remesa WHERE oficina_id = $oficina_id AND estado = 'A'";
                $result = $this->DbFetchAll($select, $Conex, true);
                $rango_remesa_ini = $result[0]['rango_remesa_ini'];

                if (is_numeric($rango_remesa_ini)) {

                    $numero_remesa = $rango_remesa_ini;

                } else {

                    print 'Debe Definir un rango de RemesasMasivo para la oficina!!!';
                    return false;

                }

            }

        }

        if($valor_facturar>0 || $valor_facturar1>0){
            $estado = 'LQ';
        }else{
            $estado = 'MF';
        }

        $this->Begin($Conex);

        $insert = "INSERT INTO remesa (remesa_id,oficina_id,solicitud_id,orden_cargue_id,orden_despacho,tipo_remesa_id,clase_remesa,
									   aseguradora_id,fecha_remesa,fecha_recogida_ss,hora_recogida_ss,numero_remesa,cliente_id,propietario_mercancia_id,
									   propietario_mercancia,tipo_identificacion_propietario_mercancia,numero_identificacion_propietario_mercancia,
								    	numero_poliza,fecha_vencimiento_poliza,origen_id,destino_id,remitente,remitente_id,tipo_identificacion_remitente_id,
										doc_remitente,digito_verificacion_remitente,direccion_remitente,telefono_remitente,
										destinatario,destinatario_id,tipo_identificacion_destinatario_id,doc_destinatario,digito_verificacion_destinatario,
										direccion_destinatario,telefono_destinatario,producto_id,descripcion_producto,peso,peso_volumen,naturaleza_id,empaque_id,
										medida_id,cantidad,tipo_liquidacion,valor_facturar,valor_costo,estado,usuario_id,usuario_registra,fecha_registro,valor,
										valor_unidad_facturar,valor_unidad_costo)

		VALUES   ($remesa_id,$oficina_id,$solicitud_id,$orden_cargue_id,'$orden_despacho',$tipo_remesa_id,'$clase_remesa',
				  $aseguradora_id,'$fecha_remesa','$fecha_recogida','04:00',$numero_remesa,$cliente_id,$propietario_mercancia_id,
				  '$propietario_mercancia','$tipo_identificacion_propietario_mercancia','$numero_identificacion_propietario_mercancia',
				  '$numero_poliza','$fecha_vencimiento_poliza',$origen_id,$destino_id,'$remitente',$remitente_id,$tipo_identificacion_remitente_id,
				  '$doc_remitente',$digito_verificacion_remitente,'$direccion_remitente','$telefono_remitente',
				  '$destinatario',$destinatario_id,$tipo_identificacion_destinatario_id,'$doc_destinatario',$digito_verificacion_destinatario,
				  '$direccion_destinatario','$telefono_destinatario',$producto_id,'$descripcion_producto',$peso,$peso_volumen,$naturaleza_id,$empaque_id,
				  $medida_id,$cantidad,'$tipo_liquidacion',$valor_facturar,$valor_costo,'$estado',$usuario_id,'$usuarioNombres','$fecha_remesa',$valor_declarado,
				  $valor_unidad_facturar,$valor_unidad_costo)";
        $this->query($insert, $Conex, true);
        if ($this->GetNumError() > 0) {
            return false;
        } else {

            if ($this->GetNumError() > 0) {
                return false;
            } else {

                $detalle_remesa_id = $this->DbgetMaxConsecutive("detalle_remesa", "detalle_remesa_id", $Conex, false, 1);
                $detalle_ss_id = $Campos[0]['detalle_ss_id'];
                $item = 1;
                $referencia_producto = '';
                $descripcion_producto = $descripcion_producto;
                $valor = $valor_declarado;
                $observaciones = 'Solicitud No: ' . $solicitud_id;

                $detalle_ss_id = is_numeric($detalle_ss_id) ? $detalle_ss_id : 'NULL';
                $orden_cargue_id = is_numeric($orden_cargue_id) ? $orden_cargue_id : 'NULL';

                $insert = "INSERT INTO detalle_remesa (detalle_remesa_id,remesa_id,detalle_ss_id,item,referencia_producto,
				  descripcion_producto,peso_volumen,peso,cantidad,valor,observaciones) VALUES
				  ($detalle_remesa_id,$remesa_id,$detalle_ss_id,$item,'$referencia_producto',
				  '$descripcion_producto',$peso_volumen,$peso,$cantidad,$valor,'$observaciones')";

                $this->query($insert, $Conex, true);

                if ($this->GetNumError() > 0) {
                    return false;
                } else {

                    if (is_numeric($detalle_ss_id)) {

                        $update = "UPDATE detalle_solicitud_servicio SET estado = 'R' WHERE detalle_ss_id = $detalle_ss_id";
                        $result = $this->query($update, $Conex);

                        if ($this->GetNumError() > 0) {
                            return false;
                        }

                    }

                    if (is_numeric($orden_cargue_id)) {

                        $update = "UPDATE orden_cargue SET estado = 'R' WHERE orden_cargue_id = $orden_cargue_id";
                        $result = $this->query($update, $Conex);

                        if ($this->GetNumError() > 0) {
                            return false;
                        }

                    }

                }

            }
            //manifiesto inicio
            $manifiesto_id = $this->DbgetMaxConsecutive("manifiesto", "manifiesto_id", $Conex, true, 1);
            $manifiesto = $this->getConsecutivoDespacho($oficina_id, $Conex);

            $select = "SELECT * FROM oficina WHERE oficina_id = $oficina_id";
            $result = $this->DbFetchAll($select, $Conex, true);

            $lugar_pago_saldo = $result[0]['direccion'];

            $select_o = "SELECT divipola FROM ubicacion	WHERE ubicacion_id = $origen_id";
            $result_o = $this->DbFetchAll($select_o, $Conex, true);
            $origen_divipola = $result_o[0]['divipola'];

            $select_d = "SELECT divipola FROM ubicacion	WHERE ubicacion_id = $destino_id";
            $result_d = $this->DbFetchAll($select_d, $Conex, true);
            $destino_divipola = $result_d[0]['divipola'];

            $insert = "INSERT INTO manifiesto (manifiesto_id,manifiesto,empresa_id,oficina_id,orden_cargue_id,tipo_manifiesto_id,modalidad,origen_id,origen_divipola,
											   destino_id,destino_divipola,cargue_pagado_por,descargue_pagado_por,titular_manifiesto_id,ciudad_titular_manifiesto_divipola,
											   titular_manifiesto,numero_identificacion_titular_manifiesto,direccion_titular_manifiesto,telefono_titular_manifiesto,
											   ciudad_titular_manifiesto,placa_id,placa,propio,placa_remolque_id,propietario_remolque,tipo_identificacion_propietario_remolque_codigo,
											   numero_identificacion_propietario_remolque,direccion_propietario_remolque, telefono_propietario_remolque,
											   fecha_mc,valor_flete,marca,linea,modelo,modelo_repotenciado,serie,color,carroceria,registro_nacional_carga,configuracion,peso_vacio,
											   numero_soat,nombre_aseguradora,vencimiento_soat,placa_remolque,propietario,tipo_identificacion_propietario_codigo,
											   numero_identificacion_propietario,direccion_propietario,telefono_propietario,ciudad_propietario,tenedor,
											   tenedor_id, tipo_identificacion_tenedor_codigo,numero_identificacion_tenedor,direccion_tenedor,telefono_tenedor,
											   ciudad_tenedor,conductor_id,tipo_identificacion_conductor_codigo,numero_identificacion,numero_licencia_cond,
											   nombre,direccion_conductor,telefono_conductor,ciudad_conductor,categoria_licencia_conductor,
											   saldo_por_pagar,valor_neto_pagar,usuario_id,usuario_registra,fecha_registro,usuario_registra_numero_identificacion,estado,oficina_pago_saldo_id,
											   lugar_pago_saldo,fecha_pago_saldo)

			VALUES   ($manifiesto_id,$manifiesto,$empresa_id,$oficina_id,$orden_cargue_id,1,'N',$origen_id, '$origen_divipola',
					  $destino_id,'$destino_divipola','E','E',$titular_manifiesto_id,'$ciudad_titular_manifiesto_divipola',
					  '$titular_manifiesto','$numero_identificacion_titular_manifiesto','$direccion_titular_manifiesto','$telefono_titular_manifiesto',
					  '$ciudad_titular_manifiesto',$placa_id,'$placa',$propio,$placa_remolque_id,$propietario_remolque,$tipo_identificacion_propietario_remolque_codigo,
					  $numero_identificacion_propietario_remolque,$direccion_propietario_remolque,$telefono_propietario_remolque,
					  '$fecha_remesa',$valor_costo,'$marca','$linea',$modelo,$modelo_repotenciado,'$serie','$color','$carroceria','$registro_nacional_carga','$configuracion','$peso_vacio',
					  '$numero_soat','$nombre_aseguradora','$vencimiento_soat','$placa_remolque','$propietario','$tipo_identificacion_propietario_codigo',
					  '$numero_identificacion_propietario','$direccion_propietario','$telefono_propietario','$ciudad_propietario','$tenedor',
					  $tenedor_id,'$tipo_identificacion_tenedor_codigo','$numero_identificacion_tenedor','$direccion_tenedor','$telefono_tenedor',
					  '$ciudad_tenedor',$conductor_id,'$tipo_identificacion_conductor_codigo','$numero_identificacion','$numero_licencia_cond',
					  '$nombre','$direccion_conductor','$telefono_conductor','$ciudad_conductor','$categoria_licencia_conductor',
					  $valor_costo,$valor_costo,$usuario_id,'$usuarioNombres','$fecha_remesa','$usuario_numero_identificacion','P',1,'SAMACA',ADDDATE(CURDATE(), INTERVAL 15 DAY))";
            $this->query($insert, $Conex, true);

            $insert_d = "INSERT INTO detalle_despacho (manifiesto_id,remesa_id) VALUES ($manifiesto_id,$remesa_id)";
            $this->query($insert_d, $Conex, true);

            $servicio_transporte_id = $this->DbgetMaxConsecutive("servicio_transporte", "servicio_transporte_id", $Conex, true, 1);
            $insert_s = "INSERT INTO servicio_transporte ( servicio_transporte_id,manifiesto_id,placa_id,conductor_id,placa_remolque_id)
						VALUES ($servicio_transporte_id,$manifiesto_id,$placa_id,$conductor_id,$placa_remolque_id)";
            $this->query($insert_s, $Conex, true);

            $tiempos_clientes_remesas_id = $this->DbgetMaxConsecutive("tiempos_clientes_remesas", "tiempos_clientes_remesas_id", $Conex, true, 1);

            $insert_t = "INSERT INTO tiempos_clientes_remesas (tiempos_clientes_remesas_id,manifiesto_id,placa_id,cliente_id)
					   VALUES ($tiempos_clientes_remesas_id,$manifiesto_id,$placa_id,$cliente_id)";

            $this->query($insert_t, $Conex, true);

            //manifiesto fin

        }

        $this->Commit($Conex);

        return array(numero_remesa => $numero_remesa, manifiesto => $manifiesto, remesa_id => $remesa_id, manifiesto_id => $manifiesto_id);
    }

    public function getConsecutivoDespacho($oficina_id, $Conex)
    {

        $select = "SELECT MAX(manifiesto) AS manifiesto FROM manifiesto WHERE oficina_id = $oficina_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $manifiesto = $result[0]['manifiesto'];

        $select = "SELECT MAX(despacho) AS despacho FROM despachos_urbanos WHERE oficina_id = $oficina_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $despacho = $result[0]['despacho'];

        if (!is_numeric($manifiesto) && !is_numeric($despacho)) {

            $select = "SELECT rango_manif_ini FROM rango_manifiesto WHERE oficina_id = $oficina_id AND estado = 'A'";
            $result = $this->DbFetchAll($select, $Conex, true);
            $rango_manif_ini = $result[0]['rango_manif_ini'];

            if (is_numeric($rango_manif_ini)) {

                $manifiesto = $rango_manif_ini;

            } else {

                print 'Debe Definir un rango de manifiestos para la oficina!!!';
                return false;

            }

        } else {

            if (is_numeric($manifiesto) && is_numeric($despacho)) {

                $select = "SELECT rango_manif_fin FROM rango_manifiesto WHERE oficina_id = $oficina_id AND estado = 'A'";
                $result = $this->DbFetchAll($select, $Conex, true);
                $rango_manif_fin = $result[0]['rango_manif_fin'];

                if ($manifiesto > $despacho) {
                    $manifiesto += 1;
                } else if ($despacho > $manifiesto) {
                    $manifiesto = $despacho + 1;
                }

                if ($manifiesto > $rango_manif_fin) {
                    print 'El numero de manifiesto para esta oficina a superado el limite definido<br>debe actualizar el rango de manifiestos asignado para esta oficina !!!';
                    return false;
                }

            } else {

                if (is_numeric($manifiesto)) {

                    $select = "SELECT rango_manif_fin FROM rango_manifiesto WHERE oficina_id = $oficina_id AND estado = 'A'";
                    $result = $this->DbFetchAll($select, $Conex, true);
                    $rango_manif_fin = $result[0]['rango_manif_fin'];

                    $manifiesto += 1;

                    if ($manifiesto > $rango_manif_fin) {
                        print 'El numero de manifiesto para esta oficina a superado el limite definido<br>debe actualizar el rango de manifiestos asignado para esta oficina !!!';
                        return false;
                    }

                } else if (is_numeric($despacho)) {

                    $select = "SELECT rango_manif_fin FROM rango_manifiesto WHERE oficina_id = $oficina_id AND estado = 'A'";
                    $result = $this->DbFetchAll($select, $Conex, true);
                    $rango_manif_fin = $result[0]['rango_manif_fin'];

                    $manifiesto = $despacho + 1;

                    if ($manifiesto > $rango_manif_fin) {
                        print 'El numero de manifiesto para esta oficina a superado el limite definido<br>debe actualizar el rango de manifiestos asignado para esta oficina !!!';
                        return false;
                    }

                } else {

                    $select = "SELECT rango_manif_ini FROM rango_manifiesto WHERE oficina_id = $oficina_id AND estado = 'A'";
                    $result = $this->DbFetchAll($select, $Conex, true);
                    $rango_manif_ini = $result[0]['rango_manif_ini'];

                    if (is_numeric($rango_manif_ini)) {
                        $manifiesto = $rango_manif_ini;
                    } else {
                        print 'Debe Definir un rango de manifiestos para la oficina!!!';
                        return false;
                    }

                }

            }

        }

        return $manifiesto;
    }

    public function validaValorMaximoPoliza($empresa_id, $valor, $Conex)
    {

        $select = "SELECT valor_maximo_despacho FROM poliza_empresa WHERE empresa_id = $empresa_id AND estado = 'A'";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {
            return $result[0]['valor_maximo_despacho'];
        } else {
            return null;
        }

    }

    public function getPoliza($empresa_id, $Conex)
    {

        $select = "SELECT * FROM poliza_empresa WHERE empresa_id = $empresa_id AND estado = 'A' ORDER BY fecha_vencimiento DESC ";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {
            return $result;
        } else {
            return array();
        }

    }

//LISTA MENU

    public function getUnidadesVolumen($Conex)
    {

        $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE tipo_unidad_medida_id = 11 ORDER BY medida ASC";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function getUnidades($Conex)
    {

        $select = "SELECT medida_id AS value,medida AS text FROM medida WHERE ministerio = 1 ORDER BY medida ASC";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function GetTiposServicio($Conex)
    {
        return $this->DbFetchAll("SELECT tipo_servicio_id AS value,tipo_servicio AS text FROM tipo_servicio ORDER BY tipo_servicio", $Conex, $ErrDb = false);

    }

    public function selectVehiculo($placa_id, $Conex)
    {

        $select = "SELECT (SELECT marca FROM marca WHERE marca_id = v.marca_id) AS marca,(SELECT linea FROM linea WHERE linea_id = v.linea_id) AS linea,modelo_vehiculo AS modelo,modelo_repotenciado,(SELECT color FROM color WHERE color_id = v.color_id) AS color,(SELECT carroceria FROM carroceria WHERE carroceria_id = v.carroceria_id) AS carroceria,registro_nacional_carga,configuracion,peso_vacio,numero_soat,(SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = v.aseguradora_soat_id) AS nombre_aseguradora,vencimiento_soat,(IF(DATE(vencimiento_soat) < DATE(NOW()),'SI','NO')) AS soat_vencio,vencimiento_tecno_vehiculo,(IF(DATE(vencimiento_tecno_vehiculo) < DATE(NOW()),'SI','NO'))  AS tecnicomecanica_vencio,placa_id,(SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,placa_remolque_id,
	(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) FROM tercero WHERE tercero_id = v.propietario_id) AS propietario,(SELECT direccion FROM tercero WHERE tercero_id = v.propietario_id) AS numero_identificacion_propietario,(SELECT direccion FROM tercero WHERE tercero_id = v.propietario_id) AS direccion_propietario,(SELECT  numero_identificacion FROM tercero WHERE tercero_id = v.propietario_id) AS numero_identificacion_propietario,(SELECT telefono FROM tercero WHERE tercero_id = v.propietario_id) AS telefono_propietario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = v.propietario_id)) AS ciudad_propietario,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sigla) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS tenedor,v.tenedor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE 	tenedor_id = v.tenedor_id))
 	AS numero_identificacion_tenedor,
	(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS direccion_tenedor,
	(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS numero_identificacion_tenedor,
	(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS telefono_tenedor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS ciudad_tenedor,conductor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS
	numero_identificacion,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS nombre,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS direccion_conductor,
	(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS 	telefono_conductor,
	(SELECT movil FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS movil_conductor,
	(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id =
	(SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id))) AS ciudad_conductor,
	(SELECT categoria FROM categoria_licencia WHERE categoria_id = (SELECT categoria_id FROM conductor WHERE conductor_id = v.conductor_id)) AS categoria_licencia_conductor,capacidad,
			(SELECT numero_licencia_cond FROM conductor WHERE conductor_id = v.conductor_id) numero_licencia_cond,
			chasis AS serie,(SELECT remolque FROM tipo_vehiculo WHERE tipo_vehiculo_id = v.tipo_vehiculo_id) AS remolque,
			(SELECT vencimiento_licencia_cond FROM conductor WHERE conductor_id = v.conductor_id) AS vencimiento_licencia_cond,(SELECT IF(DATE(vencimiento_licencia_cond) < DATE(NOW()),'SI','NO') FROM conductor WHERE conductor_id = v.conductor_id) AS licencia_vencio

			FROM vehiculo v WHERE placa_id = $placa_id ";

        $result = $this->DbFetchAll($select, $Conex, false);

        $soat_vencio = $result[0]['soat_vencio'];
        $tecnicomecanica_vencio = $result[0]['tecnicomecanica_vencio'];
        $licencia_vencio = $result[0]['licencia_vencio'];
        $conductor_id = $result[0]['conductor_id'];

        if ($licencia_vencio == 'SI') {

            $update = "UPDATE conductor SET estado = 'B' WHERE conductor_id = $conductor_id";
            $result1 = $this->query($update, $Conex, true);

        }

        if ($tecnicomecanica_vencio == 'SI' || $soat_vencio == 'SI') {

            $update = "UPDATE vehiculo SET estado = 'B' WHERE placa_id = $placa_id";
            $result1 = $this->query($update, $Conex, true);

        }

        return $result;

    }

    public function selectConductor($conductor_id, $Conex)
    {

        $select = "SELECT c.conductor_id,concat_ws(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido) AS nombre,t.numero_identificacion,
     (SELECT categoria FROM categoria_licencia WHERE categoria_id = c.categoria_id) AS categoria_licencia_conductor,
	 t.direccion AS direccion_conductor,t.telefono AS telefono_conductor,t.movil AS movil_conductor,c.numero_licencia_cond,
	 (SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS ciudad_conductor,
	 c.vencimiento_licencia_cond,IF(DATE(c.vencimiento_licencia_cond) < DATE(NOW()),'SI','NO') AS licencia_vencio
	  FROM conductor c, tercero t  WHERE
	  t.tercero_id = c.tercero_id AND c.conductor_id = $conductor_id";

        $result = $this->DbFetchAll($select, $Conex, false);

        $licencia_vencio = $result[0]['licencia_vencio'];

        if ($licencia_vencio == 'SI') {

            $update = "UPDATE conductor SET estado = 'B' WHERE conductor_id = $conductor_id";
            $result1 = $this->query($update, $Conex, true);

        }

        return $result;

    }

    public function getCiudadIdRemitenteDestinatario($remitente_destinatario_id, $Conex)
    {

        $select = "SELECT ubicacion_id FROM remitente_destinatario WHERE remitente_destinatario_id = $remitente_destinatario_id";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function selectorden_cargue_estado($orden_cargue_id, $Conex)
    {

        $select = "SELECT
				(SELECT manifiesto FROM  manifiesto WHERE orden_cargue_id=o.orden_cargue_id AND estado!='A' LIMIT 1) AS manifiesto,
				(SELECT numero_remesa FROM  remesa WHERE orden_cargue_id=o.orden_cargue_id AND estado!='AN' LIMIT 1) AS remesa
				FROM orden_cargue o  WHERE o.orden_cargue_id=$orden_cargue_id"; //echo $select;
        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

        return $result;
    }

//BUSQUEDA
    public function selectorden_cargue($orden_cargue_id, $Conex)
    {

        $select = "SELECT o.remitente_id,o.destinatario_id,o.remitente,o.destinatario,o.orden_cargue_id,o.detalle_ss_id,o.detalle_solicitud,o.consecutivo, o.fecha,	o.cliente_id,o.cliente,o.cliente_nit,o.cliente_tel,o.direccion_cargue,o.tipo_servicio_id,
					o.estado, o.hora,o.origen_id,o.destino_id,o.empaque_id,
					(SELECT producto FROM orden_cargue WHERE orden_cargue_id=$orden_cargue_id) AS producto,o.producto_id,
					o.unidad_peso_id,o.unidad_volumen_id,o.peso,o.peso_volumen,o.cantidad_cargue,
					o.placa_id,o.placa,o.placa_remolque_id,o.marca,o.linea,o.modelo,o.modelo_repotenciado,o.serie,o.color,o.carroceria,o.registro_nacional_carga,
					o.configuracion,o.peso_vacio,o.numero_soat,o.nombre_aseguradora,o.vencimiento_soat,o.placa_remolque,o.tenedor_id,o.tenedor,o.numero_identificacion_tenedor,
					o.direccion_tenedor,o.telefono_tenedor,o.ciudad_tenedor,o.propietario,o.numero_identificacion_propietario,o.direccion_propietario,o.telefono_propietario,
					o.ciudad_propietario,o.conductor_id,o.numero_identificacion,o.nombre,o.direccion_conductor,o.telefono_conductor,o.ciudad_conductor,o.categoria_licencia_conductor,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.destino_id) AS destino,
					(SELECT valor_unidad FROM detalle_solicitud_servicio WHERE detalle_ss_id=o.detalle_ss_id ) AS valor_declarado,
					(SELECT peso FROM detalle_solicitud_servicio WHERE detalle_ss_id=o.detalle_ss_id ) AS peso_declarado,
					(SELECT solicitud_id FROM detalle_solicitud_servicio WHERE detalle_ss_id=o.detalle_ss_id ) AS solicitud_id,
					(SELECT tipo_liquidacion FROM detalle_solicitud_servicio ds, solicitud_servicio s WHERE ds.detalle_ss_id=o.detalle_ss_id AND s.solicitud_id=ds.solicitud_id ) AS tipo_liquidacion,
					(SELECT orden_despacho FROM detalle_solicitud_servicio WHERE detalle_ss_id=o.detalle_ss_id ) AS orden_despacho,
					(SELECT tercero_id FROM cliente WHERE cliente_id=o.cliente_id ) AS propietario_mercancia_id,
					(SELECT ti.codigo FROM cliente c, tercero t, tipo_identificacion ti WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id AND ti.tipo_identificacion_id=t.tipo_identificacion_id ) AS tipo_identificacion_propietario_mercancia,
					(SELECT tipo_identificacion_id FROM  remitente_destinatario WHERE remitente_destinatario_id=o.remitente_id  ) AS tipo_identificacion_remitente_id,
					(SELECT numero_identificacion FROM  remitente_destinatario WHERE remitente_destinatario_id=o.remitente_id  ) AS doc_remitente,
					(SELECT digito_verificacion FROM  remitente_destinatario WHERE remitente_destinatario_id=o.remitente_id  ) AS digito_verificacion_remitente,
					(SELECT telefono FROM  remitente_destinatario WHERE remitente_destinatario_id=o.remitente_id  ) AS telefono_remitente,
					(SELECT tipo_identificacion_id FROM  remitente_destinatario WHERE remitente_destinatario_id=o.destinatario_id  ) AS tipo_identificacion_destinatario_id,
					(SELECT numero_identificacion FROM  remitente_destinatario WHERE remitente_destinatario_id=o.destinatario_id  ) AS doc_destinatario,
					(SELECT digito_verificacion FROM  remitente_destinatario WHERE remitente_destinatario_id=o.destinatario_id  ) AS digito_verificacion_destinatario,
					(SELECT direccion FROM  remitente_destinatario WHERE remitente_destinatario_id=o.destinatario_id  ) AS direccion_destinatario,
					(SELECT telefono FROM  remitente_destinatario WHERE remitente_destinatario_id=o.destinatario_id  ) AS telefono_destinatario,
					(SELECT divipola FROM  tenedor te, tercero t, ubicacion u WHERE te.tenedor_id=o.tenedor_id AND t.tercero_id=te.tercero_id AND u.ubicacion_id=t.ubicacion_id  ) AS  	ciudad_titular_manifiesto_divipola,
					(SELECT propio FROM vehiculo WHERE placa_id=o.placa_id) AS propio,o.valor_facturar,o.valor_unidad_facturar,o.tipo_liquidacion
				FROM orden_cargue o  WHERE o.orden_cargue_id=$orden_cargue_id"; //echo $select;
        $result = $this->DbFetchAll($select, $Conex, $ErrDb = true);

        return $result;
    }

    public function getDataCliente($cliente_id, $Conex)
    {

        $select = "SELECT  tr.telefono AS cliente_tel,
	 					tr.direccion AS direccion_cargue,
						tr.numero_identificacion AS cliente_nit,
						CONCAT_WS(' ',tr.primer_nombre,tr.segundo_nombre,tr.primer_apellido,tr.segundo_apellido,tr.razon_social) AS cliente
	 FROM cliente p, tercero tr WHERE p.cliente_id = $cliente_id AND tr.tercero_id = p.tercero_id";
        $result = $this->DbFetchAll($select, $Conex, false);
        return $result;

    }

    public function getDataSolicitud($detalle_ss_id, $Conex)
    {

        $select = "SELECT  (SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS nombre FROM cliente c, tercero t WHERE c.cliente_id=s.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
						(SELECT t.numero_identificacion FROM cliente c, tercero t WHERE c.cliente_id=s.cliente_id AND t.tercero_id=c.tercero_id) AS cliente_nit,
						s.cliente_id,
						s.tipo_servicio_id,
						s.fecha_recogida_ss AS fecha,
						s.hora_recogida_ss AS hora,
						d.direccion_remitente AS direccion_cargue,
						d.telefono_remitente  AS cliente_tel,
						d.origen_id,
						d.destino_id,
						(SELECT placa_id FROM vehiculo WHERE placa= d.shipment) as placa_id,
						d.shipment as placa,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.origen_id) AS origen,
						(SELECT nombre FROM ubicacion WHERE ubicacion_id=d.destino_id) AS destino,
						d.unidad_peso_id,
						d.unidad_volumen_id,
						d.cantidad AS cantidad_cargue,
						d.producto_id,
						d.descripcion_producto AS producto,
						d.peso,
						d.peso_volumen,
						d.remitente,
						d.remitente_id,
						d.destinatario,
						d.destinatario_id
	 FROM detalle_solicitud_servicio d, solicitud_servicio s WHERE d.detalle_ss_id = $detalle_ss_id AND s.solicitud_id=d.solicitud_id";
        $result = $this->DbFetchAll($select, $Conex, false);
        return $result;

    }

    public function getContactos($ClienteId, $orden_cargue_id, $Conex)
    {

        $select = "SELECT contacto_id AS value,nombre_contacto AS text,(SELECT contacto_id FROM orden_cargue WHERE orden_cargue_id = '$orden_cargue_id') AS selected
				FROM contacto
				WHERE cliente_id =  $ClienteId";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function selectDataTitular($tenedor_id, $Conex)
    {

        $select = "SELECT tn.tercero_id AS titular_manifiesto_id,UPPER(CONCAT_WS(' ',
	  t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.sigla)) AS titular_manifiesto,t.numero_identificacion
	  AS numero_identificacion_titular_manifiesto,t.direccion AS direccion_titular_manifiesto,t.telefono AS telefono_titular_manifiesto,
     (SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS ciudad_titular_manifiesto,(SELECT divipola FROM ubicacion
     WHERE ubicacion_id = t.ubicacion_id) AS ciudad_titular_manifiesto_divipola FROM tenedor tn, tercero t WHERE
     tn.tenedor_id = $tenedor_id AND tn.tercero_id = t.tercero_id";

        $result = $this->DbFetchAll($select, $Conex, false);

        return $result;

    }

    public function cancellation($Conex)
    {

        $this->Begin($Conex);

        $orden_cargue_id = $this->requestDataForQuery('orden_cargue_id', 'integer');
        $anul_orden_cargue = $this->requestDataForQuery('anul_orden_cargue', 'text');
        $desc_anul_orden_cargue = $this->requestDataForQuery('desc_anul_orden_cargue', 'text');
        $anul_usuario_id = $this->requestDataForQuery('anul_usuario_id', 'integer');

        $update = "UPDATE orden_cargue SET estado= 'A',
					anul_orden_cargue=$anul_orden_cargue,
					desc_anul_orden_cargue =$desc_anul_orden_cargue,
					anul_usuario_id=$anul_usuario_id
				WHERE orden_cargue_id=$orden_cargue_id";
        $this->query($update, $Conex);

        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {
            $this->Commit($Conex);
        }
    }

//// GRID ////
    public function getQueryOrdenCargueGrid($oficina_id)
    {

        $Query = "SELECT
	 				o.consecutivo,
					(SELECT solicitud_id FROM detalle_solicitud_servicio WHERE  detalle_ss_id=o.detalle_ss_id) AS  solicitud_id,
					o.fecha,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS cliente_nom  FROM cliente c, tercero t WHERE c.cliente_id=o.cliente_id AND t.tercero_id=c.tercero_id) AS cliente,
					(SELECT nombre_contacto  FROM contacto WHERE contacto_id=o.contacto_id) AS contacto,
					o.direccion_cargue,
					(SELECT tipo_servicio FROM tipo_servicio WHERE tipo_servicio_id=o.tipo_servicio_id ) AS tipo_servicio,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.origen_id) AS origen,
					(SELECT nombre FROM ubicacion WHERE ubicacion_id=o.destino_id) AS destino,
					o.producto,
					o.cantidad_cargue,
					o.peso,
					(SELECT medida FROM medida WHERE medida_id=o.unidad_peso_id) AS unidad_peso,
					o.peso_volumen,
					(SELECT medida FROM medida WHERE medida_id=o.unidad_volumen_id) AS unidad_volumen,
					o.placa,
					o.tenedor,
					o.propietario,
					o.nombre,
					(SELECT CONCAT_WS(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social) AS usuario_nom FROM usuario u, tercero t WHERE u.usuario_id=o.usuario_id AND t.tercero_id=u.tercero_id) AS usuario,
					(SELECT nombre FROM oficina WHERE oficina_id=o.oficina_id) AS oficina,
					o.fecha_ingreso,
					CASE o.estado WHEN 'E' THEN 'ESPERA' WHEN 'A' THEN 'ANULADO' WHEN 'R' THEN 'REALIZADO' END AS estado
	 			FROM orden_cargue o
				WHERE o.oficina_id=$oficina_id
				ORDER BY o.orden_cargue_id DESC LIMIT 0,200";

        return $Query;
    }

}
