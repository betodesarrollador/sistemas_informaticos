<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class LiquidacionDescuModel extends Db
{

    public function selectManifiestos($Conex)
    {

        $select = "SELECT * FROM manifiesto m WHERE  m.aprobacion_ministerio3 IS NULL
 	AND m.aprobacion_ministerio2 IS NOT NULL AND (m.estado='L' OR m.estado='M') AND m.fecha_mc <='2015-08-25'
	AND manifiesto_id NOT IN (12690,12739,12761,12777,12861,12989,13140,13150,13280,13459,13525,13580,13720,13749,14109,13136,13275,13276,
							  13277,13296,13433,13533,13544,13548,14260,14347,14403,14411,14429,16215,16228,16238,16247,16251,16252,16254,16285,
							  16313,16324,16325,16334,16346,16348,16386,16388,16393,16397,16400,16409,16410,16627,17005) LIMIT 0,80";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function selectManifiestosPropios($Conex)
    {

        $select = "SELECT * FROM manifiesto m, legalizacion_manifiesto l WHERE m.propio =1 AND m.aprobacion_ministerio3 IS NULL
 	AND m.aprobacion_ministerio2 IS NOT NULL AND m.estado='L' AND m.fecha_mc<='2014-11-30' AND l.manifiesto_id=m.manifiesto_id LIMIT 0,1";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function selectRemesasManifiesto($manifiesto_id, $Conex)
    {

        $select = "SELECT numero_remesa,remesa_id,estado,tipo_remesa_id,peso,peso_costo, cliente_id
	FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE
	manifiesto_id = $manifiesto_id)";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function selectOficinas($empresa_id, $Conex)
    {

        $select = "SELECT oficina_id AS value, nombre AS text FROM oficina WHERE empresa_id = $empresa_id ORDER BY nombre ASC";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function anticiposGeneroEgreso($manifiesto, $Conex)
    {

        $select = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM manifiesto
	            WHERE TRIM(manifiesto) = TRIM('$manifiesto'))";

        $result = $this->DbFetchAll($select, $Conex);

        for ($i = 0; $i < count($result); $i++) {

            $encabezado_registro_id = $result[$i]['encabezado_registro_id'];

            if (!is_numeric($encabezado_registro_id)) {
                return false;
            }

        }

        return true;

    }

    public function selectManifiesto($manifiesto_id, $Conex)
    {

        $select = "SELECT manifiesto_id,manifiesto,tenedor,tenedor_id,placa,placa_id,(SELECT nombre FROM ubicacion
	 WHERE ubicacion_id = m.origen_id) AS origen,origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id) AS destino,destino_id
	 FROM manifiesto m WHERE manifiesto_id = $manifiesto_id";

        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

    public function selectLiquidacionDescuManifiesto($manifiesto_id, $Conex)
    {

        $liquidacion = array();

        $select = "SELECT valor_flete,valor_neto_pagar,saldo_por_pagar FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
        $result = $this->DbFetchAll($select, $Conex);

        $liquidacion[0]['valor_flete'] = $result[0]['valor_flete'];
        $liquidacion[0]['valor_neto_pagar'] = $result[0]['valor_neto_pagar'];
        $liquidacion[0]['saldo_por_pagar'] = $result[0]['saldo_por_pagar'];

        $select = "SELECT SUM(IF(r.peso_costo>0,r.peso_costo,r.peso)) AS peso, SUM(IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen)) AS peso_volumen,SUM(IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad)) AS cantidad, SUM(r.valor_costo) AS valor_costos
	 FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = $manifiesto_id AND r.remesa_id=dd.remesa_id";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['valor_costos'] = $result[0][valor_costos];
            $liquidacion[0]['peso_total'] = $result[0][peso];
            $liquidacion[0]['peso_vol_total'] = $result[0][peso_volumen];
            $liquidacion[0]['cantidad_total'] = $result[0][cantidad];
        }

        $select = "SELECT r.remesa_id,r.numero_remesa,r.tipo_liquidacion,IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad) AS cantidad, r.estado,r.valor_facturar,
	 IF(r.peso_costo>0,r.peso_costo,r.peso) AS peso,IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen) AS peso_volumen,r.valor_unidad_costo,r.valor_costo,
	 (SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,
	 (SELECT producto_empresa FROM producto WHERE producto_id = r.producto_id) AS  producto,
	 (SELECT medida FROM medida WHERE   medida_id = r.medida_id) AS unidad
	 FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = $manifiesto_id AND r.remesa_id=dd.remesa_id";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['remesa_dat'] = $result;
        }

        $select = "SELECT t.*,
	 CONCAT_WS('',(SELECT numero_remesa FROM remesa WHERE remesa_id=t.remesa_id),'-',(SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = t.cliente_id))) AS clientess,
	 (SELECT placa FROM vehiculo WHERE placa_id = t.placa_id) AS  placa
	 FROM  tiempos_clientes_remesas t WHERE t.manifiesto_id = $manifiesto_id ";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['tiempos_dat'] = $result;
        }

        $select = "SELECT * FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['impuestos'] = $result;
        }

        $select = "SELECT dm.*,(SELECT descuento FROM tabla_descuentos WHERE descuento_id = dm.descuento_id)as nombre, d.calculo FROM descuentos_manifiesto dm, tabla_descuentos d WHERE dm.manifiesto_id = $manifiesto_id AND dm.descuento_id = d.descuento_id";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['descuentos'] = $result;
        }

        $select = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['anticipos'] = $result;
        }

        return $liquidacion;

    }

    public function existeLiquidacionDescu($manifiesto_id, $Conex)
    {

        $select = "SELECT * FROM liquidacion_despacho_descu WHERE fuente_servicio_cod = 'MC' AND manifiesto_id = $manifiesto_id AND estado_liquidacion!='A'"; //echo($select);

        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function getEstadoLiquidacionDescu($manifiesto_id, $Conex)
    {

        $select = "SELECT * FROM liquidacion_despacho_descu WHERE fuente_servicio_cod = 'MC' AND manifiesto_id = $manifiesto_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result[0]['estado_liquidacion'];

    }

    public function Save($Campos, $empresa_id, $oficina_id, $modifica, $usuario_id, $Conex)
    {

        $this->Begin($Conex);

        require_once "UtilidadesContablesModelClass.php";
        $UtilidadesContables = new UtilidadesContablesModel();

        $oficina_pago_id = $_REQUEST['oficina_id'];

        $select = "SELECT nombre FROM oficina WHERE oficina_id = $oficina_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $LugarPago = $result[0]['nombre'];

        $liquidacion_despacho_descu_id = $this->DbgetMaxConsecutive("liquidacion_despacho_descu", "liquidacion_despacho_descu_id", $Conex, false, 1);
        $centro_de_costo_id = $UtilidadesContables->getCentroCostoId($oficina_id, $Conex);
        $tenedor_id = $this->requestData('tenedor_id');
        $fecha = $this->requestData('fecha');
        $numero_despacho = $this->requestData('manifiesto');
        $manifiesto = $this->requestData('manifiesto');
        $manifiesto_id = $this->requestData('manifiesto_id');
        $fuente_servicio_cod = 'MC';
        $estado_liquidacion = 'L';
        $select = "SELECT oficina_id FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
        $dataOficinaPlanillo = $this->DbFetchAll($select, $Conex, true);
        $oficina_planillo_id = $dataOficinaPlanillo[0]['oficina_id'];

        if ($centro_de_costo_id > 0) {

            $select = "SELECT * FROM parametros_liquidacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";

            $result = $this->DbFetchAll($select, $Conex, true);

            if (!count($result) > 0) {
                print "<p align='center'>No ha ingresado los parametros de liquidacion!!<br>estos parametros se asignan por Paramtros Modulo -> LiquidacionDescu</p>";
                $this->RollBack($Conex);
                exit();
            } else {
                $tipo_documento_id = $result[0]['tipo_documento_descu_id'];
                $saldo_por_pagar_id = $result[0]['saldo_por_pagar_id'];
                $naturaleza_saldo_por_pagar = $result[0]['naturaleza_saldo_por_pagar'];
                $saldo_por_pagar = 0;

                if (!is_numeric($saldo_por_pagar_id)) {
                    exit("<div align='center'><b>Aun no ha parametrizado la cuenta contable para concepto de saldo pagar</b></div>
				<div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> LiquidacionDescu</b></div>");
                }

                $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)";
                $result = $this->DbFetchAll($select, $Conex, true);

                $tercero_id = $result[0]['tercero_id'];
                $numero_identificacion = strlen(trim($result[0]['numero_identificacion'])) > 0 ? $result[0]['numero_identificacion'] : 'NULL';
                $digito_verificacion = strlen(trim($result[0]['digito_verificacion'])) > 0 ? $result[0]['digito_verificacion'] : 'NULL';
                $tercero_diferencia_id = strlen(trim($result[0]['tercero_id'])) > 0 ? $result[0]['tercero_id'] : 'NULL';

                $select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_planillo_id";
                $result = $this->DbFetchAll($select, $Conex, true);

                $centro_de_costo_id = $result[0]['centro_de_costo_id'];
                $codigo_centro_costo = strlen(trim($result[0]['codigo'])) > 0 ? "'{$result[0]['codigo']}'" : 'NULL';

                if (is_numeric($centro_de_costo_id)) {

                    $valor_descuentos = $this->removeFormatCurrency($_REQUEST['valor_descuentos']);
                    $observaciones = $this->requestDataForQuery('observaciones', 'text');
                    $consecutivo = $numero_despacho;

                    if (!is_numeric($valor_sobre_flete)) {
                        $valor_sobre_flete = 0;
                    }

                    $insert = "INSERT INTO liquidacion_despacho_descu (liquidacion_despacho_descu_id,fecha,tipo_documento_id,tercero_id,centro_de_costo_id,numero_despacho,fuente_servicio_cod
			,oficina_id,estado_liquidacion,valor_descuentos,manifiesto_id,concepto,consecutivo,observaciones) VALUES ($liquidacion_despacho_descu_id,'$fecha',$tipo_documento_id,$tercero_id,$centro_de_costo_id,'$numero_despacho','$fuente_servicio_cod'
			,$oficina_id,'$estado_liquidacion',$valor_descuentos,$manifiesto_id,'MC: $numero_despacho ',$consecutivo,$observaciones);";
                    $this->query($insert, $Conex, true);
                    $insert_log = $insert;

                    if ($this->GetNumError() > 0) {
                        $this->RollBack($Conex);
                        exit();
                    } else {

                        if (is_array($_REQUEST['descuentos'])) {
							$descuentos = $_REQUEST['descuentos'];
							
                            for ($i = 0; $i < count($descuentos); $i++) {
								
								$detalle_liquidacion_despacho_descu_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho_descu", "detalle_liquidacion_despacho_descu_id", $Conex, false, 1);
								
                                $descuentos_manifiesto_id = $descuentos[$i]['descuentos_manifiesto_id'];
                                $descuento_id = $descuentos[$i]['descuento_id'];
                                $nombre = $descuentos[$i]['nombre'];
                                $valor = $this->removeFormatCurrency($descuentos[$i]['valor']);
                                $base = $descuentos[$i]['base'];
								
                                if (is_numeric($descuento_id)) {

                                    $select = "SELECT * FROM tabla_descuentos WHERE descuento_id = $descuento_id";
                                    $result = $this->DbFetchAll($select, $Conex, true);
									
                                    if (count($result) > 0) {
										
										$puc_id = $result[0]['puc_id'];
                                        $naturaleza = $result[0]['naturaleza'];
										
                                        if ($naturaleza == 'D') {
											$debito = $valor;
                                            $credito = 0;
                                        } else {
											$debito = 0;
                                            $credito = $valor;
                                        }

                                        $saldo_por_pagar = ($saldo_por_pagar + $valor);
										
                                        if ($UtilidadesContables->requiereTercero($puc_id, $Conex)) {
											$tercero_liquidacion_id = $tercero_id;
                                            $numero_identificacion_liquidacion = $numero_identificacion;
                                            $digito_verificacion_liquidacion = $digito_verificacion;
                                        } else {
											$tercero_liquidacion_id = 'NULL';
                                            $numero_identificacion_liquidacion = 'NULL';
                                            $digito_verificacion_liquidacion = 'NULL';
                                        }

                                        if ($UtilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
											$centro_costo_liquidacion_id = $centro_de_costo_id;
                                            $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                                        } else {
                                            $centro_costo_liquidacion_id = 'NULL';
                                            $codigo_centro_costo_liquidacion = 'NULL';
                                        }
										
                                        $descripcion = "$nombre MC: $numero_despacho";
										
                                        $insert = "INSERT INTO detalle_liquidacion_despacho_descu (detalle_liquidacion_despacho_descu_id,liquidacion_despacho_descu_id,puc_id,centro_de_costo_id,codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,base,debito,credito,descuento,descuentos_manifiesto_id,valor,descripcion)
				      VALUES ($detalle_liquidacion_despacho_descu_id,$liquidacion_despacho_descu_id,$puc_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,$debito,$credito,1,$descuentos_manifiesto_id,$valor,'$descripcion');";

$this->query($insert, $Conex, true);

} else {
	print "¡No ha configurado la tabla de descuentos aun!";
	$this->RollBack($Conex);
	exit();
}

}

                            }
                           
							
                        }
						
                        if ($saldo_por_pagar > 0) {
							
							if ($naturaleza_saldo_por_pagar == 'D') {
								$credito = $saldo_por_pagar;
                                $debito = 0;
                            } else {
                                $credito = 0;
                                $debito = $saldo_por_pagar;
                            }

                            $puc_id = $saldo_por_pagar_id;

                            if ($UtilidadesContables->requiereTercero($puc_id, $Conex)) {
                                $tercero_liquidacion_id = $tercero_id;
                                $numero_identificacion_liquidacion = $numero_identificacion;
                                $digito_verificacion_liquidacion = $digito_verificacion;
                            } else {
                                $tercero_liquidacion_id = 'NULL';
                                $numero_identificacion_liquidacion = 'NULL';
                                $digito_verificacion_liquidacion = 'NULL';
                            }

                            if ($UtilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                                $centro_costo_liquidacion_id = $centro_de_costo_id;
                                $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                            } else {
                                $centro_costo_liquidacion_id = 'NULL';
                                $codigo_centro_costo_liquidacion = 'NULL';
                            }

                            $detalle_liquidacion_despacho_descu_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho_descu", "detalle_liquidacion_despacho_descu_id", $Conex, false, 1);

                            $descripcion = "DESCUENTOS MC: $numero_despacho";

                            $insert = "INSERT INTO detalle_liquidacion_despacho_descu(detalle_liquidacion_despacho_descu_id,liquidacion_despacho_descu_id,
			  puc_id,centro_de_costo_id,codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,
			  base,debito,credito,contrapartida,saldo_pagar,valor,descripcion) VALUES ($detalle_liquidacion_despacho_descu_id,
			  $liquidacion_despacho_descu_id,$puc_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,
			  $tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,$debito,$credito,1,1,
			  $saldo_por_pagar,'$descripcion');";

                            $this->query($insert, $Conex, true);

                        }

                        $update = "UPDATE manifiesto SET estado='L'
					WHERE manifiesto_id =(SELECT manifiesto_id FROM liquidacion_despacho_descu WHERE liquidacion_despacho_descu_id=$liquidacion_despacho_descu_id)";
                        $this->query($update, $Conex, true);

                    }

                } else {
                    print "No ha asignado un centro de costo la oficina !!!";
                    $this->RollBack($Conex);
                    exit();
                }

            }

            $update = "UPDATE manifiesto SET estado = 'L' WHERE manifiesto_id = $manifiesto_id";
            $this->query($update, $Conex, true);

            if (is_array($_REQUEST['tiempos'])) {
                
                for ($i = 0; $i < count($tiempos); $i++) {
                    $update = "UPDATE  tiempos_clientes_remesas
			 			SET fecha_llegada_descargue = '" . $tiempos[$i]['fecha_llegada_descargue'] . "',
						hora_llegada_descargue = '" . $tiempos[$i]['hora_llegada_descargue'] . "',
			 			fecha_entrada_descargue = '" . $tiempos[$i]['fecha_entrada_descargue'] . "',
						hora_entrada_descargue = '" . $tiempos[$i]['hora_entrada_descargue'] . "',
						fecha_salida_descargue = '" . $tiempos[$i]['fecha_salida_descargue'] . "',
						hora_salida_descargue = '" . $tiempos[$i]['hora_salida_descargue'] . "'
						WHERE tiempos_clientes_remesas_id =" . $tiempos[$i]['tiempos_clientes_remesas_id'] . "";
                    //echo $update;
                    $this->query($update, $Conex, true);
                }
            }

            $this->setLogTransaction_extra('liquidacion_despacho_descu', $insert_log, $Conex, 'INSERT');
            $this->Commit($Conex);

            exit("$liquidacion_despacho_descu_id");

        } else {
            exit('Esta oficina no tiene asignado un centro de costo!!!');
            $this->RollBack($Conex);
            exit();
        }

    }

    public function Update($Campos, $empresa_id, $oficina_id, $Conex)
    {

        $this->Begin($Conex);

        require_once "UtilidadesContablesModelClass.php";
        $UtilidadesContables = new UtilidadesContablesModel();

        $estado_liquidacion = $_REQUEST['estado_liquidacion'];
        $tenedor_id = $_REQUEST['tenedor_id'];
        $detalle_liquidacion_valor_flete_id = $_REQUEST['detalle_liquidacion_valor_flete_id'];
        $valor_descuentos = $this->removeFormatCurrency($_REQUEST['valor_descuentos']);
        $detalle_liquidacion_valor_sobre_flete_id = $_REQUEST['detalle_liquidacion_valor_sobre_flete_id'];
        $liquidacion_despacho_descu_id = $_REQUEST['liquidacion_despacho_descu_id'];
        $saldo_por_pagar = 0;

        $select = "SELECT oficina_id FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho_descu WHERE
	                              liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id)";
        $dataOficinaPlanillo = $this->DbFetchAll($select, $Conex, true);
        $oficina_planillo_id = $dataOficinaPlanillo[0]['oficina_id'];

        if ($estado_liquidacion != 'L') {
            exit("LiquidacionDescu no puede ser modificado, estado cambio!!!!!");
        }

        $select = "SELECT * FROM parametros_liquidacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (!count($result) > 0) {
            print "<p align='center'>No ha ingresado los parametros de liquidacion!!<br>estos parametros se asignan por Paramtros Modulo -> LiquidacionDescu</p>";
            $this->RollBack($Conex);
            exit();
        } else {

            $tipo_documento_id = $result[0]['tipo_documento_id'];
            $saldo_por_pagar_id = $result[0]['saldo_por_pagar_id'];
            $naturaleza_saldo_por_pagar = $result[0]['naturaleza_saldo_por_pagar'];
            $oficina_lugar_pago_id = $this->requestData('oficina_id');
            $observaciones = $this->requestDataForQuery('observaciones', 'text');

            $update = "UPDATE liquidacion_despacho_descu SET valor_descuentos = $valor_descuentos,
		observaciones = $observaciones WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id";
            $this->query($update, $Conex, true);
            $update_log = $update;

            if (is_array($_REQUEST['descuentos'])) {

                $descuentos = $_REQUEST['descuentos'];

                for ($i = 0; $i < count($descuentos); $i++) {

                    $detalle_liquidacion_despacho_descu_id = $descuentos[$i]['detalle_liquidacion_despacho_descu_id'];
                    $valor = $this->removeFormatCurrency($descuentos[$i]['valor']);
                    $descuento_id = $descuentos[$i]['descuento_id'];
                    $saldo_por_pagar = ($saldo_por_pagar + $valor);
                    $select = "SELECT * FROM tabla_descuentos WHERE descuento_id = $descuento_id";
                    $result = $this->DbFetchAll($select, $Conex, true);

                    $puc_id = $result[0]['puc_id'];
                    $naturaleza = $result[0]['naturaleza'];

                    if ($naturaleza == 'D') {
                        $update = "UPDATE detalle_liquidacion_despacho_descu SET puc_id = $puc_id,debito = $valor,credito = 0,valor = $valor WHERE
			  detalle_liquidacion_despacho_descu_id = $detalle_liquidacion_despacho_descu_id";
                        $this->query($update, $Conex, true);
                    } else {
                        $update = "UPDATE detalle_liquidacion_despacho_descu SET puc_id = $puc_id,debito = 0,credito = $valor,valor = $valor WHERE
				detalle_liquidacion_despacho_descu_id = $detalle_liquidacion_despacho_descu_id";
                        $this->query($update, $Conex, true);
                    }

                }
            }

            $select1 = "SELECT * FROM detalle_liquidacion_despacho_descu
					WHERE puc_id = $saldo_por_pagar_id AND liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id
					ORDER BY detalle_liquidacion_despacho_descu_id DESC LIMIT 1";
            $result1 = $this->DbFetchAll($select1, $Conex, true);
            $detalle_liquidacion_saldo_por_pagar_id = $result1[0]['detalle_liquidacion_despacho_descu_id'];

            if ($naturaleza_saldo_por_pagar == 'D') {
                if ($detalle_liquidacion_saldo_por_pagar_id > 0) {
                    $update = "UPDATE detalle_liquidacion_despacho_descu SET puc_id = $saldo_por_pagar_id,debito = 0,credito = $saldo_por_pagar,
				  valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_descu_id = $detalle_liquidacion_saldo_por_pagar_id";
                    $this->query($update, $Conex, true);
                } else {

                    $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)";
                    $result = $this->DbFetchAll($select, $Conex, true);

                    $tercero_id = $result[0]['tercero_id'];
                    $numero_identificacion = strlen(trim($result[0]['numero_identificacion'])) > 0 ? $result[0]['numero_identificacion'] : 'NULL';
                    $digito_verificacion = strlen(trim($result[0]['digito_verificacion'])) > 0 ? $result[0]['digito_verificacion'] : 'NULL';
                    $tercero_diferencia_id = strlen(trim($result[0]['tercero_id'])) > 0 ? $result[0]['tercero_id'] : 'NULL';

                    $puc_id = $saldo_por_pagar_id;

                    if ($UtilidadesContables->requiereTercero($puc_id, $Conex)) {
                        $tercero_liquidacion_id = $tercero_id;
                        $numero_identificacion_liquidacion = $numero_identificacion;
                        $digito_verificacion_liquidacion = $digito_verificacion;
                    } else {
                        $tercero_liquidacion_id = 'NULL';
                        $numero_identificacion_liquidacion = 'NULL';
                        $digito_verificacion_liquidacion = 'NULL';
                    }

                    $select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_planillo_id";
                    $result2 = $this->DbFetchAll($select, $Conex, true);

                    $centro_de_costo_id = $result2[0]['centro_de_costo_id'];
                    $codigo_centro_costo = strlen(trim($result2[0]['codigo'])) > 0 ? "'{$result2[0]['codigo']}'" : 'NULL';

                    if ($UtilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                        $centro_costo_liquidacion_id = $centro_de_costo_id;
                        $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                    } else {
                        $centro_costo_liquidacion_id = 'NULL';
                        $codigo_centro_costo_liquidacion = 'NULL';
                    }

                    $detalle_liquidacion_despacho_descu_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho", "detalle_liquidacion_despacho_descu_id", $Conex, false, 1);

                    $descripcion = "SALDO MC: $numero_despacho";

                    $insert = "INSERT INTO detalle_liquidacion_despacho_descu(detalle_liquidacion_despacho_descu_id,liquidacion_despacho_descu_id,
				  puc_id,centro_de_costo_id,codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,
				  base,debito,credito,contrapartida,saldo_pagar,valor,descripcion) VALUES ($detalle_liquidacion_despacho_descu_id,
				  $liquidacion_despacho_descu_id,$saldo_por_pagar_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,
				  $tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,0,$saldo_por_pagar,1,1,
				  $saldo_por_pagar,'$descripcion');";

                    $this->query($insert, $Conex, true);
                }
            } else {
                if ($detalle_liquidacion_saldo_por_pagar_id > 0) {
                    $update = "UPDATE detalle_liquidacion_despacho_descu SET puc_id = $saldo_por_pagar_id,debito = $saldo_por_pagar,credito = 0,
				valor = $saldo_por_pagar WHERE detalle_liquidacion_despacho_descu_id = $detalle_liquidacion_saldo_por_pagar_id";
                    $this->query($update, $Conex, true);
                } else {

                    $select = "SELECT * FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = $tenedor_id)";
                    $result = $this->DbFetchAll($select, $Conex, true);

                    $tercero_id = $result[0]['tercero_id'];
                    $numero_identificacion = strlen(trim($result[0]['numero_identificacion'])) > 0 ? $result[0]['numero_identificacion'] : 'NULL';
                    $digito_verificacion = strlen(trim($result[0]['digito_verificacion'])) > 0 ? $result[0]['digito_verificacion'] : 'NULL';
                    $tercero_diferencia_id = strlen(trim($result[0]['tercero_id'])) > 0 ? $result[0]['tercero_id'] : 'NULL';

                    $puc_id = $saldo_por_pagar_id;

                    if ($UtilidadesContables->requiereTercero($puc_id, $Conex)) {
                        $tercero_liquidacion_id = $tercero_id;
                        $numero_identificacion_liquidacion = $numero_identificacion;
                        $digito_verificacion_liquidacion = $digito_verificacion;
                    } else {
                        $tercero_liquidacion_id = 'NULL';
                        $numero_identificacion_liquidacion = 'NULL';
                        $digito_verificacion_liquidacion = 'NULL';
                    }

                    $select = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_planillo_id";
                    $result2 = $this->DbFetchAll($select, $Conex, true);

                    $centro_de_costo_id = $result2[0]['centro_de_costo_id'];
                    $codigo_centro_costo = strlen(trim($result2[0]['codigo'])) > 0 ? "'{$result2[0]['codigo']}'" : 'NULL';

                    if ($UtilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                        $centro_costo_liquidacion_id = $centro_de_costo_id;
                        $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                    } else {
                        $centro_costo_liquidacion_id = 'NULL';
                        $codigo_centro_costo_liquidacion = 'NULL';
                    }

                    $detalle_liquidacion_despacho_descu_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho", "detalle_liquidacion_despacho_descu_id", $Conex, false, 1);

                    $descripcion = "SALDO MC: $numero_despacho";

                    $insert = "INSERT INTO detalle_liquidacion_despacho_descu(detalle_liquidacion_despacho_descu_id,liquidacion_despacho_descu_id,
				  puc_id,centro_de_costo_id,codigo_centro_costo,tercero_id,numero_identificacion,digito_verificacion,
				  base,debito,credito,contrapartida,saldo_pagar,valor,descripcion) VALUES ($detalle_liquidacion_despacho_descu_id,
				  $liquidacion_despacho_descu_id,$saldo_por_pagar_id,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,
				  $tercero_liquidacion_id,$numero_identificacion_liquidacion,$digito_verificacion_liquidacion,NULL,$saldo_por_pagar,0,1,1,
				  $saldo_por_pagar,'$descripcion');";

                    $this->query($insert, $Conex, true);
                }
            }

        }
        if (is_array($_REQUEST['tiempos'])) {
            $tiempos = $_REQUEST['tiempos'];
            for ($i = 0; $i < count($tiempos); $i++) {
                $update = "UPDATE  tiempos_clientes_remesas
			 			SET fecha_llegada_descargue = '" . $tiempos[$i]['fecha_llegada_descargue'] . "',
						hora_llegada_descargue = '" . $tiempos[$i]['hora_llegada_descargue'] . "',
			 			fecha_entrada_descargue = '" . $tiempos[$i]['fecha_entrada_descargue'] . "',
						hora_entrada_descargue = '" . $tiempos[$i]['hora_entrada_descargue'] . "',
						fecha_salida_descargue = '" . $tiempos[$i]['fecha_salida_descargue'] . "',
						hora_salida_descargue = '" . $tiempos[$i]['hora_salida_descargue'] . "'
						WHERE tiempos_clientes_remesas_id =" . $tiempos[$i]['tiempos_clientes_remesas_id'] . "";
                //echo $update;
                $this->query($update, $Conex, true);
            }
        }

        /* $valor_total_flete = ($valor_flete + $valor_sobre_flete);

        $select  = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = $manifiesto_id)";
        $remesas = $this  -> DbFetchAll($select,$Conex,true);

        $valor_facturar_total = 0;

        for($i = 0; $i < count($remesas); $i++){
        $valor_facturar_total += $result[$i]['valor_facturar'];
        }

        for($i = 0; $i < count($remesas); $i++){

        $remesa_id      = $result[$i]['remesa_id'];
        $valor_facturar = $result[$i]['valor_facturar'];
        $porcentaje     = ($valor_facturar * 100) / $valor_facturar_total;
        $valor_costo    = ($porcentaje * $valor_total_flete) / 100;

        $update = "UPDATE remesa SET valor_costo = $valor_costo, conductor_id = (SELECT conductor_id FROM manifiesto WHERE manifiesto_id = $manifiesto_id)
        WHERE remesa_id = $remesa_id";

        $this -> query($update,$Conex,true);

        }   */

        /*
        if(is_array($_REQUEST['remesa'])){
        $con_rem=0;
        $remesa = $_REQUEST['remesa'];

        for($i = 0; $i < count($remesa); $i++){
        if($remesa[$i]['valor_costo']!=''){
        $con_rem++;
        }
        }
        if( count($remesa)==$con_rem){
        $tip_guardar_rem='costo';
        }elseif($con_rem==0){
        $tip_guardar_rem='total';
        }else{
        print "<p align='center'>Debe de asignar los valores de costo por todas las remesas!!<br>De lo contrario deje todos los campos de valor de costo por remesa vacios e ingrese un valor total de flete</p>";
        $this -> RollBack($Conex);
        exit();
        }
        }
        if($tip_guardar_rem=='total'){

        $select  = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = (SELECT
        manifiesto_id FROM liquidacion_despacho_descu WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id)) AND clase_remesa = 'NN'";

        $remesas = $this  -> DbFetchAll($select,$Conex,true);

        $valor_facturar_total = 0;

        for($i = 0; $i < count($remesas); $i++){

        $valor_facturar_total += $remesas[$i]['valor_facturar'];

        if(!$remesas[$i]['valor_facturar'] > 0)  {
        $this -> RollBack($Conex);
        exit("<div align='center'>Debe liquidar todas las remesas antes de liquidar el manifiesto!!</div>");
        }

        }

        if($valor_facturar_total > 0){

        for($i = 0; $i < count($remesas); $i++){

        $remesa_id      = $remesas[$i]['remesa_id'];
        $valor_facturar = $remesas[$i]['valor_facturar'];
        $porcentaje     = ($valor_facturar / $valor_facturar_total) * 100 ;
        $valor_costo    = round(($porcentaje * $valor_total_flete) / 100);
        $update = "UPDATE remesa SET valor_costo = $valor_costo, conductor_id = (SELECT conductor_id FROM manifiesto WHERE
        manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho_descu WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id)) WHERE remesa_id = $remesa_id";

        $this -> query($update,$Conex,true);

        }

        }else{

        if(count($remesas) > 0){
        $this -> RollBack($Conex);
        exit("<div align='center'>Debe liquidar las remesas primero!!</div>");
        }

        }
        }elseif($tip_guardar_rem=='costo'){

        if(is_array($_REQUEST['remesa'])){

        $remesa = $_REQUEST['remesa'];

        for($i = 0; $i < count($remesa); $i++){

        if($remesa[$i]['estado']=='LQ' && $remesa[$i]['valor_costo']!=''){
        $valor_costo= $remesa[$i]['valor_costo']!='' ? str_replace('.','',$remesa[$i]['valor_costo']): 'NULL';
        $cantidad= $remesa[$i]['cantidad']!='' ? str_replace('.','',$remesa[$i]['cantidad']): 'NULL';
        $peso_volumen= $remesa[$i]['peso_volumen']!='' ? str_replace('.','',$remesa[$i]['peso_volumen']): 'NULL';
        $peso= $remesa[$i]['peso']!='' ? str_replace('.','',$remesa[$i]['peso']): 'NULL';
        $valor_unidad_costo= $remesa[$i]['valor_unidad_costo']!='' ? str_replace('.','',$remesa[$i]['valor_unidad_costo']): 'NULL';

        $update = "UPDATE remesa SET valor_costo = ".$valor_costo.",
        cantidad_costo = ".$cantidad.",
        peso_volumen_costo = ".$peso_volumen.",
        peso_costo = ".$peso.",
        valor_unidad_costo = ".$valor_unidad_costo.",
        conductor_id = (SELECT conductor_id FROM manifiesto WHERE manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho_descu WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id))
        WHERE remesa_id = ".$remesa[$i]['remesa_id']."";

        $this -> query($update,$Conex,true);
        }else{
        $this -> RollBack($Conex);
        exit("<div align='center'>Debe liquidar la remesa ".$remesa[$i]['numero_remesa']." primero!!!</div>");
        }
        }
        }

        }
         */
        $this->setLogTransaction_extra('liquidacion_despacho_descu', $update_log, $Conex, 'UPDATE');
        $this->Commit($Conex);

    }

    public function getTiposDocumentoContable($Conex)
    {

        $select = "SELECT tipo_documento_id AS value,nombre AS text FROM tipo_de_documento ORDER BY nombre 	ASC";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;
    }

    public function selectLiquidacionDescu($liquidacion_despacho_descu_id, $Conex)
    {

        $liquidacion = array();

        $select = "SELECT (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id = ld.encabezado_registro_id) AS doc_contable,
	ld.liquidacion_despacho_descu_id,ld.encabezado_registro_id,ld.fecha,ld.oficina_id,ld.estado_liquidacion,m.manifiesto_id,m.manifiesto,m.tenedor,m.tenedor_id,
	m.placa,m.placa_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen,m.origen_id,(SELECT nombre FROM ubicacion WHERE ubicacion_id = m.destino_id)
	 AS destino,m.destino_id,CONCAT('LIQUIDACION MC: ',m.manifiesto) AS concepto,ld.observaciones,ld.valor_descuentos FROM manifiesto m,
	 liquidacion_despacho_descu ld WHERE m.manifiesto_id = ld.manifiesto_id AND ld.liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        $liquidacion = $result;

        $select = "SELECT valor,detalle_liquidacion_despacho_descu_id FROM detalle_liquidacion_despacho_descu WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id
	AND valor_flete = 1";
        $result = $this->DbFetchAll($select, $Conex, true);

        $liquidacion[0]['valor_flete'] = $result[0]['valor'];
        $liquidacion[0]['detalle_liquidacion_valor_flete_id'] = $result[0]['detalle_liquidacion_despacho_descu_id'];

        $select = "SELECT valor,detalle_liquidacion_despacho_descu_id FROM detalle_liquidacion_despacho_descu WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id
	AND valor_sobre_flete = 1";
        $result = $this->DbFetchAll($select, $Conex, true);

        $liquidacion[0]['valor_sobre_flete'] = $result[0]['valor'];
        $liquidacion[0]['detalle_liquidacion_valor_sobre_flete_id'] = $result[0]['detalle_liquidacion_despacho_descu_id'];

        $select = "SELECT valor,detalle_liquidacion_despacho_descu_id FROM detalle_liquidacion_despacho_descu WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id
	AND saldo_pagar = 1";
        $result = $this->DbFetchAll($select, $Conex, true);

        $liquidacion[0]['saldo_por_pagar'] = $result[0]['valor'];
        $liquidacion[0]['detalle_liquidacion_saldo_por_pagar_id'] = $result[0]['detalle_liquidacion_despacho_descu_id'];

        //pedazo johnatan inicio
        $select = "SELECT SUM(IF(r.peso_costo>0,r.peso_costo,r.peso)) AS peso, SUM(IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen)) AS peso_volumen,SUM(IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad)) AS cantidad, SUM(r.valor_costo) AS valor_costos
	 FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho_descu  WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id) AND r.remesa_id=dd.remesa_id";
        $result = $this->DbFetchAll($select, $Conex);
        /*
        $select = "SELECT SUM(r.peso) AS peso, SUM(r.peso_volumen) AS peso_volumen,SUM(r.cantidad) AS cantidad, SUM(r.valor_costo) AS valor_costos
        FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho_descu  WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id) AND r.remesa_id=dd.remesa_id";
        $result = $this  -> DbFetchAll($select,$Conex); */

        if (count($result) > 0) {
            $liquidacion[0]['valor_costos'] = $result[0][valor_costos];
            $liquidacion[0]['peso_total'] = $result[0][peso];
            $liquidacion[0]['peso_vol_total'] = $result[0][peso_volumen];
            $liquidacion[0]['cantidad_total'] = $result[0][cantidad];
        }

        $select = "SELECT r.remesa_id,r.numero_remesa,r.tipo_liquidacion,IF(r.cantidad_costo>0,r.cantidad_costo,r.cantidad) AS cantidad,r.estado,r.valor_facturar,
	 IF(r.peso_costo>0,r.peso_costo,r.peso) AS peso,IF(r.peso_volumen_costo>0,r.peso_volumen_costo,r.peso_volumen) AS peso_volumen,r.valor_unidad_costo,r.valor_costo,
	 (SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = r.cliente_id)) AS cliente,
	 (SELECT producto_empresa FROM producto WHERE producto_id = r.producto_id) AS  producto,
	 (SELECT medida FROM medida WHERE   medida_id = r.medida_id) AS unidad
	 FROM detalle_despacho dd, remesa r WHERE dd.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho_descu  WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id) AND r.remesa_id=dd.remesa_id";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['remesa_dat'] = $result;
        }

        $select = "SELECT t.*,
	 CONCAT_WS('',(SELECT numero_remesa FROM remesa WHERE remesa_id=t.remesa_id),'-',(SELECT CONCAT_WS(' ',razon_social, primer_nombre,primer_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM cliente WHERE cliente_id = t.cliente_id))) AS clientess,
	 (SELECT placa FROM vehiculo WHERE placa_id = t.placa_id) AS  placa
	 FROM  tiempos_clientes_remesas t WHERE t.manifiesto_id = (SELECT manifiesto_id FROM liquidacion_despacho_descu  WHERE liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id) ";
        $result = $this->DbFetchAll($select, $Conex);

        if (count($result) > 0) {
            $liquidacion[0]['tiempos_dat'] = $result;
        }

        //pedazo johnatan fin

        $valor_neto_pagar = $liquidacion[0]['valor_flete'];

        for ($i = 0; $i < count($liquidacion[0]['impuestos']); $i++) {

            $valor_neto_pagar -= $liquidacion[0]['impuestos'][$i]['valor'];

        }

        $liquidacion[0]['valor_neto_pagar'] = $valor_neto_pagar;

        $select = "SELECT dm.*,d.calculo,dl.detalle_liquidacion_despacho_descu_id,dl.descuentos_manifiesto_id,dl.valor FROM detalle_liquidacion_despacho_descu
	dl,descuentos_manifiesto dm,tabla_descuentos d WHERE dl.liquidacion_despacho_descu_id = $liquidacion_despacho_descu_id AND dl.descuento = 1 AND
	dl.descuentos_manifiesto_id = dm.descuentos_manifiesto_id AND dm.descuento_id = d.descuento_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {
            $liquidacion[0]['descuentos'] = $result;
        }

        return $liquidacion;

    }

    public function getColumnsImpGridLiquidacionDescu($Conex)
    {

//      $select    = "SELECT DISTINCT im.nombre FROM detalle_liquidacion_despacho_descu dl,impuestos_manifiesto im WHERE dl.impuestos_manifiesto_id = im.impuestos_manifiesto_id";

        $select = "SELECT DISTINCT nombre FROM tabla_impuestos ORDER BY nombre ASC";
        $impuestos = $this->DbFetchAll($select, $Conex, true);

        for ($i = 0; $i < count($impuestos); $i++) {
            $impuestos[$i]['comparar'] = $impuestos[$i]['nombre'];
            $impuestos[$i]['nombre'] = strtoupper(preg_replace("([ ]+)", "", str_replace('%', '', $impuestos[$i]['nombre'])));
        }

        return $impuestos;

    }

    public function getColumnsDesGridLiquidacionDescu($Conex)
    {

//      $select     = "SELECT DISTINCT dm.nombre FROM detalle_liquidacion_despacho_descu dl,descuentos_manifiesto dm WHERE dl.descuentos_manifiesto_id = dm.descuentos_manifiesto_id";

        $select = "SELECT DISTINCT descuento AS nombre FROM tabla_descuentos ORDER BY nombre ASC";
        $descuentos = $this->DbFetchAll($select, $Conex, true);

        for ($i = 0; $i < count($descuentos); $i++) {
            $descuentos[$i]['comparar'] = $descuentos[$i]['nombre'];
            $descuentos[$i]['nombre'] = strtoupper(str_replace('.', '', preg_replace("([ ]+)", "", $descuentos[$i]['nombre'])));
        }

        return $descuentos;

    }

    public function mesContableEstaHabilitado($empresa_id, $oficina_id, $fecha, $Conex)
    {

        $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND
	                  oficina_id = $oficina_id AND '$fecha' BETWEEN fecha_inicio AND fecha_final";
        $result = $this->DbFetchAll($select, $Conex);

        $this->mes_contable_id = $result[0]['mes_contable_id'];

        return $result[0]['estado'] == 1 ? true : false;

    }

    public function PeriodoContableEstaHabilitado($Conex)
    {

        $mes_contable_id = $this->mes_contable_id;

        if (!is_numeric($mes_contable_id)) {
            return false;
        } else {
            $select = "SELECT estado FROM periodo_contable WHERE periodo_contable_id = (SELECT periodo_contable_id FROM
                         mes_contable WHERE mes_contable_id = $mes_contable_id)";
            $result = $this->DbFetchAll($select, $Conex);
            return $result[0]['estado'] == 1 ? true : false;
        }

    }

    public function sumadebitocredito($liquidacion_despacho_descu_id, $Conex)
    {

        if (is_numeric($liquidacion_despacho_descu_id)) {
            $select = "SELECT SUM(a.debito) AS debito,	SUM(a.credito) AS credito
					  FROM detalle_liquidacion_despacho_descu  a WHERE a.liquidacion_despacho_descu_id=$liquidacion_despacho_descu_id AND a.valor>0";
            $result = $this->DbFetchAll($select, $Conex, true);
            return $result;
        }

    }

    public function getContabilizarReg($liquidacion_despacho_descu_id, $empresa_id, $oficina_id, $usuario_id, $Conex)
    {

        include_once "UtilidadesContablesModelClass.php";

        $utilidadesContables = new UtilidadesContablesModel();

        $this->Begin($Conex);

        $select = "SELECT a.*,
						  (SELECT proveedor_id FROM proveedor WHERE tercero_id=a.tercero_id) AS proveedor_id,
						  (SELECT fp.factura_proveedor_id FROM liquidacion_despacho ld, factura_proveedor fp WHERE ld.manifiesto_id=a.manifiesto_id AND fp.liquidacion_despacho_id=ld.liquidacion_despacho_id AND fp.estado_factura_proveedor='C' LIMIT 1 ) AS causaciones_abono_factura
						  FROM liquidacion_despacho_descu a WHERE a.liquidacion_despacho_descu_id=$liquidacion_despacho_descu_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        if ($result[0]['estado_liquidacion'] == 'C') {
            exit('Esta liquidacion ya esta Contabilizada');
        }

        if (!$result[0]['proveedor_id'] > 0) {
            exit('Por favor primero cree el Tercero como Proveedor');
        }

        if ($result[0]['causaciones_abono_factura'] > 0) {

            $numero_soporte = $result[0]['numero_despacho'];
            $tipo_documento_id = $result[0]['tipo_documento_id'];
            $proveedor_id = $result[0]['proveedor_id'];
            $tercero_id1 = $result[0]['tercero_id'];
            $fecha = $result[0]['fecha'];
            $valor_descuentos = $result[0]['valor_descuentos'];
            $concepto_abono_factura = 'DESCUENTOS ' . $result[0]['concepto'];
            $causaciones_abono_factura = $result[0]['causaciones_abono_factura'] . ',';
            $causaciones = $result[0]['causaciones_abono_factura'];
            $valores_abono_factura = $result[0]['valor_descuentos'] . '=';
            $ingreso_abono_factura = date('Y-m-d H:i');
            $estado_abono_factura = 'A';
        } else {
            exit('El ' . $result[0]['concepto'] . ' No esta Causado,<br> por tal motivo No se puede contabilizar el descuento');
        }
        $abono_factura_proveedor_id = $this->DbgetMaxConsecutive("abono_factura_proveedor", "abono_factura_proveedor_id", $Conex, true, 1);
        $insert = "INSERT INTO abono_factura_proveedor (abono_factura_proveedor_id,tipo_documento_id,proveedor_id,fecha,valor_abono_factura,valor_neto_factura,concepto_abono_factura,causaciones_abono_factura,valores_abono_factura,usuario_id,oficina_id,ingreso_abono_factura,estado_abono_factura)
					VALUES ($abono_factura_proveedor_id,$tipo_documento_id,$proveedor_id,'$fecha','$valor_descuentos',$valor_descuentos,'$concepto_abono_factura','$causaciones_abono_factura','$valores_abono_factura',$usuario_id,$oficina_id,'$ingreso_abono_factura','$estado_abono_factura')";
        $this->query($insert, $Conex, true);

        $relacion_abono_factura_id = $this->DbgetMaxConsecutive("relacion_abono_factura", "relacion_abono_factura_id", $Conex, true, 1);
        $insert_item = "INSERT INTO relacion_abono_factura (relacion_abono_factura_id,factura_proveedor_id,abono_factura_proveedor_id,rel_valor_abono_factura)
					VALUES ($relacion_abono_factura_id,$causaciones,$abono_factura_proveedor_id,'$valor_descuentos')";
        $this->query($insert_item, $Conex, true);

        $select_item = "SELECT a.*
					  FROM detalle_liquidacion_despacho_descu  a WHERE a.liquidacion_despacho_descu_id=$liquidacion_despacho_descu_id AND a.valor>0";
        $result_item = $this->DbFetchAll($select_item, $Conex, true);

        for ($j = 0; $j < count($result_item); $j++) {

            $item_abono_factura_id = $this->DbgetMaxConsecutive("item_abono_factura", "item_abono_factura_id", $Conex, true, 1);
            $puc_contra = $result_item[$j]['puc_id'];
            $tercero_id = $result_item[$j]['tercero_id'];
            $numero_identificacion = $result_item[$j]['numero_identificacion'];
            $digito_verificacion = $result_item[$j]['digito_verificacion'] > 0 ? $result_item[$j]['digito_verificacion'] : 'NULL';
            $centro_costo = $result_item[$j]['centro_de_costo_id'];
            $codigo_centro_costo = $result_item[$j]['codigo_centro_costo'];
            $porcen_contra = $result_item[$j]['porcentaje'];
            $formul_contra = $result_item[$j]['formula'];
            $nombre_contra = $result_item[$j]['descripcion'];
            $debito_contra = $result_item[$j]['debito'];
            $credito_contra = $result_item[$j]['credito'];

            $insert_contra = "INSERT INTO item_abono_factura (
									item_abono_factura_id,
									abono_factura_proveedor_id,
									relacion_abono_factura_id,
									puc_id,
									tercero_id,
								 	numero_identificacion,
									digito_verificacion,
									centro_de_costo_id,
									codigo_centro_costo,
									porcentaje_abono_factura,
									formula_abono_factura,
									desc_abono_factura,
									deb_item_abono_factura,
									cre_item_abono_factura)
							VALUES (
									$item_abono_factura_id,
									$abono_factura_proveedor_id,
									$relacion_abono_factura_id,
									$puc_contra,
									$tercero_id,
									$numero_identificacion,
									$digito_verificacion,
									$centro_costo,
									'$codigo_centro_costo',
									'$porcen_contra',
									'$formul_contra',
									'$nombre_contra',
									'$debito_contra',
									'$credito_contra'
							)";
            $this->query($insert_contra, $Conex, true);

        }

        $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);

        $valor = $valor_descuentos;
        $numero_soporte = $result[0]['concepto_abono_factura'];
        $tercero_id = $tercero_id1;
        $num_cheque = 'NULL';
        $fechaMes = substr($fecha, 0, 10);
        $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fechaMes, $Conex);
        $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex);
        $consecutivo = $utilidadesContables->getConsecutivo($oficina_id, $tipo_documento_id, $periodo_contable_id, $Conex);
        $concepto = $concepto_abono_factura;

        $puc_id = $result[0]['puc_contra'];
        $fecha_registro = date("Y-m-d H:m");
        $numero_documento_fuente = $result[0]['consecutivo'];
        $id_documento_fuente = $abono_factura_proveedor_id;
        $con_fecha_abono_factura = $fecha_registro;
        $cuenta_tipo_pago_id = $result[0][cuenta_tipo_pago_id];

        $select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t
						WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
        $result_usu = $this->DbFetchAll($select_usu, $Conex, true);
        $modifica = $result_usu[0]['usuario'];

        $insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
							mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
							VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor',$num_cheque,$tercero_id,$periodo_contable_id,
							$mes_contable_id,$consecutivo,'$fecha','$concepto','C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)";

        $this->query($insert, $Conex, true);

        $select_item = "SELECT item_abono_factura_id FROM item_abono_factura WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id";
        $result_item = $this->DbFetchAll($select_item, $Conex);

        foreach ($result_item as $result_items) {

            $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
            $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,porcentaje,formula,debito,credito)
							SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_abono_factura,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_abono_factura+cre_item_abono_factura),base_abono_factura,porcentaje_abono_factura,
							formula_abono_factura,deb_item_abono_factura,cre_item_abono_factura
							FROM item_abono_factura WHERE abono_factura_proveedor_id=$abono_factura_proveedor_id AND item_abono_factura_id=$result_items[item_abono_factura_id]";
            $this->query($insert_item, $Conex, true);

        }
        if (strlen($this->GetError()) > 0) {
            $this->Rollback($Conex);
        } else {

            $update = "UPDATE abono_factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,
						estado_abono_factura= 'C',
						con_usuario_id = $usuario_id,
						con_fecha_abono_factura='$con_fecha_abono_factura'
					WHERE abono_factura_proveedor_id =$abono_factura_proveedor_id";
            $this->query($update, $Conex, true);

            $update = "UPDATE liquidacion_despacho_descu SET encabezado_registro_id=$encabezado_registro_id,
						estado_liquidacion= 'C'
					WHERE liquidacion_despacho_descu_id =$liquidacion_despacho_descu_id";
            $this->query($update, $Conex, true);

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);

            } else {
                $this->Commit($Conex);
                return true;
            }
        }
    }

    //// GRID ////
    public function getQueryManifiestosGrid($oficina_id, $colsImpuestos, $colsDescuentos)
    {

        for ($i = 0; $i < count($colsImpuestos); $i++) {
            $column = $colsImpuestos[$i]['nombre'];
            $comparar = $colsImpuestos[$i]['comparar'];
            $columnsImpuestos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho_descu WHERE impuesto = 1 AND impuestos_manifiesto_id IN (SELECT impuestos_manifiesto_id
	   FROM impuestos_manifiesto ip WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND ip.manifiesto_id = m.manifiesto_id)) AS $column,";
        }

        for ($i = 0; $i < count($colsDescuentos); $i++) {
            $column = $colsDescuentos[$i]['nombre'];
            $comparar = $colsDescuentos[$i]['comparar'];
            $columnsDescuentos .= "(SELECT SUM(valor) FROM detalle_liquidacion_despacho_descu WHERE descuento = 1 AND descuentos_manifiesto_id IN (SELECT descuentos_manifiesto_id
	   FROM descuentos_manifiesto dm WHERE UPPER(TRIM(nombre)) = UPPER(TRIM('$comparar')) AND dm.manifiesto_id = m.manifiesto_id)) AS $column,";
        }

        $Query = "SELECT m.manifiesto,m.fecha_mc AS fecha_manifiesto,ld.fecha AS fecha_liquidacion,(SELECT nombre FROM oficina WHERE oficina_id = ld.oficina_id) AS lugar_autorizado_pago, m.placa,m.numero_identificacion_tenedor,m.tenedor,ld.valor_despacho+ld.valor_sobre_flete AS valor_total,
	 (SELECT SUM(valor) FROM detalle_liquidacion_despacho_descu dld WHERE anticipo = 1 AND liquidacion_despacho_descu_id = ld.liquidacion_despacho_descu_id) AS anticipos,$columnsImpuestos $columnsDescuentos ld.saldo_por_pagar
	 FROM liquidacion_despacho ld, manifiesto m WHERE ld.manifiesto_id = m.manifiesto_id";

        return $Query;
    }

}
