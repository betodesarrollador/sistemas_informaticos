<?php

require_once "../../../framework/clases/DbClass.php";
require_once "../../../framework/clases/PermisosFormClass.php";

final class ManifiestosModel extends Db
{

    public function selectRemesasManifiesto($manifiesto_id, $Conex)
    {

        $select = "SELECT numero_remesa,remesa_id FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE
	manifiesto_id = $manifiesto_id)";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }
    public function selectEstadoManifiesto($manifiesto_id, $Conex)
    {

        $select = "SELECT estado FROM manifiesto WHERE manifiesto_id = $manifiesto_id ";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result[0]['estado'];

    }

    public function selectDivipolaUbicacion($ubicacion_id, $Conex)
    {

        $select = "SELECT divipola FROM ubicacion WHERE ubicacion_id = $ubicacion_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result[0]['divipola'];

    }

    public function getRutas($origen_id, $destino_id, $Conex)
    {

        $select = "SELECT ruta_id AS value,CONCAT_WS(' / ',ruta,pasador_vial) AS text FROM ruta
	WHERE ruta_id IN (SELECT d.ruta_id FROM detalle_ruta d WHERE d.ubicacion_id=$origen_id AND punto_referencia_id IS NULL )
	AND ruta_id IN (SELECT d.ruta_id FROM detalle_ruta d WHERE d.ubicacion_id=$destino_id AND punto_referencia_id IS NULL ) ";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function mesContableEstaHabilitado($empresa_id, $oficina_id, $fecha_mc, $Conex)
    {

        $select = "SELECT mes_contable_id,estado FROM mes_contable WHERE empresa_id = $empresa_id AND
		oficina_id = $oficina_id AND '$fecha_mc' BETWEEN fecha_inicio AND fecha_final";
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
    public function ValidaAnticipo($manifiesto_id, $Conex)
    {

        $select_antic = "SELECT anticipos_manifiesto_id FROM anticipos_manifiesto WHERE manifiesto_id=$manifiesto_id AND encabezado_registro_id IS NULL";

        $result = $this->DbFetchAll($select_antic, $Conex);

        $this->anticipos_manifiesto_id = $result[0]['anticipos_manifiesto_id'];

        return $result[0]['anticipos_manifiesto_id'] > 0 ? true : false;

    }

    public function getContabilizarReg($manifiesto_id, $empresa_id, $oficina_id, $usuario_id, $mesContable, $periodoContable, $Conex)
    {

        //$this->Begin($Conex);

        ///INICIO BLOQUE CONTABILIZAR

        $select_contab = "SELECT m.*, (SELECT consecutivo FROM encabezado_de_registro WHERE encabezado_registro_id=m.encabezado_registro_id) AS consecutivo_contable
		FROM manifiesto m WHERE m.manifiesto_id=$manifiesto_id";
        $result_contab = $this->DbFetchAll($select_contab, $Conex);

        if ($result_contab[0]['valor_flete'] == 0) {
            exit("No se permite contabilizar Manifiestos en valor cero (0).");
        }

        if ($result_contab[0]['encabezado_registro_id'] > 0 && $result_contab[0]['encabezado_registro_id'] != '') {
            exit('Ya se contabilizo previamente el Manifiesto, con el documento contable: ' . $result_contab[0]['consecutivo_contable'] . '.<br>Por favor Verifique.');
        }

        $select_param_contab = "SELECT * FROM parametros_liquidacion WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id";
        $result_param_contab = $this->DbFetchAll($select_param_contab, $Conex);

        if (!count($result_param_contab) > 0) {
            print "<p align='center'>No ha ingresado los parametros de liquidacion!!<br>estos parametros se asignan por Paramtros Modulo -> Liquidacion</p>";
            $this->RollBack($Conex);
            exit();
        } else {

            $tipo_documento_id = $result_param_contab[0]['tipo_documento_id'];
            $flete_pactado_id = $result_param_contab[0]['flete_pactado_id'];
            $naturaleza_flete_pactado = $result_param_contab[0]['naturaleza_flete_pactado'];

            $saldo_por_pagar_id = $result_param_contab[0]['saldo_por_pagar_id'];
            $naturaleza_saldo_por_pagar = $result_param_contab[0]['naturaleza_saldo_por_pagar'];
            $saldo_por_pagar = 0;

            if (!is_numeric($flete_pactado_id)) {
                exit("<div align='center'>Aun no ha parametrizado la cuenta contable para concepto de flete</div>
				<div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");
            }

            if (!is_numeric($saldo_por_pagar_id)) {
                exit("<div align='center'><b>Aun no ha parametrizado la cuenta contable para concepto de saldo pagar</b></div>
				<div align='center'><br><b>modulo de Transporte -> Parametros Modulo -> Liquidacion</b></div>");
            }

        }

        $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);
        $valor = $result_contab[0]['valor_flete'];
        $valor_flete = $valor;
        $numero_soporte = $result_contab[0]['manifiesto'];

        $saldo_por_pagar = $result_contab[0]['saldo_por_pagar'];
        $tenedor_id = $result_contab[0]['tenedor_id'];
        $numero_identificacion_titular = $result_contab[0]['numero_identificacion_titular_manifiesto'];
        $observaciones = $result_contab[0]['observaciones'];
        $anticipo_id = $result_param_contab[0]['anticipo_id'];
        $liquidacion_despacho_id = $this->DbgetMaxConsecutive("liquidacion_despacho", "liquidacion_despacho_id", $Conex, true, 1);
        $fuente_servicio_cod = 'MC';
        $estado_liquidacion = 'L';
        $oficina_pago_id = $result_contab[0]['oficina_pago_saldo_id'];
        $oficina_id = $result_contab[0]['oficina_id'];

        $select = "SELECT nombre FROM oficina WHERE oficina_id = $oficina_pago_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $LugarPago = $result[0]['nombre'];

        $select1 = "SELECT * FROM centro_de_costo WHERE oficina_id = $oficina_id";
        $result1 = $this->DbFetchAll($select1, $Conex, true);

        $centro_de_costo_id = $result1[0]['centro_de_costo_id'];
        $codigo_centro_costo = strlen(trim($result1[0]['codigo'])) > 0 ? "'" . $result1[0]['codigo'] . "'" : 'NULL';

        $select2 = "SELECT t.digito_verificacion, t.tercero_id FROM tercero t, tenedor te WHERE te.tenedor_id = $tenedor_id AND te.tercero_id=t.tercero_id";
        $result2 = $this->DbFetchAll($select2, $Conex, true);
        $tercero_id = $result2[0]['tercero_id'];
        $digito_verificacion_titular = strlen(trim($result2[0]['digito_verificacion'])) > 0 ? $result2[0]['digito_verificacion'] : 'NULL';

        $factura_proveedor_id = $this->DbgetMaxConsecutive("factura_proveedor", "factura_proveedor_id", $Conex, true, 1);
        $detalle_liquidacion_despacho_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho", "detalle_liquidacion_despacho_id", $Conex, true, 1);

        include_once "UtilidadesContablesModelClass.php";

        $utilidadesContables = new UtilidadesContablesModel();

        $fecha = date("Y-m-d");
        $vence_factura_proveedor = $result_contab[0]['fecha_pago_saldo'];
        $fechaMes = substr($fecha, 0, 10);

        $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fecha, $Conex);
        $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex);

        if ($mes_contable_id > 0 && $periodo_contable_id > 0) {
            $consecutivo = $result_contab[0]['manifiesto'];

            $concepto = 'Liquidacion MC ' . ' ' . $numero_soporte;
            $fecha_registro = date("Y-m-d H:m");
            $modifica = $result_contab[0]['usuario_registra'];
            $numero_documento_fuente = $numero_soporte;
            $id_documento_fuente = $result_contab[0]['manifiesto_id'];

            $insert_liquidacion = "INSERT INTO liquidacion_despacho (liquidacion_despacho_id,consecutivo,concepto,manifiesto_id,fecha,tipo_documento_id,tercero_id,
			centro_de_costo_id,numero_despacho,valor_despacho,saldo_por_pagar,fuente_servicio_cod,oficina_id,observaciones,estado_liquidacion)
			VALUES ($liquidacion_despacho_id,$numero_soporte,'MC: $numero_soporte   Lugar Autorizado Para Pago : $LugarPago',$manifiesto_id,'$fecha',$tipo_documento_id,
			$tercero_id,$centro_de_costo_id,'$numero_soporte',$valor,$saldo_por_pagar,'$fuente_servicio_cod',$oficina_pago_id,'$observaciones','$estado_liquidacion');";
            //echo $insert_liquidacion.'<hr>';
            $this->query($insert_liquidacion, $Conex, true);

            if ($this->GetNumError() > 0) {
                $this->RollBack($Conex);
                exit('Error al Generar Liquidacion.');
            } else {
                if ($naturaleza_flete_pactado == 'D') {
                    $debito = $valor;
                    $credito = 0;
                } else {
                    $debito = 0;
                    $credito = $valor;
                }

                $puc_id = $flete_pactado_id;

                if ($utilidadesContables->requiereTercero($puc_id, $Conex)) {
                    $tercero_liquidacion_id = $tercero_id;
                    $numero_identificacion_liquidacion = $numero_identificacion;
                    $digito_verificacion_liquidacion = $digito_verificacion;
                } else {
                    $tercero_liquidacion_id = 'NULL';
                    $numero_identificacion_liquidacion = 'NULL';
                    $digito_verificacion_liquidacion = 'NULL';
                }

                if ($utilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                    $centro_costo_liquidacion_id = $centro_de_costo_id;
                    $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                } else {
                    $centro_costo_liquidacion_id = 'NULL';
                    $codigo_centro_costo_liquidacion = 'NULL';
                }

                $descripcion = "FLETE PACTADO MC: $numero_soporte ";

                $insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,descripcion,tercero_id,
				numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,debito,credito,valor,contrapartida,valor_flete,valor_sobre_flete)
				VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,$puc_id,'$descripcion',$tercero_id,$numero_identificacion_titular,
				$digito_verificacion_titular,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$debito,$credito,$valor,0,1,0);";
                //echo $insert.'<hr>';
                $this->query($insert, $Conex, true);

                $select_item = "SELECT * FROM impuestos_manifiesto WHERE manifiesto_id=$manifiesto_id";
                $result_item = $this->DbFetchAll($select_item, $Conex);

                if (is_array($result_item)) {

                    $impuestos = $result_item;
                    $base = $valor;

                    for ($i = 0; $i < count($impuestos); $i++) {

                        $detalle_liquidacion_despacho_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho", "detalle_liquidacion_despacho_id", $Conex, true, 1);
                        $impuestos_manifiesto_id = $impuestos[$i]['impuestos_manifiesto_id'];
                        $impuesto_id = $impuestos[$i]['impuesto_id'];
                        $nombre = $impuestos[$i]['nombre'];
                        $base = $impuestos[$i]['base'] > 0 ? $impuestos[$i]['base'] : 'NULL';
                        $valor = $this->removeFormatCurrency($impuestos[$i]['valor']);

                        $select = "SELECT i.* FROM tabla_impuestos ti, impuesto i WHERE ti.empresa_id = $empresa_id AND ti.oficina_id = $oficina_id
						AND ti.impuesto_id = $impuesto_id AND ti.impuesto_id = i.impuesto_id";
                        $result = $this->DbFetchAll($select, $Conex, true);

                        if (!count($result) > 0) {
                            //echo 'ENTRA';
                            $select = "SELECT i.* FROM impuesto_oficina im, impuesto i, tabla_impuestos ti WHERE im.oficina_id  = $oficina_id
							AND ti.impuesto_id = $impuesto_id AND ti.impuesto_id = i.impuesto_id AND ti.tabla_impuestos_id = im.tabla_impuestos_id";
                            $result = $this->DbFetchAll($select, $Conex, true);

                        }

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

                            if ($utilidadesContables->requiereTercero($puc_id, $Conex)) {
                                $tercero_liquidacion_id = $tercero_id;
                                $numero_identificacion_liquidacion = $numero_identificacion;
                                $digito_verificacion_liquidacion = $digito_verificacion;
                            } else {
                                $tercero_liquidacion_id = 'NULL';
                                $numero_identificacion_liquidacion = 'NULL';
                                $digito_verificacion_liquidacion = 'NULL';
                            }

                            if ($utilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                                $centro_costo_liquidacion_id = $centro_de_costo_id;
                                $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                            } else {
                                $centro_costo_liquidacion_id = 'NULL';
                                $codigo_centro_costo_liquidacion = 'NULL';
                            }

                            $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fecha, $Conex);

                            $select = "SELECT porcentaje,formula FROM impuesto_periodo_contable WHERE impuesto_id = $impuesto_id AND periodo_contable_id
							= $periodo_contable_id";

                            $dataImpuesto = $this->DbFetchAll($select, $Conex);

                            if (count($dataImpuesto) > 0) {

                                $porcentaje = $dataImpuesto[0]['porcentaje'];
                                $formula = $dataImpuesto[0]['formula'];
                                $descripcion = "$nombre MC: $numero_soporte";

                                $insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,descripcion,
								tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base,debito,credito,valor,porcentaje,formula,
								contrapartida,impuesto,valor_sobre_flete,impuestos_manifiesto_id)
								VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,$puc_id,'$descripcion',$tercero_id,$numero_identificacion_titular,
								$digito_verificacion_titular,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$base,$debito,$credito,$valor,$porcentaje,
								'$formula',0,1,0,$impuestos_manifiesto_id);";
                                // echo $insert;
                                $this->query($insert, $Conex, true);
                            } else {
                                $anio = substr($fecha, 0, 4);
                                exit("No existen parametros para el impuesto [ $nombre ] en el periodo $anio");
                            }

                        } else {
                            print "No ha configurado el impuesto [ $nombre ] en modulo de transporte!!!  $select";
                            $this->RollBack($Conex);
                            exit();
                        }

                    }

                }

                $select_item1 = "SELECT * FROM anticipos_manifiesto WHERE manifiesto_id=$manifiesto_id";
                $result_item1 = $this->DbFetchAll($select_item1, $Conex);

                if (is_array($result_item1)) {

                    $anticipos = $result_item1;
                    $base = $valor;

                    for ($i = 0; $i < count($anticipos); $i++) {

                        $detalle_liquidacion_despacho_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho", "detalle_liquidacion_despacho_id", $Conex, false, 1);

                        $anticipos_manifiesto_id = $anticipos[$i]['anticipos_manifiesto_id'];

                        if (is_numeric($anticipos_manifiesto_id)) {

                            $valor = $this->removeFormatCurrency($anticipos[$i]['valor']);
                            $numero_anticipo = $anticipos[$i]['numero'];
                            $puc_id = $anticipo_id;

                            if ($naturaleza_anticipo == 'D') {
                                $debito = $valor;
                                $credito = 0;
                            } else {
                                $debito = 0;
                                $credito = $valor;
                            }

                            //$saldo_por_pagar = ($saldo_por_pagar - $valor);

                            if ($utilidadesContables->requiereTercero($puc_id, $Conex)) {

                                $tercero_liquidacion_id = $tercero_id;
                                $numero_identificacion_liquidacion = $numero_identificacion;
                                $digito_verificacion_liquidacion = $digito_verificacion;

                            } else {
                                $tercero_liquidacion_id = 'NULL';
                                $numero_identificacion_liquidacion = 'NULL';
                                $digito_verificacion_liquidacion = 'NULL';
                            }

                            if ($utilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                                $centro_costo_liquidacion_id = $centro_de_costo_id;
                                $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                            } else {
                                $centro_costo_liquidacion_id = 'NULL';
                                $codigo_centro_costo_liquidacion = 'NULL';
                            }

                            $detalle_liquidacion_despacho_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho", "detalle_liquidacion_despacho_id", $Conex, false, 1);

                            $descripcion = "ANTICIPO $numero_anticipo MC: $numero_soporte";

                            $insert = "INSERT INTO detalle_liquidacion_despacho (detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,descripcion,tercero_id,
							numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,debito,credito,valor,contrapartida,anticipo,
							anticipos_manifiesto_id)
							VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,$puc_id,'$descripcion',$tercero_id,$numero_identificacion_titular,
							$digito_verificacion_titular,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$debito,$credito,$valor,0,1,
					  $anticipos_manifiesto_id);"; //echo $insert;
                            //    echo $insert;
                            $this->query($insert, $Conex, true);

                            $update = "UPDATE anticipos_manifiesto SET detalle_liquidacion_despacho_id = $detalle_liquidacion_despacho_id
					  WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id";

                            $this->query($update, $Conex, true);

                        }

                    }

                }

                if ($saldo_por_pagar > 0) {

                    if ($naturaleza_saldo_por_pagar == 'D') {
                        $debito = $saldo_por_pagar;
                        $credito = 0;
                    } else {
                        $debito = 0;
                        $credito = $saldo_por_pagar;
                    }
                    $valor = $saldo_por_pagar;
                    $puc_id = $saldo_por_pagar_id;

                    if ($utilidadesContables->requiereTercero($puc_id, $Conex)) {
                        $tercero_liquidacion_id = $tercero_id;
                        $numero_identificacion_liquidacion = $numero_identificacion;
                        $digito_verificacion_liquidacion = $digito_verificacion;
                    } else {
                        $tercero_liquidacion_id = 'NULL';
                        $numero_identificacion_liquidacion = 'NULL';
                        $digito_verificacion_liquidacion = 'NULL';
                    }

                    if ($utilidadesContables->requiereCentroCosto($puc_id, $Conex)) {
                        $centro_costo_liquidacion_id = $centro_de_costo_id;
                        $codigo_centro_costo_liquidacion = $codigo_centro_costo;
                    } else {
                        $centro_costo_liquidacion_id = 'NULL';
                        $codigo_centro_costo_liquidacion = 'NULL';
                    }

                    $detalle_liquidacion_despacho_id = $this->DbgetMaxConsecutive("detalle_liquidacion_despacho", "detalle_liquidacion_despacho_id", $Conex, false, 1);

                    $descripcion = "SALDO MC: $numero_soporte";

                    $insert = "INSERT INTO detalle_liquidacion_despacho(detalle_liquidacion_despacho_id,liquidacion_despacho_id,puc_id,descripcion,tercero_id,
					numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,debito,credito,valor,contrapartida,saldo_pagar)
					VALUES ($detalle_liquidacion_despacho_id,$liquidacion_despacho_id,$puc_id,'$descripcion',$tercero_id,$numero_identificacion_titular,
					$digito_verificacion_titular,$centro_costo_liquidacion_id,$codigo_centro_costo_liquidacion,$debito,$credito,$valor,1,1);";
                    //echo  $insert.'<hr/ >';
                    $this->query($insert, $Conex, true);

                }
                //BLOQUE PARA CALCULAR VALOR COSTO DE REMESAS
                $select = "SELECT * FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id =
					$manifiesto_id) AND clase_remesa = 'NN'";
                $remesas = $this->DbFetchAll($select, $Conex, true);

                $valor_facturar_total = 0;

                for ($i = 0; $i < count($remesas); $i++) {

                    $valor_facturar_total = $valor_facturar_total + $remesas[$i]['valor_facturar'];

                    if (!$remesas[$i]['valor_facturar'] > 0) {
                        $this->RollBack($Conex);
                        exit("<div align='center'>¡Debe liquidar todas las remesa del manifiesto!</div>");
                    }

                }
                if ($valor_facturar_total > 0) {

                    for ($i = 0; $i < count($remesas); $i++) {

                        $remesa_id = $remesas[$i]['remesa_id'];
                        $valor_facturar = $remesas[$i]['valor_facturar'];
                        $porcentaje = ($valor_facturar / $valor_facturar_total) * 100;
                        $valor_costo = round(($porcentaje * $valor_flete) / 100);

                        $update = "UPDATE remesa SET valor_costo = $valor_costo WHERE remesa_id = $remesa_id";

                        $this->query($update, $Conex, true);

                    }

                } else {

                    if (count($remesas) > 0) {
                        $this->RollBack($Conex);
                        exit("<div align='center'>¡Debe liquidar las remesas de este manifiesto!</div>");
                    }

                }
                // FIN BLOQUE CALCULAR VALOR COSTO REMESAS
            }

            //causacion
            $factura_proveedor_id = $this->DbgetMaxConsecutive("factura_proveedor", "factura_proveedor_id", $Conex, true, 1);
            $fuente_servicio_cod = 'MC';
            $fecha_factura_proveedor = $fecha;

            $ingreso_factura_proveedor = date('Y-m-d H:m');
            $valor = $saldo_por_pagar;
            $concepto_factura_proveedor = 'CAUSACION MC: ' . $numero_soporte;

            $select = "SELECT l.tercero_id,
				(SELECT proveedor_id FROM proveedor WHERE tercero_id=l.tercero_id) AS proveedor_id
				FROM liquidacion_despacho l
				WHERE l.liquidacion_despacho_id=$liquidacion_despacho_id";

            $result = $this->DbFetchAll($select, $Conex, true);

            if ($result[0]['proveedor_id'] != 0 && $result[0]['proveedor_id'] != '' && $result[0]['proveedor_id'] != null) {
                $proveedor_id = $result[0]['proveedor_id'];
            } else {
                $proveedor_id = $this->DbgetMaxConsecutive("proveedor", "proveedor_id", $Conex, true, 1);

                $insert = "INSERT INTO proveedor (proveedor_id,tercero_id,estado_proveedor,autoret_proveedor,retei_proveedor)
			VALUES ($proveedor_id,$tercero_id,'A','N','N')";
                $this->query($insert, $Conex, true);

            }

            $insert = "INSERT INTO factura_proveedor (factura_proveedor_id,liquidacion_despacho_id,codfactura_proveedor,valor_factura_proveedor,fecha_factura_proveedor,vence_factura_proveedor,concepto_factura_proveedor,proveedor_id,fuente_servicio_cod,estado_factura_proveedor,usuario_id,oficina_id,ingreso_factura_proveedor)
		VALUES ($factura_proveedor_id,$liquidacion_despacho_id,'$numero_soporte',$valor,'$fecha_factura_proveedor','$vence_factura_proveedor','$concepto_factura_proveedor',$proveedor_id,'$fuente_servicio_cod','A',$usuario_id,$oficina_id,'$ingreso_factura_proveedor')";
            //echo $insert;
            $this->query($insert, $Conex, true);

            $this->assignValRequest('factura_proveedor_id', $factura_proveedor_id);

            $select_item = "SELECT d.detalle_liquidacion_despacho_id  FROM  factura_proveedor f,   detalle_liquidacion_despacho d
		    WHERE f.factura_proveedor_id=$factura_proveedor_id AND d.liquidacion_despacho_id=f.liquidacion_despacho_id AND d.valor>0";
            $result_item = $this->DbFetchAll($select_item, $Conex, true);

            foreach ($result_item as $result_items) {

                $item_factura_proveedor_id = $this->DbgetMaxConsecutive("item_factura_proveedor", "item_factura_proveedor_id", $Conex, true, 1);
                $insert = "INSERT INTO item_factura_proveedor (item_factura_proveedor_id,factura_proveedor_id,puc_id,tercero_id,numero_identificacion,digito_verificacion,centro_de_costo_id,codigo_centro_costo,base_factura_proveedor,porcentaje_factura_proveedor,formula_factura_proveedor,desc_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor,contra_factura_proveedor)
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
                $this->query($insert, $Conex, true);
                //echo $insert;

            }

            if (!strlen(trim($this->GetError())) > 0) {

                $update = "UPDATE liquidacion_despacho  SET estado_liquidacion='C'
			WHERE   liquidacion_despacho_id = $liquidacion_despacho_id";
                $this->query($update, $Conex, true);
            }

            $select = "SELECT f.factura_proveedor_id,
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

            $result = $this->DbFetchAll($select, $Conex, true);

            $select_sum = "SELECT SUM(deb_item_factura_proveedor) AS debito, SUM(cre_item_factura_proveedor) AS credito FROM  item_factura_proveedor
		WHERE factura_proveedor_id=$factura_proveedor_id ";
            $result_sum = $this->DbFetchAll($select_sum, $Conex, true);
            //echo $result_sum[0][debito].'-'.$result_sum[0][credito];
            if ($result_sum[0][debito] != $result_sum[0][credito]) {
                $this->Rollback($Conex);
                exit("<div align='center'>Debe parametrizar correctamente las cuentas, Las sumas de debito y credito no son iguales!!! <br> Debito: $" . number_format($result_sum[0][debito], 2, ",", ".") . " - Credito: $" . number_format($result_sum[0][credito], 2, ",", ".") . "</div>");
            }

            $select_usu = "SELECT CONCAT_WS(' ',t.primer_nombre, t.segundo_nombre, t.primer_apellido, t.segundo_apellido) AS usuario FROM usuario u, tercero t
		WHERE u.usuario_id=$usuario_id AND t.tercero_id=u.tercero_id";
            $result_usu = $this->DbFetchAll($select_usu, $Conex);

            $encabezado_registro_id = $this->DbgetMaxConsecutive("encabezado_de_registro", "encabezado_registro_id", $Conex, true, 1);
            $tipo_documento_id = $result[0]['tipo_documento'];
            $valor = $result[0]['valor_factura_proveedor'];
            $numero_soporte = $result[0]['codfactura_proveedor'] != '' ? $result[0]['codfactura_proveedor'] : $result[0]['numero_soporte_ord'];
            $tercero_id = $result[0]['tercero'];

            $fechaMes = substr($result[0]['fecha_factura_proveedor'], 0, 10);

            $periodo_contable_id = $utilidadesContables->getPeriodoContableId($fechaMes, $Conex);
            $mes_contable_id = $utilidadesContables->getMesContableId($fechaMes, $periodo_contable_id, $Conex);
            $consecutivo = $utilidadesContables->getConsecutivo($oficina_id, $tipo_documento_id, $periodo_contable_id, $Conex);

            $fecha = $result[0]['fecha_factura_proveedor'];
            $concepto = $result[0]['concepto_factura_proveedor'];
            $puc_id = $result[0]['puc_contra'] != '' ? $result[0]['puc_contra'] : 'NULL';
            $fecha_registro = date("Y-m-d H:m");
            $modifica = $result_usu[0]['usuario'];
            $fuente_servicio_cod = $result[0]['fuente_servicio_cod'];
            $numero_documento_fuente = $numero_soporte;
            $id_documento_fuente = $result[0]['factura_proveedor_id'];
            $liquidacion_despacho_id = $result[0]['liquidacion_despacho_id'];
            $con_fecha_factura_prov = $fecha_registro;

            $insert = "INSERT INTO encabezado_de_registro (encabezado_registro_id,empresa_id,oficina_id,tipo_documento_id,valor,numero_soporte,tercero_id,periodo_contable_id,
		mes_contable_id,consecutivo,fecha,concepto,estado,fecha_registro,modifica,usuario_id,numero_documento_fuente,id_documento_fuente)
		VALUES($encabezado_registro_id,$empresa_id,$oficina_id,$tipo_documento_id,'$valor','$numero_soporte',$tercero_id,$periodo_contable_id,
		$mes_contable_id,$consecutivo,'$fecha','$concepto','C','$fecha_registro','$modifica',$usuario_id,'$numero_documento_fuente',$id_documento_fuente)";

            //echo $insert;
            $this->query($insert, $Conex, true);

            $select_item = "SELECT item_factura_proveedor_id  FROM  item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id";
            $result_item = $this->DbFetchAll($select_item, $Conex);
            foreach ($result_item as $result_items) {
                $imputacion_contable_id = $this->DbgetMaxConsecutive("imputacion_contable", "imputacion_contable_id", $Conex, true, 1);
                $insert_item = "INSERT INTO imputacion_contable (imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,descripcion,encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,valor,base,	porcentaje,formula,debito,credito)
			SELECT  $imputacion_contable_id,tercero_id,numero_identificacion,digito_verificacion,puc_id,desc_factura_proveedor,$encabezado_registro_id,centro_de_costo_id,codigo_centro_costo,(deb_item_factura_proveedor+cre_item_factura_proveedor),base_factura_proveedor,porcentaje_factura_proveedor,
			formula_factura_proveedor,deb_item_factura_proveedor,cre_item_factura_proveedor
			FROM item_factura_proveedor WHERE factura_proveedor_id=$factura_proveedor_id AND item_factura_proveedor_id=$result_items[item_factura_proveedor_id]";
                $this->query($insert_item, $Conex, true);
            }

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);
            } else {

                $update = "UPDATE factura_proveedor SET encabezado_registro_id=$encabezado_registro_id,
			estado_factura_proveedor= 'C',
			con_usuario_id = $usuario_id,
			con_fecha_factura_proveedor='$con_fecha_factura_prov'
			WHERE factura_proveedor_id=$factura_proveedor_id";
                $this->query($update, $Conex);
                if ($liquidacion_despacho_id > 0) {
                    $update = "UPDATE liquidacion_despacho SET encabezado_registro_id=$encabezado_registro_id
				WHERE  liquidacion_despacho_id=$liquidacion_despacho_id";
                    $this->query($update, $Conex);
                }
                if (strlen($this->GetError()) > 0) {
                    $this->Rollback($Conex);

                }
            }
            //fin causacion

            if (strlen($this->GetError()) > 0) {
                $this->Rollback($Conex);
            } else {

                $update = "UPDATE manifiesto SET
			encabezado_registro_id = $encabezado_registro_id,
			estado                 = 'L'
			WHERE manifiesto_id=$manifiesto_id";

                $this->query($update, $Conex, true);

                if (strlen($this->GetError()) > 0) {
                    $this->Rollback($Conex);

                } else {
                    // $this->Commit($Conex);
                    return true;
                }
            }

        } else {
            exit("No es posible contabilizar");
        }
///FIN BLOQUE CONTABILIZAR
    }

    public function getConsecutivoDespacho($oficina_id, $Conex)
    {
        $consecutivo = $this->requestData('manifiesto');
        if($consecutivo == 'NULL'){

            $select = "SELECT MAX(manifiesto) AS manifiesto FROM manifiesto WHERE oficina_id = $oficina_id";
            $result = $this->DbFetchAll($select, $Conex, true);

            $manifiesto = $result[0]['manifiesto'];

            if (is_numeric($manifiesto)) {

                $select = "SELECT rango_manif_fin FROM rango_manifiesto WHERE oficina_id = $oficina_id
            AND estado = 'A'";
                $result = $this->DbFetchAll($select, $Conex, true);
                $rango_manif_fin = $result[0]['rango_manif_fin'];

                $manifiesto = $manifiesto + 1;

                if ($manifiesto > $rango_manif_fin) {
                    print 'El numero de manifiesto para esta oficina a superado el limite definido<br>debe actualizar el rango de manifiestos
                asignado para esta oficina !!!';
                    return false;
                }

            } else {

                $select = "SELECT rango_manif_ini FROM rango_manifiesto WHERE oficina_id = $oficina_id
            AND estado = 'A'";

                $result = $this->DbFetchAll($select, $Conex, true);

                $rango_manif_ini = $result[0]['rango_manif_ini'];

                if (is_numeric($rango_manif_ini)) {
                    $manifiesto = $rango_manif_ini;
                } else {
                    print 'Debe Definir un rango de manifiestos para la oficina!!!';
                    return false;
                }

            }

            return $manifiesto;
        }else{
            $manifiesto = $consecutivo;
            return $manifiesto;
        }
    }

    public function Save($usuario_id, $oficina_id, $empresa_id, $usuarioNombres, $usuario_numero_identificacion, $Campos, $Conex)
    {

        $fecha_entrega_mcia_mc = $this->requestData('fecha_entrega_mcia_mc') . ' ' . $this->requestData('hora_entrega');
        $fecha_estimada_salida = $this->requestData('fecha_estimada_salida') . ' ' . $this->requestData('hora_estimada_salida');

        if ($fecha_estimada_salida >= $fecha_entrega_mcia_mc) {
            exit("La fecha de entrega de la mercancia debe ser mayor a la fecha de salida!!!!!");
        }

        $manifiesto_id = $this->DbgetMaxConsecutive("manifiesto", "manifiesto_id", $Conex, true, 1);
        $manifiesto = $this->getConsecutivoDespacho($oficina_id, $Conex);

        $servicio_transporte_id = $this->DbgetMaxConsecutive("servicio_transporte", "servicio_transporte_id", $Conex);
        $servicio_transporte_id++;

        $this->assignValRequest('empresa_id', $empresa_id);
        $this->assignValRequest('oficina_id', $oficina_id);
        $this->assignValRequest('usuario_id', $usuario_id);
        $this->assignValRequest('usuario_registra', $usuarioNombres);
        $this->assignValRequest('usuario_registra_numero_identificacion', $usuario_numero_identificacion);

        $this->assignValRequest('manifiesto_id', $manifiesto_id);
        $this->assignValRequest('manifiesto', $manifiesto);
        $this->assignValRequest('servicio_transporte_id', $servicio_transporte_id);
        $this->assignValRequest('id_mobile', rand(999999, 6));
        $this->assignValRequest('fecha_registro', date("Y-m-d"));

        $this->Begin($Conex);

        $oficina_pago_saldo_id = $_REQUEST['oficina_pago_saldo_id'];

        $select = "SELECT * FROM oficina WHERE oficina_id = $oficina_pago_saldo_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $this->assignValRequest('lugar_pago_saldo', $result[0]['direccion']);

        $this->assignValRequest('estado', 'P');

        $this->DbInsertTable("manifiesto", $Campos, $Conex, true, false);
        $this->DbInsertTable("servicio_transporte", $Campos, $Conex, true, false);

        $modalidad = $_REQUEST['modalidad'];

        if ($modalidad == 'D') {
            $this->DbInsertTable("dta", $Campos, $Conex, true, false);
        }

        $placa_id = $_REQUEST['placa_id'];
        $select = "SELECT propio FROM vehiculo WHERE placa_id = $placa_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        $propio = $result[0]['propio'];

        $this->Commit($Conex);

        return array(array(manifiesto_id => $manifiesto_id, manifiesto => $manifiesto, servicio_transporte_id => $servicio_transporte_id, propio => $propio));
    }

    public function manifiestoTieneDTA($manifiesto_id, $Conex)
    {

        $select = "SELECT * FROM dta WHERE manifiesto_id = $manifiesto_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function conductorFueReportadoMinisterioTransporte($conductor_id, $Conex)
    {

        $select = "SELECT reportado_ministerio FROM conductor WHERE conductor_id = $conductor_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if ($result[0]['reportado_ministerio'] == '1') {
            return true;
        } else {
            return false;
        }

    }

    public function vehiculoFueReportadoMinisterioTransporte($placa_id, $Conex)
    {

        $select = "SELECT reportado_ministerio FROM vehiculo WHERE placa_id = $placa_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if ($result[0]['reportado_ministerio'] == '1') {
            return true;
        } else {
            return false;
        }

    }

    public function remolqueFueReportadoMinisterioTransporte($placa_remolque_id, $Conex)
    {

        $select = "SELECT reportado_ministerio FROM remolque WHERE placa_remolque_id = $placa_remolque_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if ($result[0]['reportado_ministerio'] == '1') {
            return true;
        } else {
            return false;
        }

    }

    public function Update($usuario_id, $oficina_id, $oficina_anticipo_id, $empresa_id, $usuarioNombres, $usuario_numero_identificacion, $Campos, $Conex)
    {
        
        $conductor_id = $this->requestData('conductor_id');
        $placa_id = $this->requestData('placa_id');
        $placa_remolque_id = $this->requestData('placa_remolque_id');
        $placa_remolque = $this->requestData('placa_remolque');

        $conductor_reportado = $this->conductorFueReportadoMinisterioTransporte($conductor_id, $Conex);
        $vehiculo_reportado = $this->vehiculoFueReportadoMinisterioTransporte($placa_id, $Conex);
        $remolque_reportado = $this->remolqueFueReportadoMinisterioTransporte($placa_remolque_id, $Conex);

//    if($conductor_reportado && $vehiculo_reportado && ($remolque_reportado || $placa_remolque == 'NULL')){

        $estadoManifiesto = $this->requestData("estado");
        $placa_id = $this->requestData("placa_id");

        $this->assignValRequest('empresa_id', $empresa_id);
        $this->assignValRequest('oficina_id', $oficina_id);
        $this->assignValRequest('usuario_id', $usuario_id);
        $this->assignValRequest('usuario_registra', $usuarioNombres);
        $this->assignValRequest('usuario_registra_numero_identificacion', $usuario_numero_identificacion);
        $this->assignValRequest('estado', 'M');
        $this->assignValRequest('fecha_registro', date("Y-m-d"));

        $this->Begin($Conex);

        $oficina_pago_saldo_id = $_REQUEST['oficina_pago_saldo_id'];

        $select = "SELECT o.*,(SELECT nombre FROM ubicacion WHERE ubicacion_id = o.ubicacion_id) AS ciudad FROM oficina o
		 WHERE oficina_id = $oficina_pago_saldo_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $this->assignValRequest('lugar_pago_saldo', $result[0]['ciudad']);

        $this->DbUpdateTable("manifiesto", $Campos, $Conex, true, false);
        $this->DbUpdateTable("servicio_transporte", $Campos, $Conex, true, false);

        $manifiesto_id = $this->requestData('manifiesto_id');
        $propio = $this->requestData('propio');
        $modalidad = $this->requestData('modalidad');

        if ($modalidad == 'D') {

            if ($this->manifiestoTieneDTA($manifiesto_id, $Conex)) {
                $this->DbUpdateTable("dta", $Campos, $Conex, true, false);
            } else {
                $this->DbInsertTable("dta", $Campos, $Conex, true, false);
            }

        }

        if ($propio == 1) {

            if (is_array($_REQUEST['anticipos'])) {

                $anticipos = $_REQUEST['anticipos'];
                $anticiposManifiestoId;

                for ($i = 0; $i < count($anticipos); $i++) {

                    $conductor = $anticipos[$i]['conductor'];
                    $conductor_id = $anticipos[$i]['conductor_id'];
                    $anticipos_manifiesto_id = $anticipos[$i]['anticipos_manifiesto_id'];
                    $valor = str_replace(",", ".", str_replace(".", "", $anticipos[$i]['valor']));

                    if (is_numeric($anticipos_manifiesto_id)) {

                        $query = "UPDATE anticipos_manifiesto SET propio = $propio,placa_id = $placa_id,conductor = '$conductor',
					  conductor_id = $conductor_id,valor = $valor WHERE  anticipos_manifiesto_id = $anticipos_manifiesto_id;";

                    } else {

                        $anticipos_manifiesto_id = $this->DbgetMaxConsecutive("anticipos_manifiesto", "anticipos_manifiesto_id", $Conex, true, 1);

                        $select = "SELECT MAX(numero) AS numero FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id AND devolucion=0 ";
                        $result = $this->DbFetchAll($select, $Conex, true);

                        $numero = $result[0]['numero'] > 0 ? ($result[0]['numero'] + 1) : 1;

                        $query = "INSERT INTO anticipos_manifiesto (anticipos_manifiesto_id,manifiesto_id,numero,conductor,conductor_id,valor,propio,placa_id,oficina_id)
								VALUES ($anticipos_manifiesto_id,$manifiesto_id,$numero,'$conductor',$conductor_id,$valor,$propio,$placa_id,$oficina_anticipo_id);";

                    }

                    $this->query($query, $Conex, true);

                    if (is_numeric($anticipos_manifiesto_id)) {
                        $anticiposManifiestoId .= "$anticipos_manifiesto_id,";
                    }

                }

                $anticiposManifiestoId = substr($anticiposManifiestoId, 0, strlen($anticiposManifiestoId) - 1);

                if (strlen(trim($anticiposManifiestoId)) > 0) {
                    $delete = "DELETE FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id  AND anticipos_manifiesto_id NOT
				IN ($anticiposManifiestoId) AND devolucion=0";
                    $this->query($delete, $Conex, true);
                }

            }

        } else {


            if (is_array($_REQUEST['impuestos'])) {
              
                $impuestos = $_REQUEST['impuestos'];
                $impuestosManifiestoId;

                for ($i = 0; $i < count($impuestos); $i++) {

                    $impuestos_manifiesto_id = $impuestos[$i]['impuestos_manifiesto_id'];
                    $impuesto_id = $impuestos[$i]['impuesto_id'];
                    $nombre = $impuestos[$i]['nombre'];
                    $base = $impuestos[$i]['base'];
                    $porcentaje = $impuestos[$i]['porcentaje'];
                    $valor = str_replace(",", ".", str_replace(".", "", $impuestos[$i]['valor']));

                    if (is_numeric($impuestos_manifiesto_id)) {

                        $query = "UPDATE impuestos_manifiesto SET /*impuesto_id = $impuesto_id,*/nombre = '$nombre',base = $base,porcentaje = $porcentaje,valor = $valor
					  WHERE impuestos_manifiesto_id = $impuestos_manifiesto_id;";

                    } else {

                        $impuestos_manifiesto_id = $this->DbgetMaxConsecutive("impuestos_manifiesto", "impuestos_manifiesto_id", $Conex, true, 1);

                        $query = "INSERT INTO impuestos_manifiesto (impuestos_manifiesto_id,manifiesto_id,impuesto_id,nombre,base,porcentaje,valor)
								VALUES ($impuestos_manifiesto_id,$manifiesto_id,$impuesto_id,'$nombre',$base,$porcentaje,$valor);";

                    }
                 
                    $this->query($query, $Conex, true);

                    if (is_numeric($impuestos_manifiesto_id)) {
                        $impuestosManifiestoId .= "$impuestos_manifiesto_id,";
                    }

                }

                if (is_array($_REQUEST['impuestos1'])) {

                    $impuestos1 = $_REQUEST['impuestos1'];

                    for ($i = 0; $i < count($impuestos1); $i++) {

                        $impuestos_manifiesto_id = $impuestos1[$i]['impuestos_manifiesto_id'];
                        $impuesto_id = $impuestos1[$i]['impuesto_id'];
                        $base = $impuestos1[$i]['base'];
                        $porcentaje = str_replace(",", ".", str_replace(".", "", $impuestos1[$i]['porcentaje']));
                        $valor = str_replace(",", ".", str_replace(".", "", $impuestos1[$i]['valor']));

                        $select = "SELECT * FROM tabla_impuestos WHERE impuesto_id = $impuesto_id";
                        $nombreimp = $this->DbFetchAll($select, $Conex, true);
                        $nombre = $nombreimp[0]['nombre'];

                        if (is_numeric($impuestos_manifiesto_id)) {

                            $query = "UPDATE impuestos_manifiesto SET impuesto_id = $impuesto_id,nombre = '$nombre',base = $base,porcentaje = $porcentaje,valor = $valor
						WHERE impuestos_manifiesto_id = $impuestos_manifiesto_id;";

                        } else {

                            $impuestos_manifiesto_id = $this->DbgetMaxConsecutive("impuestos_manifiesto", "impuestos_manifiesto_id", $Conex, true, 1);

                            $query = "INSERT INTO impuestos_manifiesto (impuestos_manifiesto_id,manifiesto_id,impuesto_id,nombre,base,porcentaje,valor)
						VALUES ($impuestos_manifiesto_id,$manifiesto_id,$impuesto_id,'$nombre',$base,$porcentaje,$valor);";

                        }

                        $this->query($query, $Conex, true);

                        if (is_numeric($impuestos_manifiesto_id)) {
                            $impuestosManifiestoId .= "$impuestos_manifiesto_id,";
                        }

                    }

                }

                $impuestosManifiestoId = substr($impuestosManifiestoId, 0, strlen($impuestosManifiestoId) - 1);

                if (strlen(trim($impuestosManifiestoId)) > 0) {
                    $delete = "DELETE FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id  AND impuestos_manifiesto_id NOT
				IN ($impuestosManifiestoId)";
                    $this->query($delete, $Conex, true);
                }

            }

            if (is_array($_REQUEST['descuentos'])) {

                $manifiesto_id = $_REQUEST['manifiesto_id'];
                $descuentos = $_REQUEST['descuentos'];
                $descuentosManifiestoId;

                for ($i = 0; $i < count($descuentos); $i++) {

                    $descuentos_manifiesto_id = $descuentos[$i]['descuentos_manifiesto_id'];
                    $descuento_id = $descuentos[$i]['descuento_id'];
                    $nombre = $descuentos[$i]['nombre'];
                    $valor = str_replace(",", ".", str_replace(".", "", $descuentos[$i]['valor']));

                    if (is_numeric($descuentos_manifiesto_id)) {

                        $query = "UPDATE descuentos_manifiesto SET descuento_id = $descuento_id,nombre = '$nombre',valor = $valor
					  WHERE descuentos_manifiesto_id = $descuentos_manifiesto_id;";

                    } else {

                        $descuentos_manifiesto_id = $this->DbgetMaxConsecutive("descuentos_manifiesto", "descuentos_manifiesto_id", $Conex, true, 1);

                        $query = "INSERT INTO descuentos_manifiesto (descuentos_manifiesto_id,manifiesto_id,descuento_id,nombre,valor)
								VALUES ($descuentos_manifiesto_id,$manifiesto_id,$descuento_id,'$nombre',$valor);";

                    }

                    $this->query($query, $Conex, true);

                    if (is_numeric($descuentos_manifiesto_id)) {
                        $descuentosManifiestoId .= "$descuentos_manifiesto_id,";
                    }

                }

                $descuentosManifiestoId = substr($descuentosManifiestoId, 0, strlen($descuentosManifiestoId) - 1);

                if (strlen(trim($impuestosManifiestoId)) > 0) {
                    $delete = "DELETE FROM descuentos_manifiesto WHERE manifiesto_id = $manifiesto_id  AND descuentos_manifiesto_id NOT
				IN ($descuentosManifiestoId)";
                    $this->query($delete, $Conex, true);
                }

            }

            if (is_array($_REQUEST['anticipos'])) {

                $manifiesto_id = $_REQUEST['manifiesto_id'];
                $anticipos = $_REQUEST['anticipos'];
                $anticiposManifiestoId;

                for ($i = 0; $i < count($anticipos); $i++) {

                    /*  $tenedor                 = $anticipos[$i]['tenedor'];
                    $tenedor_id              = $anticipos[$i]['tenedor_id']; */

                    /* -----------/Cambio para que siempre se guarde a nombre del tenedor del manifiesto------------- */
                    $tenedor = "(SELECT tenedor FROM manifiesto WHERE manifiesto_id = $manifiesto_id)";
                    $tenedor_id = "(SELECT tenedor_id FROM manifiesto WHERE manifiesto_id = $manifiesto_id)";
                    /* -----------/Cambio para que siempre se guarde a nombre del tenedor del manifiesto------------- */

                    $anticipos_manifiesto_id = $anticipos[$i]['anticipos_manifiesto_id'];
                    $valor = str_replace(",", ".", str_replace(".", "", $anticipos[$i]['valor']));

                    if (is_numeric($anticipos_manifiesto_id)) {

                        $query = "UPDATE anticipos_manifiesto SET tenedor = $tenedor,tenedor_id = $tenedor_id,valor = $valor,propio = $propio,
					  placa_id = $placa_id WHERE anticipos_manifiesto_id = $anticipos_manifiesto_id;";

                    } else {

                        $anticipos_manifiesto_id = $this->DbgetMaxConsecutive("anticipos_manifiesto", "anticipos_manifiesto_id", $Conex, true, 1);

                        $select = "SELECT MAX(numero) AS numero FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id AND devolucion=0 ";
                        $result = $this->DbFetchAll($select, $Conex, true);

                        $numero = $result[0]['numero'] > 0 ? ($result[0]['numero'] + 1) : 1;

                        $query = "INSERT INTO anticipos_manifiesto (anticipos_manifiesto_id,manifiesto_id,numero,tenedor,tenedor_id,valor,propio,placa_id,oficina_id)
								VALUES ($anticipos_manifiesto_id,$manifiesto_id,$numero,$tenedor,$tenedor_id,$valor,$propio,$placa_id,$oficina_anticipo_id);";

                    }

                    $this->query($query, $Conex, true);

                    if (is_numeric($anticipos_manifiesto_id)) {
                        $anticiposManifiestoId .= "$anticipos_manifiesto_id,";
                    }

                }

                $anticiposManifiestoId = substr($anticiposManifiestoId, 0, strlen($anticiposManifiestoId) - 1);

                if (strlen(trim($anticiposManifiestoId)) > 0) {
                    $delete = "DELETE FROM anticipos_manifiesto WHERE manifiesto_id = $manifiesto_id  AND anticipos_manifiesto_id NOT
				IN ($anticiposManifiestoId) AND devolucion=0";
                    $this->query($delete, $Conex, true);
                }

            }

        }

        if ($estadoManifiesto == 'P') {

            $select = "SELECT * FROM tiempos_clientes_remesas WHERE manifiesto_id = $manifiesto_id";
            $dataTiempos = $this->DbFetchAll($select, $Conex, true);

            if (count($dataTiempos) == 0) {
                exit("<div align='center'>Debe llenar los tiempos de cargue primero!!!</div>");
            } else {

                for ($i = 0; $i < count($dataTiempos); $i++) {
                }

            }

            $trafico_id = $this->DbgetMaxConsecutive("trafico", "trafico_id", $Conex, true, 1);
            $origen_id = $this->requestData('origen_id', 'integer');
            $destino_id = $this->requestData('destino_id', 'integer');
            $ruta_id = $this->requestData('ruta_id', 'integer');
            $fecha_estimada_salida = $this->requestData('fecha_estimada_salida', 'text');
            $hora_estimada_salida = $this->requestData('hora_estimada_salida', 'text');

            if (is_numeric($ruta_id)) {

                $insert = "INSERT INTO trafico (trafico_id,manifiesto_id,origen_id,destino_id,ruta_id,estado,fecha_inicial_salida,hora_inicial_salida,t_nocturno)
				VALUES ($trafico_id,$manifiesto_id,$origen_id,$destino_id,$ruta_id,'R','$fecha_estimada_salida','$hora_estimada_salida',0)";

                $this->query($insert, $Conex, true);

                $select_ori = "SELECT d.orden_det_ruta, d.detalle_ruta_id, d.ubicacion_id FROM detalle_ruta d,  trafico t
				WHERE t.trafico_id=$trafico_id AND d.ruta_id=$ruta_id AND d.ubicacion_id=t.origen_id  AND d.punto_referencia_id IS NULL  ";
                $result_ori = $this->DbFetchAll($select_ori, $Conex, true);

                $select_des = "SELECT d.orden_det_ruta, d.detalle_ruta_id, d.ubicacion_id FROM detalle_ruta d,  trafico t
				WHERE t.trafico_id=$trafico_id AND d.ruta_id=$ruta_id AND d.ubicacion_id=t.destino_id  AND d.punto_referencia_id IS NULL  ";
                $result_des = $this->DbFetchAll($select_des, $Conex, true);

                $id_det_ori = $result_ori[0][detalle_ruta_id];
                $id_det_des = $result_des[0][detalle_ruta_id];

                $origen_id = $result_ori[0][ubicacion_id];
                $destino_id = $result_des[0][ubicacion_id];

                if ($result_ori[0][orden_det_ruta] > $result_des[0][orden_det_ruta]) {
                    $orderby = 'DESC';
                    $ord_origen = $result_des[0][orden_det_ruta];
                    $ord_destino = $result_ori[0][orden_det_ruta];

                } else {
                    $orderby = 'ASC';
                    $ord_origen = $result_ori[0][orden_det_ruta];
                    $ord_destino = $result_des[0][orden_det_ruta];

                }

                $select = "SELECT d.detalle_ruta_id, d.ubicacion_id, d.punto_referencia_id, d.orden_det_ruta,IF(punto_referencia_id IS
				NULL,(SELECT nombre FROM ubicacion WHERE ubicacion_id = d.ubicacion_id),(SELECT nombre FROM punto_referencia
				WHERE punto_referencia_id=d.punto_referencia_id)) AS nombre,IF(punto_referencia_id IS NULL,(SELECT
				nombre FROM tipo_ubicacion WHERE tipo_ubicacion_id = (SELECT tipo_ubicacion_id FROM ubicacion WHERE ubicacion_id =
				d.ubicacion_id)),(SELECT nombre FROM tipo_punto_referencia WHERE tipo_punto_referencia_id = (SELECT
				tipo_punto_referencia_id FROM punto_referencia WHERE punto_referencia_id = d.punto_referencia_id)))
				AS tipo_punto FROM detalle_ruta d WHERE d.ruta_id=$ruta_id  AND d.orden_det_ruta >=$ord_origen AND  d.orden_det_ruta
				<=$ord_destino ORDER BY d.orden_det_ruta $orderby  ";

                $result = $this->DbFetchAll($select, $Conex, true);
                $cont = 1;

                foreach ($result as $items) {
                    $punto_referencia_id = $items[punto_referencia_id] != '' ? $items[punto_referencia_id] : 'NULL';

                    $detalle_seg_id = $this->DbgetMaxConsecutive("detalle_seguimiento", "detalle_seg_id", $Conex, true, 1);
                    $ubicacion_id = is_numeric($items[ubicacion_id]) ? $items[ubicacion_id] : $ubicacion_id;

                    $insert = "INSERT INTO  detalle_seguimiento (
												detalle_seg_id,
												trafico_id,
												detalle_ruta_id,
												ubicacion_id,
												punto_referencia,
												tipo_punto,
												punto_referencia_id,
												orden_det_ruta
											)VALUES(
												$detalle_seg_id,
												$trafico_id,
												$items[detalle_ruta_id],
												$ubicacion_id,
												'$items[nombre]',
												'$items[tipo_punto]',
												$punto_referencia_id,
												$cont
											)";

                    $this->query($insert, $Conex, true);
                    $cont++;
                }

            } else {

                $insert = "INSERT INTO trafico (trafico_id,manifiesto_id,origen_id,destino_id,fecha_inicial_salida,hora_inicial_salida,t_nocturno,estado)
			   VALUES ($trafico_id,$manifiesto_id,$origen_id,$destino_id,'$fecha_estimada_salida','$hora_estimada_salida',0,'P')";

                $this->query($insert, $Conex, true);

            }

            //Inicio Bloque de Codigo que valida si una remesa tiene valor_facturar entonces la deje en estado Liquidada. -RS
            $selectConteo = "SELECT COUNT(*) AS conteo FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = $manifiesto_id)";
            $contarRemesas = $this->DbFetchAll($selectConteo, $Conex, true);

            $selectRemesa = "SELECT estado, valor_facturar, remesa_id FROM remesa WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = $manifiesto_id)";
            $resultRemesas = $this->DbFetchAll($selectRemesa, $Conex, true);

            //exit($resultRemesas[0]['valor_facturar']);

            for ($i = 0; $i < $contarRemesas[0]['conteo']; $i++) {
                if ($resultRemesas[$i]['estado'] == 'PC' || $resultRemesas[$i]['estado'] == 'PD' && $resultRemesas[$i]['valor_facturar'] > 0 || $resultRemesas[$i]['valor_facturar'] != '') {

                    $remesa = $resultRemesas[$i]['remesa_id'];
                    //exit('Remesa:'.$remesa);
                    $update = "UPDATE remesa SET desbloqueada = 0,estado = 'LQ' WHERE remesa_id = $remesa";
                    $this->query($update, $Conex, true);

                } else {

                    $remesa = $resultRemesas[$i]['remesa_id'];
                    $update = "UPDATE remesa SET desbloqueada = 0,estado = 'MF' WHERE remesa_id = $remesa";
                    $this->query($update, $Conex, true);

                }
            }
            //Fin Bloque Validacion. -RS

        }

        $this->Commit($Conex);

        /*}else{

    $msjMinisterio = "<div align='center'>";

    if(!$conductor_reportado){
    $msjMinisterio .= 'El conductor no ha sido reportado al Ministerio de Transporte<br>';
    }

    if(!$vehiculo_reportado){
    $msjMinisterio .= 'El vehiculo no ha sido reportado al Ministerio de Transporte<br>';
    }

    if($placa_remolque != 'NULL' && !$remolque_reportado){
    $msjMinisterio .= 'El remolque no ha sido reportado al Ministerio de Transporte<br>';
    }

    $msjMinisterio .= "<br><b>Debe ingresar al formulario respectivo y reportar al ministerio</b></div>";

    exit("$msjMinisterio");

    }*/

    }

    public function Delete($Campos, $Conex)
    {

        $this->Begin($Conex);

        $this->DbDeleteTable("servicio_transporte", $Campos, $Conex, true, false);
        $this->DbDeleteTable("despachos_urbanos_id", $Campos, $Conex, true, false);
        $this->DbDeleteTable("manifiesto", $Campos, $Conex, true, false);

        $this->Commit($Conex);
    }

//LISTA MENU

    public function getDataPoliza($Conex, $empresa_id)
    {

        $select = "SELECT (SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = p.aseguradora_id) AS aseguradora,p.numero AS poliza, fecha_vencimiento     AS
	vencimiento_poliza FROM poliza_empresa p WHERE empresa_id = $empresa_id AND estado = 'A'";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function GetTiposManifiesto($Conex)
    {

        $select = "SELECT tipo_manifiesto_id AS value, tipo_manifiesto AS text FROM tipo_manifiesto WHERE activo=1 ORDER BY tipo_manifiesto_id ASC";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getImpuestos($empresa_id, $oficina_id, $Conex)
    {

        $select = "SELECT * FROM tabla_impuestos WHERE empresa_id = $empresa_id AND oficina_id = $oficina_id AND estado = 'A' AND rte = 1";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getImpuestosica($empresa_id, $oficina_id, $Conex)
    {

        $select = "SELECT * FROM tabla_impuestos WHERE empresa_id = $empresa_id  AND estado = 'A' AND ica=1";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function GetDescuentos($oficina_id, $Conex)
    {

        $select = "SELECT * FROM tabla_descuentos WHERE oficina_id = $oficina_id  AND estado = 'A' ORDER BY orden";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function manifiestoTieneRemesas($manifiesto_id, $Conex)
    {

        $select = "SELECT COUNT(*) AS num_remesas FROM detalle_despacho WHERE manifiesto_id = $manifiesto_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if ($result[0]['num_remesas'] > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function tenedorAutorretenedorRenta($tenedor_id, $Conex)
    {

        $select = "SELECT autoret_proveedor FROM tenedor WHERE tenedor_id = $tenedor_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if ($result[0]['autoret_proveedor'] == 'S') {
            return true;
        } else {
            return false;
        }

    }

    public function tenedorAutorretenedorIca($tenedor_id, $Conex)
    {

        $select = "SELECT retei_proveedor FROM tenedor WHERE tenedor_id = $tenedor_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if ($result[0]['retei_proveedor'] == 'S') {
            return true;
        } else {
            return false;
        }

    }

    public function impuestoNoExcentosRenta($impuesto_id, $Conex)
    {

        $select = "SELECT exentos FROM impuesto WHERE impuesto_id = $impuesto_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $excentos = $result[0]['exentos'];

        if ($excentos == 'RT') {
            return true;
        } else {
            return false;
        }

    }

    public function impuestoNoExentosIca($impuesto_id, $Conex)
    {

        $select = "SELECT exentos FROM impuesto WHERE impuesto_id = $impuesto_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        $excentos = $result[0]['exentos'];

        if ($excentos == 'IC') {
            return true;
        } else {
            return false;
        }

    }

    public function calcularImpuesto($tenedor_id, $valor_flete, $impuesto_id, $impuestos, $Conex)
    {

        $autorretenedorRenta = $this->tenedorAutorretenedorRenta($tenedor_id, $Conex);
        $autorretenedorIca = $this->tenedorAutorretenedorIca($tenedor_id, $Conex);
        $impuestoNoExcentosRenta = $this->impuestoNoExcentosRenta($impuesto_id, $Conex);
        $impuestoNoExentosIca = $this->impuestoNoExentosIca($impuesto_id, $Conex);

        if ($impuestoNoExcentosRenta && $autorretenedorRenta) {
            return array(valor => 0, base => 0, porcentaje => 0);
        }

        if ($impuestoNoExentosIca && $autorretenedorIca) {
            return array(valor => 0, base => 0, porcentaje => 0);
        }

        $anio = date("Y");
        $select = "SELECT * FROM periodo_contable WHERE anio = $anio";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {

            $periodo_contable_id = $result[0]['periodo_contable_id'];

            $select = "SELECT t.*,i.*,ip.* FROM tabla_impuestos t, impuesto i,impuesto_periodo_contable ip WHERE t.impuesto_id = $impuesto_id AND t.impuesto_id = i.impuesto_id
		    AND ip.periodo_contable_id=$periodo_contable_id AND t.impuesto_id = ip.impuesto_id";
          
            $result = $this->DbFetchAll($select, $Conex, true);

            $monto = $result[0]['monto'];
            $base = $result[0]['base'];
            $porcentaje = $result[0]['porcentaje'];
            $formula = $result[0]['formula'];
            $base_impuesto_id = $result[0]['base_impuesto_id'];

            if ($valor_flete > $monto) {

                $formula = str_replace("BASE", "$valor_flete", $formula);
                $formula = str_replace("PORCENTAJE", "$porcentaje", $formula);

                if ($base == 'F') {

                    $select = "SELECT $formula AS valor_impuesto";
                    $result = $this->DbFetchAll($select, $Conex, true);

                    return array(valor => $result[0]['valor_impuesto'], base => $valor_flete, porcentaje => $porcentaje);

                } else {

                    if (count($result) > 0) {

                        $base_impuesto_id = $result[0]['base_impuesto_id'];

                        for ($i = 0; $i < count($impuestos); $i++) {

                            $impuesto_id_base = $impuestos[$i]['impuesto_id'];

                            if ($impuesto_id_base == $base_impuesto_id) {
                                $valorBase = str_replace(",", ".", str_replace(".", "", $impuestos[$i]['valor']));
                                break;

                            }

                        }

                        if (is_numeric($valorBase)) {

                            if ($valorBase > $monto) {

                                $formula = str_replace("BASE", "$valorBase", $formula);
                                $formula = str_replace("PORCENTAJE", "$porcentaje", $formula);

                                $select = "SELECT $formula AS valor_impuesto";
                                $result = $this->DbFetchAll($select, $Conex, true);

                                return array(valor => $result[0]['valor_impuesto'], base => $valorBase, porcentaje => $porcentaje);

                            } else {

                                return array(valor => 0, base => $valorBase, porcentaje => $porcentaje);

                            }

                        } else {

                            $select = "SELECT i.*,(SELECT nombre FROM impuesto WHERE impuesto_id = $base_impuesto_id) AS impuesto_base
					 FROM impuesto i WHERE impuesto_id = $impuesto_id";
                            $result = $this->DbFetchAll($select, $Conex, true);

                            $nombreImpuesto = $result[0]['nombre'];
                            $impuesto_base = $result[0]['impuesto_base'];

                            exit("<div align='center'>El impuesto [ $nombreImpuesto ] tiene como base el impuesto [ $impuesto_base ], cuyo valor en esta liquidacion es cero (0)por favor verifique la Tabla de impuestos!!!</div>");

                        }

                    } else {

                        $select = "SELECT i.*,(SELECT impuesto_periodo_contable_id FROM impuesto_periodo_contable WHERE impuesto_id = i.impuesto_id
				 AND periodo_contable_id = $periodo_contable_id) AS impuesto_periodo_contable FROM impuesto i WHERE impuesto_id = $impuesto_id";

                        $result = $this->DbFetchAll($select, $Conex, true);
                        $nombreImpuesto = $result[0]['nombre'];

                        exit("<div align='center'>El impuesto [ $nombreImpuesto ] no ha sido bien parametrizado para el periodo [ $anio ] !! <br> Por favor revise los parametros del impuesto</div>");

                    }

                }

            } else {

                return array(valor => 0, base => 0, porcentaje => 0);

            }

        } else {

            exit("No existe periodo creado para el a�o $anio !!!, por favor ingrese periodo correspondiente");

        }

    }

    public function calcularDescuento($valor, $valor_flete, $descuento_id, $Conex)
    {

        $select = "SELECT * FROM tabla_descuentos  WHERE descuento_id = $descuento_id";
        $result = $this->DbFetchAll($select, $Conex, true);
        $calculo = $result[0]['calculo'];
        $porcentaje = $result[0]['porcentaje'];

        if ($calculo == 'P') {

            $select = "SELECT ($valor_flete*$porcentaje)/100 AS valor";
            $result = $this->DbFetchAll($select, $Conex, true);

            $valor = $result[0]['valor'];

            return $valor;

        } else {
            return $valor;
        }

    }

    public function cancellation($manifiesto_id, $causal_anulacion_id, $observacion_anulacion, $usuario_anulo_id, $Conex)
    {

        $this->Begin($Conex);

        $update = "UPDATE manifiesto SET estado = 'A',causal_anulacion_id = $causal_anulacion_id,observacion_anulacion = $observacion_anulacion,
	 fecha_anulacion = NOW(),usuario_anulo_id = $usuario_anulo_id WHERE manifiesto_id = $manifiesto_id";

        $this->query($update, $Conex, true);

        $update = "UPDATE remesa SET desbloqueada = 0,estado = 'PD' WHERE remesa_id IN (SELECT remesa_id FROM detalle_despacho WHERE manifiesto_id = $manifiesto_id)";
        $this->query($update, $Conex, true);

        $this->Commit($Conex);

    }

    public function selectVehiculo($placa_id, $Conex)
    {

        $select = "SELECT (SELECT marca FROM marca WHERE marca_id = v.marca_id) AS marca,(SELECT linea FROM linea WHERE linea_id = v.linea_id) AS linea,modelo_vehiculo AS modelo,modelo_repotenciado,(SELECT color FROM color WHERE color_id = v.color_id) AS color,(SELECT carroceria FROM carroceria WHERE carroceria_id = v.carroceria_id) AS carroceria,registro_nacional_carga,configuracion,peso_vacio,numero_soat,(SELECT nombre_aseguradora FROM aseguradora WHERE aseguradora_id = v.aseguradora_soat_id) AS nombre_aseguradora,vencimiento_soat,(IF(DATE(vencimiento_soat) < DATE(NOW()),'SI','NO')) AS soat_vencio,vencimiento_tecno_vehiculo,(IF(DATE(vencimiento_tecno_vehiculo) < DATE(NOW()),'SI','NO'))  AS tecnicomecanica_vencio,placa_id,(SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,placa_remolque_id,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = ((SELECT propietario_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id))) AS propietario_remolque,(SELECT direccion FROM tercero WHERE tercero_id = v.propietario_id) AS direccion_propietario,(SELECT  numero_identificacion FROM tercero WHERE tercero_id = (SELECT propietario_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS numero_identificacion_propietario_remolque,(SELECT  codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id = v.propietario_id)) AS tipo_identificacion_propietario_remolque_codigo,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = v.propietario_id) AS propietario,(SELECT direccion FROM tercero WHERE tercero_id = v.propietario_id) AS direccion_propietario,(SELECT  numero_identificacion FROM tercero WHERE tercero_id = v.propietario_id) AS numero_identificacion_propietario,
                    (SELECT  codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id = v.propietario_id)) AS tipo_identificacion_propietario_codigo,(SELECT telefono FROM tercero WHERE tercero_id = v.propietario_id) AS telefono_propietario,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = v.propietario_id)) AS ciudad_propietario,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS tenedor,v.tenedor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS numero_identificacion_tenedor,(SELECT  codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS tipo_identificacion_tenedor_codigo,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS direccion_tenedor,	(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS telefono_tenedor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS ciudad_tenedor,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS titular_manifiesto,v.tenedor_id AS titular_manifiesto_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))
                     AS numero_identificacion_titular_manifiesto,
                    (SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS direccion_titular_manifiesto,(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id)) AS telefono_titular_manifiesto,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS ciudad_titular_manifiesto,(SELECT divipola FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM tenedor WHERE tenedor_id = v.tenedor_id))) AS ciudad_titular_manifiesto_divipola,
                    conductor_id,(SELECT numero_identificacion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS	numero_identificacion,(SELECT  codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id))) AS tipo_identificacion_conductor_codigo,(SELECT numero_licencia_cond FROM conductor WHERE conductor_id = v.conductor_id) AS numero_licencia_cond,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS nombre,(SELECT direccion FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS direccion_conductor,(SELECT telefono FROM tercero WHERE tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id)) AS
                    telefono_conductor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = (SELECT ubicacion_id FROM tercero WHERE tercero_id =
                    (SELECT tercero_id FROM conductor WHERE conductor_id = v.conductor_id))) AS ciudad_conductor,
                    (SELECT categoria FROM categoria_licencia WHERE categoria_id = (SELECT categoria_id FROM conductor WHERE conductor_id = v.conductor_id)) AS categoria_licencia_conductor,(SELECT vencimiento_licencia_cond FROM conductor WHERE conductor_id = v.conductor_id) AS vencimiento_licencia_cond,(SELECT IF(DATE(vencimiento_licencia_cond) < DATE(NOW()),'SI','NO') FROM conductor WHERE conductor_id = v.conductor_id) AS licencia_vencio,chasis AS serie,v.propio,(SELECT remolque FROM tipo_vehiculo WHERE tipo_vehiculo_id = v.tipo_vehiculo_id) AS remolque,v.reportado_ministerio FROM vehiculo v WHERE placa_id = $placa_id ";

        $dataVehiculo = $this->DbFetchAll($select, $Conex, true);

        $soat_vencio = $dataVehiculo[0]['soat_vencio'];
        $tecnicomecanica_vencio = $dataVehiculo[0]['tecnicomecanica_vencio'];
        $licencia_vencio = $dataVehiculo[0]['licencia_vencio'];
        $conductor_id = $dataVehiculo[0]['conductor_id'];

        if ($licencia_vencio == 'SI') {

            $update = "UPDATE conductor SET estado = 'B' WHERE conductor_id = $conductor_id";
            $result = $this->query($update, $Conex, true);

        }

        if ($tecnicomecanica_vencio == 'SI' || $soat_vencio == 'SI') {

            $update = "UPDATE vehiculo SET estado = 'B' WHERE placa_id = $placa_id";
            $result = $this->query($update, $Conex, true);

        }

        return $dataVehiculo;

    }
    public function selectIcaOficina($oficina_id, $Conex)
    {
        $anio = date("Y");
        $select = "SELECT * FROM periodo_contable WHERE anio = $anio";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {

            $periodo_contable_id = $result[0]['periodo_contable_id'];

            $select = "SELECT t.*,i.*,ip.* FROM tabla_impuestos t, impuesto i,impuesto_periodo_contable ip
			WHERE t.oficina_id = $oficina_id AND t.ica=1 AND i.impuesto_id = t.impuesto_id  AND  ip.impuesto_id=t.impuesto_id AND ip.periodo_contable_id=$periodo_contable_id LIMIT 1";
            $result = $this->DbFetchAll($select, $Conex, true);
            if (count($result) > 0) {
                return array(array(impuesto_id => $result[0][impuesto_id], porcentaje => $result[0][porcentaje]));
            } else {
                exit("<div align='center'>No existe impuesto de Ica en esta oficina para el a&ntilde;o [ $anio ] !! <br> Por favor revise </div>");

            }

        } else {
            exit("<div align='center'>El Periodo contable no ha sido bien parametrizado para el a&ntilde;o [ $anio ] !! <br> Por favor revise los periodos contables</div>");
        }

    }

    public function selectConsecutivoManifiesto($Conex, $manifiesto)
    {
        if($manifiesto != ''){
            $select = "SELECT manifiesto FROM manifiesto WHERE manifiesto = $manifiesto";
            $result = $this->DbFetchAll($select, $Conex, true);

            return $result;
        }
    }

    public function selectIca($impuesto_id, $Conex)
    {
        $anio = date("Y");
        $select = "SELECT * FROM periodo_contable WHERE anio = $anio";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {

            $periodo_contable_id = $result[0]['periodo_contable_id'];

            $select = "SELECT i.*,(SELECT impuesto_periodo_contable_id FROM impuesto_periodo_contable WHERE impuesto_id = i.impuesto_id
			AND periodo_contable_id = $periodo_contable_id) AS impuesto_periodo_contable FROM impuesto i WHERE impuesto_id = $impuesto_id";

            $result = $this->DbFetchAll($select, $Conex, true);
            $nombreImpuesto = $result[0]['nombre'];
            $impuesto_periodo_contable = $result[0]['impuesto_periodo_contable'];

            if (!$impuesto_periodo_contable > 0) {
                exit("<div align='center'>El impuesto [ $nombreImpuesto ] no ha sido bien parametrizado para el periodo [$anio]!! <br> Por favor revise los parametros del impuesto</div>");
            }

            $select = "SELECT t.*,i.*,ip.* FROM tabla_impuestos t, impuesto i,impuesto_periodo_contable ip
			WHERE t.impuesto_id = $impuesto_id AND t.ica=1 AND i.impuesto_id = t.impuesto_id  AND  ip.impuesto_id=t.impuesto_id AND ip.periodo_contable_id=$periodo_contable_id";
            $result = $this->DbFetchAll($select, $Conex, true);
            return $result;

        } else {

            exit("<div align='center'>El Periodo contable no ha sido bien parametrizado para el a&ntilde;o [ $anio ] !! <br> Por favor revise los periodos contables</div>");

        }

    }
    public function selectRemolque($placa_remolque_id, $Conex)
    {

        $select = "SELECT (SELECT placa_remolque FROM remolque WHERE placa_remolque_id = v.placa_remolque_id) AS placa_remolque,placa_remolque_id,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,razon_social) FROM tercero WHERE tercero_id = ((SELECT propietario_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id))) AS propietario_remolque,(SELECT  numero_identificacion FROM tercero WHERE tercero_id = (SELECT propietario_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id)) AS numero_identificacion_propietario_remolque,(SELECT  codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT tipo_identificacion_id FROM tercero WHERE tercero_id = (SELECT propietario_id FROM remolque WHERE placa_remolque_id = v.placa_remolque_id))) AS tipo_identificacion_propietario_remolque_codigo,v.reportado_ministerio FROM remolque v WHERE placa_remolque_id = $placa_remolque_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function selectConductor($conductor_id, $Conex)
    {

        $select = "SELECT c.conductor_id,concat_ws(' ',t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido)
	 AS nombre,t.numero_identificacion,(SELECT  codigo_ministerio FROM tipo_identificacion WHERE tipo_identificacion_id = (SELECT
	 tipo_identificacion_id FROM tercero WHERE tercero_id = c.tercero_id)) AS tipo_identificacion_conductor_codigo,
	 (SELECT categoria FROM categoria_licencia WHERE categoria_id = c.categoria_id) AS
	 categoria_licencia_conductor,vencimiento_licencia_cond,
	 IF(DATE(vencimiento_licencia_cond) < DATE(NOW()),'SI','NO') AS  licencia_vencio,
	 IF (DATE(vencimiento_eps)< DATE (NOW()),'SI','NO') AS eps_vencio,
	 IF (DATE(vencimiento_arp)< DATE (NOW()),'SI','NO') AS arp_vencio,
	 c.numero_licencia_cond,t.direccion AS direccion_conductor,t.telefono AS
	  telefono_conductor,(SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS
	  ciudad_conductor,c.reportado_ministerio FROM conductor c,tercero t  WHERE t.tercero_id = c.tercero_id AND
	  c.conductor_id = $conductor_id";

        $dataConductor = $this->DbFetchAll($select, $Conex, true);
        $licencia_vencio = $dataConductor[0]['licencia_vencio'];
        $eps_vencio = $dataConductor[0]['eps_vencio'];
        $arp_vencio = $dataConductor[0]['arp_vencio'];

        if ($licencia_vencio == 'SI' || $eps_vencio == 'SI' || $arp_vencio == 'SI') {

            $update = "UPDATE conductor SET estado = 'B' WHERE conductor_id = $conductor_id";
            $result = $this->query($update, $Conex, true);

        }

        return $dataConductor;

    }

//BUSQUEDA
    public function selectManifiesto($manifiesto_id, $Conex)
    {

        $select = "SELECT d.*,m.*,(SELECT ruta_id FROM trafico WHERE manifiesto_id = m.manifiesto_id ORDER BY ruta_id DESC LIMIT 1) AS ruta_id FROM (SELECT (SELECT nombre FROM ubicacion WHERE
	ubicacion_id = m.origen_id) AS origen,(SELECT nombre FROM
	ubicacion WHERE ubicacion_id = m.destino_id) AS destino,m.*,(SELECT remolque FROM tipo_vehiculo WHERE tipo_vehiculo_id = (SELECT
	tipo_vehiculo_id FROM vehiculo WHERE placa_id = m.placa_id)) AS remolque,(SELECT servicio_transporte_id FROM servicio_transporte
	WHERE manifiesto_id = m.manifiesto_id ORDER BY servicio_transporte_id DESC LIMIT 1) AS servicio_transporte_id FROM manifiesto m WHERE manifiesto_id =$manifiesto_id) m LEFT JOIN dta d
	ON m.manifiesto_id = d.manifiesto_id";

        $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

        $propio = $result[0]['propio'];

        if ($propio == 0) {

            $data[0]['manifiesto'] = $result;

            $select = "SELECT * FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos WHERE rte=1 )";
            $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

            $data[0]['impuestos'] = $result;

            $select = "SELECT * FROM impuestos_manifiesto WHERE manifiesto_id = $manifiesto_id AND impuesto_id IN (SELECT impuesto_id FROM tabla_impuestos WHERE ica=1 )";
            $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

            $data[0]['impuestos1'] = $result;

            $select = "SELECT * FROM descuentos_manifiesto WHERE manifiesto_id = $manifiesto_id";
            $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

            $data[0]['descuentos'] = $result;

            $select = "SELECT a.*,a.tenedor AS tenedor_anticipo,a.tenedor_id AS tenedor_anticipo_id FROM anticipos_manifiesto a
			WHERE manifiesto_id = $manifiesto_id AND devolucion=0 ";
            $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

            $data[0]['anticipos'] = $result;

        } else {

            $data[0]['manifiesto'] = $result;

            $select = "SELECT a.*,a.tenedor AS tenedor_anticipo,a.tenedor_id AS tenedor_anticipo_id FROM anticipos_manifiesto a
			WHERE manifiesto_id = $manifiesto_id AND devolucion=0 ";
            $result = $this->DbFetchAll($select, $Conex, $ErrDb = false);

            $data[0]['anticipos'] = $result;

        }

        return $data;
    }

    public function selectPreliquido($manifiesto_id, $Conex)
    {

        $select = "SELECT preliquido FROM manifiesto WHERE manifiesto_id = $manifiesto_id";
        $result = $this->DbFetchAll($select, $Conex, true);

        if ($result[0]['preliquido'] == 1) {
            return true;
        } else {
            return false;
        }

    }

    public function selectDataTitular($tenedor_id, $Conex)
    {

        $select = "SELECT tn.tenedor_id AS titular_manifiesto_id,UPPER(CONCAT_WS(' ',
	  t.primer_nombre,t.segundo_nombre,t.primer_apellido,t.segundo_apellido,t.razon_social)) AS titular_manifiesto,t.numero_identificacion
	  AS numero_identificacion_titular_manifiesto,t.direccion AS direccion_titular_manifiesto,t.telefono AS telefono_titular_manifiesto,
     (SELECT nombre FROM ubicacion WHERE ubicacion_id = t.ubicacion_id) AS ciudad_titular_manifiesto,(SELECT divipola FROM ubicacion
     WHERE ubicacion_id = t.ubicacion_id) AS ciudad_titular_manifiesto_divipola FROM tenedor tn, tercero t WHERE
     tn.tenedor_id = $tenedor_id AND tn.tercero_id = t.tercero_id";

        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getLugaresSaldoPago($oficina_id, $empresa_id, $Conex)
    {

        $select = "SELECT oficina_id AS value,nombre AS text,'$oficina_id' AS selected FROM oficina ORDER BY nombre ASC";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function getFormasPago($Conex)
    {

        $select = "SELECT forma_pago_id AS value,nombre AS text FROM forma_pago ORDER BY nombre ASC";
        $result = $this->DbFetchAll($select, $Conex, true);

        return $result;

    }

    public function existeFormulario($numero_formulario, $Conex)
    {

        $select = "SELECT * FROM dta WHERE TRIM(numero_formulario) = TRIM('$numero_formulario')";
        $result = $this->DbFetchAll($select, $Conex, true);

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function getCausalesAnulacion($Conex)
    {

        $select = "SELECT causal_anulacion_id AS value,nombre AS text FROM causal_anulacion WHERE documento = 'RM' ORDER BY
		nombre";
        $result = $this->DbFetchAll($select, $Conex);

        return $result;

    }

//// GRID ////
    public function getQueryManifiestosGrid($oficina_id)
    {

        $Query = "SELECT m.manifiesto,IF(m.propio = 1,'SI','NO') AS propio,IF(m.estado = 'P','PENDIENTE',IF(m.estado = 'M','MANIFESTADO',IF(
	 m.estado = 'L','LIQUIDADO','ANULADO'))) estado, m.fecha_mc, (SELECT nombre FROM ubicacion WHERE ubicacion_id = m.origen_id) AS origen, (SELECT
	 nombre FROM ubicacion WHERE ubicacion_id =  m.destino_id) AS destino,(SELECT CONCAT_WS(' ',primer_nombre,segundo_nombre,primer_apellido,segundo_apellido) FROM tercero WHERE
	 tercero_id = (SELECT tercero_id FROM conductor WHERE conductor_id = m.conductor_id)) AS conductor, m.placa,m.placa_remolque,m.valor_flete,(SELECT GROUP_CONCAT(consecutivo)
	 FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND devolucion = 0) AS numero_anticipos,(SELECT SUM(valor)
	 FROM anticipos_manifiesto WHERE manifiesto_id = m.manifiesto_id AND devolucion = 0) AS anticipos, (SELECT SUM(valor) FROM impuestos_manifiesto WHERE manifiesto_id
	 = m.manifiesto_id) AS  impuestos, m.aprobacion_ministerio2 FROM manifiesto m WHERE m.oficina_id = $oficina_id ORDER BY m.manifiesto DESC LIMIT 0,2000";

        return $Query;
    }

}
